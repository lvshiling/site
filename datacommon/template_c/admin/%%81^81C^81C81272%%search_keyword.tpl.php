<?php /* Smarty version 2.6.19, created on 2011-04-01 13:02:46
         compiled from search_keyword.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'cycle', 'search_keyword.tpl', 27, false),array('modifier', 'default', 'search_keyword.tpl', 35, false),)), $this); ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "header.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

<div class="table clear">
<div class="f_nav">
<form name="form2" onsubmit="return checkFormData();">
<input type="hidden" name="act" value="keyword" />
热门搜索关键字:
<input type="text" class="formInput" name="keyword" size="20" maxlength="20" />&nbsp;<input type="submit" class="formButton" id="submit" accessKey="s" value=" 查找(S) " />
<input type="button" class="formButton" value=" 更新缓存 " onclick="window.location.href='search.php?act=force_update'" />
</form>
</div>
</div>

<div class="table clear">
<form name="form1" method="post">
<table class="list_style" cellpadding="0" cellspacing="0" border="1" frame="void">
  <tr>
    <td class="theader" colspan="10">热门搜索关键字(共 <?php echo $this->_tpl_vars['totalnum']; ?>
 条记录)</td>
  </tr>
  <tr class="tcat text_center">
	<td width="50">操作</td>
	<td width="80%">关键字</td>
	<td width="15%">搜索次数</td>
  </tr>
<?php if ($this->_tpl_vars['KeywordData']): ?>
<?php $_from = $this->_tpl_vars['KeywordData']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['row']):
?>
  <tr id="row_<?php echo $this->_tpl_vars['key']; ?>
" onclick="setPointer(this, <?php echo $this->_tpl_vars['key']; ?>
, 'click', 1);" class="alt<?php echo smarty_function_cycle(array('values' => '1,2'), $this);?>
" height="18" align="center">
    <td width="50"><input id="mark_box_<?php echo $this->_tpl_vars['key']; ?>
" name="data_id[]" type="checkbox" value="<?php echo $this->_tpl_vars['row']['search_keyword']; ?>
" /></td>
    <td nowrap="nowrap"><?php echo $this->_tpl_vars['row']['search_keyword']; ?>
</td>
    <td><?php echo $this->_tpl_vars['row']['search_num']; ?>
</td>
  </tr>
<?php endforeach; endif; unset($_from); ?>
  <tr>
	<td colspan="10" class="tcat text_left">
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
  <tr height="18" class="alt1 text_center">
    <td nowrap="nowrap" colspan="2">没有相关搜索关键字</td>
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