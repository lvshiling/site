var jsmenu = new Array();
var ctrlobjclassName;
jsmenu['active'] = new Array();
jsmenu['timer'] = new Array();
jsmenu['iframe'] = new Array();

function initCtrl(ctrlobj, click, duration, timeout, layer) {
	if(ctrlobj && !ctrlobj.initialized) {
		ctrlobj.initialized = true;
		ctrlobj.unselectable = true;

		ctrlobj.outfunc = typeof ctrlobj.onmouseout == 'function' ? ctrlobj.onmouseout : null;
		ctrlobj.addEvent('mouseout', function(){
			if(this.outfunc) this.outfunc();
			if(duration < 3) jsmenu['timer'][ctrlobj.id] = setTimeout('hideMenu(' + layer + ')', timeout);
		});

		if(click && duration) {
			ctrlobj.clickfunc = typeof ctrlobj.onclick == 'function' ? ctrlobj.onclick : null;
			ctrlobj.addEvent('click', function (event) {
				var event = new Event(event);
				event.stopPropagation();
				event.preventDefault();
				if(jsmenu['active'][layer] == null || jsmenu['active'][layer].ctrlkey != this.id) {
					if(this.clickfunc) this.clickfunc();
					else showMenu(this.id, true);
				} else {
					hideMenu(layer);
				}
			});
		}

		ctrlobj.overfunc = typeof ctrlobj.onmouseover == 'function' ? ctrlobj.onmouseover : null;
		ctrlobj.addEvent('mouseover', function(event) {
			var event = new Event(event);
			event.stopPropagation();
			event.preventDefault();
			if(this.overfunc) this.overfunc();
			if(click) {
				$clear(jsmenu['timer'][this.id]);
			} else {
				for(var id in jsmenu['timer']) {
					//if(jsmenu['timer'][id]) $clear(jsmenu['timer'][id]);
				}
			}
		});
	}
}

function initMenu(ctrlid, menuobj, duration, timeout, layer) {
	if(menuobj && !menuobj.initialized) {
		menuobj.initialized = true;
		menuobj.ctrlkey = ctrlid;
		menuobj.addEvent('click', ebygum);
		menuobj.setStyle('position', 'absolute');
		if(duration < 3) {
			if(duration > 1) {
				menuobj.addEvent('mouseover', function(){
					$clear(jsmenu['timer'][ctrlid]);
				});
			}
			if(duration != 1) {
				menuobj.addEvent('mouseout', function(){
					jsmenu['timer'][ctrlid] = setTimeout('hideMenu(' + layer + ')', timeout);
				});
			}
		}
		menuobj.setStyle('zIndex', 50);
	}
}

function showMenu(ctrlid, click, offset, duration, timeout, layer, showid, maxh) {
	e = window.event ? window.event : showMenu.caller.arguments[0];
	var ctrlobj = $(ctrlid);
	if(!ctrlobj) return;
	if(typeof(click) == 'undefined') click = false;
	if(typeof(offset) == 'undefined') offset = 0;
	if(typeof(duration) == 'undefined') duration = 2;
	if(typeof(timeout) == 'undefined') timeout = 500;
	if(typeof(layer) == 'undefined') layer = 0;
	if(typeof(showid) == 'undefined') showid = ctrlid;
	var showobj = $(showid);
	var menuobj = $(showid + '_menu');
	if(!showobj|| !menuobj) return;
	if(typeof(maxh) == 'undefined') maxh = 400;

	hideMenu(layer);

	for(var id in jsmenu['timer']) {
		//if(jsmenu['timer'][id]) $clear(jsmenu['timer'][id]);
	}

	initCtrl(ctrlobj, click, duration, timeout, layer);
	ctrlobjclassName = ctrlobj.className;
	ctrlobj.className += ' hover';
	initMenu(ctrlid, menuobj, duration, timeout, layer);

	menuobj.setStyle('display', '');
	if(!window.opera) {
		menuobj.setStyle('clip', 'rect(auto, auto, auto, auto)');
	}

	setMenuPosition(showid, offset);

	/*
	if(window.ie && !window.ie7) {
		if(!jsmenu['iframe'][layer]) {
			var iframe = document.createElement('iframe');
			iframe.setStyles({
				display: 'none',
				position: 'absolute',
				filter: 'progid:DXImageTransform.Microsoft.Alpha(style=0,opacity=0)'
			});
			$('append_parent') ? $('append_parent').appendChild(iframe) : menuobj.parentNode.appendChild(iframe);
			jsmenu['iframe'][layer] = iframe;
		}
		jsmenu['iframe'][layer].setStyles({
			top: menuobj.style.top,
			left: menuobj.style.left,
			width: menuobj.w,
			height: menuobj.h,
			display: 'block'
		});
	}
	*/

	if(maxh && menuobj.scrollHeight > maxh) {
		menuobj.setStyle('height', maxh + 'px');
		if(window.opera) {
			menuobj.setStyle('overflow', 'auto');
		} else {
			menuobj.setStyle('overflowY', 'auto');
		}
	}

	if(!duration) {
		setTimeout('hideMenu(' + layer + ')', timeout);
	}

	jsmenu['active'][layer] = menuobj;
}

function setMenuPosition(showid, offset) {
	var showobj = $(showid);
	var menuobj = $(showid + '_menu');
	if(typeof(offset) == 'undefined') offset = 0;
	if(showobj) {
		showobj.pos = showobj.getPosition();
		showobj.X = showobj.pos['x'];
		showobj.Y = showobj.pos['y'];
		showobj.w = showobj.offsetWidth;
		showobj.h = showobj.offsetHeight;
		menuobj.w = menuobj.offsetWidth;
		menuobj.h = menuobj.offsetHeight;

		var left = (showobj.X + menuobj.w > document.body.clientWidth) && (showobj.X + showobj.w - menuobj.w >= 0) ? showobj.X + showobj.w - menuobj.w : showobj.X;
		var top = offset == 1 ? showobj.Y : (offset == 2 || ((showobj.Y + showobj.h + menuobj.h > document.documentElement.scrollTop + document.documentElement.clientHeight) && (showobj.Y - menuobj.h >= 0)) ? (showobj.Y - menuobj.h) : showobj.Y + showobj.h);

		if (!window.ie)
		{
			top -= 12;
		}
		if (window.ie)
		{
			left -= 40;
		}

		menuobj.setStyle('left', left);
		menuobj.setStyle('top', top);

		if(menuobj.style.clip && !window.opera) {
			menuobj.style.clip = 'rect(auto, auto, auto, auto)';
		}
	}
}

function hideMenu(layer) {
	if(typeof(layer) == 'undefined') layer = 0;
	if(jsmenu['active'][layer]) {
		try {
			$(jsmenu['active'][layer].ctrlkey).className = ctrlobjclassName;
		} catch(e) {}
		$clear(jsmenu['timer'][jsmenu['active'][layer].ctrlkey]);
		jsmenu['active'][layer].setStyle('display', 'none');
		if(window.ie && !window.ie7 && jsmenu['iframe'][layer]) {
			jsmenu['iframe'][layer].setStyle('display', 'none');
		}
		jsmenu['active'][layer] = null;
	}
}

function ebygum(eventobj) {
	if(!eventobj || window.ie) {
		window.event.cancelBubble = true;
		return window.event;
	} else {
		if(eventobj.target.type == 'submit') {
			eventobj.target.form.submit();
		}
		eventobj.stopPropagation();
		return eventobj;
	}
}
/*
function menuoption_onclick_function(e) {
	this.clickfunc();
	hideMenu();
}

function menuoption_onclick_link(e) {
	choose(e, this);
}

function menuoption_onmouseover(e) {
	this.className = 'popupmenu_highlight';
}

function menuoption_onmouseout(e) {
	this.className = 'popupmenu_option';
}

function choose(e, obj) {
	var links = obj.getElementsByTagName('a');
	if(links[0]) {
		if(window.ie) {
			links[0].click();
			window.event.cancelBubble = true;
		} else {
			if(e.shiftKey) {
				window.open(links[0].href);
				e.stopPropagation();
				e.preventDefault();
			} else {
				window.location = links[0].href;
				e.stopPropagation();
				e.preventDefault();
			}
		}
		hideMenu();
	}
}
*/