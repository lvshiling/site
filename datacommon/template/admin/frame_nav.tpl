<!--{include file="header.tpl"}-->

<script type="text/javascript">
function openUrl(url)
{
	window.parent.frames.main.location = url;
}
</script>

<body class="nav">

<div class="navlayout">

<!--{counter start=0 skip=1 print=false assign=num}-->
<!--{foreach key=key item=group from=$ManageMenu.group}-->
<div id="<!--{$key}-->" style="display:<!--{if $num neq 0}-->none;<!--{/if}-->">
<div class="navtitle"><!--{$group}--></div>
<div class="navgroup">
<!--{foreach item=row from=$ManageMenu[$key]}-->
<div class="navlink-normal" onmouseover="this.className='navlink-hover';" onmouseout="this.className='navlink-normal';" onclick="openUrl('<!--{$row.url}-->');" style="cursor:pointer;"><!--{$row.name}--></div>
<!--{/foreach}-->
</div>
</div>
<!--{counter}-->
<!--{/foreach}-->

</div>

</div>

</body>
</html>