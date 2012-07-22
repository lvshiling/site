// type: 0反对 1支持 2举报
function commentVote(id, type)
{
	var c_name = 'vote'+ (2==type.toInt()?type:'') + id;
	if (Cookie.get(c_name))
	{
		commentVoteStatus(id, type, 'exists');
		return false;
	}

	var myAjax = new Ajax('ajax.php', {
		method:'post', 
		data:{
			act: 'vote', 
			id: id, 
			type: type
		}, 
		onFailure:function(){commentVoteStatus(id, type, 'error')}, 
		onComplete:function(){commentVoteStatus(id, type, this.response.text)}
	}).request();
}
function commentVoteStatus(id, type, status)
{
	$('func_msg_'+ id).style.display = 'inline';

	if ('succeed' == status)
	{
		if ('2' != type)
		{
			var _v_id = 'vote_'+ type +'_'+ id;
			$(_v_id).setText($(_v_id).getText().toInt() + 1);
		}

		var c_name = 'vote'+ (2==type.toInt()?type:'') + id;
		Cookie.set(c_name, true, {duration: 365});

		$('func_msg_'+ id).empty().setHTML(type=='2'?'感谢您的举报':'感谢您的参与');
	}
	else if ('exists' == status)
	{
		$('func_msg_'+ id).empty().setHTML(type=='2'?'请勿重复举报':'您已经投过票了');
	}
	else
	{
		status = 'error';
		$('func_msg_'+ id).empty().setHTML('系统错误,请稍后再试');
	}

	$('func_msg_'+ id).className = status;
	// 2秒后隐藏
	(function(){this.style.display = 'none';}).delay(3000, $('func_msg_'+ id));
}

function commentQuote(id)
{
	$('quote_id').value = id;
	$('quote_object').setHTML('引用回复网友:'+ $('user_location_'+ id).getText() +'发表的评论&nbsp;&nbsp;<a href="javascript:void(0);" onclick="commentQuoteCancel();return false;">取消引用</a>');
	$('content').focus();
}
function commentQuoteCancel()
{
	$('quote_id').value = 0;
	$('quote_object').empty();
}

function displayVimg()
{
	if ('none' == $('imgarea').style.display)
	{
		$('imgarea').style.display = '';
		imgRefresh('comment');
	}
}

function checkFormData()
{
	var content = $F('content').trim();
	if ('' == content)
	{
		alert('评论内容不能为空！');
		$('content').focus();
		return false;
	}
	if (comment_max_length < content.length)
	{
		alert('评论内容长度超过限制！');
		$('content').focus();
		return false;
	}
	if (open_vcode)
	{
		if ('' == $F('vcode').trim())
		{
			alert('没有输入验证码！');
			$('vcode').focus();
			return false;
		}
	}

	if ('none' == $('imgarea').style.display)
	{
		displayVimg();
		return false;
	}

	$('submit').value = Lang['submit'];
	$('submit').disabled = true;
	return true;
}

// 插入表情图片
function insertSmilie(num)
{
	// 表情数量不能超过10个
	var c_text = $('content').getText();
	if ('' != c_text)
	{
		var result = c_text.match(/\[smilie\:\d+\]/ig);
		if (result && 10 <= result.length)
		{
			return false;
		}
	}

	var txt = '[smilie:'+ num +']';

	$('content').focus();

	var obj = $('content');
	selection = document.selection;
	if (typeof obj.selectionStart != 'undefined')
	{
		obj.value = obj.value.substr(0, obj.selectionStart) + txt + obj.value.substr(obj.selectionEnd);
	}
	else if (selection && selection.createRange)
	{
		var sel = selection.createRange();
		sel.text = txt;
	}
	else
	{
		obj.value += txt;
	}
}

if (0 === comment_close && is_login)
{
	$('content').addEvent('focus', function(){displayVimg()});
	$('vcode').addEvent('focus', function(){displayVimg()});
}