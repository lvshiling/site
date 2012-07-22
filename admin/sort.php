<?php
define('IN_PLACE', 'admin');
define('IN_SCRIPT', 'sort');

require_once('global.php');

CheckPermission('can_manage_sort');

// 分类缓存文件路径
$cache_file_path = $core->Config['dir']['data'].'/cache/sort.php';

// ################## 分类排序 ################## //
if ('order' == $_POST['op'])
{
	if (!$_POST['order'])
	{
		$core->Notice($core->Language['sort']['error_no_order'], 'back');
	}
	foreach ($_POST['order'] as $sort_id=>$order_num)
	{
		$core->DB->Execute("UPDATE {$core->TablePre}sort SET display_order='{$order_num}' WHERE sort_id='{$sort_id}'");
	}

	$core->ManagerLog($core->Language['sort']['log_order']);

	// 更新缓存
	UpdateCacheFile();

	$core->Notice($core->Language['sort']['order_succeed'].'[<a href="sort.php">'.$core->Language['common']['continue'].'</a>]', 'goto', 'sort.php');
}


// ################## 添加分类 ################## //
if ('add' == $_POST['op'])
{
	$parent_id = intval($_POST['parent_sort_id']);
	if (0 < $parent_id)
	{
		if (!$core->DB->GetOne("SELECT sort_id FROM {$core->TablePre}sort WHERE sort_id='{$parent_id}'"))
		{
			$core->Notice($core->Language['sort']['error_parent_not_exist'], 'back');
		}
	}

	// 分类名称
	$sort_name = trim($_POST['sort_name']);
	$_sort_name = strip_tags($sort_name);
	if ('' == $_sort_name)
	{
		$core->Notice($core->Language['sort']['error_name_empty'], 'back');
	}
	if (50 < $core->CnStrlen($sort_name))
	{
		$core->Notice($core->Language['sort']['error_name_length'], 'back');
	}

	if ($core->DB->GetOne("SELECT sort_id FROM {$core->TablePre}sort WHERE sort_name='{$sort_name}'"))
	{
		$core->Notice($core->Language['sort']['error_name_exist'], 'back');
	}

	$external_url = trim($_POST['external_url']);
	if (!empty($external_url))
	{
		$allow_post = 0;
	}
	else
	{
		$allow_post = 1==$_POST['allow_post'] ? 1 : 0;
	}

	// vip专区
	$is_vip = 1==$_POST['is_vip'] ? 1 : 0;

	$core->DB->Execute("INSERT INTO {$core->TablePre}sort (parent_sort_id, sort_name, external_url, allow_post, is_vip) VALUES ('{$parent_id}', '{$sort_name}', '{$external_url}', '{$allow_post}', '{$is_vip}')");

	$core->ManagerLog($core->Language['sort']['log_add'].strip_tags($sort_name));

	// 更新缓存
	UpdateCacheFile();

	$core->Notice($core->Language['sort']['add_succeed'].'[<a href="sort.php">'.$core->Language['common']['continue'].'</a>]', 'goto', 'sort.php');
}
if ('add' == $_GET['act'])
{
	$parent_id = intval($_GET['parent_id']);

	$core->tpl->assign(array(
		'SortOption' => $core->sort->GetSortOption($parent_id),
		'Action'     => $_GET['act'],
	));
	$core->tpl->display('sort_post.tpl');
	exit;
}


// ################## 编辑分类 ################## //
if ('edit' == $_POST['op'])
{
	$sort_id = intval($_POST['id']);
	$parent_sort_id = intval($_POST['parent_sort_id']);
	$sort_data = $core->DB->GetRow("SELECT * FROM {$core->TablePre}sort WHERE sort_id='{$sort_id}'");
	if (!$sort_data)
	{
		$core->Notice($core->Language['sort']['error_not_exist'], 'back');
	}

	if ($sort_id == $parent_sort_id)
	{
		$core->Notice($core->Language['sort']['error_parent_select'], 'back');
	}

	// 分类名称
	$sort_name = trim($_POST['sort_name']);
	$_sort_name = strip_tags($sort_name);
	if ('' == $_sort_name)
	{
		$core->Notice($core->Language['sort']['error_name_empty'], 'back');
	}
	if (50 < $core->CnStrlen($sort_name))
	{
		$core->Notice($core->Language['sort']['error_name_length'], 'back');
	}
	if ($core->DB->GetOne("SELECT sort_id FROM {$core->TablePre}sort WHERE sort_name='{$sort_name}' AND sort_id!='{$sort_id}'"))
	{
		$core->Notice($core->Language['sort']['error_name_exist'], 'back');
	}

	// 所属父分类
	if (0 != $parent_sort_id)
	{
		if (!$core->DB->GetOne("SELECT sort_id FROM {$core->TablePre}sort WHERE sort_id='{$parent_sort_id}'"))
		{
			$core->Notice($core->Language['sort']['error_parent_not_exist'], 'back');
		}
	}

	$external_url = trim($_POST['external_url']);
	if (!empty($external_url))
	{
		$allow_post = 0;
	}
	else
	{
		$allow_post = 1==$_POST['allow_post'] ? 1 : 0;
	}

	// vip专区
	$is_vip = 1==$_POST['is_vip'] ? 1 : 0;

	$core->DB->Execute("UPDATE {$core->TablePre}sort SET parent_sort_id='{$parent_sort_id}', sort_name='{$sort_name}', external_url='{$external_url}', allow_post='{$allow_post}', is_vip='{$is_vip}' WHERE sort_id='{$sort_id}'");

	$core->ManagerLog($core->Language['sort']['log_edit'].strip_tags($sort_name));

	// 更新缓存
	UpdateCacheFile();

	$core->Notice($core->Language['sort']['edit_succeed'].'[<a href="sort.php">'.$core->Language['common']['continue'].'</a>]', 'goto', 'sort.php');
}
if ('edit' == $_GET['act'])
{
	$sort_id = $_GET['id'];
	$sort_data = $core->DB->GetRow("SELECT * FROM {$core->TablePre}sort WHERE sort_id='{$sort_id}'");
	if (!$sort_data)
	{
		$core->Notice($core->Language['sort']['error_not_exist'], 'back');
	}

	$core->tpl->assign(array(
		'SortOption' => $core->sort->GetSortOption($sort_data['parent_sort_id'], $sort_data['sort_id']),
		'SortData'   => $sort_data,
		'Action'     => $_GET['act'],
	));
	$core->tpl->display('sort_post.tpl');
	exit;
}


// ################## 删除一个分类 ################## //
if ('delete' == $_POST['op'])
{
	$sort_id = intval($_POST['id']);
	$sort_data = $core->DB->GetRow("SELECT * FROM {$core->TablePre}sort WHERE sort_id='{$sort_id}'");
	if (!$sort_data)
	{
		$core->Notice($core->Language['sort']['error_not_exist'], 'back');
	}
	$data_put = $_POST['data_put'];
	if ('transfer' == $data_put)
	{
		// 将数据转移到其它分类
		$aim_sort_id = intval($_POST['aim_sort_id']);
		if (0 >= $aim_sort_id)
		{
			$core->Notice($core->Language['sort']['error_aim_sort'], 'back');
		}
		if ($sort_data['sort_id'] == $aim_sort_id)
		{
			$core->Notice($core->Language['sort']['error_aim_sort_self'], 'back');
		}
		$aim_sort_data = $core->DB->GetRow("SELECT sort_id, sort_name FROM {$core->TablePre}sort WHERE sort_id='{$aim_sort_id}'");
		if (!$aim_sort_data)
		{
			$core->Notice($core->Language['sort']['error_aim_not_exist'], 'back');
		}

		$core->DB->Execute("UPDATE {$core->TablePre}data SET sort_id='{$aim_sort_id}', mark_update='".TIME_NOW."' WHERE sort_id='{$sort_data['sort_id']}'");

		$core->ManagerLog($core->LangReplaceText($core->Language['sort']['log_delete_transfer'], addslashes(strip_tags($sort_data['sort_name'])), addslashes(strip_tags($aim_sort_data['sort_name']))));
	}
	else if ('delete' == $data_put)
	{
		$core->DB->Execute("UPDATE {$core->TablePre}data SET mark_deleted=1 WHERE sort_id='{$sort_data['sort_id']}'");
		/*
		// 将数据和分类一并删除
		$data = $core->DB->GetArray("SELECT data_id, hash_id, page_num, release_date FROM {$core->TablePre}data WHERE sort_id='{$sort_data['sort_id']}'");
		if ($data)
		{
			foreach ($data as $key=>$row)
			{
				$core->DeleteHtml($row['data_id'], $row['page_num']);
			}
			$core->DB->Execute("DELETE d, de FROM {$core->TablePre}data AS d, {$core->TablePre}data_ext AS de WHERE d.data_id=de.data_id AND d.sort_id='{$sort_data['sort_id']}'");
		}
		*/

		$core->ManagerLog($core->LangReplaceText($core->Language['sort']['log_delete'], addslashes(strip_tags($sort_data['sort_name']))));
	}
	else
	{
		$core->Notice($core->Language['sort']['error_select_approach'], 'back');
	}

	// 查找当前删除分类的所有子分类
	$child_sort_data = $core->DB->GetArray("SELECT sort_id FROM {$core->TablePre}sort WHERE parent_sort_id='{$sort_data['sort_id']}'");
	if ($child_sort_data)
	{
		$child_sort_id_array = array();
		foreach ($child_sort_data as $key=>$row)
		{
			$child_sort_id_array[] = $row['sort_id'];
		}
		if ($child_sort_id_array)
		{
			// 将当前删除分类的所有子分类向上提升一级
			$core->DB->Execute("UPDATE {$core->TablePre}sort SET parent_sort_id='{$sort_data['parent_sort_id']}' WHERE sort_id IN (".implode(',', $child_sort_id_array).")");
		}
	}

	// 删除分类数据
	$core->DB->Execute("DELETE FROM {$core->TablePre}sort WHERE sort_id='{$sort_data['sort_id']}'");

	// 更新缓存
	UpdateCacheFile();

	$core->Notice($core->Language['sort']['delete_succeed'].'[<a href="sort.php">'.$core->Language['common']['continue'].'</a>]', 'goto', 'sort.php');
	exit;
}
if ('delete' == $_GET['act'])
{
	$sort_id = intval($_GET['id']);
	$sort_data = $core->DB->GetRow("SELECT * FROM {$core->TablePre}sort WHERE sort_id='{$sort_id}'");
	if (!$sort_data)
	{
		$core->Notice($core->Language['sort']['error_not_exist'], 'back');
	}

	$core->tpl->assign(array(
		'SortOption' => $core->sort->GetSortOption(0),
		'SortData'   => $sort_data,
	));
	$core->tpl->display('sort_delete_confirm.tpl');
	exit;
}

// ################## 重建分类缓存 ################## //
if ('build_cache' == $_GET['act'])
{
	UpdateCacheFile();
	header('Location: sort.php');
	exit;
}

// ################## 已添加分类列表 ################## //
$sort_list_code = '';
$all_sort = $core->sort->AllSort;
$sort_list = $core->sort->SortList;
$sort_tree = $core->sort->SortTree;
// 构建分类列表
BuildList();

$core->tpl->assign(array(
	'SortData' => $sort_list_code,
));
$core->tpl->display('sort_list.tpl');


// 构建分类列表(ul形式)
function BuildList($parent_id = 0, $break_sort_id = '')
{
	global $core, $sort_list_code, $sort_list, $sort_tree;

	if ($sort_tree[$parent_id])
	{
		$sort_list_code .= '<ul>';
		foreach ($sort_tree[$parent_id] as $sort_id)
		{
			$sort_list_code .= '<li><input type="text" size="3" name="order['.$sort_id.']" value="'.$sort_list[$sort_id]['order'].'" class="formInput" /><span'.($sort_list[$sort_id]['vip']?' class="text_red"':'').'>'.$sort_list[$sort_id]['name'].'</span><span class="text_12 text_normal">(ID:'.$sort_id.')&nbsp;&nbsp;[<a href="sort.php?act=edit&id='.$sort_id.'">'.$core->Language['sort']['edit'].'</a>]';

			$sort_list_code .= '&nbsp;[<a href="sort.php?act=add&parent_id='.$sort_id.'" title="'.$core->Language['sort']['add_sub_alt'].'">'.$core->Language['sort']['add_sub'].'</a>]';

			$sort_list_code .= '&nbsp;[<a href="sort.php?act=delete&id='.$sort_id.'">'.$core->Language['sort']['delete'].'</a>]</span></li>';
			BuildList($sort_id);
		}
		$sort_list_code .= '</ul>';
	}
}

// 更新分类缓存文件
function UpdateCacheFile()
{
	global $core;
	global $cache_file_path;

	// 保存分类树和分类数据
	$sort_tree = array();
	$sort_list = array();
	$query = $core->DB->Execute("SELECT * FROM {$core->TablePre}sort ORDER BY display_order ASC, sort_id ASC");
	if ($query)
	{
		while (!$query->EOF)
		{
			$sort_list[$query->fields['sort_id']] = array(
				'name'     => $query->fields['sort_name'], 
				'external' => $query->fields['external_url'], 
				'order'    => $query->fields['display_order'], 
				'parent'   => $query->fields['parent_sort_id'], 
				'vip'      => $query->fields['is_vip'], 
				'post'     => $query->fields['allow_post'], 
			);

			$sort_tree[$query->fields['parent_sort_id']][] = $query->fields['sort_id'];

			$query->MoveNext();
		}
	}

	$cache_info  = '$sort_tree = '.var_export($sort_tree, TRUE).';'."\r\n";
	$cache_info .= '$sort_list = '.var_export($sort_list, TRUE).';';

	if (!$core->UpdateCacheFile($cache_file_path, $cache_info))
	{
		$core->Notice($core->Language['common']['cache_error'], 'back');
	}
}
?>