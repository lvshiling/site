<!--{include file="header.tpl"}-->

<!--{****** 主列表显示 ******}-->
<div class="table clear">
<div class="nav_title s">
<div class="left"><h1 class="striking">
<!--{if $ID || $smarty.const.IN_SCRIPT eq "search"}-->
<!--{$SiteTitle}--><!--{if $Totalnum}-->(<!--{$Totalnum}-->)<!--{/if}-->
<!--{else}-->
最新发布：分享前<!--{$Config.pagination_list_num}-->个资源
<!--{/if}-->
</h1></div>
</div>
<!--{****** 数据列表 ******}-->
<div class="clear">
<table id="listTable" class="list_style table_fixed">
  <thead class="tcat">
	<!--{if $Data[0].sort_name}--><th class="l3">类别</th><!--{/if}-->
    <th class="l1">发表日期</th>
    <th class="l2">标题</th>
    <th class="l3">发表会员</th>
  </thead>
  <tbody class="tbody">
<!--{foreach item=row from=$Data}-->
  <tr class="alt<!--{cycle values='1,2'}-->" onmouseover="highlight(this);">
	<!--{if $row.sort_name}--><td><a href="<!--{$smarty.const.SITE_ROOT_PATH}-->/sort-<!--{$row.sort_id}-->-1.html"><!--{$row.sort_name}--></a></td><!--{/if}-->
    <td nowrap="nowrap"><!--{$row.release_date|date_format:"%Y/%m/%d %H:%M"}--></td>
    <td class="text_left"><a href="<!--{$row.show_url}-->" target="_blank"><!--{$row.data_title}--></a></td>
    <td class="author"><!--{$row.user_name}--></td>
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
<!--{****** 结束主列表显示 ******}-->

<!--{if $Multipage.page}--><div class="pages clear"><!--{$Multipage.page}--></div><!--{/if}-->

<!--{include file="footer.tpl"}-->