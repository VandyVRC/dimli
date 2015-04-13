-- phpMyAdmin SQL Dump
-- version 4.2.7.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Apr 13, 2015 at 07:47 PM
-- Server version: 5.6.20
-- PHP Version: 5.5.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `dimli`
--

-- --------------------------------------------------------

--
-- Table structure for table `activity`
--

CREATE TABLE IF NOT EXISTS `activity` (
`ActivityID` int(15) NOT NULL,
  `UserID` int(15) NOT NULL,
  `RecordType` enum('Order','Image','Work') COLLATE utf8_unicode_ci NOT NULL,
  `RecordNumber` int(15) NOT NULL,
  `ActivityType` enum('created','viewed','modified','deleted','digitized','image-edited','exported','delivered','cataloged','approved') COLLATE utf8_unicode_ci NOT NULL,
  `UnixTime` int(15) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=136090 ;

-- --------------------------------------------------------

--
-- Table structure for table `agent`
--

CREATE TABLE IF NOT EXISTS `agent` (
`id` int(11) NOT NULL,
  `related_works` text COLLATE utf8_unicode_ci NOT NULL,
  `related_images` text COLLATE utf8_unicode_ci NOT NULL,
  `agent_getty_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `agent_attribution` enum('None','After','Associate of','Circle of','Follower of','Forgery of','Office of','Pupil of','Reworking of','School of','Seal of','Studio of','Style of','Workshop of','Copy of') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'None',
  `agent_text` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `agent_type` enum('Personal','Corporate','Family','Other') COLLATE utf8_unicode_ci NOT NULL,
  `agent_role` text COLLATE utf8_unicode_ci NOT NULL,
  `display` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=48971 ;

-- --------------------------------------------------------

--
-- Table structure for table `culture`
--

CREATE TABLE IF NOT EXISTS `culture` (
`id` int(11) NOT NULL,
  `related_works` text COLLATE utf8_unicode_ci NOT NULL,
  `related_images` text COLLATE utf8_unicode_ci NOT NULL,
  `culture_getty_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `culture_text` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `display` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=49603 ;

-- --------------------------------------------------------

--
-- Table structure for table `date`
--

CREATE TABLE IF NOT EXISTS `date` (
`id` int(11) NOT NULL,
  `related_works` text COLLATE utf8_unicode_ci NOT NULL,
  `related_images` text COLLATE utf8_unicode_ci NOT NULL,
  `date_type` enum('Alteration','Broadcast','Bulk','Commission','Creation','Design','Destruction','Discovery','Exhibition','Inclusive','Performance','Publication','Restoration','Other') COLLATE utf8_unicode_ci NOT NULL,
  `date_range` tinyint(1) NOT NULL DEFAULT '0',
  `date_circa` tinyint(1) NOT NULL DEFAULT '0',
  `date_text` varchar(55) COLLATE utf8_unicode_ci NOT NULL,
  `date_era` enum('CE','BCE') COLLATE utf8_unicode_ci NOT NULL,
  `enddate_text` varchar(55) COLLATE utf8_unicode_ci NOT NULL,
  `enddate_era` enum('CE','BCE') COLLATE utf8_unicode_ci NOT NULL,
  `display` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=47282 ;

-- --------------------------------------------------------

--
-- Table structure for table `device`
--

CREATE TABLE IF NOT EXISTS `device` (
`id` int(11) NOT NULL,
  `label` varchar(11) COLLATE utf8_unicode_ci NOT NULL,
  `category` enum('Devices','Flash Drives','Remotes','Accessories','Power adapters') COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `status` enum('available','out','reserved') COLLATE utf8_unicode_ci NOT NULL,
  `patron` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `lastUpdated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updatedBy` varchar(15) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=38 ;

-- --------------------------------------------------------

--
-- Table structure for table `download`
--

CREATE TABLE IF NOT EXISTS `download` (
`id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `images` text COLLATE utf8_unicode_ci NOT NULL,
  `UnixTime` int(15) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=16 ;

-- --------------------------------------------------------

--
-- Table structure for table `edition`
--

CREATE TABLE IF NOT EXISTS `edition` (
`id` int(11) NOT NULL,
  `related_works` text COLLATE utf8_unicode_ci NOT NULL,
  `related_images` text COLLATE utf8_unicode_ci NOT NULL,
  `edition_type` enum('Edition','Impression','State','Other') COLLATE utf8_unicode_ci NOT NULL,
  `edition_text` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=45165 ;

-- --------------------------------------------------------

--
-- Table structure for table `getty_aat`
--

CREATE TABLE IF NOT EXISTS `getty_aat` (
`id` int(11) NOT NULL,
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
  `nonpref_term_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=34801 ;

-- --------------------------------------------------------

--
-- Table structure for table `getty_tgn`
--

CREATE TABLE IF NOT EXISTS `getty_tgn` (
`id` int(11) NOT NULL,
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
  `nonpref_term` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=992346 ;

-- --------------------------------------------------------

--
-- Table structure for table `getty_ulan`
--

CREATE TABLE IF NOT EXISTS `getty_ulan` (
`id` int(11) NOT NULL,
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
  `nonpref_term_language` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=202722 ;

-- --------------------------------------------------------

--
-- Table structure for table `image`
--

CREATE TABLE IF NOT EXISTS `image` (
`id` int(11) NOT NULL,
  `system_id` varchar(8) COLLATE utf8_unicode_ci NOT NULL,
  `display_id` varchar(237) COLLATE utf8_unicode_ci NOT NULL,
  `full_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
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
  `last_exported` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=69424 ;

-- --------------------------------------------------------

--
-- Table structure for table `inscription`
--

CREATE TABLE IF NOT EXISTS `inscription` (
`id` int(11) NOT NULL,
  `related_works` text COLLATE utf8_unicode_ci NOT NULL,
  `related_images` text COLLATE utf8_unicode_ci NOT NULL,
  `inscription_type` enum('Signature','Mark','Caption','Date','Text','Translation','Other') COLLATE utf8_unicode_ci NOT NULL,
  `inscription_text` text COLLATE utf8_unicode_ci NOT NULL,
  `inscription_author` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `inscription_location` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `display` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=45180 ;

-- --------------------------------------------------------

--
-- Table structure for table `lecture_tag`
--

CREATE TABLE IF NOT EXISTS `lecture_tag` (
`id` int(11) NOT NULL,
  `related_image` int(6) NOT NULL,
  `text` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `last_update_by` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `last_update_on` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=3379 ;

-- --------------------------------------------------------

--
-- Table structure for table `location`
--

CREATE TABLE IF NOT EXISTS `location` (
`id` int(11) NOT NULL,
  `related_works` text COLLATE utf8_unicode_ci NOT NULL,
  `related_images` text COLLATE utf8_unicode_ci NOT NULL,
  `location_getty_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `location_text` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `location_name_type` enum('Corporate','Geographic','Personal','Other') COLLATE utf8_unicode_ci NOT NULL,
  `location_type` enum('Creation','Discovery','Exhibition','Former owner','Former repository','Former site','Installation','Intended','Owner','Performance','Publication','Repository','Site','Other') COLLATE utf8_unicode_ci NOT NULL,
  `display` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=85741 ;

-- --------------------------------------------------------

--
-- Table structure for table `material`
--

CREATE TABLE IF NOT EXISTS `material` (
`id` int(11) NOT NULL,
  `related_works` text COLLATE utf8_unicode_ci NOT NULL,
  `related_images` text COLLATE utf8_unicode_ci NOT NULL,
  `material_type` enum('Medium','Support','Other') COLLATE utf8_unicode_ci NOT NULL,
  `material_getty_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `material_text` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `display` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=81137 ;

-- --------------------------------------------------------

--
-- Table structure for table `measurements`
--

CREATE TABLE IF NOT EXISTS `measurements` (
`id` int(11) NOT NULL,
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
  `display` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=54768 ;

-- --------------------------------------------------------

--
-- Table structure for table `order`
--

CREATE TABLE IF NOT EXISTS `order` (
`id` int(11) NOT NULL,
  `requestor` varchar(55) COLLATE utf8_unicode_ci NOT NULL,
  `requestor_id` int(11) DEFAULT NULL,
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
  `cataloguing_approved_on` date NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2697 ;

-- --------------------------------------------------------

--
-- Table structure for table `relation`
--

CREATE TABLE IF NOT EXISTS `relation` (
`id` int(11) NOT NULL,
  `related_works` text COLLATE utf8_unicode_ci NOT NULL,
  `relation_type` enum('relatedTo','partOf','formerlyPartOf','componentOf','partnerInSetWith','preparatoryFor','studyFor','cartoonFor','modelFor','planFor','counterProofFor','printingPlateFor','reliefFor','prototypeFor','designedFor','mateOf','pendantOf','exhibitedAt','copyAfter','depicts','derivedFrom','facsimileOf','replicaOf','versionOf','relatedTo','largerContextFor','formerlyLargerContextFor','componentIs','basedOn','studyIs','cartoonIs','modelIs','planIs','counterProofIs','printingPlateIs','impressionIs','prototypeIs','contextIs','mateOf','pendantOf','venueFor','copyIs','depictedIn','sourceFor','facsimileIs','relplicaIs','versionIs','imageIs') COLLATE utf8_unicode_ci NOT NULL,
  `relation_id` text COLLATE utf8_unicode_ci NOT NULL,
  `display` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=14947 ;

-- --------------------------------------------------------

--
-- Table structure for table `repository`
--

CREATE TABLE IF NOT EXISTS `repository` (
`id` int(11) NOT NULL,
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
  `images` enum('Yes','No') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'No'
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2822 ;

-- --------------------------------------------------------

--
-- Table structure for table `rights`
--

CREATE TABLE IF NOT EXISTS `rights` (
`id` int(11) NOT NULL,
  `related_works` text COLLATE utf8_unicode_ci NOT NULL,
  `related_images` text COLLATE utf8_unicode_ci NOT NULL,
  `rights_type` enum('Copyrighted','Public domain','Undetermined','Other') COLLATE utf8_unicode_ci NOT NULL,
  `rights_holder` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `rights_text` text COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=45145 ;

-- --------------------------------------------------------

--
-- Table structure for table `source`
--

CREATE TABLE IF NOT EXISTS `source` (
`id` int(11) NOT NULL,
  `related_works` text COLLATE utf8_unicode_ci NOT NULL,
  `related_images` text COLLATE utf8_unicode_ci NOT NULL,
  `source_name_type` enum('Book','Catalogue','Corpus','Donor','Electronic','Serial','Vendor','Other') COLLATE utf8_unicode_ci NOT NULL,
  `source_name_text` text COLLATE utf8_unicode_ci NOT NULL,
  `source_type` enum('Citation','ISBN','ISSN','ASIN','Open URL','URI','Vendor','Other') COLLATE utf8_unicode_ci NOT NULL,
  `source_text` text COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=100534 ;

-- --------------------------------------------------------

--
-- Table structure for table `specific_location`
--

CREATE TABLE IF NOT EXISTS `specific_location` (
`id` int(11) NOT NULL,
  `related_works` text COLLATE utf8_unicode_ci NOT NULL,
  `related_images` text COLLATE utf8_unicode_ci NOT NULL,
  `specific_location_type` enum('Address','LatLng','Note') COLLATE utf8_unicode_ci NOT NULL,
  `specific_location_address` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `specific_location_zip` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `specific_location_lat` decimal(9,6) DEFAULT NULL,
  `specific_location_long` decimal(9,6) DEFAULT NULL,
  `specific_location_note` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `display` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=13784 ;

-- --------------------------------------------------------

--
-- Table structure for table `style_period`
--

CREATE TABLE IF NOT EXISTS `style_period` (
`id` int(11) NOT NULL,
  `related_works` text COLLATE utf8_unicode_ci NOT NULL,
  `related_images` text COLLATE utf8_unicode_ci NOT NULL,
  `style_period_getty_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `style_period_text` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `display` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=49890 ;

-- --------------------------------------------------------

--
-- Table structure for table `subject`
--

CREATE TABLE IF NOT EXISTS `subject` (
`id` int(11) NOT NULL,
  `related_works` text COLLATE utf8_unicode_ci NOT NULL,
  `related_images` text COLLATE utf8_unicode_ci NOT NULL,
  `subject_type` enum('Topic: concept','Topic: descriptive','Topic: iconographic','Topic: other','Place: built work','Place: geographic','Place: other','Name: corporate','Name: personal','Name: scientific','Name: family','Name: other') COLLATE utf8_unicode_ci NOT NULL,
  `subject_text` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `subject_getty_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `display` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=46455 ;

-- --------------------------------------------------------

--
-- Table structure for table `technique`
--

CREATE TABLE IF NOT EXISTS `technique` (
`id` int(11) NOT NULL,
  `related_works` text COLLATE utf8_unicode_ci NOT NULL,
  `related_images` text COLLATE utf8_unicode_ci NOT NULL,
  `technique_getty_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `technique_text` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `display` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=67371 ;

-- --------------------------------------------------------

--
-- Table structure for table `title`
--

CREATE TABLE IF NOT EXISTS `title` (
`id` int(11) NOT NULL,
  `related_works` text COLLATE utf8_unicode_ci NOT NULL,
  `related_images` text COLLATE utf8_unicode_ci NOT NULL,
  `title_type` enum('Brand name','Cited','Creator','Descriptive','Former','Inscribed','Owner','Popular','Repository','Translated','Other') COLLATE utf8_unicode_ci NOT NULL,
  `title_text` text COLLATE utf8_unicode_ci NOT NULL,
  `display` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=51852 ;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
`id` int(11) NOT NULL,
  `username` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `crypted_password` varchar(25) COLLATE utf8_unicode_ci NOT NULL COMMENT '31py48kVKKNC2',
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
  `priv_images_flag4Export` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=156 ;

-- --------------------------------------------------------

--
-- Table structure for table `work`
--

CREATE TABLE IF NOT EXISTS `work` (
`id` int(11) NOT NULL,
  `system_id` int(11) NOT NULL,
  `display_id` varchar(237) COLLATE utf8_unicode_ci NOT NULL,
  `full_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `related_images` text COLLATE utf8_unicode_ci NOT NULL,
  `preferred_image` text COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `last_update` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `last_update_by` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` varchar(15) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=10222 ;

-- --------------------------------------------------------

--
-- Table structure for table `work_type`
--

CREATE TABLE IF NOT EXISTS `work_type` (
`id` int(11) NOT NULL,
  `related_works` text COLLATE utf8_unicode_ci NOT NULL,
  `related_images` text COLLATE utf8_unicode_ci NOT NULL,
  `work_type_getty_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `work_type_text` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `display` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=70632 ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `activity`
--
ALTER TABLE `activity`
 ADD PRIMARY KEY (`ActivityID`);

--
-- Indexes for table `agent`
--
ALTER TABLE `agent`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `culture`
--
ALTER TABLE `culture`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `date`
--
ALTER TABLE `date`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `device`
--
ALTER TABLE `device`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `download`
--
ALTER TABLE `download`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `edition`
--
ALTER TABLE `edition`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `getty_aat`
--
ALTER TABLE `getty_aat`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `getty_tgn`
--
ALTER TABLE `getty_tgn`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `getty_ulan`
--
ALTER TABLE `getty_ulan`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `image`
--
ALTER TABLE `image`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `legacy_id` (`legacy_id`), ADD UNIQUE KEY `legacy_id_2` (`legacy_id`);

--
-- Indexes for table `inscription`
--
ALTER TABLE `inscription`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `lecture_tag`
--
ALTER TABLE `lecture_tag`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `location`
--
ALTER TABLE `location`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `material`
--
ALTER TABLE `material`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `measurements`
--
ALTER TABLE `measurements`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `order`
--
ALTER TABLE `order`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `relation`
--
ALTER TABLE `relation`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `repository`
--
ALTER TABLE `repository`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rights`
--
ALTER TABLE `rights`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `source`
--
ALTER TABLE `source`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `specific_location`
--
ALTER TABLE `specific_location`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `style_period`
--
ALTER TABLE `style_period`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `subject`
--
ALTER TABLE `subject`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `technique`
--
ALTER TABLE `technique`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `title`
--
ALTER TABLE `title`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `work`
--
ALTER TABLE `work`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `work_type`
--
ALTER TABLE `work_type`
 ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `activity`
--
ALTER TABLE `activity`
MODIFY `ActivityID` int(15) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=136090;
--
-- AUTO_INCREMENT for table `agent`
--
ALTER TABLE `agent`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=48971;
--
-- AUTO_INCREMENT for table `culture`
--
ALTER TABLE `culture`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=49603;
--
-- AUTO_INCREMENT for table `date`
--
ALTER TABLE `date`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=47282;
--
-- AUTO_INCREMENT for table `device`
--
ALTER TABLE `device`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=38;
--
-- AUTO_INCREMENT for table `download`
--
ALTER TABLE `download`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=16;
--
-- AUTO_INCREMENT for table `edition`
--
ALTER TABLE `edition`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=45165;
--
-- AUTO_INCREMENT for table `getty_aat`
--
ALTER TABLE `getty_aat`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=34801;
--
-- AUTO_INCREMENT for table `getty_tgn`
--
ALTER TABLE `getty_tgn`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=992346;
--
-- AUTO_INCREMENT for table `getty_ulan`
--
ALTER TABLE `getty_ulan`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=202722;
--
-- AUTO_INCREMENT for table `image`
--
ALTER TABLE `image`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=69424;
--
-- AUTO_INCREMENT for table `inscription`
--
ALTER TABLE `inscription`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=45180;
--
-- AUTO_INCREMENT for table `lecture_tag`
--
ALTER TABLE `lecture_tag`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3379;
--
-- AUTO_INCREMENT for table `location`
--
ALTER TABLE `location`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=85741;
--
-- AUTO_INCREMENT for table `material`
--
ALTER TABLE `material`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=81137;
--
-- AUTO_INCREMENT for table `measurements`
--
ALTER TABLE `measurements`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=54768;
--
-- AUTO_INCREMENT for table `order`
--
ALTER TABLE `order`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2697;
--
-- AUTO_INCREMENT for table `relation`
--
ALTER TABLE `relation`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=14947;
--
-- AUTO_INCREMENT for table `repository`
--
ALTER TABLE `repository`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2822;
--
-- AUTO_INCREMENT for table `rights`
--
ALTER TABLE `rights`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=45145;
--
-- AUTO_INCREMENT for table `source`
--
ALTER TABLE `source`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=100534;
--
-- AUTO_INCREMENT for table `specific_location`
--
ALTER TABLE `specific_location`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=13784;
--
-- AUTO_INCREMENT for table `style_period`
--
ALTER TABLE `style_period`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=49890;
--
-- AUTO_INCREMENT for table `subject`
--
ALTER TABLE `subject`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=46455;
--
-- AUTO_INCREMENT for table `technique`
--
ALTER TABLE `technique`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=67371;
--
-- AUTO_INCREMENT for table `title`
--
ALTER TABLE `title`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=51852;
--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=156;
--
-- AUTO_INCREMENT for table `work`
--
ALTER TABLE `work`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=10222;
--
-- AUTO_INCREMENT for table `work_type`
--
ALTER TABLE `work_type`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=70632;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
