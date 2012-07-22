<?php
define('IN_PLACE', 'admin');
define('IN_SCRIPT', 'index');

require_once('global.php');


//  ################## 退出登录 ################## //
if ('logout' == $_GET['act'])
{
	$core->ManagerLog($core->Language['login']['log_logout']);

	$_SESSION['C_AdminUserID'] = 0;
	header('Location: index.php');
	exit;
}

//  ################## 登录系统 ################## //
if ('login' == $_POST['op'])
{
	$user_name = trim($_POST['username']);
	$password = $_POST['password'];
	if (empty($user_name))
	{
		$core->Notice($core->Language['login']['error_username_empty'], 'back');
	}
	if (empty($password))
	{
		$core->Notice($core->Language['login']['error_password_empty'], 'back');
	}

	// 验证码
	$core->CheckVerifyCode('mlogin', $_POST['vcode']);

	$menager_info = $core->DB->GetRow("SELECT * FROM {$core->TablePre}manager WHERE manager_name='{$user_name}'");
	if (!$menager_info || $core->CryptPW($password) != $menager_info['manager_password'])
	{
		$core->ManagerLog($core->LangReplaceText($core->Language['login']['log_illegal'], $user_name));

		$core->Notice($core->Language['login']['illegal'], 'back');
	}

	$goto_url = urldecode($_POST['url']);
	if (empty($goto_url))
	{
		$goto_url = 'index.php';
	}

	$_SESSION['C_AdminUserID'] = $menager_info['manager_id'];

	$core->ManagerLog($core->Language['login']['log_login']);

	header('Location: '.$goto_url);
	exit;
}

$manage_menu = array();
// 系统管理
if ($current_manager_data['is_super_manager'])
{
	$manage_menu['group']['sys'] = $core->Language['menu']['sys'];
	$manage_menu['sys'][] = array('name' => $core->Language['menu']['sys_1'], 'url' => 'setting.php?act=website');
	$manage_menu['sys'][] = array('name' => $core->Language['menu']['sys_3'], 'url' => 'badword.php');
	$manage_menu['sys'][] = array('name' => $core->Language['menu']['sys_5'], 'url' => 'manager.php?type=manager');
	$manage_menu['sys'][] = array('name' => $core->Language['menu']['sys_6'], 'url' => 'manager.php?type=log');
	$manage_menu['sys'][] = array('name' => $core->Language['menu']['sys_7'], 'url' => 'ftp.php');
}

// 资源管理
if ($current_manager_data['can_manage_data'])
{
	$manage_menu['group']['resource'] = $core->Language['menu']['resource'];
	$manage_menu['resource'][] = array('name' => $core->Language['menu']['resource_1'], 'url' => 'data.php?act=list');
	$manage_menu['resource'][] = array('name' => $core->Language['menu']['resource_2'], 'url' => 'data.php');
	$manage_menu['resource'][] = array('name' => $core->Language['menu']['resource_3'], 'url' => 'merger.php');
	if ($current_manager_data['can_manage_sort'])
	{
		$manage_menu['resource'][] = array('name' => $core->Language['menu']['resource_4'], 'url' => 'sort.php');
	}
}

// 用户管理
if ($current_manager_data['can_manage_user'])
{
	$manage_menu['group']['user'] = $core->Language['menu']['user'];
	$manage_menu['user'][] = array('name' => $core->Language['menu']['user_1'], 'url' => 'user.php?act=list');
	$manage_menu['user'][] = array('name' => $core->Language['menu']['user_2'], 'url' => 'user.php?act=add');
	$manage_menu['user'][] = array('name' => $core->Language['menu']['user_3'], 'url' => 'user.php');
}

// 扩展功能
if ($current_manager_data['is_super_manager'])
{
	$manage_menu['group']['other'] = $core->Language['menu']['other'];
	$manage_menu['other'][] = array('name' => $core->Language['menu']['sys_8'], 'url' => 'search.php?act=keyword');
	$manage_menu['other'][] = array('name' => $core->Language['menu']['other_6'], 'url' => 'comment.php');
	$manage_menu['other'][] = array('name' => $core->Language['menu']['other_3'], 'url' => 'feedback.php');
	$manage_menu['other'][] = array('name' => $core->Language['menu']['other_4'], 'url' => 'report.php');
}


// ################## 显示管理框架 ################## //
// 管理菜单
if ('nav' == $_GET['act'])
{
	// 不强制加入版权信息
	if (!defined('NO_COPYRIGHT_INFO')) define('NO_COPYRIGHT_INFO', TRUE);

	$core->tpl->assign(array(
		'ManageMenu' => $manage_menu,
	));
	$core->tpl->display('frame_nav.tpl');
	exit;
}
// 中间控制拦
if ('center' == $_GET['act'])
{
	// 不强制加入版权信息
	if (!defined('NO_COPYRIGHT_INFO')) define('NO_COPYRIGHT_INFO', TRUE);

	$core->tpl->display('frame_center.tpl');
	exit;
}
// 顶部
if ('top' == $_GET['act'])
{
	// 不强制加入版权信息
	if (!defined('NO_COPYRIGHT_INFO')) define('NO_COPYRIGHT_INFO', TRUE);

	$core->tpl->assign(array(
		'ManageMenuGroup' => $manage_menu['group'],
	));
	$core->tpl->display('frame_top.tpl');
	exit;
}
// 主显示部分
if ('main' == $_GET['act'])
{
	$sysinfo = array();

	// 数据库版本
	$mysql_version = $core->DB->GetRow('SELECT VERSION() AS version');

	$sysinfo['php_version'] = PHP_VERSION;
	$sysinfo['mysql_version'] = $mysql_version['version'];
	$sysinfo['service'] = $_SERVER['SERVER_SOFTWARE'];
	$sysinfo['max_upload'] = ini_get('file_uploads') ? ini_get('upload_max_filesize') : $core->Language['index']['upload_forbid'];
	$sysinfo['max_ex_time'] = ini_get('max_execution_time').$core->Language['index']['second'];

	$core->tpl->assign(array(
		'sysinfo' => $sysinfo,
	));
	$core->tpl->display('frame_main.tpl');
	exit;
}

// 框架结构模板
$core->tpl->display('frame_index.tpl');
?>