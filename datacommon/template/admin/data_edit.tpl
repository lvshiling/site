<!--{include file="header.tpl"}-->

<div class="table">
<form name="form1" method="post" action="data.php" onsubmit="return checkFormData();">
<input type="hidden" name="op" value="edit" />
<input type="hidden" name="id" value="<!--{$Data.data_id}-->" />
<input type="hidden" name="url" value="<!--{$smarty.const.HTTP_REFERER}-->" />
<table class="list_style" cellpadding="0" cellspacing="0" border="1" frame="void">
  <tr><td colspan="2" class="theader">编辑内容信息</td></tr>
  <tr class="alt1">
	<td align="right" width="15%">标题</td>
    <td width="85%"><input type="text" id="title" name="title" size="60" maxlength="200" class="formInput" value="<!--{$Data.data_title}-->" /></td>
  </tr>
  <tr class="alt2">
	<td align="right">所属分类</td>
    <td><select name="sort_id"><!--{$SortOption}--></select><!--{if $Data.lastedit_date}-->&nbsp;&nbsp;<span class="text_red">最后修改时间:<!--{$Data.lastedit_date|date_format:"%Y/%m/%d %H:%M:%S"}--></span><!--{/if}--></td>
  </tr>
  <tr class="alt1">
	<td align="right" valign="top">正文</td>
    <td><input type="hidden" id="content" name="content" value="<!--{$Data.data_content|escape:'html'}-->" /><input type="hidden" id="content___Config" value="AutoDetectLanguage=false&amp;DefaultLanguage=zh-cn" /><iframe id="content___Frame" src="htmleditor/editor/fckeditor.html?InstanceName=content&amp;Toolbar=Basic" width="100%" height="360" frameborder="no" scrolling="no"></iframe><br /><span class="form_clue">介绍内容长度请限制在20 - <!--{$Config.bt_intro_maxlength}-->个字符以内</span><a href="javascript:void(0);" onclick="checkLength();return false;">[字数检查]</a></td>
  </tr>
  <tr class="alt2">
	<td align="right">审核状态</td>
    <td><label><input type="radio" name="auditing" value="1"<!--{if $Data.is_auditing}--> checked="checked"<!--{/if}--> />通过审核</label>&nbsp;<label><input type="radio" name="auditing" value="0"<!--{if !$Data.is_auditing}--> checked="checked"<!--{/if}--> />取消审核</label></td>
  </tr>
  <tr>
    <td colspan="2" class="tfoot text_center">
	<input type="submit" class="formButton" accesskey="s" id="submit" value=" 编辑(S) " />
	<input type="reset" class="formButton" accesskey="r" value="重置(R)" />
	<input type="button" class="formButton" accesskey="n" value=" 返回(N) " onclick='javascript:history.back();' />
	<input type="button" class="formButton" style="color:red;" onclick="deleteConfirm(<!--{$Data.data_id}-->);" value="删除" />
	</td>
  </tr>
</table>
</form>
</div>

<script type="text/javascript">
var content_max_length = <!--{$Config.content_maxlength}-->;

function checkLength()
{
	alert('当前长度：'+ cnLength(getIntro()) +'，允许的长度：'+ content_max_length);
}
function getIntro()
{
	return FCKeditorAPI.GetInstance('content').GetXHTML(true);
}

function deleteConfirm(id)
{
	if (false == confirm('确定要删除这条数据？'))
	{
		return false;
	}

	location.href = 'data.php?act=delete&id='+ id;
}
</script>

<!--{include file="footer.tpl"}-->