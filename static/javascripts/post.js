function executePreview()
{
	var contents = getIntro();
	if ('' == contents.trim())
	{
		alert('没有可预览内容！');
		return false;
	}

	document.preview.preview_content.value = contents;
	document.preview.submit();
}

function checkFormData()
{
	if ('' == $F('title').trim())
	{
		alert('请填写标题！');
		$('title').focus();
		return false;
	}
	if (0 == $F('sort_id'))
	{
		alert('没有选择类别或选择的类别不允许发表信息！');
		$('sort_id').focus();
		return false;
	}
	var title_length = cnLength($F('title'));
	if (title_max_length < title_length || title_length < title_least_length)
	{
		alert('标题长度请限制在 '+ title_least_length +' - '+ title_max_length +' 字符以内！');
		$('title').focus();
		return false;
	}
	var content = getIntro();
	var content_length = cnLength(content);
	if (content_max_length < content_length)
	{
		alert('正文长度请限制在 '+ content_max_length +' 字符以内！');
		return false;
	}
	if (0 < content_length)
	{
		var result = content.match(/<div style="page-break-after: always;?"><span style="display: none;?">&nbsp;<\/span><\/div>/ig);
		if (result && max_multipage_num <= result.length)
		{
			alert('最多只能设置 '+ max_multipage_num +' 页，请修改后再提交！');
			return false;
		}
	}

	/*
	if (open_vcode)
	{
		if ('post' == Action && '' == $F('vcode').trim())
		{
			alert('请填写验证码！');
			$('vcode').focus();
			return false;
		}
	}
	*/

	$('submit').value = Lang['submit'];
	$('submit').disabled = true;
	return true;
}

function getIntro()
{
	return FCKeditorAPI.GetInstance('content').GetXHTML(true);
}

function checkLength()
{
	alert('当前长度：'+ cnLength(getIntro()) +'，允许的长度：'+ content_max_length);
}

/*
var aid = 1;
var thumbwidth = 400;
var thumbheight = 300;
var attachwh = new Array();

function delUpic(id)
{
	$('upicbody').removeChild($('upic_' + id).parentNode.parentNode);
	$('upicbody').innerHTML == '' && addUpic();
	$('localimgpreview_' + id + '_menu') ? document.body.removeChild($('localimgpreview_' + id + '_menu')) : null;
}
function addUpic()
{
	newnode = $('upicbodyhidden').getFirst().cloneNode(true);
	var id = aid;
	var _tags;
	_tags = newnode.getElementsByTagName('input');
	for (i in _tags)
	{
		if (_tags[i].name == 'upic[]')
		{
			_tags[i].id = 'upic_' + id;
			_tags[i].size = 40;
			_tags[i].onkeydown = 'return false;';
			_tags[i].oncontextmenu = 'return false;';
			_tags[i].onchange = function(){insertUpic(id)};
			_tags[i].unselectable = 'on';
		}
	}
	_tags = newnode.getElementsByTagName('span');
	for (i in _tags)
	{
		if (_tags[i].id == 'localfile[]')
		{
			_tags[i].id = 'localfile_' + id;
		}
	}
	aid++;
	$('upicbody').appendChild(newnode);
}
addUpic();

function insertUpic(id)
{
	var path = $('upic_' + id).value;

	if ('' == path) return;

	var ext = path.lastIndexOf('.') == -1 ? '' : path.substr(path.lastIndexOf('.') + 1, path.length).toLowerCase();
	if ('gif' != ext && 'jpg' != ext && 'jpeg' != ext && 'png' != ext &&  'bmp' != ext)
	{
		alert('不是一个有效的图片格式！');
		return;
	}

	if (most_upic_num < $('upicbody').getElementsByTagName('input').length)
	{
		return;
	}

	if (window.ie)
	{
		$('img_hidden').alt = id;
		$('img_hidden').filters.item("DXImageTransform.Microsoft.AlphaImageLoader").sizingMethod = 'image';
		try {
			$('img_hidden').filters.item("DXImageTransform.Microsoft.AlphaImageLoader").src = $('upic_' + id).value;
		} catch (e) {
			alert('无效的图片格式');
			return;
		}
		var wh = {'w' : $('img_hidden').offsetWidth, 'h' : $('img_hidden').offsetHeight};
		var aid = $('img_hidden').alt;
		if(wh['w'] >= thumbwidth || wh['h'] >= thumbheight) {
			wh = upicthumbImg(wh['w'], wh['h']);
		}
		attachwh[id] = wh;
		$('img_hidden').style.width = wh['w']
		$('img_hidden').style.height = wh['h'];
		$('img_hidden').filters.item("DXImageTransform.Microsoft.AlphaImageLoader").sizingMethod = 'scale';
		div = document.createElement('div');
		div.id = 'localimgpreview_' + id + '_menu';
		div.style.display = 'none';
		div.style.marginLeft = '20px';
		div.className = 'popupmenu_popup';
		document.body.appendChild(div);
		div.innerHTML = '<img style="filter:progid:DXImageTransform.Microsoft.AlphaImageLoader(sizingMethod=\'scale\',src=\'' + $('upic_' + id).value+'\');width:'+wh['w']+';height:'+wh['h']+'" src=\''+ DOMAIN_STATIC +'/images/none.gif\' border="0" aid="upic_'+ aid +'" alt="" />';
	}

	var localfile = $('upic_' + id).value.substr($('upic_' + id).value.replace(/\\/g, '/').lastIndexOf('/') + 1);

	$('localfile_' + id).innerHTML = '<a href="javascript:void(0);" onclick="delUpic(' + id + ');return false;">[删除]</a> '+(window.ie ? '<span id="localimgpreview_' + id + '" onmouseover="showMenu(this.id, 0, 0, 1, 0)">'+ localfile +'</span>' : localfile);
	$('upic_' + id).setStyle('display', 'none');

	addUpic();
}

function upicthumbImg(w, h, twidth, theight)
{
	twidth = !twidth ? thumbwidth : twidth;
	theight = !theight ? thumbheight : theight;
	var x_ratio = twidth / w;
	var y_ratio = theight / h;
	var wh = new Array();
	if((x_ratio * h) < theight)
	{
		wh['h'] = Math.ceil(x_ratio * h);
		wh['w'] = twidth;
	}
	else
	{
		wh['w'] = Math.ceil(y_ratio * w);
		wh['h'] = theight;
	}
	return wh;
}
*/