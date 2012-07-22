<ul class="tabs">
<!--{if $Current eq "general"}-->
<li class="current"><a href="#" onclick="return false;">查看内容</a></li>
<!--{else}-->
<li><a href="<!--{$Data.show_url}-->">查看内容</a></li>
<!--{/if}-->

<!--{if $Current eq "comment"}-->
<li class="current"><a href="#" onclick="return false;">网友评论</a></li>
<!--{else}-->
<li><a href="<!--{$Config.domain_comment}-->/<!--{$Data.hash_id}-->-1.html">网友评论</a></li>
<!--{/if}-->

<li><a href="javascript:void(0);" onclick="reportWindow('<!--{$Data.show_url|urlencode}-->');return false;">举报</a></li>
</ul>

<h1 id="title"><!--{$Data.data_title}--></h1>