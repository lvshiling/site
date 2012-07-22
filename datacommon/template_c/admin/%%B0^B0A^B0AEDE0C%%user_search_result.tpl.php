<?php /* Smarty version 2.6.19, created on 2011-04-01 13:59:04
         compiled from user_search_result.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'default', 'user_search_result.tpl', 7, false),array('modifier', 'date_format', 'user_search_result.tpl', 22, false),array('function', 'cycle', 'user_search_result.tpl', 19, false),)), $this); ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "header.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

<div class="table">
<form name="form1" method="post">
<table class="list_style" cellpadding="0" cellspacing="0" border="1" frame="void">
  <tr>
    <td colspan="8" class="theader">注册用户搜索结果(共&nbsp;<?php echo ((is_array($_tmp=@$this->_tpl_vars['totalnum'])) ? $this->_run_mod_handler('default', true, $_tmp, 0) : smarty_modifier_default($_tmp, 0)); ?>
&nbsp;条记录)</td>
  </tr>
  <tr class="tcat text_center">
	<td width="10%" nowrap="nowrap">用户ID</td>
	<td width="*" nowrap="nowrap">用户名</td>
    <td width="15%" nowrap="nowrap">加入日期</td>
	<td width="10%" nowrap="nowrap">Email验证</td>
	<td width="10%" nowrap="nowrap">IP验证</td>
	<td width="10%" nowrap="nowrap">操作</td>
  </tr>
<?php if ($this->_tpl_vars['UserData']): ?>
<?php $_from = $this->_tpl_vars['UserData']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['row']):
?>
  <tr id="row_<?php echo $this->_tpl_vars['key']; ?>
" onclick="setPointer(this, <?php echo $this->_tpl_vars['key']; ?>
, 'click');" class="alt<?php echo smarty_function_cycle(array('values' => '1,2'), $this);?>
" height="18" align="center">
    <td nowrap="nowrap"><?php echo $this->_tpl_vars['row']['user_id']; ?>
</td>
    <td nowrap="nowrap"><?php echo $this->_tpl_vars['row']['user_name']; ?>
</td>
    <td nowrap="nowrap"><?php echo ((is_array($_tmp=$this->_tpl_vars['row']['dateline'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%Y-%m-%d %H:%M") : smarty_modifier_date_format($_tmp, "%Y-%m-%d %H:%M")); ?>
</td>
	<td nowrap="nowrap"><?php if ($this->_tpl_vars['row']['validate_email']): ?>已验证<?php else: ?><span class="text_red">未验证</span><?php endif; ?></td>
    <td nowrap="nowrap"><?php if (! $this->_tpl_vars['Config']['validate_ip'] || $this->_tpl_vars['row']['validate_ip'] >= $this->_tpl_vars['Config']['validate_ip']): ?>已激活<?php else: ?><?php echo $this->_tpl_vars['row']['validate_ip']; ?>
<?php endif; ?></td>
    <td nowrap="nowrap"><a href="user.php?act=edit&id=<?php echo $this->_tpl_vars['row']['user_id']; ?>
"><img src="images/icon_edit.gif" title="编辑" /></a>&nbsp;<input id="mark_box_<?php echo $this->_tpl_vars['key']; ?>
" name="data_id[]" type="checkbox" value="<?php echo $this->_tpl_vars['row']['user_id']; ?>
" /></td>
  </tr>
<?php endforeach; endif; unset($_from); ?>
  <tr>
	<td colspan="8" class="tcat text_left">
	<div class="left" style="padding-top:4px;"><?php echo ((is_array($_tmp=@$this->_tpl_vars['multipage'])) ? $this->_run_mod_handler('default', true, $_tmp, "只有一页") : smarty_modifier_default($_tmp, "只有一页")); ?>
</div>
	<div class="right">
	<input name="button" type="button" value="全选" onClick='selectAll(true);' />
    <input name="button" type="button" value="全不选" onClick='selectAll(false);' />
    <input name="button" type="button" value="反选" onClick='againstSelect();' />
	<select name="op" onchange="executeOperate();">
	<option value="">将选中项</option>
	<option value="delete">删除</option>
	</select>
	</div>
	</td>
  </tr>
<?php else: ?>
  <tr height="18">
	<td colspan="8" class="alt1 text_center">没有匹配的记录！[<a href="javascript:history.back();">返回上一页</a>]</td>
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