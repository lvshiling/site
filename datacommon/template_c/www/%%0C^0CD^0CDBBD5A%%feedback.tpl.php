<?php /* Smarty version 2.6.19, created on 2011-04-02 14:20:41
         compiled from feedback.tpl */ ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "header.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

<div class="other_info">

<div class="table clear">
<script type="text/javascript">
function checkFormData()
{
	if ('' != $F('contact'))
	{
		if (100 < cnLength($F('contact')))
		{
			alert('有这么长的联系方式吗？');
			return false;
		}
	}
	if ('' == $F('content'))
	{
		alert('没有填写反馈信息！');
		$('content').focus();
		return false;
	}
	if (1000 < cnLength($F('content')))
	{
		alert('反馈信息长度不能超过1000个字符！');
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
<div class="nav_title clear text_bold"><?php echo $this->_tpl_vars['SiteTitle']; ?>
</div>
<table class="list_style">
  <tr class="alt1">
    <td class="text_right" width="15%">联系方式</td>
    <td width="85%"><input class="formInput" id="contact" name="contact" size="50" maxlength="100" /><br /><span class="form_clue">留下您的联系方式，以便我们能更即时处理您的问题</span></td>
  </tr>
  <tr class="alt2">
    <td class="text_right" valign="top">反馈信息</td>
    <td>
	<div class="left"><textarea class="formInput" id="content" name="content" style="width:360px;height:120px;"></textarea></div>
	<div class="right" style="width:430px;border:1px solid #ccc;line-height:160%;padding:3px;">这里可以放一些提示信息</div>
	</td>
  </tr>
<?php if (! $this->_tpl_vars['Config']['verify_code_close']): ?>
  <tr class="alt2">
    <td class="text_right">验证码</td>
    <td><input type="text" id="vcode" name="vcode" class="formInput" size="4" maxlength="4" /><img id="vimg" src="vimg.php?n=feedback" align="absmiddle" alt="图片验证码" />(<a href="javascript:void(0);" onclick="imgRefresh('feedback'); return false;">看不清,换一张</a>)</td>
  </tr>
<?php endif; ?>
  <tr class="tfooter text_center">
    <td colspan="2"><input type="submit" id="submit" class="formButton" value="  提 交  " /></td>
  </tr>
</table>
</form>
</div>

</div>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "footer.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>