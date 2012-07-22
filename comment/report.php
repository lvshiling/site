<?php
define('IN_PLACE', 'www');
define('IN_SCRIPT', 'report');
// 不使用文件缓存
define('NOT_USE_CACHE', '');

require_once('../global.php');

if ('add' == $_POST['op'])
{
	$core->CheckVerifyCode('report', $_POST['vcode']);

	$report_url = trim($_POST['url']);
	if (empty($report_url))
	{
		$core->Notice($core->Language['report']['error_url_empty'], 'back');
	}
	$report_url = htmlspecialchars($report_url);
	if (250 < $core->CnStrlen($report_url))
	{
		$core->Notice($core->Language['report']['error_url_length'], 'back');
	}

	$report_content = trim($_POST['content']);
	if (empty($report_content))
	{
		$core->Notice($core->Language['report']['error_content_empty'], 'back');
	}
	$report_content = htmlspecialchars($report_content);
	if (500 < $core->CnStrlen($report_content))
	{
		$core->Notice($core->Language['report']['error_content_length'], 'back');
	}

	$core->DB->Execute("INSERT INTO {$core->TablePre}report (report_url, report_content, report_date, report_ip) VALUES ('{$report_url}', '{$report_content}', '".TIME_NOW."', '".CLIENT_IP."')");

	$core->DestructVerifyCode('report');

	$core->Notice($core->Language['report']['succeed'], 'halt');
}

$report_url = trim($_GET['url']);
if (empty($report_url))
{
	$report_url = $core->GetReferrerUrl();
	if (empty($report_url)) exit;
}
else
{
	$report_url = urlencode($report_url);
}

$core->tpl->assign(array(
	'SiteTitle' => $core->Language['report']['page_title'],
	'ReportUrl' => $report_url,
));
$core->tpl->display('report.tpl');
?>