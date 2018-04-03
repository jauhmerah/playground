-- phpMyAdmin SQL Dump
-- version 4.2.10
-- http://www.phpmyadmin.net
--
-- Host: localhost:3306
-- Generation Time: Nov 22, 2016 at 10:14 AM
-- Server version: 5.5.38
-- PHP Version: 5.6.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `yii2playground`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_auth_assignment`
--

CREATE TABLE `tbl_auth_assignment` (
  `item_name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `tbl_auth_assignment`
--

INSERT INTO `tbl_auth_assignment` (`item_name`, `user_id`, `created_at`) VALUES
('admin', 2, 1460083129),
('registered', 3, 1478052094),
('super', 1, 1459491456);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_auth_item`
--

CREATE TABLE `tbl_auth_item` (
  `name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `type` int(11) NOT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `rule_name` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `data` text COLLATE utf8_unicode_ci,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `tbl_auth_item`
--

INSERT INTO `tbl_auth_item` (`name`, `type`, `description`, `rule_name`, `data`, `created_at`, `updated_at`) VALUES
('admin', 1, NULL, NULL, NULL, 1473756174, 1473756174),
('package-create', 2, 'Create package', NULL, NULL, 1473756174, 1473756174),
('package-delete', 2, 'Delete package', NULL, NULL, 1473756174, 1473756174),
('package-update', 2, 'Update package', NULL, NULL, 1473756174, 1473756174),
('package-view', 2, 'View package', NULL, NULL, 1473756174, 1473756174),
('registered', 1, NULL, NULL, NULL, 1473756174, 1473756174),
('setting-update', 2, 'Update setting', NULL, NULL, 1473756174, 1473756174),
('super', 1, NULL, NULL, NULL, 1473756174, 1473756174),
('user-create', 2, 'Create user', NULL, NULL, 1473756174, 1473756174),
('user-delete', 2, 'Delete user', NULL, NULL, 1473756174, 1473756174),
('user-update', 2, 'Update user', NULL, NULL, 1473756174, 1473756174),
('user-view', 2, 'View user', NULL, NULL, 1473756174, 1473756174);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_auth_item_child`
--

CREATE TABLE `tbl_auth_item_child` (
  `parent` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `child` varchar(64) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `tbl_auth_item_child`
--

INSERT INTO `tbl_auth_item_child` (`parent`, `child`) VALUES
('admin', 'package-create'),
('admin', 'package-delete'),
('admin', 'package-update'),
('admin', 'package-view'),
('admin', 'setting-update'),
('super', 'setting-update'),
('admin', 'user-create'),
('super', 'user-create'),
('super', 'user-delete'),
('admin', 'user-update'),
('super', 'user-update'),
('admin', 'user-view'),
('super', 'user-view');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_auth_rule`
--

CREATE TABLE `tbl_auth_rule` (
  `name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `data` text COLLATE utf8_unicode_ci,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_course`
--

CREATE TABLE `tbl_course` (
`id` int(11) NOT NULL,
  `code` varchar(10) NOT NULL,
  `name` varchar(100) NOT NULL,
  `price` decimal(7,2) unsigned NOT NULL,
  `is_deleted` tinyint(1) unsigned DEFAULT '0',
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_course`
--

INSERT INTO `tbl_course` (`id`, `code`, `name`, `price`, `is_deleted`, `created_at`, `updated_at`, `created_by`, `updated_by`) VALUES
(1, 'SC-1', 'Science 1', 1000.00, 0, 1470466638, 1471831535, 2, 2),
(2, 'SC-2', 'Science 2', 1200.00, 0, 1471831538, 1471831538, 2, 2);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_migration`
--

CREATE TABLE `tbl_migration` (
  `version` varchar(180) NOT NULL,
  `apply_time` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_migration`
--

INSERT INTO `tbl_migration` (`version`, `apply_time`) VALUES
('m000000_000000_base', 1459489388),
('m140506_102106_rbac_init', 1459489389);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_oauth_token`
--

CREATE TABLE `tbl_oauth_token` (
  `access_token` char(64) NOT NULL,
  `user_id` int(11) NOT NULL,
  `scope` varchar(255) DEFAULT NULL,
  `expire_at` int(11) NOT NULL,
  `created_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_opt_country`
--

CREATE TABLE `tbl_opt_country` (
  `code` char(2) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `phone_code` int(5) unsigned NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `tbl_opt_country`
--

INSERT INTO `tbl_opt_country` (`code`, `name`, `phone_code`) VALUES
('ad', 'Andorra', 376),
('ae', 'United Arab Emirates', 971),
('af', 'Afghanistan', 93),
('ag', 'Antigua and Barbuda', 1268),
('ai', 'Anguilla', 1264),
('al', 'Albania', 355),
('am', 'Armenia', 374),
('an', 'Netherlands Antilles', 599),
('ao', 'Angola', 244),
('aq', 'Antarctica', 0),
('ar', 'Argentina', 54),
('as', 'American Samoa', 1684),
('at', 'Austria', 43),
('au', 'Australia', 61),
('aw', 'Aruba', 297),
('az', 'Azerbaijan', 994),
('ba', 'Bosnia and Herzegovina', 387),
('bb', 'Barbados', 1246),
('bd', 'Bangladesh', 880),
('be', 'Belgium', 32),
('bf', 'Burkina Faso', 226),
('bg', 'Bulgaria', 359),
('bh', 'Bahrain', 973),
('bi', 'Burundi', 257),
('bj', 'Benin', 229),
('bm', 'Bermuda', 1441),
('bn', 'Brunei Darussalam', 673),
('bo', 'Bolivia', 591),
('br', 'Brazil', 55),
('bs', 'Bahamas', 1242),
('bt', 'Bhutan', 975),
('bv', 'Bouvet Island', 0),
('bw', 'Botswana', 267),
('by', 'Belarus', 375),
('bz', 'Belize', 501),
('ca', 'Canada', 1),
('cc', 'Cocos (Keeling) Islands', 672),
('cd', 'Congo, the Democratic Republic of the', 242),
('cf', 'Central African Republic', 236),
('cg', 'Congo', 242),
('ch', 'Switzerland', 41),
('ci', 'Cote D''Ivoire', 225),
('ck', 'Cook Islands', 682),
('cl', 'Chile', 56),
('cm', 'Cameroon', 237),
('cn', 'China', 86),
('co', 'Colombia', 57),
('cr', 'Costa Rica', 506),
('cs', 'Serbia and Montenegro', 381),
('cu', 'Cuba', 53),
('cv', 'Cape Verde', 238),
('cx', 'Christmas Island', 61),
('cy', 'Cyprus', 357),
('cz', 'Czech Republic', 420),
('de', 'Germany', 49),
('dj', 'Djibouti', 253),
('dk', 'Denmark', 45),
('dm', 'Dominica', 1767),
('do', 'Dominican Republic', 1809),
('dz', 'Algeria', 213),
('ec', 'Ecuador', 593),
('ee', 'Estonia', 372),
('eg', 'Egypt', 20),
('eh', 'Western Sahara', 212),
('er', 'Eritrea', 291),
('es', 'Spain', 34),
('et', 'Ethiopia', 251),
('fi', 'Finland', 358),
('fj', 'Fiji', 679),
('fk', 'Falkland Islands (Malvinas)', 500),
('fm', 'Micronesia, Federated States of', 691),
('fo', 'Faroe Islands', 298),
('fr', 'France', 33),
('ga', 'Gabon', 241),
('gb', 'United Kingdom', 44),
('gd', 'Grenada', 1473),
('ge', 'Georgia', 995),
('gf', 'French Guiana', 594),
('gh', 'Ghana', 233),
('gi', 'Gibraltar', 350),
('gl', 'Greenland', 299),
('gm', 'Gambia', 220),
('gn', 'Guinea', 224),
('gp', 'Guadeloupe', 590),
('gq', 'Equatorial Guinea', 240),
('gr', 'Greece', 30),
('gs', 'South Georgia and the South Sandwich Islands', 0),
('gt', 'Guatemala', 502),
('gu', 'Guam', 1671),
('gw', 'Guinea-Bissau', 245),
('gy', 'Guyana', 592),
('hk', 'Hong Kong', 852),
('hm', 'Heard Island and Mcdonald Islands', 0),
('hn', 'Honduras', 504),
('hr', 'Croatia', 385),
('ht', 'Haiti', 509),
('hu', 'Hungary', 36),
('id', 'Indonesia', 62),
('ie', 'Ireland', 353),
('il', 'Israel', 972),
('in', 'India', 91),
('io', 'British Indian Ocean Territory', 246),
('iq', 'Iraq', 964),
('ir', 'Iran, Islamic Republic of', 98),
('is', 'Iceland', 354),
('it', 'Italy', 39),
('jm', 'Jamaica', 1876),
('jo', 'Jordan', 962),
('jp', 'Japan', 81),
('ke', 'Kenya', 254),
('kg', 'Kyrgyzstan', 996),
('kh', 'Cambodia', 855),
('ki', 'Kiribati', 686),
('km', 'Comoros', 269),
('kn', 'Saint Kitts and Nevis', 1869),
('kp', 'Korea, Democratic People''s Republic of', 850),
('kr', 'Korea, Republic of', 82),
('kw', 'Kuwait', 965),
('ky', 'Cayman Islands', 1345),
('kz', 'Kazakhstan', 7),
('la', 'Lao People''s Democratic Republic', 856),
('lb', 'Lebanon', 961),
('lc', 'Saint Lucia', 1758),
('li', 'Liechtenstein', 423),
('lk', 'Sri Lanka', 94),
('lr', 'Liberia', 231),
('ls', 'Lesotho', 266),
('lt', 'Lithuania', 370),
('lu', 'Luxembourg', 352),
('lv', 'Latvia', 371),
('ly', 'Libyan Arab Jamahiriya', 218),
('ma', 'Morocco', 212),
('mc', 'Monaco', 377),
('md', 'Moldova, Republic of', 373),
('mg', 'Madagascar', 261),
('mh', 'Marshall Islands', 692),
('mk', 'Macedonia, the Former Yugoslav Republic of', 389),
('ml', 'Mali', 223),
('mm', 'Myanmar', 95),
('mn', 'Mongolia', 976),
('mo', 'Macao', 853),
('mp', 'Northern Mariana Islands', 1670),
('mq', 'Martinique', 596),
('mr', 'Mauritania', 222),
('ms', 'Montserrat', 1664),
('mt', 'Malta', 356),
('mu', 'Mauritius', 230),
('mv', 'Maldives', 960),
('mw', 'Malawi', 265),
('mx', 'Mexico', 52),
('my', 'Malaysia', 60),
('mz', 'Mozambique', 258),
('na', 'Namibia', 264),
('nc', 'New Caledonia', 687),
('ne', 'Niger', 227),
('nf', 'Norfolk Island', 672),
('ng', 'Nigeria', 234),
('ni', 'Nicaragua', 505),
('nl', 'Netherlands', 31),
('no', 'Norway', 47),
('np', 'Nepal', 977),
('nr', 'Nauru', 674),
('nu', 'Niue', 683),
('nz', 'New Zealand', 64),
('om', 'Oman', 968),
('pa', 'Panama', 507),
('pe', 'Peru', 51),
('pf', 'French Polynesia', 689),
('pg', 'Papua New Guinea', 675),
('ph', 'Philippines', 63),
('pk', 'Pakistan', 92),
('pl', 'Poland', 48),
('pm', 'Saint Pierre and Miquelon', 508),
('pn', 'Pitcairn', 0),
('pr', 'Puerto Rico', 1787),
('ps', 'Palestinian Territory, Occupied', 970),
('pt', 'Portugal', 351),
('pw', 'Palau', 680),
('py', 'Paraguay', 595),
('qa', 'Qatar', 974),
('re', 'Reunion', 262),
('ro', 'Romania', 40),
('ru', 'Russian Federation', 70),
('rw', 'Rwanda', 250),
('sa', 'Saudi Arabia', 966),
('sb', 'Solomon Islands', 677),
('sc', 'Seychelles', 248),
('sd', 'Sudan', 249),
('se', 'Sweden', 46),
('sg', 'Singapore', 65),
('sh', 'Saint Helena', 290),
('si', 'Slovenia', 386),
('sj', 'Svalbard and Jan Mayen', 47),
('sk', 'Slovakia', 421),
('sl', 'Sierra Leone', 232),
('sm', 'San Marino', 378),
('sn', 'Senegal', 221),
('so', 'Somalia', 252),
('sr', 'Suriname', 597),
('st', 'Sao Tome and Principe', 239),
('sv', 'El Salvador', 503),
('sy', 'Syrian Arab Republic', 963),
('sz', 'Swaziland', 268),
('tc', 'Turks and Caicos Islands', 1649),
('td', 'Chad', 235),
('tf', 'French Southern Territories', 0),
('tg', 'Togo', 228),
('th', 'Thailand', 66),
('tj', 'Tajikistan', 992),
('tk', 'Tokelau', 690),
('tl', 'Timor-Leste', 670),
('tm', 'Turkmenistan', 7370),
('tn', 'Tunisia', 216),
('to', 'Tonga', 676),
('tr', 'Turkey', 90),
('tt', 'Trinidad and Tobago', 1868),
('tv', 'Tuvalu', 688),
('tw', 'Taiwan', 886),
('tz', 'Tanzania, United Republic of', 255),
('ua', 'Ukraine', 380),
('ug', 'Uganda', 256),
('um', 'United States Minor Outlying Islands', 1),
('us', 'United States', 1),
('uy', 'Uruguay', 598),
('uz', 'Uzbekistan', 998),
('va', 'Holy See (Vatican City State)', 39),
('vc', 'Saint Vincent and the Grenadines', 1784),
('ve', 'Venezuela', 58),
('vg', 'Virgin Islands, British', 1284),
('vi', 'Virgin Islands, U.s.', 1340),
('vn', 'Viet Nam', 84),
('vu', 'Vanuatu', 678),
('wf', 'Wallis and Futuna', 681),
('ws', 'Samoa', 684),
('ye', 'Yemen', 967),
('yt', 'Mayotte', 269),
('za', 'South Africa', 27),
('zm', 'Zambia', 260),
('zw', 'Zimbabwe', 263);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_session`
--

CREATE TABLE `tbl_session` (
  `id` char(40) NOT NULL,
  `expire` int(11) DEFAULT NULL,
  `data` blob
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_session`
--

INSERT INTO `tbl_session` (`id`, `expire`, `data`) VALUES
('032c93d7d9e0deb860bdb98d401244ca', 1475148719, 0x5f5f666c6173687c613a303a7b7d5f5f69647c693a323b),
('2c06ab84f222038a34654e32d0811e5d', 1476092473, 0x5f5f666c6173687c613a303a7b7d5f5f72657475726e55726c7c733a32393a222f796969322f706c617967726f756e642f6261636b656e642f7765622f223b),
('4d9f3a5e6c8e717cd02a6acd6c59522f', 1475148442, 0x5f5f666c6173687c613a303a7b7d5f5f72657475726e55726c7c733a32393a222f796969322f706c617967726f756e642f6261636b656e642f7765622f223b5f5f69647c693a323b646570656e64656e747c613a313a7b733a373a225375626a656374223b613a333a7b733a353a226d6f64656c223b733a33383a225c6261636b656e645c6d6f64756c65735c7061636b6167655c6d6f64656c735c436f75727365223b733a393a22636f6e646974696f6e223b613a323a7b733a323a226964223b733a313a2231223b733a31303a2269735f64656c65746564223b693a303b7d733a393a2272657475726e55726c223b613a313a7b693a303b733a31353a222f7061636b6167652f636f75727365223b7d7d7d),
('731b64542a3e5ad71a2c7607ea36720e', 1476929768, 0x5f5f666c6173687c613a303a7b7d5f5f72657475726e55726c7c733a32393a222f796969322f706c617967726f756e642f6261636b656e642f7765622f223b5f5f69647c693a323b),
('bf8b4a42d0b1baf13e802a74327d4724', 1476018685, 0x5f5f666c6173687c613a303a7b7d5f5f72657475726e55726c7c733a32393a222f796969322f706c617967726f756e642f6261636b656e642f7765622f223b),
('f97bd54445bfc18d91e58a8181016f38', 1478053449, 0x5f5f666c6173687c613a303a7b7d5f5f72657475726e55726c7c733a32393a222f796969322f706c617967726f756e642f6261636b656e642f7765622f223b5f5f69647c693a313b);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_setting`
--

CREATE TABLE `tbl_setting` (
  `code` varchar(50) NOT NULL,
  `value` varchar(50) NOT NULL,
  `updated_at` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_setting`
--

INSERT INTO `tbl_setting` (`code`, `value`, `updated_at`, `updated_by`) VALUES
('matrix_no_format', '{user-id}-{auto-id}', 1470465051, 1),
('subject_enabled', '1', 1470467316, 2);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_subject`
--

CREATE TABLE `tbl_subject` (
`id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `code` varchar(10) NOT NULL,
  `name` varchar(100) NOT NULL,
  `is_deleted` tinyint(1) unsigned DEFAULT '0',
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_subject`
--

INSERT INTO `tbl_subject` (`id`, `course_id`, `code`, `name`, `is_deleted`, `created_at`, `updated_at`, `created_by`, `updated_by`) VALUES
(1, 1, 'P-1', 'Physics 1', 0, 1470467188, 1470467188, 2, 2),
(2, 1, 'P-2', 'Physics 2', 0, 1470467194, 1470467194, 2, 2);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_user`
--

CREATE TABLE `tbl_user` (
`id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `auth_key` varchar(32) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `password_reset_token` varchar(255) DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `country` char(2) DEFAULT NULL,
  `avatar` varchar(255) DEFAULT NULL,
  `is_disabled` tinyint(1) unsigned DEFAULT '0',
  `is_deleted` tinyint(1) unsigned DEFAULT '0',
  `last_login_at` int(11) DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_user`
--

INSERT INTO `tbl_user` (`id`, `email`, `auth_key`, `password_hash`, `password_reset_token`, `name`, `country`, `avatar`, `is_disabled`, `is_deleted`, `last_login_at`, `created_at`, `updated_at`) VALUES
(1, 'super@codetitan.com.my', 'nBifXaA1Z01bTB5SxllcY0zv5rnv9kdQ', '$2y$13$diNlvsMi6jnu8mFAXkmrfu97AaB68y1ccvb6p3ih3qLxAMCskA3Nu', NULL, 'Super Admin', NULL, NULL, 0, 0, 1460027443, 1459491456, 1478051883, NULL, NULL),
(2, 'admin@codetitan.com.my', 'GNK6GJxko8GA7jYR0K9FlRb9DMWQMkxI', '$2y$13$OCqw6GwEKmvQ4SN2F5v6CeZBeDhgsr5rzucsOeSLKrwxVPi7MsSqK', NULL, 'Admin', NULL, NULL, 0, 0, 1473903534, 1459588387, 1478052051, NULL, NULL),
(3, 'user@codetitan.com.my', '5gKBwfHHjgXxJ0lxrOjRe15aC11D6Jj8', '$2y$13$upwgeIy1FRRMSpUkhOyjRetOYrQ3lFD5NrP0dMZnr1xHEWtz3/tta', NULL, 'User', 'my', '3.jpg', 0, 0, NULL, 1471600018, 1478052094, NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_auth_assignment`
--
ALTER TABLE `tbl_auth_assignment`
 ADD PRIMARY KEY (`item_name`,`user_id`);

--
-- Indexes for table `tbl_auth_item`
--
ALTER TABLE `tbl_auth_item`
 ADD PRIMARY KEY (`name`), ADD KEY `rule_name` (`rule_name`), ADD KEY `idx-auth_item-type` (`type`);

--
-- Indexes for table `tbl_auth_item_child`
--
ALTER TABLE `tbl_auth_item_child`
 ADD PRIMARY KEY (`parent`,`child`), ADD KEY `child` (`child`);

--
-- Indexes for table `tbl_auth_rule`
--
ALTER TABLE `tbl_auth_rule`
 ADD PRIMARY KEY (`name`);

--
-- Indexes for table `tbl_course`
--
ALTER TABLE `tbl_course`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_migration`
--
ALTER TABLE `tbl_migration`
 ADD PRIMARY KEY (`version`);

--
-- Indexes for table `tbl_oauth_token`
--
ALTER TABLE `tbl_oauth_token`
 ADD PRIMARY KEY (`access_token`);

--
-- Indexes for table `tbl_opt_country`
--
ALTER TABLE `tbl_opt_country`
 ADD PRIMARY KEY (`code`);

--
-- Indexes for table `tbl_session`
--
ALTER TABLE `tbl_session`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_setting`
--
ALTER TABLE `tbl_setting`
 ADD PRIMARY KEY (`code`);

--
-- Indexes for table `tbl_subject`
--
ALTER TABLE `tbl_subject`
 ADD PRIMARY KEY (`id`), ADD KEY `fk_tbl_subject_tbl_course_idx` (`course_id`);

--
-- Indexes for table `tbl_user`
--
ALTER TABLE `tbl_user`
 ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_course`
--
ALTER TABLE `tbl_course`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `tbl_subject`
--
ALTER TABLE `tbl_subject`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `tbl_user`
--
ALTER TABLE `tbl_user`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `tbl_subject`
--
ALTER TABLE `tbl_subject`
ADD CONSTRAINT `fk_tbl_subject_tbl_course` FOREIGN KEY (`course_id`) REFERENCES `tbl_course` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
