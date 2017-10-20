-- phpMyAdmin SQL Dump
-- version 4.2.7.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Nov 05, 2014 at 11:54 AM
-- Server version: 5.6.20
-- PHP Version: 5.5.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `email_tt_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `ett_destination_rates`
--

CREATE TABLE IF NOT EXISTS `ett_destination_rates` (
`id` int(11) NOT NULL,
  `date_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `supplier_id` int(11) NOT NULL,
  `destination_name` varchar(200) NOT NULL,
  `destination_prefix` varchar(100) NOT NULL,
  `dollar_rate` float NOT NULL,
  `call_rate` float NOT NULL,
  `status` tinyint(2) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `ett_destination_rates`
--

INSERT INTO `ett_destination_rates` (`id`, `date_time`, `supplier_id`, `destination_name`, `destination_prefix`, `dollar_rate`, `call_rate`, `status`) VALUES
(1, '2014-09-25 10:42:51', 1, 'BD', '0088', 79, 0.45, 0);

-- --------------------------------------------------------

--
-- Table structure for table `ett_drafts_email`
--

CREATE TABLE IF NOT EXISTS `ett_drafts_email` (
  `id` int(11) NOT NULL,
  `email_id` int(11) NOT NULL,
  `sender` varchar(255) NOT NULL DEFAULT '--',
  `email_from` varchar(255) NOT NULL DEFAULT '--',
  `from_email_id` varchar(255) NOT NULL DEFAULT '--',
  `email_to` varchar(255) NOT NULL DEFAULT '--',
  `to_email_id` varchar(255) DEFAULT '--',
  `email_date` varchar(100) DEFAULT '0000-00-00 00:00:00	',
  `reply_to_name` varchar(255) DEFAULT '--',
  `reply_to_email` varchar(255) NOT NULL DEFAULT '--',
  `MailDate` varchar(100) DEFAULT '0000-00-00 00:00:00	',
  `read_date` datetime DEFAULT '0000-00-00 00:00:00',
  `subject` varchar(255) CHARACTER SET utf32 NOT NULL DEFAULT '--',
  `message` longtext CHARACTER SET utf8,
  `message_html` longtext CHARACTER SET utf8,
  `msg_size` int(11) NOT NULL DEFAULT '0',
  `type` varchar(100) NOT NULL DEFAULT '--',
  `status` tinyint(2) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ett_inbox_email`
--

CREATE TABLE IF NOT EXISTS `ett_inbox_email` (
`id` int(11) NOT NULL,
  `email_id` int(11) NOT NULL,
  `sender` varchar(255) NOT NULL DEFAULT '--',
  `email_from` varchar(255) NOT NULL DEFAULT '--',
  `from_email_id` varchar(255) NOT NULL DEFAULT '--',
  `email_to` varchar(255) NOT NULL DEFAULT '--',
  `to_email_id` varchar(255) DEFAULT '--',
  `email_date` varchar(100) DEFAULT '0000-00-00 00:00:00	',
  `reply_to_name` varchar(255) DEFAULT '--',
  `reply_to_email` varchar(255) NOT NULL DEFAULT '--',
  `MailDate` varchar(100) DEFAULT '0000-00-00 00:00:00	',
  `read_date` datetime DEFAULT '0000-00-00 00:00:00',
  `subject` varchar(255) CHARACTER SET utf32 NOT NULL DEFAULT '--',
  `message` longtext CHARACTER SET utf8,
  `message_html` longtext CHARACTER SET utf8,
  `msg_size` int(11) NOT NULL DEFAULT '0',
  `type` varchar(100) NOT NULL DEFAULT '--',
  `status` tinyint(2) NOT NULL
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=34 ;

--
-- Dumping data for table `ett_inbox_email`
--


CREATE TABLE IF NOT EXISTS `ett_junk_email` (
  `id` int(11) NOT NULL,
  `email_id` int(11) NOT NULL,
  `sender` varchar(255) NOT NULL DEFAULT '--',
  `email_from` varchar(255) NOT NULL DEFAULT '--',
  `from_email_id` varchar(255) NOT NULL DEFAULT '--',
  `email_to` varchar(255) NOT NULL DEFAULT '--',
  `to_email_id` varchar(255) DEFAULT '--',
  `email_date` varchar(100) DEFAULT '0000-00-00 00:00:00	',
  `reply_to_name` varchar(255) DEFAULT '--',
  `reply_to_email` varchar(255) NOT NULL DEFAULT '--',
  `MailDate` varchar(100) DEFAULT '0000-00-00 00:00:00	',
  `read_date` datetime DEFAULT '0000-00-00 00:00:00',
  `subject` varchar(255) CHARACTER SET utf32 NOT NULL DEFAULT '--',
  `message` longtext CHARACTER SET utf8,
  `message_html` longtext CHARACTER SET utf8,
  `msg_size` int(11) NOT NULL DEFAULT '0',
  `type` varchar(100) NOT NULL DEFAULT '--',
  `status` tinyint(2) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Table structure for table `ett_permissions`
--

CREATE TABLE IF NOT EXISTS `ett_permissions` (
`permission_id` int(11) NOT NULL,
  `permission` varchar(100) NOT NULL,
  `permission_alias` varchar(100) NOT NULL,
  `description` varchar(255) NOT NULL,
  `created_on` datetime NOT NULL,
  `edited_on` datetime NOT NULL,
  `group_id` int(11) NOT NULL,
  `status` tinyint(1) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=24 ;

--
-- Dumping data for table `ett_permissions`
--

INSERT INTO `ett_permissions` (`permission_id`, `permission`, `permission_alias`, `description`, `created_on`, `edited_on`, `group_id`, `status`) VALUES
(1, 'Manage Home', 'manage_home', '', '2014-09-22 00:00:00', '0000-00-00 00:00:00', 1, 0),
(2, 'Add User', 'add_user', '', '2014-09-22 00:00:00', '0000-00-00 00:00:00', 2, 0),
(3, 'Edit User', 'edit_user', '', '2014-09-22 00:00:00', '0000-00-00 00:00:00', 2, 0),
(4, 'Manager User', 'manager_user', '', '2014-09-22 00:00:00', '0000-00-00 00:00:00', 2, 0),
(5, 'Delete User', 'delete_user', '', '2014-09-22 00:00:00', '0000-00-00 00:00:00', 2, 0),
(6, 'Manage Role', 'manage_role', '', '2014-09-22 00:00:00', '0000-00-00 00:00:00', 3, 0),
(7, 'Add Role', 'add_role', '', '2014-09-22 00:00:00', '0000-00-00 00:00:00', 3, 0),
(8, 'Edit Role', 'edit_role', '', '2014-09-22 00:00:00', '0000-00-00 00:00:00', 3, 0),
(9, 'Delete Role', 'delete_role', '', '2014-09-22 00:00:00', '0000-00-00 00:00:00', 3, 0),
(10, 'Manage Permission', 'manage_permission', '', '2014-09-22 00:00:00', '0000-00-00 00:00:00', 4, 0),
(11, 'Add Permission', 'add_permission', '', '2014-09-22 00:00:00', '0000-00-00 00:00:00', 4, 0),
(12, 'Manager Supplier', 'manager_supplier', '', '2014-09-22 00:00:00', '0000-00-00 00:00:00', 5, 0);

-- --------------------------------------------------------

--
-- Table structure for table `ett_permission_groups`
--

CREATE TABLE IF NOT EXISTS `ett_permission_groups` (
`group_id` int(11) NOT NULL,
  `group` varchar(100) NOT NULL,
  `group_alias` varchar(100) NOT NULL,
  `status` tinyint(1) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `ett_permission_groups`
--

INSERT INTO `ett_permission_groups` (`group_id`, `group`, `group_alias`, `status`) VALUES
(1, 'Home', 'home', 1),
(2, 'User', 'user', 1),
(3, 'Role', 'role', 1),
(4, 'Permission', 'permission', 1),
(5, 'Supplier', 'supplier', 1),
(6, 'Rate', 'rate', 1),
(7, 'Report', 'report', 1);

-- --------------------------------------------------------

--
-- Table structure for table `ett_response_by_support`
--

CREATE TABLE IF NOT EXISTS `ett_response_by_support` (
`id` int(11) NOT NULL,
  `email_id` varchar(11) NOT NULL,
  `response_by_id` int(11) NOT NULL,
  `estimate_time` varchar(100) NOT NULL,
  `message` varchar(255) NOT NULL,
  `is_done` tinyint(1) NOT NULL DEFAULT '0',
  `response_at` datetime NOT NULL,
  `edited_at` datetime NOT NULL,
  `done_at` datetime NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Table structure for table `ett_roles`
--

CREATE TABLE IF NOT EXISTS `ett_roles` (
`role_id` int(11) NOT NULL,
  `role` varchar(100) NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `ett_roles`
--

INSERT INTO `ett_roles` (`role_id`, `role`, `status`) VALUES
(1, 'Administrator', 1),
(3, 'Top Management', 1);

-- --------------------------------------------------------

--
-- Table structure for table `ett_role_permission_relation`
--

CREATE TABLE IF NOT EXISTS `ett_role_permission_relation` (
`id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL,
  `permission` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `ett_sent_email`
--

CREATE TABLE IF NOT EXISTS `ett_sent_email` (
  `id` int(11) NOT NULL,
  `email_id` int(11) NOT NULL,
  `sender` varchar(255) NOT NULL DEFAULT '--',
  `email_from` varchar(255) NOT NULL DEFAULT '--',
  `from_email_id` varchar(255) NOT NULL DEFAULT '--',
  `email_to` varchar(255) NOT NULL DEFAULT '--',
  `to_email_id` varchar(255) DEFAULT '--',
  `email_date` varchar(100) DEFAULT '0000-00-00 00:00:00	',
  `reply_to_name` varchar(255) DEFAULT '--',
  `reply_to_email` varchar(255) NOT NULL DEFAULT '--',
  `MailDate` varchar(100) DEFAULT '0000-00-00 00:00:00	',
  `read_date` datetime DEFAULT '0000-00-00 00:00:00',
  `subject` varchar(255) CHARACTER SET utf32 NOT NULL DEFAULT '--',
  `message` longtext CHARACTER SET utf8,
  `message_html` longtext CHARACTER SET utf8,
  `msg_size` int(11) NOT NULL DEFAULT '0',
  `type` varchar(100) NOT NULL DEFAULT '--',
  `status` tinyint(2) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Table structure for table `ett_users`
--

CREATE TABLE IF NOT EXISTS `ett_users` (
`user_id` int(11) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `designition` varchar(100) NOT NULL,
  `address` varchar(200) NOT NULL,
  `image` varchar(100) NOT NULL,
  `image_path` varchar(100) NOT NULL,
  `status` int(2) NOT NULL
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `ett_users`
--

INSERT INTO `ett_users` (`user_id`, `last_name`, `first_name`, `designition`, `address`, `image`, `image_path`, `status`) VALUES
(1, 'Ahmed', 'Mamun', 'Software Engineer', 'Dhaka', '', '', 1),
(2, 'Management', 'Top', 'Admin', 'Dhaka', '', '', 1);

-- --------------------------------------------------------

--
-- Table structure for table `ett_user_login`
--

CREATE TABLE IF NOT EXISTS `ett_user_login` (
  `user_id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `user_type` int(2) NOT NULL,
  `is_active` tinyint(1) NOT NULL,
  `can_login` tinyint(1) NOT NULL,
  `last_login` datetime NOT NULL,
  `security_code` varchar(255) NOT NULL,
  `login_ip` varchar(64) NOT NULL,
  `user_agent` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ett_user_login`
--

INSERT INTO `ett_user_login` (`user_id`, `username`, `password`, `user_type`, `is_active`, `can_login`, `last_login`, `security_code`, `login_ip`, `user_agent`) VALUES
(1, 'admin@admin.com', 'ae4b1ba2aca3875dfab6c35be673ee66', 1, 1, 1, '2014-11-05 06:57:46', '', '::1', 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:33.0) Gecko/20100101 Firefox/33.0'),
(2, 'top@management.com', '8dd57884e6505457c34f313c1154237f', 1, 1, 1, '0000-00-00 00:00:00', '', '2014-10-22 01:06:15', 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:33.0) Gecko/20100101 Firefox/33.0');

-- --------------------------------------------------------

--
-- Table structure for table `ett_user_role_relation`
--

CREATE TABLE IF NOT EXISTS `ett_user_role_relation` (
`id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `ett_user_role_relation`
--

INSERT INTO `ett_user_role_relation` (`id`, `user_id`, `role_id`) VALUES
(1, 1, 1),
(3, 2, 3);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `ett_destination_rates`
--
ALTER TABLE `ett_destination_rates`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ett_inbox_email`
--
ALTER TABLE `ett_inbox_email`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ett_permissions`
--
ALTER TABLE `ett_permissions`
 ADD PRIMARY KEY (`permission_id`);

--
-- Indexes for table `ett_permission_groups`
--
ALTER TABLE `ett_permission_groups`
 ADD PRIMARY KEY (`group_id`);

--
-- Indexes for table `ett_response_by_support`
--
ALTER TABLE `ett_response_by_support`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ett_roles`
--
ALTER TABLE `ett_roles`
 ADD PRIMARY KEY (`role_id`);

--
-- Indexes for table `ett_role_permission_relation`
--
ALTER TABLE `ett_role_permission_relation`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ett_users`
--
ALTER TABLE `ett_users`
 ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `ett_user_login`
--
ALTER TABLE `ett_user_login`
 ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `ett_user_role_relation`
--
ALTER TABLE `ett_user_role_relation`
 ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `ett_destination_rates`
--
ALTER TABLE `ett_destination_rates`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `ett_inbox_email`
--
ALTER TABLE `ett_inbox_email`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=34;
--
-- AUTO_INCREMENT for table `ett_permissions`
--
ALTER TABLE `ett_permissions`
MODIFY `permission_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=24;
--
-- AUTO_INCREMENT for table `ett_permission_groups`
--
ALTER TABLE `ett_permission_groups`
MODIFY `group_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `ett_response_by_support`
--
ALTER TABLE `ett_response_by_support`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `ett_roles`
--
ALTER TABLE `ett_roles`
MODIFY `role_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `ett_role_permission_relation`
--
ALTER TABLE `ett_role_permission_relation`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ett_users`
--
ALTER TABLE `ett_users`
MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `ett_user_role_relation`
--
ALTER TABLE `ett_user_role_relation`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
