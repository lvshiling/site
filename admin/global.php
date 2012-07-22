<?php
// ģ���ļ������Ŀ¼
define('TEMPLATE_SUB_DIR', 'admin');
// ��ʹ���ļ�����
define('NOT_USE_CACHE', '');

require_once('../init.php');

if (file_exists(ROOT_PATH.'/install'))
{
	$core->Notice('Please delete the install directory: install!', 'halt');
}

define('SITE_ROOT_PATH', $core->Config['domain_www']);
define('IS_VIP', 0);

// ���ݿ�����
@$core->InitAdodb();

$core->tpl->assign(array(
	'SiteTitle' => $core->Language['global']['page_title'].' - ',
));

session_start();
@header('Cache-Control: private');

if (0 >= $_SESSION['C_AdminUserID'] && 'login' != $_POST['op'])
{
	// ��ʾ��¼ҳ��
	$core->tpl->assign(array(
		'SiteTitle'   => $core->Language['login']['page_title'].' - ',
	));
	$core->tpl->display('login.tpl');
	exit;
}

if ('login' != $_POST['op'])
{
	// ȡ��ǰ����Ա����
	$current_manager_data = $core->DB->GetRow("
		SELECT m.manager_name, m.manager_password, mp.* FROM {$core->TablePre}manager AS m, {$core->TablePre}manager_permission AS mp 
		WHERE m.manager_id=mp.manager_id AND m.manager_id='{$_SESSION['C_AdminUserID']}'
	");
	if (!$current_manager_data)
	{
		$core->Notice($core->Language['login']['illegal'], 'back');
	}
	if (!$current_manager_data['can_login'])
	{
		$_SESSION['C_AdminUserID'] = 0;
		$core->Notice($core->Language['login']['forbid'], 'goto', 'index.php');
	}

	$core->tpl->assign(array(
		'ManagerInfo' => array('id'=>$current_manager_data['manager_id'],'name'=>$current_manager_data['manager_name']),
	));
}

define('AdminUserID', $current_manager_data['manager_id']);

require_once(ROOT_PATH.'/include/kernel/class_sort.php');
$core->sort = new Sort($core->Config);

// ����Ȩ�޼��
function CheckPermission($permission)
{
	global $core;
	global $current_manager_data;

	if (!$current_manager_data['is_super_manager'] && !$current_manager_data[$permission])
	{
		$core->Notice($core->Language['global']['no_permission'], 'halt');
	}
}
?>