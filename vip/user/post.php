<?php
if (!defined('IN_SITE')) @header('HTTP/1.1  404  Not  Found');

// 检查是否有发布权限
require_once(ROOT_PATH.'/include/kernel/class_permission.php');
$permission = new Permission($core);
$permission->Check('add', $core->UserInfo['user_id']);

set_time_limit(60);

// ################## 预览内容介绍 ################## //
if ('preview' == $_POST['op'])
{
	$preview_content = $_POST['preview_content'];
	if ('' == $preview_content)
	{
		$core->Notice($core->Language['content']['error_intro_empty'], 'halt');
	}

	require_once(ROOT_PATH.'/include/library/safehtml/safehtml.php');
	$safehtml = new safehtml();
	$preview_content = $safehtml->parse(stripslashes($preview_content));
	$safehtml->clear();

	$core->tpl->assign(array(
		'SiteTitle'      => $core->Language['post']['preview'],
		/*预览内容*/
		'PreviewContent' => $preview_content,
	));
	$core->tpl->display('user/intro_preview.tpl');
	exit;
}

// ################## 发表 ################## //
if ('post' == $_POST['op'])
{
	//$core->CheckVerifyCode('post', $_POST['vcode']);

	require_once(ROOT_PATH.'/include/kernel/class_content_clean.php');
	$clear = new ContentClean($core);
	$clear->Execute($_POST);

	$hash_id = md5(TIME_NOW.$core->RandStr(6));
	/*
	if (1 == $core->UserInfo['post_auditing'])
	{
		$is_auditing = 0;
	}
	else if (0 == $core->UserInfo['post_auditing'])
	{
		$is_auditing = 1;
	}
	else
	{
		$is_auditing = $core->Config['post_auditing'] ? 0 : 1;
	}
	*/

	$page_num = $core->GetHtmlPageNum($_POST['content']);
	if ($page_num > $core->Config['content_max_multipage_num'])
	{
		$core->Notice($core->LangReplaceText($core->Language['post']['error_multipage_num'], $core->Config['content_max_multipage_num']), 'back');
	}

	$core->DB->Execute("
		INSERT INTO {$core->TablePre}data (
			hash_id, 
			user_id, 
			user_name, 
			sort_id, 
			data_title, 
			page_num, 
			release_date, 
			ipaddress
		) VALUES (
			'{$hash_id}', 
			'{$core->UserInfo['user_id']}', 
			'".addslashes($core->UserInfo['user_name'])."', 
			'{$_POST['sort_id']}', 
			'{$_POST['title']}', 
			'{$page_num}', 
			'".TIME_NOW."', 
			'".CLIENT_IP."'
		)
	");
	$new_data_id = $core->DB->Insert_ID();
	if (0 >= $new_data_id)
	{
		$core->Notice($core->Language['post']['aborted'], 'back');
	}

	$core->DB->Execute("INSERT INTO {$core->TablePre}data_ext (data_id, data_title, data_content) VALUES ('{$new_data_id}', '{$_POST['title']}', '{$_POST['content']}')");

	$core->DB->Execute("UPDATE {$core->TablePre}user SET post_totalnum=post_totalnum+1 WHERE user_id='{$core->UserInfo['user_id']}'");

	/*
	if ($is_auditing)
	{
		$core->CreateHtml($new_data_id);
	}
	*/

	//$core->DestructVerifyCode('post');

	if ($core->sort->SortList[$_POST['sort_id']]['vip'])
	{
		$show_url = $core->Config['domain_vip'].'/show-'.$hash_id.'.html';
	}
	else
	{
		$show_url = $core->Config['domain_www'].'/show/'.date('Y/md', TIME_NOW).'/'.$new_data_id.'.html';
	}

	$notice_msg = $core->Language['post']['succeed'].'<br />';
	$notice_msg .= $core->Language['post']['view_new_auditing'];
	$notice_msg .= '<br /><a href="user.php?o=post">'.$core->Language['post']['continue_post'].'</a>';

	$core->Notice($notice_msg, 'halt');
}

$core->tpl->assign(array(
	'SiteTitle'  => $core->Language['post']['page_title'],
	'Action'     => 'post',
	/*分类*/
	'SortOption' => $core->sort->GetSortOption(),
));
$core->tpl->display('user/post.tpl');
?>