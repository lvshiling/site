<?php
define('IN_PLACE', 'admin');
define('IN_SCRIPT', 'setting');

require_once('global.php');

CheckPermission('is_super_manager');


// ################## 网站参数设置 ################## //
if ('change_website' == $_POST['op'])
{
	if (!is_array($_POST['config']))
	{
		$core->Notice($core->Language['common']['p_error'], 'back');
	}

	// 关闭网站
	$_POST['config']['site_stop'] = $_POST['config']['site_stop']==1 ? 1 : 0;
	// 网站关闭提示信息
	$_POST['config']['site_stop_msg'] = trim($_POST['config']['site_stop_msg']);
	if (1 == $_POST['config']['site_stop'])
	{
		if ('' == $_POST['config']['site_stop_msg'])
		{
			$core->Notice($core->Language['setting']['error_notice_empty'], 'back');
		}
	}

	// 网站名称
	$_POST['config']['site_name'] = trim($_POST['config']['site_name']);
	if (empty($_POST['config']['site_name']))
	{
		$core->Notice($core->Language['setting']['error_sitename_empty'], 'back');
	}
	if (200 < $core->CnStrlen($_POST['config']['site_name']))
	{
		$core->Notice($core->Language['setting']['error_sitename_length'], 'back');
	}

	// 上传的种子文件最大允许
	$_POST['config']['pic_file_size'] = abs(intval($_POST['config']['pic_file_size'])) * 1024;
	// 上传的种子文件内容介绍最大允许字符
	$_POST['config']['content_maxlength'] = abs(intval($_POST['config']['content_maxlength']));
	if (0 >= $_POST['config']['content_maxlength'] || 200000 < $_POST['config']['content_maxlength'])
	{
		$_POST['config']['content_maxlength'] = 50000;
	}

	// 保存到数据库
	foreach ($_POST['config'] as $name=>$value)
	{
		if (!is_array($value)) $value = trim($value);
		// 空值,删除
		if (empty($value))
		{
			$core->DB->Execute("DELETE FROM {$core->TablePre}config WHERE name='".$name."'");
			continue;
		}
		if ($core->DB->GetOne("SELECT name FROM {$core->TablePre}config WHERE name='".$name."'"))
		{
			$core->DB->Execute("UPDATE {$core->TablePre}config SET value='".$value."' WHERE name='".$name."'");
		}
		else
		{
			$core->DB->Execute("INSERT {$core->TablePre}config (name, value) VALUES ('".$name."', '".$value."')");
		}
	}

	// 保存为文件
	$config_info .= '$CacheConfig = '.stripslashes(var_export($_POST['config'], TRUE)).';';

	$cache_config_path = $core->Config['dir']['data'].'/cache/config.php';
	if (!$core->UpdateCacheFile($cache_config_path, $config_info))
	{
		$core->Notice($core->Language['common']['cache_error'], 'back');
	}

	$core->ManagerLog($core->Language['setting']['log_change_website']);

	$core->Notice($core->Language['setting']['change_website_succeed'], 'halt');
}


// ################## 网站参数设置 ################## //
if ('website' == $_GET['act'])
{
	$config = array();
	$query = $core->DB->Execute("SELECT * FROM {$core->TablePre}config");
	if ($query)
	{
		while (!$query->EOF)
		{
			$config[$query->fields['name']] = $query->fields['value'];

			$query->MoveNext();
		}
	}
	if (!$config)
	{
		$config = $core->Config;
	}

	if (0 < $config['pic_file_size'])
	{
		$config['pic_file_size'] = $config['pic_file_size'] / 1024;
	}

	$core->tpl->assign(array(
		'Config'          => $config,
		/*时区*/
		'timezone_offset' => array(
			'-12'  => $core->Language['gmt']['text1'],
			'-11'  => $core->Language['gmt']['text2'],
			'-10'  => $core->Language['gmt']['text3'],
			'-9'   => $core->Language['gmt']['text4'],
			'-8'   => $core->Language['gmt']['text5'],
			'-7'   => $core->Language['gmt']['text6'],
			'-6'   => $core->Language['gmt']['text7'],
			'-5'   => $core->Language['gmt']['text8'],
			'-4'   => $core->Language['gmt']['text9'],
			'-3.5' => $core->Language['gmt']['text10'],
			'-3'   => $core->Language['gmt']['text11'],
			'-2'   => $core->Language['gmt']['text12'],
			'-1'   => $core->Language['gmt']['text13'],
			'0'    => $core->Language['gmt']['text14'],
			'1'    => $core->Language['gmt']['text15'],
			'2'    => $core->Language['gmt']['text16'],
			'3'    => $core->Language['gmt']['text17'],
			'3.5'  => $core->Language['gmt']['text18'],
			'4'    => $core->Language['gmt']['text19'],
			'4.5'  => $core->Language['gmt']['text20'],
			'5'    => $core->Language['gmt']['text21'],
			'5.5'  => $core->Language['gmt']['text22'],
			'6'    => $core->Language['gmt']['text23'],
			'7'    => $core->Language['gmt']['text24'],
			'8'    => $core->Language['gmt']['text25'],
			'9'    => $core->Language['gmt']['text26'],
			'9.5'  => $core->Language['gmt']['text27'],
			'10'   => $core->Language['gmt']['text28'],
			'11'   => $core->Language['gmt']['text29'],
			'12'   => $core->Language['gmt']['text30'],
			'13'   => $core->Language['gmt']['text31'],
		),
	));
	$core->tpl->display('setting_website.tpl');
	exit;
}
?>