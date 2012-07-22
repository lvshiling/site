<!--{include file="header.tpl"}-->

<div class="table clear">
	<div class="f_nav">
		<input type="button" value=" 添加 " onclick="window.location='ftp.php?act=add'" class="formButton" />
		<input type="button" value=" 管理 " onclick="window.location='ftp.php'" class="formButton" />
	</div>
</div>

<!--{if $Action eq "add" || $Action eq "edit"}-->
	<div class="table">
	<form name="form1" method="post" onsubmit="return checkFormData();">
	<input type="hidden" name="op" value="<!--{$Action}-->" />
	<!--{if $Action eq "edit"}-->
	<input type="hidden" name="id" value="<!--{$FtpInfo.ftp_id}-->" />
	<!--{/if}-->
	<table class="list_style" cellpadding="0" cellspacing="0" border="1" frame="void">
	  <tr><td colspan="2" class="theader"><!--{if $Action eq "edit"}-->修改<!--{else}-->添加<!--{/if}-->图源服务器</td></tr>
	  <tr class="alt1">
		<td align="right" width="30%">服务器地址</td>
		<td width="70%"><input type="text" class="formInput" id="host" name="host" size="50" maxlength="50" value="<!--{$FtpInfo.ftp_host}-->" /><br /><span class="form_clue">服务器IP地址或已绑定域名</span></td>
	  </tr>
	  <tr class="alt2">
		<td align="right">端口</td>
		<td><input type="text" class="formInput" id="port" name="port" size="50" maxlength="50" value="<!--{$FtpInfo.ftp_port|default:21}-->" /><br /><span class="form_clue">一般默认为:21</span></td>
	  </tr>
	  <tr class="alt1">
		<td align="right">用户名</td>
		<td><input type="text" class="formInput" id="username" name="username" size="50" maxlength="50" value="<!--{$FtpInfo.ftp_username}-->" /><br /><span class="form_clue">FTP用户名</span></td>
	  </tr>
	  <tr class="alt2">
		<td align="right">密码</td>
		<td><input type="text" class="formInput" id="password" name="password" size="50" maxlength="50" value="<!--{$FtpInfo.ftp_password}-->" /><br /><span class="form_clue">FTP密码</span></td>
	  </tr>
	  <tr class="alt1">
		<td align="right">访问地址</td>
		<td><input type="text" class="formInput" name="visit_path" size="50" maxlength="50" value="<!--{$FtpInfo.visit_path}-->" /><br /><span class="form_clue">用户访问路径，结尾不能包含'/'</span></td>
	  </tr>
	  <tr>
		<td colspan="2" class="tfoot text_center">
		<input type="submit" class="formButton" id="submit" accesskey="s" value=" <!--{if $Action eq "edit"}-->修改<!--{else}-->添加<!--{/if}-->(S) " />
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
<!--{else}-->
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
	<!--{foreach item=row from=$FtpInfo key=key}-->
	  <tr id="row_<!--{$key}-->" onclick="setPointer(this, <!--{$key}-->, 'click');" class="alt<!--{cycle values='1,2'}-->" height="18" align="center">
		<td nowrap="nowrap">ftp://<!--{$row.ftp_host}-->:<!--{$row.ftp_port|default:21}--></td>
		<td><!--{$row.visit_path}--></td>
		<td nowrap="nowrap"><a href="ftp.php?act=edit&id=<!--{$row.ftp_id}-->">修改</a>&nbsp;<a href="ftp.php?act=delete&id=<!--{$row.ftp_id}-->" onclick="return confirm('确定要删除这个服务器？')">删除</a></td>
	  </tr>
	<!--{foreachelse}-->
	  <tr height="18">
		<td colspan="5" class="alt1 text_center">还没有添加图源服务器！[<a href="javascript:history.back();">返回上一页</a>]</td>
	  </tr>
	<!--{/foreach}-->
	</table>
	</div>
<!--{/if}-->

<!--{include file="footer.tpl"}-->