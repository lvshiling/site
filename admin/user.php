<?php
define('IN_PLACE', 'admin');
define('IN_SCRIPT', 'user');

require_once('global.php');

CheckPermission('can_manage_user');


//  ################## 删除用户 ################## //
if ('delete' == $_POST['op'])
{
	$data_id_arr = $_POST['data_id'];
	if (0 >= count($data_id_arr))
	{
		$core->Notice($core->Language['comment']['error_no_select'], 'back');
	}

	//$user_ids = implode(',', $data_id_arr);

	foreach ($data_id_arr as $user_id)
	{
		$core->DB->Execute("UPDATE {$core->TablePre}data SET mark_deleted=1 WHERE user_id='{$user_id}'");

		$core->DB->Execute("DELETE FROM {$core->TablePre}user WHERE user_id='{$user_id}'");
		$core->DB->Execute("DELETE FROM {$core->TablePre}comment WHERE user_id='{$user_id}'");
	}
	/*

	$user_id = intval($_GET['id']);
	$user_data = $core->DB->GetRow("SELECT * FROM {$core->TablePre}user WHERE user_id='{$user_id}'");
	if (!$user_data)
	{
		$core->Notice($core->Language['user']['error_not_exist'], 'back');
	}
	*/

	//$core->ManagerLog($core->Language['user']['log_delete'].addslashes($user_data['user_name']));

	$goto_url = REQUEST_URI;
	$core->Notice($core->Language['user']['delete_succeed'].'[<a href="'.$goto_url.'">'.$core->Language['common']['continue'].'</a>]', 'goto', $goto_url);
}


//  ################## 添加发布用户 ################## //
if ('add' == $_POST['op'])
{
	$user_name = trim($_POST['username']);
	if ('' == $user_name)
	{
		$core->Notice($core->Language['user']['error_username_empty'], 'back');
	}
	if (preg_match('#^\d+$#', $user_name))
	{
		$core->Notice($core->Language['user']['error_username_forbid1'], 'back');
	}
	if (!$core->UserNameCheck($user_name))
	{
		$core->Notice($core->Language['user']['error_username_forbid2'], 'back');
	}
	$user_name = htmlspecialchars($user_name);
	$user_name_length = $core->CnStrlen($user_name);
	if (4 > $user_name_length || 12 < $user_name_length)
	{
		$core->Notice($core->Language['user']['error_username_length'], 'back');
	}
	$user_password = $_POST['password'];
	if ('' == $user_password)
	{
		$core->Notice($core->Language['user']['error_password_empty'], 'back');
	}
	if (4 > strlen($user_password))
	{
		$core->Notice($core->Language['user']['error_password_length'], 'back');
	}
	// 检查是否已存在相同的用户名
	if ($core->DB->GetOne("SELECT user_id FROM {$core->TablePre}user WHERE user_name='".$user_name."'"))
	{
		$core->Notice($core->Language['user']['error_username_exist'], 'back');
	}

	// 电子邮件
	$email = trim($_POST['email']);
	if (empty($email))
	{
		$core->Notice($core->Language['user']['error_email_empty'], 'back');
	}
	if (!preg_match('#\w+@\w+\.\w+#', $email) || 100 < strlen($email))
	{
		$core->Notice($core->Language['user']['error_email_invalid'], 'back');
	}
	$email = strtolower($email);

	if ($core->DB->GetOne("SELECT user_id FROM {$core->TablePre}user WHERE user_email='{$email}'"))
	{
		$core->Notice($core->Language['user']['error_email_exists'], 'back');
	}

	// 权限
	$can_add = $_POST['can_add']==1 ? 1 : 0;
	$can_edit = $_POST['can_edit']==1 ? 1 : 0;
	$can_delete = $_POST['can_delete']==1 ? 1 : 0;
	//$post_auditing = 1 == $_POST['post_auditing'] ? 1 : (isset($_POST['post_auditing']) ? 0 : -1);

	$core->DB->Execute("INSERT INTO {$core->TablePre}user (user_name, user_password, user_email, dateline, validate_email, validate_ip, can_add, can_edit, can_delete) VALUES ('{$user_name}', '".$core->CryptPW($user_password)."', '{$email}', '".TIME_NOW."', '1', '{$core->Config['validate_ip']}', '{$can_add}', '{$can_edit}', '{$can_delete}')");
	$new_user_id = $core->DB->Insert_ID();

	$core->ManagerLog($core->Language['user']['log_add'].$user_name);

	$core->Notice($core->Language['user']['add_succeed'], 'halt');
}
if ('add' == $_GET['act'])
{
	$core->tpl->assign(array(
		'Action'   => $_GET['act'],
	));
	$core->tpl->display('user_post.tpl');
	exit;
}


//  ################## 编辑用户 ################## //
if ('edit' == $_POST['op'])
{
	$user_id = intval($_POST['id']);
	$user_data = $core->DB->GetRow("SELECT * FROM {$core->TablePre}user WHERE user_id='{$user_id}'");
	if (!$user_data)
	{
		$core->Notice($core->Language['user']['error_not_exist'], 'back');
	}
	$user_name = trim($_POST['username']);
	if ('' == $user_name)
	{
		$core->Notice($core->Language['user']['error_username_empty'], 'back');
	}
	if (preg_match('#^\d+$#', $user_name))
	{
		$core->Notice($core->Language['user']['error_username_forbid1'], 'back');
	}
	if (!$core->UserNameCheck($user_name))
	{
		$core->Notice($core->Language['user']['error_username_forbid2'], 'back');
	}
	$user_name = htmlspecialchars($user_name);
	if (4 > $core->CnStrlen($user_name) || 20 < $core->CnStrlen($user_name))
	{
		$core->Notice($core->Language['user']['error_username_length'], 'back');
	}
	if ($user_name != $user_data['user_name'])
	{
		// 检查是否已存在相同的用户名
		if ($core->DB->GetOne("SELECT user_id FROM {$core->TablePre}user WHERE user_name='{$user_name}' AND user_id!='{$user_data['user_id']}'"))
		{
			$core->Notice($core->Language['user']['error_username_exist'], 'back');
		}
		// 修改用户名
		$up_user_name = ", user_name='{$user_name}'";
		$is_change_user_name = TRUE;
	}
	// 电子邮件
	$email = trim($_POST['email']);
	if ($email != $user_data['user_email'])
	{
		if (empty($email))
		{
			$core->Notice($core->Language['user']['error_email_empty'], 'back');
		}
		if (!preg_match('#\w+@\w+\.\w+#', $email) || 100 < strlen($email))
		{
			$core->Notice($core->Language['user']['error_email_invalid'], 'back');
		}

		if ($core->DB->GetOne("SELECT user_id FROM {$core->TablePre}user WHERE user_email='{$email}'"))
		{
			$core->Notice($core->Language['user']['error_email_exists'], 'back');
		}
		$up_user_email = ", user_email='{$email}'";
	}

	$user_password = $_POST['password'];
	if ('' != $user_password)
	{
		if (4 > strlen($user_password))
		{
			$core->Notice($core->Language['user']['error_password_length'], 'back');
		}
		// 修改密码
		$up_user_password = ", user_password='".$core->CryptPW($user_password)."'";
	}

	// 用户权限
	$can_add = 1 == $_POST['can_add'] ? 1 : 0;
	$can_edit = 1 == $_POST['can_edit'] ? 1 : 0;
	$can_delete = 1 == $_POST['can_delete'] ? 1 : 0;
	// email验证
	$validate_email = 1 == $_POST['validate_email'] ? 1 : 0;
	if (1 == $_POST['validate_ip'])
	{
		$validate_ip = $core->Config['validate_ip'];
	}
	else
	{
		$validate_ip = $user_data['validate_ip'];
	}
	//$post_auditing = 1 == $_POST['post_auditing'] ? 1 : (-1 == $_POST['post_auditing'] ? -1 : 0);

	$core->DB->Execute("UPDATE {$core->TablePre}user SET can_add='{$can_add}', can_edit='{$can_edit}', can_delete='".$can_delete."'".$up_user_name.$up_user_password.$up_user_email.", validate_email='{$validate_email}', validate_ip='{$validate_ip}' WHERE user_id='{$user_data['user_id']}'");

	if ($is_change_user_name)
	{
		$core->DB->Execute("UPDATE {$core->TablePre}data SET user_name='{$user_name}' WHERE user_id='{$user_data['user_id']}'");
	}

	$core->ManagerLog($core->Language['user']['log_edit'].$user_name);

	$core->Notice($core->Language['user']['edit_succeed'], 'halt');
}
if ('edit' == $_GET['act'])
{
	$user_id = intval($_GET['id']);
	$user_data = $core->DB->GetRow("SELECT * FROM {$core->TablePre}user WHERE user_id='{$user_id}'");
	if (!$user_data)
	{
		$core->Notice($core->Language['user']['error_not_exist'], 'back');
	}

	$core->tpl->assign(array(
		'UserData'  => $user_data,
		'Action'   => $_GET['act'],
	));
	$core->tpl->display('user_post.tpl');
	exit;
}


//  ################## 列表显示数据 ################## //
if ('list' == $_GET['act'])
{
	$condition = '1=1';
	$name = trim($_GET['name']);
	if (!empty($name))
	{
		$name = htmlspecialchars($name);
		if (1 == $_GET['dark_match'])
		{
			$condition .= " AND user_name LIKE '%{$name}%'";
		}
		else
		{
			$condition .= " AND user_name='{$name}'";
		}
	}
	// email验证
	if ('' != $_GET['validate_email'])
	{
		$_GET['validate_email'] = $_GET['validate_email'] ? 1 : 0;
		$condition .= " AND validate_email='{$_GET['validate_email']}'";
	}
	// ip激活
	if ($_GET['ipqualifier'])
	{
		switch ($_GET['ipqualifier'])
		{
			// 大于
			case 'gt':
				$qualifier = '>';
			break;
			// 等于
			case 'eq':
				$qualifier = '=';
			break;
			//　小于
			default:
				$qualifier = '<';
			break;
		}
		$validate_ip = intval($_GET['validate_ip']);
		$condition .= " AND validate_ip{$qualifier}'{$validate_ip}'";
	}
	if ($_GET['datequalifier'] && $_GET['join_date'])
	{
		switch ($_GET['datequalifier'])
		{
			// 大于
			case 'gt':
				$join_date = strtotime($_GET['join_date']) + 86400;
				$condition .= " AND dateline>'{$join_date}'";
			break;
			// 等于
			case 'eq':
				$join_date1 = strtotime($_GET['join_date']);
				$join_date2 = strtotime($_GET['join_date'].' 23:59:59');
				$condition .= " AND dateline>='{$join_date1}' AND dateline<='{$join_date2}'";
			break;
			//　小于
			default:
				$join_date = strtotime($_GET['join_date']) - 86400;
				$condition .= " AND dateline<'{$join_date}'";
			break;
		}
	}

	$order = $_GET['order']=='asc' ? 'ASC' : 'DESC';

	$user_data_count = $core->DB->GetRow("SELECT COUNT(user_id) AS num FROM {$core->TablePre}user WHERE $condition");
	$totalnum = $user_data_count['num'];
	unset($user_data);
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
		$user_data = $core->DB->GetArray("SELECT * FROM {$core->TablePre}user WHERE $condition ORDER BY user_id $order LIMIT $offset, $perpage");
	}

	$core->tpl->assign(array(
		'UserData'  => $user_data,
		'multipage' => $multipage,
		'totalnum'  => $totalnum,
	));
	$core->tpl->display('user_search_result.tpl');
	exit;
}

//  ################## 用户搜索表单 ################## //
$core->tpl->assign(array(
));
$core->tpl->display('user_search.tpl');
?>