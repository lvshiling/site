<!--{include file="header.tpl"}-->

<div class="m_container">
<div class="m_inner">

<!--{include file="user/left_menu.tpl"}-->

<div class="m_right">
<!--{****** 数据列表 ******}-->
<div class="table">
<div class="nav_title" style="clear:right;">
<span class="left text_bold">管理发布内容</span>
<span class="right">
<form onsubmit="return checkFormData(this);">
<input type="hidden" name="o" value="data" />
<input type="text" class="formInput" style="margin-top:-5px;" id="u_keyword" name="u_keyword" value="<!--{$keyword|default:'搜索发布的内容'}-->" /><input type="submit" value="搜索" class="formButton" style="margin-top:-5px;height:23px;" />
</form>
</span>
</div>
<form name="form1" method="post">
<input type="hidden" name="op" value="batch" />
<table class="list_style">
<!--{if $Data}-->
  <tr class="tcat text_normal text_center">
    <td width="75">发布时间</td>
    <td width="10%">分类</td>
    <td width="*">标题</td>
    <td width="8%">评论</td>
    <td width="8%">审核</td>
	<!--{if $CanEdit || $ManageSelect}--><td width="50">操作</td><!--{/if}-->
  </tr>
<!--{foreach item=row from=$Data}-->
  <tr class="alt<!--{cycle values='1,2'}--> text_center">
    <td nowrap="nowrap"><!--{$row.release_date|date_format:"%Y/%m/%d"}--></td>
    <td><a href="<!--{$Config.domain_vip}-->/sort-<!--{$row.sort_id}-->-1.html" target="_blank"><!--{$row.sort_name}--></a></td>
    <td class="text_left"><!--{if $row.is_commend}--><span class="text_red">[荐]</span><!--{/if}--><a href="<!--{if $row.is_auditing}--><!--{$row.show_url}--><!--{else}-->#<!--{/if}-->" target="_blank"><!--{$row.data_title}--></a></td>
	<td><a href="<!--{$Config.domain_comment}-->/<!--{$row.hash_id}-->-1.html" target="_blank"><!--{$row.total_comment}--></a></td>
	<td><!--{if $row.is_auditing}-->已审核<!--{else}-->未审核<!--{/if}--></td>
    <!--{if $CanEdit || $ManageSelect}--><td><input type="checkbox" id="multi_election" name="data_id[]" value="<!--{$row.data_id}-->" />&nbsp;<a href="user.php?o=data&act=edit&id=<!--{$row.data_id}-->">编辑</a></td><!--{/if}-->
  </tr>
<!--{/foreach}-->
<!--{if $ManageSelect}-->
  <tr class="text_right">
    <td colspan="8" style="padding:0;"><!--{include file="user/data_manage.tpl"}--></td>
  </tr>
<!--{/if}-->
<!--{else}-->
  <tr class="alt1 text_center">
    <td>没有可显示数据！</td>
  </tr>
<!--{/if}-->
</table>
</form>
<!--{****** 结束数据列表 ******}-->
</div>

<!--{if $Multipage.page}--><div class="pages clear"><!--{$Multipage.page}--></div><!--{/if}-->
</div>


<div class="clear"></div>
</div><!--{*** manage inner ***}-->
</div><!--{*** manage container ***}-->

<script type="text/javascript">
$('u_keyword').addEvent('focus', function(){$('u_keyword').value=''});
function checkFormData(o)
{
	var keyword = $F('u_keyword').trim();
	if ('' == keyword || keyword == '搜索发布的资源')
	{
		alert('没有填写搜索关键字');
		return false;
	}

	$('submit').disabled = true;
	return true;
}
</script>

<!--{include file="footer.tpl"}-->