/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50625
Source Host           : localhost:3306
Source Database       : spos

Target Server Type    : MYSQL
Target Server Version : 50625
File Encoding         : 65001

Date: 2016-04-19 18:08:18
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for groups
-- ----------------------------
DROP TABLE IF EXISTS `groups`;
CREATE TABLE `groups` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL,
  `description` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of groups
-- ----------------------------
INSERT INTO `groups` VALUES ('1', 'admin', 'Administrator');
INSERT INTO `groups` VALUES ('2', 'members', 'General User');
INSERT INTO `groups` VALUES ('3', 'merchandiser', '');
INSERT INTO `groups` VALUES ('4', 'sales', '');

-- ----------------------------
-- Table structure for tbl_challan
-- ----------------------------
DROP TABLE IF EXISTS `tbl_challan`;
CREATE TABLE `tbl_challan` (
  `challan_id` int(255) NOT NULL AUTO_INCREMENT,
  `challan_number` varchar(255) DEFAULT NULL,
  `challan_from` varchar(255) DEFAULT NULL,
  `challan_date` date DEFAULT NULL,
  `challan_time` time DEFAULT NULL,
  PRIMARY KEY (`challan_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of tbl_challan
-- ----------------------------
INSERT INTO `tbl_challan` VALUES ('1', 'Challan 02', 'Factory', '2016-04-18', '01:41:35');
INSERT INTO `tbl_challan` VALUES ('2', 'Challan 01', 'Factory', '2016-04-18', '01:41:55');

-- ----------------------------
-- Table structure for tbl_customer
-- ----------------------------
DROP TABLE IF EXISTS `tbl_customer`;
CREATE TABLE `tbl_customer` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `customer_name` varchar(255) DEFAULT NULL,
  `customer_phone` varchar(255) DEFAULT NULL,
  `customer_email` varchar(255) DEFAULT NULL,
  `customer_address` varchar(255) DEFAULT NULL,
  `sell_by` int(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of tbl_customer
-- ----------------------------
INSERT INTO `tbl_customer` VALUES ('1', '', '', '', '', '7');
INSERT INTO `tbl_customer` VALUES ('2', '', '', '', '', '8');
INSERT INTO `tbl_customer` VALUES ('3', '', '', '', '', '8');
INSERT INTO `tbl_customer` VALUES ('4', '', '', '', '', '7');
INSERT INTO `tbl_customer` VALUES ('5', '', '', '', '', '8');
INSERT INTO `tbl_customer` VALUES ('6', 'w', '', '', '', '8');
INSERT INTO `tbl_customer` VALUES ('7', '', '', '', '', '8');
INSERT INTO `tbl_customer` VALUES ('8', '', '', '', '', '7');

-- ----------------------------
-- Table structure for tbl_inventory
-- ----------------------------
DROP TABLE IF EXISTS `tbl_inventory`;
CREATE TABLE `tbl_inventory` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) DEFAULT NULL,
  `product_left` int(11) DEFAULT NULL,
  `product_sold` int(11) DEFAULT NULL,
  `challan_no` varchar(255) DEFAULT NULL,
  `store` int(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_product` (`product_id`),
  CONSTRAINT `fk_product` FOREIGN KEY (`product_id`) REFERENCES `tbl_product` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of tbl_inventory
-- ----------------------------
INSERT INTO `tbl_inventory` VALUES ('1', '58', '2', '8', '1', '7');
INSERT INTO `tbl_inventory` VALUES ('2', '3', '4', '6', '1', '7');
INSERT INTO `tbl_inventory` VALUES ('3', '58', '1', '9', '2', '8');
INSERT INTO `tbl_inventory` VALUES ('4', '3', '3', '7', '2', '8');

-- ----------------------------
-- Table structure for tbl_order
-- ----------------------------
DROP TABLE IF EXISTS `tbl_order`;
CREATE TABLE `tbl_order` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` int(11) DEFAULT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `store_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_order_id` (`order_id`),
  KEY `fk_customer_id` (`customer_id`),
  CONSTRAINT `fk_customer_id` FOREIGN KEY (`customer_id`) REFERENCES `tbl_customer` (`id`),
  CONSTRAINT `fk_order_id` FOREIGN KEY (`order_id`) REFERENCES `tbl_orderdetail` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of tbl_order
-- ----------------------------
INSERT INTO `tbl_order` VALUES ('1', '1', '1', '7');
INSERT INTO `tbl_order` VALUES ('2', '2', '1', '7');
INSERT INTO `tbl_order` VALUES ('3', '3', '2', '8');
INSERT INTO `tbl_order` VALUES ('4', '4', '2', '8');
INSERT INTO `tbl_order` VALUES ('5', '5', '3', '8');
INSERT INTO `tbl_order` VALUES ('6', '6', '3', '8');
INSERT INTO `tbl_order` VALUES ('7', '7', '4', '7');
INSERT INTO `tbl_order` VALUES ('8', '8', '4', '7');
INSERT INTO `tbl_order` VALUES ('9', '9', '5', '8');
INSERT INTO `tbl_order` VALUES ('10', '10', '6', '8');
INSERT INTO `tbl_order` VALUES ('11', '11', '7', '8');
INSERT INTO `tbl_order` VALUES ('12', '12', '8', '7');

-- ----------------------------
-- Table structure for tbl_orderdetail
-- ----------------------------
DROP TABLE IF EXISTS `tbl_orderdetail`;
CREATE TABLE `tbl_orderdetail` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_code` int(11) DEFAULT NULL,
  `quantity` int(2) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `discount` int(11) DEFAULT NULL,
  `discount_amount` decimal(8,2) DEFAULT NULL,
  `amount` decimal(8,2) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `invoice_no` varchar(255) DEFAULT NULL,
  `booking_code` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `fk_product_code` (`product_code`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of tbl_orderdetail
-- ----------------------------
INSERT INTO `tbl_orderdetail` VALUES ('1', '58', '5', '1750.00', '0', '0.00', '8750.00', '2016-04-18', 'SIN-OL-180416-001-0001', null, '2016-04-18 17:42:08');
INSERT INTO `tbl_orderdetail` VALUES ('2', '3', '5', '2250.00', '0', '0.00', '11250.00', '2016-04-18', 'SIN-OL-180416-001-0001', null, '2016-04-18 17:42:08');
INSERT INTO `tbl_orderdetail` VALUES ('3', '58', '5', '1750.00', '0', '0.00', '8750.00', '2016-04-18', 'SIN-OT1-180416-001-0001', null, '2016-04-18 17:42:43');
INSERT INTO `tbl_orderdetail` VALUES ('4', '3', '5', '2250.00', '0', '0.00', '11250.00', '2016-04-18', 'SIN-OT1-180416-001-0001', null, '2016-04-18 17:42:43');
INSERT INTO `tbl_orderdetail` VALUES ('5', '58', '1', '1750.00', '0', '0.00', '1750.00', '2016-04-18', 'SIN-OT1-180416-002-0002', null, '2016-04-18 17:42:58');
INSERT INTO `tbl_orderdetail` VALUES ('6', '3', '1', '2250.00', '0', '0.00', '2250.00', '2016-04-18', 'SIN-OT1-180416-002-0002', null, '2016-04-18 17:42:58');
INSERT INTO `tbl_orderdetail` VALUES ('7', '58', '1', '1750.00', '0', '0.00', '1750.00', '2016-04-18', 'SIN-OL-180416-002-0002', null, '2016-04-18 17:43:17');
INSERT INTO `tbl_orderdetail` VALUES ('8', '3', '1', '2250.00', '0', '0.00', '2250.00', '2016-04-18', 'SIN-OL-180416-002-0002', null, '2016-04-18 17:43:17');
INSERT INTO `tbl_orderdetail` VALUES ('9', '58', '2', '1750.00', '0', '0.00', '3500.00', '2016-04-18', 'SIN-OT1-180416-003-0003', null, '2016-04-18 17:54:25');
INSERT INTO `tbl_orderdetail` VALUES ('10', '58', '1', '1750.00', '0', '0.00', '1750.00', '2016-04-18', 'SIN-OT1-180416-004-0004', 'FB-001', '2016-04-18 17:56:57');
INSERT INTO `tbl_orderdetail` VALUES ('11', '3', '1', '2250.00', '0', '0.00', '2250.00', '2016-04-19', 'SIN-OT1-190416-001-0005', null, '2016-04-19 16:45:23');
INSERT INTO `tbl_orderdetail` VALUES ('12', '58', '2', '1750.00', '0', '0.00', '3500.00', '2016-04-19', 'SIN-OL-190416-001-0003', '', '2016-04-19 16:46:08');

-- ----------------------------
-- Table structure for tbl_product
-- ----------------------------
DROP TABLE IF EXISTS `tbl_product`;
CREATE TABLE `tbl_product` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_name` int(11) DEFAULT NULL,
  `product_code` varchar(255) DEFAULT NULL,
  `product_color` int(11) DEFAULT NULL,
  `product_fabric` int(11) DEFAULT NULL,
  `product_price` int(4) DEFAULT NULL,
  `product_category` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_category` (`product_category`),
  KEY `fk_product_code` (`product_code`),
  KEY `fk_product_color` (`product_color`),
  KEY `fk_product_fabric` (`product_fabric`),
  KEY `fk_product_name` (`product_name`),
  CONSTRAINT `fk_product_category` FOREIGN KEY (`product_category`) REFERENCES `tbl_product_category` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_product_color` FOREIGN KEY (`product_color`) REFERENCES `tbl_product_color` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_product_fabric` FOREIGN KEY (`product_fabric`) REFERENCES `tbl_product_fabric` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_product_name` FOREIGN KEY (`product_name`) REFERENCES `tbl_product_name` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=71 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of tbl_product
-- ----------------------------
INSERT INTO `tbl_product` VALUES ('1', '3', 'WPLB-00001-15-AA', '8', '1', '1050', '1');
INSERT INTO `tbl_product` VALUES ('2', '2', 'WPLB-00002-15-AB', '8', '1', '1400', '1');
INSERT INTO `tbl_product` VALUES ('3', '3', 'SLLB-00020-15', '8', '1', '2250', '1');
INSERT INTO `tbl_product` VALUES ('4', '4', 'WPLB-00023-15', '8', '1', '600', '1');
INSERT INTO `tbl_product` VALUES ('5', '5', 'WPLB-00025-15', '8', '1', '1050', '1');
INSERT INTO `tbl_product` VALUES ('6', '6', 'WPLB-00028-15-AA', '8', '1', '650', '1');
INSERT INTO `tbl_product` VALUES ('7', '7', 'WPLB-00029-15', '8', '1', '1550', '1');
INSERT INTO `tbl_product` VALUES ('8', '8', 'WPLB-00030-15-AA', '8', '1', '1250', '1');
INSERT INTO `tbl_product` VALUES ('9', '9', 'WPLB-00031-15', '8', '1', '1450', '1');
INSERT INTO `tbl_product` VALUES ('10', '10', 'SLLB-00033-15-AC', '8', '1', '1950', '1');
INSERT INTO `tbl_product` VALUES ('11', '11', 'WPLTB-00065-15-AC', '8', '1', '1000', '1');
INSERT INTO `tbl_product` VALUES ('12', '12', 'WPLTB-00068-15-AB', '8', '1', '980', '2');
INSERT INTO `tbl_product` VALUES ('13', '13', 'WPLB-00070-15-AA', '8', '1', '1250', '2');
INSERT INTO `tbl_product` VALUES ('14', '14', 'WPBP-00072-15-AA', '8', '1', '1050', '2');
INSERT INTO `tbl_product` VALUES ('15', '15', 'WPSHB-00076-15', '8', '1', '2250', '2');
INSERT INTO `tbl_product` VALUES ('16', '16', 'SLSHB-00077-15', '8', '1', '2500', '2');
INSERT INTO `tbl_product` VALUES ('17', '17', 'SLSHB-00078-15', '8', '1', '3000', '2');
INSERT INTO `tbl_product` VALUES ('18', '18', 'SLSHB-00079-15', '8', '4', '1800', '2');
INSERT INTO `tbl_product` VALUES ('19', '19', 'WPLB-00018-15', '8', '1', '350', '3');
INSERT INTO `tbl_product` VALUES ('20', '20', 'WPLB-00022-15', '8', '1', '350', '3');
INSERT INTO `tbl_product` VALUES ('21', '21', 'WPLB-00038-15', '8', '1', '380', '3');
INSERT INTO `tbl_product` VALUES ('22', '22', 'WPLB-00063-15', '8', '1', '350', '3');
INSERT INTO `tbl_product` VALUES ('23', '23', 'WPLB-00064-15', '8', '1', '550', '3');
INSERT INTO `tbl_product` VALUES ('25', '9', 'WPLB-00080-15', '1', '4', '380', '2');
INSERT INTO `tbl_product` VALUES ('26', '8', 'WPLB-00081-15', '8', '1', '380', '1');
INSERT INTO `tbl_product` VALUES ('27', '6', 'SLLB-00027-15', '8', '1', '1050', '1');
INSERT INTO `tbl_product` VALUES ('56', '27', 'SLLB-00034-15', '8', '5', '1800', '1');
INSERT INTO `tbl_product` VALUES ('57', '1', 'SLLB-00035-15', '8', '5', '2450', '1');
INSERT INTO `tbl_product` VALUES ('58', '2', 'CHN-04', '8', '5', '1750', '1');
INSERT INTO `tbl_product` VALUES ('59', '23', 'WPLB-00083-15-AA', '8', '5', '530', '3');
INSERT INTO `tbl_product` VALUES ('60', '11', 'SLLB-00049-15', '8', '5', '2350', '1');
INSERT INTO `tbl_product` VALUES ('61', '5', 'WPLB-00082-15', '8', '5', '700', '1');
INSERT INTO `tbl_product` VALUES ('62', '4', 'WPLB-00070-15-AB', '8', '2', '1250', '1');
INSERT INTO `tbl_product` VALUES ('63', '4', 'WPLB-00070-15-AC', '8', '5', '1250', '1');
INSERT INTO `tbl_product` VALUES ('64', '5', 'WPLB-00030-15-AB', '8', '4', '1250', '1');
INSERT INTO `tbl_product` VALUES ('65', '5', 'WPLB-00030-15-AC', '8', '5', '1250', '1');
INSERT INTO `tbl_product` VALUES ('66', '4', 'WPLB-00001-15-AB', '8', '4', '1050', '1');
INSERT INTO `tbl_product` VALUES ('67', '4', 'WPLB-00001-15-AC', '8', '4', '1050', '1');
INSERT INTO `tbl_product` VALUES ('68', '5', 'WPLB-00018-AQ', '8', '5', '350', '1');
INSERT INTO `tbl_product` VALUES ('69', '23', 'WPLB-00018-AW', '8', '5', '350', '3');
INSERT INTO `tbl_product` VALUES ('70', '4', 'WPLB-00028-15-AB', '8', '5', '650', '3');

-- ----------------------------
-- Table structure for tbl_product_category
-- ----------------------------
DROP TABLE IF EXISTS `tbl_product_category`;
CREATE TABLE `tbl_product_category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_category_name` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of tbl_product_category
-- ----------------------------
INSERT INTO `tbl_product_category` VALUES ('1', 'Ladies Bag');
INSERT INTO `tbl_product_category` VALUES ('2', 'Gents Bag');
INSERT INTO `tbl_product_category` VALUES ('3', 'Tote Bag');

-- ----------------------------
-- Table structure for tbl_product_code
-- ----------------------------
DROP TABLE IF EXISTS `tbl_product_code`;
CREATE TABLE `tbl_product_code` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_code` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of tbl_product_code
-- ----------------------------

-- ----------------------------
-- Table structure for tbl_product_color
-- ----------------------------
DROP TABLE IF EXISTS `tbl_product_color`;
CREATE TABLE `tbl_product_color` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_color` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of tbl_product_color
-- ----------------------------
INSERT INTO `tbl_product_color` VALUES ('1', 'Black');
INSERT INTO `tbl_product_color` VALUES ('2', 'Red');
INSERT INTO `tbl_product_color` VALUES ('3', 'Blue');
INSERT INTO `tbl_product_color` VALUES ('4', 'Navy Blue');
INSERT INTO `tbl_product_color` VALUES ('5', 'Orange');
INSERT INTO `tbl_product_color` VALUES ('6', 'Pink');
INSERT INTO `tbl_product_color` VALUES ('7', 'Yellow');
INSERT INTO `tbl_product_color` VALUES ('8', 'Other');

-- ----------------------------
-- Table structure for tbl_product_fabric
-- ----------------------------
DROP TABLE IF EXISTS `tbl_product_fabric`;
CREATE TABLE `tbl_product_fabric` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_fabric_name` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of tbl_product_fabric
-- ----------------------------
INSERT INTO `tbl_product_fabric` VALUES ('1', 'Polyester');
INSERT INTO `tbl_product_fabric` VALUES ('2', 'Nilon');
INSERT INTO `tbl_product_fabric` VALUES ('3', 'PU Leather');
INSERT INTO `tbl_product_fabric` VALUES ('4', 'Mix');
INSERT INTO `tbl_product_fabric` VALUES ('5', 'Other');

-- ----------------------------
-- Table structure for tbl_product_name
-- ----------------------------
DROP TABLE IF EXISTS `tbl_product_name`;
CREATE TABLE `tbl_product_name` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_name` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of tbl_product_name
-- ----------------------------
INSERT INTO `tbl_product_name` VALUES ('1', 'Leather Fashion Bag');
INSERT INTO `tbl_product_name` VALUES ('2', 'Hot Fashion Bag');
INSERT INTO `tbl_product_name` VALUES ('3', 'Jacquard Handbag');
INSERT INTO `tbl_product_name` VALUES ('4', 'Smart Handbag');
INSERT INTO `tbl_product_name` VALUES ('5', 'Simple Handbag');
INSERT INTO `tbl_product_name` VALUES ('6', 'Premium Handbag');
INSERT INTO `tbl_product_name` VALUES ('7', 'Portrait Two Tone Bag');
INSERT INTO `tbl_product_name` VALUES ('8', 'Contrast Color Handbag');
INSERT INTO `tbl_product_name` VALUES ('9', 'Cheetah Pattern Fashion Bag');
INSERT INTO `tbl_product_name` VALUES ('10', 'Foldable Fashion Bag');
INSERT INTO `tbl_product_name` VALUES ('11', 'Leather Handbag');
INSERT INTO `tbl_product_name` VALUES ('12', 'Large Laptop Bag');
INSERT INTO `tbl_product_name` VALUES ('13', 'Small Laptop Bag');
INSERT INTO `tbl_product_name` VALUES ('14', 'Smart Office Bag');
INSERT INTO `tbl_product_name` VALUES ('15', 'Small Smart Office Bag');
INSERT INTO `tbl_product_name` VALUES ('16', 'Soft Leather Bag');
INSERT INTO `tbl_product_name` VALUES ('17', 'Leather Gents Bag');
INSERT INTO `tbl_product_name` VALUES ('18', 'Smart Backpack');
INSERT INTO `tbl_product_name` VALUES ('19', 'America Bag');
INSERT INTO `tbl_product_name` VALUES ('20', 'Flower Two Toned Bag');
INSERT INTO `tbl_product_name` VALUES ('21', 'Textile Printed Bag');
INSERT INTO `tbl_product_name` VALUES ('22', 'Flower Printed Bag');
INSERT INTO `tbl_product_name` VALUES ('23', 'Printed Bag');
INSERT INTO `tbl_product_name` VALUES ('24', 'Striped Printed Bag');
INSERT INTO `tbl_product_name` VALUES ('25', 'Love Bag');
INSERT INTO `tbl_product_name` VALUES ('26', 'Leather Contrast Bag');
INSERT INTO `tbl_product_name` VALUES ('27', 'China Ladies Bag');

-- ----------------------------
-- Table structure for tbl_product_size
-- ----------------------------
DROP TABLE IF EXISTS `tbl_product_size`;
CREATE TABLE `tbl_product_size` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_size_length` decimal(4,2) DEFAULT NULL,
  `product_size_width` decimal(4,2) DEFAULT NULL,
  `product_size_bottom` decimal(4,2) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of tbl_product_size
-- ----------------------------

-- ----------------------------
-- Table structure for tbl_sales_person
-- ----------------------------
DROP TABLE IF EXISTS `tbl_sales_person`;
CREATE TABLE `tbl_sales_person` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sales_person_name` varchar(255) DEFAULT NULL,
  `sales_person_email` varchar(255) DEFAULT NULL,
  `sales_person_phone` varchar(255) DEFAULT NULL,
  `sales_person_assigned_store` int(11) DEFAULT NULL,
  `sales_person_user_id` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_store_id` (`sales_person_assigned_store`),
  KEY `fk_sales_person_user_id` (`sales_person_user_id`),
  CONSTRAINT `fk_sales_person_user_id` FOREIGN KEY (`sales_person_user_id`) REFERENCES `users` (`id`),
  CONSTRAINT `fk_store_id` FOREIGN KEY (`sales_person_assigned_store`) REFERENCES `tbl_store` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of tbl_sales_person
-- ----------------------------

-- ----------------------------
-- Table structure for tbl_store
-- ----------------------------
DROP TABLE IF EXISTS `tbl_store`;
CREATE TABLE `tbl_store` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `store_name` varchar(255) DEFAULT NULL,
  `store_address` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of tbl_store
-- ----------------------------
INSERT INTO `tbl_store` VALUES ('1', 'Outlet 1', 'Aziz Super Market');
INSERT INTO `tbl_store` VALUES ('2', 'Outlet 2', 'Head Office');

-- ----------------------------
-- Table structure for users
-- ----------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `ip_address` varchar(15) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `salt` varchar(255) DEFAULT NULL,
  `email` varchar(100) NOT NULL,
  `activation_code` varchar(40) DEFAULT NULL,
  `forgotten_password_code` varchar(40) DEFAULT NULL,
  `forgotten_password_time` int(11) unsigned DEFAULT NULL,
  `remember_code` varchar(40) DEFAULT NULL,
  `created_on` int(11) unsigned NOT NULL,
  `last_login` int(11) unsigned DEFAULT NULL,
  `active` tinyint(1) unsigned DEFAULT NULL,
  `first_name` varchar(50) DEFAULT NULL,
  `last_name` varchar(50) DEFAULT NULL,
  `company` varchar(100) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of users
-- ----------------------------
INSERT INTO `users` VALUES ('1', '127.0.0.1', 'admin', '$2a$07$SeBknntpZror9uyftVopmu61qg0ms8Qv1yV6FG.kQOSM.9QhmTo36', '', 'admin@admin.com', null, null, null, null, '1268889823', '1461065740', '1', 'Admin', 'istrator', 'ADMIN', '0');
INSERT INTO `users` VALUES ('7', '127.0.0.1', 'online', '$2y$08$2c4wydArnkhg3u8GGSmg/e7GrtV1OwO9TbdJA2bP4oHFWH24EF5Tm', null, 'designer@simuragroup.com', null, null, null, null, '1451381608', '1461062748', '1', 'Online', 'Sales', 'SIMURA Non Wovens Ltd.', '017');
INSERT INTO `users` VALUES ('8', '127.0.0.1', 'outlet1', '$2y$08$dMU1oTWxI87LSa2AkC5Hq.S3BoQ8RPCTeH.f.GHnlsKl4QmQa76Mq', null, 'outlet1@simuragroup.com', null, null, null, null, '1455704819', '1461062574', '1', 'Outlet 1', 'Aziz Super Market', 'SIMURA Non-Wovens Ltd.', '01720223388');

-- ----------------------------
-- Table structure for users_groups
-- ----------------------------
DROP TABLE IF EXISTS `users_groups`;
CREATE TABLE `users_groups` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) unsigned NOT NULL,
  `group_id` mediumint(8) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uc_users_groups` (`user_id`,`group_id`),
  KEY `fk_users_groups_users1_idx` (`user_id`),
  KEY `fk_users_groups_groups1_idx` (`group_id`),
  CONSTRAINT `fk_users_groups_groups1` FOREIGN KEY (`group_id`) REFERENCES `groups` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `fk_users_groups_users1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=39 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of users_groups
-- ----------------------------
INSERT INTO `users_groups` VALUES ('33', '1', '1');
INSERT INTO `users_groups` VALUES ('36', '7', '4');
INSERT INTO `users_groups` VALUES ('38', '8', '4');

-- ----------------------------
-- Table structure for users_stores
-- ----------------------------
DROP TABLE IF EXISTS `users_stores`;
CREATE TABLE `users_stores` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `store_id` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of users_stores
-- ----------------------------
INSERT INTO `users_stores` VALUES ('1', '8', '1');
