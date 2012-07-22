<?php /* Smarty version 2.6.19, created on 2011-04-01 13:02:54
         compiled from feedback.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'cycle', 'feedback.tpl', 25, false),array('modifier', 'date_format', 'feedback.tpl', 26, false),array('modifier', 'default', 'feedback.tpl', 26, false),array('modifier', 'nl2br', 'feedback.tpl', 26, false),)), $this); ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "header.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

<div class="table clear">
<div class="f_nav">
<form name="form2" method="get">
查找反馈信息:
<input type="text" class="formInput" name="keyword" maxlength="100" />
<input type="submit" class="formButton" id="submit" accessKey="s" value=" 查找(S) " />
</form>
</div>
</div>

<div class="table clear">
<form name="form1" method="post">
<table class="list_style" cellpadding="0" cellspacing="0" border="1" frame="void">
  <tr>
    <td colspan="2" class="theader">反馈信息(共&nbsp;<?php echo $this->_tpl_vars['totalnum']; ?>
&nbsp;条记录)</td>
  </tr>
  <tr class="tcat text_center">
	<td width="*" nowrap="nowrap">反馈信息</td>
	<td width="5%" nowrap="nowrap">操作</td>
  </tr>
<?php if ($this->_tpl_vars['FeedbackData']): ?>
<?php $_from = $this->_tpl_vars['FeedbackData']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['row']):
?>
  <tr id="row_<?php echo $this->_tpl_vars['key']; ?>
" onclick="setPointer(this, <?php echo $this->_tpl_vars['key']; ?>
, 'click');" class="alt<?php echo smarty_function_cycle(array('values' => '1,2'), $this);?>
" height="18">
    <td class="text_left" style="padding:8px;line-height:140%;"><?php echo $this->_tpl_vars['row']['feedback_ip']; ?>
&nbsp;在&nbsp;<?php echo ((is_array($_tmp=$this->_tpl_vars['row']['feedback_date'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%Y/%m/%d %H:%M") : smarty_modifier_date_format($_tmp, "%Y/%m/%d %H:%M")); ?>
&nbsp;反馈:<hr style="height:1px;color:#CCC;" /><p>联系方式: <?php echo ((is_array($_tmp=@$this->_tpl_vars['row']['feedback_contact'])) ? $this->_run_mod_handler('default', true, $_tmp, "没有填写") : smarty_modifier_default($_tmp, "没有填写")); ?>
</p><p><?php echo ((is_array($_tmp=$this->_tpl_vars['row']['feedback_content'])) ? $this->_run_mod_handler('nl2br', true, $_tmp) : smarty_modifier_nl2br($_tmp)); ?>
</p></td>
    <td nowrap="nowrap"><input id="mark_box_<?php echo $this->_tpl_vars['key']; ?>
" name="data_id[]" type="checkbox" value="<?php echo $this->_tpl_vars['row']['feedback_id']; ?>
" /></td>
  </tr>
<?php endforeach; endif; unset($_from); ?>
  <tr>
	<td colspan="2" class="tcat text_left">
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
	<td colspan="2" class="alt1 text_center">没有匹配的记录！[<a href="javascript:history.back();">返回上一页</a>]</td>
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