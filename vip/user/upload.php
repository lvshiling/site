<?php
if (!defined('IN_SITE'))
{
	@header('HTTP/1.1  404  Not  Found');
	exit;
}

set_time_limit(0);

$_FILES = $_FILES['Filedata'];
require_once(ROOT_PATH.'/include/kernel/class_upload.php');
$up = new Upload($core);
$upfile = $up->Execute();

// �ɹ�,����������ͼƬ��ַ
$core->Notice(array(
	'state' => 'succeed', 
	'value' => $up->visit_path.'/'.$upfile['remote'],
), 'json');
?>