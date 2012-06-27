/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50516
Source Host           : localhost:3306
Source Database       : invictus_crosspromo

Target Server Type    : MYSQL
Target Server Version : 50516
File Encoding         : 65001

Date: 2012-06-27 15:53:30
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `cp_click`
-- ----------------------------
DROP TABLE IF EXISTS `cp_click`;
CREATE TABLE `cp_click` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `game_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of cp_click
-- ----------------------------
INSERT INTO `cp_click` VALUES ('5', '25', '3', '2012-06-27 08:37:31');
INSERT INTO `cp_click` VALUES ('6', '52', '3', '2012-06-27 08:40:07');
