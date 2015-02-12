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

// Include dependancies
jimport('joomla.application.component.controller');

// Check component access
if (!JFactory::getUser()->authorise('core.manage', 'com_minitekwall'))
{
	return JError::raiseWarning(404, JText::_('JERROR_ALERTNOAUTHOR'));
}

// Include basic helper
JLoader::register('MinitekWallHelper', __DIR__ . '/helpers/minitekwall.php');

$controller	= JControllerLegacy::getInstance('MinitekWall');
$controller->execute(JFactory::getApplication()->input->get('task'));
$controller->redirect();

// Add stylesheet
$document = JFactory::getDocument();
$document->addStyleSheet(JURI::root().'/administrator/components/com_minitekwall/assets/css/style.css');