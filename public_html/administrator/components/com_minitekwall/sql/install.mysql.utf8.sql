CREATE TABLE IF NOT EXISTS `#__minitek_wall_instances` (
 `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
 `type_id` int(10) unsigned NOT NULL DEFAULT '0',
 `joomla_type` text NOT NULL,
 `jomsocial_type` text NOT NULL,
 `k2_type` text NOT NULL,
 `asset_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'FK to the #__assets table.',
 `title` varchar(255) NOT NULL DEFAULT '',
 `alias` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL DEFAULT '',
 `description` mediumtext NOT NULL,
 `state` tinyint(3) NOT NULL DEFAULT '0',
 `created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
 `created_by` int(10) unsigned NOT NULL DEFAULT '0',
 `created_by_alias` varchar(255) NOT NULL DEFAULT '',
 `modified` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
 `modified_by` int(10) unsigned NOT NULL DEFAULT '0',
 `checked_out` int(10) unsigned NOT NULL DEFAULT '0',
 `checked_out_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
 `publish_up` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
 `publish_down` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
 `attribs` varchar(5120) NOT NULL,
 `ordering` int(11) NOT NULL DEFAULT '0',
 `access` int(10) unsigned NOT NULL DEFAULT '0',
 `language` char(7) NOT NULL COMMENT 'The language code for the instance.',
 `xreference` varchar(50) NOT NULL COMMENT 'A reference to enable linkages to external data sets.',
 PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `#__minitek_wall_modules` (
 `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
 `asset_id` int(10) unsigned NOT NULL DEFAULT '0',
 `name` varchar(255) NOT NULL,
 `instance_id` int(10) unsigned NOT NULL DEFAULT '0',
 `description` text NOT NULL,
 `module_type` text NOT NULL,
 `published` tinyint(1) NOT NULL DEFAULT '0',
 `checked_out` int(10) unsigned NOT NULL DEFAULT '0',
 `checked_out_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
 PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `#__minitek_wall_types` (
 `id` int(10) unsigned NOT NULL,
 `value` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `#__minitek_wall_types` (id,value)
VALUES (1,'Joomla'),(2,'K2'),(3,'Jomsocial');