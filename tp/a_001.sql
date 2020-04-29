# Host: 192.168.3.3  (Version 8.0.12)
# Date: 2020-04-28 17:25:01
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

INSERT INTO `s_access` VALUES (NULL,'adduser','hr',176,862),(NULL,'index','hr',176,861),(74,'edituser','hr',NULL,865),(74,'index','hr',NULL,861),(74,'dltuser','hr',NULL,866);

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
) ENGINE=MyISAM AUTO_INCREMENT=15 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

#
# Data for table "s_department_attr"
#

INSERT INTO `s_department_attr` VALUES (7,3,2,21,'郭富城'),(8,3,1,4,'王泉'),(12,2,2,21,'郭富城'),(13,2,1,3,'王泉'),(14,2,1,21,'郭富城');

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
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=29 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

#
# Data for table "s_flow"
#

INSERT INTO `s_flow` VALUES (6,'我的标题','2020-04-12 11:37:03','2020-04-12 11:50:37',NULL,NULL,'{\"creator\":{\"S\":\"n\",\"X\":{},\"D\":0},\"end\":{\"S\":\"n\",\"X\":{},\"D\":0},\"f\":{\"S\":\"p\",\"D\":0},\"id0\":{\"S\":\"p\",\"D\":0},\"id1\":{\"T\":\"P\",\"K\":\"010099\",\"V\":\"刘德华\",\"S\":\"n\",\"Z\":1,\"C\":1,\"D\":0},\"id2\":{\"T\":\"P\",\"K\":\"010097\",\"V\":\"郭富城\",\"S\":\"n\",\"Z\":1,\"C\":1,\"D\":0}}','{\"creator\":[\"id0\"],\"f\":[\"end\"],\"id0\":[\"id1\",\"id2\"],\"id1\":[\"f\"],\"id2\":[\"f\"]}',3,NULL,'<table class=\"table-form table noselect\" style=\"margin:auto;width:601px\" data-index=\"0\" data-table=\"form-0117\"><tbody><tr><td style=\"text-align: center; vertical-align: middle; max-width: 588px; min-width: 588px; font-size: 12px; font-weight: 400; color: rgb(51, 51, 51); background: rgb(255, 255, 255) none repeat scroll 0% 0%;\" colspan=\"6\" rowspan=\"1\" data-x=\"0\" data-y=\"0\" data-type=\"text\" class=\"\">我的标题</td></tr><tr><td style=\"text-align: center; vertical-align: middle; max-width: 98px; min-width: 98px; font-size: 12px; font-weight: 400; color: rgb(51, 51, 51); background: rgb(255, 255, 255) none repeat scroll 0% 0%;\" colspan=\"1\" rowspan=\"1\" data-x=\"0\" data-y=\"1\" data-type=\"text\" class=\"\">姓名</td><td style=\"text-align: center; vertical-align: middle; max-width: 98px; min-width: 98px; font-size: 12px; font-weight: 400; color: rgb(51, 51, 51); background: rgb(255, 255, 255) none repeat scroll 0% 0%;\" colspan=\"1\" rowspan=\"1\" data-x=\"1\" data-y=\"1\" data-type=\"input\" class=\"\" data-attr=\"姓名\" data-i=\"i001\"><input readonly=\"\" noselect=\"\" type=\"text\" class=\"aya-input form-input\"></td><td style=\"text-align: center; vertical-align: middle; max-width: 98px; min-width: 98px; font-size: 12px; font-weight: 400; color: rgb(51, 51, 51); background: rgb(255, 255, 255) none repeat scroll 0% 0%;\" colspan=\"1\" rowspan=\"1\" data-x=\"2\" data-y=\"1\" data-type=\"text\" class=\"\">部门</td><td style=\"text-align: center; vertical-align: middle; max-width: 98px; min-width: 98px; font-size: 12px; font-weight: 400; color: rgb(51, 51, 51); background: rgb(255, 255, 255) none repeat scroll 0% 0%;\" colspan=\"1\" rowspan=\"1\" data-x=\"3\" data-y=\"1\" data-type=\"input\" class=\"\" data-attr=\"部门\" data-i=\"i002\"><input readonly=\"\" noselect=\"\" type=\"text\" class=\"aya-input form-input\"></td><td style=\"text-align: center; vertical-align: middle; max-width: 98px; min-width: 98px; font-size: 12px; font-weight: 400; color: rgb(51, 51, 51); background: rgb(255, 255, 255) none repeat scroll 0% 0%;\" colspan=\"1\" rowspan=\"1\" data-x=\"4\" data-y=\"1\" data-type=\"text\" class=\"\">岗位</td><td style=\"text-align: center; vertical-align: middle; max-width: 98px; min-width: 98px; font-size: 12px; font-weight: 400; color: rgb(51, 51, 51); background: rgb(255, 255, 255) none repeat scroll 0% 0%;\" colspan=\"1\" rowspan=\"1\" data-x=\"5\" data-y=\"1\" data-type=\"input\" class=\"\" data-attr=\"岗位\" data-i=\"i003\"><input readonly=\"\" noselect=\"\" type=\"text\" class=\"aya-input form-input\"></td></tr><tr><td style=\"text-align: center; vertical-align: middle; max-width: 98px; min-width: 98px; font-size: 12px; font-weight: 400; color: rgb(51, 51, 51); background: rgb(255, 255, 255) none repeat scroll 0% 0%;\" colspan=\"1\" rowspan=\"1\" data-x=\"0\" data-y=\"2\" data-type=\"text\" class=\"\">最爱吃的</td><td style=\"text-align: center; vertical-align: middle; max-width: 196px; min-width: 196px; font-size: 12px; font-weight: 400; color: rgb(51, 51, 51); background: rgb(255, 255, 255) none repeat scroll 0% 0%;\" colspan=\"2\" rowspan=\"1\" data-x=\"1\" data-y=\"2\" data-type=\"checkbox\" class=\"\">蔬菜 <input data-i=\"i004\" data-name=\"蔬菜\" type=\"checkbox\" class=\"aya-checkbox\" style=\"margin-right:24px\"> 水果 <input data-i=\"i005\" data-name=\"水果\" type=\"checkbox\" class=\"aya-checkbox\"> </td><td style=\"text-align: center; vertical-align: middle; max-width: 98px; min-width: 98px; font-size: 12px; font-weight: 400; color: rgb(51, 51, 51); background: rgb(255, 255, 255) none repeat scroll 0% 0%;\" colspan=\"1\" rowspan=\"1\" data-x=\"3\" data-y=\"2\" data-type=\"text\" class=\"\">交通工具</td><td style=\"text-align: center; vertical-align: middle; max-width: 196px; min-width: 196px; font-size: 12px; font-weight: 400; color: rgb(51, 51, 51); background: rgb(255, 255, 255) none repeat scroll 0% 0%;\" colspan=\"2\" rowspan=\"1\" data-x=\"4\" data-y=\"2\" data-type=\"select\" class=\"\" data-select=\"32\" data-name=\"交通工具\" data-i=\"i006\"><select class=\"browser-default\"><option>交通工具</option></select></td></tr><tr><td style=\"text-align: center; vertical-align: middle; max-width: 588px; min-width: 588px;\" colspan=\"6\" rowspan=\"1\" data-x=\"0\" data-y=\"3\" data-type=\"text\" class=\"\"><table class=\"table-mul\" data-table=\"subform-0114\"><thead><tr><th>序号</th><th>第一列</th><th>第二列</th></tr></thead><tbody><tr><td data-type=\"index-mul\" data-i=\"i007\">序号</td><td data-type=\"select-mul\" data-select=\"3\" data-i=\"i008\"><select class=\"browser-default\"><option value=\"3\">付款类型</option></select></td><td data-type=\"text-mul\" data-i=\"i009\"><input type=\"text\" class=\"aya-input\"></td></tr></tbody></table></td></tr><tr><td style=\"text-align:center;vertical-align:middle;max-width:98px;min-width:98px\" colspan=\"1\" rowspan=\"1\" data-x=\"0\" data-y=\"4\" data-type=\"text\"></td><td style=\"text-align:center;vertical-align:middle;max-width:98px;min-width:98px\" colspan=\"1\" rowspan=\"1\" data-x=\"1\" data-y=\"4\" data-type=\"text\"></td><td style=\"text-align:center;vertical-align:middle;max-width:98px;min-width:98px\" colspan=\"1\" rowspan=\"1\" data-x=\"2\" data-y=\"4\" data-type=\"text\"></td><td style=\"text-align:center;vertical-align:middle;max-width:98px;min-width:98px\" colspan=\"1\" rowspan=\"1\" data-x=\"3\" data-y=\"4\" data-type=\"text\"></td><td style=\"text-align:center;vertical-align:middle;max-width:98px;min-width:98px\" colspan=\"1\" rowspan=\"1\" data-x=\"4\" data-y=\"4\" data-type=\"text\"></td><td style=\"text-align:center;vertical-align:middle;max-width:98px;min-width:98px\" colspan=\"1\" rowspan=\"1\" data-x=\"5\" data-y=\"4\" data-type=\"text\"></td></tr><tr><td style=\"text-align:center;vertical-align:middle;max-width:98px;min-width:98px\" colspan=\"1\" rowspan=\"1\" data-x=\"0\" data-y=\"5\" data-type=\"text\"></td><td style=\"text-align:center;vertical-align:middle;max-width:98px;min-width:98px\" colspan=\"1\" rowspan=\"1\" data-x=\"1\" data-y=\"5\" data-type=\"text\"></td><td style=\"text-align:center;vertical-align:middle;max-width:98px;min-width:98px\" colspan=\"1\" rowspan=\"1\" data-x=\"2\" data-y=\"5\" data-type=\"text\"></td><td style=\"text-align:center;vertical-align:middle;max-width:98px;min-width:98px\" colspan=\"1\" rowspan=\"1\" data-x=\"3\" data-y=\"5\" data-type=\"text\"></td><td style=\"text-align:center;vertical-align:middle;max-width:98px;min-width:98px\" colspan=\"1\" rowspan=\"1\" data-x=\"4\" data-y=\"5\" data-type=\"text\"></td><td style=\"text-align:center;vertical-align:middle;max-width:98px;min-width:98px\" colspan=\"1\" rowspan=\"1\" data-x=\"5\" data-y=\"5\" data-type=\"text\"></td></tr></tbody></table>','管理员',1,'{\"0\":{\"0\":98,\"1\":98,\"2\":98,\"3\":98,\"4\":98,\"5\":98}}',0,'<table class=\"table-form table noselect\" style=\"margin:auto;width:601px\" data-index=\"0\" data-table=\"form-0117\"><tbody><tr><td style=\"  max-width: 588px; min-width: 588px; font-size: 12px; font-weight: 400; color: rgb(51, 51, 51); \" colspan=\"6\"    data-type=\"text\" >我的标题</td></tr><tr><td style=\"  max-width: 98px; min-width: 98px; font-size: 12px; font-weight: 400; color: rgb(51, 51, 51); \"     data-type=\"text\" >姓名</td><td style=\"  max-width: 98px; min-width: 98px; font-size: 12px; font-weight: 400; color: rgb(51, 51, 51); \"     data-type=\"input\"  data-attr=\"姓名\" data-i=\"i001\"><input readonly=\"\" noselect=\"\" type=\"text\" class=\"aya-input form-input\"></td><td style=\"  max-width: 98px; min-width: 98px; font-size: 12px; font-weight: 400; color: rgb(51, 51, 51); \"     data-type=\"text\" >部门</td><td style=\"  max-width: 98px; min-width: 98px; font-size: 12px; font-weight: 400; color: rgb(51, 51, 51); \"     data-type=\"input\"  data-attr=\"部门\" data-i=\"i002\"><input readonly=\"\" noselect=\"\" type=\"text\" class=\"aya-input form-input\"></td><td style=\"  max-width: 98px; min-width: 98px; font-size: 12px; font-weight: 400; color: rgb(51, 51, 51); \"     data-type=\"text\" >岗位</td><td style=\"  max-width: 98px; min-width: 98px; font-size: 12px; font-weight: 400; color: rgb(51, 51, 51); \"     data-type=\"input\"  data-attr=\"岗位\" data-i=\"i003\"><input readonly=\"\" noselect=\"\" type=\"text\" class=\"aya-input form-input\"></td></tr><tr><td style=\"  max-width: 98px; min-width: 98px; font-size: 12px; font-weight: 400; color: rgb(51, 51, 51); \"     data-type=\"text\" >最爱吃的</td><td style=\"  max-width: 196px; min-width: 196px; font-size: 12px; font-weight: 400; color: rgb(51, 51, 51); \" colspan=\"2\"    data-type=\"checkbox\" >蔬菜 <input data-i=\"i004\" data-name=\"蔬菜\" type=\"checkbox\" class=\"aya-checkbox\" style=\"margin-right:24px\"> 水果 <input data-i=\"i005\" data-name=\"水果\" type=\"checkbox\" class=\"aya-checkbox\"> </td><td style=\"  max-width: 98px; min-width: 98px; font-size: 12px; font-weight: 400; color: rgb(51, 51, 51); \"     data-type=\"text\" >交通工具</td><td style=\"  max-width: 196px; min-width: 196px; font-size: 12px; font-weight: 400; color: rgb(51, 51, 51); \" colspan=\"2\"    data-type=\"select\"  data-select=\"32\" data-name=\"交通工具\" data-i=\"i006\"><select class=\"browser-default\"><option>交通工具</option></select></td></tr><tr><td style=\"  max-width: 588px; min-width: 588px;\" colspan=\"6\"    data-type=\"text\" ><table class=\"table-mul\" data-table=\"subform-0114\"><thead><tr><th>序号</th><th>第一列</th><th>第二列</th></tr></thead><tbody><tr><td data-type=\"index-mul\" data-i=\"i007\">序号</td><td data-type=\"select-mul\" data-select=\"3\" data-i=\"i008\"><select class=\"browser-default\"><option value=\"3\">付款类型</option></select></td><td data-type=\"text-mul\" data-i=\"i009\"><input type=\"text\" class=\"aya-input\"></td></tr></tbody></table></td></tr><tr><td style=\"max-width:98px;min-width:98px\"     data-type=\"text\"></td><td style=\"max-width:98px;min-width:98px\"     data-type=\"text\"></td><td style=\"max-width:98px;min-width:98px\"     data-type=\"text\"></td><td style=\"max-width:98px;min-width:98px\"     data-type=\"text\"></td><td style=\"max-width:98px;min-width:98px\"     data-type=\"text\"></td><td style=\"max-width:98px;min-width:98px\"     data-type=\"text\"></td></tr><tr><td style=\"max-width:98px;min-width:98px\"     data-type=\"text\"></td><td style=\"max-width:98px;min-width:98px\"     data-type=\"text\"></td><td style=\"max-width:98px;min-width:98px\"     data-type=\"text\"></td><td style=\"max-width:98px;min-width:98px\"     data-type=\"text\"></td><td style=\"max-width:98px;min-width:98px\"     data-type=\"text\"></td><td style=\"max-width:98px;min-width:98px\"     data-type=\"text\"></td></tr></tbody></table>'),(8,'测试标题','2020-04-13 09:53:09','2020-04-18 10:02:21',NULL,NULL,'{\"creator\":{\"S\":\"n\",\"X\":{},\"D\":0},\"end\":{\"S\":\"n\",\"X\":{},\"D\":0},\"f\":{\"S\":\"p\",\"D\":0},\"id3\":{\"S\":\"p\",\"D\":0},\"id4\":{\"T\":\"P\",\"K\":\"010099\",\"V\":\"刘德华\",\"S\":\"n\",\"Z\":1,\"C\":1,\"D\":0},\"id5\":{\"S\":\"p\",\"D\":0},\"id6\":{\"T\":\"P\",\"K\":\"010097\",\"V\":\"郭富城\",\"S\":\"n\",\"Z\":1,\"X\":[[\"\",\"i002\",\"0\",\"\",\"\"]],\"C\":\"3\",\"D\":0},\"id7\":{\"T\":\"P\",\"K\":\"010099\",\"V\":\"刘德华\",\"S\":\"n\",\"Z\":1,\"X\":[[\"\",\"i002\",\"1\",\"\",\"&&\"],[\"\",\"i001\",\"1\",\"\",\"\"]],\"C\":\"3\",\"D\":0}}','{\"creator\":[\"id3\"],\"f\":[\"end\"],\"id3\":[\"id4\"],\"id4\":[\"id5\"],\"id5\":[\"id6\",\"id7\"],\"id6\":[\"f\"],\"id7\":[\"f\"]}',8,NULL,'<table class=\"table-form table noselect\" style=\"margin:auto;width:601px\" data-index=\"0\" data-table=\"form-0120\"><tbody><tr><td style=\"text-align: center; vertical-align: middle; max-width: 588px; min-width: 588px; font-size: 12px; font-weight: 400; color: rgb(51, 51, 51); background: rgb(255, 255, 255) none repeat scroll 0% 0%;\" colspan=\"6\" rowspan=\"1\" data-x=\"0\" data-y=\"0\" data-type=\"text\" class=\"border-top-none border-left-none border-right-none border-bottom-none\">测试标题</td></tr><tr><td style=\"text-align: center; vertical-align: middle; max-width: 98px; min-width: 98px; font-size: 12px; font-weight: 400; color: rgb(51, 51, 51); background: rgb(255, 255, 255) none repeat scroll 0% 0%;\" colspan=\"1\" rowspan=\"1\" data-x=\"0\" data-y=\"1\" data-type=\"text\" class=\"\">姓名</td><td style=\"text-align: center; vertical-align: middle; max-width: 98px; min-width: 98px; font-size: 12px; font-weight: 400; color: rgb(51, 51, 51); background: rgb(255, 255, 255) none repeat scroll 0% 0%;\" colspan=\"1\" rowspan=\"1\" data-x=\"1\" data-y=\"1\" data-type=\"input\" class=\"\" data-attr=\"姓名\" data-i=\"i009\"><input readonly=\"\" noselect=\"\" type=\"text\" class=\"aya-input form-input\"></td><td style=\"text-align: center; vertical-align: middle; max-width: 98px; min-width: 98px; font-size: 12px; font-weight: 400; color: rgb(51, 51, 51); background: rgb(255, 255, 255) none repeat scroll 0% 0%;\" colspan=\"1\" rowspan=\"1\" data-x=\"2\" data-y=\"1\" data-type=\"text\" class=\"\">部门</td><td style=\"text-align: center; vertical-align: middle; max-width: 98px; min-width: 98px; font-size: 12px; font-weight: 400; color: rgb(51, 51, 51); background: rgb(255, 255, 255) none repeat scroll 0% 0%;\" colspan=\"1\" rowspan=\"1\" data-x=\"3\" data-y=\"1\" data-type=\"input\" class=\"\" data-attr=\"部门\" data-i=\"i010\"><input readonly=\"\" noselect=\"\" type=\"text\" class=\"aya-input form-input\"></td><td style=\"text-align: center; vertical-align: middle; max-width: 98px; min-width: 98px; font-size: 12px; font-weight: 400; color: rgb(51, 51, 51); background: rgb(255, 255, 255) none repeat scroll 0% 0%;\" colspan=\"1\" rowspan=\"1\" data-x=\"4\" data-y=\"1\" data-type=\"text\" class=\"\">岗位</td><td style=\"text-align: center; vertical-align: middle; max-width: 98px; min-width: 98px; font-size: 12px; font-weight: 400; color: rgb(51, 51, 51); background: rgb(255, 255, 255) none repeat scroll 0% 0%;\" colspan=\"1\" rowspan=\"1\" data-x=\"5\" data-y=\"1\" data-type=\"input\" class=\"\" data-attr=\"岗位\" data-i=\"i011\"><input readonly=\"\" noselect=\"\" type=\"text\" class=\"aya-input form-input\"></td></tr><tr><td style=\"text-align: center; vertical-align: middle; max-width: 98px; min-width: 98px; font-size: 12px; font-weight: 400; color: rgb(51, 51, 51); background: rgb(255, 255, 255) none repeat scroll 0% 0%;\" colspan=\"1\" rowspan=\"1\" data-x=\"0\" data-y=\"2\" data-type=\"text\" class=\"\">最爱的食物</td><td style=\"text-align: center; vertical-align: middle; max-width: 196px; min-width: 196px; font-size: 12px; font-weight: 400; color: rgb(51, 51, 51); background: rgb(255, 255, 255) none repeat scroll 0% 0%;\" colspan=\"2\" rowspan=\"1\" data-x=\"1\" data-y=\"2\" data-type=\"checkbox\" class=\"\">水果 <input data-i=\"i001\" data-name=\"水果\" type=\"checkbox\" class=\"aya-checkbox\" style=\"margin-right:24px\"> 海鲜 <input data-i=\"i002\" data-name=\"海鲜\" type=\"checkbox\" class=\"aya-checkbox\"> </td><td style=\"text-align: center; vertical-align: middle; max-width: 98px; min-width: 98px; font-size: 12px; font-weight: 400; color: rgb(51, 51, 51); background: rgb(255, 255, 255) none repeat scroll 0% 0%;\" colspan=\"1\" rowspan=\"1\" data-x=\"3\" data-y=\"2\" data-type=\"text\" class=\"\">最爱的运动</td><td style=\"text-align: center; vertical-align: middle; max-width: 196px; min-width: 196px; font-size: 12px; font-weight: 400; color: rgb(51, 51, 51); background: rgb(255, 255, 255) none repeat scroll 0% 0%;\" colspan=\"2\" rowspan=\"1\" data-x=\"4\" data-y=\"2\" data-type=\"radio\" class=\"\"><p style=\"display:inline-block\">足球 <input data-i=\"i003\" name=\"r1586742723486\" data-name=\"足球\" type=\"radio\" class=\"aya-radio\" style=\"margin-right:24px\"></p> <p style=\"display:inline-block\">乒乓球 <input data-i=\"i004\" name=\"r1586742723486\" data-name=\"乒乓球\" type=\"radio\" class=\"aya-radio\" style=\"margin-right:24px\"></p> </td></tr><tr><td style=\"text-align: center; vertical-align: middle; max-width: 98px; min-width: 98px; font-size: 12px; font-weight: 400; color: rgb(51, 51, 51); background: rgb(255, 255, 255) none repeat scroll 0% 0%;\" colspan=\"1\" rowspan=\"1\" data-x=\"0\" data-y=\"3\" data-type=\"text\" class=\"\">交通工具</td><td style=\"text-align: center; vertical-align: middle; max-width: 196px; min-width: 196px; font-size: 12px; font-weight: 400; color: rgb(51, 51, 51); background: rgb(255, 255, 255) none repeat scroll 0% 0%;\" colspan=\"2\" rowspan=\"1\" data-x=\"1\" data-y=\"3\" data-type=\"select\" class=\"\" data-select=\"32\" data-name=\"交通工具\" data-i=\"i005\"><select class=\"browser-default\"><option>交通工具</option></select></td><td style=\"text-align:center;vertical-align:middle;max-width:98px;min-width:98px\" colspan=\"1\" rowspan=\"1\" data-x=\"3\" data-y=\"3\" data-type=\"text\"></td><td style=\"text-align:center;vertical-align:middle;max-width:98px;min-width:98px\" colspan=\"1\" rowspan=\"1\" data-x=\"4\" data-y=\"3\" data-type=\"text\"></td><td style=\"text-align:center;vertical-align:middle;max-width:98px;min-width:98px\" colspan=\"1\" rowspan=\"1\" data-x=\"5\" data-y=\"3\" data-type=\"text\"></td></tr><tr><td style=\"text-align: center; vertical-align: middle; max-width: 588px; min-width: 588px;\" colspan=\"6\" rowspan=\"1\" data-x=\"0\" data-y=\"4\" data-type=\"text\" class=\"\"><table class=\"table-mul\" data-table=\"subform-0117\"><thead><tr><th>序号</th><th>项目名称</th><th>付款类型</th></tr></thead><tbody><tr><td data-type=\"index-mul\" data-i=\"i006\" style=\"min-width: 0px; max-width: 0px;\">序号</td><td data-type=\"text-mul\" data-i=\"i007\" style=\"min-width: 0px; max-width: 0px;\"><input type=\"text\" class=\"aya-input\"></td><td data-type=\"select-mul\" data-select=\"3\" data-i=\"i008\" style=\"min-width: 0px; max-width: 0px;\"><select class=\"browser-default\"><option value=\"3\">付款类型</option></select></td></tr></tbody></table></td></tr><tr><td style=\"text-align: center; vertical-align: middle; max-width: 588px; min-width: 588px; font-size: 12px; font-weight: 400; color: rgb(51, 51, 51); background: rgb(255, 255, 255) none repeat scroll 0% 0%;\" colspan=\"6\" rowspan=\"1\" data-x=\"0\" data-y=\"5\" data-type=\"text\" class=\"border-top-none border-left-none border-right-none\">11</td></tr></tbody></table>','管理员',1,'{\"0\":{\"0\":98,\"1\":98,\"2\":98,\"3\":98,\"4\":98,\"5\":98}}',0,'<table class=\"table-form table noselect\" style=\"margin:auto;width:601px\" data-index=\"0\" data-table=\"form-0120\"><tbody><tr><td style=\"  max-width: 588px; min-width: 588px; font-size: 12px; font-weight: 400; color: rgb(51, 51, 51); \" colspan=\"6\"    data-type=\"text\" class=\"border-top-none border-left-none border-right-none border-bottom-none\">测试标题</td></tr><tr><td style=\"  max-width: 98px; min-width: 98px; font-size: 12px; font-weight: 400; color: rgb(51, 51, 51); \"     data-type=\"text\" >姓名</td><td style=\"  max-width: 98px; min-width: 98px; font-size: 12px; font-weight: 400; color: rgb(51, 51, 51); \"     data-type=\"input\"  data-attr=\"姓名\" data-i=\"i009\"><input readonly=\"\" noselect=\"\" type=\"text\" class=\"aya-input form-input\"></td><td style=\"  max-width: 98px; min-width: 98px; font-size: 12px; font-weight: 400; color: rgb(51, 51, 51); \"     data-type=\"text\" >部门</td><td style=\"  max-width: 98px; min-width: 98px; font-size: 12px; font-weight: 400; color: rgb(51, 51, 51); \"     data-type=\"input\"  data-attr=\"部门\" data-i=\"i010\"><input readonly=\"\" noselect=\"\" type=\"text\" class=\"aya-input form-input\"></td><td style=\"  max-width: 98px; min-width: 98px; font-size: 12px; font-weight: 400; color: rgb(51, 51, 51); \"     data-type=\"text\" >岗位</td><td style=\"  max-width: 98px; min-width: 98px; font-size: 12px; font-weight: 400; color: rgb(51, 51, 51); \"     data-type=\"input\"  data-attr=\"岗位\" data-i=\"i011\"><input readonly=\"\" noselect=\"\" type=\"text\" class=\"aya-input form-input\"></td></tr><tr><td style=\"  max-width: 98px; min-width: 98px; font-size: 12px; font-weight: 400; color: rgb(51, 51, 51); \"     data-type=\"text\" >最爱的食物</td><td style=\"  max-width: 196px; min-width: 196px; font-size: 12px; font-weight: 400; color: rgb(51, 51, 51); \" colspan=\"2\"    data-type=\"checkbox\" >水果 <input data-i=\"i001\" data-name=\"水果\" type=\"checkbox\" class=\"aya-checkbox\" style=\"margin-right:24px\"> 海鲜 <input data-i=\"i002\" data-name=\"海鲜\" type=\"checkbox\" class=\"aya-checkbox\"> </td><td style=\"  max-width: 98px; min-width: 98px; font-size: 12px; font-weight: 400; color: rgb(51, 51, 51); \"     data-type=\"text\" >最爱的运动</td><td style=\"  max-width: 196px; min-width: 196px; font-size: 12px; font-weight: 400; color: rgb(51, 51, 51); \" colspan=\"2\"    data-type=\"radio\" ><p style=\"display:inline-block\">足球 <input data-i=\"i003\" name=\"r1586742723486\" data-name=\"足球\" type=\"radio\" class=\"aya-radio\" style=\"margin-right:24px\"></p> <p style=\"display:inline-block\">乒乓球 <input data-i=\"i004\" name=\"r1586742723486\" data-name=\"乒乓球\" type=\"radio\" class=\"aya-radio\" style=\"margin-right:24px\"></p> </td></tr><tr><td style=\"  max-width: 98px; min-width: 98px; font-size: 12px; font-weight: 400; color: rgb(51, 51, 51); \"     data-type=\"text\" >交通工具</td><td style=\"  max-width: 196px; min-width: 196px; font-size: 12px; font-weight: 400; color: rgb(51, 51, 51); \" colspan=\"2\"    data-type=\"select\"  data-select=\"32\" data-name=\"交通工具\" data-i=\"i005\"><select class=\"browser-default\"><option>交通工具</option></select></td><td style=\"max-width:98px;min-width:98px\"     data-type=\"text\"></td><td style=\"max-width:98px;min-width:98px\"     data-type=\"text\"></td><td style=\"max-width:98px;min-width:98px\"     data-type=\"text\"></td></tr><tr><td style=\"  max-width: 588px; min-width: 588px;\" colspan=\"6\"    data-type=\"text\" ><table class=\"table-mul\" data-table=\"subform-0117\"><thead><tr><th>序号</th><th>项目名称</th><th>付款类型</th></tr></thead><tbody><tr><td data-type=\"index-mul\" data-i=\"i006\" style=\"min-width: 0px; max-width: 0px;\">序号</td><td data-type=\"text-mul\" data-i=\"i007\" style=\"min-width: 0px; max-width: 0px;\"><input type=\"text\" class=\"aya-input\"></td><td data-type=\"select-mul\" data-select=\"3\" data-i=\"i008\" style=\"min-width: 0px; max-width: 0px;\"><select class=\"browser-default\"><option value=\"3\">付款类型</option></select></td></tr></tbody></table></td></tr><tr><td style=\"  max-width: 588px; min-width: 588px; font-size: 12px; font-weight: 400; color: rgb(51, 51, 51); \" colspan=\"6\"    data-type=\"text\" class=\"border-top-none border-left-none border-right-none\">11</td></tr></tbody></table>'),(28,'111','2020-04-20 13:15:26','2020-04-27 18:08:42',NULL,NULL,'{\"creator\":{\"S\":\"n\",\"X\":{},\"D\":0},\"end\":{\"S\":\"n\",\"X\":{},\"D\":0},\"f\":{\"S\":\"p\",\"D\":0},\"id0\":{\"S\":\"p\",\"D\":0},\"id1\":{\"T\":\"P\",\"K\":\"010099\",\"V\":\"刘德华\",\"S\":\"n\",\"Z\":1,\"C\":\"3\",\"D\":0,\"X\":[[\"\",\"i004\",\"1\",\"\",\"\"]]},\"id2\":{\"T\":\"P\",\"K\":\"010097\",\"V\":\"郭富城\",\"S\":\"n\",\"Z\":1,\"C\":\"3\",\"D\":0,\"X\":[[\"\",\"i005\",\"1\",\"\",\"\"]]},\"id4\":{\"S\":\"p\",\"D\":0},\"id5\":{\"T\":\"P\",\"K\":\"010155\",\"V\":\"王泉\",\"S\":\"n\",\"Z\":1,\"C\":\"3\",\"D\":0,\"X\":[[\"\",\"aya1\",\"==\",\"3|1\",\"\",\"&&\"],[\"\",\"aya2\",\"==\",\"3\",\"\",\"\"]]},\"id6\":{\"S\":\"p\",\"D\":0},\"id7\":{\"T\":\"P\",\"K\":\"010099\",\"V\":\"刘德华\",\"S\":\"n\",\"Z\":1,\"C\":1,\"D\":0}}','{\"creator\":[\"id6\"],\"f\":[\"id5\"],\"id0\":[\"id1\",\"id2\"],\"id1\":[\"f\"],\"id2\":[\"f\"],\"id4\":[\"end\"],\"id5\":[\"id4\"],\"id6\":[\"id7\"],\"id7\":[\"id0\"]}',8,NULL,'<table class=\"table-form table noselect\" style=\"margin:auto;width:601px\" \'\'=\"\" data-index=\"0\" data-table=\"form-0153\"><tbody><tr><td data-type=\"text\" data-x=\"0\" data-y=\"0\" colspan=\"1 rowspan = \" 1\'=\"\" style=\"text-align: center; vertical-align: middle; max-width: 98px; min-width: 98px; font-size: 12px; font-weight: 400; color: rgb(51, 51, 51); background: rgb(255, 255, 255) none repeat scroll 0% 0%;\" class=\"border-top-none border-left-none border-right-none border-bottom-none\"></td><td data-type=\"text\" data-x=\"1\" data-y=\"0\" colspan=\"1 rowspan = \" 1\'=\"\" style=\"text-align: center; vertical-align: middle; max-width: 98px; min-width: 98px; font-size: 12px; font-weight: 400; color: rgb(51, 51, 51); background: rgb(255, 255, 255) none repeat scroll 0% 0%;\" class=\"border-top-none border-left-none border-right-none border-bottom-none\"></td><td data-type=\"text\" data-x=\"2\" data-y=\"0\" colspan=\"2\" 1\'=\"\" style=\"text-align: center; vertical-align: middle; max-width: 196px; min-width: 196px; font-size: 12px; font-weight: 400; color: rgb(51, 51, 51); background: rgb(255, 255, 255) none repeat scroll 0% 0%;\" class=\"border-top-none border-left-none border-right-none border-bottom-none\" rowspan=\"1\">财务借款流程</td><td data-type=\"text\" data-x=\"4\" data-y=\"0\" colspan=\"1 rowspan = \" 1\'=\"\" style=\"text-align: center; vertical-align: middle; max-width: 98px; min-width: 98px; font-size: 12px; font-weight: 400; color: rgb(51, 51, 51); background: rgb(255, 255, 255) none repeat scroll 0% 0%;\" class=\"border-top-none border-left-none border-right-none border-bottom-none\"></td><td data-type=\"text\" data-x=\"5\" data-y=\"0\" colspan=\"1 rowspan = \" 1\'=\"\" style=\"text-align: center; vertical-align: middle; max-width: 98px; min-width: 98px; font-size: 12px; font-weight: 400; color: rgb(51, 51, 51); background: rgb(255, 255, 255) none repeat scroll 0% 0%;\" class=\"border-top-none border-left-none border-right-none border-bottom-none\"></td></tr><tr style=\"height: 50px;\"><td style=\"text-align: center; vertical-align: middle; max-width: 98px; min-width: 98px; font-size: 12px; font-weight: 400; color: rgb(51, 51, 51); background: rgb(255, 255, 255) none repeat scroll 0% 0%;\" colspan=\"1\" rowspan=\"1\" data-x=\"0\" data-y=\"1\" data-type=\"text\" class=\"\">姓名</td><td style=\"text-align: center; vertical-align: middle; max-width: 98px; min-width: 98px; font-size: 12px; font-weight: 400; color: rgb(51, 51, 51); background: rgb(255, 255, 255) none repeat scroll 0% 0%;\" colspan=\"1\" rowspan=\"1\" data-x=\"1\" data-y=\"1\" data-type=\"input\" class=\"\" data-attr=\"姓名\" data-i=\"i001\"><input readonly=\"\" noselect=\"\" type=\"text\" class=\"aya-input form-input\"></td><td style=\"text-align: center; vertical-align: middle; max-width: 98px; min-width: 98px; font-size: 12px; font-weight: 400; color: rgb(51, 51, 51); background: rgb(255, 255, 255) none repeat scroll 0% 0%;\" colspan=\"1\" rowspan=\"1\" data-x=\"2\" data-y=\"1\" data-type=\"text\" class=\"\">岗位</td><td style=\"text-align: center; vertical-align: middle; max-width: 98px; min-width: 98px; font-size: 12px; font-weight: 400; color: rgb(51, 51, 51); background: rgb(255, 255, 255) none repeat scroll 0% 0%;\" colspan=\"1\" rowspan=\"1\" data-x=\"3\" data-y=\"1\" data-type=\"input\" class=\"\" data-attr=\"岗位\" data-i=\"i002\"><input readonly=\"\" noselect=\"\" type=\"text\" class=\"aya-input form-input\"></td><td style=\"text-align:center;vertical-align:middle;max-width:98px;min-width:98px\" colspan=\"1\" rowspan=\"1\" data-x=\"4\" data-y=\"1\" data-type=\"text\" class=\"\"></td><td style=\"text-align:center;vertical-align:middle;max-width:98px;min-width:98px\" colspan=\"1\" rowspan=\"1\" data-x=\"5\" data-y=\"1\" data-type=\"text\" class=\"\"></td></tr><tr style=\"height: 50px;\"><td style=\"text-align:center;vertical-align:middle;max-width:98px;min-width:98px\" colspan=\"1\" rowspan=\"1\" data-x=\"0\" data-y=\"2\" data-type=\"text\" class=\"\"></td><td style=\"text-align:center;vertical-align:middle;max-width:98px;min-width:98px\" colspan=\"1\" rowspan=\"1\" data-x=\"1\" data-y=\"2\" data-type=\"text\" class=\"\"></td><td style=\"text-align:center;vertical-align:middle;max-width:98px;min-width:98px\" colspan=\"1\" rowspan=\"1\" data-x=\"2\" data-y=\"2\" data-type=\"text\" class=\"\"></td><td style=\"text-align:center;vertical-align:middle;max-width:98px;min-width:98px\" colspan=\"1\" rowspan=\"1\" data-x=\"3\" data-y=\"2\" data-type=\"text\" class=\"\"></td><td style=\"text-align:center;vertical-align:middle;max-width:98px;min-width:98px\" colspan=\"1\" rowspan=\"1\" data-x=\"4\" data-y=\"2\" data-type=\"text\" class=\"\"></td><td style=\"text-align:center;vertical-align:middle;max-width:98px;min-width:98px\" colspan=\"1\" rowspan=\"1\" data-x=\"5\" data-y=\"2\" data-type=\"text\" class=\"\"></td></tr><tr style=\"height: 50px;\"><td style=\"text-align: center; vertical-align: middle; max-width: 294px; min-width: 294px; font-size: 12px; font-weight: 400; color: rgb(51, 51, 51); background: rgb(255, 255, 255) none repeat scroll 0% 0%;\" colspan=\"3\" rowspan=\"1\" data-x=\"0\" data-y=\"3\" data-type=\"checkbox\" class=\"\">蔬菜 <input name=\"c1587456716803\" data-i=\"i003\" data-name=\"蔬菜\" type=\"checkbox\" class=\"aya-checkbox\" style=\"margin-right:24px\"> 水果 <input name=\"c1587456716803\" data-i=\"i004\" data-name=\"水果\" type=\"checkbox\" class=\"aya-checkbox\" style=\"margin-right:24px\"> 肉类 <input name=\"c1587456716803\" data-i=\"i005\" data-name=\"肉类\" type=\"checkbox\" class=\"aya-checkbox\"> </td><td style=\"text-align: center; vertical-align: middle; max-width: 294px; min-width: 294px; font-size: 12px; font-weight: 400; color: rgb(51, 51, 51); background: rgb(255, 255, 255);\" colspan=\"3\" rowspan=\"1\" data-x=\"3\" data-y=\"3\" data-type=\"radio\" class=\"\"><p style=\"display:inline-block\">足球 <input data-i=\"i009\" name=\"r1587948720399\" data-name=\"足球\" type=\"radio\" class=\"aya-radio\" style=\"margin-right:24px\"></p> <p style=\"display:inline-block\">篮球 <input data-i=\"i010\" name=\"r1587948720399\" data-name=\"篮球\" type=\"radio\" class=\"aya-radio\" style=\"margin-right:24px\"></p> <p style=\"display:inline-block\">排球 <input data-i=\"i011\" name=\"r1587948720399\" data-name=\"排球\" type=\"radio\" class=\"aya-radio\" style=\"margin-right:24px\"></p> </td></tr><tr style=\"height: 50px;\"><td style=\"text-align:center;vertical-align:middle;max-width:98px;min-width:98px\" colspan=\"1\" rowspan=\"1\" data-x=\"0\" data-y=\"4\" data-type=\"text\" class=\"\"></td><td style=\"text-align:center;vertical-align:middle;max-width:98px;min-width:98px\" colspan=\"1\" rowspan=\"1\" data-x=\"1\" data-y=\"4\" data-type=\"text\" class=\"\"></td><td style=\"text-align:center;vertical-align:middle;max-width:98px;min-width:98px\" colspan=\"1\" rowspan=\"1\" data-x=\"2\" data-y=\"4\" data-type=\"text\" class=\"\"></td><td style=\"text-align:center;vertical-align:middle;max-width:98px;min-width:98px\" colspan=\"1\" rowspan=\"1\" data-x=\"3\" data-y=\"4\" data-type=\"text\" class=\"\"></td><td style=\"text-align: center; vertical-align: middle; max-width: 98px; min-width: 98px; font-size: 12px; font-weight: 400; color: rgb(51, 51, 51); background: rgb(255, 255, 255);\" colspan=\"1\" rowspan=\"1\" data-x=\"4\" data-y=\"4\" data-type=\"text\" class=\"\">付款方式</td><td style=\"text-align: center; vertical-align: middle; max-width: 98px; min-width: 98px; font-size: 12px; font-weight: 400; color: rgb(51, 51, 51); background: rgb(255, 255, 255);\" colspan=\"1\" rowspan=\"1\" data-x=\"5\" data-y=\"4\" data-type=\"select\" class=\"\" data-select=\"3\" data-name=\"付款类型\" data-i=\"i012\"><select class=\"browser-default\"><option>付款类型</option></select></td></tr><tr style=\"height: 50px;\"><td style=\"text-align:center;vertical-align:middle;max-width:98px;min-width:98px\" colspan=\"1\" rowspan=\"1\" data-x=\"0\" data-y=\"5\" data-type=\"text\" class=\"\"></td><td style=\"text-align: center; vertical-align: middle; max-width: 98px; min-width: 98px; font-size: 12px; font-weight: 400; color: rgb(51, 51, 51); background: rgb(255, 255, 255) none repeat scroll 0% 0%;\" colspan=\"1\" rowspan=\"1\" data-x=\"1\" data-y=\"5\" data-type=\"text\" class=\"\">阿发</td><td style=\"text-align: center; vertical-align: middle; max-width: 98px; min-width: 98px; font-size: 12px; font-weight: 400; color: rgb(51, 51, 51); background: rgb(255, 255, 255) none repeat scroll 0% 0%;\" colspan=\"1\" rowspan=\"1\" data-x=\"2\" data-y=\"5\" data-type=\"input\" class=\"\" data-attr=\"阿发\" data-i=\"i006\"><input readonly=\"\" noselect=\"\" type=\"text\" class=\"aya-input form-input\"></td><td style=\"text-align:center;vertical-align:middle;max-width:98px;min-width:98px\" colspan=\"1\" rowspan=\"1\" data-x=\"3\" data-y=\"5\" data-type=\"text\"></td><td style=\"text-align:center;vertical-align:middle;max-width:98px;min-width:98px\" colspan=\"1\" rowspan=\"1\" data-x=\"4\" data-y=\"5\" data-type=\"text\" class=\"\"></td><td style=\"text-align:center;vertical-align:middle;max-width:98px;min-width:98px\" colspan=\"1\" rowspan=\"1\" data-x=\"5\" data-y=\"5\" data-type=\"text\" class=\"\"></td></tr><tr style=\"height: 50px;\"><td style=\"text-align:center;vertical-align:middle;max-width:98px;min-width:98px\" colspan=\"1\" rowspan=\"1\" data-x=\"0\" data-y=\"6\" data-type=\"text\" class=\"\"></td><td style=\"text-align: center; vertical-align: middle; max-width: 98px; min-width: 98px; font-size: 12px; font-weight: 400; color: rgb(51, 51, 51); background: rgb(255, 255, 255) none repeat scroll 0% 0%;\" colspan=\"1\" rowspan=\"1\" data-x=\"1\" data-y=\"6\" data-type=\"text\" class=\"\">飒然</td><td style=\"text-align: center; vertical-align: middle; max-width: 98px; min-width: 98px; font-size: 12px; font-weight: 400; color: rgb(51, 51, 51); background: rgb(255, 255, 255) none repeat scroll 0% 0%;\" colspan=\"1\" rowspan=\"1\" data-x=\"2\" data-y=\"6\" data-type=\"input\" class=\"\" data-attr=\"飒然\" data-i=\"i007\"><input readonly=\"\" noselect=\"\" type=\"text\" class=\"aya-input form-input\"></td><td style=\"text-align: center; vertical-align: middle; max-width: 98px; min-width: 98px; font-size: 12px; font-weight: 400; color: rgb(51, 51, 51); background: rgb(255, 255, 255) none repeat scroll 0% 0%;\" colspan=\"1\" rowspan=\"1\" data-x=\"3\" data-y=\"6\" data-type=\"text\" class=\"\">天天</td><td style=\"text-align: center; vertical-align: middle; max-width: 98px; min-width: 98px; font-size: 12px; font-weight: 400; color: rgb(51, 51, 51); background: rgb(255, 255, 255) none repeat scroll 0% 0%;\" colspan=\"1\" rowspan=\"1\" data-x=\"4\" data-y=\"6\" data-type=\"input\" class=\"\" data-attr=\"天天\" data-i=\"i008\"><input readonly=\"\" noselect=\"\" type=\"text\" class=\"aya-input form-input\"></td><td style=\"text-align:center;vertical-align:middle;max-width:98px;min-width:98px\" colspan=\"1\" rowspan=\"1\" data-x=\"5\" data-y=\"6\" data-type=\"text\" class=\"\"></td></tr><tr><td data-type=\"text\" data-x=\"0\" data-y=\"7\" colspan=\"6\" 1\'=\"\" style=\"text-align: center; vertical-align: middle; max-width: 588px; min-width: 588px;\" class=\"\" rowspan=\"1\"><table class=\"table-mul\" data-table=\"subform-0124\"><thead><tr><th>序号</th><th>姓名</th><th>交通</th></tr></thead><tbody><tr><td data-type=\"index-mul\" data-i=\"i013\">序号</td><td data-type=\"text-mul\" data-i=\"i014\"><input type=\"text\" class=\"aya-input\"></td><td data-type=\"select-mul\" data-select=\"32\" data-i=\"i015\"><select class=\"browser-default\"><option value=\"32\">交通工具</option></select></td></tr></tbody></table></td></tr></tbody></table>','管理员',1,'{\"0\":{\"0\":98,\"1\":98,\"2\":98,\"3\":98,\"4\":98,\"5\":98}}',5,'<table class=\"table-form table noselect\" style=\"margin:auto;width:601px\" \'\'=\"\" data-index=\"0\" data-table=\"form-0153\"><tbody><tr><td data-type=\"text\"   colspan=\"1 rowspan = \" 1\'=\"\" style=\"  max-width: 98px; min-width: 98px; font-size: 12px; font-weight: 400; color: rgb(51, 51, 51); \" class=\"border-top-none border-left-none border-right-none border-bottom-none\"></td><td data-type=\"text\"   colspan=\"1 rowspan = \" 1\'=\"\" style=\"  max-width: 98px; min-width: 98px; font-size: 12px; font-weight: 400; color: rgb(51, 51, 51); \" class=\"border-top-none border-left-none border-right-none border-bottom-none\"></td><td data-type=\"text\"   colspan=\"2\" 1\'=\"\" style=\"  max-width: 196px; min-width: 196px; font-size: 12px; font-weight: 400; color: rgb(51, 51, 51); \" class=\"border-top-none border-left-none border-right-none border-bottom-none\" >财务借款流程</td><td data-type=\"text\"   colspan=\"1 rowspan = \" 1\'=\"\" style=\"  max-width: 98px; min-width: 98px; font-size: 12px; font-weight: 400; color: rgb(51, 51, 51); \" class=\"border-top-none border-left-none border-right-none border-bottom-none\"></td><td data-type=\"text\"   colspan=\"1 rowspan = \" 1\'=\"\" style=\"  max-width: 98px; min-width: 98px; font-size: 12px; font-weight: 400; color: rgb(51, 51, 51); \" class=\"border-top-none border-left-none border-right-none border-bottom-none\"></td></tr><tr style=\"height: 50px;\"><td style=\"  max-width: 98px; min-width: 98px; font-size: 12px; font-weight: 400; color: rgb(51, 51, 51); \"     data-type=\"text\" >姓名</td><td style=\"  max-width: 98px; min-width: 98px; font-size: 12px; font-weight: 400; color: rgb(51, 51, 51); \"     data-type=\"input\"  data-attr=\"姓名\" data-i=\"i001\"><input readonly=\"\" noselect=\"\" type=\"text\" class=\"aya-input form-input\"></td><td style=\"  max-width: 98px; min-width: 98px; font-size: 12px; font-weight: 400; color: rgb(51, 51, 51); \"     data-type=\"text\" >岗位</td><td style=\"  max-width: 98px; min-width: 98px; font-size: 12px; font-weight: 400; color: rgb(51, 51, 51); \"     data-type=\"input\"  data-attr=\"岗位\" data-i=\"i002\"><input readonly=\"\" noselect=\"\" type=\"text\" class=\"aya-input form-input\"></td><td style=\"max-width:98px;min-width:98px\"     data-type=\"text\" ></td><td style=\"max-width:98px;min-width:98px\"     data-type=\"text\" ></td></tr><tr style=\"height: 50px;\"><td style=\"max-width:98px;min-width:98px\"     data-type=\"text\" ></td><td style=\"max-width:98px;min-width:98px\"     data-type=\"text\" ></td><td style=\"max-width:98px;min-width:98px\"     data-type=\"text\" ></td><td style=\"max-width:98px;min-width:98px\"     data-type=\"text\" ></td><td style=\"max-width:98px;min-width:98px\"     data-type=\"text\" ></td><td style=\"max-width:98px;min-width:98px\"     data-type=\"text\" ></td></tr><tr style=\"height: 50px;\"><td style=\"  max-width: 294px; min-width: 294px; font-size: 12px; font-weight: 400; color: rgb(51, 51, 51); \" colspan=\"3\"    data-type=\"checkbox\" >蔬菜 <input name=\"c1587456716803\" data-i=\"i003\" data-name=\"蔬菜\" type=\"checkbox\" class=\"aya-checkbox\" style=\"margin-right:24px\"> 水果 <input name=\"c1587456716803\" data-i=\"i004\" data-name=\"水果\" type=\"checkbox\" class=\"aya-checkbox\" style=\"margin-right:24px\"> 肉类 <input name=\"c1587456716803\" data-i=\"i005\" data-name=\"肉类\" type=\"checkbox\" class=\"aya-checkbox\"> </td><td style=\"  max-width: 294px; min-width: 294px; font-size: 12px; font-weight: 400; color: rgb(51, 51, 51); background: rgb(255, 255, 255);\" colspan=\"3\"    data-type=\"radio\" ><p style=\"display:inline-block\">足球 <input data-i=\"i009\" name=\"r1587948720399\" data-name=\"足球\" type=\"radio\" class=\"aya-radio\" style=\"margin-right:24px\"></p> <p style=\"display:inline-block\">篮球 <input data-i=\"i010\" name=\"r1587948720399\" data-name=\"篮球\" type=\"radio\" class=\"aya-radio\" style=\"margin-right:24px\"></p> <p style=\"display:inline-block\">排球 <input data-i=\"i011\" name=\"r1587948720399\" data-name=\"排球\" type=\"radio\" class=\"aya-radio\" style=\"margin-right:24px\"></p> </td></tr><tr style=\"height: 50px;\"><td style=\"max-width:98px;min-width:98px\"     data-type=\"text\" ></td><td style=\"max-width:98px;min-width:98px\"     data-type=\"text\" ></td><td style=\"max-width:98px;min-width:98px\"     data-type=\"text\" ></td><td style=\"max-width:98px;min-width:98px\"     data-type=\"text\" ></td><td style=\"  max-width: 98px; min-width: 98px; font-size: 12px; font-weight: 400; color: rgb(51, 51, 51); background: rgb(255, 255, 255);\"     data-type=\"text\" >付款方式</td><td style=\"  max-width: 98px; min-width: 98px; font-size: 12px; font-weight: 400; color: rgb(51, 51, 51); background: rgb(255, 255, 255);\"     data-type=\"select\"  data-select=\"3\" data-name=\"付款类型\" data-i=\"i012\"><select class=\"browser-default\"><option>付款类型</option></select></td></tr><tr style=\"height: 50px;\"><td style=\"max-width:98px;min-width:98px\"     data-type=\"text\" ></td><td style=\"  max-width: 98px; min-width: 98px; font-size: 12px; font-weight: 400; color: rgb(51, 51, 51); \"     data-type=\"text\" >阿发</td><td style=\"  max-width: 98px; min-width: 98px; font-size: 12px; font-weight: 400; color: rgb(51, 51, 51); \"     data-type=\"input\"  data-attr=\"阿发\" data-i=\"i006\"><input readonly=\"\" noselect=\"\" type=\"text\" class=\"aya-input form-input\"></td><td style=\"max-width:98px;min-width:98px\"     data-type=\"text\"></td><td style=\"max-width:98px;min-width:98px\"     data-type=\"text\" ></td><td style=\"max-width:98px;min-width:98px\"     data-type=\"text\" ></td></tr><tr style=\"height: 50px;\"><td style=\"max-width:98px;min-width:98px\"     data-type=\"text\" ></td><td style=\"  max-width: 98px; min-width: 98px; font-size: 12px; font-weight: 400; color: rgb(51, 51, 51); \"     data-type=\"text\" >飒然</td><td style=\"  max-width: 98px; min-width: 98px; font-size: 12px; font-weight: 400; color: rgb(51, 51, 51); \"     data-type=\"input\"  data-attr=\"飒然\" data-i=\"i007\"><input readonly=\"\" noselect=\"\" type=\"text\" class=\"aya-input form-input\"></td><td style=\"  max-width: 98px; min-width: 98px; font-size: 12px; font-weight: 400; color: rgb(51, 51, 51); \"     data-type=\"text\" >天天</td><td style=\"  max-width: 98px; min-width: 98px; font-size: 12px; font-weight: 400; color: rgb(51, 51, 51); \"     data-type=\"input\"  data-attr=\"天天\" data-i=\"i008\"><input readonly=\"\" noselect=\"\" type=\"text\" class=\"aya-input form-input\"></td><td style=\"max-width:98px;min-width:98px\"     data-type=\"text\" ></td></tr><tr><td data-type=\"text\"   colspan=\"6\" 1\'=\"\" style=\"  max-width: 588px; min-width: 588px;\"  ><table class=\"table-mul\" data-table=\"subform-0124\"><thead><tr><th>序号</th><th>姓名</th><th>交通</th></tr></thead><tbody><tr><td data-type=\"index-mul\" data-i=\"i013\">序号</td><td data-type=\"text-mul\" data-i=\"i014\"><input type=\"text\" class=\"aya-input\"></td><td data-type=\"select-mul\" data-select=\"32\" data-i=\"i015\"><select class=\"browser-default\"><option value=\"32\">交通工具</option></select></td></tr></tbody></table></td></tr></tbody></table>');

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
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1721 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

#
# Data for table "s_flows"
#


#
# Structure for table "s_flows_auth"
#

CREATE TABLE `s_flows_auth` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `flows_id` int(11) DEFAULT NULL,
  `node_id` varchar(255) DEFAULT NULL,
  `auth` text,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=127 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

#
# Data for table "s_flows_auth"
#


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
) ENGINE=MyISAM AUTO_INCREMENT=3124 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

#
# Data for table "s_flows_comment"
#


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
) ENGINE=MyISAM AUTO_INCREMENT=183 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

#
# Data for table "s_flows_executor"
#


#
# Structure for table "s_flows_field"
#

CREATE TABLE `s_flows_field` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `flows_id` int(11) NOT NULL DEFAULT '0',
  `field` text,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=25 DEFAULT CHARSET=utf8;

#
# Data for table "s_flows_field"
#


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
) ENGINE=MyISAM AUTO_INCREMENT=28 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

#
# Data for table "s_form-0153"
#


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
) ENGINE=MyISAM AUTO_INCREMENT=44 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

#
# Data for table "s_layout"
#

INSERT INTO `s_layout` VALUES (2,1,'人事','',0,10,NULL,0,'people',0,0),(5,2,'员工档案','Hr/index',2,1,861,0,'',0,0),(6,2,'时间线','Hr/timeline',2,5,NULL,0,'',0,0),(29,2,'组织','Dept/index',2,10,868,0,'',0,0),(30,2,'岗位','Pst/index',2,20,870,0,'',0,0),(31,1,'基础资料','',0,1000,NULL,0,'view_module',0,0),(32,2,'枚举','Basic/enum',31,10,873,0,'',0,0),(33,2,'流程管理','F/manage',31,20,875,0,'',0,0),(34,1,'协同办公','',0,20,NULL,0,'repeat',0,0),(35,2,'新建事项','Fs/newFlow',34,20,878,0,'',0,1),(36,2,'待办事项','Fs/notDone',34,30,879,0,'',0,1),(37,2,'已办事项','Fs/hasDone',34,40,880,0,'',0,1),(39,2,'已发事项','Fs/hasSend',34,50,881,0,'',0,1),(43,2,'流程节点管理','F/node',31,30,882,0,'',0,0);

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
) ENGINE=MyISAM AUTO_INCREMENT=883 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

#
# Data for table "s_node"
#

INSERT INTO `s_node` VALUES (860,'人事','Hr',0,NULL,1,0,1,0),(861,'人事首页','index',0,NULL,10,860,2,0),(867,'组织','Dept',0,NULL,5,0,1,0),(868,'组织首页','index',0,NULL,10,867,2,0),(869,'岗位','Pst',0,NULL,2,0,1,0),(870,'岗位首页','index',0,NULL,1,869,2,0),(871,'基础资料','Basic',0,NULL,1000,0,1,0),(873,'枚举','enum',0,NULL,1,871,2,0),(874,'流程管理','F',0,NULL,900,0,1,0),(875,'后台','manage',0,NULL,10,874,2,0),(877,'协同','Fs',0,NULL,10,0,1,0),(878,'新增事项','newFlow',0,NULL,10,877,2,0),(879,'待办事项','notDone',0,NULL,20,877,2,0),(880,'已办事项','hasDone',0,NULL,30,877,2,0),(881,'已发事项','hasSend',0,NULL,40,877,2,0),(882,'流程节点管理','node',0,NULL,20,874,2,0);

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
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

#
# Data for table "s_subform-0124"
#

INSERT INTO `s_subform-0124` VALUES (1,1717,1,'rrwrwrwr',21),(2,1718,1,'aaaaaaaa',21),(3,1719,1,'aaaaaaa',23),(4,1720,1,'aaaaaaaa',21),(5,1720,2,'bbbbbbbbbb',23),(6,1721,1,'fafafasf',22),(7,1721,2,'fasfasfas',21),(8,1722,1,'1111111',21),(9,1723,1,'aaaaaaaaa',22),(10,1723,2,'bbbbbbbbbb',23),(11,1724,1,'aaa',22),(12,1725,1,'aaaaaaaaa',24),(13,1726,1,'111',21);

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

INSERT INTO `s_user` VALUES (171,'admin','407de5e0d85a21d317de8def45fa331b','管理员','42686304@qq.com',NULL,'2020-04-28 13:55:31',1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(172,'0101004','123','王泉','','2020-03-05 12:53:27',NULL,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,',75,74,73,'),(173,'111','11','322','','2020-03-05 12:56:10',NULL,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(174,'11111','202cb962ac59075b964b07152d234b70','网啊','','2020-03-05 13:10:28',NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,',73,'),(175,'5555','182be0c5cdcd5072bb1864cdee4d3d6e','222','','2020-03-05 13:14:31',NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,',77,'),(176,'1111','f1c1592588411002af340cbaedd6fc33','222','','2020-03-05 13:16:24','2020-04-02 10:07:32',1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,',77,'),(177,'111111','182be0c5cdcd5072bb1864cdee4d3d6e','222','','2020-03-05 13:16:52',NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,',77,'),(178,'11111155','182be0c5cdcd5072bb1864cdee4d3d6e','222','','2020-03-05 13:17:32',NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,',76,'),(179,'99999','310dcbbf4cce62f762a2aaa148d556bd','111','','2020-03-05 14:32:26',NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,',76,'),(180,'666','fae0b27c451c728867a567e8c1bb4e53','666','','2020-03-05 14:32:54',NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,',77,'),(181,'777','f1c1592588411002af340cbaedd6fc33','777','','2020-03-05 14:33:44','2020-04-01 21:02:45',1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,',77,'),(182,'010101','202cb962ac59075b964b07152d234b70','王泉','','2020-03-05 14:34:24',NULL,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,',77,72,'),(184,'052213','202cb962ac59075b964b07152d234b70','赵四','','2020-03-06 19:00:40',NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,',77,76,75,'),(185,'010099','202cb962ac59075b964b07152d234b70','刘德华','','2020-04-02 07:52:43','2020-04-28 17:02:12',1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,',78,'),(186,'010097','202cb962ac59075b964b07152d234b70','郭富城','','2020-04-02 13:52:39','2020-04-28 16:29:57',1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,',74,78,');
