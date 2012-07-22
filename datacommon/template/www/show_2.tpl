<!--{include file="header.tpl"}-->

<div class="show">

<!-- Left(box1) -->
<div class="box1">

<!--{include file="show_common.tpl" Current="general"}-->

<!--x
<div id="general">
	<p><!--{$Data.release_date|date_format:"%Y/%m/%d %H:%M:%S"}--></p>
	<div class="description"><div><!--{$Config.meta_keywords}--><div></div>
</div>
<dl id="article">
	<dt><p><!--{$Data.release_date|date_format:"%Y/%m/%d %H:%M:%S"}--></p></dt>
	<dd><div class="articlea"><div><!--{$Data.disturb_text}--><div></div></dd>
</dl>
<dl id="article">
	<dt><p><!--{$Data.release_date|date_format:"%Y/%m/%d %H:%M:%S"}--></p></dt>
	<dd><big><div><!--{$Config.meta_description}--><div></big></dd>
</dl>
x-->

<!-- General -->
<dl id="article">
	<dt><p>由会员 <!--{$Data.user_name}--> 发表于 <!--{$Data.release_date|date_format:"%Y/%m/%d %H:%M:%S"}--></p></dt>
	<dd><div class="articlea"><!--{$Data.data_content}--></div></dd>
</dl>
<!--{if $Multipage}--><div class="pages clear" style="margin-top:10px;"><!--{$Multipage}--></div><!--{/if}-->
<!-- General end -->

</div>
<!-- Left end -->

<!-- Right(box2) -->
<!--{include file="show_right.tpl"}-->
<!-- Right end -->

</div>

<!--{include file="footer.tpl"}-->