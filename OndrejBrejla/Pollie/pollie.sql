SET NAMES utf8;
SET foreign_key_checks = 0;
SET time_zone = 'SYSTEM';

DROP TABLE IF EXISTS `pollie_answers`;
CREATE TABLE `pollie_answers` (
  `id` int(11) NOT NULL,
  `questionId` int(11) default NULL,
  `answer` text collate utf8_czech_ci,
  `votes` int(11) default NULL,
  PRIMARY KEY  (`id`),
  KEY `questionId` (`questionId`),
  CONSTRAINT `pollie_answers_ibfk_1` FOREIGN KEY (`questionId`) REFERENCES `pollie_questions` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;

INSERT INTO `pollie_answers` (`id`, `questionId`, `answer`, `votes`) VALUES
(1,	1,	'Surely yes!',	43),
(2,	1,	'Hard to say.',	11),
(3,	1,	'Sorely not!',	19);

DROP TABLE IF EXISTS `pollie_questions`;
CREATE TABLE `pollie_questions` (
  `id` int(11) NOT NULL,
  `question` text collate utf8_czech_ci,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;

INSERT INTO `pollie_questions` (`id`, `question`) VALUES
(1,	'So, will it work?');

DROP TABLE IF EXISTS `pollie_votes`;
CREATE TABLE `pollie_votes` (
  `id` int(11) NOT NULL auto_increment,
  `questionId` int(11) NOT NULL,
  `ip` varchar(15) collate utf8_czech_ci NOT NULL,
  `date` datetime NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `questionId` (`questionId`),
  CONSTRAINT `pollie_votes_ibfk_1` FOREIGN KEY (`questionId`) REFERENCES `pollie_questions` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;


