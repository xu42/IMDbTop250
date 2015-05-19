CREATE TABLE IF NOT EXISTS `top250` (
  `id` int(8) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `tname` varchar(255) DEFAULT NULL,
  `date` char(4) NOT NULL,
  `rating` char(3) NOT NULL,
  `titleid` char(9) NOT NULL,
  `img` varchar(255) NOT NULL,
  `hdimg` varchar(255) NOT NULL,
  `imdburl` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `btdown` (
  `id` int(8) unsigned NOT NULL AUTO_INCREMENT,
  `titleid` char(9) NOT NULL,
  `name` varchar(255) NOT NULL,
  `uhash` char(24) NOT NULL,
  `btid` varchar(8) NOT NULL,
  `page` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
