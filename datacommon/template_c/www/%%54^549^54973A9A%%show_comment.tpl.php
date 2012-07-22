<?php /* Smarty version 2.6.19, created on 2011-04-02 21:55:08
         compiled from show_comment.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'default', 'show_comment.tpl', 5, false),array('modifier', 'date_format', 'show_comment.tpl', 27, false),array('modifier', 'urlencode', 'show_comment.tpl', 119, false),)), $this); ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "header.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

<script type="text/javascript">
var is_login = <?php if ($this->_tpl_vars['UserInfo']['user_id']): ?>true<?php else: ?>false<?php endif; ?>;
var comment_close = <?php echo ((is_array($_tmp=@$this->_tpl_vars['Config']['comment_close'])) ? $this->_run_mod_handler('default', true, $_tmp, 0) : smarty_modifier_default($_tmp, 0)); ?>
;
var comment_max_length = <?php echo ((is_array($_tmp=@$this->_tpl_vars['Config']['comment_maxlength'])) ? $this->_run_mod_handler('default', true, $_tmp, 1000) : smarty_modifier_default($_tmp, 1000)); ?>
;
</script>

<div class="show">

<!-- Left(box1) -->
<div class="box1">

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "show_common.tpl", 'smarty_include_vars' => array('Current' => 'comment')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

<!-- Comment -->
<div id="comments">

<?php if ($this->_tpl_vars['Config']['comment_close']): ?>
<p class="notice">
<img src="<?php echo $this->_tpl_vars['Config']['domain_static']; ?>
/images/icon_notice.gif" />评论发表功能暂时关闭！
</p>
<?php endif; ?>

<?php $_from = $this->_tpl_vars['CommentData']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['row']):
?>
<div id="comment<?php echo $this->_tpl_vars['row']['comment_id']; ?>
" class="comment alt2">
<h3><span class="floor"><?php echo $this->_tpl_vars['FirstFloor']+$this->_tpl_vars['key']; ?>
.</span>会员 <span id="user_location_<?php echo $this->_tpl_vars['row']['comment_id']; ?>
"><?php echo $this->_tpl_vars['row']['user_name']; ?>
</span>&nbsp;&nbsp;发表于<?php echo ((is_array($_tmp=$this->_tpl_vars['row']['comment_date'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%Y/%m/%d %H:%M:%S") : smarty_modifier_date_format($_tmp, "%Y/%m/%d %H:%M:%S")); ?>
</h3>
<div><?php echo $this->_tpl_vars['row']['comment_content']; ?>
</div>
<p class="func"><span id="func_msg_<?php echo $this->_tpl_vars['row']['comment_id']; ?>
"></span>&nbsp;&nbsp;<a href="javascript:void(0);" onclick="commentQuote(<?php echo $this->_tpl_vars['row']['comment_id']; ?>
);return false;" title="引用回复该评论">引用</a> | <a href="javascript:void(0);" onclick="commentVote(<?php echo $this->_tpl_vars['row']['comment_id']; ?>
, 1);return false;" title="赞同该观点">支持(<span id="vote_1_<?php echo $this->_tpl_vars['row']['comment_id']; ?>
"><?php echo $this->_tpl_vars['row']['agree_num']; ?>
</span>)</a> | <a href="javascript:void(0);" onclick="commentVote(<?php echo $this->_tpl_vars['row']['comment_id']; ?>
, 0);return false;" title="反对该观点">反对(<span id="vote_0_<?php echo $this->_tpl_vars['row']['comment_id']; ?>
"><?php echo $this->_tpl_vars['row']['oppose_num']; ?>
</span>)</a> | <a href="javascript:void(0);" onclick="commentVote(<?php echo $this->_tpl_vars['row']['comment_id']; ?>
, 2);return false;" title="违法/垃圾信息举报">举报</a></p>
</div>
<?php endforeach; else: ?>
<div class="comment alt1 text_center">还没有网友发表评论</div>
<?php endif; unset($_from); ?>

<?php if ($this->_tpl_vars['Multipage']['page']): ?><div class="pages clear" style="margin-bottom:10px;"><?php echo $this->_tpl_vars['Multipage']['page']; ?>
</div><?php endif; ?>

<?php if (! $this->_tpl_vars['Config']['comment_close']): ?>
<?php if ($this->_tpl_vars['UserInfo']['user_id']): ?>
<div class="table clear">
<a name="addcomment"></a>
<div class="nav_title">发表您的观点</div>
<form method="post" onsubmit="return checkFormData();">
<input type="hidden" name="op" value="add" />
<input type="hidden" id="quote_id" name="quote_id" />
<table class="list_style">
  <tr class="alt1">
    <td style="width:60px;">登录用户</td>
    <td><?php echo $this->_tpl_vars['UserInfo']['user_name']; ?>
 [<a href="<?php echo $this->_tpl_vars['Config']['domain_vip']; ?>
/user.php?o=login&act=logout">退出</a>]</td>
  </tr>
  <tr class="alt2">
    <td valign="top">评论内容</td>
    <td>
	<div id="quote_object"></div>
	<div style="overflow:hidden;height:1%;">
	<div class="left"><textarea style="width:450px;height:130px;" id="content" name="content"></textarea></div>
	<div class="right text_center">
	<img src="/images/smilies/0.gif" onclick="insertSmilie(0);" style="cursor:pointer;" title="微笑" />
	<img src="/images/smilies/1.gif" onclick="insertSmilie(1);" style="cursor:pointer;" title="憋嘴" />
	<img src="/images/smilies/2.gif" onclick="insertSmilie(2);" style="cursor:pointer;" title="色" />
	<img src="/images/smilies/3.gif" onclick="insertSmilie(3);" style="cursor:pointer;" title="发呆" />
	<img src="/images/smilies/4.gif" onclick="insertSmilie(4);" style="cursor:pointer;" title="得意" />
	<img src="/images/smilies/5.gif" onclick="insertSmilie(5);" style="cursor:pointer;" title="流泪" />
	<img src="/images/smilies/6.gif" onclick="insertSmilie(6);" style="cursor:pointer;" title="害羞" />
	<img src="/images/smilies/7.gif" onclick="insertSmilie(7);" style="cursor:pointer;" title="闭嘴" />
	<img src="/images/smilies/8.gif" onclick="insertSmilie(8);" style="cursor:pointer;" title="睡" /><br />
	<img src="/images/smilies/9.gif" onclick="insertSmilie(9);" style="cursor:pointer;" title="大哭" />
	<img src="/images/smilies/10.gif" onclick="insertSmilie(10);" style="cursor:pointer;" title="尴尬" />
	<img src="/images/smilies/11.gif" onclick="insertSmilie(11);" style="cursor:pointer;" title="发怒" />
	<img src="/images/smilies/12.gif" onclick="insertSmilie(12);" style="cursor:pointer;" title="调皮" />
	<img src="/images/smilies/13.gif" onclick="insertSmilie(13);" style="cursor:pointer;" title="龇牙" />
	<img src="/images/smilies/14.gif" onclick="insertSmilie(14);" style="cursor:pointer;" title="惊讶" />
	<img src="/images/smilies/15.gif" onclick="insertSmilie(15);" style="cursor:pointer;" title="强" />
	<img src="/images/smilies/16.gif" onclick="insertSmilie(16);" style="cursor:pointer;" title="弱" />
	<img src="/images/smilies/17.gif" onclick="insertSmilie(17);" style="cursor:pointer;" title="握手" /><br />
	<img src="/images/smilies/18.gif" onclick="insertSmilie(18);" style="cursor:pointer;" title="抓狂" />
	<img src="/images/smilies/19.gif" onclick="insertSmilie(19);" style="cursor:pointer;" title="吐" />
	<img src="/images/smilies/20.gif" onclick="insertSmilie(20);" style="cursor:pointer;" title="偷笑" />
	<img src="/images/smilies/21.gif" onclick="insertSmilie(21);" style="cursor:pointer;" title="可爱" />
	<img src="/images/smilies/22.gif" onclick="insertSmilie(22);" style="cursor:pointer;" title="白眼" />
	<img src="/images/smilies/23.gif" onclick="insertSmilie(23);" style="cursor:pointer;" title="傲慢" />
	<img src="/images/smilies/24.gif" onclick="insertSmilie(24);" style="cursor:pointer;" title="饥渴" />
	<img src="/images/smilies/25.gif" onclick="insertSmilie(25);" style="cursor:pointer;" title="困" />
	<img src="/images/smilies/26.gif" onclick="insertSmilie(26);" style="cursor:pointer;" title="惊恐" /><br />
	<img src="/images/smilies/27.gif" onclick="insertSmilie(27);" style="cursor:pointer;" title="流汗" />
	<img src="/images/smilies/28.gif" onclick="insertSmilie(28);" style="cursor:pointer;" title="憨笑" />
	<img src="/images/smilies/29.gif" onclick="insertSmilie(29);" style="cursor:pointer;" title="大兵" />
	<img src="/images/smilies/30.gif" onclick="insertSmilie(30);" style="cursor:pointer;" title="奋斗" />
	<img src="/images/smilies/31.gif" onclick="insertSmilie(31);" style="cursor:pointer;" title="咒骂" />
	<img src="/images/smilies/32.gif" onclick="insertSmilie(32);" style="cursor:pointer;" title="疑问" />
	<img src="/images/smilies/33.gif" onclick="insertSmilie(33);" style="cursor:pointer;" title="嘘..." />
	<img src="/images/smilies/34.gif" onclick="insertSmilie(34);" style="cursor:pointer;" title="晕" />
	<img src="/images/smilies/35.gif" onclick="insertSmilie(35);" style="cursor:pointer;" title="折磨" /><br />
	<img src="/images/smilies/36.gif" onclick="insertSmilie(36);" style="cursor:pointer;" title="衰" />
	<img src="/images/smilies/37.gif" onclick="insertSmilie(37);" style="cursor:pointer;" title="骷髅" />
	<img src="/images/smilies/38.gif" onclick="insertSmilie(38);" style="cursor:pointer;" title="敲打" />
	<img src="/images/smilies/39.gif" onclick="insertSmilie(39);" style="cursor:pointer;" title="再见" />
	<img src="/images/smilies/40.gif" onclick="insertSmilie(40);" style="cursor:pointer;" title="擦汗" />
	<img src="/images/smilies/41.gif" onclick="insertSmilie(41);" style="cursor:pointer;" title="抠鼻" />
	<img src="/images/smilies/42.gif" onclick="insertSmilie(42);" style="cursor:pointer;" title="鼓掌" />
	<img src="/images/smilies/43.gif" onclick="insertSmilie(43);" style="cursor:pointer;" title="糗大了" />
	<img src="/images/smilies/44.gif" onclick="insertSmilie(44);" style="cursor:pointer;" title="坏笑" />
	</div>
	</div>
	</td>
  </tr>
  <tr class="alt1">
    <td>验证码</td>
    <td><input type="text" id="vcode" name="vcode" class="formInput" size="4" maxlength="4" /><span id="imgarea" style="display:none;"><img id="vimg" align="absmiddle" alt="图片验证码" />(<a href="javascript:void(0);" onclick="imgRefresh('comment'); return false;">看不清,换一张</a>)&nbsp;&nbsp;</span><u>评论长度最多允许<?php echo ((is_array($_tmp=@$this->_tpl_vars['Config']['comment_maxlength'])) ? $this->_run_mod_handler('default', true, $_tmp, 1000) : smarty_modifier_default($_tmp, 1000)); ?>
字</u></td>
  </tr>
  <tr class="alt2">
    <td></td>
    <td><input type="submit" id="submit" name="submit" class="formButton" value="提交" /></td>
  </tr>
</table>
</form>
</div>
<?php else: ?>
<p class="notice">
<img src="<?php echo $this->_tpl_vars['Config']['domain_static']; ?>
/images/icon_notice.gif" />登录后才能发表评论，<a href="<?php echo $this->_tpl_vars['Config']['domain_vip']; ?>
/user.php?o=login&goto=<?php echo ((is_array($_tmp=@CURRENT_URL)) ? $this->_run_mod_handler('urlencode', true, $_tmp) : urlencode($_tmp)); ?>
"><u>请点击这里登录</u></a>
</p>
<?php endif; ?>
<?php endif; ?>
<script type="text/javascript" src="<?php echo $this->_tpl_vars['Config']['domain_static']; ?>
/javascripts/comment.js?v20080318"></script>
<!-- Comment end -->
</div>

</div>
<!-- Left end -->

<!-- Right(box2) -->
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "show_right.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<!-- Right end -->

</div>


<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "footer.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>