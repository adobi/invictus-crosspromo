/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50516
Source Host           : localhost:3306
Source Database       : invictus_crosspromo

Target Server Type    : MYSQL
Target Server Version : 50516
File Encoding         : 65001

Date: 2012-06-28 10:55:19
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `cp_category`
-- ----------------------------
DROP TABLE IF EXISTS `cp_category`;
CREATE TABLE `cp_category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of cp_category
-- ----------------------------
INSERT INTO `cp_category` VALUES ('1', 'Casual');
INSERT INTO `cp_category` VALUES ('2', 'Car');
INSERT INTO `cp_category` VALUES ('3', 'Jump');
INSERT INTO `cp_category` VALUES ('5', 'Social');
INSERT INTO `cp_category` VALUES ('6', 'Fighting');
