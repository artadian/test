/*
 Navicat Premium Data Transfer

 Source Server         : localhost
 Source Server Type    : MySQL
 Source Server Version : 100121
 Source Host           : localhost:3306
 Source Schema         : rigid

 Target Server Type    : MySQL
 Target Server Version : 100121
 File Encoding         : 65001

 Date: 25/01/2021 09:34:53
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for barangsupplier
-- ----------------------------
DROP TABLE IF EXISTS `barangsupplier`;
CREATE TABLE `barangsupplier`  (
  `kode` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `nama` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `merk` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `supplierid` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `createdby` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `createdon` datetime(6) NULL DEFAULT NULL,
  PRIMARY KEY (`kode`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of barangsupplier
-- ----------------------------
INSERT INTO `barangsupplier` VALUES ('A1', 'Aibon', 'Aibon', 'undefined', 'admin', '2020-12-14 00:44:42.000000');
INSERT INTO `barangsupplier` VALUES ('A3', 'kasa', 'prima husada', 'undefined', 'admin', '2020-12-14 00:47:00.000000');
INSERT INTO `barangsupplier` VALUES ('A4', 'AAA', 'AAA', 'qqq', 'admin', '2020-12-14 00:49:34.000000');
INSERT INTO `barangsupplier` VALUES ('IND001', 'Mie Instan', 'Indomie', '001', 'admin', '2020-12-14 04:11:44.000000');
INSERT INTO `barangsupplier` VALUES ('IND002', 'Kopi', 'ABC', '001', 'admin', '2020-12-14 04:11:44.000000');
INSERT INTO `barangsupplier` VALUES ('K01', 'Kardus', 'prima', 'A12', 'admin', '2020-12-14 01:14:00.000000');
INSERT INTO `barangsupplier` VALUES ('K02', 'Stereofoam', 'djuanda', 'A12', 'admin', '2020-12-14 01:14:00.000000');
INSERT INTO `barangsupplier` VALUES ('qwe', 'qwe', 'qwe', 'qqq', 'admin', '2020-12-13 17:19:30.000000');

-- ----------------------------
-- Table structure for lookup
-- ----------------------------
DROP TABLE IF EXISTS `lookup`;
CREATE TABLE `lookup`  (
  `id` int(15) NOT NULL AUTO_INCREMENT,
  `lookupkey` int(10) NULL DEFAULT NULL,
  `lookupvalue` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of lookup
-- ----------------------------
INSERT INTO `lookup` VALUES (1, 0, 'OPEN');
INSERT INTO `lookup` VALUES (2, 1, 'DONE');

-- ----------------------------
-- Table structure for podetail
-- ----------------------------
DROP TABLE IF EXISTS `podetail`;
CREATE TABLE `podetail`  (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `poheaderid` int(20) NULL DEFAULT NULL,
  `kodebarang` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `namabarang` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `merkbarang` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `qty` int(10) NULL DEFAULT NULL,
  `satuan` varchar(20) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `createdby` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `createdon` datetime(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 7 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of podetail
-- ----------------------------
INSERT INTO `podetail` VALUES (1, 9, 'K02', 'Stereofoam', 'djuanda', 1, '1', 'admin', '2020-12-14 02:25:17');
INSERT INTO `podetail` VALUES (2, 10, 'K01', 'Kardus', 'prima', 5, '2', 'admin', '2020-12-14 02:26:00');
INSERT INTO `podetail` VALUES (3, 10, 'K02', 'Stereofoam', 'djuanda', 1, '3', 'admin', '2020-12-14 02:26:00');
INSERT INTO `podetail` VALUES (4, 11, 'IND001', 'Mie Instan', 'Indomie', 5, '1', 'admin', '2020-12-14 04:13:27');
INSERT INTO `podetail` VALUES (5, 11, 'IND002', 'Kopi', 'ABC', 5, '1', 'admin', '2020-12-14 04:13:28');
INSERT INTO `podetail` VALUES (6, 12, 'IND001', 'Mie Instan', 'Indomie', 1, '1', 'admin', '2020-12-14 04:21:19');

-- ----------------------------
-- Table structure for poheader
-- ----------------------------
DROP TABLE IF EXISTS `poheader`;
CREATE TABLE `poheader`  (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `nomor` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `kodesupplier` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `status` int(3) NULL DEFAULT NULL,
  `orderdate` varchar(20) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 13 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of poheader
-- ----------------------------
INSERT INTO `poheader` VALUES (1, '111', 'A12', 0, '2020-12-14');
INSERT INTO `poheader` VALUES (2, 'a', 'A12', 0, '2020-12-14');
INSERT INTO `poheader` VALUES (3, 'a', 'A12', 0, '2020-12-14');
INSERT INTO `poheader` VALUES (4, 'a', 'A12', 0, '2020-12-14');
INSERT INTO `poheader` VALUES (5, 'a', 'A12', 0, '2020-12-14');
INSERT INTO `poheader` VALUES (6, '1', 'A12', 0, '2020-12-14');
INSERT INTO `poheader` VALUES (7, '1', 'A12', 0, '2020-12-14');
INSERT INTO `poheader` VALUES (8, '1', 'A12', 0, '2020-12-14');
INSERT INTO `poheader` VALUES (9, '1', 'A12', 0, '2020-12-14');
INSERT INTO `poheader` VALUES (10, '15', 'A12', 0, '2020-12-14');
INSERT INTO `poheader` VALUES (11, 'PO121', '001', NULL, '2020-12-14');
INSERT INTO `poheader` VALUES (12, 'PO002', '001', NULL, '2020-12-14');

-- ----------------------------
-- Table structure for supplier
-- ----------------------------
DROP TABLE IF EXISTS `supplier`;
CREATE TABLE `supplier`  (
  `kodesupplier` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `nama` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `alamat` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `kota` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `telpon` varchar(14) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `email` varchar(80) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `isactive` int(2) NULL DEFAULT NULL,
  `createdon` datetime(6) NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP(6),
  PRIMARY KEY (`kodesupplier`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of supplier
-- ----------------------------
INSERT INTO `supplier` VALUES ('001', 'Indofood', 'Jakarta', 'Jakarta', '086777991010', 'indofood@indofood.com', 1, '2020-12-14 04:11:44.000000');
INSERT INTO `supplier` VALUES ('A12', 'ASII', 'Jakarta', 'Jakarta', '0899009999', 'asii.purchasing@asii.com', 1, '2020-12-14 01:14:00.000000');
INSERT INTO `supplier` VALUES ('qqq', 'qqq', 'qqq', 'qqq', 'qqq', 'qqq', 1, '2020-12-13 17:19:30.000000');

-- ----------------------------
-- Table structure for tipe
-- ----------------------------
DROP TABLE IF EXISTS `tipe`;
CREATE TABLE `tipe`  (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `nama` varchar(30) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 4 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of tipe
-- ----------------------------
INSERT INTO `tipe` VALUES (1, 'Plastik');
INSERT INTO `tipe` VALUES (2, 'Makanan');
INSERT INTO `tipe` VALUES (3, 'Minuman');

-- ----------------------------
-- Table structure for uom
-- ----------------------------
DROP TABLE IF EXISTS `uom`;
CREATE TABLE `uom`  (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `nama` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `active` int(2) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 4 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of uom
-- ----------------------------
INSERT INTO `uom` VALUES (1, 'pcs', 1);
INSERT INTO `uom` VALUES (2, 'karton', 1);
INSERT INTO `uom` VALUES (3, 'roll', 1);

-- ----------------------------
-- Table structure for user
-- ----------------------------
DROP TABLE IF EXISTS `user`;
CREATE TABLE `user`  (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `userid` varchar(20) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `nama` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `password` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `createdon` datetime(6) NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP(6),
  `active` int(2) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of user
-- ----------------------------
INSERT INTO `user` VALUES (1, 'admin', 'admin', 'e10adc3949ba59abbe56e057f20f883e', '2020-12-13 18:46:07.761623', 0);

SET FOREIGN_KEY_CHECKS = 1;
