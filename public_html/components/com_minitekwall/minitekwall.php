<?php
/**
* @title			Minitek Wall
* @copyright   		Copyright (C) 2011-2014 Minitek, All rights reserved.
* @license   		GNU General Public License version 3 or later.
* @author url   	http://www.minitek.gr/
* @developers   	Minitek.gr
*/

// no direct access
defined('_JEXEC') or die('Restricted access');

if(!defined('DS')){
	define('DS',DIRECTORY_SEPARATOR);
}

// Require the base controller
require_once JPATH_COMPONENT.DS.'controller.php';

jimport('joomla.filesystem.file');

$controller	= JControllerLegacy::getInstance('MinitekWall');
$controller->execute(JFactory::getApplication()->input->get('task'));
$controller->redirect();

// Add helpers
require_once( JPATH_COMPONENT.DS.'helpers'.DS.'utilities.php' );

// Add stylesheet
$document = JFactory::getDocument();
$document->addStyleSheet(JURI::base().'components/com_minitekwall/assets/css/style.css');
jimport( 'joomla.application.component.helper' );
$params  = JComponentHelper::getParams('com_minitekwall');

// Load jQuery
JHtml::_('jquery.framework');

// Font Awesome
if ($params->get('load_fontawesome')) {
	$document->addStyleSheet('http://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css');
}

// Fancybox css
if ($params->get('load_fancybox')) {
	$document->addStyleSheet(JURI::base().'components/com_minitekwall/assets/fancybox/jquery.fancybox-1.3.4.css');
}
		
// Get javascript variables
$document->addScriptDeclaration('window.mnwvars = {
	token: "'.JSession::getFormToken().'",
	site_path: "'.JURI::root().'",
	itemid: "'.JRequest::getVar('Itemid').'"
};');

// Add scripts
$document->addScript(JURI::base().'components/com_minitekwall/assets/js/mnwall-isotope.js');
$document->addScript(JURI::base().'components/com_minitekwall/assets/js/mnwall-isotope-packery.js');
$document->addScript(JURI::base().'components/com_minitekwall/assets/js/mnwall.js');
$document->addScript(JURI::base().'components/com_minitekwall/assets/js/imagesloaded.pkgd.min.js');

// Fancybox
if ($params->get('load_fancybox')) {
	$document->addScript(JURI::base().'components/com_minitekwall/assets/fancybox/jquery.fancybox-1.3.4.pack.js');
}

// Add params
jimport( 'joomla.application.component.helper' );
$params  = JComponentHelper::getParams('com_minitekwall');

