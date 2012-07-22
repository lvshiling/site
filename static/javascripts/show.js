// report
window.addEvent('domready', function(){
	Dlg = new Dialog({height:'228px'});
	$('resourceReport').addEvent('click', function(e){
		var e = new Event(e);
		e.stop();
		Dlg.box('<strong>举报</strong>');
		Dlg.show('<table class="list_style"><tr class="alt1"><td><textarea id="report_content" style="width:380px;height:140px;"></textarea></td></tr><tr class="alt2 text_center"><td><input type="button" id="submit_report" onclick="submitReport();" class="formButton" value="提交" /></td></tr></table>');
	});
});
function submitReport()
{
	if ('' == $F('report_content').trim())
	{
		alert('没有填写举报原因！');
		$('report_content').focus();
		return false;
	}

	var myAjax = new Ajax(DOMAIN_COMMENT +'/ajax.php', {
		method:'post', 
		data:{
			act: 'report', 
			id: data_id, 
			content: $F('report_content')
		}, 
		onComplete:function(){submitReportStatus(this.response.text)}
	}).request();
	$('submit_report').value = Lang['submit'];
	$('submit_report').disabled = true;
}
function submitReportStatus(msg)
{
	var status = Json.evaluate(msg);
	if ('error' == status.state)
	{
		alert(status.message);
		$('submit_report').value = '提交';
		$('submit_report').disabled = false;
		return false;
	}

	Dlg.show('<br /><br /><br /><br /><p class="text_center">'+ status.message +'</p>');
	(function(){Dlg.hide()}).delay(3000);
}