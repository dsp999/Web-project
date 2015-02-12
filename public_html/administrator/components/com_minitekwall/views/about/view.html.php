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

class MinitekWallViewAbout extends JViewLegacy
{
	public function display($tpl = null)
	{
		MinitekWallHelper::addSubmenu('about');
		
		$this->addToolbar();
		$this->sidebar = JHtmlSidebar::render();
		
		parent::display($tpl);
	}

	protected function addToolbar()
	{
		$user  = JFactory::getUser();

		JToolbarHelper::title(JText::_('COM_MINITEKWALL_ABOUT_TITLE'), 'about.png');
		
		if ($user->authorise('core.admin', 'com_minitekwall')) {  
			JToolbarHelper::preferences('com_minitekwall');
		}
		
	}

}
