<?php
define('IN_PLACE', 'admin');
define('IN_SCRIPT', 'database');

require_once('global.php');

CheckPermission('is_super_manager');


// ################## 执行替换 ################## //
if ('replace' == $_POST['op'])
{
    $exptable = trim($_POST['exptable']);
    $field = trim($_POST['field']);
    $rpstring = trim($_POST['rpstring']);
    $tostring = trim($_POST['tostring']);
    $condition = trim($_POST['condition']);

    if (!empty($condition))
    {
        $condition = stripslashes($condition);
        $condition = " WHERE {$condition}";
    }

    $replace_sql = "UPDATE `{$exptable}` SET `{$field}`=REPLACE(`{$field}`, '{$rpstring}', '{$tostring}'){$condition}";

	if (!$core->DB->Execute($replace_sql))
	{
		$core->Notice($core->Language['database']['replace_failed'].$replace_sql, 'back');
	}

	$core->ManagerLog($core->LangReplaceText($core->Language['database']['log_replace'], $delete_total));

	$core->Notice($core->Language['common']['succeed'], 'halt');
}

// ################## 获取某个表的所有字段 ################## //
if ('field' == $_POST['op'])
{
    $exptable = trim($_POST['exptable']);

    $query = mysql_list_fields($core->Config['db']['name'], $exptable);
    while($row = mysql_fetch_field($query))
    {
        echo '<a href="javascript:void(0);" onclick="selectField(\''.$row->name.'\');">'.$row->name.'</a><br />';
    }
    exit;
}

$tables = $core->DB->GetArray("SHOW TABLES");
if (!$tables)
{
    $core->Notice($core->Language['database']['no_permission'], 'back');
    exit;
}
$new_tables = array();
foreach ($tables as $table)
{
    $new_tables[] = $table['Tables_in_'.$core->Config['db']['name']];
}

$core->tpl->assign(array(
	'Tables' => $new_tables,
));
$core->tpl->display('database.tpl');
?>