<?php /* Smarty version 2.6.19, created on 2011-04-02 17:12:15
         compiled from user/validate_ip_notice.tpl */ ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "header.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

<div class="table" style="width:700px;margin:0 auto;">
<div class="nav_title text_bold">提示信息</div>
<script type="text/javascript">
function copyP(obj)
{
	if (window.ie)
	{
		obj.select();
		var txt = obj.createTextRange();
		txt.execCommand("Copy");
		alert('已经复制到了剪贴板！');
	}
}
</script>
<div style="padding:0 4px;line-height:150%;">
<p><?php if (! $this->_tpl_vars['UserInfo']['user_id']): ?>感谢您的注册<?php else: ?>欢迎您，<?php echo $this->_tpl_vars['UserInfo']['user_name']; ?>
<?php endif; ?>。为了把本站告诉更多的人，本站要求您推荐 <span class="text_red"><?php echo $this->_tpl_vars['Config']['validate_ip']; ?>
</span> 个人(独立IP)进入本网站，才能激活您的帐户!</p>
<?php if ($this->_tpl_vars['UserInfo']['user_id']): ?>
<p class="text_green">您已经推荐了 <span class="text_red"><?php echo $this->_tpl_vars['UserInfo']['validate_ip']; ?>
</span> 个人，还需要继续努力哦！</p>
<?php endif; ?>
<p>下面是您的推荐地址↓↓↓ 赶快把推荐地址发给QQ群和QQ好友吧！<br /><input type="text" size="70" value="某某网站:<?php echo $this->_tpl_vars['Config']['domain_vip']; ?>
/p.php?id=<?php if ($this->_tpl_vars['UserInfo']['user_id']): ?><?php echo $this->_tpl_vars['UserInfo']['user_id']; ?>
<?php else: ?><?php echo $this->_tpl_vars['UserID']; ?>
<?php endif; ?>" onmouseover="this.focus();" onfocus="this.select();" onclick="copyP(this);" /></p>
<?php if (! $this->_tpl_vars['UserInfo']['user_id']): ?>
<p>您登陆本站即可知道您已经推荐网友数量。<br /><a href="user.php?o=login">马上登录</a></p>
<?php endif; ?>
</div>
</div>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "footer.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>