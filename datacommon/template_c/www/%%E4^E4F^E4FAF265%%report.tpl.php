<?php /* Smarty version 2.6.19, created on 2011-04-02 14:49:45
         compiled from report.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'urldecode', 'report.tpl', 64, false),)), $this); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="Content-Language" content="zh-CN" />
<title><?php if ($this->_tpl_vars['SiteTitle']): ?><?php echo $this->_tpl_vars['SiteTitle']; ?>
 - <?php endif; ?><?php echo $this->_tpl_vars['Config']['site_name']; ?>
</title>
<meta name="robots" content="<?php if (@IN_SCRIPT == user): ?>none<?php else: ?>all<?php endif; ?>" />
<script type="text/javascript">
var DOMAIN_SEARCH = '<?php echo $this->_tpl_vars['Config']['domain_search']; ?>
';
var DOMAIN_COMMENT = '<?php echo $this->_tpl_vars['Config']['domain_comment']; ?>
';
var DOMAIN_STATIC = '<?php echo $this->_tpl_vars['Config']['domain_static']; ?>
';
var open_vcode = <?php if ($this->_tpl_vars['Config']['verify_code_close']): ?>false<?php else: ?>true<?php endif; ?>;
</script>
<link rel="stylesheet" type="text/css" href="<?php echo $this->_tpl_vars['Config']['domain_static']; ?>
/css/global.css?v20080321" />
<script type="text/javascript" src="<?php echo $this->_tpl_vars['Config']['domain_static']; ?>
/javascripts/mootools.js?v1.11.2"></script>
<script type="text/javascript" src="<?php echo $this->_tpl_vars['Config']['domain_static']; ?>
/javascripts/global.js?v20080327"></script>
<style>
body{width:530px;}
</style>
</head>

<body>
<div class="bg">
<div class="main">

<div class="table clear">
<script type="text/javascript">
function checkFormData()
{
	if ('' == $F('content'))
	{
		alert('没有填写举报理由！');
		$('content').focus();
		return false;
	}
	if (500 < cnLength($F('content')))
	{
		alert('举报理由长度不能超过500个字符！');
		$('content').focus();
		return false;
	}
	if (open_vcode)
	{
		if ('' == $F('vcode'))
		{
			alert('请填写验证码！');
			$('vcode').focus();
			return false;
		}
	}

	$('submit').value = Lang['submit'];
	$('submit').disabled = true;
	return true;
}
</script>
<form name="form1" method="post" onsubmit="return checkFormData();">
<input type="hidden" name="op" value="add" />
<input type="hidden" name="url" value="<?php echo $this->_tpl_vars['ReportUrl']; ?>
" />
<div class="nav_title clear text_bold"><?php echo $this->_tpl_vars['SiteTitle']; ?>
</div>
<table class="list_style">
  <tr class="alt1">
    <td class="text_right" width="20%">举报地址</td>
    <td width="80%"><a href="<?php echo ((is_array($_tmp=$this->_tpl_vars['ReportUrl'])) ? $this->_run_mod_handler('urldecode', true, $_tmp) : urldecode($_tmp)); ?>
" target="_blank"><?php echo ((is_array($_tmp=$this->_tpl_vars['ReportUrl'])) ? $this->_run_mod_handler('urldecode', true, $_tmp) : urldecode($_tmp)); ?>
</a></td>
  </tr>
  <tr class="alt2">
    <td class="text_right" valign="top">您的举报理由</td>
    <td><textarea class="formInput" id="content" name="content" style="width:360px;height:120px;"></textarea></td>
  </tr>
<?php if (! $this->_tpl_vars['Config']['verify_code_close']): ?>
  <tr class="alt1">
    <td class="text_right">验证码</td>
    <td><input type="text" id="vcode" name="vcode" class="formInput" size="4" maxlength="4" /><img id="vimg" src="vimg.php?n=report" align="absmiddle" alt="图片验证码" />(<a href="javascript:void(0);" onclick="imgRefresh('report'); return false;">看不清,换一张</a>)</td>
  </tr>
<?php endif; ?>
  <tr class="tfooter text_center">
    <td colspan="2"><input type="submit" id="submit" class="formButton" value="  提 交  " /></td>
  </tr>
</table>
</form>
</div>

</div>
</div>

</body>
</html>