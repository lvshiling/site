<!--{include file="header.tpl"}-->

<div class="m_container">
<div class="m_inner">

<!--{include file="user/left_menu.tpl"}-->

<!--{if $Config.pic_file_size}-->
<script type="text/javascript" src="/swfupload/swfupload.js"></script>
<script type="text/javascript" src="/swfupload/handlers.js"></script>
<link href="/swfupload/images/default.css" rel="stylesheet" type="text/css" />
<script type="text/javascript">
var swfu;
window.onload = function()
{
	swfu = new SWFUpload(
	{
		upload_url: "/user.php?o=upload",
		post_params: {"PHPSESSID": "<?php echo session_id(); ?>"},
		file_size_limit : "1 MB",
		file_types : "*.gif;*.jpg;*.png",
		file_types_description : "Images",
		file_upload_limit : <!--{$Config.most_upic_num|default:5}-->,
		file_queue_error_handler : fileQueueError,
		file_dialog_complete_handler : fileDialogComplete,
		upload_progress_handler : uploadProgress,
		upload_error_handler : uploadError,
		upload_success_handler : uploadSuccess,
		upload_complete_handler : uploadComplete,
		button_image_url : "/swfupload/images/SmallSpyGlassWithTransperancy_17x18.png",	// Relative to the SWF file
		button_placeholder_id : "spanButtonPlaceholder",
		button_width: 100,
		button_height: 18,
		button_text : '<span class="swfbutton">选择本地图片</span>',
		button_text_style : '.swfbutton{ font-family: Helvetica, Arial, sans-serif; font-size: 12px; }',
		button_text_top_padding: 0,
		button_text_left_padding: 18,
		button_window_mode: SWFUpload.WINDOW_MODE.TRANSPARENT,
		button_cursor: SWFUpload.CURSOR.HAND,
		flash_url : "/swfupload/images/swfupload.swf",
		custom_settings :{upload_target : "divFileProgressContainer"},
		debug: false
	});
};
</script>
<!--{/if}-->

<div class="table m_right">
<div class="nav_title text_bold"><!--{if $Action eq 'post'}-->内容发布<!--{else}-->编辑内容<!--{/if}--></div>
<form name="form1" method="post" onsubmit="return checkFormData();">
<input type="hidden" name="op" value="<!--{$Action}-->" />
<!--{if $Action eq "edit"}-->
<input type="hidden" name="id" value="<!--{$Data.data_id}-->" />
<input type="hidden" name="url" value="<!--{$smarty.const.HTTP_REFERER}-->" />
<!--{/if}-->
<input type="hidden" id="uploaded" name="uploaded" />
<table class="list_style">
  <tr class="alt1">
    <td class="text_right" width="15%" nowrap="nowrap">标题：</td>
    <td width="85%"><input type="text" id="title" name="title" size="60" maxlength="200" class="formInput" value="<!--{$Data.data_title}-->" /><br /><span class="form_clue">标题长度请限制在<!--{$Config.title_least|default:10}--> - <!--{$Config.title_max|default:100}-->字符以内</span></td>
  </tr>
  <tr class="alt2">
    <td class="text_right" nowrap="nowrap">所属类别：</td>
    <td><select id="sort_id" name="sort_id" class="formInput"><option value="0">请选择</option><!--{$SortOption}--></select></td>
  </tr>
  <tr class="alt1">
    <td class="text_right" valign="top" nowrap="nowrap">正文：</td>
    <td>
	<input type="hidden" id="content" name="content" value="<!--{$Data.data_content|escape:'html'}-->" /><input type="hidden" id="content___Config" value="AutoDetectLanguage=false&amp;DefaultLanguage=zh-cn" /><iframe id="content___Frame" src="/htmleditor/editor/fckeditor.html?InstanceName=content&amp;Toolbar=Basic" width="100%" height="360" frameborder="no" scrolling="no"></iframe><br /><span class="form_clue">正文长度请限制在 <!--{$Config.content_maxlength}--> 个字符以内</span><a href="javascript:void(0);" onclick="checkLength();return false;">[字数检查]</a>
	</td>
  </tr>
  <!--{if $Config.pic_file_size}-->
  <tr>
    <td class="tcat" align="right">图片上传</td>
    <td class="tcat">文件单个尺寸小于<!--{$Config.pic_file_size/1024}-->KB. 一次最多允许上传<!--{$Config.most_upic_num|default:10}-->张图片, 允许的格式: GIF,JPG,PNG</td>
  </tr>
  <tr class="alt1">
    <td class="text_right" valign="top" nowrap="nowrap">
		<div style="display: inline; border: solid 1px #7FAAFF; background-color: #C5D9FF; padding: 2px;">
			<span id="spanButtonPlaceholder"></span>
		</div>
	</td>
    <td>
		<div id="divFileProgressContainer" style="display:none;height:75px;"></div>
		<div id="thumbnails"></div>
	</td>
  </tr>
  <!--{/if}-->
  <!--{if $Action eq "post" and !$Config.verify_code_close}-->
  <!--{*
  <tr class="alt1">
    <td class="text_right" nowrap="nowrap">验证码：</td>
    <td><input type="text" id="vcode" name="vcode" class="formInput" size="4" maxlength="4" /><img id="vimg" src="vimg.php?n=post" align="absmiddle" alt="图片验证码" />(<a href="javascript:void(0);" onclick="imgRefresh('post'); return false;">看不清,换一张</a>)</td>
  </tr>
  *}-->
  <!--{/if}-->
  <tr class="tfooter text_center">
    <td colspan="2">
	<input type="submit" id="submit" value=" 提交 " class="formButton" />
	<input type="button" value=" 预览 " class="formButton" onclick="executePreview();" />
	</td>
  </tr>
</table>
</form>
</div>

<div id="img_hidden" alt="1" style="position:absolute;top:-100000px;filter:progid:DXImageTransform.Microsoft.AlphaImageLoader(sizingMethod='image');width:400px;height:300px"></div>

<form name="preview" action="user.php?o=post" method="post" target="preview">
<input type="hidden" name="op" value="preview" />
<input type="hidden" name="preview_content" />
</form>

<script type="text/javascript">
var Action = '<!--{$Action}-->';
var content_max_length = <!--{$Config.content_maxlength|default:5000}-->;
var title_max_length = <!--{$Config.title_max|default:100}-->;
var title_least_length = <!--{$Config.title_least|default:10}-->;
var most_upic_num = <!--{$Config.most_upic_num|default:10}-->;
var max_multipage_num = <!--{$Config.content_max_multipage_num|default:10}-->;

function insertImg(src)
{
	var oEditor = FCKeditorAPI.GetInstance('content');
	if (oEditor.EditMode == FCK_EDITMODE_WYSIWYG )
	{
		oEditor.InsertHtml('<img src="'+ src +'" />') ;
	}
	else
	{
		alert('请先转换到所见即所得模式') ;
	}
}
</script>
<script type="text/javascript" src="<!--{$Config.domain_static}-->/javascripts/post.js"></script>

<div class="clear"></div>
</div><!--{*** manage inner ***}-->
</div><!--{*** manage container ***}-->

<!--{include file="footer.tpl"}-->