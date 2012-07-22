<?php
// Chinese Simplified
$lang = array();

// common
$lang['common']['p_error'] = '错误的参数';
$lang['common']['back'] = '返回上一页';
$lang['common']['no_vcode'] = '没有输入验证码！';
$lang['common']['vcode_error'] = '验证码输入错误，请重新输入！';
$lang['common']['notice'] = '提示信息';
$lang['common']['continue'] = '继续';
$lang['common']['cache_error'] = '缓存数据更新失败，请重试！';
$lang['common']['data_not_exist'] = '不存在的数据！';
$lang['common']['succeed'] = '操作成功';
$lang['common']['error_no_select_del'] = '没有选择需要删除的数据！';

// include/kernel/class_multipage.php
$lang['multipage']['page_info'] = '第(%s1/%s2)页';
$lang['multipage']['home'] = '首页';
$lang['multipage']['last'] = '末页';
$lang['multipage']['previous'] = '上一页';
$lang['multipage']['next'] = '下一页';
$lang['multipage']['jump'] = '转到第%s1页';
$lang['multipage']['jump_go'] = '确定';

// badword.php
$lang['badword']['error_length'] = '单个关键字长度不能超过20个字符！';
$lang['badword']['error_exist'] = '已存在相同的关键字！';
$lang['badword']['succeed'] = '屏蔽关键字更新成功！';
$lang['badword']['not_exist'] = '没有这个关键字！';
$lang['badword']['add'] = '添加屏蔽关键字:';
$lang['badword']['edit'] = '编辑屏蔽关键字:';
$lang['badword']['delete'] = '删除屏蔽关键字:';

// comment.php
$lang['comment']['error_no_select'] = '没有选择需要删除的评论数据！';

// create_html.php
$lang['html']['title_today'] = '今日新增';
$lang['html']['title_yesterday'] = '昨日新增';
$lang['html']['error_date'] = '选择了错误的日期范围';
$lang['html']['error_data_empty'] = '没有数据被生成，请重新选择操作';
$lang['html']['waiting_begin'] = '本次共需要生成 %s1 个文件<br /><a href="%s2">即将开始生成,请不要中断</a>';
$lang['html']['waiting_batch'] = '<a href="%s4">正在生成静态文件,请稍候</a><br />当前正在生成 %s1 的第 %s2 页，剩余 %s3 页';

// data.php
$lang['data']['no_select'] = '没有选择需要管理的内容';
$lang['data']['delete'] = '删除';
$lang['data']['commend'] = '推荐/取消推荐';
$lang['data']['heightlight'] = '高亮显示';
$lang['data']['log_edit'] = '编辑内容信息ID:';
$lang['data']['log_delete'] = '删除资源';
$lang['data']['log_heightlight'] = '高亮内容标题';
$lang['data']['log_commend_1'] = '推荐内容';
$lang['data']['log_commend_0'] = '撤销推荐内容';

// ftp.php
$lang['ftp']['error_host_empty'] = '服务器地址不能为空';
$lang['ftp']['error_port'] = '端口只能由数字组成';
$lang['ftp']['error_username_empty'] = '用户名不能为空';
$lang['ftp']['error_password_empty'] = '密码不能为空';
$lang['ftp']['error_visit_path_empty'] = '访问路径不能为空';
$lang['ftp']['error_visit_path'] = '不是一个正确的访问地址';
$lang['ftp']['not_exists'] = '没有这个服务器';
$lang['ftp']['test_error_connect'] = 'FTP测试连接失败';
$lang['ftp']['test_error_login'] = 'FTP测试登录失败';
$lang['ftp']['test_succeed'] = 'FTP测试登录成功';

// include/kernel/class_content_clean.php
$lang['content']['error_no_select_sort'] = '没有选择分类，请选择！';
$lang['content']['error_title_empty'] = '没有填写标题！';
$lang['content']['error_title_length1'] = '正文信息长度不能少于 %s1 字符！';
$lang['content']['error_title_length2'] = '正文信息长度不能超过 %s1 字符！';
$lang['content']['error_intro_empty'] = '没有填写正文信息！';
$lang['content']['error_intro_length1'] = '正文信息长度不能少于 20 字符！';
$lang['content']['error_intro_length2'] = '正文信息长度不能超过 %s1 字符！';
$lang['content']['error_intro_forbid'] = '发表信息中存在非法字词<span class="text_red">%s1</span>';
$lang['content']['error_sort_not_exist'] = '选择的分类不存在，请重新选择！';

// global.php
$lang['global']['page_title'] = '管理中心';
$lang['global']['no_permission'] = '您没有此项操作权限!';

$lang['login']['page_title'] = '登录系统';
$lang['login']['illegal'] = '非法登录!';
$lang['login']['log_illegal'] = '用户名:%s1非法登录';
$lang['login']['forbid'] = '此账号已被禁止登录!';
$lang['login']['error_username_empty'] = '没有输入用户名！';
$lang['login']['error_password_empty'] = '没有输入登录密码！';
$lang['login']['log_login'] = '登录管理后台';
$lang['login']['log_logout'] = '退出管理后台';

// index.php
$lang['menu']['sys'] = '系统管理';
$lang['menu']['sys_1'] = '网站全局设置';
$lang['menu']['sys_3'] = '屏蔽关键字';
$lang['menu']['sys_5'] = '设置系统管理员';
$lang['menu']['sys_6'] = '后台管理日志';
$lang['menu']['sys_7'] = '图源服务器设置';
$lang['menu']['sys_8'] = '热门搜索关键字';

$lang['menu']['resource'] = '内容管理';
$lang['menu']['resource_1'] = '内容列表';
$lang['menu']['resource_2'] = '搜索内容';
$lang['menu']['resource_3'] = '内容合并';
$lang['menu']['resource_4'] = '内容分类';

$lang['menu']['user'] = '用户管理';
$lang['menu']['user_1'] = '用户列表';
$lang['menu']['user_2'] = '添加用户';
$lang['menu']['user_3'] = '搜索用户';

$lang['menu']['other'] = '扩展功能';
$lang['menu']['other_3'] = '反馈信息';
$lang['menu']['other_4'] = '举报信息';
$lang['menu']['other_6'] = '评论管理';

$lang['index']['upload_forbid'] = '禁止文件上传';
$lang['index']['second'] = '秒';

// manager.php
$lang['manager']['log_no_select'] = '没有需要删除的管理日志!';
$lang['manager']['log_delete'] = '删除管理日志共 %s1 条';
$lang['manager']['delete_succeed'] = '管理日志清除成功！';
$lang['manager']['clear_7day'] = '清除七天前的所有管理日志';
$lang['manager']['log_add_manager'] = '添加管理员:';
$lang['manager']['add_manager_succeed'] = '添加成功！';
$lang['manager']['add_manager_fail'] = '添加失败，请稍后再试！';
$lang['manager']['cannot_edit_self'] = '不能编辑自己!';
$lang['manager']['log_edit_manager'] = '编辑管理员:';
$lang['manager']['edit_manager_succeed'] = '编辑成功！';
$lang['manager']['not_exist_manager'] = '没有这个管理员!';
$lang['manager']['cannot_delete_self'] = '不能删除自己!';
$lang['manager']['log_delete_manager'] = '删除管理员:';
$lang['manager']['delete_manager_succeed'] = '删除成功！';
$lang['manager']['error_username_empty'] = '用户名不能为空!';
$lang['manager']['error_username_length'] = '用户名长度请限制在4-20个字符之间，且只能由英文、数字和下划线组成!';
$lang['manager']['error_username_exist'] = '已存在相同用户名的管理员!';
$lang['manager']['error_password_empty'] = '登录密码不能为空!';
$lang['manager']['error_password_length'] = '登录密码长度不能少于4个字符!';

// merger.php
$lang['merger']['error_self'] = '不能合并自己！';
$lang['merger']['error_nso_sort'] = '没有选择源分类！';
$lang['merger']['error_nsa_sort'] = '没有选择目标分类！';
$lang['merger']['error_neo_sort'] = '不存在的源分类！';
$lang['merger']['error_nea_sort'] = '不存在的目标分类！';
$lang['merger']['log_sort'] = '将分类%s1合并到分类%s2';
$lang['merger']['error_nso_user'] = '没有指定源用户！';
$lang['merger']['error_nsa_user'] = '没有指定目标用户！';
$lang['merger']['error_neo_user'] = '不存在的源用户！';
$lang['merger']['error_nea_user'] = '不存在的目标用户！';
$lang['merger']['log_user'] = '将用户%s1合并到用户%s2';
$lang['merger']['succeed'] = '合并成功！';

// misc.php
$lang['misc']['error_password_old_empty'] = '没有输入当前使用密码！';
$lang['misc']['error_password_new_empty'] = '没有输入新密码！';
$lang['misc']['error_password_length'] = '新密码长度不得少于6个字符！';
$lang['misc']['error_password_mismatch'] = '两次输入的新密码不一致！';
$lang['misc']['error_password_current'] = '当前使用密码不正确！';
$lang['misc']['log_password'] = '修改登录密码';
$lang['misc']['password_succeed'] = '恭喜，登录密码修改成功！';

// report.php
$lang['report']['no_select'] = '没有需要删除的举报信息!';
$lang['report']['log_delete'] = '删除举报信息共 %s1 条';
$lang['report']['delete_succeed'] = '选择的举报信息删除成功！';

// feedback.php
$lang['feedback']['no_select'] = '没有需要删除的反馈信息!';
$lang['feedback']['log_delete'] = '删除反馈信息共 %s1 条';
$lang['feedback']['delete_succeed'] = '选择的反馈信息删除成功！';

// setting.php
$lang['setting']['error_notice_empty'] = '网站提示信息为空！';
$lang['setting']['error_sitename_empty'] = '网站名称不能为空！';
$lang['setting']['error_sitename_length'] = '网站名称过长！';
$lang['setting']['log_change_website'] = '修改网站设置';
$lang['setting']['change_website_succeed'] = '网站配置更新成功！';

$lang['gmt']['text1']  = '(GMT-12:00) 国际换日线以西、瓜加林岛';
$lang['gmt']['text2']  = '(GMT-11:00) 中途岛、萨摩亚';
$lang['gmt']['text3']  = '(GMT-10:00) 夏威夷';
$lang['gmt']['text4']  = '(GMT-09:00) 阿拉斯加';
$lang['gmt']['text5']  = '(GMT-08:00) 美国与加拿大太平洋时区';
$lang['gmt']['text6']  = '(GMT-07:00) 美国与加拿大山区时区';
$lang['gmt']['text7']  = '(GMT-06:00) 美国与加拿大中部时区、墨西哥';
$lang['gmt']['text8']  = '(GMT-05:00) 美国与加拿大东部时区、波哥大、利马、基多';
$lang['gmt']['text9']  = '(GMT-04:00) 加拿大大西洋时区、卡拉卡斯、拉巴斯';
$lang['gmt']['text10'] = '(GMT-03:30) 纽芬兰';
$lang['gmt']['text11'] = '(GMT-03:00) 巴西利亚、布宜诺艾利斯、佐治敦';
$lang['gmt']['text12'] = '(GMT-02:00) 大西洋中部';
$lang['gmt']['text13'] = '(GMT-01:00) 亚速尔群岛、维德角群岛';
$lang['gmt']['text14'] = '(GMT) 格林威治时间、伦敦、都柏林、里斯本、卡萨布兰卡、蒙罗维亚';
$lang['gmt']['text15'] = '(GMT+01:00) 阿姆斯特丹、柏林、罗马、布鲁赛尔、马德里、巴黎';
$lang['gmt']['text16'] = '(GMT+02:00) 雅典、伊斯坦布尔、明斯克、赫尔辛基、耶路撒冷、南非';
$lang['gmt']['text17'] = '(GMT+03:00) 巴格达、科威特、利雅德、莫斯科、圣彼得堡';
$lang['gmt']['text18'] = '(GMT+03:30) 德黑兰';
$lang['gmt']['text19'] = '(GMT+04:00) 阿布扎比、马斯喀特、巴库、第比利斯';
$lang['gmt']['text20'] = '(GMT+04:30) 喀布尔';
$lang['gmt']['text21'] = '(GMT+05:00) 伊卡特林堡、伊斯兰堡、卡拉奇、塔什干';
$lang['gmt']['text22'] = '(GMT+05:30) 孟买、加尔各答、马德拉斯、新德里';
$lang['gmt']['text23'] = '(GMT+06:00) 阿马提、达卡、科伦坡';
$lang['gmt']['text24'] = '(GMT+07:00) 曼谷、河内、雅加达';
$lang['gmt']['text25'] = '(GMT+08:00) 北京、新加坡、香港、乌鲁木齐、台北';
$lang['gmt']['text26'] = '(GMT+09:00) 东京、汉城、大阪、札幌、亚库次克';
$lang['gmt']['text27'] = '(GMT+09:30) 爱德蓝、达尔文';
$lang['gmt']['text28'] = '(GMT+10:00) 布里斯本、坎培拉、墨尔本、悉尼、关岛、海参威';
$lang['gmt']['text29'] = '(GMT+11:00) 马加丹、所罗门群岛、新加勒多尼亚';
$lang['gmt']['text30'] = '(GMT+12:00) 奥克兰、威灵顿、斐济、堪察加半岛、马绍尔群岛';
$lang['gmt']['text31'] = '(GMT+13:00) 努库阿洛法';

// sort.php
// include/kernel/class_sort.php
$lang['sort']['error_no_order'] = '没有可排序的分类！';
$lang['sort']['log_order'] = '分类排序';
$lang['sort']['order_succeed'] = '分类顺序调整成功！';
$lang['sort']['error_parent_not_exist']  = '选择的父分类不存在！';
$lang['sort']['error_name_empty']  = '分类名称不能为空！';
$lang['sort']['error_name_length']  = '分类名称长度不能超过50个字符(包括HTML代码)！';
$lang['sort']['error_name_exist']  = '已存在相同的分类名称！';
$lang['sort']['log_add'] = '添加分类:';
$lang['sort']['add_succeed'] = '新分类添加成功！';
$lang['sort']['error_not_exist'] = '没有这个分类！';
$lang['sort']['error_parent_select'] = '父分类不能是自己！';
$lang['sort']['log_edit'] = '编辑分类:';
$lang['sort']['edit_succeed'] = '分类编辑成功！';
$lang['sort']['error_aim_sort'] = '请选择一个有效的目标分类！';
$lang['sort']['error_aim_sort_self'] = '不能选择当前将要删除的分类作为目标分类！';
$lang['sort']['error_aim_not_exist'] = '选择的目标分类不存在！';
$lang['sort']['log_delete_transfer'] = '删除分类:%s1,将其下所有数据转移到分类:%s2';
$lang['sort']['log_delete'] = '删除分类:%s1,同时删除其下所有数据';
$lang['sort']['error_select_approach'] = '请为该分类下的数据选择一种处理方式！';
$lang['sort']['delete_succeed'] = '分类删除成功！';
$lang['sort']['edit'] = '编辑';
$lang['sort']['delete'] = '删除';
$lang['sort']['add_sub_alt'] = '在该分类下添加新的子分类';
$lang['sort']['add_sub'] = '添加子分类';

// user.php
$lang['user']['error_username_empty'] = '登录用户名不能为空！';
$lang['user']['error_username_forbid1'] = '用户名不能是全数字！';
$lang['user']['error_username_forbid2'] = '登录用户名包含禁止使用的符号！';
$lang['user']['error_username_length'] = '用户名长度请限制在 4 - 12 个字符以内！';
$lang['user']['error_username_exist'] = '已存在相同的用户名！';
$lang['user']['error_password_empty'] = '登录密码不能为空！';
$lang['user']['error_password_length'] = '登录密码长度不能少于 4 个字符！';
$lang['user']['error_password_mismatch'] = '两次输入的密码不匹配！';
$lang['user']['error_email_empty'] = '电子邮件地址不能为空！';
$lang['user']['error_email_invalid'] = '电子邮件地址无效！';
$lang['user']['error_email_exists'] = '电子邮件地址已被其他用户使用！';
$lang['user']['log_add'] = '添加用户:';
$lang['user']['add_succeed'] = '用户添加成功！';
$lang['user']['error_not_exist'] = '没有这个用户！';
$lang['user']['log_edit'] = '编辑用户:';
$lang['user']['edit_succeed'] = '用户编辑成功！';
$lang['user']['log_delete'] = '删除用户:';
$lang['user']['delete_succeed'] = '用户删除成功！';


// database.php
$lang['database']['no_permission'] = '数据库权限不够，不能执行该操作！';
$lang['database']['replace_failed'] = '替换失败，你执行的SQL是：';
?>