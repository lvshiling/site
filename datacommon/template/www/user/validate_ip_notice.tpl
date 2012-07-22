<!--{include file="header.tpl"}-->

<div class="table" style="width:700px;margin:0 auto;">
<div class="nav_title text_bold">提示信息</div>
<script type="text/javascript">
function copyP(obj)
{
	if (window.ie)
	{
		obj.select();
		var txt = obj.createTextRange();
		txt.execCommand("Copy");
		alert('已经复制到了剪贴板！');
	}
}
</script>
<div style="padding:0 4px;line-height:150%;">
<p><!--{if !$UserInfo.user_id}-->感谢您的注册<!--{else}-->欢迎您，<!--{$UserInfo.user_name}--><!--{/if}-->。为了把本站告诉更多的人，本站要求您推荐 <span class="text_red"><!--{$Config.validate_ip}--></span> 个人(独立IP)进入本网站，才能激活您的帐户!</p>
<!--{if $UserInfo.user_id}-->
<p class="text_green">您已经推荐了 <span class="text_red"><!--{$UserInfo.validate_ip}--></span> 个人，还需要继续努力哦！</p>
<!--{/if}-->
<p>下面是您的推荐地址↓↓↓ 赶快把推荐地址发给QQ群和QQ好友吧！<br /><input type="text" size="70" value="某某网站:<!--{$Config.domain_vip}-->/p.php?id=<!--{if $UserInfo.user_id}--><!--{$UserInfo.user_id}--><!--{else}--><!--{$UserID}--><!--{/if}-->" onmouseover="this.focus();" onfocus="this.select();" onclick="copyP(this);" /></p>
<!--{if !$UserInfo.user_id}-->
<p>您登陆本站即可知道您已经推荐网友数量。<br /><a href="user.php?o=login">马上登录</a></p>
<!--{/if}-->
</div>
</div>

<!--{include file="footer.tpl"}-->