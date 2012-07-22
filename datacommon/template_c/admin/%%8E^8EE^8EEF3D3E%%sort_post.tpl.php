<?php /* Smarty version 2.6.19, created on 2011-04-01 13:06:01
         compiled from sort_post.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'escape', 'sort_post.tpl', 24, false),)), $this); ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "header.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

<div class="table clear">
<div class="f_nav">
<input type="button" value="添加分类" onclick="window.location='sort.php?act=add'" class="formButton" />
<input type="button" value="分类列表" onclick="window.location='sort.php'" class="formButton" />
</div>
</div>

<div class="table clear">
<form name="form1" method="post" onsubmit="return checkFormData();">
<input type="hidden" name="op" value="<?php echo $this->_tpl_vars['Action']; ?>
" />
<?php if ($this->_tpl_vars['Action'] == 'edit'): ?><input type="hidden" name="id" value="<?php echo $this->_tpl_vars['SortData']['sort_id']; ?>
" /><?php endif; ?>
<table class="list_style" cellpadding="0" cellspacing="0" border="1" frame="void">
  <tr><td colspan="2" class="theader"><?php if ($this->_tpl_vars['Action'] == 'edit'): ?>编辑<?php else: ?>添加<?php endif; ?>分类</td></tr>
<?php if (@ISPay): ?>
  <tr class="alt1">
	<td align="right">父分类</td>
    <td><select id="parent_sort_id" name="parent_sort_id"><option value="0">无父分类</option><?php echo $this->_tpl_vars['SortOption']; ?>
</select><br /><span class="form_clue">如果不选择父分类，该分类将作为顶级分类存在</span></td>
  </tr>
<?php endif; ?>
  <tr class="alt2">
	<td align="right">分类名称</td>
    <td><input type="text" class="formInput" name="sort_name" size="50" maxlength="100" value="<?php echo ((is_array($_tmp=$this->_tpl_vars['SortData']['sort_name'])) ? $this->_run_mod_handler('escape', true, $_tmp, 'html') : smarty_modifier_escape($_tmp, 'html')); ?>
" /><br /><span class="form_clue">长度请限制在50个字符以内，允许使用HTML标签</span></td>
  </tr>
  <tr class="alt1">
	<td align="right">外部链接</td>
    <td><input type="text" class="formInput" name="external_url" size="50" maxlength="200" value="<?php echo $this->_tpl_vars['SortData']['external_url']; ?>
" /><br /><span class="form_clue">如果填写了外部链接，下面的选项将无效</span></td>
  </tr>
  <tr class="alt2">
	<td align="right">允许发表</td>
    <td><label><input type="radio" name="allow_post" value="1"<?php if (! $this->_tpl_vars['SortData'] || $this->_tpl_vars['SortData']['allow_post']): ?> checked="checked"<?php endif; ?> />允许</label>&nbsp;<label><input type="radio" name="allow_post" value="0"<?php if ($this->_tpl_vars['SortData'] && ! $this->_tpl_vars['SortData']['allow_post']): ?> checked="checked"<?php endif; ?> />禁止</label><br /><span class="form_clue">禁止将不允许发表信息在该分类下</span></td>
  </tr>
  <tr class="alt1">
	<td align="right">VIP专区</td>
    <td><label><input type="checkbox" name="is_vip" value="1"<?php if ($this->_tpl_vars['SortData']['is_vip']): ?>checked="checked"<?php endif; ?> /><span class="form_clue">只允许VIP用户访问</span></label></td>
  </tr>
  <tr>
    <td colspan="2" class="tfoot text_center">
	<input type="submit" class="formButton" accesskey="s" id="submit" value=" <?php if ($this->_tpl_vars['Action'] == 'edit'): ?>编辑<?php else: ?>添加<?php endif; ?>分类(S) " />
	<input type="reset" class="formButton" accesskey="r" value="重置(R)" />
	<input type="button" class="formButton" accesskey="n" value=" 返回(N) " onclick='javascript:history.back();' />
	</td>
  </tr>
</table>
</form>
</div>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "footer.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>