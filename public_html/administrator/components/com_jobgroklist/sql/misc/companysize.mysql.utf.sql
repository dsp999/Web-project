CREATE TABLE IF NOT EXISTS `#__tst_jglist_static_companysize` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `size` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

INSERT INTO `#__tst_jglist_static_companysize` (`id`, `size`) VALUES
(1, '1 to 2 Employees'),
(2, '3 to 20 Employees'),
(3, '21 to 50 Employees'),
(4, '51 to 100 Employees'),
(5, '101 to 500 Employees'),
(6, '501 to 1000 Employees'),
(7, '1001 to 5000 Employees'),
(8, '5001 to 10000 Employees'),
(9, '10001 to 50000 Employees'),
(10, '50001 or more Employees');
