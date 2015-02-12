<?php

/**
 *
 *
 * This is the panel.php controller for jobgroklist
 *
 * Created: June 13, 2014, 1:18 am
 *
 * Subversion Details
 * $Date: 2014-04-19 23:37:19 -0500 (Sat, 19 Apr 2014) $
 * $Revision: 5936 $
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

class JobgroklistControllerPanel extends JControllerLegacy

{
/**
 *
 * The constructor
 *
 */
    function __construct()
    {
        parent :: __construct();
    }

    function bugFixI()
    {
        $model = $this->getModel('panel');
        if ( !$model->bugFixI())
        {
            $msg = JTEXT::_('COM_JOBGROKLIST_CONTROLLERS_PANEL_BUG_FIX_I_FAILED');
        }
        else
        {
            $msg = JTEXT::_('COM_JOBGROKLIST_CONTROLLERS_PANEL_BUG_FIX_I_SUCCESS');
        }
        $this->setRedirect('index.php?option=com_jobgroklist&controller=panel',$msg);
    }
    function staticAttributes()
    {
        $this->setRedirect('index.php?option=com_jobgroklist&controller=staticjobtype');
    }

    function importApp()
    {
        $model = $this->getModel('panel');
        if ( !$model->importApp())
        {
            $msg = JTEXT::_('COM_JOBGROKLIST_CONTROLLERS_PANEL_ERROR_COULD_NOT_IMPORT_FROM_PRIOR_VERSION');
        }
        else
        {
            $msg = JTEXT::_('COM_JOBGROKLIST_CONTROLLERS_PANEL_IMPORTED_DATA_FROM_PRIOR_VERSION');
        }
        $this->setRedirect('index.php?option=com_jobgroklist&controller=panel', $msg);
    }

    function importList()
    {
        $model = $this->getModel('panel');
        if ( !$model->importList())
        {
            $msg = JTEXT::_('COM_JOBGROKLIST_CONTROLLERS_PANEL_ERROR_COULD_NOT_IMPORT_FROM_PRIOR_VERSION');
        }
        else
        {
            $msg = JTEXT::_('COM_JOBGROKLIST_CONTROLLERS_PANEL_IMPORTED_DATA_FROM_PRIOR_VERSION');
        }
        $this->setRedirect('index.php?option=com_jobgroklist&controller=panel', $msg);
    }

    function resetAllHits()
    {
        $model = $this->getModel('panel');
        if ($model->resetAllHits())
        {
            $msg = JTEXT::_('COM_JOBGROKLIST_CONTROLLERS_PANEL_ALL_POSTING_HITS_RESET');
        }
        else
        {
            $msg = JTEXT::_('COM_JOBGROKLIST_CONTROLLERS_PANEL_ALL_POSTING_HITS_RESET_ERROR');
        }
        $this->setRedirect('index.php?option=com_jobgroklist&controller=panel', $msg);
    }

    /**
     *
     * Display
     *
     */
    function display($cachable = false, $urlparams = false)
    {
        $document = JFactory :: getDocument();
        $viewName = JRequest :: getVar('view', 'panel');
        $viewType = $document->getType();
        $view = $this->getView($viewName, $viewType);
        $model = $this->getModel('panel', 'JobgroklistModel');
        if (!JError :: isError($model))
        {
            $view->setModel($model, true);
        }
        $view->setLayout('default');
        $view->display();
    }

}
?>
