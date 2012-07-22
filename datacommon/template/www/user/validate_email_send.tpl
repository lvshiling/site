<!--{include file="header.tpl"}-->

<!--{****** 登录区域 ******}-->
<div class="table" style="width:480px;margin:0 auto;">
<div class="nav_title text_bold">重发验证邮件</div>
<script type="text/javascript">
var use_v_code = <!--{if !$Config.verify_code_close}-->true<!--{else}-->false<!--{/if}-->;
function checkFormData()
{
	if ('' == $F('username').trim())
	{
		alert('请输入注册的用户名！');
		$('username').focus();
		return false;
	}
	if ('' == $F('email').trim())
	{
		alert('请输入注册的电子邮件！');
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
<form name="form1" method="post" onsubmit="return checkFormData();">
<input type="hidden" name="op" value="send" />
<table class="list_style">
  <tr class="alt1">
    <td class="text_right" width="120">用户名</td>
    <td width="*"><input type="text" id="username" name="username" class="formInput" size="25" maxlength="30" /></td>
  </tr>
  <tr class="alt2">
    <td class="text_right">电子邮件</td>
    <td><input type="text" id="email" name="email" class="formInput" size="25" maxlength="50" /></td>
  </tr>
<!--{if !$Config.verify_code_close}-->
  <tr class="alt1">
    <td class="text_right">验证码</td>
    <td><input type="text" name="vcode" class="formInput" size="4" maxlength="4" /><img id="vimg" src="vimg.php?n=vemail" align="absmiddle" alt="图片验证码" />(<a href="javascript:void(0);" onclick="imgRefresh('vemail'); return false;">看不清,换一张</a>)</td>
  </tr>
<!--{/if}-->
  <tr class="tfooter text_center">
    <td colspan="2"><input type="submit" id="submit" class="formButton" value=" 发 送 " /></td>
  </tr>
</table>
</form>
</div>
<!--{****** 结束登录区域 ******}-->

<!--{include file="footer.tpl"}-->