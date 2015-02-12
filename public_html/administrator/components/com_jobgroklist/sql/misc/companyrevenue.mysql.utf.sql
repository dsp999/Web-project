CREATE TABLE IF NOT EXISTS `#__tst_jglist_static_companyrevenue` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `revenue` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

INSERT INTO `#__tst_jglist_static_companyrevenue` (`id`, `revenue`) VALUES
(1, 'Less than 250000'),
(2, 'Between 250000 and 1 Million'),
(3, 'Between 1 Million and 10 Million'),
(4, 'Between 10 Million and 100 Million'),
(5, 'Between 100 Million and 1 Billion'),
(6, 'More than 1 Billion');
