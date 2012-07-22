<?php /* Smarty version 2.6.19, created on 2011-04-02 17:16:46
         compiled from user/post.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'default', 'user/post.tpl', 25, false),array('modifier', 'escape', 'user/post.tpl', 71, false),)), $this); ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "header.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

<div class="m_container">
<div class="m_inner">

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "user/left_menu.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

<?php if ($this->_tpl_vars['Config']['pic_file_size']): ?>
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
		post_params: {"PHPSESSID": "<?php echo '<?php'; ?>
 echo session_id(); <?php echo '?>'; ?>
"},
		file_size_limit : "1 MB",
		file_types : "*.gif;*.jpg;*.png",
		file_types_description : "Images",
		file_upload_limit : <?php echo ((is_array($_tmp=@$this->_tpl_vars['Config']['most_upic_num'])) ? $this->_run_mod_handler('default', true, $_tmp, 5) : smarty_modifier_default($_tmp, 5)); ?>
,
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
<?php endif; ?>

<div class="table m_right">
<div class="nav_title text_bold"><?php if ($this->_tpl_vars['Action'] == 'post'): ?>内容发布<?php else: ?>编辑内容<?php endif; ?></div>
<form name="form1" method="post" onsubmit="return checkFormData();">
<input type="hidden" name="op" value="<?php echo $this->_tpl_vars['Action']; ?>
" />
<?php if ($this->_tpl_vars['Action'] == 'edit'): ?>
<input type="hidden" name="id" value="<?php echo $this->_tpl_vars['Data']['data_id']; ?>
" />
<input type="hidden" name="url" value="<?php echo @HTTP_REFERER; ?>
" />
<?php endif; ?>
<input type="hidden" id="uploaded" name="uploaded" />
<table class="list_style">
  <tr class="alt1">
    <td class="text_right" width="15%" nowrap="nowrap">标题：</td>
    <td width="85%"><input type="text" id="title" name="title" size="60" maxlength="200" class="formInput" value="<?php echo $this->_tpl_vars['Data']['data_title']; ?>
" /><br /><span class="form_clue">标题长度请限制在<?php echo ((is_array($_tmp=@$this->_tpl_vars['Config']['title_least'])) ? $this->_run_mod_handler('default', true, $_tmp, 10) : smarty_modifier_default($_tmp, 10)); ?>
 - <?php echo ((is_array($_tmp=@$this->_tpl_vars['Config']['title_max'])) ? $this->_run_mod_handler('default', true, $_tmp, 100) : smarty_modifier_default($_tmp, 100)); ?>
字符以内</span></td>
  </tr>
  <tr class="alt2">
    <td class="text_right" nowrap="nowrap">所属类别：</td>
    <td><select id="sort_id" name="sort_id" class="formInput"><option value="0">请选择</option><?php echo $this->_tpl_vars['SortOption']; ?>
</select></td>
  </tr>
  <tr class="alt1">
    <td class="text_right" valign="top" nowrap="nowrap">正文：</td>
    <td>
	<input type="hidden" id="content" name="content" value="<?php echo ((is_array($_tmp=$this->_tpl_vars['Data']['data_content'])) ? $this->_run_mod_handler('escape', true, $_tmp, 'html') : smarty_modifier_escape($_tmp, 'html')); ?>
" /><input type="hidden" id="content___Config" value="AutoDetectLanguage=false&amp;DefaultLanguage=zh-cn" /><iframe id="content___Frame" src="/htmleditor/editor/fckeditor.html?InstanceName=content&amp;Toolbar=Basic" width="100%" height="360" frameborder="no" scrolling="no"></iframe><br /><span class="form_clue">正文长度请限制在 <?php echo $this->_tpl_vars['Config']['content_maxlength']; ?>
 个字符以内</span><a href="javascript:void(0);" onclick="checkLength();return false;">[字数检查]</a>
	</td>
  </tr>
  <?php if ($this->_tpl_vars['Config']['pic_file_size']): ?>
  <tr>
    <td class="tcat" align="right">图片上传</td>
    <td class="tcat">文件单个尺寸小于<?php echo $this->_tpl_vars['Config']['pic_file_size']/1024; ?>
KB. 一次最多允许上传<?php echo ((is_array($_tmp=@$this->_tpl_vars['Config']['most_upic_num'])) ? $this->_run_mod_handler('default', true, $_tmp, 10) : smarty_modifier_default($_tmp, 10)); ?>
张图片, 允许的格式: GIF,JPG,PNG</td>
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
  <?php endif; ?>
  <?php if ($this->_tpl_vars['Action'] == 'post' && ! $this->_tpl_vars['Config']['verify_code_close']): ?>
    <?php endif; ?>
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
var Action = '<?php echo $this->_tpl_vars['Action']; ?>
';
var content_max_length = <?php echo ((is_array($_tmp=@$this->_tpl_vars['Config']['content_maxlength'])) ? $this->_run_mod_handler('default', true, $_tmp, 5000) : smarty_modifier_default($_tmp, 5000)); ?>
;
var title_max_length = <?php echo ((is_array($_tmp=@$this->_tpl_vars['Config']['title_max'])) ? $this->_run_mod_handler('default', true, $_tmp, 100) : smarty_modifier_default($_tmp, 100)); ?>
;
var title_least_length = <?php echo ((is_array($_tmp=@$this->_tpl_vars['Config']['title_least'])) ? $this->_run_mod_handler('default', true, $_tmp, 10) : smarty_modifier_default($_tmp, 10)); ?>
;
var most_upic_num = <?php echo ((is_array($_tmp=@$this->_tpl_vars['Config']['most_upic_num'])) ? $this->_run_mod_handler('default', true, $_tmp, 10) : smarty_modifier_default($_tmp, 10)); ?>
;
var max_multipage_num = <?php echo ((is_array($_tmp=@$this->_tpl_vars['Config']['content_max_multipage_num'])) ? $this->_run_mod_handler('default', true, $_tmp, 10) : smarty_modifier_default($_tmp, 10)); ?>
;

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
<script type="text/javascript" src="<?php echo $this->_tpl_vars['Config']['domain_static']; ?>
/javascripts/post.js"></script>

<div class="clear"></div>
</div></div>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "footer.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>