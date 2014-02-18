-- phpMyAdmin SQL Dump
-- version 4.0.4.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Dec 16, 2013 at 11:49 PM
-- Server version: 5.5.32
-- PHP Version: 5.4.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";

SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `dimli`
--
CREATE DATABASE IF NOT EXISTS `dimli` DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;
USE `dimli`;

-- --------------------------------------------------------

--
-- Table structure for table `activity`
--

CREATE TABLE IF NOT EXISTS `activity` (
  `ActivityID` int(15) NOT NULL AUTO_INCREMENT,
  `UserID` int(15) NOT NULL,
  `RecordType` enum('Order','Image','Work') COLLATE utf8_unicode_ci NOT NULL,
  `RecordNumber` int(15) NOT NULL,
  `ActivityType` enum('created','viewed','modified','deleted','digitized','image-edited','exported','delivered','cataloged','approved') COLLATE utf8_unicode_ci NOT NULL,
  `UnixTime` int(15) NOT NULL,
  PRIMARY KEY (`ActivityID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;


-- --------------------------------------------------------

--
-- Table structure for table `agent`
--

CREATE TABLE IF NOT EXISTS `agent` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `related_works` text COLLATE utf8_unicode_ci NOT NULL,
  `related_images` text COLLATE utf8_unicode_ci NOT NULL,
  `agent_getty_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `agent_attribution` enum('None','After','Associate of','Circle of','Follower of','Forgery of','Office of','Pupil of','Reworking of','School of','Seal of','Studio of','Style of','Workshop of','Copy of') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'None',
  `agent_text` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `agent_type` enum('Personal','Corporate','Family','Other') COLLATE utf8_unicode_ci NOT NULL,
  `agent_role` text COLLATE utf8_unicode_ci NOT NULL,
  `display` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;


-- --------------------------------------------------------

--
-- Table structure for table `culture`
--

CREATE TABLE IF NOT EXISTS `culture` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `related_works` text COLLATE utf8_unicode_ci NOT NULL,
  `related_images` text COLLATE utf8_unicode_ci NOT NULL,
  `culture_getty_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `culture_text` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `display` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `date`
--

CREATE TABLE IF NOT EXISTS `date` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `related_works` text COLLATE utf8_unicode_ci NOT NULL,
  `related_images` text COLLATE utf8_unicode_ci NOT NULL,
  `date_type` enum('Alteration','Broadcast','Bulk','Commission','Creation','Design','Destruction','Discovery','Exhibition','Inclusive','Performance','Publication','Restoration','Other') COLLATE utf8_unicode_ci NOT NULL,
  `date_range` tinyint(1) NOT NULL DEFAULT '0',
  `date_circa` tinyint(1) NOT NULL DEFAULT '0',
  `date_text` varchar(55) COLLATE utf8_unicode_ci NOT NULL,
  `date_era` enum('CE','BCE') COLLATE utf8_unicode_ci NOT NULL,
  `enddate_text` varchar(55) COLLATE utf8_unicode_ci NOT NULL,
  `enddate_era` enum('CE','BCE') COLLATE utf8_unicode_ci NOT NULL,
  `display` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `edition`
--

CREATE TABLE IF NOT EXISTS `edition` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `related_works` text COLLATE utf8_unicode_ci NOT NULL,
  `related_images` text COLLATE utf8_unicode_ci NOT NULL,
  `edition_type` enum('Edition','Impression','State','Other') COLLATE utf8_unicode_ci NOT NULL,
  `edition_text` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `getty_aat`
--

CREATE TABLE IF NOT EXISTS `getty_aat` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `popularity` int(11) NOT NULL DEFAULT '0',
  `getty_id` int(11) NOT NULL,
  `record_type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `note_text` text COLLATE utf8_unicode_ci NOT NULL,
  `hierarchy` text COLLATE utf8_unicode_ci NOT NULL,
  `english_pref_term` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `pref_term_text` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `pref_term_qualifier` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `pref_term_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `nonpref_term_text` text COLLATE utf8_unicode_ci NOT NULL,
  `nonpref_term_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `getty_tgn`
--

CREATE TABLE IF NOT EXISTS `getty_tgn` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `popularity` int(11) NOT NULL DEFAULT '0',
  `getty_id` int(11) NOT NULL,
  `note_text` text COLLATE utf8_unicode_ci NOT NULL,
  `note_language` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `coord_lat_decimal` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `coord_long_decimal` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `hierarchy` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `pref_place_type_id` int(11) NOT NULL,
  `pref_place_type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `pref_historic_flag` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `nonpref_place_type_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `nonpref_place_type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `nonpref_historic_flag` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `english_pref_term` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `getty_pref_term` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `nonpref_term` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `getty_ulan`
--

CREATE TABLE IF NOT EXISTS `getty_ulan` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `popularity` int(11) NOT NULL DEFAULT '0',
  `getty_id` varchar(11) COLLATE utf8_unicode_ci NOT NULL,
  `record_type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `note_text` text COLLATE utf8_unicode_ci NOT NULL,
  `note_language` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `pref_bio_text` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `birth_date` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `death_date` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `sex` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `pref_event_id` int(11) NOT NULL,
  `pref_event_type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `pref_event_place_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `pref_event_place_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `pref_event_display_date` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `pref_event_start_date` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `pref_event_end_date` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `nonpref_event_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `nonpref_event_type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `nonpref_event_place_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `nonpref_event_place_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `nonpref_event_display_date` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `nonpref_event_start_date` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `nonpref_event_end_date` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `hierarchy` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `pref_nationality_id` int(11) NOT NULL,
  `pref_nationality_type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `nonpref_nationality_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `nonpref_nationality_type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `pref_role_id` int(11) NOT NULL,
  `pref_role_type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `pref_role_historic_flag` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `nonpref_role_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `nonpref_role_type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `nonpref_role_historical_flag` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `english_pref_term` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `pref_term` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `pref_term_historic_flag` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `pref_term_language_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `pref_term_language` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `nonpref_term` text COLLATE utf8_unicode_ci NOT NULL,
  `nonpref_term_historic_flag` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `nonpref_term_language_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `nonpref_term_language` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `image`
--

CREATE TABLE IF NOT EXISTS `image` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `legacy_id` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `related_works` text COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `order_id` int(11) NOT NULL,
  `page` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `fig` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `file_format` enum('.jpg','.tif','Other') COLLATE utf8_unicode_ci NOT NULL,
  `catalogued` tinyint(1) NOT NULL,
  `last_update` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `last_update_by` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `flagged_for_export` int(1) NOT NULL DEFAULT '0',
  `last_exported` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `inscription`
--

CREATE TABLE IF NOT EXISTS `inscription` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `related_works` text COLLATE utf8_unicode_ci NOT NULL,
  `related_images` text COLLATE utf8_unicode_ci NOT NULL,
  `inscription_type` enum('Signature','Mark','Caption','Date','Text','Translation','Other') COLLATE utf8_unicode_ci NOT NULL,
  `inscription_text` text COLLATE utf8_unicode_ci NOT NULL,
  `inscription_author` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `inscription_location` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `display` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `location`
--

CREATE TABLE IF NOT EXISTS `location` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `related_works` text COLLATE utf8_unicode_ci NOT NULL,
  `related_images` text COLLATE utf8_unicode_ci NOT NULL,
  `location_getty_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `location_text` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `location_name_type` enum('Corporate','Geographic','Personal','Other') COLLATE utf8_unicode_ci NOT NULL,
  `location_type` enum('Creation','Discovery','Exhibition','Former owner','Former repository','Former site','Installation','Intended','Owner','Performance','Publication','Repository','Site','Other') COLLATE utf8_unicode_ci NOT NULL,
  `display` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `material`
--

CREATE TABLE IF NOT EXISTS `material` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `related_works` text COLLATE utf8_unicode_ci NOT NULL,
  `related_images` text COLLATE utf8_unicode_ci NOT NULL,
  `material_type` enum('Medium','Support','Other') COLLATE utf8_unicode_ci NOT NULL,
  `material_getty_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `material_text` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `display` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `measurements`
--

CREATE TABLE IF NOT EXISTS `measurements` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `related_works` text COLLATE utf8_unicode_ci NOT NULL,
  `related_images` text COLLATE utf8_unicode_ci NOT NULL,
  `measurements_type` enum('Area','Bit depth','Circumference','Count','Depth','Diameter','Distance between','Duration','File size','Height','Length','Resolution','Running time','Scale','Size','Weight','Width','Other') COLLATE utf8_unicode_ci NOT NULL,
  `measurements_text` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `measurements_unit` varchar(9) COLLATE utf8_unicode_ci NOT NULL,
  `measurements_text_2` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `measurements_unit_2` varchar(9) COLLATE utf8_unicode_ci NOT NULL,
  `inches_value` int(11) NOT NULL,
  `area_unit` varchar(9) COLLATE utf8_unicode_ci NOT NULL,
  `duration_days` int(11) NOT NULL,
  `duration_hours` int(11) NOT NULL,
  `duration_minutes` int(11) NOT NULL,
  `duration_seconds` int(11) NOT NULL,
  `filesize_unit` varchar(9) COLLATE utf8_unicode_ci NOT NULL,
  `resolution_width` int(11) NOT NULL,
  `resolution_height` int(11) NOT NULL,
  `weight_unit` varchar(9) COLLATE utf8_unicode_ci NOT NULL,
  `measurements_description` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `display` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;
-- --------------------------------------------------------

--
-- Table structure for table `order`
--

CREATE TABLE IF NOT EXISTS `order` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `requestor` varchar(55) COLLATE utf8_unicode_ci NOT NULL,
  `department` enum('History of Art','Classical Studies','Other') COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(55) COLLATE utf8_unicode_ci NOT NULL,
  `date_created` datetime NOT NULL,
  `created_by` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `date_needed` date NOT NULL,
  `image_count` int(2) NOT NULL,
  `assigned_to` smallint(6) NOT NULL,
  `creation_pending` tinyint(1) NOT NULL DEFAULT '0',
  `cataloging_assigned_to` varchar(55) COLLATE utf8_unicode_ci NOT NULL,
  `ready_for_export` tinyint(1) NOT NULL DEFAULT '0',
  `complete` tinyint(1) NOT NULL DEFAULT '0',
  `last_update` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `last_update_by` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `order_digitized` tinyint(4) DEFAULT NULL,
  `order_digitized_by` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `order_digitized_on` date NOT NULL,
  `images_edited` tinyint(4) DEFAULT NULL,
  `images_edited_by` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `images_edited_on` date NOT NULL,
  `images_exported` tinyint(4) DEFAULT NULL,
  `images_exported_by` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `images_exported_on` date NOT NULL,
  `images_delivered` tinyint(4) DEFAULT NULL,
  `images_delivered_by` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `images_delivered_on` date NOT NULL,
  `images_catalogued` tinyint(4) DEFAULT NULL,
  `images_catalogued_by` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `images_catalogued_on` date NOT NULL,
  `cataloguing_approved` tinyint(4) DEFAULT NULL,
  `cataloguing_approved_by` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `cataloguing_approved_on` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `repository`
--

CREATE TABLE IF NOT EXISTS `repository` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `popularity` int(11) NOT NULL DEFAULT '0',
  `museum` text COLLATE utf8_unicode_ci NOT NULL,
  `address` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `city` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `state` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `zip` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `region` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `country` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `website` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `images` enum('Yes','No') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'No',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `rights`
--

CREATE TABLE IF NOT EXISTS `rights` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `related_works` text COLLATE utf8_unicode_ci NOT NULL,
  `related_images` text COLLATE utf8_unicode_ci NOT NULL,
  `rights_type` enum('Copyrighted','Public domain','Undetermined','Other') COLLATE utf8_unicode_ci NOT NULL,
  `rights_holder` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `rights_text` text COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `source`
--

CREATE TABLE IF NOT EXISTS `source` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `related_works` text COLLATE utf8_unicode_ci NOT NULL,
  `related_images` text COLLATE utf8_unicode_ci NOT NULL,
  `source_name_type` enum('Book','Catalogue','Corpus','Donor','Electronic','Serial','Vendor','Other') COLLATE utf8_unicode_ci NOT NULL,
  `source_name_text` text COLLATE utf8_unicode_ci NOT NULL,
  `source_type` enum('Citation','ISBN','ISSN','ASIN','Open URL','URI','Vendor','Other') COLLATE utf8_unicode_ci NOT NULL,
  `source_text` text COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `style_period`
--

CREATE TABLE IF NOT EXISTS `style_period` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `related_works` text COLLATE utf8_unicode_ci NOT NULL,
  `related_images` text COLLATE utf8_unicode_ci NOT NULL,
  `style_period_getty_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `style_period_text` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `display` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `subject`
--

CREATE TABLE IF NOT EXISTS `subject` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `related_works` text COLLATE utf8_unicode_ci NOT NULL,
  `related_images` text COLLATE utf8_unicode_ci NOT NULL,
  `subject_type` enum('Topic: concept','Topic: descriptive','Topic: iconographic','Topic: other','Place: built work','Place: geographic','Place: other','Name: corporate','Name: personal','Name: scientific','Name: family','Name: other') COLLATE utf8_unicode_ci NOT NULL,
  `subject_text` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `subject_getty_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `display` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `technique`
--

CREATE TABLE IF NOT EXISTS `technique` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `related_works` text COLLATE utf8_unicode_ci NOT NULL,
  `related_images` text COLLATE utf8_unicode_ci NOT NULL,
  `technique_getty_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `technique_text` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `display` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `title`
--

CREATE TABLE IF NOT EXISTS `title` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `related_works` text COLLATE utf8_unicode_ci NOT NULL,
  `related_images` text COLLATE utf8_unicode_ci NOT NULL,
  `title_type` enum('Brand name','Cited','Creator','Descriptive','Former','Inscribed','Owner','Popular','Repository','Translated','Other') COLLATE utf8_unicode_ci NOT NULL,
  `title_text` text COLLATE utf8_unicode_ci NOT NULL,
  `display` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `crypted_password` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  `first_name` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  `last_name` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  `display_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `department` enum('History of Art','Classical Studies','Other') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'Other',
  `last_order` mediumint(4) NOT NULL,
  `last_legReader` int(6) NOT NULL DEFAULT '0',
  `pref_lantern_view` enum('list','grid') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'grid',
  `pref_user_type` enum('cataloger','end_user') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'end_user',
  `date_created` datetime NOT NULL,
  `last_update` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `priv_digitize` tinyint(1) NOT NULL DEFAULT '0',
  `priv_edit` tinyint(1) NOT NULL DEFAULT '0',
  `priv_exportImages` tinyint(1) NOT NULL DEFAULT '0',
  `priv_deliver` tinyint(1) NOT NULL DEFAULT '0',
  `priv_catalog` tinyint(1) NOT NULL DEFAULT '0',
  `priv_approve` tinyint(1) NOT NULL DEFAULT '0',
  `priv_users_read` tinyint(1) NOT NULL DEFAULT '0',
  `priv_users_create` tinyint(1) NOT NULL DEFAULT '0',
  `priv_users_delete` tinyint(1) NOT NULL DEFAULT '0',
  `priv_orders_read` tinyint(1) NOT NULL DEFAULT '0',
  `priv_orders_create` tinyint(1) NOT NULL DEFAULT '0',
  `priv_orders_confirmCreation` tinyint(1) NOT NULL DEFAULT '0',
  `priv_orders_download` tinyint(1) NOT NULL DEFAULT '0',
  `priv_orders_delete` tinyint(1) NOT NULL DEFAULT '0',
  `priv_csv_import` tinyint(1) NOT NULL DEFAULT '0',
  `priv_csv_export` tinyint(1) NOT NULL DEFAULT '0',
  `priv_image_ids_edit` tinyint(1) NOT NULL DEFAULT '0',
  `priv_images_delete` tinyint(1) NOT NULL DEFAULT '0',
  `priv_images_flag4Export` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=46 ;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `username`, `crypted_password`, `first_name`, `last_name`, `display_name`, `email`, `department`, `last_order`, `last_legReader`, `pref_lantern_view`, `pref_user_type`, `date_created`, `last_update`, `priv_digitize`, `priv_edit`, `priv_exportImages`, `priv_deliver`, `priv_catalog`, `priv_approve`, `priv_users_read`, `priv_users_create`, `priv_users_delete`, `priv_orders_read`, `priv_orders_create`, `priv_orders_confirmCreation`, `priv_orders_download`, `priv_orders_delete`, `priv_csv_import`, `priv_csv_export`, `priv_image_ids_edit`,`priv_images_delete`, `priv_images_flag4Export`) VALUES
(1, 'admin', '19Dk3miSfj2Dc', 'Admin', 'Doe', 'Default Admin', 'johndoe@dimli.org', 'Other', 0, 0, 'list', 'cataloger', '2013-11-01 20:38:26', '2013-12-16 21:49:29', 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1);
-- --------------------------------------------------------

--
-- Table structure for table `work`
--

CREATE TABLE IF NOT EXISTS `work` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `legacy_id` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `related_images` text COLLATE utf8_unicode_ci NOT NULL,
  `preferred_image` text COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `last_update` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `last_update_by` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `work_type`
--

CREATE TABLE IF NOT EXISTS `work_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `related_works` text COLLATE utf8_unicode_ci NOT NULL,
  `related_images` text COLLATE utf8_unicode_ci NOT NULL,
  `work_type_getty_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `work_type_text` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `display` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
