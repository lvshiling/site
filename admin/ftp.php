<?php
define('IN_PLACE', 'admin');
define('IN_SCRIPT', 'ftp');

require_once('global.php');

CheckPermission('is_super_manager');


// FTP测试
if ('test' == $_POST['op'])
{
	$ftp = ftp_connect($_POST['ftp_host'], $_POST['ftp_port']);
	if (!$ftp)
	{
		$core->Notice($core->Language['ftp']['test_error_connect'], 'halt');
	}
	if (!ftp_login($ftp, $_POST['ftp_username'], $_POST['ftp_password']))
	{
		$core->Notice($core->Language['ftp']['test_error_login'], 'halt');
	}
	ftp_close($ftp);

	$core->Notice($core->Language['ftp']['test_succeed'], 'halt');
	exit;
}

// 删除服务器
if ('delete' == $_GET['act'])
{
	$ftp_id = intval($_GET['id']);

	$core->DB->Execute("DELETE FROM {$core->TablePre}ftp_setting WHERE ftp_id='{$ftp_id}'");

	header('Location: ftp.php');
	exit;
}

// 修改服务器
if ('edit' == $_POST['op'])
{
	$ftp_id = intval($_POST['id']);

	CheckFormData($_POST);

	$core->DB->Execute("UPDATE {$core->TablePre}ftp_setting SET ftp_host='{$_POST['host']}', ftp_port='{$_POST['port']}', ftp_username='{$_POST['username']}', ftp_password='{$_POST['password']}', visit_path='{$_POST['visit_path']}' WHERE ftp_id='{$ftp_id}'");

	$core->Notice($core->Language['common']['succeed'].'[<a href="ftp.php">'.$core->Language['common']['continue'].'</a>]', 'goto', 'ftp.php');
}
if ('edit' == $_GET['act'])
{
	$ftp_id = intval($_GET['id']);

	$ftpinfo = $core->DB->GetRow("SELECT * FROM {$core->TablePre}ftp_setting WHERE ftp_id='{$ftp_id}'");
	if (!$ftpinfo)
	{
		$core->Notice($core->Language['ftp']['not_exists'], 'back');
	}

	$core->tpl->assign(array(
		'Action' => 'edit',
		'FtpInfo' => $ftpinfo,
	));
	$core->tpl->display('ftp.tpl');
	exit;
}

// 添加服务器
if ('add' == $_POST['op'])
{
	CheckFormData($_POST);

	$core->DB->Execute("INSERT INTO {$core->TablePre}ftp_setting (ftp_host, ftp_port, ftp_username, ftp_password, visit_path) VALUES ('{$_POST['host']}', '{$_POST['port']}', '{$_POST['username']}', '{$_POST['password']}', '{$_POST['visit_path']}')");

	$core->Notice($core->Language['common']['succeed'].'[<a href="ftp.php">'.$core->Language['common']['continue'].'</a>]', 'goto', 'ftp.php');
}
if ('add' == $_GET['act'])
{
	$core->tpl->assign(array(
		'Action' => 'add',
	));
	$core->tpl->display('ftp.tpl');
	exit;
}

// 所有服务器列表
$ftpinfo = $core->DB->GetArray("SELECT * FROM {$core->TablePre}ftp_setting ORDER BY ftp_id DESC");
$core->tpl->assign(array(
	'Action' => 'list',
	'FtpInfo' => $ftpinfo,
));
$core->tpl->display('ftp.tpl');

function CheckFormData(&$data)
{
	global $core;

	$data['host'] = trim($data['host']);
	if (empty($data['host']))
	{
		$core->Notice($core->Language['ftp']['error_host_empty'], 'back');
	}

	$data['port'] = trim($data['port']);
	if (preg_match('#[^\d]#', $data['port']))
	{
		$core->Notice($core->Language['ftp']['error_port'], 'back');
	}

	$data['username'] = trim($data['username']);
	if (empty($data['username']))
	{
		$core->Notice($core->Language['ftp']['error_username_empty'], 'back');
	}

	$data['password'] = trim($data['password']);
	if (empty($data['password']))
	{
		$core->Notice($core->Language['ftp']['error_password_empty'], 'back');
	}

	$data['visit_path'] = trim($data['visit_path']);
	if (empty($data['visit_path']))
	{
		$core->Notice($core->Language['ftp']['error_visit_path_empty'], 'back');
	}
	if (!preg_match('#^http://#', $data['visit_path']) || preg_match('#\/$#', $data['visit_path']))
	{
		$core->Notice($core->Language['ftp']['error_visit_path'], 'back');
	}
}
?>