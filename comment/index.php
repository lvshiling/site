<?php
define('IN_PLACE', 'www');
define('IN_SCRIPT', 'comment');
// 不使用文件缓存
define('NOT_USE_CACHE', '');

require_once('../global.php');

// 每页显示记录数
$perpage = 30;

$data = $core->DB->GetRow("SELECT * FROM {$core->TablePre}data WHERE hash_id='{$_GET['id']}'");
if (!$data || !$data['is_auditing'] || $data['mark_deleted'])
{
	header('Location: '.$core->Config['domain_www']);
	exit;
}

if (IS_VIP || $core->sort->SortList[$data['sort_id']]['vip'])
{
	$data['show_url'] = $core->Config['domain_vip'].'/show-'.$data['hash_id'].'.html';
}
else
{
	$data['show_url'] = $core->Config['domain_www'].'/go.html?p='.$core->UrlEncryptParame($data['data_id'], $data['release_date']);
	//$data['show_url'] = $core->Config['domain_www'].'/show/'.date('Y/md', $data['release_date']).'/'.$data['data_id'].'.html';
}

// 发表评论
if ('add' == $_POST['op'])
{
	if ($core->Config['comment_close'])
	{
		// 评论已关闭
		$core->Notice($core->Language['comment']['close'], 'halt');
	}

    // 评论内容禁止英文字符
    if ($core->Config['comment_letter_forbid'])
    {
        if (preg_match('#[a-z]#i', $_POST['content']))
        {
		    $core->Notice($core->Language['comment']['letter_forbid'], 'halt');
        }
    }

	// 防止恶意刷评论
	if (0 < $core->Config['comment_post_space'])
	{
		if (isset($_COOKIE['_comment']) && TIME_NOW < $_COOKIE['_comment'] + $core->Config['comment_post_space'])
		{
			$core->Notice($core->Language['comment']['error_post_space'], 'back');
		}
	}

	// 检查验证码
	$core->CheckVerifyCode('comment', $_POST['vcode']);

	// 未登录
	if (!$core->UserInfo['user_id'])
	{
        $core->Notice($core->Language['comment']['not_login'], 'back');
	}

	$comment_content = trim($_POST['content']);
	if (empty($comment_content))
	{
		$core->Notice($core->Language['comment']['error_empty'], 'back');
	}
	// 检查评论长度
	if ($core->Config['comment_maxlength'] < iconv_strlen($comment_content, 'utf-8'))
	{
		$core->Notice($core->Language['comment']['error_length'], 'back');
	}

	// 表情数量
	$smilie_num = preg_match_all('#\[smilie\:\d+\]#i', $comment_content, $matchs);
	if (10 < $smilie_num)
	{
		$core->Notice($core->Language['comment']['error_smilie'], 'back');
	}

	// 检查屏蔽关键字
	$check_word = $core->CheckBadword($comment_content);
	if (TRUE !== $check_word)
	{
		$core->Notice($core->Language['comment']['error_keyword_forbid'], 'back');
	}

	$comment_content = htmlspecialchars($comment_content);

	// 加入引用内容
	$quote_comment_id = intval($_POST['quote_id']);
	if (0 < $quote_comment_id)
	{
		$quote_comment = $core->DB->GetRow("SELECT * FROM {$core->TablePre}comment WHERE comment_id='{$quote_comment_id}'");
		if ($quote_comment)
		{
			$quote_comment_content  = '<div class="quote">';
			$quote_author = $core->LangReplaceText($core->Language['comment']['quote'], $quote_comment['user_name']);
			$quote_comment_content .= '<span>'.addslashes($quote_author).'</span><br />';
			$quote_comment_content .= '<span>'.addslashes($quote_comment['comment_content']).'</span>';
			$quote_comment_content .= '</div>';
			$comment_content = $quote_comment_content.$comment_content;
		}
	}

	// 发表评论是否需要审核
	if ($core->Config['comment_auditing'])
	{
		$comment_auditing = 0;
	}
	else
	{
		$comment_auditing = 1;
	}

	$core->DB->Execute("
		INSERT INTO {$core->TablePre}comment (
			data_id, 
			user_id, 
			user_name, 
			comment_content, 
			comment_date, 
			client_ip, 
			comment_auditing
		) VALUES (
			'{$data['data_id']}', 
			'{$core->UserInfo['user_id']}', 
			'".addslashes($core->UserInfo['user_name'])."', 
			'{$comment_content}', 
			'".TIME_NOW."', 
			'".CLIENT_IP."', 
			'{$comment_auditing}'
		)
	");
	$core->DB->Execute("UPDATE {$core->TablePre}data SET total_comment=total_comment+1 WHERE data_id='{$data['data_id']}'");

	// 防止恶意刷评论
	if (0 < $core->Config['comment_post_space'])
	{
		$core->MySetcookie('_comment', TIME_NOW, $core->Config['comment_post_space']);
	}

	// 计算总页数
	$total_num = $data['total_comment'] + 1;
	$last_page = ceil($total_num / $perpage);

	header('Location: index.php?id='.$data['hash_id'].'&page='.$last_page);
	exit;
}


// 显示评论列表
$total = $core->DB->GetRow("SELECT COUNT(*) AS num FROM {$core->TablePre}comment WHERE data_id='{$data['data_id']}' AND comment_auditing='1'");
$data['total_comment'] = $total['num'];

$comment_data = array();
if (0 < $data['total_comment'])
{
	$offset = 0;
	if ($data['total_comment'] > $perpage)
	{
		// 处理分页
		$multipage = $core->Multipage($data['total_comment'], intval($_GET['page']), $perpage, 'html', '/'.$data['hash_id'].'-1.html');
		$offset = $multipage['offset'];
	}

	// 当前页起始楼层
	$first_floor = 1 + $offset;

	$query = $core->DB->Execute("SELECT * FROM {$core->TablePre}comment WHERE data_id='{$data['data_id']}' AND comment_auditing='1' ORDER BY comment_id ASC LIMIT $offset, $perpage");
	if ($query)
	{
		$key = 0;
		while (!$query->EOF)
		{
			$comment_data[$key] = $query->fields;

			$comment_data[$key]['comment_date'] = date('Y-m-d H:i:s', $comment_data[$key]['comment_date']);
			$comment_data[$key]['comment_content'] = nl2br($comment_data[$key]['comment_content']);
			$comment_data[$key]['comment_content'] = preg_replace('#\[smilie\:(\d+)\]#ie', 'smilie_replace(\\1)', $comment_data[$key]['comment_content']);

			$key++;
			$query->MoveNext();
		}
	}
}

// 表情代码替换
function smilie_replace($num)
{
	if (0 > $num || $num > 44) return '[smilie:'.$num.']';
	return '<img src="/images/smilies/'.$num.'.gif" />';
}

// 显示
$core->tpl->assign(array(
	'SiteTitle'   => $core->Language['comment']['title'].':'.$data['data_title'], 
	'SubNav'      => $core->Language['comment']['title'], 
	'Data'        => $data, 
	'HtmlSubPath' => date('Y/md', $data['release_date']), 
	'CommentData' => $comment_data, 
	'Totalnum'    => $total_num, 
	'Multipage'   => $multipage, 
	'FirstFloor'  => $first_floor, 
));
$core->tpl->display('show_comment.tpl');
?>