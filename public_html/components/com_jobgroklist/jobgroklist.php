<?php

/**
 *
 * This is the entrance point to jobgroklist
 *
 * Created: June 13, 2014, 1:18 am
 *
 * Subversion Details
 * $Date: 2014-05-11 19:41:36 -0500 (Sun, 11 May 2014) $
 * $Revision: 6072 $
 * $Author: bobsteen $
 *
 * @author TK Tek, LLC. info@jobgrok.com
 * @version 3.1-1.2.57
 * @package com_jobgroklist
 *
 * @copyright Copyright {c} 2008-2014
 * @license GNU Public License Version 2
 *
 * This file is part of JobGrok.
 *
 * JobGrok is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 2 of the License, or
 * (at your option) any later version.
 *
 * JobGrok is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with JobGrok.  If not, see <http://www.gnu.org/licenses/>.
 *
 */

defined('_JEXEC') or die('Restricted access');

$params = JComponentHelper::getParams('com_jobgroklist');
if ($params->get('display_errors','99') == '0') {
    ini_set('display_errors', '0');
} elseif ($params->get('display_errors','99') == '1') {
    ini_set('display_errors', '1');
} 

require_once (JPATH_COMPONENT .DIRECTORY_SEPARATOR. 'controller.php');
$default_controller = 'posting';

$document = JFactory::getDocument();
$cssFile = JURI::base(true).'/components/com_jobgroklist/assets/css/jobgroklist.css';
$document->addStyleSheet($cssFile, 'text/css', null, array());
JHTML::addIncludePath(JPATH_COMPONENT.DIRECTORY_SEPARATOR.'helpers');

// Because most of this is table-ified...
$css = "div.jg tr, div.jg td, div.jg_ea tr, div.jg_ea tr { border: 0px none; }";
$document->addStyleDeclaration($css);

$view = JRequest::getCmd('view');
if (JRequest::getVar('format') == 'app') JRequest::setVar('Itemid',$params->get('mobile_app_menu_item','0'));

$isMenuItem = JRequest::getVar('Itemid',false)==''?false:true;
if ($isMenuItem) {
    $db = JFactory::getDbo();
    $query = "SELECT `link` FROM #__menu WHERE id=".JRequest::getVar('Itemid');
    $db->setQuery($query); $db->query();
    $result = $db->loadObject();

    if ($result = $db->loadObject()) {
        $isMenuItem = false;
        $p = explode('&',$result->link);
        foreach ($p as $pp) {
                if ($pp == 'index.php?option=com_jobgroklist') $isMenuItem = true;
        }
    } else {
        $isMenuItem = false;
    }
}


// sets our default controller, if none is set
if ($c = JRequest :: getCmd('controller', $default_controller))
{
    if (!($isMenuItem || JRequest::getVar('e') == '1')) { $default_controller = 'denied'; }
    if (JRequest::getVar('e') == '1') { $default_controller = 'application'; }
    $path = JPATH_COMPONENT .DIRECTORY_SEPARATOR. 'controllers' .DIRECTORY_SEPARATOR. $default_controller . '.php';
    jimport('joomla.filesystem.file');
    if (JFile :: exists($path)) {
        require_once ($path);
    } else {
        JError :: raiseError('500', JText::_('Unknown controller: <br>' . $default_controller . ':' . $path));
    }
    $c = 'JobgroklistController' . $default_controller;
    $controller = new $c ();
    $controller->execute(JRequest :: getCmd('task', 'display'));
    $controller->redirect();
}
else
{
    JError::raiseError('500', JTEXT::_('COM_JOBGROKLIST_JOBGROK_NO_CONTROLLER_FOUND'));
}

?>
