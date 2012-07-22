<?php
// ģ���ļ������Ŀ¼
define('TEMPLATE_SUB_DIR', 'www');

require_once('init.php');

// �Ƿ�ر���վ
if ($core->Config['site_stop'])
{
	$core->Notice($core->Config['site_stop_msg'], 'halt');
}

// �������ݿ�
$core->InitAdodb();
// ȡ��¼�û���Ϣ
$core->GetUserInfo($_COOKIE['XX_UserID']);
define('IS_VIP', $core->UserInfo['vip']);

if (IS_VIP)
{
	define('SITE_ROOT_PATH', $core->Config['domain_vip']);
}
else
{
	define('SITE_ROOT_PATH', $core->Config['domain_www']);
}

if (!defined('NOT_USE_TEMPLATE'))
{
	// ����ķ�������
	require_once(ROOT_PATH.'/include/kernel/class_sort.php');
	$core->sort = new Sort($core->Config);

	$core->tpl->assign(array(
		'SortTree' => $core->sort->SortTree,
		'SortList' => $core->sort->SortList,
		'SortOne'  => $core->sort->SortOneList,
		'UserInfo' => $core->UserInfo,
		'SpecialSortData' => $core->SpecialSortData(),
	));
}
?>