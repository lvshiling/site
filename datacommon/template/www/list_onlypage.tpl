<!--{include file="header.tpl"}-->

<!--{****** 主列表 ******}-->
<!--{foreach item=sort_id from=$SortOne}-->
<div class="table clear">
<a name="<!--{$sort_id}-->"></a>
<div class="nav_title s">
<div class="left"><a href="/sort-<!--{$sort_id}-->-1.html" class="striking"><h1><!--{$SortList[$sort_id].name}--></h1></a></div>
</div>
<!--{****** 数据列表 ******}-->
<div class="clear">
<table class="list_style table_fixed">
  <thead>
  <tr class="tcat text_center">
    <td class="l1">发表日期</td>
    <td class="l2">标题</td>
    <td class="l3">发表会员</td>
  </tr>
  </thead>
  <tbody class="tbody">
<!--{foreach item=row from=$Data[$sort_id]}-->
  <tr class="alt<!--{cycle values='1,2'}-->" onmouseover="highlight(this);">
    <td nowrap="nowrap"><!--{$row.release_date|date_format:"%Y/%m/%d %H:%M"}--></td>
    <td class="text_left"><a href="<!--{$row.show_url}-->" target="_blank"><!--{$row.data_title}--></a></td>
    <td><!--{$row.user_name}--></td>
  </tr>
<!--{foreachelse}-->
  <tr class="alt1 text_center">
    <td colspan="3">没有可显示数据</td>
  </tr>
<!--{/foreach}-->
  </tbody>
</table>
</div>
<!--{****** 结束数据列表 ******}-->
</div>
<!--{/foreach}-->
<!--{****** 结束主列表 ******}-->

<!--{include file="footer.tpl"}-->