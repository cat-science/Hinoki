SET FOREIGN_KEY_CHECKS=0;

CREATE TABLE IF NOT EXISTS `ib_ejus_records` (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `user_id` int(8) NOT NULL DEFAULT '0',
  `year` int(8) DEFAULT NULL,
  `number_of_times` int(1) DEFAULT NULL,
  `ja_reading` int(8) DEFAULT NULL,
  `ja_listening` int(8) DEFAULT NULL,
  `ja_writing` int(8) DEFAULT NULL,
  `sc_physics` int(8) DEFAULT NULL,
  `sc_chemistry` int(8) DEFAULT NULL,
  `sc_biology` int(8) DEFAULT NULL,
  `sougou` int(8) DEFAULT NULL,
  `ma_course1` int(8) DEFAULT NULL,
  `ma_course2` int(8) DEFAULT NULL,
  `created` datetime NOT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `ib_groups_lectures` (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `group_id` int(8) NOT NULL DEFAULT '0',
  `lecture_id` int(8) NOT NULL DEFAULT '0',
  `started` date DEFAULT NULL,
  `ended` date DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  `comment` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `ib_interviews` (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `user_id` int(8) NOT NULL DEFAULT '0',
  `future_path` varchar(500) DEFAULT NULL,
  `english_record` varchar(500) DEFAULT NULL,
  `parctice_record` varchar(500) DEFAULT NULL,
  `future_field` varchar(500) DEFAULT NULL,
  `admin_comment` varchar(500) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `ib_lectures` (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `lecture_name` varchar(200) DEFAULT NULL,
  `docent_id` int(8) NOT NULL DEFAULT '0',
  `lecture_date` varchar(500) DEFAULT NULL,
  `comment` varchar(200) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `ib_lectures_attendances` (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `lecture_id` int(8) NOT NULL,
  `no` int(8) NOT NULL,
  `lecture_date` DATE NOT NULL,
  `user_id` int(8) NOT NULL,
  `status` int(8) NOT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `ib_lectures_records` (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `lecture_id` int(8) NOT NULL,
  `no` int(8) NOT NULL,
  `lecture_date` DATE NOT NULL,
  `docent_id` int(8) NOT NULL,
  `text` VARCHAR(200) DEFAULT NULL,
  `homework` VARCHAR(200) DEFAULT NULL,
  `comment` VARCHAR(200) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `ib_users_lectures` (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `user_id` int(8) NOT NULL DEFAULT '0',
  `lecture_id` int(8) NOT NULL DEFAULT '0',
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  `comment` text,
  PRIMARY KEY (`id`),
  KEY `idx_user_lecture_id` (`user_id`,`lecture_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

SET FOREIGN_KEY_CHECKS=1;

ALTER TABLE ib_interviews DROP COLUMN eju_record;