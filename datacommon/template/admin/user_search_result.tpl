<!--{include file="header.tpl"}-->

<div class="table">
<form name="form1" method="post">
<table class="list_style" cellpadding="0" cellspacing="0" border="1" frame="void">
  <tr>
    <td colspan="8" class="theader">注册用户搜索结果(共&nbsp;<!--{$totalnum|default:0}-->&nbsp;条记录)</td>
  </tr>
  <tr class="tcat text_center">
	<td width="10%" nowrap="nowrap">用户ID</td>
	<td width="*" nowrap="nowrap">用户名</td>
    <td width="15%" nowrap="nowrap">加入日期</td>
	<td width="10%" nowrap="nowrap">Email验证</td>
	<td width="10%" nowrap="nowrap">IP验证</td>
	<td width="10%" nowrap="nowrap">操作</td>
  </tr>
<!--{if $UserData}-->
<!--{foreach item=row from=$UserData key=key}-->
  <tr id="row_<!--{$key}-->" onclick="setPointer(this, <!--{$key}-->, 'click');" class="alt<!--{cycle values='1,2'}-->" height="18" align="center">
    <td nowrap="nowrap"><!--{$row.user_id}--></td>
    <td nowrap="nowrap"><!--{$row.user_name}--></td>
    <td nowrap="nowrap"><!--{$row.dateline|date_format:"%Y-%m-%d %H:%M"}--></td>
	<td nowrap="nowrap"><!--{if $row.validate_email}-->已验证<!--{else}--><span class="text_red">未验证</span><!--{/if}--></td>
    <td nowrap="nowrap"><!--{if !$Config.validate_ip || $row.validate_ip gte $Config.validate_ip}-->已激活<!--{else}--><!--{$row.validate_ip}--><!--{/if}--></td>
    <td nowrap="nowrap"><a href="user.php?act=edit&id=<!--{$row.user_id}-->"><img src="images/icon_edit.gif" title="编辑" /></a>&nbsp;<input id="mark_box_<!--{$key}-->" name="data_id[]" type="checkbox" value="<!--{$row.user_id}-->" /></td>
  </tr>
<!--{/foreach}-->
  <tr>
	<td colspan="8" class="tcat text_left">
	<div class="left" style="padding-top:4px;"><!--{$multipage|default:"只有一页"}--></div>
	<div class="right">
	<input name="button" type="button" value="全选" onClick='selectAll(true);' />
    <input name="button" type="button" value="全不选" onClick='selectAll(false);' />
    <input name="button" type="button" value="反选" onClick='againstSelect();' />
	<select name="op" onchange="executeOperate();">
	<option value="">将选中项</option>
	<option value="delete">删除</option>
	</select>
	</div>
	</td>
  </tr>
<!--{else}-->
  <tr height="18">
	<td colspan="8" class="alt1 text_center">没有匹配的记录！[<a href="javascript:history.back();">返回上一页</a>]</td>
  </tr>
<!--{/if}-->
</table>
</form>
</div>

<!--{include file="footer.tpl"}-->