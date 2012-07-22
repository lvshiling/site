<!--{include file="header.tpl"}-->

<div class="table clear">
<form name="form1" method="post">
<input type="hidden" name="op" value="batch" />
<table class="list_style" cellpadding="0" cellspacing="0" border="1" frame="void">
  <tr>
    <td colspan="10" class="theader">发表内容搜索结果(共&nbsp;<!--{$totalnum}-->&nbsp;条记录)</td>
  </tr>
  <tr class="tcat text_center">
	<td width="10"></td>
	<td width="8%">分类</td>
    <td width="*">标题</td>
	<td width="10%">作者</td>
	<td width="10%">审核</td>
	<td width="50">操作</td>
  </tr>
<!--{if $Data}-->
<!--{foreach item=row from=$Data key=key}-->
  <tr id="row_<!--{$key}-->" onclick="setPointer(this, <!--{$key}-->, 'click');" class="alt<!--{cycle values='1,2'}-->" align="center">
	<td width="10"><input type="checkbox" id="mark_box_<!--{$key}-->" name="data_id[]" value="<!--{$row.data_id}-->" /></td>
	<td><a href="data.php?act=list&sort_id=<!--{$row.sort_id}-->"><!--{$row.sort_name}--></a></td>
    <td align="left" style="line-height:140%;"><!--{if $row.is_commend}--><span class="list_commend">[荐]</span><!--{/if}--><a href="<!--{$row.show_url}-->" target="_blank"><!--{$row.data_title}--></a><br /><span class="list_data">发布日期:<!--{$row.release_date|date_format:"%m-%d %H:%M"}-->&nbsp;&nbsp;IP:<!--{$row.ipaddress}--></span></td>
    <td><a href="data.php?act=list&user_id=<!--{$row.user_id}-->"><!--{$row.user_name}--></a></td>
    <td><!--{if $row.is_auditing}-->已审核<!--{else}--><span class="text_red">未审核</span><!--{/if}--></td>
    <td><a href="data.php?act=html&id=<!--{$row.data_id}-->"><img src="images/icon_html.gif" title="HTML" /></a>&nbsp;<a href="data.php?act=edit&id=<!--{$row.data_id}-->"><img src="images/icon_edit.gif" title="编辑" /></a></td>
  </tr>
<!--{/foreach}-->
  <tr>
	<td colspan="10" class="text_left" style="padding:0;"><!--{include file="data_manage.tpl"}--></td>
  </tr>
  <tr height="18">
	<td colspan="10" class="tcat text_left"><!--{$multipage|default:"只有一页"}--></td>
  </tr>
<!--{else}-->
  <tr height="18">
	<td colspan="10" class="alt1 text_center">没有匹配的记录！[<a href="javascript:history.back();">返回上一页</a>]</td>
  </tr>
<!--{/if}-->
</table>
</form>
</div>

<!--{include file="footer.tpl"}-->