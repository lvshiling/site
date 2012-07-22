<?php /* Smarty version 2.6.19, created on 2011-04-01 12:48:28
         compiled from setting_website.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'default', 'setting_website.tpl', 99, false),array('function', 'html_options', 'setting_website.tpl', 244, false),)), $this); ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "header.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

<div class="tip" style="color:#0278D9;">
<table width="100%">
<tr><td><a href="#basal">基本参数</a></td><td><a href="#domain">网站域名</a></td><td><a href="#optimize">性能优化</a></td></tr>
<tr><td><a href="#user">用户注册控制</a></td><td><a href="#resource">内容发布</a></td><td><a href="#comment">评论设置</a></td></tr>
<tr><td><a href="#search">搜索相关</a></td><td><a href="#other">其他设置</a></td><td></td></tr>
</table>
</div>

<div class="table">
<form name="form1" method="post" onsubmit="return checkFormData();">
<input type="hidden" name="op" value="change_website" />
<a name="basal"></a>
<table class="list_style" cellpadding="0" cellspacing="0" border="1" frame="void">
  <tr><td colspan="2" class="theader">基本参数</td></tr>
  <tr class="alt1">
	<td align="right" width="25%">关闭网站</td>
    <td width="75%"><input type="radio" name="config[site_stop]" value="0"<?php if (! $this->_tpl_vars['Config']['site_stop']): ?> checked="checked"<?php endif; ?> />开放&nbsp;<input type="radio" name="config[site_stop]" value="1"<?php if ($this->_tpl_vars['Config']['site_stop']): ?> checked="checked"<?php endif; ?> />关闭<br /><span class="form_clue">关闭网站时管理后台仍然可以正常使用</span></td>
  </tr>
  <tr class="alt2">
	<td align="right" valign="top">关闭网站提示信息</td>
    <td><textarea cols="50" rows="4" name="config[site_stop_msg]" class="formTextarea"><?php echo $this->_tpl_vars['Config']['site_stop_msg']; ?>
</textarea><br /><span class="form_clue">支持HTML语法</span></td>
  </tr>
  <tr class="alt1">
	<td align="right">网站名称</td>
    <td><input type="text" class="formInput" name="config[site_name]" size="40" value="<?php echo $this->_tpl_vars['Config']['site_name']; ?>
" maxlength="200" /></td>
  </tr>
  <tr class="alt2">
	<td align="right">网站关键字 (Keywords)</td>
    <td><input type="text" class="formInput" name="config[meta_keywords]" size="40" value="<?php echo $this->_tpl_vars['Config']['meta_keywords']; ?>
" maxlength="200" /></td>
  </tr>
  <tr class="alt1">
	<td align="right">网站描述 (Description)</td>
    <td><textarea cols="50" rows="4" name="config[meta_description]" class="formTextarea"><?php echo $this->_tpl_vars['Config']['meta_description']; ?>
</textarea></td>
  </tr>
</table>
<a name="domain"></a>
<table class="list_style" cellpadding="0" cellspacing="0" border="1" frame="void">
  <tr><td colspan="2" class="theader">网站域名</td></tr>
  <tr class="alt1">
	<td align="right">网站域名</td>
    <td><input type="text" class="formInput" name="config[site_domain]" size="40" value="<?php echo $this->_tpl_vars['Config']['site_domain']; ?>
" maxlength="50" /><br /><span class="form_clue">例如:domain.com</span></td>
  </tr>
  <tr class="alt2">
	<td align="right">主域名</td>
    <td><input type="text" class="formInput" name="config[domain_www]" size="40" value="<?php echo $this->_tpl_vars['Config']['domain_www']; ?>
" maxlength="50" /><br /><span class="form_clue">例如:http://www.domain.com , 静态</span></td>
  </tr>
  <tr class="alt1">
	<td align="right">VIP域名</td>
    <td><input type="text" class="formInput" name="config[domain_vip]" size="40" value="<?php echo $this->_tpl_vars['Config']['domain_vip']; ?>
" maxlength="50" /><br /><span class="form_clue">例如:http://vip.domain.com , 动态</span></td>
  </tr>
  <tr class="alt2">
	<td align="right">搜索域名</td>
    <td><input type="text" class="formInput" name="config[domain_search]" size="40" value="<?php echo $this->_tpl_vars['Config']['domain_search']; ?>
" maxlength="50" /><br /><span class="form_clue">例如:http://search.domain.com</span></td>
  </tr>
  <tr class="alt1">
	<td align="right">评论域名</td>
    <td><input type="text" class="formInput" name="config[domain_comment]" size="40" value="<?php echo $this->_tpl_vars['Config']['domain_comment']; ?>
" maxlength="50" /><br /><span class="form_clue">例如:http://comment.domain.com</span></td>
  </tr>
  <tr class="alt2">
	<td align="right">公共文件域名</td>
    <td><input type="text" class="formInput" name="config[domain_static]" size="40" value="<?php echo $this->_tpl_vars['Config']['domain_static']; ?>
" maxlength="50" /><br /><span class="form_clue">例如:http://static.domain.com</span></td>
  </tr>
</table>
<a name="optimize"></a>
<table class="list_style" cellpadding="0" cellspacing="0" border="1" frame="void">
  <tr><td colspan="2" class="theader">性能优化</td></tr>
  <tr class="alt1">
	<td align="right" width="25%">GZIP压缩输出</td>
    <td width="75%"><input type="radio" name="config[gzip_enabled]" value="1"<?php if ($this->_tpl_vars['Config']['gzip_enabled']): ?> checked="checked"<?php endif; ?> />开启&nbsp;<input type="radio" name="config[gzip_enabled]" value="0"<?php if (! $this->_tpl_vars['Config']['gzip_enabled']): ?> checked="checked"<?php endif; ?> />关闭<br /><span class="form_clue">可以很明显的降低带宽需求，但只有在客户端支持的情况下才可使用，并会增大服务器系统开销</span></td>
  </tr>
  <tr class="alt2">
	<td align="right">模板编译</td>
    <td><input type="radio" name="config[tpl_compile]" value="1"<?php if ($this->_tpl_vars['Config']['tpl_compile']): ?> checked="checked"<?php endif; ?> />开启&nbsp;<input type="radio" name="config[tpl_compile]" value="0"<?php if (! $this->_tpl_vars['Config']['tpl_compile']): ?> checked="checked"<?php endif; ?> />关闭<br /><span class="form_clue">关闭有利于提高程序运行速度。修改模板后，需要将该项开启，修改生效再选择是否关闭</span></td>
  </tr>
  <tr class="alt1">
	<td align="right">开启缓存</td>
    <td><input type="radio" name="config[tpl_cache]" value="1"<?php if ($this->_tpl_vars['Config']['tpl_cache']): ?> checked="checked"<?php endif; ?> />开启&nbsp;<input type="radio" name="config[tpl_cache]" value="0"<?php if (! $this->_tpl_vars['Config']['tpl_cache']): ?> checked="checked"<?php endif; ?> />关闭<br /><span class="form_clue">开启缓存将占用较多磁盘空间，但速度会有显著提升。强烈推荐开启该功能</span></td>
  </tr>
  <tr class="alt2">
	<td align="right">缓存有效期</td>
    <td><input type="text" class="formInput" name="config[tpl_cache_time_list]" maxlength="9" value="<?php echo $this->_tpl_vars['Config']['tpl_cache_time_list']; ?>
" size="10" />秒<br /><span class="form_clue">设置值如果小于60将自动关闭缓存功能</span></td>
  </tr>
  <tr class="alt1">
	<td align="right">列表每页显示数量</td>
    <td><input type="text" name="config[pagination_list_num]" class="formInput" size="10" maxlength="3" value="<?php echo $this->_tpl_vars['Config']['pagination_list_num']; ?>
" /><br /><span class="form_clue">不包括用户管理的相关列表</span></td>
  </tr>
</table>
<a name="sendmail"></a>
<table class="list_style" cellpadding="0" cellspacing="0" border="1" frame="void">
  <tr><td colspan="2" class="theader">邮件发送设置</td></tr>
  <tr class="alt1">
	<td align="right" width="25%">SMTP 服务器</td>
    <td width="75%"><input type="text" name="config[smtp_host]" class="formInput" size="40" maxlength="50" value="<?php echo $this->_tpl_vars['Config']['smtp_host']; ?>
" /></td>
  </tr>
  <tr class="alt2">
	<td align="right">SMTP 端口</td>
    <td><input type="text" name="config[smtp_port]" class="formInput" size="40" maxlength="50" value="<?php echo ((is_array($_tmp=@$this->_tpl_vars['Config']['smtp_port'])) ? $this->_run_mod_handler('default', true, $_tmp, 25) : smarty_modifier_default($_tmp, 25)); ?>
" /></td>
  </tr>
  <tr class="alt1">
	<td align="right">SMTP 身份验证用户名</td>
    <td><input type="text" name="config[smtp_user]" class="formInput" size="40" maxlength="50" value="<?php echo $this->_tpl_vars['Config']['smtp_user']; ?>
" /></td>
  </tr>
  <tr class="alt2">
	<td align="right">SMTP 身份验证密码</td>
    <td><input type="text" name="config[smtp_password]" class="formInput" size="40" maxlength="50" value="<?php echo $this->_tpl_vars['Config']['smtp_password']; ?>
" /></td>
  </tr>
</table>
<a name="user"></a>
<table class="list_style" cellpadding="0" cellspacing="0" border="1" frame="void">
  <tr><td colspan="2" class="theader">用户注册控制</td></tr>
  <tr class="alt1">
	<td align="right" width="25%">开启用户注册</td>
    <td width="75%"><input type="radio" name="config[user_register]" value="1"<?php if ($this->_tpl_vars['Config']['user_register']): ?> checked="checked"<?php endif; ?> />开启&nbsp;<input type="radio" name="config[user_register]" value="0"<?php if (! $this->_tpl_vars['Config']['user_register']): ?> checked="checked"<?php endif; ?> />关闭</td>
  </tr>
  <tr class="alt2">
	<td align="right">注册邮件地址验证</td>
    <td><input type="radio" name="config[user_register_vemail]" value="1"<?php if ($this->_tpl_vars['Config']['user_register_vemail']): ?> checked="checked"<?php endif; ?> />开启&nbsp;<input type="radio" name="config[user_register_vemail]" value="0"<?php if (! $this->_tpl_vars['Config']['user_register_vemail']): ?> checked="checked"<?php endif; ?> />关闭</td>
  </tr>
  <tr class="alt1">
	<td align="right">推广激活IP数</td>
    <td><input type="text" class="formInput" name="config[validate_ip]" maxlength="9" value="<?php echo ((is_array($_tmp=@$this->_tpl_vars['Config']['validate_ip'])) ? $this->_run_mod_handler('default', true, $_tmp, 0) : smarty_modifier_default($_tmp, 0)); ?>
" size="10" />个<br /><span class="form_clue">设置为零(0)表示不需要IP激活</span></td>
  </tr>
  <tr class="alt2">
	<td align="right">推广转向目标地址</td>
    <td><input type="text" class="formInput" name="config[validate_ip_aim_url]" value="<?php echo $this->_tpl_vars['Config']['validate_ip_aim_url']; ?>
" size="40" /></td>
  </tr>
</table>
<a name="resource"></a>
<table class="list_style" cellpadding="0" cellspacing="0" border="1" frame="void">
  <tr><td colspan="2" class="theader">内容发布</td></tr>
  <tr class="alt1">
	<td align="right">上传的图片文件最大允许</td>
    <td><input type="text" class="formInput" name="config[pic_file_size]" value="<?php echo $this->_tpl_vars['Config']['pic_file_size']; ?>
" size="10" />KB<br /><span class="form_clue">最大不要超过2048KB</span></td>
  </tr>
  <tr class="alt2">
	<td align="right">上传图片自动缩小</td>
    <td><input type="text" class="formInput" name="config[pic_auto_modify]" value="<?php echo ((is_array($_tmp=@$this->_tpl_vars['Config']['pic_auto_modify'])) ? $this->_run_mod_handler('default', true, $_tmp, 720) : smarty_modifier_default($_tmp, 720)); ?>
" size="10" />px<br /><span class="form_clue">当图片宽度超过设定值时，将自动等比缩小到设定值。设置为零(0)将不调整</span></td>
  </tr>
  <tr class="alt1">
	<td align="right">一次最多上传图片张数</td>
    <td><input type="text" class="formInput" name="config[most_upic_num]" value="<?php echo ((is_array($_tmp=@$this->_tpl_vars['Config']['most_upic_num'])) ? $this->_run_mod_handler('default', true, $_tmp, 10) : smarty_modifier_default($_tmp, 10)); ?>
" size="10" /></td>
  </tr>
  <tr class="alt2">
	<td align="right">上传图片添加水印</td>
    <td><input type="radio" name="config[watermark]" value="1"<?php if ($this->_tpl_vars['Config']['watermark']): ?> checked="checked"<?php endif; ?> />开启&nbsp;<input type="radio" name="config[watermark]" value="0"<?php if (! $this->_tpl_vars['Config']['watermark']): ?> checked="checked"<?php endif; ?> />关闭</td>
  </tr>
  <tr class="alt1">
	<td align="right">ImageMagick安装路径</td>
    <td><input type="text" class="formInput" name="config[imagick_path]" value="<?php echo $this->_tpl_vars['Config']['imagick_path']; ?>
" size="40" /><br /><span class="form_clue">图像处理软件ImageMagick的安装绝对路径，windows系统一般留空即可</span></td>
  </tr>
  <tr class="alt2">
	<td align="right">资源名称长度限制</td>
    <td><input type="text" class="formInput" name="config[title_least]" value="<?php echo ((is_array($_tmp=@$this->_tpl_vars['Config']['title_least'])) ? $this->_run_mod_handler('default', true, $_tmp, 10) : smarty_modifier_default($_tmp, 10)); ?>
" size="5" /> - <input type="text" class="formInput" name="config[title_max]" value="<?php echo ((is_array($_tmp=@$this->_tpl_vars['Config']['title_max'])) ? $this->_run_mod_handler('default', true, $_tmp, 100) : smarty_modifier_default($_tmp, 100)); ?>
" size="5" />字符以内<br /><span class="form_clue">最多允许200个字符</span></td>
  </tr>
  <tr class="alt1">
	<td align="right">资源介绍内容长度限制</td>
    <td><input type="text" class="formInput" name="config[content_maxlength]" value="<?php echo $this->_tpl_vars['Config']['content_maxlength']; ?>
" size="10" />个字符<br /><span class="form_clue">最多允许200000个字符</span></td>
  </tr>
  <tr class="alt2">
	<td align="right">内容最大分页数</td>
    <td><input type="text" class="formInput" name="config[content_max_multipage_num]" value="<?php echo $this->_tpl_vars['Config']['content_max_multipage_num']; ?>
" size="10" /><br /><span class="form_clue">超过设置的数量将被禁止提交</span></td>
  </tr>
  <tr class="alt1">
	<td align="right">两次编辑最少间隔时间</td>
    <td><input type="text" class="formInput" name="config[content_edit_space_time]" value="<?php echo $this->_tpl_vars['Config']['content_edit_space_time']; ?>
" size="10" />分钟<br /><span class="form_clue">不设置则不限制</span></td>
  </tr>
  <tr class="alt2">
	<td align="right">图片提示信息</td>
    <td><input type="text" class="formInput" name="config[upic_title]" value="<?php echo $this->_tpl_vars['Config']['upic_title']; ?>
" size="40" maxlength="200" /></td>
  </tr>
  <tr class="alt1">
	<td align="right">图片链接</td>
    <td><input type="text" class="formInput" name="config[upic_url]" value="<?php echo $this->_tpl_vars['Config']['upic_url']; ?>
" size="40" maxlength="200" /></td>
  </tr>
</table>
<a name="search"></a>
<table class="list_style" cellpadding="0" cellspacing="0" border="1" frame="void">
  <tr><td colspan="2" class="theader">搜索相关</td></tr>
  <tr class="alt1">
	<td align="right" width="25%">站内搜索</td>
    <td width="75%"><input type="radio" name="config[search_close]" value="0"<?php if (! $this->_tpl_vars['Config']['search_close']): ?> checked="checked"<?php endif; ?> />开启&nbsp;<input type="radio" name="config[search_close]" value="1"<?php if ($this->_tpl_vars['Config']['search_close']): ?> checked="checked"<?php endif; ?> />关闭</td>
  </tr>
  <tr class="alt2">
	<td align="right">全文搜索</td>
    <td><input type="radio" name="config[search_full_text]" value="1"<?php if ($this->_tpl_vars['Config']['search_full_text']): ?> checked="checked"<?php endif; ?> />开启&nbsp;<input type="radio" name="config[search_full_text]" value="0"<?php if (! $this->_tpl_vars['Config']['search_full_text']): ?> checked="checked"<?php endif; ?> />关闭<br /><span class="form_clue">开启全文搜索将允许用户搜索内容介绍</span></td>
  </tr>
  <tr class="alt1">
	<td align="right" width="25%">搜索统计延迟更新</td>
    <td width="75%"><input type="radio" name="config[search_stats_delayed]" value="1"<?php if ($this->_tpl_vars['Config']['search_stats_delayed']): ?> checked="checked"<?php endif; ?> />开启&nbsp;<input type="radio" name="config[search_stats_delayed]" value="0"<?php if (! $this->_tpl_vars['Config']['search_stats_delayed']): ?> checked="checked"<?php endif; ?> />关闭</td>
  </tr>
  <tr class="alt1">
	<td align="right">关键字长度至少</td>
    <td><input type="text" class="formInput" name="config[search_keyword_least]" value="<?php echo ((is_array($_tmp=@$this->_tpl_vars['Config']['search_keyword_least'])) ? $this->_run_mod_handler('default', true, $_tmp, 4) : smarty_modifier_default($_tmp, 4)); ?>
" size="10" />个字符<br /><span class="form_clue">最多不能超过20字符</span></td>
  </tr>
  <tr class="alt2">
	<td align="right">两次搜索间隔时间</td>
    <td><input type="text" class="formInput" name="config[search_space_time]" value="<?php echo ((is_array($_tmp=@$this->_tpl_vars['Config']['search_space_time'])) ? $this->_run_mod_handler('default', true, $_tmp, 0) : smarty_modifier_default($_tmp, 0)); ?>
" size="10" />秒<br /><span class="form_clue">设置同一访客两次搜索间隔时间，设置为0表示不限制。</span></td>
  </tr>
  <tr class="alt1">
	<td align="right">热门关键字显示数量</td>
    <td><input type="text" name="config[search_top_num]" class="formInput" size="10" value="<?php echo $this->_tpl_vars['Config']['search_top_num']; ?>
" /><br /><span class="form_clue">设置为0则不显示热门关键字</span></td>
  </tr>
</table>
<a name="comment"></a>
<table class="list_style" cellpadding="0" cellspacing="0" border="1" frame="void">
  <tr><td colspan="2" class="theader">评论设置</td></tr>
  <tr class="alt1">
	<td align="right" width="25%">评论发表</td>
    <td width="75%"><input type="radio" name="config[comment_close]" value="0"<?php if (! $this->_tpl_vars['Config']['comment_close']): ?> checked="checked"<?php endif; ?> />开启&nbsp;<input type="radio" name="config[comment_close]" value="1"<?php if ($this->_tpl_vars['Config']['comment_close']): ?> checked="checked"<?php endif; ?> />关闭</td>
  </tr>
  <tr class="alt2">
	<td align="right">发表评论审核</td>
    <td><input type="radio" name="config[comment_auditing]" value="1"<?php if ($this->_tpl_vars['Config']['comment_auditing']): ?> checked="checked"<?php endif; ?> />开启&nbsp;<input type="radio" name="config[comment_auditing]" value="0"<?php if (! $this->_tpl_vars['Config']['comment_auditing']): ?> checked="checked"<?php endif; ?> />关闭</td>
  </tr>
  <tr class="alt1">
	<td align="right">评论字数限制</td>
    <td><input type="text" class="formInput" name="config[comment_maxlength]" value="<?php echo ((is_array($_tmp=@$this->_tpl_vars['Config']['comment_maxlength'])) ? $this->_run_mod_handler('default', true, $_tmp, 1000) : smarty_modifier_default($_tmp, 1000)); ?>
" size="10" />字<br /><span class="form_clue">评论最多允许字符数，不能超过40000字符</span></td>
  </tr>
  <tr class="alt2">
	<td align="right">评论发表间隔时间</td>
    <td><input type="text" class="formInput" name="config[comment_post_space]" value="<?php echo ((is_array($_tmp=@$this->_tpl_vars['Config']['comment_post_space'])) ? $this->_run_mod_handler('default', true, $_tmp, 60) : smarty_modifier_default($_tmp, 60)); ?>
" size="10" />秒<br /><span class="form_clue">设置两次评论发表之间的等待时间</span></td>
  </tr>
  <tr class="alt2">
	<td align="right">评论内容禁止英文字符</td>
    <td><input type="checkbox" class="formInput" name="config[comment_letter_forbid]" value="1"<?php if ($this->_tpl_vars['Config']['comment_letter_forbid'] == 1): ?> checked="checked"<?php endif; ?> /></td>
  </tr>
</table>
<a name="other"></a>
<table class="list_style" cellpadding="0" cellspacing="0" border="1" frame="void">
  <tr><td colspan="2" class="theader">其他设置</td></tr>
  <tr class="alt1">
	<td align="right" width="25%">公告分类数字ID</td>
    <td width="75%"><input type="text" class="formInput" name="config[announcement_sort_id]" value="<?php echo ((is_array($_tmp=@$this->_tpl_vars['Config']['announcement_sort_id'])) ? $this->_run_mod_handler('default', true, $_tmp, 0) : smarty_modifier_default($_tmp, 0)); ?>
" size="10" /><br /><span class="form_clue">显示在公告&amp;帮助区的分类</span></td>
  </tr>
  <tr class="alt2">
	<td align="right">图片验证码</td>
    <td><input type="radio" name="config[verify_code_close]" value="0"<?php if (! $this->_tpl_vars['Config']['verify_code_close']): ?> checked="checked"<?php endif; ?> />开启&nbsp;<input type="radio" name="config[verify_code_close]" value="1"<?php if ($this->_tpl_vars['Config']['verify_code_close']): ?> checked="checked"<?php endif; ?> />关闭<br /><span class="form_clue">如果开启该功能，需要服务器支持GD</span><img id="vimg" src="vimg.php?n=test" align="absmiddle" alt="图片验证码" /></td>
  </tr>
  <tr class="alt1">
	<td align="right">系统时区设置</td>
    <td><select name="config[timezone_offset]">
	<?php echo smarty_function_html_options(array('options' => $this->_tpl_vars['timezone_offset'],'selected' => ((is_array($_tmp=@$this->_tpl_vars['Config']['timezone_offset'])) ? $this->_run_mod_handler('default', true, $_tmp, 8) : smarty_modifier_default($_tmp, 8))), $this);?>

	</select></td>
  </tr>
  <tr class="alt2">
	<td align="right">数据库调试信息</td>
    <td><input type="radio" name="config[debug]" value="1"<?php if ($this->_tpl_vars['Config']['debug']): ?> checked="checked"<?php endif; ?> />开启&nbsp;<input type="radio" name="config[debug]" value="0"<?php if (! $this->_tpl_vars['Config']['debug']): ?> checked="checked"<?php endif; ?> />关闭</td>
  </tr>
</table>
<table class="list_style" cellpadding="0" cellspacing="0" border="1" frame="void">
  <tr>
    <td colspan="2" class="tfoot text_center">
	<input type="submit" class="formButton" accesskey="s" id="submit" value=" 保存设置(S) " />
	<input type="reset" class="formButton" accesskey="r" value="重置(R)" />
	<input type="button" class="formButton" accesskey="n" value=" 返回(N) " onclick='javascript:history.back();' />
	</td>
  </tr>
</table>
</form>
</div>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "footer.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>