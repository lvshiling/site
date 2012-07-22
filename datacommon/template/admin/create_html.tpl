<!--{include file="header.tpl"}-->

<script type="text/javascript" src="javascripts/calendar.js"></script>

<div class="table">
<table class="list_style" cellpadding="0" cellspacing="0" border="1" frame="void">
  <tr><td colspan="10" class="theader">网站静态文件生成</td></tr>
</table>
</div>

<div class="table">
<table class="list_style" cellpadding="0" cellspacing="0" border="1" frame="void">
  <tr class="alt1">
	<td width="20%" align="right">&nbsp;</td>
	<td><input type="button" class="formButton" value="更新网站首页" onclick="window.location='create_html.php?act=home'" />&nbsp;<input type="button" class="formButton" value="今日新增" onclick="window.location='create_html.php?act=today'" />&nbsp;<input type="button" class="formButton" value="昨日新增" onclick="window.location='create_html.php?act=yesterday'" /></td>
  </tr>
  <tr class="alt2">
	<td align="right">&nbsp;</td>
	<td><input type="button" class="formButton" value="更新所有列表" onclick="window.location='create_html.php?act=list'" /></td>
  </tr>
  <tr class="alt2">
	<td align="right">&nbsp;</td>
	<td><input type="button" class="formButton" value="更新热门搜索" onclick="window.location='create_html.php?act=hotsearch'" /></td>
  </tr>
</table>
</div>

<form action="create_html.php">
<input type="hidden" name="act" value="show" />
<div class="table">
<table class="list_style" cellpadding="0" cellspacing="0" border="1" frame="void">
  <tr class="alt1">
	<td width="20%" align="right">所有内容页数据</td>
	<td><input type="text" class="formInput" id="pre" name="pre" size="5" maxlength="3" value="50" />
	<input type="submit" class="formButton" value="生成" /></td>
  </tr>
</table>
</div>
</form>

<form action="create_html.php">
<input type="hidden" name="act" value="show" />
<div class="table">
<table class="list_style" cellpadding="0" cellspacing="0" border="1" frame="void">
  <tr class="alt1">
	<td width="20%" align="right"><select name="date_type"><option value="release">发布时间在</option></select></td>
	<td width="80%">
	<input type="text" class="formInput" id="start_date" name="start_date" value="<!--{$CurrentDate}-->" readonly="readonly" size="10" maxlength="10" onclick='showCalendar(this, $("start_date"), "yyyy-mm-dd",null,0,-1,-1)' /> - 
	<input type="text" class="formInput" id="last_date" name="last_date" value="<!--{$CurrentDate}-->" readonly="readonly" size="10" maxlength="10" onclick='showCalendar(this, $("last_date"), "yyyy-mm-dd",null,0,-1,-1)' /> 之间
	</td>
  </tr>
  <tr class="alt2">
	<td align="right">每次生成数量</td>
	<td><input type="text" class="formInput" id="pre" name="pre" size="5" maxlength="3" value="50" />
	<input type="submit" class="formButton" value="生成" />
	</td>
  </tr>
</table>
</div>
</form>

<!--{include file="footer.tpl"}-->