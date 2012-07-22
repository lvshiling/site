<?php
//ini_set('display_errors', 'on');
error_reporting(E_ALL & ~E_NOTICE);

if (!get_magic_quotes_gpc())
{
	// php5+
	if (isset($_SERVER))   array_walk_recursive($_SERVER,   'custom_addslashes');
	if (isset($_POST))     array_walk_recursive($_POST,     'custom_addslashes');
	if (isset($_GET))      array_walk_recursive($_GET,      'custom_addslashes');
	if (isset($_FILES))    array_walk_recursive($_FILES,    'custom_addslashes');
	if (isset($_COOKIE))   array_walk_recursive($_COOKIE,   'custom_addslashes');
	if (isset($_SESSION))  array_walk_recursive($_SESSION,  'custom_addslashes');
}
ini_set('magic_quotes_runtime', 0);


define('IN_SITE', TRUE);
// �����ļ���·��
define('ROOT_PATH', dirname(__FILE__));
// request uri
if (isset($_SERVER['HTTP_X_REWRITE_URL']))
{
	// IIS(ISAPI REWRITE)
	$request_uri = $_SERVER['HTTP_X_REWRITE_URL'];
}
else if (isset($_SERVER['HTTP_SCRIPT_URL']))
{
	// IIS(IIS REWRITE)
	$request_uri = $_SERVER['HTTP_SCRIPT_URL'];
}
else
{
	// APACHE
	$request_uri = $_SERVER['REQUEST_URI'];
}
define('REQUEST_URI', $request_uri);

// ǿ�Ʊ���
header('Content-type:text/html; charset=utf-8');

if ('ajax' == $_GET['act'] || 'ajax' == $_POST['act']) define('IS_AJAX', TRUE);

// ################################################################ //
// ��վȫ�������ļ�
require_once(ROOT_PATH.'/include/config.default.php');
// ������
require_once(ROOT_PATH.'/include/kernel/class_core.php');
$core = new Core();
$core->Config = &$CONFIG;
unset($CONFIG);

// ���÷ÿ�IP��ַ����CLIENT_IP
$core->GetClientIP();

// ��ȡ��վ���û����ļ�
$CacheConfig = array();
$cache_config_file = $core->Config['dir']['data'].'/cache/config.php';
if (!file_exists($cache_config_file))
{
	die('Error: Config.php');
}
require_once($cache_config_file);
$core->Config = $core->Config + $CacheConfig;
// վ������
define('SITE_DOMAIN', strtolower($_SERVER['HTTP_HOST']));
// ��ǰҳ��ַ
define('CURRENT_URL', 'http://'.SITE_DOMAIN.REQUEST_URI);

// �������ϵͳ��ǰʱ��
$time_now = time() - date('Z') + $core->Config['timezone_offset'] * 3600;
define('TIME_NOW', $time_now);

if ($core->Config['gzip_enabled'] && function_exists('ob_gzhandler') && 'cron' != IN_SCRIPT)
{
	if (preg_match('#gzip#i', $_SERVER['HTTP_ACCEPT_ENCODING'])) ob_start('ob_gzhandler');
}

if (!defined('NOT_USE_TEMPLATE') && defined('TEMPLATE_SUB_DIR'))
{
	// ��ʼ��ģ������
	$core->InitTemplate(TEMPLATE_SUB_DIR);

	$core->tpl->assign(array(
		/*������Ϣ*/
		'Config' => $core->Config,
	));
}

// �ַ�ת��
function custom_addslashes(&$value, $key)
{
	if ('' != trim($value))
	{
		$value = addslashes($value);
	}
}

// ����Ƿ�ͨ��.html����
// ��ֹĳЩPHP�ű���ֱ�ӷ���
function check_visit_method($url = '')
{
	if (preg_match('#\.php#i', REQUEST_URI))
	{
		header('Location: /');
		exit;
	}
}

// smarty����ʱ�����û���
function insert_getLoginStatus()
{
	global $core;

	return $core->UserInfo['user_name'];
}
?>