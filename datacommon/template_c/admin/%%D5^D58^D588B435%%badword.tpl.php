<?php /* Smarty version 2.6.19, created on 2011-04-01 13:00:35
         compiled from badword.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'cycle', 'badword.tpl', 23, false),)), $this); ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "header.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

<div class="table clear">
<div class="f_nav">
<form name="form1" method="post" onsubmit="return checkFormData();">
<input type="hidden" name="op" value="add" />
添加屏蔽关键字:
<input type="text" class="formInput" name="word" size="20" maxlength="20" />&nbsp;<input type="submit" class="formButton" id="submit" accessKey="s" value=" 添加(S) " />
</form>
</div>
</div>

<div class="table clear">
<table class="list_style" cellpadding="0" cellspacing="0" border="1" frame="void">
  <tr>
    <td class="theader" colspan="10">已添加的屏蔽关键字</td>
  </tr>
  <tr class="tcat text_center">
	<td width="*">关键字</td>
	<td width="20%">操作</td>
  </tr>
<?php $_from = $this->_tpl_vars['Badword']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['row']):
?>
  <tr id="row_<?php echo $this->_tpl_vars['key']; ?>
" onclick="setPointer(this, <?php echo $this->_tpl_vars['key']; ?>
, 'click');" class="alt<?php echo smarty_function_cycle(array('values' => '1,2'), $this);?>
" height="18" align="center">
    <td nowrap="nowrap"><?php echo $this->_tpl_vars['row']['badword_name']; ?>
</td>
    <td nowrap="nowrap"><a href="badword.php?act=edit&id=<?php echo $this->_tpl_vars['row']['badword_id']; ?>
"><img src="images/icon_edit.gif" title="编辑" /></a><a href="badword.php?act=delete&id=<?php echo $this->_tpl_vars['row']['badword_id']; ?>
" onclick="return confirm('确定要删除该关键字？');"><img src="images/icon_delete.gif" title="删除" /></a></td>
  </tr>
<?php endforeach; else: ?>
  <tr height="18" class="alt1 text_center">
    <td nowrap="nowrap" colspan="2">没有添加任何屏蔽关键字！</td>
  </tr>
<?php endif; unset($_from); ?>
</table>
</div>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "footer.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>