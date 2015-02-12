CREATE TABLE IF NOT EXISTS
`#__tst_jglist_static_category` (
	`id` Int NOT NULL AUTO_INCREMENT,
	`category` TEXT NOT NULL,
	PRIMARY KEY(id)) ENGINE=InnoDB
CHARACTER SET 'utf8' COLLATE 'utf8_general_ci';

CREATE TABLE IF NOT EXISTS
`#__tst_jglist_static_country` (
	`id` Int NOT NULL AUTO_INCREMENT,
	`code` TEXT NOT NULL,
	`country` TEXT NOT NULL,
	PRIMARY KEY(id)) ENGINE=InnoDB
CHARACTER SET 'utf8' COLLATE 'utf8_general_ci';

CREATE TABLE IF NOT EXISTS
`#__tst_jglist_static_jobtype` (
        `id` Int NOT NULL AUTO_INCREMENT,
        `jobtype` TEXT NOT NULL,
        PRIMARY KEY(id)) ENGINE=InnoDB
CHARACTER SET 'utf8' COLLATE 'utf8_general_ci';

CREATE TABLE IF NOT EXISTS
`#__tst_jglist_static_companysize` (
        `id` Int NOT NULL AUTO_INCREMENT,
        `size` TEXT NOT NULL,
        PRIMARY KEY(id)) ENGINE=InnoDB
CHARACTER SET 'utf8' COLLATE 'utf8_general_ci';

CREATE TABLE IF NOT EXISTS
`#__tst_jglist_static_companyrevenue` (
        `id` Int NOT NULL AUTO_INCREMENT,
        `revenue` TEXT NOT NULL,
        PRIMARY KEY(id)) ENGINE=InnoDB
CHARACTER SET 'utf8' COLLATE 'utf8_general_ci';

CREATE TABLE IF NOT EXISTS
`#__tst_jglist_static_education` (
        `id` Int NOT NULL AUTO_INCREMENT,
        `education` TEXT NOT NULL,
        PRIMARY KEY(id)) ENGINE=InnoDB
CHARACTER SET 'utf8' COLLATE 'utf8_general_ci';

CREATE TABLE IF NOT EXISTS `#__tst_jglist_static_payrange` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `range` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS
`#__tst_jglist_categories` (
	`id` Int NOT NULL AUTO_INCREMENT,
	`code` Int NOT NULL DEFAULT 0,
	`description` Varchar(255) NOT NULL,
	`use_description` Int NOT NULL DEFAULT 0,
	`company_id` Int NOT NULL DEFAULT 0,
	`cat_contact_id` Int NOT NULL,
	`cat_notify_contact` Tinyint NOT NULL DEFAULT 0,
	`checked_out` Int UNSIGNED NOT NULL DEFAULT 0,
	`checked_out_time` Datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
	`params` Text NOT NULL DEFAULT '',
	`ordering` Int NOT NULL DEFAULT 0,
	`hits` Int NOT NULL DEFAULT 0,
	`published` Tinyint NOT NULL DEFAULT 0,
	PRIMARY KEY(id)) ENGINE=InnoDB
CHARACTER SET 'utf8' COLLATE 'utf8_general_ci';

CREATE TABLE IF NOT EXISTS
`#__tst_jglist_companies` (
	`id` Int NOT NULL AUTO_INCREMENT,
	`company` Varchar(255) NOT NULL,
	`company_revenue` Int NOT NULL DEFAULT 0,
	`company_size` Int NOT NULL DEFAULT 0,
	`checked_out` Int UNSIGNED NOT NULL DEFAULT 0,
	`checked_out_time` Datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
	`params` Text NOT NULL DEFAULT '',
	`ordering` Int NOT NULL DEFAULT 0,
	`hits` Int NOT NULL DEFAULT 0,
	`published` Tinyint NOT NULL DEFAULT 0,
	PRIMARY KEY(id)) ENGINE=InnoDB
CHARACTER SET 'utf8' COLLATE 'utf8_general_ci';

CREATE TABLE IF NOT EXISTS 
`#__tst_jglist_departments` (
	`id` Int NOT NULL AUTO_INCREMENT,
	`department` Varchar(255) NOT NULL,
	`company_id` Int NOT NULL DEFAULT 0,
	`checked_out` Int NOT NULL DEFAULT 0,
	`checked_out_time` Datetime NOT NULL,
	`params` Text NOT NULL DEFAULT '',
	`ordering` Int NOT NULL DEFAULT 0,
	`hits` Int NOT NULL DEFAULT 0,
	`published` Tinyint NOT NULL DEFAULT 0,
	PRIMARY KEY(id)) ENGINE=InnoDB
CHARACTER SET 'utf8' COLLATE 'utf8_general_ci';

CREATE TABLE IF NOT EXISTS
`#__tst_jglist_locations` (
	`id` Int NOT NULL AUTO_INCREMENT,
	`location` Varchar(255) NOT NULL,
	`use_location` Int NOT NULL DEFAULT 0,
	`loc_description` Varchar(255) NOT NULL,
	`loc_address` Varchar(255) NOT NULL,
	`country_id` Int NOT NULL DEFAULT 0,
	`company_id` Int NOT NULL DEFAULT 0,
	`checked_out` Int NOT NULL DEFAULT 0,
	`checked_out_time` Datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
	`params` Text NOT NULL DEFAULT '',
	`ordering` Int NOT NULL DEFAULT 0,
	`hits` Int NOT NULL DEFAULT 0,
	`published` Tinyint NOT NULL DEFAULT 0,
	PRIMARY KEY(id)) ENGINE = InnoDB
CHARACTER SET 'utf8' COLLATE 'utf8_general_ci';

CREATE TABLE IF NOT EXISTS
`#__tst_jglist_jobtypes` (
	`id` Int NOT NULL AUTO_INCREMENT,
	`code` Int NOT NULL DEFAULT 0,
	`jobtype` Varchar(255) NOT NULL,
	`use_description` Int NOT NULL DEFAULT 0,
	`company_id` Int NOT NULL DEFAULT 0,
	`checked_out` Int NOT NULL DEFAULT 0,
	`checked_out_time` Datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
	`params` Text NOT NULL DEFAULT '',
	`ordering` Int NOT NULL DEFAULT 0,
	`hits` Int NOT NULL DEFAULT 0,
	`published` Tinyint NOT NULL DEFAULT 0,
	PRIMARY KEY(id)) ENGINE = InnoDB
CHARACTER SET 'utf8' COLLATE 'utf8_general_ci';

CREATE TABLE IF NOT EXISTS
`#__tst_jglist_contacts` (
	`id` Int NOT NULL AUTO_INCREMENT,
	`contact` Varchar(255) NOT NULL,
	`contact_email` Varchar(255) NOT NULL,
	`company_id` Int NOT NULL DEFAULT 0,
	`checked_out` Int NOT NULL DEFAULT 0,
	`checked_out_time` Datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
	`params` Text NOT NULL DEFAULT '',
	`ordering` Int NOT NULL DEFAULT 0,
	`hits` Int NOT NULL DEFAULT 0,
	`published` Tinyint NOT NULL DEFAULT 0,
	PRIMARY KEY(id)) ENGINE = InnoDB
CHARACTER SET 'utf8' COLLATE 'utf8_general_ci';

CREATE TABLE IF NOT EXISTS
`#__tst_jglist_shifts` (
	`id` Int NOT NULL AUTO_INCREMENT,
	`shift` Varchar(255) NOT NULL,
	`company_id` Int NOT NULL DEFAULT 0,
	`checked_out` Int UNSIGNED NOT NULL DEFAULT 0,
	`checked_out_time` Datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
	`params` Text NOT NULL DEFAULT '',
	`ordering` Int NOT NULL DEFAULT 0,
	`hits` Int NOT NULL DEFAULT 0,
	`published` Tinyint NOT NULL DEFAULT 0,
	PRIMARY KEY(id)) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS
`#__tst_jglist_jobs` (
	`id` Int NOT NULL AUTO_INCREMENT,
        `job_code` Varchar(255) NOT NULL,
	`title` Varchar(255) NOT NULL,
        `alias` Varchar(255) NOT NULL,
	`category_id` Int NOT NULL,
	`department_id` Int NOT NULL,
	`shift_id` Int NOT NULL,
	`location_id` Int NOT NULL,
	`jobtype_id` Int NOT NULL,
	`company_id` Int NOT NULL,
	`education_id` Int NOT NULL,
	`pay_rate` Varchar(255) NOT NULL,
	`hide_payrate` Tinyint NOT NULL DEFAULT 0,
        `payrange` INT NOT NULL DEFAULT 0,
	`duration` Varchar(255) NOT NULL,
	`travel` Varchar(255) NOT NULL,
	`job_description` Text NOT NULL,
	`preferred_skills` Text NOT NULL,
	`checked_out` Int NOT NULL DEFAULT 0,
	`checked_out_time` Datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
	`params` Text NOT NULL DEFAULT '',
	`ordering` Int NOT NULL DEFAULT 0,
	`hits` Int NOT NULL DEFAULT 0,
	`published` Tinyint NOT NULL DEFAULT 0,
        `create_date` Datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
	PRIMARY KEY(id)) ENGINE = InnoDB
CHARACTER SET 'utf8' COLLATE 'utf8_general_ci';

CREATE TABLE IF NOT EXISTS 
`#__tst_jglist_postings` (
	`id` Int NOT NULL AUTO_INCREMENT,
        `viewlevel` Int NOT NULL DEFAULT 1,
        `featured` TINYINT NOT NULL DEFAULT 0,
	`job_id` Int NOT NULL,
	`company_id` Int NOT NULL,
        `location_id` Int NOT NULL,
	`summary` Text NOT NULL,
	`posting_date` Datetime NOT NULL,
	`closing_date` Datetime NOT NULL,
        `closing_days` INT NOT NULL DEFAULT 0,
	`contact_id` Int NOT NULL,
	`notify_contact` Tinyint NOT NULL DEFAULT 0,
	`include_detail` Tinyint NOT NULL DEFAULT 0,
	`application_type` Int NOT NULL,
        `link` TEXT,
        `link_text` TEXT,
        `tweet` Tinyint NOT NULL DEFAULT 0,
	`checked_out` Int NOT NULL DEFAULT 0,
	`checked_out_time` Datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
	`params` Text NOT NULL DEFAULT '',
	`ordering` Int NOT NULL DEFAULT 0,
	`hits` Int NOT NULL DEFAULT 0,
	`applications` Int NOT NULL DEFAULT 0,
	`published` Tinyint NOT NULL DEFAULT 0,
	PRIMARY KEY(id)) ENGINE = InnoDB
CHARACTER SET 'utf8' COLLATE 'utf8_general_ci';




CREATE TABLE IF NOT EXISTS
        `#__tst_jglist_values`
            (`variable` text,
             `value` text) ENGINE=InnoDB;
