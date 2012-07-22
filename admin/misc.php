<?php
define('IN_PLACE', 'admin');
define('IN_SCRIPT', 'misc');

require_once('global.php');


// ################## ÐÞ¸ÄµÇÂ¼ÃÜÂë ################## //
if ('change_pw' == $_POST['op'])
{
	$current_password = $_POST['c_pw'];
	$new_password = $_POST['n_pw'];
	$repeat_new_password = $_POST['r_n_pw'];
	if ('' == $current_password)
	{
		$core->Notice($core->Language['misc']['error_password_old_empty'], 'back');
	}
	if ('' == $new_password)
	{
		$core->Notice($core->Language['misc']['error_password_new_empty'], 'back');
	}
	if (6 > strlen($new_password))
	{
		$core->Notice($core->Language['misc']['error_password_length'], 'back');
	}
	if ($new_password != $repeat_new_password)
	{
		$core->Notice($core->Language['misc']['error_password_mismatch'], 'back');
	}

	if ($core->CryptPW($current_password) != $current_manager_data['manager_password'])
	{
		$core->Notice($core->Language['misc']['error_password_current'], 'back');
	}

	$core->DB->Execute("UPDATE {$core->TablePre}manager SET manager_password='".$core->CryptPW($new_password)."' WHERE manager_id='".AdminUserID."'");

	$core->ManagerLog($core->Language['misc']['log_password']);

	$core->Notice($core->Language['misc']['password_succeed'], 'halt');
}
if ('change_pw' == $_GET['act'])
{
	$core->tpl->display('change_pw.tpl');
}
?>