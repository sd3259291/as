# Host: 192.168.3.3  (Version 8.0.12)
# Date: 2020-06-09 15:43:10
# Generator: MySQL-Front 6.1  (Build 1.26)


#
# Structure for table "s_access"
#

CREATE TABLE `s_access` (
  `role_id` int(5) unsigned DEFAULT NULL,
  `action` varchar(50) DEFAULT '0',
  `controller` varchar(50) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `node_id` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

#
# Data for table "s_access"
#

INSERT INTO `s_access` VALUES (NULL,'adduser','hr',176,862),(NULL,'index','hr',176,861),(74,'edituser','hr',NULL,865),(74,'index','hr',NULL,861),(74,'dltuser','hr',NULL,866),(73,'newflow','fs',NULL,878);

#
# Structure for table "s_basic_class"
#

CREATE TABLE `s_basic_class` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `class_id` int(11) NOT NULL DEFAULT '0',
  `code` varchar(255) NOT NULL DEFAULT '',
  `name` varchar(255) NOT NULL DEFAULT '',
  `pid` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=23 DEFAULT CHARSET=utf8;

#
# Data for table "s_basic_class"
#

INSERT INTO `s_basic_class` VALUES (1,0,'01','采购件',0),(2,1,'01','江苏',0),(5,0,'02','自制件',0),(9,1,'01','南京',2),(12,0,'01','钢材',1),(13,0,'02','弹簧',1),(14,0,'01','不锈钢',12),(15,0,'02','圆钢',12),(16,0,'01','长弹簧',13),(17,0,'02','短弹簧',13),(18,2,'01','江苏',0),(19,2,'02','浙江',0),(20,2,'01','南京',18),(21,2,'02','镇江',18),(22,1,'02','徐州',2);

#
# Structure for table "s_customer"
#

CREATE TABLE `s_customer` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(255) NOT NULL DEFAULT '',
  `name` varchar(255) NOT NULL DEFAULT '',
  `contact` varchar(255) NOT NULL DEFAULT '',
  `phone` varchar(255) NOT NULL DEFAULT '',
  `email` varchar(255) NOT NULL DEFAULT '',
  `tel` varchar(255) NOT NULL DEFAULT '',
  `fax` varchar(255) NOT NULL DEFAULT '',
  `address` varchar(255) NOT NULL DEFAULT '',
  `basic_class_id` int(11) NOT NULL DEFAULT '0',
  `maker` varchar(255) NOT NULL DEFAULT '',
  `create_date` date DEFAULT NULL,
  `modify_date` date DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `code` (`code`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

#
# Data for table "s_customer"
#

INSERT INTO `s_customer` VALUES (1,'11','22','3333','44','55','66','77','88',19,'管理员','2020-05-08',NULL),(2,'发阿发','1414','424','','2525','','525','',21,'管理员','2020-05-08',NULL);

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
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

#
# Data for table "s_department"
#

INSERT INTO `s_department` VALUES (1,'公司名称',0,1,1,1,1),(2,'综合管理部',1,1,2,2,0),(3,'人事科',2,1,3,1,0),(4,'行政科',2,1,3,2,0),(5,'信息科',2,1,3,3,0);

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
) ENGINE=MyISAM AUTO_INCREMENT=28 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

#
# Data for table "s_department_attr"
#

INSERT INTO `s_department_attr` VALUES (12,2,2,21,'郭富城'),(13,2,1,3,'王泉'),(14,2,1,21,'郭富城'),(19,3,2,21,'郭富城'),(20,3,1,4,'王泉'),(21,3,1,21,'郭富城'),(24,5,2,4,'王泉'),(25,5,2,14,'刘德华'),(26,5,1,4,'王泉'),(27,5,1,14,'刘德华');

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
  `active` int(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `number` (`number`)
) ENGINE=MyISAM AUTO_INCREMENT=23 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

#
# Data for table "s_employee"
#

INSERT INTO `s_employee` VALUES (2,'010004','王泉',5,4,1,0,1,'111111111111111111','2024-03-20','111','sara','123','家庭住址111','家庭住址2',0,'2020-03-14',NULL,1),(3,'010155','王泉',5,4,1,1,1,'111111111111111111','2024-03-20','111','紧急人','123','家庭住址1','家庭住址2',0,'2020-03-11',NULL,1),(4,'010100','王泉',5,4,1,1,1,'111111111111111111','2024-03-20','111','紧急人','123','家庭住址1','家庭住址2',0,NULL,NULL,1),(5,'010050','张三',5,1,1,1,1,'111111111111111111','2023-03-29','12345678901','张三老婆','141414','张三的家','张三现在的家',0,'2020-03-14',NULL,1),(14,'010099','刘德华',5,1,1,1,1,'111111111111111111','2024-03-29','1414','虎仔老婆','414','法法师','发生发',0,'2020-03-16',NULL,1),(21,'010097','郭富城',3,1,1,1,1,'111111111111111111','2026-03-26','41','22','55','法法','发',0,'2020-03-16',NULL,1),(22,'010066','张学友',4,1,1,1,1,'111111111111111111','2023-03-22','1','1','1','1','1',0,'2020-03-16',NULL,1);

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
) ENGINE=MyISAM AUTO_INCREMENT=31 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

#
# Data for table "s_employee_education"
#

INSERT INTO `s_employee_education` VALUES (4,4,'2010年5月','2014年5月','山东大学','本科','土木工程'),(11,19,'2019年6月','2020年6月','香港大学','博士','唱歌'),(12,20,'2019年6月','2020年6月','香港大学','博士','唱歌'),(22,5,'2010年6月','2016年8月','清华大学','博士','网管'),(23,3,'2010年5月','2014年5月','山东大学','本科','土木工程'),(24,22,'1','2','3','4','5'),(28,2,'2010年5月','2014年5月','山东大学','本科','土木工程'),(30,21,'2019年6月','2020年6月','香港大学','博士','唱歌');

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
) ENGINE=MyISAM AUTO_INCREMENT=41 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

#
# Data for table "s_employee_workexperience"
#

INSERT INTO `s_employee_workexperience` VALUES (8,19,'2019年1月','至今',NULL,NULL,NULL),(9,20,'2019年1月','至今',NULL,NULL,NULL),(25,5,'2017年','至今','null','',''),(26,22,'6','7','8','9','0'),(36,2,'2011年4月','至今','上海公司','fafa',''),(37,2,'2005年9月','2010年3月','南京公司','',''),(38,2,'2012年5月','至今','江苏公司','',''),(40,21,'2019年1月','至今','null','','');

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
) ENGINE=MyISAM AUTO_INCREMENT=35 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

#
# Data for table "s_enum"
#

INSERT INTO `s_enum` VALUES (2,'财务枚举',0,1,0),(3,'付款类型',0,1,2),(27,'系统枚举',1,1,0),(28,'岗位类型',1,1,27),(29,'工作类型',1,1,27),(32,'交通工具',0,3,2),(33,'人事',0,4,0),(34,'请假期限',0,1,33);

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
) ENGINE=MyISAM AUTO_INCREMENT=28 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

#
# Data for table "s_enum_detail"
#

INSERT INTO `s_enum_detail` VALUES (2,3,'支付宝支付','21','1',4),(3,3,'网银支付','20','1',3),(12,28,'管理类','0','1',1),(13,28,'技术类','1','1',1),(14,28,'营销类','2','1',1),(15,28,'职能类','3','1',1),(16,29,'类1','0','1',1),(17,29,'类2','1','1',1),(18,29,'类3','2','1',1),(19,29,'类4','3','1',1),(20,3,'微信支付','22','1',2),(21,32,'公共汽车','1','1',1),(22,32,'火车','2','1',2),(23,32,'轮船','3','1',3),(24,32,'飞机','4','1',4),(25,34,'一天之内','1','1',1),(26,34,'一天到三天','2','1',2),(27,34,'三天以上','3','1',3);

#
# Structure for table "s_erp_config"
#

CREATE TABLE `s_erp_config` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `key` varchar(255) NOT NULL DEFAULT '',
  `value` varchar(255) DEFAULT NULL,
  `type` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`,`key`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

#
# Data for table "s_erp_config"
#

INSERT INTO `s_erp_config` VALUES (4,'vendor_price_just_flow','1','vendor_price_just'),(5,'vendor_price_just_only_dlt_myself','0','vendor_price_just');

#
# Structure for table "s_erp_option"
#

CREATE TABLE `s_erp_option` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `option` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci,
  `dft` tinyint(3) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

#
# Data for table "s_erp_option"
#

INSERT INTO `s_erp_option` VALUES (1,'admin','我的方案','vendor_price_just_list','{\"option_ddh\":\"222\",\"option_vendor_code\":\"0101002\",\"option_vendor_name\":\"南京市爱香机械制造有限公司\",\"option_inventory_code\":\"00001\",\"option_inventory_name\":\"弹簧\"}',0),(2,'admin','我的另一个方案','vendor_price_just_list','{\"option_ddh\":\"2525\",\"option_vendor_code\":\"0101001\",\"option_vendor_name\":\"南京多云科技有限公司\",\"option_inventory_code\":\"00002\",\"option_inventory_name\":\"弹簧\"}',0),(5,'admin','myTest','vendor_price_just_list','{\"option_ddh\":\"26\",\"option_vendor_code\":\"\",\"option_vendor_name\":\"\",\"option_inventory_code\":\"\",\"option_inventory_name\":\"\"}',0);

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
  `cut_form` mediumtext CHARACTER SET utf8 COLLATE utf8_general_ci,
  `system_flow` int(1) NOT NULL DEFAULT '0',
  `system_flow_type` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=33 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

#
# Data for table "s_flow"
#

INSERT INTO `s_flow` VALUES (6,'我的标题','2020-04-12 11:37:03','2020-04-12 11:50:37',NULL,NULL,'{\"creator\":{\"S\":\"n\",\"X\":{},\"D\":0},\"end\":{\"S\":\"n\",\"X\":{},\"D\":0},\"f\":{\"S\":\"p\",\"D\":0},\"id0\":{\"S\":\"p\",\"D\":0},\"id1\":{\"T\":\"P\",\"K\":\"010099\",\"V\":\"刘德华\",\"S\":\"n\",\"Z\":1,\"C\":1,\"D\":0},\"id2\":{\"T\":\"P\",\"K\":\"010097\",\"V\":\"郭富城\",\"S\":\"n\",\"Z\":1,\"C\":1,\"D\":0}}','{\"creator\":[\"id0\"],\"f\":[\"end\"],\"id0\":[\"id1\",\"id2\"],\"id1\":[\"f\"],\"id2\":[\"f\"]}',3,NULL,'<table class=\"table-form table noselect\" style=\"margin:auto;width:601px\" data-index=\"0\" data-table=\"form-0117\"><tbody><tr><td style=\"text-align: center; vertical-align: middle; max-width: 588px; min-width: 588px; font-size: 12px; font-weight: 400; color: rgb(51, 51, 51); background: rgb(255, 255, 255) none repeat scroll 0% 0%;\" colspan=\"6\" rowspan=\"1\" data-x=\"0\" data-y=\"0\" data-type=\"text\" class=\"\">我的标题</td></tr><tr><td style=\"text-align: center; vertical-align: middle; max-width: 98px; min-width: 98px; font-size: 12px; font-weight: 400; color: rgb(51, 51, 51); background: rgb(255, 255, 255) none repeat scroll 0% 0%;\" colspan=\"1\" rowspan=\"1\" data-x=\"0\" data-y=\"1\" data-type=\"text\" class=\"\">姓名</td><td style=\"text-align: center; vertical-align: middle; max-width: 98px; min-width: 98px; font-size: 12px; font-weight: 400; color: rgb(51, 51, 51); background: rgb(255, 255, 255) none repeat scroll 0% 0%;\" colspan=\"1\" rowspan=\"1\" data-x=\"1\" data-y=\"1\" data-type=\"input\" class=\"\" data-attr=\"姓名\" data-i=\"i001\"><input readonly=\"\" noselect=\"\" type=\"text\" class=\"aya-input form-input\"></td><td style=\"text-align: center; vertical-align: middle; max-width: 98px; min-width: 98px; font-size: 12px; font-weight: 400; color: rgb(51, 51, 51); background: rgb(255, 255, 255) none repeat scroll 0% 0%;\" colspan=\"1\" rowspan=\"1\" data-x=\"2\" data-y=\"1\" data-type=\"text\" class=\"\">部门</td><td style=\"text-align: center; vertical-align: middle; max-width: 98px; min-width: 98px; font-size: 12px; font-weight: 400; color: rgb(51, 51, 51); background: rgb(255, 255, 255) none repeat scroll 0% 0%;\" colspan=\"1\" rowspan=\"1\" data-x=\"3\" data-y=\"1\" data-type=\"input\" class=\"\" data-attr=\"部门\" data-i=\"i002\"><input readonly=\"\" noselect=\"\" type=\"text\" class=\"aya-input form-input\"></td><td style=\"text-align: center; vertical-align: middle; max-width: 98px; min-width: 98px; font-size: 12px; font-weight: 400; color: rgb(51, 51, 51); background: rgb(255, 255, 255) none repeat scroll 0% 0%;\" colspan=\"1\" rowspan=\"1\" data-x=\"4\" data-y=\"1\" data-type=\"text\" class=\"\">岗位</td><td style=\"text-align: center; vertical-align: middle; max-width: 98px; min-width: 98px; font-size: 12px; font-weight: 400; color: rgb(51, 51, 51); background: rgb(255, 255, 255) none repeat scroll 0% 0%;\" colspan=\"1\" rowspan=\"1\" data-x=\"5\" data-y=\"1\" data-type=\"input\" class=\"\" data-attr=\"岗位\" data-i=\"i003\"><input readonly=\"\" noselect=\"\" type=\"text\" class=\"aya-input form-input\"></td></tr><tr><td style=\"text-align: center; vertical-align: middle; max-width: 98px; min-width: 98px; font-size: 12px; font-weight: 400; color: rgb(51, 51, 51); background: rgb(255, 255, 255) none repeat scroll 0% 0%;\" colspan=\"1\" rowspan=\"1\" data-x=\"0\" data-y=\"2\" data-type=\"text\" class=\"\">最爱吃的</td><td style=\"text-align: center; vertical-align: middle; max-width: 196px; min-width: 196px; font-size: 12px; font-weight: 400; color: rgb(51, 51, 51); background: rgb(255, 255, 255) none repeat scroll 0% 0%;\" colspan=\"2\" rowspan=\"1\" data-x=\"1\" data-y=\"2\" data-type=\"checkbox\" class=\"\">蔬菜 <input data-i=\"i004\" data-name=\"蔬菜\" type=\"checkbox\" class=\"aya-checkbox\" style=\"margin-right:24px\"> 水果 <input data-i=\"i005\" data-name=\"水果\" type=\"checkbox\" class=\"aya-checkbox\"> </td><td style=\"text-align: center; vertical-align: middle; max-width: 98px; min-width: 98px; font-size: 12px; font-weight: 400; color: rgb(51, 51, 51); background: rgb(255, 255, 255) none repeat scroll 0% 0%;\" colspan=\"1\" rowspan=\"1\" data-x=\"3\" data-y=\"2\" data-type=\"text\" class=\"\">交通工具</td><td style=\"text-align: center; vertical-align: middle; max-width: 196px; min-width: 196px; font-size: 12px; font-weight: 400; color: rgb(51, 51, 51); background: rgb(255, 255, 255) none repeat scroll 0% 0%;\" colspan=\"2\" rowspan=\"1\" data-x=\"4\" data-y=\"2\" data-type=\"select\" class=\"\" data-select=\"32\" data-name=\"交通工具\" data-i=\"i006\"><select class=\"browser-default\"><option>交通工具</option></select></td></tr><tr><td style=\"text-align: center; vertical-align: middle; max-width: 588px; min-width: 588px;\" colspan=\"6\" rowspan=\"1\" data-x=\"0\" data-y=\"3\" data-type=\"text\" class=\"\"><table class=\"table-mul\" data-table=\"subform-0114\"><thead><tr><th>序号</th><th>第一列</th><th>第二列</th></tr></thead><tbody><tr><td data-type=\"index-mul\" data-i=\"i007\">序号</td><td data-type=\"select-mul\" data-select=\"3\" data-i=\"i008\"><select class=\"browser-default\"><option value=\"3\">付款类型</option></select></td><td data-type=\"text-mul\" data-i=\"i009\"><input type=\"text\" class=\"aya-input\"></td></tr></tbody></table></td></tr><tr><td style=\"text-align:center;vertical-align:middle;max-width:98px;min-width:98px\" colspan=\"1\" rowspan=\"1\" data-x=\"0\" data-y=\"4\" data-type=\"text\"></td><td style=\"text-align:center;vertical-align:middle;max-width:98px;min-width:98px\" colspan=\"1\" rowspan=\"1\" data-x=\"1\" data-y=\"4\" data-type=\"text\"></td><td style=\"text-align:center;vertical-align:middle;max-width:98px;min-width:98px\" colspan=\"1\" rowspan=\"1\" data-x=\"2\" data-y=\"4\" data-type=\"text\"></td><td style=\"text-align:center;vertical-align:middle;max-width:98px;min-width:98px\" colspan=\"1\" rowspan=\"1\" data-x=\"3\" data-y=\"4\" data-type=\"text\"></td><td style=\"text-align:center;vertical-align:middle;max-width:98px;min-width:98px\" colspan=\"1\" rowspan=\"1\" data-x=\"4\" data-y=\"4\" data-type=\"text\"></td><td style=\"text-align:center;vertical-align:middle;max-width:98px;min-width:98px\" colspan=\"1\" rowspan=\"1\" data-x=\"5\" data-y=\"4\" data-type=\"text\"></td></tr><tr><td style=\"text-align:center;vertical-align:middle;max-width:98px;min-width:98px\" colspan=\"1\" rowspan=\"1\" data-x=\"0\" data-y=\"5\" data-type=\"text\"></td><td style=\"text-align:center;vertical-align:middle;max-width:98px;min-width:98px\" colspan=\"1\" rowspan=\"1\" data-x=\"1\" data-y=\"5\" data-type=\"text\"></td><td style=\"text-align:center;vertical-align:middle;max-width:98px;min-width:98px\" colspan=\"1\" rowspan=\"1\" data-x=\"2\" data-y=\"5\" data-type=\"text\"></td><td style=\"text-align:center;vertical-align:middle;max-width:98px;min-width:98px\" colspan=\"1\" rowspan=\"1\" data-x=\"3\" data-y=\"5\" data-type=\"text\"></td><td style=\"text-align:center;vertical-align:middle;max-width:98px;min-width:98px\" colspan=\"1\" rowspan=\"1\" data-x=\"4\" data-y=\"5\" data-type=\"text\"></td><td style=\"text-align:center;vertical-align:middle;max-width:98px;min-width:98px\" colspan=\"1\" rowspan=\"1\" data-x=\"5\" data-y=\"5\" data-type=\"text\"></td></tr></tbody></table>','管理员',1,'{\"0\":{\"0\":98,\"1\":98,\"2\":98,\"3\":98,\"4\":98,\"5\":98}}',0,'<table class=\"table-form table noselect\" style=\"margin:auto;width:601px\" data-index=\"0\" data-table=\"form-0117\"><tbody><tr><td style=\"  max-width: 588px; min-width: 588px; font-size: 12px; font-weight: 400; color: rgb(51, 51, 51); \" colspan=\"6\"    data-type=\"text\" >我的标题</td></tr><tr><td style=\"  max-width: 98px; min-width: 98px; font-size: 12px; font-weight: 400; color: rgb(51, 51, 51); \"     data-type=\"text\" >姓名</td><td style=\"  max-width: 98px; min-width: 98px; font-size: 12px; font-weight: 400; color: rgb(51, 51, 51); \"     data-type=\"input\"  data-attr=\"姓名\" data-i=\"i001\"><input readonly=\"\" noselect=\"\" type=\"text\" class=\"aya-input form-input\"></td><td style=\"  max-width: 98px; min-width: 98px; font-size: 12px; font-weight: 400; color: rgb(51, 51, 51); \"     data-type=\"text\" >部门</td><td style=\"  max-width: 98px; min-width: 98px; font-size: 12px; font-weight: 400; color: rgb(51, 51, 51); \"     data-type=\"input\"  data-attr=\"部门\" data-i=\"i002\"><input readonly=\"\" noselect=\"\" type=\"text\" class=\"aya-input form-input\"></td><td style=\"  max-width: 98px; min-width: 98px; font-size: 12px; font-weight: 400; color: rgb(51, 51, 51); \"     data-type=\"text\" >岗位</td><td style=\"  max-width: 98px; min-width: 98px; font-size: 12px; font-weight: 400; color: rgb(51, 51, 51); \"     data-type=\"input\"  data-attr=\"岗位\" data-i=\"i003\"><input readonly=\"\" noselect=\"\" type=\"text\" class=\"aya-input form-input\"></td></tr><tr><td style=\"  max-width: 98px; min-width: 98px; font-size: 12px; font-weight: 400; color: rgb(51, 51, 51); \"     data-type=\"text\" >最爱吃的</td><td style=\"  max-width: 196px; min-width: 196px; font-size: 12px; font-weight: 400; color: rgb(51, 51, 51); \" colspan=\"2\"    data-type=\"checkbox\" >蔬菜 <input data-i=\"i004\" data-name=\"蔬菜\" type=\"checkbox\" class=\"aya-checkbox\" style=\"margin-right:24px\"> 水果 <input data-i=\"i005\" data-name=\"水果\" type=\"checkbox\" class=\"aya-checkbox\"> </td><td style=\"  max-width: 98px; min-width: 98px; font-size: 12px; font-weight: 400; color: rgb(51, 51, 51); \"     data-type=\"text\" >交通工具</td><td style=\"  max-width: 196px; min-width: 196px; font-size: 12px; font-weight: 400; color: rgb(51, 51, 51); \" colspan=\"2\"    data-type=\"select\"  data-select=\"32\" data-name=\"交通工具\" data-i=\"i006\"><select class=\"browser-default\"><option>交通工具</option></select></td></tr><tr><td style=\"  max-width: 588px; min-width: 588px;\" colspan=\"6\"    data-type=\"text\" ><table class=\"table-mul\" data-table=\"subform-0114\"><thead><tr><th>序号</th><th>第一列</th><th>第二列</th></tr></thead><tbody><tr><td data-type=\"index-mul\" data-i=\"i007\">序号</td><td data-type=\"select-mul\" data-select=\"3\" data-i=\"i008\"><select class=\"browser-default\"><option value=\"3\">付款类型</option></select></td><td data-type=\"text-mul\" data-i=\"i009\"><input type=\"text\" class=\"aya-input\"></td></tr></tbody></table></td></tr><tr><td style=\"max-width:98px;min-width:98px\"     data-type=\"text\"></td><td style=\"max-width:98px;min-width:98px\"     data-type=\"text\"></td><td style=\"max-width:98px;min-width:98px\"     data-type=\"text\"></td><td style=\"max-width:98px;min-width:98px\"     data-type=\"text\"></td><td style=\"max-width:98px;min-width:98px\"     data-type=\"text\"></td><td style=\"max-width:98px;min-width:98px\"     data-type=\"text\"></td></tr><tr><td style=\"max-width:98px;min-width:98px\"     data-type=\"text\"></td><td style=\"max-width:98px;min-width:98px\"     data-type=\"text\"></td><td style=\"max-width:98px;min-width:98px\"     data-type=\"text\"></td><td style=\"max-width:98px;min-width:98px\"     data-type=\"text\"></td><td style=\"max-width:98px;min-width:98px\"     data-type=\"text\"></td><td style=\"max-width:98px;min-width:98px\"     data-type=\"text\"></td></tr></tbody></table>',0,NULL),(8,'测试标题','2020-04-13 09:53:09','2020-04-18 10:02:21',NULL,NULL,'{\"creator\":{\"S\":\"n\",\"X\":{},\"D\":0},\"end\":{\"S\":\"n\",\"X\":{},\"D\":0},\"f\":{\"S\":\"p\",\"D\":0},\"id3\":{\"S\":\"p\",\"D\":0},\"id4\":{\"T\":\"P\",\"K\":\"010099\",\"V\":\"刘德华\",\"S\":\"n\",\"Z\":1,\"C\":1,\"D\":0},\"id5\":{\"S\":\"p\",\"D\":0},\"id6\":{\"T\":\"P\",\"K\":\"010097\",\"V\":\"郭富城\",\"S\":\"n\",\"Z\":1,\"X\":[[\"\",\"i002\",\"0\",\"\",\"\"]],\"C\":\"3\",\"D\":0},\"id7\":{\"T\":\"P\",\"K\":\"010099\",\"V\":\"刘德华\",\"S\":\"n\",\"Z\":1,\"X\":[[\"\",\"i002\",\"1\",\"\",\"&&\"],[\"\",\"i001\",\"1\",\"\",\"\"]],\"C\":\"3\",\"D\":0}}','{\"creator\":[\"id3\"],\"f\":[\"end\"],\"id3\":[\"id4\"],\"id4\":[\"id5\"],\"id5\":[\"id6\",\"id7\"],\"id6\":[\"f\"],\"id7\":[\"f\"]}',8,NULL,'<table class=\"table-form table noselect\" style=\"margin:auto;width:601px\" data-index=\"0\" data-table=\"form-0120\"><tbody><tr><td style=\"text-align: center; vertical-align: middle; max-width: 588px; min-width: 588px; font-size: 12px; font-weight: 400; color: rgb(51, 51, 51); background: rgb(255, 255, 255) none repeat scroll 0% 0%;\" colspan=\"6\" rowspan=\"1\" data-x=\"0\" data-y=\"0\" data-type=\"text\" class=\"border-top-none border-left-none border-right-none border-bottom-none\">测试标题</td></tr><tr><td style=\"text-align: center; vertical-align: middle; max-width: 98px; min-width: 98px; font-size: 12px; font-weight: 400; color: rgb(51, 51, 51); background: rgb(255, 255, 255) none repeat scroll 0% 0%;\" colspan=\"1\" rowspan=\"1\" data-x=\"0\" data-y=\"1\" data-type=\"text\" class=\"\">姓名</td><td style=\"text-align: center; vertical-align: middle; max-width: 98px; min-width: 98px; font-size: 12px; font-weight: 400; color: rgb(51, 51, 51); background: rgb(255, 255, 255) none repeat scroll 0% 0%;\" colspan=\"1\" rowspan=\"1\" data-x=\"1\" data-y=\"1\" data-type=\"input\" class=\"\" data-attr=\"姓名\" data-i=\"i009\"><input readonly=\"\" noselect=\"\" type=\"text\" class=\"aya-input form-input\"></td><td style=\"text-align: center; vertical-align: middle; max-width: 98px; min-width: 98px; font-size: 12px; font-weight: 400; color: rgb(51, 51, 51); background: rgb(255, 255, 255) none repeat scroll 0% 0%;\" colspan=\"1\" rowspan=\"1\" data-x=\"2\" data-y=\"1\" data-type=\"text\" class=\"\">部门</td><td style=\"text-align: center; vertical-align: middle; max-width: 98px; min-width: 98px; font-size: 12px; font-weight: 400; color: rgb(51, 51, 51); background: rgb(255, 255, 255) none repeat scroll 0% 0%;\" colspan=\"1\" rowspan=\"1\" data-x=\"3\" data-y=\"1\" data-type=\"input\" class=\"\" data-attr=\"部门\" data-i=\"i010\"><input readonly=\"\" noselect=\"\" type=\"text\" class=\"aya-input form-input\"></td><td style=\"text-align: center; vertical-align: middle; max-width: 98px; min-width: 98px; font-size: 12px; font-weight: 400; color: rgb(51, 51, 51); background: rgb(255, 255, 255) none repeat scroll 0% 0%;\" colspan=\"1\" rowspan=\"1\" data-x=\"4\" data-y=\"1\" data-type=\"text\" class=\"\">岗位</td><td style=\"text-align: center; vertical-align: middle; max-width: 98px; min-width: 98px; font-size: 12px; font-weight: 400; color: rgb(51, 51, 51); background: rgb(255, 255, 255) none repeat scroll 0% 0%;\" colspan=\"1\" rowspan=\"1\" data-x=\"5\" data-y=\"1\" data-type=\"input\" class=\"\" data-attr=\"岗位\" data-i=\"i011\"><input readonly=\"\" noselect=\"\" type=\"text\" class=\"aya-input form-input\"></td></tr><tr><td style=\"text-align: center; vertical-align: middle; max-width: 98px; min-width: 98px; font-size: 12px; font-weight: 400; color: rgb(51, 51, 51); background: rgb(255, 255, 255) none repeat scroll 0% 0%;\" colspan=\"1\" rowspan=\"1\" data-x=\"0\" data-y=\"2\" data-type=\"text\" class=\"\">最爱的食物</td><td style=\"text-align: center; vertical-align: middle; max-width: 196px; min-width: 196px; font-size: 12px; font-weight: 400; color: rgb(51, 51, 51); background: rgb(255, 255, 255) none repeat scroll 0% 0%;\" colspan=\"2\" rowspan=\"1\" data-x=\"1\" data-y=\"2\" data-type=\"checkbox\" class=\"\">水果 <input data-i=\"i001\" data-name=\"水果\" type=\"checkbox\" class=\"aya-checkbox\" style=\"margin-right:24px\"> 海鲜 <input data-i=\"i002\" data-name=\"海鲜\" type=\"checkbox\" class=\"aya-checkbox\"> </td><td style=\"text-align: center; vertical-align: middle; max-width: 98px; min-width: 98px; font-size: 12px; font-weight: 400; color: rgb(51, 51, 51); background: rgb(255, 255, 255) none repeat scroll 0% 0%;\" colspan=\"1\" rowspan=\"1\" data-x=\"3\" data-y=\"2\" data-type=\"text\" class=\"\">最爱的运动</td><td style=\"text-align: center; vertical-align: middle; max-width: 196px; min-width: 196px; font-size: 12px; font-weight: 400; color: rgb(51, 51, 51); background: rgb(255, 255, 255) none repeat scroll 0% 0%;\" colspan=\"2\" rowspan=\"1\" data-x=\"4\" data-y=\"2\" data-type=\"radio\" class=\"\"><p style=\"display:inline-block\">足球 <input data-i=\"i003\" name=\"r1586742723486\" data-name=\"足球\" type=\"radio\" class=\"aya-radio\" style=\"margin-right:24px\"></p> <p style=\"display:inline-block\">乒乓球 <input data-i=\"i004\" name=\"r1586742723486\" data-name=\"乒乓球\" type=\"radio\" class=\"aya-radio\" style=\"margin-right:24px\"></p> </td></tr><tr><td style=\"text-align: center; vertical-align: middle; max-width: 98px; min-width: 98px; font-size: 12px; font-weight: 400; color: rgb(51, 51, 51); background: rgb(255, 255, 255) none repeat scroll 0% 0%;\" colspan=\"1\" rowspan=\"1\" data-x=\"0\" data-y=\"3\" data-type=\"text\" class=\"\">交通工具</td><td style=\"text-align: center; vertical-align: middle; max-width: 196px; min-width: 196px; font-size: 12px; font-weight: 400; color: rgb(51, 51, 51); background: rgb(255, 255, 255) none repeat scroll 0% 0%;\" colspan=\"2\" rowspan=\"1\" data-x=\"1\" data-y=\"3\" data-type=\"select\" class=\"\" data-select=\"32\" data-name=\"交通工具\" data-i=\"i005\"><select class=\"browser-default\"><option>交通工具</option></select></td><td style=\"text-align:center;vertical-align:middle;max-width:98px;min-width:98px\" colspan=\"1\" rowspan=\"1\" data-x=\"3\" data-y=\"3\" data-type=\"text\"></td><td style=\"text-align:center;vertical-align:middle;max-width:98px;min-width:98px\" colspan=\"1\" rowspan=\"1\" data-x=\"4\" data-y=\"3\" data-type=\"text\"></td><td style=\"text-align:center;vertical-align:middle;max-width:98px;min-width:98px\" colspan=\"1\" rowspan=\"1\" data-x=\"5\" data-y=\"3\" data-type=\"text\"></td></tr><tr><td style=\"text-align: center; vertical-align: middle; max-width: 588px; min-width: 588px;\" colspan=\"6\" rowspan=\"1\" data-x=\"0\" data-y=\"4\" data-type=\"text\" class=\"\"><table class=\"table-mul\" data-table=\"subform-0117\"><thead><tr><th>序号</th><th>项目名称</th><th>付款类型</th></tr></thead><tbody><tr><td data-type=\"index-mul\" data-i=\"i006\" style=\"min-width: 0px; max-width: 0px;\">序号</td><td data-type=\"text-mul\" data-i=\"i007\" style=\"min-width: 0px; max-width: 0px;\"><input type=\"text\" class=\"aya-input\"></td><td data-type=\"select-mul\" data-select=\"3\" data-i=\"i008\" style=\"min-width: 0px; max-width: 0px;\"><select class=\"browser-default\"><option value=\"3\">付款类型</option></select></td></tr></tbody></table></td></tr><tr><td style=\"text-align: center; vertical-align: middle; max-width: 588px; min-width: 588px; font-size: 12px; font-weight: 400; color: rgb(51, 51, 51); background: rgb(255, 255, 255) none repeat scroll 0% 0%;\" colspan=\"6\" rowspan=\"1\" data-x=\"0\" data-y=\"5\" data-type=\"text\" class=\"border-top-none border-left-none border-right-none\">11</td></tr></tbody></table>','管理员',1,'{\"0\":{\"0\":98,\"1\":98,\"2\":98,\"3\":98,\"4\":98,\"5\":98}}',0,'<table class=\"table-form table noselect\" style=\"margin:auto;width:601px\" data-index=\"0\" data-table=\"form-0120\"><tbody><tr><td style=\"  max-width: 588px; min-width: 588px; font-size: 12px; font-weight: 400; color: rgb(51, 51, 51); \" colspan=\"6\"    data-type=\"text\" class=\"border-top-none border-left-none border-right-none border-bottom-none\">测试标题</td></tr><tr><td style=\"  max-width: 98px; min-width: 98px; font-size: 12px; font-weight: 400; color: rgb(51, 51, 51); \"     data-type=\"text\" >姓名</td><td style=\"  max-width: 98px; min-width: 98px; font-size: 12px; font-weight: 400; color: rgb(51, 51, 51); \"     data-type=\"input\"  data-attr=\"姓名\" data-i=\"i009\"><input readonly=\"\" noselect=\"\" type=\"text\" class=\"aya-input form-input\"></td><td style=\"  max-width: 98px; min-width: 98px; font-size: 12px; font-weight: 400; color: rgb(51, 51, 51); \"     data-type=\"text\" >部门</td><td style=\"  max-width: 98px; min-width: 98px; font-size: 12px; font-weight: 400; color: rgb(51, 51, 51); \"     data-type=\"input\"  data-attr=\"部门\" data-i=\"i010\"><input readonly=\"\" noselect=\"\" type=\"text\" class=\"aya-input form-input\"></td><td style=\"  max-width: 98px; min-width: 98px; font-size: 12px; font-weight: 400; color: rgb(51, 51, 51); \"     data-type=\"text\" >岗位</td><td style=\"  max-width: 98px; min-width: 98px; font-size: 12px; font-weight: 400; color: rgb(51, 51, 51); \"     data-type=\"input\"  data-attr=\"岗位\" data-i=\"i011\"><input readonly=\"\" noselect=\"\" type=\"text\" class=\"aya-input form-input\"></td></tr><tr><td style=\"  max-width: 98px; min-width: 98px; font-size: 12px; font-weight: 400; color: rgb(51, 51, 51); \"     data-type=\"text\" >最爱的食物</td><td style=\"  max-width: 196px; min-width: 196px; font-size: 12px; font-weight: 400; color: rgb(51, 51, 51); \" colspan=\"2\"    data-type=\"checkbox\" >水果 <input data-i=\"i001\" data-name=\"水果\" type=\"checkbox\" class=\"aya-checkbox\" style=\"margin-right:24px\"> 海鲜 <input data-i=\"i002\" data-name=\"海鲜\" type=\"checkbox\" class=\"aya-checkbox\"> </td><td style=\"  max-width: 98px; min-width: 98px; font-size: 12px; font-weight: 400; color: rgb(51, 51, 51); \"     data-type=\"text\" >最爱的运动</td><td style=\"  max-width: 196px; min-width: 196px; font-size: 12px; font-weight: 400; color: rgb(51, 51, 51); \" colspan=\"2\"    data-type=\"radio\" ><p style=\"display:inline-block\">足球 <input data-i=\"i003\" name=\"r1586742723486\" data-name=\"足球\" type=\"radio\" class=\"aya-radio\" style=\"margin-right:24px\"></p> <p style=\"display:inline-block\">乒乓球 <input data-i=\"i004\" name=\"r1586742723486\" data-name=\"乒乓球\" type=\"radio\" class=\"aya-radio\" style=\"margin-right:24px\"></p> </td></tr><tr><td style=\"  max-width: 98px; min-width: 98px; font-size: 12px; font-weight: 400; color: rgb(51, 51, 51); \"     data-type=\"text\" >交通工具</td><td style=\"  max-width: 196px; min-width: 196px; font-size: 12px; font-weight: 400; color: rgb(51, 51, 51); \" colspan=\"2\"    data-type=\"select\"  data-select=\"32\" data-name=\"交通工具\" data-i=\"i005\"><select class=\"browser-default\"><option>交通工具</option></select></td><td style=\"max-width:98px;min-width:98px\"     data-type=\"text\"></td><td style=\"max-width:98px;min-width:98px\"     data-type=\"text\"></td><td style=\"max-width:98px;min-width:98px\"     data-type=\"text\"></td></tr><tr><td style=\"  max-width: 588px; min-width: 588px;\" colspan=\"6\"    data-type=\"text\" ><table class=\"table-mul\" data-table=\"subform-0117\"><thead><tr><th>序号</th><th>项目名称</th><th>付款类型</th></tr></thead><tbody><tr><td data-type=\"index-mul\" data-i=\"i006\" style=\"min-width: 0px; max-width: 0px;\">序号</td><td data-type=\"text-mul\" data-i=\"i007\" style=\"min-width: 0px; max-width: 0px;\"><input type=\"text\" class=\"aya-input\"></td><td data-type=\"select-mul\" data-select=\"3\" data-i=\"i008\" style=\"min-width: 0px; max-width: 0px;\"><select class=\"browser-default\"><option value=\"3\">付款类型</option></select></td></tr></tbody></table></td></tr><tr><td style=\"  max-width: 588px; min-width: 588px; font-size: 12px; font-weight: 400; color: rgb(51, 51, 51); \" colspan=\"6\"    data-type=\"text\" class=\"border-top-none border-left-none border-right-none\">11</td></tr></tbody></table>',0,NULL),(28,'111','2020-04-20 13:15:26','2020-05-18 15:37:24',NULL,NULL,'{\"creator\":{\"S\":\"n\",\"X\":{},\"D\":0},\"end\":{\"S\":\"n\",\"X\":{},\"D\":0},\"f\":{\"S\":\"p\",\"D\":0},\"id0\":{\"S\":\"p\",\"D\":0},\"id1\":{\"T\":\"P\",\"K\":\"010099\",\"V\":\"刘德华\",\"S\":\"n\",\"Z\":1,\"C\":\"3\",\"D\":0,\"X\":[[\"\",\"i004\",\"1\",\"\",\"\"]]},\"id2\":{\"T\":\"P\",\"K\":\"010097\",\"V\":\"郭富城\",\"S\":\"n\",\"Z\":1,\"C\":\"3\",\"D\":0,\"X\":[[\"\",\"i005\",\"1\",\"\",\"\"]]},\"id4\":{\"S\":\"p\",\"D\":0},\"id5\":{\"T\":\"P\",\"K\":\"010155\",\"V\":\"王泉\",\"S\":\"n\",\"Z\":1,\"C\":\"3\",\"D\":0,\"X\":[[\"\",\"aya1\",\"==\",\"3|1\",\"\",\"&&\"],[\"\",\"aya2\",\"==\",\"3\",\"\",\"\"]]},\"id6\":{\"S\":\"p\",\"D\":0},\"id7\":{\"T\":\"P\",\"K\":\"010099\",\"V\":\"刘德华\",\"S\":\"n\",\"Z\":1,\"C\":1,\"D\":0},\"id10\":{\"S\":\"p\",\"D\":0},\"id11\":{\"T\":\"D\",\"K\":\"2|1\",\"V\":\"综合管理部\",\"S\":\"n\",\"Z\":1,\"C\":1,\"D\":0},\"id12\":{\"S\":\"p\",\"D\":0},\"id13\":{\"T\":\"P\",\"K\":\"010004\",\"V\":\"王泉\",\"S\":\"n\",\"Z\":1,\"C\":1,\"D\":0}}','{\"creator\":[\"id6\"],\"f\":[\"id5\"],\"id0\":[\"id1\",\"id2\"],\"id1\":[\"f\"],\"id2\":[\"f\"],\"id4\":[\"end\"],\"id5\":[\"id4\"],\"id6\":[\"id7\"],\"id7\":[\"id12\"],\"id10\":[\"id11\"],\"id11\":[\"id0\"],\"id12\":[\"id13\"],\"id13\":[\"id10\"]}',14,NULL,'<table class=\"table-form table noselect\" style=\"margin:auto;width:601px\" \'\'=\"\" data-index=\"0\" data-table=\"form-0153\"><tbody><tr><td data-type=\"text\" data-x=\"0\" data-y=\"0\" colspan=\"1 rowspan = \" 1\'=\"\" style=\"text-align: center; vertical-align: middle; max-width: 98px; min-width: 98px; font-size: 12px; font-weight: 400; color: rgb(51, 51, 51); background: rgb(255, 255, 255) none repeat scroll 0% 0%;\" class=\"border-top-none border-left-none border-right-none border-bottom-none\"></td><td data-type=\"text\" data-x=\"1\" data-y=\"0\" colspan=\"1 rowspan = \" 1\'=\"\" style=\"text-align: center; vertical-align: middle; max-width: 98px; min-width: 98px; font-size: 12px; font-weight: 400; color: rgb(51, 51, 51); background: rgb(255, 255, 255) none repeat scroll 0% 0%;\" class=\"border-top-none border-left-none border-right-none border-bottom-none\"></td><td data-type=\"text\" data-x=\"2\" data-y=\"0\" colspan=\"2\" 1\'=\"\" style=\"text-align: center; vertical-align: middle; max-width: 196px; min-width: 196px; font-size: 12px; font-weight: 400; color: rgb(51, 51, 51); background: rgb(255, 255, 255) none repeat scroll 0% 0%;\" class=\"border-top-none border-left-none border-right-none border-bottom-none\" rowspan=\"1\">财务借款流程</td><td data-type=\"text\" data-x=\"4\" data-y=\"0\" colspan=\"1 rowspan = \" 1\'=\"\" style=\"text-align: center; vertical-align: middle; max-width: 98px; min-width: 98px; font-size: 12px; font-weight: 400; color: rgb(51, 51, 51); background: rgb(255, 255, 255) none repeat scroll 0% 0%;\" class=\"border-top-none border-left-none border-right-none border-bottom-none\"></td><td data-type=\"text\" data-x=\"5\" data-y=\"0\" colspan=\"1 rowspan = \" 1\'=\"\" style=\"text-align: center; vertical-align: middle; max-width: 98px; min-width: 98px; font-size: 12px; font-weight: 400; color: rgb(51, 51, 51); background: rgb(255, 255, 255) none repeat scroll 0% 0%;\" class=\"border-top-none border-left-none border-right-none border-bottom-none\"></td></tr><tr style=\"height: 50px;\"><td style=\"text-align: center; vertical-align: middle; max-width: 98px; min-width: 98px; font-size: 12px; font-weight: 400; color: rgb(51, 51, 51); background: rgb(255, 255, 255) none repeat scroll 0% 0%;\" colspan=\"1\" rowspan=\"1\" data-x=\"0\" data-y=\"1\" data-type=\"text\" class=\"\">姓名</td><td style=\"text-align: center; vertical-align: middle; max-width: 98px; min-width: 98px; font-size: 12px; font-weight: 400; color: rgb(51, 51, 51); background: rgb(255, 255, 255) none repeat scroll 0% 0%;\" colspan=\"1\" rowspan=\"1\" data-x=\"1\" data-y=\"1\" data-type=\"input\" class=\"\" data-attr=\"姓名\" data-i=\"i001\"><input readonly=\"\" noselect=\"\" type=\"text\" class=\"aya-input form-input\"></td><td style=\"text-align: center; vertical-align: middle; max-width: 98px; min-width: 98px; font-size: 12px; font-weight: 400; color: rgb(51, 51, 51); background: rgb(255, 255, 255) none repeat scroll 0% 0%;\" colspan=\"1\" rowspan=\"1\" data-x=\"2\" data-y=\"1\" data-type=\"text\" class=\"\">岗位</td><td style=\"text-align: center; vertical-align: middle; max-width: 98px; min-width: 98px; font-size: 12px; font-weight: 400; color: rgb(51, 51, 51); background: rgb(255, 255, 255) none repeat scroll 0% 0%;\" colspan=\"1\" rowspan=\"1\" data-x=\"3\" data-y=\"1\" data-type=\"input\" class=\"\" data-attr=\"岗位\" data-i=\"i002\"><input readonly=\"\" noselect=\"\" type=\"text\" class=\"aya-input form-input\"></td><td style=\"text-align:center;vertical-align:middle;max-width:98px;min-width:98px\" colspan=\"1\" rowspan=\"1\" data-x=\"4\" data-y=\"1\" data-type=\"text\" class=\"\"></td><td style=\"text-align:center;vertical-align:middle;max-width:98px;min-width:98px\" colspan=\"1\" rowspan=\"1\" data-x=\"5\" data-y=\"1\" data-type=\"text\" class=\"\"></td></tr><tr style=\"height: 50px;\"><td style=\"text-align:center;vertical-align:middle;max-width:98px;min-width:98px\" colspan=\"1\" rowspan=\"1\" data-x=\"0\" data-y=\"2\" data-type=\"text\" class=\"\"></td><td style=\"text-align:center;vertical-align:middle;max-width:98px;min-width:98px\" colspan=\"1\" rowspan=\"1\" data-x=\"1\" data-y=\"2\" data-type=\"text\" class=\"\"></td><td style=\"text-align:center;vertical-align:middle;max-width:98px;min-width:98px\" colspan=\"1\" rowspan=\"1\" data-x=\"2\" data-y=\"2\" data-type=\"text\" class=\"\"></td><td style=\"text-align:center;vertical-align:middle;max-width:98px;min-width:98px\" colspan=\"1\" rowspan=\"1\" data-x=\"3\" data-y=\"2\" data-type=\"text\" class=\"\"></td><td style=\"text-align:center;vertical-align:middle;max-width:98px;min-width:98px\" colspan=\"1\" rowspan=\"1\" data-x=\"4\" data-y=\"2\" data-type=\"text\" class=\"\"></td><td style=\"text-align:center;vertical-align:middle;max-width:98px;min-width:98px\" colspan=\"1\" rowspan=\"1\" data-x=\"5\" data-y=\"2\" data-type=\"text\" class=\"\"></td></tr><tr style=\"height: 50px;\"><td style=\"text-align: center; vertical-align: middle; max-width: 294px; min-width: 294px; font-size: 12px; font-weight: 400; color: rgb(51, 51, 51); background: rgb(255, 255, 255) none repeat scroll 0% 0%;\" colspan=\"3\" rowspan=\"1\" data-x=\"0\" data-y=\"3\" data-type=\"checkbox\" class=\"\">蔬菜 <input name=\"c1587456716803\" data-i=\"i003\" data-name=\"蔬菜\" type=\"checkbox\" class=\"aya-checkbox\" style=\"margin-right:24px\"> 水果 <input name=\"c1587456716803\" data-i=\"i004\" data-name=\"水果\" type=\"checkbox\" class=\"aya-checkbox\" style=\"margin-right:24px\"> 肉类 <input name=\"c1587456716803\" data-i=\"i005\" data-name=\"肉类\" type=\"checkbox\" class=\"aya-checkbox\"> </td><td style=\"text-align: center; vertical-align: middle; max-width: 294px; min-width: 294px; font-size: 12px; font-weight: 400; color: rgb(51, 51, 51); background: rgb(255, 255, 255);\" colspan=\"3\" rowspan=\"1\" data-x=\"3\" data-y=\"3\" data-type=\"radio\" class=\"\"><p style=\"display:inline-block\">足球 <input data-i=\"i009\" name=\"r1587948720399\" data-name=\"足球\" type=\"radio\" class=\"aya-radio\" style=\"margin-right:24px\"></p> <p style=\"display:inline-block\">篮球 <input data-i=\"i010\" name=\"r1587948720399\" data-name=\"篮球\" type=\"radio\" class=\"aya-radio\" style=\"margin-right:24px\"></p> <p style=\"display:inline-block\">排球 <input data-i=\"i011\" name=\"r1587948720399\" data-name=\"排球\" type=\"radio\" class=\"aya-radio\" style=\"margin-right:24px\"></p> </td></tr><tr style=\"height: 50px;\"><td style=\"text-align:center;vertical-align:middle;max-width:98px;min-width:98px\" colspan=\"1\" rowspan=\"1\" data-x=\"0\" data-y=\"4\" data-type=\"text\" class=\"\"></td><td style=\"text-align:center;vertical-align:middle;max-width:98px;min-width:98px\" colspan=\"1\" rowspan=\"1\" data-x=\"1\" data-y=\"4\" data-type=\"text\" class=\"\"></td><td style=\"text-align:center;vertical-align:middle;max-width:98px;min-width:98px\" colspan=\"1\" rowspan=\"1\" data-x=\"2\" data-y=\"4\" data-type=\"text\" class=\"\"></td><td style=\"text-align:center;vertical-align:middle;max-width:98px;min-width:98px\" colspan=\"1\" rowspan=\"1\" data-x=\"3\" data-y=\"4\" data-type=\"text\" class=\"\"></td><td style=\"text-align: center; vertical-align: middle; max-width: 98px; min-width: 98px; font-size: 12px; font-weight: 400; color: rgb(51, 51, 51); background: rgb(255, 255, 255);\" colspan=\"1\" rowspan=\"1\" data-x=\"4\" data-y=\"4\" data-type=\"text\" class=\"\">付款方式</td><td style=\"text-align: center; vertical-align: middle; max-width: 98px; min-width: 98px; font-size: 12px; font-weight: 400; color: rgb(51, 51, 51); background: rgb(255, 255, 255);\" colspan=\"1\" rowspan=\"1\" data-x=\"5\" data-y=\"4\" data-type=\"select\" class=\"\" data-select=\"3\" data-name=\"付款类型\" data-i=\"i012\"><select class=\"browser-default\"><option>付款类型</option></select></td></tr><tr style=\"height: 50px;\"><td style=\"text-align:center;vertical-align:middle;max-width:98px;min-width:98px\" colspan=\"1\" rowspan=\"1\" data-x=\"0\" data-y=\"5\" data-type=\"text\" class=\"\"></td><td style=\"text-align: center; vertical-align: middle; max-width: 98px; min-width: 98px; font-size: 12px; font-weight: 400; color: rgb(51, 51, 51); background: rgb(255, 255, 255) none repeat scroll 0% 0%;\" colspan=\"1\" rowspan=\"1\" data-x=\"1\" data-y=\"5\" data-type=\"text\" class=\"\">阿发</td><td style=\"text-align: center; vertical-align: middle; max-width: 98px; min-width: 98px; font-size: 12px; font-weight: 400; color: rgb(51, 51, 51); background: rgb(255, 255, 255) none repeat scroll 0% 0%;\" colspan=\"1\" rowspan=\"1\" data-x=\"2\" data-y=\"5\" data-type=\"input\" class=\"\" data-attr=\"阿发\" data-i=\"i006\"><input readonly=\"\" noselect=\"\" type=\"text\" class=\"aya-input form-input\"></td><td style=\"text-align:center;vertical-align:middle;max-width:98px;min-width:98px\" colspan=\"1\" rowspan=\"1\" data-x=\"3\" data-y=\"5\" data-type=\"text\"></td><td style=\"text-align:center;vertical-align:middle;max-width:98px;min-width:98px\" colspan=\"1\" rowspan=\"1\" data-x=\"4\" data-y=\"5\" data-type=\"text\" class=\"\"></td><td style=\"text-align:center;vertical-align:middle;max-width:98px;min-width:98px\" colspan=\"1\" rowspan=\"1\" data-x=\"5\" data-y=\"5\" data-type=\"text\" class=\"\"></td></tr><tr style=\"height: 50px;\"><td style=\"text-align:center;vertical-align:middle;max-width:98px;min-width:98px\" colspan=\"1\" rowspan=\"1\" data-x=\"0\" data-y=\"6\" data-type=\"text\" class=\"\"></td><td style=\"text-align: center; vertical-align: middle; max-width: 98px; min-width: 98px; font-size: 12px; font-weight: 400; color: rgb(51, 51, 51); background: rgb(255, 255, 255) none repeat scroll 0% 0%;\" colspan=\"1\" rowspan=\"1\" data-x=\"1\" data-y=\"6\" data-type=\"text\" class=\"\">飒然</td><td style=\"text-align: center; vertical-align: middle; max-width: 98px; min-width: 98px; font-size: 12px; font-weight: 400; color: rgb(51, 51, 51); background: rgb(255, 255, 255) none repeat scroll 0% 0%;\" colspan=\"1\" rowspan=\"1\" data-x=\"2\" data-y=\"6\" data-type=\"input\" class=\"\" data-attr=\"飒然\" data-i=\"i007\"><input readonly=\"\" noselect=\"\" type=\"text\" class=\"aya-input form-input\"></td><td style=\"text-align: center; vertical-align: middle; max-width: 98px; min-width: 98px; font-size: 12px; font-weight: 400; color: rgb(51, 51, 51); background: rgb(255, 255, 255) none repeat scroll 0% 0%;\" colspan=\"1\" rowspan=\"1\" data-x=\"3\" data-y=\"6\" data-type=\"text\" class=\"\">天天</td><td style=\"text-align: center; vertical-align: middle; max-width: 98px; min-width: 98px; font-size: 12px; font-weight: 400; color: rgb(51, 51, 51); background: rgb(255, 255, 255) none repeat scroll 0% 0%;\" colspan=\"1\" rowspan=\"1\" data-x=\"4\" data-y=\"6\" data-type=\"input\" class=\"\" data-attr=\"天天\" data-i=\"i008\"><input readonly=\"\" noselect=\"\" type=\"text\" class=\"aya-input form-input\"></td><td style=\"text-align:center;vertical-align:middle;max-width:98px;min-width:98px\" colspan=\"1\" rowspan=\"1\" data-x=\"5\" data-y=\"6\" data-type=\"text\" class=\"\"></td></tr><tr><td data-type=\"text\" data-x=\"0\" data-y=\"7\" colspan=\"6\" 1\'=\"\" style=\"text-align: center; vertical-align: middle; max-width: 588px; min-width: 588px;\" class=\"\" rowspan=\"1\"><table class=\"table-mul\" data-table=\"subform-0124\"><thead><tr><th>序号</th><th>姓名</th><th>交通</th></tr></thead><tbody><tr><td data-type=\"index-mul\" data-i=\"i013\">序号</td><td data-type=\"text-mul\" data-i=\"i014\"><input type=\"text\" class=\"aya-input\"></td><td data-type=\"select-mul\" data-select=\"32\" data-i=\"i015\"><select class=\"browser-default\"><option value=\"32\">交通工具</option></select></td></tr></tbody></table></td></tr></tbody></table>','管理员',1,'{\"0\":{\"0\":98,\"1\":98,\"2\":98,\"3\":98,\"4\":98,\"5\":98}}',5,'<table class=\"table-form table noselect\" style=\"margin:auto;width:601px\" \'\'=\"\" data-index=\"0\" data-table=\"form-0153\"><tbody><tr><td data-type=\"text\"   colspan=\"1 rowspan = \" 1\'=\"\" style=\"  max-width: 98px; min-width: 98px; font-size: 12px; font-weight: 400; color: rgb(51, 51, 51); \" class=\"border-top-none border-left-none border-right-none border-bottom-none\"></td><td data-type=\"text\"   colspan=\"1 rowspan = \" 1\'=\"\" style=\"  max-width: 98px; min-width: 98px; font-size: 12px; font-weight: 400; color: rgb(51, 51, 51); \" class=\"border-top-none border-left-none border-right-none border-bottom-none\"></td><td data-type=\"text\"   colspan=\"2\" 1\'=\"\" style=\"  max-width: 196px; min-width: 196px; font-size: 12px; font-weight: 400; color: rgb(51, 51, 51); \" class=\"border-top-none border-left-none border-right-none border-bottom-none\" >财务借款流程</td><td data-type=\"text\"   colspan=\"1 rowspan = \" 1\'=\"\" style=\"  max-width: 98px; min-width: 98px; font-size: 12px; font-weight: 400; color: rgb(51, 51, 51); \" class=\"border-top-none border-left-none border-right-none border-bottom-none\"></td><td data-type=\"text\"   colspan=\"1 rowspan = \" 1\'=\"\" style=\"  max-width: 98px; min-width: 98px; font-size: 12px; font-weight: 400; color: rgb(51, 51, 51); \" class=\"border-top-none border-left-none border-right-none border-bottom-none\"></td></tr><tr style=\"height: 50px;\"><td style=\"  max-width: 98px; min-width: 98px; font-size: 12px; font-weight: 400; color: rgb(51, 51, 51); \"     data-type=\"text\" >姓名</td><td style=\"  max-width: 98px; min-width: 98px; font-size: 12px; font-weight: 400; color: rgb(51, 51, 51); \"     data-type=\"input\"  data-attr=\"姓名\" data-i=\"i001\"><input readonly=\"\" noselect=\"\" type=\"text\" class=\"aya-input form-input\"></td><td style=\"  max-width: 98px; min-width: 98px; font-size: 12px; font-weight: 400; color: rgb(51, 51, 51); \"     data-type=\"text\" >岗位</td><td style=\"  max-width: 98px; min-width: 98px; font-size: 12px; font-weight: 400; color: rgb(51, 51, 51); \"     data-type=\"input\"  data-attr=\"岗位\" data-i=\"i002\"><input readonly=\"\" noselect=\"\" type=\"text\" class=\"aya-input form-input\"></td><td style=\"max-width:98px;min-width:98px\"     data-type=\"text\" ></td><td style=\"max-width:98px;min-width:98px\"     data-type=\"text\" ></td></tr><tr style=\"height: 50px;\"><td style=\"max-width:98px;min-width:98px\"     data-type=\"text\" ></td><td style=\"max-width:98px;min-width:98px\"     data-type=\"text\" ></td><td style=\"max-width:98px;min-width:98px\"     data-type=\"text\" ></td><td style=\"max-width:98px;min-width:98px\"     data-type=\"text\" ></td><td style=\"max-width:98px;min-width:98px\"     data-type=\"text\" ></td><td style=\"max-width:98px;min-width:98px\"     data-type=\"text\" ></td></tr><tr style=\"height: 50px;\"><td style=\"  max-width: 294px; min-width: 294px; font-size: 12px; font-weight: 400; color: rgb(51, 51, 51); \" colspan=\"3\"    data-type=\"checkbox\" >蔬菜 <input name=\"c1587456716803\" data-i=\"i003\" data-name=\"蔬菜\" type=\"checkbox\" class=\"aya-checkbox\" style=\"margin-right:24px\"> 水果 <input name=\"c1587456716803\" data-i=\"i004\" data-name=\"水果\" type=\"checkbox\" class=\"aya-checkbox\" style=\"margin-right:24px\"> 肉类 <input name=\"c1587456716803\" data-i=\"i005\" data-name=\"肉类\" type=\"checkbox\" class=\"aya-checkbox\"> </td><td style=\"  max-width: 294px; min-width: 294px; font-size: 12px; font-weight: 400; color: rgb(51, 51, 51); background: rgb(255, 255, 255);\" colspan=\"3\"    data-type=\"radio\" ><p style=\"display:inline-block\">足球 <input data-i=\"i009\" name=\"r1587948720399\" data-name=\"足球\" type=\"radio\" class=\"aya-radio\" style=\"margin-right:24px\"></p> <p style=\"display:inline-block\">篮球 <input data-i=\"i010\" name=\"r1587948720399\" data-name=\"篮球\" type=\"radio\" class=\"aya-radio\" style=\"margin-right:24px\"></p> <p style=\"display:inline-block\">排球 <input data-i=\"i011\" name=\"r1587948720399\" data-name=\"排球\" type=\"radio\" class=\"aya-radio\" style=\"margin-right:24px\"></p> </td></tr><tr style=\"height: 50px;\"><td style=\"max-width:98px;min-width:98px\"     data-type=\"text\" ></td><td style=\"max-width:98px;min-width:98px\"     data-type=\"text\" ></td><td style=\"max-width:98px;min-width:98px\"     data-type=\"text\" ></td><td style=\"max-width:98px;min-width:98px\"     data-type=\"text\" ></td><td style=\"  max-width: 98px; min-width: 98px; font-size: 12px; font-weight: 400; color: rgb(51, 51, 51); background: rgb(255, 255, 255);\"     data-type=\"text\" >付款方式</td><td style=\"  max-width: 98px; min-width: 98px; font-size: 12px; font-weight: 400; color: rgb(51, 51, 51); background: rgb(255, 255, 255);\"     data-type=\"select\"  data-select=\"3\" data-name=\"付款类型\" data-i=\"i012\"><select class=\"browser-default\"><option>付款类型</option></select></td></tr><tr style=\"height: 50px;\"><td style=\"max-width:98px;min-width:98px\"     data-type=\"text\" ></td><td style=\"  max-width: 98px; min-width: 98px; font-size: 12px; font-weight: 400; color: rgb(51, 51, 51); \"     data-type=\"text\" >阿发</td><td style=\"  max-width: 98px; min-width: 98px; font-size: 12px; font-weight: 400; color: rgb(51, 51, 51); \"     data-type=\"input\"  data-attr=\"阿发\" data-i=\"i006\"><input readonly=\"\" noselect=\"\" type=\"text\" class=\"aya-input form-input\"></td><td style=\"max-width:98px;min-width:98px\"     data-type=\"text\"></td><td style=\"max-width:98px;min-width:98px\"     data-type=\"text\" ></td><td style=\"max-width:98px;min-width:98px\"     data-type=\"text\" ></td></tr><tr style=\"height: 50px;\"><td style=\"max-width:98px;min-width:98px\"     data-type=\"text\" ></td><td style=\"  max-width: 98px; min-width: 98px; font-size: 12px; font-weight: 400; color: rgb(51, 51, 51); \"     data-type=\"text\" >飒然</td><td style=\"  max-width: 98px; min-width: 98px; font-size: 12px; font-weight: 400; color: rgb(51, 51, 51); \"     data-type=\"input\"  data-attr=\"飒然\" data-i=\"i007\"><input readonly=\"\" noselect=\"\" type=\"text\" class=\"aya-input form-input\"></td><td style=\"  max-width: 98px; min-width: 98px; font-size: 12px; font-weight: 400; color: rgb(51, 51, 51); \"     data-type=\"text\" >天天</td><td style=\"  max-width: 98px; min-width: 98px; font-size: 12px; font-weight: 400; color: rgb(51, 51, 51); \"     data-type=\"input\"  data-attr=\"天天\" data-i=\"i008\"><input readonly=\"\" noselect=\"\" type=\"text\" class=\"aya-input form-input\"></td><td style=\"max-width:98px;min-width:98px\"     data-type=\"text\" ></td></tr><tr><td data-type=\"text\"   colspan=\"6\" 1\'=\"\" style=\"  max-width: 588px; min-width: 588px;\"  ><table class=\"table-mul\" data-table=\"subform-0124\"><thead><tr><th>序号</th><th>姓名</th><th>交通</th></tr></thead><tbody><tr><td data-type=\"index-mul\" data-i=\"i013\">序号</td><td data-type=\"text-mul\" data-i=\"i014\"><input type=\"text\" class=\"aya-input\"></td><td data-type=\"select-mul\" data-select=\"32\" data-i=\"i015\"><select class=\"browser-default\"><option value=\"32\">交通工具</option></select></td></tr></tbody></table></td></tr></tbody></table>',0,NULL),(32,NULL,NULL,NULL,NULL,NULL,'{\"creator\":{\"S\":\"n\",\"X\":{},\"D\":0},\"end\":{\"S\":\"n\",\"X\":{},\"D\":0},\"f\":{\"S\":\"p\",\"D\":0},\"id17\":{\"S\":\"p\",\"D\":0},\"id18\":{\"T\":\"P\",\"K\":\"010100\",\"V\":\"王泉\",\"S\":\"n\",\"Z\":1,\"C\":1,\"D\":0},\"id19\":{\"T\":\"R\",\"K\":5,\"V\":\"B\",\"B\":\"信息科\",\"S\":\"n\",\"Z\":1,\"C\":1,\"D\":0},\"id20\":{\"S\":\"p\",\"D\":0},\"id21\":{\"T\":\"P\",\"K\":\"010100\",\"V\":\"王泉\",\"S\":\"n\",\"Z\":1,\"C\":1,\"D\":0},\"id22\":{\"S\":\"p\",\"D\":0},\"id23\":{\"T\":\"R\",\"K\":5,\"V\":\"F\",\"B\":\"信息科\",\"S\":\"n\",\"Z\":1,\"C\":1,\"D\":0}}','{\"creator\":[\"id17\"],\"f\":[\"end\"],\"id17\":[\"id18\",\"id19\"],\"id18\":[\"f\"],\"id19\":[\"id20\"],\"id20\":[\"id21\"],\"id21\":[\"id22\"],\"id22\":[\"id23\"],\"id23\":[\"f\"]}',24,NULL,NULL,NULL,0,NULL,0,NULL,1,'vendor_price_just_flow');

#
# Structure for table "s_flow_auth"
#

CREATE TABLE `s_flow_auth` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `flow_id` int(11) DEFAULT NULL,
  `node_id` varchar(255) DEFAULT NULL,
  `auth` text,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

#
# Data for table "s_flow_auth"
#

INSERT INTO `s_flow_auth` VALUES (10,28,'creator','{\"i001\":{\"b\":\"person\",\"a\":1,\"m\":1,\"d\":\"\",\"n\":0,\"t\":\"1\"},\"i002\":{\"b\":\"relation\",\"m\":0,\"d\":\"\",\"n\":1,\"t\":\"\",\"a\":null},\"i003\":{\"b\":\"checkbox\",\"a\":0,\"m\":0,\"d\":0,\"n\":1,\"t\":\"\"},\"i004\":{\"b\":\"checkbox\",\"a\":0,\"m\":0,\"d\":0,\"n\":1,\"t\":\"\"},\"i005\":{\"b\":\"checkbox\",\"a\":0,\"m\":0,\"d\":0,\"n\":1,\"t\":\"\"},\"i006\":{\"b\":\"relation\",\"m\":0,\"d\":\"\",\"n\":1,\"t\":\"\",\"a\":null},\"i007\":{\"b\":\"varchar\",\"a\":1,\"m\":1,\"d\":\"目标ffff\",\"n\":1,\"t\":\"\"},\"i008\":{\"b\":\"varchar\",\"a\":0,\"m\":0,\"d\":\"\",\"n\":1,\"t\":\"\"},\"i009\":{\"b\":\"radio\",\"a\":0,\"m\":0,\"d\":0,\"n\":1,\"t\":\"\"},\"i010\":{\"b\":\"radio\",\"a\":0,\"m\":0,\"d\":0,\"n\":1,\"t\":\"\"},\"i011\":{\"b\":\"radio\",\"a\":0,\"m\":0,\"d\":0,\"n\":1,\"t\":\"\"},\"i012\":{\"b\":\"enum\",\"a\":1,\"m\":1,\"d\":\"\",\"n\":1,\"t\":\"\"},\"i013\":{\"b\":\"index\",\"a\":1,\"m\":0,\"d\":\"\",\"n\":1,\"t\":\"\"},\"i014\":{\"b\":\"varchar\",\"a\":1,\"m\":0,\"d\":\"\",\"n\":1,\"t\":\"\"},\"i015\":{\"b\":\"enum\",\"a\":1,\"m\":0,\"d\":\"\",\"n\":1,\"t\":\"\"}}'),(11,28,'id2','{\"i001\":{\"b\":\"person\",\"a\":\"0\",\"m\":0,\"d\":0,\"n\":1,\"t\":\"\"},\"i002\":{\"b\":\"relation\",\"a\":0,\"m\":0,\"d\":\"\",\"n\":1,\"t\":\"\"},\"i003\":{\"b\":\"checkbox\",\"a\":0,\"m\":0,\"d\":\"\",\"n\":1,\"t\":\"\"},\"i004\":{\"b\":\"checkbox\",\"a\":0,\"m\":0,\"d\":\"\",\"n\":1,\"t\":\"\"},\"i005\":{\"b\":\"checkbox\",\"a\":0,\"m\":0,\"d\":\"\",\"n\":1,\"t\":\"\"},\"i006\":{\"b\":\"relation\",\"a\":0,\"m\":0,\"d\":\"\",\"n\":1,\"t\":\"\"},\"i007\":{\"b\":\"varchar\",\"a\":\"0\",\"m\":0,\"d\":0,\"n\":1,\"t\":\"\"},\"i008\":{\"b\":\"varchar\",\"a\":\"0\",\"m\":0,\"d\":0,\"n\":1,\"t\":\"\"}}'),(12,28,'id1','{\"i001\":{\"b\":\"person\",\"a\":\"0\",\"m\":0,\"d\":0,\"n\":1,\"t\":\"\"},\"i002\":{\"b\":\"relation\",\"a\":0,\"m\":0,\"d\":\"\",\"n\":1,\"t\":\"\"},\"i003\":{\"b\":\"checkbox\",\"a\":0,\"m\":0,\"d\":\"\",\"n\":1,\"t\":\"\"},\"i004\":{\"b\":\"checkbox\",\"a\":0,\"m\":0,\"d\":\"\",\"n\":1,\"t\":\"\"},\"i005\":{\"b\":\"checkbox\",\"a\":0,\"m\":0,\"d\":\"\",\"n\":1,\"t\":\"\"},\"i006\":{\"b\":\"relation\",\"a\":0,\"m\":0,\"d\":\"\",\"n\":1,\"t\":\"\"},\"i007\":{\"b\":\"varchar\",\"a\":\"0\",\"m\":0,\"d\":0,\"n\":1,\"t\":\"\"},\"i008\":{\"b\":\"varchar\",\"a\":\"0\",\"m\":0,\"d\":0,\"n\":1,\"t\":\"\"}}'),(13,28,'id7','{\"i001\":{\"b\":\"person\",\"a\":0,\"m\":0,\"d\":\"\",\"n\":1,\"t\":\"\"},\"i002\":{\"b\":\"relation\",\"a\":null,\"m\":0,\"d\":\"\",\"n\":1,\"t\":\"\"},\"i003\":{\"b\":\"checkbox\",\"a\":1,\"m\":0,\"d\":1,\"n\":1,\"t\":\"\"},\"i004\":{\"b\":\"checkbox\",\"a\":1,\"m\":0,\"d\":0,\"n\":1,\"t\":\"\"},\"i005\":{\"b\":\"checkbox\",\"a\":1,\"m\":0,\"d\":1,\"n\":1,\"t\":\"\"},\"i006\":{\"b\":\"relation\",\"a\":null,\"m\":0,\"d\":\"\",\"n\":1,\"t\":\"\"},\"i007\":{\"b\":\"varchar\",\"a\":0,\"m\":0,\"d\":\"\",\"n\":1,\"t\":\"\"},\"i008\":{\"b\":\"varchar\",\"a\":1,\"m\":1,\"d\":\"天天的天气\",\"n\":1,\"t\":\"\"},\"i009\":{\"b\":\"radio\",\"a\":1,\"m\":0,\"d\":0,\"n\":1,\"t\":\"\"},\"i010\":{\"b\":\"radio\",\"a\":1,\"m\":0,\"d\":0,\"n\":1,\"t\":\"\"},\"i011\":{\"b\":\"radio\",\"a\":1,\"m\":0,\"d\":1,\"n\":1,\"t\":\"\"},\"i012\":{\"b\":\"enum\",\"a\":0,\"m\":0,\"d\":\"\",\"n\":1,\"t\":\"\"},\"i013\":{\"b\":\"index\",\"a\":0,\"m\":0,\"d\":\"\",\"n\":1,\"t\":\"\"},\"i014\":{\"b\":\"varchar\",\"a\":0,\"m\":0,\"d\":\"\",\"n\":1,\"t\":\"\"},\"i015\":{\"b\":\"enum\",\"a\":0,\"m\":0,\"d\":\"\",\"n\":1,\"t\":\"\"}}');

#
# Structure for table "s_flow_group"
#

CREATE TABLE `s_flow_group` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

#
# Data for table "s_flow_group"
#


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
# Data for table "s_flow_group_list"
#


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
# Data for table "s_flow_node"
#

INSERT INTO `s_flow_node` VALUES (3,'审核',1,'2,3,4,',0,0),(4,'知会',2,NULL,0,1),(5,'通知',31,'3,',0,1),(6,'113535',10,NULL,0,1);

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
  `group` varchar(255) DEFAULT NULL,
  `relation_i` varchar(10) DEFAULT NULL COMMENT '关联字段',
  `relation_a` varchar(255) DEFAULT NULL COMMENT '关联类型',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=149 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

#
# Data for table "s_flow_table"
#

INSERT INTO `s_flow_table` VALUES (1,'form-0094',1,'i001','姓名','varchar',255,0,'',0,1,NULL,NULL,NULL),(2,'form-0094',1,'i002','岗位','varchar',255,0,'',0,1,NULL,NULL,NULL),(3,'subform-0101',1,'i003','序号','varchar',255,0,'',0,0,NULL,NULL,NULL),(4,'subform-0101',1,'i004','第一列','enum',0,0,'请假期限',34,0,NULL,NULL,NULL),(5,'subform-0101',1,'i005','第二列','varchar',255,0,'',0,0,NULL,NULL,NULL),(6,'subform-0101',1,'i006','第三列','enum',0,0,'交通工具',32,0,NULL,NULL,NULL),(7,'subform-0101',1,'i007','第四列','varchar',255,0,'',0,0,NULL,NULL,NULL),(8,'form-0094',1,'i008','aa','varchar',255,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(9,'form-0094',1,'i009','bb','varchar',255,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(10,'form-0094',1,'i010','请假期限','enum',NULL,NULL,'请假期限',34,NULL,NULL,NULL,NULL),(11,'form-0094',1,'i011','11','checkbox',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(12,'form-0094',1,'i012','22','checkbox',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(13,'form-0094',1,'i013','33','radio',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(14,'form-0094',1,'i014','44','radio',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(15,'form-0096',2,'i001','aa','varchar',255,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(16,'form-0097',2,'i002','11','varchar',255,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(17,'form-0105',3,'i001','aaa','varchar',22,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(18,'form-0105',3,'i002','aaaa','varchar',255,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(19,'form-0105',3,'i003','aaa','varchar',100,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(20,'subform-0102',3,'i004','序号','index',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(21,'subform-0102',3,'i005','姓名','varchar',255,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(22,'subform-0102',3,'i006','枚举','enum',NULL,NULL,'交通工具',32,NULL,NULL,NULL,NULL),(23,'subform-0103',3,'i007','序号','varchar',279,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(24,'subform-0103',3,'i008','第一列','varchar',33,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(25,'subform-0103',3,'i009','第二列','enum',NULL,NULL,'付款类型',3,NULL,NULL,NULL,NULL),(26,'subform-0103',3,'i010','第三列','varchar',22,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(27,'form-0105',3,'i011','支付宝3','checkbox',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(28,'form-0105',3,'i012','微信','checkbox',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(29,'form-0105',3,'i013','银联卡','checkbox',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(30,'form-0105',3,'i014','微信2','radio',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(31,'form-0105',3,'i015','支付宝','radio',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(32,'form-0105',3,'i016','其他方式','radio',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(33,'form-0107',4,'i001','姓名','varchar',255,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(34,'form-0107',4,'i002','部门','varchar',255,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(35,'form-0107',4,'i003','岗位','varchar',255,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(36,'form-0107',4,'i004','付款类型','enum',NULL,NULL,'付款类型',3,NULL,NULL,NULL,NULL),(37,'form-0107',4,'i005','红色','checkbox',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(38,'form-0107',4,'i006','绿色','checkbox',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(39,'form-0107',4,'i007','紫色','checkbox',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(40,'form-0107',4,'i008','蔬菜','radio',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(41,'form-0107',4,'i009','水果','radio',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(42,'form-0107',4,'i010','海鲜','radio',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(43,'form-0107',4,'i011','部门主管','varchar',255,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(44,'form-0107',4,'i012','分管领导','varchar',255,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(45,'subform-0104',4,'i013','序号','index',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(46,'subform-0104',4,'i014','第一列','varchar',255,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(47,'subform-0104',4,'i015','第二列','enum',NULL,NULL,'请假期限',34,NULL,NULL,NULL,NULL),(48,'subform-0104',4,'i016','第三列','varchar',255,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(49,'subform-0104',4,'i017','第四列','enum',NULL,NULL,'交通工具',32,NULL,NULL,NULL,NULL),(50,'form-0116',5,'i001','姓名','varchar',255,0,'',0,1,NULL,NULL,NULL),(51,'form-0116',5,'i002','部门','varchar',255,0,'',0,1,NULL,NULL,NULL),(52,'form-0116',5,'i003','岗位','varchar',255,0,'',0,1,NULL,NULL,NULL),(53,'form-0116',5,'i004','蔬菜','checkbox',0,0,'',0,1,NULL,NULL,NULL),(54,'form-0116',5,'i005','水果','checkbox',0,0,'',0,1,NULL,NULL,NULL),(55,'form-0116',5,'i006','交通工具','enum',0,0,'交通工具',32,1,NULL,NULL,NULL),(56,'subform-0113',5,'i007','序号','index',0,0,'',0,0,NULL,NULL,NULL),(57,'subform-0113',5,'i008','第一列','enum',0,0,'付款类型',3,0,NULL,NULL,NULL),(58,'subform-0113',5,'i009','第二列','varchar',255,0,'',0,0,NULL,NULL,NULL),(59,'form-0117',6,'i001','姓名','varchar',255,0,'',0,1,NULL,NULL,NULL),(60,'form-0117',6,'i002','部门','varchar',255,0,'',0,1,NULL,NULL,NULL),(61,'form-0117',6,'i003','岗位','varchar',255,0,'',0,1,NULL,NULL,NULL),(62,'form-0117',6,'i004','蔬菜','checkbox',0,0,'',0,1,NULL,NULL,NULL),(63,'form-0117',6,'i005','水果','checkbox',0,0,'',0,1,NULL,NULL,NULL),(64,'form-0117',6,'i006','交通工具','enum',0,0,'交通工具',32,1,NULL,NULL,NULL),(65,'subform-0114',6,'i007','序号','index',0,0,'',0,0,NULL,NULL,NULL),(66,'subform-0114',6,'i008','第一列','enum',0,0,'付款类型',3,0,NULL,NULL,NULL),(67,'subform-0114',6,'i009','第二列','varchar',255,0,'',0,0,NULL,NULL,NULL),(68,'form-0119',7,'i001','姓名','varchar',255,0,'',0,1,NULL,NULL,NULL),(69,'form-0119',7,'i002','部门','varchar',255,0,'',0,1,NULL,NULL,NULL),(70,'form-0119',7,'i003','岗位','varchar',255,0,'',0,1,NULL,NULL,NULL),(71,'form-0119',7,'i004','蔬菜','checkbox',0,0,'',0,1,NULL,NULL,NULL),(72,'form-0119',7,'i005','水果','checkbox',0,0,'',0,1,NULL,NULL,NULL),(73,'form-0119',7,'i006','交通工具','enum',0,0,'交通工具',32,1,NULL,NULL,NULL),(74,'subform-0116',7,'i007','序号','index',0,0,'',0,0,NULL,NULL,NULL),(75,'subform-0116',7,'i008','第一列','enum',0,0,'付款类型',3,0,NULL,NULL,NULL),(76,'subform-0116',7,'i009','第二列','varchar',255,0,'',0,0,NULL,NULL,NULL),(77,'form-0120',8,'i001','水果','checkbox',0,0,'',0,1,NULL,NULL,NULL),(78,'form-0120',8,'i002','海鲜','checkbox',0,0,'',0,1,NULL,NULL,NULL),(79,'form-0120',8,'i003','足球','radio',0,0,'',0,1,NULL,NULL,NULL),(80,'form-0120',8,'i004','乒乓球','radio',0,0,'',0,1,NULL,NULL,NULL),(81,'form-0120',8,'i005','交通工具','enum',0,0,'交通工具',32,1,NULL,NULL,NULL),(82,'subform-0117',8,'i006','序号','index',0,0,'',0,0,NULL,NULL,NULL),(83,'subform-0117',8,'i007','项目名称','varchar',100,0,'',0,0,NULL,NULL,NULL),(84,'subform-0117',8,'i008','付款类型','enum',0,0,'付款类型',3,0,NULL,NULL,NULL),(85,'form-0120',8,'i009','姓名','varchar',100,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(86,'form-0120',8,'i010','部门','varchar',110,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(87,'form-0120',8,'i011','岗位','varchar',120,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(134,'form-0153',28,'i001','姓名','person',NULL,NULL,'',0,1,'',NULL,NULL),(135,'form-0153',28,'i002','岗位','relation',NULL,NULL,'',0,1,'','i001','post_name'),(136,'form-0153',28,'i003','蔬菜','checkbox',0,0,'',0,1,'c1587456716803',NULL,NULL),(137,'form-0153',28,'i004','水果','checkbox',0,0,'',0,1,'c1587456716803',NULL,NULL),(138,'form-0153',28,'i005','肉类','checkbox',0,0,'',0,1,'c1587456716803',NULL,NULL),(139,'form-0153',28,'i006','阿发','relation',NULL,NULL,'',0,1,'','i001','department_name'),(140,'form-0153',28,'i007','飒然','varchar',255,0,'',0,1,'','',''),(141,'form-0153',28,'i008','天天','varchar',255,0,'',0,1,'','',''),(142,'form-0153',28,'i009','足球','radio',0,0,'',0,1,'r1587948720399','',''),(143,'form-0153',28,'i010','篮球','radio',0,0,'',0,1,'r1587948720399','',''),(144,'form-0153',28,'i011','排球','radio',0,0,'',0,1,'r1587948720399','',''),(145,'form-0153',28,'i012','付款类型','enum',0,0,'付款类型',3,1,'','',''),(146,'subform-0124',28,'i013','序号','index',0,0,'',0,0,'',NULL,NULL),(147,'subform-0124',28,'i014','姓名','varchar',255,0,'',0,0,'',NULL,NULL),(148,'subform-0124',28,'i015','交通','enum',0,0,'交通工具',32,0,'',NULL,NULL);

#
# Structure for table "s_flow_type"
#

CREATE TABLE `s_flow_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(20) DEFAULT NULL,
  `status` int(1) DEFAULT NULL,
  `sort` int(11) DEFAULT NULL,
  KEY `id` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

#
# Data for table "s_flow_type"
#

INSERT INTO `s_flow_type` VALUES (3,'技术支持',1,3),(5,'财务流程',1,2);

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
  `flow_id` int(11) DEFAULT NULL,
  `system_flow` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=115 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

#
# Data for table "s_flows"
#

INSERT INTO `s_flows` VALUES (3,'010099','2020-05-03 10:06:42',NULL,NULL,'form-0153,subform-0124',NULL,NULL,'刘德华','111',5,'{\"creator\":[\"id6\"],\"f\":[\"id5\"],\"id0\":[\"id1\",\"id2\"],\"id1\":[\"f\"],\"id2\":[\"f\"],\"id4\":[\"end\"],\"id5\":[\"id4\"],\"id6\":[\"id7\"],\"id7\":[\"id10\"],\"id10\":[\"id11\"],\"id11\":[\"id0\"]}','{\"creator\":{\"S\":\"n\",\"X\":[],\"D\":2},\"end\":{\"S\":\"n\",\"X\":[],\"D\":0},\"f\":{\"S\":\"p\",\"D\":0},\"id0\":{\"S\":\"p\",\"D\":0},\"id1\":{\"T\":\"P\",\"K\":\"010099\",\"V\":\"\\u5218\\u5fb7\\u534e\",\"S\":\"n\",\"Z\":1,\"C\":\"3\",\"D\":0,\"X\":[[\"\",\"i004\",\"1\",\"\",\"\"]]},\"id2\":{\"T\":\"P\",\"K\":\"010097\",\"V\":\"\\u90ed\\u5bcc\\u57ce\",\"S\":\"n\",\"Z\":1,\"C\":\"3\",\"D\":0,\"X\":[[\"\",\"i005\",\"1\",\"\",\"\"]]},\"id4\":{\"S\":\"p\",\"D\":0},\"id5\":{\"T\":\"P\",\"K\":\"010155\",\"V\":\"\\u738b\\u6cc9\",\"S\":\"n\",\"Z\":1,\"C\":\"3\",\"D\":0,\"X\":[[\"\",\"aya1\",\"==\",\"3|1\",\"\",\"&&\"],[\"\",\"aya2\",\"==\",\"3\",\"\",\"\"]]},\"id6\":{\"S\":\"p\",\"D\":2},\"id7\":{\"T\":\"P\",\"K\":\"010099\",\"V\":\"\\u5218\\u5fb7\\u534e\",\"S\":\"n\",\"Z\":1,\"C\":1,\"D\":2},\"id10\":{\"S\":\"p\",\"D\":2},\"id11\":{\"T\":\"D\",\"K\":\"2|1\",\"V\":\"\\u7efc\\u5408\\u7ba1\\u7406\\u90e8\",\"S\":\"n\",\"Z\":1,\"C\":1,\"D\":1}}',NULL,NULL,'郭富城',NULL,'<table class=\"table-form2 table noselect\" style=\"margin:auto;width:601px\" \'\'=\"\" data-index=\"0\" data-table=\"form-0153\"><tbody><tr><td data-type=\"text\"   colspan=\"1 rowspan = \" 1\'=\"\" style=\"  max-width: 98px; min-width: 98px; font-size: 12px; font-weight: 400; color: rgb(51, 51, 51); \" class=\"border-top-none border-left-none border-right-none border-bottom-none\"></td><td data-type=\"text\"   colspan=\"1 rowspan = \" 1\'=\"\" style=\"  max-width: 98px; min-width: 98px; font-size: 12px; font-weight: 400; color: rgb(51, 51, 51); \" class=\"border-top-none border-left-none border-right-none border-bottom-none\"></td><td data-type=\"text\"   colspan=\"2\" 1\'=\"\" style=\"  max-width: 196px; min-width: 196px; font-size: 12px; font-weight: 400; color: rgb(51, 51, 51); \" class=\"border-top-none border-left-none border-right-none border-bottom-none\" >财务借款流程</td><td data-type=\"text\"   colspan=\"1 rowspan = \" 1\'=\"\" style=\"  max-width: 98px; min-width: 98px; font-size: 12px; font-weight: 400; color: rgb(51, 51, 51); \" class=\"border-top-none border-left-none border-right-none border-bottom-none\"></td><td data-type=\"text\"   colspan=\"1 rowspan = \" 1\'=\"\" style=\"  max-width: 98px; min-width: 98px; font-size: 12px; font-weight: 400; color: rgb(51, 51, 51); \" class=\"border-top-none border-left-none border-right-none border-bottom-none\"></td></tr><tr style=\"height: 50px;\"><td style=\"  max-width: 98px; min-width: 98px; font-size: 12px; font-weight: 400; color: rgb(51, 51, 51); \"     data-type=\"text\" >姓名</td><td style=\"  max-width: 98px; min-width: 98px; font-size: 12px; font-weight: 400; color: rgb(51, 51, 51); \"     data-type=\"input\"  data-attr=\"姓名\" data-i=\"i001\"><input readonly=\"\" noselect=\"\" type=\"text\" class=\"aya-input form-input\"></td><td style=\"  max-width: 98px; min-width: 98px; font-size: 12px; font-weight: 400; color: rgb(51, 51, 51); \"     data-type=\"text\" >岗位</td><td style=\"  max-width: 98px; min-width: 98px; font-size: 12px; font-weight: 400; color: rgb(51, 51, 51); \"     data-type=\"input\"  data-attr=\"岗位\" data-i=\"i002\"><input readonly=\"\" noselect=\"\" type=\"text\" class=\"aya-input form-input\"></td><td style=\"max-width:98px;min-width:98px\"     data-type=\"text\" ></td><td style=\"max-width:98px;min-width:98px\"     data-type=\"text\" ></td></tr><tr style=\"height: 50px;\"><td style=\"max-width:98px;min-width:98px\"     data-type=\"text\" ></td><td style=\"max-width:98px;min-width:98px\"     data-type=\"text\" ></td><td style=\"max-width:98px;min-width:98px\"     data-type=\"text\" ></td><td style=\"max-width:98px;min-width:98px\"     data-type=\"text\" ></td><td style=\"max-width:98px;min-width:98px\"     data-type=\"text\" ></td><td style=\"max-width:98px;min-width:98px\"     data-type=\"text\" ></td></tr><tr style=\"height: 50px;\"><td style=\"  max-width: 294px; min-width: 294px; font-size: 12px; font-weight: 400; color: rgb(51, 51, 51); \" colspan=\"3\"    data-type=\"checkbox\" >蔬菜 <input name=\"c1587456716803\" data-i=\"i003\" data-name=\"蔬菜\" type=\"checkbox\" class=\"aya-checkbox\" style=\"margin-right:24px\"> 水果 <input name=\"c1587456716803\" data-i=\"i004\" data-name=\"水果\" type=\"checkbox\" class=\"aya-checkbox\" style=\"margin-right:24px\"> 肉类 <input name=\"c1587456716803\" data-i=\"i005\" data-name=\"肉类\" type=\"checkbox\" class=\"aya-checkbox\"> </td><td style=\"  max-width: 294px; min-width: 294px; font-size: 12px; font-weight: 400; color: rgb(51, 51, 51); background: rgb(255, 255, 255);\" colspan=\"3\"    data-type=\"radio\" ><p style=\"display:inline-block\">足球 <input data-i=\"i009\" name=\"r1587948720399\" data-name=\"足球\" type=\"radio\" class=\"aya-radio\" style=\"margin-right:24px\"></p> <p style=\"display:inline-block\">篮球 <input data-i=\"i010\" name=\"r1587948720399\" data-name=\"篮球\" type=\"radio\" class=\"aya-radio\" style=\"margin-right:24px\"></p> <p style=\"display:inline-block\">排球 <input data-i=\"i011\" name=\"r1587948720399\" data-name=\"排球\" type=\"radio\" class=\"aya-radio\" style=\"margin-right:24px\"></p> </td></tr><tr style=\"height: 50px;\"><td style=\"max-width:98px;min-width:98px\"     data-type=\"text\" ></td><td style=\"max-width:98px;min-width:98px\"     data-type=\"text\" ></td><td style=\"max-width:98px;min-width:98px\"     data-type=\"text\" ></td><td style=\"max-width:98px;min-width:98px\"     data-type=\"text\" ></td><td style=\"  max-width: 98px; min-width: 98px; font-size: 12px; font-weight: 400; color: rgb(51, 51, 51); background: rgb(255, 255, 255);\"     data-type=\"text\" >付款方式</td><td style=\"  max-width: 98px; min-width: 98px; font-size: 12px; font-weight: 400; color: rgb(51, 51, 51); background: rgb(255, 255, 255);\"     data-type=\"select\"  data-select=\"3\" data-name=\"付款类型\" data-i=\"i012\"><select class=\"browser-default\"><option>付款类型</option></select></td></tr><tr style=\"height: 50px;\"><td style=\"max-width:98px;min-width:98px\"     data-type=\"text\" ></td><td style=\"  max-width: 98px; min-width: 98px; font-size: 12px; font-weight: 400; color: rgb(51, 51, 51); \"     data-type=\"text\" >阿发</td><td style=\"  max-width: 98px; min-width: 98px; font-size: 12px; font-weight: 400; color: rgb(51, 51, 51); \"     data-type=\"input\"  data-attr=\"阿发\" data-i=\"i006\"><input readonly=\"\" noselect=\"\" type=\"text\" class=\"aya-input form-input\"></td><td style=\"max-width:98px;min-width:98px\"     data-type=\"text\"></td><td style=\"max-width:98px;min-width:98px\"     data-type=\"text\" ></td><td style=\"max-width:98px;min-width:98px\"     data-type=\"text\" ></td></tr><tr style=\"height: 50px;\"><td style=\"max-width:98px;min-width:98px\"     data-type=\"text\" ></td><td style=\"  max-width: 98px; min-width: 98px; font-size: 12px; font-weight: 400; color: rgb(51, 51, 51); \"     data-type=\"text\" >飒然</td><td style=\"  max-width: 98px; min-width: 98px; font-size: 12px; font-weight: 400; color: rgb(51, 51, 51); \"     data-type=\"input\"  data-attr=\"飒然\" data-i=\"i007\"><input readonly=\"\" noselect=\"\" type=\"text\" class=\"aya-input form-input\"></td><td style=\"  max-width: 98px; min-width: 98px; font-size: 12px; font-weight: 400; color: rgb(51, 51, 51); \"     data-type=\"text\" >天天</td><td style=\"  max-width: 98px; min-width: 98px; font-size: 12px; font-weight: 400; color: rgb(51, 51, 51); \"     data-type=\"input\"  data-attr=\"天天\" data-i=\"i008\"><input readonly=\"\" noselect=\"\" type=\"text\" class=\"aya-input form-input\"></td><td style=\"max-width:98px;min-width:98px\"     data-type=\"text\" ></td></tr><tr><td data-type=\"text\"   colspan=\"6\" 1\'=\"\" style=\"  max-width: 588px; min-width: 588px;\"  ><table class=\"table-mul\" data-table=\"subform-0124\"><thead><tr><th>序号</th><th>姓名</th><th>交通</th></tr></thead><tbody><tr><td data-type=\"index-mul\" data-i=\"i013\">序号</td><td data-type=\"text-mul\" data-i=\"i014\"><input type=\"text\" class=\"aya-input\"></td><td data-type=\"select-mul\" data-select=\"32\" data-i=\"i015\"><select class=\"browser-default\"><option value=\"32\">交通工具</option></select></td></tr></tbody></table></td></tr></tbody></table>',28,0),(98,'admin','2020-05-20 14:32:42',NULL,NULL,NULL,NULL,NULL,'管理员',NULL,9,'{\"creator\":[\"id5\"],\"f\":[\"end\"],\"id5\":[\"id6\"],\"id6\":[\"f\"]}','{\"creator\":{\"S\":\"n\",\"X\":[],\"D\":2},\"end\":{\"S\":\"n\",\"X\":[],\"D\":2},\"f\":{\"S\":\"p\",\"D\":2},\"id5\":{\"S\":\"p\",\"D\":2},\"id6\":{\"T\":\"R\",\"K\":3,\"V\":\"B\",\"B\":\"\\u4eba\\u4e8b\\u79d1\",\"S\":\"n\",\"Z\":1,\"C\":1,\"D\":2}}',NULL,NULL,'-',NULL,'',32,1),(103,'010099','2020-05-21 09:57:17',NULL,NULL,'form-0153,subform-0124',NULL,NULL,'刘德华','111',5,'{\"creator\":[\"id6\"],\"f\":[\"id5\"],\"id0\":[\"id1\",\"id2\"],\"id1\":[\"f\"],\"id2\":[\"f\"],\"id4\":[\"end\"],\"id5\":[\"id4\"],\"id6\":[\"id7\"],\"id7\":[\"id12\"],\"id10\":[\"id11\"],\"id11\":[\"id0\"],\"id12\":[\"id13\"],\"id13\":[\"id10\"]}','{\"creator\":{\"S\":\"n\",\"X\":[],\"D\":2},\"end\":{\"S\":\"n\",\"X\":[],\"D\":0},\"f\":{\"S\":\"p\",\"D\":0},\"id0\":{\"S\":\"p\",\"D\":0},\"id1\":{\"T\":\"P\",\"K\":\"010099\",\"V\":\"\\u5218\\u5fb7\\u534e\",\"S\":\"n\",\"Z\":1,\"C\":\"3\",\"D\":0,\"X\":[[\"\",\"i004\",\"1\",\"\",\"\"]]},\"id2\":{\"T\":\"P\",\"K\":\"010097\",\"V\":\"\\u90ed\\u5bcc\\u57ce\",\"S\":\"n\",\"Z\":1,\"C\":\"3\",\"D\":0,\"X\":[[\"\",\"i005\",\"1\",\"\",\"\"]]},\"id4\":{\"S\":\"p\",\"D\":0},\"id5\":{\"T\":\"P\",\"K\":\"010155\",\"V\":\"\\u738b\\u6cc9\",\"S\":\"n\",\"Z\":1,\"C\":\"3\",\"D\":0,\"X\":[[\"\",\"aya1\",\"==\",\"3|1\",\"\",\"&&\"],[\"\",\"aya2\",\"==\",\"3\",\"\",\"\"]]},\"id6\":{\"S\":\"p\",\"D\":2},\"id7\":{\"T\":\"P\",\"K\":\"010099\",\"V\":\"\\u5218\\u5fb7\\u534e\",\"S\":\"n\",\"Z\":1,\"C\":1,\"D\":1},\"id10\":{\"S\":\"p\",\"D\":0},\"id11\":{\"T\":\"D\",\"K\":\"2|1\",\"V\":\"\\u7efc\\u5408\\u7ba1\\u7406\\u90e8\",\"S\":\"n\",\"Z\":1,\"C\":1,\"D\":0},\"id12\":{\"S\":\"p\",\"D\":0},\"id13\":{\"T\":\"P\",\"K\":\"010004\",\"V\":\"\\u738b\\u6cc9\",\"S\":\"n\",\"Z\":1,\"C\":1,\"D\":0}}',NULL,NULL,'王泉',NULL,'<table class=\"table-form2 table noselect\" style=\"margin:auto;width:601px\" \'\'=\"\" data-index=\"0\" data-table=\"form-0153\"><tbody><tr><td data-type=\"text\"   colspan=\"1 rowspan = \" 1\'=\"\" style=\"  max-width: 98px; min-width: 98px; font-size: 12px; font-weight: 400; color: rgb(51, 51, 51); \" class=\"border-top-none border-left-none border-right-none border-bottom-none\"></td><td data-type=\"text\"   colspan=\"1 rowspan = \" 1\'=\"\" style=\"  max-width: 98px; min-width: 98px; font-size: 12px; font-weight: 400; color: rgb(51, 51, 51); \" class=\"border-top-none border-left-none border-right-none border-bottom-none\"></td><td data-type=\"text\"   colspan=\"2\" 1\'=\"\" style=\"  max-width: 196px; min-width: 196px; font-size: 12px; font-weight: 400; color: rgb(51, 51, 51); \" class=\"border-top-none border-left-none border-right-none border-bottom-none\" >财务借款流程</td><td data-type=\"text\"   colspan=\"1 rowspan = \" 1\'=\"\" style=\"  max-width: 98px; min-width: 98px; font-size: 12px; font-weight: 400; color: rgb(51, 51, 51); \" class=\"border-top-none border-left-none border-right-none border-bottom-none\"></td><td data-type=\"text\"   colspan=\"1 rowspan = \" 1\'=\"\" style=\"  max-width: 98px; min-width: 98px; font-size: 12px; font-weight: 400; color: rgb(51, 51, 51); \" class=\"border-top-none border-left-none border-right-none border-bottom-none\"></td></tr><tr style=\"height: 50px;\"><td style=\"  max-width: 98px; min-width: 98px; font-size: 12px; font-weight: 400; color: rgb(51, 51, 51); \"     data-type=\"text\" >姓名</td><td style=\"  max-width: 98px; min-width: 98px; font-size: 12px; font-weight: 400; color: rgb(51, 51, 51); \"     data-type=\"input\"  data-attr=\"姓名\" data-i=\"i001\"><input readonly=\"\" noselect=\"\" type=\"text\" class=\"aya-input form-input\"></td><td style=\"  max-width: 98px; min-width: 98px; font-size: 12px; font-weight: 400; color: rgb(51, 51, 51); \"     data-type=\"text\" >岗位</td><td style=\"  max-width: 98px; min-width: 98px; font-size: 12px; font-weight: 400; color: rgb(51, 51, 51); \"     data-type=\"input\"  data-attr=\"岗位\" data-i=\"i002\"><input readonly=\"\" noselect=\"\" type=\"text\" class=\"aya-input form-input\"></td><td style=\"max-width:98px;min-width:98px\"     data-type=\"text\" ></td><td style=\"max-width:98px;min-width:98px\"     data-type=\"text\" ></td></tr><tr style=\"height: 50px;\"><td style=\"max-width:98px;min-width:98px\"     data-type=\"text\" ></td><td style=\"max-width:98px;min-width:98px\"     data-type=\"text\" ></td><td style=\"max-width:98px;min-width:98px\"     data-type=\"text\" ></td><td style=\"max-width:98px;min-width:98px\"     data-type=\"text\" ></td><td style=\"max-width:98px;min-width:98px\"     data-type=\"text\" ></td><td style=\"max-width:98px;min-width:98px\"     data-type=\"text\" ></td></tr><tr style=\"height: 50px;\"><td style=\"  max-width: 294px; min-width: 294px; font-size: 12px; font-weight: 400; color: rgb(51, 51, 51); \" colspan=\"3\"    data-type=\"checkbox\" >蔬菜 <input name=\"c1587456716803\" data-i=\"i003\" data-name=\"蔬菜\" type=\"checkbox\" class=\"aya-checkbox\" style=\"margin-right:24px\"> 水果 <input name=\"c1587456716803\" data-i=\"i004\" data-name=\"水果\" type=\"checkbox\" class=\"aya-checkbox\" style=\"margin-right:24px\"> 肉类 <input name=\"c1587456716803\" data-i=\"i005\" data-name=\"肉类\" type=\"checkbox\" class=\"aya-checkbox\"> </td><td style=\"  max-width: 294px; min-width: 294px; font-size: 12px; font-weight: 400; color: rgb(51, 51, 51); background: rgb(255, 255, 255);\" colspan=\"3\"    data-type=\"radio\" ><p style=\"display:inline-block\">足球 <input data-i=\"i009\" name=\"r1587948720399\" data-name=\"足球\" type=\"radio\" class=\"aya-radio\" style=\"margin-right:24px\"></p> <p style=\"display:inline-block\">篮球 <input data-i=\"i010\" name=\"r1587948720399\" data-name=\"篮球\" type=\"radio\" class=\"aya-radio\" style=\"margin-right:24px\"></p> <p style=\"display:inline-block\">排球 <input data-i=\"i011\" name=\"r1587948720399\" data-name=\"排球\" type=\"radio\" class=\"aya-radio\" style=\"margin-right:24px\"></p> </td></tr><tr style=\"height: 50px;\"><td style=\"max-width:98px;min-width:98px\"     data-type=\"text\" ></td><td style=\"max-width:98px;min-width:98px\"     data-type=\"text\" ></td><td style=\"max-width:98px;min-width:98px\"     data-type=\"text\" ></td><td style=\"max-width:98px;min-width:98px\"     data-type=\"text\" ></td><td style=\"  max-width: 98px; min-width: 98px; font-size: 12px; font-weight: 400; color: rgb(51, 51, 51); background: rgb(255, 255, 255);\"     data-type=\"text\" >付款方式</td><td style=\"  max-width: 98px; min-width: 98px; font-size: 12px; font-weight: 400; color: rgb(51, 51, 51); background: rgb(255, 255, 255);\"     data-type=\"select\"  data-select=\"3\" data-name=\"付款类型\" data-i=\"i012\"><select class=\"browser-default\"><option>付款类型</option></select></td></tr><tr style=\"height: 50px;\"><td style=\"max-width:98px;min-width:98px\"     data-type=\"text\" ></td><td style=\"  max-width: 98px; min-width: 98px; font-size: 12px; font-weight: 400; color: rgb(51, 51, 51); \"     data-type=\"text\" >阿发</td><td style=\"  max-width: 98px; min-width: 98px; font-size: 12px; font-weight: 400; color: rgb(51, 51, 51); \"     data-type=\"input\"  data-attr=\"阿发\" data-i=\"i006\"><input readonly=\"\" noselect=\"\" type=\"text\" class=\"aya-input form-input\"></td><td style=\"max-width:98px;min-width:98px\"     data-type=\"text\"></td><td style=\"max-width:98px;min-width:98px\"     data-type=\"text\" ></td><td style=\"max-width:98px;min-width:98px\"     data-type=\"text\" ></td></tr><tr style=\"height: 50px;\"><td style=\"max-width:98px;min-width:98px\"     data-type=\"text\" ></td><td style=\"  max-width: 98px; min-width: 98px; font-size: 12px; font-weight: 400; color: rgb(51, 51, 51); \"     data-type=\"text\" >飒然</td><td style=\"  max-width: 98px; min-width: 98px; font-size: 12px; font-weight: 400; color: rgb(51, 51, 51); \"     data-type=\"input\"  data-attr=\"飒然\" data-i=\"i007\"><input readonly=\"\" noselect=\"\" type=\"text\" class=\"aya-input form-input\"></td><td style=\"  max-width: 98px; min-width: 98px; font-size: 12px; font-weight: 400; color: rgb(51, 51, 51); \"     data-type=\"text\" >天天</td><td style=\"  max-width: 98px; min-width: 98px; font-size: 12px; font-weight: 400; color: rgb(51, 51, 51); \"     data-type=\"input\"  data-attr=\"天天\" data-i=\"i008\"><input readonly=\"\" noselect=\"\" type=\"text\" class=\"aya-input form-input\"></td><td style=\"max-width:98px;min-width:98px\"     data-type=\"text\" ></td></tr><tr><td data-type=\"text\"   colspan=\"6\" 1\'=\"\" style=\"  max-width: 588px; min-width: 588px;\"  ><table class=\"table-mul\" data-table=\"subform-0124\"><thead><tr><th>序号</th><th>姓名</th><th>交通</th></tr></thead><tbody><tr><td data-type=\"index-mul\" data-i=\"i013\">序号</td><td data-type=\"text-mul\" data-i=\"i014\"><input type=\"text\" class=\"aya-input\"></td><td data-type=\"select-mul\" data-select=\"32\" data-i=\"i015\"><select class=\"browser-default\"><option value=\"32\">交通工具</option></select></td></tr></tbody></table></td></tr></tbody></table>',28,0),(106,'010099','2020-05-21 15:12:09',NULL,NULL,NULL,NULL,NULL,'刘德华',NULL,9,'{\"creator\":[\"id8\"],\"f\":[\"end\"],\"id8\":[\"id9\"],\"id9\":[\"id13\"],\"id13\":[\"id14\"],\"id14\":[\"f\"]}','{\"creator\":{\"S\":\"n\",\"X\":[],\"D\":2},\"end\":{\"S\":\"n\",\"X\":[],\"D\":2},\"f\":{\"S\":\"p\",\"D\":2},\"id8\":{\"S\":\"p\",\"D\":2},\"id9\":{\"T\":\"P\",\"K\":\"010099\",\"V\":\"\\u5218\\u5fb7\\u534e\",\"S\":\"n\",\"Z\":1,\"C\":1,\"D\":2},\"id13\":{\"S\":\"p\",\"D\":2},\"id14\":{\"T\":\"R\",\"K\":3,\"V\":\"B\",\"B\":\"\\u4eba\\u4e8b\\u79d1\",\"S\":\"n\",\"Z\":1,\"C\":1,\"D\":2}}',NULL,NULL,'-',NULL,'',32,1),(114,'admin','2020-06-05 20:26:05',NULL,NULL,NULL,NULL,NULL,'管理员',NULL,5,'{\"creator\":[\"id17\"],\"f\":[\"end\"],\"id17\":[\"id18\",\"id19\"],\"id18\":[\"f\"],\"id19\":[\"id20\"],\"id20\":[\"id21\"],\"id21\":[\"id22\"],\"id22\":[\"id23\"],\"id23\":[\"f\"]}','{\"creator\":{\"S\":\"n\",\"X\":[],\"D\":2},\"end\":{\"S\":\"n\",\"X\":[],\"D\":0},\"f\":{\"S\":\"p\",\"D\":0},\"id17\":{\"S\":\"p\",\"D\":2},\"id18\":{\"T\":\"P\",\"K\":\"010100\",\"V\":\"\\u738b\\u6cc9\",\"S\":\"n\",\"Z\":1,\"C\":1,\"D\":2},\"id19\":{\"T\":\"R\",\"K\":5,\"V\":\"B\",\"B\":\"\\u4fe1\\u606f\\u79d1\",\"S\":\"n\",\"Z\":1,\"C\":1,\"D\":2},\"id20\":{\"S\":\"p\",\"D\":2},\"id21\":{\"T\":\"P\",\"K\":\"010100\",\"V\":\"\\u738b\\u6cc9\",\"S\":\"n\",\"Z\":1,\"C\":1,\"D\":1},\"id22\":{\"S\":\"p\",\"D\":0},\"id23\":{\"T\":\"R\",\"K\":5,\"V\":\"F\",\"B\":\"\\u4fe1\\u606f\\u79d1\",\"S\":\"n\",\"Z\":1,\"C\":1,\"D\":0}}',NULL,NULL,'王泉',NULL,'',32,1);

#
# Structure for table "s_flows_auth"
#

CREATE TABLE `s_flows_auth` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `flows_id` int(11) DEFAULT NULL,
  `node_id` varchar(255) DEFAULT NULL,
  `auth` text,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=25 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

#
# Data for table "s_flows_auth"
#

INSERT INTO `s_flows_auth` VALUES (9,3,'id7','{\"i001\":{\"b\":\"person\",\"a\":0,\"m\":0,\"d\":\"\",\"n\":1,\"t\":\"\"},\"i002\":{\"b\":\"relation\",\"a\":null,\"m\":0,\"d\":\"\",\"n\":1,\"t\":\"\"},\"i003\":{\"b\":\"checkbox\",\"a\":1,\"m\":0,\"d\":1,\"n\":1,\"t\":\"\"},\"i004\":{\"b\":\"checkbox\",\"a\":1,\"m\":0,\"d\":0,\"n\":1,\"t\":\"\"},\"i005\":{\"b\":\"checkbox\",\"a\":1,\"m\":0,\"d\":1,\"n\":1,\"t\":\"\"},\"i006\":{\"b\":\"relation\",\"a\":null,\"m\":0,\"d\":\"\",\"n\":1,\"t\":\"\"},\"i007\":{\"b\":\"varchar\",\"a\":0,\"m\":0,\"d\":\"\",\"n\":1,\"t\":\"\"},\"i008\":{\"b\":\"varchar\",\"a\":1,\"m\":1,\"d\":\"天天的天气\",\"n\":1,\"t\":\"\"},\"i009\":{\"b\":\"radio\",\"a\":1,\"m\":0,\"d\":0,\"n\":1,\"t\":\"\"},\"i010\":{\"b\":\"radio\",\"a\":1,\"m\":0,\"d\":0,\"n\":1,\"t\":\"\"},\"i011\":{\"b\":\"radio\",\"a\":1,\"m\":0,\"d\":1,\"n\":1,\"t\":\"\"},\"i012\":{\"b\":\"enum\",\"a\":0,\"m\":0,\"d\":\"\",\"n\":1,\"t\":\"\"},\"i013\":{\"b\":\"index\",\"a\":0,\"m\":0,\"d\":\"\",\"n\":1,\"t\":\"\"},\"i014\":{\"b\":\"varchar\",\"a\":0,\"m\":0,\"d\":\"\",\"n\":1,\"t\":\"\"},\"i015\":{\"b\":\"enum\",\"a\":0,\"m\":0,\"d\":\"\",\"n\":1,\"t\":\"\"}}'),(10,3,'creator','{\"i001\":{\"b\":\"person\",\"a\":1,\"m\":1,\"d\":\"\",\"n\":0,\"t\":\"1\"},\"i002\":{\"b\":\"relation\",\"m\":0,\"d\":\"\",\"n\":1,\"t\":\"\",\"a\":null},\"i003\":{\"b\":\"checkbox\",\"a\":0,\"m\":0,\"d\":0,\"n\":1,\"t\":\"\"},\"i004\":{\"b\":\"checkbox\",\"a\":0,\"m\":0,\"d\":0,\"n\":1,\"t\":\"\"},\"i005\":{\"b\":\"checkbox\",\"a\":0,\"m\":0,\"d\":0,\"n\":1,\"t\":\"\"},\"i006\":{\"b\":\"relation\",\"m\":0,\"d\":\"\",\"n\":1,\"t\":\"\",\"a\":null},\"i007\":{\"b\":\"varchar\",\"a\":1,\"m\":1,\"d\":\"目标ffff\",\"n\":1,\"t\":\"\"},\"i008\":{\"b\":\"varchar\",\"a\":0,\"m\":0,\"d\":\"\",\"n\":1,\"t\":\"\"},\"i009\":{\"b\":\"radio\",\"a\":0,\"m\":0,\"d\":0,\"n\":1,\"t\":\"\"},\"i010\":{\"b\":\"radio\",\"a\":0,\"m\":0,\"d\":0,\"n\":1,\"t\":\"\"},\"i011\":{\"b\":\"radio\",\"a\":0,\"m\":0,\"d\":0,\"n\":1,\"t\":\"\"},\"i012\":{\"b\":\"enum\",\"a\":1,\"m\":1,\"d\":\"\",\"n\":1,\"t\":\"\"},\"i013\":{\"b\":\"index\",\"a\":1,\"m\":0,\"d\":\"\",\"n\":1,\"t\":\"\"},\"i014\":{\"b\":\"varchar\",\"a\":1,\"m\":0,\"d\":\"\",\"n\":1,\"t\":\"\"},\"i015\":{\"b\":\"enum\",\"a\":1,\"m\":0,\"d\":\"\",\"n\":1,\"t\":\"\"}}'),(11,3,'id2','{\"i001\":{\"b\":\"person\",\"a\":\"0\",\"m\":0,\"d\":0,\"n\":1,\"t\":\"\"},\"i002\":{\"b\":\"relation\",\"a\":0,\"m\":0,\"d\":\"\",\"n\":1,\"t\":\"\"},\"i003\":{\"b\":\"checkbox\",\"a\":0,\"m\":0,\"d\":\"\",\"n\":1,\"t\":\"\"},\"i004\":{\"b\":\"checkbox\",\"a\":0,\"m\":0,\"d\":\"\",\"n\":1,\"t\":\"\"},\"i005\":{\"b\":\"checkbox\",\"a\":0,\"m\":0,\"d\":\"\",\"n\":1,\"t\":\"\"},\"i006\":{\"b\":\"relation\",\"a\":0,\"m\":0,\"d\":\"\",\"n\":1,\"t\":\"\"},\"i007\":{\"b\":\"varchar\",\"a\":\"0\",\"m\":0,\"d\":0,\"n\":1,\"t\":\"\"},\"i008\":{\"b\":\"varchar\",\"a\":\"0\",\"m\":0,\"d\":0,\"n\":1,\"t\":\"\"}}'),(12,3,'id1','{\"i001\":{\"b\":\"person\",\"a\":\"0\",\"m\":0,\"d\":0,\"n\":1,\"t\":\"\"},\"i002\":{\"b\":\"relation\",\"a\":0,\"m\":0,\"d\":\"\",\"n\":1,\"t\":\"\"},\"i003\":{\"b\":\"checkbox\",\"a\":0,\"m\":0,\"d\":\"\",\"n\":1,\"t\":\"\"},\"i004\":{\"b\":\"checkbox\",\"a\":0,\"m\":0,\"d\":\"\",\"n\":1,\"t\":\"\"},\"i005\":{\"b\":\"checkbox\",\"a\":0,\"m\":0,\"d\":\"\",\"n\":1,\"t\":\"\"},\"i006\":{\"b\":\"relation\",\"a\":0,\"m\":0,\"d\":\"\",\"n\":1,\"t\":\"\"},\"i007\":{\"b\":\"varchar\",\"a\":\"0\",\"m\":0,\"d\":0,\"n\":1,\"t\":\"\"},\"i008\":{\"b\":\"varchar\",\"a\":\"0\",\"m\":0,\"d\":0,\"n\":1,\"t\":\"\"}}'),(17,5,'id7','{\"i001\":{\"b\":\"person\",\"a\":0,\"m\":0,\"d\":\"\",\"n\":1,\"t\":\"\"},\"i002\":{\"b\":\"relation\",\"a\":null,\"m\":0,\"d\":\"\",\"n\":1,\"t\":\"\"},\"i003\":{\"b\":\"checkbox\",\"a\":1,\"m\":0,\"d\":1,\"n\":1,\"t\":\"\"},\"i004\":{\"b\":\"checkbox\",\"a\":1,\"m\":0,\"d\":0,\"n\":1,\"t\":\"\"},\"i005\":{\"b\":\"checkbox\",\"a\":1,\"m\":0,\"d\":1,\"n\":1,\"t\":\"\"},\"i006\":{\"b\":\"relation\",\"a\":null,\"m\":0,\"d\":\"\",\"n\":1,\"t\":\"\"},\"i007\":{\"b\":\"varchar\",\"a\":0,\"m\":0,\"d\":\"\",\"n\":1,\"t\":\"\"},\"i008\":{\"b\":\"varchar\",\"a\":1,\"m\":1,\"d\":\"天天的天气\",\"n\":1,\"t\":\"\"},\"i009\":{\"b\":\"radio\",\"a\":1,\"m\":0,\"d\":0,\"n\":1,\"t\":\"\"},\"i010\":{\"b\":\"radio\",\"a\":1,\"m\":0,\"d\":0,\"n\":1,\"t\":\"\"},\"i011\":{\"b\":\"radio\",\"a\":1,\"m\":0,\"d\":1,\"n\":1,\"t\":\"\"},\"i012\":{\"b\":\"enum\",\"a\":0,\"m\":0,\"d\":\"\",\"n\":1,\"t\":\"\"},\"i013\":{\"b\":\"index\",\"a\":0,\"m\":0,\"d\":\"\",\"n\":1,\"t\":\"\"},\"i014\":{\"b\":\"varchar\",\"a\":0,\"m\":0,\"d\":\"\",\"n\":1,\"t\":\"\"},\"i015\":{\"b\":\"enum\",\"a\":0,\"m\":0,\"d\":\"\",\"n\":1,\"t\":\"\"}}'),(18,5,'creator','{\"i001\":{\"b\":\"person\",\"a\":1,\"m\":1,\"d\":\"\",\"n\":0,\"t\":\"1\"},\"i002\":{\"b\":\"relation\",\"m\":0,\"d\":\"\",\"n\":1,\"t\":\"\",\"a\":null},\"i003\":{\"b\":\"checkbox\",\"a\":0,\"m\":0,\"d\":0,\"n\":1,\"t\":\"\"},\"i004\":{\"b\":\"checkbox\",\"a\":0,\"m\":0,\"d\":0,\"n\":1,\"t\":\"\"},\"i005\":{\"b\":\"checkbox\",\"a\":0,\"m\":0,\"d\":0,\"n\":1,\"t\":\"\"},\"i006\":{\"b\":\"relation\",\"m\":0,\"d\":\"\",\"n\":1,\"t\":\"\",\"a\":null},\"i007\":{\"b\":\"varchar\",\"a\":1,\"m\":1,\"d\":\"目标ffff\",\"n\":1,\"t\":\"\"},\"i008\":{\"b\":\"varchar\",\"a\":0,\"m\":0,\"d\":\"\",\"n\":1,\"t\":\"\"},\"i009\":{\"b\":\"radio\",\"a\":0,\"m\":0,\"d\":0,\"n\":1,\"t\":\"\"},\"i010\":{\"b\":\"radio\",\"a\":0,\"m\":0,\"d\":0,\"n\":1,\"t\":\"\"},\"i011\":{\"b\":\"radio\",\"a\":0,\"m\":0,\"d\":0,\"n\":1,\"t\":\"\"},\"i012\":{\"b\":\"enum\",\"a\":1,\"m\":1,\"d\":\"\",\"n\":1,\"t\":\"\"},\"i013\":{\"b\":\"index\",\"a\":1,\"m\":0,\"d\":\"\",\"n\":1,\"t\":\"\"},\"i014\":{\"b\":\"varchar\",\"a\":1,\"m\":0,\"d\":\"\",\"n\":1,\"t\":\"\"},\"i015\":{\"b\":\"enum\",\"a\":1,\"m\":0,\"d\":\"\",\"n\":1,\"t\":\"\"}}'),(19,5,'id2','{\"i001\":{\"b\":\"person\",\"a\":\"0\",\"m\":0,\"d\":0,\"n\":1,\"t\":\"\"},\"i002\":{\"b\":\"relation\",\"a\":0,\"m\":0,\"d\":\"\",\"n\":1,\"t\":\"\"},\"i003\":{\"b\":\"checkbox\",\"a\":0,\"m\":0,\"d\":\"\",\"n\":1,\"t\":\"\"},\"i004\":{\"b\":\"checkbox\",\"a\":0,\"m\":0,\"d\":\"\",\"n\":1,\"t\":\"\"},\"i005\":{\"b\":\"checkbox\",\"a\":0,\"m\":0,\"d\":\"\",\"n\":1,\"t\":\"\"},\"i006\":{\"b\":\"relation\",\"a\":0,\"m\":0,\"d\":\"\",\"n\":1,\"t\":\"\"},\"i007\":{\"b\":\"varchar\",\"a\":\"0\",\"m\":0,\"d\":0,\"n\":1,\"t\":\"\"},\"i008\":{\"b\":\"varchar\",\"a\":\"0\",\"m\":0,\"d\":0,\"n\":1,\"t\":\"\"}}'),(20,5,'id1','{\"i001\":{\"b\":\"person\",\"a\":\"0\",\"m\":0,\"d\":0,\"n\":1,\"t\":\"\"},\"i002\":{\"b\":\"relation\",\"a\":0,\"m\":0,\"d\":\"\",\"n\":1,\"t\":\"\"},\"i003\":{\"b\":\"checkbox\",\"a\":0,\"m\":0,\"d\":\"\",\"n\":1,\"t\":\"\"},\"i004\":{\"b\":\"checkbox\",\"a\":0,\"m\":0,\"d\":\"\",\"n\":1,\"t\":\"\"},\"i005\":{\"b\":\"checkbox\",\"a\":0,\"m\":0,\"d\":\"\",\"n\":1,\"t\":\"\"},\"i006\":{\"b\":\"relation\",\"a\":0,\"m\":0,\"d\":\"\",\"n\":1,\"t\":\"\"},\"i007\":{\"b\":\"varchar\",\"a\":\"0\",\"m\":0,\"d\":0,\"n\":1,\"t\":\"\"},\"i008\":{\"b\":\"varchar\",\"a\":\"0\",\"m\":0,\"d\":0,\"n\":1,\"t\":\"\"}}'),(21,103,'id7','{\"i001\":{\"b\":\"person\",\"a\":0,\"m\":0,\"d\":\"\",\"n\":1,\"t\":\"\"},\"i002\":{\"b\":\"relation\",\"a\":null,\"m\":0,\"d\":\"\",\"n\":1,\"t\":\"\"},\"i003\":{\"b\":\"checkbox\",\"a\":1,\"m\":0,\"d\":1,\"n\":1,\"t\":\"\"},\"i004\":{\"b\":\"checkbox\",\"a\":1,\"m\":0,\"d\":0,\"n\":1,\"t\":\"\"},\"i005\":{\"b\":\"checkbox\",\"a\":1,\"m\":0,\"d\":1,\"n\":1,\"t\":\"\"},\"i006\":{\"b\":\"relation\",\"a\":null,\"m\":0,\"d\":\"\",\"n\":1,\"t\":\"\"},\"i007\":{\"b\":\"varchar\",\"a\":0,\"m\":0,\"d\":\"\",\"n\":1,\"t\":\"\"},\"i008\":{\"b\":\"varchar\",\"a\":1,\"m\":1,\"d\":\"天天的天气\",\"n\":1,\"t\":\"\"},\"i009\":{\"b\":\"radio\",\"a\":1,\"m\":0,\"d\":0,\"n\":1,\"t\":\"\"},\"i010\":{\"b\":\"radio\",\"a\":1,\"m\":0,\"d\":0,\"n\":1,\"t\":\"\"},\"i011\":{\"b\":\"radio\",\"a\":1,\"m\":0,\"d\":1,\"n\":1,\"t\":\"\"},\"i012\":{\"b\":\"enum\",\"a\":0,\"m\":0,\"d\":\"\",\"n\":1,\"t\":\"\"},\"i013\":{\"b\":\"index\",\"a\":0,\"m\":0,\"d\":\"\",\"n\":1,\"t\":\"\"},\"i014\":{\"b\":\"varchar\",\"a\":0,\"m\":0,\"d\":\"\",\"n\":1,\"t\":\"\"},\"i015\":{\"b\":\"enum\",\"a\":0,\"m\":0,\"d\":\"\",\"n\":1,\"t\":\"\"}}'),(22,103,'creator','{\"i001\":{\"b\":\"person\",\"a\":1,\"m\":1,\"d\":\"\",\"n\":0,\"t\":\"1\"},\"i002\":{\"b\":\"relation\",\"m\":0,\"d\":\"\",\"n\":1,\"t\":\"\",\"a\":null},\"i003\":{\"b\":\"checkbox\",\"a\":0,\"m\":0,\"d\":0,\"n\":1,\"t\":\"\"},\"i004\":{\"b\":\"checkbox\",\"a\":0,\"m\":0,\"d\":0,\"n\":1,\"t\":\"\"},\"i005\":{\"b\":\"checkbox\",\"a\":0,\"m\":0,\"d\":0,\"n\":1,\"t\":\"\"},\"i006\":{\"b\":\"relation\",\"m\":0,\"d\":\"\",\"n\":1,\"t\":\"\",\"a\":null},\"i007\":{\"b\":\"varchar\",\"a\":1,\"m\":1,\"d\":\"目标ffff\",\"n\":1,\"t\":\"\"},\"i008\":{\"b\":\"varchar\",\"a\":0,\"m\":0,\"d\":\"\",\"n\":1,\"t\":\"\"},\"i009\":{\"b\":\"radio\",\"a\":0,\"m\":0,\"d\":0,\"n\":1,\"t\":\"\"},\"i010\":{\"b\":\"radio\",\"a\":0,\"m\":0,\"d\":0,\"n\":1,\"t\":\"\"},\"i011\":{\"b\":\"radio\",\"a\":0,\"m\":0,\"d\":0,\"n\":1,\"t\":\"\"},\"i012\":{\"b\":\"enum\",\"a\":1,\"m\":1,\"d\":\"\",\"n\":1,\"t\":\"\"},\"i013\":{\"b\":\"index\",\"a\":1,\"m\":0,\"d\":\"\",\"n\":1,\"t\":\"\"},\"i014\":{\"b\":\"varchar\",\"a\":1,\"m\":0,\"d\":\"\",\"n\":1,\"t\":\"\"},\"i015\":{\"b\":\"enum\",\"a\":1,\"m\":0,\"d\":\"\",\"n\":1,\"t\":\"\"}}'),(23,103,'id2','{\"i001\":{\"b\":\"person\",\"a\":\"0\",\"m\":0,\"d\":0,\"n\":1,\"t\":\"\"},\"i002\":{\"b\":\"relation\",\"a\":0,\"m\":0,\"d\":\"\",\"n\":1,\"t\":\"\"},\"i003\":{\"b\":\"checkbox\",\"a\":0,\"m\":0,\"d\":\"\",\"n\":1,\"t\":\"\"},\"i004\":{\"b\":\"checkbox\",\"a\":0,\"m\":0,\"d\":\"\",\"n\":1,\"t\":\"\"},\"i005\":{\"b\":\"checkbox\",\"a\":0,\"m\":0,\"d\":\"\",\"n\":1,\"t\":\"\"},\"i006\":{\"b\":\"relation\",\"a\":0,\"m\":0,\"d\":\"\",\"n\":1,\"t\":\"\"},\"i007\":{\"b\":\"varchar\",\"a\":\"0\",\"m\":0,\"d\":0,\"n\":1,\"t\":\"\"},\"i008\":{\"b\":\"varchar\",\"a\":\"0\",\"m\":0,\"d\":0,\"n\":1,\"t\":\"\"}}'),(24,103,'id1','{\"i001\":{\"b\":\"person\",\"a\":\"0\",\"m\":0,\"d\":0,\"n\":1,\"t\":\"\"},\"i002\":{\"b\":\"relation\",\"a\":0,\"m\":0,\"d\":\"\",\"n\":1,\"t\":\"\"},\"i003\":{\"b\":\"checkbox\",\"a\":0,\"m\":0,\"d\":\"\",\"n\":1,\"t\":\"\"},\"i004\":{\"b\":\"checkbox\",\"a\":0,\"m\":0,\"d\":\"\",\"n\":1,\"t\":\"\"},\"i005\":{\"b\":\"checkbox\",\"a\":0,\"m\":0,\"d\":\"\",\"n\":1,\"t\":\"\"},\"i006\":{\"b\":\"relation\",\"a\":0,\"m\":0,\"d\":\"\",\"n\":1,\"t\":\"\"},\"i007\":{\"b\":\"varchar\",\"a\":\"0\",\"m\":0,\"d\":0,\"n\":1,\"t\":\"\"},\"i008\":{\"b\":\"varchar\",\"a\":\"0\",\"m\":0,\"d\":0,\"n\":1,\"t\":\"\"}}');

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
) ENGINE=MyISAM AUTO_INCREMENT=65 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

#
# Data for table "s_flows_comment"
#

INSERT INTO `s_flows_comment` VALUES (8,'刘德华','2020-05-21 09:46:36','审批通过（系统自动生成）',98,'010099','信息科','人事专员'),(9,'刘德华','2020-05-21 09:57:30','审批通过（系统自动生成）',103,'010099','信息科','人事专员'),(10,'刘德华','2020-05-21 11:10:35','审批回退（系统自动生成）',103,'010099','信息科','人事专员'),(11,'刘德华','2020-05-21 11:10:57','审批通过（系统自动生成）',103,'010099','信息科','人事专员'),(12,'刘德华','2020-05-21 11:12:03','审批回退（系统自动生成）',103,'010099','信息科','人事专员'),(13,'刘德华','2020-05-21 11:12:22','审批通过（系统自动生成）',103,'010099','信息科','人事专员'),(14,'刘德华','2020-05-21 11:12:24','审批取回（系统自动生成）',103,'010099','信息科','人事专员'),(56,'刘德华','2020-05-21 15:15:26','审批通过（系统自动生成）',106,'010099','信息科','人事专员'),(57,'刘德华','2020-05-21 15:15:31','审批取回（系统自动生成）',106,'010099','信息科','人事专员'),(58,'刘德华','2020-05-21 15:38:24','审批通过（系统自动生成）',106,'010099','信息科','人事专员'),(59,'刘德华','2020-05-21 15:38:30','审批取回（系统自动生成）',106,'010099','信息科','人事专员'),(60,'刘德华','2020-05-21 15:38:35','审批通过（系统自动生成）',106,'010099','信息科','人事专员'),(61,'郭富城','2020-05-21 15:38:45','审批通过（系统自动生成）',106,'010097','人事科','人事专员'),(63,'王泉','2020-06-05 20:28:05','审批通过（系统自动生成）',114,'010100','信息科','普通员工'),(64,'王泉','2020-06-06 12:24:22','审批通过（系统自动生成）',114,'010100','信息科','普通员工');

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
) ENGINE=MyISAM AUTO_INCREMENT=233 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

#
# Data for table "s_flows_executor"
#

INSERT INTO `s_flows_executor` VALUES (4,3,'id7','010099','刘德华',2,'刘德华','2020-05-03 10:06:42','2020-05-03 10:37:37','2020-05-03 10:37:51',1,NULL),(6,3,'id11','010097','郭富城',0,'刘德华','2020-05-03 10:37:51',NULL,NULL,1,NULL),(186,98,'id6','010099','刘德华',2,'管理员','2020-05-20 14:32:42',NULL,'2020-05-21 09:46:36',1,NULL),(191,103,'id7','010099','刘德华',1,'刘德华','2020-05-21 09:57:17','2020-05-21 11:12:35','2020-05-21 11:12:22',3,NULL),(218,106,'id9','010099','刘德华',2,'刘德华','2020-05-21 15:12:09',NULL,'2020-05-21 15:38:35',3,NULL),(221,106,'id14','010097','郭富城',2,'刘德华','2020-05-21 15:38:35',NULL,'2020-05-21 15:38:45',1,NULL),(230,114,'id18','010100','王泉',2,'管理员','2020-06-05 20:26:05',NULL,'2020-06-06 12:24:22',1,NULL),(231,114,'id19','010100','王泉',2,'管理员','2020-06-05 20:26:05',NULL,'2020-06-05 20:28:05',1,NULL),(232,114,'id21','010100','王泉',0,'王泉','2020-06-05 20:28:05',NULL,NULL,1,NULL);

#
# Structure for table "s_flows_field"
#

CREATE TABLE `s_flows_field` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `flows_id` int(11) NOT NULL DEFAULT '0',
  `field` text,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

#
# Data for table "s_flows_field"
#

INSERT INTO `s_flows_field` VALUES (1,1,'{\"i004\":{\"type\":\"checkbox\",\"length1\":0,\"length2\":0,\"enum_id\":0,\"relation_i\":null,\"relation_a\":null,\"group\":\"c1587456716803\",\"main\":1,\"table_name\":\"form-0153\",\"label\":\"\\u6c34\\u679c\"},\"i005\":{\"type\":\"checkbox\",\"length1\":0,\"length2\":0,\"enum_id\":0,\"relation_i\":null,\"relation_a\":null,\"group\":\"c1587456716803\",\"main\":1,\"table_name\":\"form-0153\",\"label\":\"\\u8089\\u7c7b\"},\"i003\":{\"type\":\"checkbox\",\"length1\":0,\"length2\":0,\"enum_id\":0,\"relation_i\":null,\"relation_a\":null,\"group\":\"c1587456716803\",\"main\":1,\"table_name\":\"form-0153\",\"label\":\"\\u852c\\u83dc\"},\"i001\":{\"type\":\"person\",\"length1\":null,\"length2\":null,\"enum_id\":0,\"relation_i\":null,\"relation_a\":null,\"group\":\"\",\"main\":1,\"table_name\":\"form-0153\",\"label\":\"\\u59d3\\u540d\"},\"i002\":{\"type\":\"relation\",\"length1\":null,\"length2\":null,\"enum_id\":0,\"relation_i\":\"i001\",\"relation_a\":\"post_name\",\"group\":\"\",\"main\":1,\"table_name\":\"form-0153\",\"label\":\"\\u5c97\\u4f4d\"},\"i006\":{\"type\":\"relation\",\"length1\":null,\"length2\":null,\"enum_id\":0,\"relation_i\":\"i001\",\"relation_a\":\"department_name\",\"group\":\"\",\"main\":1,\"table_name\":\"form-0153\",\"label\":\"\\u963f\\u53d1\"},\"i007\":{\"type\":\"varchar\",\"length1\":255,\"length2\":0,\"enum_id\":0,\"relation_i\":\"\",\"relation_a\":\"\",\"group\":\"\",\"main\":1,\"table_name\":\"form-0153\",\"label\":\"\\u98d2\\u7136\"},\"i008\":{\"type\":\"varchar\",\"length1\":255,\"length2\":0,\"enum_id\":0,\"relation_i\":\"\",\"relation_a\":\"\",\"group\":\"\",\"main\":1,\"table_name\":\"form-0153\",\"label\":\"\\u5929\\u5929\"},\"i009\":{\"type\":\"radio\",\"length1\":0,\"length2\":0,\"enum_id\":0,\"relation_i\":\"\",\"relation_a\":\"\",\"group\":\"r1587948720399\",\"main\":1,\"table_name\":\"form-0153\",\"label\":\"\\u8db3\\u7403\"},\"i010\":{\"type\":\"radio\",\"length1\":0,\"length2\":0,\"enum_id\":0,\"relation_i\":\"\",\"relation_a\":\"\",\"group\":\"r1587948720399\",\"main\":1,\"table_name\":\"form-0153\",\"label\":\"\\u7bee\\u7403\"},\"i011\":{\"type\":\"radio\",\"length1\":0,\"length2\":0,\"enum_id\":0,\"relation_i\":\"\",\"relation_a\":\"\",\"group\":\"r1587948720399\",\"main\":1,\"table_name\":\"form-0153\",\"label\":\"\\u6392\\u7403\"},\"i012\":{\"type\":\"enum\",\"length1\":0,\"length2\":0,\"enum_id\":3,\"relation_i\":\"\",\"relation_a\":\"\",\"group\":\"\",\"main\":1,\"table_name\":\"form-0153\",\"label\":\"\\u4ed8\\u6b3e\\u7c7b\\u578b\"},\"i013\":{\"type\":\"index\",\"length1\":0,\"length2\":0,\"enum_id\":0,\"relation_i\":null,\"relation_a\":null,\"group\":\"\",\"main\":0,\"table_name\":\"subform-0124\",\"label\":\"\\u5e8f\\u53f7\"},\"i014\":{\"type\":\"varchar\",\"length1\":255,\"length2\":0,\"enum_id\":0,\"relation_i\":null,\"relation_a\":null,\"group\":\"\",\"main\":0,\"table_name\":\"subform-0124\",\"label\":\"\\u59d3\\u540d\"},\"i015\":{\"type\":\"enum\",\"length1\":0,\"length2\":0,\"enum_id\":32,\"relation_i\":null,\"relation_a\":null,\"group\":\"\",\"main\":0,\"table_name\":\"subform-0124\",\"label\":\"\\u4ea4\\u901a\"}}'),(2,2,'{\"i004\":{\"type\":\"checkbox\",\"length1\":0,\"length2\":0,\"enum_id\":0,\"relation_i\":null,\"relation_a\":null,\"group\":\"c1587456716803\",\"main\":1,\"table_name\":\"form-0153\",\"label\":\"\\u6c34\\u679c\"},\"i005\":{\"type\":\"checkbox\",\"length1\":0,\"length2\":0,\"enum_id\":0,\"relation_i\":null,\"relation_a\":null,\"group\":\"c1587456716803\",\"main\":1,\"table_name\":\"form-0153\",\"label\":\"\\u8089\\u7c7b\"},\"i003\":{\"type\":\"checkbox\",\"length1\":0,\"length2\":0,\"enum_id\":0,\"relation_i\":null,\"relation_a\":null,\"group\":\"c1587456716803\",\"main\":1,\"table_name\":\"form-0153\",\"label\":\"\\u852c\\u83dc\"},\"i001\":{\"type\":\"person\",\"length1\":null,\"length2\":null,\"enum_id\":0,\"relation_i\":null,\"relation_a\":null,\"group\":\"\",\"main\":1,\"table_name\":\"form-0153\",\"label\":\"\\u59d3\\u540d\"},\"i002\":{\"type\":\"relation\",\"length1\":null,\"length2\":null,\"enum_id\":0,\"relation_i\":\"i001\",\"relation_a\":\"post_name\",\"group\":\"\",\"main\":1,\"table_name\":\"form-0153\",\"label\":\"\\u5c97\\u4f4d\"},\"i006\":{\"type\":\"relation\",\"length1\":null,\"length2\":null,\"enum_id\":0,\"relation_i\":\"i001\",\"relation_a\":\"department_name\",\"group\":\"\",\"main\":1,\"table_name\":\"form-0153\",\"label\":\"\\u963f\\u53d1\"},\"i007\":{\"type\":\"varchar\",\"length1\":255,\"length2\":0,\"enum_id\":0,\"relation_i\":\"\",\"relation_a\":\"\",\"group\":\"\",\"main\":1,\"table_name\":\"form-0153\",\"label\":\"\\u98d2\\u7136\"},\"i008\":{\"type\":\"varchar\",\"length1\":255,\"length2\":0,\"enum_id\":0,\"relation_i\":\"\",\"relation_a\":\"\",\"group\":\"\",\"main\":1,\"table_name\":\"form-0153\",\"label\":\"\\u5929\\u5929\"},\"i009\":{\"type\":\"radio\",\"length1\":0,\"length2\":0,\"enum_id\":0,\"relation_i\":\"\",\"relation_a\":\"\",\"group\":\"r1587948720399\",\"main\":1,\"table_name\":\"form-0153\",\"label\":\"\\u8db3\\u7403\"},\"i010\":{\"type\":\"radio\",\"length1\":0,\"length2\":0,\"enum_id\":0,\"relation_i\":\"\",\"relation_a\":\"\",\"group\":\"r1587948720399\",\"main\":1,\"table_name\":\"form-0153\",\"label\":\"\\u7bee\\u7403\"},\"i011\":{\"type\":\"radio\",\"length1\":0,\"length2\":0,\"enum_id\":0,\"relation_i\":\"\",\"relation_a\":\"\",\"group\":\"r1587948720399\",\"main\":1,\"table_name\":\"form-0153\",\"label\":\"\\u6392\\u7403\"},\"i012\":{\"type\":\"enum\",\"length1\":0,\"length2\":0,\"enum_id\":3,\"relation_i\":\"\",\"relation_a\":\"\",\"group\":\"\",\"main\":1,\"table_name\":\"form-0153\",\"label\":\"\\u4ed8\\u6b3e\\u7c7b\\u578b\"},\"i013\":{\"type\":\"index\",\"length1\":0,\"length2\":0,\"enum_id\":0,\"relation_i\":null,\"relation_a\":null,\"group\":\"\",\"main\":0,\"table_name\":\"subform-0124\",\"label\":\"\\u5e8f\\u53f7\"},\"i014\":{\"type\":\"varchar\",\"length1\":255,\"length2\":0,\"enum_id\":0,\"relation_i\":null,\"relation_a\":null,\"group\":\"\",\"main\":0,\"table_name\":\"subform-0124\",\"label\":\"\\u59d3\\u540d\"},\"i015\":{\"type\":\"enum\",\"length1\":0,\"length2\":0,\"enum_id\":32,\"relation_i\":null,\"relation_a\":null,\"group\":\"\",\"main\":0,\"table_name\":\"subform-0124\",\"label\":\"\\u4ea4\\u901a\"}}'),(3,3,'{\"i004\":{\"type\":\"checkbox\",\"length1\":0,\"length2\":0,\"enum_id\":0,\"relation_i\":null,\"relation_a\":null,\"group\":\"c1587456716803\",\"main\":1,\"table_name\":\"form-0153\",\"label\":\"\\u6c34\\u679c\"},\"i005\":{\"type\":\"checkbox\",\"length1\":0,\"length2\":0,\"enum_id\":0,\"relation_i\":null,\"relation_a\":null,\"group\":\"c1587456716803\",\"main\":1,\"table_name\":\"form-0153\",\"label\":\"\\u8089\\u7c7b\"},\"i003\":{\"type\":\"checkbox\",\"length1\":0,\"length2\":0,\"enum_id\":0,\"relation_i\":null,\"relation_a\":null,\"group\":\"c1587456716803\",\"main\":1,\"table_name\":\"form-0153\",\"label\":\"\\u852c\\u83dc\"},\"i001\":{\"type\":\"person\",\"length1\":null,\"length2\":null,\"enum_id\":0,\"relation_i\":null,\"relation_a\":null,\"group\":\"\",\"main\":1,\"table_name\":\"form-0153\",\"label\":\"\\u59d3\\u540d\"},\"i002\":{\"type\":\"relation\",\"length1\":null,\"length2\":null,\"enum_id\":0,\"relation_i\":\"i001\",\"relation_a\":\"post_name\",\"group\":\"\",\"main\":1,\"table_name\":\"form-0153\",\"label\":\"\\u5c97\\u4f4d\"},\"i006\":{\"type\":\"relation\",\"length1\":null,\"length2\":null,\"enum_id\":0,\"relation_i\":\"i001\",\"relation_a\":\"department_name\",\"group\":\"\",\"main\":1,\"table_name\":\"form-0153\",\"label\":\"\\u963f\\u53d1\"},\"i007\":{\"type\":\"varchar\",\"length1\":255,\"length2\":0,\"enum_id\":0,\"relation_i\":\"\",\"relation_a\":\"\",\"group\":\"\",\"main\":1,\"table_name\":\"form-0153\",\"label\":\"\\u98d2\\u7136\"},\"i008\":{\"type\":\"varchar\",\"length1\":255,\"length2\":0,\"enum_id\":0,\"relation_i\":\"\",\"relation_a\":\"\",\"group\":\"\",\"main\":1,\"table_name\":\"form-0153\",\"label\":\"\\u5929\\u5929\"},\"i009\":{\"type\":\"radio\",\"length1\":0,\"length2\":0,\"enum_id\":0,\"relation_i\":\"\",\"relation_a\":\"\",\"group\":\"r1587948720399\",\"main\":1,\"table_name\":\"form-0153\",\"label\":\"\\u8db3\\u7403\"},\"i010\":{\"type\":\"radio\",\"length1\":0,\"length2\":0,\"enum_id\":0,\"relation_i\":\"\",\"relation_a\":\"\",\"group\":\"r1587948720399\",\"main\":1,\"table_name\":\"form-0153\",\"label\":\"\\u7bee\\u7403\"},\"i011\":{\"type\":\"radio\",\"length1\":0,\"length2\":0,\"enum_id\":0,\"relation_i\":\"\",\"relation_a\":\"\",\"group\":\"r1587948720399\",\"main\":1,\"table_name\":\"form-0153\",\"label\":\"\\u6392\\u7403\"},\"i012\":{\"type\":\"enum\",\"length1\":0,\"length2\":0,\"enum_id\":3,\"relation_i\":\"\",\"relation_a\":\"\",\"group\":\"\",\"main\":1,\"table_name\":\"form-0153\",\"label\":\"\\u4ed8\\u6b3e\\u7c7b\\u578b\"},\"i013\":{\"type\":\"index\",\"length1\":0,\"length2\":0,\"enum_id\":0,\"relation_i\":null,\"relation_a\":null,\"group\":\"\",\"main\":0,\"table_name\":\"subform-0124\",\"label\":\"\\u5e8f\\u53f7\"},\"i014\":{\"type\":\"varchar\",\"length1\":255,\"length2\":0,\"enum_id\":0,\"relation_i\":null,\"relation_a\":null,\"group\":\"\",\"main\":0,\"table_name\":\"subform-0124\",\"label\":\"\\u59d3\\u540d\"},\"i015\":{\"type\":\"enum\",\"length1\":0,\"length2\":0,\"enum_id\":32,\"relation_i\":null,\"relation_a\":null,\"group\":\"\",\"main\":0,\"table_name\":\"subform-0124\",\"label\":\"\\u4ea4\\u901a\"}}'),(4,4,'{\"i004\":{\"type\":\"checkbox\",\"length1\":0,\"length2\":0,\"enum_id\":0,\"relation_i\":null,\"relation_a\":null,\"group\":\"c1587456716803\",\"main\":1,\"table_name\":\"form-0153\",\"label\":\"\\u6c34\\u679c\"},\"i005\":{\"type\":\"checkbox\",\"length1\":0,\"length2\":0,\"enum_id\":0,\"relation_i\":null,\"relation_a\":null,\"group\":\"c1587456716803\",\"main\":1,\"table_name\":\"form-0153\",\"label\":\"\\u8089\\u7c7b\"},\"i003\":{\"type\":\"checkbox\",\"length1\":0,\"length2\":0,\"enum_id\":0,\"relation_i\":null,\"relation_a\":null,\"group\":\"c1587456716803\",\"main\":1,\"table_name\":\"form-0153\",\"label\":\"\\u852c\\u83dc\"},\"i001\":{\"type\":\"person\",\"length1\":null,\"length2\":null,\"enum_id\":0,\"relation_i\":null,\"relation_a\":null,\"group\":\"\",\"main\":1,\"table_name\":\"form-0153\",\"label\":\"\\u59d3\\u540d\"},\"i002\":{\"type\":\"relation\",\"length1\":null,\"length2\":null,\"enum_id\":0,\"relation_i\":\"i001\",\"relation_a\":\"post_name\",\"group\":\"\",\"main\":1,\"table_name\":\"form-0153\",\"label\":\"\\u5c97\\u4f4d\"},\"i006\":{\"type\":\"relation\",\"length1\":null,\"length2\":null,\"enum_id\":0,\"relation_i\":\"i001\",\"relation_a\":\"department_name\",\"group\":\"\",\"main\":1,\"table_name\":\"form-0153\",\"label\":\"\\u963f\\u53d1\"},\"i007\":{\"type\":\"varchar\",\"length1\":255,\"length2\":0,\"enum_id\":0,\"relation_i\":\"\",\"relation_a\":\"\",\"group\":\"\",\"main\":1,\"table_name\":\"form-0153\",\"label\":\"\\u98d2\\u7136\"},\"i008\":{\"type\":\"varchar\",\"length1\":255,\"length2\":0,\"enum_id\":0,\"relation_i\":\"\",\"relation_a\":\"\",\"group\":\"\",\"main\":1,\"table_name\":\"form-0153\",\"label\":\"\\u5929\\u5929\"},\"i009\":{\"type\":\"radio\",\"length1\":0,\"length2\":0,\"enum_id\":0,\"relation_i\":\"\",\"relation_a\":\"\",\"group\":\"r1587948720399\",\"main\":1,\"table_name\":\"form-0153\",\"label\":\"\\u8db3\\u7403\"},\"i010\":{\"type\":\"radio\",\"length1\":0,\"length2\":0,\"enum_id\":0,\"relation_i\":\"\",\"relation_a\":\"\",\"group\":\"r1587948720399\",\"main\":1,\"table_name\":\"form-0153\",\"label\":\"\\u7bee\\u7403\"},\"i011\":{\"type\":\"radio\",\"length1\":0,\"length2\":0,\"enum_id\":0,\"relation_i\":\"\",\"relation_a\":\"\",\"group\":\"r1587948720399\",\"main\":1,\"table_name\":\"form-0153\",\"label\":\"\\u6392\\u7403\"},\"i012\":{\"type\":\"enum\",\"length1\":0,\"length2\":0,\"enum_id\":3,\"relation_i\":\"\",\"relation_a\":\"\",\"group\":\"\",\"main\":1,\"table_name\":\"form-0153\",\"label\":\"\\u4ed8\\u6b3e\\u7c7b\\u578b\"},\"i013\":{\"type\":\"index\",\"length1\":0,\"length2\":0,\"enum_id\":0,\"relation_i\":null,\"relation_a\":null,\"group\":\"\",\"main\":0,\"table_name\":\"subform-0124\",\"label\":\"\\u5e8f\\u53f7\"},\"i014\":{\"type\":\"varchar\",\"length1\":255,\"length2\":0,\"enum_id\":0,\"relation_i\":null,\"relation_a\":null,\"group\":\"\",\"main\":0,\"table_name\":\"subform-0124\",\"label\":\"\\u59d3\\u540d\"},\"i015\":{\"type\":\"enum\",\"length1\":0,\"length2\":0,\"enum_id\":32,\"relation_i\":null,\"relation_a\":null,\"group\":\"\",\"main\":0,\"table_name\":\"subform-0124\",\"label\":\"\\u4ea4\\u901a\"}}'),(5,5,'{\"i004\":{\"type\":\"checkbox\",\"length1\":0,\"length2\":0,\"enum_id\":0,\"relation_i\":null,\"relation_a\":null,\"group\":\"c1587456716803\",\"main\":1,\"table_name\":\"form-0153\",\"label\":\"\\u6c34\\u679c\"},\"i005\":{\"type\":\"checkbox\",\"length1\":0,\"length2\":0,\"enum_id\":0,\"relation_i\":null,\"relation_a\":null,\"group\":\"c1587456716803\",\"main\":1,\"table_name\":\"form-0153\",\"label\":\"\\u8089\\u7c7b\"},\"i003\":{\"type\":\"checkbox\",\"length1\":0,\"length2\":0,\"enum_id\":0,\"relation_i\":null,\"relation_a\":null,\"group\":\"c1587456716803\",\"main\":1,\"table_name\":\"form-0153\",\"label\":\"\\u852c\\u83dc\"},\"i001\":{\"type\":\"person\",\"length1\":null,\"length2\":null,\"enum_id\":0,\"relation_i\":null,\"relation_a\":null,\"group\":\"\",\"main\":1,\"table_name\":\"form-0153\",\"label\":\"\\u59d3\\u540d\"},\"i002\":{\"type\":\"relation\",\"length1\":null,\"length2\":null,\"enum_id\":0,\"relation_i\":\"i001\",\"relation_a\":\"post_name\",\"group\":\"\",\"main\":1,\"table_name\":\"form-0153\",\"label\":\"\\u5c97\\u4f4d\"},\"i006\":{\"type\":\"relation\",\"length1\":null,\"length2\":null,\"enum_id\":0,\"relation_i\":\"i001\",\"relation_a\":\"department_name\",\"group\":\"\",\"main\":1,\"table_name\":\"form-0153\",\"label\":\"\\u963f\\u53d1\"},\"i007\":{\"type\":\"varchar\",\"length1\":255,\"length2\":0,\"enum_id\":0,\"relation_i\":\"\",\"relation_a\":\"\",\"group\":\"\",\"main\":1,\"table_name\":\"form-0153\",\"label\":\"\\u98d2\\u7136\"},\"i008\":{\"type\":\"varchar\",\"length1\":255,\"length2\":0,\"enum_id\":0,\"relation_i\":\"\",\"relation_a\":\"\",\"group\":\"\",\"main\":1,\"table_name\":\"form-0153\",\"label\":\"\\u5929\\u5929\"},\"i009\":{\"type\":\"radio\",\"length1\":0,\"length2\":0,\"enum_id\":0,\"relation_i\":\"\",\"relation_a\":\"\",\"group\":\"r1587948720399\",\"main\":1,\"table_name\":\"form-0153\",\"label\":\"\\u8db3\\u7403\"},\"i010\":{\"type\":\"radio\",\"length1\":0,\"length2\":0,\"enum_id\":0,\"relation_i\":\"\",\"relation_a\":\"\",\"group\":\"r1587948720399\",\"main\":1,\"table_name\":\"form-0153\",\"label\":\"\\u7bee\\u7403\"},\"i011\":{\"type\":\"radio\",\"length1\":0,\"length2\":0,\"enum_id\":0,\"relation_i\":\"\",\"relation_a\":\"\",\"group\":\"r1587948720399\",\"main\":1,\"table_name\":\"form-0153\",\"label\":\"\\u6392\\u7403\"},\"i012\":{\"type\":\"enum\",\"length1\":0,\"length2\":0,\"enum_id\":3,\"relation_i\":\"\",\"relation_a\":\"\",\"group\":\"\",\"main\":1,\"table_name\":\"form-0153\",\"label\":\"\\u4ed8\\u6b3e\\u7c7b\\u578b\"},\"i013\":{\"type\":\"index\",\"length1\":0,\"length2\":0,\"enum_id\":0,\"relation_i\":null,\"relation_a\":null,\"group\":\"\",\"main\":0,\"table_name\":\"subform-0124\",\"label\":\"\\u5e8f\\u53f7\"},\"i014\":{\"type\":\"varchar\",\"length1\":255,\"length2\":0,\"enum_id\":0,\"relation_i\":null,\"relation_a\":null,\"group\":\"\",\"main\":0,\"table_name\":\"subform-0124\",\"label\":\"\\u59d3\\u540d\"},\"i015\":{\"type\":\"enum\",\"length1\":0,\"length2\":0,\"enum_id\":32,\"relation_i\":null,\"relation_a\":null,\"group\":\"\",\"main\":0,\"table_name\":\"subform-0124\",\"label\":\"\\u4ea4\\u901a\"}}'),(6,103,'{\"i004\":{\"type\":\"checkbox\",\"length1\":0,\"length2\":0,\"enum_id\":0,\"relation_i\":null,\"relation_a\":null,\"group\":\"c1587456716803\",\"main\":1,\"table_name\":\"form-0153\",\"label\":\"\\u6c34\\u679c\"},\"i005\":{\"type\":\"checkbox\",\"length1\":0,\"length2\":0,\"enum_id\":0,\"relation_i\":null,\"relation_a\":null,\"group\":\"c1587456716803\",\"main\":1,\"table_name\":\"form-0153\",\"label\":\"\\u8089\\u7c7b\"},\"i003\":{\"type\":\"checkbox\",\"length1\":0,\"length2\":0,\"enum_id\":0,\"relation_i\":null,\"relation_a\":null,\"group\":\"c1587456716803\",\"main\":1,\"table_name\":\"form-0153\",\"label\":\"\\u852c\\u83dc\"},\"i001\":{\"type\":\"person\",\"length1\":null,\"length2\":null,\"enum_id\":0,\"relation_i\":null,\"relation_a\":null,\"group\":\"\",\"main\":1,\"table_name\":\"form-0153\",\"label\":\"\\u59d3\\u540d\"},\"i002\":{\"type\":\"relation\",\"length1\":null,\"length2\":null,\"enum_id\":0,\"relation_i\":\"i001\",\"relation_a\":\"post_name\",\"group\":\"\",\"main\":1,\"table_name\":\"form-0153\",\"label\":\"\\u5c97\\u4f4d\"},\"i006\":{\"type\":\"relation\",\"length1\":null,\"length2\":null,\"enum_id\":0,\"relation_i\":\"i001\",\"relation_a\":\"department_name\",\"group\":\"\",\"main\":1,\"table_name\":\"form-0153\",\"label\":\"\\u963f\\u53d1\"},\"i007\":{\"type\":\"varchar\",\"length1\":255,\"length2\":0,\"enum_id\":0,\"relation_i\":\"\",\"relation_a\":\"\",\"group\":\"\",\"main\":1,\"table_name\":\"form-0153\",\"label\":\"\\u98d2\\u7136\"},\"i008\":{\"type\":\"varchar\",\"length1\":255,\"length2\":0,\"enum_id\":0,\"relation_i\":\"\",\"relation_a\":\"\",\"group\":\"\",\"main\":1,\"table_name\":\"form-0153\",\"label\":\"\\u5929\\u5929\"},\"i009\":{\"type\":\"radio\",\"length1\":0,\"length2\":0,\"enum_id\":0,\"relation_i\":\"\",\"relation_a\":\"\",\"group\":\"r1587948720399\",\"main\":1,\"table_name\":\"form-0153\",\"label\":\"\\u8db3\\u7403\"},\"i010\":{\"type\":\"radio\",\"length1\":0,\"length2\":0,\"enum_id\":0,\"relation_i\":\"\",\"relation_a\":\"\",\"group\":\"r1587948720399\",\"main\":1,\"table_name\":\"form-0153\",\"label\":\"\\u7bee\\u7403\"},\"i011\":{\"type\":\"radio\",\"length1\":0,\"length2\":0,\"enum_id\":0,\"relation_i\":\"\",\"relation_a\":\"\",\"group\":\"r1587948720399\",\"main\":1,\"table_name\":\"form-0153\",\"label\":\"\\u6392\\u7403\"},\"i012\":{\"type\":\"enum\",\"length1\":0,\"length2\":0,\"enum_id\":3,\"relation_i\":\"\",\"relation_a\":\"\",\"group\":\"\",\"main\":1,\"table_name\":\"form-0153\",\"label\":\"\\u4ed8\\u6b3e\\u7c7b\\u578b\"},\"i013\":{\"type\":\"index\",\"length1\":0,\"length2\":0,\"enum_id\":0,\"relation_i\":null,\"relation_a\":null,\"group\":\"\",\"main\":0,\"table_name\":\"subform-0124\",\"label\":\"\\u5e8f\\u53f7\"},\"i014\":{\"type\":\"varchar\",\"length1\":255,\"length2\":0,\"enum_id\":0,\"relation_i\":null,\"relation_a\":null,\"group\":\"\",\"main\":0,\"table_name\":\"subform-0124\",\"label\":\"\\u59d3\\u540d\"},\"i015\":{\"type\":\"enum\",\"length1\":0,\"length2\":0,\"enum_id\":32,\"relation_i\":null,\"relation_a\":null,\"group\":\"\",\"main\":0,\"table_name\":\"subform-0124\",\"label\":\"\\u4ea4\\u901a\"}}');

#
# Structure for table "s_form-0094"
#

CREATE TABLE `s_form-0094` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `flows_id` int(11) NOT NULL DEFAULT '0',
  `i001` int(11) DEFAULT NULL,
  `i002` varchar(255) DEFAULT NULL,
  `i008` varchar(255) DEFAULT NULL,
  `i009` varchar(255) DEFAULT NULL,
  `i010` int(11) DEFAULT NULL,
  `i011` int(1) DEFAULT NULL,
  `i012` int(1) DEFAULT NULL,
  `i013` int(1) DEFAULT NULL,
  `i014` int(1) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

#
# Data for table "s_form-0094"
#

INSERT INTO `s_form-0094` VALUES (1,1,1,'发顺丰','1','1',1,1,NULL,1,NULL),(2,220,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL);

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
# Data for table "s_form-0096"
#


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
# Data for table "s_form-0097"
#


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
# Data for table "s_form-0105"
#


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
# Data for table "s_form-0107"
#

INSERT INTO `s_form-0107` VALUES (1,1670,'法法','法师法师',NULL,2,0,1,0,0,1,0,'法师法师','法发顺丰');

#
# Structure for table "s_form-0116"
#

CREATE TABLE `s_form-0116` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `i001` varchar(255) DEFAULT NULL,
  `i002` varchar(255) DEFAULT NULL,
  `i003` varchar(255) DEFAULT NULL,
  `i004` int(1) DEFAULT '0',
  `i005` int(1) DEFAULT '0',
  `i006` int(11) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

#
# Data for table "s_form-0116"
#


#
# Structure for table "s_form-0117"
#

CREATE TABLE `s_form-0117` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `i001` varchar(255) DEFAULT NULL,
  `i002` varchar(255) DEFAULT NULL,
  `i003` varchar(255) DEFAULT NULL,
  `i004` int(1) DEFAULT '0',
  `i005` int(1) DEFAULT '0',
  `i006` int(11) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

#
# Data for table "s_form-0117"
#


#
# Structure for table "s_form-0119"
#

CREATE TABLE `s_form-0119` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `i001` varchar(255) DEFAULT NULL,
  `i002` varchar(255) DEFAULT NULL,
  `i003` varchar(255) DEFAULT NULL,
  `i004` int(1) DEFAULT '0',
  `i005` int(1) DEFAULT '0',
  `i006` int(11) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

#
# Data for table "s_form-0119"
#


#
# Structure for table "s_form-0120"
#

CREATE TABLE `s_form-0120` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `flows_id` int(11) NOT NULL,
  `i001` int(1) DEFAULT '0',
  `i002` int(1) DEFAULT '0',
  `i003` int(1) DEFAULT '0',
  `i004` int(1) DEFAULT '0',
  `i005` int(11) DEFAULT '0',
  `i009` varchar(100) DEFAULT NULL,
  `i010` varchar(110) DEFAULT NULL,
  `i011` varchar(120) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=19 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

#
# Data for table "s_form-0120"
#

INSERT INTO `s_form-0120` VALUES (1,1672,1,0,1,0,22,'姓名','部门','岗位'),(2,1673,1,0,1,0,22,'姓名','部门','岗位'),(3,1674,1,0,1,0,22,'姓名','部门','岗位'),(4,1675,1,0,1,0,22,'姓名','部门','岗位'),(5,1676,1,0,1,0,22,'姓名','部门','岗位'),(6,1677,1,0,1,0,22,'姓名','部门','岗位'),(7,1678,1,0,1,0,22,'姓名','部门','岗位'),(8,1679,1,0,1,0,22,'姓名','部门','岗位'),(9,1680,1,0,1,0,22,'姓名','部门','岗位'),(10,1681,0,0,0,0,24,'1','2','3'),(11,1682,1,0,0,1,24,'1','2','3'),(12,1683,1,0,0,0,23,'111','222','333'),(13,1684,1,0,0,1,21,'1111','2222','3333'),(14,1685,1,0,1,0,23,'11','11','11'),(15,1686,1,0,1,0,22,'11','22','33'),(16,1687,0,1,0,0,22,'123','456','789'),(17,1688,0,0,0,0,21,'fasfa','fasfas','fasfas'),(18,1689,0,0,0,0,21,'fafa','fafas','fasfasf');

#
# Structure for table "s_form-0153"
#

CREATE TABLE `s_form-0153` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `flows_id` int(11) NOT NULL,
  `i001` int(11) DEFAULT NULL,
  `i002` varchar(255) DEFAULT NULL,
  `i003` int(1) DEFAULT NULL,
  `i004` int(1) DEFAULT NULL,
  `i005` int(1) DEFAULT NULL,
  `i006` varchar(255) DEFAULT NULL,
  `i007` varchar(255) DEFAULT NULL,
  `i008` varchar(255) DEFAULT NULL,
  `i009` int(1) DEFAULT NULL,
  `i010` int(1) DEFAULT NULL,
  `i011` int(1) DEFAULT NULL,
  `i012` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=41 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

#
# Data for table "s_form-0153"
#

INSERT INTO `s_form-0153` VALUES (1,1691,171,'-',NULL,1,1,'-','目标',NULL,NULL,NULL,NULL,NULL),(2,1692,185,'人事专员',NULL,1,0,'信息科','目标',NULL,NULL,NULL,NULL,NULL),(3,1693,185,'人事专员',NULL,1,1,'信息科','目标',NULL,NULL,NULL,NULL,NULL),(4,1694,185,'人事专员',NULL,0,1,'信息科','师傅三',NULL,NULL,NULL,NULL,NULL),(5,1695,185,'人事专员',NULL,0,1,'信息科','师傅三',NULL,NULL,NULL,NULL,NULL),(6,1696,185,'人事专员',NULL,0,1,'信息科','师傅三',NULL,NULL,NULL,NULL,NULL),(7,1697,185,'人事专员',NULL,0,1,'信息科','123',NULL,NULL,NULL,NULL,NULL),(8,1698,185,'人事专员',NULL,0,1,'信息科','12345',NULL,NULL,NULL,NULL,NULL),(9,1699,185,'人事专员',NULL,1,0,'信息科','4141414',NULL,NULL,NULL,NULL,NULL),(10,1700,185,'人事专员',NULL,0,1,'信息科','飒然','法法',NULL,NULL,NULL,NULL),(11,1701,185,'人事专员',NULL,1,1,'信息科','目标','',NULL,NULL,NULL,NULL),(12,1702,185,'人事专员',NULL,1,1,'信息科','目标','asfasf',NULL,NULL,NULL,NULL),(13,1703,185,'人事专员',NULL,1,1,'信息科','目标','33',NULL,NULL,NULL,NULL),(14,1704,185,NULL,NULL,0,1,NULL,'目标',NULL,0,NULL,NULL,NULL),(15,1705,185,NULL,NULL,0,1,NULL,'目标ffff',NULL,1,0,0,NULL),(16,1706,185,NULL,NULL,0,1,NULL,'目标ffff',NULL,1,0,0,20),(17,1707,185,NULL,NULL,0,1,NULL,'目标ffff',NULL,1,0,0,3),(18,1708,22,'人事专员',NULL,1,1,'行政科','一起努力',NULL,0,0,1,20),(19,1709,185,'人事专员',NULL,0,1,'信息科','目标ffff',NULL,1,0,0,3),(20,1710,185,'人事专员',NULL,0,1,'信息科','目标ffff',NULL,1,0,0,3),(21,1713,185,'人事专员',NULL,0,1,'信息科','目标ffff',NULL,1,0,0,3),(22,1715,185,'人事专员',NULL,0,1,'信息科','目标ffff',NULL,1,0,0,3),(23,1716,185,'人事专员',NULL,0,1,'信息科','目标ffff',NULL,1,0,0,3),(24,1717,185,'人事专员',NULL,0,1,'信息科','目标ffff',NULL,1,0,0,3),(25,1718,185,'人事专员',NULL,1,0,'信息科','目标ffff',NULL,0,1,0,2),(26,1719,14,'人事专员',NULL,0,1,'信息科','目标ffff',NULL,1,0,0,3),(27,1720,14,'人事专员',NULL,0,0,'信息科','目标ffff',NULL,1,0,0,3),(28,1721,14,'人事专员',NULL,1,0,'信息科','目标ffff',NULL,0,1,0,20),(29,1722,14,'人事专员',1,0,1,'信息科','abc','abc',0,0,1,3),(30,1723,14,'人事专员',1,0,1,'信息科','123456','天天的天气',0,0,1,20),(31,1724,14,'人事专员',1,0,1,'信息科','11','天天的天气',0,0,1,3),(32,1725,14,'人事专员',1,0,1,'信息科','aaaff','天天的天气',0,0,1,20),(33,1726,14,'人事专员',1,0,1,'信息科','目标ffff','天天的天气',0,0,1,2),(34,1727,14,'人事专员',NULL,NULL,NULL,'信息科','目标ffff',NULL,NULL,NULL,NULL,3),(35,1,14,'人事专员',1,0,1,'信息科','目标ffff','14141555',0,0,1,3),(36,2,14,'人事专员',NULL,NULL,NULL,'信息科','fafasfasfasfas',NULL,NULL,NULL,NULL,3),(37,3,14,'人事专员',1,0,1,'信息科','saaaa','天天的天气',0,0,1,3),(38,4,14,'人事专员',NULL,NULL,NULL,'信息科','目标ffff',NULL,NULL,NULL,NULL,3),(39,5,14,'人事专员',NULL,NULL,NULL,'信息科','目标ffff',NULL,NULL,NULL,NULL,2),(40,103,14,'人事专员',NULL,NULL,NULL,'信息科','目标ffff',NULL,NULL,NULL,NULL,2);

#
# Structure for table "s_inventory"
#

CREATE TABLE `s_inventory` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(255) NOT NULL DEFAULT '',
  `name` varchar(255) NOT NULL DEFAULT '',
  `std` varchar(255) DEFAULT NULL,
  `unit_id` int(11) NOT NULL DEFAULT '0',
  `self` tinyint(3) NOT NULL DEFAULT '0',
  `end_date` date DEFAULT NULL,
  `create_date` date DEFAULT NULL,
  `maker` varchar(255) DEFAULT NULL,
  `basic_class_id` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `code` (`code`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

#
# Data for table "s_inventory"
#

INSERT INTO `s_inventory` VALUES (1,'01000144','弹簧4433','0015533',5,1,NULL,NULL,NULL,16),(2,'00001','弹簧','02',3,1,NULL,'2020-05-07','管理员',17),(3,'00002','弹簧','03',3,0,NULL,'2020-05-07','管理员',16);

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
) ENGINE=MyISAM AUTO_INCREMENT=54 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

#
# Data for table "s_layout"
#

INSERT INTO `s_layout` VALUES (2,1,'人事','',0,10,NULL,0,'people',0,0),(5,2,'员工档案','Hr/index',2,1,861,0,'',0,0),(6,2,'时间线','Hr/timeline',2,5,NULL,0,'',0,0),(29,2,'组织','Dept/index',2,10,868,0,'',0,0),(30,2,'岗位','Pst/index',2,20,870,0,'',0,0),(31,1,'基础资料','',0,1000,NULL,0,'view_module',0,0),(32,2,'枚举','Basic/enum',31,10,873,0,'',0,0),(33,2,'流程管理','F/manage',31,20,875,0,'',0,0),(34,1,'协同办公','',0,20,NULL,0,'repeat',0,0),(35,2,'新建事项','Fs/newFlow',34,20,878,0,'',0,1),(36,2,'待办事项','Fs/notDone',34,30,879,0,'',0,1),(37,2,'已办事项','Fs/hasDone',34,40,880,0,'',0,1),(39,2,'已发事项','Fs/hasSend',34,50,881,0,'',0,1),(43,2,'流程节点管理','F/node',31,30,882,0,'',0,0),(44,2,'存货档案','ErpBase/inventory',31,100,885,0,'',0,0),(45,2,'供应商档案','ErpBase/vendor',31,110,886,0,'',0,0),(47,2,'客户档案','ErpBase/customer',31,120,887,0,'',0,0),(48,2,'计量单位','ErpBase/unit',31,200,884,0,'',0,0),(49,2,'基础资料分类','ErpBase/basicClass',31,500,888,0,'',0,0),(50,1,'采购','',0,30,NULL,0,'local_shipping',0,0),(52,2,'供应商价格表 - 新增','Purchase/vendorPriceJust',50,30,892,0,'',0,0),(53,2,'供应商价格表 - 列表','Purchase/vendorPriceJustList',50,40,893,0,'',0,0);

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
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

#
# Data for table "s_max"
#

INSERT INTO `s_max` VALUES (1,'flow_table',153,124,'0','');

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
  KEY `name` (`name`),
  KEY `pid` (`pid`),
  KEY `status` (`status`)
) ENGINE=MyISAM AUTO_INCREMENT=894 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

#
# Data for table "s_node"
#

INSERT INTO `s_node` VALUES (860,'人事','Hr',0,NULL,1,0,1,0),(861,'人事首页','index',0,NULL,10,860,2,0),(867,'组织','Dept',0,NULL,5,0,1,0),(868,'组织首页','index',0,NULL,10,867,2,0),(869,'岗位','Pst',0,NULL,2,0,1,0),(870,'岗位首页','index',0,NULL,1,869,2,0),(871,'基础资料','Basic',0,NULL,1000,0,1,0),(873,'枚举','enum',0,NULL,1,871,2,0),(874,'流程管理','F',0,NULL,900,0,1,0),(875,'后台','manage',0,NULL,10,874,2,0),(877,'协同','Fs',0,NULL,10,0,1,0),(878,'新增事项','newFlow',0,NULL,10,877,2,0),(879,'待办事项','notDone',0,NULL,20,877,2,0),(880,'已办事项','hasDone',0,NULL,30,877,2,0),(881,'已发事项','hasSend',0,NULL,40,877,2,0),(882,'流程节点管理','node',0,NULL,20,874,2,0),(883,'基础资料_ERP','ErpBase',0,NULL,800,0,1,0),(884,'计量单位','unit',0,NULL,50,883,2,0),(885,'存货档案','inventory',0,NULL,10,883,2,0),(886,'供应商档案','vendor',0,NULL,30,883,2,0),(887,'供应商档案','customer',0,NULL,40,883,2,0),(888,'基础资料分类','basicClass',0,NULL,100,883,2,0),(889,'采购','Purchase',0,NULL,100,0,1,0),(890,'采购订单','purchaseOrder',0,NULL,10,889,2,0),(892,'供应商价格表（新增）','vendorPriceJust',0,NULL,20,889,2,0),(893,'供应商价格表（列表）','vendorPriceJustList',0,NULL,30,889,2,0);

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
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

#
# Data for table "s_post"
#

INSERT INTO `s_post` VALUES (1,'人事专员',15,'职能类',1,1),(2,'行政专员',15,'职能类',0,21),(3,'行政助理',15,'职能类',1,3),(4,'普通员工',14,'营销类',1,4);

#
# Structure for table "s_role"
#

CREATE TABLE `s_role` (
  `id` smallint(6) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL,
  `status` tinyint(1) unsigned DEFAULT NULL,
  `remark` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=79 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

#
# Data for table "s_role"
#

INSERT INTO `s_role` VALUES (72,'测试组1',1,''),(73,'测试组2',1,''),(74,'测试组3',1,''),(75,'测试组4',1,''),(76,'测试组5',1,''),(77,'测试组6',1,''),(78,'人事专员',1,'');

#
# Structure for table "s_role_user"
#

CREATE TABLE `s_role_user` (
  `role_id` int(9) unsigned NOT NULL DEFAULT '0',
  `user_id` int(9) NOT NULL DEFAULT '0',
  KEY `group_id` (`role_id`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=FIXED;

#
# Data for table "s_role_user"
#

INSERT INTO `s_role_user` VALUES (77,180),(77,181),(77,182),(75,173),(75,184),(73,172),(74,172),(76,184),(77,184),(75,172),(76,179),(76,178),(77,177),(77,176),(77,175),(73,174),(72,182),(78,185),(74,186),(78,186);

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
# Data for table "s_subform-0101"
#


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
# Data for table "s_subform-0102"
#


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
# Data for table "s_subform-0103"
#


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
# Data for table "s_subform-0104"
#

INSERT INTO `s_subform-0104` VALUES (1,1670,1,'法师法师',26,'法法师',24),(2,1670,2,'法师法师',26,'法师法师',23);

#
# Structure for table "s_subform-0113"
#

CREATE TABLE `s_subform-0113` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `form_id` int(11) NOT NULL,
  `i007` int(4) DEFAULT '0',
  `i008` int(11) DEFAULT '0',
  `i009` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

#
# Data for table "s_subform-0113"
#


#
# Structure for table "s_subform-0114"
#

CREATE TABLE `s_subform-0114` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `form_id` int(11) NOT NULL,
  `i007` int(4) DEFAULT '0',
  `i008` int(11) DEFAULT '0',
  `i009` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

#
# Data for table "s_subform-0114"
#


#
# Structure for table "s_subform-0116"
#

CREATE TABLE `s_subform-0116` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `form_id` int(11) NOT NULL,
  `i007` int(4) DEFAULT '0',
  `i008` int(11) DEFAULT '0',
  `i009` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

#
# Data for table "s_subform-0116"
#


#
# Structure for table "s_subform-0117"
#

CREATE TABLE `s_subform-0117` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `flows_id` int(11) NOT NULL,
  `i006` int(4) DEFAULT '0',
  `i007` varchar(100) DEFAULT NULL,
  `i008` int(11) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=29 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

#
# Data for table "s_subform-0117"
#

INSERT INTO `s_subform-0117` VALUES (1,1672,1,'打车',2),(2,1672,2,'吃饭',3),(3,1673,1,'打车',2),(4,1673,2,'吃饭',3),(5,1674,1,'打车',2),(6,1674,2,'吃饭',3),(7,1675,1,'打车',2),(8,1675,2,'吃饭',3),(9,1676,1,'打车',2),(10,1676,2,'吃饭',3),(11,1677,1,'打车',2),(12,1677,2,'吃饭',3),(13,1678,1,'打车',2),(14,1678,2,'吃饭',3),(15,1679,1,'打车',2),(16,1679,2,'吃饭',3),(17,1680,1,'打车',2),(18,1680,2,'吃饭',3),(19,1681,1,'11',20),(20,1682,1,'11',20),(21,1682,2,'33',3),(22,1683,1,'fff',3),(23,1684,1,'fasf',3),(24,1685,1,'33',2),(25,1686,1,'33',2),(26,1687,1,'22',2),(27,1688,1,'fasfas',2),(28,1689,1,'fasfas',2);

#
# Structure for table "s_subform-0124"
#

CREATE TABLE `s_subform-0124` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `flows_id` int(11) NOT NULL DEFAULT '0',
  `i013` int(4) DEFAULT '0',
  `i014` varchar(255) DEFAULT NULL,
  `i015` int(11) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=21 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

#
# Data for table "s_subform-0124"
#

INSERT INTO `s_subform-0124` VALUES (1,1717,1,'rrwrwrwr',21),(2,1718,1,'aaaaaaaa',21),(3,1719,1,'aaaaaaa',23),(4,1720,1,'aaaaaaaa',21),(5,1720,2,'bbbbbbbbbb',23),(6,1721,1,'fafafasf',22),(7,1721,2,'fasfasfas',21),(8,1722,1,'1111111',21),(9,1723,1,'aaaaaaaaa',22),(10,1723,2,'bbbbbbbbbb',23),(11,1724,1,'aaa',22),(12,1725,1,'aaaaaaaaa',24),(13,1726,1,'111',21),(14,1727,1,'111',22),(15,1,1,'cafaf',22),(16,2,1,'fasfasfas',22),(17,3,1,'111',22),(18,4,1,'11',22),(19,5,1,'11',23),(20,103,1,'222',23);

#
# Structure for table "s_unit"
#

CREATE TABLE `s_unit` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(10) NOT NULL DEFAULT '',
  `sort` int(11) NOT NULL DEFAULT '0',
  `status` int(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

#
# Data for table "s_unit"
#

INSERT INTO `s_unit` VALUES (3,'个',33,1),(5,'公斤',2,1);

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

#
# Data for table "s_user"
#

INSERT INTO `s_user` VALUES (171,'admin','407de5e0d85a21d317de8def45fa331b','管理员','42686304@qq.com',NULL,'2020-06-09 14:16:12',1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(172,'0101004','123','王泉','','2020-03-05 12:53:27',NULL,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,',75,74,73,'),(173,'111','11','322','','2020-03-05 12:56:10',NULL,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(174,'11111','202cb962ac59075b964b07152d234b70','网啊','','2020-03-05 13:10:28',NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,',73,'),(175,'5555','182be0c5cdcd5072bb1864cdee4d3d6e','222','','2020-03-05 13:14:31',NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,',77,'),(176,'1111','f1c1592588411002af340cbaedd6fc33','222','','2020-03-05 13:16:24','2020-04-02 10:07:32',1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,',77,'),(177,'111111','182be0c5cdcd5072bb1864cdee4d3d6e','222','','2020-03-05 13:16:52',NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,',77,'),(178,'11111155','182be0c5cdcd5072bb1864cdee4d3d6e','222','','2020-03-05 13:17:32',NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,',76,'),(179,'99999','310dcbbf4cce62f762a2aaa148d556bd','111','','2020-03-05 14:32:26',NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,',76,'),(180,'666','fae0b27c451c728867a567e8c1bb4e53','666','','2020-03-05 14:32:54',NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,',77,'),(181,'777','f1c1592588411002af340cbaedd6fc33','777','','2020-03-05 14:33:44','2020-04-01 21:02:45',1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,',77,'),(182,'010100','202cb962ac59075b964b07152d234b70','王泉','','2020-03-05 14:34:24','2020-06-07 09:37:55',1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,',72,77,'),(184,'052213','202cb962ac59075b964b07152d234b70','赵四','','2020-03-06 19:00:40',NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,',77,76,75,'),(185,'010099','202cb962ac59075b964b07152d234b70','刘德华','','2020-04-02 07:52:43','2020-06-05 20:24:18',1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,',78,'),(186,'010097','202cb962ac59075b964b07152d234b70','郭富城','','2020-04-02 13:52:39','2020-05-21 15:38:41',1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,',74,78,');

#
# Structure for table "s_vendor"
#

CREATE TABLE `s_vendor` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(255) NOT NULL DEFAULT '',
  `name` varchar(255) NOT NULL DEFAULT '',
  `contact` varchar(255) NOT NULL DEFAULT '',
  `phone` varchar(255) NOT NULL DEFAULT '',
  `email` varchar(255) NOT NULL DEFAULT '',
  `tel` varchar(255) NOT NULL DEFAULT '',
  `fax` varchar(255) NOT NULL DEFAULT '',
  `address` varchar(255) NOT NULL DEFAULT '',
  `basic_class_id` int(11) NOT NULL DEFAULT '0',
  `maker` varchar(255) NOT NULL DEFAULT '',
  `create_date` date DEFAULT NULL,
  `modify_date` date DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `code` (`code`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

#
# Data for table "s_vendor"
#

INSERT INTO `s_vendor` VALUES (5,'0101001','南京多云科技有限公司','王多云','18951954522','55353@qq.com','141515','2424','南京市将军路15号',9,'管理员','2020-05-12',NULL),(6,'0101002','南京市爱香机械制造有限公司','张大连','13912934532','fasfs@daxiang.com','25255252','97979797','南京市玄武区南陵路110号',9,'管理员','2020-05-12',NULL),(7,'0102001','徐州大埠岗加工中心','李丽','12559867531','511156362@qq.com','525262621','579257927','徐州市大厂区东陵路992号',22,'管理员','2020-05-12',NULL);

#
# Structure for table "s_vendor_price"
#

CREATE TABLE `s_vendor_price` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `vendor_code` varchar(255) DEFAULT NULL,
  `inventory_code` varchar(255) DEFAULT NULL,
  `price` decimal(10,3) DEFAULT NULL,
  `tax` int(3) DEFAULT NULL,
  `tax_price` decimal(10,3) DEFAULT NULL,
  `maker` varchar(255) DEFAULT NULL,
  `create_time` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=19 DEFAULT CHARSET=utf8;

#
# Data for table "s_vendor_price"
#

INSERT INTO `s_vendor_price` VALUES (13,'0101001','00002',1.000,13,1.130,'管理员','2020-05-21 09:46:36'),(14,'0101002','01000144',2.000,13,2.260,'管理员','2020-05-21 09:46:36'),(17,'0101002','00002',4.000,13,4.520,'管理员','2020-05-22 11:04:55'),(18,'0101001','00001',4.000,13,4.520,'管理员','2020-05-22 11:04:55');

#
# Structure for table "s_vendor_price_just"
#

CREATE TABLE `s_vendor_price_just` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date` date DEFAULT NULL,
  `maker` varchar(255) DEFAULT NULL,
  `maker_number` varchar(255) DEFAULT NULL,
  `status` int(1) NOT NULL DEFAULT '0',
  `ddh` varchar(255) DEFAULT NULL,
  `remark` varchar(255) DEFAULT NULL,
  `flow_id` int(11) NOT NULL DEFAULT '0',
  `create_time` int(11) DEFAULT NULL,
  `update_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=255 DEFAULT CHARSET=utf8;

#
# Data for table "s_vendor_price_just"
#

INSERT INTO `s_vendor_price_just` VALUES (26,'2020-05-20','管理员','admin',9,'00000026','',98,NULL,NULL),(174,'2020-05-21','刘德华','010099',9,'00000174','',106,NULL,NULL),(215,'2020-05-21','管理员','admin',9,'00000215','',0,1590109262,1590109374),(216,'2020-05-21','管理员','admin',9,'00000216','',0,1590109483,1590116695),(254,'2020-06-05','管理员','admin',5,'00000254','',114,1591359965,1591359965);

#
# Structure for table "s_vendor_price_just_history"
#

CREATE TABLE `s_vendor_price_just_history` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `vendor_code` varchar(255) DEFAULT NULL,
  `inventory_code` varchar(255) DEFAULT NULL,
  `price` decimal(10,3) DEFAULT NULL,
  `tax` int(3) DEFAULT NULL,
  `tax_price` decimal(10,2) DEFAULT NULL,
  `maker` varchar(255) DEFAULT NULL,
  `create_datetime` datetime DEFAULT NULL,
  `origin_price` decimal(10,3) DEFAULT NULL,
  `origin_tax` int(3) DEFAULT NULL,
  `origin_tax_price` decimal(10,2) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

#
# Data for table "s_vendor_price_just_history"
#

INSERT INTO `s_vendor_price_just_history` VALUES (1,'0101001','00002',1.000,13,1.13,'管理员','2020-05-20 16:06:07',NULL,NULL,NULL),(2,'0101002','01000144',2.000,13,2.26,'管理员','2020-05-20 16:06:07',NULL,NULL,NULL),(3,'0101001','00002',1.000,13,1.13,'管理员','2020-05-20 16:06:47',0.000,0,0.00),(4,'0101002','01000144',2.000,13,2.26,'管理员','2020-05-20 16:06:47',0.000,0,0.00),(5,'0101001','00002',1.000,13,1.13,'管理员','2020-05-21 09:46:36',0.000,0,0.00),(6,'0101002','01000144',2.000,13,2.26,'管理员','2020-05-21 09:46:36',0.000,0,0.00),(7,'0101002','00002',2.000,13,2.26,'刘德华','2020-05-21 15:38:45',0.000,0,0.00),(8,'0101002','00002',44.000,13,49.72,'管理员','2020-05-22 09:02:54',0.000,0,0.00),(9,'0101002','00002',4.000,13,4.52,'管理员','2020-05-22 11:04:55',0.000,0,0.00),(10,'0101001','00001',4.000,13,4.52,'管理员','2020-05-22 11:04:55',0.000,0,0.00);

#
# Structure for table "s_vendor_price_just_list"
#

CREATE TABLE `s_vendor_price_just_list` (
  `listid` int(11) NOT NULL AUTO_INCREMENT,
  `id` int(11) DEFAULT NULL,
  `vendor_code` varchar(255) DEFAULT NULL,
  `inventory_code` varchar(255) DEFAULT NULL,
  `origin_price` decimal(10,3) DEFAULT NULL,
  `origin_tax` int(10) DEFAULT NULL,
  `origin_tax_price` decimal(10,3) DEFAULT NULL,
  `price` decimal(10,3) DEFAULT NULL,
  `tax` int(3) DEFAULT NULL,
  `tax_price` decimal(10,3) DEFAULT NULL,
  PRIMARY KEY (`listid`)
) ENGINE=InnoDB AUTO_INCREMENT=98 DEFAULT CHARSET=utf8;

#
# Data for table "s_vendor_price_just_list"
#

INSERT INTO `s_vendor_price_just_list` VALUES (11,26,'0101001','00002',0.000,0,0.000,1.000,13,1.130),(12,26,'0101002','01000144',0.000,0,0.000,2.000,13,2.260),(27,174,'0101002','00002',0.000,0,0.000,2.000,13,2.260),(63,215,'0101002','00002',0.000,0,0.000,44.000,13,49.720),(64,216,'0101002','00002',0.000,0,0.000,4.000,13,4.520),(68,216,'0101001','00001',0.000,0,0.000,4.000,13,4.520),(97,254,'0101002','00002',4.000,13,4.520,233.000,13,263.290);
