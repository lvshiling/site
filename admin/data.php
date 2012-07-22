<?php
define('IN_PLACE', 'admin');
define('IN_SCRIPT', 'data');

require_once('global.php');

CheckPermission('can_manage_data');

if (!defined('HTTP_REFERER'))
{
	define('HTTP_REFERER', $core->GetReferrerUrl());
}

// ################## 数据批量管理 ################## //
if ('batch' == $_POST['op'])
{
	require_once(ROOT_PATH.'/include/kernel/class_moderate.php');
	$mod = new Moderate($core);
	$mod->sort = $sort;
	$mod->AdminManage = TRUE;
	$mod->Execute();

	$core->Notice($core->Language['common']['succeed'].'[<a href="'.REQUEST_URI.'">'.$core->Language['common']['continue'].'</a>]', 'goto', REQUEST_URI);
}

// ################## 生成HTML文件 ################## //
if ('html' == $_GET['act'])
{
	$core->CreateHtml($_GET['id'], $sort);
	header('Location: '.urldecode(HTTP_REFERER));
	exit;
}

// ################## 编辑资源 ################## //
if ('edit' == $_POST['op'])
{
	$edit_data_id = intval($_POST['id']);
	$data = $core->DB->GetRow("SELECT * FROM {$core->TablePre}data WHERE data_id='{$edit_data_id}'");
	if (!$data || $data['mark_deleted'])
	{
		$core->Notice($core->Language['common']['data_not_exist'], 'back');
	}

	require_once(ROOT_PATH.'/include/kernel/class_content_clean.php');
	$clear = new ContentClean($core);
	$clear->Execute($_POST);

	$page_num = $core->GetHtmlPageNum($_POST['content']);
	$is_auditing = 1==$_POST['auditing'] ? 1 : 0;

	if ($is_auditing) $mark_update = TIME_NOW;
	else $mark_update = 0;

	$core->DB->Execute("
		UPDATE {$core->TablePre}data SET 
			sort_id='".$_POST['sort_id']."', 
			data_title='".$_POST['title']."', 
			page_num='{$page_num}', 
			is_auditing='{$is_auditing}', 
			mark_update='{$mark_update}' 
		WHERE data_id='".$data['data_id']."'
	");
	$core->DB->Execute("
		UPDATE {$core->TablePre}data_ext SET 
			data_title='".$_POST['title']."', 
			data_content='".$_POST['content']."' 
		WHERE data_id='".$data['data_id']."'
	");

	if (!$is_auditing || $page_num != $data['page_num'])
	{
		$core->DeleteHtml($data['data_id'], $data['page_num']);
	}
	if ($is_auditing)
	{
		$core->CreateHtml($data['data_id'], $sort);
	}

	$core->ManagerLog($core->Language['data']['log_edit'].$data['data_id']);

	// 操作成功转向的地址
	$goto_url = trim($_POST['url']);
	if ('' == $goto_url || $goto_url == 'index.php')
	{
		$goto_url = 'data.php?act=list';
	}
	else
	{
		$goto_url = urldecode($goto_url);
	}

	$core->Notice($core->Language['common']['succeed'].'[<a href="'.$goto_url.'">'.$core->Language['common']['continue'].'</a>]', 'goto', $goto_url);
	exit;
}
if ('edit' == $_GET['act'])
{
	$data_id = intval($_GET['id']);
	$data = $core->DB->GetRow("SELECT d.*, de.data_content FROM {$core->TablePre}data AS d, {$core->TablePre}data_ext AS de WHERE d.data_id=de.data_id AND d.data_id='{$data_id}'");
	if (!$data || $data['mark_deleted'])
	{
		$core->Notice($core->Language['common']['data_not_exist'], 'back');
	}

	$core->tpl->assign(array(
		'SortOption' => $core->sort->GetSortOption($data['sort_id']),
		'Data' => $data,
	));
	$core->tpl->display('data_edit.tpl');
	exit;
}


// ################## 列表显示数据 ################## //
if ('list' == $_GET['act'])
{
	$condition = 'd.mark_deleted=0';
	// 搜索HASH
	$hash = trim($_GET['hash']);
	if (preg_match('#^[a-z0-9]{32}$#i', $hash))
	{
		$condition = "d.hash_id='{$hash}'";
	}
	// 是否搜索扩展表
	$is_search_ext = 0;
	// 关键字
	$keyword = trim($_GET['keyword']);
	if (!empty($keyword))
	{
		$keyword = htmlspecialchars($keyword);
		switch ($_GET['bound'])
		{
			// 内容和标题
			case 'all':
				$is_search_ext = 1;
				$condition .= " AND (de.data_title LIKE '%".htmlspecialchars($keyword)."%' OR de.data_content LIKE '%".htmlspecialchars($keyword)."%')";
			break;
			// 内容
			case 'content':
				$is_search_ext = 1;
				$condition .= " AND de.data_content LIKE '%".htmlspecialchars($keyword)."%'";
			break;
			// 标题
			default:
				$condition .= " AND d.data_title LIKE '%".htmlspecialchars($keyword)."%'";
			break;
		}
	}
	// 所属分类
	$sort_id = intval($_GET['sort_id']);
	if (0 < $sort_id)
	{
		$condition .= " AND d.sort_id='".$sort_id."'";
	}
	// 所属用户ID或用户名
	$_GET['user_id'] = trim($_GET['user_id']);
	if (!empty($_GET['user_id']))
	{
		if (preg_match('#^[1-9]{1}\d*$#', $_GET['user_id']))
		{
			// ID
			$condition .= " AND d.user_id='{$_GET['user_id']}'";
		}
		else
		{
			// 用户名
			$user_name = htmlspecialchars($_GET['user_id']);
			$get_user = $core->DB->GetRow("SELECT user_id FROM {$core->TablePre}user WHERE user_name='{$user_name}'");
			$condition .= " AND d.user_id='{$get_user['user_id']}'";
		}
	}
	// 是否已审核
	switch ($_GET['auditing'])
	{
		case '1':
			$condition .= " AND d.is_auditing='1'";
		break;
		case '0':
			$condition .= " AND d.is_auditing='0'";
		break;
		default:
			// void
		break;
	}
	// 排序方式
	switch ($_GET['by'])
	{
		case 'edate':
			$by = 'd.lastedit_date';// 最后修改
		break;
		default:
			$by = 'd.release_date';// 发布日期
		break;
	}
	$order = $_GET['order']=='asc' ? 'ASC' : 'DESC';
	if (!$is_search_ext)
	{
		$count_sql = "SELECT COUNT(d.data_id) AS num FROM {$core->TablePre}data AS d WHERE $condition";
		$query_sql = "SELECT d.* FROM {$core->TablePre}data AS d WHERE {$condition}";
	}
	else
	{
		$count_sql = "SELECT COUNT(d.data_id) AS num FROM {$core->TablePre}data AS d, {$core->TablePre}data_ext AS de WHERE d.data_id=de.data_id AND $condition";
		$query_sql = "SELECT d.* FROM {$core->TablePre}data AS d, {$core->TablePre}data_ext AS de WHERE d.data_id=de.data_id AND {$condition}";
	}

	$data_count = $core->DB->GetRow($count_sql);
	$totalnum = $data_count['num'];
	unset($data);
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
		$query = $core->DB->Execute($query_sql." ORDER BY $by $order LIMIT $offset, $perpage");
		if (!$query)
		{
			$core->Notice('db query error: 0001', 'halt');
		}
		$data = array();
		$key = 0;
		while (!$query->EOF)
		{
			$data[$key] = $query->fields;

			if (!empty($data[$key]['title_style']))
			{
				$_style = '<span style="';
				$title_style = explode('|', $data[$key]['title_style']);
				if ($title_style[0]) $_style .= 'color:'.$title_style[0].';';
				if ($title_style[1]) $_style .= 'font-weight:bold;';
				if ($title_style[2]) $_style .= 'text-decoration:line-through;';
				if ($title_style[3]) $_style .= 'font-style:italic;';
				$_style .= '">';

				$data[$key]['data_title'] = $_style.$data[$key]['data_title'].'</span>';
			}

			// 从缓存获取分类名称
			$data[$key]['sort_name'] = $core->sort->SortList[$data[$key]['sort_id']]['name'];
			if ('' == $data[$key]['sort_name']) $data[$key]['sort_name'] = 'UNKNOWN';

			$data[$key]['show_url'] = $core->Config['domain_vip'].'/show-'.$data[$key]['hash_id'].'.html';

			$key++;
			$query->MoveNext();
		}
	}

	$core->tpl->assign(array(
		'Data'    => $data,
		'multipage' => $multipage,
		'totalnum'  => $totalnum,
	));
	$core->tpl->display('data_search_result.tpl');
	exit;
}

// ################## 搜索表单显示 ################## //
$core->tpl->assign(array(
	'SortOption' => $core->sort->GetSortOption(),
));
$core->tpl->display('data_search.tpl');
?>