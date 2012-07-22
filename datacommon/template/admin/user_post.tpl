<!--{include file="header.tpl"}-->

<div class="table clear">
<form name="form1" method="post" onsubmit="return checkFormData();">
<input type="hidden" name="op" value="<!--{$Action}-->" />
<!--{if $Action eq "edit"}--><input type="hidden" name="id" value="<!--{$UserData.user_id}-->" /><!--{/if}-->
<table class="list_style" cellpadding="0" cellspacing="0" border="1" frame="void">
  <tr><td colspan="2" class="theader"><!--{if $Action eq "edit"}-->编辑<!--{else}-->添加本地<!--{/if}-->发布用户</td></tr>
  <tr class="alt1">
	<td align="right" width="30%">登录用户名</td>
    <td width="70%"><input type="text" class="formInput" name="username" size="30" maxlength="12" value="<!--{$UserData.user_name}-->" /><br /><span class="form_clue">长度在4 - 12个字符以内</span></td>
  </tr>
  <tr class="alt2">
	<td align="right">登录密码</td>
    <td><input type="text" class="formInput" name="password" size="30" maxlength="100" /><br /><span class="form_clue">密码长度不少于4个字符<!--{if $Action eq "edit"}-->，不修改密码请留空<!--{/if}--></span></td>
  </tr>
  <tr class="alt1">
	<td align="right">电子邮件</td>
    <td><input type="text" class="formInput" name="email" size="30" maxlength="100" value="<!--{$UserData.user_email}-->" /></td>
  </tr>
</table>
<table class="list_style" cellpadding="0" cellspacing="0" border="1" frame="void">
  <tr><td colspan="2" class="theader">用户权限</td></tr>
  <tr class="alt1">
	<td align="right" width="30%">允许发表内容</td>
    <td><input type="radio" name="can_add" value="1"<!--{if $UserData.can_add}--> checked="checked"<!--{/if}--> />是&nbsp;<input type="radio" name="can_add" value="0"<!--{if !$UserData.can_add}--> checked="checked"<!--{/if}--> />否</td>
  </tr>
  <tr class="alt2">
	<td align="right">允许编辑自己发表的</td>
    <td><input type="radio" name="can_edit" value="1"<!--{if $UserData.can_edit}--> checked="checked"<!--{/if}--> />是&nbsp;<input type="radio" name="can_edit" value="0"<!--{if !$UserData.can_edit}--> checked="checked"<!--{/if}--> />否</td>
  </tr>
  <tr class="alt1">
	<td align="right">允许删除自己发表的</td>
    <td><input type="radio" name="can_delete" value="1"<!--{if $UserData.can_delete}--> checked="checked"<!--{/if}--> />是&nbsp;<input type="radio" name="can_delete" value="0"<!--{if !$UserData.can_delete}--> checked="checked"<!--{/if}--> />否</td>
  </tr>
<!--{if $Action eq "edit"}-->
  <tr class="alt2">
	<td align="right">Email验证</td>
    <td><label><input type="radio" name="validate_email" value="1"<!--{if $UserData.validate_email}--> checked="checked"<!--{/if}--> />已验证</label>&nbsp;<label><input type="radio" name="validate_email" value="0"<!--{if !$UserData.validate_email}--> checked="checked"<!--{/if}--> />未验证</label></td>
  </tr>
  <tr class="alt1">
	<td align="right">IP验证</td>
    <td><label><!--{if $UserData.validate_ip gte $Config.validate_ip}--><input type="hidden" name="validate_ip" value="1" /><!--{else}--><input type="checkbox" name="validate_ip" value="1" /><!--{/if}-->已验证</label></td>
  </tr>
<!--{/if}-->
</table>
<table class="list_style" cellpadding="0" cellspacing="0" border="1" frame="void">
  <tr>
    <td colspan="2" class="tfoot text_center">
	<input type="submit" class="formButton" accesskey="s" id="submit" value=" <!--{if $Action eq 'edit'}-->编辑<!--{else}-->添加<!--{/if}-->(S) " />
	<input type="reset" class="formButton" accesskey="r" value="重置(R)" />
	<input type="button" class="formButton" accesskey="n" value=" 返回(N) " onclick='javascript:history.back();' />
<!--{if $Action eq "edit"}-->
	<input type="button" class="formButton" style="color:red;" onclick="deleteConfirm(<!--{$UserData.user_id}-->);" value="删除" />
<!--{/if}-->
	</td>
  </tr>
</table>
</form>
</div>

<script type="text/javascript">
function deleteConfirm(id)
{
	if (false == confirm('确定要删除这个用户？'))
	{
		return false;
	}

	location.href = 'user.php?act=delete&id='+ id;
}
</script>

<!--{include file="footer.tpl"}-->