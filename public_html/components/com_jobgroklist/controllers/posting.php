<?php

/**
 *
 *
 * This is the posting.php controller for jobgroklist
 *
 * Created: June 13, 2014, 1:18 am
 *
 * Subversion Details
 * $Date: 2012-11-04 21:47:36 -0600 (Sun, 04 Nov 2012) $
 * $Revision: 4532 $
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

/**
 * Make sure entry is initiated by Joomla!
 */
defined('_JEXEC') or die('Restricted access');

/**
 * Import the controller base class
 */
jimport('joomla.application.component.controller');

/**
 * Employment Listing Posting Controller
 */
class JobgroklistControllerPosting extends JControllerLegacy
{
	/*
	 * constructor (registers additional tasks to methods)
	 */
	function __construct()
	{
		parent :: __construct();

		// Register Extra tasks
	}

	/* 
	 * Display 
	 */
	function display($cachable = false, $urlparams = false)
	{
		$document = JFactory :: getDocument();
		$layoutName = JRequest :: getVar('layout', 'default');
		$viewName = JRequest :: getVar('view', 'postings');
		$viewType = $document->getType();
		$view = $this->getView($viewName, $viewType);
		$model = $this->getModel('posting', 'JobgroklistModel');
		if (!JError :: isError($model))
		{
			$view->setModel($model, true);
		}
		$view->setLayout($layoutName);
		$view->display();
	}

}
?>
