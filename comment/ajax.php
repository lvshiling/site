<?php
define('IN_PLACE', 'www');
define('IN_SCRIPT', 'ajax');
// ��ʹ���ļ�����
define('NOT_USE_CACHE', '');
//define('NOT_USE_TEMPLATE', TRUE);

require_once('../global.php');

// �ٱ�
if ('report' == $_POST['act'])
{
	$data_id = intval($_POST['id']);
	if (!$core->DB->GetOne("SELECT data_id FROM {$core->TablePre}data WHERE data_id='{$data_id}'"))
	{
		$core->Notice(array('state'=>'error', 'message'=>$core->Language['common']['data_not_exist']), 'json');
	}

	$report_content = trim($_POST['content']);
	if (empty($report_content))
	{
		$core->Notice(array('state'=>'error', 'message'=>$core->Language['report']['error_content_empty']), 'json');
	}
	if (500 < $core->CnStrlen($report_content))
	{
		$core->Notice(array('state'=>'error', 'message'=>$core->Language['report']['error_content_length']), 'json');
	}

	$report_content = htmlspecialchars($report_content);

	$core->DB->Execute("INSERT INTO {$core->TablePre}report (data_id, report_content, report_date, report_ip) VALUES ('{$data_id}', '{$report_content}', '".TIME_NOW."', '".CLIENT_IP."')");

	$core->Notice(array('state'=>'succeed', 'message'=>$core->Language['report']['succeed']), 'json');
}

// ����
if ('vote' == $_POST['act'])
{
	$comment_id = intval($_POST['id']);
	if (!$core->DB->GetOne("SELECT comment_id FROM {$core->TablePre}comment WHERE comment_id='{$comment_id}'"))
	{
		$core->Notice('error');
	}
	// 0: ����, 1: �޳�, 2: �ٱ�
	if (0 == $_POST['type'] || 1 == $_POST['type'])
	{
		$type = 0 == $_POST['type'] ? 'oppose_num' : 'agree_num';
		$core->DB->Execute("UPDATE {$core->TablePre}comment SET {$type}={$type}+1 WHERE comment_id='{$comment_id}'");
	}
	else if (2 == $_POST['type'])
	{
		$core->DB->Execute("UPDATE {$core->TablePre}comment SET report_num=report_num+1 WHERE comment_id='{$comment_id}'");
	}
	else
	{
		$core->Notice('error');
	}
	$core->Notice('succeed');
}
?>