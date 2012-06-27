/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50516
Source Host           : localhost:3306
Source Database       : invictus_crosspromo

Target Server Type    : MYSQL
Target Server Version : 50516
File Encoding         : 65001

Date: 2012-06-27 15:53:56
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `cp_order`
-- ----------------------------
DROP TABLE IF EXISTS `cp_order`;
CREATE TABLE `cp_order` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `game_id` int(11) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of cp_order
-- ----------------------------
INSERT INTO `cp_order` VALUES ('1', '3', '52', '1', '2012-06-27 11:12:57');
INSERT INTO `cp_order` VALUES ('2', '3', '52', '1', '2012-06-27 11:13:40');
INSERT INTO `cp_order` VALUES ('3', '3', '52', '1', '2012-06-27 11:17:37');
INSERT INTO `cp_order` VALUES ('4', '3', '52', '1', '2012-06-27 11:20:22');
INSERT INTO `cp_order` VALUES ('5', '3', '52', '1', '2012-06-27 11:26:17');
INSERT INTO `cp_order` VALUES ('9', '3', '52', '1', '2012-06-27 12:45:50');
INSERT INTO `cp_order` VALUES ('10', '3', '52', '1', '2012-06-27 12:47:43');
INSERT INTO `cp_order` VALUES ('11', '3', '52', '1', '2012-06-27 13:19:10');
INSERT INTO `cp_order` VALUES ('12', '3', '52', '1', '2012-06-27 13:20:08');
