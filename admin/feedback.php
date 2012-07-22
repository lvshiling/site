<?php
define('IN_PLACE', 'admin');
define('IN_SCRIPT', 'feedback');

require_once('global.php');

CheckPermission('is_super_manager');


// ################## 删除反馈信息 ################## //
if ('delete' == $_POST['op'])
{
	$data_id_arr = $_POST['data_id'];
	$delete_total = count($data_id_arr);
	if (0 >= $delete_total)
	{
		$core->Notice($core->Language['feedback']['no_select'], 'back');
	}

	$core->DB->Execute("DELETE FROM {$core->TablePre}feedback WHERE feedback_id IN (".implode(',', $data_id_arr).")");

	$core->ManagerLog($core->LangReplaceText($core->Language['feedback']['log_delete'], $delete_total));

	$core->Notice($core->Language['feedback']['delete_succeed'], 'halt');
}

// ################## 显示反馈信息 ################## //
$condition = '1=1';
$keyword = trim($_GET['keyword']);
if (!empty($keyword))
{
	$keyword = htmlspecialchars($keyword);
	$condition .= " AND feedback_content LIKE '%".$keyword."%'";
}

$feedback_data = array();
$feedback_data_count = $core->DB->GetRow("SELECT COUNT(*) AS num FROM {$core->TablePre}feedback WHERE $condition");
$totalnum = $feedback_data_count['num'];
unset($feedback_data);
if (0 < $totalnum)
{
	// 每页显示记录
	$perpage = 30;
	$offset = 0;
	if ($totalnum > $perpage)
	{
		$pageinfo = $core->Multipage($totalnum, $_GET['page'], $perpage);
		$offset = $pageinfo['offset'];

		$multipage = '<span class="multipage">'.$pageinfo['page'].'</span>';
	}

	// 查询记录
	$feedback_data = $core->DB->GetArray("SELECT * FROM {$core->TablePre}feedback WHERE $condition ORDER BY feedback_id DESC LIMIT $offset, $perpage");
}

$core->tpl->assign(array(
	'FeedbackData' => $feedback_data,
	'totalnum'   => $totalnum,
	'multipage'  => $multipage,
));
$core->tpl->display('feedback.tpl');
?>