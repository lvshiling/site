<?php
if (!defined('IN_SITE')) @header('HTTP/1.1  404  Not  Found');

$CONFIG = array();

/* ############################################################# */
// 数据库类型
// 目前只支持mysql数据库
$CONFIG['db']['type']     = 'mysql';

// 数据库服务器地址
$CONFIG['db']['host']     = 'localhost';
// 数据库连接用户名
$CONFIG['db']['user']     = 'root';
// 数据库连接密码
$CONFIG['db']['password'] = '';
// 使用的数据库名
$CONFIG['db']['name']     = 'site';

// 数据库持久连接
// 0:关闭, 1:打开
$CONFIG['db']['pconnect'] = 0;
// 表名前缀
$CONFIG['db']['prefix']   = 'xx_';


/* ############################################################# */
// 数据保存目录(结尾不包含'/')
$CONFIG['dir']['data'] = ROOT_PATH.'/datacommon';
?>