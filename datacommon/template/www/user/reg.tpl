<!--{include file="header.tpl"}-->

<!--{****** 注册区域 ******}-->
<div class="table" style="width:600px;margin:0 auto;">
<div class="nav_title text_bold">新用户注册</div>
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
	if ('' == $F('r_password').trim())
	{
		alert('请输入确认密码！');
		$('r_password').focus();
		return false;
	}
	if ($F('password') != $F('r_password'))
	{
		alert('两次输入的密码不匹配！');
		return false;
	}
	if ('' == $F('email').trim())
	{
		alert('请填写您的电子邮件地址！');
		$('email').focus();
		return false;
	}
	if (/[\w\-]+@[\w\-]+\.[\w\-]+/.test($F('email')) == false)
	{
		alert('不是一个正确的电子邮件地址！');
		$('email').focus();
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
<form name="form1" action="user.php?o=reg" method="post" onsubmit="return checkFormData();">
<input type="hidden" name="op" value="reg" />
<table class="list_style">
  <tr class="alt1">
    <td class="text_right" width="130">登录用户名</td>
    <td width="*"><input type="text" id="username" name="username" class="formInput" size="30" maxlength="12" /><br /><span class="form_clue">用户名长度请限制在4-12个字符以内</span></td>
  </tr>
  <tr class="alt2">
    <td class="text_right">登录密码</td>
    <td><input type="password" id="password" name="password" class="formInput" size="30" maxlength="30" /><br /><span class="form_clue">密码长度不能少于4个字符</span></td>
  </tr>
  <tr class="alt1">
    <td class="text_right">确认密码</td>
    <td><input type="password" id="r_password" name="r_password" class="formInput" size="30" maxlength="30" /><br /><span class="form_clue">重复输入一次密码</span></td>
  </tr>
  <tr class="alt2">
    <td class="text_right">电子邮件</td>
    <td><input type="text" id="email" name="email" class="formInput" size="50" maxlength="50" /><br /><span class="form_clue">注册需要验证电子邮件地址，请填写您的真实邮件地址</span></td>
  </tr>
<!--{if !$Config.verify_code_close}-->
  <tr class="alt1">
    <td class="text_right">验证码</td>
    <td><input type="text" name="vcode" class="formInput" size="4" maxlength="4" /><img id="vimg" src="vimg.php?n=reg" align="absmiddle" alt="图片验证码" />(<a href="javascript:void(0);" onclick="imgRefresh('reg'); return false;">看不清,换一张</a>)</td>
  </tr>
<!--{/if}-->
  <tr class="tfooter text_center">
    <td colspan="2"><input type="submit" id="submit" class="formButton" value=" 注 册 " />&nbsp;&nbsp;<a href="user.php?o=login">已注册用户？</a></td>
  </tr>
</table>
</form>
</div>
<!--{****** 结束注册区域 ******}-->

<!--{include file="footer.tpl"}-->