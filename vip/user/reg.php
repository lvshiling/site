<?php
if (!defined('IN_SITE')) @header('HTTP/1.1  404  Not  Found');

// ################## 已注册用户 ################## //
if (0 < $core->UserInfo['user_id'])
{
	header('location: user.php?o=upload');
	exit;
}

if (!$core->Config['user_register'])
{
	$core->Notice($core->Language['reg']['close'], 'halt');
}

//  ################## 执行注册 ################## //
if ('reg' == $_POST['op'])
{
	$core->CheckVerifyCode('reg', $_POST['vcode']);

	// 登录名
	$user_name = trim($_POST['username']);// 4-12
	if ('' == $user_name)
	{
		$core->Notice($core->Language['reg']['error_username_empty'], 'back');
	}
	if (preg_match('#^\d+$#', $user_name))
	{
		$core->Notice($core->Language['reg']['error_username_forbid1'], 'back');
	}
	// 允许使用中英文数字和_(下划线)
	if (!$core->UserNameCheck($user_name))
	{
		$core->Notice($core->Language['reg']['error_username_forbid2'], 'back');
	}
	$user_name = htmlspecialchars($user_name);
	$user_name_length = $core->CnStrlen($user_name);
	if (12 < $user_name_length || 4 > $user_name_length)
	{
		$core->Notice($core->Language['reg']['error_username_length'], 'back');
	}
	// 密码
	$password = $_POST['password'];// 4+
	$r_password = $_POST['r_password'];
	if ('' == $password)
	{
		$core->Notice($core->Language['reg']['error_password_empty'], 'back');
	}
	if (4 > strlen($password))
	{
		$core->Notice($core->Language['reg']['error_password_length'], 'back');
	}
	if ($password != $r_password)
	{
		$core->Notice($core->Language['reg']['error_password_mismatch'], 'back');
	}

	// 电子邮件
	$email = trim($_POST['email']);
	if (empty($email))
	{
		$core->Notice($core->Language['reg']['error_email_empty'], 'back');
	}
	if (!preg_match('#[\w\-]+@[\w\-]+\.[\w\-]+#', $email) || 100 < strlen($email))
	{
		$core->Notice($core->Language['reg']['error_email_error'], 'back');
	}
	$email = strtolower($email);

	if ($core->DB->GetOne("SELECT user_id FROM {$core->TablePre}user WHERE user_name='{$user_name}'"))
	{
		$core->Notice($core->Language['reg']['error_username_exist'], 'back');
	}

	if ($core->DB->GetOne("SELECT user_id FROM {$core->TablePre}user WHERE user_email='{$email}'"))
	{
		$core->Notice($core->Language['reg']['error_email_exist'], 'back');
	}

	$validate_email = 1;
	$core->Config['user_register_vemail'] && $validate_email = 0;

	$core->DB->Execute("INSERT INTO {$core->TablePre}user (user_name, user_password, user_email, dateline, validate_email, can_add, can_edit, can_delete, ipaddress) VALUES ('{$user_name}', '".$core->CryptPW($password)."', '{$email}', '".TIME_NOW."', '{$validate_email}', 1, 1, 1, '".CLIENT_IP."')");
	$new_user_id = $core->DB->Insert_ID();

	$core->DestructVerifyCode('reg');

	if ($core->Config['user_register_vemail'])
	{
		// 发送验证邮件
		require_once(ROOT_PATH.'/include/kernel/class_login.php');
		$login = new Login($core);
		$login->SendValidateEmail($email);
	}
	else
	{
		$core->IPValidateCheck($new_user_id);
	}

	$core->Notice($core->LangReplaceText($core->Language['reg']['succeed_'.$validate_email], $user_name).'<br /><a href="user.php?o=login">'.$core->Language['reg']['login'].'</a>', 'halt');
}


// ################## 显示注册界面 ################## //
$core->tpl->assign(array(
	'SiteTitle' => $core->Language['reg']['page_title'],
	'SubNav' => $core->Language['reg']['page_title'],
));
$core->tpl->display('user/reg.tpl');
?>