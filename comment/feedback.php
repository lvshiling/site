<?php
define('IN_PLACE', 'www');
define('IN_SCRIPT', 'feedback');
// 不使用文件缓存
define('NOT_USE_CACHE', '');

require_once('../global.php');

if ('add' == $_POST['op'])
{
	$core->CheckVerifyCode('feedback', $_POST['vcode']);

	$feedback_contact = trim($_POST['contact']);
	if (!empty($feedback_contact))
	{
		$feedback_contact = htmlspecialchars($feedback_contact);
		if (100 < $core->CnStrlen($feedback_contact))
		{
			$core->Notice($core->Language['feedback']['error_contact_length'], 'back');
		}
	}

	$feedback_content = trim($_POST['content']);
	if (empty($feedback_content))
	{
		$core->Notice($core->Language['feedback']['error_content_empty'], 'back');
	}
	$feedback_content = htmlspecialchars($feedback_content);
	if (1000 < $core->CnStrlen($feedback_content))
	{
		$core->Notice($core->Language['feedback']['error_content_length'], 'back');
	}

	$core->DB->Execute("INSERT INTO {$core->TablePre}feedback (feedback_contact, feedback_content, feedback_date, feedback_ip) VALUES ('{$feedback_contact}', '{$feedback_content}', '".TIME_NOW."', '".CLIENT_IP."')");

	$core->DestructVerifyCode('feedback');

	$core->Notice($core->Language['feedback']['succeed'], 'halt');
}

$core->tpl->assign(array(
	'SiteTitle' => $core->Language['feedback']['page_title'],
));
$core->tpl->display('feedback.tpl');
?>