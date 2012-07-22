<?php /* Smarty version 2.6.19, created on 2011-04-01 14:01:22
         compiled from manager_post.tpl */ ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "header.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

<div class="table clear">
<div class="f_nav">
<input type="button" value="添加管理员" onclick="window.location='manager.php?type=manager&act=add'" class="formButton" />
<input type="button" value="管理员列表" onclick="window.location='manager.php?type=manager'" class="formButton" />
</div>
</div>

<div class="table clear">
<form name="form1" method="post" action="manager.php?type=manager" onsubmit="return checkFormData();">
<input type="hidden" name="op" value="<?php echo $this->_tpl_vars['Action']; ?>
" />
<input type="hidden" name="id" value="<?php echo $this->_tpl_vars['Manager']['manager_id']; ?>
" />
<table class="list_style" cellpadding="0" cellspacing="0" border="1" frame="void">
  <tr><td colspan="2" class="theader"><?php if ($this->_tpl_vars['Action'] == 'edit'): ?>编辑<?php else: ?>添加<?php endif; ?>管理员</td></tr>
  <tr class="alt1">
	<td align="right" width="30%">用户名</td>
    <td width="70%"><input type="text" class="formInput" name="username" size="30" maxlength="50" value="<?php echo $this->_tpl_vars['Manager']['manager_name']; ?>
" /></td>
  </tr>
  <tr class="alt2">
	<td align="right">登录密码</td>
    <td><input type="password" class="formInput" name="password" size="30" maxlength="50" /><br /><span class="form_clue">密码最少4个字符，只能由英文、数字和下划线组成<?php if ($this->_tpl_vars['Action'] == 'edit'): ?>。如果不修改密码此项请留空<?php endif; ?></span></td>
  </tr>
</table>

<table class="list_style" cellpadding="0" cellspacing="0" border="1" frame="void">
  <tr><td colspan="2" class="theader">权限分配</td></tr>
  <tr class="alt1">
	<td align="right" width="30%">允许登录</td>
    <td width="70%"><input type="radio" name="can_login" value="1" <?php if ($this->_tpl_vars['Manager']['can_login']): ?>checked="checked"<?php endif; ?> />允许&nbsp;<input type="radio" name="can_login" value="0" <?php if (! $this->_tpl_vars['Manager']['can_login']): ?>checked="checked"<?php endif; ?> />禁止</td>
  </tr>
  <tr class="alt2">
	<td align="right">是超级管理员</td>
    <td><input type="checkbox" name="is_super_manager" value="1" <?php if ($this->_tpl_vars['Manager']['is_super_manager']): ?>checked="checked"<?php endif; ?> /><br /><span class="form_clue">超级管理员可以管理后台所有内容，请不要随意赋予此权限</span></td>
  </tr>
  <tr class="alt1">
	<td align="right">允许管理发布内容</td>
    <td><input type="radio" name="can_manage_data" value="1" <?php if ($this->_tpl_vars['Manager']['can_manage_data']): ?>checked="checked"<?php endif; ?> />允许&nbsp;<input type="radio" name="can_manage_data" value="0" <?php if (! $this->_tpl_vars['Manager']['can_manage_data']): ?>checked="checked"<?php endif; ?> />禁止</td>
  </tr>
  <tr class="alt2">
	<td align="right">允许管理内容分类</td>
    <td><input type="radio" name="can_manage_sort" value="1" <?php if ($this->_tpl_vars['Manager']['can_manage_sort']): ?>checked="checked"<?php endif; ?> />允许&nbsp;<input type="radio" name="can_manage_sort" value="0" <?php if (! $this->_tpl_vars['Manager']['can_manage_sort']): ?>checked="checked"<?php endif; ?> />禁止</td>
  </tr>
  <tr class="alt1">
	<td align="right">允许管理用户</td>
    <td><input type="radio" name="can_manage_user" value="1" <?php if ($this->_tpl_vars['Manager']['can_manage_user']): ?>checked="checked"<?php endif; ?> />允许&nbsp;<input type="radio" name="can_manage_user" value="0" <?php if (! $this->_tpl_vars['Manager']['can_manage_user']): ?>checked="checked"<?php endif; ?> />禁止</td>
  </tr>
  <tr>
    <td colspan="2" class="tfoot text_center">
	<input type="submit" class="formButton" accesskey="s" id="submit" value=" <?php if ($this->_tpl_vars['Action'] == 'edit'): ?>编辑<?php else: ?>添加<?php endif; ?>(S) " />
	<input type="reset" class="formButton" accesskey="r" value="重置(R)" />
	<input type="button" class="formButton" accesskey="n" value=" 返回(N) " onclick='javascript:history.back();' />
<?php if ($this->_tpl_vars['Action'] == 'edit'): ?>
	<input class="formButton" type="button" style="color:red;" onclick="deleteConfirm(<?php echo $this->_tpl_vars['Manager']['manager_id']; ?>
);" value="删除" />
<?php endif; ?>
	</td>
  </tr>
</table>
</form>
</div>

<script type="text/javascript">
function checkFormData()
{
	if (true == document.form1.is_super_manager.checked)
	{
		if (false == confirm('确定添加为超级管理员？'))
		{
			return false;
		}
	}

	$('submit').value = Lang['submit'];
	$('submit').disabled = true;
	return true;
}
function deleteConfirm(id)
{
	if (false == confirm('确定要删除这个管理员？'))
	{
		return false;
	}

	location.href = 'manager.php?type=manager&act=delete&id='+ id;
}
</script>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "footer.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>