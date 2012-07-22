<?php /* Smarty version 2.6.19, created on 2011-04-02 17:15:44
         compiled from user_post.tpl */ ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "header.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

<div class="table clear">
<form name="form1" method="post" onsubmit="return checkFormData();">
<input type="hidden" name="op" value="<?php echo $this->_tpl_vars['Action']; ?>
" />
<?php if ($this->_tpl_vars['Action'] == 'edit'): ?><input type="hidden" name="id" value="<?php echo $this->_tpl_vars['UserData']['user_id']; ?>
" /><?php endif; ?>
<table class="list_style" cellpadding="0" cellspacing="0" border="1" frame="void">
  <tr><td colspan="2" class="theader"><?php if ($this->_tpl_vars['Action'] == 'edit'): ?>编辑<?php else: ?>添加本地<?php endif; ?>发布用户</td></tr>
  <tr class="alt1">
	<td align="right" width="30%">登录用户名</td>
    <td width="70%"><input type="text" class="formInput" name="username" size="30" maxlength="12" value="<?php echo $this->_tpl_vars['UserData']['user_name']; ?>
" /><br /><span class="form_clue">长度在4 - 12个字符以内</span></td>
  </tr>
  <tr class="alt2">
	<td align="right">登录密码</td>
    <td><input type="text" class="formInput" name="password" size="30" maxlength="100" /><br /><span class="form_clue">密码长度不少于4个字符<?php if ($this->_tpl_vars['Action'] == 'edit'): ?>，不修改密码请留空<?php endif; ?></span></td>
  </tr>
  <tr class="alt1">
	<td align="right">电子邮件</td>
    <td><input type="text" class="formInput" name="email" size="30" maxlength="100" value="<?php echo $this->_tpl_vars['UserData']['user_email']; ?>
" /></td>
  </tr>
</table>
<table class="list_style" cellpadding="0" cellspacing="0" border="1" frame="void">
  <tr><td colspan="2" class="theader">用户权限</td></tr>
  <tr class="alt1">
	<td align="right" width="30%">允许发表内容</td>
    <td><input type="radio" name="can_add" value="1"<?php if ($this->_tpl_vars['UserData']['can_add']): ?> checked="checked"<?php endif; ?> />是&nbsp;<input type="radio" name="can_add" value="0"<?php if (! $this->_tpl_vars['UserData']['can_add']): ?> checked="checked"<?php endif; ?> />否</td>
  </tr>
  <tr class="alt2">
	<td align="right">允许编辑自己发表的</td>
    <td><input type="radio" name="can_edit" value="1"<?php if ($this->_tpl_vars['UserData']['can_edit']): ?> checked="checked"<?php endif; ?> />是&nbsp;<input type="radio" name="can_edit" value="0"<?php if (! $this->_tpl_vars['UserData']['can_edit']): ?> checked="checked"<?php endif; ?> />否</td>
  </tr>
  <tr class="alt1">
	<td align="right">允许删除自己发表的</td>
    <td><input type="radio" name="can_delete" value="1"<?php if ($this->_tpl_vars['UserData']['can_delete']): ?> checked="checked"<?php endif; ?> />是&nbsp;<input type="radio" name="can_delete" value="0"<?php if (! $this->_tpl_vars['UserData']['can_delete']): ?> checked="checked"<?php endif; ?> />否</td>
  </tr>
<?php if ($this->_tpl_vars['Action'] == 'edit'): ?>
  <tr class="alt2">
	<td align="right">Email验证</td>
    <td><label><input type="radio" name="validate_email" value="1"<?php if ($this->_tpl_vars['UserData']['validate_email']): ?> checked="checked"<?php endif; ?> />已验证</label>&nbsp;<label><input type="radio" name="validate_email" value="0"<?php if (! $this->_tpl_vars['UserData']['validate_email']): ?> checked="checked"<?php endif; ?> />未验证</label></td>
  </tr>
  <tr class="alt1">
	<td align="right">IP验证</td>
    <td><label><?php if ($this->_tpl_vars['UserData']['validate_ip'] >= $this->_tpl_vars['Config']['validate_ip']): ?><input type="hidden" name="validate_ip" value="1" /><?php else: ?><input type="checkbox" name="validate_ip" value="1" /><?php endif; ?>已验证</label></td>
  </tr>
<?php endif; ?>
</table>
<table class="list_style" cellpadding="0" cellspacing="0" border="1" frame="void">
  <tr>
    <td colspan="2" class="tfoot text_center">
	<input type="submit" class="formButton" accesskey="s" id="submit" value=" <?php if ($this->_tpl_vars['Action'] == 'edit'): ?>编辑<?php else: ?>添加<?php endif; ?>(S) " />
	<input type="reset" class="formButton" accesskey="r" value="重置(R)" />
	<input type="button" class="formButton" accesskey="n" value=" 返回(N) " onclick='javascript:history.back();' />
<?php if ($this->_tpl_vars['Action'] == 'edit'): ?>
	<input type="button" class="formButton" style="color:red;" onclick="deleteConfirm(<?php echo $this->_tpl_vars['UserData']['user_id']; ?>
);" value="删除" />
<?php endif; ?>
	</td>
  </tr>
</table>
</form>
</div>

<script type="text/javascript">
function deleteConfirm(id)
{
	if (false == confirm('确定要删除这个用户？'))
	{
		return false;
	}

	location.href = 'user.php?act=delete&id='+ id;
}
</script>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "footer.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>