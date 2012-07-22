<?php /* Smarty version 2.6.19, created on 2011-04-01 13:00:14
         compiled from ftp.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'default', 'ftp.tpl', 25, false),array('function', 'cycle', 'ftp.tpl', 104, false),)), $this); ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "header.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

<div class="table clear">
	<div class="f_nav">
		<input type="button" value=" 添加 " onclick="window.location='ftp.php?act=add'" class="formButton" />
		<input type="button" value=" 管理 " onclick="window.location='ftp.php'" class="formButton" />
	</div>
</div>

<?php if ($this->_tpl_vars['Action'] == 'add' || $this->_tpl_vars['Action'] == 'edit'): ?>
	<div class="table">
	<form name="form1" method="post" onsubmit="return checkFormData();">
	<input type="hidden" name="op" value="<?php echo $this->_tpl_vars['Action']; ?>
" />
	<?php if ($this->_tpl_vars['Action'] == 'edit'): ?>
	<input type="hidden" name="id" value="<?php echo $this->_tpl_vars['FtpInfo']['ftp_id']; ?>
" />
	<?php endif; ?>
	<table class="list_style" cellpadding="0" cellspacing="0" border="1" frame="void">
	  <tr><td colspan="2" class="theader"><?php if ($this->_tpl_vars['Action'] == 'edit'): ?>修改<?php else: ?>添加<?php endif; ?>图源服务器</td></tr>
	  <tr class="alt1">
		<td align="right" width="30%">服务器地址</td>
		<td width="70%"><input type="text" class="formInput" id="host" name="host" size="50" maxlength="50" value="<?php echo $this->_tpl_vars['FtpInfo']['ftp_host']; ?>
" /><br /><span class="form_clue">服务器IP地址或已绑定域名</span></td>
	  </tr>
	  <tr class="alt2">
		<td align="right">端口</td>
		<td><input type="text" class="formInput" id="port" name="port" size="50" maxlength="50" value="<?php echo ((is_array($_tmp=@$this->_tpl_vars['FtpInfo']['ftp_port'])) ? $this->_run_mod_handler('default', true, $_tmp, 21) : smarty_modifier_default($_tmp, 21)); ?>
" /><br /><span class="form_clue">一般默认为:21</span></td>
	  </tr>
	  <tr class="alt1">
		<td align="right">用户名</td>
		<td><input type="text" class="formInput" id="username" name="username" size="50" maxlength="50" value="<?php echo $this->_tpl_vars['FtpInfo']['ftp_username']; ?>
" /><br /><span class="form_clue">FTP用户名</span></td>
	  </tr>
	  <tr class="alt2">
		<td align="right">密码</td>
		<td><input type="text" class="formInput" id="password" name="password" size="50" maxlength="50" value="<?php echo $this->_tpl_vars['FtpInfo']['ftp_password']; ?>
" /><br /><span class="form_clue">FTP密码</span></td>
	  </tr>
	  <tr class="alt1">
		<td align="right">访问地址</td>
		<td><input type="text" class="formInput" name="visit_path" size="50" maxlength="50" value="<?php echo $this->_tpl_vars['FtpInfo']['visit_path']; ?>
" /><br /><span class="form_clue">用户访问路径，结尾不能包含'/'</span></td>
	  </tr>
	  <tr>
		<td colspan="2" class="tfoot text_center">
		<input type="submit" class="formButton" id="submit" accesskey="s" value=" <?php if ($this->_tpl_vars['Action'] == 'edit'): ?>修改<?php else: ?>添加<?php endif; ?>(S) " />
		<input type="reset" class="formButton" accesskey="r" value="重置(R)" />
		<input type="button" class="formButton" onclick="testConnect();" value=" 测试连接 " />
		</td>
	  </tr>
	</table>
	</form>
	</div>

	<form id="testftp" method="post" target="testftp">
	<input type="hidden" name="op" value="test" />
	<input type="hidden" id="ftp_host" name="ftp_host" />
	<input type="hidden" id="ftp_port" name="ftp_port" />
	<input type="hidden" id="ftp_username" name="ftp_username" />
	<input type="hidden" id="ftp_password" name="ftp_password" />
	</form>

	<script type="text/javascript">
	function testConnect()
	{
		if ('' == $F('host'))
		{
			alert('服务器地址没有填写');
			return false;
		}
		if ('' != $F('port'))
		{
			if (/^\d+$/g.test($F('port')) != true)
			{
				alert('不是一个正确的端口');
				return false;
			}
		}
		if ('' == $F('username'))
		{
			alert('用户名没有填写');
			return false;
		}
		if ('' == $F('password'))
		{
			alert('密码没有填写');
			return false;
		}

		$('ftp_host').value = $F('host');
		$('ftp_port').value = $F('port');
		$('ftp_username').value = $F('username');
		$('ftp_password').value = $F('password');
		$('testftp').submit();
	}
	</script>
<?php else: ?>
	<div class="table">
	<table class="list_style" cellpadding="0" cellspacing="0" border="1" frame="void">
	  <tr>
		<td colspan="10" class="theader">图源服务器管理</td>
	  </tr>
	  <tr class="tcat text_center">
		<td width="30%" nowrap="nowrap">服务器地址</td>
		<td width="60%" nowrap="nowrap">访问地址</td>
		<td width="10%" nowrap="nowrap"></td>
	  </tr>
	<?php $_from = $this->_tpl_vars['FtpInfo']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['row']):
?>
	  <tr id="row_<?php echo $this->_tpl_vars['key']; ?>
" onclick="setPointer(this, <?php echo $this->_tpl_vars['key']; ?>
, 'click');" class="alt<?php echo smarty_function_cycle(array('values' => '1,2'), $this);?>
" height="18" align="center">
		<td nowrap="nowrap">ftp://<?php echo $this->_tpl_vars['row']['ftp_host']; ?>
:<?php echo ((is_array($_tmp=@$this->_tpl_vars['row']['ftp_port'])) ? $this->_run_mod_handler('default', true, $_tmp, 21) : smarty_modifier_default($_tmp, 21)); ?>
</td>
		<td><?php echo $this->_tpl_vars['row']['visit_path']; ?>
</td>
		<td nowrap="nowrap"><a href="ftp.php?act=edit&id=<?php echo $this->_tpl_vars['row']['ftp_id']; ?>
">修改</a>&nbsp;<a href="ftp.php?act=delete&id=<?php echo $this->_tpl_vars['row']['ftp_id']; ?>
" onclick="return confirm('确定要删除这个服务器？')">删除</a></td>
	  </tr>
	<?php endforeach; else: ?>
	  <tr height="18">
		<td colspan="5" class="alt1 text_center">还没有添加图源服务器！[<a href="javascript:history.back();">返回上一页</a>]</td>
	  </tr>
	<?php endif; unset($_from); ?>
	</table>
	</div>
<?php endif; ?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "footer.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>