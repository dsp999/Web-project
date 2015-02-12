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

class MinitekWallController extends JControllerLegacy
{
	protected $default_view = 'dashboard';

	public function display($cachable = false, $urlparams = false)
	{
		
		$view   = $this->input->get('view', 'instances');
		$layout = $this->input->get('layout', 'instances');
		$id     = $this->input->getInt('id');

		// Check for edit form.
		if ($view == 'instance' && $layout == 'edit' && !$this->checkEditId('com_minitekwall.edit.instance', $id))
		{
			// Somehow the person just went to the form - we don't allow that.
			$this->setError(JText::sprintf('JLIB_APPLICATION_ERROR_UNHELD_ID', $id));
			$this->setMessage($this->getError(), 'error');
			$this->setRedirect(JRoute::_('index.php?option=com_minitekwall&view=instances', false));

			return false;
		}

		parent::display();

		return $this;
	}
	
	public function purgeImages()
	{
		jimport('joomla.filesystem.folder');
		JSession::checkToken('request') or jexit('Invalid token');		
		$app =& JFactory::getApplication();
		
		$tmppath =  JPATH_SITE.DS.'images'.DS.'mnwallimages'.DS;
		if(file_exists($tmppath)) {
			JFolder::delete($tmppath);
			$message = JText::_('COM_MINITEKWALL_IMAGES_PURGED');
			$link = JRoute::_('index.php?option=com_minitekwall');
			$app->redirect(str_replace('&amp;', '&', $link), $message, 'message');	
		} else {
			$message = JText::_('COM_MINITEKWALL_IMAGES_PURGED_ALREADY');
			$link = JRoute::_('index.php?option=com_minitekwall');
			$app->redirect(str_replace('&amp;', '&', $link), $message, 'notice');	
		}
			
		
	}
			
}
