<?php
if (!defined('IN_SITE')) @header('HTTP/1.1  404  Not  Found');

// ################## ÐÞ¸ÄÃÜÂë ################## //
if ('change_pw' == $_POST['op'])
{
	$current_pw = $_POST['current_pw'];
	$new_pw = $_POST['new_pw'];
	$repeat_new_pw = $_POST['repeat_new_pw'];
	if ('' == $current_pw)
	{
		$core->Notice($core->Language['profile']['error_password_empty1'], 'back');
	}
	if ('' == $new_pw)
	{
		$core->Notice($core->Language['profile']['error_password_empty2'], 'back');
	}
	if ($repeat_new_pw != $new_pw)
	{
		$core->Notice($core->Language['profile']['error_password_mismatch'], 'back');
	}
	if (4 > strlen($new_pw))
	{
		$core->Notice($core->Language['profile']['error_password_length'], 'back');
	}

	if ($core->CryptPW($current_pw) != $core->UserInfo['user_password'])
	{
		$core->Notice($core->Language['profile']['error_password_current'], 'back');
	}

	$core->DB->Execute("UPDATE {$core->TablePre}user SET user_password='".$core->CryptPW($new_pw)."' WHERE user_id='".$core->UserInfo['user_id']."'");

	$core->Notice($core->Language['profile']['password_succeed'], 'halt');
}
if ('change_pw' == $_GET['act'])
{
	$core->tpl->assign(array(
		'SiteTitle' => $core->Language['profile']['page_title'],
	));
	$core->tpl->display('user/change_pw.tpl');
}
?>