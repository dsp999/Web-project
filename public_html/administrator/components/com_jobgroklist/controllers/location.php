<?php

/**
 *
 *
 * This is the location.php controller for jobgroklist
 *
 * Created: June 13, 2014, 1:18 am
 *
 * Subversion Details
 * $Date: 2012-05-05 21:53:47 -0500 (Sat, 05 May 2012) $
 * $Revision: 3836 $
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

jimport('joomla.application.component.controller');

class JobgroklistControllerLocation extends JControllerLegacy
{
	/*
	 * constructor (registers additional tasks to methods)
	 */
	function __construct()
	{
		parent :: __construct();

		// Register Extra tasks
		$this->registerTask('add', 'edit', 'copy');
	}

	/*
	 * display the edit form
	 */
	function edit()
	{
        if( version_compare( JVERSION, '1.6.0', 'ge') ) {
            $user = JFactory::getUser();
            if (!$user->authorise('core.edit', 'com_jobgroklist')) {
                return JError::raiseWarning(403, JTEXT::_('COM_JOBGROKLIST_CONTROLLERS_LOCATION_JERROR_ALERTNOAUTHOR'));
            }
            if (!$user->authorise('core.create', 'com_jobgroklist')) {
                return JError::raiseWarning(403, JTEXT::_('COM_JOBGROKLIST_CONTROLLERS_LOCATION_JERROR_ALERTNOAUTHOR'));
            }
        }
		/*
		 * Set up the desired variables for editing a category
		 */
		JRequest :: setVar('view', 'location');
		JRequest :: setVar('layout', 'default');
		JRequest :: setVar('hidemainmenu', 1);
		/*
		 * Display based on the set variables
		 */
		parent :: display();
	}

	/*
	 * remove record(s)
	 */
	function remove()
	{
        if( version_compare( JVERSION, '1.6.0', 'ge') ) {
            $user = JFactory::getUser();
            if (!$user->authorise('core.delete', 'com_jobgroklist')) {
                return JError::raiseWarning(403, JTEXT::_('COM_JOBGROKLIST_CONTROLLERS_LOCATION_JERROR_ALERTNOAUTHOR'));
            }
        }
		JRequest::checkToken() or die( 'Invalid Token');
		$model = $this->getModel('location');
		if (!$model->delete())
		{
			$msg = JTEXT::_('COM_JOBGROKLIST_CONTROLLERS_LOCATION_LOCATION_REMOVE_ERROR');
		}
		else
		{
			$msg = JTEXT::_('COM_JOBGROKLIST_CONTROLLERS_LOCATION_LOCATION_REMOVE_SUCCESS');
		}

		$this->setRedirect('index.php?option=com_jobgroklist&controller=location', $msg);
	}

	/*
	 * cancel editing a record
	 */
	function cancel()
	{
		$msg = JTEXT::_('COM_JOBGROKLIST_CONTROLLERS_LOCATION_LOCATION_CANCEL');
		$this->setRedirect('index.php?option=com_jobgroklist&controller=location', $msg);
	}

	function copy()
	{
        if( version_compare( JVERSION, '1.6.0', 'ge') ) {
            $user = JFactory::getUser();
            if (!$user->authorise('core.create', 'com_jobgroklist')) {
                return JError::raiseWarning(403, JTEXT::_('COM_JOBGROKLIST_CONTROLLERS_LOCATION_JERROR_ALERTNOAUTHOR'));
            }
        }
		JRequest::checkToken() or die( 'Invalid Token');
		// copy the selected record
		$model = $this->getModel('location');
		if (!$model->copy())
		{
			$msg = JTEXT::_('COM_JOBGROKLIST_CONTROLLERS_LOCATION_LOCATION_COPY_ERROR');
		}
		else
		{
			$msg = JTEXT::_('COM_JOBGROKLIST_CONTROLLERS_LOCATION_LOCATION_COPY_SUCCESS');
		}
		$this->setRedirect('index.php?option=com_jobgroklist&controller=location', $msg);
	}
	
	/*
	 * save a record (and redirect to main page)
	 */
	function save()
	{
        if( version_compare( JVERSION, '1.6.0', 'ge') ) {
            $user = JFactory::getUser();
            if (!$user->authorise('core.edit', 'com_jobgroklist')) {
                return JError::raiseWarning(403, JTEXT::_('COM_JOBGROKLIST_CONTROLLERS_LOCATION_JERROR_ALERTNOAUTHOR'));
            }
            if (!$user->authorise('core.create', 'com_jobgroklist')) {
                return JError::raiseWarning(403, JTEXT::_('COM_JOBGROKLIST_CONTROLLERS_LOCATION_JERROR_ALERTNOAUTHOR'));
            }
        }
		JRequest::checkToken() or die( 'Invalid Token');
		$model = $this->getModel('location');
		$format = JRequest::getVar('format');

		if ($model->store())
		{
			$msg = JTEXT::_('COM_JOBGROKLIST_CONTROLLERS_LOCATION_LOCATION_SAVED_SUCCESS');
		}
		else
		{
			$msg = JTEXT::_('COM_JOBGROKLIST_CONTROLLERS_LOCATION_LOCATION_SAVED_ERROR');
		}

		$link = 'index.php?option=com_jobgroklist&controller=location';
		if ($format == 'none') 
		{	
			$link = $link.'&view=location&format=none';
			$this->setRedirect($link);
		}
		else
		{
			$this->setRedirect($link, $msg);
		}
	}

	/* 
	 * Display 
	 */
	function display($cachable = false, $urlparams = false)
	{
        if( version_compare( JVERSION, '1.6.0', 'ge') ) {
            $user = JFactory::getUser();
            if (!$user->authorise('core.manage', 'com_jobgroklist')) {
                return JError::raiseWarning(403, JTEXT::_('COM_JOBGROKLIST_CONTROLLERS_LOCATION_JERROR_ALERTNOAUTHOR'));
            }
        }
		$document = JFactory :: getDocument();
		$viewName = JRequest :: getVar('view', 'locations');
		$viewType = $document->getType();
		$view = $this->getView($viewName, $viewType);
		$model = $this->getModel('location', 'JobgroklistModel');
		if (!JError :: isError($model))
		{
			$view->setModel($model, true);
		}
		$view->setLayout('default');
		$view->display();
	}

}
?>
