<?php /* Smarty version 2.6.19, created on 2011-04-01 13:45:57
         compiled from list_multipage.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'cycle', 'list_multipage.tpl', 25, false),array('modifier', 'date_format', 'list_multipage.tpl', 27, false),)), $this); ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "header.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

<div class="table clear">
<div class="nav_title s">
<div class="left"><h1 class="striking">
<?php if ($this->_tpl_vars['ID'] || @IN_SCRIPT == 'search'): ?>
<?php echo $this->_tpl_vars['SiteTitle']; ?>
<?php if ($this->_tpl_vars['Totalnum']): ?>(<?php echo $this->_tpl_vars['Totalnum']; ?>
)<?php endif; ?>
<?php else: ?>
最新发布：分享前<?php echo $this->_tpl_vars['Config']['pagination_list_num']; ?>
个资源
<?php endif; ?>
</h1></div>
</div>
<div class="clear">
<table id="listTable" class="list_style table_fixed">
  <thead class="tcat">
	<?php if ($this->_tpl_vars['Data'][0]['sort_name']): ?><th class="l3">类别</th><?php endif; ?>
    <th class="l1">发表日期</th>
    <th class="l2">标题</th>
    <th class="l3">发表会员</th>
  </thead>
  <tbody class="tbody">
<?php $_from = $this->_tpl_vars['Data']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['row']):
?>
  <tr class="alt<?php echo smarty_function_cycle(array('values' => '1,2'), $this);?>
" onmouseover="highlight(this);">
	<?php if ($this->_tpl_vars['row']['sort_name']): ?><td><a href="<?php echo @SITE_ROOT_PATH; ?>
/sort-<?php echo $this->_tpl_vars['row']['sort_id']; ?>
-1.html"><?php echo $this->_tpl_vars['row']['sort_name']; ?>
</a></td><?php endif; ?>
    <td nowrap="nowrap"><?php echo ((is_array($_tmp=$this->_tpl_vars['row']['release_date'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%Y/%m/%d %H:%M") : smarty_modifier_date_format($_tmp, "%Y/%m/%d %H:%M")); ?>
</td>
    <td class="text_left"><a href="<?php echo $this->_tpl_vars['row']['show_url']; ?>
" target="_blank"><?php echo $this->_tpl_vars['row']['data_title']; ?>
</a></td>
    <td class="author"><?php echo $this->_tpl_vars['row']['user_name']; ?>
</td>
  </tr>
<?php endforeach; else: ?>
  <tr class="alt1 text_center">
    <td colspan="3">没有可显示数据</td>
  </tr>
<?php endif; unset($_from); ?>
  </tbody>
</table>
</div>
</div>

<?php if ($this->_tpl_vars['Multipage']['page']): ?><div class="pages clear"><?php echo $this->_tpl_vars['Multipage']['page']; ?>
</div><?php endif; ?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "footer.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>