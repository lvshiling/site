<?php
define('IN_PLACE', 'www');
define('IN_SCRIPT', 'list');
//define('NOT_USE_CACHE', '');
// list缓存时间
define('CACHE_PLACE', 'list');

require_once('../global.php');

// 检查用户是否有访问权限
if (!$core->UserInfo['user_id'])
{
	header('Location: '.$core->Config['domain_vip'].'/user.php?o=login&goto='.urlencode(CURRENT_URL));
	exit;
}

$core->IPValidateCheck();

$page = intval($_GET['page']);
$page || $page = 1;
$id = intval($_GET['id']);
if (0 >= $id && 'sort' == $_GET['act'])
{
	header('Location: /');exit;
}

$condition = 'd.is_auditing=1 AND d.mark_deleted=0';
switch ($_GET['act'])
{
	case 'sort':
		$exists_sub_sort = FALSE;
		$child_sort = $core->sort->GetChild($id);
		if (is_array($child_sort) && $child_sort)
		{
			$exists_sub_sort = TRUE;
			// 所有子分类包括自己
			$child_sort[] = $id;
			$condition .= " AND d.sort_id IN(".implode(',', $child_sort).")";
		}
		else
		{
			$condition .= " AND d.sort_id='{$id}'";
		}
	break;
	// 今日新增
	case 'today':
		$condition .= " AND d.release_date >= UNIX_TIMESTAMP(CURRENT_DATE())";
		$site_title = $core->Language['page']['title_today'];
		$id = 'today';
	break;
	// 昨日新增
	case 'yesterday':
		$condition .= " AND d.release_date <= UNIX_TIMESTAMP(DATE_SUB(CURRENT_DATE(), INTERVAL 1 SECOND)) AND d.release_date >= UNIX_TIMESTAMP(DATE_SUB(CURRENT_DATE(), INTERVAL 1 DAY))";
		$site_title = $core->Language['page']['title_yesterday'];
		$id = 'yesterday';
	break;
	default:
		// 显示所有
		unset($_GET['act']);
		$site_title = '';
	break;
}

$template_name = 'list_multipage.tpl';
$cache_only_key = $core->CheckCache($template_name, 'list', $_GET['act'].$id.$page);

$sub_nav = '';
if ('sort' == $_GET['act'])
{
	if (!$core->sort->SortList[$id])
	{
		// 没有这个分类
		$core->Notice($core->Language['page']['view_sort_not_exists'], 'back');
	}

	// 外部链接
	if ($core->sort->SortList[$id]['external'])
	{
		header('Location: '.$core->sort->SortList[$id]['external']);
		exit;
	}

	// 取得父分类树
	$parent_tree = $core->sort->GetParentTree($id);
	if ($parent_tree)
	{
		foreach ($parent_tree as $sort_id=>$sort_name)
		{
			$sub_nav .= '<a href="/sort-'.$sort_id.'-1.html">'.$sort_name.'</a> &raquo; ';
		}
	}

	$site_title = strip_tags($core->sort->SortList[$id]['name']);
	$sub_nav .= $core->sort->SortList[$id]['name'];
}

if ('sort' == $_GET['act'])
{
	$total = $core->DB->GetRow("SELECT COUNT(*) AS num FROM {$core->TablePre}data AS d WHERE {$condition}");
	$total_num = $total['num'];

	$data = array();
	if (0 < $total_num)
	{
		$perpage = $core->Config['pagination_list_num'];
		$offset = 0;

		if ($total_num > $perpage)
		{
			$multipage = $core->Multipage($total_num, $page, $perpage, 'html', '/sort-'.$id.'-1.html');
			$offset = $multipage['offset'];
		}

		require_once(ROOT_PATH.'/include/kernel/class_list.php');
		$list = new XXList($core);
		if ($exists_sub_sort || !$_GET['act'])
		{
			$list->show_sort = TRUE;
		}

		$data = $list->html("SELECT * FROM {$core->TablePre}data AS d WHERE {$condition} ORDER BY d.release_date DESC LIMIT {$offset}, {$perpage}");
	}
}
else
{
	if (!$id) $limit = " LIMIT {$core->Config['pagination_list_num']}";
	require_once(ROOT_PATH.'/include/kernel/class_list.php');
	$list = new XXList($core);
	$list->show_sort = TRUE;
	$data = $list->html("SELECT * FROM {$core->TablePre}data AS d WHERE {$condition} ORDER BY d.release_date DESC{$limit}");
}

// 显示
$core->tpl->assign_by_ref('Data', $data);
$core->tpl->assign(array(
	'SiteTitle'    => $site_title,
	'SubNav'       => $sub_nav,
	'Action'       => $_GET['act'],
	'ID'           => $id,
	'Totalnum'     => $total_num,
	'Multipage'    => $multipage,
));
$core->tpl->display($template_name, $cache_only_key);
?>