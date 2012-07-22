<?php /* Smarty version 2.6.19, created on 2011-04-01 13:02:48
         compiled from comment.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'cycle', 'comment.tpl', 30, false),array('modifier', 'date_format', 'comment.tpl', 31, false),array('modifier', 'default', 'comment.tpl', 36, false),)), $this); ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "header.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

<div class="table clear">
<form action="comment.php">
<input type="hidden" name="act" value="list" />
<div class="f_nav">
搜索评论:
<input type="text" name="keyword" class="formInput" size="20" maxlength="50" />
<input type="submit" value=" 显示 " class="formButton" />
<input type="button" value=" 未审核 " onclick="window.location='comment.php?auditing=0'" class="formButton" />
<input type="button" value=" 已审核 " onclick="window.location='comment.php?auditing=1'" class="formButton" />
<input type="button" value=" 被举报评论 " onclick="window.location='comment.php?report=1'" class="formButton" />
</div>
</form>
</div>

<style>
hr{border:1px dashed #A8DFF0;height:1px;}
.quote{border:1px solid #CCC;padding:4px;margin:4px;}
</style>

<div class="table clear">
<form name="form1" method="post">
<table class="list_style" cellpadding="0" cellspacing="0" border="1" frame="void">
  <tr>
    <td colspan="4" class="theader">网友评论(共&nbsp;<?php echo $this->_tpl_vars['CommentTotalnum']; ?>
&nbsp;条记录)</td>
  </tr>
<?php if ($this->_tpl_vars['CommentData']): ?>
<?php $_from = $this->_tpl_vars['CommentData']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['row']):
?>
  <tr id="row_<?php echo $this->_tpl_vars['key']; ?>
" onclick="setPointer(this, <?php echo $this->_tpl_vars['key']; ?>
, 'click');" class="alt<?php echo smarty_function_cycle(array('values' => '1,2'), $this);?>
" height="18">
    <td style="line-height:160%;"><?php echo $this->_tpl_vars['row']['comment_content']; ?>
<hr /><input id="mark_box_<?php echo $this->_tpl_vars['key']; ?>
" name="data_id[]" type="checkbox" value="<?php echo $this->_tpl_vars['row']['comment_id']; ?>
" />&nbsp;&nbsp;<?php if ($this->_tpl_vars['row']['comment_auditing']): ?><a href="<?php echo $this->_tpl_vars['Config']['domain_comment']; ?>
/index.php?id=<?php echo $this->_tpl_vars['row']['hash_id']; ?>
" target="_blank">查看</a><?php else: ?>未审核<?php endif; ?>&nbsp;&nbsp;|&nbsp;&nbsp;<?php echo $this->_tpl_vars['row']['user_name']; ?>
(<?php echo $this->_tpl_vars['row']['client_ip']; ?>
)&nbsp;&nbsp;|&nbsp;&nbsp;<?php echo ((is_array($_tmp=$this->_tpl_vars['row']['comment_date'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%Y-%m-%d %H:%M:%S") : smarty_modifier_date_format($_tmp, "%Y-%m-%d %H:%M:%S")); ?>
&nbsp;&nbsp;|&nbsp;&nbsp;支持:<?php echo $this->_tpl_vars['row']['agree_num']; ?>
&nbsp;反对:<?php echo $this->_tpl_vars['row']['oppose_num']; ?>
&nbsp;举报: <span style="<?php if ($this->_tpl_vars['row']['report_num']): ?>color:red;<?php endif; ?>"><?php echo $this->_tpl_vars['row']['report_num']; ?>
</span></td>
  </tr>
<?php endforeach; endif; unset($_from); ?>
  <tr>
	<td colspan="4" class="tcat text_left">
	<div class="left" style="padding-top:4px;"><?php echo ((is_array($_tmp=@$this->_tpl_vars['multipage'])) ? $this->_run_mod_handler('default', true, $_tmp, "只有一页") : smarty_modifier_default($_tmp, "只有一页")); ?>
</div>
	<div class="right">
	<input name="button" type="button" value="全选" onClick='selectAll(true);' />
    <input name="button" type="button" value="全不选" onClick='selectAll(false);' />
    <input name="button" type="button" value="反选" onClick='againstSelect();' />
	<select name="op" onchange="executeOperate();">
	<option value="">将选中项</option>
	<option value="auditing">审核</option>
	<option value="delete">删除</option>
	</select>
	</div>
	</td>
  </tr>
<?php else: ?>
  <tr height="18">
	<td colspan="4" class="alt1 text_center">没有匹配的记录！[<a href="javascript:history.back();">返回上一页</a>]</td>
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