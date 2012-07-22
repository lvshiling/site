<?php
// 执行的操作
$act = $argv[1];
if (!preg_match('#^\w+$#', $act)) exit;

define('IN_PLACE', 'admin');
define('IN_SCRIPT', 'cron');
// 模板文件存放子目录
define('TEMPLATE_SUB_DIR', 'admin');
// 关闭文件缓存
define('NOT_USE_CACHE', '');

require_once('init.php');

define('SITE_ROOT_PATH', $core->Config['domain_www']);
define('IS_VIP', 0);

// 连接数据库
$core->InitAdodb();

// 循环100次停一秒
//sleep(1);
// 1.网站首页 - 每5分钟
// 2.热门搜索 - 每天00:00:01
if ('home' == $act || 'hotsearch' == $act || 'today' == $act || 'yesterday' == $act)
{
	require_once(ROOT_PATH.'/include/kernel/class_sort.php');
	$core->sort = new Sort($core->Config);

	$core->CreateHtml($act);
}
// 3.更新所有分类列表
else if ('list' == $act)
{
	require_once(ROOT_PATH.'/include/kernel/class_sort.php');
	$core->sort = new Sort($core->Config);

	require_once(ROOT_PATH.'/include/kernel/class_html.php');
	$create = new Html($core);
	$core->SetTemplateDir('www');
	$num = 0;
	foreach ($core->sort->SortList as $sort_id=>$row)
	{
		if ($row['vip']) continue;

		$condition = 'is_auditing=1 AND mark_deleted=0';
		$child_sort = $core->sort->GetChild($sort_id);
		if (is_array($child_sort) && $child_sort)
		{
			$exists_sub_sort = TRUE;
			$child_sort[] = $sort_id;
			$condition .= " AND sort_id IN(".implode(',', $child_sort).")";
		}
		else
		{
			$condition .= " AND sort_id='{$sort_id}'";
		}
		$sub_nav = '';
		$parent_tree = $core->sort->GetParentTree($sort_id);
		if ($parent_tree)
		{
			foreach ($parent_tree as $sid=>$sort_name)
			{
				$sub_nav .= '<a href="/sort-'.$sid.'-1.html">'.$sort_name.'</a> &raquo; ';
			}
		}
		$sub_nav .= $core->sort->SortList[$sort_id]['name'];

		$total = $core->DB->GetRow("SELECT COUNT(*) AS num FROM {$core->TablePre}data WHERE {$condition}");
		$total = $total['num'];
		$total || $total = 1;
		$total_page = ceil($total/$core->Config['pagination_list_num']);

		for ($page = 1; $page <= $total_page; $page++)
		{
			$create->OneList($sub_nav, $sort_id, $exists_sub_sort, $total, $page, $condition);
			$num++;

			if ($num%50 == 0) sleep(1);
		}
	}
}
// 4.删除所有标记为删除的资源(每5分钟)
else if ('delete' == $act)
{
	$query = $core->DB->Execute("SELECT data_id, user_id, page_num FROM {$core->TablePre}data WHERE mark_deleted=1 ORDER BY data_id ASC");
	while (!$query->EOF)
	{
		$core->DeleteHtml($query->fields['data_id'], $query->fields['page_num']);

		$core->DB->Execute("UPDATE {$core->TablePre}user SET post_totalnum=post_totalnum-1 WHERE user_id='{$query->fields['user_id']}'");

		$query->MoveNext();
	}
	$core->DB->Execute("DELETE {$core->TablePre}data, {$core->TablePre}data_ext, {$core->TablePre}comment FROM {$core->TablePre}data AS d LEFT JOIN {$core->TablePre}data_ext AS de ON(d.data_id=de.data_id) LEFT JOIN {$core->TablePre}comment AS c ON(d.data_id=c.data_id) WHERE d.mark_deleted=1");
}
else{}
?>