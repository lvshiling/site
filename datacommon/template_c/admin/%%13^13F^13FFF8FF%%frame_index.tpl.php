<?php /* Smarty version 2.6.19, created on 2011-04-01 12:48:06
         compiled from frame_index.tpl */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Frameset//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-frameset.dtd">
<html dir="ltr" lang="zh_CN">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title><?php echo $this->_tpl_vars['SiteTitle']; ?>
<?php echo $this->_tpl_vars['Config']['site_name']; ?>
</title>
</head>

<frameset rows="65,*" cols="*" framespacing="0" frameborder="0">
  <frame id="top_nav" name="top_nav" src="index.php?act=top" scrolling="no" noresize="noresize" frameborder="0" border="0" />
  <frameset id="sframe" name="sframe" rows="*" cols="160,10,*">
    <frame id="nav" name="nav" src="index.php?act=nav" scrolling="no" frameborder="0" border="0" />
    <frame id="center" name="center" src="index.php?act=center" scrolling="no" frameborder="0" border="0" noresize="noresize" />
    <frame id="main" name="main" src="index.php?act=main" scrolling="yes" frameborder="0" border="0" />
  </frameset>
</frameset>

<noframes>
<body><p>您的浏览器不支持框架显示，请选择一个新浏览器！</p></body>
</noframes>

</html>