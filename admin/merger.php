<?php
define('IN_PLACE', 'admin');
define('IN_SCRIPT', 'merger');

require_once('global.php');

CheckPermission('can_manage_bt');


//  ################## 合并两个分类 ################## //
if ('sort' == $_POST['op'])
{
	$origin_sort_id = intval($_POST['origin_sort_id']);
	$aim_sort_id = intval($_POST['aim_sort_id']);
	if (0 >= $origin_sort_id)
	{
		$core->Notice($core->Language['merger']['error_nso_sort'], 'back');
	}
	if (0 >= $aim_sort_id)
	{
		$core->Notice($core->Language['merger']['error_nsa_sort'], 'back');
	}
	if ($origin_sort_id == $aim_sort_id)
	{
		$core->Notice($core->Language['merger']['error_self'], 'back');
	}

	// 源分类
	$origin_sort_data = $core->DB->GetRow("SELECT * FROM {$core->TablePre}sort WHERE sort_id='{$origin_sort_id}'");
	if (!$origin_sort_data)
	{
		$core->Notice($core->Language['merger']['error_neo_sort'], 'back');
	}

	// 目标分类
	$aim_sort_data = $core->DB->GetRow("SELECT * FROM {$core->TablePre}sort WHERE sort_id='{$aim_sort_id}'");
	if (!$aim_sort_data)
	{
		$core->Notice($core->Language['merger']['error_nea_sort'], 'back');
	}

	$core->DB->Execute("UPDATE {$core->TablePre}data SET sort_id='{$aim_sort_id}' WHERE sort_id='{$origin_sort_id}'");

	$core->ManagerLog($core->LangReplaceText($core->Language['merger']['log_sort'], addslashes($origin_sort_data['sort_name']), addslashes($aim_sort_data['sort_name'])));

	$core->Notice($core->Language['merger']['succeed'], 'halt');
}


//  ################## 合并两个用户 ################## //
if ('user' == $_POST['op'])
{
	$origin_user_id = intval($_POST['origin_user_id']);
	$aim_user_id = intval($_POST['aim_user_id']);
	if (0 >= $origin_user_id)
	{
		$core->Notice($core->Language['merger']['error_nso_user'], 'back');
	}
	if (0 >= $aim_user_id)
	{
		$core->Notice($core->Language['merger']['error_nsa_user'], 'back');
	}
	if ($origin_user_id == $aim_user_id)
	{
		$core->Notice($core->Language['merger']['error_self'], 'back');
	}

	// 源用户
	$origin_user_data = $core->DB->GetRow("SELECT user_id, user_name FROM {$core->TablePre}user WHERE user_id='{$origin_user_id}'");
	if (!$origin_user_data)
	{
		$core->Notice($core->Language['merger']['error_neo_user'], 'back');
	}

	// 目标用户
	$aim_user_data = $core->DB->GetRow("SELECT user_id, user_name FROM {$core->TablePre}user WHERE user_id='{$aim_user_id}'");
	if (!$aim_user_data)
	{
		$core->Notice($core->Language['merger']['error_nea_user'], 'back');
	}

	$core->DB->Execute("UPDATE {$core->TablePre}data SET user_id='".$aim_user_id."'".$append_update." WHERE user_id='{$origin_user_id}'");

	$core->ManagerLog($core->LangReplaceText($core->Language['merger']['log_user'], addslashes($origin_user_data['user_name']), addslashes($aim_user_data['user_name'])));

	$core->Notice($core->Language['merger']['succeed'], 'halt');
}

// ################## 显示合并操作页面 ################## //
$core->tpl->assign(array(
	'OriginSortOption' => $core->sort->GetSortOption(),
	'AimSortOption' => $core->sort->GetSortOption(),
));
$core->tpl->display('merger.tpl');
?>