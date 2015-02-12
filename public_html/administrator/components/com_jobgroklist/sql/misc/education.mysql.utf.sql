CREATE TABLE IF NOT EXISTS `#__tst_jglist_static_education` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `education` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

INSERT INTO `#__tst_jglist_static_education` (`id`, `education`) VALUES
(1, 'None'),
(2, 'High School'),
(3, '2 Year Degree'),
(4, '4 Year Degree'),
(5, 'Graduate Degree'),
(6, 'Other Diploma/Certificate');
