<?php
// Chinese Simplified
$lang = array();

// common
$lang['common']['p_error'] = '错误的参数';
$lang['common']['back'] = '返回上一页';
$lang['common']['no_vcode'] = '没有输入验证码！';
$lang['common']['vcode_error'] = '验证码输入错误，请重新输入！';
$lang['common']['ip_disabled'] = 'IP地址 %s1 被禁止访问！';
$lang['common']['notice'] = '提示信息';
$lang['common']['file_not_exist'] = 'Torrent文件不存在！';
$lang['common']['data_not_exist'] = '不存在的数据！';
$lang['common']['succeed'] = '操作成功';

// include/kernel/class_multipage.php
$lang['multipage']['page_info'] = '第(%s1/%s2)页';
$lang['multipage']['home'] = '首页';
$lang['multipage']['last'] = '末页';
$lang['multipage']['previous'] = '上一页';
$lang['multipage']['next'] = '下一页';
$lang['multipage']['jump'] = '转到第%s1页';
$lang['multipage']['jump_go'] = '确定';

// announcement.php
$lang['announcement']['page_title'] = '网站公告信息';

// comment.php
$lang['comment']['title'] = '查看评论';
$lang['comment']['close'] = '评论已关闭';
$lang['comment']['quote'] = '引用 %s1 的原帖:';
$lang['comment']['error_post_space'] = '请不要恶意发表评论！';
$lang['comment']['error_empty'] = '评论内容不能为空！';
$lang['comment']['error_length'] = '评论长度超过限制！';
$lang['comment']['error_keyword_forbid'] = '评论内容中包含非法字符！';
$lang['comment']['error_smilie'] = '使用表情数量不能超过10个！';
$lang['comment']['letter_forbid'] = '禁止发表含有英文字符的评论！';
$lang['comment']['not_login'] = '只有注册会员才能发表评论！';

// index.php|list.php|search.php
$lang['page']['title_index'] = '查看全部资源';
$lang['page']['title_commend'] = '推荐资源';
$lang['page']['title_user'] = '用户 %s1 发布的资源';
$lang['page']['title_today'] = '今日新增';
$lang['page']['title_yesterday'] = '昨日新增';
$lang['page']['title_search'] = '关键字 "%s1" 的搜索结果';
$lang['page']['view_sort_not_exists'] = '查看的资源分类不存在';
$lang['page']['view_user_not_exists'] = '查看的发布用户不存在';

// program.php
$lang['program']['page_title'] = '动漫节目单';

// report.php
$lang['report']['page_title'] = '举报';
$lang['report']['error_url_empty'] = '举报地址不能为空！';
$lang['report']['error_url_length'] = '举报地址长度超过250字符限制！';
$lang['report']['error_content_empty'] = '没有填写举报理由！';
$lang['report']['error_content_length'] = '举报理由长度不能超过500个字符！';
$lang['report']['succeed'] = '举报已成功提交，感谢您的支持！';

// feedback.php
$lang['feedback']['page_title'] = '信息反馈';
$lang['feedback']['error_contact_length'] = '联系方式长度超过100字符，请修改后再提交！';
$lang['feedback']['error_content_empty'] = '没有填写反馈信息！';
$lang['feedback']['error_content_length'] = '反馈信息长度不能超过1000个字符！';
$lang['feedback']['succeed'] = '反馈信息已成功提交，感谢您的支持！';

// search.php
$lang['search']['page_title'] = '高级搜索';
$lang['search']['search_result'] = '搜索结果';
$lang['search']['error_keyword_empty'] = '没有指定搜索关键字！';
$lang['search']['error_keyword_length1'] = '搜索关键字长度不能少于 %s1 个字符！';
$lang['search']['error_keyword_length2'] = '搜索关键字长度不能超过30个字符！';
$lang['search']['error_user_not_exist'] = '搜索的用户"%s1"不存在！';
$lang['search']['error_space_time'] = '两次搜索间隔时间不能少于 %s1 秒，请稍后再试！';
$lang['search']['result_empty'] = '关键字"&nbsp;<span class="text_red">%s1</span>&nbsp;"的搜索结果为空，没有找到符合搜索条件的记录！';
$lang['search']['close'] = '站内搜索暂时关闭！';

// show.php
$lang['show']['data_not_exist'] = '查看的信息不存在或已被删除！';
$lang['show']['get_fail'] = '数据获取失败！';

// user.php
$lang['user']['page_title'] = '控制面板';

// user/data.php
$lang['data']['no_select'] = '没有选择需要管理的内容';
$lang['data']['edit'] = '编辑';
$lang['data']['delete'] = '删除';
$lang['data']['commend'] = '推荐/取消推荐';
$lang['data']['heightlight'] = '高亮显示';
$lang['data']['page_title'] = '管理发布的内容';
$lang['data']['back_list'] = '回管理列表页面';
$lang['data']['edit_title'] = '编辑资源信息';
$lang['data']['view_data'] = '查看编辑后的信息';
$lang['data']['no_permission'] = '您没有管理权限！';
$lang['data']['error_edit_space_time'] = '两次编辑间隔时间不能少于%s1分钟！';
$lang['data']['edit_succeed'] = '编辑成功，编辑后的信息需要经过网站管理员再次审核！';

// user/login.php
$lang['login']['page_title'] = '登录网站';
$lang['login']['error_user_empty'] = '登录失败，用户名为空！';
$lang['login']['error_password_empty'] = '没有填写登录密码！';
$lang['login']['error_password'] = '登录失败，登录密码不正确！';
$lang['login']['error_no_validate_email'] = '此账号还未通过Email验证，暂时不能登录！';
$lang['login']['error_user_not_exist'] = '登录失败，没有 %s1 这个用户！';

$lang['validate_email']['page_title'] = '重发验证邮件';
$lang['validate_email']['error_input'] = '请完成所有表单内容的填写！';
$lang['validate_email']['error_not_exists'] = '没有匹配的注册信息！';
$lang['validate_email']['error_validated'] = '该电子邮件地址已验证！';
$lang['validate_email']['send_succeed'] = '验证邮件已发送到您的信箱，请查收！<br /><a href="user.php?o=login">登录网站</a>';
$lang['validate_email']['error_request'] = '错误的验证请求！';
$lang['validate_email']['validate_succeed'] = '恭喜，您的账号已成功激活！<br /><a href="user.php?o=login">现在登录网站</a>';
$lang['validate_email']['mail_subject'] = '激活您在%s1注册的账号';

// user/profile.php
$lang['profile']['page_title'] = '修改登录密码';
$lang['profile']['error_password_empty1'] = '没有输入当前密码！';
$lang['profile']['error_password_empty2'] = '没有输入新密码！';
$lang['profile']['error_password_mismatch'] = '两次输入新密码不一致，请重新密码！';
$lang['profile']['error_password_length'] = '新密码长度不能少于 4 个字符！';
$lang['profile']['error_password_current'] = '当前密码错误！';
$lang['profile']['password_succeed'] = '恭喜，登录密码修改成功！';

// user/reg.php
$lang['reg']['page_title'] = '新用户注册';
$lang['reg']['close'] = '用户注册暂时关闭！';
$lang['reg']['error_username_empty'] = '登录用户名不能为空！';
$lang['reg']['error_username_forbid1'] = '用户名不能是全数字！';
$lang['reg']['error_username_forbid2'] = '登录用户名包含禁止注册的符号！';
$lang['reg']['error_username_length'] = '用户名长度请限制在 4 - 12 个字符以内！';
$lang['reg']['error_username_exist'] = '已存在相同的用户名！';
$lang['reg']['error_password_empty'] = '登录密码不能为空！';
$lang['reg']['error_email_empty'] = '没有填写电子邮件地址！';
$lang['reg']['error_email_error'] = '填写的电子邮件地址格式不正确！';
$lang['reg']['error_email_exist'] = '该电子邮件地址已被使用！';
$lang['reg']['error_password_length'] = '登录密码长度不能少于 4 个字符！';
$lang['reg']['error_password_mismatch'] = '两次输入的密码不匹配！';
$lang['reg']['succeed_0'] = '恭喜，您的用户名[&nbsp;%s1&nbsp;]注册成功！<br />一封激活账号的邮件已发送到您注册时填写的邮箱，激活后才能登录！';
$lang['reg']['succeed_1'] = '恭喜，您的用户名[&nbsp;%s1&nbsp;]注册成功！';
$lang['reg']['login'] = '现在登录网站';

// user/upload.php
// include/kernel/class_bupload.php
$lang['post']['page_title']  = '内容发布';
$lang['post']['preview'] = '内容预览';
$lang['post']['error_multipage_num'] = '最多只能设置 %s1 页，请返回修改后再提交！';
$lang['post']['succeed'] = '恭喜，内容发布成功！';
$lang['post']['view_new_auditing'] = '发布内容需要经过管理员审核';
//$lang['post']['view_new'] = '查看发布的内容(由于缓存的原因，发布的信息可能需要等待几分钟后才可浏览)';
$lang['post']['continue_post'] = '继续发布内容';
$lang['post']['aborted'] = '发布失败，请稍后再试';

// include/kernel/class_content_clean.php
$lang['content']['error_no_select_sort'] = '没有选择类别或选择的类别不允许发表信息！';
$lang['content']['error_title_empty'] = '没有填写标题！';
$lang['content']['error_title_length1'] = '标题长度不能少于 %s1 字符！';
$lang['content']['error_title_length2'] = '标题长度不能超过 %s1 字符！';
$lang['content']['error_content_empty'] = '没有填写正文信息！';
$lang['content']['error_content_length1'] = '正文长度不能少于 20 字符！';
$lang['content']['error_content_length2'] = '正文长度不能超过 %s1 字符！';
$lang['content']['error_content_forbid'] = '发布信息中存在非法字词<span class="text_red">%s1</span>';
$lang['content']['error_sort_not_exist'] = '选择的类别不存在，请重新选择！';
$lang['content']['error_ftp_setting'] = '系统上传参数配置错误';
$lang['content']['error_ftp_connect_failure'] = '上传服务器连接失败';
$lang['content']['error_ftp_login_failure'] = '上传服务器登录失败';
$lang['content']['error_upload_size'] = '上传中包含超过规定大小的图片';
$lang['content']['error_upload_filetype'] = '上传文件中包含不允许上传的文件类型';
$lang['content']['error_upload_dircreate'] = '存储目录创建失败';
$lang['content']['error_upload_1'] = '上传文件大小超过系统限制';
$lang['content']['error_upload_2'] = '上传文件大小超过系统限制';
$lang['content']['error_upload_3'] = '文件上传不完整';
$lang['content']['error_upload_6'] = '找不到系统临时存储目录';
$lang['content']['error_upload_7'] = '上传文件保存失败';

// include/kernel/class_permission.php
$lang['permission']['add'] = '发布';
$lang['permission']['edit'] = '编辑';
$lang['permission']['delete'] = '删除';
$lang['permission']['no_permission'] = '没有%s1权限！';

// js.php
$lang['js_transfer']['site_stop'] = '网站暂时关闭';
$lang['js_transfer']['close'] = '调用关闭';
$lang['js_transfer']['error_not_allowed_domain'] = '非法调用';
?>