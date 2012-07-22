<?php
define('IN_SCRIPT', 'user');
// ��ʹ���ļ�����
define('NOT_USE_CACHE', '');

require_once('../global.php');

// δ��¼�Ҳ��ڵ�¼��ע��ҳ��
if (0 >= $core->UserInfo['user_id'] && !preg_match('#user\.php\?o\=(login|reg|validate_email)#i', CURRENT_URL))
{
	header('Location: user.php?o=login&goto='.urlencode(CURRENT_URL));
	exit;
}

$core->tpl->assign(array(
	'SortTree' => $core->sort->SortTree, 
	'SortList' => $core->sort->SortList, 
	'SubNav'   => $core->Language['user']['page_title'].'('.$core->UserInfo['user_name'].')',
));

switch ($_GET['o'])
{
	case 'data':
	case 'login':
	case 'profile':
	case 'reg':
	case 'validate_email':
	case 'post':
	case 'upload':
		$module_file = $_GET['o'];
	break;
	default:
		$_GET['o'] = 'index';
		$module_file = 'index';
	break;
}

if ('login' != $_GET['o'] && 0 < $core->UserInfo['user_id'])
{
	$core->IPValidateCheck();
}

if ('login' == $_GET['o'] || 'reg' == $_GET['o'] || 'validate_email' == $_GET['o'])
{
	// ��¼��ע�����֤EMAIL����ǰ̨����
	define('IN_PLACE', 'www');
}
else
{
	define('IN_PLACE', 'user');
}

require_once(ROOT_PATH.'/vip/user/'.$module_file.'.php');
?>