<?php
if (!defined('IN_SITE')) @header('HTTP/1.1  404  Not  Found');

$CONFIG = array();

/* ############################################################# */
// ���ݿ�����
// Ŀǰֻ֧��mysql���ݿ�
$CONFIG['db']['type']     = 'mysql';

// ���ݿ��������ַ
$CONFIG['db']['host']     = 'localhost';
// ���ݿ������û���
$CONFIG['db']['user']     = 'root';
// ���ݿ���������
$CONFIG['db']['password'] = '';
// ʹ�õ����ݿ���
$CONFIG['db']['name']     = 'site';

// ���ݿ�־�����
// 0:�ر�, 1:��
$CONFIG['db']['pconnect'] = 0;
// ����ǰ׺
$CONFIG['db']['prefix']   = 'xx_';


/* ############################################################# */
// ���ݱ���Ŀ¼(��β������'/')
$CONFIG['dir']['data'] = ROOT_PATH.'/datacommon';
?>