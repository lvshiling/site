<?php /* Smarty version 2.6.19, created on 2011-04-01 12:59:56
         compiled from sort_list.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'default', 'sort_list.tpl', 18, false),)), $this); ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "header.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

<div class="table clear">
<div class="f_nav">
<input type="button" value="添加分类" onclick="window.location='sort.php?act=add'" class="formButton" />
<input type="button" value="分类列表" onclick="window.location='sort.php'" class="formButton" />
<input type="button" value="更新分类缓存" onclick="window.location='sort.php?act=build_cache'" class="formButton" />
</div>
</div>

<div class="table clear">
<form action="sort.php" method="post">
<input type="hidden" name="op" value="order" />
<table class="list_style" cellpadding="0" cellspacing="0" border="1" frame="void">
  <tr>
    <td colspan="10" class="theader">已添加分类</td>
  </tr>
  <tr class="alt1" align="left"><td class="sort_list"><?php echo ((is_array($_tmp=@$this->_tpl_vars['SortData'])) ? $this->_run_mod_handler('default', true, $_tmp, "还没有添加任何分类！") : smarty_modifier_default($_tmp, "还没有添加任何分类！")); ?>
</td></tr>
  <tr><td class="tfoot text_center"><input type="submit" class="formButton" value="保存分类顺序" /></td></tr>
</table>
</form>
</div>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "footer.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>