<?php
define('IN_PLACE', 'admin');
define('IN_SCRIPT', 'search');

require_once('global.php');

CheckPermission('is_super_manager');

// 删除选择的热门关键字
if ('delete' == $_POST['op'])
{
	$keywords = $_POST['data_id'];
	if (!$keywords)
	{
		$core->Notice($core->Language['common']['p_error'], 'back');
	}

	foreach ($keywords as $keyword)
	{
		$core->DB->Execute("DELETE FROM {$core->TablePre}search_keyword WHERE search_keyword='{$keyword}'");
	}

	$core->KeywordTop(1);

	$goto_url = $core->GetReferrerUrl();
	if ('index.php' == $goto_url)
	{
		$goto_url = 'search.php?act=keyword';
	}

	header('Location:'.$goto_url);
	exit;
}

// 强制更新热门关键字排行
if ('force_update' == $_GET['act'])
{
	$core->KeywordTop(1);

	$core->Notice($core->Language['common']['succeed'], 'goto', 'search.php?act=keyword');
	exit;
}

// 搜索热门关键字
if ('keyword' == $_GET['act'])
{
	$condition = '1=1';
	$keyword = trim($_GET['keyword']);
	if (!empty($keyword))
	{
		$keyword = htmlspecialchars($keyword);
		$condition .= " AND search_keyword LIKE '%{$keyword}%'";
	}

	$keyword_data_count = $core->DB->GetRow("SELECT COUNT(*) AS num FROM {$core->TablePre}search_keyword WHERE {$condition}");
	$totalnum = $keyword_data_count['num'];
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

		$keyword_data = $core->DB->GetArray("
			SELECT * 
			FROM {$core->TablePre}search_keyword 
			WHERE {$condition} 
			ORDER BY search_num DESC 
			LIMIT $offset, $perpage
		");
	}

	$core->tpl->assign(array(
		'KeywordData' => $keyword_data,
		'multipage'   => $multipage,
		'totalnum'    => $totalnum,
	));
	$core->tpl->display('search_keyword.tpl');
	exit;
}
?>