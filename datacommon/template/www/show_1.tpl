<!--{include file="header.tpl"}-->

<div class="show">

<!-- Left(box1) -->
<div class="box1">

<!--{include file="show_common.tpl" Current="general"}-->

<!-- General -->
<div id="general">
	<p>由会员 <!--{$Data.user_name}--> 发表于 <!--{$Data.release_date|date_format:"%Y/%m/%d %H:%M:%S"}--></p>
	<div class="description"><!--{$Data.data_content}--></div>
	<!--{if $Multipage}--><div class="pages clear" style="margin-top:10px;"><!--{$Multipage}--></div><!--{/if}-->
</div>
<!-- General end -->

</div>
<!-- Left end -->

<!-- Right(box2) -->
<!--{include file="show_right.tpl"}-->
<!-- Right end -->

</div>

<!--{include file="footer.tpl"}-->