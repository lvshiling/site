<?php /* Smarty version 2.6.19, created on 2011-04-01 12:48:06
         compiled from frame_main.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'date_format', 'frame_main.tpl', 28, false),)), $this); ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "header.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

<div class="table">
<table class="list_style" cellpadding="0" cellspacing="0" border="1" frame="void">
  <tr><td colspan="2" class="theader">系统信息</td></tr>
  <tr class="alt1" height="18">
	<td align="right" width="20%">PHP版本</td>
    <td><?php echo $this->_tpl_vars['sysinfo']['php_version']; ?>
</td>
  </tr>
  <tr class="alt2" height="18">
	<td align="right">MySql版本</td>
    <td><?php echo $this->_tpl_vars['sysinfo']['mysql_version']; ?>
</td>
  </tr>
  <tr class="alt1" height="18">
	<td align="right">服务器端信息</td>
    <td><?php echo $this->_tpl_vars['sysinfo']['service']; ?>
</td>
  </tr>
  <tr class="alt2" height="18">
	<td align="right">最大上传限制</td>
    <td><?php echo $this->_tpl_vars['sysinfo']['max_upload']; ?>
</td>
  </tr>
  <tr class="alt1" height="18">
	<td align="right">最大执行时间</td>
    <td><?php echo $this->_tpl_vars['sysinfo']['max_ex_time']; ?>
</td>
  </tr>
  <tr class="alt2" height="18">
	<td align="right">服务器时间</td>
    <td><?php echo ((is_array($_tmp=@TIME_NOW)) ? $this->_run_mod_handler('date_format', true, $_tmp, "%Y/%m/%d %H:%M:%S") : smarty_modifier_date_format($_tmp, "%Y/%m/%d %H:%M:%S")); ?>
</td>
  </tr>
</table>
</div>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "footer.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>