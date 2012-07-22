<?php /* Smarty version 2.6.19, created on 2011-04-01 12:47:16
         compiled from login.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'urlencode', 'login.tpl', 6, false),)), $this); ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "header.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

<div class="table" style="width:380px;margin:60px auto 0 auto;">
<form name="form1" action="index.php" method="post">
<input type="hidden" name="op" value="login" />
<input type="hidden" name="url" value="<?php echo ((is_array($_tmp=@CURRENT_URL)) ? $this->_run_mod_handler('urlencode', true, $_tmp) : urlencode($_tmp)); ?>
" />
<table class="list_style" cellpadding="0" cellspacing="0" border="1" frame="void">
  <tr><td colspan="2" class="theader text_bold"><img src="images/icon_login.gif" />&nbsp;管理员登录</td></tr>
  <tr class="alt1">
    <td class="text_right" width="120">用户名</td>
    <td width="230"><input type="text" id="username" name="username" class="formInput" size="25" maxlength="30" /></td>
  </tr>
  <tr class="alt2">
    <td class="text_right">密&nbsp;&nbsp;码</td>
    <td><input type="password" name="password" class="formInput" size="25" /></td>
  </tr>
<?php if (! $this->_tpl_vars['Config']['verify_code_close']): ?>
  <tr class="alt1">
    <td class="text_right">验证码</td>
    <td><input type="text" name="vcode" class="formInput" size="4" maxlength="4" /><img src="vimg.php?n=mlogin" align="absmiddle" alt="图片验证码" /></td>
  </tr>
<?php endif; ?>
  <tr>
    <td class="tfoot text_center" colspan="2"><input type="submit" id="submit" class="formButton" value=" 登 录 " /></td>
  </tr>
</table>
</form>
</div>

<script type="text/javascript">
$('username').focus();
</script>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "footer.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>