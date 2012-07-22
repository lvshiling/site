<?php
define('IN_PLACE', 'admin');
define('IN_SCRIPT', 'report');

require_once('global.php');

CheckPermission('is_super_manager');


// ################## 删除举报信息 ################## //
if ('delete' == $_POST['op'])
{
	$data_id_arr = $_POST['data_id'];
	$delete_total = count($data_id_arr);
	if (0 >= $delete_total)
	{
		$core->Notice($core->Language['report']['no_select'], 'back');
	}

	$core->DB->Execute("DELETE FROM {$core->TablePre}report WHERE report_id IN (".implode(',', $data_id_arr).")");

	$core->ManagerLog($core->LangReplaceText($core->Language['report']['log_delete'], $delete_total));

	$core->Notice($core->Language['report']['delete_succeed'], 'halt');
}

// ################## 显示举报信息 ################## //
$condition = '1=1';
$keyword = trim($_GET['keyword']);
if (!empty($keyword))
{
	$keyword = htmlspecialchars($keyword);
	$condition .= " AND report_content LIKE '%".$keyword."%'";
}

$report_data = array();
$report_data_count = $core->DB->GetRow("SELECT COUNT(*) AS num FROM {$core->TablePre}report WHERE $condition");
$totalnum = $report_data_count['num'];
unset($report_data);
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
	$report_data = $core->DB->GetArray("SELECT * FROM {$core->TablePre}report WHERE $condition ORDER BY report_id DESC LIMIT $offset, $perpage");
}

$core->tpl->assign(array(
	'ReportData' => $report_data,
	'totalnum'   => $totalnum,
	'multipage'  => $multipage,
));
$core->tpl->display('report.tpl');
?>