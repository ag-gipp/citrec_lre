SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `lre`
--

CREATE DATABASE `lre` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `lre`;

-- --------------------------------------------------------

--
-- Table structure for table `experiment`
--

CREATE TABLE IF NOT EXISTS `experiment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(500) NOT NULL,
  `Description` varchar(1023) DEFAULT NULL,
  `show_small_analysis` tinyint(1) DEFAULT NULL,
  `randomize_order` tinyint(1) DEFAULT NULL,
  `debug_view` tinyint(1) DEFAULT NULL,
  `result_type_id` int(11) DEFAULT NULL,
  `visible` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `IDX_136F58B2A7750E77` (`result_type_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=12 ;

-- --------------------------------------------------------

--
-- Table structure for table `experiment_task`
--

CREATE TABLE IF NOT EXISTS `experiment_task` (
  `experiment_id` int(11) NOT NULL,
  `ref_doc_id` int(11) NOT NULL,
  `position` int(11) NOT NULL,
  PRIMARY KEY (`ref_doc_id`,`experiment_id`),
  KEY `fk_experiment` (`experiment_id`),
  KEY `fk_experiment_task_pmcfileabstract1` (`ref_doc_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `method`
--

CREATE TABLE IF NOT EXISTS `method` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

-- --------------------------------------------------------

--
-- Table structure for table `pmcfileabstract`
--

CREATE TABLE IF NOT EXISTS `pmcfileabstract` (
  `pmcid` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(2047) NOT NULL,
  `abstract` varchar(2047) NOT NULL,
  PRIMARY KEY (`pmcid`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3371822 ;

-- --------------------------------------------------------

--
-- Table structure for table `pmcfileabstract_neu`
--

CREATE TABLE IF NOT EXISTS `pmcfileabstract_neu` (
  `pmcid` int(11) NOT NULL,
  `title` varchar(4095) NOT NULL,
  `file` varchar(255) DEFAULT '',
  `abstract` text NOT NULL,
  PRIMARY KEY (`pmcid`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `recommendation`
--

CREATE TABLE IF NOT EXISTS `recommendation` (
  `doc_id` int(11) NOT NULL,
  `method_id` int(11) NOT NULL,
  `rec_doc_id` int(11) NOT NULL,
  `rec_id` int(11) NOT NULL,
  PRIMARY KEY (`doc_id`,`method_id`,`rec_id`),
  UNIQUE KEY `rec_id_UNIQUE` (`rec_id`),
  KEY `method_id` (`method_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `result`
--

CREATE TABLE IF NOT EXISTS `result` (
  `user_id` int(11) NOT NULL,
  `experiment_id` int(11) NOT NULL,
  `time` int(11) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `confidence` int(11) NOT NULL,
  `value` int(11) DEFAULT NULL,
  `recommendation_id` int(11) NOT NULL,
  PRIMARY KEY (`user_id`,`experiment_id`,`recommendation_id`),
  KEY `fk_result_user1` (`user_id`),
  KEY `fk_result_experiment1` (`experiment_id`),
  KEY `IDX_136AC113D173940B` (`recommendation_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ResultType`
--

CREATE TABLE IF NOT EXISTS `ResultType` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(200) NOT NULL,
  `passphrase` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=19 ;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `experiment_task`
--
ALTER TABLE `experiment_task`
  ADD CONSTRAINT `FK_49811A88FC4F2045` FOREIGN KEY (`ref_doc_id`) REFERENCES `pmcfileabstract` (`pmcid`),
  ADD CONSTRAINT `fk_experiment` FOREIGN KEY (`experiment_id`) REFERENCES `experiment` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `recommendation`
--
ALTER TABLE `recommendation`
  ADD CONSTRAINT `recommendation_ibfk_1` FOREIGN KEY (`doc_id`) REFERENCES `pmcfileabstract` (`pmcid`),
  ADD CONSTRAINT `recommendation_ibfk_2` FOREIGN KEY (`method_id`) REFERENCES `method` (`id`);

--
-- Constraints for table `result`
--
ALTER TABLE `result`
  ADD CONSTRAINT `FK_136AC113A76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `FK_136AC113D173940B` FOREIGN KEY (`recommendation_id`) REFERENCES `recommendation` (`rec_id`),
  ADD CONSTRAINT `FK_136AC113FF444C8` FOREIGN KEY (`experiment_id`) REFERENCES `experiment` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
