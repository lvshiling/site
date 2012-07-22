<?php /* Smarty version 2.6.19, created on 2012-07-20 14:34:01
         compiled from user_search.tpl */ ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "header.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<script type="text/javascript" src="javascripts/calendar.js"></script>

<div class="tip">不指定搜索条件则显示全部数据</div>

<div class="table">
<form name="form1" method="get" action="user.php">
<input type="hidden" name="act" value="list" />
<table class="list_style" cellpadding="0" cellspacing="0" border="1" frame="void">
  <tr><td colspan="2" class="theader">用户搜索</td></tr>
  <tr class="alt1">
	<td align="right" width="30%">用户名</td>
    <td width="70%"><input type="text" class="formInput" name="name" size="30" maxlength="50" /><label><input type="checkbox" name="dark_match" value="1" />模糊匹配</label></td>
  </tr>
  <tr class="alt2">
	<td align="right">Email验证</td>
    <td><select name="validate_email">
	<option value=""></option>
	<option value="1">已验证</option>
	<option value="0">未验证</option>
	</select></td>
  </tr>
  <tr class="alt2">
	<td align="right">IP激活数</td>
    <td><select name="ipqualifier">
	<option value=""></option>
	<option value="gt">大于</option>
	<option value="eq">等于</option>
	<option value="lt">小于</option>
	</select><input type="text" name="validate_ip" size="10" maxlength="5" /><br /><span class="form_clue">当前设置为激活需要IP数:<?php echo $this->_tpl_vars['Config']['validate_ip']; ?>
</span></td>
  </tr>
  <tr class="alt1">
	<td align="right">加入日期</td>
    <td><select name="datequalifier">
	<option value=""></option>
	<option value="gt">大于</option>
	<option value="eq">等于</option>
	<option value="lt">小于</option>
	</select><input type="text" id="join_date" name="join_date" readonly="readonly" size="10" maxlength="10" onclick='showCalendar(this, $("join_date"), "yyyy-mm-dd", null, 0, -1, -1);' /></td>
  </tr>
  <tr class="alt2">
	<td align="right">显示结果按</td>
    <td><select><option value="">加入日期</option></select><select name="order"><option value="desc">降序排列</option><option value="asc">升序排列</option></select></td>
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