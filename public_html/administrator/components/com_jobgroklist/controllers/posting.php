<?php

/**
 *
 *
 * This is the posting.php controller for jobgroklist
 *
 * Created: June 13, 2014, 1:18 am
 *
 * Subversion Details
 * $Date: 2013-02-10 15:36:10 -0600 (Sun, 10 Feb 2013) $
 * $Revision: 4742 $
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

class JobgroklistControllerPosting extends JControllerLegacy
{
	/*
	 * constructor (registers additional tasks to methods)
	 */
	function __construct()
	{
		parent :: __construct();

		// Register Extra tasks
		$this->registerTask('add', 'edit');
	}

	function import()
	{
		JRequest::checkToken() or die( 'Invalid Token');
		$model = $this->getModel('posting');
		if ( !$model->import())
		{
			$msg = JTEXT::_('COM_JOBGROKLIST_CONTROLLERS_POSTING_ERROR_COULD_NOT_IMPORT_FROM_PRIOR_VERSION');
		}
		else
		{
			$msg = JTEXT::_('COM_JOBGROKLIST_CONTROLLERS_POSTING_IMPORTED_DATA_FROM_PRIOR_VERSION');
		}
		$this->setRedirect('index.php?option=com_jobgroklist&controller=posting', $msg);
	}

        function bugFixI()
        {
            $model = $this->getModel('posting');
            if ( !$model->bugFixI())
            {
                $msg = JTEXT::_('COM_JOBGROKLIST_CONTROLLERS_POSTING_BUG_FIX_I_FAILED');
            }
            else
            {
                $msg = JTEXT::_('COM_JOBGROKLIST_CONTROLLERS_POSTING_BUG_FIX_I_SUCCESS');
            }
            $this->setRedirect('index.php?option=com_jobgroklist&controller=posting',$msg);
        }
	
	function publish()
	{
		JRequest::checkToken() or die( 'Invalid Token');
		$model = $this->getModel('posting');
		if (!$model->publish())
		{
			$msg = JTEXT::_('COM_JOBGROKLIST_CONTROLLERS_POSTING_PUBLISHED_JOB_POSTING_ERROR');
		}	
		else
		{
			$msg = JTEXT::_('COM_JOBGROKLIST_CONTROLLERS_POSTING_PUBLISHED_JOB_POSTING_SUCCESS');
		}
		$this->setRedirect('index.php?option=com_jobgroklist&controller=posting', $msg);
	}
	
	function unpublish()
	{
		JRequest::checkToken() or die( 'Invalid Token');
		$model = $this->getModel('posting');
		if (!$model->unpublish())
		{
			$msg = JTEXT::_('COM_JOBGROKLIST_CONTROLLERS_POSTING_UNPUBLISHED_JOB_POSTING_ERROR');
		}	
		else
		{
			$msg = JTEXT::_('COM_JOBGROKLIST_CONTROLLERS_POSTING_UNPUBLISHED_JOB_POSTING_SUCCESS');
		}
		$this->setRedirect('index.php?option=com_jobgroklist&controller=posting', $msg);
	}

        function featured() {
            if( version_compare( JVERSION, '1.6.0', 'ge') ) {
                $user = JFactory::getUser();
                if (!$user->authorise('core.edit', 'com_jobgroklist')) {
                    return JError::raiseWarning(403, JTEXT::_('COM_JOBGROKLIST_CONTROLLERS_POSTING_JERROR_ALERTNOAUTHOR'));
                }
            }
            $model = $this->getModel('posting');
            if (!$model->featured()) {
                $msg = JTEXT::_('COM_JOBGROKLIST_CONTROLLERS_POSTING_FEATURED_JOB_POSTING_ERROR');
            } else {
                $msg = JTEXT::_('COM_JOBGROKLIST_CONTROLLERS_POSTING_FEATURED_JOB_POSTING_SUCCESS');
            }
            $this->setRedirect('index.php?option=com_jobgroklist&controller=posting', $msg);
        }

        function unfeatured() {
            if( version_compare( JVERSION, '1.6.0', 'ge') ) {
                $user = JFactory::getUser();
                if (!$user->authorise('core.edit', 'com_jobgroklist')) {
                    return JError::raiseWarning(403, JTEXT::_('COM_JOBGROKLIST_CONTROLLERS_POSTING_JERROR_ALERTNOAUTHOR'));
                }
            }
            $model = $this->getModel('posting');
            if (!$model->unfeatured()) {
                $msg = JTEXT::_('COM_JOBGROKLIST_CONTROLLERS_POSTING_UNFEATURED_JOB_POSTING_ERROR');
            } else {
                $msg = JTEXT::_('COM_JOBGROKLIST_CONTROLLERS_POSTING_UNFEATURED_JOB_POSTING_SUCCESS');
            }
            $this->setRedirect('index.php?option=com_jobgroklist&controller=posting', $msg);
        }
        
	/*
	 * display the edit form
	 */
	function edit()
	{
        if( version_compare( JVERSION, '1.6.0', 'ge') ) {
            $user = JFactory::getUser();
            if (!$user->authorise('core.edit', 'com_jobgroklist')) {
                return JError::raiseWarning(403, JTEXT::_('COM_JOBGROKLIST_CONTROLLERS_POSTING_JERROR_ALERTNOAUTHOR'));
            }
            if (!$user->authorise('core.create', 'com_jobgroklist')) {
                return JError::raiseWarning(403, JTEXT::_('COM_JOBGROKLIST_CONTROLLERS_POSTING_JERROR_ALERTNOAUTHOR'));
            }
        }
		/*
		 * Set up the desired variables for editing a category
		 */
		JRequest :: setVar('view', 'posting');
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
                return JError::raiseWarning(403, JTEXT::_('COM_JOBGROKLIST_CONTROLLERS_POSTING_JERROR_ALERTNOAUTHOR'));
            }
        }
		JRequest::checkToken() or die( 'Invalid Token');
		$model = $this->getModel('posting');
		if (!$model->delete())
		{
			$msg = JTEXT::_('COM_JOBGROKLIST_CONTROLLERS_POSTING_POSTING_REMOVE_ERROR');
		}
		else
		{
			$msg = JTEXT::_('COM_JOBGROKLIST_CONTROLLERS_POSTING_POSTING_REMOVE_SUCCESS');
		}

		$this->setRedirect('index.php?option=com_jobgroklist&controller=posting', $msg);
	}

	/*
	 * cancel editing a record
	 */
	function cancel()
	{
		$msg = JTEXT::_('COM_JOBGROKLIST_CONTROLLERS_POSTING_POSTING_CANCEL');
		$this->setRedirect('index.php?option=com_jobgroklist&controller=posting', $msg);
	}

	function copy()
	{
        if( version_compare( JVERSION, '1.6.0', 'ge') ) {
            $user = JFactory::getUser();
            if (!$user->authorise('core.create', 'com_jobgroklist')) {
                return JError::raiseWarning(403, JTEXT::_('COM_JOBGROKLIST_CONTROLLERS_POSTING_JERROR_ALERTNOAUTHOR'));
            }
        }
		JRequest::checkToken() or die( 'Invalid Token');
		// copy the selected record
		$model = $this->getModel('posting');
		if (!$model->copy())
		{
			$msg = JTEXT::_('COM_JOBGROKLIST_CONTROLLERS_POSTING_POSTING_COPY_ERROR');
		}
		else
		{
			$msg = JTEXT::_('COM_JOBGROKLIST_CONTROLLERS_POSTING_POSTING_COPY_SUCCESS');
		}
		$this->setRedirect('index.php?option=com_jobgroklist&controller=posting', $msg);
	}

	/*
	 * save a record (and redirect to main page)
	 */
	function save()
	{
        if( version_compare( JVERSION, '1.6.0', 'ge') ) {
            $user = JFactory::getUser();
            if (!$user->authorise('core.edit', 'com_jobgroklist')) {
                return JError::raiseWarning(403, JTEXT::_('COM_JOBGROKLIST_CONTROLLERS_POSTING_JERROR_ALERTNOAUTHOR'));
            }
            if (!$user->authorise('core.create', 'com_jobgroklist')) {
                return JError::raiseWarning(403, JTEXT::_('COM_JOBGROKLIST_CONTROLLERS_POSTING_JERROR_ALERTNOAUTHOR'));
            }
        }
		JRequest::checkToken() or die( 'Invalid Token');
		$model = $this->getModel('Posting');

		if ($model->store())
		{
			$msg = JTEXT::_('COM_JOBGROKLIST_CONTROLLERS_POSTING_POSTING_SAVED_SUCCESS');
		}
		else
		{
			$msg = JTEXT::_('COM_JOBGROKLIST_CONTROLLERS_POSTING_POSTING_SAVED_ERROR');
		}

		$link = 'index.php?option=com_jobgroklist&controller=posting';
		$this->setRedirect($link, $msg);
	}

        function reset()
        {
            if( version_compare( JVERSION, '1.6.0', 'ge') ) {
                $user = JFactory::getUser();
                if (!$user->authorise('core.manage', 'com_jobgroklist')) {
                    return JError::raiseWarning(403, JTEXT::_('COM_JOBGROKLIST_CONTROLLERS_POSTING_JERROR_ALERTNOAUTHOR'));
                }
            }
            //JRequest::checkToken() or die('Invalid Token');
            $model = $this->getModel('Posting');

            if ($model->reset())
            {
                $msg = JTEXT::_('COM_JOBGROKLIST_CONTROLLERS_POSTING_POSTING_HITS_RESET');
            }
            else
            {
                $msg = JTEXT::_('COM_JOBGROKLIST_CONTROLLERS_POSTING_POSTING_HITS_RESET_ERROR');
            }
            $link = 'index.php?option=com_jobgroklist&controller=posting';
            $this->setRedirect($link, $msg);
        }

	/* 
	 * Display 
	 */
	function display($cachable = false, $urlparams = false)
	{
        if( version_compare( JVERSION, '1.6.0', 'ge') ) {
            $user = JFactory::getUser();
            if (!$user->authorise('core.manage', 'com_jobgroklist')) {
                return JError::raiseWarning(403, JTEXT::_('COM_JOBGROKLIST_CONTROLLERS_POSTING_JERROR_ALERTNOAUTHOR'));
            }
        }
		$document = JFactory :: getDocument();
		$viewName = JRequest :: getVar('view', 'postings');
		$viewType = $document->getType();
		$view = $this->getView($viewName, $viewType);
		$model = $this->getModel('posting', 'JobgroklistModel');
		if (!JError :: isError($model))
		{
			$view->setModel($model, true);
		}
		$view->setLayout('default');
		$view->display();
	}

}
?>
