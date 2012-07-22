<!--{include file="header.tpl"}-->

<div class="m_container">
<div class="m_inner">

<!--{include file="user/left_menu.tpl"}-->

<div class="table m_right">
<div class="nav_title text_bold"><!--{if $Action eq 'post'}-->内容发布<!--{else}-->编辑内容<!--{/if}--></div>
<form name="form1" method="post" enctype="multipart/form-data" onsubmit="return checkFormData();">
<input type="hidden" name="op" value="<!--{$Action}-->" />
<!--{if $Action eq "edit"}-->
<input type="hidden" name="id" value="<!--{$Data.data_id}-->" />
<input type="hidden" name="url" value="<!--{$smarty.const.HTTP_REFERER}-->" />
<!--{/if}-->
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
    <td colspan="2" class="tcat">图片上传</td>
  </tr>
  <tr class="alt2">
    <td class="text_right" valign="top" nowrap="nowrap">上传图片：</td>
    <td>
    <table cellspacing="0" cellpadding="0" width="100%">
	<tbody id="upicbodyhidden" style="display:none;">
	<tr><td><input type="file" name="upic[]" onkeydown="return false;" oncontextmenu="return false;" /><span id="localfile[]"></span></td></tr>
	</tbody>
	<tbody id="upicbody"></tbody>
	</table>
	<span style="display:none;">
	<input type="file" name="upic[]" size="40" onkeydown="return false" oncontextmenu="return false" />
	</span>
	<span class="form_clue">文件单个尺寸:小于<!--{$Config.pic_file_size/1024}-->KB. 一次最多允许上传<!--{$Config.most_upic_num|default:10}-->张图片, 允许的格式: GIF,JPG,PNG</span></td>
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
</script>
<script type="text/javascript" src="<!--{$Config.domain_static}-->/javascripts/post.js"></script>

<div class="clear"></div>
</div><!--{*** manage inner ***}-->
</div><!--{*** manage container ***}-->

<!--{include file="footer.tpl"}-->