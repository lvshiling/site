<?php
define('IN_PLACE', 'admin');
define('IN_SCRIPT', 'sort');

require_once('global.php');

CheckPermission('is_super_manager');

//  ################## 删除评论 ################## //
if ('delete' == $_POST['op'])
{
	$data_id_arr = $_POST['data_id'];
	if (0 >= count($data_id_arr))
	{
		$core->Notice($core->Language['comment']['error_no_select'], 'back');
	}

	$comment_ids = implode(',', $data_id_arr);
	/*
	$query = $core->DB->Execute("SELECT data_id FROM {$core->TablePre}comment WHERE comment_id IN ({$comment_ids})");
	while (!$query->EOF)
	{
		$core->DB->Execute("UPDATE {$core->TablePre}data SET total_comment=total_comment-1 WHERE data_id='{$query->fields['data_id']}'");

		$query->MoveNext();
	}
	*/

	$core->DB->Execute("DELETE FROM {$core->TablePre}comment WHERE comment_id IN ({$comment_ids})");

	header('Location: '.REQUEST_URI);
	exit;
}

//  ################## 审核评论 ################## //
if ('auditing' == $_POST['op'])
{
	$data_id_arr = $_POST['data_id'];
	if (0 >= count($data_id_arr))
	{
		$core->Notice($core->Language['comment']['error_no_select'], 'back');
	}

	$core->DB->Execute("UPDATE {$core->TablePre}comment SET comment_auditing=1 WHERE data_id IN (".implode(',', $data_id_arr).")");
	header('Location: '.REQUEST_URI);
	exit;
}

//  ################## 评论列表 ################## //
$condition = '1=1';
$data_id = intval($_GET['data_id']);
if (0 < $data_id)
{
	$condition .= " AND c.data_id='{$data_id}'";
}
if (1 == $_GET['report'])
{
	$condition .= " AND report_num>0";
}
if (isset($_GET['auditing']))
{
	$auditing = 1==$_GET['auditing'] ? 1 : 0;
	$condition .= " AND comment_auditing='{$auditing}'";
}
$keyword = trim($_GET['keyword']);
if (!empty($keyword))
{
	$condition .= " AND c.comment_content LIKE '%{$keyword}%'";
}

$comment_data = array();
$total = $core->DB->GetRow("SELECT COUNT(*) AS num FROM {$core->TablePre}comment AS c WHERE {$condition}");
if (0 < $total['num'])
{
	$perpage = 30;
	$offset = 0;
	if ($total['num'] > $perpage)
	{
		// 处理分页
		$pageinfo = $core->Multipage($total['num'], $_GET['page'], $perpage);
		$offset = $pageinfo['offset'];

		$multipage = '<span class="multipage">'.$pageinfo['page'].'</span>';
	}

	$query = $core->DB->Execute("
		SELECT c.*, d.hash_id 
		FROM {$core->TablePre}comment AS c 
		LEFT JOIN {$core->TablePre}data AS d ON(c.data_id=d.data_id) 
		WHERE {$condition} 
		ORDER BY c.comment_id DESC 
		LIMIT $offset, $perpage
	");
	if ($query)
	{
		$key = 0;
		while (!$query->EOF)
		{
			$comment_data[$key] = $query->fields;

			$comment_data[$key]['comment_content'] = nl2br($comment_data[$key]['comment_content']);

			$key++;
			$query->MoveNext();
		}
	}
}

$core->tpl->assign(array(
	'CommentData'     => $comment_data,
	'CommentTotalnum' => $total['num'],
	'multipage'       => $multipage,
));
$core->tpl->display('comment.tpl');
?>