<?php /* Smarty version 2.6.19, created on 2011-04-01 12:59:52
         compiled from merger.tpl */ ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "header.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

<div class="table">
<form name="form1" method="post" action="merger.php" onsubmit="return checkFormData();">
<input type="hidden" name="op" value="sort" />
<table class="list_style" cellpadding="0" cellspacing="0" border="1" frame="void">
  <tr><td colspan="2" class="theader">合并分类数据</td></tr>
  <tr class="alt1">
	<td align="right" width="30%">原分类</td>
    <td width="70%"><select id="origin_sort_id" name="origin_sort_id"><option value="0">请选择</option><?php echo $this->_tpl_vars['OriginSortOption']; ?>
</select></td>
  </tr>
  <tr class="alt2">
	<td align="right">目标分类</td>
    <td><select id="aim_sort_id" name="aim_sort_id"><option value="0">请选择</option><?php echo $this->_tpl_vars['AimSortOption']; ?>
</select></td>
  </tr>
  <tr>
    <td colspan="2" class="tfoot text_center">
	<input type="submit" class="formButton" accesskey="s" id="submit" value=" 开始合并分类(S) " />
	<input type="reset" class="formButton" accesskey="r" value="重置(R)" />
	</td>
  </tr>
</table>
</form>
</div>

<div class="table">
<form name="form3" method="post" action="merger.php" onsubmit="return checkFormData();">
<input type="hidden" name="op" value="user" />
<table class="list_style" cellpadding="0" cellspacing="0" border="1" frame="void">
  <tr><td colspan="2" class="theader">合并用户数据</td></tr>
  <tr class="alt1">
	<td align="right" width="30%">原用户数字ID</td>
    <td width="70%"><input type="text" class="formInput" name="origin_user_id" size="10" maxlength="10" /></td>
  </tr>
  <tr class="alt2">
	<td align="right">目标用户数字ID</td>
    <td><input type="text" class="formInput" name="aim_user_id" size="10" maxlength="10" /></td>
  </tr>
  <tr>
    <td colspan="2" class="tfoot text_center">
	<input type="submit" class="formButton" id="submit" accessKey="s" value=" 开始合并用户(S) " />
	<input class="formButton" accessKey="r" type="reset" value="重置(R)" />
	</td>
  </tr>
</table>
</form>
</div>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "footer.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>