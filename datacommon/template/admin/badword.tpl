<!--{include file="header.tpl"}-->

<div class="table clear">
<div class="f_nav">
<form name="form1" method="post" onsubmit="return checkFormData();">
<input type="hidden" name="op" value="add" />
添加屏蔽关键字:
<input type="text" class="formInput" name="word" size="20" maxlength="20" />&nbsp;<input type="submit" class="formButton" id="submit" accessKey="s" value=" 添加(S) " />
</form>
</div>
</div>

<div class="table clear">
<table class="list_style" cellpadding="0" cellspacing="0" border="1" frame="void">
  <tr>
    <td class="theader" colspan="10">已添加的屏蔽关键字</td>
  </tr>
  <tr class="tcat text_center">
	<td width="*">关键字</td>
	<td width="20%">操作</td>
  </tr>
<!--{foreach item=row from=$Badword key=key}-->
  <tr id="row_<!--{$key}-->" onclick="setPointer(this, <!--{$key}-->, 'click');" class="alt<!--{cycle values='1,2'}-->" height="18" align="center">
    <td nowrap="nowrap"><!--{$row.badword_name}--></td>
    <td nowrap="nowrap"><a href="badword.php?act=edit&id=<!--{$row.badword_id}-->"><img src="images/icon_edit.gif" title="编辑" /></a><a href="badword.php?act=delete&id=<!--{$row.badword_id}-->" onclick="return confirm('确定要删除该关键字？');"><img src="images/icon_delete.gif" title="删除" /></a></td>
  </tr>
<!--{foreachelse}-->
  <tr height="18" class="alt1 text_center">
    <td nowrap="nowrap" colspan="2">没有添加任何屏蔽关键字！</td>
  </tr>
<!--{/foreach}-->
</table>
</div>

<!--{include file="footer.tpl"}-->