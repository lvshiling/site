<?php
if (!defined('IN_SITE')) @header('HTTP/1.1  404  Not  Found');

// ################## �˳���¼ ################## //
if ('logout' == $_GET['act'])
{
	$core->MySetcookie('XX_UserID', 0, 0, $core->Config['site_domain']);
	header('Location: /');
	exit;
}

// ################## �ѵ�¼ ################## //
if (0 < $core->UserInfo['user_id'])
{
	header('location: user.php');
	exit;
}

//  ################## ִ�е�¼ ################## //
if ('login' == $_POST['op'])
{
	$core->CheckVerifyCode('login', $_POST['vcode']);

	// ִ�е�¼
	require_once(ROOT_PATH.'/include/kernel/class_login.php');
	$login = new Login($core);
	$login->Execute($_POST['username'], $_POST['password']);

	$core->DestructVerifyCode('login');

	// ��¼�ɹ�����ת���ĵ�ַ
	$goto_url = urldecode(trim($_POST['url']));
	if (empty($goto_url))
	{
		$goto_url = 'user.php?o=upload';
	}
	header('location: '.$goto_url);
	exit;
}

// ################## ��ʾ��¼���� ################## //

$goto_url = trim($_GET['goto']);
$goto_url = '' == $goto_url ? 'user.php' : $goto_url;

$core->tpl->assign(array(
	'SiteTitle' => $core->Language['login']['page_title'],
	'SubNav'    => $core->Language['login']['page_title'],
	/*��¼�ɹ�������ҳ��*/
	'GotoURL'   => $goto_url,
));
$core->tpl->display('user/login.tpl');
?>