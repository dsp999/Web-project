<?php
/**
* googleMaps.util.php
* allows you to include one or more google maps
* right inside Joomla content item or article
* Author: kksou
* Copyright (C) 2006-2008. kksou.com. All Rights Reserved
* License: GNU/GPL http://www.gnu.org/copyleft/gpl.html
* Website: http://www.kksou.com/php-gtk2
* 2011.11.12 googleMaps 1.7.15 googleDirections 1.7.09
* 2012.01.03 googleMaps 1.7.17 googleDirections 1.7.11
* 2012.02.03 googleMaps 1.7.18 googleDirections 1.7.12
**/

function get_paths($path_base) {
	$googleMaps_lib = $path_base.'/googleMaps/googleMaps.lib.php';
	$googleDirections_lib = $path_base.'/googleDirections/googleDirections.lib.php';
	$googleDirections_tohere_lib = $path_base.'/googleDirections_tohere/googleDirections_tohere.lib.php';
	return array($googleMaps_lib, $googleDirections_lib, $googleDirections_tohere_lib);
}

function get_googleMaps_ver($path_base) {
	$ver = '';
	$ver_file = $path_base . '/googleMaps/googleMaps.ver';
	if (file_exists ( $ver_file )) $ver = file_get_contents ( $ver_file );
	return $ver;
}

function get_googleDirections_ver($path_base) {
	$ver = '';
	$ver_file = $path_base . '/googleDirections/googleDirections.ver';
	if (file_exists ( $ver_file )) $ver = file_get_contents ( $ver_file );
	return $ver;
}

function error_msg2($required_url, $msg, $plugin) {
	print "<p style=\"background:#ffff00;padding-bottom:20px;padding-top:20px;padding-left:10px;padding-right:10px;\"><b>ERROR >>> </b>You need to install the <a href=\"http://www.kksou.com/php-gtk2/Joomla-Gadgets/{$required_url}.php#download\"><b>$msg</b></a> for the $plugin plugin to work.</p>";
}

function googleMaps_ver_ok($googleMaps_ver) {
	if (! isset ( $googleMaps_ver ) || $googleMaps_ver < '010718') { // version 1.7.18
		error_msg2('googleMaps-plugin.php', 'latest version of googleMaps plugin', 'googleDirections');
		return 0;
	} else {
		return 1;
	}
}

function googleDirections_ver_ok($googleDirections_ver) {
	if (! isset ( $googleDirections_ver ) || $googleDirections_ver < '010712') { // version 1.7.12
		error_msg2('googleDirections.php', 'latest version of googleDirections plugin', 'googleDirections_tohere');
		return 0;
	} else {
		return 1;
	}
}

?>