/*
 Navicat Premium Data Transfer

 Source Server         : localhost_3306
 Source Server Type    : MySQL
 Source Server Version : 50719
 Source Host           : localhost:3306
 Source Schema         : study

 Target Server Type    : MySQL
 Target Server Version : 50719
 File Encoding         : 65001

 Date: 07/02/2018 09:11:57
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for st_group
-- ----------------------------
DROP TABLE IF EXISTS `st_group`;
CREATE TABLE `st_group`  (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Group\'s ID',
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT 'Gtoup\'s name',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 4 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for st_subject_items
-- ----------------------------
DROP TABLE IF EXISTS `st_subject_items`;
CREATE TABLE `st_subject_items`  (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Option\'s Id',
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT 'Option\'s name',
  `grade` int(3) NULL DEFAULT NULL COMMENT 'Option\'s Grade',
  `no` int(11) NOT NULL COMMENT 'Subject\'s Id',
  `state` int(1) NULL DEFAULT 1 COMMENT 'Subject\'s state',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 36 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for st_subjects
-- ----------------------------
DROP TABLE IF EXISTS `st_subjects`;
CREATE TABLE `st_subjects`  (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Subject\'s ID',
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT 'Subject\'s Name',
  `state` int(1) NOT NULL DEFAULT 1 COMMENT 'Subject\'s State',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 15 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for st_users
-- ----------------------------
DROP TABLE IF EXISTS `st_users`;
CREATE TABLE `st_users`  (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'User\'s ID',
  `username` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT 'User\'s Name',
  `password` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT 'User\'s login system password',
  `sex` int(1) NULL DEFAULT 0 COMMENT 'User\'s sex',
  `email` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT 'User\'s e-mail, login system Username',
  `group` int(255) NOT NULL DEFAULT 2 COMMENT 'User\'s Group',
  `mobile` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT 'User\'s Mobile Phone',
  `age` int(3) NULL DEFAULT 0,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 10000105 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

SET FOREIGN_KEY_CHECKS = 1;
