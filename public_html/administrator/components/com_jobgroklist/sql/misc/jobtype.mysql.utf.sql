CREATE TABLE IF NOT EXISTS `#__tst_jglist_static_jobtype` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `jobtype` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

INSERT INTO `#__tst_jglist_static_jobtype` (`id`, `jobtype`) VALUES
(1, 'Full Time'),
(2, 'Part Time'),
(3, 'Contract'),
(4, 'Internship');
