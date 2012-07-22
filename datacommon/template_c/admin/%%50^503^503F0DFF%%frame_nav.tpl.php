<?php /* Smarty version 2.6.19, created on 2011-04-01 12:48:06
         compiled from frame_nav.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'counter', 'frame_nav.tpl', 14, false),)), $this); ?>
﻿<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "header.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

<script type="text/javascript">
function openUrl(url)
{
	window.parent.frames.main.location = url;
}
</script>

<body class="nav">

<div class="navlayout">

<?php echo smarty_function_counter(array('start' => 0,'skip' => 1,'print' => false,'assign' => 'num'), $this);?>

<?php $_from = $this->_tpl_vars['ManageMenu']['group']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['group']):
?>
<div id="<?php echo $this->_tpl_vars['key']; ?>
" style="display:<?php if ($this->_tpl_vars['num'] != 0): ?>none;<?php endif; ?>">
<div class="navtitle"><?php echo $this->_tpl_vars['group']; ?>
</div>
<div class="navgroup">
<?php $_from = $this->_tpl_vars['ManageMenu'][$this->_tpl_vars['key']]; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['row']):
?>
<div class="navlink-normal" onmouseover="this.className='navlink-hover';" onmouseout="this.className='navlink-normal';" onclick="openUrl('<?php echo $this->_tpl_vars['row']['url']; ?>
');" style="cursor:pointer;"><?php echo $this->_tpl_vars['row']['name']; ?>
</div>
<?php endforeach; endif; unset($_from); ?>
</div>
</div>
<?php echo smarty_function_counter(array(), $this);?>

<?php endforeach; endif; unset($_from); ?>

</div>

</div>

</body>
</html>