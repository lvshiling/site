<?php /* Smarty version 2.6.19, created on 2011-04-01 13:45:58
         compiled from header.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'date_format', 'header.tpl', 44, false),)), $this); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="Content-Language" content="zh-CN" />
<title><?php if ($this->_tpl_vars['SiteTitle']): ?><?php echo $this->_tpl_vars['SiteTitle']; ?>
 - <?php endif; ?><?php echo $this->_tpl_vars['Config']['site_name']; ?>
</title>
<meta name="robots" content="<?php if (@IN_SCRIPT == user): ?>none<?php else: ?>all<?php endif; ?>" />
<?php if ($this->_tpl_vars['Config']['meta_keywords']): ?>
<meta name="keywords" content="<?php echo $this->_tpl_vars['Config']['meta_keywords']; ?>
" />
<?php endif; ?>
<?php if ($this->_tpl_vars['Config']['meta_description']): ?>
<meta name="description" content="<?php echo $this->_tpl_vars['Config']['meta_description']; ?>
" />
<?php endif; ?>
<script type="text/javascript">
var DOMAIN_SEARCH = '<?php echo $this->_tpl_vars['Config']['domain_search']; ?>
';
var DOMAIN_COMMENT = '<?php echo $this->_tpl_vars['Config']['domain_comment']; ?>
';
var DOMAIN_STATIC = '<?php echo $this->_tpl_vars['Config']['domain_static']; ?>
';
var open_vcode = <?php if ($this->_tpl_vars['Config']['verify_code_close']): ?>false<?php else: ?>true<?php endif; ?>;
</script>
<link rel="stylesheet" type="text/css" href="<?php echo $this->_tpl_vars['Config']['domain_static']; ?>
/css/global.css?v20080327" />
<script type="text/javascript" src="<?php echo $this->_tpl_vars['Config']['domain_static']; ?>
/javascripts/mootools.js?v1.11.2"></script>
<script type="text/javascript" src="<?php echo $this->_tpl_vars['Config']['domain_static']; ?>
/javascripts/global.js?v20080327"></script>
<script type="text/javascript" src="<?php echo $this->_tpl_vars['Config']['domain_static']; ?>
/javascripts/menu.js?v20080318"></script>
</head>

<body>
<div class="bg">
<!-- Header -->
<div class="header clear">
<div class="logo left"><a href="<?php echo @SITE_ROOT_PATH; ?>
/"><img src="<?php echo $this->_tpl_vars['Config']['domain_static']; ?>
/images/logo.jpg" alt="<?php echo $this->_tpl_vars['Config']['site_name']; ?>
" /></a></div>
<div class="nav right">
<div class="search_top clear">
<div class="search1" id="smenu_search" onmouseover="showMenu(this.id, true, 0, 2, 100)">&nbsp;</div>
<input type="hidden" id="searchToggler" value="keyword" />
<div class="search2"><input type="text" id="keyword" value="<?php echo $this->_tpl_vars['Keyword']; ?>
" onkeypress="doSearchEvent(event);" maxlength="100" /></div>
<div class="search3"><strong><a href="javascript:void(0);" onclick="doSearch();return false;">搜 索</a></strong></div>
<div class="search4"><a href="<?php echo $this->_tpl_vars['Config']['domain_search']; ?>
">高级搜索</a></div>
<div class="search5"><a href="<?php echo $this->_tpl_vars['Config']['domain_vip']; ?>
/user.php?o=post">内容发布</a></div>
</div>
<script type="text/javascript">
searchTogglers();
var anndelay = 5000;var anncount = 0;var annheight = 18;var annst = 0;
</script>
<div class="search_hot"><span class="left">热门搜索:&nbsp;</span><div id="searchkey" onmouseover="if(!anncount) {clearTimeout(annst);annst = 0}" onmouseout="if(!annst) annst = setTimeout('searchHotScroll()', anndelay);"><div id="searchkeybody"><script type="text/javascript" src="<?php echo $this->_tpl_vars['Config']['domain_www']; ?>
/hot_search.js?v<?php echo ((is_array($_tmp=@TIME_NOW)) ? $this->_run_mod_handler('date_format', true, $_tmp, '%Y%m%d') : smarty_modifier_date_format($_tmp, '%Y%m%d')); ?>
"></script></div></div></div>
</div>
</div>
<!-- Header end -->

<ul class="popup_menu_search" id="smenu_search_menu" style="display:none;">
<li><a href="javascript:void(0);" class="skeyword" onclick="searchTogglers('keyword');return false;">标题</a></li>
<li><a href="javascript:void(0);" class="scontent" onclick="searchTogglers('content');return false;">内容</a></li>
<li><a href="javascript:void(0);" class="suser" onclick="searchTogglers('user');return false;">会员</a></li>
</ul>

<div class="nav_menu"><div>
	<span class="left"><a href="<?php echo @SITE_ROOT_PATH; ?>
/">返回首页</a></span>
	<ul>
		<li><a href="<?php echo @SITE_ROOT_PATH; ?>
/today.html">本日新增</a></li>
		<li><a href="<?php echo @SITE_ROOT_PATH; ?>
/yesterday.html">昨日新增</a></li>
		<li><a href="#">在线影院</a></li>
	</ul>
</div></div>

<div class="main">
<div style="margin-bottom:10px;"></div>

<?php if ($this->_tpl_vars['SortOne']): ?>
<table class="portalbox" cellpadding="0" cellspacing="1">
<tr>
<td class="btd" style="width:630px;">
<?php if ($this->_tpl_vars['SortOne']): ?>
<div class="program">
<?php $_from = $this->_tpl_vars['SortOne']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['sortid']):
?>
	<?php if ($this->_tpl_vars['sortid'] != $this->_tpl_vars['Config']['announcement_sort_id']): ?>
	<div class="row">
		<div class="p1"><a href="<?php if ($this->_tpl_vars['SortList'][$this->_tpl_vars['sortid']]['vip']): ?><?php echo $this->_tpl_vars['Config']['domain_vip']; ?>
<?php else: ?><?php echo @SITE_ROOT_PATH; ?>
<?php endif; ?>/sort-<?php echo $this->_tpl_vars['sortid']; ?>
-1.html"><?php echo $this->_tpl_vars['SortList'][$this->_tpl_vars['sortid']]['name']; ?>
</a></div>
		<div class="p2"><?php $_from = $this->_tpl_vars['SortTree'][$this->_tpl_vars['sortid']]; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['sid']):
?><a<?php if ($this->_tpl_vars['SortList'][$this->_tpl_vars['sid']]['external']): ?> target="_blank"<?php endif; ?> href="<?php if ($this->_tpl_vars['SortList'][$this->_tpl_vars['sid']]['external']): ?><?php echo $this->_tpl_vars['SortList'][$this->_tpl_vars['sid']]['external']; ?>
<?php else: ?><?php if ($this->_tpl_vars['SortList'][$this->_tpl_vars['sid']]['vip']): ?><?php echo $this->_tpl_vars['Config']['domain_vip']; ?>
<?php else: ?><?php echo @SITE_ROOT_PATH; ?>
<?php endif; ?>/sort-<?php echo $this->_tpl_vars['sid']; ?>
-1.html<?php endif; ?>"><?php echo $this->_tpl_vars['SortList'][$this->_tpl_vars['sid']]['name']; ?>
</a><?php endforeach; endif; unset($_from); ?></div>
	</div>
	<?php endif; ?>
<?php endforeach; endif; unset($_from); ?>
</div>
<?php endif; ?>
</td>
<td class="btd">
<div class="title"><h3><?php echo $this->_tpl_vars['SortList'][$this->_tpl_vars['Config']['announcement_sort_id']]['name']; ?>
</h3><span class="right"><a href="<?php echo @SITE_ROOT_PATH; ?>
/sort-<?php echo $this->_tpl_vars['Config']['announcement_sort_id']; ?>
-1.html">更多</a></span></div>
<?php if ($this->_tpl_vars['SpecialSortData']): ?>
<ul class="announce">
<?php $_from = $this->_tpl_vars['SpecialSortData']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['row']):
?>
<li><a href="<?php echo $this->_tpl_vars['row']['show_url']; ?>
" target="_blank"><?php echo $this->_tpl_vars['row']['data_title']; ?>
</a></li>
<?php endforeach; endif; unset($_from); ?>
</ul>
<?php endif; ?>
</td>
</tr>
</table>
<?php endif; ?>

<iframe id="iframe_center" src="<?php echo $this->_tpl_vars['Config']['domain_static']; ?>
/iframe/center.html" width="100%" height="0" frameborder="0" marginheight="0" marginwidth="0" scrolling="no"></iframe>

<?php if ($this->_tpl_vars['SubNav']): ?>
<div class="sub_nav">您的位置：<a href="<?php echo @SITE_ROOT_PATH; ?>
/">首页</a> &raquo; <?php echo $this->_tpl_vars['SubNav']; ?>
</div>
<?php endif; ?>