/*
 Navicat Premium Data Transfer

 Source Server         : Mysql Local
 Source Server Type    : MySQL
 Source Server Version : 50727
 Source Host           : 127.0.0.1:3306
 Source Schema         : wo

 Target Server Type    : MySQL
 Target Server Version : 50727
 File Encoding         : 65001

 Date: 24/08/2019 07:06:17
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for jadwal_meeting
-- ----------------------------
DROP TABLE IF EXISTS `jadwal_meeting`;
CREATE TABLE `jadwal_meeting`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `tanggal` date NULL DEFAULT NULL,
  `waktu` time(0) NULL DEFAULT NULL,
  `tempat` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `keperluan` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `id_wedding` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `kepada` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for undangan
-- ----------------------------
DROP TABLE IF EXISTS `undangan`;
CREATE TABLE `undangan`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_wedding` int(11) NULL DEFAULT NULL,
  `id_pengantin` int(11) NULL DEFAULT NULL,
  `nama` varchar(500) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `alamat` varchar(500) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `tipe_undangan` varchar(500) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `barcode` varchar(500) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

SET FOREIGN_KEY_CHECKS = 1;
