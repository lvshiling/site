CREATE TABLE IF NOT EXISTS `xx_badword` (
  `badword_id` int(10) unsigned NOT NULL auto_increment,
  `badword_name` varchar(50) NOT NULL default '',
  PRIMARY KEY  (`badword_id`),
  UNIQUE KEY `badword_name` (`badword_name`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `xx_comment` (
  `comment_id` int(10) unsigned NOT NULL auto_increment,
  `data_id` int(10) unsigned NOT NULL default '0',
  `user_id` int(10) unsigned NOT NULL default '0',
  `user_name` varchar(50) NOT NULL default '',
  `comment_content` text NOT NULL,
  `comment_date` int(10) unsigned NOT NULL default '0',
  `client_ip` varchar(15) NOT NULL default '',
  `agree_num` int(10) unsigned NOT NULL default '0',
  `oppose_num` int(10) unsigned NOT NULL default '0',
  `report_num` int(10) unsigned NOT NULL default '0',
  `comment_auditing` tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (`comment_id`),
  KEY `book_id` (`data_id`),
  KEY `report_num` (`report_num`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `xx_config` (
  `name` varchar(50) NOT NULL default '',
  `value` text NOT NULL,
  PRIMARY KEY  (`name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `xx_data` (
  `data_id` int(10) unsigned NOT NULL auto_increment,
  `hash_id` varchar(32) NOT NULL default '',
  `user_id` int(10) unsigned NOT NULL default '0',
  `user_name` varchar(50) NOT NULL default '',
  `sort_id` int(10) unsigned NOT NULL default '0',
  `title_style` varchar(15) NOT NULL default '',
  `data_title` varchar(200) NOT NULL default '',
  `page_num` tinyint(3) NOT NULL default '0',
  `release_date` int(10) unsigned NOT NULL default '0',
  `lastedit_date` int(10) unsigned NOT NULL default '0',
  `ipaddress` varchar(15) NOT NULL default '',
  `is_commend` tinyint(1) NOT NULL default '0',
  `is_auditing` tinyint(1) NOT NULL default '0',
  `total_comment` int(10) unsigned NOT NULL default '0',
  `mark_update` int(10) unsigned NOT NULL,
  `mark_deleted` tinyint(1) unsigned NOT NULL default '0',
  PRIMARY KEY  (`data_id`),
  UNIQUE KEY `hash_id` (`hash_id`),
  KEY `user_id` (`user_id`),
  KEY `sort_id` (`sort_id`),
  KEY `is_commend` (`is_commend`),
  KEY `release_date` (`release_date`),
  KEY `is_auditing` (`is_auditing`),
  KEY `mark_deleted` (`mark_deleted`),
  KEY `lastedit_date` (`lastedit_date`),
  KEY `mark_update` (`mark_update`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `xx_data_ext` (
  `data_id` int(10) unsigned NOT NULL default '0',
  `data_title` varchar(200) NOT NULL default '',
  `data_content` mediumtext NOT NULL,
  PRIMARY KEY  (`data_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `xx_feedback` (
  `feedback_id` int(10) unsigned NOT NULL auto_increment,
  `feedback_contact` varchar(100) NOT NULL default '',
  `feedback_content` text NOT NULL,
  `feedback_date` int(10) unsigned NOT NULL default '0',
  `feedback_ip` varchar(15) NOT NULL default '',
  PRIMARY KEY  (`feedback_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `xx_ftp_setting` (
  `ftp_id` int(10) unsigned NOT NULL auto_increment,
  `ftp_host` varchar(100) NOT NULL default '',
  `ftp_port` varchar(100) NOT NULL default '',
  `ftp_username` varchar(100) NOT NULL default '',
  `ftp_password` varchar(100) NOT NULL default '',
  `visit_path` varchar(100) NOT NULL default '',
  PRIMARY KEY  (`ftp_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `xx_manager` (
  `manager_id` smallint(6) unsigned NOT NULL auto_increment,
  `manager_name` varchar(50) NOT NULL default '',
  `manager_password` varchar(32) NOT NULL default '',
  `dateline` int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (`manager_id`),
  KEY `manager_name` (`manager_name`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `xx_manager_log` (
  `log_id` int(10) unsigned NOT NULL auto_increment,
  `manager_id` smallint(6) unsigned NOT NULL default '0',
  `action` text NOT NULL,
  `dateline` int(10) unsigned NOT NULL default '0',
  `client_ip` varchar(15) NOT NULL default '',
  PRIMARY KEY  (`log_id`),
  KEY `dateline` (`dateline`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `xx_manager_permission` (
  `manager_id` smallint(6) unsigned NOT NULL default '0',
  `can_login` tinyint(1) NOT NULL default '0',
  `can_manage_data` tinyint(1) NOT NULL default '0',
  `is_super_manager` tinyint(1) NOT NULL default '0',
  `can_manage_sort` tinyint(1) NOT NULL default '0',
  `can_manage_user` tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (`manager_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `xx_report` (
  `report_id` int(10) unsigned NOT NULL auto_increment,
  `report_url` varchar(250) NOT NULL default '',
  `report_content` text NOT NULL,
  `report_date` int(10) unsigned NOT NULL default '0',
  `report_ip` varchar(15) NOT NULL default '',
  PRIMARY KEY  (`report_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `xx_search_keyword` (
  `search_keyword` varchar(20) NOT NULL default '',
  `search_num` int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (`search_keyword`),
  KEY `search_num` (`search_num`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `xx_sort` (
  `sort_id` int(10) unsigned NOT NULL auto_increment,
  `parent_sort_id` int(10) unsigned NOT NULL default '0',
  `sort_name` varchar(50) NOT NULL default '',
  `external_url` varchar(255) NOT NULL,
  `allow_post` tinyint(1) NOT NULL default '1',
  `display_order` int(10) unsigned NOT NULL default '1',
  `is_vip` tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (`sort_id`),
  UNIQUE KEY `sort_name` (`sort_name`),
  KEY `parent_sort_id` (`parent_sort_id`),
  KEY `display_order` (`display_order`,`sort_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `xx_user` (
  `user_id` int(10) unsigned NOT NULL auto_increment,
  `user_name` varchar(50) NOT NULL default '',
  `user_password` varchar(32) NOT NULL default '',
  `user_email` varchar(100) NOT NULL default '',
  `dateline` int(10) unsigned NOT NULL default '0',
  `validate_email` tinyint(4) NOT NULL default '1',
  `validate_ip` smallint(6) unsigned NOT NULL default '0',
  `can_add` tinyint(1) NOT NULL default '1',
  `can_edit` tinyint(1) NOT NULL default '1',
  `can_delete` tinyint(1) NOT NULL default '1',
  `post_totalnum` int(10) unsigned NOT NULL default '0',
  `ipaddress` varchar(15) NOT NULL default '',
  PRIMARY KEY  (`user_id`),
  UNIQUE KEY `user_email` (`user_email`),
  KEY `is_auditing` (`validate_email`),
  KEY `user_name` (`user_name`),
  KEY `validate_ip` (`validate_ip`),
  KEY `post_totalnum` (`post_totalnum`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `xx_user_ip_validate` (
  `user_id` int(10) unsigned NOT NULL default '0',
  `validate_ip` char(15) NOT NULL default '',
  `validate_date` int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (`user_id`,`validate_ip`),
  KEY `validate_date` (`validate_date`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

INSERT INTO `xx_manager` (`manager_id`, `manager_name`, `manager_password`, `dateline`) VALUES (1, 'admin', 'e10adc3949ba59abbe56e057f20f883e', 1175863134);
INSERT INTO `xx_manager_permission` (`manager_id`, `can_login`, `can_manage_data`, `is_super_manager`, `can_manage_sort`, `can_manage_user`) VALUES (1, 1, 1, 1, 1, 1);