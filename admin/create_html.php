<?php
define('IN_PLACE', 'admin');
define('IN_SCRIPT', 'create');

//if (isset($_GET['act'])) define('TEMPLATE_SUB_DIR', 'www');

require_once('global.php');

define('SITE_ROOT_PATH', $core->Config['domain_www']);
define('IS_VIP', 0);

// 检查权限
// 允许所有能登录的管理员

if (isset($_GET['act']))
{
	if (
			'home' == $_GET['act'] 
		 || 'list' == $_GET['act'] 
		 || 'hotsearch' == $_GET['act'] 
		 || 'today' == $_GET['act'] 
		 || 'yesterday' == $_GET['act']
	)
	{
		$core->CreateHtml($_GET['act']);
		header('Location: create_html.php?act=succeed');
	}
	else if ('show' == $_GET['act'])
	{
		// 当前页
		$page = intval($_GET['page']);
		$page = 0 >= $page ? 1 : $page;
		// 生成总数
		$total = intval($_GET['total']);
		// 每次循环处理的数量
		$pre_num = intval($_GET['pre']);
		$pre_num = 0 >= $pre_num || $pre_num > 500 ? 20 : $pre_num;
		$offset = ($page - 1) * $pre_num;

		// 生成条件
		$condition = 'is_auditing=1';
		$sort_id = intval($_GET['sort']);
		if (0 < $sort_id)
		{
			$condition .= " AND sort_id='{$sort_id}'";
		}
		if (isset($_GET['date_type']))
		{
			if ($_GET['start_date'] > $_GET['last_date'])
			{
				$core->Notice($core->Language['html']['error_date'], 'back');
			}
			$start_date = strtotime($_GET['start_date'].' 00:00:00');
			$last_date = strtotime($_GET['last_date'].' 23:59:59');
			switch ($_GET['date_type'])
			{
				default:
					$condition .= " AND release_date>='{$start_date}' AND release_date<='{$last_date}'";
				break;
			}
		}

		// 继续下一批数据
		$pass_parameter = array(
			'act'        => $_GET['act'], 
			'sort'       => $sort_id, 
			'date_type'  => $_GET['date_type'], 
			'start_date' => $_GET['start_date'], 
			'last_date'  => $_GET['last_date'], 
			'total'      => $total, 
			'pre'        => $pre_num, 
		);

		$_current_1 = $offset + 1;
		$_current_2 = $_current_1 + $pre_num - 1;

		if (0 >= $total)
		{
			$g_total = $core->DB->GetRow("SELECT COUNT(*) AS num FROM {$core->TablePre}data WHERE $condition");
			if (0 >= $g_total['num'])
			{
				$core->Notice($core->Language['html']['error_data_empty'], 'back');
			}
			$pass_parameter['total'] = $g_total['num'];

			$_current_2 = $g_total['num'] < $_current_2 ? $g_total['num'] : $_current_2;
			$_current_3 = $g_total['num'] - $_current_2;
			$_current_3 = 0 > $_current_3 ? 0 : $_current_3;

			$goto_url = 'create_html.php?'.http_build_query($pass_parameter);

			// 开始正式生成
			$core->Notice($core->LangReplaceText($core->Language['html']['waiting_begin'], $g_total['num'], $goto_url), 'goto', $goto_url, 1);
		}

		if ($total <= $offset)
		{
			// 结束了
			header('Location: create_html.php?act=succeed');
			exit;
		}

		$query = $core->DB->Execute("SELECT data_id FROM {$core->TablePre}data WHERE $condition ORDER BY data_id ASC LIMIT $offset, $pre_num");
		while (!$query->EOF)
		{
			$core->CreateHtml($query->fields['data_id']);
			$query->MoveNext();
		}

		$_current_2 = $total < $_current_2 ? $total : $_current_2;
		$_current_3 = $total - $_current_2;
		$_current_3 = 0 > $_current_3 ? 0 : $_current_3;

		$pass_parameter['page'] = $page + 1;

		$core->SetTemplateDir('admin');
		$goto_url = 'create_html.php?'.http_build_query($pass_parameter);
		$core->Notice($core->LangReplaceText($core->Language['html']['waiting_batch'], $_current_1, $_current_2, $_current_3, $goto_url), 'goto', $goto_url, 1);
	}
	else if ('succeed' == $_GET['act'])
	{
		$core->Notice($core->Language['common']['succeed'], 'halt');
	}
	else
	{
		$core->Notice($core->Language['common']['p_error'], 'halt');
	}
}
else
{
	// 显示HTML生成界面
	$core->tpl->assign(array(
		'SortList'    => $sort,
		'CurrentDate' => date('Y-m-d', TIME_NOW),
	));
	$core->tpl->display('create_html.tpl');
}
?>