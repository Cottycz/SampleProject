-- Adminer 4.7.5 MySQL dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

CREATE DATABASE `database` /*!40100 DEFAULT CHARACTER SET utf16 COLLATE utf16_czech_ci */;
USE `database`;

DROP TABLE IF EXISTS `news`;
CREATE TABLE `news` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `subject` varchar(55) COLLATE utf16_czech_ci NOT NULL,
  `message` text COLLATE utf16_czech_ci NOT NULL,
  `loggedonly` tinyint(4) NOT NULL,
  `system_created` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf16 COLLATE=utf16_czech_ci;

INSERT INTO `news` (`id`, `subject`, `message`, `loggedonly`, `system_created`) VALUES
(3,	'Article Three',	'Lorem ipsum dolor three',	0,	'2020-02-04 16:44:14'),
(11,	'Lorem ipsum dolor',	'Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aliquam ante. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos hymenaeos. Duis risus. Praesent dapibus. Curabitur bibendum justo non orci. Mauris metus. Nullam justo enim, consectetuer nec, ullamcorper ac, vestibulum in, elit.',	1,	'2020-02-06 11:58:09'),
(5,	'Article Five',	'Lorem ipsum dolor five',	0,	'2020-02-04 16:44:14'),
(12,	'Nulla pulvinar eleifend sem',	'Nulla pulvinar eleifend sem. Phasellus enim erat, vestibulum vel, aliquam a, posuere eu, velit. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt.',	0,	'2020-02-06 11:58:34'),
(13,	'Article Seven',	'Lorem ipsum dolor Seven',	0,	'2020-02-06 12:00:04'),
(14,	'Article Nine',	'Lorem ipsum dolor nine',	0,	'2020-02-06 12:00:14');

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(55) COLLATE utf16_czech_ci NOT NULL,
  `password` varchar(55) COLLATE utf16_czech_ci NOT NULL,
  `system_created` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf16 COLLATE=utf16_czech_ci;

INSERT INTO `users` (`id`, `username`, `password`, `system_created`) VALUES
(1,	'admin',	'admin',	'2020-02-06 21:34:36');

-- 2020-02-06 20:56:35
