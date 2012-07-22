<!--{include file="header.tpl"}-->

<div class="table clear">
<div class="f_nav">
<form name="form2" method="get">
查找举报信息:
<input type="text" class="formInput" name="keyword" maxlength="100" />
<input type="submit" class="formButton" id="submit" accessKey="s" value=" 查找(S) " />
</form>
</div>
</div>

<div class="table clear">
<form name="form1" method="post">
<table class="list_style" cellpadding="0" cellspacing="0" border="1" frame="void">
  <tr>
    <td colspan="2" class="theader">举报信息(共&nbsp;<!--{$totalnum}-->&nbsp;条记录)</td>
  </tr>
  <tr class="tcat text_center">
	<td width="*" nowrap="nowrap">举报信息</td>
	<td width="5%" nowrap="nowrap">操作</td>
  </tr>
<!--{if $ReportData}-->
<!--{foreach item=row from=$ReportData key=key}-->
  <tr id="row_<!--{$key}-->" onclick="setPointer(this, <!--{$key}-->, 'click');" class="alt<!--{cycle values='1,2'}-->" height="18">
    <td class="text_left" style="padding:8px;line-height:140%;"><!--{$row.report_ip}-->&nbsp;在&nbsp;<!--{$row.report_date|date_format:"%Y/%m/%d %H:%M"}-->&nbsp;举报:<hr style="height:1px;color:#CCC;" /><p>举报地址: <a href="<!--{$row.report_url|urldecode}-->" target="_blank"><!--{$row.report_url|urldecode}--></a></p><p><!--{$row.report_content|nl2br}--></p></td>
    <td nowrap="nowrap"><input id="mark_box_<!--{$key}-->" name="data_id[]" type="checkbox" value="<!--{$row.report_id}-->" /></td>
  </tr>
<!--{/foreach}-->
  <tr>
	<td colspan="2" class="tcat text_left">
	<div class="left" style="padding-top:4px;"><!--{$multipage|default:"只有一页"}--></div>
	<div class="right">
	<input type="button" value="全选" onclick='selectAll(true);' />
    <input type="button" value="全不选" onclick='selectAll(false);' />
    <input type="button" value="反选" onclick='againstSelect();' />
	<select name="op" onchange="executeOperate();">
	<option value="">将选中项</option>
	<option value="delete">删除</option>
	</select>
	</div>
	</td>
  </tr>
<!--{else}-->
  <tr height="18">
	<td colspan="2" class="alt1 text_center">没有匹配的记录！[<a href="javascript:history.back();">返回上一页</a>]</td>
  </tr>
<!--{/if}-->
</table>
</form>
</div>

<!--{include file="footer.tpl"}-->