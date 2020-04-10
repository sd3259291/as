


CREATE TABLE `s_access` (
  `role_id` int(5) unsigned DEFAULT NULL,
  `action` varchar(50) DEFAULT '0',
  `controller` varchar(50) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `node_id` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

#
# Structure for table "s_department"
#

CREATE TABLE `s_department` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `pid` int(11) DEFAULT NULL,
  `status` int(1) DEFAULT NULL,
  `level` int(1) DEFAULT NULL,
  `sort` int(11) NOT NULL DEFAULT '0',
  `icon` int(1) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

#
# Structure for table "s_department_attr"
#

CREATE TABLE `s_department_attr` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `department_id` int(11) DEFAULT NULL,
  `type` int(2) DEFAULT NULL,
  `key` int(11) DEFAULT NULL,
  `value` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=15 DEFAULT CHARSET=utf8;

#
# Structure for table "s_employee"
#

CREATE TABLE `s_employee` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `number` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `department_id` int(11) DEFAULT NULL,
  `post_id` int(11) DEFAULT NULL,
  `sex` int(1) DEFAULT NULL,
  `married` int(1) DEFAULT NULL,
  `affiliation` int(1) DEFAULT NULL,
  `idcard` varchar(255) DEFAULT NULL,
  `idcard_date` date DEFAULT NULL,
  `tel` varchar(255) DEFAULT NULL,
  `emergency_contact` varchar(255) DEFAULT NULL,
  `emergency_contact_tel` varchar(255) DEFAULT NULL,
  `addr1` varchar(255) DEFAULT NULL,
  `addr2` varchar(255) DEFAULT NULL,
  `is_zs` int(1) DEFAULT NULL,
  `entry_date` date DEFAULT NULL,
  `resign_date` date DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `number` (`number`)
) ENGINE=MyISAM AUTO_INCREMENT=23 DEFAULT CHARSET=utf8;

#
# Structure for table "s_employee_education"
#

CREATE TABLE `s_employee_education` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `employee_id` int(11) DEFAULT NULL,
  `start` varchar(255) DEFAULT NULL,
  `end` varchar(255) DEFAULT NULL,
  `school` varchar(255) DEFAULT NULL,
  `xl` varchar(255) DEFAULT NULL,
  `zy` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=30 DEFAULT CHARSET=utf8;

#
# Structure for table "s_employee_workexperience"
#

CREATE TABLE `s_employee_workexperience` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `employee_id` int(11) DEFAULT NULL,
  `start` varchar(255) DEFAULT NULL,
  `end` varchar(255) DEFAULT NULL,
  `company` varchar(255) DEFAULT NULL,
  `department` varchar(255) DEFAULT NULL,
  `post` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=40 DEFAULT CHARSET=utf8;

#
# Structure for table "s_enum"
#

CREATE TABLE `s_enum` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `system` int(1) DEFAULT '0',
  `sort` int(11) NOT NULL DEFAULT '0',
  `pid` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=35 DEFAULT CHARSET=utf8;

#
# Structure for table "s_enum_detail"
#

CREATE TABLE `s_enum_detail` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `enum_id` int(11) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `value` varchar(255) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `sort` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=28 DEFAULT CHARSET=utf8;

#
# Structure for table "s_flow"
#

CREATE TABLE `s_flow` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(100) DEFAULT NULL,
  `create_datetime` datetime DEFAULT NULL,
  `modify_datetime` datetime DEFAULT NULL,
  `done` varchar(50) DEFAULT NULL,
  `show` varchar(50) DEFAULT NULL,
  `node` text,
  `p` text,
  `max_id` int(11) DEFAULT NULL,
  `before_dlt` varchar(255) DEFAULT NULL,
  `form` mediumtext,
  `maker` varchar(20) DEFAULT NULL,
  `status` int(2) NOT NULL DEFAULT '0',
  `td_width` text,
  `type_id` int(3) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

#
# Structure for table "s_flow_auth"
#

CREATE TABLE `s_flow_auth` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `flow_id` int(11) DEFAULT NULL,
  `node_id` varchar(255) DEFAULT NULL,
  `auth` text,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

#
# Structure for table "s_flow_group"
#

CREATE TABLE `s_flow_group` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

#
# Structure for table "s_flow_group_list"
#

CREATE TABLE `s_flow_group_list` (
  `autoid` int(11) NOT NULL AUTO_INCREMENT,
  `id` int(11) DEFAULT NULL,
  `number` varchar(50) DEFAULT NULL,
  `name` varchar(50) DEFAULT NULL,
  `type` varchar(5) DEFAULT NULL,
  `value` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`autoid`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

#
# Structure for table "s_flow_node"
#

CREATE TABLE `s_flow_node` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL,
  `sort` int(11) DEFAULT NULL,
  `auth1` varchar(255) DEFAULT NULL,
  `default` tinyint(3) NOT NULL DEFAULT '0',
  `status` int(1) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

#
# Structure for table "s_flow_table"
#

CREATE TABLE `s_flow_table` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `table_name` varchar(255) DEFAULT NULL,
  `flow_id` int(11) DEFAULT NULL,
  `i` varchar(255) DEFAULT NULL,
  `label` varchar(255) DEFAULT NULL,
  `type` varchar(255) DEFAULT NULL,
  `length1` int(11) DEFAULT NULL,
  `length2` int(11) DEFAULT NULL,
  `enum_name` varchar(255) DEFAULT NULL,
  `enum_id` int(11) DEFAULT NULL,
  `main` int(1) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=50 DEFAULT CHARSET=utf8;

#
# Structure for table "s_flow_type"
#

CREATE TABLE `s_flow_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(20) DEFAULT NULL,
  `status` int(1) DEFAULT NULL,
  `sort` int(11) DEFAULT NULL,
  KEY `id` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

#
# Structure for table "s_flows"
#

CREATE TABLE `s_flows` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `maker` varchar(10) DEFAULT NULL,
  `datetime` datetime DEFAULT NULL,
  `datetime_end` datetime DEFAULT NULL,
  `table_resource` varchar(50) DEFAULT NULL,
  `table_name` varchar(255) DEFAULT NULL,
  `table_id` int(11) DEFAULT NULL,
  `tip_id` int(11) DEFAULT NULL,
  `maker_name` varchar(10) DEFAULT NULL,
  `title` varchar(100) DEFAULT NULL,
  `status` tinyint(3) DEFAULT NULL,
  `p` text,
  `node` text,
  `show` varchar(50) DEFAULT NULL,
  `done` varchar(50) DEFAULT NULL,
  `handler` varchar(255) DEFAULT NULL,
  `before_dlt` varchar(50) DEFAULT NULL,
  `form` text,
  `form_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1671 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

#
# Structure for table "s_flows_auth"
#

CREATE TABLE `s_flows_auth` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `flows_id` int(11) DEFAULT NULL,
  `node_id` varchar(255) DEFAULT NULL,
  `auth` text,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

#
# Structure for table "s_flows_comment"
#

CREATE TABLE `s_flows_comment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(10) DEFAULT NULL,
  `datetime` datetime DEFAULT NULL,
  `comment` text,
  `flow_id` int(11) DEFAULT NULL,
  `username` varchar(10) DEFAULT NULL,
  `department` varchar(50) DEFAULT NULL,
  `post` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3078 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

#
# Structure for table "s_flows_executor"
#

CREATE TABLE `s_flows_executor` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `flow_id` int(11) DEFAULT NULL,
  `node_id` varchar(10) DEFAULT NULL,
  `number` varchar(10) DEFAULT NULL,
  `name` varchar(10) DEFAULT NULL,
  `status` tinyint(3) DEFAULT NULL,
  `sender` varchar(10) DEFAULT NULL,
  `datetime_r` datetime DEFAULT NULL,
  `datetime_s` datetime DEFAULT NULL,
  `datetime_h` datetime DEFAULT NULL,
  `type` tinyint(1) NOT NULL DEFAULT '1',
  `p` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=100 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

#
# Structure for table "s_form-0094"
#

CREATE TABLE `s_form-0094` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `flows_id` int(11) NOT NULL DEFAULT '0',
  `i001` varchar(255) DEFAULT NULL,
  `i002` varchar(255) DEFAULT NULL,
  `i008` varchar(255) DEFAULT NULL,
  `i009` varchar(255) DEFAULT NULL,
  `i010` int(11) DEFAULT NULL,
  `i011` int(1) DEFAULT NULL,
  `i012` int(1) DEFAULT NULL,
  `i013` int(1) DEFAULT NULL,
  `i014` int(1) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

#
# Structure for table "s_form-0096"
#

CREATE TABLE `s_form-0096` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `flows_id` int(11) NOT NULL DEFAULT '0',
  `i001` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

#
# Structure for table "s_form-0097"
#

CREATE TABLE `s_form-0097` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `flows_id` int(11) NOT NULL DEFAULT '0',
  `i002` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

#
# Structure for table "s_form-0105"
#

CREATE TABLE `s_form-0105` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `flows_id` varchar(255) NOT NULL DEFAULT '',
  `i001` varchar(22) DEFAULT NULL,
  `i002` varchar(255) DEFAULT NULL,
  `i003` varchar(100) DEFAULT NULL,
  `i011` int(1) DEFAULT NULL,
  `i012` int(1) DEFAULT NULL,
  `i013` int(1) DEFAULT NULL,
  `i014` int(1) DEFAULT NULL,
  `i015` int(1) DEFAULT NULL,
  `i016` int(1) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

#
# Structure for table "s_form-0107"
#

CREATE TABLE `s_form-0107` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `flows_id` int(11) NOT NULL DEFAULT '0',
  `i001` varchar(255) DEFAULT NULL,
  `i002` varchar(255) DEFAULT NULL,
  `i003` varchar(255) DEFAULT NULL,
  `i004` int(11) DEFAULT '0',
  `i005` int(1) DEFAULT '0',
  `i006` int(1) DEFAULT '0',
  `i007` int(1) DEFAULT '0',
  `i008` int(1) DEFAULT '0',
  `i009` int(1) DEFAULT '0',
  `i010` int(1) DEFAULT '0',
  `i011` varchar(255) DEFAULT NULL,
  `i012` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

#
# Structure for table "s_layout"
#

CREATE TABLE `s_layout` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `level` int(3) NOT NULL DEFAULT '0',
  `name` varchar(255) NOT NULL DEFAULT '',
  `url` varchar(255) DEFAULT '',
  `pid` int(11) NOT NULL DEFAULT '0',
  `sort` int(11) NOT NULL DEFAULT '0',
  `node_id` int(11) DEFAULT NULL,
  `newwindow` int(1) NOT NULL DEFAULT '0',
  `icon` varchar(50) DEFAULT NULL,
  `hidenav` int(1) NOT NULL DEFAULT '0' COMMENT '是否隐藏导航栏',
  `public` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=44 DEFAULT CHARSET=utf8;

#
# Structure for table "s_max"
#

CREATE TABLE `s_max` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` varchar(255) DEFAULT NULL,
  `f` int(11) DEFAULT NULL,
  `s` int(11) DEFAULT NULL,
  `length` varchar(2) NOT NULL DEFAULT '0',
  `pre` varchar(20) NOT NULL DEFAULT '',
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

#
# Structure for table "s_node"
#

CREATE TABLE `s_node` (
  `id` int(6) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL DEFAULT '',
  `action` varchar(50) DEFAULT NULL,
  `status` tinyint(1) DEFAULT '0',
  `remark` varchar(255) DEFAULT NULL,
  `sort` int(6) unsigned DEFAULT NULL,
  `pid` int(6) unsigned NOT NULL DEFAULT '0',
  `level` tinyint(1) unsigned NOT NULL,
  `isdataauth` tinyint(3) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `level` (`level`),
  KEY `pid` (`pid`),
  KEY `status` (`status`),
  KEY `name` (`name`)
) ENGINE=MyISAM AUTO_INCREMENT=883 DEFAULT CHARSET=utf8;

#
# Structure for table "s_post"
#

CREATE TABLE `s_post` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL DEFAULT '',
  `type_id` int(11) NOT NULL DEFAULT '0',
  `type_name` varchar(255) NOT NULL DEFAULT '',
  `status` int(1) NOT NULL DEFAULT '1',
  `sort` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

#
# Structure for table "s_role"
#

CREATE TABLE `s_role` (
  `id` smallint(6) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL,
  `status` tinyint(1) unsigned DEFAULT NULL,
  `remark` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=79 DEFAULT CHARSET=utf8;

#
# Structure for table "s_role_user"
#

CREATE TABLE `s_role_user` (
  `role_id` int(9) unsigned NOT NULL DEFAULT '0',
  `user_id` int(9) NOT NULL DEFAULT '0',
  KEY `group_id` (`role_id`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

#
# Structure for table "s_subform-0101"
#

CREATE TABLE `s_subform-0101` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `flows_id` int(11) NOT NULL DEFAULT '0',
  `i003` varchar(255) DEFAULT NULL,
  `i004` int(11) DEFAULT '0',
  `i005` varchar(255) DEFAULT NULL,
  `i006` int(11) DEFAULT '0',
  `i007` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

#
# Structure for table "s_subform-0102"
#

CREATE TABLE `s_subform-0102` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `flows_id` int(11) NOT NULL DEFAULT '0',
  `i004` int(4) DEFAULT '0',
  `i005` varchar(255) DEFAULT NULL,
  `i006` int(11) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

#
# Structure for table "s_subform-0103"
#

CREATE TABLE `s_subform-0103` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `flows_id` int(11) NOT NULL DEFAULT '0',
  `i007` varchar(279) DEFAULT NULL,
  `i008` varchar(33) DEFAULT NULL,
  `i009` int(11) DEFAULT '0',
  `i010` varchar(22) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

#
# Structure for table "s_subform-0104"
#

CREATE TABLE `s_subform-0104` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `flows_id` int(11) NOT NULL DEFAULT '0',
  `i013` int(4) DEFAULT '0',
  `i014` varchar(255) DEFAULT NULL,
  `i015` int(11) DEFAULT '0',
  `i016` varchar(255) DEFAULT NULL,
  `i017` int(11) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

#
# Structure for table "s_user"
#

CREATE TABLE `s_user` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(150) NOT NULL,
  `password` varchar(100) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(100) DEFAULT '',
  `reg_date` datetime DEFAULT NULL,
  `last_login_date` datetime DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `params` text,
  `number` varchar(20) DEFAULT NULL,
  `email_account` varchar(255) DEFAULT NULL,
  `email_password` varchar(255) DEFAULT NULL,
  `email_name` varchar(255) DEFAULT NULL,
  `openId` varchar(255) DEFAULT NULL,
  `headImg` varchar(255) DEFAULT NULL,
  `access_token` varchar(255) DEFAULT NULL,
  `role_id` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  KEY `name` (`name`)
) ENGINE=MyISAM AUTO_INCREMENT=187 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;
