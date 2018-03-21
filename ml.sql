/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50505
Source Host           : 127.0.0.1:3306
Source Database       : ml

Target Server Type    : MYSQL
Target Server Version : 50505
File Encoding         : 65001

Date: 2018-03-20 23:02:40
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for ml_materials
-- ----------------------------
DROP TABLE IF EXISTS `ml_materials`;
CREATE TABLE `ml_materials` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ml_id` tinyint(4) NOT NULL COMMENT '材料ID',
  `su_id` tinyint(4) DEFAULT NULL COMMENT '供应商ID',
  `ml_no` varchar(255) DEFAULT '' COMMENT '送货编号',
  `ku_nums` tinyint(4) DEFAULT '0' COMMENT '库号',
  `num` decimal(15,2) DEFAULT NULL COMMENT '重量',
  `user_cl` tinyint(4) DEFAULT NULL COMMENT '材料员',
  `remarks` varchar(255) DEFAULT NULL COMMENT '备注',
  `create_time` datetime DEFAULT NULL COMMENT '添加时间',
  `update_time` datetime DEFAULT NULL COMMENT '修改时间',
  `add_time` datetime DEFAULT NULL COMMENT '材料入库时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='材料入库记录表';

-- ----------------------------
-- Records of ml_materials
-- ----------------------------

-- ----------------------------
-- Table structure for ml_use_summary
-- ----------------------------
DROP TABLE IF EXISTS `ml_use_summary`;
CREATE TABLE `ml_use_summary` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `gh_type` tinyint(4) DEFAULT NULL COMMENT '缸号类型 1 砂浆(c15) 、2砂浆(c30)、3 C15、4 C20、5 C25、6 C30、7 C30P6、8 C35、9 C40',
  `gh_amount` decimal(10,2) DEFAULT '0.00' COMMENT '缸号方量',
  `m_p_water` decimal(15,2) DEFAULT '0.00' COMMENT '水',
  `m_u_water` decimal(15,2) DEFAULT '0.00' COMMENT '水',
  `m_p_cement` decimal(15,2) DEFAULT '0.00' COMMENT '水泥(缸号配比使用)',
  `m_u_cement` decimal(15,2) DEFAULT '0.00' COMMENT '水泥(生产使用)',
  `m_p_ash` decimal(15,2) DEFAULT '0.00' COMMENT '火山灰',
  `m_u_ash` decimal(15,2) DEFAULT '0.00' COMMENT '火山灰',
  `m_p_gravel` decimal(15,2) DEFAULT '0.00' COMMENT '碎石',
  `m_u_gravel` decimal(15,2) DEFAULT '0.00' COMMENT '碎石',
  `m_p_sand` decimal(15,2) DEFAULT '0.00' COMMENT '机制砂',
  `m_u_sand` decimal(15,2) DEFAULT '0.00' COMMENT '机制砂',
  `m_p_river_sand` decimal(15,2) DEFAULT '0.00' COMMENT '河沙',
  `m_u_river_sand` decimal(15,2) DEFAULT '0.00' COMMENT '河沙',
  `m_p_additive` decimal(15,2) DEFAULT '0.00' COMMENT '外加剂',
  `m_u_additive` decimal(15,2) DEFAULT '0.00' COMMENT '外加剂',
  `capacity` decimal(15,2) DEFAULT '0.00' COMMENT '容量',
  `add_time` datetime DEFAULT NULL COMMENT '添加时间',
  `update_time` datetime DEFAULT NULL COMMENT '最后修改时间',
  `s_number` varchar(255) DEFAULT '' COMMENT '编号',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='生产缸号使用材料汇总表';

-- ----------------------------
-- Records of ml_use_summary
-- ----------------------------
