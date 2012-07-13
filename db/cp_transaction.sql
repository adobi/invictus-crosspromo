/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50516
Source Host           : localhost:3306
Source Database       : invictus_crosspromo

Target Server Type    : MYSQL
Target Server Version : 50516
File Encoding         : 65001

Date: 2012-07-13 08:47:55
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `cp_transaction`
-- ----------------------------
DROP TABLE IF EXISTS `cp_transaction`;
CREATE TABLE `cp_transaction` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` int(11) DEFAULT NULL,
  `sku` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `category` varchar(255) DEFAULT NULL,
  `price` varchar(255) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `store_name` varchar(255) DEFAULT NULL,
  `tax` varchar(255) DEFAULT NULL,
  `shipping` varchar(255) DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `state` varchar(255) DEFAULT NULL,
  `country` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of cp_transaction
-- ----------------------------
