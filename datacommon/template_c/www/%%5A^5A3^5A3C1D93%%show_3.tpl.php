<?php /* Smarty version 2.6.19, created on 2011-04-02 17:17:45
         compiled from show_3.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'date_format', 'show_3.tpl', 12, false),)), $this); ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "header.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

<div class="show">

<!-- Left(box1) -->
<div class="box1">

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "show_common.tpl", 'smarty_include_vars' => array('Current' => 'general')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

<!--x
<div id="general">
	<p><?php echo ((is_array($_tmp=$this->_tpl_vars['Data']['release_date'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%Y/%m/%d %H:%M:%S") : smarty_modifier_date_format($_tmp, "%Y/%m/%d %H:%M:%S")); ?>
</p>
	<div class="description"><div><?php echo $this->_tpl_vars['Config']['meta_keywords']; ?>
<div></div>
</div>
<dl id="article">
	<dt><p><?php echo ((is_array($_tmp=$this->_tpl_vars['Data']['release_date'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%Y/%m/%d %H:%M:%S") : smarty_modifier_date_format($_tmp, "%Y/%m/%d %H:%M:%S")); ?>
</p></dt>
	<dd><big><div><?php echo $this->_tpl_vars['Data']['disturb_text']; ?>
<div></big></dd>
</dl>
x-->

<!-- General -->
<dl id="article">
	<dt><p>由会员 <?php echo $this->_tpl_vars['Data']['user_name']; ?>
 发表于 <?php echo ((is_array($_tmp=$this->_tpl_vars['Data']['release_date'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%Y/%m/%d %H:%M:%S") : smarty_modifier_date_format($_tmp, "%Y/%m/%d %H:%M:%S")); ?>
</p></dt>
	<dd><big><?php echo $this->_tpl_vars['Data']['data_content']; ?>
</big></dd>
</dl>
<?php if ($this->_tpl_vars['Multipage']): ?><div class="pages clear" style="margin-top:10px;"><?php echo $this->_tpl_vars['Multipage']; ?>
</div><?php endif; ?>
<!-- General end -->

<!--x
<dl id="article">
	<dt><p><?php echo ((is_array($_tmp=$this->_tpl_vars['Data']['release_date'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%Y/%m/%d %H:%M:%S") : smarty_modifier_date_format($_tmp, "%Y/%m/%d %H:%M:%S")); ?>
</p></dt>
	<dd><div class="articlea"><?php echo $this->_tpl_vars['Config']['meta_description']; ?>
</div></dd>
</dl>
x-->

</div>
<!-- Left end -->

<!-- Right(box2) -->
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "show_right.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<!-- Right end -->

</div>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "footer.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>