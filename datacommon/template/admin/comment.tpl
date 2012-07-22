<!--{include file="header.tpl"}-->

<div class="table clear">
<form action="comment.php">
<input type="hidden" name="act" value="list" />
<div class="f_nav">
搜索评论:
<input type="text" name="keyword" class="formInput" size="20" maxlength="50" />
<input type="submit" value=" 显示 " class="formButton" />
<input type="button" value=" 未审核 " onclick="window.location='comment.php?auditing=0'" class="formButton" />
<input type="button" value=" 已审核 " onclick="window.location='comment.php?auditing=1'" class="formButton" />
<input type="button" value=" 被举报评论 " onclick="window.location='comment.php?report=1'" class="formButton" />
</div>
</form>
</div>

<style>
hr{border:1px dashed #A8DFF0;height:1px;}
.quote{border:1px solid #CCC;padding:4px;margin:4px;}
</style>

<div class="table clear">
<form name="form1" method="post">
<table class="list_style" cellpadding="0" cellspacing="0" border="1" frame="void">
  <tr>
    <td colspan="4" class="theader">网友评论(共&nbsp;<!--{$CommentTotalnum}-->&nbsp;条记录)</td>
  </tr>
<!--{if $CommentData}-->
<!--{foreach item=row from=$CommentData key=key}-->
  <tr id="row_<!--{$key}-->" onclick="setPointer(this, <!--{$key}-->, 'click');" class="alt<!--{cycle values='1,2'}-->" height="18">
    <td style="line-height:160%;"><!--{$row.comment_content}--><hr /><input id="mark_box_<!--{$key}-->" name="data_id[]" type="checkbox" value="<!--{$row.comment_id}-->" />&nbsp;&nbsp;<!--{if $row.comment_auditing}--><a href="<!--{$Config.domain_comment}-->/index.php?id=<!--{$row.hash_id}-->" target="_blank">查看</a><!--{else}-->未审核<!--{/if}-->&nbsp;&nbsp;|&nbsp;&nbsp;<!--{$row.user_name}-->(<!--{$row.client_ip}-->)&nbsp;&nbsp;|&nbsp;&nbsp;<!--{$row.comment_date|date_format:"%Y-%m-%d %H:%M:%S"}-->&nbsp;&nbsp;|&nbsp;&nbsp;支持:<!--{$row.agree_num}-->&nbsp;反对:<!--{$row.oppose_num}-->&nbsp;举报: <span style="<!--{if $row.report_num}-->color:red;<!--{/if}-->"><!--{$row.report_num}--></span></td>
  </tr>
<!--{/foreach}-->
  <tr>
	<td colspan="4" class="tcat text_left">
	<div class="left" style="padding-top:4px;"><!--{$multipage|default:"只有一页"}--></div>
	<div class="right">
	<input name="button" type="button" value="全选" onClick='selectAll(true);' />
    <input name="button" type="button" value="全不选" onClick='selectAll(false);' />
    <input name="button" type="button" value="反选" onClick='againstSelect();' />
	<select name="op" onchange="executeOperate();">
	<option value="">将选中项</option>
	<option value="auditing">审核</option>
	<option value="delete">删除</option>
	</select>
	</div>
	</td>
  </tr>
<!--{else}-->
  <tr height="18">
	<td colspan="4" class="alt1 text_center">没有匹配的记录！[<a href="javascript:history.back();">返回上一页</a>]</td>
  </tr>
<!--{/if}-->
</table>
</form>
</div>

<!--{include file="footer.tpl"}-->