<?php
if (!defined('IN_SITE')) @header('HTTP/1.1  404  Not  Found');

// ################## 数据批量管理 ################## //
if ('batch' == $_POST['op'])
{
	require_once(ROOT_PATH.'/include/kernel/class_moderate.php');
	$mod = new Moderate($core);
	$mod->Execute();

	$core->Notice($core->Language['common']['succeed'].'<br /><a href="'.REQUEST_URI.'">'.$core->Language['data']['back_list'].'</a>', 'halt');
}

require_once(ROOT_PATH.'/include/kernel/class_permission.php');
$permission = new Permission($core);

set_time_limit(60);

// ################## 编辑数据 ################## //
if ('edit' == $_POST['op'])
{
	$edit_data_id = intval($_POST['id']);
	$data = $core->DB->GetRow("SELECT * FROM {$core->TablePre}data WHERE data_id='{$edit_data_id}'");
	if (!$data || $data['mark_deleted'])
	{
		$core->Notice($core->Language['common']['data_not_exist'], 'back');
	}
	// 检查编辑权限
	$permission->Check('edit', $data['user_id']);

	require_once(ROOT_PATH.'/include/kernel/class_content_clean.php');
	$clear = new ContentClean($core);
	$clear->Execute($_POST);

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
		UPDATE {$core->TablePre}data SET 
			sort_id='{$_POST['sort_id']}', 
			data_title='{$_POST['title']}', 
			page_num='{$page_num}', 
			lastedit_date='".TIME_NOW."', 
			is_auditing='0' 
		WHERE data_id='{$data['data_id']}'
	");
	$core->DB->Execute("
		UPDATE {$core->TablePre}data_ext SET 
			data_title='{$_POST['title']}', 
			data_content='{$_POST['content']}' 
		WHERE data_id='{$data['data_id']}'
	");

	/*
	if (!$is_auditing || $page_num != $data['page_num'])
	{
		$core->DeleteHtml($data['data_id'], $data['page_num']);
	}
	if ($is_auditing)
	{
		$core->CreateHtml($data['data_id']);
	}
	*/

	// 操作成功转向的地址
	$goto_url = trim($_POST['url']);
	if ('' == $goto_url || $goto_url == 'index.php')
	{
		$goto_url = 'user.php?o=data';
	}
	else
	{
		$goto_url = urldecode($goto_url);
	}

	$notice_msg = $core->Language['data']['edit_succeed'].'<br /><a href="'.$goto_url.'">'.$core->Language['data']['back_list'].'</a>';

	$core->Notice($notice_msg, 'halt');
}
if ('edit' == $_GET['act'])
{
	$data_id = intval($_GET['id']);
	$data = $core->DB->GetRow("SELECT d.*, de.data_content FROM {$core->TablePre}data AS d, {$core->TablePre}data_ext AS de WHERE d.data_id=de.data_id AND d.data_id='{$data_id}'");
	if (!$data || $data['mark_deleted'])
	{
		$core->Notice($core->Language['common']['data_not_exist'], 'back');
	}
	// 检查编辑权限
	$permission->Check('edit', $data['user_id']);

	if ($data['lastedit_date'] > TIME_NOW - $core->Config['content_edit_space_time'] * 60)
	{
		$core->Notice($core->LangReplaceText($core->Language['data']['error_edit_space_time'], $core->Config['content_edit_space_time']), 'back');
	}

	if (!defined('HTTP_REFERER'))
	{
		define('HTTP_REFERER', $core->GetReferrerUrl());
	}

	$core->tpl->assign(array(
		'SiteTitle'  => $core->Language['data']['edit_title'],
		'SortOption' => $core->sort->GetSortOption($data['sort_id']),
		'Data'       => $data,
		'Action'     => 'edit',
	));
	$core->tpl->display('user/post.tpl');
	exit;
}

// ################## 显示记录列表 ################## //
$condition = "user_id='{$core->UserInfo['user_id']}' AND mark_deleted='0'";

$keyword = trim($_GET['u_keyword']);
if (!empty($keyword))
{
	$keyword = htmlspecialchars($keyword);
	$condition .= " AND data_title LIKE '%".$keyword."%'";
}

// 检查是否有编辑权限
$can_edit = FALSE;
if ($core->UserInfo['can_edit'])
{
	$can_edit = TRUE;
}

// 符合条件的记录总数
$data_count = $core->DB->GetRow("SELECT COUNT(*) AS num FROM {$core->TablePre}data WHERE $condition");
$totalnum = $data_count['num'];
unset($data);
if (0 < $totalnum)
{
	// 每页显示记录
	$perpage = 30;
	$offset = 0;
	if ($totalnum > $perpage)
	{
		$multipage = $core->Multipage($totalnum, $_GET['page'], $perpage);
		$offset = $multipage['offset'];
	}

	require_once(ROOT_PATH.'/include/kernel/class_list.php');
	$list = new XXList($core);
	$list->show_sort = TRUE;
	$list->show_author = FALSE;
	$data = $list->html("SELECT * FROM {$core->TablePre}data WHERE {$condition} ORDER BY release_date DESC LIMIT $offset, $perpage");

	// 创建管理选项下拉菜单
	$manage_select = array();
	if ($core->UserInfo['can_delete'])
	{
		$manage_select['delete'] = $core->Language['data']['delete'];
	}
}

// ################## 列表显示 ################## //
$core->tpl->assign(array(
	'SiteTitle'    => $core->Language['data']['page_title'],
	'Data'         => $data,
	'CanEdit'      => $can_edit,
	'ManageSelect' => $manage_select,
	'keyword'      => stripslashes($keyword),
	'Multipage'    => $multipage,
));
$core->tpl->display('user/data.tpl');
?>