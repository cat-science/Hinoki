SET FOREIGN_KEY_CHECKS=0;

CREATE TABLE IF NOT EXISTS `ib_practices_records` (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `practice_date` date DEFAULT NULL,
  `practice_theme` VARCHAR(200) DEFAULT NULL,
  `docent_id` int(8) NOT NULL DEFAULT '0',
  `user_id` int(8) NOT NULL DEFAULT '0',
  `practice_body` text,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

SET FOREIGN_KEY_CHECKS=1;

ALTER TABLE ib_interviews DROP COLUMN practice_record;