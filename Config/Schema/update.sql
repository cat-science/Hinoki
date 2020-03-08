SET FOREIGN_KEY_CHECKS=0;

CREATE TABLE IF NOT EXISTS `ib_qas` (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `user_id` int(8) NOT NULL,
  `title` text,
  `body` text,
  `is_anonymous` int(8) NOT NULL DEFAULT '0',
  `is_public` int(8) NOT NULL DEFAULT '0',
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


CREATE TABLE IF NOT EXISTS `ib_qas_records` (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `qa_id` int(8) NOT NULL,
  `res_user_id` int(8) NOT NULL,
  `body` text,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

SET FOREIGN_KEY_CHECKS=1;
