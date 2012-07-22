<?php
define('IN_PLACE', 'www');
define('IN_SCRIPT', 'show');
define('NOT_USE_CACHE', '');

require_once('../global.php');

// 检查用户是否有访问权限
if (!$core->UserInfo['user_id'])
{
	header('Location: '.$core->Config['domain_vip'].'/user.php?o=login&goto='.urlencode(CURRENT_URL));
	exit;
}

$core->IPValidateCheck();

$id = trim($_GET['id']);
$page = abs(intval($_GET['page']));
if (!preg_match('#^[a-f0-9]{32}$#', $id))
{
	header('Location: '.$core->Config['domain_www']);
	exit;
}

$data = $core->DB->GetRow("SELECT d.*, de.data_content FROM {$core->TablePre}data AS d, {$core->TablePre}data_ext AS de WHERE d.data_id=de.data_id AND d.hash_id='{$id}'");
if (!$data || !$data['is_auditing'] || $data['mark_deleted'])
{
	header('Location: '.$core->Config['domain_www']);
	exit;
}
if ($page > $data['page_num'])
{
	$core->Notice($core->Language['common']['p_error'], 'halt');
}

// 所属分类树
$sub_nav = '';
$parent_tree = $core->sort->GetParentTree($data['sort_id']);
if ($parent_tree)
{
	foreach ($parent_tree as $sort_id=>$sort_name)
	{
		$sub_nav .= '<a href="/sort-'.$sort_id.'-1.html">'.$sort_name.'</a> &raquo; ';
	}
}
$sub_nav .= '<a href="/sort-'.$data['sort_id'].'-1.html">'.$core->sort->SortList[$data['sort_id']]['name'].'</a>';

if (0 < $data['page_num'])
{
	$page_break_str = '<div style="page-break-after: always"><span style="display: none">&nbsp;</span></div>';
	$contents = explode($page_break_str, $data['data_content']);
	$data['data_content'] = $contents[$page];
}

if (IS_VIP || $core->sort->SortList[$data['sort_id']]['vip'])
{
	$data['show_url'] = $core->Config['domain_vip'].'/show-'.$data['hash_id'].'.html';
}
else
{
	$data['show_url'] = $core->Config['domain_www'].'/go.html?p='.$core->UrlEncryptParame($data['data_id'], $data['release_date']);
	//$data['show_url'] = $core->Config['domain_www'].'/show/'.date('Y/md', $data['release_date']).'/'.$data['data_id'].'.html';
}

require_once(ROOT_PATH.'/include/kernel/class_html_tidy.php');
$tidy = new html_tidy();
$data['data_content'] = $tidy->Execute($data['data_content']);
$data['data_content'] = $core->ReplaceImageInfo($data['data_content']);

$core->tpl->assign(array(
	'SiteTitle' => $data['data_title'].' - '.strip_tags($core->sort->SortList[$data['sort_id']]['name']),
	'SubNav'    => $sub_nav,
	'Data'      => $data,
	'Multipage' => $core->ContentMultipage('show-'.$data['hash_id'], $data['page_num'], $page),
));
$core->tpl->display('show_1.tpl');
?>