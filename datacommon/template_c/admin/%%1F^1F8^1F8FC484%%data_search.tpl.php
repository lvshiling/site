<?php /* Smarty version 2.6.19, created on 2011-04-01 12:59:38
         compiled from data_search.tpl */ ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "header.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

<div class="tip">不指定搜索条件则显示所有发表内容</div>

<div class="table">
<form name="form1" method="get" action="data.php" onsubmit="return checkFormData();">
<input type="hidden" name="act" value="list" />
<table class="list_style" cellpadding="0" cellspacing="0" border="1" frame="void">
  <tr><td colspan="2" class="theader">搜索发表内容</td></tr>
  <tr class="alt1">
	<td align="right" width="30%">
	<select name="bound">
	<option value="title">内容标题</option>
	<option value="content">内容正文</option>
	<option value="all">标题和正文</option>
	</select>包含</td>
    <td width="70%"><input type="text" class="formInput" name="keyword" size="40" /></td>
  </tr>
  <tr class="alt2">
	<td align="right">所属分类</td>
    <td><select name="sort_id"><option value="">所有分类</option><?php echo $this->_tpl_vars['SortOption']; ?>
</select></td>
  </tr>
  <tr class="alt1">
	<td align="right">发表用户ID/用户名</td>
    <td><input type="text" class="formInput" name="user_id" size="10" /></td>
  </tr>
  <tr class="alt2">
	<td align="right">是否审核</td>
    <td><input type="radio" name="auditing" value="all" checked="checked" />任意&nbsp;<input type="radio" name="auditing" value="1" />是&nbsp;<input type="radio" name="auditing" value="0" />否</td>
  </tr>
  <tr class="alt1">
	<td align="right">显示结果按照</td>
    <td><select name="by"><option value="rdate">发表日期</option><option value="edate">最后修改日期</option></select><select name="order"><option value="desc">降序排列</option><option value="asc">升序排列</option></select></td>
  </tr>
  <tr>
    <td colspan="2" class="tfoot text_center">
	<input type="submit" class="formButton" accesskey="s" id="submit" value=" 显示结果(S) " />
	<input type="reset" class="formButton" accesskey="r" value="重置(R)" />
	<input type="button" class="formButton" accesskey="n" value=" 返回(N) " onclick='javascript:history.back();' />
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