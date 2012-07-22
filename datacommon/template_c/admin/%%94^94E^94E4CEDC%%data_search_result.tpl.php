<?php /* Smarty version 2.6.19, created on 2011-04-01 12:49:11
         compiled from data_search_result.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'cycle', 'data_search_result.tpl', 20, false),array('modifier', 'date_format', 'data_search_result.tpl', 23, false),array('modifier', 'default', 'data_search_result.tpl', 33, false),)), $this); ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "header.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

<div class="table clear">
<form name="form1" method="post">
<input type="hidden" name="op" value="batch" />
<table class="list_style" cellpadding="0" cellspacing="0" border="1" frame="void">
  <tr>
    <td colspan="10" class="theader">发表内容搜索结果(共&nbsp;<?php echo $this->_tpl_vars['totalnum']; ?>
&nbsp;条记录)</td>
  </tr>
  <tr class="tcat text_center">
	<td width="10"></td>
	<td width="8%">分类</td>
    <td width="*">标题</td>
	<td width="10%">作者</td>
	<td width="10%">审核</td>
	<td width="50">操作</td>
  </tr>
<?php if ($this->_tpl_vars['Data']): ?>
<?php $_from = $this->_tpl_vars['Data']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['row']):
?>
  <tr id="row_<?php echo $this->_tpl_vars['key']; ?>
" onclick="setPointer(this, <?php echo $this->_tpl_vars['key']; ?>
, 'click');" class="alt<?php echo smarty_function_cycle(array('values' => '1,2'), $this);?>
" align="center">
	<td width="10"><input type="checkbox" id="mark_box_<?php echo $this->_tpl_vars['key']; ?>
" name="data_id[]" value="<?php echo $this->_tpl_vars['row']['data_id']; ?>
" /></td>
	<td><a href="data.php?act=list&sort_id=<?php echo $this->_tpl_vars['row']['sort_id']; ?>
"><?php echo $this->_tpl_vars['row']['sort_name']; ?>
</a></td>
    <td align="left" style="line-height:140%;"><?php if ($this->_tpl_vars['row']['is_commend']): ?><span class="list_commend">[荐]</span><?php endif; ?><a href="<?php echo $this->_tpl_vars['row']['show_url']; ?>
" target="_blank"><?php echo $this->_tpl_vars['row']['data_title']; ?>
</a><br /><span class="list_data">发布日期:<?php echo ((is_array($_tmp=$this->_tpl_vars['row']['release_date'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%m-%d %H:%M") : smarty_modifier_date_format($_tmp, "%m-%d %H:%M")); ?>
&nbsp;&nbsp;IP:<?php echo $this->_tpl_vars['row']['ipaddress']; ?>
</span></td>
    <td><a href="data.php?act=list&user_id=<?php echo $this->_tpl_vars['row']['user_id']; ?>
"><?php echo $this->_tpl_vars['row']['user_name']; ?>
</a></td>
    <td><?php if ($this->_tpl_vars['row']['is_auditing']): ?>已审核<?php else: ?><span class="text_red">未审核</span><?php endif; ?></td>
    <td><a href="data.php?act=html&id=<?php echo $this->_tpl_vars['row']['data_id']; ?>
"><img src="images/icon_html.gif" title="HTML" /></a>&nbsp;<a href="data.php?act=edit&id=<?php echo $this->_tpl_vars['row']['data_id']; ?>
"><img src="images/icon_edit.gif" title="编辑" /></a></td>
  </tr>
<?php endforeach; endif; unset($_from); ?>
  <tr>
	<td colspan="10" class="text_left" style="padding:0;"><?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "data_manage.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?></td>
  </tr>
  <tr height="18">
	<td colspan="10" class="tcat text_left"><?php echo ((is_array($_tmp=@$this->_tpl_vars['multipage'])) ? $this->_run_mod_handler('default', true, $_tmp, "只有一页") : smarty_modifier_default($_tmp, "只有一页")); ?>
</td>
  </tr>
<?php else: ?>
  <tr height="18">
	<td colspan="10" class="alt1 text_center">没有匹配的记录！[<a href="javascript:history.back();">返回上一页</a>]</td>
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