<?php
if (!defined('IN_SITE')) @header('HTTP/1.1  404  Not  Found');

$key = trim($_GET['key']);
if ($key)
{
	// 验证EMAIL
	$key = base64_decode($key);
	$key = explode('||', $key);
	if (!$key[1] || md5('xx+-!'.$key[1]) != $key[0])
	{
		$core->Notice($core->Language['validate_email']['error_request'], 'halt');
	}

	$core->DB->Execute("UPDATE {$core->TablePre}user SET validate_email='1' WHERE user_email='{$key[1]}'");
	$core->Notice($core->Language['validate_email']['validate_succeed'], 'halt');
	exit;
}

// 发送邮件
if ('send' == $_POST['op'])
{
	$core->CheckVerifyCode('vemail', $_POST['vcode']);

	$username = trim($_POST['username']);
	$email = trim($_POST['email']);
	if (empty($username) || empty($email))
	{
		$core->Notice($core->Language['validate_email']['error_input'], 'back');
	}

	$user_info = $core->DB->GetRow("SELECT user_email, validate_email FROM {$core->TablePre}user WHERE user_name='{$username}' AND user_email='{$email}'");
	if (!$user_info)
	{
		$core->Notice($core->Language['validate_email']['error_not_exists'], 'back');
	}
	if (!$user_info['validate_email'])
	{
		$core->Notice($core->Language['validate_email']['error_validated'], 'back');
	}

	$core->DestructVerifyCode('vemail');

	// 发送验证邮件
	require_once(ROOT_PATH.'/include/kernel/class_login.php');
	$login = new Login($core);
	$login->SendValidateEmail($user_info['user_email']);

	// 发送邮件
	$core->Notice($core->Language['validate_email']['send_succeed'], 'halt');
	exit;
}

// 发送EMAIL验证表单
$core->tpl->assign(array(
	'SiteTitle'  => $core->Language['validate_email']['page_title'],
	'SubNav' => $core->Language['validate_email']['page_title'],
));
$core->tpl->display('user/validate_email_send.tpl');
?>