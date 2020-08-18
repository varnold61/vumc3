CREATE DATABASE `repos` /*!40100 DEFAULT CHARACTER SET latin1 */;

USE repos;

DROP TABLE IF EXISTS  repos;
CREATE TABLE repos (
   `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `repo_id` int(11) unsigned NOT NULL UNIQUE,
  `name` varchar(80) DEFAULT NULL,
  `url` varchar(256) DEFAULT NULL,
  `desc` varchar(256) DEFAULT NULL,
  `stars` int(11) NOT NULL DEFAULT 0,
  `created`  DATETIME NOT NULL,
  `last_push` DATETIME,
  `rawdata` blob DEFAULT NULL,
  PRIMARY KEY (`id`)
  ) ENGINE=InnoDB;
