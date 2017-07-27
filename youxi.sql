/*
Navicat MySQL Data Transfer

Source Server         : lirn
Source Server Version : 50547
Source Host           : localhost:3306
Source Database       : youxi

Target Server Type    : MYSQL
Target Server Version : 50547
File Encoding         : 65001

Date: 2017-02-14 09:24:55
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `sf_account_log`
-- ----------------------------
DROP TABLE IF EXISTS `sf_account_log`;
CREATE TABLE `sf_account_log` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL COMMENT '用户id',
  `money` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '用户余额',
  `frozen_money` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '冻结金额',
  `integral` varchar(255) NOT NULL DEFAULT '0' COMMENT '消费积分',
  `user_point_buy` varchar(255) NOT NULL DEFAULT '0' COMMENT '买家信用积分',
  `user_point_sell` varchar(255) NOT NULL DEFAULT '0' COMMENT '卖家信用积分',
  `change_time` int(10) unsigned NOT NULL COMMENT '改变时间',
  `change_desc` varchar(255) NOT NULL DEFAULT '' COMMENT '原因',
  `change_type` tinyint(3) unsigned NOT NULL COMMENT '操作类型,0为充值,1为提现,2为管理员调节,3为支付，4为出售，5为退款，99为其它类型',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=60 DEFAULT CHARSET=utf8 COMMENT='账目日志';

-- ----------------------------
-- Records of sf_account_log
-- ----------------------------
INSERT INTO `sf_account_log` VALUES ('4', '14', '100.00', '0.00', '0', '0', '0', '1473037966', '测试变动', '2');
INSERT INTO `sf_account_log` VALUES ('5', '14', '-1.00', '100.00', '2', '0', '0', '1473038004', '测试', '2');
INSERT INTO `sf_account_log` VALUES ('6', '14', '100.00', '-50.00', '0', '0', '0', '1473044810', '测试', '2');
INSERT INTO `sf_account_log` VALUES ('7', '14', '-1.00', '0.00', '0', '0', '0', '1473044832', '测试', '2');
INSERT INTO `sf_account_log` VALUES ('8', '13', '1000.00', '0.00', '0', '0', '0', '1473237547', '想加就加咯', '2');
INSERT INTO `sf_account_log` VALUES ('9', '25', '1000.00', '0.00', '0', '0', '0', '1474937145', '加钱', '2');
INSERT INTO `sf_account_log` VALUES ('11', '25', '-111.00', '0.00', '0', '0', '0', '1474945853', '支付订单YXZB20160927084355-63185', '3');
INSERT INTO `sf_account_log` VALUES ('12', '25', '-111.00', '0.00', '0', '0', '0', '1474946602', '支付订单YXZB20160927112040-72753', '3');
INSERT INTO `sf_account_log` VALUES ('13', '25', '111.00', '0.00', '0', '0', '0', '1474946767', '订单YXZB20160927112040-72753退款', '5');
INSERT INTO `sf_account_log` VALUES ('14', '25', '-118.00', '0.00', '0', '0', '0', '1475984085', '支付订单ZB20161009113415-23319', '3');
INSERT INTO `sf_account_log` VALUES ('15', '25', '-1.00', '0.00', '0', '0', '0', '1477360606', '支付订单YXZH20161025095350-30478', '3');
INSERT INTO `sf_account_log` VALUES ('16', '9', '1000.00', '0.00', '0', '0', '0', '1478587645', '加', '2');
INSERT INTO `sf_account_log` VALUES ('17', '9', '-530.00', '0.00', '0', '0', '0', '1478587660', '支付订单ZH20161108144651-51377', '3');
INSERT INTO `sf_account_log` VALUES ('18', '25', '-530.00', '0.00', '0', '0', '0', '1478677629', '支付订单ZH20161109153059-13749', '3');
INSERT INTO `sf_account_log` VALUES ('21', '25', '530.00', '0.00', '0', '0', '0', '1478757843', '订单ZH20161109153059-13749 退款', '5');
INSERT INTO `sf_account_log` VALUES ('22', '2', '-100.00', '0.00', '0', '0', '0', '1478760792', '支付订单YXZH20161110143040-73619', '3');
INSERT INTO `sf_account_log` VALUES ('23', '25', '-200.00', '200.00', '0', '0', '0', '1478765420', '用户提现', '1');
INSERT INTO `sf_account_log` VALUES ('24', '25', '200.00', '-200.00', '0', '0', '0', '1478766132', '失误', '2');
INSERT INTO `sf_account_log` VALUES ('25', '25', '-199.00', '199.00', '0', '0', '0', '1478766176', '用户提现', '1');
INSERT INTO `sf_account_log` VALUES ('26', '25', '199.00', '-199.00', '0', '0', '0', '1478766797', '用户提现审核不通过，退款', '99');
INSERT INTO `sf_account_log` VALUES ('27', '33', '500.00', '0.00', '0', '0', '0', '1478853291', '加钱', '2');
INSERT INTO `sf_account_log` VALUES ('28', '33', '-460.00', '0.00', '0', '0', '0', '1478853379', '支付订单YXB20161111163353-44107', '99');
INSERT INTO `sf_account_log` VALUES ('29', '25', '460.00', '0.00', '0', '0', '0', '1478853547', '订单YXB20161111163353-44107出售，所得收益', '4');
INSERT INTO `sf_account_log` VALUES ('30', '33', '0.00', '0.00', '460', '460', '0', '1478853547', '购买订单YXB20161111163353-44107获得积分', '3');
INSERT INTO `sf_account_log` VALUES ('31', '25', '0.00', '0.00', '460', '460', '460', '1478853547', '出售订单YXB20161111163353-44107获得积分', '4');
INSERT INTO `sf_account_log` VALUES ('32', '33', '500.00', '0.00', '0', '0', '0', '1478858560', '你好', '2');
INSERT INTO `sf_account_log` VALUES ('33', '33', '-230.00', '0.00', '0', '0', '0', '1478858569', '支付订单YXB20161111180153-18505', '99');
INSERT INTO `sf_account_log` VALUES ('34', '2', '500.00', '0.00', '0', '0', '0', '1479086900', '增加余额', '2');
INSERT INTO `sf_account_log` VALUES ('35', '2', '-230.00', '0.00', '0', '0', '0', '1479086913', '支付订单YXB20161114092737-28076', '99');
INSERT INTO `sf_account_log` VALUES ('36', '2', '0.00', '0.00', '230', '230', '0', '1479087454', '购买订单YXB20161114092737-28076获得积分', '3');
INSERT INTO `sf_account_log` VALUES ('37', '25', '0.00', '0.00', '0', '0', '230', '1479087454', '出售订单YXB20161114092737-28076获得积分', '4');
INSERT INTO `sf_account_log` VALUES ('38', '25', '230.00', '0.00', '0', '0', '0', '1479087454', '订单YXB20161114092737-28076出售，所得收益', '4');
INSERT INTO `sf_account_log` VALUES ('39', '25', '0.00', '0.00', '100', '0', '0', '1479105838', '才', '2');
INSERT INTO `sf_account_log` VALUES ('40', '25', '0.00', '0.00', '-5', '0', '0', '1479110447', '用户积分兑换', '99');
INSERT INTO `sf_account_log` VALUES ('41', '25', '0.00', '0.00', '-1', '0', '0', '1479110685', '用户积分兑换', '99');
INSERT INTO `sf_account_log` VALUES ('42', '2', '0.00', '0.00', '10000', '0', '0', '1479113728', 'c', '2');
INSERT INTO `sf_account_log` VALUES ('43', '2', '0.00', '0.00', '-3000', '0', '0', '1479113754', '用户积分兑换', '99');
INSERT INTO `sf_account_log` VALUES ('44', '2', '0.00', '0.00', '3000', '0', '0', '1479177029', '订单DH2016111416554148037 取消退回积分', '99');
INSERT INTO `sf_account_log` VALUES ('45', '25', '-111.00', '0.00', '0', '0', '0', '1479720023', '支付订单YXZB20161010163230-56265', '99');
INSERT INTO `sf_account_log` VALUES ('46', '0', '111.00', '0.00', '0', '0', '0', '1479720206', '订单YXZB20161010163230-56265出售，所得收益', '4');
INSERT INTO `sf_account_log` VALUES ('47', '25', '0.00', '0.00', '111', '111', '0', '1479720206', '购买订单YXZB20161010163230-56265获得积分', '3');
INSERT INTO `sf_account_log` VALUES ('48', '0', '0.00', '0.00', '0', '0', '111', '1479720206', '出售订单YXZB20161010163230-56265获得积分', '4');
INSERT INTO `sf_account_log` VALUES ('49', '9', '-50.00', '0.00', '0', '0', '0', '1484128335', '支付点卡订单DK2017011117521428478', '99');
INSERT INTO `sf_account_log` VALUES ('50', '9', '-50.00', '0.00', '0', '0', '0', '1484128377', '支付点卡订单DK2017011117525661276', '99');
INSERT INTO `sf_account_log` VALUES ('51', '9', '-200.00', '0.00', '0', '0', '0', '1484128412', '支付点卡订单DK2017011117533185439', '99');
INSERT INTO `sf_account_log` VALUES ('52', '9', '-30.00', '0.00', '0', '0', '0', '1484128571', '支付点卡订单DK2017011117561199970', '99');
INSERT INTO `sf_account_log` VALUES ('57', '9', '50.00', '0.00', '0', '0', '0', '1484201018', '点卡订单DK2017011117521428478 退款', '2');
INSERT INTO `sf_account_log` VALUES ('58', '9', '-1.00', '0.00', '0', '0', '0', '1484707625', '支付点卡订单DK2017011810470499277', '99');
INSERT INTO `sf_account_log` VALUES ('59', '9', '-100.00', '0.00', '0', '0', '0', '1484712198', '支付点卡订单DK2017011812031818301', '99');

-- ----------------------------
-- Table structure for `sf_ad`
-- ----------------------------
DROP TABLE IF EXISTS `sf_ad`;
CREATE TABLE `sf_ad` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `ad_name` varchar(255) NOT NULL DEFAULT '' COMMENT '广告名称',
  `type` varchar(10) NOT NULL DEFAULT '1' COMMENT '1图片，2代码',
  `position_id` int(10) unsigned NOT NULL COMMENT '广告位置',
  `start_time` datetime NOT NULL COMMENT '开始时间',
  `end_time` datetime NOT NULL COMMENT '结束时间',
  `ad_url` varchar(255) NOT NULL DEFAULT '' COMMENT '链接地址',
  `ad_code` text NOT NULL COMMENT '广告图片',
  `is_open` varchar(10) NOT NULL DEFAULT '0' COMMENT '0开启，1关闭',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=utf8 COMMENT='广告表';

-- ----------------------------
-- Records of sf_ad
-- ----------------------------
INSERT INTO `sf_ad` VALUES ('8', '注册广告', '1', '6', '2016-09-19 00:00:00', '2036-09-19 00:00:00', '/', '/public/uploads/3cb2c037f281a98e480f97c7135647d2.jpg', '0');
INSERT INTO `sf_ad` VALUES ('9', '登录广告', '1', '7', '2016-09-19 00:00:00', '2050-09-19 00:00:00', '/', '/public/uploads/37b0ef1794bea6cadfc1c6e7c66bbef8.png', '0');
INSERT INTO `sf_ad` VALUES ('10', '积分商品轮播', '1', '8', '2016-11-14 00:00:00', '2028-11-14 00:00:00', '/', '/public/uploads/5296ddeb1cadc62e1634e3b5675a1389.jpg', '0');
INSERT INTO `sf_ad` VALUES ('11', '积分商品轮播1', '1', '8', '2016-11-14 00:00:00', '2026-11-18 00:00:00', '/', '/public/uploads/9c1a583c4a162050e851c7ad1538cabc.jpg', '0');
INSERT INTO `sf_ad` VALUES ('12', '安全中心轮播图', '1', '9', '2016-11-17 00:00:00', '2025-11-28 00:00:00', '', '/public/uploads/e3cdef24c3efe8769e88e65e1846891d.jpg', '0');
INSERT INTO `sf_ad` VALUES ('7', '二维码', '1', '5', '2016-09-19 12:00:00', '2064-09-27 12:00:00', '', '/public/uploads/6fab1f7ca403ca93d41c819d86ecbb1c.png', '0');

-- ----------------------------
-- Table structure for `sf_ad_position`
-- ----------------------------
DROP TABLE IF EXISTS `sf_ad_position`;
CREATE TABLE `sf_ad_position` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `adp_name` varchar(100) NOT NULL DEFAULT '' COMMENT '广告位名称',
  `adp_width` int(10) unsigned NOT NULL COMMENT '广告位宽度',
  `adp_height` int(10) unsigned NOT NULL COMMENT '高度',
  `adp_desc` varchar(255) NOT NULL DEFAULT '' COMMENT '广告位描述',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COMMENT='广告位';

-- ----------------------------
-- Records of sf_ad_position
-- ----------------------------
INSERT INTO `sf_ad_position` VALUES ('5', '底部二维码', '80', '80', '');
INSERT INTO `sf_ad_position` VALUES ('6', '注册页广告位', '520', '390', '');
INSERT INTO `sf_ad_position` VALUES ('7', '登录页广告位', '425', '366', '');
INSERT INTO `sf_ad_position` VALUES ('8', '积分商品轮播', '800', '297', '');
INSERT INTO `sf_ad_position` VALUES ('9', '安全中心轮播', '1000', '313', '');

-- ----------------------------
-- Table structure for `sf_applications`
-- ----------------------------
DROP TABLE IF EXISTS `sf_applications`;
CREATE TABLE `sf_applications` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL DEFAULT '' COMMENT '网站用户名',
  `email` varchar(255) NOT NULL DEFAULT '' COMMENT '注册邮箱',
  `BindPhone` int(11) unsigned NOT NULL COMMENT '绑定手机',
  `IdCard` varchar(255) NOT NULL DEFAULT '' COMMENT '身份证',
  `bankNo` varchar(255) NOT NULL DEFAULT '' COMMENT '银行卡号',
  `bankName` varchar(255) NOT NULL DEFAULT '' COMMENT '银行名称',
  `content` tinytext NOT NULL COMMENT '申请理由',
  `phone` int(11) unsigned NOT NULL COMMENT '联系电话',
  `qq` varchar(255) NOT NULL DEFAULT '' COMMENT '联系QQ',
  `CardImg` varchar(255) NOT NULL DEFAULT '' COMMENT '身份证正面',
  `CardFmImg` varchar(255) NOT NULL DEFAULT '' COMMENT '身份证反面',
  `bankCard` varchar(255) NOT NULL DEFAULT '' COMMENT '银行卡',
  `RecordImg` varchar(255) NOT NULL DEFAULT '' COMMENT '充值记录',
  `EmailImg` varchar(255) NOT NULL DEFAULT '' COMMENT '注册邮箱',
  `user_id` int(10) unsigned NOT NULL,
  `type` varchar(255) NOT NULL DEFAULT '' COMMENT '申请类型',
  `result` tinyint(4) NOT NULL DEFAULT '0' COMMENT '0未处理，1通过，2不通过',
  `created_at` varchar(11) DEFAULT NULL,
  `updated_at` varchar(11) DEFAULT NULL,
  `re_content` tinytext COMMENT '回复',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COMMENT='//用户异常申请表';

-- ----------------------------
-- Records of sf_applications
-- ----------------------------
INSERT INTO `sf_applications` VALUES ('4', 'liming', '419091561@qq.com', '4294967295', '513902199111203333', '121213213213213231', '梵蒂冈', '倒数第三赛段', '4294967295', '1232342', '/public/uploads/3d2b935e75aac49a25bcb246b03c56b5.jpg', '/public/uploads/b292c52ad870478d0f07d8337b329321.jpg', '', '', '', '25', '开户名修改', '1', '1476756425', null, '');
INSERT INTO `sf_applications` VALUES ('9', '', '419091561@qq.com', '4294967295', '513902199112120234', '62284804232145216848', '张三', '不想用这个用户名了', '4294967295', '1423245765', '/public/uploads/3c054615de7b9f72e62ddda2c1417492.jpg', '/public/uploads/5cdd4c92dbef913177cee2c355f73475.jpg', '/public/uploads/945d084d5ce59d92457df20568d64b3e.jpg', '/public/uploads/2b93d500b9eb5ab360995273999addb0.jpg', '/public/uploads/6faeec9d7572f583a6714ff08a5d11a0.jpg', '25', '资金异常申请', '0', null, null, null);

-- ----------------------------
-- Table structure for `sf_article`
-- ----------------------------
DROP TABLE IF EXISTS `sf_article`;
CREATE TABLE `sf_article` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL DEFAULT '' COMMENT '文章标题',
  `thumb` varchar(255) NOT NULL DEFAULT '' COMMENT '缩略图',
  `desc` varchar(255) NOT NULL DEFAULT '' COMMENT '文章简介',
  `content` text NOT NULL COMMENT '内容',
  `created_at` datetime NOT NULL COMMENT '创建时间',
  `updated_at` datetime NOT NULL COMMENT '更新时间',
  `cat_id` int(10) unsigned NOT NULL COMMENT '所属分类id',
  `is_recommend` tinyint(3) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=33 DEFAULT CHARSET=utf8 COMMENT='文章表';

-- ----------------------------
-- Records of sf_article
-- ----------------------------
INSERT INTO `sf_article` VALUES ('13', '《冒险岛2》酷爽免费来袭 ', '', '', '<p style=\"margin-top: 0px; margin-bottom: 0px; padding: 0px; line-height: 42px; font-size: 14px; font-family: &quot;Microsoft YaHei&quot;, 宋体, Arial, simsun, sans-serif, Mingliu, Verdana, Helvetica, Lucida; white-space: normal;\"><span style=\"margin: 0px; padding: 0px;\">尊敬的用户：</span></p><p style=\"margin-top: 0px; margin-bottom: 0px; padding: 0px; line-height: 42px; font-size: 14px; font-family: &quot;Microsoft YaHei&quot;, 宋体, Arial, simsun, sans-serif, Mingliu, Verdana, Helvetica, Lucida; white-space: normal;\"><span style=\"margin: 0px; padding: 0px;\">&nbsp; &nbsp;</span><span style=\"margin: 0px; padding: 0px;\">荷风送香气，竹露滴清响。</span><span style=\"margin: 0px; padding: 0px;\"></span><span style=\"margin: 0px; padding: 0px;\">为感谢广大新老用户的支持，即日起，《冒险岛2》所有商品的<span style=\"margin: 0px; padding: 0px; color: rgb(255, 0, 0);\"><span style=\"margin: 0px; padding: 0px; color: rgb(0, 0, 0);\">寄</span><span style=\"margin: 0px; padding: 0px; color: rgb(0, 0, 0);\">售、担保、账号以及求购</span>开启<strong style=\"margin: 0px; padding: 0px;\">零</strong>手续费交易服务</span>，这样的福利你还在犹豫什么！赶紧来发布商品吧！</span><span style=\"margin: 0px; padding: 0px;\">今后我们将推出更多优惠活动，敬请期待！</span></p><p style=\"margin-top: 0px; margin-bottom: 0px; padding: 0px; line-height: 42px; font-size: 14px; font-family: &quot;Microsoft YaHei&quot;, 宋体, Arial, simsun, sans-serif, Mingliu, Verdana, Helvetica, Lucida; white-space: normal;\"><span style=\"margin: 0px; padding: 0px;\"></span></p><p style=\"margin-top: 0px; margin-bottom: 0px; padding: 0px; line-height: 42px; font-size: 14px; font-family: &quot;Microsoft YaHei&quot;, 宋体, Arial, simsun, sans-serif, Mingliu, Verdana, Helvetica, Lucida; white-space: normal;\"><span style=\"margin: 0px; padding: 0px;\">如您有疑问，请进入</span><a title=\"咨询中心\" href=\"http://help.dd373.com/Member/ReleaseAsk\" target=\"_blank\" style=\"margin: 0px; padding: 0px; text-decoration: none; cursor: pointer; color: rgb(0, 112, 192); outline: none;\">咨询中心</a><span style=\"margin: 0px; padding: 0px;\">进行提问，我们的客服会在10分钟内为您答疑。</span></p><p style=\"margin-top: 0px; margin-bottom: 0px; padding: 0px; line-height: 42px; font-size: 14px; font-family: &quot;Microsoft YaHei&quot;, 宋体, Arial, simsun, sans-serif, Mingliu, Verdana, Helvetica, Lucida; white-space: normal;\"><span style=\"margin: 0px; padding: 0px;\"><a title=\"我要买\" href=\"http://www.dd373.com/buy/Index.html\" target=\"_blank\" style=\"margin: 0px; padding: 0px; text-decoration: none; cursor: pointer; color: rgb(0, 112, 192); outline: none;\">我要买</a>&nbsp;&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;<a title=\"我要卖\" href=\"http://sell.dd373.com/sell.html\" target=\"_blank\" style=\"margin: 0px; padding: 0px; text-decoration: none; cursor: pointer; color: rgb(51, 51, 51); outline: none;\"><span style=\"margin: 0px; padding: 0px; color: rgb(0, 112, 192);\">我要卖</span></a></span></p><p style=\"margin-top: 0px; margin-bottom: 0px; padding: 0px; line-height: 42px; font-size: 14px; font-family: &quot;Microsoft YaHei&quot;, 宋体, Arial, simsun, sans-serif, Mingliu, Verdana, Helvetica, Lucida; white-space: normal;\"><span style=\"margin: 0px; padding: 0px;\"></span></p><p style=\"margin-top: 0px; margin-bottom: 0px; padding: 0px; line-height: 42px; font-size: 14px; font-family: &quot;Microsoft YaHei&quot;, 宋体, Arial, simsun, sans-serif, Mingliu, Verdana, Helvetica, Lucida; white-space: normal;\"><br/></p><p><br/></p>', '2016-11-07 11:30:15', '2016-11-08 11:30:20', '25', '0');
INSERT INTO `sf_article` VALUES ('14', '中国互联网协会网络诚信推进联盟成立仪式', '', '', '<p>各有关企业网站：</p><p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;面对虚假身份、恶意欺诈、钓鱼网站等日益突出的诚信风险和木马、病毒、隐私窃取等多元化的安全威胁，互联网站和电子商务正面临着“诚信”和“信任”的两大挑战，如何确保网站经营者的诚信和如何获得网民的信任已经成为互联网从业人员必须要解决的两大迫切问题。</p><p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;经过多年的网站信用研究和管理实践，<span style=\"margin: 0px; padding: 0px;\">iTrust信用评价中心在国内率先提出了“网站信用证”概念并作出了精确定义，受到了互联网业界的普遍关注。为了让尽可能多的合法诚信网站参与认证，最大限度地确保广大网民的上网安全，iTrust信用评价中心联合北京至诚信用管理有限公司隆重推出首个具有第三方担保的“网站信用证”公益服务，自即日起正式受理企业网站免费申请。</span></p><p>&nbsp;&nbsp;&nbsp;</p><p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;特此公告。</p><p>&nbsp;</p><p style=\"margin-top: 0px; margin-bottom: 0px; padding: 0px; text-indent: 0em; line-height: 42px; font-size: 14px;\">中国互联网协会网络诚信推进联盟成立仪式视频如下：</p><p><span style=\"text-decoration:underline;\"><span style=\"color:#0066cc\">凤凰网副总裁邹明感言</span></span>&nbsp;&nbsp;<span style=\"color:#0066cc\"><span style=\"text-decoration:underline;\">百度COO叶朋感言 副理事长黄澄清致辞 搜狐总监罗利元感言</span></span><span style=\"color:#000000\">&nbsp;<span style=\"text-decoration:underline;\"><span style=\"color:#0066cc\">腾讯新闻中心总监马立感言</span></span></span></p><p>&nbsp;</p><p><span style=\"color:#000000\"><span style=\"text-decoration:underline;\"><span style=\"color:#0066cc\">网易高级副总裁周枫感言</span></span>&nbsp;&nbsp;<span style=\"text-decoration:underline;\"><span style=\"color:#0066cc\">新浪副总编闻进感言</span></span>&nbsp;</span></p><p style=\"margin-top: 0px; margin-bottom: 0px; padding: 0px; line-height: 42px; font-size: 14px; font-family: &quot;Microsoft YaHei&quot;, 宋体, Arial, simsun, sans-serif, Mingliu, Verdana, Helvetica, Lucida; white-space: normal;\"><a href=\"http://v.ifeng.com/news/china/200903/df969680-885f-46e3-a766-2f2d14e3c297.shtml\" style=\"margin: 0px; padding: 0px; text-decoration: none; cursor: pointer; color: rgb(51, 51, 51); outline: none;\">http://v.ifeng.com/news/china/200903/9f7b007b-b53a-4f1b-92eb-5ad831a408ag.shtml#9f7b007b-b53a-4f1b-92eb-5ad831a408ag</a></p><p><br/></p>', '2016-11-09 11:30:24', '2016-11-17 17:16:15', '25', '0');
INSERT INTO `sf_article` VALUES ('11', '《DNF》商家收货免费公告 ', '', '', '<p style=\"margin-top: 0px; margin-bottom: 0px; padding: 0px; line-height: 48px; font-size: 14px; font-family: &quot;Microsoft YaHei&quot;, 宋体, Arial, simsun, sans-serif, Mingliu, Verdana, Helvetica, Lucida; white-space: normal;\"><span style=\"margin: 0px; padding: 0px; font-family: &quot;Microsoft YaHei&quot;, serif;\">尊敬的用户：</span></p><p style=\"margin-top: 0px; margin-bottom: 0px; padding: 0px; text-indent: 0em; line-height: 48px; font-size: 14px; font-family: &quot;Microsoft YaHei&quot;, 宋体, Arial, simsun, sans-serif, Mingliu, Verdana, Helvetica, Lucida; white-space: normal;\"><span style=\"margin: 0px; padding: 0px; font-family: &quot;Microsoft YaHei&quot;, serif;\">&nbsp; &nbsp; &nbsp; &nbsp;</span><span style=\"margin: 0px; padding: 0px; font-family: &quot;Microsoft YaHei&quot;, serif;\">海上生明月，天涯共此时。佳节来临之际，为了向您提供更优质的服务，自2016年9月17日17:30（周六）起，《地下城与勇士》开启新一轮的优惠活动，所有区服的“游戏币、深渊票”等收货交易均开启</span><strong style=\"margin: 0px; padding: 0px;\"><span style=\"margin: 0px; padding: 0px; color: red; font-family: &quot;Microsoft YaHei&quot;, serif;\">零手续费</span></strong><span style=\"margin: 0px; padding: 0px; font-family: &quot;Microsoft YaHei&quot;, serif;\">。</span></p><p style=\"margin-top: 0px; margin-bottom: 0px; padding: 0px; line-height: 48px; font-size: 14px; font-family: &quot;Microsoft YaHei&quot;, 宋体, Arial, simsun, sans-serif, Mingliu, Verdana, Helvetica, Lucida; white-space: normal;\"><span style=\"margin: 0px; padding: 0px; font-family: &quot;Microsoft YaHei&quot;, serif;\">&nbsp; &nbsp; &nbsp; &nbsp;</span><span style=\"margin: 0px; padding: 0px; font-family: &quot;Microsoft YaHei&quot;, serif;\">这样的福利你还在犹豫什么！赶紧来发布商品吧！&nbsp;<br/>&nbsp; &nbsp; &nbsp; &nbsp;如您有疑问，请进入</span><a title=\"咨询中心\" href=\"http://help.dd373.com/Member/ReleaseAsk\" target=\"_blank\" style=\"margin: 0px; padding: 0px; text-decoration: none; cursor: pointer; color: rgb(51, 51, 51); outline: none;\"><span style=\"margin: 0px; padding: 0px; color: rgb(31, 73, 125); font-family: &quot;Microsoft YaHei&quot;, serif;\">咨询中心</span></a><span style=\"margin: 0px; padding: 0px; font-family: &quot;Microsoft YaHei&quot;, serif;\">进行提问，我们的客服会在10分钟内为您答疑。</span></p><p><br/></p>', '2016-11-08 11:30:30', '2016-11-19 11:30:33', '25', '0');
INSERT INTO `sf_article` VALUES ('12', '《征途2》最新免费公告 ', '', '', '<p style=\"padding: 0px; line-height: 48px; font-size: 14px; font-family: &quot;Microsoft YaHei&quot;, 宋体, Arial, simsun, sans-serif, Mingliu, Verdana, Helvetica, Lucida; white-space: normal;\"><span style=\"margin: 0px; padding: 0px; font-family: &quot;Microsoft YaHei&quot;, serif;\">尊敬的用户：</span></p><p style=\"padding: 0px; text-indent: 0em; line-height: 48px; font-size: 14px; font-family: &quot;Microsoft YaHei&quot;, 宋体, Arial, simsun, sans-serif, Mingliu, Verdana, Helvetica, Lucida; white-space: normal;\"><span style=\"margin: 0px; padding: 0px; font-family: &quot;Microsoft YaHei&quot;, serif;\">&nbsp; &nbsp; &nbsp; &nbsp;</span><span style=\"margin: 0px; padding: 0px; font-family: &quot;Microsoft YaHei&quot;, serif;\">中秋月，月到中秋偏皎洁。佳节来临之际，为了向您提供更优质的服务，自2016年9月17日12:00（周六）起，《征途2》开启新一轮的优惠活动，所有区服寄售、担保、求购、账号、商城均开启交易</span><strong style=\"margin: 0px; padding: 0px;\"><span style=\"margin: 0px; padding: 0px; color: red; font-family: &quot;Microsoft YaHei&quot;, serif;\">零手续费</span></strong><span style=\"margin: 0px; padding: 0px; font-family: &quot;Microsoft YaHei&quot;, serif;\">。</span></p><p style=\"padding: 0px; text-indent: 2em; line-height: 3em; font-size: 14px; font-family: &quot;Microsoft YaHei&quot;, 宋体, Arial, simsun, sans-serif, Mingliu, Verdana, Helvetica, Lucida; white-space: normal;\"><span style=\"margin: 0px; padding: 0px; text-indent: 35px; font-family: &quot;Microsoft YaHei&quot;, serif;\">账号过户费也开启</span><strong style=\"margin: 0px; padding: 0px; text-indent: 35px;\"><span style=\"margin: 0px; padding: 0px; color: red; font-family: &quot;Microsoft YaHei&quot;, serif;\">免费服务</span></strong><span style=\"margin: 0px; padding: 0px; text-indent: 35px; font-family: &quot;Microsoft YaHei&quot;, serif;\">，每笔固定收取60元官方服务费。</span><strong style=\"margin: 0px; padding: 0px; text-indent: 35px;\"><span style=\"margin: 0px; padding: 0px; color: red; font-family: &quot;Microsoft YaHei&quot;, serif;\">（官方过户收取固定服务）</span></strong></p><p style=\"padding: 0px; line-height: 48px; font-size: 14px; font-family: &quot;Microsoft YaHei&quot;, 宋体, Arial, simsun, sans-serif, Mingliu, Verdana, Helvetica, Lucida; white-space: normal;\"><span style=\"margin: 0px; padding: 0px; font-family: &quot;Microsoft YaHei&quot;, serif;\">&nbsp; &nbsp; &nbsp; &nbsp;</span><span style=\"margin: 0px; padding: 0px; font-family: &quot;Microsoft YaHei&quot;, serif;\">活动期间，所有区服的“游戏币”、“装备”、“材料”、“血钻”、“点券”、“宠物”“账号”“代练”，等所有寄售、担保以及账号交易均为</span><strong style=\"margin: 0px; padding: 0px;\"><span style=\"margin: 0px; padding: 0px; color: red; font-family: &quot;Microsoft YaHei&quot;, serif;\">零手续</span></strong><strong style=\"margin: 0px; padding: 0px;\"><span style=\"margin: 0px; padding: 0px; color: red; font-family: &quot;Microsoft YaHei&quot;, serif;\">费</span></strong><span style=\"margin: 0px; padding: 0px; font-family: &quot;Microsoft YaHei&quot;, serif;\">。快来畅爽交易，免费嗨翻天！</span></p><p style=\"padding: 0px; line-height: 48px; font-size: 14px; font-family: &quot;Microsoft YaHei&quot;, 宋体, Arial, simsun, sans-serif, Mingliu, Verdana, Helvetica, Lucida; white-space: normal;\"><span style=\"margin: 0px; padding: 0px; font-family: &quot;Microsoft YaHei&quot;, serif;\">&nbsp; &nbsp; &nbsp; &nbsp;</span><span style=\"margin: 0px; padding: 0px; font-family: &quot;Microsoft YaHei&quot;, serif;\">这样的福利你还在犹豫什么！赶紧来发布商品吧！&nbsp;<br/>&nbsp; &nbsp; &nbsp; &nbsp;如您有疑问，请进入</span><a title=\"咨询中心\" href=\"http://help.dd373.com/Member/ReleaseAsk\" target=\"_blank\" style=\"margin: 0px; padding: 0px; text-decoration: none; cursor: pointer; color: rgb(51, 51, 51); outline: none;\"><span style=\"margin: 0px; padding: 0px; color: rgb(31, 73, 125); font-family: &quot;Microsoft YaHei&quot;, serif;\">咨询中心</span></a><span style=\"margin: 0px; padding: 0px; font-family: &quot;Microsoft YaHei&quot;, serif;\">进行提问，我们的客服会在10分钟内为您答疑。</span></p><p><br/></p>', '2016-11-09 11:30:36', '2016-11-18 11:30:40', '25', '0');
INSERT INTO `sf_article` VALUES ('10', '最新防骗通知 ', '', '', '<p style=\"margin-top: 0px; margin-bottom: 0px; padding: 0px; line-height: 32px; font-size: 14px; font-family: &quot;Microsoft YaHei&quot;, 宋体, Arial, simsun, sans-serif, Mingliu, Verdana, Helvetica, Lucida; white-space: normal;\"><span style=\"margin: 0px; padding: 0px; font-size: 12px;\">尊敬的DD用户：</span></p><p style=\"margin-top: 0px; margin-bottom: 0px; padding: 0px; text-indent: 32px; line-height: 28px; font-size: 14px; font-family: &quot;Microsoft YaHei&quot;, 宋体, Arial, simsun, sans-serif, Mingliu, Verdana, Helvetica, Lucida; white-space: normal;\"><span style=\"margin: 0px; padding: 0px; font-size: 12px;\">近期发现有不法分子冒充DD373工作人员以各种形式向用户索要相关帐户资料，例如发送邮件、在游戏中冒充DD373交易员等。</span></p><p style=\"margin-top: 0px; margin-bottom: 0px; padding: 0px; text-indent: 32px; line-height: 28px; font-size: 14px; font-family: &quot;Microsoft YaHei&quot;, 宋体, Arial, simsun, sans-serif, Mingliu, Verdana, Helvetica, Lucida; white-space: normal;\"><span style=\"margin: 0px; padding: 0px; font-size: 12px;\"><span style=\"margin: 0px; padding: 0px;\">温馨提示您：遇到不明邮件，请谨慎，不要随意打开，更不应点击邮件内的任何链接。真正的DD373工作人员不会以任何理由要求用户再次确</span><span style=\"margin: 0px; padding: 0px;\">认帐号信息。请广大用户不要随意泄露自己的帐号信息，谨防上当受骗！对于别人发的链接和联系您的QQ，建议您在网页地址栏手动输入</span></span><a href=\"http://www.dd373.com/\" style=\"margin: 0px; padding: 0px; text-decoration: none; cursor: pointer; color: rgb(51, 51, 51); outline: none;\"><span style=\"margin: 0px; padding: 0px; color: purple; font-size: 12px;\">www.dd373.com</span></a><span style=\"margin: 0px; padding: 0px; color: rgb(102, 102, 102); font-size: 12px;\">，</span><span style=\"margin: 0px; padding: 0px; font-size: 12px;\">进入网站首页右上方的验证中心进行验证。</span></p><p style=\"margin-top: 0px; margin-bottom: 0px; padding: 0px; text-indent: 32px; line-height: 28px; font-size: 14px; font-family: &quot;Microsoft YaHei&quot;, 宋体, Arial, simsun, sans-serif, Mingliu, Verdana, Helvetica, Lucida; white-space: normal;\"><span style=\"margin: 0px; padding: 0px; font-size: 12px;\">对于回复假冒DD373工作人员发送的向您索要账号信息的邮件，导致您的账号被盗或者被洗，均与本站无关。</span></p><p style=\"margin-top: 0px; margin-bottom: 0px; padding: 0px; text-indent: 32px; line-height: 28px; font-size: 14px; font-family: &quot;Microsoft YaHei&quot;, 宋体, Arial, simsun, sans-serif, Mingliu, Verdana, Helvetica, Lucida; white-space: normal;\"><span style=\"margin: 0px; padding: 0px; font-size: 12px;\"><span style=\"margin: 0px; padding: 0px;\">岁末年关将至，骗子也越来越疯狂。希望大家提高警惕，防患未然。请在充分了解DD373业务流程的情况下进行交易，切记多长个心眼，以免上当受骗带来不必要的损失。<br/></span><strong style=\"margin: 0px; padding: 0px;\"><span style=\"margin: 0px; padding: 0px; font-family: 宋体;\">骗子戏法：</span></strong></span></p><ul class=\" list-paddingleft-2\" style=\"list-style-type: circle;\"><li><p style=\"margin-top: 0px; margin-bottom: 0px; padding: 0px; text-indent: 0em; line-height: 32px; font-family: 宋体;\"><span style=\"margin: 0px; padding: 0px; color: red; font-size: 12px;\">利用QQ软件冒充客服</span><span style=\"margin: 0px; padding: 0px; font-size: 12px;\">。利用QQ个人资料可以设置任意昵称及邮箱，把真实的QQ号码伪装成DD373 客服QQ，躲过用户验证；</span></p></li><li><p style=\"margin-top: 0px; margin-bottom: 0px; padding: 0px; text-indent: 0em; line-height: 32px; font-family: 宋体;\"><span style=\"margin: 0px; padding: 0px; color: red; font-size: 12px;\">利用游戏昵称冒充客服。</span><span style=\"margin: 0px; padding: 0px; font-size: 12px;\">利用游戏角色名称，如DD373发货员或DD373客服等角色名字，在交易地点套取用户订单信息和联系方式；</span></p></li><li><p style=\"margin-top: 0px; margin-bottom: 0px; padding: 0px; text-indent: 0em; line-height: 32px; font-family: 宋体;\"><span style=\"margin: 0px; padding: 0px; font-size: 12px;\">以用户初次交易信誉不足需要</span><span style=\"margin: 0px; padding: 0px; color: red; font-size: 12px;\">交纳押金保证金</span><span style=\"margin: 0px; padding: 0px; font-size: 12px;\">为由，要求用户汇款或充值实施诈骗；</span></p></li><li><p style=\"margin-top: 0px; margin-bottom: 0px; padding: 0px; text-indent: 0em; line-height: 32px; font-family: 宋体;\"><span style=\"margin: 0px; padding: 0px; font-size: 12px;\">他人发送且需要</span><span style=\"margin: 0px; padding: 0px; color: red; font-size: 12px;\">登陆和支付的链接都是钓鱼网站</span><span style=\"margin: 0px; padding: 0px; font-size: 12px;\">，一旦支付，资金将有去无回。</span></p><p style=\"margin-top: 0px; margin-bottom: 0px; padding: 0px; text-indent: 0em; line-height: 32px; font-size: 14px;\"><span style=\"margin: 0px; padding: 0px; font-size: 12px;\"><strong style=\"margin: 0px; padding: 0px;\"><span style=\"margin: 0px; padding: 0px; font-family: 宋体;\">防骗攻略：</span></strong></span></p></li><li><p style=\"margin-top: 0px; margin-bottom: 0px; padding: 0px; text-indent: 0em; line-height: 32px; font-size: 14px;\"><span style=\"margin: 0px; padding: 0px; font-size: 12px;\">请注意保护自己的隐私，防止个人信息泄露。不要在游戏中把个人的QQ、手机号码等联系方式随便告诉陌生人；</span></p></li><li><p style=\"margin-top: 0px; margin-bottom: 0px; padding: 0px; text-indent: 0em; line-height: 32px; font-size: 14px;\"><span style=\"margin: 0px; padding: 0px; font-size: 12px;\">接到类似客服联系,请先到网站首页进行核实验证，也可登录“我的DD373→我是卖家→“我出售的商品””中便可查看到订单状态；</span></p></li><li><p style=\"margin-top: 0px; margin-bottom: 0px; padding: 0px; text-indent: 0em; line-height: 32px; font-size: 14px;\"><span style=\"margin: 0px; padding: 0px; font-size: 12px;\">切记如果您的订单无人支付购买，不会有任何客服联系您；</span><span style=\"margin: 0px; padding: 0px; font-size: 12px;\"></span></p></li><li><p style=\"margin-top: 0px; margin-bottom: 0px; padding: 0px; text-indent: 0em; line-height: 32px; font-size: 14px;\"><span style=\"margin: 0px; padding: 0px; font-size: 12px;\">DD373客服不会向您索要游戏帐号、密码等帐号信息（交易所需的信息在您发布商品和购买订单时已经填写完善）；</span></p></li><li><p style=\"margin-top: 0px; margin-bottom: 0px; padding: 0px; text-indent: 0em; line-height: 32px; font-size: 14px;\"><span style=\"margin: 0px; padding: 0px; font-size: 12px;\">如您的订单被支付，请您按照订单上买家角色名进行交易。对特殊字符等留心核对，以免认错人；</span></p></li><li><p style=\"margin-top: 0px; margin-bottom: 0px; padding: 0px; text-indent: 0em; line-height: 32px; font-size: 14px;\"><span style=\"margin: 0px; padding: 0px; font-size: 12px;\">DD373服务人员不会以任何理由向您取回已交易商品，不会在游戏中索要您的DD373账户名、QQ帐号等私密信息！</span></p></li><li><p style=\"margin-top: 0px; margin-bottom: 0px; padding: 0px; text-indent: 0em; line-height: 32px; font-size: 14px;\"><span style=\"margin: 0px; padding: 0px; font-size: 12px;\">假客服发送的订单信息里是没有DD373用户名以及客服暗号的，客服联系请谨慎核实</span></p></li></ul><p><br/></p>', '2016-11-03 11:30:44', '2016-11-11 11:30:48', '25', '0');
INSERT INTO `sf_article` VALUES ('16', '如何提现？', '', '', '<p>如何提现？如何提现？如何提现？如何提现？如何提现？如何提现？如何提现？如何提现？如何提现？如何提现？如何提现？如何提现？如何提现？如何提现？如何提现？如何提现？如何提现？如何提现？如何提现？如何提现？如何提现？如何提现？如何提现？如何提现？如何提现？如何提现？如何提现？如何提现？如何提现？如何提现？如何提现？如何提现？如何提现？如何提现？如何提现？如何提现？如何提现？如何提现？如何提现？如何提现？如何提现？如何提现？如何提现？如何提现？如何提现？如何提现？如何提现？如何提现？如何提现？如何提现？如何提现？如何提现？如何提现？如何提现？如何提现？如何提现？如何提现？如何提现？如何提现？如何提现？如何提现？如何提现？如何提现？如何提现？如何提现？如何提现？如何提现？如何提现？如何提现？如何提现？如何提现？如何提现？如何提现？如何提现？</p>', '2016-11-15 15:57:34', '2016-11-17 17:16:18', '39', '0');
INSERT INTO `sf_article` VALUES ('17', '什么是钓鱼网站', '', '', '<p style=\"padding: 0px; margin-top: 0px; margin-bottom: 0px; line-height: 20px; width: auto; overflow: hidden; clear: both; height: auto;\"><strong style=\"display: block; float: left;\">概述：</strong><span style=\"display: block; float: left; width: 502px;\">网络钓鱼是骗子的常用手法，但是只要了解了原理，也就不难防范了。</span></p><p style=\"padding: 0px; margin: 10px auto 14px; color: rgb(51, 51, 51); line-height: 24px; width: 565px; text-indent: 2em; overflow: hidden;\"><strong>定义：</strong>网络钓鱼是一种网络欺诈行为，指不法分子利用各种手段，仿冒真实网站的地址以及页面内容，以此来骗取用户银行或信用卡帐号、密码等私人资料。</p><p style=\"padding: 0px; margin: 10px auto 14px; color: rgb(51, 51, 51); line-height: 24px; width: 565px; text-indent: 2em; overflow: hidden;\"><strong>特点：</strong></p><p style=\"padding: 0px; margin: 10px auto 14px; color: rgb(51, 51, 51); line-height: 24px; width: 565px; text-indent: 2em; overflow: hidden;\">·1、假客服通过QQ和电子邮件发送假网址，<span class=\"f_red\" style=\"color: rgb(255, 0, 0);\">花言巧语诱骗您点击。</span><br/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;·2、要求您<span class=\"f_red\" style=\"color: rgb(255, 0, 0);\">提交帐号密码、邮箱、手机短信验证码等</span>关键信息，<span class=\"f_red\" style=\"color: rgb(255, 0, 0);\">仿冒网站与真实网站页面很相似。</span><br/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;·3、<span class=\"f_red\" style=\"color: rgb(255, 0, 0);\">假网址与真实网址只有细微差别</span>，但假网址结构较简单。</p><p class=\"pic\" style=\"padding: 0px; margin: 10px auto; color: rgb(68, 68, 68); line-height: 24px; width: 565px; overflow: hidden; text-align: center;\"><img src=\"/ueditor/php/upload/image/20161117/1479372846568449.jpg\"/></p><p style=\"padding: 0px; margin: 10px auto 14px; color: rgb(51, 51, 51); line-height: 24px; width: 565px; text-indent: 2em; overflow: hidden;\">安全专家提示：最好的自我保护方式是不需要多少技术的。</p><p style=\"padding: 0px; margin: 10px auto 14px; color: rgb(51, 51, 51); line-height: 24px; width: 565px; text-indent: 2em; overflow: hidden;\"><strong>1、</strong>留意网址——<span class=\"f_red\" style=\"color: rgb(255, 0, 0);\">QQ对正确的5173网址加&nbsp;<img src=\"/ueditor/php/upload/image/20161117/1479372847110884.gif\"/>&nbsp;标记。</span></p><p class=\"pic\" style=\"padding: 0px; margin: 10px auto; color: rgb(68, 68, 68); line-height: 24px; width: 565px; overflow: hidden; text-align: center;\"><img src=\"/ueditor/php/upload/image/20161117/1479372847122718.gif\"/></p><p style=\"padding: 0px; margin: 10px auto 14px; color: rgb(51, 51, 51); line-height: 24px; width: 565px; text-indent: 2em; overflow: hidden;\"><strong>2、</strong>&nbsp;验证网址——对于<span class=\"f_red\" style=\"color: rgb(255, 0, 0);\">任何通过QQ或邮件等发送的网址进行验证</span></p><p class=\"pic\" style=\"padding: 0px; margin: 10px auto; color: rgb(68, 68, 68); line-height: 24px; width: 565px; overflow: hidden; text-align: center;\"><img src=\"/ueditor/php/upload/image/20161117/1479372847389179.gif\"/></p><p style=\"padding: 0px; margin-top: 0px; margin-bottom: 0px; width: auto; clear: both; line-height: 20px; height: auto; overflow: hidden;\"><strong style=\"display: block; float: left;\">总结：</strong><span style=\"display: block; float: left; width: 502px;\">网络钓鱼不可怕，可怕的是那些骗子利用各种花言巧语骗我们去钓鱼网站。如何辨别真假，提高自身防范意识、加强网络安全知识的学习必不可少。</span></p><p><br/></p><p><br/></p>', '2016-11-17 16:54:28', '2016-11-17 16:54:34', '62', '1');
INSERT INTO `sf_article` VALUES ('18', '防止木马盗号', '', '', '<p><strong style=\"margin: 0px; padding: 0px;\">概述：</strong>&nbsp;不要因为一些小的诱惑和利益去接受或点击一些不明链接...</p><p style=\"margin-top: 10px; margin-bottom: 10px; padding: 0px; width: 650px; line-height: 1.75em; text-indent: 2em; color: rgb(51, 51, 51); font-family: Arial, 宋体, &quot;Microsoft YaHei&quot;, simsun, sans-serif, Mingliu, Verdana, Helvetica, Lucida; font-size: 12px; white-space: normal;\"><span style=\"margin: 0px; padding: 0px; font-family: 微软雅黑, &quot;Microsoft YaHei&quot;; font-size: 14px;\">防止盗号木马盗取我们的账号和密码</span></p><p style=\"margin-top: 10px; margin-bottom: 10px; padding: 0px; width: 650px; line-height: 1.75em; text-indent: 2em; color: rgb(51, 51, 51); font-family: Arial, 宋体, &quot;Microsoft YaHei&quot;, simsun, sans-serif, Mingliu, Verdana, Helvetica, Lucida; font-size: 12px; white-space: normal;\"><span style=\"margin: 0px; padding: 0px; font-family: 微软雅黑, &quot;Microsoft YaHei&quot;; font-size: 14px;\">概述：不要因为一些小的诱惑和利益去接受或点击一些不明的文件、网址，或许它们带来的木马、病毒会让您损失更多。</span></p><p style=\"margin-top: 10px; margin-bottom: 10px; padding: 0px; width: 650px; line-height: 1.75em; text-indent: 2em; color: rgb(51, 51, 51); font-family: Arial, 宋体, &quot;Microsoft YaHei&quot;, simsun, sans-serif, Mingliu, Verdana, Helvetica, Lucida; font-size: 12px; white-space: normal;\"><span style=\"margin: 0px; padding: 0px; font-family: 微软雅黑, &quot;Microsoft YaHei&quot;; font-size: 14px; line-height: 1.75em; text-indent: 2em;\">木马,全称特洛伊木马（Trojan horse），是一种客户/服务器程序，对计算机系统和网络安全危害相当大。木马病毒的传播可以通过QQ聊天时发送带有病毒的链接或者发送带有病毒的压缩包（有诱惑力内容的文件），一旦点击链接，打开压缩包就会中木马程序。</span><span style=\"margin: 0px; padding: 0px; font-family: 微软雅黑, &quot;Microsoft YaHei&quot;; font-size: 14px;\"><br/></span></p><p style=\"margin-top: 10px; margin-bottom: 10px; padding: 0px; width: 650px; line-height: 1.75em; text-indent: 2em; color: rgb(51, 51, 51); font-family: Arial, 宋体, &quot;Microsoft YaHei&quot;, simsun, sans-serif, Mingliu, Verdana, Helvetica, Lucida; font-size: 12px; white-space: normal; background: none 0% 0% repeat scroll white;\"><img src=\"/ueditor/php/upload/image/20161117/1479374159764588.png\" title=\"K)J{B[B0J`QE%H80G(7L]LO.png\"/><br/></p><p style=\"margin-top: 10px; margin-bottom: 10px; padding: 0px; width: 650px; line-height: 1.75em; text-indent: 2em; color: rgb(51, 51, 51); font-family: Arial, 宋体, &quot;Microsoft YaHei&quot;, simsun, sans-serif, Mingliu, Verdana, Helvetica, Lucida; font-size: 12px; white-space: normal; background: none 0% 0% repeat scroll white;\"><span style=\"margin: 0px; padding: 0px; font-family: 微软雅黑, &quot;Microsoft YaHei&quot;; font-size: 14px;\">很多用户就是这样被盗取帐号，密码，导致财产损失的。</span></p><p style=\"margin-top: 10px; margin-bottom: 10px; padding: 0px; width: 650px; line-height: 1.75em; text-indent: 2em; color: rgb(51, 51, 51); font-family: Arial, 宋体, &quot;Microsoft YaHei&quot;, simsun, sans-serif, Mingliu, Verdana, Helvetica, Lucida; font-size: 12px; white-space: normal; background: none 0% 0% repeat scroll white;\"><span style=\"margin: 0px; padding: 0px; font-family: 微软雅黑, &quot;Microsoft YaHei&quot;; font-size: 14px;\">以下的防范措施可以参考：</span></p><p style=\"margin-top: 10px; margin-bottom: 10px; padding: 0px; width: 650px; line-height: 1.75em; text-indent: 2em; color: rgb(51, 51, 51); font-family: Arial, 宋体, &quot;Microsoft YaHei&quot;, simsun, sans-serif, Mingliu, Verdana, Helvetica, Lucida; font-size: 12px; white-space: normal; background: none 0% 0% repeat scroll white;\"><span style=\"margin: 0px; padding: 0px; font-family: 微软雅黑, &quot;Microsoft YaHei&quot;; font-size: 14px;\">一、不要接收陌生人发来的任何压缩包文件及其他类型不明文件；</span></p><p style=\"margin-top: 10px; margin-bottom: 10px; padding: 0px; width: 650px; line-height: 1.75em; text-indent: 2em; color: rgb(51, 51, 51); font-family: Arial, 宋体, &quot;Microsoft YaHei&quot;, simsun, sans-serif, Mingliu, Verdana, Helvetica, Lucida; font-size: 12px; white-space: normal; background: none 0% 0% repeat scroll white;\"><span style=\"margin: 0px; padding: 0px; font-family: 微软雅黑, &quot;Microsoft YaHei&quot;; font-size: 14px;\">二、对可疑的文件（压缩包）进行杀毒；</span></p><p style=\"margin-top: 10px; margin-bottom: 10px; padding: 0px; width: 650px; line-height: 1.75em; text-indent: 2em; color: rgb(51, 51, 51); font-family: Arial, 宋体, &quot;Microsoft YaHei&quot;, simsun, sans-serif, Mingliu, Verdana, Helvetica, Lucida; font-size: 12px; white-space: normal; background: none 0% 0% repeat scroll white;\"><span style=\"margin: 0px; padding: 0px; font-family: 微软雅黑, &quot;Microsoft YaHei&quot;; font-size: 14px;\">三、不要接收任何自己不能确定类型的压缩包文件或者其他类型文件；</span></p><p style=\"margin-top: 10px; margin-bottom: 10px; padding: 0px; width: 650px; line-height: 1.75em; text-indent: 2em; color: rgb(51, 51, 51); font-family: Arial, 宋体, &quot;Microsoft YaHei&quot;, simsun, sans-serif, Mingliu, Verdana, Helvetica, Lucida; font-size: 12px; white-space: normal; background: none 0% 0% repeat scroll white;\"><span style=\"margin: 0px; padding: 0px; font-family: 微软雅黑, &quot;Microsoft YaHei&quot;; font-size: 14px;\">四、不要到不良网站下载不良信息文件，并解压安装到您的电脑；</span></p><p style=\"margin-top: 10px; margin-bottom: 10px; padding: 0px; width: 650px; line-height: 1.75em; text-indent: 2em; color: rgb(51, 51, 51); font-family: Arial, 宋体, &quot;Microsoft YaHei&quot;, simsun, sans-serif, Mingliu, Verdana, Helvetica, Lucida; font-size: 12px; white-space: normal; background: none 0% 0% repeat scroll white;\"><span style=\"margin: 0px; padding: 0px; font-family: 微软雅黑, &quot;Microsoft YaHei&quot;; font-size: 14px;\">五、电脑定期杀毒；</span></p><p style=\"margin-top: 10px; margin-bottom: 10px; padding: 0px; width: 650px; line-height: 1.75em; text-indent: 2em; color: rgb(51, 51, 51); font-family: Arial, 宋体, &quot;Microsoft YaHei&quot;, simsun, sans-serif, Mingliu, Verdana, Helvetica, Lucida; font-size: 12px; white-space: normal; background: none 0% 0% repeat scroll white;\"><span style=\"margin: 0px; padding: 0px; font-family: 微软雅黑, &quot;Microsoft YaHei&quot;; font-size: 14px;\">六、将QQ的安全防范级别设置为最高。</span></p><p><br/></p>', '2016-11-17 17:16:10', '2016-11-17 17:16:13', '62', '1');
INSERT INTO `sf_article` VALUES ('19', '钓鱼邮件以中奖为名诈骗用户', '', '', '<p style=\"margin-top: 10px;margin-bottom: 10px;padding: 0px;width: 650px;line-height: 1.75em;text-indent: 32px;color: rgb(51, 51, 51);font-family: Arial, 宋体, &#39;Microsoft YaHei&#39;, simsun, sans-serif, Mingliu, Verdana, Helvetica, Lucida;font-size: 12px;white-space: normal\"><span style=\";padding: 0px;color: black;font-family: 微软雅黑, &#39;Microsoft YaHei&#39;;font-size: 14px\">用户小张收到了来自骗子的一封邮件。邮件内容中以网站为名通知小张中奖，要求他点击链接以确认信息。当小张点击该链接登录（其实是个钓鱼网站）后，小张的嘟嘟账户信息已经被骗子掌握了。这时，骗子很快就将小张的账号密码修改，盗走账户里的钱。</span></p><p style=\"margin-top: 10px;margin-bottom: 10px;padding: 0px;width: 650px;line-height: 1.75em;text-indent: 32px;color: rgb(51, 51, 51);font-family: Arial, 宋体, &#39;Microsoft YaHei&#39;, simsun, sans-serif, Mingliu, Verdana, Helvetica, Lucida;font-size: 12px;white-space: normal\"><span style=\";padding: 0px;font-family: 微软雅黑, &#39;Microsoft YaHei&#39;;font-size: 14px;color: rgb(255, 0, 0)\">提醒：</span><span style=\";padding: 0px;font-family: 微软雅黑, &#39;Microsoft YaHei&#39;;font-size: 14px\"><span style=\";padding: 0px;color: black\">在您不能确认发件人是真假客服的时候，可以通过</span><span style=\";padding: 0px;color: rgb(255, 0, 0)\"><span style=\";padding: 0px\">QQ:</span>&nbsp;<span style=\";padding: 0px\">80000000</span></span><span style=\";padding: 0px;color: black\">在线咨询或拔打服务热线：&nbsp;<span style=\";padding: 0px;color: rgb(255, 0, 0)\">0373-00000（全天24小时）</span>进行咨询。</span></span></p><p><br/></p>', '2016-11-17 17:17:45', '2016-11-17 17:17:48', '62', '1');
INSERT INTO `sf_article` VALUES ('20', '各种网站骗术', '', '', '<p><strong style=\"margin: 0px; padding: 0px;\">概述：</strong>&nbsp;骗子在论坛上发布热门商品信息，并以低廉的价格诱惑买家购买他的商品，在买家联系客服之前马上提供一家网站...</p><p style=\"margin-top: 10px; margin-bottom: 10px; padding: 0px; width: 650px; line-height: 1.75em; text-indent: 2em; color: rgb(51, 51, 51); font-family: Arial, 宋体, &quot;Microsoft YaHei&quot;, simsun, sans-serif, Mingliu, Verdana, Helvetica, Lucida; font-size: 12px; white-space: normal;\"><span style=\"margin: 0px; padding: 0px; font-family: 微软雅黑, &quot;Microsoft YaHei&quot;; font-size: 14px;\">骗子在论坛上发布热门商品信息，并以低廉的价格诱惑买家购买他的商品，在买家联系客服之前马上提供一家网站，以种种借口要求买家上其提供的交易网进行交易（骗子借口最多的有：曾经被骗过钱或他的商品寄售在其提供的网站上），而当买家汇款给假网站客服，客服称有两位客户汇相同的款项，因为无法确定是哪位汇的，要求买家再次给他汇款以便确认钱是这位买家的。</span></p><p style=\"margin-top: 10px; margin-bottom: 10px; padding: 0px; width: 650px; line-height: 1.75em; text-indent: 2em; color: rgb(51, 51, 51); font-family: Arial, 宋体, &quot;Microsoft YaHei&quot;, simsun, sans-serif, Mingliu, Verdana, Helvetica, Lucida; font-size: 12px; white-space: normal;\"><span style=\"margin: 0px; padding: 0px; font-family: 微软雅黑, &quot;Microsoft YaHei&quot;; font-size: 14px;\">漏洞一：天上不会掉馅饼，请在购买物品之前先了解市场价格，如果卖家开出过低的价格时一定要引起注意。</span></p><p style=\"margin-top: 10px; margin-bottom: 10px; padding: 0px; width: 650px; line-height: 1.75em; text-indent: 2em; color: rgb(51, 51, 51); font-family: Arial, 宋体, &quot;Microsoft YaHei&quot;, simsun, sans-serif, Mingliu, Verdana, Helvetica, Lucida; font-size: 12px; white-space: normal;\"><span style=\"margin: 0px; padding: 0px; font-family: 微软雅黑, &quot;Microsoft YaHei&quot;; font-size: 14px;\">漏洞二：卖家既然已经在上发布信息，就说明对是信任的。为什么他还要以种种借口要求买家去其他交易网站呢？</span></p><p style=\"margin-top: 10px; margin-bottom: 10px; padding: 0px; width: 650px; line-height: 1.75em; text-indent: 2em; color: rgb(51, 51, 51); font-family: Arial, 宋体, &quot;Microsoft YaHei&quot;, simsun, sans-serif, Mingliu, Verdana, Helvetica, Lucida; font-size: 12px; white-space: normal;\"><span style=\"margin: 0px; padding: 0px; font-family: 微软雅黑, &quot;Microsoft YaHei&quot;; font-size: 14px;\">漏洞三：就算真的有两位客户汇款金额是一样的，那么只需要您提供银行的汇款小票就可以了，而他要您再汇款是为了骗取您更多的钱。</span></p><p><br/></p>', '2016-11-17 17:18:32', '2016-11-17 17:18:35', '61', '1');
INSERT INTO `sf_article` VALUES ('21', '安全设置密码的窍门', '', '', '<p><strong style=\"margin: 0px; padding: 0px;\">概述：</strong>&nbsp;为了您的账户安全，在设置密码时，请参考以下建议：一、密码长度保持在6-20个字符。二、设置时使用英文...</p><p style=\"margin-top: 10px; margin-bottom: 10px; padding: 0px; width: 650px; line-height: 1.75em; text-indent: 2em; color: rgb(51, 51, 51); font-family: Arial, 宋体, &quot;Microsoft YaHei&quot;, simsun, sans-serif, Mingliu, Verdana, Helvetica, Lucida; font-size: 12px; white-space: normal;\"><br/></p><p style=\"margin-top: 10px; margin-bottom: 10px; padding: 0px; width: 650px; line-height: 1.75em; text-indent: 32px; color: rgb(51, 51, 51); font-family: Arial, 宋体, &quot;Microsoft YaHei&quot;, simsun, sans-serif, Mingliu, Verdana, Helvetica, Lucida; font-size: 12px; white-space: normal;\"><span style=\"margin: 0px; padding: 0px; font-size: 14px; font-family: 微软雅黑, &quot;Microsoft YaHei&quot;;\"><strong style=\"margin: 0px; padding: 0px;\"><span style=\"margin: 0px; padding: 0px;\">一、密码长度保持在6-20个字符。</span></strong><strong style=\"margin: 0px; padding: 0px;\"><span style=\"margin: 0px; padding: 0px; font-family: 宋体;\"></span></strong></span><span style=\"margin: 0px; padding: 0px; font-family: 微软雅黑, &quot;Microsoft YaHei&quot;; font-size: 14px;\"><strong style=\"margin: 0px; padding: 0px;\"><span style=\"margin: 0px; padding: 0px; font-size: 12px; font-family: 宋体;\"></span></strong></span></p><p style=\"margin-top: 10px; margin-bottom: 10px; padding: 0px; width: 650px; line-height: 1.75em; text-indent: 32px; color: rgb(51, 51, 51); font-family: Arial, 宋体, &quot;Microsoft YaHei&quot;, simsun, sans-serif, Mingliu, Verdana, Helvetica, Lucida; font-size: 12px; white-space: normal;\"><span style=\"margin: 0px; padding: 0px; font-family: 微软雅黑, &quot;Microsoft YaHei&quot;; font-size: 14px;\"><strong style=\"margin: 0px; padding: 0px;\"><span style=\"margin: 0px; padding: 0px;\">二、设置时使用英文字母和数字的组合</span></strong><span style=\"margin: 0px; padding: 0px;\">（如asiuwe253、wfrefg694等，尽量不要规律）</span></span></p><p style=\"margin-top: 10px; margin-bottom: 10px; padding: 0px; width: 650px; line-height: 1.75em; text-indent: 32px; color: rgb(51, 51, 51); font-family: Arial, 宋体, &quot;Microsoft YaHei&quot;, simsun, sans-serif, Mingliu, Verdana, Helvetica, Lucida; font-size: 12px; white-space: normal;\"><img src=\"/ueditor/php/upload/image/20161117/1479374344970366.png\" title=\"F@MQ[WKHVD5KW48SKX@%R43.png\"/><br/></p><p style=\"margin-top: 10px; margin-bottom: 10px; padding: 0px; width: 650px; line-height: 1.75em; text-indent: 32px; color: rgb(51, 51, 51); font-family: Arial, 宋体, &quot;Microsoft YaHei&quot;, simsun, sans-serif, Mingliu, Verdana, Helvetica, Lucida; font-size: 12px; white-space: normal;\"><br/></p><p style=\"margin-top: 10px; margin-bottom: 10px; padding: 0px; width: 650px; line-height: 1.75em; text-indent: 32px; color: rgb(51, 51, 51); font-family: Arial, 宋体, &quot;Microsoft YaHei&quot;, simsun, sans-serif, Mingliu, Verdana, Helvetica, Lucida; font-size: 12px; white-space: normal;\"><span style=\"margin: 0px; padding: 0px; font-size: 14px; font-family: 微软雅黑, &quot;Microsoft YaHei&quot;;\"><strong style=\"margin: 0px; padding: 0px;\"><span style=\"margin: 0px; padding: 0px;\">三、千万别设置成以下这样安全性过低的密码：</span></strong><strong style=\"margin: 0px; padding: 0px;\"><span style=\"margin: 0px; padding: 0px; font-family: 宋体;\"></span></strong></span><span style=\"margin: 0px; padding: 0px; font-family: 微软雅黑, &quot;Microsoft YaHei&quot;; font-size: 14px;\"><strong style=\"margin: 0px; padding: 0px;\"><span style=\"margin: 0px; padding: 0px; font-size: 12px; font-family: 宋体;\"></span></strong></span></p><p style=\"margin-top: 10px; margin-bottom: 10px; padding: 0px; width: 650px; line-height: 1.75em; text-indent: 32px; color: rgb(51, 51, 51); font-family: Arial, 宋体, &quot;Microsoft YaHei&quot;, simsun, sans-serif, Mingliu, Verdana, Helvetica, Lucida; font-size: 12px; white-space: normal;\"><span style=\"margin: 0px; padding: 0px; font-family: 微软雅黑, &quot;Microsoft YaHei&quot;; font-size: 14px;\">1. 密码和登录帐号完全一致；</span></p><p style=\"margin-top: 10px; margin-bottom: 10px; padding: 0px; width: 650px; line-height: 1.75em; text-indent: 32px; color: rgb(51, 51, 51); font-family: Arial, 宋体, &quot;Microsoft YaHei&quot;, simsun, sans-serif, Mingliu, Verdana, Helvetica, Lucida; font-size: 12px; white-space: normal;\"><span style=\"margin: 0px; padding: 0px; font-family: 微软雅黑, &quot;Microsoft YaHei&quot;; font-size: 14px;\">2. 密码和您的联系方式一致；（如：电话号码为：0755-85027110，密码为：85027110）</span></p><p style=\"margin-top: 10px; margin-bottom: 10px; padding: 0px; width: 650px; line-height: 1.75em; text-indent: 32px; color: rgb(51, 51, 51); font-family: Arial, 宋体, &quot;Microsoft YaHei&quot;, simsun, sans-serif, Mingliu, Verdana, Helvetica, Lucida; font-size: 12px; white-space: normal;\"><span style=\"margin: 0px; padding: 0px; font-family: 微软雅黑, &quot;Microsoft YaHei&quot;; font-size: 14px;\">3. 密码用连续数字或字母组成；（如：123456、abcdef）</span></p><p style=\"margin-top: 10px; margin-bottom: 10px; padding: 0px; width: 650px; line-height: 1.75em; text-indent: 32px; color: rgb(51, 51, 51); font-family: Arial, 宋体, &quot;Microsoft YaHei&quot;, simsun, sans-serif, Mingliu, Verdana, Helvetica, Lucida; font-size: 12px; white-space: normal;\"><span style=\"margin: 0px; padding: 0px; font-family: 微软雅黑, &quot;Microsoft YaHei&quot;; font-size: 14px;\">4. 密码用同一个字母或数字的连续形式；（如：111111，aaaaaa）</span></p><p style=\"margin-top: 10px; margin-bottom: 10px; padding: 0px; width: 650px; line-height: 1.75em; text-indent: 32px; color: rgb(51, 51, 51); font-family: Arial, 宋体, &quot;Microsoft YaHei&quot;, simsun, sans-serif, Mingliu, Verdana, Helvetica, Lucida; font-size: 12px; white-space: normal;\"><span style=\"margin: 0px; padding: 0px; font-family: 微软雅黑, &quot;Microsoft YaHei&quot;; font-size: 14px;\">5. 密码是帐号中的一部分； （如您的登录帐号是 fadfi1243556，勿使用1243556或fadfi作为密码）</span></p><p style=\"margin-top: 10px; margin-bottom: 10px; padding: 0px; width: 650px; line-height: 1.75em; text-indent: 32px; color: rgb(51, 51, 51); font-family: Arial, 宋体, &quot;Microsoft YaHei&quot;, simsun, sans-serif, Mingliu, Verdana, Helvetica, Lucida; font-size: 12px; white-space: normal;\"><span style=\"margin: 0px; padding: 0px; font-family: 微软雅黑, &quot;Microsoft YaHei&quot;; font-size: 14px;\">6. 密码是您的姓名拼音、您的生日；（如：姓名：张三，密码：zhangsan、生日：1982年6月12日，密码：820612）</span></p><p style=\"margin-top: 10px; margin-bottom: 10px; padding: 0px; width: 650px; line-height: 1.75em; text-indent: 32px; color: rgb(51, 51, 51); font-family: Arial, 宋体, &quot;Microsoft YaHei&quot;, simsun, sans-serif, Mingliu, Verdana, Helvetica, Lucida; font-size: 12px; white-space: normal;\"><span style=\"margin: 0px; padding: 0px; font-family: 微软雅黑, &quot;Microsoft YaHei&quot;; font-size: 14px;\">7. 密码用简单有规律的数字。（如：789456、123321）</span></p><p style=\"margin-top: 10px; margin-bottom: 10px; padding: 0px; width: 650px; line-height: 1.75em; text-indent: 32px; color: rgb(51, 51, 51); font-family: Arial, 宋体, &quot;Microsoft YaHei&quot;, simsun, sans-serif, Mingliu, Verdana, Helvetica, Lucida; font-size: 12px; white-space: normal;\"><span style=\"margin: 0px; padding: 0px; font-family: 微软雅黑, &quot;Microsoft YaHei&quot;; font-size: 14px;\"><span style=\"margin: 0px; padding: 0px;\">如果您目前设置的就是类似上述安全性过低的密码，</span><span style=\"margin: 0px; padding: 0px; color: rgb(255, 0, 0);\">请立即进行修改</span><span style=\"margin: 0px; padding: 0px;\">。</span><span style=\"margin: 0px; padding: 0px; line-height: 1.75em;\">&nbsp;&nbsp;</span></span><span style=\"margin: 0px; padding: 0px; font-family: 微软雅黑, &quot;Microsoft YaHei&quot;; font-size: 14px; line-height: 1.75em;\">&nbsp;&nbsp;</span></p><p style=\"margin-top: 10px; margin-bottom: 10px; padding: 0px; width: 650px; line-height: 1.75em; text-indent: 2em; color: rgb(51, 51, 51); font-family: Arial, 宋体, &quot;Microsoft YaHei&quot;, simsun, sans-serif, Mingliu, Verdana, Helvetica, Lucida; font-size: 12px; white-space: normal;\"><span style=\"margin: 0px; padding: 0px; font-size: 14px; font-family: 微软雅黑, &quot;Microsoft YaHei&quot;;\"><strong style=\"margin: 0px; padding: 0px;\"><span style=\"margin: 0px; padding: 0px;\">四、定期修改登录密码，可以让你的帐户更安全。</span></strong></span></p><p><br/></p>', '2016-11-17 17:19:09', '2016-11-17 17:19:12', '61', '1');
INSERT INTO `sf_article` VALUES ('22', '注意保护个人隐私数据', '', '', '<p><strong style=\"margin: 0px; padding: 0px;\">概述：</strong>&nbsp;在别的地方上网时应特别注意自己的个人数据</p><p style=\"margin-top: 0px; margin-bottom: 0px; padding: 0px; width: 650px; line-height: 30px; text-indent: 2em; color: rgb(51, 51, 51); font-family: Arial, 宋体, &quot;Microsoft YaHei&quot;, simsun, sans-serif, Mingliu, Verdana, Helvetica, Lucida; font-size: 12px; white-space: normal;\"><br/></p><p style=\"margin-top: 10px; margin-bottom: 10px; padding: 0px; width: 650px; line-height: 1.75em; text-indent: 2em; color: rgb(51, 51, 51); font-family: Arial, 宋体, &quot;Microsoft YaHei&quot;, simsun, sans-serif, Mingliu, Verdana, Helvetica, Lucida; font-size: 12px; white-space: normal;\"><span style=\"margin: 0px; padding: 0px; font-family: 微软雅黑, &quot;Microsoft YaHei&quot;; font-size: 14px;\">提醒各位注意保护隐私数据，尤其是在别的地方上网时，比如，你在别人的电脑登录QQ，建议选择网吧模式登录，这样在你下线时，你的聊天记录和QQ号信息会被删除，不用担心有人用黑客程序破解你的QQ密码和聊天内容。</span></p><p style=\"margin-top: 10px; margin-bottom: 10px; padding: 0px; width: 650px; line-height: 1.75em; text-indent: 2em; color: rgb(51, 51, 51); font-family: Arial, 宋体, &quot;Microsoft YaHei&quot;, simsun, sans-serif, Mingliu, Verdana, Helvetica, Lucida; font-size: 12px; white-space: normal;\"><span style=\"margin: 0px; padding: 0px; font-family: 微软雅黑, &quot;Microsoft YaHei&quot;; font-size: 14px;\">当你下线时，可以选择清空浏览器缓存和cookies，让居心不良的攻击者无机可趁。你使用电脑留下的记录、打开文档的记录，都可能暴露你的个人信息。利用IE自带的历史清理工具就可以把浏览器历史清除。</span><span style=\"margin: 0px; padding: 0px; font-family: 微软雅黑, &quot;Microsoft YaHei&quot;; font-size: 14px; line-height: 1.75em; text-indent: 2em;\">&nbsp;&nbsp;</span></p><p style=\"margin-top: 10px; margin-bottom: 10px; padding: 0px; width: 650px; line-height: 1.75em; text-indent: 2em; color: rgb(51, 51, 51); font-family: Arial, 宋体, &quot;Microsoft YaHei&quot;, simsun, sans-serif, Mingliu, Verdana, Helvetica, Lucida; font-size: 12px; white-space: normal;\"><span style=\"margin: 0px; padding: 0px; font-family: 微软雅黑, &quot;Microsoft YaHei&quot;; font-size: 14px;\">另外，听说网吧里还有一帮人，专在别人背后看人输密码，技能非常熟练，可以在很短时间内把别人输入的密码记下来。你在网吧上网时，得注意看看身后有没有人盯着。</span></p><p><br/></p>', '2016-11-17 17:19:34', '2016-11-17 17:19:36', '61', '1');
INSERT INTO `sf_article` VALUES ('23', '假冒客服的各种诈骗骗术', '', '', '<p><strong style=\"margin: 0px; padding: 0px;\">概述：</strong>&nbsp;一：假冒交易客服1. 骗子假装买家联系受骗者谈好价格后，再用与真客服QQ相近的号码通知受骗者汇款已经...</p><p style=\"margin-top: 10px; margin-bottom: 10px; padding: 0px; width: 650px; line-height: 1.75em; text-indent: 2em; color: rgb(51, 51, 51); font-family: Arial, 宋体, &quot;Microsoft YaHei&quot;, simsun, sans-serif, Mingliu, Verdana, Helvetica, Lucida; font-size: 12px; white-space: normal;\"><span style=\"margin: 0px; padding: 0px; font-family: 微软雅黑, &quot;Microsoft YaHei&quot;; font-size: 14px;\">&nbsp;一：假冒交易客服</span></p><p style=\"margin-top: 10px; margin-bottom: 10px; padding: 0px; width: 650px; line-height: 1.75em; text-indent: 2em; color: rgb(51, 51, 51); font-family: Arial, 宋体, &quot;Microsoft YaHei&quot;, simsun, sans-serif, Mingliu, Verdana, Helvetica, Lucida; font-size: 12px; white-space: normal;\"><span style=\"margin: 0px; padding: 0px; font-family: 微软雅黑, &quot;Microsoft YaHei&quot;; font-size: 14px;\">1. 骗子假装买家联系受骗者谈好价格后，再用与真客服QQ相近的号码通知受骗者汇款已经到客服帐户上，请他上线把交易商品移交给骗子。</span></p><p style=\"margin-top: 10px; margin-bottom: 10px; padding: 0px; width: 650px; line-height: 1.75em; text-indent: 2em; color: rgb(51, 51, 51); font-family: Arial, 宋体, &quot;Microsoft YaHei&quot;, simsun, sans-serif, Mingliu, Verdana, Helvetica, Lucida; font-size: 12px; white-space: normal;\"><span style=\"margin: 0px; padding: 0px; font-family: 微软雅黑, &quot;Microsoft YaHei&quot;; font-size: 14px;\">2. &nbsp;骗子发布虚假出售信息，受骗者与骗子联系后，骗子以低廉的价格引诱受骗者购买他的商品并用假客服加受骗者QQ，受骗者与假客服联系并填写交易单子的同时。骗子也在与真客服联系填写同样金额的交易单子。假客服让受骗者代替他给真客服帐户上汇款。受骗者汇款之后联系假客服，骗子也同时联系真客服告知汇款到了，但以种种理由要求退款。真客服查到钱并确认是骗子与她产生的这笔交易退款给骗子。</span></p><p style=\"margin-top: 10px; margin-bottom: 10px; padding: 0px; width: 650px; line-height: 1.75em; text-indent: 2em; color: rgb(51, 51, 51); font-family: Arial, 宋体, &quot;Microsoft YaHei&quot;, simsun, sans-serif, Mingliu, Verdana, Helvetica, Lucida; font-size: 12px; white-space: normal;\"><span style=\"margin: 0px; padding: 0px; font-family: 微软雅黑, &quot;Microsoft YaHei&quot;; font-size: 14px;\">3. 骗子在担保下订单后打网络电话给卖家电话，告知卖家已有买家汇款至，请卖家上线把商品移交给客服。然后再用假客服联系卖家QQ骗取商品。</span></p><p style=\"margin-top: 10px; margin-bottom: 10px; padding: 0px; width: 650px; line-height: 1.75em; text-indent: 2em; color: rgb(51, 51, 51); font-family: Arial, 宋体, &quot;Microsoft YaHei&quot;, simsun, sans-serif, Mingliu, Verdana, Helvetica, Lucida; font-size: 12px; white-space: normal;\"><span style=\"margin: 0px; padding: 0px; font-family: 微软雅黑, &quot;Microsoft YaHei&quot;; font-size: 14px;\">二：假冒热线客服</span></p><p style=\"margin-top: 10px; margin-bottom: 10px; padding: 0px; width: 650px; line-height: 1.75em; text-indent: 2em; color: rgb(51, 51, 51); font-family: Arial, 宋体, &quot;Microsoft YaHei&quot;, simsun, sans-serif, Mingliu, Verdana, Helvetica, Lucida; font-size: 12px; white-space: normal;\"><span style=\"margin: 0px; padding: 0px; font-family: 微软雅黑, &quot;Microsoft YaHei&quot;; font-size: 14px;\">受骗者在论坛上发布咨询帖并留有自己的联系方式，骗子看到后假冒工作人员联系受骗者，要求受骗者把账号、登录密码和支付密码给他或按照求助内容进行诈骗。</span></p><p><br/></p>', '2016-11-17 17:20:29', '2016-11-17 17:20:31', '63', '1');
INSERT INTO `sf_article` VALUES ('24', '当心钓鱼网站和假冒官方工作人员', '', '', '<p><strong style=\"margin: 0px; padding: 0px;\">概述：</strong>&nbsp;当心钓鱼网站和假冒官方工作人员</p><p style=\"margin-top: 0px; margin-bottom: 0px; padding: 0px; width: 650px; line-height: 30px; text-indent: 2em; color: rgb(51, 51, 51); font-family: Arial, 宋体, &quot;Microsoft YaHei&quot;, simsun, sans-serif, Mingliu, Verdana, Helvetica, Lucida; font-size: 12px; white-space: normal;\"><br/></p><p style=\"margin-top: 10px; margin-bottom: 10px; padding: 0px; width: 650px; line-height: 1.75em; text-indent: 2em; color: rgb(51, 51, 51); font-family: Arial, 宋体, &quot;Microsoft YaHei&quot;, simsun, sans-serif, Mingliu, Verdana, Helvetica, Lucida; font-size: 12px; white-space: normal;\"><span style=\"margin: 0px; padding: 0px; font-family: 微软雅黑, &quot;Microsoft YaHei&quot;; font-size: 14px;\">骗子在论坛上发布热门商品信息，并以低廉的价格诱惑买家购买他的商品，在买家联系客服之前马上提供一家网站，以种种借口要求买家上其提供的交易网进行交易，而当买家汇款给假网站客服，客服称有两位客户汇相同的款项，因为无法确定是哪位汇的，要求买家再次给他汇款以便确认钱是这位买家的。</span></p><p style=\"margin-top: 10px; margin-bottom: 10px; padding: 0px; width: 650px; line-height: 1.75em; text-indent: 2em; color: rgb(51, 51, 51); font-family: Arial, 宋体, &quot;Microsoft YaHei&quot;, simsun, sans-serif, Mingliu, Verdana, Helvetica, Lucida; font-size: 12px; white-space: normal;\"><span style=\"margin: 0px; padding: 0px; font-family: 微软雅黑, &quot;Microsoft YaHei&quot;; font-size: 14px; color: rgb(255, 0, 0);\">漏洞一：</span><span style=\"margin: 0px; padding: 0px; font-family: 微软雅黑, &quot;Microsoft YaHei&quot;; font-size: 14px;\">天上不会掉馅饼，请在购买物品之前先了解市场价格，如果卖家开出过低的价格时一定要引起注意。</span></p><p style=\"margin-top: 10px; margin-bottom: 10px; padding: 0px; width: 650px; line-height: 1.75em; text-indent: 2em; color: rgb(51, 51, 51); font-family: Arial, 宋体, &quot;Microsoft YaHei&quot;, simsun, sans-serif, Mingliu, Verdana, Helvetica, Lucida; font-size: 12px; white-space: normal;\"><span style=\"margin: 0px; padding: 0px; font-family: 微软雅黑, &quot;Microsoft YaHei&quot;; font-size: 14px; color: rgb(255, 0, 0);\">漏洞二：</span><span style=\"margin: 0px; padding: 0px; font-family: 微软雅黑, &quot;Microsoft YaHei&quot;; font-size: 14px;\">就算真的有两位客户汇款金额是一样的，那么只需要您提供银行的汇款小票就可以了，而他要您再汇款是为了骗取您更多的钱。</span></p><p><br/></p>', '2016-11-17 17:20:57', '2016-11-17 17:23:12', '66', '1');
INSERT INTO `sf_article` VALUES ('25', '购买低价装备被骗钱', '', '', '<p><strong style=\"margin: 0px; padding: 0px;\">概述：</strong>&nbsp;不要因为贪图小便宜而被骗</p><p style=\"margin-top: 0px; margin-bottom: 0px; padding: 0px; width: 650px; line-height: 30px; text-indent: 2em; color: rgb(51, 51, 51); font-family: Arial, 宋体, &quot;Microsoft YaHei&quot;, simsun, sans-serif, Mingliu, Verdana, Helvetica, Lucida; font-size: 12px; white-space: normal;\"><br/></p><p style=\"margin-top: 10px; margin-bottom: 10px; padding: 0px; width: 650px; line-height: 1.75em; text-indent: 24pt; color: rgb(51, 51, 51); font-family: Arial, 宋体, &quot;Microsoft YaHei&quot;, simsun, sans-serif, Mingliu, Verdana, Helvetica, Lucida; font-size: 12px; white-space: normal;\"><span style=\"margin: 0px; padding: 0px; font-family: 微软雅黑, &quot;Microsoft YaHei&quot;; color: black; font-size: 14px;\">很多游戏玩家在购买一些极品装备时，一旦有卖家声称有且以不是很高的价格出售时，为了快速获得，往往会忽视交易安全的问题。对于像通过QQ发来的链接，一般都不会去仔细辨认真假。骗子们正是抓住了这种急于求成的心理，以廉价出售高级物品的诱饵骗取买家上钩进行诈骗。</span></p><p style=\"margin-top: 10px; margin-bottom: 10px; padding: 0px; width: 650px; line-height: 1.75em; text-indent: 24pt; color: rgb(51, 51, 51); font-family: Arial, 宋体, &quot;Microsoft YaHei&quot;, simsun, sans-serif, Mingliu, Verdana, Helvetica, Lucida; font-size: 12px; white-space: normal;\"><span style=\"margin: 0px; padding: 0px; font-family: 微软雅黑, &quot;Microsoft YaHei&quot;; color: black; font-size: 14px;\">小刘是一位网游《天龙八部2》的玩家，由于该游戏中打造的极品装备可以进行交易，小刘最近也在网上一直寻找相关的出售信息。但是没想到被骗了。</span></p><p style=\"margin-top: 10px; margin-bottom: 10px; padding: 0px; width: 650px; line-height: 1.75em; text-indent: 24pt; color: rgb(51, 51, 51); font-family: Arial, 宋体, &quot;Microsoft YaHei&quot;, simsun, sans-serif, Mingliu, Verdana, Helvetica, Lucida; font-size: 12px; white-space: normal;\"><span style=\"margin: 0px; padding: 0px; color: black; font-family: 微软雅黑, &quot;Microsoft YaHei&quot;; font-size: 14px;\">很显然，小刘被骗子卖家利用钓鱼链接盗取了账号信息，资金已经被卖家转移了。同时，为了骗取小刘更多的钱，假客服又以缴纳交易保证金的理由进行了诈骗。因为小刘没有更多的钱去充值，骗子最后竟然连他的游戏账号里的装备也全部骗取并盗走。</span></p><p style=\"margin-top: 10px; margin-bottom: 10px; padding: 0px; width: 650px; line-height: 1.75em; text-indent: 24pt; color: rgb(51, 51, 51); font-family: Arial, 宋体, &quot;Microsoft YaHei&quot;, simsun, sans-serif, Mingliu, Verdana, Helvetica, Lucida; font-size: 12px; white-space: normal;\"><span style=\"margin: 0px; padding: 0px; color: black; font-family: 微软雅黑, &quot;Microsoft YaHei&quot;; font-size: 14px;\">为什么会被骗，究其原因，还是因为急于购买装备而造成的。</span></p><p style=\"margin-top: 10px; margin-bottom: 10px; padding: 0px; width: 650px; line-height: 1.75em; text-indent: 2em; color: rgb(51, 51, 51); font-family: Arial, 宋体, &quot;Microsoft YaHei&quot;, simsun, sans-serif, Mingliu, Verdana, Helvetica, Lucida; font-size: 12px; white-space: normal;\"><span style=\"margin: 0px; padding: 0px; font-family: 微软雅黑, &quot;Microsoft YaHei&quot;; font-size: 14px; color: rgb(255, 0, 0);\">温馨提示：</span><span style=\"margin: 0px; padding: 0px; font-size: 14px; font-family: 微软雅黑, &quot;Microsoft YaHei&quot;;\"><span style=\"margin: 0px; padding: 0px; color: black;\">在点击骗子通过QQ发来的链接前，</span><span style=\"margin: 0px; padding: 0px; color: red;\">请在官方网站上进行咨询核实，谨防上当受骗。</span></span></p><p><br/></p>', '2016-11-17 17:21:29', '2016-11-17 17:23:10', '66', '1');
INSERT INTO `sf_article` VALUES ('26', '诈骗网银的过程', '', '', '<p><strong style=\"margin: 0px; padding: 0px;\">概述：</strong>&nbsp;刚刚加入二手商的芊芊邮箱里收到这样一封邮件&amp;ldquo;您好，我是XX游戏的大卖家，因五一要...</p><p style=\"margin-top: 10px; margin-bottom: 10px; padding: 0px; width: 650px; line-height: 1.75em; text-indent: 2em; color: rgb(51, 51, 51); font-family: Arial, 宋体, &quot;Microsoft YaHei&quot;, simsun, sans-serif, Mingliu, Verdana, Helvetica, Lucida; font-size: 12px; white-space: normal;\"><span style=\"margin: 0px; padding: 0px; font-family: 微软雅黑, &quot;Microsoft YaHei&quot;; font-size: 14px;\">刚刚加入二手商的芊芊邮箱里收到这样一封邮件：</span></p><p style=\"margin-top: 10px; margin-bottom: 10px; padding: 0px; width: 650px; line-height: 1.75em; text-indent: 2em; color: rgb(51, 51, 51); font-family: Arial, 宋体, &quot;Microsoft YaHei&quot;, simsun, sans-serif, Mingliu, Verdana, Helvetica, Lucida; font-size: 12px; white-space: normal;\"><span style=\"margin: 0px; padding: 0px; font-family: 微软雅黑, &quot;Microsoft YaHei&quot;; font-size: 14px;\">“您好，我是XX游戏的大卖家，因五一要出门旅游，所以想把手上一批XX游戏的装备以低于市场价2/3的价格抛售，请您登陆我的网站www.*****.com &nbsp;查看详情”</span></p><p style=\"margin-top: 10px; margin-bottom: 10px; padding: 0px; width: 650px; line-height: 1.75em; text-indent: 2em; color: rgb(51, 51, 51); font-family: Arial, 宋体, &quot;Microsoft YaHei&quot;, simsun, sans-serif, Mingliu, Verdana, Helvetica, Lucida; font-size: 12px; white-space: normal;\"><span style=\"margin: 0px; padding: 0px; font-family: 微软雅黑, &quot;Microsoft YaHei&quot;; font-size: 14px;\">芊芊一看有这么便宜的事，没有多想直接进入了网站。</span></p><p style=\"margin-top: 10px; margin-bottom: 10px; padding: 0px; width: 650px; line-height: 1.75em; text-indent: 2em; color: rgb(51, 51, 51); font-family: Arial, 宋体, &quot;Microsoft YaHei&quot;, simsun, sans-serif, Mingliu, Verdana, Helvetica, Lucida; font-size: 12px; white-space: normal;\"><span style=\"margin: 0px; padding: 0px; font-family: 微软雅黑, &quot;Microsoft YaHei&quot;; font-size: 14px;\">网站里不仅有价格低得离谱的游戏装备卖，还有非常便宜的点卡，芊芊心里想：“网上骗子这么多，价格这么低说不定就是骗子哦！我先买一张小金额的点卡试试，如果给我了就说明不是骗子了。”想到这为自己的小聪明而得意洋洋的芊芊，在网站上链接的银行支付页面上登录自己的账户转钱，而芊芊等网站发点卡给她的时候骗子已经把她银行里的钱全部转走了。</span></p><p style=\"margin-top: 10px; margin-bottom: 10px; padding: 0px; width: 650px; line-height: 1.75em; text-indent: 2em; color: rgb(51, 51, 51); font-family: Arial, 宋体, &quot;Microsoft YaHei&quot;, simsun, sans-serif, Mingliu, Verdana, Helvetica, Lucida; font-size: 12px; white-space: normal;\"><strong style=\"margin: 0px; padding: 0px;\"><span style=\"margin: 0px; padding: 0px; font-family: 微软雅黑, &quot;Microsoft YaHei&quot;; font-size: 14px;\">分析：</span></strong></p><p style=\"margin-top: 10px; margin-bottom: 10px; padding: 0px; width: 650px; line-height: 1.75em; text-indent: 2em; color: rgb(51, 51, 51); font-family: Arial, 宋体, &quot;Microsoft YaHei&quot;, simsun, sans-serif, Mingliu, Verdana, Helvetica, Lucida; font-size: 12px; white-space: normal;\"><span style=\"margin: 0px; padding: 0px; font-family: 微软雅黑, &quot;Microsoft YaHei&quot;; font-size: 14px;\">一、以超低价格诱惑买家消费，利用了人们求便宜的心理。</span></p><p style=\"margin-top: 10px; margin-bottom: 10px; padding: 0px; width: 650px; line-height: 1.75em; text-indent: 2em; color: rgb(51, 51, 51); font-family: Arial, 宋体, &quot;Microsoft YaHei&quot;, simsun, sans-serif, Mingliu, Verdana, Helvetica, Lucida; font-size: 12px; white-space: normal;\"><span style=\"margin: 0px; padding: 0px; font-family: 微软雅黑, &quot;Microsoft YaHei&quot;; font-size: 14px;\">二、利用免费注册会员信息获取玩家登录账号和密码。建议网站的注册信息尽量少用真实信息，特别是注册账号和密码要避免与游戏账号相同。</span></p><p style=\"margin-top: 10px; margin-bottom: 10px; padding: 0px; width: 650px; line-height: 1.75em; text-indent: 2em; color: rgb(51, 51, 51); font-family: Arial, 宋体, &quot;Microsoft YaHei&quot;, simsun, sans-serif, Mingliu, Verdana, Helvetica, Lucida; font-size: 12px; white-space: normal;\"><span style=\"margin: 0px; padding: 0px; font-family: 微软雅黑, &quot;Microsoft YaHei&quot;; font-size: 14px;\">三、在支付前一定要核实银行支付页面的专用网址与网站跳转的支付网址。</span></p><p><br/></p>', '2016-11-17 17:22:02', '2016-11-17 17:23:09', '65', '1');
INSERT INTO `sf_article` VALUES ('27', '如何举报和处理垃圾或非法邮件', '', '第三方第三方的手', '<p><strong style=\"margin: 0px; padding: 0px;\">概述：</strong>&nbsp;当您收到垃圾邮件或钓鱼网站邮件时...</p><p style=\"margin-top: 10px; margin-bottom: 10px; padding: 0px; width: 650px; line-height: 1.75em; text-indent: 2em; color: rgb(51, 51, 51); font-family: Arial, 宋体, &quot;Microsoft YaHei&quot;, simsun, sans-serif, Mingliu, Verdana, Helvetica, Lucida; font-size: 12px; white-space: normal;\"><span style=\"margin: 0px; padding: 0px; font-family: 微软雅黑, &quot;Microsoft YaHei&quot;; font-size: 14px;\">当您收到垃圾邮件或钓鱼网站邮件时，可直接向中国互联网协会反垃圾邮件中心进行举报，也可将此邮件作为附件转发到中国互联网违法和不良信息举报中心邮箱（jubao@china.org.cn）后，由我中心转交至反垃圾邮件中心。</span></p><p style=\"margin-top: 10px; margin-bottom: 10px; padding: 0px; width: 650px; line-height: 1.75em; text-indent: 2em; color: rgb(51, 51, 51); font-family: Arial, 宋体, &quot;Microsoft YaHei&quot;, simsun, sans-serif, Mingliu, Verdana, Helvetica, Lucida; font-size: 12px; white-space: normal;\"><span style=\"margin: 0px; padding: 0px; font-family: 微软雅黑, &quot;Microsoft YaHei&quot;; font-size: 14px;\">垃圾邮件举报受理中心综合平台举报受理方式如下：</span></p><p style=\"margin-top: 10px; margin-bottom: 10px; padding: 0px; width: 650px; line-height: 1.75em; text-indent: 2em; color: rgb(51, 51, 51); font-family: Arial, 宋体, &quot;Microsoft YaHei&quot;, simsun, sans-serif, Mingliu, Verdana, Helvetica, Lucida; font-size: 12px; white-space: normal;\"><span style=\"margin: 0px; padding: 0px; font-family: 微软雅黑, &quot;Microsoft YaHei&quot;; font-size: 14px;\">（1）电话：010-12321；各省举报中心为：省会城市区号+12321</span></p><p style=\"margin-top: 10px; margin-bottom: 10px; padding: 0px; width: 650px; line-height: 1.75em; text-indent: 2em; color: rgb(51, 51, 51); font-family: Arial, 宋体, &quot;Microsoft YaHei&quot;, simsun, sans-serif, Mingliu, Verdana, Helvetica, Lucida; font-size: 12px; white-space: normal;\"><span style=\"margin: 0px; padding: 0px; font-family: 微软雅黑, &quot;Microsoft YaHei&quot;; font-size: 14px;\">（2）邮件：abuse@anti-spam.cn；各省举报中心为：省会城市区号+@anti-spam.cn</span></p><p style=\"margin-top: 10px; margin-bottom: 10px; padding: 0px; width: 650px; line-height: 1.75em; text-indent: 2em; color: rgb(51, 51, 51); font-family: Arial, 宋体, &quot;Microsoft YaHei&quot;, simsun, sans-serif, Mingliu, Verdana, Helvetica, Lucida; font-size: 12px; white-space: normal;\"><span style=\"margin: 0px; padding: 0px; font-family: 微软雅黑, &quot;Microsoft YaHei&quot;; font-size: 14px;\">（3）网站：http://www.anti-spam.cn/； 全国统一。</span></p><p><br/></p>', '2016-11-17 17:22:58', '2016-11-18 16:42:14', '61', '1');
INSERT INTO `sf_article` VALUES ('28', '如何提现', '', '', '<p style=\"margin-top: 10px; margin-bottom: 10px; padding: 0px; font-size: 14px; line-height: 1.75em; text-indent: 2em; color: rgb(51, 51, 51); font-family: Arial, 宋体, &quot;Microsoft YaHei&quot;, simsun, sans-serif, Mingliu, Verdana, Helvetica, Lucida; white-space: normal;\"><span style=\"margin: 0px; padding: 0px; font-family: 微软雅黑, &quot;Microsoft YaHei&quot;; color: rgb(255, 0, 0);\">温馨提示：充值和退款资金需要在48小时后才能提现。</span></p><p style=\"margin-top: 10px; margin-bottom: 10px; padding: 0px; font-size: 14px; line-height: 1.75em; text-indent: 2em; color: rgb(51, 51, 51); font-family: Arial, 宋体, &quot;Microsoft YaHei&quot;, simsun, sans-serif, Mingliu, Verdana, Helvetica, Lucida; white-space: normal;\"><span style=\"margin: 0px; padding: 0px; font-family: 微软雅黑, &quot;Microsoft YaHei&quot;;\">1、个人账户登录并选择首页上方的“提现”如图所示：</span></p><p style=\"margin-top: 0px; margin-bottom: 0px; padding: 0px; font-size: 14px; line-height: 52px; text-indent: 2em; color: rgb(51, 51, 51); font-family: Arial, 宋体, &quot;Microsoft YaHei&quot;, simsun, sans-serif, Mingliu, Verdana, Helvetica, Lucida; white-space: normal;\"><span style=\"margin: 0px; padding: 0px; color: rgb(0, 0, 0); font-family: 宋体, sans-serif; line-height: 19px; background-color: rgb(255, 255, 255);\"><img src=\"/ueditor/php/upload/image/20161206/1481011620107403.png\" title=\"dd373.1.png\"/><br/></span></p><p style=\"margin-top: 10px; margin-bottom: 10px; padding: 0px; font-size: 14px; line-height: 1.75em; text-indent: 2em; color: rgb(51, 51, 51); font-family: Arial, 宋体, &quot;Microsoft YaHei&quot;, simsun, sans-serif, Mingliu, Verdana, Helvetica, Lucida; white-space: normal;\"><span style=\"margin: 0px; padding: 0px; color: rgb(0, 0, 0); line-height: 19px; font-family: 微软雅黑, &quot;Microsoft YaHei&quot;; background-color: rgb(255, 255, 255);\">2、在打开的新页面中，查看一下自己账号上面的“可提现金额”，并输入相应的金额，查看自己的银行账号和真实姓名是否吻合，看一下相对应的银行名称，最后，输入支付密码,点 击“下一步”按钮。如图所示：</span></p><p style=\"margin-top: 0px; margin-bottom: 0px; padding: 0px; font-size: 14px; line-height: 52px; text-indent: 2em; color: rgb(51, 51, 51); font-family: Arial, 宋体, &quot;Microsoft YaHei&quot;, simsun, sans-serif, Mingliu, Verdana, Helvetica, Lucida; white-space: normal;\"><span style=\"margin: 0px; padding: 0px; color: rgb(0, 0, 0); font-family: 宋体, sans-serif; line-height: 19px; background-color: rgb(255, 255, 255);\"><img src=\"/ueditor/php/upload/image/20161206/1481011620133936.png\" title=\"dd373.2.png\"/><br/></span></p><p style=\"margin-top: 10px; margin-bottom: 10px; padding: 0px; font-size: 14px; line-height: 1.75em; text-indent: 2em; color: rgb(51, 51, 51); font-family: Arial, 宋体, &quot;Microsoft YaHei&quot;, simsun, sans-serif, Mingliu, Verdana, Helvetica, Lucida; white-space: normal;\"><span style=\"margin: 0px; padding: 0px; color: rgb(0, 0, 0); line-height: 19px; font-family: 微软雅黑, &quot;Microsoft YaHei&quot;; background-color: rgb(255, 255, 255);\">3.提示下页：提现申请已提交成功。如图所示：</span></p><p style=\"margin-top: 0px; margin-bottom: 0px; padding: 0px; font-size: 14px; line-height: 52px; text-indent: 2em; color: rgb(51, 51, 51); font-family: Arial, 宋体, &quot;Microsoft YaHei&quot;, simsun, sans-serif, Mingliu, Verdana, Helvetica, Lucida; white-space: normal;\"><span style=\"margin: 0px; padding: 0px; color: rgb(0, 0, 0); font-family: 宋体, sans-serif; line-height: 19px; background-color: rgb(255, 255, 255);\"><img src=\"/ueditor/php/upload/image/20161206/1481011621249024.png\" title=\"dd373.3.png\"/><br/></span></p><p style=\"margin-top: 10px; margin-bottom: 10px; padding: 0px; font-size: 14px; line-height: 1.75em; text-indent: 2em; color: rgb(51, 51, 51); font-family: Arial, 宋体, &quot;Microsoft YaHei&quot;, simsun, sans-serif, Mingliu, Verdana, Helvetica, Lucida; white-space: normal;\"><span style=\"margin: 0px; padding: 0px; font-family: 微软雅黑, &quot;Microsoft YaHei&quot;; color: rgb(255, 0, 0);\">注：</span><span style=\"margin: 0px; padding: 0px; font-family: 微软雅黑, &quot;Microsoft YaHei&quot;;\">正常情况下工商为20分钟内到账，交通银行，建设银行，农业银行，邮政储蓄银行，中国银行，招商银行，兴业银行，广发银行，浦发银行，光大银行方面是2小时内到账。充值或退款资金需要在48小时后进行提现操作，此举是防止他人通过本平台恶意进行资金套现、洗钱等行为。如果由此给您带来不便，非常抱歉，敬请谅解！</span></p><p><br/></p>', '2016-12-06 16:07:42', '2016-12-06 16:07:47', '39', '1');
INSERT INTO `sf_article` VALUES ('29', '网站商品订单整改公告 ', '', '', '<p style=\"margin-top: 10px; margin-bottom: 10px; padding: 0px; line-height: 2em; font-size: 14px; font-family: &quot;Microsoft YaHei&quot;, 宋体, Arial, simsun, sans-serif, Mingliu, Verdana, Helvetica, Lucida; white-space: normal;\"><span style=\"margin: 0px; padding: 0px; font-family: 微软雅黑, &quot;Microsoft YaHei&quot;;\">尊敬的用户：</span></p><p style=\"margin-top: 10px; margin-bottom: 10px; padding: 0px; text-indent: 2em; line-height: 2em; font-size: 14px; font-family: &quot;Microsoft YaHei&quot;, 宋体, Arial, simsun, sans-serif, Mingliu, Verdana, Helvetica, Lucida; white-space: normal;\"><span style=\"margin: 0px; padding: 0px; font-family: 微软雅黑, &quot;Microsoft YaHei&quot;;\">为了规范游戏交易市场，提供一个高效、公平和安全的交易环境，同时给玩家提供更多更高质量的商品和服务，即日起对网站所有游戏的订单系统会进行自动检测和排查，凡是不符合价格区间和网站协议的一律进行下架处理，如多次出现违规操作影响网站正常运营秩序的行为，本站将有权对其进行相应的处理，最终解释权归网站所有。</span></p><p style=\"margin-top: 10px; margin-bottom: 10px; padding: 0px; text-indent: 2em; line-height: 2em; font-size: 14px; font-family: &quot;Microsoft YaHei&quot;, 宋体, Arial, simsun, sans-serif, Mingliu, Verdana, Helvetica, Lucida; white-space: normal;\"><span style=\"margin: 0px; padding: 0px; font-family: 微软雅黑, &quot;Microsoft YaHei&quot;;\">请各用户自觉遵守，相互监督，谢谢配合！</span></p><p style=\"margin-top: 10px; margin-bottom: 10px; padding: 0px; text-indent: 2em; line-height: 2em; font-size: 14px; font-family: &quot;Microsoft YaHei&quot;, 宋体, Arial, simsun, sans-serif, Mingliu, Verdana, Helvetica, Lucida; white-space: normal;\"><span style=\"margin: 0px; padding: 0px; font-family: 微软雅黑, &quot;Microsoft YaHei&quot;;\">&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;</span></p><p style=\"margin-top: 10px; margin-bottom: 10px; padding: 0px; text-indent: 2em; line-height: 2em; font-size: 14px; font-family: &quot;Microsoft YaHei&quot;, 宋体, Arial, simsun, sans-serif, Mingliu, Verdana, Helvetica, Lucida; white-space: normal;\"><span style=\"margin: 0px; padding: 0px; font-family: 微软雅黑, &quot;Microsoft YaHei&quot;;\">如您有疑问，请进入</span><a href=\"http://help.dd373.com/Member/ReleaseAsk\" target=\"_blank\" title=\"咨询中心\" style=\"margin: 0px; padding: 0px; text-decoration: none; cursor: pointer; color: rgb(51, 51, 51); outline: none;\"><span style=\"margin: 0px; padding: 0px; color: rgb(79, 129, 189); font-family: 微软雅黑, &quot;Microsoft YaHei&quot;; text-decoration: underline;\">咨询中心</span></a><span style=\"margin: 0px; padding: 0px; font-family: 微软雅黑, &quot;Microsoft YaHei&quot;;\">进行提问，我们客服会在10分钟为您答疑。</span></p><p style=\"margin-top: 10px; margin-bottom: 10px; padding: 0px; text-indent: 2em; line-height: 2em; font-size: 14px; font-family: &quot;Microsoft YaHei&quot;, 宋体, Arial, simsun, sans-serif, Mingliu, Verdana, Helvetica, Lucida; white-space: normal;\"><span style=\"margin: 0px; padding: 0px; font-family: 微软雅黑, &quot;Microsoft YaHei&quot;;\">&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;</span></p><p style=\"margin-top: 10px; margin-bottom: 10px; padding: 0px; text-indent: 2em; line-height: 2em; font-size: 14px; font-family: &quot;Microsoft YaHei&quot;, 宋体, Arial, simsun, sans-serif, Mingliu, Verdana, Helvetica, Lucida; white-space: normal;\"><span style=\"margin: 0px; padding: 0px; font-family: 微软雅黑, &quot;Microsoft YaHei&quot;;\">感谢您对的关注与支持，祝您生活愉快！</span></p><p><br/></p>', '2016-12-12 14:13:14', '2016-12-12 14:13:14', '25', '0');
INSERT INTO `sf_article` VALUES ('30', '用户注册协议', '', '', '<p>　　欢迎阅读服务条款协议，本协议阐述之条款和条件适用于您使用嘟嘟网络游戏服务网www.搜付在线.com网站（以下简称“网站”）的各种功能和享受的各项网站服务（以下简称“服务”）。本服务协议双方为本网站所有者新乡市嘟嘟网络技术有限公司（以下简称“本公司”）与本网站用户，本服务协议具有合同效力。本服务协议内容包括本协议正文及所有本网站已经发布的或将来可能发布的各类规则、声明等各项规范网站运营及明确本公司和用户权利义务、责任的文件资料。所有规则、声明等均为本服务协议不可分割的一部分，与本服务协议具有同等法律效力。在本网站中没有以“规则”、“声明”字样表示的链接文字所指示的文件就专门的事项与本服务协议有不同规定的，在不违反本服务协议基本原则的前提下优先适用其规定，且仅适用于该专门的事项。</p><p><br/></p><p>　　用户在使用本网站提供的各项服务的同时，承诺接受并遵守本服务协议及各项相关规则、声明的规定。本网站有权根据需要不时制定、修改本协议或各类规则、声明，如本协议有任何变更，将在网站上以刊载公告的方式通知予用户。如用户不同意相关变更，必须停止使用本网站各项功能和享受各项“服务”。经修订的协议一经在本网站上公布，立即自动生效，并追溯至本网站用户注册之时。各类规则、声明等会在发布后生效，亦成为本协议的一部分。登录或继续使用本网站各项功能或享受各项“服务”将表示用户接受经修订的协议。除另行明确声明外，任何使“服务”范围扩大或功能增强的新内容均受本协议约束。</p><p><br/></p><p>　　按照国家对未成年人保护的相关法律法规规定及国家对网络游戏进行管理的相关要求：搜付在线交易平台加入身份验证系统。将对注册时所填写的帐号身份证信息进行验证，同时要求注册用户在注册时提供有效身份证复印件。凡未填写身份信息（真实姓名、身份证号码）、身份证号码年龄在18岁以下以及身份证号码与姓名不符的用户帐号，将不支持使用搜付在线平台功能。对未满18周岁的未成年人注册用户，本网站一经发现，将立即终止服务并注销该用户账户。在用户点击“我同意”选项确认本服务协议后，本服务协议即在用户和本公司之间产生法律效力。请用户务必在注册之前认真阅读全部服务协议内容，如有任何疑问，可向本网站咨询。鉴于本网站无法掌控和确定用户是否已仔细阅读服务协议内容，且阅读与否责任并不在本网站和本公司，因此特别声明如下：</p><p><br/></p><p>　　(1)无论用户事实上是否在注册之前认真阅读了本服务协议，只要用户点击注册页面的“我同意”选项，并按照网站注册程序成功注册为用户，即视为用户已经全文阅读并接受本服务协议之全部内容，本服务协议即在本公司和用户之间签订，对双方具有约束力。</p><p><br/></p><p>　　(2)本协议仅系本公司与本网站用户间因使用本网站而产生的权利义务关系，不涉及本网站用户之间因网上交易而产生的法律关系及法律纠纷。</p><p><br/></p><p>　　第一部分定义</p><p><br/></p><p>　　1、本网站网上交易平台</p><p><br/></p><p>　　有关本网站网上交易平台上的术语或图标的含义，详见本网站帮助。</p><p><br/></p><p>　　2、用户及用户注册</p><p><br/></p><p>　　用户必须是具备完全民事行为能力的自然人，或者是具有合法经营资格的组织。无民事行为能力人、限制民事行为能力人以及无经营资格或无特定经营资格的组织违反规定以任何方式注册为本网站用户或超过其民事权利或行为能力范围从事交易，其注册行为及与本公司之间的服务协议均自始无效，本网站一经发现，有权立即注销该用户，并追究其使用本网站“服务”的一切法律责任。用户注册是指用户登陆本网站，按要求填写相关信息，提供有效身份证复印件，并确认同意履行相关用户协议的过程。用户因进行交易、获取有偿服务或接触本网站服务器而发生的所有应纳税赋，以及一切硬件、软件、服务及其他方面的费用均由用户自己承担并负责自行支付。本网站仅作为本公司为注册用户提供的进行虚拟物品交易的网络交易平台，并通过该平台向用户提供在线交易支持服务。</p><p><br/></p><p>　　第二部分权利义务</p><p><br/></p><p>　　一、用户权利和义务</p><p><br/></p><p>　　1、用户有权利拥有自己在本网站的通行证，包括但不限于用户名、登录密码及交易密码，并有权利使用自己的用户名及密码随时登陆本网站交易平台。用户不得以任何形式擅自转让或授权他人使用自己在本网站注册的用户名。</p><p><br/></p><p>　　2、用户有权根据本服务协议的规定以及本网站上发布的相关规则、声明利用网上交易平台查询物品信息、发布交易信息、登录物品、购买物品、与其他用户订立物品买卖合同、参加本网站的有关活动以及有权享受本网站提供的其他的相关信息服务。用户保证其具有相应的法律权利和行为能力进行上述活动，其在本网站交易平台进行或参与上述行为不会导致其违反任何适用的法律法规，及对用户具有约束力的合同、协议、法院及仲裁机构的有效裁判、规章、行政许可、政府命令、禁令及其他文件的规定，并保证对该等行为独立承担一切法律责任（包括但不限于出售非法或侵权物品的法律责任及任何对第三方的侵权及违约责任）。若本网站因任何可归咎于用户违反法律法规，或对用户具有约束力的合同、协议、法院及仲裁机构的有效裁判、规章、行政许可、政府命令、禁令及其他文件的行为承担任何连带责任，用户同意对本网站的损失予以全额赔偿。同时，鉴于搜付在线为用户提供服务过程中，有时需要使用游戏客户端软件，因此，用户须自行下载、安装游戏客户端软件于搜付在线服务器上，用户在此确认，用户在下载、安装游戏客户端软件前已经阅读、理解并完全接受运营商相关游戏之客户端协议，搜付在线不负责游戏客户端软件的下载、和安装。同时用户全权委托及授权搜付在线代表用户本人使用游戏客户端软件提供相关交易服务。用户同时保证，如因下载、安装或使用游戏客户端软件导致搜付在线被控侵权或被要求承担违约等其他法律责任，搜付在线将有权删除用户下载及安装到搜付在线服务器的游戏软件客户端，且对于因侵权或违约等行为所产生的全部责任由用户自身承担。</p><p><br/></p><p>　　3、用户在本网站进行网上交易过程中如与其他用户因交易产生纠纷，可以请求网站从中予以协调。用户如发现其他用户有违法或违反本服务协议的行为，可以向本网站进行反映要求处理。如用户因网上交易与其他用户产生诉讼的，用户有权通过司法部门要求本网站提供相关资料。</p><p><br/></p><p>　　4、用户有义务在注册时提供自己的真实资料（包括但不限于有效身份证复印件），并保证诸如电子邮件地址、联系电话等内容的真实性、有效性及安全性，保证本网站及其他用户可以通过上述联系方式与自己进行联系。同时，用户也有义务在相关资料实际变更时及时更新有关注册资料。用户保证不以他人资料在本网站进行注册或认证。用户保证当绑定注册信息（包括但不限于电子邮件、银行帐户）丢失或失效时，及时与本网站联系，并注销该帐户。</p><p><br/></p><p>　　5、用户应当保证在使用本网站网上交易平台进行交易过程中遵守诚实信用的原则，不发布虚假信息，不恶意抬高物价，不在交易过程中采取不正当竞争行为，不扰乱网上交易的正常秩序，不从事与网上交易无关的行为。</p><p><br/></p><p>　　6、用户在本网站网上交易平台上不得发布各类违法或违规信息。</p><p><br/></p><p>　　7、用户在本网站网上交易平台上不得买卖国家禁止销售的或限制销售的物品，不得买卖侵犯他人知识产权或其他合法权益的物品，也不得买卖违背社会公共利益或公共道德的或是本网站认为不适合在本网站上销售的物品。</p><p><br/></p><p>　　8、用户承诺自己在使用本网站时实施的所有行为遵守国家法律、法规和本网站的相关规定以及各种社会公共利益或公共道德。对于任何法律后果的发生，用户将以自己的名义独立承担所有相应的法律责任。</p><p><br/></p><p>　　9、不作商业性利用。用户同意，不对本网站及其任何资料作商业性利用，包括但不限于在未经本网站事先书面同意的情况下，以复制、传播等方式使用在本网站上展示的任何资料。</p><p><br/></p><p>　　10、用户同意接收来自本网站的信息。</p><p><br/></p><p>　　二、本网站权利和义务</p><p><br/></p><p>　　1、本网站有义务在现有技术上维护整个网上交易平台的正常运行，并努力提升和改进技术，使用户网上交易活动能够顺利进行。</p><p><br/></p><p>　　2、对用户在注册使用本网站网上交易平台中所遇到的与交易或注册有关的问题及反映的情况，本网站将会及时做出回复。</p><p><br/></p><p>　　3、对于在本网站网上交易平台上的不当行为或其它任何本网站认为应当终止服务的情况，本网站有权随时做出删除相关信息、终止服务提供等处理，而无须征得用户的同意。如用户违反本协议及搜付在线相关规则、声明等内容，搜付在线有权采取包括但不限于限制订单、锁定用户名、封锁个别IP、终止服务直至永久锁定用户账户等一项或多项处理措施。</p><p><br/></p><p>　　4、鉴于网上交易平台的特殊性，本网站没有义务对用户的注册资料、所有的交易行为以及与交易有关的其他事项进行事先审查，但如存在下列情况，本网站有权根据不同情况选择保留或删除相关信息以及选择继续或停止对该用户提供服务，并追究相关法律责任：</p><p><br/></p><p>　　（1）用户或其他第三方通知本网站，认为某个具体用户或具体交易事项可能存在重大问题；</p><p><br/></p><p>　　（2）用户或其他第三方向本网站告知交易平台上有违法或不当行为的，本网站以普通非专业交易者的知识水平标准对相关内容进行判别，可以明显认为这些内容或行为具有违法或不当性质的；</p><p><br/></p><p>　　5、用户在本网站网上交易过程中如与其他用户因交易产生纠纷，请求本网站从中予以调处，经本网站审核后，本网站有权通过电子邮件等联系方式向纠纷双方了解情况，并将所了解的情况通过电子邮件等联系方式互相通知对方。</p><p><br/></p><p>　　6、用户因在本网站从事网上交易与其他用户产生诉讼的，用户通过司法部门或行政部门依照法定程序要求本网站提供相关资料，本网站应积极配合并提供有关资料。</p><p><br/></p><p>　　7.、本网站有权对用户的注册资料及交易行为进行查阅，发现注册资料或交易行为中存在任何问题或怀疑，均有权向用户发出询问及要求改正的通知或者直接做出删除等处理。</p><p><br/></p><p>　　8、经国家生效法律文书或行政处罚决定确认用户存在违法行为，或者本网站有足够事实依据可以认定用户存在违法或违反服务协议行为的，本网站有权选择下列一种或多种处理措施进行处理：</p><p><br/></p><p>　　（1）中止或终止用户网上交易权限；</p><p><br/></p><p>　　（2）注销或删除用户帐户；</p><p><br/></p><p>　　（3）在本网站交易平台及所在网站上以网络发布形式公布用户的违法行为。</p><p><br/></p><p>　　9、对于用户在本网站交易平台发布的下列各类信息，本网站有权在不通知用户的前提下进行删除或采取其他限制性措施，该类信息包括但不限于：</p><p><br/></p><p>　　（1）以规避费用为目的；</p><p><br/></p><p>　　（2）以恶意抬高物价为目的；</p><p><br/></p><p>　　（3）本网站有理由相信存在欺诈等恶意或虚假内容；</p><p><br/></p><p>　　（4）本网站有理由相信与网上交易无关或不是以交易为目的；</p><p><br/></p><p>　　（5）本网站有理由相信存在恶意竞价或其他试图扰乱正常交易秩序因素；</p><p><br/></p><p>　　（6）本网站有理由相信该信息违反公共利益或可能严重损害本网站和其他用户合法利益的；</p><p><br/></p><p>　　（7）其他可能损害本网站、本网站其他用户或公共利益信息。</p><p><br/></p><p>　　10、许可使用权。用户以此授予本网站独家的、全球通用的、永久的、免费的许可使用权利（以及对该许可使用权进行再授权的权利），使本网站有权（全部或部份地）使用、复制、修订、改写、发布、翻译、分发、执行和展示用户公示于网站的各类信息或制作其派生作品，和/或以现在已知或日后开发的任何形式、媒体或技术，将上述信息纳入其他作品内。</p><p><br/></p><p>　　11、关于Cookies的限制，本网站会在用户的电脑上设定或取用cookies。本网站允许那些在本网站网页上发布广告的公司到用户电脑上设定或取用cookies。在用户登录时获取资料，本网站使用cookies可为您用户提供个性化服务。如果拒绝所有cookies，用户将不能使用需要登录的本网站产品及服务内容。</p><p><br/></p><p>　　12、您将对使用该账户及密码进行的一切操作及言论负完全的责任，您同意：</p><p><br/></p><p>　　（1）本网站通过您的用户名和密码识别您的指示，请您妥善保管您的用户名和密码，对于因密码泄露所致的损失，由您自行承担。</p><p><br/></p><p>　　（2）如您发现有他人冒用或盗用您的账户及密码或任何其他未经合法授权之情形时，应立即以有效方式通知本公司，要求本公司暂停相关服务。同时，您理解本公司对您的请求采取行动需要合理期限，在此之前，本公司对已执行的指令及(或)所导致的您的损失不承担任何责任。</p><p><br/></p><p>　　（3）您同意，基于运行和交易安全的需要，本公司可以暂时停止提供或者限制本服务部分功能,或提供新的功能，在任何功能减少、增加或者变化时，只要您仍然使用本服务，表示您仍然同意本协议或者变更后的协议。</p><p><br/></p><p>　　（4）用户在交易过程中可能产生用户名被盗或被骗的情况，由此您同意，为维护您的权益，本网站可以视情况采取重置用户密码及限制资金支付的操作。</p><p><br/></p><p>　　13、卖家将出售的商品及账号托管到网站上，搜付在线对卖家的账号及出售物品有保密、保管的权益，如果托管物品及账号出现任何异常问题，将委托搜付在线进行处理一切后续事宜。</p><p><br/></p><p>　　第三部分服务的中断和终止</p><p><br/></p><p>　　1、用户同意，本网站可自行全权决定以任何理由（包括但不限于本网站认为您已违反本协议的字面意义和精神，或以不符合本协议的字面意义和精神的方式行事，或您在超过90天的时间内未以您的帐户及密码登录网站等）随时终止用户的“服务”密码、帐户（或其任何部份）或您对“服务”的使用，并删除（不再保存）用户在使用“服务”中提交的“用户资料”，但已经收取手续费或服务费的，前述“终止”和/或“删除”行为应在交易完成后执行。同时本网站可自行全权决定，在发出通知或不发出通知的情况下，随时停止提供“服务”或其任何部份。帐户终止后，本网站没有义务为您保留原帐户中或与之相关的任何信息，或转发任何未曾阅读或发送的信息给您或第三方。此外，您同意，本网站不就终止您接入“服务”而对您或任何第三者承担任何责任。</p><p><br/></p><p>　　2、如用户向本网站提出注销注册用户身份时，经本网站审核同意，由本网站注销该注册用户，用户即解除与本网站的服务协议关系。但注销该用户帐户后，本网站仍保留下列权利：</p><p><br/></p><p>　　（1）用户注销后，本网站有权保留该用户的注册资料及以前的交易行为记录；</p><p><br/></p><p>　　（2）用户注销后，如用户在注销前在本网站交易平台上存在违法行为或违反合同的行为，本网站仍可行使本服务协议所规定的权利。</p><p><br/></p><p>　　3、在下列情况下，本网站可不经通知用户并以注销用户的方式终止服务：</p><p><br/></p><p>　　（1）在用户违反本服务协议相关规定时，本网站有权终止向该用户提供服务；</p><p><br/></p><p>　　（2）如该用户在被本网站终止提供服务后，再一次直接或间接或以他人名义注册为本网站用户的，本网站有权再次单方面终止向该用户提供服务；</p><p><br/></p><p>　　（3）如本网站通过用户提供的信息与用户联系时，发现用户在注册时填写的电子邮箱已不存在或无法接收电子邮件的，经本网站以其他联系方式通知用户更改，而用户在三个工作日内仍未能提供新的电子邮箱地址的，本网站有权终止向该用户提供服务；</p><p><br/></p><p>　　（4）一旦本网站发现用户注册资料中主要内容是虚假的，本网站有权随时终止向该用户提供服务；</p><p><br/></p><p>　　（5）本服务协议终止或更新时，用户未确认新的服务协议的；</p><p><br/></p><p>　　（6）其它本网站认为需终止服务的情况。</p><p><br/></p><p>　　4、服务中断、终止之前用户交易行为的处理。因用户违反法律法规或者违反服务协议规定而致使本网站中断、终止对用户服务的，对于服务中断、终止之前用户交易行为依下列原则处理：</p><p><br/></p><p>　　（1）服务中断、终止之前，用户已经上传至本网站的物品尚未交易或尚未交易完成的，本网站有权在中断、终止服务的同时删除此项物品的相关信息。</p><p><br/></p><p>　　（2）服务中断、终止之前，用户已经就其他用户出售的具体物品作出要约，但交易尚未结束，本网站有权在中断或终止服务的同时删除该用户的相关要约。</p><p><br/></p><p>　　（3）服务中断、终止之前，用户已经与另一用户就具体交易达成一致，本网站可以不删除该项交易，但本网站有权在中断、终止服务的同时将用户被中断或终止服务的情况通知用户的交易对方。</p><p><br/></p><p>　　5、因网站升级或维护或其他技术需要导致本网站需要中断服务的，本网站将在中断服务时通知用户。但任何原因导致本网站终止或中断服务，本公司及本网站均不承担任何责任，用户因此遭受的各项损失，由用户本人自行承担。</p><p><br/></p><p>　　第四部分责任范围</p><p><br/></p><p>　　本公司、本公司的关联公司和相关实体在任何情况下均不就因本公司的网站、本公司的服务或本协议而产生的或与之有关的利润损失或任何特别、间接或后果性的损害（无论以何种方式产生，包括疏忽）承担任何责任。用户同意就用户自身行为之合法性单独承担责任。用户同意，本公司和本公司的所有关联公司和相关实体对本公司用户的行为的合法性及产生的任何结果不承担责任。用户明确理解和同意，本公司及本网站不对因下述任一情形而发生的任何损害赔偿（包括但不限于利润、商誉、使用、数据等方面的损失或其他无形损失的损害赔偿，且无论本公司和/或本网站是否已被告知该等损害赔偿的可能性）承担任何责任：</p><p><br/></p><p>　　（1）使用或未能使用“服务”。</p><p><br/></p><p>　　（2）用户因通过“服务”购买或获取任何货物、样品、数据、资料或服务，或通过或从“服务”接收任何信息或缔结任何交易所产生的获取替代货物和服务的费用。</p><p><br/></p><p>　　（3）第三方未经批准的接入或第三方更改您的传输资料或数据，第三方对“服务”的声明或关于“服务”的行为；</p><p><br/></p><p>　　（4）因任何原因而引起的与“服务”有关的任何其他事宜，包括但不限于疏忽。</p><p><br/></p><p>　　第五部分免责条款</p><p><br/></p><p>　　鉴于本公司不参与本网站用户之间的实际交易，用户如与一名或多名其他用户发生争议，用户应就上述争议产生的或在任何方面与上述争议有关的每一种类和性质的已知或未知、可疑或非可疑、披露或未披露的索赔、要求和损害免除本公司（和本公司的高级职员、董事、代理人、关联公司、母公司、子公司和雇员）的责任，具体免责事项包括但不限于如下情形之规定：</p><p><br/></p><p>　　1、关于以下事由造成的各项损失，本公司免责：</p><p><br/></p><p>　　（1）战争、事变、天灾地变等，不可抗力等情况；</p><p><br/></p><p>　　（2）使用者故意或过失所造成损害；</p><p><br/></p><p>　　（3）因通信服务提供业者方面造成之通信障碍；</p><p><br/></p><p>　　（4）游戏开发业者、游戏服务业者提供不良服务者或游戏开发运营者与游戏用户纠纷；</p><p><br/></p><p>　　（5）用户身份之真实性、民事权利能力民事行为能力之适当性、用户信用程度之可靠性；</p><p><br/></p><p>　　（6）交易物品来源合法性、权利归属、真伪性、数量质量性能等各种事项之真实准确完整性；</p><p><br/></p><p>　　（7）其他非本网站所能控制或掌握之事项。</p><p><br/></p><p>　　2、本公司所有连结网站皆为独立营运网站，与各用户之间的互动与交易行为本公司免责。</p><p><br/></p><p>　　3、本网站免责声明规定之事项，本公司免责。</p><p><br/></p><p>　　第六部分知识产权保护</p><p><br/></p><p>　　本网站所使用之作品（包括但不限于软件、图片或程序）及网站上所有内容（包括但不限于著作、图片、档案、信息、数据、网站画面的安排、网页设计）均由本公司或其它权利人依法拥有其各项知识产权（包括但不限于商标权、专利权、著作权、商业秘密与专有技术等）。任何人未经本公司及权利人授权，不得擅自使用、修改、重制或者公开播送、改作、散布、发行、公开发表，或者进行还原工程解编或反向组绎。如有违反，除依著作权法及相关法律规定论处，并应对本公司负损害赔偿责任（包括但不限于诉讼费用及律师费用等）。</p><p><br/></p><p>　　第七部分通知</p><p><br/></p><p>　　除非另行明示载明，任何通知将发往用户在注册过程中向本公司提供的电邮地址。或者，本公司可通过已预付邮资和要求回执的保证航空信，将通知发往用户在注册过程中向本公司提供或您做出相关更新的地址。任何通知应视为于以下时间发出：</p><p><br/></p><p>　　（a）如通过电邮发送，则电邮发送后24个小时，但发送方被告知电邮地址无效的，则属例外；</p><p><br/></p><p>　　（b）如以预付邮资的信件发送，则投邮之日后三个营业日；如寄往或寄自中国，则在投邮后第七个营业日；</p><p><br/></p><p>　　（c）如通过传真发送，则传真发出的该个营业日（只要发送人收到载明以上传真号码、发送页数和发送日期的确认报告）。就本款而言，“营业日”指中国境内除星期六、星期日或公众假期以外的日期。</p><p><br/></p><p>　　第八部分不保证</p><p><br/></p><p>　　本公司和本网站合作伙伴以“按现状”的方式提供本公司网站和服务，而不带有任何保证或条件，无论是明示、默示或法定的。本公司对本网站的合作伙伴向用户提供的服务不提供任何形式的承诺或保证。在法律准许的范围内，本公司和本网站合作伙伴特别否定任何有关所有权、适销性、特定目的之适用性和不侵权的默示保证。此外，本公司不就持续地、不受影响地或安全地接受本公司服务做出任何担保，且本公司网站的经营可能受本公司无法控制的多种外部因素影响。</p><p><br/></p><p>　　第九部分协议完整性、可分割性、可转让性及权利保留</p><p><br/></p><p>　　本协议取代用户和本公司先前就相同事项订立的任何书面或口头协议，本协议与本网站之任何现在或将来的规则、声明构成完整的统一体。倘若本协议任何规定被裁定为无效或不可强制执行，该项规定应被撤销，而其他规定应予执行。条款标题仅为方便参阅而设，并不以任何方式界定、限制、解释或描述该条款的范围或限度。本协议和所有纳入协议的条款和规则可由本公司自行酌情决定向第三方自动转让。本公司及本网站未就用户或其他人士的某项违约行为采取行动，并不表明本公司及本网站撤回就任何继后或类似的违约事件采取行动的权利。</p><p><br/></p><p>　　第十部分争议解决及法律适用</p><p><br/></p><p>　　因本协议或本网站服务所引起或与之有关的任何争议应向本公司所在地金华市婺城区有管辖权的人民法院提起诉讼，本协议各方面均受中华人民共和国大陆地区法律的管辖。</p><p><br/></p><p>　　境外用户提示：由于外汇管理以及知识产权保护方面的法律限制，我们暂时不能为中国（为本协议目的，中国不包括香港、澳门、台湾）以外国家和地区的用户以及在中国以外国家和地区登陆搜付在线交易平台的用户提供服务。我们将积极寻求为境外用户提供服务的方案，在此之前请您不要使用搜付在线交易平台的服务，对因您使用搜付在线交易平台服务或在搜付在线交易平台上进行的任何操作而使本公司或本公司关联方遭受任何处罚或损失，您应当承担赔偿责任。</p><p><br/></p>', '2016-12-13 14:29:47', '2016-12-13 14:29:47', '25', '0');
INSERT INTO `sf_article` VALUES ('31', '如何购买', '', '', '<p style=\"margin-top: 10px; margin-bottom: 10px; padding: 0px; font-size: 14px; line-height: 1.75em; text-indent: 2em; color: rgb(51, 51, 51); font-family: Arial, 宋体, &quot;Microsoft YaHei&quot;, simsun, sans-serif, Mingliu, Verdana, Helvetica, Lucida; white-space: normal;\"><span style=\"margin: 0px; padding: 0px; line-height: 19px; font-family: 微软雅黑, &quot;Microsoft YaHei&quot;; background-color: rgb(255, 255, 255);\">1、dd373个人账户登录，可以选择买家中心“我要买”链接，如图所示：</span></p><p style=\"margin-top: 0px; margin-bottom: 0px; padding: 0px; font-size: 14px; line-height: 52px; text-indent: 2em; color: rgb(51, 51, 51); font-family: Arial, 宋体, &quot;Microsoft YaHei&quot;, simsun, sans-serif, Mingliu, Verdana, Helvetica, Lucida; white-space: normal;\"><span style=\"margin: 0px; padding: 0px; font-family: 宋体, sans-serif; line-height: 19px; background-color: rgb(255, 255, 255);\"><img src=\"/ueditor/php/upload/image/20161213/1481616001927894.png\" title=\"dd373.png\"/><br/></span></p><p style=\"margin-top: 10px; margin-bottom: 10px; padding: 0px; font-size: 14px; line-height: 1.75em; text-indent: 2em; color: rgb(51, 51, 51); font-family: Arial, 宋体, &quot;Microsoft YaHei&quot;, simsun, sans-serif, Mingliu, Verdana, Helvetica, Lucida; white-space: normal;\"><span style=\"margin: 0px; padding: 0px; line-height: 19px; font-family: 微软雅黑, &quot;Microsoft YaHei&quot;; background-color: rgb(255, 255, 255);\">2、在打开的新页面中，进行游戏种类的选择。如图所示：</span></p><p style=\"margin-top: 0px; margin-bottom: 0px; padding: 0px; font-size: 14px; line-height: 52px; text-indent: 2em; color: rgb(51, 51, 51); font-family: Arial, 宋体, &quot;Microsoft YaHei&quot;, simsun, sans-serif, Mingliu, Verdana, Helvetica, Lucida; white-space: normal;\"><span style=\"margin: 0px; padding: 0px; font-family: 宋体, sans-serif; line-height: 19px; background-color: rgb(255, 255, 255);\"><span style=\"margin: 0px; padding: 0px; line-height: 19.2px;\"><img src=\"/ueditor/php/upload/image/20161213/1481616001360132.png\" title=\"dd373.1.png\"/><br/></span></span></p><p style=\"margin-top: 10px; margin-bottom: 10px; padding: 0px; font-size: 14px; line-height: 1.75em; text-indent: 2em; color: rgb(51, 51, 51); font-family: Arial, 宋体, &quot;Microsoft YaHei&quot;, simsun, sans-serif, Mingliu, Verdana, Helvetica, Lucida; white-space: normal;\"><span style=\"margin: 0px; padding: 0px; line-height: 19px; font-family: 微软雅黑, &quot;Microsoft YaHei&quot;; background-color: rgb(255, 255, 255);\">3、新页面中列出了您所选游戏的商品，在列表中选择你所想购买的物品。如图所示：</span><span style=\"margin: 0px; padding: 0px; font-family: 宋体, sans-serif; line-height: 19px; background-color: rgb(255, 255, 255);\"><br/></span></p><p style=\"margin-top: 0px; margin-bottom: 0px; padding: 0px; font-size: 14px; line-height: 52px; text-indent: 2em; color: rgb(51, 51, 51); font-family: Arial, 宋体, &quot;Microsoft YaHei&quot;, simsun, sans-serif, Mingliu, Verdana, Helvetica, Lucida; white-space: normal;\"><img src=\"/ueditor/php/upload/image/20161213/1481616002133394.png\" title=\"dd373.2.png\"/><br/></p><p style=\"margin-top: 10px; margin-bottom: 10px; padding: 0px; font-size: 14px; line-height: 1.75em; text-indent: 2em; color: rgb(51, 51, 51); font-family: Arial, 宋体, &quot;Microsoft YaHei&quot;, simsun, sans-serif, Mingliu, Verdana, Helvetica, Lucida; white-space: normal;\"><span style=\"margin: 0px; padding: 0px; line-height: 19px; font-family: 微软雅黑, &quot;Microsoft YaHei&quot;; background-color: rgb(255, 255, 255);\">4、在详细物品介绍页面中查看物品的详细信息，确认无误后，点击“立即购买”按钮，如图所示：</span></p><p style=\"margin-top: 0px; margin-bottom: 0px; padding: 0px; font-size: 14px; line-height: 52px; text-indent: 2em; color: rgb(51, 51, 51); font-family: Arial, 宋体, &quot;Microsoft YaHei&quot;, simsun, sans-serif, Mingliu, Verdana, Helvetica, Lucida; white-space: normal;\"><span style=\"margin: 0px; padding: 0px; font-family: 宋体, sans-serif; line-height: 19px; background-color: rgb(255, 255, 255);\"><span style=\"margin: 0px; padding: 0px; line-height: 19.2px;\"><span style=\"margin: 0px; padding: 0px; line-height: 19px;\"><span style=\"margin: 0px; padding: 0px; line-height: 19px;\"><img src=\"/ueditor/php/upload/image/20161213/1481616002252553.png\" title=\"dd373.4.png\"/><br/></span></span></span></span></p><p style=\"margin-top: 10px; margin-bottom: 10px; padding: 0px; font-size: 14px; line-height: 1.75em; text-indent: 2em; color: rgb(51, 51, 51); font-family: Arial, 宋体, &quot;Microsoft YaHei&quot;, simsun, sans-serif, Mingliu, Verdana, Helvetica, Lucida; white-space: normal;\"><span style=\"margin: 0px; padding: 0px; line-height: 19px; font-family: 微软雅黑, &quot;Microsoft YaHei&quot;; background-color: rgb(255, 255, 255);\">5、选择接手交易客服，填写个人收货资料信息，并点击“下一步”按钮。</span><span style=\"margin: 0px; padding: 0px; font-family: 宋体, sans-serif; line-height: 19px; background-color: rgb(255, 255, 255);\"><br/></span></p><p style=\"margin-top: 0px; margin-bottom: 0px; padding: 0px; font-size: 14px; line-height: 52px; text-indent: 2em; color: rgb(51, 51, 51); font-family: Arial, 宋体, &quot;Microsoft YaHei&quot;, simsun, sans-serif, Mingliu, Verdana, Helvetica, Lucida; white-space: normal;\"><img src=\"/ueditor/php/upload/image/20161213/1481616003172944.png\" title=\"dd373.5.png\"/><br/></p><p style=\"margin-top: 0px; margin-bottom: 0px; padding: 0px; font-size: 14px; line-height: 52px; text-indent: 2em; color: rgb(51, 51, 51); font-family: Arial, 宋体, &quot;Microsoft YaHei&quot;, simsun, sans-serif, Mingliu, Verdana, Helvetica, Lucida; white-space: normal;\"><span style=\"margin: 0px; padding: 0px; font-family: 宋体, sans-serif; line-height: 19px; background-color: rgb(255, 255, 255);\"><span style=\"margin: 0px; padding: 0px; line-height: 19.2px;\"><span style=\"margin: 0px; padding: 0px; line-height: 19px;\"><span style=\"margin: 0px; padding: 0px; line-height: 19px;\"><span style=\"margin: 0px; padding: 0px; line-height: 19px;\"><br/></span></span></span></span></span></p><p style=\"margin-top: 10px; margin-bottom: 10px; padding: 0px; font-size: 14px; line-height: 1.75em; text-indent: 2em; color: rgb(51, 51, 51); font-family: Arial, 宋体, &quot;Microsoft YaHei&quot;, simsun, sans-serif, Mingliu, Verdana, Helvetica, Lucida; white-space: normal;\"><span style=\"margin: 0px; padding: 0px; line-height: 19px; font-family: 微软雅黑, &quot;Microsoft YaHei&quot;; background-color: rgb(255, 255, 255);\">6.选择付款方式：dd373账户和其他方式付款，点击“确认付款”按钮。</span></p><p style=\"margin-top: 0px; margin-bottom: 0px; padding: 0px; font-size: 14px; line-height: 52px; text-indent: 2em; color: rgb(51, 51, 51); font-family: Arial, 宋体, &quot;Microsoft YaHei&quot;, simsun, sans-serif, Mingliu, Verdana, Helvetica, Lucida; white-space: normal;\"><img src=\"/ueditor/php/upload/image/20161213/1481616003582865.png\" title=\"dd373.6.png\"/><br/></p><p style=\"margin-top: 10px; margin-bottom: 10px; padding: 0px; font-size: 14px; line-height: 1.75em; text-indent: 2em; color: rgb(51, 51, 51); font-family: Arial, 宋体, &quot;Microsoft YaHei&quot;, simsun, sans-serif, Mingliu, Verdana, Helvetica, Lucida; white-space: normal;\"><span style=\"margin: 0px; padding: 0px; line-height: 19px; font-family: 微软雅黑, &quot;Microsoft YaHei&quot;; background-color: rgb(255, 255, 255);\">7、所购买物品发送页面。</span><br/></p><p style=\"margin-top: 0px; margin-bottom: 0px; padding: 0px; font-size: 14px; line-height: 52px; text-indent: 2em; color: rgb(51, 51, 51); font-family: Arial, 宋体, &quot;Microsoft YaHei&quot;, simsun, sans-serif, Mingliu, Verdana, Helvetica, Lucida; white-space: normal;\"><img src=\"/ueditor/php/upload/image/20161213/1481616003127851.png\" title=\"dd373.8.png\"/></p><p><br/></p>', '2016-12-13 16:00:07', '2016-12-13 16:00:09', '32', '1');
INSERT INTO `sf_article` VALUES ('32', '如何求购', '', '', '<p style=\"margin-top: 10px; margin-bottom: 10px; padding: 0px; font-size: 14px; line-height: 1.75em; text-indent: 2em; color: rgb(51, 51, 51); font-family: Arial, 宋体, &quot;Microsoft YaHei&quot;, simsun, sans-serif, Mingliu, Verdana, Helvetica, Lucida; white-space: normal;\"><span style=\"margin: 0px; padding: 0px; line-height: 19px; font-family: 微软雅黑, &quot;Microsoft YaHei&quot;; background-color: rgb(255, 255, 255);\">1、dd373个人账户登录并选择“我要求购”如图所示：</span><br/></p><p style=\"margin-top: 0px; margin-bottom: 0px; padding: 0px; font-size: 14px; line-height: 52px; text-indent: 2em; color: rgb(51, 51, 51); font-family: Arial, 宋体, &quot;Microsoft YaHei&quot;, simsun, sans-serif, Mingliu, Verdana, Helvetica, Lucida; white-space: normal;\"><img src=\"http://cdnimg.dd373.com/Upload/SitePic/2015-10-13/20151013195057332165845.png\" title=\"G3E`WS5HZSX7VWY{WKS1XTT.png\"/><br/></p><p style=\"margin-top: 10px; margin-bottom: 10px; padding: 0px; font-size: 14px; line-height: 1.75em; text-indent: 2em; color: rgb(51, 51, 51); font-family: Arial, 宋体, &quot;Microsoft YaHei&quot;, simsun, sans-serif, Mingliu, Verdana, Helvetica, Lucida; white-space: normal;\"><span style=\"margin: 0px; padding: 0px; line-height: 19px; font-family: 微软雅黑, &quot;Microsoft YaHei&quot;; background-color: rgb(255, 255, 255);\">2、在打开的新页面中，点击“去发布求购信息”按钮，如图所示：</span><br/></p><p style=\"margin-top: 0px; margin-bottom: 0px; padding: 0px; font-size: 14px; line-height: 52px; text-indent: 2em; color: rgb(51, 51, 51); font-family: Arial, 宋体, &quot;Microsoft YaHei&quot;, simsun, sans-serif, Mingliu, Verdana, Helvetica, Lucida; white-space: normal;\"><span style=\"margin: 0px; padding: 0px; font-family: 宋体, sans-serif; line-height: 19px; background-color: rgb(255, 255, 255);\"><img src=\"http://cdnimg.dd373.com/Upload/SitePic/2015-10-13/20151013195257959159735.png\" title=\"YPHU1G(76D]X3VJ2G[MMI1B.png\"/></span></p><p style=\"margin-top: 10px; margin-bottom: 10px; padding: 0px; font-size: 14px; line-height: 1.75em; text-indent: 2em; color: rgb(51, 51, 51); font-family: Arial, 宋体, &quot;Microsoft YaHei&quot;, simsun, sans-serif, Mingliu, Verdana, Helvetica, Lucida; white-space: normal;\"><span style=\"margin: 0px; padding: 0px; line-height: 19px; font-family: 微软雅黑, &quot;Microsoft YaHei&quot;; background-color: rgb(255, 255, 255);\">3、在打开的新页面中，进行游戏种类的选择并点击“继续求购”按钮。如图所示：</span></p><p style=\"margin-top: 0px; margin-bottom: 0px; padding: 0px; font-size: 14px; line-height: 52px; text-indent: 2em; color: rgb(51, 51, 51); font-family: Arial, 宋体, &quot;Microsoft YaHei&quot;, simsun, sans-serif, Mingliu, Verdana, Helvetica, Lucida; white-space: normal;\"><img src=\"http://cdnimg.dd373.com/Upload/SitePic/2015-10-13/20151013195626337054773.png\" title=\"$JENYAYC)2CLO)]BB5)OQ(Q.png\"/><br/></p><p style=\"margin-top: 10px; margin-bottom: 10px; padding: 0px; font-size: 14px; line-height: 1.75em; text-indent: 2em; color: rgb(51, 51, 51); font-family: Arial, 宋体, &quot;Microsoft YaHei&quot;, simsun, sans-serif, Mingliu, Verdana, Helvetica, Lucida; white-space: normal;\"><span style=\"margin: 0px; padding: 0px; line-height: 19px; font-family: 微软雅黑, &quot;Microsoft YaHei&quot;; background-color: rgb(255, 255, 255);\">4、新页面中填写你想要求购物品的详细信息，点击“确认，提交发布”按钮。如图所示：</span><br/></p><p style=\"margin-top: 0px; margin-bottom: 0px; padding: 0px; font-size: 14px; line-height: 52px; text-indent: 2em; color: rgb(51, 51, 51); font-family: Arial, 宋体, &quot;Microsoft YaHei&quot;, simsun, sans-serif, Mingliu, Verdana, Helvetica, Lucida; white-space: normal;\"><span style=\"margin: 0px; padding: 0px; font-family: 宋体, sans-serif; line-height: 19px; background-color: rgb(255, 255, 255);\"><img src=\"http://cdnimg.dd373.com/Upload/SitePic/2015-10-13/20151013195926483557968.png\" title=\"$0Z17G{SAA]IN72EKU}NO}1.png\"/><br/></span></p><p style=\"margin-top: 0px; margin-bottom: 0px; padding: 0px; font-size: 14px; line-height: 52px; text-indent: 2em; color: rgb(51, 51, 51); font-family: Arial, 宋体, &quot;Microsoft YaHei&quot;, simsun, sans-serif, Mingliu, Verdana, Helvetica, Lucida; white-space: normal;\"><span style=\"margin: 0px; padding: 0px; font-family: 宋体, sans-serif; line-height: 19px; background-color: rgb(255, 255, 255);\"><img src=\"http://cdnimg.dd373.com/Upload/SitePic/2015-10-13/20151013200107243238675.png\" title=\"PT48M9}R9`)5LCG}XRC9OAG.png\"/><br/></span></p><p style=\"margin-top: 10px; margin-bottom: 10px; padding: 0px; font-size: 14px; line-height: 1.75em; text-indent: 2em; color: rgb(51, 51, 51); font-family: Arial, 宋体, &quot;Microsoft YaHei&quot;, simsun, sans-serif, Mingliu, Verdana, Helvetica, Lucida; white-space: normal;\"><span style=\"margin: 0px; padding: 0px; line-height: 19px; font-family: 微软雅黑, &quot;Microsoft YaHei&quot;; background-color: rgb(255, 255, 255);\">5、出现物品的详细页面，表明你发布的求购信息发布成功。如图所示：</span><span style=\"margin: 0px; padding: 0px; font-family: 宋体, sans-serif; line-height: 19px; background-color: rgb(255, 255, 255);\"><br/></span></p><p style=\"margin-top: 0px; margin-bottom: 0px; padding: 0px; font-size: 14px; line-height: 52px; text-indent: 2em; color: rgb(51, 51, 51); font-family: Arial, 宋体, &quot;Microsoft YaHei&quot;, simsun, sans-serif, Mingliu, Verdana, Helvetica, Lucida; white-space: normal;\"><span style=\"margin: 0px; padding: 0px; font-family: 宋体, sans-serif; line-height: 19px; background-color: rgb(255, 255, 255);\"><span style=\"margin: 0px; padding: 0px; line-height: 19px;\"><img src=\"http://cdnimg.dd373.com/Upload/SitePic/2015-10-13/20151013200431997282626.png\" title=\"WRSDZ37JHU}0IQRGFH[)%XM.png\"/><br/></span></span></p><p style=\"margin-top: 0px; margin-bottom: 0px; padding: 0px; font-size: 14px; line-height: 52px; text-indent: 2em; color: rgb(51, 51, 51); font-family: Arial, 宋体, &quot;Microsoft YaHei&quot;, simsun, sans-serif, Mingliu, Verdana, Helvetica, Lucida; white-space: normal;\"><span style=\"margin: 0px; padding: 0px; font-family: 宋体, sans-serif; line-height: 19px; background-color: rgb(255, 255, 255);\"><span style=\"margin: 0px; padding: 0px; line-height: 19px;\"><img src=\"http://cdnimg.dd373.com/Upload/SitePic/2015-10-13/20151013200625406339472.png\" title=\"%}Q`56[PZVY}][5RPL7UR5X.png\"/></span></span></p><p><br/></p>', '2016-12-13 16:01:15', '2016-12-13 16:01:17', '33', '1');

-- ----------------------------
-- Table structure for `sf_art_category`
-- ----------------------------
DROP TABLE IF EXISTS `sf_art_category`;
CREATE TABLE `sf_art_category` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `cat_name` varchar(50) NOT NULL DEFAULT '' COMMENT '分类名称',
  `cat_desc` varchar(255) NOT NULL DEFAULT '' COMMENT '分类描述',
  `cat_order` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `p_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '父级id，0为顶级',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=67 DEFAULT CHARSET=utf8 COMMENT='文章分类';

-- ----------------------------
-- Records of sf_art_category
-- ----------------------------
INSERT INTO `sf_art_category` VALUES ('39', '如何提现', '', '0', '38');
INSERT INTO `sf_art_category` VALUES ('38', '提现帮助', '', '0', '28');
INSERT INTO `sf_art_category` VALUES ('35', '出售寄售', '', '0', '34');
INSERT INTO `sf_art_category` VALUES ('36', '出售担保', '', '0', '34');
INSERT INTO `sf_art_category` VALUES ('37', '出售求购', '', '0', '34');
INSERT INTO `sf_art_category` VALUES ('34', '出售帮助', '', '0', '28');
INSERT INTO `sf_art_category` VALUES ('30', '搜索商品', '', '0', '29');
INSERT INTO `sf_art_category` VALUES ('31', '购买帮助', '', '0', '28');
INSERT INTO `sf_art_category` VALUES ('32', '如何购买', '', '0', '31');
INSERT INTO `sf_art_category` VALUES ('33', '如何求购', '', '0', '31');
INSERT INTO `sf_art_category` VALUES ('28', '帮助中心', '', '0', '0');
INSERT INTO `sf_art_category` VALUES ('29', '物品查询帮助', '', '0', '28');
INSERT INTO `sf_art_category` VALUES ('24', '网站公告信息', '网站公告信息', '0', '0');
INSERT INTO `sf_art_category` VALUES ('25', '本站公告', '', '0', '24');
INSERT INTO `sf_art_category` VALUES ('26', '系统公告', '', '1', '24');
INSERT INTO `sf_art_category` VALUES ('27', '精彩活动', '', '2', '24');
INSERT INTO `sf_art_category` VALUES ('40', '充值帮助', '', '0', '28');
INSERT INTO `sf_art_category` VALUES ('41', '支付宝充值', '', '0', '40');
INSERT INTO `sf_art_category` VALUES ('44', '微信充值', '', '0', '40');
INSERT INTO `sf_art_category` VALUES ('45', '资金记录帮助', '', '0', '28');
INSERT INTO `sf_art_category` VALUES ('46', '充值明细', '', '0', '45');
INSERT INTO `sf_art_category` VALUES ('47', '提现明细', '', '0', '45');
INSERT INTO `sf_art_category` VALUES ('48', '全部记录', '', '0', '45');
INSERT INTO `sf_art_category` VALUES ('49', '常见帮助', '', '0', '28');
INSERT INTO `sf_art_category` VALUES ('50', '寄售交易帮助', '', '0', '49');
INSERT INTO `sf_art_category` VALUES ('51', '担保交易帮助', '', '0', '49');
INSERT INTO `sf_art_category` VALUES ('52', '求购交易帮助', '', '0', '49');
INSERT INTO `sf_art_category` VALUES ('53', '特色服务', '', '0', '28');
INSERT INTO `sf_art_category` VALUES ('54', '安全保障服务', '', '0', '53');
INSERT INTO `sf_art_category` VALUES ('55', '用户管理规范', '', '0', '28');
INSERT INTO `sf_art_category` VALUES ('56', '用户管理规范条例', '', '0', '55');
INSERT INTO `sf_art_category` VALUES ('57', '注册用户协议', '', '0', '55');
INSERT INTO `sf_art_category` VALUES ('58', '商品发布管理条例', '', '0', '28');
INSERT INTO `sf_art_category` VALUES ('59', '商品发布管理条例', '', '0', '58');
INSERT INTO `sf_art_category` VALUES ('60', '安全知识中心', '', '0', '0');
INSERT INTO `sf_art_category` VALUES ('61', '安全常识', '', '0', '60');
INSERT INTO `sf_art_category` VALUES ('62', '钓鱼网站盗号', '', '0', '60');
INSERT INTO `sf_art_category` VALUES ('63', '假客服欺诈', '', '0', '60');
INSERT INTO `sf_art_category` VALUES ('66', '邮件假链接', '', '0', '60');
INSERT INTO `sf_art_category` VALUES ('65', '骗术大揭秘', '', '0', '60');

-- ----------------------------
-- Table structure for `sf_ask`
-- ----------------------------
DROP TABLE IF EXISTS `sf_ask`;
CREATE TABLE `sf_ask` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `type_id` tinyint(3) unsigned NOT NULL COMMENT '1为咨询，2为建议，3为投诉',
  `ask_title` varchar(255) NOT NULL,
  `ask_time` varchar(255) NOT NULL,
  `pic` varchar(255) DEFAULT NULL,
  `ask_content` tinytext NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `tel` varchar(255) NOT NULL,
  `qq` varchar(255) NOT NULL,
  `answer` tinytext,
  `answer_user_name` varchar(255) DEFAULT NULL,
  `cate_id` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COMMENT='咨询建议表';

-- ----------------------------
-- Records of sf_ask
-- ----------------------------
INSERT INTO `sf_ask` VALUES ('2', '1', '发布求降价等多久啊', '1479277983', '', '发布求降价等多久啊？请回复下？', '25', '15698574581', '123234218', '发布求降价等多久啊？请回复下？发布求降价等多久啊？请回复下？发布求降价等多久啊？请回复下？111112331111', 'admin', '2');
INSERT INTO `sf_ask` VALUES ('7', '2', '我刚要出售一个账号提示我 要填写客服暗号 这个怎么填啊', '1479354894', '', '以前也卖过账号 好像没要客服暗号啊', '25', '15698574581', '123234218', '您好，请卖家在发布商品时设置客服暗号，当客服电话/QQ联系卖家时，卖家可以让客服提供“客服暗号”，以验证联系客服的真伪。未能正确提供“客服暗号”者，必为假客服，请谨防被骗！ ', 'admin', '0');
INSERT INTO `sf_ask` VALUES ('8', '1', '寄售是怎么收费的？', '1481601960', '', '寄售是怎么收费的？寄售是怎么收费的？寄售是怎么收费的？寄售是怎么收费的？', '9', '18628970131', '52365124', '寄售是怎么收费的？寄售是怎么收费的？寄售是怎么收费的？寄售是怎么收费的？', 'admin', '0');
INSERT INTO `sf_ask` VALUES ('9', '2', '怎么增加在线客服吗', '1481602026', '', '怎么增加在线客服吗怎么增加在线客服吗怎么增加在线客服吗', '9', '18628970131', '52365124', '怎么增加在线客服吗怎么增加在线客服吗怎么增加在线客服吗怎么增加在线客服吗怎么增加在线客服吗怎么增加在线客服吗', 'admin', '4');

-- ----------------------------
-- Table structure for `sf_attribute`
-- ----------------------------
DROP TABLE IF EXISTS `sf_attribute`;
CREATE TABLE `sf_attribute` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `game_id` int(10) unsigned NOT NULL COMMENT '游戏id',
  `game_goods_type_id` int(10) unsigned NOT NULL COMMENT '游戏商品类型id',
  `data` varchar(255) NOT NULL DEFAULT '' COMMENT '属性值',
  `game_cate_id` int(10) unsigned NOT NULL COMMENT '游戏分类id',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=21 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of sf_attribute
-- ----------------------------
INSERT INTO `sf_attribute` VALUES ('10', '38', '48', '{\"name\":[\"QQ好友\",\"性别\"],\"value\":[[\"有QQ好友\",\"无QQ好友\"],[\"男\",\"女\"]]}', '1');
INSERT INTO `sf_attribute` VALUES ('11', '22', '98', '{\"name\":[\"QQ好友\",\"性别\"],\"value\":[[\"有QQ好友\",\"无QQ好友\"],[\"男\",\"女\"]]}', '1');
INSERT INTO `sf_attribute` VALUES ('15', '35', '56', '{\"name\":[\"性别\",\"QQ好友\"],\"value\":[[\"男\",\"女\"],[\"有QQ好友\",\"无QQ好友\"]],\"field\":[\"sex\",\"is_qq\"]}', '1');
INSERT INTO `sf_attribute` VALUES ('16', '37', '43', '{\"name\":[\"QQ好友\",\"性别\"],\"value\":[[\"有QQ好友\",\"无QQ好友\"],[\"男\",\"女\"]],\"field\":[\"is_qq\",\"sex\"],\"key\":[[0,1],[0,1]]}', '1');
INSERT INTO `sf_attribute` VALUES ('18', '36', '41', '{\"name\":[\"密保问题\"],\"value\":[[\"密保问题未设置1\",\"密保问题已设置\"]]}', '1');
INSERT INTO `sf_attribute` VALUES ('19', '22', '99', '{\"name\":[\"游戏币单位\"],\"value\":[[\"万金\"]],\"field\":[\"\"],\"key\":[[0]]}', '1');
INSERT INTO `sf_attribute` VALUES ('20', '22', '97', '{\"name\":[\"装备类型\"],\"value\":[[\"卡片\",\"深渊票\"]],\"field\":[\"\"],\"key\":[[0,1]]}', '1');

-- ----------------------------
-- Table structure for `sf_banner`
-- ----------------------------
DROP TABLE IF EXISTS `sf_banner`;
CREATE TABLE `sf_banner` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `banner_name` varchar(255) NOT NULL DEFAULT '',
  `banner_order` int(10) unsigned NOT NULL,
  `banner_url` varchar(255) NOT NULL DEFAULT '',
  `banner_img` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of sf_banner
-- ----------------------------
INSERT INTO `sf_banner` VALUES ('2', 'kkk', '2', '/', '/public/uploads/c0844e497593c4fe914506be3c337b14.jpg');
INSERT INTO `sf_banner` VALUES ('3', 'yyy', '0', '/', '/public/uploads/0340c1ef269f050674d75fe735d4ff48.jpg');

-- ----------------------------
-- Table structure for `sf_collection`
-- ----------------------------
DROP TABLE IF EXISTS `sf_collection`;
CREATE TABLE `sf_collection` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `goods_id` int(10) unsigned NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COMMENT='收藏表';

-- ----------------------------
-- Records of sf_collection
-- ----------------------------
INSERT INTO `sf_collection` VALUES ('1', '9', '25');
INSERT INTO `sf_collection` VALUES ('2', '17', '25');
INSERT INTO `sf_collection` VALUES ('3', '19', '25');

-- ----------------------------
-- Table structure for `sf_config`
-- ----------------------------
DROP TABLE IF EXISTS `sf_config`;
CREATE TABLE `sf_config` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `config_title` varchar(50) NOT NULL DEFAULT '' COMMENT '配置标题',
  `config_name` varchar(50) NOT NULL DEFAULT '' COMMENT '配置变量名称',
  `config_content` text NOT NULL COMMENT '配置内容',
  `config_order` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `config_tips` varchar(255) NOT NULL DEFAULT '' COMMENT '描述',
  `field_type` varchar(50) NOT NULL DEFAULT '' COMMENT '字段类型',
  `field_value` varchar(255) NOT NULL DEFAULT '' COMMENT '字段值',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COMMENT='网站配置';

-- ----------------------------
-- Records of sf_config
-- ----------------------------
INSERT INTO `sf_config` VALUES ('1', '网站标题', 'web_title', '搜付在线', '1', '网站的显示标题，用于seo优化', 'input', '');
INSERT INTO `sf_config` VALUES ('3', '网站简介', 'web_description', '搜付在线游戏平台', '10', '网站主要业务的介绍', 'input', '');
INSERT INTO `sf_config` VALUES ('6', '网站关键词', 'web_keywords', '搜付,在线,游戏,平台', '0', '网站关键词，请用半角逗号(,)分隔多个关键字', 'textarea', '');
INSERT INTO `sf_config` VALUES ('5', '网站状态', 'web_status', '1', '5', '网站的打开关闭控制', 'radio', '0|关闭,1|开启');
INSERT INTO `sf_config` VALUES ('7', '积分比例(消费金额和积分的比例)', 'IntegralRatio', '1', '0', '消费金额和积分的比例', 'input', '');
INSERT INTO `sf_config` VALUES ('8', '网站顶部公告', 'topNews', '警惕：搜付在线热线及专线电话无外拨功能，任何以“兼职”，“刷信誉”，“做任务”，“缴纳保证金”为借口的均为诈骗行为。客服不会以任何形式向您索要游戏账号密码信息，谨防上当！', '0', '网站重要信息头部展示', 'textarea', '');

-- ----------------------------
-- Table structure for `sf_cut_price`
-- ----------------------------
DROP TABLE IF EXISTS `sf_cut_price`;
CREATE TABLE `sf_cut_price` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `goods_id` int(10) unsigned NOT NULL,
  `old_price` decimal(10,2) NOT NULL,
  `new_price` decimal(10,2) NOT NULL,
  `status` tinyint(3) unsigned NOT NULL DEFAULT '1' COMMENT '1等待，2同意，3拒绝或撤销',
  `telphone` varchar(255) NOT NULL,
  `qq` varchar(255) NOT NULL,
  `role_name` varchar(255) NOT NULL,
  `buy_number` int(11) unsigned NOT NULL,
  `user_id` int(11) unsigned NOT NULL,
  `created_time` varchar(255) NOT NULL,
  `to_user_id` int(10) unsigned NOT NULL,
  `order_sn` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COMMENT='降价申请';

-- ----------------------------
-- Records of sf_cut_price
-- ----------------------------

-- ----------------------------
-- Table structure for `sf_dk_game_facevalue`
-- ----------------------------
DROP TABLE IF EXISTS `sf_dk_game_facevalue`;
CREATE TABLE `sf_dk_game_facevalue` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `pid` int(10) unsigned NOT NULL,
  `cardid` int(10) unsigned DEFAULT NULL,
  `innum` int(10) unsigned DEFAULT NULL COMMENT '库存',
  `cardname` varchar(255) NOT NULL,
  `amounts` varchar(255) DEFAULT NULL COMMENT '可选数量',
  `memberprice` decimal(10,2) DEFAULT NULL,
  `is_on_sale` tinyint(4) NOT NULL DEFAULT '1' COMMENT '1上架，2下架',
  `thumb` varchar(255) DEFAULT NULL,
  `pervalue` int(11) DEFAULT NULL,
  `accountdesc` varchar(255) DEFAULT NULL,
  `is_recommend` tinyint(3) unsigned NOT NULL DEFAULT '1' COMMENT '1不推荐，2推荐',
  `is_hot` tinyint(3) unsigned NOT NULL DEFAULT '1' COMMENT '1不热销，2热销',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1130 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of sf_dk_game_facevalue
-- ----------------------------
INSERT INTO `sf_dk_game_facevalue` VALUES ('566', '2201', '220101', '30', '传奇世界2_游戏账号_元宝_任意充', '1', '1.00', '1', '/public/uploads/bb5a9758a578ddf3217e1c2b76a5adfb.jpg', '1', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('567', '2201', '220198', '30', '传奇世界2_游戏账号_时间_任意充直充', '1', '1.00', '1', null, '1', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('568', '2201', '220102', '30', '传奇世界2_盛大通行证_元宝_任意充直充', '1', '1.00', '1', null, '1', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('569', '2201', '220199', '30', '传奇世界2_盛大通行证_时间_任意充直充', '1', '1.00', '1', null, '1', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('570', '2202', '220208', '30', '热血传奇_游戏账号_元宝_任意充直充', '1', '1.00', '1', null, '1', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('571', '2202', '220209', '30', '热血传奇_盛大通行证_元宝_任意充直充', '1', '1.00', '1', null, '1', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('572', '2203', '220301', '30', '浩方VIP30天_盛大通行证10元直充', '1', '10.00', '2', null, '10', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('573', '2203', '220302', '30', '浩方1000点_盛大通行证10元', '1', '10.00', '1', null, '10', 'a:0:{}', '2', '2');
INSERT INTO `sf_dk_game_facevalue` VALUES ('574', '2203', '220303', '30', '浩方VIP30天_游戏账号10元直充', '1', '10.00', '1', null, '10', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('575', '2203', '220304', '30', '浩方1000点_游戏帐号10元', '1', '10.00', '1', null, '10', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('576', '2204', '220404', '30', '神迹_充元宝_盛大通行证任意充直充', '1', '1.00', '1', null, '1', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('577', '2204', '220405', '30', '神迹_充元宝_游戏帐号任意充直充', '1', '1.00', '1', null, '1', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('578', '2205', '220505', '30', '冒险岛任意充直充', '1', '1.00', '1', null, '1', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('579', '2206', '2252401', '30', '吉林Q币任意充直充', '1', '1.00', '1', null, '1', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('580', '2206', '220612', '30', 'Q币任意充直充', '1', '1.00', '1', null, '1', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('581', '2206', '220614', '30', 'Q币5元直充', '1', '5.00', '1', null, '5', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('582', '2206', '220615', '30', 'Q币10元直充', '1', '10.00', '1', null, '10', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('583', '2206', '220616', '30', 'Q币20元直充', '1', '20.00', '1', null, '20', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('584', '2206', '220617', '30', 'Q币30元直充', '1', '30.00', '1', null, '30', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('585', '2206', '220619', '30', 'Q币充值_接口专用_任意充直充', '1', '1.00', '1', null, '1', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('586', '2206', '220698', '30', '50Q币直充50元直充', '1', '50.00', '1', null, '50', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('587', '2206', '220699', '30', '100Q币直充100元直充', '1', '100.00', '1', null, '100', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('588', '2206', '2272901', '30', '全国Q币(按元充)任意充直充', '1', '1.00', '1', null, '1', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('589', '2206', '2253401', '30', '云南Q币任意充直充', '1', '1.00', '1', null, '1', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('590', '2206', '2254601', '30', '广东Q币任意充直充', '1', '1.00', '1', null, '1', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('591', '2206', '2249500', '30', '江苏Q币任意充直充', '1', '1.00', '1', null, '1', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('592', '2206', '2252601', '30', '湖南Q币任意充直充', '1', '1.00', '1', null, '1', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('593', '2206', '2253601', '30', '贵州Q币任意充直充', '1', '1.00', '1', null, '1', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('594', '2206', '2268501', '30', '腾讯-QQ币直充1000元', '1', '1000.00', '1', null, '1000', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('595', '2206', '2268503', '30', '腾讯-QQ币直充500元', '1', '500.00', '1', null, '500', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('596', '2206', '2268504', '30', '腾讯-QQ币直充200元', '1', '200.00', '1', null, '200', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('597', '2206', '2268506', '30', '腾讯-QQ币直充60元', '1', '60.00', '1', null, '60', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('598', '2206', '2268513', '30', '腾讯-QQ币直充300元', '1', '300.00', '1', null, '300', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('599', '2206', '2268514', '30', '腾讯-QQ币直充80元', '1', '80.00', '1', null, '80', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('600', '2206', '2268515', '30', '腾讯-QQ币直充70元', '1', '70.00', '1', null, '70', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('601', '2206', '2268516', '30', '腾讯-QQ币直充2元', '1', '2.00', '1', null, '2', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('602', '2206', '2268517', '30', '腾讯-QQ币直充90元', '1', '90.00', '1', null, '90', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('603', '2206', '2268518', '30', '腾讯-QQ币直充120元', '1', '120.00', '1', null, '120', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('604', '2206', '2268519', '30', '腾讯-QQ币直充150元', '1', '150.00', '1', null, '150', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('605', '2206', '2268520', '30', '腾讯-QQ币直充45元', '1', '45.00', '1', null, '45', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('606', '2206', '2268522', '30', '腾讯-QQ币直充35元', '1', '35.00', '1', null, '35', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('607', '2206', '2268523', '30', '腾讯-QQ币直充25元', '1', '25.00', '1', null, '25', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('608', '2206', '2268521', '30', '腾讯-QQ币直充40元', '1', '40.00', '1', null, '40', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('609', '2207', '220701', '30', '世纪天成_跑跑卡丁车_洛奇英雄传_反恐精英OL_EVE_任意充直充', '1', '1.00', '1', null, '1', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('610', '2207', '220702', '30', '世纪天成一卡通20元直充', '1', '20.00', '1', null, '20', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('611', '2207', '2274301', '30', '江苏世纪天成_跑跑卡丁车_洛奇英雄传_反恐精英OL_EVE_任意充直充', '1', '1.00', '1', null, '1', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('612', '2208', '2215310', '30', '网易一卡通(点卡交易/寄售)直充60元', '1', '60.00', '1', null, '60', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('613', '2208', '220801', '30', '网易一卡通5元直充', '1', '5.00', '1', null, '5', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('614', '2208', '220802', '30', '网易一卡通点卡交易寄售5元直充', '1', '5.00', '1', null, '5', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('615', '2208', '220803', '30', '网易一卡通10元直充', '1', '10.00', '1', null, '10', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('616', '2208', '220804', '30', '网易一卡通点卡交易寄售10元直充', '1', '10.00', '1', null, '10', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('617', '2208', '220805', '30', '网易一卡通20元直充', '1', '20.00', '1', null, '20', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('618', '2208', '220806', '30', '网易一卡通点卡交易寄售20元直充', '1', '20.00', '1', null, '20', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('619', '2208', '220807', '30', '网易一卡通50元直充', '1', '50.00', '1', null, '50', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('620', '2208', '220808', '30', '网易一卡通点卡交易寄售50元直充', '1', '50.00', '1', null, '50', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('621', '2208', '220809', '30', '网易一卡通6元直充', '1', '6.00', '1', null, '6', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('622', '2208', '220810', '30', '网易一卡通点卡交易寄售6元直充', '1', '6.00', '1', null, '6', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('623', '2208', '220811', '30', '网易一卡通40元直充', '1', '40.00', '1', null, '40', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('624', '2208', '220812', '30', '网易一卡通点卡交易寄售40元直充', '1', '40.00', '1', null, '40', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('625', '2208', '220813', '30', '网易一卡通15元直充', '1', '15.00', '1', null, '15', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('626', '2208', '220814', '30', '网易一卡通点卡交易寄售15元直充', '1', '15.00', '1', null, '15', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('627', '2208', '220815', '30', '网易一卡通30元直充', '1', '30.00', '1', null, '30', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('628', '2208', '220816', '30', '网易一卡通点卡交易寄售30元直充', '1', '30.00', '1', null, '30', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('629', '2208', '2215300', '30', '网易一卡通_点卡交易_寄售_100元直充', '1', '100.00', '1', null, '100', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('630', '2208', '2215315', '30', '网易一卡通_点卡交易_寄售_任意充直充', '1', '1.00', '1', null, '1', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('631', '2208', '2216700', '30', '网易一卡通100元直充', '1', '100.00', '1', null, '100', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('632', '2208', '2216718', '30', '网易一卡通任意充直充', '1', '1.00', '1', null, '1', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('633', '2208', '2272801', '30', '网易一卡通特惠直充100元', '1', '100.00', '1', null, '100', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('634', '2208', '2272802', '30', '网易一卡通特惠直充50元', '1', '50.00', '1', null, '50', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('635', '2208', '2272803', '30', '网易一卡通特惠直充30元', '1', '30.00', '1', null, '30', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('636', '2208', '2215308', '30', '网易一卡通(点卡交易/寄售)直充200元 ', '1', '200.00', '1', null, '200', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('637', '2208', '2137002', '30', '网易一卡通直充500元 ', '1', '500.00', '1', null, '500', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('638', '2208', '2137102', '30', '网易一卡通(点卡交易/寄售)直充500元 ', '1', '500.00', '1', null, '500', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('639', '2208', '2137001', '30', '网易一卡通直充1000元 ', '1', '1000.00', '1', null, '1000', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('640', '2208', '2137101', '30', '网易一卡通(点卡交易/寄售)直充1000元', '1', '1000.00', '1', null, '1000', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('641', '2208', '2216711', '30', '网易一卡通直充60元', '1', '60.00', '1', null, '60', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('642', '2208', '2216709', '30', '网易一卡通直充200元', '1', '200.00', '1', null, '200', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('643', '2209', '2217900', '30', '战网一卡通15元直充', '1', '15.00', '1', null, '15', 'a:0:{}', '2', '2');
INSERT INTO `sf_dk_game_facevalue` VALUES ('644', '2209', '2217902', '30', '战网一卡通30元直充', '1', '30.00', '1', null, '30', 'a:0:{}', '2', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('645', '2209', '2217901', '30', '战网一卡通20元直充', '1', '20.00', '1', null, '20', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('646', '2209', '220906', '30', '魔兽世界15元直充', '1', '15.00', '1', null, '15', 'a:0:{}', '2', '2');
INSERT INTO `sf_dk_game_facevalue` VALUES ('647', '2209', '220902', '30', '魔兽世界30元直充', '1', '30.00', '1', null, '30', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('648', '2209', '220999', '30', '网易战网_魔兽世界_1元在线直充_提交15的倍数_15战点=2000分钟_非代充', '1', '1.00', '1', null, '1', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('649', '2210', '221001', '30', '完美世界10元直充', '1', '10.00', '1', null, '10', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('650', '2210', '221002', '30', '完美世界20元直充', '1', '20.00', '1', null, '20', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('651', '2210', '221004', '30', '完美世界100元直充', '1', '100.00', '1', null, '100', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('652', '2210', '221003', '30', '完美世界50元直充', '1', '50.00', '1', null, '50', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('653', '2210', '221005', '30', '完美世界任意充直充', '1', '1.00', '1', null, '1', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('654', '22100', '2210004', '30', '空中网_坦克世界_激战2_龙_恶魔法则_圣魔之血_100元直充', '1', '100.00', '1', null, '100', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('655', '22100', '2210003', '30', '空中网_坦克世界_激战2_龙_恶魔法则_圣魔之血_50元直充', '1', '50.00', '1', null, '50', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('656', '22100', '2210001', '30', '空中网_坦克世界_激战2_龙_恶魔法则_圣魔之血_10元直充', '1', '10.00', '1', null, '10', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('657', '22100', '2210002', '30', '空中网_坦克世界_激战2_龙_恶魔法则_圣魔之血_30元直充', '1', '30.00', '1', null, '30', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('658', '22100', '2223102', '30', '坦克世界任意充直充', '1', '1.00', '1', null, '1', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('659', '22101', '2210101', '30', '降龙之剑10元直充', '1', '10.00', '1', null, '10', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('660', '22101', '2210102', '30', '降龙之剑20元直充', '1', '20.00', '1', null, '20', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('661', '22101', '2210103', '30', '降龙之剑50元直充', '1', '50.00', '1', null, '50', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('662', '22101', '2210104', '30', '降龙之剑100元直充', '1', '100.00', '1', null, '100', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('663', '22101', '2210105', '30', '降龙之剑任意充直充', '1', '1.00', '1', null, '1', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('664', '22102', '2210201', '30', '神鬼世界10元直充', '1', '10.00', '1', null, '10', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('665', '22102', '2210202', '30', '神鬼世界20元直充', '1', '20.00', '1', null, '20', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('666', '22102', '2210203', '30', '神鬼世界50元直充', '1', '50.00', '1', null, '50', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('667', '22102', '2210204', '30', '神鬼世界100元直充', '1', '100.00', '1', null, '100', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('668', '22102', '2210205', '30', '神鬼世界任意充直充', '1', '1.00', '1', null, '1', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('669', '22103', '2210301', '30', '搜狐一卡通任意充直充', '1', '1.00', '1', null, '1', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('670', '22103', '2210302', '30', '搜狐畅游一卡通100元直充', '1', '100.00', '1', null, '100', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('671', '22103', '2210303', '30', '搜狐畅游一卡通600点直充30元直充', '1', '30.00', '1', null, '30', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('672', '22103', '2218103', '30', '搜狐一卡通15元直充', '1', '15.00', '1', null, '15', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('673', '22103', '2218104', '30', '搜狐一卡通40元直充', '1', '40.00', '1', null, '40', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('674', '22103', '2218105', '30', '搜狐一卡通5元直充', '1', '5.00', '1', null, '5', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('675', '22104', '2210401', '30', '梦三国_电魂一卡通充值10元', '1', '10.00', '1', null, '10', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('676', '22104', '2210402', '30', '梦三国_电魂一卡通充值30元', '1', '30.00', '1', null, '30', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('677', '22104', '2210403', '30', '梦三国_电魂一卡通充值100元', '1', '100.00', '1', null, '100', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('678', '22104', '2210404', '30', '梦三国_电魂一卡通充值50元', '1', '50.00', '1', null, '50', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('679', '22105', null, null, '此商品暂不可用', null, null, '1', null, null, null, '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('680', '22106', null, null, '此商品暂不可用', null, null, '1', null, null, null, '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('681', '22107', null, null, '此商品暂不可用', null, null, '1', null, null, null, '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('682', '22108', null, null, '此商品暂不可用', null, null, '1', null, null, null, '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('683', '22109', null, null, '此商品暂不可用', null, null, '1', null, null, null, '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('684', '2211', '221101', '30', '武林外传10元直充', '1', '10.00', '1', null, '10', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('685', '2211', '221102', '30', '武林外传20元直充', '1', '20.00', '1', null, '20', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('686', '2211', '221103', '30', '武林外传50元直充', '1', '50.00', '1', null, '50', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('687', '2211', '221104', '30', '武林外传100元直充', '1', '100.00', '1', null, '100', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('688', '2211', '221105', '30', '武林外传任意充直充', '1', '1.00', '1', null, '1', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('689', '22111', null, null, '此商品暂不可用', null, null, '1', null, null, null, '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('690', '22112', '2211201', '30', '完美点券10元直充', '1', '10.00', '1', null, '10', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('691', '22112', '2211202', '30', '完美点券20元直充', '1', '20.00', '1', null, '20', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('692', '22112', '2211203', '30', '完美点券50元直充', '1', '50.00', '1', null, '50', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('693', '22112', '2211204', '30', '完美点券100元直充', '1', '100.00', '1', null, '100', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('694', '22112', '2211205', '30', '完美点券任意充直充', '1', '1.00', '1', null, '1', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('695', '22113', '2211301', '30', '星辰变任意充直充', '1', '1.00', '1', null, '1', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('696', '22114', '2211401', '30', '降龙极致10元直充', '1', '10.00', '1', null, '10', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('697', '22114', '2211402', '30', '降龙极致20元直充', '1', '20.00', '1', null, '20', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('698', '22114', '2211403', '30', '降龙极致50元直充', '1', '50.00', '1', null, '50', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('699', '22114', '2211404', '30', '降龙极致100元直充', '1', '100.00', '1', null, '100', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('700', '22114', '2211405', '30', '降龙极致任意充直充', '1', '1.00', '1', null, '1', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('701', '22116', '2211601', '30', '倚天屠龙记10元直充', '1', '10.00', '1', null, '10', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('702', '22116', '2211602', '30', '倚天屠龙记20元直充', '1', '20.00', '1', null, '20', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('703', '22116', '2211603', '30', '倚天屠龙记50元直充', '1', '50.00', '1', null, '50', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('704', '22116', '2211604', '30', '倚天屠龙记100元直充', '1', '100.00', '1', null, '100', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('705', '22116', '2211605', '30', '倚天屠龙记任意充直充', '1', '1.00', '1', null, '1', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('706', '22117', '2211701', '30', '鹿鼎记5元直充', '1', '5.00', '1', null, '5', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('707', '22117', '2211702', '30', '鹿鼎记15元直充', '1', '15.00', '1', null, '15', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('708', '22117', '2211704', '30', '鹿鼎记2000点直充100元', '1', '100.00', '1', null, '100', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('709', '22119', '2211901', '30', '米米卡_米米号_米币_10元充值', '1', '10.00', '1', null, '10', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('710', '22119', '2211902', '30', '米米卡_米米号_米币_30元充值', '1', '30.00', '1', null, '30', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('711', '22119', '2211903', '30', '米米卡_米米号_米币_50元充值', '1', '50.00', '1', null, '50', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('712', '2212', '221201', '30', '剑侠情缘网络版贰15元直充', '1', '15.00', '1', null, '15', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('713', '2212', '221202', '30', '剑侠情缘网络版贰50元直充', '1', '50.00', '1', null, '50', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('714', '22120', '225409', '30', '盛大传奇3直充任意充', '1', '1.00', '1', null, '1', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('715', '22121', '2212101', '30', '泥巴一卡通_三国演义_梦幻隋唐_冰火纪元_任意充直充', '1', '1.00', '1', null, '1', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('716', '22122', '2212201', '30', '风云传奇任意充直充', '1', '1.00', '1', null, '1', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('717', '22123', '2212301', '30', '神雕侠侣任意充直充', '1', '1.00', '1', null, '1', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('718', '22123', '2212302', '30', '神雕侠侣10元直充', '1', '10.00', '1', null, '10', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('719', '22123', '2212303', '30', '神雕侠侣20元直充', '1', '20.00', '1', null, '20', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('720', '22123', '2212304', '30', '神雕侠侣50元直充', '1', '50.00', '1', null, '50', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('721', '22123', '2212305', '30', '神雕侠侣直充100元', '1', '100.00', '1', null, '100', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('722', '22124', '2212401', '30', '迅雷魔域任意充直充', '1', '1.00', '1', null, '1', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('723', '22124', '2212402', '30', '迅雷机战任意充直充', '1', '1.00', '1', null, '1', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('724', '22124', '2212403', '30', '迅雷侠义道任意充直充', '1', '1.00', '1', null, '1', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('725', '22124', '2212404', '30', '迅雷新魔界任意充直充', '1', '1.00', '1', null, '1', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('726', '22124', '2212405', '30', '迅雷功夫世界任意充直充', '1', '1.00', '1', null, '1', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('727', '22124', '2212406', '30', '迅雷三国风云任意充直充', '1', '1.00', '1', null, '1', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('728', '22124', '2212407', '30', '迅雷英雄任意充直充', '1', '1.00', '1', null, '1', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('729', '22124', '2212408', '30', '迅雷兽血沸腾任意充直充', '1', '1.00', '1', null, '1', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('730', '22124', '2212409', '30', '迅雷龙任意充直充', '1', '1.00', '1', null, '1', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('731', '22124', '2212410', '30', '迅雷成吉思汗II任意充直充', '1', '1.00', '1', null, '1', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('732', '22124', '2212411', '30', '迅雷武侠风云任意充直充', '1', '1.00', '1', null, '1', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('733', '22124', '2212412', '30', '迅雷三十六计任意充直充', '1', '1.00', '1', null, '1', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('734', '22124', '2212413', '30', '仙剑神曲Online任意充直充', '1', '1.00', '1', null, '1', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('735', '22124', '2212414', '30', '迅雷仙宠任意充直充', '1', '1.00', '1', null, '1', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('736', '22124', '2212415', '30', '迅雷十年一剑任意充直充', '1', '1.00', '1', null, '1', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('737', '22124', '2212416', '30', '迅雷南帝北丐任意充直充', '1', '1.00', '1', null, '1', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('738', '22124', '2212417', '30', '迅雷仙侠风云任意充直充', '1', '1.00', '1', null, '1', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('739', '22124', '2212418', '30', '迅雷傲视天地任意充直充', '1', '1.00', '1', null, '1', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('740', '22124', '2212419', '30', '迅雷一骑当先_网页_任意充直充', '1', '1.00', '1', null, '1', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('741', '22124', '2212420', '30', '迅雷大冲锋任意充直充', '1', '1.00', '1', null, '1', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('742', '22124', '2212421', '30', '修魔任意充直充', '1', '1.00', '1', null, '1', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('743', '22124', '2212422', '30', '迅雷墨攻_网页_任意充直充', '1', '1.00', '1', null, '1', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('744', '22124', '2212423', '30', '迅雷卧龙吟_网页_任意充直充', '1', '1.00', '1', null, '1', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('745', '22124', '2212424', '30', '迅雷神仙道_网页_任意充直充', '1', '1.00', '1', null, '1', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('746', '22124', '2212425', '30', '迅雷斗破苍穹2_网页_任意充直充', '1', '1.00', '1', null, '1', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('747', '22124', '2212426', '30', '迅雷梦幻飞仙_网页_任意充直充', '1', '1.00', '1', null, '1', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('748', '22124', '2212427', '30', '迅雷龙将_网页_任意充直充', '1', '1.00', '1', null, '1', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('749', '22124', '2212428', '30', '迅雷火影世界_网页_任意充直充', '1', '1.00', '1', null, '1', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('750', '22125', '2212501', '30', '舞侠OL任意充直充', '1', '1.00', '1', null, '1', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('751', '22126', '2212601', '30', '圣斗士星矢10元直充', '1', '10.00', '1', null, '10', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('752', '22126', '2212602', '30', '圣斗士星矢20元直充', '1', '20.00', '1', null, '20', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('753', '22126', '2212603', '30', '圣斗士星矢50元直充', '1', '50.00', '1', null, '50', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('754', '22126', '2212604', '30', '圣斗士星矢100元直充', '1', '100.00', '1', null, '100', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('755', '22126', '2212605', '30', '圣斗士星矢任意充直充', '1', '1.00', '1', null, '1', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('756', '22127', null, null, '此商品暂不可用', null, null, '2', null, null, null, '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('757', '22128', null, null, '此商品暂不可用', null, null, '1', null, null, null, '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('758', '22129', null, null, '此商品暂不可用', null, null, '1', null, null, null, '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('759', '2213', '44466', '30', '七骑士Q点任意充直充', '1', '1.00', '1', null, '1', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('760', '2213', '221301', '30', 'Q点5元直充', '1', '5.00', '1', null, '5', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('761', '2213', '221303', '30', 'Q点10元直充', '1', '10.00', '1', null, '10', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('762', '2213', '221305', '30', 'Q点15元直充', '1', '15.00', '1', null, '15', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('763', '2213', '221307', '30', 'Q点30元直充', '1', '30.00', '1', null, '30', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('764', '2213', '221309', '30', 'Q点50元直充', '1', '50.00', '1', null, '50', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('765', '2213', '44475', '30', '仙剑奇侠传Q点任意充直充', '1', '1.00', '1', null, '1', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('766', '2213', '2203200', '30', 'Q点任意充直充', '1', '1.00', '1', null, '1', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('767', '2213', '44462', '30', '全民英雄Q点任意充直充', '1', '1.00', '1', null, '1', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('768', '2213', '44453', '30', '腾讯游戏通用安卓Q点任意充直充', '1', '1.00', '1', null, '1', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('769', '2213', '44464', '30', '全民砰砰砰Q点任意充直充', '1', '1.00', '1', null, '1', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('770', '2213', '44474', '30', '我叫MT2Q点任意充直充', '1', '1.00', '1', null, '1', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('771', '2213', '44456', '30', '欢乐斗牛Q点任意充直充', '1', '1.00', '1', null, '1', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('772', '2213', '44460', '30', '全民飞机大战Q点任意充直充', '1', '1.00', '1', null, '1', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('773', '2213', '44461', '30', '全民打怪兽Q点任意充直充', '1', '1.00', '1', null, '1', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('774', '2213', '44467', '30', '全民小镇Q点任意充直充', '1', '1.00', '1', null, '1', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('775', '2213', '44473', '30', '炫舞时代Q点任意充直充', '1', '1.00', '1', null, '1', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('776', '2213', '44470', '30', '天天飞车Q点任意充直充', '1', '1.00', '1', null, '1', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('777', '2213', '44463', '30', '全民炫舞Q点任意充直充', '1', '1.00', '1', null, '1', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('778', '2213', '44459', '30', '雷霆战机Q点任意充直充', '1', '1.00', '1', null, '1', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('779', '2213', '44455', '30', '欢乐斗地主Q点任意充直充', '1', '1.00', '1', null, '1', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('780', '2213', '44472', '30', '天天风之旅Q点任意充直充', '1', '1.00', '1', null, '1', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('781', '2213', '44469', '30', '天天炫斗Q点任意充直充', '1', '1.00', '1', null, '1', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('782', '2213', '44457', '30', '欢乐西游Q点任意充直充', '1', '1.00', '1', null, '1', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('783', '2213', '44471', '30', '天天逆战Q点任意充直充', '1', '1.00', '1', null, '1', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('784', '2213', '44454', '30', '魔龙与勇士Q点任意充直充', '1', '1.00', '1', null, '1', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('785', '2213', '44465', '30', '全民突击Q点任意充直充', '1', '1.00', '1', null, '1', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('786', '2213', '44458', '30', '节奏大师Q点任意充直充', '1', '1.00', '1', null, '1', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('787', '2213', '44468', '30', '天天酷跑Q点任意充直充', '1', '1.00', '1', null, '1', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('788', '2213', '44476', '30', '游龙英雄Q点任意充直充', '1', '1.00', '1', null, '1', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('789', '22130', null, null, '此商品暂不可用', null, null, '1', null, null, null, '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('790', '22131', null, null, '此商品暂不可用', null, null, '1', null, null, null, '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('791', '22132', null, null, '此商品暂不可用', null, null, '1', null, null, null, '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('792', '22133', null, null, '此商品暂不可用', null, null, '1', null, null, null, '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('793', '22134', null, null, '此商品暂不可用', null, null, '1', null, null, null, '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('794', '22135', null, null, '此商品暂不可用', null, null, '1', null, null, null, '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('795', '22136', null, null, '此商品暂不可用', null, null, '1', null, null, null, '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('796', '22137', null, null, '此商品暂不可用', null, null, '1', null, null, null, '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('797', '22138', null, null, '此商品暂不可用', null, null, '1', null, null, null, '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('798', '22139', null, null, '此商品暂不可用', null, null, '1', null, null, null, '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('799', '2214', '221409', '30', '久游_久游通行证帐号_限江苏任意充直充', '1', '1.00', '1', null, '1', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('800', '2214', '221410', '30', '久游_久游通行证帐号任意充直充', '1', '1.00', '1', null, '1', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('801', '22140', null, null, '此商品暂不可用', null, null, '1', null, null, null, '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('802', '22141', null, null, '此商品暂不可用', null, null, '1', null, null, null, '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('803', '22143', '2243400', '30', '圣王任意充直充', '1', '1.00', '1', null, '1', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('804', '22144', null, null, '此商品暂不可用', null, null, '1', null, null, null, '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('805', '22145', '2244700', '30', '天翼决任意充直充', '1', '1.00', '1', null, '1', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('806', '22146', '2245501', '30', 'dota2_刀塔_10元直充', '1', '10.00', '1', null, '10', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('807', '22146', '2245500', '30', 'dota2_刀塔_100元直充', '1', '100.00', '1', null, '100', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('808', '22146', '2245502', '30', 'dota2_刀塔_20元直充', '1', '20.00', '1', null, '20', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('809', '22146', '2245503', '30', 'dota2_刀塔_50元直充', '1', '50.00', '1', null, '50', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('810', '22146', '2245504', '30', 'dota2_刀塔_任意充直充', '1', '1.00', '1', null, '1', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('811', '2215', '221501', '30', '金山一卡通15元直充', '1', '15.00', '1', null, '15', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('812', '2215', '221502', '30', '金山一卡通50元直充', '1', '50.00', '1', null, '50', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('813', '2215', '221503', '30', '金山一卡通5元直充', '1', '5.00', '1', null, '5', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('814', '2215', '221504', '30', '金山一卡通100元直充', '1', '100.00', '1', null, '100', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('815', '2216', '221605', '30', '梦幻国度任意充直充', '1', '1.00', '1', null, '1', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('816', '2217', '221708', '30', '泡泡堂直充_游戏账号_任意充直充', '1', '1.00', '1', null, '1', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('817', '2217', '221709', '30', '泡泡堂直充_盛大通行证_任意充直充', '1', '1.00', '1', null, '1', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('818', '2218', '221804', '30', '霸王II任意充直充', '1', '1.00', '1', null, '1', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('819', '2219', '221903', '30', '武神10元直充', '1', '10.00', '1', null, '10', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('820', '2219', '221904', '30', '武神30元直充', '1', '30.00', '1', null, '30', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('821', '22190', '2219000', '30', '问道10元直充', '1', '10.00', '1', null, '10', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('822', '22190', '2219001', '30', '问道100元直充', '1', '100.00', '1', null, '100', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('823', '22190', '2219002', '30', '问道30元直充', '1', '30.00', '1', null, '30', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('824', '22190', '2219003', '30', '问道任意充直充', '1', '1.00', '1', null, '1', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('825', '2220', '222001', '30', '完美国际10元直充', '1', '10.00', '1', null, '10', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('826', '2220', '222002', '30', '完美国际20元直充', '1', '20.00', '1', null, '20', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('827', '2220', '222003', '30', '完美国际50元直充', '1', '50.00', '1', null, '50', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('828', '2220', '222004', '30', '完美国际100元直充', '1', '100.00', '1', null, '100', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('829', '2220', '222005', '30', '完美国际任意充直充', '1', '1.00', '1', null, '1', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('830', '2221', '222101', '30', '诛仙3直充10元', '1', '10.00', '1', null, '10', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('831', '2221', '222102', '30', '诛仙3直充20元', '1', '20.00', '1', null, '20', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('832', '2221', '222103', '30', '诛仙3直充50元', '1', '50.00', '1', null, '50', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('833', '2221', '222104', '30', '诛仙3直充100元', '1', '100.00', '1', null, '100', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('834', '2221', '222105', '30', '诛仙3直充任意充', '1', '1.00', '1', null, '1', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('835', '2221', '222198', '30', '诛仙3直充15元', '1', '15.00', '1', null, '15', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('836', '2221', '222199', '30', '诛仙3直充30元', '1', '30.00', '1', null, '30', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('837', '22215', '2221500', '30', '4399一卡通5元直充', '1', '5.00', '1', null, '5', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('838', '22215', '2221501', '30', '4399一卡通直充10元', '1', '10.00', '1', null, '10', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('839', '22215', '2221502', '30', '4399一卡通直充30元', '1', '30.00', '1', null, '30', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('840', '22215', '2221503', '30', '4399一卡通直充50元', '1', '50.00', '1', null, '50', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('841', '22215', '2221504', '30', '4399一卡通直充100元', '1', '100.00', '1', null, '100', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('842', '22215', '2221505', '30', '4399一卡通直充500元', '1', '500.00', '1', null, '500', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('843', '22215', '2221506', '30', '4399一卡通任意充直充', '1', '1.00', '1', null, '1', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('844', '2222', '222201', '30', '彩虹岛Online任意充直充', '1', '1.00', '1', null, '1', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('845', '2223', '222301', '30', '红钻贵族10元直充', '1', '10.00', '1', null, '10', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('846', '2223', '222302', '30', '黄钻贵族10元直充', '1', '10.00', '1', null, '10', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('847', '2223', '222304', '30', 'QQ堂紫钻10元直充', '1', '10.00', '1', null, '10', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('848', '2223', '222305', '30', '粉钻贵族10元直充', '1', '10.00', '1', null, '10', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('849', '2223', '222306', '30', '绿钻贵族10元直充', '1', '10.00', '1', null, '10', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('850', '2223', '222307', '30', '音速紫钻10元直充', '1', '10.00', '1', null, '10', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('851', '2223', '222308', '30', '蓝钻贵族10元直充', '1', '10.00', '1', null, '10', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('852', '2223', '222309', '30', 'QQ会员10元直充', '1', '10.00', '1', null, '10', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('853', '2223', '222310', '30', '飞车紫钻10元直充', '1', '10.00', '1', null, '10', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('854', '2223', '222311', '30', '炫舞紫钻20元直充', '1', '20.00', '1', null, '20', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('855', '2223', '222312', '30', 'CF会员30元直充', '1', '30.00', '1', null, '30', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('856', '2223', '222313', '30', '黄钻豪华版15元直充', '1', '15.00', '1', null, '15', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('857', '2223', '222314', '30', '蓝钻豪华版15元直充', '1', '15.00', '1', null, '15', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('858', '2223', '222315', '30', 'QQ情侣红钻按月充15元直充', '1', '15.00', '1', null, '15', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('859', '2223', '222316', '30', 'QQ蓝钻年费会员120元直充', '1', '120.00', '1', null, '120', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('860', '2223', '222320', '30', 'QQ游戏欢乐大礼包5元直充', '1', '5.00', '1', null, '5', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('861', '2223', '2244800', '30', 'QQ超级会员20元直充', '1', '20.00', '1', null, '20', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('862', '2225', '222501', '30', '街头篮球任意充直充', '1', '1.00', '1', null, '1', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('863', '2225', '222503', '30', '拍拍部落任意充直充', '1', '1.00', '1', null, '1', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('864', '2226', '222601', '30', '魔域[魔石卡]1380点充值50元直充', '1', '50.00', '1', null, '50', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('865', '2226', '222602', '30', '魔域[魔石卡]270点充值10元直充', '1', '10.00', '1', null, '10', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('866', '2226', '222603', '30', '机战1380点直充60元直充', '1', '60.00', '1', null, '60', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('867', '2226', '222604', '30', '征服天石卡1380点价格50元充值', '1', '50.00', '1', null, '50', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('868', '2226', '222605', '30', '投名状Online1380点直充60元直充', '1', '60.00', '1', null, '60', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('869', '2226', '222606', '30', '英雄无敌在线1380点直充60元直充', '1', '60.00', '1', null, '60', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('870', '2226', '222607', '30', '开心1380点直充60元直充', '1', '60.00', '1', null, '60', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('871', '2226', '222609', '30', '征服天石卡270点价格10元充值', '1', '10.00', '1', null, '10', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('872', '2226', '222610', '30', '机战270点15元直充', '1', '15.00', '1', null, '15', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('873', '2226', '222611', '30', '开心270点15元直充', '1', '15.00', '1', null, '15', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('874', '2226', '222616', '30', '梦幻迪士尼270点15元直充', '1', '15.00', '1', null, '15', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('875', '2226', '222617', '30', '梦幻迪士尼1380点直充60元直充', '1', '60.00', '1', null, '60', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('876', '2226', '222618', '30', '天元270点15元直充', '1', '15.00', '1', null, '15', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('877', '2226', '222619', '30', '天元1380点直充60元直充', '1', '60.00', '1', null, '60', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('878', '2226', '222613', '30', '英雄无敌在线270点15元直充', '1', '15.00', '1', null, '15', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('879', '2227', '222701', '30', '疯狂赛车II任意充直充', '1', '1.00', '1', null, '1', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('880', '2228', '222801', '30', '新热血英豪直充_游戏账号任意充直充', '1', '1.00', '1', null, '1', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('881', '2228', '222802', '30', '新热血英豪直充_盛大通行证任意充直充', '1', '1.00', '1', null, '1', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('882', '2229', '222903', '30', '新水浒Q传_原大话水浒_5元_100点直充', '1', '5.00', '1', null, '5', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('883', '2229', '222904', '30', '新水浒Q传15元直充', '1', '15.00', '1', null, '15', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('884', '2229', '222905', '30', '新水浒Q传40元直充', '1', '40.00', '1', null, '40', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('885', '2230', '223001', '30', '联众币任意充直充', '1', '1.00', '1', null, '1', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('886', '2231', '223101', '30', '赤壁10元直充', '1', '10.00', '1', null, '10', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('887', '2231', '223102', '30', '赤壁20元直充', '1', '20.00', '1', null, '20', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('888', '2231', '223103', '30', '赤壁50元直充', '1', '50.00', '1', null, '50', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('889', '2231', '223104', '30', '赤壁100元直充', '1', '100.00', '1', null, '100', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('890', '2231', '223105', '30', '赤壁任意充直充', '1', '1.00', '1', null, '1', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('891', '2232', '223201', '30', '风云_武魂传说游戏账号_任意充直充', '1', '1.00', '1', null, '1', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('892', '2232', '223202', '30', '风云_武魂传说盛大通行证_任意充直充', '1', '1.00', '1', null, '1', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('893', '2233', '223301', '30', '苍天任意充直充', '1', '1.00', '1', null, '1', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('894', '2234', '223401', '30', '超级跑跑任意充直充', '1', '1.00', '1', null, '1', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('895', '22348', '2234800', '30', '问道外传任意充直充', '1', '1.00', '1', null, '1', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('896', '22348', '2234801', '30', '问道外传10元直充', '1', '10.00', '1', null, '10', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('897', '22348', '2234802', '30', '问道外传100元直充', '1', '100.00', '1', null, '100', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('898', '22348', '2234803', '30', '问道外传30元直充', '1', '30.00', '1', null, '30', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('899', '2235', '223501', '30', '新英雄年代任意充直充', '1', '1.00', '1', null, '1', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('900', '2236', '223601', '30', '春秋Q传15元直充', '1', '15.00', '1', null, '15', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('901', '2236', '223602', '30', '春秋Q传50元直充', '1', '50.00', '1', null, '50', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('902', '2237', '223701', '30', '纵横天下任意充直充', '1', '1.00', '1', null, '1', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('903', '2238', '223804', '30', '热舞派对II100元直充', '1', '100.00', '1', null, '100', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('904', '2238', '223801', '30', '热舞派对II10元直充', '1', '10.00', '1', null, '10', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('905', '2238', '223802', '30', '热舞派对II20元直充', '1', '20.00', '1', null, '20', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('906', '2238', '223803', '30', '热舞派对II50元直充', '1', '50.00', '1', null, '50', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('907', '2238', '223805', '30', '热舞派对II任意充直充', '1', '1.00', '1', null, '1', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('908', '2239', '223901', '30', '千年3直充任意充', '1', '1.00', '1', null, '1', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('909', '2241', '224101', '30', '盛大点券任意充直充_盛大通行证', '1', '1.00', '1', null, '1', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('910', '2241', '224102', '30', '盛大通行证_盛大点券直充10元', '1', '10.00', '1', null, '10', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('911', '2241', '224103', '30', '盛大通行证/盛大点券任意充直充', '1', '1.00', '1', null, '1', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('912', '22412', '2241202', '30', '多玩Y币18Y币20元直充', '1', '20.00', '1', null, '20', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('913', '22412', '2241200', '30', '多玩Y币9Y币10元直充', '1', '10.00', '1', null, '10', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('914', '22412', '2241201', '30', '多玩Y币13.5Y币15元直充', '1', '15.00', '1', null, '15', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('915', '22412', '2241203', '30', '多玩Y币4.5Y币5元直充', '1', '5.00', '1', null, '5', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('916', '22412', '2241204', '30', '多玩Y币45Y币50元直充', '1', '50.00', '1', null, '50', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('917', '22412', '2241205', '30', '多玩Y币90Y币100元直充', '1', '100.00', '1', null, '100', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('918', '22412', '2241206', '30', '多玩Y币27Y币30元直充', '1', '30.00', '1', null, '30', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('919', '2242', '224201', '30', '剑侠世界15元直充', '1', '15.00', '1', null, '15', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('920', '2242', '224202', '30', '剑侠世界50元直充', '1', '50.00', '1', null, '50', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('921', '2243', '224301', '30', 'QQ三国任意充直充', '1', '1.00', '1', null, '1', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('922', '2244', '224401', '30', 'DNF黑钻20元直充', '1', '20.00', '1', null, '20', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('923', '2244', '224402', '30', '地下城与勇士任意充直充', '1', '1.00', '1', null, '1', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('924', '2245', '224501', '30', 'QQ华夏100点任意充直充', '1', '1.00', '1', null, '1', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('925', '2245', '224502', '30', 'QQ华夏1铜板任意充直充', '1', '1.00', '1', null, '1', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('926', '2245', '224503', '30', 'QQ华夏1银元宝任意充直充10元直充', '1', '10.00', '1', null, '10', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('927', '2245', '224504', '30', 'QQ华夏1金元宝任意充直充30元直充', '1', '30.00', '1', null, '30', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('928', '2246', '224601', '30', '口袋西游10元直充', '1', '10.00', '1', null, '10', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('929', '2246', '224602', '30', '口袋西游20元直充', '1', '20.00', '1', null, '20', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('930', '2246', '224603', '30', '口袋西游50元直充', '1', '50.00', '1', null, '50', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('931', '2246', '224604', '30', '口袋西游100元直充', '1', '100.00', '1', null, '100', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('932', '2246', '224605', '30', '口袋西游任意充直充', '1', '1.00', '1', null, '1', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('933', '2247', '224701', '30', '边锋一区任意充直充_银子__游戏帐号', '1', '1.00', '1', null, '1', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('934', '2247', '224702', '30', '边锋棋牌任意充直充_盛大通行证直充', '1', '1.00', '1', null, '1', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('935', '2248', '224802', '30', '星际争霸II包月充值_20元月', '1', '20.00', '1', null, '20', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('936', '2248', '224803', '30', '星际争霸II畅玩卡充值90战网点90元直充', '1', '90.00', '1', null, '90', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('937', '22488', '2248800', '30', '幻想神域15元直充', '1', '15.00', '1', null, '15', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('938', '22488', '2248801', '30', '幻想神域任意充直充5的倍数', '1', '1.00', '1', null, '1', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('939', '22488', '2248802', '30', '幻想神域50元直充', '1', '50.00', '1', null, '50', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('940', '22488', '2248803', '30', '幻想神域100元直充', '1', '100.00', '1', null, '100', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('941', '2249', '224901', '30', '热血三国10元直充', '1', '10.00', '1', null, '10', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('942', '2249', '224902', '30', '热血三国30元直充', '1', '30.00', '1', null, '30', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('943', '2249', '224903', '30', '热血三国100元直充', '1', '100.00', '1', null, '100', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('944', '22493', '2249301', '30', '神谕之战_TERA_100元直充', '1', '100.00', '1', null, '100', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('945', '22493', '2249300', '30', '神谕之战_TERA_30元直充', '1', '30.00', '1', null, '30', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('946', '22493', '2249302', '30', '神谕之战_TERA_50元直充', '1', '50.00', '1', null, '50', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('947', '22494', '2249400', '30', '昆仑一卡通100元直充', '1', '100.00', '1', null, '100', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('948', '22494', '2249401', '30', '昆仑一卡通30元直充', '1', '30.00', '1', null, '30', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('949', '22494', '2249402', '30', '昆仑一卡通50元直充', '1', '50.00', '1', null, '50', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('950', '2250', '225003', '30', '悠游一卡通15元直充', '1', '15.00', '1', null, '15', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('951', '2251', '225103', '30', '巨人一卡通100元直充', '1', '100.00', '1', null, '100', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('952', '2251', '225101', '30', '巨人一卡通20元直充', '1', '20.00', '1', null, '20', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('953', '2251', '225102', '30', '巨人一卡通50元直充', '1', '50.00', '1', null, '50', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('954', '2251', '225104', '30', '巨人一卡通10元直充', '1', '10.00', '1', null, '10', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('955', '2251', '225198', '30', '巨人一卡通直充60元', '1', '60.00', '1', null, '60', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('956', '2251', '225199', '30', '巨人一卡通直充30元', '1', '30.00', '1', null, '30', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('957', '2252', '225201', '30', '热血江湖30元充值', '1', '30.00', '1', null, '30', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('958', '2252', '225202', '30', '热血江湖10元充值', '1', '10.00', '1', null, '10', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('959', '2252', '225203', '30', '热血江湖任意充直充点击购买更多面值', '1', '1.00', '1', null, '1', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('960', '2253', '225301', '30', '新倚天剑与屠龙刀30元直充', '1', '30.00', '1', null, '30', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('961', '2254', '225407', '30', '神泣任意充直充', '1', '1.00', '1', null, '1', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('962', '2254', '225408', '30', '星战前夜_EVE_任意充直充', '1', '1.00', '1', null, '1', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('963', '2254', '225401', '30', 'CDC金币任意充直充', '1', '1.00', '1', null, '1', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('964', '2254', '225405', '30', '特种部队任意充直充', '1', '1.00', '1', null, '1', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('965', '2255', '225501', '30', '91币_充值到91通行证_10元直充', '1', '10.00', '1', null, '10', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('966', '2255', '225502', '30', '91币_充值到91通行证_35元直充', '1', '35.00', '1', null, '35', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('967', '2256', '225601', '30', '光宇币30元直充', '1', '30.00', '1', null, '30', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('968', '2256', '225602', '30', '光宇币10元直充', '1', '10.00', '1', null, '10', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('969', '2256', '225603', '30', '光宇一卡通任意充直充', '1', '1.00', '1', null, '1', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('970', '2257', null, null, '此商品暂不可用', null, null, '1', null, null, null, '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('971', '2258', '225801', '30', '凤舞天骄10元直充', '1', '10.00', '1', null, '10', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('972', '2258', '225802', '30', '凤舞天骄30元直充', '1', '30.00', '1', null, '30', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('973', '2259', '225901', '30', '久游休闲卡10元直充', '1', '10.00', '1', null, '10', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('974', '2259', '225902', '30', '久游休闲卡30元直充', '1', '30.00', '1', null, '30', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('975', '2259', '225903', '30', '久游休闲卡50元直充', '1', '50.00', '1', null, '50', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('976', '2260', '226001', '30', '天龙八部3直充15元_300点', '1', '15.00', '1', null, '15', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('977', '2260', '226002', '30', '天龙八部3直充30元_600点', '1', '30.00', '1', null, '30', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('978', '2260', '226003', '30', '天龙八部3直充40元_800点', '1', '40.00', '1', null, '40', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('979', '2260', '226004', '30', '天龙八部3直充5元_100点', '1', '5.00', '1', null, '5', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('980', '2260', '226005', '30', '天龙八部3直充100元_2000点', '1', '100.00', '1', null, '100', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('981', '2261', '226103', '30', '华夏Online38元直充', '1', '38.00', '1', null, '38', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('982', '2261', '226102', '30', '华夏Online免费版38元直充', '1', '38.00', '1', null, '38', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('983', '2261', '226104', '30', '华夏IIOnline38元直充', '1', '38.00', '1', null, '38', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('984', '2261', '226105', '30', '英雄岛38元直充', '1', '38.00', '1', null, '38', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('985', '2262', '226202', '30', '剑舞江南10元直充', '1', '10.00', '1', null, '10', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('986', '2262', '226201', '30', '剑舞江南50元直充', '1', '50.00', '1', null, '50', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('987', '2263', '226301', '30', '唐人游10元直充', '1', '10.00', '1', null, '10', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('988', '2263', '226302', '30', '唐人游20元直充', '1', '20.00', '1', null, '20', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('989', '2264', '226403', '30', '传奇归来任意充直充', '1', '1.00', '1', null, '1', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('990', '2265', '226505', '30', '迅雷雷点卡20元直充', '1', '20.00', '1', null, '20', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('991', '2265', '226501', '30', '迅雷雷点卡10元直充', '1', '10.00', '1', null, '10', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('992', '2265', '226502', '30', '迅雷雷点卡30元直充', '1', '30.00', '1', null, '30', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('993', '2265', '226503', '30', '迅雷雷点卡50元直充', '1', '50.00', '1', null, '50', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('994', '2265', '226504', '30', '迅雷雷点卡100元直充', '1', '100.00', '1', null, '100', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('995', '2265', '226506', '30', '迅雷雷点卡200元直充', '1', '200.00', '1', null, '200', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('996', '2265', '226507', '30', '迅雷雷点卡500元直充', '1', '500.00', '1', null, '500', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('997', '2266', '226601', '30', '三国无双1500点在线充15元直充', '1', '15.00', '1', null, '15', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('998', '2266', '226602', '30', '三国无双3000点在线充30元直充', '1', '30.00', '1', null, '30', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('999', '2267', '226705', '30', '神魔大陆100元直充', '1', '100.00', '1', null, '100', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('1000', '2267', '226706', '30', '神魔大陆任意充直充', '1', '1.00', '1', null, '1', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('1001', '2267', '226702', '30', '神魔大陆10元直充', '1', '10.00', '1', null, '10', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('1002', '2267', '226703', '30', '神魔大陆20元直充', '1', '20.00', '1', null, '20', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('1003', '2267', '226704', '30', '神魔大陆50元直充', '1', '50.00', '1', null, '50', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('1004', '2269', '226901', '30', '网易一卡通150点直充_游戏点数15元直充', '1', '15.00', '1', null, '15', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('1005', '2269', '226902', '30', '网易一卡通300点直充_游戏点数30元直充', '1', '30.00', '1', null, '30', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('1006', '2270', '227001', '30', 'VS对战平台10元直充', '1', '10.00', '1', null, '10', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('1007', '2270', '227002', '30', 'VS对战平台任意充直充', '1', '1.00', '1', null, '1', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('1008', '2271', '227101', '30', '烈焰飞雪30元直充', '1', '30.00', '1', null, '30', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('1009', '2272', '227202', '30', '舞街区30元直充', '1', '30.00', '1', null, '30', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('1010', '2272', '227203', '30', '航海世纪30元直充', '1', '30.00', '1', null, '30', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('1011', '2272', '227205', '30', '天子30元直充', '1', '30.00', '1', null, '30', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('1012', '2272', '227206', '30', '龙战_页游_30元直充', '1', '30.00', '1', null, '30', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('1013', '2274', '227401', '30', '预言Online30元直充', '1', '30.00', '1', null, '30', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('1014', '2274', '227402', '30', '预言Online100元直充', '1', '100.00', '1', null, '100', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('1015', '2274', '227403', '30', '盛世Online30元直充', '1', '30.00', '1', null, '30', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('1016', '2275', '227501', '30', '龙游天下一卡通_征战_30元直充', '1', '30.00', '1', null, '30', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('1017', '2275', '227502', '30', '反恐行动15元直充', '1', '15.00', '1', null, '15', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('1018', '2275', '227503', '30', '反恐行动50元直充', '1', '50.00', '1', null, '50', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('1019', '2276', '227602', '30', '诸侯任意充直充', '1', '1.00', '1', null, '1', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('1020', '2276', '227603', '30', '生肖传说任意充直充', '1', '1.00', '1', null, '1', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('1021', '2276', '227604', '30', '战神光辉任意充直充', '1', '1.00', '1', null, '1', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('1022', '2276', '227605', '30', '魔界任意充直充', '1', '1.00', '1', null, '1', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('1023', '2277', '227701', '30', '神鬼传奇10元直充', '1', '10.00', '1', null, '10', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('1024', '2277', '227702', '30', '神鬼传奇20元直充', '1', '20.00', '1', null, '20', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('1025', '2277', '227703', '30', '神鬼传奇50元直充', '1', '50.00', '1', null, '50', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('1026', '2277', '227704', '30', '神鬼传奇100元直充', '1', '100.00', '1', null, '100', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('1027', '2277', '227705', '30', '神鬼传奇任意充直充', '1', '1.00', '1', null, '1', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('1028', '22771', '2277103', '30', '苹果AppStore300元直充', '1', '300.00', '1', null, '300', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('1029', '22771', '2277105', '30', '苹果AppStore50元直充', '1', '50.00', '1', null, '50', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('1030', '22771', '2277102', '30', '苹果AppStore500元直充', '1', '500.00', '1', null, '500', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('1031', '22771', '2277106', '30', '苹果AppStore1000元直充', '1', '1000.00', '1', null, '1000', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('1032', '22771', '2277104', '30', '苹果AppStore100元直充', '1', '100.00', '1', null, '100', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('1033', '2279', '227901', '30', '蜀山新传任意充直充', '1', '1.00', '1', null, '1', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('1034', '2280', '228001', '30', '永恒之塔_盛大通行证_时间任意充直充', '1', '1.00', '1', null, '1', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('1035', '2280', '228098', '30', '永恒之塔_盛大通行证_守护点任意充直充', '1', '1.00', '1', null, '1', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('1036', '2280', '228002', '30', '盛大永恒之塔深谷回响冲级特惠包直充35元直充', '1', '35.00', '1', null, '35', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('1037', '2281', '228101', '30', '剑网2外传15元直充', '1', '15.00', '1', null, '15', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('1038', '2281', '228102', '30', '剑网2外传50元直充', '1', '50.00', '1', null, '50', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('1039', '2282', '228201', '30', '5173在线充50点60元直充', '1', '60.00', '1', null, '60', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('1040', '2282', '228202', '30', '5173在线充100点120元直充', '1', '120.00', '1', null, '120', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('1041', '2282', '228203', '30', '5173在线充300点360元直充', '1', '360.00', '1', null, '360', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('1042', '2282', '228204', '30', '5173在线充80点96元直充', '1', '96.00', '1', null, '96', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('1043', '2282', '228205', '30', '5173在线充200点240元直充', '1', '240.00', '1', null, '240', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('1044', '2283', '228301', '30', '剑侠世界盛大版任意充直充', '1', '1.00', '1', null, '1', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('1045', '2284', '228401', '30', 'EA_SPORTS_FIFA_Online2直充15元', '1', '15.00', '1', null, '15', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('1046', '2284', '228402', '30', 'EA_SPORTS_FIFA_Online2直充30元', '1', '30.00', '1', null, '30', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('1047', '2286', '228601', '30', '新梦幻诛仙10元直充', '1', '10.00', '1', null, '10', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('1048', '2286', '228602', '30', '新梦幻诛仙20元直充', '1', '20.00', '1', null, '20', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('1049', '2286', '228603', '30', '新梦幻诛仙50元直充', '1', '50.00', '1', null, '50', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('1050', '2286', '228604', '30', '新梦幻诛仙100元直充', '1', '100.00', '1', null, '100', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('1051', '2286', '228605', '30', '新梦幻诛仙任意充直充', '1', '1.00', '1', null, '1', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('1052', '2287', '228701', '30', '新蜀门10元直充', '1', '10.00', '1', null, '10', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('1053', '2287', '228702', '30', '新蜀门50元直充', '1', '50.00', '1', null, '50', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('1054', '2287', '228703', '30', '新蜀门100元直充', '1', '100.00', '1', null, '100', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('1055', '2288', '2206300', '30', '新剑侠情缘网络版叁5元直充', '1', '5.00', '1', null, '5', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('1056', '2288', '2206301', '30', '新剑侠情缘网络版叁100元直充', '1', '100.00', '1', null, '100', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('1057', '2288', '2206302', '30', '新剑侠情缘网络版叁30元直充', '1', '30.00', '1', null, '30', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('1058', '2288', '228801', '30', '新剑侠情缘网络版叁15元直充', '1', '15.00', '1', null, '15', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('1059', '2288', '228802', '30', '新剑侠情缘网络版叁_新剑网3_50元直充', '1', '50.00', '1', null, '50', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('1060', '22888', null, null, '此商品暂不可用', null, null, '1', null, null, null, '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('1061', '2289', '228901', '30', '成吉思汗3直充10元', '1', '10.00', '1', null, '10', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('1062', '2289', '228902', '30', '成吉思汗3直充30元', '1', '30.00', '1', null, '30', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('1063', '2289', '228903', '30', '成吉思汗3直充50元', '1', '50.00', '1', null, '50', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('1064', '2289', '228904', '30', '成吉思汗3直充100元', '1', '100.00', '1', null, '100', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('1065', '2291', '229101', '30', '传世群英传盛大通行证_任意充直充', '1', '1.00', '1', null, '1', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('1066', '2292', '229201', '30', '吞食天地2直充任意充', '1', '1.00', '1', null, '1', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('1067', '2293', '229301', '30', '星尘传说任意充直充', '1', '1.00', '1', null, '1', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('1068', '2294', '229401', '30', '龙之谷任意充直充', '1', '1.00', '1', null, '1', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('1069', '2295', '2204700', '30', '寻仙任意充直充', '1', '1.00', '1', null, '1', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('1070', '2295', '229503', '30', '寻仙10元直充', '1', '10.00', '1', null, '10', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('1071', '2295', '229504', '30', '寻仙30元直充', '1', '30.00', '1', null, '30', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('1072', '2295', '229507', '30', '丝路英雄10元直充', '1', '10.00', '1', null, '10', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('1073', '2295', '229508', '30', '丝路英雄30元直充', '1', '30.00', '1', null, '30', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('1074', '2295', '2205202', '30', '穿越火线任意充直充', '1', '1.00', '1', null, '1', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('1075', '2295', '229501', '30', '穿越火线10元直充', '1', '10.00', '1', null, '10', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('1076', '2295', '229502', '30', '穿越火线30元直充', '1', '30.00', '1', null, '30', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('1077', '2295', '229505', '30', 'QQ飞车1000飞车点券直充10元直充', '1', '10.00', '1', null, '10', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('1078', '2295', '229509', '30', '七雄争霸100元宝充值10元直充', '1', '10.00', '1', null, '10', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('1079', '2295', '229510', '30', 'QQ炫舞100点充值任意充直充', '1', '1.00', '1', null, '1', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('1080', '2295', '229511', '30', 'QQ飞车点券100点充值任意充直充', '1', '1.00', '1', null, '1', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('1081', '2295', '229512', '30', '战地之王AVA100点券充值任意充直充', '1', '1.00', '1', null, '1', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('1082', '2295', '229513', '30', '大明龙权点券100点充值任意充直充', '1', '1.00', '1', null, '1', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('1083', '2295', '229514', '30', '英雄联盟_LOL_充值100点任意充直充', '1', '1.00', '1', null, '1', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('1084', '2295', '229515', '30', 'QQ仙侠传点券直充100元宝任意充直充', '1', '1.00', '1', null, '1', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('1085', '2295', '229516', '30', '第九大陆_C9_点怀渲耽任意充直充', '1', '1.00', '1', null, '1', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('1086', '2295', '229517', '30', '御龙在天金子任意充直充', '1', '1.00', '1', null, '1', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('1087', '2295', '229518', '30', '轩辕传奇任意充直充', '1', '1.00', '1', null, '1', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('1088', '2295', '2241501', '30', '战争前线_100WF点任意充直充', '1', '1.00', '1', null, '1', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('1089', '2295', '2241502', '30', '战争前线_1000WF点10元直充', '1', '10.00', '1', null, '10', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('1090', '2295', '2241600', '30', '夜店之王_10金币任意充直充', '1', '1.00', '1', null, '1', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('1091', '2295', '2244200', '30', '逆战任意充直充', '1', '1.00', '1', null, '1', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('1092', '2296', '229601', '30', '功夫小子任意充直充', '1', '1.00', '1', null, '1', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('1093', '22960', null, null, '此商品暂不可用', null, null, '1', null, null, null, '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('1094', '22964', null, null, '此商品暂不可用', null, null, '1', null, null, null, '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('1095', '22968', null, null, '此商品暂不可用', null, null, '1', null, null, null, '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('1096', '2297', '229701', '30', '新热血英豪任意充直充', '1', '1.00', '1', null, '1', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('1097', '22973', null, null, '此商品暂不可用', null, null, '1', null, null, null, '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('1098', '22974', null, null, '此商品暂不可用', null, null, '1', null, null, null, '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('1099', '22975', null, null, '此商品暂不可用', null, null, '1', null, null, null, '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('1100', '22976', null, null, '此商品暂不可用', null, null, '1', null, null, null, '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('1101', '22977', null, null, '此商品暂不可用', null, null, '1', null, null, null, '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('1102', '22979', null, null, '此商品暂不可用', null, null, '1', null, null, null, '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('1103', '2298', '229801', '30', '鬼吹灯外传任意充直充', '1', '1.00', '1', null, '1', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('1104', '22980', null, null, '此商品暂不可用', null, null, '1', null, null, null, '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('1105', '22982', null, null, '此商品暂不可用', null, null, '1', null, null, null, '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('1106', '22983', null, null, '此商品暂不可用', null, null, '1', null, null, null, '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('1107', '22984', null, null, '此商品暂不可用', null, null, '1', null, null, null, '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('1108', '22985', null, null, '此商品暂不可用', null, null, '1', null, null, null, '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('1109', '22986', null, null, '此商品暂不可用', null, null, '1', null, null, null, '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('1110', '22987', null, null, '此商品暂不可用', null, null, '1', null, null, null, '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('1111', '22988', null, null, '此商品暂不可用', null, null, '1', null, null, null, '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('1112', '22989', null, null, '此商品暂不可用', null, null, '1', null, null, null, '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('1113', '2299', '229901', '30', '传奇外传任意充直充', '1', '1.00', '1', null, '1', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('1114', '22990', null, null, '此商品暂不可用', null, null, '1', null, null, null, '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('1115', '22991', null, null, '此商品暂不可用', null, null, '1', null, null, null, '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('1116', '22992', null, null, '此商品暂不可用', null, null, '1', null, null, null, '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('1117', '22993', null, null, '此商品暂不可用', null, null, '1', null, null, null, '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('1118', '22994', null, null, '此商品暂不可用', null, null, '1', null, null, null, '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('1119', '22995', null, null, '此商品暂不可用', null, null, '1', null, null, null, '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('1120', '22996', null, null, '此商品暂不可用', null, null, '1', null, null, null, '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('1121', '22997', null, null, '此商品暂不可用', null, null, '1', null, null, null, '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('1122', '22998', null, null, '此商品暂不可用', null, null, '1', null, null, null, '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('1123', '22999', null, null, '此商品暂不可用', null, null, '1', null, null, null, '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('1124', '229998', null, null, '此商品暂不可用', null, null, '1', null, null, null, '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('1125', '229999', null, null, '此商品暂不可用', null, null, '1', null, null, null, '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('1126', '2509', '2219801', '30', '同城游直充10元', '1', '10.00', '1', null, '10', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('1127', '2509', '250902', '30', '同城游直充20元', '1', '20.00', '1', null, '20', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('1128', '2509', '250903', '30', '同城游直充50元', '1', '50.00', '1', null, '50', 'a:0:{}', '1', '1');
INSERT INTO `sf_dk_game_facevalue` VALUES ('1129', '3419', null, null, '此商品暂不可用', null, null, '1', null, null, null, '1', '1');

-- ----------------------------
-- Table structure for `sf_dk_game_list`
-- ----------------------------
DROP TABLE IF EXISTS `sf_dk_game_list`;
CREATE TABLE `sf_dk_game_list` (
  `id` int(10) unsigned zerofill NOT NULL AUTO_INCREMENT,
  `cardid` int(10) unsigned zerofill NOT NULL,
  `cardimg` varchar(255) DEFAULT NULL,
  `cardname` varchar(255) NOT NULL,
  `is_show` tinyint(3) unsigned NOT NULL DEFAULT '1' COMMENT '1显示充值，2不显示',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=356 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of sf_dk_game_list
-- ----------------------------
INSERT INTO `sf_dk_game_list` VALUES ('0000000180', '0000002201', '/public/uploads/02af69182e1aa117d85d15dbce4cce51.jpg', '传奇世界', '1');
INSERT INTO `sf_dk_game_list` VALUES ('0000000181', '0000002202', null, '热血传奇直充', '1');
INSERT INTO `sf_dk_game_list` VALUES ('0000000182', '0000002203', null, '浩方对战平台直充', '1');
INSERT INTO `sf_dk_game_list` VALUES ('0000000183', '0000002204', null, '神迹直充', '1');
INSERT INTO `sf_dk_game_list` VALUES ('0000000184', '0000002205', null, '冒险岛直充', '1');
INSERT INTO `sf_dk_game_list` VALUES ('0000000185', '0000002206', null, 'Q币按元随意直充(腾讯QB) ', '1');
INSERT INTO `sf_dk_game_list` VALUES ('0000000186', '0000002207', null, '世纪天成（跑跑卡丁车/洛奇/反恐精英OL/开心星球/洛奇英雄传）直充', '1');
INSERT INTO `sf_dk_game_list` VALUES ('0000000187', '0000002208', null, '网易直充(梦幻西游/大话西游II/大话西游3/战歌/创世西游/大唐豪侠/大唐豪侠外传/大唐无双/天下贰/新飞飞/倩女幽魂/精灵牧场/宠物王国/iTown/疯狂石头/富甲西游/篮球也疯狂/泡泡游戏)(请购买时仔细区分充值游戏帐号和游戏货币！)', '1');
INSERT INTO `sf_dk_game_list` VALUES ('0000000188', '0000002209', null, '魔兽世界（战网一卡通）直充', '1');
INSERT INTO `sf_dk_game_list` VALUES ('0000000189', '0000002210', null, '完美世界直充', '1');
INSERT INTO `sf_dk_game_list` VALUES ('0000000190', '0000022100', null, '空中网充值(功夫英雄/龙/恶魔法则/侠客行/圣魔之血/坦克世界/恶魔法则3)在线充值', '1');
INSERT INTO `sf_dk_game_list` VALUES ('0000000191', '0000022101', null, '降龙之剑 直充', '1');
INSERT INTO `sf_dk_game_list` VALUES ('0000000192', '0000022102', null, '神鬼世界 直充', '1');
INSERT INTO `sf_dk_game_list` VALUES ('0000000193', '0000022103', null, '搜狐游戏直充(桃园/刀剑英雄/九鼎传说/天龙八部3/中华英雄/古域/大话水浒/剑仙/鹿鼎记)', '1');
INSERT INTO `sf_dk_game_list` VALUES ('0000000194', '0000022104', null, '梦三国 在线充值', '1');
INSERT INTO `sf_dk_game_list` VALUES ('0000000195', '0000022105', null, '远征OL 在线充值', '1');
INSERT INTO `sf_dk_game_list` VALUES ('0000000196', '0000022106', null, '百游游戏直充[天下通](新兽血沸腾/龙腾世界/倾国倾城/凡人修仙传/星战三国/百游钱包)', '1');
INSERT INTO `sf_dk_game_list` VALUES ('0000000197', '0000022107', null, '中青宝网游戏充值(抗战/天道/新战国英雄/亮剑/梦回山海/天朝/玄武)', '1');
INSERT INTO `sf_dk_game_list` VALUES ('0000000198', '0000022108', null, '悠游网游戏直充(三国群英传/风色群英传/风色幻想/牧场/精灵乐章/天使之恋/十二之天贰/黄易群侠传)', '1');
INSERT INTO `sf_dk_game_list` VALUES ('0000000199', '0000022109', null, '极光世界 充值', '1');
INSERT INTO `sf_dk_game_list` VALUES ('0000000200', '0000002211', null, '武林外传直充', '1');
INSERT INTO `sf_dk_game_list` VALUES ('0000000201', '0000022111', null, '醉逍遥 在线充值', '1');
INSERT INTO `sf_dk_game_list` VALUES ('0000000202', '0000022112', null, '完美点券直充', '1');
INSERT INTO `sf_dk_game_list` VALUES ('0000000203', '0000022113', null, '星辰变直充', '1');
INSERT INTO `sf_dk_game_list` VALUES ('0000000204', '0000022114', null, '降龙之剑极致版充值', '1');
INSERT INTO `sf_dk_game_list` VALUES ('0000000205', '0000022116', null, '倚天屠龙记充值', '1');
INSERT INTO `sf_dk_game_list` VALUES ('0000000206', '0000022117', null, '鹿鼎记直充', '1');
INSERT INTO `sf_dk_game_list` VALUES ('0000000207', '0000022119', null, '米米号(米币)在线充值(摩尔庄园/赛尔号)', '1');
INSERT INTO `sf_dk_game_list` VALUES ('0000000208', '0000002212', null, '剑侠情缘网络版II直充', '1');
INSERT INTO `sf_dk_game_list` VALUES ('0000000209', '0000022120', null, '传奇3直充(盛大)', '1');
INSERT INTO `sf_dk_game_list` VALUES ('0000000210', '0000022121', null, '泥巴一卡通（三国演义,梦幻隋唐,冰火纪元）', '1');
INSERT INTO `sf_dk_game_list` VALUES ('0000000211', '0000022122', null, '风云传奇直充', '1');
INSERT INTO `sf_dk_game_list` VALUES ('0000000212', '0000022123', null, '神雕侠侣直充', '1');
INSERT INTO `sf_dk_game_list` VALUES ('0000000213', '0000022124', null, '迅雷游戏直充', '1');
INSERT INTO `sf_dk_game_list` VALUES ('0000000214', '0000022125', null, '舞侠OL直充', '1');
INSERT INTO `sf_dk_game_list` VALUES ('0000000215', '0000022126', null, '圣斗士星矢直充', '1');
INSERT INTO `sf_dk_game_list` VALUES ('0000000216', '0000022127', null, '666玩游戏直充', '2');
INSERT INTO `sf_dk_game_list` VALUES ('0000000217', '0000022128', null, '神雕OL直冲', '1');
INSERT INTO `sf_dk_game_list` VALUES ('0000000218', '0000022129', null, '黑暗帝国直冲', '1');
INSERT INTO `sf_dk_game_list` VALUES ('0000000219', '0000002213', null, 'Q点直充(QQ游戏/QQ自由幻想/QQ音速/QQ飞车/QQ炫舞/QQ堂/QQ飞行岛/CF穿越火线/DNF地下城与勇士/寻仙/丝路英雄)', '1');
INSERT INTO `sf_dk_game_list` VALUES ('0000000220', '0000022130', null, '红途OL直冲', '1');
INSERT INTO `sf_dk_game_list` VALUES ('0000000221', '0000022131', null, '真三国直冲', '1');
INSERT INTO `sf_dk_game_list` VALUES ('0000000222', '0000022132', null, '神仙传2直冲', '1');
INSERT INTO `sf_dk_game_list` VALUES ('0000000223', '0000022133', null, '大唐2直冲', '1');
INSERT INTO `sf_dk_game_list` VALUES ('0000000224', '0000022134', null, '出发OL直冲', '1');
INSERT INTO `sf_dk_game_list` VALUES ('0000000225', '0000022135', null, '列国志直冲', '1');
INSERT INTO `sf_dk_game_list` VALUES ('0000000226', '0000022136', null, '魔方一卡通直冲', '1');
INSERT INTO `sf_dk_game_list` VALUES ('0000000227', '0000022137', null, '逍遥城直冲', '1');
INSERT INTO `sf_dk_game_list` VALUES ('0000000228', '0000022138', null, '六迪世界直冲', '1');
INSERT INTO `sf_dk_game_list` VALUES ('0000000229', '0000022139', null, '龙之幻想直冲', '1');
INSERT INTO `sf_dk_game_list` VALUES ('0000000230', '0000002214', null, '久游游戏在线直充（劲舞团/超级舞者/GT劲舞团2/大富翁Online/SD敢达Online/勇士Online/神兵传奇/流星蝴蝶剑Online/蓝海战记/魔力宝贝Ⅱ/宠物森林/仙剑Online/仙之岭）', '1');
INSERT INTO `sf_dk_game_list` VALUES ('0000000231', '0000022140', null, '诸神之战直冲', '1');
INSERT INTO `sf_dk_game_list` VALUES ('0000000232', '0000022141', null, '飞五游戏直充', '1');
INSERT INTO `sf_dk_game_list` VALUES ('0000000233', '0000022143', null, '圣王直充', '1');
INSERT INTO `sf_dk_game_list` VALUES ('0000000234', '0000022144', null, '醉逍遥直充', '1');
INSERT INTO `sf_dk_game_list` VALUES ('0000000235', '0000022145', null, '天翼决直充', '1');
INSERT INTO `sf_dk_game_list` VALUES ('0000000236', '0000022146', null, 'dota2(刀塔)', '1');
INSERT INTO `sf_dk_game_list` VALUES ('0000000237', '0000002215', null, '金山一卡通直充(金山币/春秋外传/剑侠世界/剑侠贰外传/反恐行动/剑侠情缘网络版2/剑侠情缘网络版/封神榜2/封神榜国际版/春秋Q传/封神榜网络版/仙侣奇缘2)', '1');
INSERT INTO `sf_dk_game_list` VALUES ('0000000238', '0000002216', null, '梦幻国度直充', '1');
INSERT INTO `sf_dk_game_list` VALUES ('0000000239', '0000002217', null, '泡泡堂直充', '1');
INSERT INTO `sf_dk_game_list` VALUES ('0000000240', '0000002218', null, '霸王II直充', '1');
INSERT INTO `sf_dk_game_list` VALUES ('0000000241', '0000002219', null, '武神直充', '1');
INSERT INTO `sf_dk_game_list` VALUES ('0000000242', '0000022190', null, '问道直充', '1');
INSERT INTO `sf_dk_game_list` VALUES ('0000000243', '0000002220', null, '完美世界国际版(2012)直充', '1');
INSERT INTO `sf_dk_game_list` VALUES ('0000000244', '0000002221', null, '诛仙前传按元直充', '1');
INSERT INTO `sf_dk_game_list` VALUES ('0000000245', '0000022215', null, '4399一卡通直充', '1');
INSERT INTO `sf_dk_game_list` VALUES ('0000000246', '0000002222', null, '彩虹岛直充', '1');
INSERT INTO `sf_dk_game_list` VALUES ('0000000247', '0000002223', null, 'QQ付费业务(QQ会员/黄钻/红钻/绿钻/蓝钻/紫钻/粉钻/QQ穿越火线CFvip/QQ游戏/QQ堂/QQ音速/QQ飞车/QQ炫舞紫钻包月/QQ超级会员)', '1');
INSERT INTO `sf_dk_game_list` VALUES ('0000000248', '0000002225', null, '街头篮球/拍拍部落直充', '1');
INSERT INTO `sf_dk_game_list` VALUES ('0000000249', '0000002226', null, '91游戏（魔域/魔域掉钱版/机战/开心/天元/投名状OL/英雄无敌在线/梦幻迪士尼/征服）直充', '1');
INSERT INTO `sf_dk_game_list` VALUES ('0000000250', '0000002227', null, '疯狂赛车II直充', '1');
INSERT INTO `sf_dk_game_list` VALUES ('0000000251', '0000002228', null, '热血英豪直充', '1');
INSERT INTO `sf_dk_game_list` VALUES ('0000000252', '0000002229', null, '大话水浒在线充值', '1');
INSERT INTO `sf_dk_game_list` VALUES ('0000000253', '0000002230', null, '联众币直充', '1');
INSERT INTO `sf_dk_game_list` VALUES ('0000000254', '0000002231', null, '赤壁直充', '1');
INSERT INTO `sf_dk_game_list` VALUES ('0000000255', '0000002232', null, '风云-武魂传说直充', '1');
INSERT INTO `sf_dk_game_list` VALUES ('0000000256', '0000002233', null, '苍天直充', '1');
INSERT INTO `sf_dk_game_list` VALUES ('0000000257', '0000002234', null, '超级跑跑直充', '1');
INSERT INTO `sf_dk_game_list` VALUES ('0000000258', '0000022348', null, '问道外传直充', '1');
INSERT INTO `sf_dk_game_list` VALUES ('0000000259', '0000002235', null, '新英雄年代直充', '1');
INSERT INTO `sf_dk_game_list` VALUES ('0000000260', '0000002236', null, '春秋Q传直充', '1');
INSERT INTO `sf_dk_game_list` VALUES ('0000000261', '0000002237', null, '纵横天下直充', '1');
INSERT INTO `sf_dk_game_list` VALUES ('0000000262', '0000002238', null, '热舞派对直充', '1');
INSERT INTO `sf_dk_game_list` VALUES ('0000000263', '0000002239', null, '千年3直充', '1');
INSERT INTO `sf_dk_game_list` VALUES ('0000000264', '0000002241', null, '盛大一卡通/盛大点卷（盛大通行证） 直充', '1');
INSERT INTO `sf_dk_game_list` VALUES ('0000000265', '0000022412', null, '多玩Y币直充', '1');
INSERT INTO `sf_dk_game_list` VALUES ('0000000266', '0000002242', null, '剑侠世界直充', '1');
INSERT INTO `sf_dk_game_list` VALUES ('0000000267', '0000002243', null, 'QQ三国直充', '1');
INSERT INTO `sf_dk_game_list` VALUES ('0000000268', '0000002244', null, '地下城与勇士（DNF）直充', '1');
INSERT INTO `sf_dk_game_list` VALUES ('0000000269', '0000002245', null, 'QQ华夏直充', '1');
INSERT INTO `sf_dk_game_list` VALUES ('0000000270', '0000002246', null, '口袋西游直充', '1');
INSERT INTO `sf_dk_game_list` VALUES ('0000000271', '0000002247', null, '边锋一区直充', '1');
INSERT INTO `sf_dk_game_list` VALUES ('0000000272', '0000002248', null, '星际争霸Ⅱ(SC2)直充', '1');
INSERT INTO `sf_dk_game_list` VALUES ('0000000273', '0000022488', null, '搜狐幻想神域直充', '1');
INSERT INTO `sf_dk_game_list` VALUES ('0000000274', '0000002249', null, '热血三国在线充', '1');
INSERT INTO `sf_dk_game_list` VALUES ('0000000275', '0000022493', null, '神谕之战(TERA)直充', '1');
INSERT INTO `sf_dk_game_list` VALUES ('0000000276', '0000022494', null, '昆仑一卡通直充', '1');
INSERT INTO `sf_dk_game_list` VALUES ('0000000277', '0000002250', null, '悠游一卡通直充(三国群英传/风色群英传/风色幻想/牧场/精灵乐章/天使之恋/十二之天贰/黄易群侠传)', '1');
INSERT INTO `sf_dk_game_list` VALUES ('0000000278', '0000002251', null, '巨人网络（征途/征途2/征途时间版/巨人/万王之王/我的小傻瓜/征途怀旧版/绿色征途/黄金国度/仙途/龙魂)直充', '1');
INSERT INTO `sf_dk_game_list` VALUES ('0000000279', '0000002252', null, '热血江湖直充(中华网游戏集团)', '1');
INSERT INTO `sf_dk_game_list` VALUES ('0000000280', '0000002253', null, '倚天剑与屠龙刀直充', '1');
INSERT INTO `sf_dk_game_list` VALUES ('0000000281', '0000002254', null, '中华网游戏直充(极速轮滑/东游记/指环王/热血江湖/特种部队/神泣/光之国度/星战前夜/侠义道/封神无敌/webgame)', '1');
INSERT INTO `sf_dk_game_list` VALUES ('0000000282', '0000002255', null, '91币直充(充到91通行证)', '1');
INSERT INTO `sf_dk_game_list` VALUES ('0000000283', '0000002256', null, '光宇游戏直充(问道/西游Q记/幻想之翼/神界/争霸天下/创世/希望/大冒险/炫舞吧/秦始皇)', '1');
INSERT INTO `sf_dk_game_list` VALUES ('0000000284', '0000002257', null, '魔法之门（摩力游摩豆） 直充', '1');
INSERT INTO `sf_dk_game_list` VALUES ('0000000285', '0000002258', null, '凤舞天骄直充', '1');
INSERT INTO `sf_dk_game_list` VALUES ('0000000286', '0000002259', null, '久游一卡通/久游休闲卡 直充(神兵传奇/勇士OL/GT劲舞团2/劲舞团/超级舞者/吉堂社区/SD敢达/宠物森林/仙剑OL/魔力宝贝/大富翁OL/流星蝴蝶剑/蓝海战记)', '1');
INSERT INTO `sf_dk_game_list` VALUES ('0000000287', '0000002260', null, '天龙八部3直充', '1');
INSERT INTO `sf_dk_game_list` VALUES ('0000000288', '0000002261', null, '网域一卡通(华夏前传/华夏/华夏2/华夏免费版/QQ华夏/英雄岛/九界)', '1');
INSERT INTO `sf_dk_game_list` VALUES ('0000000289', '0000002262', null, '剑舞江南直充', '1');
INSERT INTO `sf_dk_game_list` VALUES ('0000000290', '0000002263', null, '唐人游直充', '1');
INSERT INTO `sf_dk_game_list` VALUES ('0000000291', '0000002264', null, '传奇归来直充', '1');
INSERT INTO `sf_dk_game_list` VALUES ('0000000292', '0000002265', null, '迅雷雷点直充(迅雷服务/大冲锋/迅雷游戏)', '1');
INSERT INTO `sf_dk_game_list` VALUES ('0000000293', '0000002266', null, '真三国无双Online在线充', '1');
INSERT INTO `sf_dk_game_list` VALUES ('0000000294', '0000002267', null, '神魔大陆 直充', '1');
INSERT INTO `sf_dk_game_list` VALUES ('0000000295', '0000002269', null, '网易一卡通 直充', '1');
INSERT INTO `sf_dk_game_list` VALUES ('0000000296', '0000002270', null, 'VS竞技游戏平台在线充', '1');
INSERT INTO `sf_dk_game_list` VALUES ('0000000297', '0000002271', null, '烈焰飞雪在线充', '1');
INSERT INTO `sf_dk_game_list` VALUES ('0000000298', '0000002272', null, '蜗牛游戏直充（舞街区/机甲世纪/航海世纪/天子/龙战）', '1');
INSERT INTO `sf_dk_game_list` VALUES ('0000000299', '0000002274', null, '预言Online/盛世Online（暴雨游戏）直充', '1');
INSERT INTO `sf_dk_game_list` VALUES ('0000000300', '0000002275', null, '反恐行动直充', '1');
INSERT INTO `sf_dk_game_list` VALUES ('0000000301', '0000002276', null, '金酷游戏在线充值(诸侯/生肖传说/魔界/战神光辉/魔界2)', '1');
INSERT INTO `sf_dk_game_list` VALUES ('0000000302', '0000002277', null, '神鬼传奇直充', '1');
INSERT INTO `sf_dk_game_list` VALUES ('0000000303', '0000022771', null, '苹果appstore充值', '1');
INSERT INTO `sf_dk_game_list` VALUES ('0000000304', '0000002279', null, '蜀山新传online直充', '1');
INSERT INTO `sf_dk_game_list` VALUES ('0000000305', '0000002280', null, '盛大永恒之塔在线充', '1');
INSERT INTO `sf_dk_game_list` VALUES ('0000000306', '0000002281', null, '剑网2外传直充', '1');
INSERT INTO `sf_dk_game_list` VALUES ('0000000307', '0000002282', null, '5173在线充值', '1');
INSERT INTO `sf_dk_game_list` VALUES ('0000000308', '0000002283', null, '盛大剑侠世界直充', '1');
INSERT INTO `sf_dk_game_list` VALUES ('0000000309', '0000002284', null, 'FIFA OnLine2直充', '1');
INSERT INTO `sf_dk_game_list` VALUES ('0000000310', '0000002286', null, '新梦幻诛仙直充', '1');
INSERT INTO `sf_dk_game_list` VALUES ('0000000311', '0000002287', null, '蜀门Online直充', '1');
INSERT INTO `sf_dk_game_list` VALUES ('0000000312', '0000002288', null, '新剑侠情缘叁网络版/新剑网3 直充', '1');
INSERT INTO `sf_dk_game_list` VALUES ('0000000313', '0000022888', null, '其他游戏直充', '1');
INSERT INTO `sf_dk_game_list` VALUES ('0000000314', '0000002289', null, '成吉思汗2直充', '1');
INSERT INTO `sf_dk_game_list` VALUES ('0000000315', '0000002291', null, '传世群英传 直充', '1');
INSERT INTO `sf_dk_game_list` VALUES ('0000000316', '0000002292', null, '吞食天地2Online 直充', '1');
INSERT INTO `sf_dk_game_list` VALUES ('0000000317', '0000002293', null, '星尘-星空战记直充', '1');
INSERT INTO `sf_dk_game_list` VALUES ('0000000318', '0000002294', null, '龙之谷直充', '1');
INSERT INTO `sf_dk_game_list` VALUES ('0000000319', '0000002295', null, '腾讯游戏点券(穿越火线CF点/大明龙权/寻仙仙玉/QQ飞车点券/丝路英雄丝路点/七雄争霸元宝/大明龙权/QQ仙侠传/战争前线/御龙在天/第九大陆/QQ炫舞/夜店之王/英雄联盟/战争前线/战地之王)直充', '1');
INSERT INTO `sf_dk_game_list` VALUES ('0000000320', '0000002296', null, '功夫小子直充', '1');
INSERT INTO `sf_dk_game_list` VALUES ('0000000321', '0000022960', null, 'QQ业务代充(测试/限买1个)', '1');
INSERT INTO `sf_dk_game_list` VALUES ('0000000322', '0000022964', null, '波克城市直充', '1');
INSERT INTO `sf_dk_game_list` VALUES ('0000000323', '0000022968', null, '网易-可充值点数和寄售(大话西游II/梦幻西游/大话西游3/天下贰/大唐豪侠/疯狂石头/易三国)-', '1');
INSERT INTO `sf_dk_game_list` VALUES ('0000000324', '0000002297', null, '生死格斗online直充', '1');
INSERT INTO `sf_dk_game_list` VALUES ('0000000325', '0000022973', null, '暴雨(预言online/预言经典版/盛世Online/预言怀旧版/宠物小精灵/兔趴帝国)', '1');
INSERT INTO `sf_dk_game_list` VALUES ('0000000326', '0000022974', null, '中青宝网(玄武/抗战/天道/亮剑/新战国英雄/战国后传/梦回山海/天朝)', '1');
INSERT INTO `sf_dk_game_list` VALUES ('0000000327', '0000022975', null, '武神世纪（武神/神话)按元直充', '1');
INSERT INTO `sf_dk_game_list` VALUES ('0000000328', '0000022976', null, '久游网（劲舞团/超级舞者/SD敢达OL/勇士OL/GT劲舞团2/劲爆篮球/仙剑OL/魔力宝贝2/宠物森林/大富翁OL/超级乐者/神兵传奇/侠道金刚/吉堂社区)', '1');
INSERT INTO `sf_dk_game_list` VALUES ('0000000329', '0000022977', null, '悠游一卡通在线充(三国群英传/黄易群侠传/天使之恋/十二之天贰/飘邈之旅/风色幻想/精灵乐章/风色群侠传/牧场OnWeb）', '1');
INSERT INTO `sf_dk_game_list` VALUES ('0000000330', '0000022979', null, '摩力游(魔法之门/海盗王)', '1');
INSERT INTO `sf_dk_game_list` VALUES ('0000000331', '0000002298', null, '鬼吹灯外传直充', '1');
INSERT INTO `sf_dk_game_list` VALUES ('0000000332', '0000022980', null, '网域一卡通充值(英雄岛/华夏免费版/华夏online/华夏II/QQ华夏/华夏前传/网币充值', '1');
INSERT INTO `sf_dk_game_list` VALUES ('0000000333', '0000022982', null, '蜗牛(航海世纪/舞街区/天子/英雄之城/帝国文明/龙战/机甲世纪/机甲世纪革新版)', '1');
INSERT INTO `sf_dk_game_list` VALUES ('0000000334', '0000022983', null, '金酷(战神光辉/生肖传说/魔界/诸侯/英雄之城/生肖外传/魔界onweb)', '1');
INSERT INTO `sf_dk_game_list` VALUES ('0000000335', '0000022984', null, '51.com（51交友卡、51新炫舞）', '1');
INSERT INTO `sf_dk_game_list` VALUES ('0000000336', '0000022985', null, '起凡三国争霸', '1');
INSERT INTO `sf_dk_game_list` VALUES ('0000000337', '0000022986', null, '麒麟网络(成吉思汗2/梦幻聊斋)', '1');
INSERT INTO `sf_dk_game_list` VALUES ('0000000338', '0000022987', null, '金游世界', '1');
INSERT INTO `sf_dk_game_list` VALUES ('0000000339', '0000022988', null, '百度币(欧飞)', '1');
INSERT INTO `sf_dk_game_list` VALUES ('0000000340', '0000022989', null, '腾讯直充（七雄争霸/QQ飞车/绿色征途/QQ三国)', '1');
INSERT INTO `sf_dk_game_list` VALUES ('0000000341', '0000002299', null, '传奇外传直充', '1');
INSERT INTO `sf_dk_game_list` VALUES ('0000000342', '0000022990', null, '金山游戏充值(剑侠情缘2010/仙侣奇缘II)', '1');
INSERT INTO `sf_dk_game_list` VALUES ('0000000343', '0000022991', null, '盛大极光世界', '1');
INSERT INTO `sf_dk_game_list` VALUES ('0000000344', '0000022992', null, '盛大星尘-星空战记', '1');
INSERT INTO `sf_dk_game_list` VALUES ('0000000345', '0000022993', null, '盛大夺宝传世', '1');
INSERT INTO `sf_dk_game_list` VALUES ('0000000346', '0000022994', null, '盛大巨星', '1');
INSERT INTO `sf_dk_game_list` VALUES ('0000000347', '0000022995', null, '盛大星辰变', '1');
INSERT INTO `sf_dk_game_list` VALUES ('0000000348', '0000022996', null, '盛大英雄连Online', '1');
INSERT INTO `sf_dk_game_list` VALUES ('0000000349', '0000022997', null, '盛大魔界II直充', '1');
INSERT INTO `sf_dk_game_list` VALUES ('0000000350', '0000022998', null, '边锋在线充值', '1');
INSERT INTO `sf_dk_game_list` VALUES ('0000000351', '0000022999', null, '亿酷棋牌网直冲', '1');
INSERT INTO `sf_dk_game_list` VALUES ('0000000352', '0000229998', null, '中华英雄在线直充', '1');
INSERT INTO `sf_dk_game_list` VALUES ('0000000353', '0000229999', null, '剑仙在线直充', '1');
INSERT INTO `sf_dk_game_list` VALUES ('0000000354', '0000002509', null, '同城游 直充', '1');
INSERT INTO `sf_dk_game_list` VALUES ('0000000355', '0000003419', null, '起点中文网直充', '1');

-- ----------------------------
-- Table structure for `sf_dk_order`
-- ----------------------------
DROP TABLE IF EXISTS `sf_dk_order`;
CREATE TABLE `sf_dk_order` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `sporder_id` varchar(255) NOT NULL DEFAULT '' COMMENT 'dk订单号',
  `game_userid` varchar(255) NOT NULL COMMENT '充值账户',
  `user_id` int(10) unsigned NOT NULL,
  `telphone` varchar(255) NOT NULL,
  `qq` varchar(255) NOT NULL,
  `cardname` varchar(255) NOT NULL,
  `cardnum` int(10) unsigned NOT NULL,
  `cardid` int(10) unsigned NOT NULL,
  `ordercash` decimal(10,0) NOT NULL,
  `game_area` varchar(255) DEFAULT NULL,
  `game_srv` varchar(255) DEFAULT NULL,
  `game_state` varchar(255) NOT NULL,
  `time` varchar(255) NOT NULL,
  `pay_status` tinyint(4) NOT NULL COMMENT '1未支付，2已支付',
  `order_status` tinyint(4) DEFAULT NULL COMMENT '1.未退款，2已退款',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=23 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of sf_dk_order
-- ----------------------------
INSERT INTO `sf_dk_order` VALUES ('17', 'DK2017011117521428478', '123', '9', '18628970131', '52365124', '热血传奇_游戏账号_元宝_任意充直充', '50', '220208', '50', 'a:0:{}', 'a:0:{}', '0', '1484128335', '2', '2');
INSERT INTO `sf_dk_order` VALUES ('18', 'DK2017011117525661276', '123', '9', '18628970131', '52365124', '热血传奇_游戏账号_元宝_任意充直充', '50', '220208', '50', 'a:0:{}', 'a:0:{}', '0', '1484128377', '2', '1');
INSERT INTO `sf_dk_order` VALUES ('19', 'DK2017011117533185439', 'asd', '9', '18628970131', '52365124', '热血传奇_游戏账号_元宝_任意充直充', '200', '220208', '200', 'a:0:{}', 'a:0:{}', '0', '1484128412', '2', '1');
INSERT INTO `sf_dk_order` VALUES ('20', 'DK2017011117561199970', '123', '9', '18628970131', '52365124', '热血传奇_游戏账号_元宝_任意充直充', '30', '220208', '30', 'a:0:{}', 'a:0:{}', '0', '1484128571', '2', '1');
INSERT INTO `sf_dk_order` VALUES ('21', 'DK2017011810470499277', 'asdasd', '9', '18628970131', '52365124', '神迹_充元宝_盛大通行证任意充直充', '1', '220404', '1', 'a:0:{}', 'a:0:{}', '0', '1484707625', '2', '1');
INSERT INTO `sf_dk_order` VALUES ('22', 'DK2017011812031818301', 'asddsa', '9', '18628970131', '52365124', '神迹_充元宝_盛大通行证任意充直充', '100', '220404', '100', 'a:0:{}', 'a:0:{}', '0', '1484712198', '2', '1');

-- ----------------------------
-- Table structure for `sf_exchange`
-- ----------------------------
DROP TABLE IF EXISTS `sf_exchange`;
CREATE TABLE `sf_exchange` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `goods_name` varchar(255) NOT NULL COMMENT '商品名称',
  `integral` int(10) unsigned NOT NULL COMMENT '所需积分',
  `stock` int(10) unsigned NOT NULL COMMENT '库存',
  `max_exchange` int(10) unsigned NOT NULL COMMENT '单人最大兑换数量',
  `pic` varchar(255) NOT NULL COMMENT '商品图片',
  `content` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 COMMENT='积分商品';

-- ----------------------------
-- Records of sf_exchange
-- ----------------------------
INSERT INTO `sf_exchange` VALUES ('1', '300卖家成长值', '3000', '998', '5', '/public/uploads/922672ec36cb3e045037786a74894a09.png', '<p style=\"outline: none; margin-top: 10px; margin-bottom: 10px; padding: 0px; color: rgb(51, 51, 51); font-family: &quot;Microsoft YaHei&quot;; font-size: 14px; white-space: normal; background-color: rgb(255, 255, 255);\"><span style=\"outline: none; font-weight: 800;\"><span style=\"outline: none; margin: 0px; padding: 0px; font-family: 微软雅黑, &quot;Microsoft YaHei&quot;; font-size: 18px; color: rgb(0, 112, 192);\">商品介绍</span></span></p><p style=\"outline: none; margin-top: 10px; margin-bottom: 10px; padding: 0px; color: rgb(51, 51, 51); font-family: &quot;Microsoft YaHei&quot;; font-size: 14px; white-space: normal; background-color: rgb(255, 255, 255);\"><span style=\"outline: none; margin: 0px; padding: 0px; font-size: 12px; font-family: 微软雅黑, &quot;Microsoft YaHei&quot;;\">1. 商品名称：</span><span style=\"outline: none; margin: 0px; padding: 0px; font-family: 微软雅黑, &quot;Microsoft YaHei&quot;; font-size: 12px;\">成长值300点</span></p><p style=\"outline: none; margin-top: 10px; margin-bottom: 10px; padding: 0px; color: rgb(51, 51, 51); font-family: &quot;Microsoft YaHei&quot;; font-size: 14px; white-space: normal; background-color: rgb(255, 255, 255);\"><span style=\"outline: none; margin: 0px; padding: 0px; font-size: 12px; font-family: 微软雅黑, &quot;Microsoft YaHei&quot;;\">2. 增加卖家成长值：+300</span></p><p style=\"outline: none; margin-top: 10px; margin-bottom: 10px; padding: 0px; color: rgb(51, 51, 51); font-family: &quot;Microsoft YaHei&quot;; font-size: 14px; white-space: normal; background-color: rgb(255, 255, 255);\"><span style=\"outline: none; font-weight: 800;\"><span style=\"outline: none; margin: 0px; padding: 0px; color: rgb(0, 112, 192); font-size: 18px; font-family: 微软雅黑, &quot;Microsoft YaHei&quot;;\">使用说明</span></span></p><p style=\"outline: none; margin-top: 10px; margin-bottom: 10px; padding: 0px; color: rgb(51, 51, 51); font-family: &quot;Microsoft YaHei&quot;; font-size: 14px; white-space: normal; background-color: rgb(255, 255, 255);\"><span style=\"outline: none; margin: 0px; padding: 0px; font-size: 12px; font-family: 微软雅黑, &quot;Microsoft YaHei&quot;;\">1. 积分兑换成长值不受成长值上限影响。</span></p><p style=\"outline: none; margin-top: 10px; margin-bottom: 10px; padding: 0px; color: rgb(51, 51, 51); font-family: &quot;Microsoft YaHei&quot;; font-size: 14px; white-space: normal; background-color: rgb(255, 255, 255);\"><span style=\"outline: none; margin: 0px; padding: 0px; font-size: 12px; font-family: 微软雅黑, &quot;Microsoft YaHei&quot;;\">2. 成长值兑换需要客服操作，请耐心等待处理结果。</span></p><p><br/></p>');
INSERT INTO `sf_exchange` VALUES ('2', '10QB', '10000', '100', '10', '/public/uploads/4a5fea7abe368d02513c3b56a3d3c000.jpg', '<p style=\"outline: none; margin-top: 10px; margin-bottom: 10px; padding: 0px; color: rgb(51, 51, 51); font-family: &quot;Microsoft YaHei&quot;; font-size: 14px; white-space: normal; background-color: rgb(255, 255, 255);\"><span style=\"outline: none; margin: 0px; padding: 0px; color: rgb(0, 112, 192); font-size: 18px;\"><span style=\"outline: none; font-weight: 800;\"><span style=\"outline: none; margin: 0px; padding: 0px; font-family: 微软雅黑, &quot;Microsoft YaHei&quot;;\">商品介绍</span></span></span></p><p style=\"outline: none; margin-top: 10px; margin-bottom: 10px; padding: 0px; color: rgb(51, 51, 51); font-family: &quot;Microsoft YaHei&quot;; font-size: 14px; white-space: normal; background-color: rgb(255, 255, 255);\"><span style=\"outline: none; margin: 0px; padding: 0px; font-family: 微软雅黑, &quot;Microsoft YaHei&quot;; font-size: 12px;\">1. 商品名称：腾讯Q币10元</span></p><p style=\"outline: none; margin-top: 10px; margin-bottom: 10px; padding: 0px; color: rgb(51, 51, 51); font-family: &quot;Microsoft YaHei&quot;; font-size: 14px; white-space: normal; background-color: rgb(255, 255, 255);\"><span style=\"outline: none; margin: 0px; padding: 0px; font-family: 微软雅黑, &quot;Microsoft YaHei&quot;; font-size: 12px;\">2. 面值：10元</span></p><p style=\"outline: none; margin-top: 10px; margin-bottom: 10px; padding: 0px; color: rgb(51, 51, 51); font-family: &quot;Microsoft YaHei&quot;; font-size: 14px; white-space: normal; background-color: rgb(255, 255, 255);\"><span style=\"outline: none; margin: 0px; padding: 0px; color: rgb(0, 112, 192); font-family: 微软雅黑, &quot;Microsoft YaHei&quot;;\"><span style=\"outline: none; margin: 0px; padding: 0px; font-size: 18px;\"><span style=\"outline: none; font-weight: 800;\">注意事项</span></span></span></p><p style=\"outline: none; margin-top: 10px; margin-bottom: 10px; padding: 0px; color: rgb(51, 51, 51); font-family: &quot;Microsoft YaHei&quot;; font-size: 14px; white-space: normal; background-color: rgb(255, 255, 255);\"><span style=\"outline: none; margin: 0px; padding: 0px; font-family: 微软雅黑, &quot;Microsoft YaHei&quot;; font-size: 12px;\">1. Q币系统自动充值到腾讯Q币账户余额中。</span></p><p style=\"outline: none; margin-top: 10px; margin-bottom: 10px; padding: 0px; color: rgb(51, 51, 51); font-family: &quot;Microsoft YaHei&quot;; font-size: 14px; white-space: normal; background-color: rgb(255, 255, 255);\"><span style=\"outline: none; margin: 0px; padding: 0px; font-family: 微软雅黑, &quot;Microsoft YaHei&quot;; font-size: 12px;\">2. 请仔细检查您要充值的QQ号码，输入QQ号码错误导致误充，责任用户自己承担。<br/></span></p><p style=\"outline: none; margin-top: 10px; margin-bottom: 10px; padding: 0px; color: rgb(51, 51, 51); font-family: &quot;Microsoft YaHei&quot;; font-size: 14px; white-space: normal; background-color: rgb(255, 255, 255);\"><span style=\"outline: none; margin: 0px; padding: 0px; font-family: 微软雅黑, &quot;Microsoft YaHei&quot;; font-size: 12px;\">3. 如遇特殊原因导致充值失败，系统会自动退还所用积分。</span></p><p><br/></p>');
INSERT INTO `sf_exchange` VALUES ('3', '20QB', '19000', '100', '10', '/public/uploads/bbf981ac427ae96474a86f3271e61f29.jpg', '<p style=\"outline: none; margin-top: 10px; margin-bottom: 10px; padding: 0px; color: rgb(51, 51, 51); font-family: &quot;Microsoft YaHei&quot;; font-size: 14px; white-space: normal; background-color: rgb(255, 255, 255);\"><span style=\"outline: none; margin: 0px; padding: 0px; color: rgb(0, 112, 192); font-size: 18px;\"><span style=\"outline: none; font-weight: 800;\"><span style=\"outline: none; margin: 0px; padding: 0px; font-family: 微软雅黑, &quot;Microsoft YaHei&quot;;\">商品介绍</span></span></span></p><p style=\"outline: none; margin-top: 10px; margin-bottom: 10px; padding: 0px; color: rgb(51, 51, 51); font-family: &quot;Microsoft YaHei&quot;; font-size: 14px; white-space: normal; background-color: rgb(255, 255, 255);\"><span style=\"outline: none; margin: 0px; padding: 0px; font-family: 微软雅黑, &quot;Microsoft YaHei&quot;; font-size: 12px;\">1. 商品名称：腾讯Q币20元</span></p><p style=\"outline: none; margin-top: 10px; margin-bottom: 10px; padding: 0px; color: rgb(51, 51, 51); font-family: &quot;Microsoft YaHei&quot;; font-size: 14px; white-space: normal; background-color: rgb(255, 255, 255);\"><span style=\"outline: none; margin: 0px; padding: 0px; font-family: 微软雅黑, &quot;Microsoft YaHei&quot;; font-size: 12px;\">2. 面值：20元</span></p><p style=\"outline: none; margin-top: 10px; margin-bottom: 10px; padding: 0px; color: rgb(51, 51, 51); font-family: &quot;Microsoft YaHei&quot;; font-size: 14px; white-space: normal; background-color: rgb(255, 255, 255);\"><span style=\"outline: none; margin: 0px; padding: 0px; color: rgb(0, 112, 192); font-family: 微软雅黑, &quot;Microsoft YaHei&quot;;\"><span style=\"outline: none; margin: 0px; padding: 0px; font-size: 18px;\"><span style=\"outline: none; font-weight: 800;\">注意事项</span></span></span></p><p style=\"outline: none; margin-top: 10px; margin-bottom: 10px; padding: 0px; color: rgb(51, 51, 51); font-family: &quot;Microsoft YaHei&quot;; font-size: 14px; white-space: normal; background-color: rgb(255, 255, 255);\"><span style=\"outline: none; margin: 0px; padding: 0px; font-family: 微软雅黑, &quot;Microsoft YaHei&quot;; font-size: 12px;\">1. Q币系统自动充值到腾讯Q币账户余额中。</span></p><p style=\"outline: none; margin-top: 10px; margin-bottom: 10px; padding: 0px; color: rgb(51, 51, 51); font-family: &quot;Microsoft YaHei&quot;; font-size: 14px; white-space: normal; background-color: rgb(255, 255, 255);\"><span style=\"outline: none; margin: 0px; padding: 0px; font-family: 微软雅黑, &quot;Microsoft YaHei&quot;; font-size: 12px;\">2. 请仔细检查您要充值的QQ号码，输入QQ号码错误导致误充，责任用户自己承担。<br/></span></p><p style=\"outline: none; margin-top: 10px; margin-bottom: 10px; padding: 0px; color: rgb(51, 51, 51); font-family: &quot;Microsoft YaHei&quot;; font-size: 14px; white-space: normal; background-color: rgb(255, 255, 255);\"><span style=\"outline: none; margin: 0px; padding: 0px; font-family: 微软雅黑, &quot;Microsoft YaHei&quot;; font-size: 12px;\">3. 如遇特殊原因导致充值失败，系统会自动退还所用积分。</span></p><p><br/></p>');
INSERT INTO `sf_exchange` VALUES ('4', '30QB', '28000', '100', '10', '/public/uploads/f81fa52584243297f49e95a3502934fd.jpg', '<p style=\"outline: none; margin-top: 10px; margin-bottom: 10px; padding: 0px; color: rgb(51, 51, 51); font-family: &quot;Microsoft YaHei&quot;; font-size: 14px; white-space: normal; background-color: rgb(255, 255, 255);\"><span style=\"outline: none; margin: 0px; padding: 0px; color: rgb(0, 112, 192); font-size: 18px;\"><span style=\"outline: none; font-weight: 800;\"><span style=\"outline: none; margin: 0px; padding: 0px; font-family: 微软雅黑, &quot;Microsoft YaHei&quot;;\">商品介绍</span></span></span></p><p style=\"outline: none; margin-top: 10px; margin-bottom: 10px; padding: 0px; color: rgb(51, 51, 51); font-family: &quot;Microsoft YaHei&quot;; font-size: 14px; white-space: normal; background-color: rgb(255, 255, 255);\"><span style=\"outline: none; margin: 0px; padding: 0px; font-family: 微软雅黑, &quot;Microsoft YaHei&quot;; font-size: 12px;\">1. 商品名称：腾讯Q币30元</span></p><p style=\"outline: none; margin-top: 10px; margin-bottom: 10px; padding: 0px; color: rgb(51, 51, 51); font-family: &quot;Microsoft YaHei&quot;; font-size: 14px; white-space: normal; background-color: rgb(255, 255, 255);\"><span style=\"outline: none; margin: 0px; padding: 0px; font-family: 微软雅黑, &quot;Microsoft YaHei&quot;; font-size: 12px;\">2. 面值：30元</span></p><p style=\"outline: none; margin-top: 10px; margin-bottom: 10px; padding: 0px; color: rgb(51, 51, 51); font-family: &quot;Microsoft YaHei&quot;; font-size: 14px; white-space: normal; background-color: rgb(255, 255, 255);\"><span style=\"outline: none; margin: 0px; padding: 0px; color: rgb(0, 112, 192); font-family: 微软雅黑, &quot;Microsoft YaHei&quot;;\"><span style=\"outline: none; margin: 0px; padding: 0px; font-size: 18px;\"><span style=\"outline: none; font-weight: 800;\">注意事项</span></span></span></p><p style=\"outline: none; margin-top: 10px; margin-bottom: 10px; padding: 0px; color: rgb(51, 51, 51); font-family: &quot;Microsoft YaHei&quot;; font-size: 14px; white-space: normal; background-color: rgb(255, 255, 255);\"><span style=\"outline: none; margin: 0px; padding: 0px; font-family: 微软雅黑, &quot;Microsoft YaHei&quot;; font-size: 12px;\">1. Q币系统自动充值到腾讯Q币账户余额中。</span></p><p style=\"outline: none; margin-top: 10px; margin-bottom: 10px; padding: 0px; color: rgb(51, 51, 51); font-family: &quot;Microsoft YaHei&quot;; font-size: 14px; white-space: normal; background-color: rgb(255, 255, 255);\"><span style=\"outline: none; margin: 0px; padding: 0px; font-family: 微软雅黑, &quot;Microsoft YaHei&quot;; font-size: 12px;\">2. 请仔细检查您要充值的QQ号码，输入QQ号码错误导致误充，责任用户自己承担。<br/></span></p><p style=\"outline: none; margin-top: 10px; margin-bottom: 10px; padding: 0px; color: rgb(51, 51, 51); font-family: &quot;Microsoft YaHei&quot;; font-size: 14px; white-space: normal; background-color: rgb(255, 255, 255);\"><span style=\"outline: none; margin: 0px; padding: 0px; font-family: 微软雅黑, &quot;Microsoft YaHei&quot;; font-size: 12px;\">3. 如遇特殊原因导致充值失败，系统会自动退还所用积分。</span></p><p><br/></p>');
INSERT INTO `sf_exchange` VALUES ('5', '40QB', '37000', '100', '10', '/public/uploads/7aef4a9e55c8adaefdc38f1077f5ef05.jpg', '<p style=\"outline: none; margin-top: 10px; margin-bottom: 10px; padding: 0px; color: rgb(51, 51, 51); font-family: &quot;Microsoft YaHei&quot;; font-size: 14px; white-space: normal; background-color: rgb(255, 255, 255);\"><span style=\"outline: none; margin: 0px; padding: 0px; color: rgb(0, 112, 192); font-size: 18px;\"><span style=\"outline: none; font-weight: 800;\"><span style=\"outline: none; margin: 0px; padding: 0px; font-family: 微软雅黑, &quot;Microsoft YaHei&quot;;\">商品介绍</span></span></span></p><p style=\"outline: none; margin-top: 10px; margin-bottom: 10px; padding: 0px; color: rgb(51, 51, 51); font-family: &quot;Microsoft YaHei&quot;; font-size: 14px; white-space: normal; background-color: rgb(255, 255, 255);\"><span style=\"outline: none; margin: 0px; padding: 0px; font-family: 微软雅黑, &quot;Microsoft YaHei&quot;; font-size: 12px;\">1. 商品名称：腾讯Q币40元</span></p><p style=\"outline: none; margin-top: 10px; margin-bottom: 10px; padding: 0px; color: rgb(51, 51, 51); font-family: &quot;Microsoft YaHei&quot;; font-size: 14px; white-space: normal; background-color: rgb(255, 255, 255);\"><span style=\"outline: none; margin: 0px; padding: 0px; font-family: 微软雅黑, &quot;Microsoft YaHei&quot;; font-size: 12px;\">2. 面值：40元</span></p><p style=\"outline: none; margin-top: 10px; margin-bottom: 10px; padding: 0px; color: rgb(51, 51, 51); font-family: &quot;Microsoft YaHei&quot;; font-size: 14px; white-space: normal; background-color: rgb(255, 255, 255);\"><span style=\"outline: none; margin: 0px; padding: 0px; color: rgb(0, 112, 192); font-family: 微软雅黑, &quot;Microsoft YaHei&quot;;\"><span style=\"outline: none; margin: 0px; padding: 0px; font-size: 18px;\"><span style=\"outline: none; font-weight: 800;\">注意事项</span></span></span></p><p style=\"outline: none; margin-top: 10px; margin-bottom: 10px; padding: 0px; color: rgb(51, 51, 51); font-family: &quot;Microsoft YaHei&quot;; font-size: 14px; white-space: normal; background-color: rgb(255, 255, 255);\"><span style=\"outline: none; margin: 0px; padding: 0px; font-family: 微软雅黑, &quot;Microsoft YaHei&quot;; font-size: 12px;\">1. Q币系统自动充值到腾讯Q币账户余额中。</span></p><p style=\"outline: none; margin-top: 10px; margin-bottom: 10px; padding: 0px; color: rgb(51, 51, 51); font-family: &quot;Microsoft YaHei&quot;; font-size: 14px; white-space: normal; background-color: rgb(255, 255, 255);\"><span style=\"outline: none; margin: 0px; padding: 0px; font-family: 微软雅黑, &quot;Microsoft YaHei&quot;; font-size: 12px;\">2. 请仔细检查您要充值的QQ号码，输入QQ号码错误导致误充，责任用户自己承担。<br/></span></p><p style=\"outline: none; margin-top: 10px; margin-bottom: 10px; padding: 0px; color: rgb(51, 51, 51); font-family: &quot;Microsoft YaHei&quot;; font-size: 14px; white-space: normal; background-color: rgb(255, 255, 255);\"><span style=\"outline: none; margin: 0px; padding: 0px; font-family: 微软雅黑, &quot;Microsoft YaHei&quot;; font-size: 12px;\">3. 如遇特殊原因导致充值失败，系统会自动退还所用积分。</span></p><p><br/></p>');
INSERT INTO `sf_exchange` VALUES ('6', '50QB', '46000', '50', '10', '/public/uploads/4a8fb51f8a82ae935d6f464d80ace315.jpg', '<p style=\"outline: none; margin-top: 10px; margin-bottom: 10px; padding: 0px; color: rgb(51, 51, 51); font-family: &quot;Microsoft YaHei&quot;; font-size: 14px; white-space: normal; background-color: rgb(255, 255, 255);\"><span style=\"outline: none; margin: 0px; padding: 0px; color: rgb(0, 112, 192); font-size: 18px;\"><span style=\"outline: none; font-weight: 800;\"><span style=\"outline: none; margin: 0px; padding: 0px; font-family: 微软雅黑, &quot;Microsoft YaHei&quot;;\">商品介绍</span></span></span></p><p style=\"outline: none; margin-top: 10px; margin-bottom: 10px; padding: 0px; color: rgb(51, 51, 51); font-family: &quot;Microsoft YaHei&quot;; font-size: 14px; white-space: normal; background-color: rgb(255, 255, 255);\"><span style=\"outline: none; margin: 0px; padding: 0px; font-family: 微软雅黑, &quot;Microsoft YaHei&quot;; font-size: 12px;\">1. 商品名称：腾讯Q币50元</span></p><p style=\"outline: none; margin-top: 10px; margin-bottom: 10px; padding: 0px; color: rgb(51, 51, 51); font-family: &quot;Microsoft YaHei&quot;; font-size: 14px; white-space: normal; background-color: rgb(255, 255, 255);\"><span style=\"outline: none; margin: 0px; padding: 0px; font-family: 微软雅黑, &quot;Microsoft YaHei&quot;; font-size: 12px;\">2. 面值：50元</span></p><p style=\"outline: none; margin-top: 10px; margin-bottom: 10px; padding: 0px; color: rgb(51, 51, 51); font-family: &quot;Microsoft YaHei&quot;; font-size: 14px; white-space: normal; background-color: rgb(255, 255, 255);\"><span style=\"outline: none; margin: 0px; padding: 0px; color: rgb(0, 112, 192); font-family: 微软雅黑, &quot;Microsoft YaHei&quot;;\"><span style=\"outline: none; margin: 0px; padding: 0px; font-size: 18px;\"><span style=\"outline: none; font-weight: 800;\">注意事项</span></span></span></p><p style=\"outline: none; margin-top: 10px; margin-bottom: 10px; padding: 0px; color: rgb(51, 51, 51); font-family: &quot;Microsoft YaHei&quot;; font-size: 14px; white-space: normal; background-color: rgb(255, 255, 255);\"><span style=\"outline: none; margin: 0px; padding: 0px; font-family: 微软雅黑, &quot;Microsoft YaHei&quot;; font-size: 12px;\">1. Q币系统自动充值到腾讯Q币账户余额中。</span></p><p style=\"outline: none; margin-top: 10px; margin-bottom: 10px; padding: 0px; color: rgb(51, 51, 51); font-family: &quot;Microsoft YaHei&quot;; font-size: 14px; white-space: normal; background-color: rgb(255, 255, 255);\"><span style=\"outline: none; margin: 0px; padding: 0px; font-family: 微软雅黑, &quot;Microsoft YaHei&quot;; font-size: 12px;\">2. 请仔细检查您要充值的QQ号码，输入QQ号码错误导致误充，责任用户自己承担。<br/></span></p><p style=\"outline: none; margin-top: 10px; margin-bottom: 10px; padding: 0px; color: rgb(51, 51, 51); font-family: &quot;Microsoft YaHei&quot;; font-size: 14px; white-space: normal; background-color: rgb(255, 255, 255);\"><span style=\"outline: none; margin: 0px; padding: 0px; font-family: 微软雅黑, &quot;Microsoft YaHei&quot;; font-size: 12px;\">3. 如遇特殊原因导致充值失败，系统会自动退还所用积分。</span></p><p><br/></p>');
INSERT INTO `sf_exchange` VALUES ('7', '100QB', '900000', '100', '10', '/public/uploads/0edcf03696d5ad987fb3eb0deda4c0e7.jpg', '<p style=\"outline: none; margin-top: 10px; margin-bottom: 10px; padding: 0px; color: rgb(51, 51, 51); font-family: &quot;Microsoft YaHei&quot;; font-size: 14px; white-space: normal; background-color: rgb(255, 255, 255);\"><span style=\"outline: none; margin: 0px; padding: 0px; color: rgb(0, 112, 192); font-size: 18px;\"><span style=\"outline: none; font-weight: 800;\"><span style=\"outline: none; margin: 0px; padding: 0px; font-family: 微软雅黑, &quot;Microsoft YaHei&quot;;\">商品介绍</span></span></span></p><p style=\"outline: none; margin-top: 10px; margin-bottom: 10px; padding: 0px; color: rgb(51, 51, 51); font-family: &quot;Microsoft YaHei&quot;; font-size: 14px; white-space: normal; background-color: rgb(255, 255, 255);\"><span style=\"outline: none; margin: 0px; padding: 0px; font-family: 微软雅黑, &quot;Microsoft YaHei&quot;; font-size: 12px;\">1. 商品名称：腾讯Q币100元</span></p><p style=\"outline: none; margin-top: 10px; margin-bottom: 10px; padding: 0px; color: rgb(51, 51, 51); font-family: &quot;Microsoft YaHei&quot;; font-size: 14px; white-space: normal; background-color: rgb(255, 255, 255);\"><span style=\"outline: none; margin: 0px; padding: 0px; font-family: 微软雅黑, &quot;Microsoft YaHei&quot;; font-size: 12px;\">2. 面值：100元</span></p><p style=\"outline: none; margin-top: 10px; margin-bottom: 10px; padding: 0px; color: rgb(51, 51, 51); font-family: &quot;Microsoft YaHei&quot;; font-size: 14px; white-space: normal; background-color: rgb(255, 255, 255);\"><span style=\"outline: none; margin: 0px; padding: 0px; color: rgb(0, 112, 192); font-family: 微软雅黑, &quot;Microsoft YaHei&quot;;\"><span style=\"outline: none; margin: 0px; padding: 0px; font-size: 18px;\"><span style=\"outline: none; font-weight: 800;\">注意事项</span></span></span></p><p style=\"outline: none; margin-top: 10px; margin-bottom: 10px; padding: 0px; color: rgb(51, 51, 51); font-family: &quot;Microsoft YaHei&quot;; font-size: 14px; white-space: normal; background-color: rgb(255, 255, 255);\"><span style=\"outline: none; margin: 0px; padding: 0px; font-family: 微软雅黑, &quot;Microsoft YaHei&quot;; font-size: 12px;\">1. Q币系统自动充值到腾讯Q币账户余额中。</span></p><p style=\"outline: none; margin-top: 10px; margin-bottom: 10px; padding: 0px; color: rgb(51, 51, 51); font-family: &quot;Microsoft YaHei&quot;; font-size: 14px; white-space: normal; background-color: rgb(255, 255, 255);\"><span style=\"outline: none; margin: 0px; padding: 0px; font-family: 微软雅黑, &quot;Microsoft YaHei&quot;; font-size: 12px;\">2. 请仔细检查您要充值的QQ号码，输入QQ号码错误导致误充，责任用户自己承担。<br/></span></p><p style=\"outline: none; margin-top: 10px; margin-bottom: 10px; padding: 0px; color: rgb(51, 51, 51); font-family: &quot;Microsoft YaHei&quot;; font-size: 14px; white-space: normal; background-color: rgb(255, 255, 255);\"><span style=\"outline: none; margin: 0px; padding: 0px; font-family: 微软雅黑, &quot;Microsoft YaHei&quot;; font-size: 12px;\">3. 如遇特殊原因导致充值失败，系统会自动退还所用积分。</span></p><p><br/></p>');
INSERT INTO `sf_exchange` VALUES ('8', '地下城游戏币100W', '1000000', '1000', '10', '/public/uploads/0cb1dcad88b1aae7c1dbba3860bd0141.jpg', '<p style=\"outline: none; margin-top: 10px; margin-bottom: 10px; padding: 0px; color: rgb(51, 51, 51); font-family: &quot;Microsoft YaHei&quot;; font-size: 14px; white-space: normal; background-color: rgb(255, 255, 255);\"><span style=\"outline: none; margin: 0px; padding: 0px; font-size: 18px; color: rgb(0, 112, 192);\"><span style=\"outline: none; font-weight: 800;\"><span style=\"outline: none; margin: 0px; padding: 0px; font-family: 微软雅黑, &quot;Microsoft YaHei&quot;;\">商品介绍</span></span></span></p><p style=\"outline: none; margin-top: 10px; margin-bottom: 10px; padding: 0px; color: rgb(51, 51, 51); font-family: &quot;Microsoft YaHei&quot;; font-size: 14px; white-space: normal; background-color: rgb(255, 255, 255);\"><span style=\"outline: none; margin: 0px; padding: 0px; font-family: 微软雅黑, &quot;Microsoft YaHei&quot;; font-size: 12px;\">1. 商品名称：地下城游戏币100W</span></p><p style=\"outline: none; margin-top: 10px; margin-bottom: 10px; padding: 0px; color: rgb(51, 51, 51); font-family: &quot;Microsoft YaHei&quot;; font-size: 14px; white-space: normal; background-color: rgb(255, 255, 255);\"><span style=\"outline: none; margin: 0px; padding: 0px; font-family: 微软雅黑, &quot;Microsoft YaHei&quot;; font-size: 12px;\"><span style=\"outline: none; font-weight: 800; font-size: 18px; color: rgb(0, 112, 192);\">注意事项</span></span></p><p style=\"outline: none; margin-top: 10px; margin-bottom: 10px; padding: 0px; color: rgb(51, 51, 51); font-family: &quot;Microsoft YaHei&quot;; font-size: 14px; white-space: normal; background-color: rgb(255, 255, 255);\"><span style=\"outline: none; margin: 0px; padding: 0px; font-family: 微软雅黑, &quot;Microsoft YaHei&quot;;\"><span style=\"outline: none; margin: 0px; padding: 0px; font-size: 12px;\">1. 由于商品特殊原因，该商品不保证长期一定有货。</span></span></p><p style=\"outline: none; margin-top: 10px; margin-bottom: 10px; padding: 0px; color: rgb(51, 51, 51); font-family: &quot;Microsoft YaHei&quot;; font-size: 14px; white-space: normal; background-color: rgb(255, 255, 255);\"><span style=\"outline: none; margin: 0px; padding: 0px; font-family: 微软雅黑, &quot;Microsoft YaHei&quot;;\"><span style=\"outline: none; margin: 0px; padding: 0px; font-size: 12px;\">2.&nbsp;请仔细检查您的收货角色及区服，填错导致错发，责任用户自行承担。</span></span></p><p style=\"outline: none; margin-top: 10px; margin-bottom: 10px; padding: 0px; color: rgb(51, 51, 51); font-family: &quot;Microsoft YaHei&quot;; font-size: 14px; white-space: normal; background-color: rgb(255, 255, 255);\"><span style=\"outline: none; margin: 0px; padding: 0px; font-family: 微软雅黑, &quot;Microsoft YaHei&quot;;\"><span style=\"outline: none; margin: 0px; padding: 0px; font-size: 12px;\">3. 如遇特殊原因取消或交易失败，退还该商品所用积分。</span></span></p><p><br/></p>');

-- ----------------------------
-- Table structure for `sf_exchange_order`
-- ----------------------------
DROP TABLE IF EXISTS `sf_exchange_order`;
CREATE TABLE `sf_exchange_order` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `goods_id` int(10) unsigned NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `integral` int(10) unsigned NOT NULL,
  `num` int(10) unsigned NOT NULL,
  `order_integral` int(11) NOT NULL,
  `create_time` varchar(255) NOT NULL,
  `order_status` tinyint(3) unsigned NOT NULL DEFAULT '1' COMMENT '1未处理，2处理完成，3取消',
  `order_code` varchar(255) NOT NULL,
  `user_info` text NOT NULL,
  `tel` varchar(255) NOT NULL,
  `qq` varchar(255) NOT NULL,
  `note` varchar(255) DEFAULT NULL,
  `note_time` varchar(255) DEFAULT NULL,
  `action_user_name` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COMMENT='积分兑换订单';

-- ----------------------------
-- Records of sf_exchange_order
-- ----------------------------
INSERT INTO `sf_exchange_order` VALUES ('3', '1', '2', '3000', '1', '3000', '1479113754', '3', 'DH2016111416554148037', '', '18562547211', '69852365', '无货了，退您积分', '1479177029', 'admin');

-- ----------------------------
-- Table structure for `sf_game`
-- ----------------------------
DROP TABLE IF EXISTS `sf_game`;
CREATE TABLE `sf_game` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `game_name` varchar(255) NOT NULL DEFAULT '' COMMENT '游戏名',
  `game_desc` tinytext NOT NULL COMMENT '游戏描述',
  `game_order` int(10) unsigned NOT NULL DEFAULT '0',
  `cate_id` int(10) unsigned NOT NULL COMMENT '关联游戏分类id',
  `display_name` varchar(255) NOT NULL DEFAULT '' COMMENT '拼音',
  `thumb` varchar(255) NOT NULL DEFAULT '' COMMENT '缩略图',
  `is_recommend` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '0不推荐，1推荐',
  `is_hot` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '0不热门，1热门',
  `is_free` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '0不是免费游戏，1是免费游戏',
  `is_keyword` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '是否为首页热门关键词',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=52 DEFAULT CHARSET=utf8 COMMENT='游戏表';

-- ----------------------------
-- Records of sf_game
-- ----------------------------
INSERT INTO `sf_game` VALUES ('22', '地下城与勇士', '地下城与勇士11111', '0', '1', 'dxcyys', '/public/uploads/14c95b76f56b97b7668e6dd0132555cb.jpg', '1', '1', '1', '1', '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `sf_game` VALUES ('23', '天下3', '天下', '0', '1', 'tx3', '/public/uploads/f36133de7518c15064c7f4994c8ebf2b.jpg', '1', '1', '1', '1', '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `sf_game` VALUES ('24', '剑灵', '剑灵是一个游戏', '2', '1', 'jl', '/public/uploads/6ba846d6bd554b69415487507b38f5ea.jpg', '1', '1', '1', '1', '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `sf_game` VALUES ('25', '斗战神', '斗战神斗战神', '0', '1', 'dzs', '/public/uploads/33f28926710f93919713e29899fdb6ee.jpg', '1', '1', '1', '1', '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `sf_game` VALUES ('35', '传奇永恒', '传奇永恒传奇永恒', '2', '1', 'chuanqiyongheng', '/public/uploads/42bab84926dea2a7bebe9ed8069fad2d.jpg', '0', '1', '1', '1', '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `sf_game` VALUES ('36', '穿越火线', '穿越火线穿越火线', '2', '1', 'cyhx', '/public/uploads/55e6cde57ec2a0b6940541fbd63b8a29.jpg', '1', '1', '1', '1', '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `sf_game` VALUES ('37', '反恐精英ol', '反恐精英ol', '0', '1', 'fankongjingyingol', '', '0', '1', '1', '0', '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `sf_game` VALUES ('38', '怪物猎人ol', '怪物猎人ol', '0', '1', 'gwlrol', '/public/uploads/e06cd4bc25f337e1775166919dee3179.jpg', '1', '1', '1', '1', '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `sf_game` VALUES ('42', '蜀山缥缈录', '', '0', '1', 'ssl', '/public/uploads/b0ea96ffeba2fe1bb79b559cf83c664c.png', '0', '1', '1', '0', '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `sf_game` VALUES ('43', '天涯明月刀', '天命风流', '0', '1', 'tymyd', '/public/uploads/f504d219d2efe126c6acc35b3026cbe5.jpg', '0', '1', '1', '1', '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `sf_game` VALUES ('44', '天子剑', '', '0', '1', 'tzj', '', '0', '0', '1', '0', '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `sf_game` VALUES ('47', '火影忍者', '', '0', '3', 'hyrz', '', '1', '1', '1', '0', '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `sf_game` VALUES ('48', '英雄联盟', '', '0', '1', 'yxlm', '/public/uploads/a85661c287c5a7ab21bcb9bc19c26125.jpg', '1', '1', '1', '1', '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `sf_game` VALUES ('49', '新天龙八部', '', '0', '1', 'xtlbb', '', '1', '0', '1', '0', '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `sf_game` VALUES ('50', '阴阳师', '', '0', '3', 'yys', '', '1', '1', '1', '0', '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `sf_game` VALUES ('51', '大天使之剑', '', '0', '2', 'dtszj', '', '1', '0', '1', '0', '0000-00-00 00:00:00', '0000-00-00 00:00:00');

-- ----------------------------
-- Table structure for `sf_game_category`
-- ----------------------------
DROP TABLE IF EXISTS `sf_game_category`;
CREATE TABLE `sf_game_category` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `cat_name` varchar(100) NOT NULL DEFAULT '' COMMENT '分类名称',
  `display_name` varchar(255) NOT NULL DEFAULT '' COMMENT '拼音',
  `cat_order` int(10) unsigned NOT NULL DEFAULT '0',
  `desc` tinytext NOT NULL COMMENT '描述',
  `pid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '关系',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COMMENT='游戏分类';

-- ----------------------------
-- Records of sf_game_category
-- ----------------------------
INSERT INTO `sf_game_category` VALUES ('1', '网络游戏', 'duanyou', '0', 'pc端游戏', '0');
INSERT INTO `sf_game_category` VALUES ('2', '页游', 'yeyou', '0', '网页游戏', '0');
INSERT INTO `sf_game_category` VALUES ('3', '手游', 'shouyou', '0', '手机游戏', '0');

-- ----------------------------
-- Table structure for `sf_game_qu`
-- ----------------------------
DROP TABLE IF EXISTS `sf_game_qu`;
CREATE TABLE `sf_game_qu` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `game_id` int(10) unsigned NOT NULL COMMENT '游戏id',
  `qu_name` varchar(255) NOT NULL DEFAULT '' COMMENT '区服名称',
  `pid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '0是大区，其余是大区下的服务器',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=272 DEFAULT CHARSET=utf8 COMMENT='游戏区服信息';

-- ----------------------------
-- Records of sf_game_qu
-- ----------------------------
INSERT INTO `sf_game_qu` VALUES ('216', '46', '44', '215');
INSERT INTO `sf_game_qu` VALUES ('167', '22', '电信区', '0');
INSERT INTO `sf_game_qu` VALUES ('166', '22', '网通1区', '164');
INSERT INTO `sf_game_qu` VALUES ('165', '22', '网通2区', '164');
INSERT INTO `sf_game_qu` VALUES ('164', '22', '网通区', '0');
INSERT INTO `sf_game_qu` VALUES ('36', '23', '网通区', '0');
INSERT INTO `sf_game_qu` VALUES ('37', '23', '网通1', '36');
INSERT INTO `sf_game_qu` VALUES ('38', '23', '电信区', '0');
INSERT INTO `sf_game_qu` VALUES ('39', '23', '测试', '38');
INSERT INTO `sf_game_qu` VALUES ('40', '23', '测试1', '38');
INSERT INTO `sf_game_qu` VALUES ('41', '24', '网通1区', '0');
INSERT INTO `sf_game_qu` VALUES ('42', '24', '修炼谷', '41');
INSERT INTO `sf_game_qu` VALUES ('43', '24', '金刚不坏', '41');
INSERT INTO `sf_game_qu` VALUES ('44', '24', '御龙林', '41');
INSERT INTO `sf_game_qu` VALUES ('45', '24', '电信2区', '0');
INSERT INTO `sf_game_qu` VALUES ('46', '24', '情缘崖', '45');
INSERT INTO `sf_game_qu` VALUES ('47', '24', '大漠流沙', '45');
INSERT INTO `sf_game_qu` VALUES ('48', '24', '开天辟地', '45');
INSERT INTO `sf_game_qu` VALUES ('49', '24', '电信1区', '0');
INSERT INTO `sf_game_qu` VALUES ('50', '24', '松岩亭', '49');
INSERT INTO `sf_game_qu` VALUES ('51', '24', '绿明村', '49');
INSERT INTO `sf_game_qu` VALUES ('52', '24', '烈沙地带', '49');
INSERT INTO `sf_game_qu` VALUES ('53', '25', '双线二区', '0');
INSERT INTO `sf_game_qu` VALUES ('54', '25', '积雷山', '53');
INSERT INTO `sf_game_qu` VALUES ('55', '25', '斩妖台', '53');
INSERT INTO `sf_game_qu` VALUES ('56', '25', '双线一区', '0');
INSERT INTO `sf_game_qu` VALUES ('57', '25', '五行山', '56');
INSERT INTO `sf_game_qu` VALUES ('58', '25', '福陵山', '56');
INSERT INTO `sf_game_qu` VALUES ('59', '25', '金山寺', '56');
INSERT INTO `sf_game_qu` VALUES ('116', '35', '王者', '114');
INSERT INTO `sf_game_qu` VALUES ('115', '35', '狂风', '114');
INSERT INTO `sf_game_qu` VALUES ('114', '35', '二区', '0');
INSERT INTO `sf_game_qu` VALUES ('113', '35', '天龙', '112');
INSERT INTO `sf_game_qu` VALUES ('112', '35', '一区', '0');
INSERT INTO `sf_game_qu` VALUES ('73', '36', '体验区', '0');
INSERT INTO `sf_game_qu` VALUES ('74', '36', '体验服', '73');
INSERT INTO `sf_game_qu` VALUES ('75', '36', '网通区', '0');
INSERT INTO `sf_game_qu` VALUES ('76', '36', '河南1区', '75');
INSERT INTO `sf_game_qu` VALUES ('77', '36', '河北1区', '75');
INSERT INTO `sf_game_qu` VALUES ('78', '36', '电信区', '0');
INSERT INTO `sf_game_qu` VALUES ('79', '36', '四川1区', '78');
INSERT INTO `sf_game_qu` VALUES ('80', '36', '广东1区', '78');
INSERT INTO `sf_game_qu` VALUES ('81', '37', '电信', '0');
INSERT INTO `sf_game_qu` VALUES ('82', '37', '一区', '81');
INSERT INTO `sf_game_qu` VALUES ('83', '37', '二区', '81');
INSERT INTO `sf_game_qu` VALUES ('84', '37', '三区', '81');
INSERT INTO `sf_game_qu` VALUES ('85', '37', '网通', '0');
INSERT INTO `sf_game_qu` VALUES ('86', '37', '一区', '85');
INSERT INTO `sf_game_qu` VALUES ('87', '37', '二区', '85');
INSERT INTO `sf_game_qu` VALUES ('254', '48', '均衡教派', '241');
INSERT INTO `sf_game_qu` VALUES ('90', '38', '华南新区', '0');
INSERT INTO `sf_game_qu` VALUES ('91', '38', '真红之角', '90');
INSERT INTO `sf_game_qu` VALUES ('92', '38', '流光爆散', '90');
INSERT INTO `sf_game_qu` VALUES ('93', '38', '大地女王', '90');
INSERT INTO `sf_game_qu` VALUES ('253', '48', '钢铁烈阳', '241');
INSERT INTO `sf_game_qu` VALUES ('96', '38', '华东新区', '0');
INSERT INTO `sf_game_qu` VALUES ('97', '38', '森中怪鸟', '96');
INSERT INTO `sf_game_qu` VALUES ('98', '38', '群星眷顾', '96');
INSERT INTO `sf_game_qu` VALUES ('99', '38', '华东一区', '0');
INSERT INTO `sf_game_qu` VALUES ('100', '38', '巨齿豪杰', '99');
INSERT INTO `sf_game_qu` VALUES ('101', '38', '华北一区', '0');
INSERT INTO `sf_game_qu` VALUES ('102', '38', '厄兆残光', '101');
INSERT INTO `sf_game_qu` VALUES ('103', '38', '伏影白雷', '101');
INSERT INTO `sf_game_qu` VALUES ('104', '38', '华南一区', '0');
INSERT INTO `sf_game_qu` VALUES ('105', '38', '网中死神', '104');
INSERT INTO `sf_game_qu` VALUES ('252', '48', '暗影岛', '241');
INSERT INTO `sf_game_qu` VALUES ('251', '48', '黑色玫瑰', '241');
INSERT INTO `sf_game_qu` VALUES ('250', '48', '裁决之地', '241');
INSERT INTO `sf_game_qu` VALUES ('249', '48', '雷瑟守备', '241');
INSERT INTO `sf_game_qu` VALUES ('248', '48', '巨神峰', '241');
INSERT INTO `sf_game_qu` VALUES ('247', '48', '战争学院', '241');
INSERT INTO `sf_game_qu` VALUES ('246', '48', '皮尔特沃夫', '241');
INSERT INTO `sf_game_qu` VALUES ('245', '48', '班德尔城', '241');
INSERT INTO `sf_game_qu` VALUES ('244', '48', '诺克萨斯', '241');
INSERT INTO `sf_game_qu` VALUES ('243', '48', '祖安', '241');
INSERT INTO `sf_game_qu` VALUES ('242', '48', '艾欧尼亚', '241');
INSERT INTO `sf_game_qu` VALUES ('241', '48', '电信区', '0');
INSERT INTO `sf_game_qu` VALUES ('240', '48', '怒瑞玛', '235');
INSERT INTO `sf_game_qu` VALUES ('239', '48', '无畏先锋', '235');
INSERT INTO `sf_game_qu` VALUES ('238', '48', '佛雷尔卓德', '235');
INSERT INTO `sf_game_qu` VALUES ('237', '48', '德玛西亚', '235');
INSERT INTO `sf_game_qu` VALUES ('236', '48', '比尔吉沃特', '235');
INSERT INTO `sf_game_qu` VALUES ('235', '48', '网通区', '0');
INSERT INTO `sf_game_qu` VALUES ('255', '48', '水晶之痕', '241');
INSERT INTO `sf_game_qu` VALUES ('215', '46', '44', '0');
INSERT INTO `sf_game_qu` VALUES ('214', '46', 'df', '208');
INSERT INTO `sf_game_qu` VALUES ('213', '46', 'df', '208');
INSERT INTO `sf_game_qu` VALUES ('212', '46', 'qq', '208');
INSERT INTO `sf_game_qu` VALUES ('211', '46', 'dd', '208');
INSERT INTO `sf_game_qu` VALUES ('210', '46', 'ds', '208');
INSERT INTO `sf_game_qu` VALUES ('209', '46', 'sa', '208');
INSERT INTO `sf_game_qu` VALUES ('208', '46', 'd', '0');
INSERT INTO `sf_game_qu` VALUES ('207', '43', '装备1', '205');
INSERT INTO `sf_game_qu` VALUES ('206', '43', '装备', '205');
INSERT INTO `sf_game_qu` VALUES ('205', '43', '装备', '0');
INSERT INTO `sf_game_qu` VALUES ('204', '22', '电信3区', '167');
INSERT INTO `sf_game_qu` VALUES ('202', '22', '电信1区', '167');
INSERT INTO `sf_game_qu` VALUES ('203', '22', '电信2区', '167');
INSERT INTO `sf_game_qu` VALUES ('217', '46', '11', '215');
INSERT INTO `sf_game_qu` VALUES ('218', '46', '5', '215');
INSERT INTO `sf_game_qu` VALUES ('219', '46', '22', '0');
INSERT INTO `sf_game_qu` VALUES ('220', '46', '11', '219');
INSERT INTO `sf_game_qu` VALUES ('221', '46', '22', '219');
INSERT INTO `sf_game_qu` VALUES ('222', '46', '33', '219');
INSERT INTO `sf_game_qu` VALUES ('223', '46', '1', '0');
INSERT INTO `sf_game_qu` VALUES ('224', '46', '2', '223');
INSERT INTO `sf_game_qu` VALUES ('225', '46', '21', '223');
INSERT INTO `sf_game_qu` VALUES ('226', '46', '3', '223');
INSERT INTO `sf_game_qu` VALUES ('227', '44', '1', '0');
INSERT INTO `sf_game_qu` VALUES ('228', '44', '2', '227');
INSERT INTO `sf_game_qu` VALUES ('229', '47', '苹果', '0');
INSERT INTO `sf_game_qu` VALUES ('230', '47', '1', '229');
INSERT INTO `sf_game_qu` VALUES ('231', '47', '2', '229');
INSERT INTO `sf_game_qu` VALUES ('232', '47', '安卓', '0');
INSERT INTO `sf_game_qu` VALUES ('233', '47', '1', '232');
INSERT INTO `sf_game_qu` VALUES ('234', '47', '2', '232');
INSERT INTO `sf_game_qu` VALUES ('256', '49', '电信大区', '0');
INSERT INTO `sf_game_qu` VALUES ('257', '49', '白虹剑/辟邪剑谱/玄冥神掌', '256');
INSERT INTO `sf_game_qu` VALUES ('258', '49', '北冥神功/雁翎枪/普陀山/玄', '256');
INSERT INTO `sf_game_qu` VALUES ('259', '49', '冰蚕掌/岳老三/人界/老白干/飞龙在天/慕容博/上海滩/烟雨楼', '256');
INSERT INTO `sf_game_qu` VALUES ('260', '49', '网通大区', '0');
INSERT INTO `sf_game_qu` VALUES ('261', '49', '百泉书院/玉佛苑/大乘寺/会', '260');
INSERT INTO `sf_game_qu` VALUES ('262', '49', '碧螺春/比翼鸟/三生石/大明', '260');
INSERT INTO `sf_game_qu` VALUES ('263', '49', '双线大区', '0');
INSERT INTO `sf_game_qu` VALUES ('264', '49', '傲世/放纵/战魂/雄霸/风云', '263');
INSERT INTO `sf_game_qu` VALUES ('265', '50', '苹果', '0');
INSERT INTO `sf_game_qu` VALUES ('266', '50', '苹果1区', '265');
INSERT INTO `sf_game_qu` VALUES ('267', '50', '安卓', '0');
INSERT INTO `sf_game_qu` VALUES ('268', '50', '安卓1区', '267');
INSERT INTO `sf_game_qu` VALUES ('269', '51', '99YX', '0');
INSERT INTO `sf_game_qu` VALUES ('270', '51', ' YY', '0');
INSERT INTO `sf_game_qu` VALUES ('271', '51', '160yx', '0');

-- ----------------------------
-- Table structure for `sf_game_type`
-- ----------------------------
DROP TABLE IF EXISTS `sf_game_type`;
CREATE TABLE `sf_game_type` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `game_id` int(10) unsigned NOT NULL COMMENT '游戏id',
  `type` varchar(50) NOT NULL DEFAULT '' COMMENT '类型',
  `fee` decimal(10,2) unsigned NOT NULL COMMENT '手续费',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=142 DEFAULT CHARSET=utf8 COMMENT='游戏商品类型';

-- ----------------------------
-- Records of sf_game_type
-- ----------------------------
INSERT INTO `sf_game_type` VALUES ('1', '24', '游戏币', '0.00');
INSERT INTO `sf_game_type` VALUES ('2', '24', '装备', '0.00');
INSERT INTO `sf_game_type` VALUES ('3', '24', '游戏帐号', '0.00');
INSERT INTO `sf_game_type` VALUES ('28', '25', '游戏帐号', '0.00');
INSERT INTO `sf_game_type` VALUES ('29', '25', '游戏币', '0.00');
INSERT INTO `sf_game_type` VALUES ('30', '25', '真言', '0.00');
INSERT INTO `sf_game_type` VALUES ('56', '35', '游戏帐号', '0.00');
INSERT INTO `sf_game_type` VALUES ('55', '35', '装备', '0.00');
INSERT INTO `sf_game_type` VALUES ('41', '36', '游戏帐号', '0.00');
INSERT INTO `sf_game_type` VALUES ('42', '36', 'cf点', '0.00');
INSERT INTO `sf_game_type` VALUES ('43', '37', '宠物', '0.00');
INSERT INTO `sf_game_type` VALUES ('44', '37', '装备', '0.00');
INSERT INTO `sf_game_type` VALUES ('45', '38', '银币', '0.00');
INSERT INTO `sf_game_type` VALUES ('46', '38', '装备', '0.00');
INSERT INTO `sf_game_type` VALUES ('47', '38', '游戏币', '0.00');
INSERT INTO `sf_game_type` VALUES ('48', '38', '游戏帐号', '0.00');
INSERT INTO `sf_game_type` VALUES ('98', '22', '帐号', '0.00');
INSERT INTO `sf_game_type` VALUES ('97', '22', '游戏装备', '0.00');
INSERT INTO `sf_game_type` VALUES ('126', '24', '激活码', '0.00');
INSERT INTO `sf_game_type` VALUES ('125', '23', '激活码', '0.00');
INSERT INTO `sf_game_type` VALUES ('124', '48', '帐号', '0.00');
INSERT INTO `sf_game_type` VALUES ('128', '49', '宝宝', '0.00');
INSERT INTO `sf_game_type` VALUES ('127', '49', '宝石', '0.00');
INSERT INTO `sf_game_type` VALUES ('99', '22', '游戏币', '0.00');
INSERT INTO `sf_game_type` VALUES ('101', '23', '装备', '0.00');
INSERT INTO `sf_game_type` VALUES ('102', '42', '宠物', '5.00');
INSERT INTO `sf_game_type` VALUES ('103', '42', '武魂珠', '5.00');
INSERT INTO `sf_game_type` VALUES ('104', '42', '材料', '5.00');
INSERT INTO `sf_game_type` VALUES ('105', '42', '游戏币', '5.00');
INSERT INTO `sf_game_type` VALUES ('106', '42', '装备', '5.00');
INSERT INTO `sf_game_type` VALUES ('107', '42', '点券', '10.00');
INSERT INTO `sf_game_type` VALUES ('108', '42', '游戏帐号', '5.00');
INSERT INTO `sf_game_type` VALUES ('109', '43', '装备', '5.00');
INSERT INTO `sf_game_type` VALUES ('110', '43', '点券礼包-CDKEY', '0.00');
INSERT INTO `sf_game_type` VALUES ('111', '43', '游戏帐号', '10.00');
INSERT INTO `sf_game_type` VALUES ('112', '43', '游戏币', '5.00');
INSERT INTO `sf_game_type` VALUES ('113', '43', '道具', '5.00');
INSERT INTO `sf_game_type` VALUES ('114', '44', '装备', '1.00');
INSERT INTO `sf_game_type` VALUES ('115', '44', '游戏帐号', '10.11');
INSERT INTO `sf_game_type` VALUES ('116', '44', '游戏币', '5.00');
INSERT INTO `sf_game_type` VALUES ('117', '45', '11', '11.00');
INSERT INTO `sf_game_type` VALUES ('118', '46', '3', '3.00');
INSERT INTO `sf_game_type` VALUES ('119', '46', '2', '2.00');
INSERT INTO `sf_game_type` VALUES ('120', '46', '1', '1.00');
INSERT INTO `sf_game_type` VALUES ('121', '46', '4', '4.00');
INSERT INTO `sf_game_type` VALUES ('122', '46', '5', '5.00');
INSERT INTO `sf_game_type` VALUES ('123', '47', '帐号', '0.00');
INSERT INTO `sf_game_type` VALUES ('129', '49', '激活码', '0.00');
INSERT INTO `sf_game_type` VALUES ('130', '49', '游戏币', '0.00');
INSERT INTO `sf_game_type` VALUES ('131', '49', '装备', '0.00');
INSERT INTO `sf_game_type` VALUES ('132', '49', '元宝', '0.00');
INSERT INTO `sf_game_type` VALUES ('133', '47', '游戏币', '0.00');
INSERT INTO `sf_game_type` VALUES ('134', '47', '装备', '0.00');
INSERT INTO `sf_game_type` VALUES ('135', '50', '游戏币', '0.00');
INSERT INTO `sf_game_type` VALUES ('136', '50', '装备', '0.00');
INSERT INTO `sf_game_type` VALUES ('137', '50', '帐号', '0.00');
INSERT INTO `sf_game_type` VALUES ('138', '51', '元宝', '0.00');
INSERT INTO `sf_game_type` VALUES ('139', '51', '帐号', '0.00');
INSERT INTO `sf_game_type` VALUES ('140', '51', '游戏币', '0.00');
INSERT INTO `sf_game_type` VALUES ('141', '51', '装备', '0.00');

-- ----------------------------
-- Table structure for `sf_game_user_info`
-- ----------------------------
DROP TABLE IF EXISTS `sf_game_user_info`;
CREATE TABLE `sf_game_user_info` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `game_user_name` varchar(255) NOT NULL DEFAULT '' COMMENT '游戏帐号',
  `game_user_pwd` varchar(255) NOT NULL DEFAULT '' COMMENT '密码',
  `is_datacard` varchar(3) NOT NULL DEFAULT '0' COMMENT '0没绑定身份证，1绑定',
  `is_secretcard` varchar(3) NOT NULL DEFAULT '0' COMMENT '0没绑定密保卡，1绑定',
  `secretcard_img` varchar(255) NOT NULL DEFAULT '' COMMENT '密保卡图片',
  `game_user_phone` varchar(255) NOT NULL DEFAULT '' COMMENT '座机',
  `game_user_qq` varchar(255) NOT NULL DEFAULT '' COMMENT 'QQ',
  `game_user_tel` varchar(255) NOT NULL DEFAULT '' COMMENT '手机',
  `goods_id` int(10) unsigned NOT NULL COMMENT '商品id',
  `is_bind_tel` varchar(3) NOT NULL DEFAULT '0' COMMENT '0没绑定手机，1绑定',
  `is_man_day` varchar(3) NOT NULL DEFAULT '0' COMMENT '0没满15天，1满15天',
  `mb_tel` varchar(255) NOT NULL DEFAULT '' COMMENT '密保电话',
  `mb_question` varchar(255) NOT NULL DEFAULT '' COMMENT '密保问题',
  `mb_answer` varchar(255) NOT NULL DEFAULT '' COMMENT '密保答案',
  `game_user` varchar(255) NOT NULL DEFAULT '' COMMENT '角色名称',
  `two_level_pass` varchar(255) NOT NULL DEFAULT '' COMMENT '二级密码',
  `datacard` varchar(255) NOT NULL DEFAULT '',
  `warehouse_pass` varchar(255) DEFAULT NULL COMMENT '仓库密码',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=35 DEFAULT CHARSET=utf8 COMMENT='游戏商品帐号信息';

-- ----------------------------
-- Records of sf_game_user_info
-- ----------------------------
INSERT INTO `sf_game_user_info` VALUES ('32', 'asdasd', 'asdasd', '0', '0', '', '', '1213213213', '18523654754', '43', '0', '0', '', '', '', 'asdasd', '', '', null);
INSERT INTO `sf_game_user_info` VALUES ('33', 'asdasd', 'asdasd', '0', '0', '', '', '1213213213', '18523654754', '44', '0', '0', '', '', '', 'asdasd', '', '', null);
INSERT INTO `sf_game_user_info` VALUES ('34', 'asdasd', 'asdasd', '0', '0', '', '', '1213213213', '18523654754', '45', '0', '0', '', '', '', '', '', '', null);

-- ----------------------------
-- Table structure for `sf_goods_game`
-- ----------------------------
DROP TABLE IF EXISTS `sf_goods_game`;
CREATE TABLE `sf_goods_game` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `goods_name` varchar(255) NOT NULL DEFAULT '' COMMENT '商品名',
  `goods_price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '商品单价',
  `goods_code` varchar(100) NOT NULL DEFAULT '' COMMENT '商品编号',
  `cate_id` int(10) unsigned NOT NULL COMMENT '游戏分类id',
  `game_id` int(11) NOT NULL COMMENT '所属游戏id',
  `qu_id` int(10) unsigned NOT NULL COMMENT '大区id',
  `game_qu_id` int(10) unsigned NOT NULL COMMENT '服务器id',
  `traded_type` int(3) unsigned NOT NULL DEFAULT '0' COMMENT '交易类型，0=寄售交易，1=担保交易，2=求购交易',
  `goods_type_id` int(10) unsigned NOT NULL COMMENT '商品类型id',
  `goods_stock` varchar(255) NOT NULL DEFAULT '' COMMENT '库存',
  `sale_start_time` varchar(255) NOT NULL DEFAULT '' COMMENT '开始时间',
  `sale_end_time` varchar(255) NOT NULL DEFAULT '' COMMENT '商品结束时间',
  `best_time` varchar(255) NOT NULL DEFAULT '' COMMENT '最佳交易时间',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `is_check` varchar(10) NOT NULL DEFAULT '0' COMMENT '0没有审核，1审核通过，2审核不通过',
  `is_cut_price` varchar(10) NOT NULL DEFAULT '0' COMMENT '0不议价，1可以议价',
  `goods_content` text NOT NULL COMMENT '商品详情',
  `user_id` int(10) unsigned NOT NULL COMMENT '发布人id',
  `pwd` varchar(255) NOT NULL DEFAULT '' COMMENT '购买密码',
  `to_money` varchar(3) NOT NULL DEFAULT '0' COMMENT '0平台账户，1银行',
  `account` varchar(255) NOT NULL DEFAULT '' COMMENT '账户号',
  `security` varchar(100) NOT NULL DEFAULT '' COMMENT '安保措施',
  `code` varchar(255) DEFAULT '' COMMENT '交易暗号',
  `attr_value` varchar(255) DEFAULT '' COMMENT '属性值',
  `is_trash` varchar(3) NOT NULL DEFAULT '0' COMMENT '1在回收站中,-1软删除',
  `one_num` int(10) unsigned NOT NULL COMMENT '单件数量',
  `is_on_sale` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '0下架，1上架',
  `error_reson` varchar(255) DEFAULT NULL COMMENT '失败原因',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=46 DEFAULT CHARSET=utf8 COMMENT='商品';

-- ----------------------------
-- Records of sf_goods_game
-- ----------------------------
INSERT INTO `sf_goods_game` VALUES ('43', '+010释魂之真灵【巨剑，太刀，短剑，光剑】4选1，放心购买，正品行货。【在线发货，方便快捷】', '140.00', 'YXZB20161215100451-66671', '1', '22', '167', '202', '0', '97', '5', '1481767491', '1483149910', '00:00-24:00', '2016-12-15 10:04:51', '2016-12-16 11:36:15', '1', '0', '', '0', '123123', '0', '', '', '', '[\"卡片\"]', '0', '0', '1', '');
INSERT INTO `sf_goods_game` VALUES ('44', '【深渊票 】2035张深渊票=100.00元【邮寄交易，DD373免手续费】', '100.00', 'YXZB20161215100924-15902', '1', '22', '167', '202', '0', '97', '16', '1481767764', '1483150204', '00:00-24:00', '2016-12-15 10:09:24', '2016-12-15 10:09:45', '1', '0', '', '0', '', '0', '', '', '', 'a:2:{i:0;s:11:\"有QQ好友\";i:1;s:3:\"男\";}', '0', '0', '1', '');
INSERT INTO `sf_goods_game` VALUES ('45', '装扮套鲁莽套两史诗武器史诗姨妈戒12火刀耀眼黄金金库', '200.00', 'ZH20161215103618-34793', '1', '22', '167', '204', '0', '98', '1', '1481769378', '1483151825', '00:00-24:00', '2016-12-15 10:36:18', '2016-12-15 10:37:09', '1', '0', '', '0', '', '0', '', '', '', 'a:2:{i:0;s:11:\"有QQ好友\";i:1;s:3:\"男\";}', '0', '0', '1', '');

-- ----------------------------
-- Table structure for `sf_goods_game_picture`
-- ----------------------------
DROP TABLE IF EXISTS `sf_goods_game_picture`;
CREATE TABLE `sf_goods_game_picture` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `goods_id` int(10) unsigned NOT NULL COMMENT '商品id',
  `picture` varchar(255) NOT NULL DEFAULT '' COMMENT '图片地址',
  `create_time` varchar(255) NOT NULL DEFAULT '' COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=62 DEFAULT CHARSET=utf8 COMMENT='商品图片';

-- ----------------------------
-- Records of sf_goods_game_picture
-- ----------------------------

-- ----------------------------
-- Table structure for `sf_jobs`
-- ----------------------------
DROP TABLE IF EXISTS `sf_jobs`;
CREATE TABLE `sf_jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8_unicode_ci NOT NULL,
  `attempts` tinyint(3) unsigned NOT NULL,
  `reserved` tinyint(3) unsigned NOT NULL,
  `reserved_at` int(10) unsigned DEFAULT NULL,
  `available_at` int(10) unsigned NOT NULL,
  `created_at` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_reserved_reserved_at_index` (`queue`,`reserved`,`reserved_at`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='队列';

-- ----------------------------
-- Records of sf_jobs
-- ----------------------------

-- ----------------------------
-- Table structure for `sf_link`
-- ----------------------------
DROP TABLE IF EXISTS `sf_link`;
CREATE TABLE `sf_link` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `link_name` varchar(50) NOT NULL DEFAULT '' COMMENT '链接名称',
  `link_url` varchar(255) NOT NULL DEFAULT '' COMMENT '链接地址',
  `link_order` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `link_type` varchar(10) NOT NULL DEFAULT '0' COMMENT '0代表文字链接，1代表图片链接',
  `link_logo` varchar(255) NOT NULL DEFAULT '' COMMENT '链接logo',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COMMENT='友情链接';

-- ----------------------------
-- Records of sf_link
-- ----------------------------
INSERT INTO `sf_link` VALUES ('1', '炉石星空', 'http://www.lushisky.com', '10', '0', '');
INSERT INTO `sf_link` VALUES ('7', '新浪游戏频道', '/', '4', '0', '');
INSERT INTO `sf_link` VALUES ('6', '178游戏网', '/', '1', '0', '');
INSERT INTO `sf_link` VALUES ('4', '炉石shy', 'http://www.lushisky.com', '1', '0', '');
INSERT INTO `sf_link` VALUES ('5', '658金融网', '/', '0', '0', '');
INSERT INTO `sf_link` VALUES ('8', '猫扑游戏频道', '/', '0', '0', '');
INSERT INTO `sf_link` VALUES ('9', '腾讯游戏频道', '/', '0', '0', '');

-- ----------------------------
-- Table structure for `sf_mail_log`
-- ----------------------------
DROP TABLE IF EXISTS `sf_mail_log`;
CREATE TABLE `sf_mail_log` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(255) NOT NULL DEFAULT '' COMMENT '邮箱',
  `activationcode` varchar(255) NOT NULL DEFAULT '' COMMENT '验证码',
  `create_time` varchar(255) NOT NULL DEFAULT '' COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=35 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of sf_mail_log
-- ----------------------------
INSERT INTO `sf_mail_log` VALUES ('29', '201677277@qq.com', '30affcfb68cf8a0b88e64aa1e0761015', '1478448000');
INSERT INTO `sf_mail_log` VALUES ('30', '651249879@qq.com', 'c6653f5b6cacd73cc272fa3cf1573163', '1478659758');
INSERT INTO `sf_mail_log` VALUES ('31', 'asdasd123@qq.com', 'e8752071221e9776082ec6fb1cd59970', '1478661078');
INSERT INTO `sf_mail_log` VALUES ('32', 'asdasd321@qq.com', '45f2464958e3e67e2f506cfa0bfbc4e9', '1478661469');
INSERT INTO `sf_mail_log` VALUES ('34', '6546498@qq.com', '419af3ecffb0094d923b2eafba4ca27e', '1481275327');

-- ----------------------------
-- Table structure for `sf_menu`
-- ----------------------------
DROP TABLE IF EXISTS `sf_menu`;
CREATE TABLE `sf_menu` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(60) NOT NULL DEFAULT '' COMMENT '菜单名',
  `order` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `url` varchar(255) NOT NULL DEFAULT '' COMMENT '地址',
  `pid` int(10) unsigned NOT NULL DEFAULT '0',
  `ico` varchar(100) NOT NULL DEFAULT '' COMMENT 'css样式',
  `bind_permission` int(10) unsigned NOT NULL COMMENT '绑定权限',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=52 DEFAULT CHARSET=utf8 COMMENT='后台菜单';

-- ----------------------------
-- Records of sf_menu
-- ----------------------------
INSERT INTO `sf_menu` VALUES ('1', '文章管理', '3', '', '0', 'fa-book', '0');
INSERT INTO `sf_menu` VALUES ('2', '权限管理', '2', '', '0', 'fa-lock', '0');
INSERT INTO `sf_menu` VALUES ('3', '系统设置', '1', '', '0', 'fa-cog', '0');
INSERT INTO `sf_menu` VALUES ('4', '广告管理', '3', '', '0', 'fa-image', '0');
INSERT INTO `sf_menu` VALUES ('5', '文章列表', '0', 'news', '1', 'fa-list-ul', '4');
INSERT INTO `sf_menu` VALUES ('6', '文章分类', '0', 'ArtCate', '1', 'fa-list-alt', '5');
INSERT INTO `sf_menu` VALUES ('7', '管理员列表', '0', 'power', '2', 'fa-list-ul', '12');
INSERT INTO `sf_menu` VALUES ('8', '角色管理', '1', 'role', '2', 'fa-male', '16');
INSERT INTO `sf_menu` VALUES ('10', '网站配置', '0', 'config', '3', 'fa-cubes', '20');
INSERT INTO `sf_menu` VALUES ('11', '自定义导航', '0', 'nav', '3', 'fa-navicon', '24');
INSERT INTO `sf_menu` VALUES ('12', '友情链接', '0', 'link', '3', 'fa-share-square-o', '28');
INSERT INTO `sf_menu` VALUES ('13', '广告列表', '2', 'ad', '4', 'fa-list', '32');
INSERT INTO `sf_menu` VALUES ('14', '广告位置', '1', 'ad_position', '4', 'fa-globe', '36');
INSERT INTO `sf_menu` VALUES ('15', '菜单管理', '0', 'menu', '3', 'fa-building-o', '40');
INSERT INTO `sf_menu` VALUES ('23', '游戏管理', '0', '', '0', 'fa-gamepad', '0');
INSERT INTO `sf_menu` VALUES ('22', '查看日志', '0', 'log-viewer', '2', 'fa-male', '41');
INSERT INTO `sf_menu` VALUES ('24', '游戏列表', '1', 'game', '23', 'fa-laptop', '42');
INSERT INTO `sf_menu` VALUES ('25', '游戏分类', '1', 'cate_game', '23', 'fa-tasks', '43');
INSERT INTO `sf_menu` VALUES ('26', '游戏商品列表', '0', 'goodsgame', '23', 'fa-list', '50');
INSERT INTO `sf_menu` VALUES ('27', '游戏属性', '1', 'attribute', '23', 'fa-sliders', '54');
INSERT INTO `sf_menu` VALUES ('28', '回收站', '6', 'trash', '23', 'fa-trash', '59');
INSERT INTO `sf_menu` VALUES ('30', '会员管理', '0', '', '0', 'fa-users', '0');
INSERT INTO `sf_menu` VALUES ('31', '会员列表', '0', 'user', '30', ' fa-user', '64');
INSERT INTO `sf_menu` VALUES ('32', '订单管理', '0', '', '0', 'fa-building-o', '0');
INSERT INTO `sf_menu` VALUES ('33', '订单列表', '1', 'order', '32', 'fa-list', '70');
INSERT INTO `sf_menu` VALUES ('34', '充值提现申请', '2', 'user_account', '30', 'fa-money', '72');
INSERT INTO `sf_menu` VALUES ('35', '会员等级', '4', 'user_rank', '30', 'fa-level-up', '75');
INSERT INTO `sf_menu` VALUES ('36', '轮播图列表', '0', 'banner', '3', ' fa-image', '84');
INSERT INTO `sf_menu` VALUES ('37', '积分商品', '0', 'exchange', '23', 'fa-list', '88');
INSERT INTO `sf_menu` VALUES ('38', '积分商品订单', '2', 'exchange_order', '32', 'fa-list', '92');
INSERT INTO `sf_menu` VALUES ('39', '投诉咨询管理', '0', '', '0', 'fa-graduation-cap', '0');
INSERT INTO `sf_menu` VALUES ('40', '咨询列表', '0', 'ask', '39', 'fa-list', '96');
INSERT INTO `sf_menu` VALUES ('41', '建议列表', '0', 'advise', '39', 'fa-list', '100');
INSERT INTO `sf_menu` VALUES ('42', '投诉列表', '0', 'complaint', '39', 'fa-list', '104');
INSERT INTO `sf_menu` VALUES ('43', '异常申请列表', '4', 'application', '30', 'fa-list', '108');
INSERT INTO `sf_menu` VALUES ('44', '报表统计', '0', '', '0', ' fa-bar-chart-o', '0');
INSERT INTO `sf_menu` VALUES ('45', '订单统计', '0', 'order_stats', '44', ' fa-table', '112');
INSERT INTO `sf_menu` VALUES ('46', '销售概况', '0', 'sale_general', '44', 'fa-list-alt', '113');
INSERT INTO `sf_menu` VALUES ('47', '销售明细', '0', 'sale_list', '44', ' fa-list-ul', '114');
INSERT INTO `sf_menu` VALUES ('48', '点卡管理', '0', '', '0', 'fa-keyboard-o', '0');
INSERT INTO `sf_menu` VALUES ('49', '点卡设置', '0', 'dk_config', '48', 'fa-cog', '115');
INSERT INTO `sf_menu` VALUES ('50', '充值订单', '0', 'dk_list', '48', 'fa-list', '116');
INSERT INTO `sf_menu` VALUES ('51', '点卡游戏列表', '0', 'dk_game_list', '48', 'fa-list', '117');

-- ----------------------------
-- Table structure for `sf_migrations`
-- ----------------------------
DROP TABLE IF EXISTS `sf_migrations`;
CREATE TABLE `sf_migrations` (
  `migration` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of sf_migrations
-- ----------------------------
INSERT INTO `sf_migrations` VALUES ('2014_10_12_000000_create_users_table', '1');
INSERT INTO `sf_migrations` VALUES ('2014_10_12_100000_create_password_resets_table', '1');
INSERT INTO `sf_migrations` VALUES ('2015_01_15_105324_create_roles_table', '2');
INSERT INTO `sf_migrations` VALUES ('2015_01_15_114412_create_role_user_table', '2');
INSERT INTO `sf_migrations` VALUES ('2015_01_26_115212_create_permissions_table', '2');
INSERT INTO `sf_migrations` VALUES ('2015_01_26_115523_create_permission_role_table', '2');
INSERT INTO `sf_migrations` VALUES ('2015_02_09_132439_create_permission_user_table', '2');
INSERT INTO `sf_migrations` VALUES ('2014_10_28_175635_create_threads_table', '3');
INSERT INTO `sf_migrations` VALUES ('2014_10_28_175710_create_messages_table', '3');
INSERT INTO `sf_migrations` VALUES ('2014_10_28_180224_create_participants_table', '3');
INSERT INTO `sf_migrations` VALUES ('2014_11_03_154831_add_soft_deletes_to_participants_table', '3');
INSERT INTO `sf_migrations` VALUES ('2014_12_04_124531_add_softdeletes_to_threads_table', '3');
INSERT INTO `sf_migrations` VALUES ('2015_12_21_111514_create_sms_table', '3');
INSERT INTO `sf_migrations` VALUES ('2014_02_10_145728_notification_categories', '4');
INSERT INTO `sf_migrations` VALUES ('2014_08_01_210813_create_notification_groups_table', '4');
INSERT INTO `sf_migrations` VALUES ('2014_08_01_211045_create_notification_category_notification_group_table', '4');
INSERT INTO `sf_migrations` VALUES ('2015_05_05_212549_create_notifications_table', '4');
INSERT INTO `sf_migrations` VALUES ('2015_06_06_211555_add_expire_time_column_to_notification_table', '4');
INSERT INTO `sf_migrations` VALUES ('2015_06_06_211555_change_type_to_extra_in_notifications_table', '4');
INSERT INTO `sf_migrations` VALUES ('2015_06_07_211555_alter_category_name_to_unique', '4');
INSERT INTO `sf_migrations` VALUES ('2016_04_19_200827_make_notification_url_nullable', '4');
INSERT INTO `sf_migrations` VALUES ('2016_05_19_144531_add_stack_id_to_notifications', '4');
INSERT INTO `sf_migrations` VALUES ('2016_11_21_151901_create_jobs_table', '5');

-- ----------------------------
-- Table structure for `sf_nav`
-- ----------------------------
DROP TABLE IF EXISTS `sf_nav`;
CREATE TABLE `sf_nav` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nav_name` varchar(50) NOT NULL DEFAULT '' COMMENT '导航名',
  `nav_order` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `nav_url` varchar(255) NOT NULL DEFAULT '' COMMENT '链接地址',
  `nav_wz` varchar(10) NOT NULL DEFAULT '' COMMENT '导航位置，1顶部，2主导航，3尾部',
  `is_show` varchar(10) NOT NULL DEFAULT '1' COMMENT '1显示，0不显示',
  `p_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '上级id',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=60 DEFAULT CHARSET=utf8 COMMENT='前台导航';

-- ----------------------------
-- Records of sf_nav
-- ----------------------------
INSERT INTO `sf_nav` VALUES ('7', '寄售交易', '2', 'all_game', '2', '1', '0');
INSERT INTO `sf_nav` VALUES ('5', '我要求购', '0', 'need', '2', '1', '0');
INSERT INTO `sf_nav` VALUES ('8', '点卡商城', '4', 'dk_shop', '2', '1', '0');
INSERT INTO `sf_nav` VALUES ('9', '积分商城', '4', 'exchange', '2', '1', '0');
INSERT INTO `sf_nav` VALUES ('10', '帮助中心', '5', 'help/help', '2', '1', '0');
INSERT INTO `sf_nav` VALUES ('11', '客服中心', '6', 'help', '2', '1', '0');
INSERT INTO `sf_nav` VALUES ('12', '新手入门', '7', '/', '3', '1', '0');
INSERT INTO `sf_nav` VALUES ('13', '充值提现', '8', '/', '3', '1', '0');
INSERT INTO `sf_nav` VALUES ('14', '特色服务', '9', '/', '3', '1', '0');
INSERT INTO `sf_nav` VALUES ('15', '客服中心', '10', '/', '3', '1', '0');
INSERT INTO `sf_nav` VALUES ('16', '了解搜付', '11', '/', '3', '1', '0');
INSERT INTO `sf_nav` VALUES ('17', '诚信与安全', '0', 'help/safe', '3', '1', '12');
INSERT INTO `sf_nav` VALUES ('18', '用户注册', '0', '/', '3', '1', '12');
INSERT INTO `sf_nav` VALUES ('19', '交易流程', '0', '/', '3', '1', '12');
INSERT INTO `sf_nav` VALUES ('20', '充值方式', '0', '/', '3', '1', '13');
INSERT INTO `sf_nav` VALUES ('21', '如何提现', '0', 'help/detail/16?menu=0&cat=39', '3', '1', '13');
INSERT INTO `sf_nav` VALUES ('22', '交易收费标准', '0', '/', '3', '1', '13');
INSERT INTO `sf_nav` VALUES ('23', '提现收费标准', '0', '/', '3', '1', '13');
INSERT INTO `sf_nav` VALUES ('24', '保险服务', '0', '/', '3', '1', '14');
INSERT INTO `sf_nav` VALUES ('25', '小额交易', '0', '/', '3', '1', '14');
INSERT INTO `sf_nav` VALUES ('26', '客服验证', '0', '/', '3', '1', '15');
INSERT INTO `sf_nav` VALUES ('27', '帮助中心', '0', '/', '3', '1', '15');
INSERT INTO `sf_nav` VALUES ('28', '咨询建议', '0', '/', '3', '1', '15');
INSERT INTO `sf_nav` VALUES ('29', '商务合作', '0', '/', '3', '1', '15');
INSERT INTO `sf_nav` VALUES ('30', '信念与荣耀', '0', '/', '3', '1', '16');
INSERT INTO `sf_nav` VALUES ('31', '合作伙伴', '0', '/', '3', '1', '16');
INSERT INTO `sf_nav` VALUES ('32', '免责声明', '0', '/', '3', '1', '16');
INSERT INTO `sf_nav` VALUES ('33', '隐私保护', '0', '/', '3', '1', '16');
INSERT INTO `sf_nav` VALUES ('34', '买家中心', '0', 'buyer', '1', '1', '0');
INSERT INTO `sf_nav` VALUES ('35', '卖家中心', '1', 'seller', '1', '1', '0');
INSERT INTO `sf_nav` VALUES ('36', '客服中心', '2', 'help', '1', '1', '0');
INSERT INTO `sf_nav` VALUES ('37', '网站导航', '3', 'daohang', '1', '1', '0');
INSERT INTO `sf_nav` VALUES ('38', '官方微博', '4', 'weibo', '1', '1', '0');
INSERT INTO `sf_nav` VALUES ('39', '我要买', '0', 'all_game', '1', '1', '34');
INSERT INTO `sf_nav` VALUES ('40', '我要求购', '1', 'needsPublish', '1', '1', '34');
INSERT INTO `sf_nav` VALUES ('41', '我购买的商品', '2', 'user/goods', '1', '1', '34');
INSERT INTO `sf_nav` VALUES ('42', '我购买的点卡', '4', 'user/dk', '1', '1', '34');
INSERT INTO `sf_nav` VALUES ('43', '我要充值', '5', 'user/money/recharge', '1', '1', '34');
INSERT INTO `sf_nav` VALUES ('44', '我要卖', '0', 'user/sell', '1', '1', '35');
INSERT INTO `sf_nav` VALUES ('45', '我的订单管理', '1', 'user/SellOrder', '1', '1', '35');
INSERT INTO `sf_nav` VALUES ('46', '求降价管理', '2', 'user/sell/changePriceInfo', '1', '1', '35');
INSERT INTO `sf_nav` VALUES ('47', '发布的商品', '4', 'user/MySell', '1', '1', '35');
INSERT INTO `sf_nav` VALUES ('48', '帮助中心', '0', 'help/help', '1', '1', '36');
INSERT INTO `sf_nav` VALUES ('49', '安全中心', '1', 'help/safe', '1', '1', '36');
INSERT INTO `sf_nav` VALUES ('50', '我要咨询', '2', 'help/ask/type', '1', '1', '36');
INSERT INTO `sf_nav` VALUES ('59', '担保交易', '3', 'all_game', '2', '1', '0');
INSERT INTO `sf_nav` VALUES ('52', '个人中心', '0', 'user', '1', '1', '37');
INSERT INTO `sf_nav` VALUES ('53', '点卡商城', '1', 'dk_shop', '1', '1', '37');
INSERT INTO `sf_nav` VALUES ('54', '积分商城', '2', 'exchange', '1', '1', '37');
INSERT INTO `sf_nav` VALUES ('55', '我要求购', '3', 'need', '1', '1', '37');
INSERT INTO `sf_nav` VALUES ('57', '新浪微博', '0', '/', '1', '1', '38');
INSERT INTO `sf_nav` VALUES ('58', '腾讯微博', '1', '/', '1', '1', '38');

-- ----------------------------
-- Table structure for `sf_notifications`
-- ----------------------------
DROP TABLE IF EXISTS `sf_notifications`;
CREATE TABLE `sf_notifications` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `from_id` bigint(20) unsigned NOT NULL,
  `from_type` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `to_id` bigint(20) unsigned NOT NULL,
  `to_type` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `category_id` int(10) unsigned NOT NULL,
  `url` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `extra` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `read` tinyint(4) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `expire_time` timestamp NULL DEFAULT NULL,
  `stack_id` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `notifications_from_id_index` (`from_id`),
  KEY `notifications_from_type_index` (`from_type`),
  KEY `notifications_to_id_index` (`to_id`),
  KEY `notifications_to_type_index` (`to_type`),
  KEY `notifications_category_id_index` (`category_id`)
) ENGINE=MyISAM AUTO_INCREMENT=26 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of sf_notifications
-- ----------------------------
INSERT INTO `sf_notifications` VALUES ('7', '3', null, '9', null, '15', 'http://http://sfzx.bb.com/user/message', '{\"order_sn\":\"\",\"money\":\"\",\"name\":\"asdasd\",\"goods_code\":\"\"}', '1', '2016-12-09 15:56:49', '2016-12-09 16:01:58', null, null);
INSERT INTO `sf_notifications` VALUES ('6', '3', null, '25', null, '19', 'http://http://sfzx.bb.com/user/message', '{\"order_sn\":\"YXZB20161010163230-56265\",\"money\":\"111\",\"name\":\"\",\"goods_code\":\"\"}', '1', '2016-11-21 17:36:59', '2016-11-22 14:13:38', null, null);
INSERT INTO `sf_notifications` VALUES ('8', '3', null, '9', null, '15', 'http://http://sfzx.bb.com/user/message', '{\"order_sn\":\"\",\"money\":\"\",\"name\":\"asdasd\",\"goods_code\":\"\"}', '1', '2016-12-09 15:58:22', '2016-12-09 16:02:01', null, null);
INSERT INTO `sf_notifications` VALUES ('9', '3', null, '9', null, '15', 'http://http://sfzx.bb.com/user/message', '{\"order_sn\":\"\",\"money\":\"\",\"name\":\"asdasd\",\"goods_code\":\"\"}', '1', '2016-12-09 15:58:42', '2016-12-09 16:02:03', null, null);
INSERT INTO `sf_notifications` VALUES ('10', '3', null, '9', null, '13', 'http://http://sfzx.bb.com/user/message', '{\"order_sn\":\"\",\"money\":\"\",\"name\":\"asdasd\",\"goods_code\":\"\"}', '0', '2016-12-09 16:14:19', '2016-12-09 16:14:19', null, null);
INSERT INTO `sf_notifications` VALUES ('11', '3', null, '25', null, '18', 'http://http://sfzx.bb.com/user/message', '{\"order_sn\":\"\",\"money\":\"\",\"name\":\"lirn_ld\",\"goods_code\":\"\"}', '0', '2016-12-09 16:59:25', '2016-12-09 16:59:25', null, null);
INSERT INTO `sf_notifications` VALUES ('12', '3', null, '25', null, '14', 'http://http://sfzx.bb.com/user/message', '{\"order_sn\":\"\",\"money\":\"\",\"name\":\"lirn_ld\",\"goods_code\":\"\"}', '0', '2016-12-09 17:00:28', '2016-12-09 17:00:28', null, null);
INSERT INTO `sf_notifications` VALUES ('13', '3', null, '25', null, '14', 'http://http://sfzx.bb.com/user/message', '{\"order_sn\":\"\",\"money\":\"\",\"name\":\"lirn_ld\",\"goods_code\":\"\"}', '0', '2016-12-09 17:02:27', '2016-12-09 17:02:27', null, null);
INSERT INTO `sf_notifications` VALUES ('14', '3', null, '25', null, '14', 'http://http://sfzx.bb.com/user/message', '{\"order_sn\":\"\",\"money\":\"\",\"name\":\"lirn_ld\",\"goods_code\":\"\"}', '0', '2016-12-09 17:12:11', '2016-12-09 17:12:11', null, null);
INSERT INTO `sf_notifications` VALUES ('15', '3', null, '25', null, '17', 'http://http://sfzx.bb.com/user/message', '{\"order_sn\":\"\\u53d1\\u5e03\\u6c42\\u964d\\u4ef7\\u7b49\\u591a\\u4e45\\u554a\",\"money\":\"\",\"name\":\"\",\"goods_code\":\"\"}', '0', '2016-12-12 17:44:55', '2016-12-12 17:44:55', null, null);
INSERT INTO `sf_notifications` VALUES ('16', '3', null, '2', null, '24', 'http://http://sfzx.bb.com/user/message', '{\"order_sn\":\"\",\"money\":\"\",\"name\":\"asd\",\"goods_code\":\"\"}', '0', '2016-12-13 10:49:32', '2016-12-13 10:49:32', null, null);
INSERT INTO `sf_notifications` VALUES ('17', '3', null, '9', null, '17', 'http://http://sfzx.bb.com/user/message', '{\"order_sn\":\"\\u5bc4\\u552e\\u662f\\u600e\\u4e48\\u6536\\u8d39\\u7684\\uff1f\",\"money\":\"\",\"name\":\"\",\"goods_code\":\"\"}', '1', '2016-12-13 12:06:18', '2016-12-13 13:49:10', null, null);
INSERT INTO `sf_notifications` VALUES ('18', '3', null, '9', null, '17', 'http://http://sfzx.bb.com/user/message', '{\"order_sn\":\"\\u600e\\u4e48\\u589e\\u52a0\\u5728\\u7ebf\\u5ba2\\u670d\\u5417\",\"money\":\"\",\"name\":\"\",\"goods_code\":\"\"}', '1', '2016-12-13 12:07:26', '2016-12-13 13:49:06', null, null);
INSERT INTO `sf_notifications` VALUES ('19', '3', null, '9', null, '5', 'http://http://sfzx.bb.com/user/message', '{\"order_sn\":\"DK2017011117521428478\",\"money\":\"\",\"name\":\"\",\"goods_code\":\"\"}', '0', '2017-01-11 17:52:15', '2017-01-11 17:52:15', null, null);
INSERT INTO `sf_notifications` VALUES ('20', '3', null, '9', null, '5', 'http://http://sfzx.bb.com/user/message', '{\"order_sn\":\"DK2017011117525661276\",\"money\":\"\",\"name\":\"\",\"goods_code\":\"\"}', '0', '2017-01-11 17:52:57', '2017-01-11 17:52:57', null, null);
INSERT INTO `sf_notifications` VALUES ('21', '3', null, '9', null, '5', 'http://http://sfzx.bb.com/user/message', '{\"order_sn\":\"DK2017011117533185439\",\"money\":\"\",\"name\":\"\",\"goods_code\":\"\"}', '0', '2017-01-11 17:53:32', '2017-01-11 17:53:32', null, null);
INSERT INTO `sf_notifications` VALUES ('22', '3', null, '9', null, '5', 'http://http://sfzx.bb.com/user/message', '{\"order_sn\":\"DK2017011117561199970\",\"money\":\"\",\"name\":\"\",\"goods_code\":\"\"}', '0', '2017-01-11 17:56:11', '2017-01-11 17:56:11', null, null);
INSERT INTO `sf_notifications` VALUES ('23', '3', null, '9', null, '25', 'http://http://sfzx.bb.com/user/message', '{\"order_sn\":\"DK2017011117521428478\",\"money\":\"50\",\"name\":\"\",\"goods_code\":\"\"}', '1', '2017-01-12 14:03:38', '2017-01-12 14:03:48', null, null);
INSERT INTO `sf_notifications` VALUES ('24', '3', null, '9', null, '5', 'http://http://sfzx.aa.com/user/message', '{\"order_sn\":\"DK2017011810470499277\",\"money\":\"\",\"name\":\"\",\"goods_code\":\"\"}', '0', '2017-01-18 10:47:05', '2017-01-18 10:47:05', null, null);
INSERT INTO `sf_notifications` VALUES ('25', '3', null, '9', null, '5', 'http://http://sfzx.aa.com/user/message', '{\"order_sn\":\"DK2017011812031818301\",\"money\":\"\",\"name\":\"\",\"goods_code\":\"\"}', '0', '2017-01-18 12:03:18', '2017-01-18 12:03:18', null, null);

-- ----------------------------
-- Table structure for `sf_notifications_categories_in_groups`
-- ----------------------------
DROP TABLE IF EXISTS `sf_notifications_categories_in_groups`;
CREATE TABLE `sf_notifications_categories_in_groups` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `category_id` int(10) unsigned NOT NULL,
  `group_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `notifications_categories_in_groups_category_id_index` (`category_id`),
  KEY `notifications_categories_in_groups_group_id_index` (`group_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of sf_notifications_categories_in_groups
-- ----------------------------

-- ----------------------------
-- Table structure for `sf_notification_categories`
-- ----------------------------
DROP TABLE IF EXISTS `sf_notification_categories`;
CREATE TABLE `sf_notification_categories` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `text` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `notification_categories_name_unique` (`name`),
  KEY `notification_categories_name_index` (`name`)
) ENGINE=MyISAM AUTO_INCREMENT=26 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of sf_notification_categories
-- ----------------------------
INSERT INTO `sf_notification_categories` VALUES ('3', 'user.order_cancel', '您的订单编号为{extra.order_sn}的交易已经取消，如有疑问请咨询客服');
INSERT INTO `sf_notification_categories` VALUES ('4', 'user.order_invalid', '您的订单编号为{extra.order_sn}的交易无效，如有疑问请咨询客服');
INSERT INTO `sf_notification_categories` VALUES ('5', 'user.order_payment', '您的订单编号为{extra.order_sn}付款成功，如有疑问请咨询客服');
INSERT INTO `sf_notification_categories` VALUES ('6', 'user.order_deliver', '您的订单编号为{extra.order_sn}的交易已经发货，请注意查收');
INSERT INTO `sf_notification_categories` VALUES ('7', 'seller.goods_sell', '您的商品编号为{extra.goods_code}的商品有人付款了，请及时发货');
INSERT INTO `sf_notification_categories` VALUES ('8', 'seller.goods_on_sale', '您的商品编号为{extra.goods_code}的商品已经审核通过了');
INSERT INTO `sf_notification_categories` VALUES ('9', 'seller.goods_error', '很遗憾，您的商品编号为{extra.goods_code}的商品审核失败了，请修改后重新提交');
INSERT INTO `sf_notification_categories` VALUES ('10', 'seller.cut_price', '您的商品编号为{extra.goods_code}的商品有一条新的砍价消息，请及时查看');
INSERT INTO `sf_notification_categories` VALUES ('11', 'user.idcard_pass', '恭喜您，你的实名认证申请已经通过审核！');
INSERT INTO `sf_notification_categories` VALUES ('12', 'user.idcard_error', '很遗憾，你的实名认证申请未通过！请重新提交申请');
INSERT INTO `sf_notification_categories` VALUES ('13', 'user.edit_pay_password', '{extra.name}您的支付密码修改成功。请妥善保管个人信息。');
INSERT INTO `sf_notification_categories` VALUES ('14', 'user.edit_ip', '{extra.name}您的IP绑定成功。请妥善保管个人信息。');
INSERT INTO `sf_notification_categories` VALUES ('15', 'user.edit_login_password', '{extra.name}您的登录密码成功。请妥善保管个人信息。');
INSERT INTO `sf_notification_categories` VALUES ('16', 'user.edit_answer', '{extra.name}您的密保问题成功。请妥善保管个人信息。');
INSERT INTO `sf_notification_categories` VALUES ('17', 'user.ask', '您的提问{extra.order_sn}客服已经回复，请前往查看。');
INSERT INTO `sf_notification_categories` VALUES ('18', 'user.edit_phone', '{extra.name}您的绑定手机已经变更。请妥善保管个人信息。');
INSERT INTO `sf_notification_categories` VALUES ('19', 'seller.money_change', '恭喜您，你的订单{extra.order_sn}已经交易完成，你获得的收益{extra.money}正在为你处理到相应账户中！');
INSERT INTO `sf_notification_categories` VALUES ('20', 'user.recharge', '{extra.name}您充值的金额{extra.money}已经充值成功。');
INSERT INTO `sf_notification_categories` VALUES ('21', 'user.withdrawal', '{extra.name}您提现的金额{extra.money}已经通过审核，近期请留意您的提现账户,如有疑问请咨询客服');
INSERT INTO `sf_notification_categories` VALUES ('22', 'user.exchange_goods', '{extra.name}您充值的金额{extra.money}已经充值成功。');
INSERT INTO `sf_notification_categories` VALUES ('23', 'user.withdrawal_error', '{extra.name}您提现的金额{extra.money}审核失败，请重新申请后提交,如有疑问请咨询客服');
INSERT INTO `sf_notification_categories` VALUES ('24', 'user.msg', '{extra.name}');
INSERT INTO `sf_notification_categories` VALUES ('25', 'user.order_refund', '您的订单编号为{extra.order_sn}的交易已取消，支付金额{extra.money}已退回余额，如有疑问请咨询客服');

-- ----------------------------
-- Table structure for `sf_notification_groups`
-- ----------------------------
DROP TABLE IF EXISTS `sf_notification_groups`;
CREATE TABLE `sf_notification_groups` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `notification_groups_name_unique` (`name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of sf_notification_groups
-- ----------------------------

-- ----------------------------
-- Table structure for `sf_order`
-- ----------------------------
DROP TABLE IF EXISTS `sf_order`;
CREATE TABLE `sf_order` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `order_type` tinyint(3) unsigned NOT NULL COMMENT '订单类型，0=寄售订单，1=担保订单，2=求购订单',
  `order_sn` varchar(255) NOT NULL DEFAULT '' COMMENT '订单编号',
  `user_id` int(10) unsigned NOT NULL,
  `order_status` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '订单状态;0未操作 1正在发货 2待确认收货 3交易成功 4交易取消 5无效 ',
  `pay_status` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '支付状态;0未付款;1已付款',
  `postmsg` varchar(255) NOT NULL DEFAULT '' COMMENT '订单附言',
  `pay_id` tinyint(3) unsigned NOT NULL COMMENT '支付方式id,0为余额支付，1为支付宝，2为微信，3混合支付',
  `pay_name` varchar(120) NOT NULL DEFAULT '' COMMENT '支付方式名称',
  `goods_price` decimal(10,2) NOT NULL COMMENT '商品单价',
  `goods_amount` decimal(10,2) unsigned NOT NULL COMMENT '商品总金额',
  `money_paid` decimal(10,2) unsigned NOT NULL COMMENT '已付款金额',
  `order_amount` decimal(10,2) unsigned NOT NULL COMMENT '应付款金额',
  `created_at` varchar(255) NOT NULL COMMENT '创建时间',
  `confirm_time` varchar(255) NOT NULL COMMENT '订单确认时间',
  `pay_time` varchar(255) NOT NULL COMMENT '支付时间',
  `pay_note` varchar(255) NOT NULL COMMENT '付款备注, 在订单管理编辑修改',
  `goods_id` int(10) unsigned NOT NULL,
  `buy_number` smallint(5) unsigned NOT NULL COMMENT '购买数量',
  `flag` varchar(255) DEFAULT NULL COMMENT '订单标识',
  `use_balance` decimal(10,2) unsigned DEFAULT NULL COMMENT '混合支付中记录使用多少余额',
  `updated_at` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=63 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of sf_order
-- ----------------------------
INSERT INTO `sf_order` VALUES ('62', '0', 'YXZB20161215165403-65856', '25', '0', '0', '', '0', '', '140.00', '140.00', '0.00', '140.00', '1481792355', '', '', '', '43', '1', null, '1.00', '1481792366');

-- ----------------------------
-- Table structure for `sf_order_action`
-- ----------------------------
DROP TABLE IF EXISTS `sf_order_action`;
CREATE TABLE `sf_order_action` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `order_id` int(10) unsigned NOT NULL COMMENT '订单id',
  `action_user_name` varchar(255) NOT NULL DEFAULT '' COMMENT '操作人姓名',
  `order_status` tinyint(3) unsigned NOT NULL COMMENT '订单状态;0未操作 1正在发货 2待确认收货 3交易成功 4交易取消 5无效',
  `pay_status` tinyint(3) unsigned NOT NULL COMMENT '支付状态 0未付款;  1已付款',
  `action_note` varchar(255) NOT NULL DEFAULT '' COMMENT '备注',
  `log_time` varchar(255) NOT NULL DEFAULT '' COMMENT '操作时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=53 DEFAULT CHARSET=utf8 COMMENT='订单操作日志表';

-- ----------------------------
-- Records of sf_order_action
-- ----------------------------

-- ----------------------------
-- Table structure for `sf_password_resets`
-- ----------------------------
DROP TABLE IF EXISTS `sf_password_resets`;
CREATE TABLE `sf_password_resets` (
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  KEY `password_resets_email_index` (`email`),
  KEY `password_resets_token_index` (`token`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of sf_password_resets
-- ----------------------------
INSERT INTO `sf_password_resets` VALUES ('215538462@qq.com', 'b71b28b89c565351752a08167294fe7d079eac5bed2a9375f8cf35562026d020', '2016-09-09 16:17:24');

-- ----------------------------
-- Table structure for `sf_payment`
-- ----------------------------
DROP TABLE IF EXISTS `sf_payment`;
CREATE TABLE `sf_payment` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `pay_name` varchar(255) NOT NULL DEFAULT '' COMMENT '支付名称',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='支付方式';

-- ----------------------------
-- Records of sf_payment
-- ----------------------------

-- ----------------------------
-- Table structure for `sf_pay_log`
-- ----------------------------
DROP TABLE IF EXISTS `sf_pay_log`;
CREATE TABLE `sf_pay_log` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `order_id` int(10) unsigned NOT NULL,
  `order_amount` decimal(10,2) unsigned NOT NULL COMMENT '支付金额',
  `is_paid` tinyint(3) unsigned NOT NULL COMMENT '是否已支付,0否;1是',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=utf8 COMMENT='支付记录';

-- ----------------------------
-- Records of sf_pay_log
-- ----------------------------
INSERT INTO `sf_pay_log` VALUES ('1', '31', '111.00', '1');
INSERT INTO `sf_pay_log` VALUES ('2', '32', '111.00', '1');
INSERT INTO `sf_pay_log` VALUES ('3', '34', '118.00', '1');
INSERT INTO `sf_pay_log` VALUES ('4', '47', '1.00', '1');
INSERT INTO `sf_pay_log` VALUES ('5', '53', '530.00', '1');
INSERT INTO `sf_pay_log` VALUES ('6', '56', '530.00', '1');
INSERT INTO `sf_pay_log` VALUES ('7', '57', '100.00', '1');
INSERT INTO `sf_pay_log` VALUES ('8', '58', '460.00', '1');
INSERT INTO `sf_pay_log` VALUES ('9', '59', '230.00', '1');
INSERT INTO `sf_pay_log` VALUES ('10', '60', '230.00', '1');
INSERT INTO `sf_pay_log` VALUES ('11', '36', '111.00', '1');

-- ----------------------------
-- Table structure for `sf_permissions`
-- ----------------------------
DROP TABLE IF EXISTS `sf_permissions`;
CREATE TABLE `sf_permissions` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `model` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `pid` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `permissions_slug_unique` (`slug`)
) ENGINE=MyISAM AUTO_INCREMENT=118 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='权限';

-- ----------------------------
-- Records of sf_permissions
-- ----------------------------
INSERT INTO `sf_permissions` VALUES ('1', 'Create news', 'create.news', '新增文章', null, '2016-08-10 10:43:59', '2016-08-10 10:43:59', '4');
INSERT INTO `sf_permissions` VALUES ('2', 'Delete news', 'delete.news', '删除文章', null, '2016-08-10 10:43:59', '2016-08-10 10:43:59', '4');
INSERT INTO `sf_permissions` VALUES ('3', 'Edit news', 'edit.news', '修改文章', null, '2016-08-10 14:05:50', '2016-08-10 14:05:52', '4');
INSERT INTO `sf_permissions` VALUES ('4', 'List news', 'list.news', '文章列表', null, '2016-08-10 14:07:44', '2016-08-10 14:07:46', '0');
INSERT INTO `sf_permissions` VALUES ('5', 'List artCate', 'list.artCate', '文章分类列表', null, '2016-08-10 14:08:59', '2016-08-10 14:09:01', '0');
INSERT INTO `sf_permissions` VALUES ('6', 'Create artCate', 'create.artCate', '新增文章分类', null, '2016-08-10 14:09:44', '2016-08-10 14:09:46', '5');
INSERT INTO `sf_permissions` VALUES ('7', 'Delete artCate', 'delete.artCate', '删除文章分类', null, '2016-08-10 14:10:22', '2016-08-10 14:10:24', '5');
INSERT INTO `sf_permissions` VALUES ('8', 'Edit artCate', 'edit.artCate', '修改文章分类', null, '2016-08-10 14:10:55', '2016-08-10 14:10:57', '5');
INSERT INTO `sf_permissions` VALUES ('9', 'Create admin', 'create.admin', '新增管理员', null, '2016-08-10 14:18:34', '2016-08-10 14:18:34', '12');
INSERT INTO `sf_permissions` VALUES ('10', 'Delete admin', 'delete.admin', '删除管理员', null, '2016-08-10 14:18:34', '2016-08-10 14:18:34', '12');
INSERT INTO `sf_permissions` VALUES ('11', 'Edit admin', 'edit.admin', '修改管理员', null, '2016-08-10 14:18:34', '2016-08-10 14:18:34', '12');
INSERT INTO `sf_permissions` VALUES ('12', 'List admin', 'list.admin', '管理员列表', null, '2016-08-10 14:18:34', '2016-08-10 14:18:34', '0');
INSERT INTO `sf_permissions` VALUES ('13', 'Create role', 'create.role', '新增角色', null, '2016-08-10 14:18:34', '2016-08-10 14:18:34', '16');
INSERT INTO `sf_permissions` VALUES ('14', 'Delete role', 'delete.role', '删除角色', null, '2016-08-10 14:18:34', '2016-08-10 14:18:34', '16');
INSERT INTO `sf_permissions` VALUES ('15', 'Edit role', 'edit.role', '修改角色', null, '2016-08-10 14:18:34', '2016-08-10 14:18:34', '16');
INSERT INTO `sf_permissions` VALUES ('16', 'List role', 'list.role', '角色列表', null, '2016-08-10 14:18:34', '2016-08-10 14:18:34', '0');
INSERT INTO `sf_permissions` VALUES ('17', 'Create config', 'create.config', '新增配置', null, '2016-08-10 14:21:14', '2016-08-10 14:21:14', '20');
INSERT INTO `sf_permissions` VALUES ('18', 'Delete config', 'delete.config', '删除配置', null, '2016-08-10 14:21:14', '2016-08-10 14:21:14', '20');
INSERT INTO `sf_permissions` VALUES ('19', 'Edit config', 'edit.config', '修改配置', null, '2016-08-10 14:21:14', '2016-08-10 14:21:14', '20');
INSERT INTO `sf_permissions` VALUES ('20', 'List config', 'list.config', '网站配置列表', null, '2016-08-10 14:21:14', '2016-08-10 14:21:14', '0');
INSERT INTO `sf_permissions` VALUES ('21', 'Create nav', 'create.nav', '新增自定义导航', null, '2016-08-10 14:21:14', '2016-08-10 14:21:14', '24');
INSERT INTO `sf_permissions` VALUES ('22', 'Delete nav', 'delete.nav', '删除自定义导航', null, '2016-08-10 14:21:14', '2016-08-10 14:21:14', '24');
INSERT INTO `sf_permissions` VALUES ('23', 'Edit nav', 'edit.nav', '修改自定义导航', null, '2016-08-10 14:21:14', '2016-08-10 14:21:14', '24');
INSERT INTO `sf_permissions` VALUES ('24', 'List nav', 'list.nav', '自定义导航列表', null, '2016-08-10 14:21:14', '2016-08-10 14:21:14', '0');
INSERT INTO `sf_permissions` VALUES ('25', 'Create link', 'create.link', '新增友情链接', null, '2016-08-10 14:22:39', '2016-08-10 14:22:39', '28');
INSERT INTO `sf_permissions` VALUES ('26', 'Delete link', 'delete.link', '删除友情链接', null, '2016-08-10 14:22:39', '2016-08-10 14:22:39', '28');
INSERT INTO `sf_permissions` VALUES ('27', 'Edit link', 'edit.link', '修改友情链接', null, '2016-08-10 14:22:39', '2016-08-10 14:22:39', '28');
INSERT INTO `sf_permissions` VALUES ('28', 'List link', 'list.link', '友情链接列表', null, '2016-08-10 14:22:39', '2016-08-10 14:22:39', '0');
INSERT INTO `sf_permissions` VALUES ('29', 'Create ad', 'create.ad', '新增广告', null, '2016-08-10 14:56:40', '2016-08-10 14:56:40', '32');
INSERT INTO `sf_permissions` VALUES ('30', 'Delete ad', 'delete.ad', '删除广告', null, '2016-08-10 14:56:40', '2016-08-10 14:56:40', '32');
INSERT INTO `sf_permissions` VALUES ('31', 'Edit ad', 'edit.ad', '修改广告', null, '2016-08-10 14:56:40', '2016-08-10 14:56:40', '32');
INSERT INTO `sf_permissions` VALUES ('32', 'List ad', 'list.ad', '广告列表', null, '2016-08-10 14:56:40', '2016-08-10 14:56:40', '0');
INSERT INTO `sf_permissions` VALUES ('33', 'Create adPosition', 'create.adposition', '新增广告位置', null, '2016-08-10 14:57:43', '2016-08-10 14:57:43', '36');
INSERT INTO `sf_permissions` VALUES ('34', 'Delete adPosition', 'delete.adposition', '删除广告位置', null, '2016-08-10 14:57:43', '2016-08-10 14:57:43', '36');
INSERT INTO `sf_permissions` VALUES ('35', 'Edit adPosition', 'edit.adposition', '修改广告位置', null, '2016-08-10 14:57:43', '2016-08-10 14:57:43', '36');
INSERT INTO `sf_permissions` VALUES ('36', 'List adPosition', 'list.adposition', '广告位置列表', null, '2016-08-10 14:57:43', '2016-08-10 14:57:43', '0');
INSERT INTO `sf_permissions` VALUES ('37', 'Create menu', 'create.menu', '创建菜单', null, '2016-08-11 10:35:13', '2016-08-11 10:35:17', '40');
INSERT INTO `sf_permissions` VALUES ('38', 'Delete menu', 'delete.menu', '删除菜单', null, '2016-08-11 10:35:49', '2016-08-11 10:35:52', '40');
INSERT INTO `sf_permissions` VALUES ('39', 'Edit menu', 'edit.menu', '修改菜单', null, '2016-08-11 10:36:22', '2016-08-11 10:36:24', '40');
INSERT INTO `sf_permissions` VALUES ('40', 'List menu', 'list.menu', '菜单列表', null, '2016-08-11 10:37:21', '2016-08-11 10:37:23', '0');
INSERT INTO `sf_permissions` VALUES ('41', 'List log', 'list.log', '日志列表', null, '2016-08-12 14:58:03', '2016-08-12 14:58:05', '12');
INSERT INTO `sf_permissions` VALUES ('42', 'List game', 'list.game', '游戏列表', null, '2016-08-12 18:25:51', '2016-08-12 18:25:54', '0');
INSERT INTO `sf_permissions` VALUES ('43', 'List categame', 'list.categame', '游戏分类列表', null, '2016-08-12 18:26:59', '2016-08-12 18:27:02', '0');
INSERT INTO `sf_permissions` VALUES ('44', 'Create game', 'create.game', '新增游戏', null, '2016-08-17 09:52:46', '2016-08-17 09:52:49', '42');
INSERT INTO `sf_permissions` VALUES ('45', 'Delete game', 'delete.game', '删除游戏', null, '2016-08-17 09:53:25', '2016-08-17 09:53:27', '42');
INSERT INTO `sf_permissions` VALUES ('46', 'Edit game', 'edit.game', '修改游戏', null, '2016-08-17 09:54:04', '2016-08-17 09:54:06', '42');
INSERT INTO `sf_permissions` VALUES ('47', 'Create categame', 'create.categame', '新增游戏分类', null, '2016-08-17 09:55:53', '2016-08-17 09:55:55', '43');
INSERT INTO `sf_permissions` VALUES ('48', 'Delete categame', 'delete.categame', '删除游戏分类', null, '2016-08-17 09:56:37', '2016-08-17 09:56:40', '43');
INSERT INTO `sf_permissions` VALUES ('49', 'Edit categame', 'edit.categame', '修改游戏分类', null, '2016-08-17 09:57:15', '2016-08-17 09:57:18', '43');
INSERT INTO `sf_permissions` VALUES ('50', 'List goodsgame', 'list.goodsgame', '游戏商品列表', null, '2016-08-17 09:58:03', '2016-08-17 09:58:05', '0');
INSERT INTO `sf_permissions` VALUES ('51', 'Create goodsgame', 'create.goodsgame', '新增游戏商品', null, '2016-08-17 09:58:50', '2016-08-17 09:58:52', '50');
INSERT INTO `sf_permissions` VALUES ('52', 'Delete goodsgame', 'delete.goodsgame', '删除游戏商品', null, '2016-08-17 09:59:28', '2016-08-17 09:59:31', '50');
INSERT INTO `sf_permissions` VALUES ('53', 'Edit goodsgame', 'edit.goodsgame', '修改游戏商品', null, '2016-08-17 10:00:17', '2016-08-17 10:00:19', '50');
INSERT INTO `sf_permissions` VALUES ('54', 'List goodsattribute', 'list.goodsattribute', '游戏属性列表', null, '2016-08-26 16:14:30', '2016-08-26 16:14:34', '0');
INSERT INTO `sf_permissions` VALUES ('55', 'Create goodsattribute', 'create.goodsattribute', '添加游戏属性', null, '2016-08-26 16:15:24', '2016-08-26 16:15:26', '54');
INSERT INTO `sf_permissions` VALUES ('56', 'Delete goodsattribute', 'delete.goodsattribute', '删除游戏属性', null, '2016-08-26 16:15:51', '2016-08-26 16:15:53', '54');
INSERT INTO `sf_permissions` VALUES ('57', 'Edit goodsattribute', 'edit.goodsattribute', '修改游戏属性', null, '2016-08-26 16:16:17', '2016-08-26 16:16:19', '54');
INSERT INTO `sf_permissions` VALUES ('58', 'Check goodsgame', 'check.goodsgame', '审核游戏商品', null, '2016-08-31 14:30:00', '2016-08-31 14:30:02', '50');
INSERT INTO `sf_permissions` VALUES ('59', 'List trash', 'list.trash', '回收站', null, '2016-08-31 14:35:07', '2016-08-31 14:35:09', '0');
INSERT INTO `sf_permissions` VALUES ('60', 'clear stock', 'clear.stock', '清理库存', null, '2016-09-01 11:39:48', '2016-09-01 11:39:51', '50');
INSERT INTO `sf_permissions` VALUES ('61', 'clear expired', 'clear.expired', '清理到期', null, '2016-09-01 11:40:35', '2016-09-01 11:40:37', '50');
INSERT INTO `sf_permissions` VALUES ('62', 'Delete trash', 'delete.trash', '回收站删除', null, '2016-09-01 14:08:51', '2016-09-01 14:08:54', '59');
INSERT INTO `sf_permissions` VALUES ('63', 'recovery trash', 'recovery trash', '回收站恢复', null, '2016-09-01 14:10:02', '2016-09-01 14:10:04', '59');
INSERT INTO `sf_permissions` VALUES ('64', 'List user', 'list.user', '会员列表', null, '2016-09-01 14:10:37', '2016-09-01 14:10:39', '0');
INSERT INTO `sf_permissions` VALUES ('65', 'Detele user', 'delete.user', '删除会员', null, '2016-09-01 14:11:04', '2016-09-01 14:11:06', '64');
INSERT INTO `sf_permissions` VALUES ('66', 'Create user', 'create.user', '新增会员', null, '2016-09-01 14:11:36', '2016-09-01 14:11:38', '64');
INSERT INTO `sf_permissions` VALUES ('67', 'Edit user', 'edit.user', '修改会员', null, '2016-09-01 14:12:04', '2016-09-01 14:12:06', '64');
INSERT INTO `sf_permissions` VALUES ('68', 'List account', 'list.account', '账目明细', null, '2016-09-06 10:18:27', '2016-09-06 10:18:30', '64');
INSERT INTO `sf_permissions` VALUES ('69', 'Create account', 'create.account', '调节账户', null, '2016-09-06 10:19:19', '2016-09-06 10:19:22', '64');
INSERT INTO `sf_permissions` VALUES ('70', 'List order', 'list.order', '订单列表', null, '2016-09-06 10:49:07', '2016-09-06 10:49:09', '0');
INSERT INTO `sf_permissions` VALUES ('71', 'Edit order', 'edit.order', '修改订单', null, '2016-09-06 10:50:14', '2016-09-06 10:50:20', '70');
INSERT INTO `sf_permissions` VALUES ('72', 'List user_account', 'list.user_account', '充值提现列表', null, '2016-09-07 14:14:52', '2016-09-07 14:14:55', '0');
INSERT INTO `sf_permissions` VALUES ('73', 'Edit user_account', 'edit.user_account', '审核充值提现', null, '2016-09-07 14:17:02', '2016-09-07 14:17:04', '72');
INSERT INTO `sf_permissions` VALUES ('74', 'Delete user_account', 'delete.user_account', '删除充值提现', null, '2016-09-07 14:18:10', '2016-09-07 14:18:12', '72');
INSERT INTO `sf_permissions` VALUES ('75', 'List user_rank', 'list.user_rank', '会员等级', null, '2016-09-07 16:46:45', '2016-09-07 16:46:47', '0');
INSERT INTO `sf_permissions` VALUES ('76', 'Create user_rank', 'create.user_rank', '创建会员等级', null, '2016-09-07 16:47:31', '2016-09-07 16:47:33', '75');
INSERT INTO `sf_permissions` VALUES ('77', 'Edit user_rank', 'edit.user_rank', '修改会员等级', null, '2016-09-07 16:48:10', '2016-09-07 16:48:12', '75');
INSERT INTO `sf_permissions` VALUES ('78', 'Delete user_rank', 'delete.user_rank', '删除会员等级', null, '2016-09-07 16:48:54', '2016-09-07 16:48:56', '75');
INSERT INTO `sf_permissions` VALUES ('79', 'Create order', 'create.order', '新增订单', null, '2016-09-14 14:37:07', '2016-09-14 14:37:10', '70');
INSERT INTO `sf_permissions` VALUES ('80', 'Delete order', 'delete.order', '删除订单', null, '2016-09-14 14:37:57', '2016-09-14 14:38:01', '70');
INSERT INTO `sf_permissions` VALUES ('81', 'All order', 'all.order', '批量操作订单', null, '2016-09-14 14:38:54', '2016-09-14 14:38:56', '70');
INSERT INTO `sf_permissions` VALUES ('82', 'Edit user info', 'edit.user.info', '修改收货信息', null, '2016-09-14 14:40:00', '2016-09-14 14:40:02', '70');
INSERT INTO `sf_permissions` VALUES ('83', 'Edit money', 'edit.money', '修改订单金额', null, '2016-09-14 14:40:41', '2016-09-14 14:40:45', '70');
INSERT INTO `sf_permissions` VALUES ('84', 'List banner', 'list.banner', '轮播图列表', null, '2016-09-20 16:16:26', '2016-09-20 16:16:28', '0');
INSERT INTO `sf_permissions` VALUES ('85', 'Create banner', 'create.banner', '新增轮播图', null, '2016-09-20 16:17:00', '2016-09-20 16:17:02', '84');
INSERT INTO `sf_permissions` VALUES ('86', 'Edit banner', 'edit.banner', '修改轮播图', null, '2016-09-20 16:17:32', '2016-09-20 16:17:35', '84');
INSERT INTO `sf_permissions` VALUES ('87', 'Delete banner', 'delete.banner', '删除轮播图', null, '2016-09-20 16:18:01', '2016-09-20 16:18:17', '84');
INSERT INTO `sf_permissions` VALUES ('88', 'List exchange', 'list.exchange', '积分商品', null, '2016-11-14 11:21:58', '2016-11-14 11:22:00', '0');
INSERT INTO `sf_permissions` VALUES ('89', 'Create exchange', 'create.exchange', '新增积分商品', null, '2016-11-14 11:26:22', '2016-11-14 11:26:25', '88');
INSERT INTO `sf_permissions` VALUES ('90', 'Edit exchange', 'edit.exchange', '修改积分商品', null, '2016-11-14 11:26:56', '2016-11-14 11:26:58', '88');
INSERT INTO `sf_permissions` VALUES ('91', 'Delete exchange', 'delete.exchange', '删除积分商品', null, '2016-11-14 11:27:31', '2016-11-14 11:27:33', '88');
INSERT INTO `sf_permissions` VALUES ('92', 'List exchange_order', 'list.exchange_order', '积分商品订单', null, '2016-11-14 16:38:49', '2016-11-14 16:38:51', '0');
INSERT INTO `sf_permissions` VALUES ('93', 'Create exchange_order', 'create.exchange_order', '新增积分商品订单', null, '2016-11-14 16:39:47', '2016-11-14 16:39:49', '92');
INSERT INTO `sf_permissions` VALUES ('94', 'Edit exchange_order', 'edit.exchange_order', '修改积分商品订单', null, '2016-11-14 16:40:18', '2016-11-14 16:40:20', '92');
INSERT INTO `sf_permissions` VALUES ('95', 'Delete exchange_order', 'delete.exchange_order', '删除积分商品订单', null, '2016-11-14 16:40:50', '2016-11-14 16:40:52', '92');
INSERT INTO `sf_permissions` VALUES ('96', 'List ask', 'list.ask', '咨询列表', null, '2016-11-15 16:27:47', '2016-11-15 16:27:49', '0');
INSERT INTO `sf_permissions` VALUES ('97', 'Create ask', 'create.ask', '添加咨询', null, '2016-11-15 16:28:13', '2016-11-15 16:28:15', '96');
INSERT INTO `sf_permissions` VALUES ('98', 'Edit ask', 'edit.ask', '修改咨询', null, '2016-11-15 16:29:28', '2016-11-15 16:29:30', '96');
INSERT INTO `sf_permissions` VALUES ('99', 'Delete ask', 'delete.ask', '删除咨询', null, '2016-11-15 16:30:07', '2016-11-15 16:30:09', '96');
INSERT INTO `sf_permissions` VALUES ('100', 'List advise', 'list.advise', '建议列表', null, '2016-11-15 16:31:36', '2016-11-15 16:31:37', '0');
INSERT INTO `sf_permissions` VALUES ('101', 'Create advise', 'create.advise', '新增建议', null, '2016-11-15 16:32:02', '2016-11-15 16:32:04', '100');
INSERT INTO `sf_permissions` VALUES ('102', 'Edit advise', 'edit.advise', '修改建议', null, '2016-11-15 16:32:25', '2016-11-15 16:32:27', '100');
INSERT INTO `sf_permissions` VALUES ('103', 'Delete advise', 'delete.advise', '删除建议', null, '2016-11-15 16:32:47', '2016-11-15 16:32:48', '100');
INSERT INTO `sf_permissions` VALUES ('104', 'List complain', 'list.complain', '投诉列表', null, '2016-11-15 16:33:36', '2016-11-15 16:33:38', '0');
INSERT INTO `sf_permissions` VALUES ('105', 'Create complain', 'create.complain', '新增投诉', null, '2016-11-15 16:34:19', '2016-11-15 16:34:21', '104');
INSERT INTO `sf_permissions` VALUES ('106', 'Edit complain', 'edit.complain', '修改投诉', null, '2016-11-15 16:34:52', '2016-11-15 16:34:55', '104');
INSERT INTO `sf_permissions` VALUES ('107', 'Delete complain', 'delete.complain', '删除投诉', null, '2016-11-15 16:35:17', '2016-11-15 16:35:19', '14');
INSERT INTO `sf_permissions` VALUES ('108', 'List application', 'list.application', '异常申请列表', null, '2016-11-22 14:44:30', '2016-11-22 14:44:32', '0');
INSERT INTO `sf_permissions` VALUES ('109', 'Create application', 'create.application', '新增异常申请', null, '2016-11-22 14:45:23', '2016-11-22 14:45:26', '108');
INSERT INTO `sf_permissions` VALUES ('110', 'Edit application', 'edit.application', '修改异常申请', null, '2016-11-22 14:45:52', '2016-11-22 14:45:54', '108');
INSERT INTO `sf_permissions` VALUES ('111', 'Delete application', 'delete.application', '删除异常申请', null, '2016-11-22 14:46:35', '2016-11-22 14:46:37', '108');
INSERT INTO `sf_permissions` VALUES ('112', 'Order stats', 'order.stats', '订单统计', null, '2016-12-01 15:22:00', '2016-12-01 15:22:02', '0');
INSERT INTO `sf_permissions` VALUES ('113', 'Sale general', 'sale.general', '销售概况', null, '2016-12-01 15:37:17', '2016-12-01 15:37:20', '0');
INSERT INTO `sf_permissions` VALUES ('114', 'Sale list', 'sale.list', '销售明细', null, '2016-12-01 15:38:33', '2016-12-01 15:38:35', '0');
INSERT INTO `sf_permissions` VALUES ('115', 'DK config', 'dk.config', '点卡设置', null, '2016-12-23 15:07:51', '2016-12-23 15:07:52', '0');
INSERT INTO `sf_permissions` VALUES ('116', 'Dk list', 'dk.list', '点卡充值订单列表', null, '2016-12-23 15:08:47', '2016-12-23 15:08:49', '0');
INSERT INTO `sf_permissions` VALUES ('117', 'Dk game_list', 'dk.game_list', '点卡游戏列表', null, '2016-12-29 17:19:16', '2016-12-29 17:19:18', '0');

-- ----------------------------
-- Table structure for `sf_permission_role`
-- ----------------------------
DROP TABLE IF EXISTS `sf_permission_role`;
CREATE TABLE `sf_permission_role` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `permission_id` int(10) unsigned NOT NULL,
  `role_id` int(10) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `permission_role_permission_id_index` (`permission_id`),
  KEY `permission_role_role_id_index` (`role_id`)
) ENGINE=MyISAM AUTO_INCREMENT=160 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='权限与角色关系';

-- ----------------------------
-- Records of sf_permission_role
-- ----------------------------
INSERT INTO `sf_permission_role` VALUES ('1', '1', '1', '2016-08-10 10:43:59', '2016-08-10 10:43:59');
INSERT INTO `sf_permission_role` VALUES ('2', '2', '1', '2016-08-10 10:44:39', '2016-08-10 10:44:42');
INSERT INTO `sf_permission_role` VALUES ('76', '24', '2', '2016-08-12 10:00:42', '2016-08-12 10:00:42');
INSERT INTO `sf_permission_role` VALUES ('4', '3', '1', '2016-08-10 14:25:25', '2016-08-10 14:25:25');
INSERT INTO `sf_permission_role` VALUES ('5', '4', '1', '2016-08-10 14:25:25', '2016-08-10 14:25:25');
INSERT INTO `sf_permission_role` VALUES ('6', '5', '1', '2016-08-10 14:25:25', '2016-08-10 14:25:25');
INSERT INTO `sf_permission_role` VALUES ('7', '6', '1', '2016-08-10 14:25:25', '2016-08-10 14:25:25');
INSERT INTO `sf_permission_role` VALUES ('8', '7', '1', '2016-08-10 14:25:25', '2016-08-10 14:25:25');
INSERT INTO `sf_permission_role` VALUES ('9', '8', '1', '2016-08-10 14:25:25', '2016-08-10 14:25:25');
INSERT INTO `sf_permission_role` VALUES ('10', '9', '1', '2016-08-10 14:25:25', '2016-08-10 14:25:25');
INSERT INTO `sf_permission_role` VALUES ('11', '10', '1', '2016-08-10 14:25:25', '2016-08-10 14:25:25');
INSERT INTO `sf_permission_role` VALUES ('12', '11', '1', '2016-08-10 14:25:25', '2016-08-10 14:25:25');
INSERT INTO `sf_permission_role` VALUES ('13', '12', '1', '2016-08-10 14:25:25', '2016-08-10 14:25:25');
INSERT INTO `sf_permission_role` VALUES ('14', '13', '1', '2016-08-10 14:25:25', '2016-08-10 14:25:25');
INSERT INTO `sf_permission_role` VALUES ('15', '14', '1', '2016-08-10 14:25:25', '2016-08-10 14:25:25');
INSERT INTO `sf_permission_role` VALUES ('16', '15', '1', '2016-08-10 14:25:25', '2016-08-10 14:25:25');
INSERT INTO `sf_permission_role` VALUES ('17', '16', '1', '2016-08-10 14:25:25', '2016-08-10 14:25:25');
INSERT INTO `sf_permission_role` VALUES ('18', '17', '1', '2016-08-10 14:25:25', '2016-08-10 14:25:25');
INSERT INTO `sf_permission_role` VALUES ('19', '18', '1', '2016-08-10 14:25:25', '2016-08-10 14:25:25');
INSERT INTO `sf_permission_role` VALUES ('20', '19', '1', '2016-08-10 14:25:25', '2016-08-10 14:25:25');
INSERT INTO `sf_permission_role` VALUES ('21', '20', '1', '2016-08-10 14:25:25', '2016-08-10 14:25:25');
INSERT INTO `sf_permission_role` VALUES ('22', '21', '1', '2016-08-10 14:25:25', '2016-08-10 14:25:25');
INSERT INTO `sf_permission_role` VALUES ('23', '22', '1', '2016-08-10 14:25:25', '2016-08-10 14:25:25');
INSERT INTO `sf_permission_role` VALUES ('24', '23', '1', '2016-08-10 14:25:25', '2016-08-10 14:25:25');
INSERT INTO `sf_permission_role` VALUES ('25', '24', '1', '2016-08-10 14:25:25', '2016-08-10 14:25:25');
INSERT INTO `sf_permission_role` VALUES ('26', '25', '1', '2016-08-10 14:25:25', '2016-08-10 14:25:25');
INSERT INTO `sf_permission_role` VALUES ('27', '26', '1', '2016-08-10 14:25:25', '2016-08-10 14:25:25');
INSERT INTO `sf_permission_role` VALUES ('28', '27', '1', '2016-08-10 14:25:25', '2016-08-10 14:25:25');
INSERT INTO `sf_permission_role` VALUES ('29', '28', '1', '2016-08-10 14:25:25', '2016-08-10 14:25:25');
INSERT INTO `sf_permission_role` VALUES ('30', '29', '1', '2016-08-10 14:59:26', '2016-08-10 14:59:26');
INSERT INTO `sf_permission_role` VALUES ('31', '30', '1', '2016-08-10 14:59:26', '2016-08-10 14:59:26');
INSERT INTO `sf_permission_role` VALUES ('32', '31', '1', '2016-08-10 14:59:26', '2016-08-10 14:59:26');
INSERT INTO `sf_permission_role` VALUES ('33', '32', '1', '2016-08-10 14:59:26', '2016-08-10 14:59:26');
INSERT INTO `sf_permission_role` VALUES ('34', '33', '1', '2016-08-10 14:59:26', '2016-08-10 14:59:26');
INSERT INTO `sf_permission_role` VALUES ('35', '34', '1', '2016-08-10 14:59:26', '2016-08-10 14:59:26');
INSERT INTO `sf_permission_role` VALUES ('36', '35', '1', '2016-08-10 14:59:26', '2016-08-10 14:59:26');
INSERT INTO `sf_permission_role` VALUES ('37', '36', '1', '2016-08-10 14:59:26', '2016-08-10 14:59:26');
INSERT INTO `sf_permission_role` VALUES ('75', '29', '2', '2016-08-12 10:00:42', '2016-08-12 10:00:42');
INSERT INTO `sf_permission_role` VALUES ('40', '37', '1', '2016-08-11 10:38:18', '2016-08-11 10:38:20');
INSERT INTO `sf_permission_role` VALUES ('41', '38', '1', '2016-08-11 10:38:27', '2016-08-11 10:38:30');
INSERT INTO `sf_permission_role` VALUES ('42', '39', '1', '2016-08-11 10:38:38', '2016-08-11 10:38:40');
INSERT INTO `sf_permission_role` VALUES ('43', '40', '1', '2016-08-11 10:38:50', '2016-08-11 10:38:52');
INSERT INTO `sf_permission_role` VALUES ('69', '4', '9', '2016-08-11 18:16:58', '2016-08-11 18:16:58');
INSERT INTO `sf_permission_role` VALUES ('66', '1', '9', '2016-08-11 18:16:58', '2016-08-11 18:16:58');
INSERT INTO `sf_permission_role` VALUES ('68', '3', '9', '2016-08-11 18:16:58', '2016-08-11 18:16:58');
INSERT INTO `sf_permission_role` VALUES ('82', '41', '1', '2016-08-12 15:01:58', '2016-08-12 15:02:00');
INSERT INTO `sf_permission_role` VALUES ('80', '33', '2', '2016-08-12 10:32:50', '2016-08-12 10:32:50');
INSERT INTO `sf_permission_role` VALUES ('79', '32', '2', '2016-08-12 10:31:21', '2016-08-12 10:31:21');
INSERT INTO `sf_permission_role` VALUES ('67', '2', '9', '2016-08-11 18:16:58', '2016-08-11 18:16:58');
INSERT INTO `sf_permission_role` VALUES ('78', '16', '2', '2016-08-12 10:31:21', '2016-08-12 10:31:21');
INSERT INTO `sf_permission_role` VALUES ('77', '4', '2', '2016-08-12 10:31:21', '2016-08-12 10:31:21');
INSERT INTO `sf_permission_role` VALUES ('81', '36', '2', '2016-08-12 10:32:50', '2016-08-12 10:32:50');
INSERT INTO `sf_permission_role` VALUES ('74', '13', '2', '2016-08-12 10:00:42', '2016-08-12 10:00:42');
INSERT INTO `sf_permission_role` VALUES ('73', '1', '2', '2016-08-12 10:00:42', '2016-08-12 10:00:42');
INSERT INTO `sf_permission_role` VALUES ('83', '42', '1', '2016-08-12 18:34:34', '2016-08-12 18:34:37');
INSERT INTO `sf_permission_role` VALUES ('84', '43', '1', '2016-08-12 18:34:43', '2016-08-12 18:34:46');
INSERT INTO `sf_permission_role` VALUES ('85', '44', '1', '2016-08-17 10:01:28', '2016-08-17 10:01:30');
INSERT INTO `sf_permission_role` VALUES ('86', '45', '1', '2016-08-17 10:01:33', '2016-08-17 10:01:35');
INSERT INTO `sf_permission_role` VALUES ('87', '46', '1', '2016-08-17 10:01:48', '2016-08-17 10:01:50');
INSERT INTO `sf_permission_role` VALUES ('88', '47', '1', '2016-08-17 10:02:15', '2016-08-17 10:02:18');
INSERT INTO `sf_permission_role` VALUES ('89', '48', '1', '2016-08-17 10:02:26', '2016-08-17 10:02:29');
INSERT INTO `sf_permission_role` VALUES ('90', '49', '1', '2016-08-17 10:02:37', '2016-08-17 10:02:39');
INSERT INTO `sf_permission_role` VALUES ('91', '50', '1', '2016-08-17 10:02:58', '2016-08-17 10:03:01');
INSERT INTO `sf_permission_role` VALUES ('92', '51', '1', '2016-08-17 10:03:07', '2016-08-17 10:03:09');
INSERT INTO `sf_permission_role` VALUES ('93', '52', '1', '2016-08-17 10:03:16', '2016-08-17 10:03:18');
INSERT INTO `sf_permission_role` VALUES ('94', '53', '1', '2016-08-17 10:03:25', '2016-08-17 10:03:27');
INSERT INTO `sf_permission_role` VALUES ('95', '54', '1', '2016-08-26 16:19:21', '2016-08-26 16:19:24');
INSERT INTO `sf_permission_role` VALUES ('96', '55', '1', '2016-08-26 16:19:29', '2016-08-26 16:19:32');
INSERT INTO `sf_permission_role` VALUES ('97', '56', '1', '2016-08-26 16:19:38', '2016-08-26 16:19:40');
INSERT INTO `sf_permission_role` VALUES ('98', '57', '1', '2016-08-26 16:19:46', '2016-08-26 16:19:49');
INSERT INTO `sf_permission_role` VALUES ('100', '58', '1', '2016-08-31 14:32:19', '2016-08-31 14:32:21');
INSERT INTO `sf_permission_role` VALUES ('101', '59', '1', '2016-08-31 14:51:01', '2016-08-31 14:51:04');
INSERT INTO `sf_permission_role` VALUES ('102', '60', '1', '2016-09-01 14:12:33', '2016-09-01 14:12:35');
INSERT INTO `sf_permission_role` VALUES ('103', '61', '1', '2016-09-01 14:12:42', '2016-09-01 14:12:45');
INSERT INTO `sf_permission_role` VALUES ('104', '62', '1', '2016-09-01 14:12:51', '2016-09-01 14:12:53');
INSERT INTO `sf_permission_role` VALUES ('105', '63', '1', '2016-09-01 14:13:00', '2016-09-01 14:13:02');
INSERT INTO `sf_permission_role` VALUES ('106', '64', '1', '2016-09-01 14:13:10', '2016-09-01 14:13:12');
INSERT INTO `sf_permission_role` VALUES ('107', '65', '1', '2016-09-01 14:13:17', '2016-09-01 14:13:19');
INSERT INTO `sf_permission_role` VALUES ('108', '66', '1', '2016-09-01 14:13:25', '2016-09-01 14:13:27');
INSERT INTO `sf_permission_role` VALUES ('109', '67', '1', '2016-09-01 14:13:32', '2016-09-01 14:13:34');
INSERT INTO `sf_permission_role` VALUES ('110', '68', '1', '2016-09-06 10:19:52', '2016-09-06 10:19:54');
INSERT INTO `sf_permission_role` VALUES ('111', '69', '1', '2016-09-06 10:20:03', '2016-09-06 10:20:05');
INSERT INTO `sf_permission_role` VALUES ('112', '70', '1', '2016-09-06 11:03:19', '2016-09-06 11:03:22');
INSERT INTO `sf_permission_role` VALUES ('113', '71', '1', '2016-09-06 11:03:29', '2016-09-06 11:03:32');
INSERT INTO `sf_permission_role` VALUES ('114', '72', '1', '2016-09-07 14:18:41', '2016-09-07 14:18:43');
INSERT INTO `sf_permission_role` VALUES ('115', '73', '1', '2016-09-07 14:18:57', '2016-09-07 14:19:05');
INSERT INTO `sf_permission_role` VALUES ('116', '74', '1', '2016-09-07 14:19:12', '2016-09-07 14:19:14');
INSERT INTO `sf_permission_role` VALUES ('117', '75', '1', '2016-09-07 16:49:19', '2016-09-07 16:49:21');
INSERT INTO `sf_permission_role` VALUES ('118', '76', '1', '2016-09-07 16:49:28', '2016-09-07 16:49:31');
INSERT INTO `sf_permission_role` VALUES ('119', '77', '1', '2016-09-07 16:49:37', '2016-09-07 16:49:39');
INSERT INTO `sf_permission_role` VALUES ('120', '78', '1', '2016-09-07 16:49:45', '2016-09-07 16:49:47');
INSERT INTO `sf_permission_role` VALUES ('121', '79', '1', '2016-09-14 14:44:44', '2016-09-14 14:44:46');
INSERT INTO `sf_permission_role` VALUES ('122', '80', '1', '2016-09-14 14:44:52', '2016-09-14 14:44:54');
INSERT INTO `sf_permission_role` VALUES ('123', '81', '1', '2016-09-14 14:45:00', '2016-09-14 14:45:03');
INSERT INTO `sf_permission_role` VALUES ('124', '82', '1', '2016-09-14 14:45:10', '2016-09-14 14:45:12');
INSERT INTO `sf_permission_role` VALUES ('125', '83', '1', '2016-09-14 14:45:17', '2016-09-14 14:45:19');
INSERT INTO `sf_permission_role` VALUES ('126', '84', '1', '2016-09-20 16:18:47', '2016-09-20 16:18:49');
INSERT INTO `sf_permission_role` VALUES ('127', '85', '1', '2016-09-20 16:18:54', '2016-09-20 16:18:56');
INSERT INTO `sf_permission_role` VALUES ('128', '86', '1', '2016-09-20 16:19:03', '2016-09-20 16:19:05');
INSERT INTO `sf_permission_role` VALUES ('129', '87', '1', '2016-09-20 16:19:11', '2016-09-20 16:19:14');
INSERT INTO `sf_permission_role` VALUES ('130', '88', '1', '2016-11-14 11:23:22', '2016-11-14 11:23:25');
INSERT INTO `sf_permission_role` VALUES ('131', '89', '1', '2016-11-14 11:27:47', '2016-11-14 11:27:50');
INSERT INTO `sf_permission_role` VALUES ('132', '90', '1', '2016-11-14 11:28:00', '2016-11-14 11:28:02');
INSERT INTO `sf_permission_role` VALUES ('133', '91', '1', '2016-11-14 11:28:08', '2016-11-14 11:28:10');
INSERT INTO `sf_permission_role` VALUES ('134', '92', '1', '2016-11-14 16:42:06', '2016-11-14 16:42:08');
INSERT INTO `sf_permission_role` VALUES ('135', '93', '1', '2016-11-14 16:42:14', '2016-11-14 16:42:16');
INSERT INTO `sf_permission_role` VALUES ('136', '94', '1', '2016-11-14 16:42:21', '2016-11-14 16:42:23');
INSERT INTO `sf_permission_role` VALUES ('137', '95', '1', '2016-11-14 16:42:29', '2016-11-14 16:42:31');
INSERT INTO `sf_permission_role` VALUES ('138', '96', '1', null, null);
INSERT INTO `sf_permission_role` VALUES ('139', '97', '1', null, null);
INSERT INTO `sf_permission_role` VALUES ('140', '98', '1', null, null);
INSERT INTO `sf_permission_role` VALUES ('141', '99', '1', null, null);
INSERT INTO `sf_permission_role` VALUES ('142', '100', '1', null, null);
INSERT INTO `sf_permission_role` VALUES ('143', '101', '1', null, null);
INSERT INTO `sf_permission_role` VALUES ('144', '102', '1', null, null);
INSERT INTO `sf_permission_role` VALUES ('145', '103', '1', null, null);
INSERT INTO `sf_permission_role` VALUES ('146', '104', '1', null, null);
INSERT INTO `sf_permission_role` VALUES ('147', '105', '1', null, null);
INSERT INTO `sf_permission_role` VALUES ('148', '106', '1', null, null);
INSERT INTO `sf_permission_role` VALUES ('149', '107', '1', null, null);
INSERT INTO `sf_permission_role` VALUES ('150', '108', '1', null, null);
INSERT INTO `sf_permission_role` VALUES ('151', '109', '1', null, null);
INSERT INTO `sf_permission_role` VALUES ('152', '110', '1', null, null);
INSERT INTO `sf_permission_role` VALUES ('153', '111', '1', null, null);
INSERT INTO `sf_permission_role` VALUES ('154', '112', '1', null, null);
INSERT INTO `sf_permission_role` VALUES ('155', '113', '1', null, null);
INSERT INTO `sf_permission_role` VALUES ('156', '114', '1', null, null);
INSERT INTO `sf_permission_role` VALUES ('157', '115', '1', null, null);
INSERT INTO `sf_permission_role` VALUES ('158', '116', '1', null, null);
INSERT INTO `sf_permission_role` VALUES ('159', '117', '1', null, null);

-- ----------------------------
-- Table structure for `sf_permission_user`
-- ----------------------------
DROP TABLE IF EXISTS `sf_permission_user`;
CREATE TABLE `sf_permission_user` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `permission_id` int(10) unsigned NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `permission_user_permission_id_index` (`permission_id`),
  KEY `permission_user_user_id_index` (`user_id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of sf_permission_user
-- ----------------------------
INSERT INTO `sf_permission_user` VALUES ('1', '2', '3', '2016-08-10 10:43:59', '2016-08-10 10:43:59');

-- ----------------------------
-- Table structure for `sf_roles`
-- ----------------------------
DROP TABLE IF EXISTS `sf_roles`;
CREATE TABLE `sf_roles` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `level` int(11) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `roles_slug_unique` (`slug`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='角色表';

-- ----------------------------
-- Records of sf_roles
-- ----------------------------
INSERT INTO `sf_roles` VALUES ('1', 'admin', 'admin', '系统管理员', '6', '2016-08-10 10:37:00', '2016-08-10 10:37:00');
INSERT INTO `sf_roles` VALUES ('2', 'manage', 'manage', '网站管理员', '3', '2016-08-10 10:37:00', '2016-08-12 09:56:57');
INSERT INTO `sf_roles` VALUES ('9', 'kefu', 'kefu', '客服', '3', '2016-08-11 18:16:58', '2016-08-11 18:16:58');

-- ----------------------------
-- Table structure for `sf_role_user`
-- ----------------------------
DROP TABLE IF EXISTS `sf_role_user`;
CREATE TABLE `sf_role_user` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `role_id` int(10) unsigned NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `role_user_role_id_index` (`role_id`),
  KEY `role_user_user_id_index` (`user_id`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='角色与用户关系';

-- ----------------------------
-- Records of sf_role_user
-- ----------------------------
INSERT INTO `sf_role_user` VALUES ('2', '1', '3', '2016-08-10 10:39:09', '2016-08-10 10:39:09');
INSERT INTO `sf_role_user` VALUES ('8', '2', '8', '2016-08-11 18:23:12', '2016-08-11 18:23:12');
INSERT INTO `sf_role_user` VALUES ('9', '9', '34', '2016-11-16 16:20:25', '2016-11-16 16:20:25');

-- ----------------------------
-- Table structure for `sf_users`
-- ----------------------------
DROP TABLE IF EXISTS `sf_users`;
CREATE TABLE `sf_users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '用户名',
  `email` varchar(255) COLLATE utf8_unicode_ci DEFAULT '' COMMENT '邮箱',
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '密码',
  `remember_token` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '记住我字段',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `is_admin` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '是否后台管理,0不是，1是',
  `is_check_email` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '0没验证，1验证',
  `qq` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT 'QQ',
  `head_img` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '头像',
  `online_status` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '在线状态，0没在线，1在线',
  `integral` varchar(255) COLLATE utf8_unicode_ci DEFAULT '0' COMMENT '积分',
  `telphone` varchar(255) COLLATE utf8_unicode_ci DEFAULT '' COMMENT '手机',
  `rel_name` varchar(100) COLLATE utf8_unicode_ci DEFAULT '' COMMENT '真实姓名',
  `datecard` varchar(255) COLLATE utf8_unicode_ci DEFAULT '' COMMENT '身份证号',
  `is_check_phone` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '0没验证，1验证',
  `money` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '用户余额',
  `bd_img` varchar(255) COLLATE utf8_unicode_ci DEFAULT '' COMMENT '身份证正面图片',
  `back_bd_img` varchar(255) COLLATE utf8_unicode_ci DEFAULT '' COMMENT '背面照',
  `hand_bd_img` varchar(255) COLLATE utf8_unicode_ci DEFAULT '' COMMENT '手持照',
  `sex` tinyint(3) unsigned NOT NULL DEFAULT '2' COMMENT '性别，0男，1女，2保密',
  `user_point_sell` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0' COMMENT '卖家信用积分',
  `user_point_buy` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0' COMMENT '买家信用积分',
  `reg_time` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '注册时间',
  `last_login` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '上次登录时间',
  `last_ip` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '上次登录ip',
  `status` tinyint(3) NOT NULL DEFAULT '0' COMMENT '0帐号正常，1封闭',
  `pay_password` varchar(255) COLLATE utf8_unicode_ci DEFAULT '' COMMENT '支付密码',
  `question` varchar(255) COLLATE utf8_unicode_ci DEFAULT '' COMMENT '密保问题',
  `answer` varchar(255) COLLATE utf8_unicode_ci DEFAULT '' COMMENT '答案',
  `frozen_money` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '冻结资金',
  `is_check_datecard` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '0未审核，1审核通过，2不通过',
  `birthday` date DEFAULT NULL COMMENT '生日',
  `bind_ip` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '绑定ip',
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=MyISAM AUTO_INCREMENT=37 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='用户表';

-- ----------------------------
-- Records of sf_users
-- ----------------------------
INSERT INTO `sf_users` VALUES ('3', 'admin', 'admin@admin.com', 'eyJpdiI6IlZ5Z1hvdDNmQlk4UjhDb0xqemlVK3c9PSIsInZhbHVlIjoiNXhmQUM3cFg5SkV5UEJyVTRsNjNJQT09IiwibWFjIjoiNGU4OTY5MGE1ZDk3YjUxNzY5MzdiNDJkNDU0OGM5MzY1YWE0ZmQwZDVjZjM2MjhmNjBjNDlhMTBjMWIzOWIzYSJ9', null, '2016-08-01 10:21:41', '2016-11-18 16:42:00', '1', '0', '12323432', '/public/uploads/604f06b0ff3be280f29ae6c4482a878a.jpg', '0', '0', '', '', '', '0', '0.00', '', '', '', '2', '0', '0', '', '', '', '0', '', '                                                \r\n                    \r\n                    ', '', '0.00', '0', null, '');
INSERT INTO `sf_users` VALUES ('2', 'qq123', 'qq123@qq.com', '$2y$10$ZCyuPbJlBM48dHuEjlsuI.A6V5eAuWmYmxQbwp.xjn7b6kWHcPUOu', 'K86anY3u3WQk2Zx4wSeHPi9oO5gzo2x1MP9JetkiZXqGtgPNn2Pcs230wot3', '2016-08-05 14:46:05', '2016-12-06 09:52:50', '0', '1', '69852365', '', '0', '16230', '18562547211', '', '', '1', '270.00', '', '', '', '2', '0', '230', '1472629862', '1480989170', '127.0.0.1', '0', '$2y$10$KfFXFZQoWwoNn7gHy0mufe/nwJ2hMxbhFdWGefi56wEnKwWmaQfM.', '您最喜欢的游戏是什么?', 'dnf', '0.00', '0', '0000-00-00', '');
INSERT INTO `sf_users` VALUES ('8', 'admin1', 'admin1@qq.com', 'eyJpdiI6IlJhSXFSZXErc1ZqT0NKa1VLb2VQWmc9PSIsInZhbHVlIjoiQW90ZlRmRWZVMWJHUUpCRnpQRzFJZz09IiwibWFjIjoiZGIzZGIxMmVjNjk2ZDYwNTRjMTg3YmIyYmFiMzI0Y2MzMjhlNTViMDViZmM1MDgwMzE0NWMyYzRhNDNiMDI5YyJ9', null, '2016-08-11 18:03:56', '2016-08-11 18:23:12', '1', '0', '', '', '0', '0', '', '', '', '0', '0.00', '', '', '', '2', '0', '0', '', '', '', '0', '', '', '', '0.00', '0', null, '');
INSERT INTO `sf_users` VALUES ('9', 'asdasd', 'asdasd@qq.com', '$2y$10$CEcJQTDHamqg4Kz5Njgn3Oo1q3dCJwpOqhPBNerhaO6HeRYTRf5hW', 'W9bI2O3qho2gX3Nb1Wjt2SS6SqudtYyEGviMcFMFkxBCzgfaZaVTCMr2D4Rk', '2016-09-01 16:17:59', '2017-02-12 17:22:26', '0', '0', '52365124', '', '0', '0', '18628970131', '罗宇', '41080019941115863X', '1', '289.00', '', '', '', '2', '0', '0', '1472629862', '1486891346', '127.0.0.1', '0', '$2y$10$L.wPk.UF5s15BuiuIKmeruOp8eHs.3IWc.PlXgbDVflI/0UcCHKQO', '您最喜欢的游戏是什么?', 'asd', '0.00', '2', '0000-00-00', '');
INSERT INTO `sf_users` VALUES ('10', 'zxczxc', 'zxczxc@qq.com', '$2y$10$JkaSxOqQuI4s7jhh8tBcI.0kO.CAHhc51g87T5KAfgzGeomrOK6uG', '3AEM5IMggg0YUV85uYlcURxIKraLtEKdI4zZmN4UqAY6t1N7mvgGVzhAJUnU', '2016-09-01 16:49:04', '2016-11-09 09:29:12', '0', '0', '', '', '0', '0', '18628970132', '', '', '1', '0.00', '', '', '', '2', '0', '0', '1472720398', '1478654852', '127.0.0.1', '0', '', '', '', '0.00', '0', null, '');
INSERT INTO `sf_users` VALUES ('11', 'qweqwe', 'qweqwe@qq.com', '$2y$10$xPTm.xs0GtN7dBEeIJTyKOGGi58LyfmLiiFk8ABFrL9xLAygl4KX6', null, '2016-09-01 16:52:49', '2016-09-01 16:52:49', '0', '0', '', '', '0', '0', '', '', '', '0', '0.00', '', '', '', '2', '0', '0', '1472720398', '', '', '0', '', '', '', '0.00', '0', null, '');
INSERT INTO `sf_users` VALUES ('12', 'poipoi', 'poipoi@qq.com', '$2y$10$ce1OeLYAnV/EyZZCHBXaTOnuCtBTJsSR69/Bc/BqvuNGCuGLDJ0bi', 'cvqCOqIoDiQqHHDcEWRHPqFLESZt2NxGDBkCSvnTcIofxNYyfxJlmkv80d85', '2016-09-01 16:55:31', '2016-11-07 09:24:14', '0', '1', '56321455', '', '0', '0', '18628970134', '', '', '1', '0.00', '', '', '', '2', '0', '0', '1472720398', '1478481827', '127.0.0.1', '0', '$2y$10$NT7CkSyMaM4XBejviyOkq.cnReYCBCBHkFg/tVWvSc3eemlxXZAIO', '您的暗号?', 'asd', '0.00', '0', null, '1.194');
INSERT INTO `sf_users` VALUES ('13', 'lirmm', 'lirn@qq.com', '$2y$10$bx4MC..qDocuUhNjlETEieEblgfV3J0f71eH8vGtrE4anLkDDCITm', null, '2016-09-01 16:59:58', '2016-09-01 16:59:58', '0', '0', '4356435', '', '0', '0', '15698574581', '', '', '0', '800.00', '', '', '', '2', '0', '0', '1472720398', '', '', '0', 'asdasd', '您的暗号?', 'asd', '0.00', '0', '1995-09-13', '');
INSERT INTO `sf_users` VALUES ('14', 'a31521', 'sdfsd@qq.com', '$2y$10$TWkgFiu5ufOQYbDy5Tf8WO4/AVvzwpKUVqEP.cwNKkDl40mIWihAu', null, '2016-09-02 10:38:56', '2016-09-05 11:11:51', '0', '0', '465465471', '', '0', '2', '15365985215', '王中中', '513545265475457458', '0', '99.00', '/public/uploads/27e58154ae5003eda44c969bed3d3da8.png', '/public/uploads/72023491f4ed33e1cfe2ee7aaf77ab62.png', '/public/uploads/43c6ec39ca193c0311595e177e06d4ed.png', '2', '0', '0', '1472783936', '', '', '0', '$2y$10$qbicM1VJrdbzW5QvVlH2wu24L.7jb7cp0LtcnsPuhi9z3qcWqSBOa', '您的暗号?', 'asd', '50.00', '1', '0000-00-00', '');
INSERT INTO `sf_users` VALUES ('15', 'usertest', '215538462@qq.com', '$2y$10$LRDLfYNlxqNv5HpR1H9KfeWfpYMEUmeanWoDyUkemmsJecN.ulMFO', 'amESnmLM2fZhutAN7An9UCYOeVEbAzt3I3qGfrLgodCLG5A4QDQfT4wHPZmj', '2016-09-09 16:14:44', '2016-09-09 16:16:24', '0', '0', '215538462', '', '0', '0', '15698574588', '', '', '0', '0.00', '', '', '', '2', '0', '0', '1473408884', '', '', '0', '$2y$10$L1WbPZDqlW8jrMI6DNhaf.TPMaGjF6/qGMillkQcU4jG/fjNkkVky', '您的暗号?', 'asd', '0.00', '0', '0000-00-00', '');
INSERT INTO `sf_users` VALUES ('26', 'lirn_aa', 'asdasd321@qq.com', '$2y$10$bxbkUHmow1.4IfPTP1jDFOmyVIHj9a/9XiIfIb58nef.4cD5/vgNi', null, '2016-09-20 11:14:04', '2016-11-09 11:17:49', '0', '0', '', '', '0', '0', '', '', '', '0', '0.00', '', '', '', '2', '0', '0', '1474341244', '1474341244', '127.0.0.1', '0', '', '', '', '0.00', '0', null, '');
INSERT INTO `sf_users` VALUES ('17', 'mnbmnb', 'qq@qq.com', '$2y$10$fGtDxdPz9Cbwv.J3./TU9eNOkPknKTT2ek2xu43G.eghsS0avanJO', null, '2016-09-19 15:28:23', '2016-09-19 15:28:23', '0', '0', '', '', '0', '0', '', '', '', '0', '0.00', '', '', '', '2', '0', '0', '1474270103', '1474270103', '127.0.0.1', '0', '', '', '', '0.00', '0', null, '');
INSERT INTO `sf_users` VALUES ('25', 'lirn_ld', '419091561@qq.com', '$2y$10$nDYXKzahVshs8VngyP2D5.QgvAdn8nf2rsuCGCJnfvjxDAyphZLw6', 'JguhvAf4hiJp9RgX13BNAGARWvxebzzsuPB9VpXerqhhJJfbX6D65rcWFy47', '2016-09-20 08:48:01', '2016-12-15 16:53:38', '0', '1', '123234218', '/public/uploads/8b2ffb7d2a430752b7d0cce8bd6cd908.jpg', '0', '217', '18542145232', '张电', '513300198705013166', '1', '1038.00', '', '', '', '2', '0', '801', '1474332481', '1481792018', '127.0.0.1', '0', '$2y$10$hOzH1BHouyuRKZkQApr9JOEyYsteMlbvk6ejpo83cvhIeP/y5pEDi', '您的暗号?', 'asd', '0.00', '1', '0000-00-00', '');
INSERT INTO `sf_users` VALUES ('27', '636363aa', '636363@qq.com', '$2y$10$Yr4eA4eW0.SofvZuD76.O.4Gwf3IXMOVWyWeneVIwoOAaxrLCRiuG', null, '2016-09-20 14:38:33', '2016-09-20 14:38:33', '0', '0', '', '', '0', '0', '', '', '', '0', '0.00', '', '', '', '2', '0', '0', '1474353513', '1474353513', '127.0.0.1', '0', '', '', '', '0.00', '0', null, '');
INSERT INTO `sf_users` VALUES ('28', '6544qq.com', '6544@qq.com', '$2y$10$9dSoQxLITnLbEcImmCFMP.Dqyfn7IACES2t0quRSpyZnvN9plTvCS', null, '2016-09-20 16:07:04', '2016-09-20 16:07:04', '0', '0', '', '', '0', '0', '', '', '', '0', '0.00', '', '', '', '2', '0', '0', '1474358824', '1474358824', '127.0.0.1', '0', '', '', '', '0.00', '0', null, '');
INSERT INTO `sf_users` VALUES ('29', 'kiraaa', '416161@qq.com', '$2y$10$cUu6O0Pack/nsOWqAuOHIeGxTJVZISJ6Sie3ZkORz0Lvuyc8FE6Ri', null, '2016-09-22 15:56:43', '2016-09-22 15:56:43', '0', '0', '', '', '0', '0', '', '', '', '0', '0.00', '', '', '', '2', '0', '0', '1474531003', '1474531003', '127.0.0.1', '0', '', '', '', '0.00', '0', null, '');
INSERT INTO `sf_users` VALUES ('30', 'asdasdasd', '52654775@qq.com', '$2y$10$6QNernXlwXiHos8HOnCrI.eJtcRLQo8Tl.PyAkdJPJR4vVIW6lHcG', null, '2016-10-10 15:17:58', '2016-10-10 15:17:58', '0', '0', '', '', '0', '0', '', '', '', '0', '0.00', '', '', '', '2', '0', '0', '1476083878', '1476083878', '127.0.0.1', '0', '', '', '', '0.00', '0', null, '');
INSERT INTO `sf_users` VALUES ('31', '5626541', '4562145@qq.com', '$2y$10$3ATgY3ghiSmjBayBjK.7KukX/Dx5A4v/X5uGIQ8peQI8LmuSBpEse', null, '2016-10-11 14:59:05', '2016-10-11 14:59:05', '0', '0', '', '', '0', '0', '', '', '', '0', '0.00', '', '', '', '2', '0', '0', '1476169145', '1476169145', '127.0.0.1', '0', '', '', '', '0.00', '0', null, '');
INSERT INTO `sf_users` VALUES ('32', 'mnbmnbmnb', 'mnbmnb@qq.com', '$2y$10$3rZJOlp/xSBfSWs/guvamOSk3ZQiC10dae/BdmbEfJpPynBzqULs.', null, '2016-10-17 10:49:37', '2016-10-17 10:49:37', '0', '0', '', '', '0', '0', '', '', '', '0', '0.00', '', '', '', '2', '0', '0', '1476672577', '1476672577', '127.0.0.1', '0', '', '', '', '0.00', '0', null, '');
INSERT INTO `sf_users` VALUES ('33', 'kimi123', '1620193657@qq.com', '$2y$10$YFpxEvg2uXCvQpJnESzAouFXoosF4ZVdYDe5ua6KOEMvBzm3nyhFy', null, '2016-11-11 16:23:03', '2016-11-11 16:36:03', '0', '1', '65498774', '', '0', '460', '15632541326', '', '', '1', '310.00', '', '', '', '2', '0', '460', '1478852583', '1478852722', '127.0.0.1', '0', '$2y$10$yIVjYLzkSAY0Rriv1/bOi.ZWU2dkfaxknO1aH7om4HKxCAGaS6itq', '您的出生地是？', 'asd', '0.00', '0', null, '');
INSERT INTO `sf_users` VALUES ('34', '丽丽', '2354235@qq.com', 'eyJpdiI6ImJoNHN0ZkJoY2hwbXVTWVpKMVRqNFE9PSIsInZhbHVlIjoieUV0bzVvejZUUTZ6b2ozNVVSTEVkQT09IiwibWFjIjoiNDZkNGFmZDhjZWY5YjRhMGQ0YzQ5NGEwOGYxOTU5NjcwM2VjZTA3ZjU2Mjg3MjJlYjNmMzM1NDU1NTcyOGFiOSJ9', null, '2016-11-16 16:20:25', '2016-11-16 16:20:25', '1', '0', '', '', '0', '0', '', '', '', '0', '0.00', '', '', '', '2', '0', '0', '', '', '', '0', '', '', '', '0.00', '0', null, '');
INSERT INTO `sf_users` VALUES ('35', 'test123', '4654131@qq.com', '$2y$10$0uqZQs0x/LShLV7rwSF7Fe1FyJTgR43giuXKYnNkhTHT4f6qX307O', null, '2016-12-09 17:17:05', '2016-12-09 17:17:05', '0', '0', '', '', '0', '0', '', '', '', '0', '0.00', '', '', '', '2', '0', '0', '1481275025', '1481275025', '127.0.0.1', '0', '', '', '', '0.00', '0', null, '');
INSERT INTO `sf_users` VALUES ('36', '123123', '6546498@qq.com', '$2y$10$1Ib.ETwcilpMtr3Bk59qSu9acW1pVHMpSKmFEKQazKn9HhcXmLPfi', null, '2016-12-09 17:22:05', '2016-12-09 17:22:05', '0', '0', '', '', '0', '0', '', '', '', '0', '0.00', '', '', '', '2', '0', '0', '1481275325', '1481275325', '127.0.0.1', '0', '', '', '', '0.00', '0', null, '');

-- ----------------------------
-- Table structure for `sf_user_account`
-- ----------------------------
DROP TABLE IF EXISTS `sf_user_account`;
CREATE TABLE `sf_user_account` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `admin_user` varchar(255) NOT NULL DEFAULT '' COMMENT '操作该笔交易的管理员的用户名',
  `amount` decimal(10,2) NOT NULL COMMENT '资金的数目，正数为增加，负数为减少',
  `created_at` datetime NOT NULL COMMENT '记录插入时间',
  `updated_at` datetime NOT NULL COMMENT '更新时间',
  `admin_note` varchar(255) NOT NULL DEFAULT '' COMMENT '备注',
  `user_note` varchar(255) NOT NULL DEFAULT '' COMMENT '用户备注',
  `process_type` tinyint(4) NOT NULL COMMENT '操作类型，1，提现；0，充值',
  `payment` varchar(255) NOT NULL DEFAULT '' COMMENT '支付方式',
  `is_paid` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '是否已经操作，０，未；１，是',
  `pay_status` varchar(3) NOT NULL DEFAULT '' COMMENT '支付状态，0未支付，1支付',
  `result` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '结果，0未处理，1成功，2无效',
  `account` varchar(255) DEFAULT NULL COMMENT '提现信息',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COMMENT='用户资金流动表';

-- ----------------------------
-- Records of sf_user_account
-- ----------------------------
INSERT INTO `sf_user_account` VALUES ('1', '2', 'admin', '100.00', '2016-09-02 00:00:00', '2016-09-07 00:00:00', '通过了，请查收', '麻烦快点', '0', '支付宝', '1', '1', '2', null);
INSERT INTO `sf_user_account` VALUES ('2', '13', 'admin', '200.00', '2016-09-07 15:18:11', '2016-09-07 15:18:14', '通过', '麻烦处理下', '1', '', '1', '', '1', null);
INSERT INTO `sf_user_account` VALUES ('5', '25', 'admin', '200.00', '2016-11-10 16:10:20', '2016-11-10 16:10:20', '已打钱', '张电,62153265475415214575,中国建设银行 ,辽宁大连', '1', '银行', '1', '', '1', '');
INSERT INTO `sf_user_account` VALUES ('6', '25', 'admin', '199.00', '2016-11-10 16:22:56', '2016-11-10 16:22:56', '', '姓名：张飞帐号:564654@qq.com', '1', '支付宝', '1', '', '2', null);

-- ----------------------------
-- Table structure for `sf_user_bank`
-- ----------------------------
DROP TABLE IF EXISTS `sf_user_bank`;
CREATE TABLE `sf_user_bank` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `data` tinytext NOT NULL,
  `add_time` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL DEFAULT '',
  `user_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COMMENT='用户银行';

-- ----------------------------
-- Records of sf_user_bank
-- ----------------------------
INSERT INTO `sf_user_bank` VALUES ('4', '{\"name\":\"张电\",\"bankNo\":\"62153265475415214575\",\"bank_name\":\"中国建设银行 \",\"sheng\":\"辽宁\",\"city\":\"大连\"}', '1476324869', '25');

-- ----------------------------
-- Table structure for `sf_user_ip`
-- ----------------------------
DROP TABLE IF EXISTS `sf_user_ip`;
CREATE TABLE `sf_user_ip` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `ip_info` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=17 DEFAULT CHARSET=utf8 COMMENT='用户登录ip记录';

-- ----------------------------
-- Records of sf_user_ip
-- ----------------------------
INSERT INTO `sf_user_ip` VALUES ('13', '10', 'a:3:{s:4:\"time\";i:1478080859;s:2:\"ip\";s:12:\"1.194.18.107\";s:7:\"address\";s:24:\"河南省郑州市电信\";}');
INSERT INTO `sf_user_ip` VALUES ('11', '12', 'a:3:{s:4:\"time\";i:1478481827;s:2:\"ip\";s:11:\"1.194.18.85\";s:7:\"address\";s:24:\"河南省郑州市电信\";}*a:3:{s:4:\"time\";i:1477986556;s:2:\"ip\";s:11:\"1.194.22.42\";s:7:\"address\";s:24:\"河南省郑州市电信\";}*a:3:{s:4:\"time\";i:1477987561;s:2:\"ip\";s:11:\"1.194.22.42\";s:7:\"address\";s:24:\"河南省郑州市电信\";}*a:3:{s:4:\"time\";i:1477987813;s:2:\"ip\";s:11:\"1.194.22.42\";s:7:\"address\";s:24:\"河南省郑州市电信\";}*a:3:{s:4:\"time\";i:1477987834;s:2:\"ip\";s:11:\"1.194.22.42\";s:7:\"address\";s:24:\"河南省郑州市电信\";}*a:3:{s:4:\"time\";i:1477987905;s:2:\"ip\";s:11:\"1.194.22.42\";s:7:\"address\";s:24:\"河南省郑州市电信\";}*a:3:{s:4:\"time\";i:1477987932;s:2:\"ip\";s:11:\"1.194.22.42\";s:7:\"address\";s:24:\"河南省郑州市电信\";}*a:3:{s:4:\"time\";i:1477987942;s:2:\"ip\";s:11:\"1.194.22.42\";s:7:\"address\";s:24:\"河南省郑州市电信\";}*a:3:{s:4:\"time\";i:1477987953;s:2:\"ip\";s:11:\"1.194.22.42\";s:7:\"address\";s:24:\"河南省郑州市电信\";}*a:3:{s:4:\"time\";i:1477989050;s:2:\"ip\";s:11:\"1.194.22.42\";s:7:\"address\";s:24:\"河南省郑州市电信\";}');
INSERT INTO `sf_user_ip` VALUES ('12', '2', 'a:3:{s:4:\"time\";i:1478072082;s:2:\"ip\";s:12:\"1.194.19.113\";s:7:\"address\";s:24:\"河南省郑州市电信\";}*a:3:{s:4:\"time\";i:1478571509;s:2:\"ip\";s:11:\"1.194.18.85\";s:7:\"address\";s:24:\"河南省郑州市电信\";}*a:3:{s:4:\"time\";i:1478758060;s:2:\"ip\";s:12:\"1.194.18.162\";s:7:\"address\";s:24:\"河南省郑州市电信\";}*a:3:{s:4:\"time\";i:1479086419;s:2:\"ip\";s:12:\"1.194.22.225\";s:7:\"address\";s:24:\"河南省郑州市电信\";}*a:3:{s:4:\"time\";i:1479113700;s:2:\"ip\";s:12:\"1.194.22.225\";s:7:\"address\";s:24:\"河南省郑州市电信\";}*a:3:{s:4:\"time\";i:1479175454;s:2:\"ip\";s:12:\"1.194.22.225\";s:7:\"address\";s:24:\"河南省郑州市电信\";}*a:3:{s:4:\"time\";i:1480989170;s:2:\"ip\";s:12:\"1.194.22.253\";s:7:\"address\";s:24:\"河南省郑州市电信\";}');
INSERT INTO `sf_user_ip` VALUES ('14', '9', 'a:3:{s:4:\"time\";i:1486891260;s:2:\"ip\";s:15:\"110.184.147.115\";s:7:\"address\";s:24:\"四川省成都市电信\";}*a:3:{s:4:\"time\";i:1478587611;s:2:\"ip\";s:11:\"1.194.18.85\";s:7:\"address\";s:24:\"河南省郑州市电信\";}*a:3:{s:4:\"time\";i:1479784262;s:2:\"ip\";s:12:\"1.194.23.144\";s:7:\"address\";s:24:\"河南省郑州市电信\";}*a:3:{s:4:\"time\";i:1479784390;s:2:\"ip\";s:12:\"1.194.23.144\";s:7:\"address\";s:24:\"河南省郑州市电信\";}*a:3:{s:4:\"time\";i:1479785206;s:2:\"ip\";s:12:\"1.194.23.144\";s:7:\"address\";s:24:\"河南省郑州市电信\";}*a:3:{s:4:\"time\";i:1479785290;s:2:\"ip\";s:12:\"1.194.23.144\";s:7:\"address\";s:24:\"河南省郑州市电信\";}*a:3:{s:4:\"time\";i:1479785315;s:2:\"ip\";s:12:\"1.194.23.144\";s:7:\"address\";s:24:\"河南省郑州市电信\";}*a:3:{s:4:\"time\";i:1479785340;s:2:\"ip\";s:12:\"1.194.23.144\";s:7:\"address\";s:24:\"河南省郑州市电信\";}*a:3:{s:4:\"time\";i:1479785376;s:2:\"ip\";s:12:\"1.194.23.144\";s:7:\"address\";s:24:\"河南省郑州市电信\";}*a:3:{s:4:\"time\";i:1479785832;s:2:\"ip\";s:12:\"1.194.23.144\";s:7:\"address\";s:24:\"河南省郑州市电信\";}');
INSERT INTO `sf_user_ip` VALUES ('15', '25', 'a:3:{s:4:\"time\";i:1481792018;s:2:\"ip\";s:12:\"1.194.22.244\";s:7:\"address\";s:24:\"河南省郑州市电信\";}*a:3:{s:4:\"time\";i:1478240372;s:2:\"ip\";s:12:\"1.194.23.143\";s:7:\"address\";s:24:\"河南省郑州市电信\";}*a:3:{s:4:\"time\";i:1478481869;s:2:\"ip\";s:11:\"1.194.18.85\";s:7:\"address\";s:24:\"河南省郑州市电信\";}*a:3:{s:4:\"time\";i:1478568391;s:2:\"ip\";s:11:\"1.194.18.85\";s:7:\"address\";s:24:\"河南省郑州市电信\";}*a:3:{s:4:\"time\";i:1478568982;s:2:\"ip\";s:11:\"1.194.18.85\";s:7:\"address\";s:24:\"河南省郑州市电信\";}*a:3:{s:4:\"time\";i:1478585892;s:2:\"ip\";s:11:\"1.194.18.85\";s:7:\"address\";s:24:\"河南省郑州市电信\";}*a:3:{s:4:\"time\";i:1478661532;s:2:\"ip\";s:11:\"1.194.18.85\";s:7:\"address\";s:24:\"河南省郑州市电信\";}*a:3:{s:4:\"time\";i:1478749807;s:2:\"ip\";s:12:\"1.194.18.162\";s:7:\"address\";s:24:\"河南省郑州市电信\";}*a:3:{s:4:\"time\";i:1478827312;s:2:\"ip\";s:12:\"1.194.18.162\";s:7:\"address\";s:24:\"河南省郑州市电信\";}*a:3:{s:4:\"time\";i:1478835293;s:2:\"ip\";s:12:\"1.194.18.162\";s:7:\"address\";s:24:\"河南省郑州市电信\";}');
INSERT INTO `sf_user_ip` VALUES ('16', '33', 'a:3:{s:4:\"time\";i:1478852722;s:2:\"ip\";s:12:\"1.194.18.162\";s:7:\"address\";s:24:\"河南省郑州市电信\";}');

-- ----------------------------
-- Table structure for `sf_user_order_address`
-- ----------------------------
DROP TABLE IF EXISTS `sf_user_order_address`;
CREATE TABLE `sf_user_order_address` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `order_id` int(10) unsigned NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `game_id` int(10) unsigned NOT NULL COMMENT '游戏名称',
  `da_qu_id` int(10) unsigned NOT NULL COMMENT '大区id',
  `xia_qu_id` int(10) unsigned NOT NULL COMMENT '小区id',
  `role_name` varchar(255) NOT NULL DEFAULT '' COMMENT '收货角色',
  `telphone` varchar(11) NOT NULL COMMENT '联系电话',
  `qq` varchar(20) NOT NULL COMMENT 'qq',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=53 DEFAULT CHARSET=utf8 COMMENT='用户收货地址';

-- ----------------------------
-- Records of sf_user_order_address
-- ----------------------------
INSERT INTO `sf_user_order_address` VALUES ('1', '1', '13', '38', '96', '98', '士大夫', '18562547211', '562145325');
INSERT INTO `sf_user_order_address` VALUES ('2', '2', '13', '35', '112', '113', '发呆不不啊', '15698574588', '4356435');
INSERT INTO `sf_user_order_address` VALUES ('6', '15', '25', '22', '167', '204', '豆腐干', '15698574581', '12343534');
INSERT INTO `sf_user_order_address` VALUES ('32', '41', '2', '36', '78', '79', '霍尔特尔', '15698574581', '123234218');
INSERT INTO `sf_user_order_address` VALUES ('11', '20', '25', '22', '167', '204', '阿萨', '15698574588', '12334232');
INSERT INTO `sf_user_order_address` VALUES ('13', '22', '25', '24', '49', '51', '第三方', '15698574588', '1233242');
INSERT INTO `sf_user_order_address` VALUES ('14', '23', '25', '24', '49', '51', '啊啊', '15698574588', '1232342');
INSERT INTO `sf_user_order_address` VALUES ('15', '24', '25', '24', '49', '51', '艾思', '18562547211', '1233244');
INSERT INTO `sf_user_order_address` VALUES ('40', '50', '2', '22', '167', '202', '1', '18562547211', '69852365');
INSERT INTO `sf_user_order_address` VALUES ('41', '51', '2', '22', '167', '202', '1', '18562547211', '69852365');
INSERT INTO `sf_user_order_address` VALUES ('42', '52', '2', '22', '167', '202', '1', '18562547211', '69852365');
INSERT INTO `sf_user_order_address` VALUES ('20', '29', '25', '24', '49', '51', '啊啊', '15698574581', '1232342');
INSERT INTO `sf_user_order_address` VALUES ('43', '53', '9', '22', '167', '202', 'ads', '18628970131', '52365124');
INSERT INTO `sf_user_order_address` VALUES ('39', '49', '2', '22', '167', '202', '21', '18562547211', '69852365');
INSERT INTO `sf_user_order_address` VALUES ('38', '48', '2', '22', '167', '202', '如果对方', '18562547211', '69852365');
INSERT INTO `sf_user_order_address` VALUES ('51', '61', '25', '22', '167', '204', 'asdasd', '18542145232', '123234218');
INSERT INTO `sf_user_order_address` VALUES ('52', '62', '25', '22', '167', '202', 'asdasd', '18542145232', '123234218');
INSERT INTO `sf_user_order_address` VALUES ('47', '57', '2', '36', '75', '77', '豆腐干豆腐干', '18562547211', '69852365');
INSERT INTO `sf_user_order_address` VALUES ('48', '58', '33', '22', '167', '202', '大法师但是', '15632541326', '65498774');
INSERT INTO `sf_user_order_address` VALUES ('49', '59', '33', '22', '167', '202', '法国工会法', '15632541326', '65498774');
INSERT INTO `sf_user_order_address` VALUES ('50', '60', '2', '22', '167', '202', '日光灯发光', '18562547211', '69852365');

-- ----------------------------
-- Table structure for `sf_user_rank`
-- ----------------------------
DROP TABLE IF EXISTS `sf_user_rank`;
CREATE TABLE `sf_user_rank` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `rank_name` varchar(50) NOT NULL DEFAULT '' COMMENT '等级名',
  `min_points` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '该等级的最低积分',
  `max_points` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '该等级的最高积分',
  `discount` tinyint(3) unsigned NOT NULL COMMENT '该等级的手续费折扣',
  `rank_img` varchar(255) NOT NULL DEFAULT '' COMMENT '等级图片',
  `max_issue` int(10) unsigned NOT NULL COMMENT '允许发布的最大条数',
  `max_time` int(11) NOT NULL COMMENT '最多有效期天数',
  `max_changePrice` int(10) unsigned NOT NULL COMMENT '最大求降价数量',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COMMENT='用户等级';

-- ----------------------------
-- Records of sf_user_rank
-- ----------------------------
INSERT INTO `sf_user_rank` VALUES ('2', '一星一级', '0', '200', '100', '/public/uploads/fc280a0a1c006b461eff055e06634e29.gif', '50', '3', '1');
INSERT INTO `sf_user_rank` VALUES ('3', '一星二级', '200', '400', '99', '/public/uploads/0118d00a15046092a1a25529545eef86.gif', '80', '5', '2');
INSERT INTO `sf_user_rank` VALUES ('4', '一星三级', '400', '600', '98', '/public/uploads/47ba3eeeeb7a1108dd9f4b9ec8f63d81.gif', '100', '8', '3');
INSERT INTO `sf_user_rank` VALUES ('5', '一星四级', '600', '800', '97', '/public/uploads/b45f6d96c13201cb8908d5925f8d2526.gif', '120', '10', '4');
INSERT INTO `sf_user_rank` VALUES ('6', '一星五级', '800', '1000', '96', '/public/uploads/08a3327456523b40c1b9487f0f6fa91e.gif', '150', '14', '5');
INSERT INTO `sf_user_rank` VALUES ('7', '二星一级', '1000', '1200', '96', '/public/uploads/644db420975cf55266cc2a731d0526e9.gif', '180', '18', '6');
