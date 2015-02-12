<?php
/**
* @title			Newsticker for K2
* @version   		3.x
* @copyright   		Copyright (C) 2011-2014 Minitek, All rights reserved.
* @license   		GNU General Public License version 3 or later.
* @author url   	http://www.minitek.gr/
* @author email   	info@minitek.gr
* @developers   	Minitek.gr
*/

// no direct access
defined('_JEXEC') or die('Restricted access');

if(!defined('DS')){
define('DS',DIRECTORY_SEPARATOR);
}

// Get Helper function
require_once JPATH_SITE.DS.'modules'.DS.'mod_newsticker_for_k2'.DS.'helper.php';

// Get global variables
$module_id = $module->id;

// Define parameters
if ($params->get('auto_module_id')) {
  $newstickerk2 = 'newstickerk2'.$module_id;
} else {
  $newstickerk2 = ''.$params->get('custom_module_id'); 
}

// Add stylesheets
$document = & JFactory::getDocument();
$document->addStyleSheet(JURI::base().'modules/mod_newsticker_for_k2/assets/css/ticker-style.css');

// Add scripts
if ($params->get('load_jquery')) {
	$document->addScript(JURI::base().'modules/mod_newsticker_for_k2/assets/js/jquery.min.js');
}
$document->addScript(JURI::base().'modules/mod_newsticker_for_k2/assets/js/jquery.ticker.js');

// Define Params
$titleText = $params->get('titleText');
$displayType = $params->get('displayType');
/*if ($params->get('controls')) {
	$controls = 'true';
} else {
	$controls = 'false';
}*/
$speed = $params->get('speed');
//$direction = $params->get('direction');
$pauseOnItems = $params->get('pauseOnItems');
$fadeInSpeed = $params->get('fadeInSpeed');
$fadeOutSpeed = $params->get('fadeOutSpeed');

// Add script
$document->addScriptDeclaration(
   'jQuery.noConflict();
   
     jQuery(document).ready(function() {
			
		  jQuery("#'.$newstickerk2.'").ticker({
			  ajaxFeed: false,       // Populate jQuery News Ticker via a feed
			  feedUrl: false,        // The URL of the feed
									 // MUST BE ON THE SAME DOMAIN AS THE TICKER
			  feedType: "xml",       // Currently only XML
			  htmlFeed: true,        // Populate jQuery News Ticker via HTML
			  debugMode: false,       // Show some helpful errors in the console or as alerts
									 // SHOULD BE SET TO FALSE FOR PRODUCTION SITES!
			  
			  titleText: "'.$titleText.'",   // To remove the title set this to an empty String
			  displayType: "'.$displayType.'", 
			  speed: '.$speed.',     			   
			  controls: false,        
			  direction: "ltr",     
			  pauseOnItems: '.$pauseOnItems.', 
			  fadeInSpeed: '.$fadeInSpeed.', 
			  fadeOutSpeed: '.$fadeOutSpeed.',
		  });			
			
	 });
   '
);

// Get Helper function
$items = modNewstickerForK2Helper::getItems($params, $module_id);

require(JModuleHelper::getLayoutPath('mod_newsticker_for_k2'));