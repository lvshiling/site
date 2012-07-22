<?php
define('IN_PLACE', 'admin');
define('IN_SCRIPT', 'manager');

require_once('global.php');

CheckPermission('is_super_manager');

if ('log' == $_GET['type'])
{
	// 允许删除7天之前的管理日志
	$valid_del_time = TIME_NOW - 86400 * 7;
	// ################## 删除管理日志 ################## //
	if ('delete' == $_POST['op'])
	{
		$data_id_arr = $_POST['data_id'];
		if (0 >= count($data_id_arr))
		{
			$core->Notice($core->Language['manager']['log_no_select'], 'back');
		}

		foreach ($data_id_arr as $key=>$log_id)
		{
			$log_data = $core->DB->GetRow("SELECT dateline FROM {$core->TablePre}manager_log WHERE log_id='".$log_id."'");
			if (!$log_data || $valid_del_time < $log_data['dateline'])
			{
				unset($data_id_arr[$key]);
			}
		}

		$delete_total = count($data_id_arr);
		if (0 < $delete_total)
		{
			$core->DB->Execute("DELETE FROM {$core->TablePre}manager_log WHERE log_id IN (".implode(',', $data_id_arr).")");

			$core->ManagerLog($core->LangReplaceText($core->Language['manager']['log_delete'], $delete_total));
		}

		$core->Notice($core->Language['manager']['delete_succeed'].'[<a href="manager.php?type=log">'.$core->Language['common']['continue'].'</a>]', 'goto', 'manager.php?type=log');
		exit;
	}

	// ################## 清除多余管理日志 ################## //
	if ('clear' == $_GET['act'])
	{
		// 清除时间超过7天的管理日志
		$core->DB->Execute("DELETE FROM {$core->TablePre}manager_log WHERE dateline < '".$valid_del_time."'");

		$core->ManagerLog($core->Language['manager']['clear_7day']);

		$core->Notice($core->Language['manager']['delete_succeed'].'[<a href="manager.php?type=log">'.$core->Language['common']['continue'].'</a>]', 'goto', 'manager.php?type=log');
		exit;
	}

	// ################## 管理日志列表 ################## //
	// 查询条件
	$condition = '1=1';
	$manager_id = intval($_GET['id']);
	if (0 < $manager_id)
	{
		$condition .= " AND ml.manager_id='".$manager_id."'";
	}
	$keyword = trim($_GET['keyword']);
	if ('' != $keyword)
	{
		$condition .= " AND ml.action LIKE '%".htmlspecialchars($keyword)."%'";
	}

	$log_data_count = $core->DB->GetRow("SELECT COUNT(*) AS num FROM {$core->TablePre}manager_log AS ml WHERE $condition");
	$totalnum = $log_data_count['num'];
	unset($log_data);
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
		$log_data = &$core->DB->GetArray("
			SELECT ml.*, m.manager_name 
			FROM {$core->TablePre}manager_log AS ml 
			LEFT JOIN {$core->TablePre}manager AS m USING(manager_id) 
			WHERE $condition 
			ORDER BY ml.log_id DESC 
			LIMIT $offset, $perpage
		");
	}

	$core->tpl->assign(array(
		'LogData'      => $log_data,
		'multipage'    => $multipage,
		'totalnum'     => $totalnum,
		'ValidDelTime' => $valid_del_time,
	));
	$core->tpl->display('manager_log.tpl');
	exit;
}
else if ('manager' == $_GET['type'])
{
	// ################## 添加管理员 ################## //
	if ('add' == $_POST['op'])
	{
		CheckFormData('add', $_POST);

		$core->DB->Execute("INSERT INTO {$core->TablePre}manager (manager_name, manager_password, dateline) VALUES ('".$_POST['username']."', '".$_POST['password']."', '".TIME_NOW."')");
		$new_manager_id = $core->DB->Insert_ID();
		if (0 < $new_manager_id)
		{
			$core->DB->Execute("
				INSERT INTO {$core->TablePre}manager_permission (
					manager_id, 
					can_login, 
					is_super_manager, 
					can_manage_data, 
					can_manage_sort, 
					can_manage_user
				) VALUES (
					'".$new_manager_id."', 
					'".$_POST['can_login']."', 
					'".$_POST['is_super_manager']."', 
					'".$_POST['can_manage_data']."', 
					'".$_POST['can_manage_sort']."', 
					'".$_POST['can_manage_user']."'
				)
			");
			$core->ManagerLog($core->Language['manager']['log_add_manager'].$_POST['username']);
			$core->Notice($core->Language['manager']['add_manager_succeed'].'[<a href="manager.php?type=manager">'.$core->Language['common']['continue'].'</a>]', 'goto', 'manager.php?type=manager');
		}
		else
		{
			$core->Notice($core->Language['manager']['add_manager_fail'], 'back');
		}
		exit;
	}
	if ('add' == $_GET['act'])
	{
		$core->tpl->assign(array(
			'Action'   => 'add',
		));
		$core->tpl->display('manager_post.tpl');
		exit;
	}

	// ################## 编辑管理员 ################## //
	if ('edit' == $_POST['op'])
	{
		$manager_id = intval($_POST['id']);

		if ($manager_id == AdminUserID)
		{
			$core->Notice($core->Language['manager']['cannot_edit_self'], 'back');
		}

		CheckFormData('edit', $_POST);

		if ('' != $_POST['password'])
		{
			$update_password = ", manager_password='".$_POST['password']."'";
		}
		$core->DB->Execute("UPDATE {$core->TablePre}manager SET manager_name='".$_POST['username']."'{$update_password} WHERE manager_id='".$manager_id."'");
		$core->DB->Execute("
			UPDATE {$core->TablePre}manager_permission SET 
				can_login='".$_POST['can_login']."', 
				is_super_manager='".$_POST['is_super_manager']."', 
				can_manage_data='".$_POST['can_manage_data']."', 
				can_manage_sort='".$_POST['can_manage_sort']."', 
				can_manage_user='".$_POST['can_manage_user']."' 
			WHERE manager_id='".$manager_id."'
		");

		$core->ManagerLog($core->Language['manager']['log_edit_manager'].$_POST['username']);
		$core->Notice($core->Language['manager']['edit_manager_succeed'].'[<a href="manager.php?type=manager">'.$core->Language['common']['continue'].'</a>]', 'goto', 'manager.php?type=manager');
		exit;
	}
	if ('edit' == $_GET['act'])
	{
		$manager_id = intval($_GET['id']);

		if (AdminUserID == $manager_id)
		{
			$core->Notice($core->Language['manager']['cannot_edit_self'], 'back');
		}

		$manager_data = $core->DB->GetRow("
			SELECT * FROM {$core->TablePre}manager AS m, {$core->TablePre}manager_permission AS mp 
			WHERE m.manager_id=mp.manager_id AND m.manager_id='".$manager_id."'
		");
		if (!$manager_data)
		{
			$core->Notice($core->Language['manager']['not_exist_manager'], 'back');
		}

		$core->tpl->assign(array(
			'Action'  => 'edit',
			'Manager' => $manager_data,
		));
		$core->tpl->display('manager_post.tpl');
		exit;
	}

	// ################## 删除管理员 ################## //
	if ('delete' == $_GET['act'])
	{
		$manager_id = intval($_GET['id']);

		if (AdminUserID == $manager_id)
		{
			$core->Notice($core->Language['manager']['cannot_delete_self'], 'back');
		}

		$manager_info = $core->DB->GetRow("SELECT * FROM {$core->TablePre}manager WHERE manager_id='".$manager_id."'");
		if (!$manager_info)
		{
			$core->Notice($core->Language['manager']['not_exist_manager'], 'back');
		}

		$core->DB->Execute("DELETE FROM {$core->TablePre}manager WHERE manager_id='".$manager_id."'");

		$core->ManagerLog($core->Language['manager']['log_delete_manager'].addslashes($manager_info['manager_name']));

		$core->Notice($core->Language['manager']['delete_manager_succeed'].'[<a href="manager.php?type=manager">'.$core->Language['common']['continue'].'</a>]', 'goto', 'manager.php?type=manager');
		exit;
	}

	// ################## 管理员列表 ################## //
	$manager_data_count = $core->DB->GetRow("SELECT COUNT(*) AS num FROM {$core->TablePre}manager AS m");
	$totalnum = $manager_data_count['num'];
	unset($manager_data);
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
		$manager_data = &$core->DB->GetArray("
			SELECT m.*, mp.is_super_manager 
			FROM {$core->TablePre}manager AS m 
			LEFT JOIN {$core->TablePre}manager_permission AS mp USING(manager_id) 
			ORDER BY m.manager_id DESC 
			LIMIT $offset, $perpage
		");
	}

	$core->tpl->assign(array(
		'ManagerData' => $manager_data,
		'multipage'   => $multipage,
		'totalnum'    => $totalnum,
	));
	$core->tpl->display('manager_list.tpl');
	exit;
}
else
{
	// void
}



// 检查表单数据
function CheckFormData($action, &$data)
{
	global $core;

	$data['username'] = trim($data['username']);
	if ('' == $data['username'])
	{
		$core->Notice($core->Language['manager']['error_username_empty'], 'back');
	}
	$data['username'] = htmlspecialchars($data['username']);
	if (!preg_match('#^[a-z0-9\_]{4,20}$#i', $data['username']))
	{
		$core->Notice($core->Language['manager']['error_username_length'], 'back');
	}

	if ('add' == $action)
	{
		$check_sql = "SELECT * FROM {$core->TablePre}manager WHERE manager_name='".$data['username']."'";
	}
	else
	{
		$check_sql = "SELECT * FROM {$core->TablePre}manager WHERE manager_id!='".$data['id']."' AND manager_name='".$data['username']."'";
	}

	if ($core->DB->GetOne($check_sql))
	{
		$core->Notice($core->Language['manager']['error_username_exist'], 'back');
	}

	if (('edit' == $action && '' != $data['password']) || 'add' == $action)
	{
		if ('' == $data['password'])
		{
			$core->Notice($core->Language['manager']['error_password_empty'], 'back');
		}
		if (4 > strlen($data['password']))
		{
			$core->Notice($core->Language['manager']['error_password_length'], 'back');
		}
		$data['password'] = md5($data['password']);
	}

	$data['can_login'] = $data['can_login'] ? 1 : 0;
	$data['is_super_manager'] = $data['is_super_manager'] ? 1 : 0;
	$data['can_manage_data'] = $data['can_manage_data'] ? 1 : 0;
	$data['can_manage_sort'] = $data['can_manage_sort'] ? 1 : 0;
	$data['can_manage_user'] = $data['can_manage_user'] ? 1 : 0;
}
?>