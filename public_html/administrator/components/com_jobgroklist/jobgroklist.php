<?php

/**
 * (?=.*?\bindex\b)^(?!.*Itemid).* 
 * This is the entrance point to jobgroklist (admin)
 *
 * Created: June 13, 2014, 1:18 am
 *
 * Subversion Details
 * $Date: 2014-04-20 16:01:30 -0500 (Sun, 20 Apr 2014) $
 * $Revision: 5940 $
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

$document = JFactory::getDocument();
$cssFile = JURI::base(true).'/components/com_jobgroklist/assets/css/jobgroklist.css';
$document->addStyleSheet($cssFile, 'text/css', null, array());

JHTML::addIncludePath(JPATH_COMPONENT.DIRECTORY_SEPARATOR.'helpers');

$params = JComponentHelper::getParams('com_jobgroklist');
if ($params->get('display_errors','99') == '0') {
    ini_set('display_errors', '0');
} elseif ($params->get('display_errors','99') == '1') {
    ini_set('display_errors', '1');
} 

require_once (JPATH_COMPONENT .DIRECTORY_SEPARATOR. 'controller.php');

// sets our default controller, if none is set
if ($c = JRequest :: getCmd('controller', 'panel')) {
    $path = JPATH_COMPONENT .DIRECTORY_SEPARATOR. 'controllers' .DIRECTORY_SEPARATOR. $c . '.php';
    jimport('joomla.filesystem.file');

    if (JFile :: exists($path)) {
        // chosen controller - all the action happens here
        require_once ($path);
    }
    else {
        JError :: raiseError('500', JText::_('Unknown controller: <br>' . $c . ':' . $path));
    }
}

$task = JRequest::getCmd('task','display');
if ( $c == 'panel' || $c == 'company' || $c == 'category' || $c == 'contact' || $c == 'department' ||
        $c == 'jobtype' || $c == 'location' || $c == 'shift' || $c == 'posting' || $c == 'job') {
    $panel = 'index.php?option=com_jobgroklist&controller=panel';
    $job = 'index.php?option=com_jobgroklist&controller=job';
    $posting = 'index.php?option=com_jobgroklist&controller=posting';
    $company = 'index.php?option=com_jobgroklist&controller=company';
    $location = 'index.php?option=com_jobgroklist&controller=location';
    $department = 'index.php?option=com_jobgroklist&controller=department';
    $category = 'index.php?option=com_jobgroklist&controller=category';
    $jobtype = 'index.php?option=com_jobgroklist&controller=jobtype';
    $shift = 'index.php?option=com_jobgroklist&controller=shift';
    $contact = 'index.php?option=com_jobgroklist&controller=contact';

    JSubMenuHelper::addEntry(JTEXT::_('COM_JOBGROKLIST_ADMIN_JOBGROK_COM_JOBGROK_CONTROL_PANEL'), $panel, $c=='panel');
    JSubMenuHelper::addEntry(JTEXT::_('COM_JOBGROKLIST_ADMIN_JOBGROK_POSTINGS'), $posting, $c=='posting');
    JSubMenuHelper::addEntry(JTEXT::_('COM_JOBGROKLIST_ADMIN_JOBGROK_JOBS'), $job, $c=='job');
    JSubMenuHelper::addEntry(JTEXT::_('COM_JOBGROKLIST_ADMIN_JOBGROK_COMPANY'), $company, $c=='company');
    JSubMenuHelper::addEntry(JTEXT::_('COM_JOBGROKLIST_ADMIN_JOBGROK_LOCATION'), $location, $c=='location');
    JSubMenuHelper::addEntry(JTEXT::_('COM_JOBGROKLIST_ADMIN_JOBGROK_DEPARTMENT'), $department, $c=='department');
    JSubMenuHelper::addEntry(JTEXT::_('COM_JOBGROKLIST_ADMIN_JOBGROK_CATEGORY'), $category, $c=='category');
    JSubMenuHelper::addEntry(JTEXT::_('COM_JOBGROKLIST_ADMIN_JOBGROK_JOB_TYPE'), $jobtype, $c=='jobtype');
    JSubMenuHelper::addEntry(JTEXT::_('COM_JOBGROKLIST_ADMIN_JOBGROK_SHIFT'), $shift, $c=='shift');
    JSubMenuHelper::addEntry(JTEXT::_('COM_JOBGROKLIST_ADMIN_JOBGROK_CONTACT'), $contact, $c=='contact');
}

$c = 'JobgroklistController' . $c;
$controller = new $c();
$controller->execute($task);
$controller->redirect();
?>
