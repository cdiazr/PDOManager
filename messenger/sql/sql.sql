/*
Navicat MySQL Data Transfer

Source Server Version : 50545
Source Host           : localhost:3306
Source Database       : mp

Target Server Type    : MYSQL
Target Server Version : 50599
File Encoding         : 65001

Date: 2017-02-26 10:16:31
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for messages
-- ----------------------------
DROP TABLE IF EXISTS `messages`;
CREATE TABLE `messages` (
`MsgID`  int(9) UNSIGNED NOT NULL AUTO_INCREMENT ,
`ToUserID`  int(11) NULL DEFAULT NULL ,
`FromUserID`  int(11) NULL DEFAULT NULL ,
`MsgRead`  tinyint(1) NULL DEFAULT 0 ,
`date`  datetime NULL DEFAULT NULL ,
`subject`  varchar(180) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL ,
`msg`  text CHARACTER SET utf8 COLLATE utf8_general_ci NULL ,
PRIMARY KEY (`MsgID`)
)
ENGINE=MyISAM
DEFAULT CHARACTER SET=utf8 COLLATE=utf8_general_ci
AUTO_INCREMENT=5

;

-- ----------------------------
-- Records of messages
-- ----------------------------
BEGIN;
INSERT INTO `messages` VALUES ('1', '1', '2', '0', '2017-02-01 20:37:19', 'Bienvenido al sistema', 'Hola maluma, bienvenido a el sistema de mensajes'),('2', '3', '1', '0', '2017-02-23 20:38:03', 'Probando', 'Hola como estas?'), ('3', '1', '3', '0', '2017-02-24 08:02:26', 'Prueba real', 'funciona?'), ('4', '2', '1', '0', '2017-02-24 09:02:24', 'Uno para ti', 'No me he olvidado de ti!');
COMMIT;

-- ----------------------------
-- Table structure for usuarios
-- ----------------------------
DROP TABLE IF EXISTS `usuarios`;
CREATE TABLE `usuarios` (
`UserID`  int(11) UNSIGNED NOT NULL AUTO_INCREMENT ,
`Username`  varchar(180) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL ,
PRIMARY KEY (`UserID`)
)
ENGINE=MyISAM
DEFAULT CHARACTER SET=utf8 COLLATE=utf8_general_ci
AUTO_INCREMENT=4

;

-- ----------------------------
-- Records of usuarios
-- ----------------------------
BEGIN;
INSERT INTO `usuarios` VALUES ('1', 'maluma'), ('2', 'ricky'), ('3', 'daddyanki');
COMMIT;

-- ----------------------------
-- Auto increment value for messages
-- ----------------------------
ALTER TABLE `messages` AUTO_INCREMENT=5;

-- ----------------------------
-- Auto increment value for usuarios
-- ----------------------------
ALTER TABLE `usuarios` AUTO_INCREMENT=4;
