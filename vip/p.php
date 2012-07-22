<?php
define('IN_PLACE', 'www');
define('IN_SCRIPT', 'promotion');
define('NOT_USE_CACHE', '');
define('NOT_USE_TEMPLATE', TRUE);

require_once('../global.php');

$core->Config['validate_ip_aim_url'] || $core->Config['validate_ip_aim_url'] = $core->Config['domain_www'];

// อฦนใผคป๎
$user_id = intval($_GET['id']);
if (0 >= $user_id)
{
	header('Location: '.$core->Config['validate_ip_aim_url']);
	exit;
}

$user_info = $core->DB->GetRow("SELECT * FROM {$core->TablePre}user WHERE user_id='{$user_id}'");
if (!$user_info || CLIENT_IP == $user_info['ipaddress'])
{
	header('Location: '.$core->Config['validate_ip_aim_url']);
	exit;
}

$ip_validate = $core->DB->GetRow("SELECT * FROM {$core->TablePre}user_ip_validate WHERE user_id='{$user_id}' AND validate_ip='".CLIENT_IP."'");
if ($ip_validate)
{
	header('Location: '.$core->Config['validate_ip_aim_url']);
	exit;
}

$core->DB->Execute("UPDATE {$core->TablePre}user SET validate_ip=validate_ip+1 WHERE user_id='{$user_id}'");
$core->DB->Execute("INSERT INTO {$core->TablePre}user_ip_validate (user_id, validate_ip, validate_date) VALUES ('{$user_id}', '".CLIENT_IP."', '".TIME_NOW."')");

header('Location: '.$core->Config['validate_ip_aim_url']);
exit;
?>