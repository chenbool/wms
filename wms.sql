/*
Navicat MySQL Data Transfer

Source Server         : mysql
Source Server Version : 50553
Source Host           : localhost:3306
Source Database       : wms

Target Server Type    : MYSQL
Target Server Version : 50553
File Encoding         : 65001

Date: 2018-01-27 17:09:05
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for w_category
-- ----------------------------
DROP TABLE IF EXISTS `w_category`;
CREATE TABLE `w_category` (
  `id` mediumint(9) unsigned NOT NULL AUTO_INCREMENT,
  `pid` mediumint(9) unsigned NOT NULL DEFAULT '0',
  `name` varchar(40) NOT NULL,
  `status` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `desc` mediumtext,
  `add_time` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of w_category
-- ----------------------------
INSERT INTO `w_category` VALUES ('1', '0', '数码', '0', '', '1514456685');
INSERT INTO `w_category` VALUES ('2', '1', '手机', '0', '手机', '1514457825');
INSERT INTO `w_category` VALUES ('3', '0', '服装', '0', '', '1514554550');

-- ----------------------------
-- Table structure for w_company
-- ----------------------------
DROP TABLE IF EXISTS `w_company`;
CREATE TABLE `w_company` (
  `id` mediumint(9) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(40) NOT NULL,
  `tel` varchar(12) NOT NULL,
  `email` varchar(40) NOT NULL,
  `status` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `address` varchar(100) DEFAULT NULL,
  `desc` mediumtext,
  `add_time` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COMMENT='公司管理';

-- ----------------------------
-- Records of w_company
-- ----------------------------
INSERT INTO `w_company` VALUES ('1', '苏州牧冬光电', '0512-5689105', '30024167@qq.com', '0', '江苏省苏州市园区', '', '1515753231');
INSERT INTO `w_company` VALUES ('2', '苏州大金空调有限公司', '0512-5689107', '30024167@qq.com', '0', '', '', '1515753528');
INSERT INTO `w_company` VALUES ('3', '苏州麦克维尔制冷有限公司', '0512-5689107', '81001985@qq.com', '0', '', '', '1515753572');
INSERT INTO `w_company` VALUES ('4', '三星显示器有限公司', '0512-5689107', '123@qq.com', '0', '方洲路', '', '1515753597');
INSERT INTO `w_company` VALUES ('5', 'delphi电子', '0532-5689107', '11@qq.com', '0', '江苏省苏州市', '', '1516965310');

-- ----------------------------
-- Table structure for w_customer
-- ----------------------------
DROP TABLE IF EXISTS `w_customer`;
CREATE TABLE `w_customer` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `sn` varchar(40) NOT NULL,
  `name` varchar(40) NOT NULL,
  `contact` varchar(20) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `email` varchar(40) NOT NULL,
  `fax` varchar(20) NOT NULL,
  `address` varchar(40) NOT NULL,
  `desc` mediumtext,
  `status` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `add_time` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`) USING BTREE,
  UNIQUE KEY `sn` (`sn`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='客户';

-- ----------------------------
-- Records of w_customer
-- ----------------------------
INSERT INTO `w_customer` VALUES ('1', '5a44a4f6f1f18', '苏州牧冬光电有限公司', '测试', '15069900798', '30024167@qq.com', '15069900798', '江苏省苏州市长阳街', '苏州牧冬光电有限公司...', '0', '1514448252');
INSERT INTO `w_customer` VALUES ('2', '5a44b3f23a31c', '爱美克空气过滤器', '测试', '1705280089', '30024167@qq.com', '0312-56777890', '苏州市工业园区长阳街', '爱美克空气过滤器', '0', '1514452007');

-- ----------------------------
-- Table structure for w_goods
-- ----------------------------
DROP TABLE IF EXISTS `w_goods`;
CREATE TABLE `w_goods` (
  `goods_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `cat_id` smallint(5) unsigned NOT NULL DEFAULT '0',
  `ent_id` int(10) NOT NULL DEFAULT '0',
  `goods_sn` varchar(60) NOT NULL DEFAULT '',
  `product_no` varchar(30) DEFAULT '' COMMENT '产品编码',
  `goods_name` varchar(120) NOT NULL DEFAULT '',
  `brand` varchar(64) DEFAULT '' COMMENT '品牌',
  `goods_spec` varchar(255) NOT NULL DEFAULT '',
  `goods_weight` decimal(10,3) unsigned NOT NULL DEFAULT '0.000',
  `market_price` decimal(10,2) unsigned NOT NULL DEFAULT '0.00',
  `goods_price` decimal(10,2) unsigned NOT NULL DEFAULT '0.00',
  `add_time` int(10) unsigned NOT NULL DEFAULT '0',
  `unit` varchar(15) DEFAULT '' COMMENT '申报单位',
  `goods_sn_cus` varchar(60) DEFAULT NULL COMMENT '海关备案号',
  `goods_sn_ciq` varchar(60) DEFAULT NULL COMMENT '商检备案号',
  `customs_tax_rate` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '关税税率',
  `consumption_tax_rate` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '消费税税率',
  `valueadded_tax_rate` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '增值税税率',
  `code_ts` varchar(50) DEFAULT '',
  `g_weight` decimal(18,5) NOT NULL DEFAULT '0.00000',
  `r_weight` decimal(18,5) NOT NULL DEFAULT '0.00000',
  `for_orgin` varchar(50) DEFAULT '' COMMENT '原产国',
  `qty1` decimal(18,5) NOT NULL DEFAULT '0.00000' COMMENT '法定数量',
  `unit1` varchar(12) DEFAULT '' COMMENT '法定单位',
  `qty2` decimal(18,5) NOT NULL DEFAULT '0.00000' COMMENT '法定第二数量',
  `unit2` varchar(12) DEFAULT '' COMMENT '法定第二单位',
  `qty1_ratio` decimal(10,2) unsigned DEFAULT '1.00' COMMENT '第一法定单位对应申报单位的换算系数',
  `qty2_ratio` decimal(10,2) unsigned DEFAULT '1.00' COMMENT '第二法定单位对应申报单位的换算系数',
  PRIMARY KEY (`goods_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of w_goods
-- ----------------------------

-- ----------------------------
-- Table structure for w_location
-- ----------------------------
DROP TABLE IF EXISTS `w_location`;
CREATE TABLE `w_location` (
  `id` mediumint(9) unsigned NOT NULL AUTO_INCREMENT,
  `sn` varchar(40) NOT NULL,
  `name` varchar(40) NOT NULL,
  `storage` mediumint(5) unsigned NOT NULL,
  `status` tinyint(1) unsigned NOT NULL COMMENT '0',
  `desc` varchar(200) DEFAULT NULL COMMENT '备注',
  `add_time` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='库位管理';

-- ----------------------------
-- Records of w_location
-- ----------------------------
INSERT INTO `w_location` VALUES ('1', '17122705595244343', 'B区', '1', '0', '', '1514368943');
INSERT INTO `w_location` VALUES ('2', '17122706022839995', 'A区', '3', '0', '', '1514368959');

-- ----------------------------
-- Table structure for w_menu
-- ----------------------------
DROP TABLE IF EXISTS `w_menu`;
CREATE TABLE `w_menu` (
  `id` mediumint(9) unsigned NOT NULL AUTO_INCREMENT,
  `pid` mediumint(9) unsigned DEFAULT '0',
  `name` varchar(40) DEFAULT NULL,
  `ico` varchar(20) DEFAULT NULL,
  `level` tinyint(1) unsigned DEFAULT '0',
  `controller` varchar(20) DEFAULT NULL,
  `action` varchar(20) DEFAULT NULL,
  `status` tinyint(1) unsigned DEFAULT '0',
  `add_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=MyISAM AUTO_INCREMENT=30 DEFAULT CHARSET=utf8 COMMENT='菜单';

-- ----------------------------
-- Records of w_menu
-- ----------------------------
INSERT INTO `w_menu` VALUES ('1', '0', '控制台', 'linecons-cog', '0', 'Index', 'index', '0', null);
INSERT INTO `w_menu` VALUES ('2', '0', '系统设置', 'linecons-desktop', '0', '', null, '0', null);
INSERT INTO `w_menu` VALUES ('3', '2', '员工管理', null, '1', 'User', 'index', '0', null);
INSERT INTO `w_menu` VALUES ('4', '0', '仓库作业', 'linecons-tag', '0', null, null, '0', null);
INSERT INTO `w_menu` VALUES ('5', '4', '入库管理', null, '1', 'Instorage', 'index', '0', '5');
INSERT INTO `w_menu` VALUES ('6', '4', '出库管理', null, '1', 'Outstorage', 'index', '0', null);
INSERT INTO `w_menu` VALUES ('7', '4', '查询管理', null, '1', 'Product', 'lists', '0', null);
INSERT INTO `w_menu` VALUES ('8', '0', '基本设置', 'linecons-cog', '0', null, null, '0', null);
INSERT INTO `w_menu` VALUES ('9', '8', '仓库管理', null, '1', 'Storage', 'index', '0', null);
INSERT INTO `w_menu` VALUES ('10', '8', '库位管理', null, '1', 'Location', 'index', '0', null);
INSERT INTO `w_menu` VALUES ('11', '8', '供应商管理', null, '1', 'Supplier', 'index', '0', null);
INSERT INTO `w_menu` VALUES ('12', '8', '客户管理', null, '1', 'Customer', 'index', '0', null);
INSERT INTO `w_menu` VALUES ('13', '8', '计量单位', null, '1', 'Unit', 'index', '0', null);
INSERT INTO `w_menu` VALUES ('14', '8', '产品类别', null, '1', 'Category', 'index', '0', null);
INSERT INTO `w_menu` VALUES ('15', '8', '产品管理', null, '1', 'Product', 'index', '0', null);
INSERT INTO `w_menu` VALUES ('16', '2', '角色管理', null, '1', 'Role', 'index', '0', null);
INSERT INTO `w_menu` VALUES ('17', '8', '企业管理', null, '1', 'Company', 'index', '0', null);
INSERT INTO `w_menu` VALUES ('18', '8', '货架管理', null, '1', 'Shelve', 'index', '0', null);
INSERT INTO `w_menu` VALUES ('19', '8', '货位管理', null, '1', 'Position', 'index', '1', null);
INSERT INTO `w_menu` VALUES ('20', '0', '订单管理', 'linecons-note', '0', '', null, '0', null);
INSERT INTO `w_menu` VALUES ('21', '20', '订单查询', null, '1', 'Order', 'index', '0', null);
INSERT INTO `w_menu` VALUES ('22', '20', '订单导入', null, '1', 'Order', 'import', '0', null);
INSERT INTO `w_menu` VALUES ('23', '4', '货物上架', null, '1', 'Goodtop', 'index', '0', null);
INSERT INTO `w_menu` VALUES ('24', '4', '调度管理', null, '1', 'Allot', 'index', '0', null);
INSERT INTO `w_menu` VALUES ('25', '26', '理货管理', null, '1', 'Pack', 'index', '0', null);
INSERT INTO `w_menu` VALUES ('26', '0', '发货管理', 'linecons-doc', '0', null, null, '0', null);
INSERT INTO `w_menu` VALUES ('27', '26', '理货任务', null, '1', 'Pack', 'send', '0', null);
INSERT INTO `w_menu` VALUES ('28', '20', '拣货管理', null, '1', 'Pack', 'pack', '0', null);
INSERT INTO `w_menu` VALUES ('29', '20', '理货包装', null, '1', 'Pack', 'arrange', '0', null);

-- ----------------------------
-- Table structure for w_order
-- ----------------------------
DROP TABLE IF EXISTS `w_order`;
CREATE TABLE `w_order` (
  `id` mediumint(9) unsigned NOT NULL AUTO_INCREMENT,
  `sn` varchar(40) DEFAULT NULL,
  `car_no` varchar(40) DEFAULT NULL,
  `ban_no` varchar(40) DEFAULT NULL,
  `detailed_no` varchar(40) DEFAULT NULL COMMENT '载货清单号',
  `author` varchar(20) DEFAULT NULL,
  `supplier` varchar(40) DEFAULT NULL,
  `state` tinyint(1) unsigned DEFAULT NULL COMMENT '1',
  `type` varchar(40) DEFAULT NULL,
  `res` mediumtext,
  `desc` mediumtext,
  `add_time` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `sn` (`sn`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of w_order
-- ----------------------------
INSERT INTO `w_order` VALUES ('1', 'SN2018012110414826907', '', '', '', '布尔', '默认', '1', '采购入库', null, '', '1516545717');
INSERT INTO `w_order` VALUES ('2', 'SN2018012111214042566', '苏E', '', '', '布尔', '默认', '1', '采购入库', null, '', '1516548122');
INSERT INTO `w_order` VALUES ('3', 'SN2018012212010089315', '', '', '', '布尔', '默认', '2', '采购出库', null, '', '1516550472');
INSERT INTO `w_order` VALUES ('4', 'SN2018012212144368051', '', '', '', '布尔', '默认', '2', '采购出库', null, '', '1516551291');

-- ----------------------------
-- Table structure for w_order_good
-- ----------------------------
DROP TABLE IF EXISTS `w_order_good`;
CREATE TABLE `w_order_good` (
  `rec_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `order_sn` varchar(40) DEFAULT NULL,
  `batch_no` varchar(20) DEFAULT NULL COMMENT '导入批号',
  `referer` varchar(40) DEFAULT NULL COMMENT '订单来源',
  `identify_no` varchar(20) DEFAULT NULL COMMENT '身份证',
  `author` varchar(20) DEFAULT NULL COMMENT '订单作者',
  `waybillno` varchar(40) DEFAULT NULL COMMENT '物流编号',
  `delivery` varchar(40) NOT NULL DEFAULT '第三方物流' COMMENT '送货方式',
  `receiver_name` varchar(20) DEFAULT NULL COMMENT '收件人',
  `receiver_phone` varchar(12) DEFAULT NULL COMMENT '收件人电话',
  `receiver_province` varchar(20) DEFAULT NULL COMMENT '收件省份',
  `receiver_city` varchar(20) DEFAULT NULL COMMENT '收件城市',
  `receiver_district` varchar(20) DEFAULT NULL COMMENT '收件县区',
  `receiver_address` mediumtext COMMENT '收件地址',
  `sender_name` varchar(20) DEFAULT NULL COMMENT '发件人',
  `sender_phone` varchar(12) DEFAULT NULL COMMENT '发件电话',
  `sender_address` mediumtext COMMENT '发件地址',
  `is_print` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否打印：0：未打印 1：已打印',
  `pick_status` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '拣货状态0：未拣货 1：拣货',
  `tally_status` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '理货状态0：未理货 1：挂起 2：理货完成',
  `out_status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '出库状态0：未出库1：已出库',
  `shipping_fee` decimal(4,2) unsigned DEFAULT '0.00' COMMENT '运费',
  `desc` mediumtext,
  `add_time` int(11) unsigned NOT NULL,
  PRIMARY KEY (`rec_id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of w_order_good
-- ----------------------------
INSERT INTO `w_order_good` VALUES ('1', 'AD888013016NY', '20180122092551', '导入', '11010119971218402X', '', '9977937396691', '第三方物流', '刘如忆', '13705009875', '福建省', '福州市', '鼓楼区', '东泰路竹林镜新村27号401', 'BOBO', '9294347911', '312bay ridge ave brooklyn NY', '0', '1', '0', '0', '0.00', null, '1516627551');
INSERT INTO `w_order_good` VALUES ('2', 'AD888013017NY', '20180122092642', '导入', '51012519820402002X', '', '9977937396692', '第三方物流', '陈莉', '13799983277', '福建省', '福州市', '台江区', '洋中路178号文景苑514', 'BOBO', 'BOBO', '312bay ridge ave brooklyn NY', '0', '1', '0', '0', '0.00', null, '1516627602');
INSERT INTO `w_order_good` VALUES ('3', 'AD888013018NY', '20180122092652', '导入', '51012519820402002X', '布尔', '9977937396693', '第三方物流', '布尔', '13799983275', '福建省', '福州市', '台江区', '洋中路178号文景苑514', 'BOBO', 'BOBO', 'ge ave brooklyn NY', '0', '0', '0', '0', '0.00', null, '0');

-- ----------------------------
-- Table structure for w_order_goods
-- ----------------------------
DROP TABLE IF EXISTS `w_order_goods`;
CREATE TABLE `w_order_goods` (
  `rec_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `order_sn` varchar(40) DEFAULT NULL,
  `order_id` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `goods_id` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `goods_sn` varchar(60) NOT NULL DEFAULT '' COMMENT '商品货号',
  `goods_name` varchar(128) DEFAULT '' COMMENT '品名',
  `brand` varchar(64) DEFAULT '' COMMENT '品牌',
  `goods_spec` varchar(128) DEFAULT '' COMMENT '规格',
  `currency` varchar(50) DEFAULT '' COMMENT '币值',
  `product_no` varchar(50) DEFAULT '' COMMENT '产品编码',
  `goods_number` smallint(5) unsigned NOT NULL DEFAULT '1',
  `market_price` decimal(10,2) NOT NULL DEFAULT '0.00',
  `goods_price` decimal(10,2) NOT NULL DEFAULT '0.00',
  `tax_price` float(10,2) NOT NULL DEFAULT '0.00',
  `note` varchar(256) DEFAULT NULL,
  `unit` varchar(50) DEFAULT '0' COMMENT '申报计量单位 3位代码',
  `unit2` varchar(12) DEFAULT '' COMMENT '法定第二单位',
  `g_weight` decimal(18,5) DEFAULT NULL COMMENT '毛重',
  `r_weight` decimal(18,5) DEFAULT NULL COMMENT '净重',
  `qty1` decimal(18,5) DEFAULT '0.00000' COMMENT '法定数量',
  `unit1` varchar(12) DEFAULT '' COMMENT '法定单位',
  `qty2` decimal(18,5) DEFAULT '0.00000' COMMENT '法定第二数量',
  PRIMARY KEY (`rec_id`),
  KEY `order_id` (`order_id`) USING BTREE,
  KEY `goods_id` (`goods_id`) USING BTREE,
  KEY `goods_sn` (`goods_sn`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of w_order_goods
-- ----------------------------

-- ----------------------------
-- Table structure for w_order_info
-- ----------------------------
DROP TABLE IF EXISTS `w_order_info`;
CREATE TABLE `w_order_info` (
  `order_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `o_id` mediumint(9) unsigned DEFAULT NULL COMMENT '关联id',
  `ent_id` int(11) DEFAULT '0' COMMENT '所属企业ID',
  `batch_no` varchar(64) DEFAULT NULL COMMENT '导入批次号',
  `order_sn` varchar(64) DEFAULT '' COMMENT '电商内部订单号',
  `referer` varchar(64) DEFAULT '' COMMENT '订单来源',
  `waybillno` varchar(64) DEFAULT '' COMMENT '物流单号',
  `product_no` varchar(64) DEFAULT '' COMMENT '产品编码(必填)',
  `identify_no` varchar(60) DEFAULT '' COMMENT '身份证号码',
  `receiver_name` varchar(60) DEFAULT '' COMMENT '收件人姓名',
  `receiver_phone` varchar(60) DEFAULT '' COMMENT '收件人电话',
  `receiver_province` varchar(60) DEFAULT '' COMMENT '收件人省份',
  `receiver_city` varchar(60) DEFAULT '' COMMENT '收件人市',
  `receiver_district` varchar(60) DEFAULT '' COMMENT '收件人区县',
  `receiver_address` varchar(255) DEFAULT '' COMMENT '收件人地址',
  `sender_name` varchar(60) DEFAULT '' COMMENT '发件人姓名',
  `sender_phone` varchar(60) DEFAULT '' COMMENT '发件人电话',
  `sender_address` varchar(255) DEFAULT '' COMMENT '发件人地址',
  `g_weight` decimal(18,5) DEFAULT NULL COMMENT '毛重',
  `r_weight` decimal(18,5) DEFAULT NULL COMMENT '净重',
  `goods_number` smallint(5) unsigned DEFAULT '1',
  `goods_amount` decimal(10,2) DEFAULT '0.00',
  `currency` varchar(50) DEFAULT '' COMMENT '币值',
  `shipping_fee` decimal(10,2) DEFAULT '0.00' COMMENT '运费',
  `remark` varchar(255) DEFAULT '' COMMENT '订单备注',
  `is_print` varchar(1) NOT NULL DEFAULT '0' COMMENT '是否打印：0：未打印 1：已打印',
  `pick_status` varchar(1) NOT NULL DEFAULT '0' COMMENT '拣货状态0：未拣货 1：拣货',
  `tally_status` varchar(1) NOT NULL DEFAULT '0' COMMENT '理货状态0：未理货 1：挂起 2：理货完成',
  `out_status` varchar(1) NOT NULL DEFAULT '0' COMMENT '出库状态0：未出库1：已出库',
  `add_time` int(11) NOT NULL,
  PRIMARY KEY (`order_id`),
  KEY `order_sn` (`order_sn`) USING BTREE,
  KEY `waybillno` (`waybillno`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COMMENT='发货';

-- ----------------------------
-- Records of w_order_info
-- ----------------------------
INSERT INTO `w_order_info` VALUES ('1', '1', '0', '20180122093010', 'AD888013016NY', null, '9977937396691', '5a450753a97ee', '11010119971218402X', '刘如忆', '13705009875', '福建省', '福州市', '鼓楼区', '东泰路竹林镜新村27号401', 'BOBO', '9294347911', '312bay ridge ave brooklyn NY', null, '2.10000', '4', '200.00', '50', '0.00', null, '0', '0', '0', '0', '1516627810');
INSERT INTO `w_order_info` VALUES ('2', '2', '0', '20180122093010', 'AD888013017NY', null, '9977937396692', '5a450753a97ee', '51012519820402002X', '陈莉', '13799983277', '福建省', '福州市', '台江区', '洋中路178号文景苑514', 'BOBO', '9294347911', '312bay ridge ave brooklyn NY', null, '5.30000', '6', '439.80', '73.3', '0.00', null, '0', '0', '0', '0', '1516627810');
INSERT INTO `w_order_info` VALUES ('3', '2', '0', '20180122093010', 'AD888013017NY', null, '9977937396692', '5a450753a97ee', '51012519820402002X', '陈莉', '13799983277', '福建省', '福州市', '台江区', '洋中路178号文景苑514', 'BOBO', '9294347911', '312bay ridge ave brooklyn NY', null, '2.10000', '4', '200.00', '50', '0.00', null, '0', '0', '0', '0', '1516627810');
INSERT INTO `w_order_info` VALUES ('4', '1', '0', '20180122094305', 'AD888013016NY', null, '9977937396691', '5a47110d39206', '11010119971218402X', '刘如忆', '13705009875', '福建省', '福州市', '鼓楼区', '东泰路竹林镜新村27号401', 'BOBO', '9294347911', '312bay ridge ave brooklyn NY', null, '2.10000', '4', '200.00', '50', '0.00', null, '0', '0', '0', '0', '1516628585');
INSERT INTO `w_order_info` VALUES ('5', '2', '0', '20180122094305', 'AD888013017NY', null, '9977937396692', '5a47110d39206', '51012519820402002X', '陈莉', '13799983277', '福建省', '福州市', '台江区', '洋中路178号文景苑514', 'BOBO', '9294347911', '312bay ridge ave brooklyn NY', null, '5.30000', '6', '439.80', '73.3', '0.00', null, '0', '0', '0', '0', '1516628585');
INSERT INTO `w_order_info` VALUES ('6', '2', '0', '20180122094305', 'AD888013017NY', null, '9977937396692', '5a47110d39206', '51012519820402002X', '陈莉', '13799983277', '福建省', '福州市', '台江区', '洋中路178号文景苑514', 'BOBO', '9294347911', '312bay ridge ave brooklyn NY', null, '2.10000', '4', '200.00', '50', '0.00', null, '0', '0', '0', '0', '1516628585');

-- ----------------------------
-- Table structure for w_order_infow
-- ----------------------------
DROP TABLE IF EXISTS `w_order_infow`;
CREATE TABLE `w_order_infow` (
  `order_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `o_id` mediumint(9) unsigned DEFAULT NULL COMMENT '关联id',
  `ent_id` int(11) DEFAULT '0' COMMENT '所属企业ID',
  `product_no` varchar(40) DEFAULT NULL,
  `g_weight` decimal(18,5) DEFAULT NULL COMMENT '毛重',
  `r_weight` decimal(18,5) DEFAULT NULL COMMENT '净重',
  `goods_number` smallint(5) unsigned DEFAULT '1',
  `goods_amount` decimal(10,2) DEFAULT '0.00',
  `currency` varchar(50) DEFAULT '' COMMENT '币值',
  `remark` varchar(255) DEFAULT '' COMMENT '订单备注',
  `add_time` int(11) NOT NULL,
  PRIMARY KEY (`order_id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COMMENT='发货';

-- ----------------------------
-- Records of w_order_infow
-- ----------------------------
INSERT INTO `w_order_infow` VALUES ('1', '1', '0', '5a450753a97ee', null, '2.10000', '4', '200.00', '50', null, '1516627602');
INSERT INTO `w_order_infow` VALUES ('2', '2', '0', '5a450753a97ee', null, '5.30000', '6', '439.80', '73.3', null, '1516627602');
INSERT INTO `w_order_infow` VALUES ('3', '2', '0', '5a450753a97ee', null, '2.10000', '4', '200.00', '50', null, '1516627602');

-- ----------------------------
-- Table structure for w_order_list
-- ----------------------------
DROP TABLE IF EXISTS `w_order_list`;
CREATE TABLE `w_order_list` (
  `id` mediumint(9) unsigned NOT NULL AUTO_INCREMENT,
  `good_id` mediumint(9) unsigned DEFAULT NULL COMMENT '关联商品id',
  `order_id` mediumint(9) unsigned DEFAULT NULL COMMENT '入库订单id',
  `num` mediumint(9) unsigned DEFAULT NULL COMMENT '入库数量',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COMMENT='订单关联表';

-- ----------------------------
-- Records of w_order_list
-- ----------------------------
INSERT INTO `w_order_list` VALUES ('1', '1', '1', '1');
INSERT INTO `w_order_list` VALUES ('2', '3', '1', '10');
INSERT INTO `w_order_list` VALUES ('3', '6', '2', '1');
INSERT INTO `w_order_list` VALUES ('4', '5', '2', '10');
INSERT INTO `w_order_list` VALUES ('5', '4', '3', '1');
INSERT INTO `w_order_list` VALUES ('6', '3', '3', '10');
INSERT INTO `w_order_list` VALUES ('7', '6', '2', '5');

-- ----------------------------
-- Table structure for w_product
-- ----------------------------
DROP TABLE IF EXISTS `w_product`;
CREATE TABLE `w_product` (
  `id` mediumint(9) unsigned NOT NULL AUTO_INCREMENT,
  `sn` varchar(40) NOT NULL,
  `name` varchar(20) NOT NULL,
  `nbsn` varchar(40) DEFAULT NULL,
  `cjsn` varchar(40) DEFAULT NULL,
  `category` varchar(20) DEFAULT NULL,
  `storage` varchar(20) DEFAULT NULL,
  `location` varchar(20) DEFAULT NULL,
  `unit` varchar(20) DEFAULT NULL,
  `supplier` varchar(40) DEFAULT NULL,
  `customer` varchar(40) DEFAULT NULL,
  `shelve` mediumint(9) DEFAULT NULL,
  `spec` varchar(40) DEFAULT NULL COMMENT '规格',
  `price` decimal(10,2) unsigned DEFAULT NULL,
  `num` mediumint(9) unsigned NOT NULL DEFAULT '0' COMMENT '数量',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `desc` mediumtext,
  `add_time` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COMMENT='产品';

-- ----------------------------
-- Records of w_product
-- ----------------------------
INSERT INTO `w_product` VALUES ('1', '5a450753a97ee', '鞋子', '', '5a450753a97ee', '数码', '华中地区', 'A区', '双', '苏州牧冬光电有限公司', '爱美克空气过滤器', null, '', '5.00', '120', '0', '111', '1514473336');
INSERT INTO `w_product` VALUES ('2', '5a45c671401ec', '产品1', '', '5a45c671401ec', '手机', '西北仓库', 'A区', '箱', '苏州牧冬光电有限公司', '爱美克空气过滤器', null, '', '10.00', '11', '0', '', '1514522247');
INSERT INTO `w_product` VALUES ('3', '5a4644bcb7ec1', '服装', '', '5a4644bcb7ec1', '服装', '华东仓库', 'B区', '箱', '苏州牧冬光电有限公司', '爱美克空气过滤器', null, '', '50.00', '17', '0', '', '1514554572');
INSERT INTO `w_product` VALUES ('4', '5a470f4c59ebd', '荣耀V10', '', '5a470f4c59ebd', '手机', '华东仓库', 'B区', '个', '苏州牧冬光电有限公司', '爱美克空气过滤器', null, '', '1999.00', '9', '0', '', '1514606441');
INSERT INTO `w_product` VALUES ('5', '5a47110d39206', '金立s10', '', '5a47110d39206', '手机', '西南地区', 'B区', '个', '苏州牧冬光电有限公司', '爱美克空气过滤器', null, '', '2555.00', '15', '0', '', '1514606883');
INSERT INTO `w_product` VALUES ('6', '5a4711ce77e24', '小米6', '', '5a4711ce77e24', '手机', '华中地区', 'B区', '个', '苏州牧冬光电有限公司', '爱美克空气过滤器', null, '', '2499.00', '0', '0', '', '1514607078');
INSERT INTO `w_product` VALUES ('7', '5a5e0dfa45122', 'bool', '', '5a5e0dfa45122', '手机', '华东仓库', 'A区', '箱', '苏州牧冬光电有限公司', '苏州牧冬光电有限公司', null, 'www', '5.00', '0', '0', '', '1516113498');
INSERT INTO `w_product` VALUES ('8', '5a5e0e928b118', '111', '', '5a5e0e928b118', '数码', '华东仓库', 'B区', '箱', '苏州牧冬光电有限公司', '苏州牧冬光电有限公司', null, '', '50.00', '0', '0', '', '1516113559');
INSERT INTO `w_product` VALUES ('9', '5a5e0e928b118', 'buer ', '', '5a5e0e928b118', '数码', '华东仓库', 'B区', '箱', '苏州牧冬光电有限公司', '苏州牧冬光电有限公司', null, '11', '111.00', '0', '0', '', '1516113596');

-- ----------------------------
-- Table structure for w_productup
-- ----------------------------
DROP TABLE IF EXISTS `w_productup`;
CREATE TABLE `w_productup` (
  `id` mediumint(9) unsigned NOT NULL AUTO_INCREMENT,
  `gid` mediumint(9) DEFAULT NULL,
  `storage` varchar(20) DEFAULT NULL,
  `location` varchar(20) DEFAULT NULL,
  `shelve` mediumint(9) DEFAULT NULL,
  `shelve_list` varchar(20) DEFAULT NULL,
  `num` mediumint(9) unsigned NOT NULL DEFAULT '0',
  `desc` mediumtext,
  `add_time` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COMMENT='产品';

-- ----------------------------
-- Records of w_productup
-- ----------------------------
INSERT INTO `w_productup` VALUES ('1', '1', '华中地区', 'A区', '1', '2', '15', '111', '1514473336');
INSERT INTO `w_productup` VALUES ('2', '2', '西北仓库', 'A区', '2', '1', '5', '', '1514522247');
INSERT INTO `w_productup` VALUES ('7', '7', '华东仓库', 'B区', '2', '1', '0', '', '1516113596');
INSERT INTO `w_productup` VALUES ('3', '3', '华东仓库', 'B区', '1', '1', '1', null, '0');
INSERT INTO `w_productup` VALUES ('4', '4', '华东仓库', 'B区', '1', '1', '1', null, '0');
INSERT INTO `w_productup` VALUES ('5', '5', '西南地区', 'B区', '1', '1', '10', null, '0');
INSERT INTO `w_productup` VALUES ('6', '6', '华中地区', 'B区', '1', '1', '2', null, '0');
INSERT INTO `w_productup` VALUES ('8', '8', null, null, null, null, '0', null, '0');
INSERT INTO `w_productup` VALUES ('9', '9', null, null, null, null, '0', null, '0');

-- ----------------------------
-- Table structure for w_role
-- ----------------------------
DROP TABLE IF EXISTS `w_role`;
CREATE TABLE `w_role` (
  `id` mediumint(9) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(40) NOT NULL,
  `ids` mediumtext,
  `status` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `desc` mediumtext,
  `add_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of w_role
-- ----------------------------
INSERT INTO `w_role` VALUES ('1', '系统管理员', '1,2,3,16', '0', '1111111111111', '1515743511');
INSERT INTO `w_role` VALUES ('2', '仓库管理', '4,5,6,7', '0', '11111111', '1515743749');

-- ----------------------------
-- Table structure for w_shelve
-- ----------------------------
DROP TABLE IF EXISTS `w_shelve`;
CREATE TABLE `w_shelve` (
  `id` mediumint(9) unsigned NOT NULL AUTO_INCREMENT,
  `sn` varchar(40) NOT NULL,
  `name` varchar(40) NOT NULL,
  `location` mediumint(5) unsigned NOT NULL,
  `status` tinyint(1) unsigned NOT NULL COMMENT '0',
  `list` mediumtext,
  `desc` varchar(200) DEFAULT NULL COMMENT '备注',
  `add_time` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COMMENT='货架管理';

-- ----------------------------
-- Records of w_shelve
-- ----------------------------
INSERT INTO `w_shelve` VALUES ('1', '17122705595244343', 'A1', '2', '0', '1,2,3,4,5', '111', '1514368943');
INSERT INTO `w_shelve` VALUES ('2', '17122706022839995', 'A2', '2', '0', '1,2,3,4,5', '', '1514368959');
INSERT INTO `w_shelve` VALUES ('3', '18011302055978362', 'B1', '2', '0', '1,2,3,4,5', '', '1515823705');

-- ----------------------------
-- Table structure for w_storage
-- ----------------------------
DROP TABLE IF EXISTS `w_storage`;
CREATE TABLE `w_storage` (
  `id` mediumint(9) unsigned NOT NULL AUTO_INCREMENT,
  `sn` varchar(40) NOT NULL COMMENT '编号',
  `name` varchar(40) NOT NULL COMMENT '名字',
  `contact` varchar(16) NOT NULL,
  `phone` varchar(12) NOT NULL,
  `desc` mediumtext,
  `status` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '状态： 0正常 1禁用',
  `address` varchar(40) DEFAULT NULL,
  `add_time` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`),
  UNIQUE KEY `sn` (`sn`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COMMENT='仓库管理';

-- ----------------------------
-- Records of w_storage
-- ----------------------------
INSERT INTO `w_storage` VALUES ('1', 'SN2017122704154711343', '华东仓库', '布尔', '17052850083', '华东仓库', '0', '江苏省苏州市', '1514349093');
INSERT INTO `w_storage` VALUES ('2', 'SN2017122704160191249', '华北仓库', '测试', '15052850085', '华北仓库', '0', '山东省青岛市城阳区', '1514350644');
INSERT INTO `w_storage` VALUES ('3', 'SN2017122704163071894', '华南仓库', '阿德民', '18101565682', '华南仓库', '0', '广东省广州市天河区车陂', '1514351327');
INSERT INTO `w_storage` VALUES ('4', 'SN2017122704163675950', '东北仓库', '马云', '15069900798', '东北仓库', '0', '黑龙江省哈尔滨市', '1514351479');
INSERT INTO `w_storage` VALUES ('5', 'SN2017122704165667035', '西北仓库', '秦始皇', '17052850085', '西北仓库', '0', '陕西省西安市大雁区', '1514351552');
INSERT INTO `w_storage` VALUES ('6', 'SN2017122704171789530', '华中地区', '无名', '17052850083', '华中地区', '0', '湖北省武汉市汉口区', '1514351653');
INSERT INTO `w_storage` VALUES ('7', 'SN2017122704172619176', '西南地区', '张杰', '17052850086', '西南地区', '0', '四川省成都市', '1514351716');

-- ----------------------------
-- Table structure for w_supplier
-- ----------------------------
DROP TABLE IF EXISTS `w_supplier`;
CREATE TABLE `w_supplier` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `sn` varchar(40) NOT NULL,
  `name` varchar(40) NOT NULL,
  `contact` varchar(20) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `email` varchar(40) NOT NULL,
  `fax` varchar(20) NOT NULL,
  `address` varchar(40) NOT NULL,
  `desc` mediumtext,
  `status` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `add_time` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`) USING BTREE,
  UNIQUE KEY `sn` (`sn`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COMMENT='供应商';

-- ----------------------------
-- Records of w_supplier
-- ----------------------------
INSERT INTO `w_supplier` VALUES ('1', '5a44a4f6f1f18', '苏州牧冬光电有限公司', '测试', '15069900798', '30024167@qq.com', '15069900798', '江苏省苏州市长阳街', '苏州牧冬光电有限公司...', '0', '1514448252');
INSERT INTO `w_supplier` VALUES ('2', '5a6b0dcb2d8b2', '精端显示器', '布尔', '151015656875', '333@qq.com', '151015656875', '江苏省苏州市', '', '0', '1516965378');
INSERT INTO `w_supplier` VALUES ('3', '5a6b0e0a2eaad', '伟创力电子', 'bool', '111', '11@qq.com', '11', '江苏省苏州市', '', '0', '1516965414');

-- ----------------------------
-- Table structure for w_unit
-- ----------------------------
DROP TABLE IF EXISTS `w_unit`;
CREATE TABLE `w_unit` (
  `id` mediumint(9) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL,
  `status` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `desc` mediumtext,
  `add_time` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of w_unit
-- ----------------------------
INSERT INTO `w_unit` VALUES ('1', '箱', '0', '箱', '1514454975');
INSERT INTO `w_unit` VALUES ('2', '个', '0', '', '1514455204');
INSERT INTO `w_unit` VALUES ('3', '包', '0', '', '1514455226');
INSERT INTO `w_unit` VALUES ('4', '片', '0', '', '1514455232');
INSERT INTO `w_unit` VALUES ('5', '双', '0', '', '1516544029');

-- ----------------------------
-- Table structure for w_user
-- ----------------------------
DROP TABLE IF EXISTS `w_user`;
CREATE TABLE `w_user` (
  `id` mediumint(9) NOT NULL AUTO_INCREMENT,
  `sn` mediumtext,
  `username` varchar(16) NOT NULL COMMENT '用户名',
  `password` varchar(32) NOT NULL COMMENT '密码',
  `phone` varchar(12) DEFAULT NULL COMMENT '手机号',
  `eamil` varchar(100) DEFAULT NULL COMMENT '邮箱',
  `truename` varchar(16) DEFAULT NULL,
  `status` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '状态 0:正常 1:禁用',
  `desc` mediumtext,
  `add_time` int(11) unsigned DEFAULT NULL,
  `role` mediumint(10) unsigned DEFAULT NULL,
  `company` mediumint(10) unsigned DEFAULT NULL COMMENT '公司',
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COMMENT='用户表';

-- ----------------------------
-- Records of w_user
-- ----------------------------
INSERT INTO `w_user` VALUES ('1', '18011401143519201', 'bool', '21232f297a57a5a743894a0e4a801fc3', '17052850083', '30024167', '布尔', '0', null, '1515908045', '1', '1');
INSERT INTO `w_user` VALUES ('2', '18011401143519202', 'admin', '21232f297a57a5a743894a0e4a801fc3', '17052850083', '30024167', '管理员', '0', null, '1515908045', '1', '2');
INSERT INTO `w_user` VALUES ('3', '18011401143519203', 'admin1', '21232f297a57a5a743894a0e4a801fc3', '17052850083', '30024167', '布尔1111', '0', '', '1515908045', '2', '2');
