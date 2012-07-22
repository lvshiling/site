<!--{include file="header.tpl"}-->

<div class="m_container">
<div class="m_inner">

<!--{include file="user/left_menu.tpl"}-->

<div class="table m_right">
<div class="nav_title text_bold">修改登录密码</div>
<script type="text/javascript">
function checkFormData()
{
	if ('' == $F('current_pw').trim())
	{
		alert('没有输入当前密码！');
		$('current_pw').focus();
		return false;
	}
	if ('' == $F('new_pw').trim())
	{
		alert('没有输入新密码！');
		$('new_pw').focus();
		return false;
	}
	if ($F('new_pw') != $F('repeat_new_pw'))
	{
		alert('两次输入的新密码不一致！');
		return false;
	}

	$('submit').value = Lang['submit'];
	$('submit').disabled = true;
	return true;
}
</script>
<form name="form1" action="user.php?o=profile" method="post" onsubmit="return checkFormData();">
<input type="hidden" name="op" value="change_pw" />
<table class="list_style">
  <tr class="alt1">
    <td class="text_right" width="20%">当前密码</td>
    <td width="80%"><input type="password" id="current_pw" name="current_pw" size="30" maxlength="30" class="formInput" /><br /><span class="form_clue">当前正在使用的密码</span></td>
  </tr>
  <tr class="alt2">
    <td class="text_right">新密码</td>
    <td><input type="password" id="new_pw" name="new_pw" size="30" maxlength="30" class="formInput" /><br /><span class="form_clue">密码长度不能少于4个字符</span></td>
  </tr>
  <tr class="alt1">
    <td class="text_right">确认新密码</td>
    <td><input type="password" id="repeat_new_pw" name="repeat_new_pw" size="30" maxlength="30" class="formInput" /><br /><span class="form_clue">重复输入上面的新密码</span></td>
  </tr>
  <tr class="tfooter text_center">
    <td colspan="2">
	<input type="submit" id="submit" value="修改密码" class="formButton" />
	</td>
  </tr>
</table>
</form>
</div>

<div class="clear"></div>
</div><!--{*** manage inner ***}-->
</div><!--{*** manage container ***}-->

<!--{include file="footer.tpl"}-->