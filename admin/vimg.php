<?php
define('IN_PLACE', 'admin');
define('IN_SCRIPT', 'vimg');

// 不使用模板引擎
define('NOT_USE_TEMPLATE', TRUE);

require_once('../init.php');

if ('test' != $_GET['n'])
{
	// 关闭验证码
	if ($core->Config['verify_code_close']) exit;
}

$cookie_name = preg_replace('#[^a-z]#i', '', trim($_GET['n']));

$randstr = $core->RandStr(4);

$core->MySetcookie($cookie_name, md5($randstr));

require_once(ROOT_PATH.'/include/kernel/class_vimg.php');
// 实例化类, 传入将要写入图片的文字
$img = new VerifyImage($randstr);

// [必须]设置图像中文字的字体
$img->TxtFont = ROOT_PATH.'/include/fonts/acmesa'.(rand(0,1)==1?'i':'').'.ttf';

// [可选]设置图像中的文字大小, 默认为9pt
$img->FontSize = 14;

// [可选]图像边框颜色, 默认为黑色
$img->BorderColor = 'FFFFFF';

// [可选]图像干扰素颜色, 默认为黑色
//$img->DColor = 'CCCCCC';

// [可选]图像背景颜色, 默认为白色
$img->ImgBgColor = 'FFFFFF';

// [可选][数组]设置一组文字颜色, 默认为单一黑色
// 该组颜色将会随机应用在图片中的文字上
$img->TxtColors = array('0000CC', 'D70B2E', 'B00B96', '336600', '000000', 'FF6600');

// [可选]输出格式, 默认为png, 有效值: gif | jpeg | png
//$img->OutFormat = 'png';

// [必须]设置文字在图像中的位置
// 给出两个参数: 横坐标和纵坐标
$img->SetTextPosition(3, 20);

// 创建图像, 并设置图像的宽和高
$img->CreateImg(68, 26);
?>