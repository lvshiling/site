var Dlg = null;
var Config = new Array();
var Lang = new Array();
Lang['submit'] = '数据正在提交';
Lang['expand'] = '展开';
Lang['collapse'] = '收缩';
Lang['open_image'] = '点击在新窗口查看完整图片';

function $F(o){return $(o).value;}

function checkFormData()
{
	$('submit').value = Lang['submit'];
	$('submit').disabled = true;
	return true;
}

// 表格高亮
function highlight(o)
{
	var c_css_name = o.className;
	o.className = 'heightlight';
	o.onmouseout = function(){
		o.className = c_css_name;
	};
}

// 刷新图片验证码
function imgRefresh(name)
{
	$('vimg').src = '/vimg.php?n='+ name +'&'+ $time();
}

// 统计字符长度
function cnLength(str)
{
	if ('' == str) return 0;

	var arr = str.match(/[^\x00-\xff]/ig);

	return str.length + (arr == null ? 0 : arr.length);
}

function imgResize(o, size)
{
	if (o.width > size)
	{
		o.width = size;
		//o.title = Lang['open_image'];
		//o.setStyle('cursor', 'hand');
		//o.onclick = function(){window.open(o.src)};
	}
}

function doSearchEvent(e)
{
	if (13 == e.keyCode) doSearch();
}
function doSearch()
{
	var searchToggler = $F('searchToggler');
	var keyword = $F('keyword').trim();
	if ('' == keyword) return;

	Document.location = DOMAIN_SEARCH +'/?'+ searchToggler +'='+ encodeURI(keyword);
}

function searchTogglers(object)
{
	var c_object = Cookie.get('searchToggler');

	if (false === $type(object))
	{
		if (c_object) object = c_object;
		else object = 'keyword';
	}

	if (c_object != object)
	{
		Cookie.set('searchToggler', object, {path:'/'});
	}

	var bg_img_position = 'keyword' == object ? '0 0' : ('content' == object ? '0 -26px' : '0 -52px');
	$('smenu_search').setStyle('background-position', bg_img_position);
	$('searchToggler').value = object;
	$('keyword').focus();

	hideMenu();
}

function addFavorite(title, url)
{
	if ('undefined' == typeof(title))
	{
		title = Document.location.href;
	}
	if ('undefined' == typeof(url))
	{
		url = Document.location.href;
	}

	if (true == window.ie)
	{
		// ie
		window.external.addFavorite(url, title);
	}
	else if (window.sidebar)
	{
		// Gecko
		window.sidebar.addPanel(title, url, '');
	}
	else
	{
		alert('您使用的浏览器不支持此操作，请手动添加！');
	}
}

function searchHotScroll()
{
	if (!annst)
	{
		$('searchkeybody').innerHTML += '<br style="clear: both" />' + $('searchkeybody').innerHTML;
		$('searchkeybody').scrollTop = 0;
		if ($('searchkeybody').scrollHeight > annheight * 3)
		{
			annst = searchHotScroll.delay(anndelay);
		}
		else
		{
			$('searchkey').onmouseover = $('searchkey').onmouseout = null;
		}
		return;
	}
	if (anncount == annheight)
	{
		if ($('searchkeybody').scrollHeight - annheight <= $('searchkeybody').scrollTop)
		{
			$('searchkeybody').scrollTop = $('searchkeybody').scrollHeight / 2 - annheight;
		}
		anncount = 0;
		annst = searchHotScroll.delay(anndelay);
	}
	else
	{
		$('searchkeybody').scrollTop++;
		anncount++;
		annst = searchHotScroll.delay(10);
	}
}

function reportWindow(url)
{
	window.open(DOMAIN_COMMENT +'/report.php?url='+ url, 'report', 'height=290, width=530');
}