-- phpMyAdmin SQL Dump
-- version 4.0.10.18
-- https://www.phpmyadmin.net
--
-- Host: localhost:3306
-- Generation Time: May 17, 2017 at 07:39 PM
-- Server version: 5.6.35-cll-lve
-- PHP Version: 5.6.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `quotation_system`
--

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE IF NOT EXISTS `customer` (
  `customer_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL,
  `company` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `country` varchar(100) DEFAULT NULL,
  `city` varchar(100) DEFAULT NULL,
  `phone` varchar(15) DEFAULT NULL,
  `created_date` datetime NOT NULL,
  `created_by` varchar(50) NOT NULL,
  PRIMARY KEY (`customer_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`customer_id`, `name`, `company`, `email`, `country`, `city`, `phone`, `created_date`, `created_by`) VALUES
(1, 'Eche Nwankwo', 'Chowze Group Inc', 'teamchowze@gmail.com', 'US', 'Houston', '', '2017-05-01 08:37:06', 'admin'),
(2, 'Laura Grinstead', 'Merry Muffins', 'laura.grinstead98@gmail.com', 'US', 'Houston', '', '2017-05-02 09:25:57', 'admin'),
(3, 'Wong Jia Mein', 'ABB Private Limited', 'jiamein.wong@sg.abb.com', 'SG', 'Singapore', '+65 9679 3770', '2017-05-03 13:06:41', 'shawn.ignatius@sheerindustries.com'),
(4, 'Leonard Faucher', 'Franchise Innovators', 'lfaucher@franchiseinnovators.com', 'US', 'Houston', '', '2017-05-03 17:54:41', 'admin'),
(5, 'Chimmie', 'Akwukwo LLC', 'contact.akwukwo@gmail.com', 'US', 'Houston', '', '2017-05-05 08:53:59', 'admin'),
(6, 'Yejide Agunbiade', 'Hypeseekers', 'yejide912@gmail.com', 'US', 'Houston', '', '2017-05-05 10:16:17', 'admin'),
(7, 'Dagmar Garcia', '', 'dagmargarcial@gmail.com', 'US', 'Dallas', '', '2017-05-09 10:00:54', 'shawn.ignatius@sheerindustries.com'),
(8, 'Jonathan Sylvester', 'First Impression Training', 'jsylvesterfitness@gmail.com', 'US', 'Houston', '', '2017-05-09 11:39:07', 'admin'),
(9, 'John Karlo', 'Geoscience', 'johnkarlo.geoscience@gmail.com', 'US', 'Houston', '+1 281 508 0131', '2017-05-09 13:04:25', 'shawn.ignatius@sheerindustries.com');

-- --------------------------------------------------------

--
-- Table structure for table `historic_customer`
--

CREATE TABLE IF NOT EXISTS `historic_customer` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `customer_id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `company` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `country` varchar(100) DEFAULT NULL,
  `city` varchar(100) DEFAULT NULL,
  `phone` varchar(15) DEFAULT NULL,
  `updated_date` datetime NOT NULL,
  `updated_by` varchar(25) NOT NULL,
  `updated_type` varchar(50) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `historic_customer_ibfk_1` (`customer_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=12 ;

--
-- Dumping data for table `historic_customer`
--

INSERT INTO `historic_customer` (`id`, `customer_id`, `name`, `company`, `email`, `country`, `city`, `phone`, `updated_date`, `updated_by`, `updated_type`) VALUES
(1, 1, 'Eche Nwankwo', 'Chowze Group Inc', 'teamchowze@gmail.com', 'US', 'Houston', '', '2017-05-01 08:37:06', 'admin', 'new'),
(2, 2, 'Laura Grinstead', 'Merry Muffins', 'laura.grinstead98@gmail.com', 'US', 'Houston', '', '2017-05-02 09:25:57', 'admin', 'new'),
(3, 3, 'Jia Mein', 'ABB Private Limited', 'jiamein.wong@sg.abb.com', 'SG', 'Singapore', '+65 9679 3770', '2017-05-03 13:06:41', 'shawn.ignatius@sheerindus', 'new'),
(4, 3, 'Wong Jia Mein', 'ABB Private Limited', 'jiamein.wong@sg.abb.com', 'SG', 'Singapore', '+65 9679 3770', '2017-05-03 13:07:46', 'shawn.ignatius@sheerindus', 'edit'),
(5, 4, 'Leonard Faucher', 'Franchise Innovators', 'lfaucher@franchiseinnovators.com', 'US', 'Houston', '', '2017-05-03 17:54:41', 'admin', 'new'),
(6, 5, 'Chimmie', 'Akwukwo LLC', 'contact.akwukwo@gmail.com', 'US', 'Houston', '', '2017-05-05 08:53:59', 'admin', 'new'),
(7, 6, 'Yejide Agunbiade', 'Hypeseekers', 'yejide912@gmail.com', 'US', 'Houston', '', '2017-05-05 10:16:17', 'admin', 'new'),
(8, 7, 'Dagmar Garcia', '', 'dagmargarcial@gmail.com', 'US', '', '', '2017-05-09 10:00:54', 'shawn.ignatius@sheerindus', 'new'),
(9, 7, 'Dagmar Garcia', '', 'dagmargarcial@gmail.com', 'US', 'Dallas', '', '2017-05-09 10:16:33', 'shawn.ignatius@sheerindus', 'edit'),
(10, 8, 'Jonathan Sylvester', 'First Impression Training', 'jsylvesterfitness@gmail.com', 'US', 'Houston', '', '2017-05-09 11:39:07', 'admin', 'new'),
(11, 9, 'John Karlo', 'Geoscience', 'johnkarlo.geoscience@gmail.com', 'US', 'Houston', '+1 281 508 0131', '2017-05-09 13:04:25', 'shawn.ignatius@sheerindus', 'new');

-- --------------------------------------------------------

--
-- Table structure for table `historic_quotation`
--

CREATE TABLE IF NOT EXISTS `historic_quotation` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `quotation_number` int(11) NOT NULL,
  `service_type` varchar(2) NOT NULL,
  `country` varchar(2) DEFAULT NULL,
  `project_name` varchar(100) DEFAULT NULL,
  `project_description` text NOT NULL,
  `project_date` date NOT NULL,
  `status_id` int(11) NOT NULL,
  `updated_date` datetime NOT NULL,
  `updated_by` varchar(25) NOT NULL,
  `updated_type` varchar(50) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `historic_quotation_ibfk_1` (`quotation_number`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=31 ;

--
-- Dumping data for table `historic_quotation`
--

INSERT INTO `historic_quotation` (`id`, `quotation_number`, `service_type`, `country`, `project_name`, `project_description`, `project_date`, `status_id`, `updated_date`, `updated_by`, `updated_type`) VALUES
(1, 166, 'DV', 'US', 'Chowze Android Phone App', 'Migrate backend to AWS and port iOS to Android', '2017-05-01', 1, '2017-05-01 08:38:06', 'admin', 'new'),
(10, 167, 'SP', 'US', 'Website Content Update', 'Update current contents and add \\"In the news\\" page', '2017-05-02', 1, '2017-05-02 11:45:11', 'admin', 'new'),
(11, 168, 'DV', 'SG', 'PQMS - Consultancy', 'PQMS Development (Requirements Capture, Consultancy, Implementation)', '2017-05-03', 1, '2017-05-03 15:26:34', 'shawn.ignatius@sheerindus', 'new'),
(12, 169, 'DV', 'US', 'May - Monthly Support', 'Maintenance and Support for \\r\\nFranchise Innovators website and Franchise Now App', '2017-05-03', 1, '2017-05-03 17:55:28', 'admin', 'new'),
(13, 168, '', NULL, NULL, '', '0000-00-00', 2, '2017-05-03 18:37:07', 'shawn.ignatius@sheerindus', 'edit'),
(14, 169, 'SP', 'US', 'May - Monthly Support', 'Maintenance and Support for \\r\\nFranchise Innovators website and Franchise Now App', '2017-05-03', 0, '2017-05-03 19:20:28', '', 'edit'),
(15, 169, '', NULL, NULL, '', '0000-00-00', 4, '2017-05-03 19:24:15', 'admin', 'edit'),
(16, 170, 'DV', 'US', 'Hypeseekers Web Portal', 'Develop a job referral web portal.', '2017-05-05', 1, '2017-05-05 10:17:04', 'admin', 'new'),
(17, 171, 'DV', 'US', 'Blog', 'Dagmar is looking at developing a blog website.\\r\\n\\r\\n1. Blog Section With Different Categories\\r\\n2. E-Commerce\\r\\n3. Linked with Rewardstyle and Instagram\\r\\n4. Contact Us Form', '2017-05-09', 1, '2017-05-09 10:04:21', 'shawn.ignatius@sheerindus', 'new'),
(18, 172, 'DV', 'US', 'Contact Form Upgrade', 'Add conditional features to contact form', '2017-05-09', 1, '2017-05-09 11:39:35', 'admin', 'new'),
(19, 173, 'DV', 'US', 'Website', 'Informational Website', '2017-05-09', 1, '2017-05-09 13:38:50', 'shawn.ignatius@sheerindus', 'new'),
(20, 173, 'DV', 'US', 'Geologist Services Website', 'Informational Website', '2017-05-09', 0, '2017-05-10 10:38:53', '', 'edit'),
(21, 171, 'DV', 'US', 'Dagmar Garcia Blog', 'Dagmar is looking at developing a blog website.\\r\\n\\r\\n1. Blog Section With Different Categories\\r\\n2. E-Commerce\\r\\n3. Linked with Rewardstyle and Instagram\\r\\n4. Contact Us Form', '2017-05-09', 0, '2017-05-10 10:39:21', '', 'edit'),
(22, 174, 'DV', 'US', 'Akukwo Learn Igbo App', 'Akukwo Igbo Learning App for childre', '2017-05-13', 1, '2017-05-13 13:29:23', 'admin', 'new'),
(23, 166, '', NULL, NULL, '', '0000-00-00', 2, '2017-05-13 13:29:40', 'admin', 'edit'),
(24, 170, '', NULL, NULL, '', '0000-00-00', 2, '2017-05-13 13:29:59', 'admin', 'edit'),
(25, 172, '', NULL, NULL, '', '0000-00-00', 4, '2017-05-13 13:30:24', 'admin', 'edit'),
(26, 173, '', NULL, NULL, '', '0000-00-00', 2, '2017-05-13 13:30:37', 'admin', 'edit'),
(27, 171, '', NULL, NULL, '', '0000-00-00', 2, '2017-05-13 13:30:55', 'admin', 'edit'),
(28, 167, '', NULL, NULL, '', '0000-00-00', 4, '2017-05-13 13:31:11', 'admin', 'edit'),
(29, 174, 'DV', 'US', 'Akwukwo Learn Igbo App', 'Akwukwo Igbo Learning App for childre', '2017-05-13', 0, '2017-05-13 13:38:02', '', 'edit'),
(30, 175, 'DV', 'US', 'Website Refresh', 'Develop a new MerryMuffins website which includes online sales of products', '2017-05-17', 1, '2017-05-17 10:16:32', 'admin', 'new');

-- --------------------------------------------------------

--
-- Table structure for table `historic_revision`
--

CREATE TABLE IF NOT EXISTS `historic_revision` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `revision_id` int(11) NOT NULL,
  `revision_name` varchar(100) NOT NULL,
  `revision_description` text NOT NULL,
  `revision_date` date NOT NULL,
  `status_id` int(11) NOT NULL,
  `updated_date` datetime NOT NULL,
  `updated_by` varchar(50) NOT NULL,
  `updated_type` varchar(50) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `historic_revision_updatedBy_user_id` (`updated_by`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `quotation`
--

CREATE TABLE IF NOT EXISTS `quotation` (
  `quotation_number` int(11) NOT NULL AUTO_INCREMENT,
  `country` varchar(2) DEFAULT NULL,
  `service_type` varchar(2) NOT NULL,
  `customer_id` varchar(25) NOT NULL,
  `project_name` varchar(100) NOT NULL,
  `project_description` text NOT NULL,
  `project_date` date NOT NULL,
  `status_id` int(11) NOT NULL DEFAULT '1',
  `created_date` datetime NOT NULL,
  `created_by` varchar(50) NOT NULL,
  PRIMARY KEY (`quotation_number`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=176 ;

--
-- Dumping data for table `quotation`
--

INSERT INTO `quotation` (`quotation_number`, `country`, `service_type`, `customer_id`, `project_name`, `project_description`, `project_date`, `status_id`, `created_date`, `created_by`) VALUES
(166, 'US', 'DV', '1', 'Chowze Android Phone App', 'Migrate backend to AWS and port iOS to Android', '2017-05-01', 2, '2017-05-01 08:38:06', 'admin'),
(167, 'US', 'SP', '2', 'Website Content Update', 'Update current contents and add "In the news" page', '2017-05-02', 4, '2017-05-02 11:45:11', 'admin'),
(168, 'SG', 'DV', '3', 'PQMS - Consultancy', 'PQMS Development (Requirements Capture, Consultancy, Implementation)', '2017-05-03', 2, '2017-05-03 15:26:34', 'shawn.ignatius@sheerindustries.com'),
(169, 'US', 'SP', '4', 'May - Monthly Support', 'Maintenance and Support for \r\nFranchise Innovators website and Franchise Now App', '2017-05-03', 4, '2017-05-03 17:55:28', 'admin'),
(170, 'US', 'DV', '6', 'Hypeseekers Web Portal', 'Develop a job referral web portal.', '2017-05-05', 2, '2017-05-05 10:17:04', 'admin'),
(171, 'US', 'DV', '7', 'Dagmar Garcia Blog', 'Dagmar is looking at developing a blog website.\r\n\r\n1. Blog Section With Different Categories\r\n2. E-Commerce\r\n3. Linked with Rewardstyle and Instagram\r\n4. Contact Us Form', '2017-05-09', 2, '2017-05-09 10:04:21', 'shawn.ignatius@sheerindustries.com'),
(172, 'US', 'DV', '8', 'Contact Form Upgrade', 'Add conditional features to contact form', '2017-05-09', 4, '2017-05-09 11:39:35', 'admin'),
(173, 'US', 'DV', '9', 'Geologist Services Website', 'Informational Website', '2017-05-09', 2, '2017-05-09 13:38:50', 'shawn.ignatius@sheerindustries.com'),
(174, 'US', 'DV', '5', 'Akwukwo Learn Igbo App', 'Akwukwo Igbo Learning App for childre', '2017-05-13', 1, '2017-05-13 13:29:23', 'admin'),
(175, 'US', 'DV', '2', 'Website Refresh', 'Develop a new MerryMuffins website which includes online sales of products', '2017-05-17', 1, '2017-05-17 10:16:32', 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `quotation_files`
--

CREATE TABLE IF NOT EXISTS `quotation_files` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `quotation_number` int(11) NOT NULL,
  `file_name` varchar(200) NOT NULL,
  `created_date` datetime NOT NULL,
  `created_by` varchar(50) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `quotation_files_ibfk_1` (`quotation_number`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `quotation_files`
--

INSERT INTO `quotation_files` (`id`, `quotation_number`, `file_name`, `created_date`, `created_by`) VALUES
(1, 168, 'SV0317-153.pdf', '2017-05-03 18:36:49', 'shawn.ignatius@sheerindustries.com'),
(2, 173, 'DV-009-0173.pdf', '2017-05-09 14:05:41', 'shawn.ignatius@sheerindustries.com'),
(3, 171, 'DV-007-0171.pdf', '2017-05-10 10:39:59', 'admin'),
(4, 170, 'DV-006-0170.pdf', '2017-05-13 12:39:40', 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `revision`
--

CREATE TABLE IF NOT EXISTS `revision` (
  `revision_id` int(11) NOT NULL AUTO_INCREMENT,
  `quotation_number` int(11) NOT NULL,
  `revision_letter` varchar(1) NOT NULL,
  `revision_name` varchar(100) NOT NULL,
  `revision_description` text NOT NULL,
  `revision_date` date NOT NULL,
  `status_id` int(11) NOT NULL,
  `created_date` datetime NOT NULL,
  `created_by` varchar(50) NOT NULL,
  PRIMARY KEY (`revision_id`),
  KEY `revision_ibfk_1` (`quotation_number`),
  KEY `revision_status-id_1` (`status_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `revision_files`
--

CREATE TABLE IF NOT EXISTS `revision_files` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `revision_id` int(11) NOT NULL,
  `file_name` varchar(200) NOT NULL,
  `created_date` datetime NOT NULL,
  `created_by` varchar(50) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `revisionfiles_revision_id_1` (`revision_id`),
  KEY `revisionfiles_created_by_1` (`created_by`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `status`
--

CREATE TABLE IF NOT EXISTS `status` (
  `status_id` int(11) NOT NULL AUTO_INCREMENT,
  `status_name` varchar(50) NOT NULL,
  PRIMARY KEY (`status_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `status`
--

INSERT INTO `status` (`status_id`, `status_name`) VALUES
(1, 'In Progress'),
(2, 'Customer Review'),
(3, 'Canceled'),
(4, 'Closed');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `user_id` varchar(50) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `email` varchar(100) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `created_date` datetime NOT NULL,
  `created_by` varchar(50) NOT NULL,
  `last_access` datetime DEFAULT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `name`, `email`, `password_hash`, `created_date`, `created_by`, `last_access`) VALUES
('admin', 'Admin User', 'admin@sheerindustries.com', '$2y$12$UNMCNHgaeHPhW//Ue4EpfOjMb4WAihBjAyoOvHKjfEwTAcrcsoJPi', '2017-04-14 17:48:23', '', NULL),
('nicol.loh@sheerindustries.com', 'Nicol Loh', 'nicol.loh@sheerindustries.com', '$2y$12$GFOOi50nMFXnTwa108L.PO06d9hFy04HdaiOOH0akeA/fc73fbJme', '2017-05-03 13:02:17', 'admin', NULL),
('Shawn.ignatius@sheerindustries.com', 'Shawn Ignatius', 'Shawn.ignatius@sheerindustries.com', '$2y$12$UcoaQuJVuuw/QDKdVltkBeUiILJhzkKpjWcu1oK6UG65VpzuWA38a', '2017-05-03 13:01:17', 'admin', NULL);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `historic_customer`
--
ALTER TABLE `historic_customer`
  ADD CONSTRAINT `historic_customer_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customer` (`customer_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `historic_quotation`
--
ALTER TABLE `historic_quotation`
  ADD CONSTRAINT `historic_quotation_ibfk_1` FOREIGN KEY (`quotation_number`) REFERENCES `quotation` (`quotation_number`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `historic_revision`
--
ALTER TABLE `historic_revision`
  ADD CONSTRAINT `historic_revision_updatedBy_user_id` FOREIGN KEY (`updated_by`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `quotation_files`
--
ALTER TABLE `quotation_files`
  ADD CONSTRAINT `quotation_files_ibfk_1` FOREIGN KEY (`quotation_number`) REFERENCES `quotation` (`quotation_number`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `revision`
--
ALTER TABLE `revision`
  ADD CONSTRAINT `revision_ibfk_1` FOREIGN KEY (`quotation_number`) REFERENCES `quotation` (`quotation_number`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `revision_status-id_1` FOREIGN KEY (`status_id`) REFERENCES `status` (`status_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `revision_files`
--
ALTER TABLE `revision_files`
  ADD CONSTRAINT `revisionfiles_created_by_1` FOREIGN KEY (`created_by`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `revisionfiles_revision_id_1` FOREIGN KEY (`revision_id`) REFERENCES `revision` (`revision_id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
