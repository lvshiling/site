var Lang = new Array();
Lang['no_select'] = '没有选择任何数据！';
Lang['delete'] = '确定要将选择的数据删除吗？';
Lang['submit'] = '数据正在提交';

function $(o){return document.getElementById(o);}
function $F(o){return $(o).value;}

function checkFormData()
{
	$('submit').value = Lang['submit'];
	$('submit').disabled = true;
	return true;
}

function cnLength(str)
{
	if ('' == str) return 0;

	var arr = str.match(/[^\x00-\xff]/ig);

	return str.length + (arr == null ? 0 : arr.length);
}

function selectAll(flag)
{
	//var fname = document.form1;
	var o = document.getElementsByName('data_id[]');
	var len = o.length;
	for (var i = 0; i < len; i++)
	{
		//if ('checkbox' != o.type) continue;

		o[i].checked = flag;

		marked_row = new Array;
		setPointer($('row_'+ i), i, (flag ? 'click' : 'out'));
	}
}
function againstSelect()
{
	//var fname = document.form1;
	var o = document.getElementsByName('data_id[]');
	var len = o.length;
	for (var i = 0; i < len; i++)
	{
		var flag = !o[i].checked;
		o[i].checked = flag;

		marked_row = new Array;
		setPointer($('row_'+ i), i, (flag ? 'click' : 'out'));
	}
}

function executeOperate()
{
	var fname = document.form1;

	var s_type = fname.op.value;

	if ('' == s_type) return false;

	tag = false;
	for (var i = 0; i < fname.elements.length; i++)
	{
		if ('checkbox' == fname.elements[i].type && fname.elements[i].checked)
		{
			tag = true;
			break;
		}
	}

	if (false === tag)
	{
		fname.op.options[0].selected = true;
		alert(Lang['no_select']);
		return false;
	}

	if ('delete' == s_type)
	{
		if (false == confirm(Lang['delete']))
		{
			fname.op.options[0].selected = true;
			return false;
		}
	}

	fname.submit();
}

var marked_row = new Array;
function setPointer(theRow, theRowNum, theAction)
{
	var theCells = null;

	var theMarkClass = 'highlight';

	var theDefaultClass = "alt1";
	if ((theRowNum + 1)%2 == 0)
	{
		theDefaultClass = "alt2";
	}

	// 1. Pointer and mark feature are disabled or the browser can't get the
	//    row -> exits
	if (typeof(theRow.style) == 'undefined')
	{
		return false;
	}

	// 2. Gets the current row and exits if the browser can't get it
	if (typeof(document.getElementsByTagName) != 'undefined')
	{
		theCells = theRow.getElementsByTagName('td');
	}
	else if (typeof(theRow.cells) != 'undefined')
	{
		theCells = theRow.cells;
	}
	else
	{
		return false;
	}

	// 3. Gets the current Class...
	var rowCellsCnt  = theCells.length;
	var domDetect    = null;
	var currentClass = null;
	var newClass     = null;
	// 3.1 ... with DOM compatible browsers except Opera that does not return
	//         valid values with "getAttribute"
	if (typeof(window.opera) == 'undefined' && typeof(theCells[0].getAttribute) != 'undefined')
	{
		// setAttribute
		currentClass = theCells[0].className;
		domDetect    = true;
	}
	// 3.2 ... with other browsers
	else
	{
		currentClass = theCells[0].className;
		domDetect    = false;
	} // end 3

	// 4. Defines the new Class
	// 4.1 Current Class is the default one
	if (currentClass == '' || currentClass.toLowerCase() == theDefaultClass.toLowerCase())
	{
		if (theAction == 'click')
		{
			newClass = theMarkClass;
			marked_row[theRowNum] = true;
			// Garvin: deactivated onclick marking of the checkbox because it's also executed
			// when an action (like edit/delete) on a single item is performed. Then the checkbox
			// would get deactived, even though we need it activated. Maybe there is a way
			// to detect if the row was clicked, and not an item therein...
			// document.getElementById('id_rows_to_delete' + theRowNum).checked = true;
		}
	}
	// 4.1.2 Current Class is the pointer one
	else if (typeof(marked_row[theRowNum]) == 'undefined' || !marked_row[theRowNum])
	{
		if (theAction == 'out')
		{
			newClass              = theDefaultClass;
		}
		else if (theAction == 'click' && theMarkClass != '')
		{
			newClass              = theMarkClass;
			marked_row[theRowNum] = true;
			// document.getElementById('id_rows_to_delete' + theRowNum).checked = true;
		}
	}
	// 4.1.3 Current Class is the marker one
	else if (currentClass.toLowerCase() == theMarkClass.toLowerCase())
	{
		if (theAction == 'click')
		{
			newClass              = theDefaultClass;
			marked_row[theRowNum] = (typeof(marked_row[theRowNum]) == 'undefined' || !marked_row[theRowNum])
                                  ? true
                                  : null;
			// document.getElementById('id_rows_to_delete' + theRowNum).checked = false;
		}
	} // end 4

	var mark_id = $('mark_box_'+ theRowNum);
	if (mark_id)
	{
		if (theMarkClass == newClass)
		{
			mark_id.checked = true;
		}
		else
		{
			mark_id.checked = false;
		}
	}

	// 5. Sets the new Class...
	if (newClass)
	{
		var c = null;
		// 5.1 ... with DOM compatible browsers except Opera
		if (domDetect)
		{
			for (c = 0; c < rowCellsCnt; c++)
			{
				// setAttribute
				theCells[c].className = newClass;
			} // end for
		}
		// 5.2 ... with other browsers
		else
		{
			for (c = 0; c < rowCellsCnt; c++)
			{
				theCells[c].className = newClass;
			}
		}
	} // end 5

	return true;
}
