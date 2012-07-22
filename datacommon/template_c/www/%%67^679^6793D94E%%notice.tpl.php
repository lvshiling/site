<?php /* Smarty version 2.6.19, created on 2011-04-02 17:17:23
         compiled from user/notice.tpl */ ?>
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

<div class="table m_right">
<div class="nav_title text_bold">提示信息</div>
<table class="list_style">
  <tr class="alt1">
    <td class="text_center text_bold font_big" style="margin:10px;line-height:180%;"><?php echo $this->_tpl_vars['Content']; ?>
</td>
  </tr>
</table>
</div>

<div class="clear"></div>
</div></div>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "footer.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>