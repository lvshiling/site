<?php
define('IN_PLACE', 'admin');
define('IN_SCRIPT', 'badword');

require_once('global.php');

CheckPermission('is_super_manager');


//  ################## Ìí¼ÓÐÂµÄ¹Ø¼ü×Ö ################## //
if ('add' == $_POST['op'])
{
	$word = trim($_POST['word']);
	if ('' == $word)
	{
		header('Location: badword.php');
		exit;
	}
	$word = htmlspecialchars($word);
	if (20 < $core->CnStrlen($word))
	{
		$core->Notice($core->Language['badword']['error_length'], 'back');
	}

	if ($core->DB->GetOne("SELECT badword_id FROM {$core->TablePre}badword WHERE badword_name='".$word."'"))
	{
		$core->Notice($core->Language['badword']['error_exist'], 'back');
	}

	$core->DB->Execute("INSERT INTO {$core->TablePre}badword (badword_name) VALUES ('".$word."')");

	$core->ManagerLog($core->Language['badword']['add'].$word);

	// Çå³ý»º´æ
	$core->DB->CacheFlush("SELECT * FROM {$core->TablePre}badword ORDER BY badword_id DESC");

	header('Location: badword.php');
	exit;
}

//  ################## ±à¼­¹Ø¼ü×Ö ################## //
if ('edit' == $_POST['op'])
{
	$word_id = intval($_POST['id']);
	$word = trim($_POST['word']);
	if ('' == $word)
	{
		header('Location: badword.php');
		exit;
	}
	$word = htmlspecialchars($word);
	if (20 < $core->CnStrlen($word))
	{
		$core->Notice($core->Language['badword']['error_length'], 'back');
	}

	if ($core->DB->GetOne("SELECT badword_id FROM {$core->TablePre}badword WHERE badword_name='".$word."' AND badword_id!='".$word_id."'"))
	{
		$core->Notice($core->Language['badword']['error_exist'], 'back');
	}

	$core->DB->Execute("UPDATE {$core->TablePre}badword SET badword_name='".$word."' WHERE badword_id='".$word_id."'");

	$core->ManagerLog($core->Language['badword']['edit'].$word);

	// Çå³ý»º´æ
	$core->DB->CacheFlush("SELECT * FROM {$core->TablePre}badword ORDER BY badword_id DESC");

	$core->Notice($core->Language['badword']['succeed'], 'halt');
}
if ('edit' == $_GET['act'])
{
	$word_id = intval($_GET['id']);
	$badword = $core->DB->GetRow("SELECT * FROM {$core->TablePre}badword WHERE badword_id='".$word_id."'");
	if (!$badword)
	{
		$core->Notice($core->Language['badword']['not_exist'], 'back');
	}
	$core->tpl->assign(array(
		'Badword' => $badword,
	));
	$core->tpl->display('badword_edit.tpl');
	exit;
}

//  ################## É¾³ý¹Ø¼ü×Ö ################## //
if ('delete' == $_GET['act'])
{
	$word_id = intval($_GET['id']);

	$badword = $core->DB->GetRow("SELECT * FROM {$core->TablePre}badword WHERE badword_id='".$word_id."'");
	if (!$badword)
	{
		$core->Notice($core->Language['badword']['not_exist'], 'back');
	}

	$core->DB->Execute("DELETE FROM {$core->TablePre}badword WHERE badword_id='".$badword['badword_id']."'");

	$core->ManagerLog($core->Language['badword']['delete'].addslashes($badword['badword_name']));

	// Çå³ý»º´æ
	$core->DB->CacheFlush("SELECT * FROM {$core->TablePre}badword ORDER BY badword_id DESC");

	header('Location: badword.php');
	exit;
}


//  ################## ÁÐ±íÏÔÊ¾ ################## //
$badword = $core->DB->GetArray("SELECT * FROM {$core->TablePre}badword ORDER BY badword_id DESC");

$core->tpl->assign(array(
	'Badword' => $badword,
));
$core->tpl->display('badword.tpl');
?>