<?php
define('IN_PLACE', 'www');
define('IN_SCRIPT', 'search');
// list:缓存时间同列表缓存时间
define('CACHE_PLACE', 'list');

require_once('../global.php');

// 暂时关闭缓存
$core->tpl->caching = FALSE;

$keyword = trim($_GET['keyword']);
$content = trim($_GET['content']);
$user = trim($_GET['user']);

// ################## 执行搜索 ################## //
if (!empty($keyword) || !empty($content) || !empty($user))
{
	// 搜索关闭
	if ($core->Config['search_close'])
	{
		$core->Notice($core->Language['search']['close'], 'back');
	}

	if (isset($_GET['user']))
	{
		$keyword = $user;
		$user_info = $core->DB->GetRow("SELECT user_id FROM {$core->TablePre}user WHERE user_name='{$keyword}' LIMIT 1");
		if (!$user_info)
		{
			$core->Notice($core->LangReplaceText($core->Language['search']['error_user_not_exist'], $keyword), 'back');
		}
		$condition = "d.user_id='{$user_info['user_id']}' AND d.is_auditing=1 AND d.mark_deleted=0";
	}
	else
	{
		if (isset($_GET['content']) && !isset($_GET['keyword']))
		{
			$_GET['field'] = 'tandc';
			$keyword = $content;
		}
		require_once(ROOT_PATH.'/include/kernel/class_search.php');
		$search = new Search($core);
		$condition = $search->Condition($keyword);
	}

	$search_key = md5($condition);

	$page = intval($_GET['page']);
	$page = 0 >= $page ? 1 : $page;

	// 强制打开缓存
	$core->tpl->caching = TRUE;
	$template_name = 'list_multipage.tpl';
	// 检查缓存是否有效
	$cache_only_key = $core->CheckCache($template_name, 'search', $search_key.$page.(IS_VIP?'vip':''));

	// ####################### 缓存无效 ####################### //
	$search_state = array();
	// 使用不同条件时限制搜索时间
	// 两次搜索间隔时间限制
	if (!isset($core->Config['search_space_time']))
	{
		$core->Config['search_space_time'] = 60;
	}
	if (0 < (int)$core->Config['search_space_time'])
	{
		if ($_COOKIE['search_state'])
		{
			$search_state = explode('|', $_COOKIE['search_state']);
		}
		if ($search_state[1] != $search_key && $search_state[0] > TIME_NOW - $core->Config['search_space_time'])
		{
			$core->Notice($core->LangReplaceText($core->Language['search']['error_space_time'], $core->Config['search_space_time']), 'back');
		}
		if ($search_state[1] != $search_key)
		{
			$core->MySetcookie('search_state', TIME_NOW.'|'.$search_key, $core->Config['search_space_time'] + 1);
		}
	}

	// 全文搜索
	if ($search->is_search_ext)
	{
		$count_sql = "SELECT COUNT(*) AS num FROM {$core->TablePre}data AS d, {$core->TablePre}data_ext AS de WHERE d.data_id=de.data_id AND {$condition} ";
		$query_sql = "SELECT d.* FROM {$core->TablePre}data AS d, {$core->TablePre}data_ext AS de WHERE d.data_id=de.data_id AND {$condition}";
	}
	else
	{
		$count_sql = "SELECT COUNT(*) AS num FROM {$core->TablePre}data AS d WHERE {$condition}";
		$query_sql = "SELECT d.* FROM {$core->TablePre}data AS d WHERE {$condition}";
	}

	// 符合条件的记录总数
	$data_count = $core->DB->GetRow($count_sql);
	$totalnum = $data_count['num'];
	unset($data);
	if (0 < $totalnum)
	{
		// 每页显示记录
		$perpage = $core->Config['pagination_list_num'];
		$offset = 0;
		if ($totalnum > $perpage)
		{
			$multipage = $core->Multipage($totalnum, $page, $perpage);
			$offset = $multipage['offset'];
		}

		require_once(ROOT_PATH.'/include/kernel/class_list.php');
		$list = new XXList($core);
		$list->show_sort = TRUE;
		$list->heightlight = $search->keyword_all;
		$data = $list->html($query_sql." ORDER BY d.release_date DESC LIMIT {$offset}, {$perpage}");
	}
	else
	{
		// 没有数据,关闭缓存
		$core->tpl->caching = FALSE;
	}

	// 记录搜索次数
	if (0 < $core->Config['search_top_num'] && 0 < $totalnum)
	{
		// 同一用户搜索同一组关键词,每5分钟累加一次
		if ($search_state[1] != $search_key && $search_state[0] < TIME_NOW - 300)
		{
			// 延迟更新搜索统计
			if ($core->Config['search_stats_delayed'])
			{
				foreach ($search->keywords as $kw)
				{
					// 忽略全数字
					if (preg_match('#^\d+$#', $kw)) continue;

					$keyword_md5 = md5($kw);
					$cache_save_dir = $core->Config['dir']['data'].'/cache/search_keyword/'.substr($keyword_md5, 0, 2);
					if (!is_dir($cache_save_dir))
					{
						mkdir($cache_save_dir, 0755);
					}
					$cache_save_dir .= '/'.substr($keyword_md5, 2, 1);
					if (!is_dir($cache_save_dir))
					{
						mkdir($cache_save_dir, 0755);
					}
					$cache_file_name = $cache_save_dir.'/'.$keyword_md5.'.txt';
					file_put_contents($cache_file_name, 1, FILE_APPEND|LOCK_EX);
					$cache_file_size = filesize($cache_file_name);
					if (10 <= $cache_file_size)
					{
						update_search_stats($kw, $cache_file_size);
						unlink($cache_file_name);
					}
				}
			}
			else
			{
				update_search_stats($search->keywords, 1);
			}
		}
	}

	$keyword = htmlspecialchars(stripslashes($keyword));

	$core->tpl->assign_by_ref('Data', $data);
	$core->tpl->assign(array(
		'SiteTitle' => $core->LangReplaceText($core->Language['page']['title_search'], $keyword),
		'SubNav'    => $core->Language['search']['search_result'],
		/*结果总数*/
		'Totalnum'  => $totalnum,
		'Keyword'   => $keyword,
		/*数据分页*/
		'Multipage' => $multipage,
	));
	$core->tpl->display($template_name, $cache_only_key);
	exit;
}

// 更新搜索关键字统计
function update_search_stats($keywords, $num)
{
	global $core;

	if (!is_array($keywords) && !empty($keywords))
	{
		$keywords = array($keywords);
	}
	if (!$keywords || 0 >= $num) return;

	foreach ($keywords as $kw)
	{
		// 忽略全数字
		if (preg_match('#^\d+$#', $kw)) continue;

		$kw = addslashes($kw);
		$keyword_search = $core->DB->GetOne("SELECT search_num FROM {$core->TablePre}search_keyword WHERE search_keyword='{$kw}'");
		if ($keyword_search)
		{
			$core->DB->Execute("UPDATE {$core->TablePre}search_keyword SET search_num=search_num+{$num} WHERE search_keyword='{$kw}'");
		}
		else
		{
			$core->DB->Execute("INSERT INTO {$core->TablePre}search_keyword (search_keyword, search_num) VALUES ('{$kw}', {$num})");
		}
	}

	return TRUE;
}

// 高级搜索
$core->tpl->assign(array(
	'SiteTitle' => $core->Language['search']['page_title'],
	'SortOption' => $core->sort->GetSortOption(),
));
$core->tpl->display('search.tpl');
?>