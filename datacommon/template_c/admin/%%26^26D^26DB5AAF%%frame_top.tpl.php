<?php /* Smarty version 2.6.19, created on 2011-04-01 12:48:06
         compiled from frame_top.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'counter', 'frame_top.tpl', 29, false),)), $this); ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "header.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

<div class="topbody">
<div class="left">&nbsp;</div>
<div class="nav right">
<a href="misc.php?act=change_pw" target="main">修改密码(<?php echo $this->_tpl_vars['ManagerInfo']['name']; ?>
)</a>
<a href="create_html.php" target="main">静态页生成</a>
<a href="index.php?act=logout" onclick="return confirm('确定退出登录？');" title="安全退出！" target="_top">退出登录</a>
</div>
</div>

<div class="pagetitle clear">
<div class="left top_nav">
<a href="index.php?act=main" target="main">管理首页</a>
<?php $_from = $this->_tpl_vars['ManageMenuGroup']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['group']):
?>
<a id="a_<?php echo $this->_tpl_vars['key']; ?>
" href="javascript:void(0);" onclick="showMenu('<?php echo $this->_tpl_vars['key']; ?>
');"><?php echo $this->_tpl_vars['group']; ?>
</a>
<?php endforeach; endif; unset($_from); ?>
</div>
<div class="right top_tool">
<a href="javascript:void(0);" onclick="parent.main.history.go(-1);return false;"><img src="images/back.gif" title="后退" /></a>
<a href="javascript:void(0);" onclick="parent.main.history.go(1);return false;"><img src="images/forward.gif" title="前进" /></a>
<a href="javascript:void(0);" onclick="parent.main.location.reload();return false;"><img src="images/reload.gif" title="刷新" /></a>
</div>
<div class="clear"></div>
</div>

<script type="text/javascript">
var menu_ = new Array();
<?php echo smarty_function_counter(array('start' => 0,'skip' => 1,'print' => false,'assign' => 'num'), $this);?>

<?php $_from = $this->_tpl_vars['ManageMenuGroup']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['group']):
?>
menu_[<?php echo $this->_tpl_vars['num']; ?>
] = '<?php echo $this->_tpl_vars['key']; ?>
';
<?php echo smarty_function_counter(array(), $this);?>

<?php endforeach; endif; unset($_from); ?>
if (menu_[0])
{
	window.onload = function(){activateMenu(menu_[0])};
}
function showMenu(type)
{
	for (var i = 0; i < menu_.length; i++)
	{
		if (menu_[i] == type)
		{
			window.parent.frames.nav.$(menu_[i]).style.display = '';
		}
		else
		{
			window.parent.frames.nav.$(menu_[i]).style.display = 'none';
		}
	}
	activateMenu(type);
}
function activateMenu(type)
{
	for (var i = 0; i < menu_.length; i++)
	{
		if (menu_[i] == type)
		{
			window.top.frames.top_nav.$('a_'+ menu_[i]).style.background = 'url("images/nav_bg_hover.gif")';
		}
		else
		{
			window.top.frames.top_nav.$('a_'+ menu_[i]).style.background = '';
		}
	}
}
</script>

</div>

</body>
</html>