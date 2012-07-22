<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="Content-Language" content="zh-CN" />
<title><!--{if $SiteTitle}--><!--{$SiteTitle}--> - <!--{/if}--><!--{$Config.site_name}--></title>
<meta name="robots" content="<!--{if $smarty.const.IN_SCRIPT eq user}-->none<!--{else}-->all<!--{/if}-->" />
<!--{if $Config.meta_keywords}-->
<meta name="keywords" content="<!--{$Config.meta_keywords}-->" />
<!--{/if}-->
<!--{if $Config.meta_description}-->
<meta name="description" content="<!--{$Config.meta_description}-->" />
<!--{/if}-->
<script type="text/javascript">
var DOMAIN_SEARCH = '<!--{$Config.domain_search}-->';
var DOMAIN_COMMENT = '<!--{$Config.domain_comment}-->';
var DOMAIN_STATIC = '<!--{$Config.domain_static}-->';
var open_vcode = <!--{if $Config.verify_code_close}-->false<!--{else}-->true<!--{/if}-->;
</script>
<link rel="stylesheet" type="text/css" href="<!--{$Config.domain_static}-->/css/global.css?v20080327" />
<script type="text/javascript" src="<!--{$Config.domain_static}-->/javascripts/mootools.js?v1.11.2"></script>
<script type="text/javascript" src="<!--{$Config.domain_static}-->/javascripts/global.js?v20080327"></script>
<script type="text/javascript" src="<!--{$Config.domain_static}-->/javascripts/menu.js?v20080318"></script>
</head>

<body>
<div class="bg">
<!-- Header -->
<div class="header clear">
<div class="logo left"><a href="<!--{$smarty.const.SITE_ROOT_PATH}-->/"><img src="<!--{$Config.domain_static}-->/images/logo.jpg" alt="<!--{$Config.site_name}-->" /></a></div>
<div class="nav right">
<div class="search_top clear">
<div class="search1" id="smenu_search" onmouseover="showMenu(this.id, true, 0, 2, 100)">&nbsp;</div>
<input type="hidden" id="searchToggler" value="keyword" />
<div class="search2"><input type="text" id="keyword" value="<!--{$Keyword}-->" onkeypress="doSearchEvent(event);" maxlength="100" /></div>
<div class="search3"><strong><a href="javascript:void(0);" onclick="doSearch();return false;">搜 索</a></strong></div>
<div class="search4"><a href="<!--{$Config.domain_search}-->">高级搜索</a></div>
<div class="search5"><a href="<!--{$Config.domain_vip}-->/user.php?o=post">内容发布</a></div>
</div>
<script type="text/javascript">
searchTogglers();
var anndelay = 5000;var anncount = 0;var annheight = 18;var annst = 0;
</script>
<div class="search_hot"><span class="left">热门搜索:&nbsp;</span><div id="searchkey" onmouseover="if(!anncount) {clearTimeout(annst);annst = 0}" onmouseout="if(!annst) annst = setTimeout('searchHotScroll()', anndelay);"><div id="searchkeybody"><script type="text/javascript" src="<!--{$Config.domain_www}-->/hot_search.js?v<!--{$smarty.const.TIME_NOW|date_format:'%Y%m%d'}-->"></script></div></div></div>
</div>
</div>
<!-- Header end -->

<ul class="popup_menu_search" id="smenu_search_menu" style="display:none;">
<li><a href="javascript:void(0);" class="skeyword" onclick="searchTogglers('keyword');return false;">标题</a></li>
<li><a href="javascript:void(0);" class="scontent" onclick="searchTogglers('content');return false;">内容</a></li>
<li><a href="javascript:void(0);" class="suser" onclick="searchTogglers('user');return false;">会员</a></li>
</ul>

<div class="nav_menu"><div>
	<span class="left"><a href="<!--{$smarty.const.SITE_ROOT_PATH}-->/">返回首页</a></span>
	<ul>
		<li><a href="<!--{$smarty.const.SITE_ROOT_PATH}-->/today.html">本日新增</a></li>
		<li><a href="<!--{$smarty.const.SITE_ROOT_PATH}-->/yesterday.html">昨日新增</a></li>
		<li><a href="#">在线影院</a></li>
	</ul>
</div></div>

<div class="main">
<!--{****** 空白行 ******}-->
<div style="margin-bottom:10px;"></div>

<!--{if $SortOne}-->
<table class="portalbox" cellpadding="0" cellspacing="1">
<tr>
<td class="btd" style="width:630px;">
<!--{if $SortOne}-->
<div class="program">
<!--{foreach item=sortid from=$SortOne}-->
	<!--{if $sortid neq $Config.announcement_sort_id}-->
	<div class="row">
		<div class="p1"><a href="<!--{if $SortList[$sortid].vip}--><!--{$Config.domain_vip}--><!--{else}--><!--{$smarty.const.SITE_ROOT_PATH}--><!--{/if}-->/sort-<!--{$sortid}-->-1.html"><!--{$SortList[$sortid].name}--></a></div>
		<div class="p2"><!--{foreach item=sid from=$SortTree[$sortid]}--><a<!--{if $SortList[$sid].external}--> target="_blank"<!--{/if}--> href="<!--{if $SortList[$sid].external}--><!--{$SortList[$sid].external}--><!--{else}--><!--{if $SortList[$sid].vip}--><!--{$Config.domain_vip}--><!--{else}--><!--{$smarty.const.SITE_ROOT_PATH}--><!--{/if}-->/sort-<!--{$sid}-->-1.html<!--{/if}-->"><!--{$SortList[$sid].name}--></a><!--{/foreach}--></div>
	</div>
	<!--{/if}-->
<!--{/foreach}-->
</div>
<!--{/if}-->
</td>
<td class="btd">
<div class="title"><h3><!--{$SortList[$Config.announcement_sort_id].name}--></h3><span class="right"><a href="<!--{$smarty.const.SITE_ROOT_PATH}-->/sort-<!--{$Config.announcement_sort_id}-->-1.html">更多</a></span></div>
<!--{if $SpecialSortData}-->
<ul class="announce">
<!--{foreach item=row from=$SpecialSortData}-->
<li><a href="<!--{$row.show_url}-->" target="_blank"><!--{$row.data_title}--></a></li>
<!--{/foreach}-->
</ul>
<!--{/if}-->
</td>
</tr>
</table>
<!--{/if}-->

<iframe id="iframe_center" src="<!--{$Config.domain_static}-->/iframe/center.html" width="100%" height="0" frameborder="0" marginheight="0" marginwidth="0" scrolling="no"></iframe>

<!--{if $SubNav}-->
<div class="sub_nav">您的位置：<a href="<!--{$smarty.const.SITE_ROOT_PATH}-->/">首页</a> &raquo; <!--{$SubNav}--></div>
<!--{/if}-->
