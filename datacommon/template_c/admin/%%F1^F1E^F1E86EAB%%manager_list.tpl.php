<?php /* Smarty version 2.6.19, created on 2011-04-01 13:00:09
         compiled from manager_list.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'cycle', 'manager_list.tpl', 22, false),array('modifier', 'date_format', 'manager_list.tpl', 24, false),array('modifier', 'default', 'manager_list.tpl', 29, false),)), $this); ?>
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
<table class="list_style" cellpadding="0" cellspacing="0" border="1" frame="void">
  <tr>
    <td colspan="10" class="theader">现有管理员(共&nbsp;<?php echo $this->_tpl_vars['totalnum']; ?>
&nbsp;个)</td>
  </tr>
  <tr class="tcat text_center">
	<td width="50%" nowrap="nowrap">管理员</td>
    <td width="30%">添加日期</td>
	<td width="20%" nowrap="nowrap"></td>
  </tr>
<?php if ($this->_tpl_vars['ManagerData']): ?>
<?php $_from = $this->_tpl_vars['ManagerData']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['row']):
?>
  <tr id="row_<?php echo $this->_tpl_vars['key']; ?>
" onclick="setPointer(this, <?php echo $this->_tpl_vars['key']; ?>
, 'click');" class="alt<?php echo smarty_function_cycle(array('values' => '1,2'), $this);?>
" height="18" align="center">
    <td nowrap="nowrap"><a href="manager.php?type=log&id=<?php echo $this->_tpl_vars['row']['manager_id']; ?>
"<?php if ($this->_tpl_vars['row']['is_super_manager']): ?> class="text_red"<?php endif; ?>><?php echo $this->_tpl_vars['row']['manager_name']; ?>
</td>
    <td nowrap="nowrap"><?php echo ((is_array($_tmp=$this->_tpl_vars['row']['dateline'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%Y-%m-%d %H:%M:%S") : smarty_modifier_date_format($_tmp, "%Y-%m-%d %H:%M:%S")); ?>
</td>
    <td nowrap="nowrap"><a href="manager.php?type=manager&act=edit&id=<?php echo $this->_tpl_vars['row']['manager_id']; ?>
"><img src="images/icon_edit.gif" title="编辑" /></a><a href="manager.php?type=manager&act=delete&id=<?php echo $this->_tpl_vars['row']['manager_id']; ?>
" onclick="return confirm('确定要删除这个管理员？');"><img src="images/icon_delete.gif" title="删除" /></a></td>
  </tr>
<?php endforeach; endif; unset($_from); ?>
  <tr height="18">
	<td colspan="3" class="tcat text_left"><?php echo ((is_array($_tmp=@$this->_tpl_vars['multipage'])) ? $this->_run_mod_handler('default', true, $_tmp, "只有一页") : smarty_modifier_default($_tmp, "只有一页")); ?>
</td>
  </tr>
<?php else: ?>
  <tr height="18">
	<td colspan="3" class="alt1 text_center">没有匹配的日志记录！[<a href="javascript:history.back();">返回上一页</a>]</td>
  </tr>
<?php endif; ?>
</table>
</div>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "footer.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>