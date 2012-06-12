/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50516
Source Host           : localhost:3306
Source Database       : invictus_crosspromo

Target Server Type    : MYSQL
Target Server Version : 50516
File Encoding         : 65001

Date: 2012-06-12 13:33:20
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `cp_crosspromo`
-- ----------------------------
DROP TABLE IF EXISTS `cp_crosspromo`;
CREATE TABLE `cp_crosspromo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `base_game_id` int(11) DEFAULT NULL,
  `promo_game_id` int(11) DEFAULT NULL,
  `order` int(11) DEFAULT NULL,
  `ga_category` varchar(250) DEFAULT NULL,
  `ga_action` varchar(250) DEFAULT NULL,
  `ga_label` varchar(250) DEFAULT NULL,
  `ga_value` int(11) DEFAULT NULL,
  `ga_noninteraction` int(11) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `until` datetime DEFAULT NULL,
  `list_id` int(11) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `type_id` int(11) DEFAULT NULL,
  `promo_price` double DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_crosspromo_base_game_platform` (`base_game_id`),
  KEY `fk_crosspromo_promo_game_id` (`promo_game_id`),
  KEY `fk_crosspromo_crosspromo_list` (`list_id`),
  KEY `fk_crosspromo_crosspromo_typ` (`type_id`),
  CONSTRAINT `fk_crosspromo_crosspromo_list` FOREIGN KEY (`list_id`) REFERENCES `cp_crosspromo_list` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_crosspromo_crosspromo_typ` FOREIGN KEY (`type_id`) REFERENCES `cp_crosspromo_type` (`id`) ON DELETE SET NULL ON UPDATE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- ----------------------------
-- Records of cp_crosspromo
-- ----------------------------
INSERT INTO `cp_crosspromo` VALUES ('19', '75', '85', '1000', 'Crosspromo - alma', 'Click', '4x4 Jam - 0 - alma - 1339080797', '1', null, null, '2012-06-28 00:00:00', '32', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry.', '6', '1.99', '- 20%');
INSERT INTO `cp_crosspromo` VALUES ('20', '75', '85', '1000', 'Crosspromo - Free', 'Click', '4x4 Jam - 0 - Free - 1339420311', '1', null, null, '2012-06-30 00:00:00', '36', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry.', '9', '1.99', 'Free all over the world');
INSERT INTO `cp_crosspromo` VALUES ('21', '75', '84', '1000', 'Crosspromo - Free', 'Click', '4x4 Jam - 0 - Free - 1339420311', '1', null, null, '0000-00-00 00:00:00', '36', '', '7', '2.99', '');
INSERT INTO `cp_crosspromo` VALUES ('22', '75', '77', '1000', 'Crosspromo - Free', 'Click', 'Blastwave - 0 - Free - 1339420311', '1', null, null, null, '36', null, null, null, null);
INSERT INTO `cp_crosspromo` VALUES ('23', '75', '83', '1000', 'Crosspromo - Free', 'Click', 'Fly Fu Pro - 0 - Free - 1339420311', '1', null, null, null, '36', null, null, null, null);
INSERT INTO `cp_crosspromo` VALUES ('24', '75', '56', '1000', 'Crosspromo - Free', 'Click', 'Fly Control - 0 - Free - 1339420311', '1', null, null, null, '36', null, null, null, null);
INSERT INTO `cp_crosspromo` VALUES ('25', '75', '52', '1000', 'Crosspromo - Free', 'Click', 'Froggy Jump - 0 - Free - 1339420311', '1', null, null, null, '36', null, null, null, null);
INSERT INTO `cp_crosspromo` VALUES ('26', '75', '25', '1000', 'Crosspromo - Free', 'Click', 'Greed Corp - 0 - Free - 1339420311', '1', null, null, null, '36', null, null, null, null);
INSERT INTO `cp_crosspromo` VALUES ('27', '75', '52', '1000', 'Crosspromo - Offer', 'Click', 'Froggy Jump - 0 - Offer - 1339146929', '1', null, null, null, '33', null, null, null, null);
INSERT INTO `cp_crosspromo` VALUES ('28', '75', '50', '1000', 'Crosspromo - Offer', 'Click', 'Froggy Launcher - 0 - Offer - 1339146930', '1', null, null, null, '33', null, null, null, null);
INSERT INTO `cp_crosspromo` VALUES ('29', '75', '28', '1000', 'Crosspromo - Offer', 'Click', 'Greed Corp - 0 - Offer - 1339146932', '1', null, null, null, '33', null, null, null, null);

-- ----------------------------
-- Table structure for `cp_crosspromo_list`
-- ----------------------------
DROP TABLE IF EXISTS `cp_crosspromo_list`;
CREATE TABLE `cp_crosspromo_list` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `game_id` int(11) DEFAULT NULL,
  `order` int(11) DEFAULT NULL,
  `ga_category` varchar(255) DEFAULT NULL,
  `ga_action` varchar(255) DEFAULT NULL,
  `ga_label` varchar(255) DEFAULT NULL,
  `ga_value` int(11) DEFAULT NULL,
  `ga_noninteraction` int(11) DEFAULT NULL,
  `is_active` int(11) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_crosspromo_list_game_platforms` (`game_id`)
) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of cp_crosspromo_list
-- ----------------------------
INSERT INTO `cp_crosspromo_list` VALUES ('32', 'Hot', '75', '1', null, null, null, null, null, '1', '1339069995_icon-hot.png');
INSERT INTO `cp_crosspromo_list` VALUES ('33', 'Offer', '75', '2', null, null, null, null, null, '1', '1338993077_icon-offer.png');
INSERT INTO `cp_crosspromo_list` VALUES ('36', 'Free', '75', '0', null, null, null, null, null, '1', '1338993086_icon-hot.png');

-- ----------------------------
-- Table structure for `cp_crosspromo_type`
-- ----------------------------
DROP TABLE IF EXISTS `cp_crosspromo_type`;
CREATE TABLE `cp_crosspromo_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `text` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of cp_crosspromo_type
-- ----------------------------
INSERT INTO `cp_crosspromo_type` VALUES ('4', 'Nothing', null, null);
INSERT INTO `cp_crosspromo_type` VALUES ('6', 'Sale', '1339076584_icon-new.png', null);
INSERT INTO `cp_crosspromo_type` VALUES ('7', 'Update', '1339076603_icon-update.png', 'Update now');
INSERT INTO `cp_crosspromo_type` VALUES ('8', 'Featured', '1339076652_icon-update.png', null);
INSERT INTO `cp_crosspromo_type` VALUES ('9', 'New', '1339076633_icon-new.png', 'Download now');

-- ----------------------------
-- Table structure for `cp_game`
-- ----------------------------
DROP TABLE IF EXISTS `cp_game`;
CREATE TABLE `cp_game` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `meta_id` int(11) DEFAULT NULL,
  `name` varchar(150) DEFAULT NULL,
  `url` varchar(150) DEFAULT NULL,
  `released` datetime DEFAULT NULL,
  `logo` varchar(250) DEFAULT NULL,
  `hero_image` varchar(150) DEFAULT NULL,
  `teaser_image` varchar(150) DEFAULT NULL,
  `short_description` varchar(150) DEFAULT NULL,
  `long_description` text,
  `is_active` int(11) DEFAULT NULL,
  `facebook_app_id` varchar(150) DEFAULT NULL,
  `twitter_page` varchar(150) DEFAULT NULL,
  `facebook_page` varchar(250) DEFAULT NULL,
  `order` int(11) DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_game_meta` (`meta_id`),
  KEY `fk_game_game_category` (`category_id`),
  CONSTRAINT `fk_game_game_category` FOREIGN KEY (`category_id`) REFERENCES `cp_game_category` (`id`) ON DELETE SET NULL ON UPDATE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=38 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of cp_game
-- ----------------------------
INSERT INTO `cp_game` VALUES ('13', null, 'Race of Champions', 'race-of-champions', null, '1339500634_1334598165_Icon170.png', null, null, null, null, '1', null, null, null, null, null);
INSERT INTO `cp_game` VALUES ('14', null, 'Greed Corp', 'greed-corp', null, '1339500634_1334672493_Greed_Corp_Icon.png', null, null, null, null, '1', null, null, null, null, null);
INSERT INTO `cp_game` VALUES ('15', null, 'Wild Slide', 'wild-slide', null, '1339500634_1335445561_Wild_Slide_Icon.png', null, null, null, null, '1', null, null, null, null, null);
INSERT INTO `cp_game` VALUES ('16', null, 'Groovy Garage', 'groovy-garage', null, '1339500634_1334918503_facebook_logo.png', null, null, null, null, '1', null, null, null, null, null);
INSERT INTO `cp_game` VALUES ('17', null, 'Froggy Jump', 'froggy-jump', null, '1339500634_1334757893_Froggy_Jump_Icon.png', null, null, null, null, '1', null, null, null, null, null);
INSERT INTO `cp_game` VALUES ('19', null, 'Mist Bouncer', 'mist-bouncer', null, '1339500634_1334844880_Mist_Bouncer_Icon.png', null, null, null, null, '1', null, null, null, null, null);
INSERT INTO `cp_game` VALUES ('20', null, 'Froggy Launcher', 'froggy-launcher', null, '1339500634_1335445614_Froggy_Launcher_Icon.png', null, null, null, null, '1', null, null, null, null, null);
INSERT INTO `cp_game` VALUES ('22', null, 'Truck Jam', 'truck-jam', null, '1339500634_1335445472_Truck_Jam_Icon.png', null, null, null, null, '1', null, null, null, null, null);
INSERT INTO `cp_game` VALUES ('23', null, '1nsane', '1nsane', null, '1339500634_1334924690_1nsane_Icon.png', null, null, null, null, '1', null, null, null, null, null);
INSERT INTO `cp_game` VALUES ('24', null, 'Overspeed', 'overspeed', null, '1339500634_1334923840_Overspeed_Icon.png', null, null, null, null, '1', null, null, null, null, null);
INSERT INTO `cp_game` VALUES ('26', null, 'L.A. Street Racing', 'la-street-racing', null, '1339500634_1334925376_LASR_Icon.png', null, null, null, null, '1', null, null, null, null, null);
INSERT INTO `cp_game` VALUES ('27', null, 'Monster Garage', 'monster-garage', null, '1339500634_1335172442_Monster_Garage_Icon.png', null, null, null, null, '1', null, null, null, null, null);
INSERT INTO `cp_game` VALUES ('28', null, 'Cross Racing Championship', 'cross-racing-championship', null, '1339500634_1335259854_CRC_Icon.png', null, null, null, null, '1', null, null, null, null, null);
INSERT INTO `cp_game` VALUES ('29', null, 'Heat Online', 'heat-online', null, '1339500634_1335259869_Heat_Online_Icon.png', null, null, null, null, '1', null, null, null, null, null);
INSERT INTO `cp_game` VALUES ('30', null, 'Street Legal', 'street-legal', null, '1339500634_1335259945_Street_Legal_Icon.png', null, null, null, null, '1', null, null, null, null, null);
INSERT INTO `cp_game` VALUES ('32', null, 'Santa Ride!', 'santa-ride', null, '1339500634_1335355309_Santa_Ride_Icon.png', null, null, null, null, '1', null, null, null, null, null);
INSERT INTO `cp_game` VALUES ('33', null, 'Fly Control', 'fly-control', null, '1339500634_1335433597_fly_control_icon.png', null, null, null, null, '1', null, null, null, null, null);
INSERT INTO `cp_game` VALUES ('34', null, 'Blastwave', 'blastwave', null, '1339500634_1335452187_Blastwave_Icon.png', null, null, null, null, '1', null, null, null, null, null);
INSERT INTO `cp_game` VALUES ('35', null, 'Grim Filler', 'grim-filler', null, '1339500634_1335452950_Grim_Filler_Icon.png', null, null, null, null, '1', null, null, null, null, null);
INSERT INTO `cp_game` VALUES ('36', null, 'Fly Fu Pro', 'fly-fu-pro', null, '1339500634_1335470790_Fly_Fu_Pro_Icon.jpg', null, null, null, null, '1', null, null, null, null, null);
INSERT INTO `cp_game` VALUES ('37', null, '4x4 Jam', '4x4-jam', null, '1339500634_1335508062_4x4jam_icon.png', null, null, null, null, '1', null, null, null, null, null);

-- ----------------------------
-- Table structure for `cp_game_category`
-- ----------------------------
DROP TABLE IF EXISTS `cp_game_category`;
CREATE TABLE `cp_game_category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(150) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of cp_game_category
-- ----------------------------

-- ----------------------------
-- Table structure for `cp_game_platform`
-- ----------------------------
DROP TABLE IF EXISTS `cp_game_platform`;
CREATE TABLE `cp_game_platform` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `game_id` int(11) DEFAULT NULL,
  `platform_id` int(11) DEFAULT NULL,
  `url` varchar(250) DEFAULT NULL,
  `long_url` varchar(250) DEFAULT NULL,
  `min_os_version` varchar(20) DEFAULT NULL,
  `version` varchar(20) DEFAULT NULL,
  `ga_category` varchar(255) DEFAULT NULL,
  `ga_action` varchar(255) DEFAULT NULL,
  `ga_label` varchar(255) DEFAULT NULL,
  `ga_value` int(11) DEFAULT NULL,
  `ga_noninteraction` int(11) DEFAULT NULL,
  `is_new` int(11) DEFAULT NULL,
  `is_update` int(11) DEFAULT NULL,
  `price` double DEFAULT NULL,
  `currency` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_game_platform_game` (`game_id`),
  KEY `fk_game_platform_platform` (`platform_id`)
) ENGINE=InnoDB AUTO_INCREMENT=89 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of cp_game_platform
-- ----------------------------
INSERT INTO `cp_game_platform` VALUES ('24', '14', '2', 'http://bit.ly/HF9qGA', 'http://itunes.apple.com/us/app/greed-corp/id484852980', '0', '0', null, null, null, null, null, null, null, '0', '');
INSERT INTO `cp_game_platform` VALUES ('25', '14', '5', 'http://bit.ly/HF9vKt', 'http://itunes.apple.com/us/app/greed-corp-hd/id468398642', '0', '0', null, null, null, null, null, null, null, '0', '');
INSERT INTO `cp_game_platform` VALUES ('26', '14', '1', 'http://bit.ly/HF9Exz', 'http://itunes.apple.com/us/app/greed-corp/id470513549', '0', '0', null, null, null, null, null, null, null, '0', '');
INSERT INTO `cp_game_platform` VALUES ('27', '14', '8', 'http://bit.ly/HF9K8o', 'https://play.google.com/store/apps/details?id=com.Invictus.GreedCorp', '0', '0', null, null, null, null, null, null, null, '0', '');
INSERT INTO `cp_game_platform` VALUES ('28', '14', '7', 'http://bit.ly/HF9MNH', 'https://play.google.com/store/apps/details?id=com.Invictus.GreedCorpMobile', '0', '0', null, null, null, null, null, null, null, '0', '');
INSERT INTO `cp_game_platform` VALUES ('29', '15', '2', 'http://bit.ly/HSOTCc', 'http://itunes.apple.com/us/app/wild-slide/id417218572', '0', '0', null, null, null, null, null, null, null, '0', '');
INSERT INTO `cp_game_platform` VALUES ('30', '16', '10', 'http://bit.ly/HHwftm', 'https://apps.facebook.com/groovygarage', '0', '0', null, null, null, null, null, null, null, '0', '');
INSERT INTO `cp_game_platform` VALUES ('33', '18', '2', 'http://bit.ly/J4xiZ6', 'http://itunes.apple.com/us/app/fly-fu/id372157319', '0', '0', null, null, null, null, null, null, null, '0', '');
INSERT INTO `cp_game_platform` VALUES ('42', '22', '2', 'http://bit.ly/JtUYFA', 'http://itunes.apple.com/gb/app/truck-jam/id394077788', '0', '0', null, null, null, null, null, null, null, '0', '');
INSERT INTO `cp_game_platform` VALUES ('43', '22', '5', 'http://bit.ly/JtV5kt', 'http://itunes.apple.com/us/app/truck-jam-hd/id411878909', '0', '0', null, null, null, null, null, null, null, '0', '');
INSERT INTO `cp_game_platform` VALUES ('44', '22', '1', 'http://bit.ly/JtV7sw', 'http://itunes.apple.com/us/app/truck-jam/id434392031', '0', '0', null, null, null, null, null, null, null, '0', '');
INSERT INTO `cp_game_platform` VALUES ('45', '13', '2', 'http://bit.ly/IagfVQ', 'http://itunes.apple.com/gb/app/race-champions-official-game/id469354336', '4', '10', null, null, null, null, null, null, null, '2.99', '$');
INSERT INTO `cp_game_platform` VALUES ('46', '13', '5', 'http://bit.ly/IagfVQ', 'http://itunes.apple.com/gb/app/race-champions-official-game/id469354336', '0', '0', null, null, null, null, null, null, null, '0', '');
INSERT INTO `cp_game_platform` VALUES ('47', '13', '7', 'http://bit.ly/IagpMX', 'https://play.google.com/store/apps/details?id=com.invictus.roc', '0', '0', null, null, null, null, null, null, null, '0', '');
INSERT INTO `cp_game_platform` VALUES ('48', '13', '8', 'http://bit.ly/IagpMX', 'https://play.google.com/store/apps/details?id=com.invictus.roc', '0', '0', null, null, null, null, null, null, null, '0', '');
INSERT INTO `cp_game_platform` VALUES ('50', '20', '2', 'http://bit.ly/HTggYe', 'http://itunes.apple.com/us/app/froggy-launcher/id388925104', '0', '0', null, null, null, null, null, null, null, '0', '');
INSERT INTO `cp_game_platform` VALUES ('51', '19', '2', 'http://bit.ly/J4ynjz', 'http://itunes.apple.com/us/app/mist-bouncer/id484449814', '0', '0', null, null, null, null, null, null, null, '0', '');
INSERT INTO `cp_game_platform` VALUES ('52', '17', '2', 'http://bit.ly/y2rJcR', 'http://itunes.apple.com/us/app/froggy-jump/id364355046', '0', '0', null, null, null, null, null, null, null, '0', '');
INSERT INTO `cp_game_platform` VALUES ('53', '32', '2', 'http://bit.ly/JMeNaU', 'http://itunes.apple.com/us/app/santa-ride!-hd/id487630157', '0', '0', null, null, null, null, null, null, null, '0', '');
INSERT INTO `cp_game_platform` VALUES ('54', '32', '7', 'http://bit.ly/I9dDDU', 'https://play.google.com/store/apps/details?id=com.invictus.santaride', '0', '0', null, null, null, null, null, null, null, '0', '');
INSERT INTO `cp_game_platform` VALUES ('55', '33', '2', 'http://bit.ly/K9UMq9', 'http://itunes.apple.com/us/app/fly-control/id346111596', '0', '0', null, null, null, null, null, null, null, '0', '');
INSERT INTO `cp_game_platform` VALUES ('56', '33', '5', 'http://bit.ly/K9UMq9', 'http://itunes.apple.com/us/app/fly-control/id346111596', '0', '0', null, null, null, null, null, null, null, '0', '');
INSERT INTO `cp_game_platform` VALUES ('61', '32', '13', 'http://bit.ly/vM5quo', 'http://santaride.invictus.com/', '0', '0', null, null, null, null, null, null, null, '0', '');
INSERT INTO `cp_game_platform` VALUES ('62', '30', '13', '', '', '0', '0', null, null, null, null, null, null, null, '0', '');
INSERT INTO `cp_game_platform` VALUES ('63', '29', '13', 'http://bit.ly/KgV4vR', 'http://heatonline.com/', '0', '0', null, null, null, null, null, null, null, '0', '');
INSERT INTO `cp_game_platform` VALUES ('64', '28', '13', '', '', '0', '0', null, null, null, null, null, null, null, '0', '');
INSERT INTO `cp_game_platform` VALUES ('65', '27', '13', '', '', '0', '0', null, null, null, null, null, null, null, '0', '');
INSERT INTO `cp_game_platform` VALUES ('66', '26', '13', '', '', '0', '0', null, null, null, null, null, null, null, '0', '');
INSERT INTO `cp_game_platform` VALUES ('69', '17', '7', 'http://bit.ly/IbufL7', 'https://play.google.com/store/apps/details?id=org.invictus.froggyjumpx', '0', '0', null, null, null, null, null, null, null, '0', '');
INSERT INTO `cp_game_platform` VALUES ('72', '19', '5', 'http://bit.ly/J4ynjz', 'http://itunes.apple.com/us/app/mist-bouncer/id484449814', '0', '0', null, null, null, null, null, null, null, '0', '');
INSERT INTO `cp_game_platform` VALUES ('73', '32', '5', 'http://bit.ly/JMeNaU', 'http://itunes.apple.com/us/app/santa-ride!-hd/id487630157', '0', '0', null, null, null, null, null, null, null, '0', '');
INSERT INTO `cp_game_platform` VALUES ('74', '32', '1', 'http://bit.ly/JMeNaU', 'http://itunes.apple.com/us/app/santa-ride!-hd/id487630157', '0', '0', null, null, null, null, null, null, null, '0', '');
INSERT INTO `cp_game_platform` VALUES ('75', '23', '13', '', '', '0', '0', null, null, null, null, null, null, null, '0', '');
INSERT INTO `cp_game_platform` VALUES ('76', '24', '13', '', '', '0', '0', null, null, null, null, null, null, null, '0', '');
INSERT INTO `cp_game_platform` VALUES ('77', '34', '2', 'http://bit.ly/I3V6HX', 'http://itunes.apple.com/us/app/blastwave/id339984708', '0', '0', null, null, null, null, null, null, null, '0', '');
INSERT INTO `cp_game_platform` VALUES ('78', '35', '2', 'http://bit.ly/JsJ5Mu', 'http://itunes.apple.com/us/app/grim-filler/id335315069', '0', '0', null, null, null, null, null, null, null, '0', '');
INSERT INTO `cp_game_platform` VALUES ('79', '18', '12', 'http://bit.ly/HSlFU8', 'http://uk.playstation.com/psn/games/detail/item304526/Fly-Fu/', '0', '0', null, null, null, null, null, null, null, '0', '');
INSERT INTO `cp_game_platform` VALUES ('81', '36', '1', 'http://bit.ly/JCRf8T', 'http://itunes.apple.com/gb/app/fly-fu-pro/id439854840', '0', '0', null, null, null, null, null, null, null, '0', '');
INSERT INTO `cp_game_platform` VALUES ('82', '36', '2', 'http://bit.ly/JCRhgP', 'http://itunes.apple.com/gb/app/fly-fu-pro/id409793139', '0', '0', null, null, null, null, null, null, null, '0', '');
INSERT INTO `cp_game_platform` VALUES ('83', '36', '5', 'http://bit.ly/JCRqAR', 'http://itunes.apple.com/us/app/fly-fu-pro-hd/id435051903', '0', '0', null, null, null, null, null, null, null, '0', '');
INSERT INTO `cp_game_platform` VALUES ('84', '37', '2', 'http://bit.ly/JiqoK8', 'http://itunes.apple.com/us/app/4x4-jam/id321262190', '0', '0', null, null, null, null, null, null, null, '0', '');
INSERT INTO `cp_game_platform` VALUES ('85', '37', '12', 'http://bit.ly/I82b9f', 'http://playstationnetwork.playsmartgames.com/2012/01/4x4-jam-playstation-network-game.html', '0', '0', null, null, null, null, null, null, null, '0', '');
INSERT INTO `cp_game_platform` VALUES ('86', '13', '14', 'http://amzn.to/K5gaDJ', 'http://www.amazon.com/Invictus-Games-Ltd-Race-Of-Champions/dp/B00887FG6K', '0', '0', null, null, null, null, null, null, null, '0', '');
INSERT INTO `cp_game_platform` VALUES ('87', '17', '14', 'http://amzn.to/JG2h8X', 'http://www.amazon.com/Invictus-Games-Ltd-Froggy-Jump/dp/B0084HDXT6/ref=sr_1_1?s=mobile-apps&ie=UTF8&qid=1338798262&sr=1-1', '0', '0', null, null, null, null, null, null, null, '0', '');
INSERT INTO `cp_game_platform` VALUES ('88', '14', '14', 'http://amzn.to/K5hJ4u', 'http://www.amazon.com/Invictus-Games-Ltd-Greed-Corp/dp/B0081J3GXA/ref=sr_1_1?s=mobile-apps&ie=UTF8&qid=1338798297&sr=1-1', '0', '0', null, null, null, null, null, null, null, '0', '');

-- ----------------------------
-- Table structure for `cp_platform`
-- ----------------------------
DROP TABLE IF EXISTS `cp_platform`;
CREATE TABLE `cp_platform` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(150) DEFAULT NULL,
  `url` varchar(150) DEFAULT NULL,
  `image` varchar(150) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of cp_platform
-- ----------------------------
INSERT INTO `cp_platform` VALUES ('1', 'iMac', 'imac', null);
INSERT INTO `cp_platform` VALUES ('2', 'iPod, iPhone', 'ipod-iphone', null);
INSERT INTO `cp_platform` VALUES ('5', 'iPad', 'ipad', null);
INSERT INTO `cp_platform` VALUES ('7', 'Android Phone', 'android-phone', null);
INSERT INTO `cp_platform` VALUES ('8', 'Android Tablet', 'android-tablet', null);
INSERT INTO `cp_platform` VALUES ('10', 'Facebook', 'facebook', null);
INSERT INTO `cp_platform` VALUES ('12', 'PSP', 'psp', null);
INSERT INTO `cp_platform` VALUES ('13', 'PC', 'pc', null);

-- ----------------------------
-- Table structure for `cp_user`
-- ----------------------------
DROP TABLE IF EXISTS `cp_user`;
CREATE TABLE `cp_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `device_id` varchar(150) DEFAULT NULL,
  `os_version` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of cp_user
-- ----------------------------
INSERT INTO `cp_user` VALUES ('1', '0cc175b9c0f1b6a831c399e269772661', 'a');

-- ----------------------------
-- Table structure for `cp_user_game`
-- ----------------------------
DROP TABLE IF EXISTS `cp_user_game`;
CREATE TABLE `cp_user_game` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `game_id` int(11) DEFAULT NULL,
  `game_version` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of cp_user_game
-- ----------------------------
INSERT INTO `cp_user_game` VALUES ('1', '1', '75', '2');
