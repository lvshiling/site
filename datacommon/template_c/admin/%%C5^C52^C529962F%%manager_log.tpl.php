<?php /* Smarty version 2.6.19, created on 2011-04-01 13:00:27
         compiled from manager_log.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'cycle', 'manager_log.tpl', 34, false),array('modifier', 'date_format', 'manager_log.tpl', 37, false),array('modifier', 'default', 'manager_log.tpl', 44, false),)), $this); ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "header.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

<div class="tip clear">
<li>不能删除七天以内的数据</li>
<li><a href="manager.php?type=log&act=clear">清除多余的数据</a></li>
</div>

<div class="table clear">
<div class="f_nav">
<form name="form2" method="get">
<input type="hidden" name="type" value="log" />
查找管理日志:
<input type="text" class="formInput" name="keyword" maxlength="100" />
<input type="submit" class="formButton" id="submit" accessKey="s" value=" 查找(S) " />
</form>
</div>
</div>

<div class="table">
<form name="form1" method="post">
<table class="list_style" cellpadding="0" cellspacing="0" border="1" frame="void">
  <tr>
    <td colspan="10" class="theader">管理日志(共&nbsp;<?php echo $this->_tpl_vars['totalnum']; ?>
&nbsp;条记录)</td>
  </tr>
  <tr class="tcat text_center">
	<td width="10%" nowrap="nowrap">管理员</td>
	<td width="*" nowrap="nowrap">动作</td>
    <td width="15%" nowrap="nowrap">日期</td>
    <td width="15%" nowrap="nowrap">IP地址</td>
	<td width="5%" nowrap="nowrap"></td>
  </tr>
<?php if ($this->_tpl_vars['LogData']): ?>
<?php $_from = $this->_tpl_vars['LogData']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['row']):
?>
  <tr id="row_<?php echo $this->_tpl_vars['key']; ?>
" onclick="setPointer(this, <?php echo $this->_tpl_vars['key']; ?>
, 'click');" class="alt<?php echo smarty_function_cycle(array('values' => '1,2'), $this);?>
" height="18" align="center">
    <td nowrap="nowrap"><a href="manager.php?type=log&id=<?php echo $this->_tpl_vars['row']['manager_id']; ?>
"><?php echo $this->_tpl_vars['row']['manager_name']; ?>
</a></td>
    <td align="left"><?php echo $this->_tpl_vars['row']['action']; ?>
</td>
    <td nowrap="nowrap"><?php echo ((is_array($_tmp=$this->_tpl_vars['row']['dateline'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%Y-%m-%d %H:%M:%S") : smarty_modifier_date_format($_tmp, "%Y-%m-%d %H:%M:%S")); ?>
</td>
    <td nowrap="nowrap"><?php echo $this->_tpl_vars['row']['client_ip']; ?>
</td>
    <td nowrap="nowrap"><?php if ($this->_tpl_vars['ValidDelTime'] > $this->_tpl_vars['row']['dateline']): ?><input id="mark_box_<?php echo $this->_tpl_vars['key']; ?>
" name="data_id[]" type="checkbox" value="<?php echo $this->_tpl_vars['row']['log_id']; ?>
" /><?php endif; ?></td>
  </tr>
<?php endforeach; endif; unset($_from); ?>
  <tr>
	<td colspan="5" class="tcat text_left">
	<div class="left" style="padding-top:4px;"><?php echo ((is_array($_tmp=@$this->_tpl_vars['multipage'])) ? $this->_run_mod_handler('default', true, $_tmp, "只有一页") : smarty_modifier_default($_tmp, "只有一页")); ?>
</div>
	<div class="right">
	<input type="button" value="全选" onclick='selectAll(true);' />
    <input type="button" value="全不选" onclick='selectAll(false);' />
    <input type="button" value="反选" onclick='againstSelect();' />
	<select name="op" onchange="executeOperate();">
	<option value="">将选中项</option>
	<option value="delete">删除</option>
	</select>
	</div>
	</td>
  </tr>
<?php else: ?>
  <tr height="18">
	<td colspan="5" class="alt1 text_center">没有匹配的日志记录！[<a href="javascript:history.back();">返回上一页</a>]</td>
  </tr>
<?php endif; ?>
</table>
</form>
</div>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "footer.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>