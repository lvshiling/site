<?php /* Smarty version 2.6.19, created on 2011-04-02 17:16:58
         compiled from user/data.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'default', 'user/data.tpl', 16, false),array('modifier', 'date_format', 'user/data.tpl', 34, false),array('function', 'cycle', 'user/data.tpl', 33, false),)), $this); ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "header.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

<div class="m_container">
<div class="m_inner">

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "user/left_menu.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

<div class="m_right">
<div class="table">
<div class="nav_title" style="clear:right;">
<span class="left text_bold">管理发布内容</span>
<span class="right">
<form onsubmit="return checkFormData(this);">
<input type="hidden" name="o" value="data" />
<input type="text" class="formInput" style="margin-top:-5px;" id="u_keyword" name="u_keyword" value="<?php echo ((is_array($_tmp=@$this->_tpl_vars['keyword'])) ? $this->_run_mod_handler('default', true, $_tmp, '搜索发布的内容') : smarty_modifier_default($_tmp, '搜索发布的内容')); ?>
" /><input type="submit" value="搜索" class="formButton" style="margin-top:-5px;height:23px;" />
</form>
</span>
</div>
<form name="form1" method="post">
<input type="hidden" name="op" value="batch" />
<table class="list_style">
<?php if ($this->_tpl_vars['Data']): ?>
  <tr class="tcat text_normal text_center">
    <td width="75">发布时间</td>
    <td width="10%">分类</td>
    <td width="*">标题</td>
    <td width="8%">评论</td>
    <td width="8%">审核</td>
	<?php if ($this->_tpl_vars['CanEdit'] || $this->_tpl_vars['ManageSelect']): ?><td width="50">操作</td><?php endif; ?>
  </tr>
<?php $_from = $this->_tpl_vars['Data']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['row']):
?>
  <tr class="alt<?php echo smarty_function_cycle(array('values' => '1,2'), $this);?>
 text_center">
    <td nowrap="nowrap"><?php echo ((is_array($_tmp=$this->_tpl_vars['row']['release_date'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%Y/%m/%d") : smarty_modifier_date_format($_tmp, "%Y/%m/%d")); ?>
</td>
    <td><a href="<?php echo $this->_tpl_vars['Config']['domain_vip']; ?>
/sort-<?php echo $this->_tpl_vars['row']['sort_id']; ?>
-1.html" target="_blank"><?php echo $this->_tpl_vars['row']['sort_name']; ?>
</a></td>
    <td class="text_left"><?php if ($this->_tpl_vars['row']['is_commend']): ?><span class="text_red">[荐]</span><?php endif; ?><a href="<?php if ($this->_tpl_vars['row']['is_auditing']): ?><?php echo $this->_tpl_vars['row']['show_url']; ?>
<?php else: ?>#<?php endif; ?>" target="_blank"><?php echo $this->_tpl_vars['row']['data_title']; ?>
</a></td>
	<td><a href="<?php echo $this->_tpl_vars['Config']['domain_comment']; ?>
/<?php echo $this->_tpl_vars['row']['hash_id']; ?>
-1.html" target="_blank"><?php echo $this->_tpl_vars['row']['total_comment']; ?>
</a></td>
	<td><?php if ($this->_tpl_vars['row']['is_auditing']): ?>已审核<?php else: ?>未审核<?php endif; ?></td>
    <?php if ($this->_tpl_vars['CanEdit'] || $this->_tpl_vars['ManageSelect']): ?><td><input type="checkbox" id="multi_election" name="data_id[]" value="<?php echo $this->_tpl_vars['row']['data_id']; ?>
" />&nbsp;<a href="user.php?o=data&act=edit&id=<?php echo $this->_tpl_vars['row']['data_id']; ?>
">编辑</a></td><?php endif; ?>
  </tr>
<?php endforeach; endif; unset($_from); ?>
<?php if ($this->_tpl_vars['ManageSelect']): ?>
  <tr class="text_right">
    <td colspan="8" style="padding:0;"><?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "user/data_manage.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?></td>
  </tr>
<?php endif; ?>
<?php else: ?>
  <tr class="alt1 text_center">
    <td>没有可显示数据！</td>
  </tr>
<?php endif; ?>
</table>
</form>
</div>

<?php if ($this->_tpl_vars['Multipage']['page']): ?><div class="pages clear"><?php echo $this->_tpl_vars['Multipage']['page']; ?>
</div><?php endif; ?>
</div>


<div class="clear"></div>
</div></div>
<script type="text/javascript">
$('u_keyword').addEvent('focus', function(){$('u_keyword').value=''});
function checkFormData(o)
{
	var keyword = $F('u_keyword').trim();
	if ('' == keyword || keyword == '搜索发布的资源')
	{
		alert('没有填写搜索关键字');
		return false;
	}

	$('submit').disabled = true;
	return true;
}
</script>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "footer.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>