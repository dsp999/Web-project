<?php 
/*
# ------------------------------------------------------------------------
# Extensions for Joomla 2.5.x - Joomla 3.x
# ------------------------------------------------------------------------
# Copyright (C) 2011-2014 Ext-Joom.com. All Rights Reserved.
# @license - PHP files are GNU/GPL V2.
# Author: Ext-Joom.com
# Websites:  http://www.ext-joom.com 
# Date modified: 08/04/2014 - 13:00
# ------------------------------------------------------------------------
*/

// no direct access
defined('_JEXEC') or die;
error_reporting(E_ALL & ~E_NOTICE);

$document 					= JFactory::getDocument();
$document->addStyleSheet(JURI::base() . 'modules/mod_ext_bxslider_images/assets/css/jquery.bxslider.css');
$ext_jquery_ver				= $params->get('ext_jquery_ver', '1.10.2');
$ext_load_jquery			= (int)$params->get('ext_load_jquery', 1);
$ext_load_easing			= (int)$params->get('ext_load_easing', 1);
$ext_load_bxslider			= (int)$params->get('ext_load_bxslider', 1);

	
$moduleclass_sfx			= $params->get('moduleclass_sfx');
$ext_id 					= "mod_".$module->id;
$ext_width					= (int)$params->get('ext_width', 600);

// bxSlider options - http://bxslider.com/options
$ext_mode					= $params->get('ext_mode', 'horizontal');
$ext_speed					= (int)$params->get('ext_speed', 500);
$ext_controls				= $params->get('ext_controls', 'true');
$ext_auto					= $params->get('ext_auto', 'false');
$ext_autohover				= $params->get('ext_autohover', 'false');
$ext_pause					= (int)$params->get('ext_pause', 3000);
$ext_auto_controls			= $params->get('ext_auto_controls', 'true');
$ext_auto_delay				= (int)$params->get('ext_auto_delay', 0);
$ext_pager					= $params->get('ext_pager', 'true');
$ext_pager_type 			= $params->get('ext_pager_type', 'full');
$ext_pager_saparator		= $params->get('ext_pager_saparator', '/');
$ext_min_slides				= (int)$params->get('ext_min_slides', 1);
$ext_max_slides				= (int)$params->get('ext_max_slides', 1);
$ext_move_slides			= (int)$params->get('ext_move_slides', 0);	
$ext_slide_width			= (int)$params->get('ext_slide_width', 0);
$ext_slide_margin			= (int)$params->get('ext_slide_margin', 0);
$ext_adaptive_height		= $params->get('ext_adaptive_height', 'false');
$ext_adaptive_height_speed	= (int)$params->get('ext_adaptive_height_speed', 500);
$ext_easing					= $params->get('ext_easing', 'null');
//$ext_captions				= $params->get('ext_captions', 'false');
//$ext_ticker 				= $params->get('ext_ticker', 'false');
//$ext_ticker_hover			= $params->get('ext_ticker_hover', 'false');
$ext_random_start			= $params->get('ext_random_start', 'false');



// Load jQuery
//---------------------------------------------------------------------

$ext_script = <<<SCRIPT


var jQbxImg = false;
function initJQ() {
	if (typeof(jQuery) == 'undefined') {
		if (!jQbxImg) {
			jQbxImg = true;
			document.write('<scr' + 'ipt type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/$ext_jquery_ver/jquery.min.js"></scr' + 'ipt>');
		}
		setTimeout('initJQ()', 500);
	}
}
initJQ(); 
 
 if (jQuery) jQuery.noConflict();    
  
  
 

SCRIPT;

if ($ext_load_jquery  > 0) {
	$document->addScriptDeclaration($ext_script);		
}

if ($ext_load_easing  > 0) { 
	$document->addCustomTag('<script type = "text/javascript" src = "'.JURI::root().'modules/mod_ext_bxslider_images/assets/js/jquery.easing.1.3.js"></script>'); 
}
if ($ext_load_bxslider > 0) {	
	$document->addCustomTag('<script type = "text/javascript" src = "'.JURI::root().'modules/mod_ext_bxslider_images/assets/js/jquery.bxslider.min.js"></script>');
}



// Load img params
//---------------------------------------------------------------------

$names = array('img', 'alt', 'url', 'target', 'html');
$max = 5;
foreach($names as $name) {
    ${$name} = array();
    for($i = 1; $i <= $max; ++$i)
        ${$name}[] = $params->get($name . $i);
}	
require JModuleHelper::getLayoutPath('mod_ext_bxslider_images', $params->get('layout', 'default'));
echo JText::_(COP_JOOMLA);
?>