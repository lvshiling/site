<!--{include file="header.tpl"}-->

<div class="table">
<table class="list_style" cellpadding="0" cellspacing="0" border="1" frame="void">
  <tr><td colspan="2" class="theader">系统信息</td></tr>
  <tr class="alt1" height="18">
	<td align="right" width="20%">PHP版本</td>
    <td><!--{$sysinfo.php_version}--></td>
  </tr>
  <tr class="alt2" height="18">
	<td align="right">MySql版本</td>
    <td><!--{$sysinfo.mysql_version}--></td>
  </tr>
  <tr class="alt1" height="18">
	<td align="right">服务器端信息</td>
    <td><!--{$sysinfo.service}--></td>
  </tr>
  <tr class="alt2" height="18">
	<td align="right">最大上传限制</td>
    <td><!--{$sysinfo.max_upload}--></td>
  </tr>
  <tr class="alt1" height="18">
	<td align="right">最大执行时间</td>
    <td><!--{$sysinfo.max_ex_time}--></td>
  </tr>
  <tr class="alt2" height="18">
	<td align="right">服务器时间</td>
    <td><!--{$smarty.const.TIME_NOW|date_format:"%Y/%m/%d %H:%M:%S"}--></td>
  </tr>
</table>
</div>

<!--{include file="footer.tpl"}-->