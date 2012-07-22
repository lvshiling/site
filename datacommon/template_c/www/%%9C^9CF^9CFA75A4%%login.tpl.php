<?php /* Smarty version 2.6.19, created on 2011-04-02 14:19:02
         compiled from user/login.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'urlencode', 'user/login.tpl', 39, false),)), $this); ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "header.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

<div class="table" style="width:480px;margin:0 auto;">
<?php if ($this->_tpl_vars['LoginNotice'] != ""): ?>
<div class="text_center text_red text_bold" style="margin: 10px;">*<?php echo $this->_tpl_vars['LoginNotice']; ?>
</div>
<?php endif; ?>
<div class="nav_title text_bold"><img src="<?php echo $this->_tpl_vars['Config']['domain_static']; ?>
/images/icon_login.gif" align="absmiddle" /> 登录网站</div>
<script type="text/javascript">
var use_v_code = <?php if (! $this->_tpl_vars['Config']['verify_code_close']): ?>true<?php else: ?>false<?php endif; ?>;
function checkFormData()
{
	if ('' == $F('username').trim())
	{
		alert('请输入登录用户名！');
		$('username').focus();
		return false;
	}
	if ('' == $F('password').trim())
	{
		alert('请输入登录密码！');
		$('password').focus();
		return false;
	}
	if (true == use_v_code && '' == $F('vcode').trim())
	{
		alert('请填写验证码！');
		$('vcode').focus();
		return false;
	}

	$('submit').value = Lang['submit'];
	$('submit').disabled = true;
	return true;
}
</script>
<form name="form1" action="user.php?o=login" method="post" onsubmit="return checkFormData();">
<input type="hidden" name="op" value="login" />
<input type="hidden" name="url" value="<?php echo ((is_array($_tmp=$this->_tpl_vars['GotoURL'])) ? $this->_run_mod_handler('urlencode', true, $_tmp) : urlencode($_tmp)); ?>
" />
<table class="list_style">
  <tr class="alt1">
    <td class="text_right" width="120">用户名</td>
    <td width="*"><input type="text" id="username" name="username" class="formInput" size="25" maxlength="30" /></td>
  </tr>
  <tr class="alt2">
    <td class="text_right">密&nbsp;&nbsp;码</td>
    <td><input type="password" id="password" name="password" class="formInput" size="25" maxlength="30" /></td>
  </tr>
  <tr class="alt1">
    <td class="text_right">登录有效期</td>
    <td><select name="cookietime" class="formInput">
	<option value="0">浏览器进程</option>
	<option value="2592000">保存一月</option>
	<option value="86400">保存一天</option>
	<option value="315360000">永久有效</option>
	</select></td>
  </tr>
<?php if (! $this->_tpl_vars['Config']['verify_code_close']): ?>
  <tr class="alt2">
    <td class="text_right">验证码</td>
    <td><input type="text" name="vcode" class="formInput" size="4" maxlength="4" /><img id="vimg" src="vimg.php?n=login" align="absmiddle" alt="图片验证码" />(<a href="javascript:void(0);" onclick="imgRefresh('login'); return false;">看不清,换一张</a>)</td>
  </tr>
<?php endif; ?>
  <tr class="tfooter text_center">
    <td colspan="2"><input type="submit" id="submit" class="formButton" value=" 登 录 " /><?php if ($this->_tpl_vars['Config']['user_register']): ?>&nbsp;&nbsp;<a href="user.php?o=reg">没有注册？</a><?php endif; ?><?php if ($this->_tpl_vars['Config']['user_register_vemail']): ?>&nbsp;&nbsp;<a href="user.php?o=validate_email">重发验证邮件</a><?php endif; ?></td>
  </tr>
</table>
</form>
</div>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "footer.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>