<?php
if (!defined('IN_SITE')) @header('HTTP/1.1  404  Not  Found');

// ################## 退出登录 ################## //
if ('logout' == $_GET['act'])
{
	$core->MySetcookie('XX_UserID', 0, 0, $core->Config['site_domain']);
	header('Location: /');
	exit;
}

// ################## 已登录 ################## //
if (0 < $core->UserInfo['user_id'])
{
	header('location: user.php');
	exit;
}

//  ################## 执行登录 ################## //
if ('login' == $_POST['op'])
{
	$core->CheckVerifyCode('login', $_POST['vcode']);

	// 执行登录
	require_once(ROOT_PATH.'/include/kernel/class_login.php');
	$login = new Login($core);
	$login->Execute($_POST['username'], $_POST['password']);

	$core->DestructVerifyCode('login');

	// 登录成功后跳转到的地址
	$goto_url = urldecode(trim($_POST['url']));
	if (empty($goto_url))
	{
		$goto_url = 'user.php?o=upload';
	}
	header('location: '.$goto_url);
	exit;
}

// ################## 显示登录界面 ################## //

$goto_url = trim($_GET['goto']);
$goto_url = '' == $goto_url ? 'user.php' : $goto_url;

$core->tpl->assign(array(
	'SiteTitle' => $core->Language['login']['page_title'],
	'SubNav'    => $core->Language['login']['page_title'],
	/*登录成功后进入的页面*/
	'GotoURL'   => $goto_url,
));
$core->tpl->display('user/login.tpl');
?>