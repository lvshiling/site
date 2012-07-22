<!--{include file="header.tpl"}-->

<!--{****** 登录区域 ******}-->
<div class="table" style="width:480px;margin:0 auto;">
<!--{if $LoginNotice neq ""}-->
<div class="text_center text_red text_bold" style="margin: 10px;">*<!--{$LoginNotice}--></div>
<!--{/if}-->
<div class="nav_title text_bold"><img src="<!--{$Config.domain_static}-->/images/icon_login.gif" align="absmiddle" /> 登录网站</div>
<script type="text/javascript">
var use_v_code = <!--{if !$Config.verify_code_close}-->true<!--{else}-->false<!--{/if}-->;
function checkFormData()
{
	if ('' == $F('username').trim())
	{
		alert('请输入登录用户名！');
		$('username').focus();
		return false;
	}
	if ('' == $F('password').trim())
	{
		alert('请输入登录密码！');
		$('password').focus();
		return false;
	}
	if (true == use_v_code && '' == $F('vcode').trim())
	{
		alert('请填写验证码！');
		$('vcode').focus();
		return false;
	}

	$('submit').value = Lang['submit'];
	$('submit').disabled = true;
	return true;
}
</script>
<form name="form1" action="user.php?o=login" method="post" onsubmit="return checkFormData();">
<input type="hidden" name="op" value="login" />
<input type="hidden" name="url" value="<!--{$GotoURL|urlencode}-->" />
<table class="list_style">
  <tr class="alt1">
    <td class="text_right" width="120">用户名</td>
    <td width="*"><input type="text" id="username" name="username" class="formInput" size="25" maxlength="30" /></td>
  </tr>
  <tr class="alt2">
    <td class="text_right">密&nbsp;&nbsp;码</td>
    <td><input type="password" id="password" name="password" class="formInput" size="25" maxlength="30" /></td>
  </tr>
  <tr class="alt1">
    <td class="text_right">登录有效期</td>
    <td><select name="cookietime" class="formInput">
	<option value="0">浏览器进程</option>
	<option value="2592000">保存一月</option>
	<option value="86400">保存一天</option>
	<option value="315360000">永久有效</option>
	</select></td>
  </tr>
<!--{if !$Config.verify_code_close}-->
  <tr class="alt2">
    <td class="text_right">验证码</td>
    <td><input type="text" name="vcode" class="formInput" size="4" maxlength="4" /><img id="vimg" src="vimg.php?n=login" align="absmiddle" alt="图片验证码" />(<a href="javascript:void(0);" onclick="imgRefresh('login'); return false;">看不清,换一张</a>)</td>
  </tr>
<!--{/if}-->
  <tr class="tfooter text_center">
    <td colspan="2"><input type="submit" id="submit" class="formButton" value=" 登 录 " /><!--{if $Config.user_register}-->&nbsp;&nbsp;<a href="user.php?o=reg">没有注册？</a><!--{/if}--><!--{if $Config.user_register_vemail}-->&nbsp;&nbsp;<a href="user.php?o=validate_email">重发验证邮件</a><!--{/if}--></td>
  </tr>
</table>
</form>
</div>
<!--{****** 结束登录区域 ******}-->

<!--{include file="footer.tpl"}-->