<?php
// 模板文件存放子目录
define('TEMPLATE_SUB_DIR', 'www');

require_once('init.php');

// 是否关闭网站
if ($core->Config['site_stop'])
{
	$core->Notice($core->Config['site_stop_msg'], 'halt');
}

// 连接数据库
$core->InitAdodb();
// 取登录用户信息
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
	// 缓存的分类数据
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