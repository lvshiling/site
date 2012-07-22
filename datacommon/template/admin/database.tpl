<!--{include file="header.tpl"}-->

<div class="table clear">
<div class="f_nav">
程序用于批量替换数据库中某字段的内容，此操作极为危险，请小心使用。
</div>
</div>

<script type="text/javascript">
var request = false;
function myAjax()
{
    try {
        request = new XMLHttpRequest();
    } catch (trymicrosoft) {
        try {
            request = new ActiveXObject("Msxml2.XMLHTTP");
        } catch (othermicrosoft) {
            try {
                request = new ActiveXObject("Microsoft.XMLHTTP");
            } catch (failed) {
                request = false;
            }
        }
    }
    if (!request) alert("Error initializing XMLHttpRequest!");
}
function ShowFields()
{
	var exptable = document.getElementById("exptable").value;
	document.getElementById('tablename').innerHTML = exptable;

	myAjax();

	var ParamString = 'op=field&exptable='+ exptable;
    var url = 'database.php';
    request.open("POST", url, true);
	request.setRequestHeader("Content-Type","application/x-www-form-urlencoded;");
    request.onreadystatechange = updateField;
    request.send(ParamString);
}
function updateField()
{

    var fields = document.getElementById("fields");
	if (request.readyState == 4) {
		if (request.status == 200) {
			fields.innerHTML = request.responseText;
			document.getElementById("field").value = '';
		}
	}
}
function selectField(v)
{
	document.getElementById("field").value = v;
}

function CheckSubmit()
{
	if (document.getElementById("exptable").value == "")
	{
		alert("没有选择替换的数据表");
		return false;
	}
	if (document.getElementById("field").value == "")
	{
		alert("没有选择替换的字段");
		return false;
	}
	if (document.getElementById("rpstring").value == "" || document.getElementById("tostring").value == "")
	{
		alert("没有正确填写替换内容");
		return false;
	}
	return true;
}
</script>

<div class="table clear">
<form name="form1" method="post" onsubmit="return CheckSubmit()">
<input type="hidden" name="op" value="replace" />
<table class="list_style" cellpadding="0" cellspacing="0" border="1" frame="void">
  <tr>
    <td colspan="2" class="theader">举报信息(共&nbsp;<!--{$totalnum}-->&nbsp;条记录)</td>
  </tr>
  <tr class="alt1">
	<td width="150" nowrap="nowrap" align="right">选择数据表和字段</td>
	<td nowrap="nowrap" align="left">
		<select name='exptable' id='exptable' size='10' style="width:300px;height:100px;" class="formInput" onchange='ShowFields();'>
			<!--{foreach item=table from=$Tables}-->
			<option value='<!--{$table}-->'><!--{$table}--></option>
			<!--{/foreach}-->
		</select>
		<div style="margin-top:4px;border:1px solid #DDD;padding:4px;width:400px;">表(<span id="tablename">-</span>)含有的字段<div style="margin-top:4px;border-top:1px solid #DDD;"></div><span id="fields" style="display:block;width:200px;line-height:24px;"></span></div>
		要替换的字段：<input type="text" id="field" name="field" readonly="readonly" class="formInput" style="width:100px;" />
	</td>
  </tr>
  <tr class="alt2">
	<td width="150" nowrap="nowrap" align="right">被替换内容</td>
	<td nowrap="nowrap" align="left"><textarea name="rpstring" id="rpstring" style="width:300px;height:80px;" class="formInput"></textarea></td>
  </tr>
  <tr class="alt1">
	<td width="150" nowrap="nowrap" align="right">替换为</td>
	<td nowrap="nowrap" align="left"><textarea name="tostring" id="tostring" style="width:300px;height:80px;" class="formInput"></textarea></td>
  </tr>
  <tr class="alt2">
	<td width="150" nowrap="nowrap" align="right">替换条件</td>
	<td nowrap="nowrap" align="left"><input name="condition" type="text" style="width:300px;" class="formInput" />(空完全替换)</td>
  </tr>
  <tr class="alt1">
	<td width="150" nowrap="nowrap" align="right"></td>
	<td nowrap="nowrap" align="left"><input type="submit" value="执行替换" class="formButton" /></td>
  </tr>
</table>
</form>
</div>

<!--{include file="footer.tpl"}-->