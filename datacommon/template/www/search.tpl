<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="Content-Language" content="zh-CN" />
<title><!--{if $SiteTitle}--><!--{$SiteTitle}--> - <!--{/if}--><!--{$Config.site_name}--></title>
<meta name="robots" content="all" />
<link rel="stylesheet" type="text/css" href="<!--{$Config.domain_static}-->/css/global.css?v20080318" />
<script type="text/javascript" src="<!--{$Config.domain_static}-->/javascripts/mootools.js?v20080318"></script>
<script type="text/javascript" src="<!--{$Config.domain_static}-->/javascripts/global.js?v20080318"></script>
<style>
.adv_search{margin:0 auto;margin-top:10px;padding:10px;width:500px;overflow:hidden;}
.adv_search .formInput{padding:4px;}
</style>
<script type="text/javascript">
function submitFormData()
{
	var keyword = $F('keyword');
	if ('' == keyword)
	{
		alert('没有输入搜索关键词！');
		$('keyword').focus();
		return false;
	}

	$('submit').value = Lang['submit'];
	$('submit').disabled = true;
}
function syncDisplay()
{
	$('sync_keyword').innerHTML = $('keyword').value;
}
</script>
</head>

<body>
<div class="bg">
<div class="top_menu">
<p class="left">&nbsp;</p>
<p class="right"><a href="<!--{$Config.domain_www}-->">返回首页</a></p>
</div>

<div class="adv_search text_center">
<form onsubmit="return submitFormData();">
<input type="text" id="keyword" name="keyword" class="formInput" size="60" maxlength="100" onkeyup="syncDisplay();" />
<p>在&nbsp;<select id="sort_id" name="sort_id"><option value="0">所有</option><!--{$SortOption}--></select>&nbsp;分类下搜索&nbsp;<select><option value="title">标题</option></select>&nbsp;中</p>
<p>包含&nbsp;<strong><u><span id="sync_keyword">您所输入的关键词</span></u></strong>&nbsp;的资源</p>
<input type="submit" id="submit" class="formButton" value=" 搜索资源 " />
</form>
</div>

<div class="footer text_center">
<p><a href="#">联系我们</a> - <a href="<!--{$Config.domain_comment}-->/report.php" target="_blank">意见反馈</a></p>
<p>Copyright &copy;2008&nbsp;<a href="#" target="_blank" class="copyright">1234</a>. All rights reserved.</p>
</div>

</div>

</body>
</html>