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

// import Joomla controller library
jimport('joomla.application.component.controller');

require_once( JPATH_COMPONENT.DS.'helpers'.DS.'utilities.php' );

class MinitekWallController extends JControllerLegacy
{

  	function display($cachable = false, $urlparams = false) 
	{
        // Make sure we have a default view
        if( !JRequest::getVar( 'view' )) {
            JRequest::setVar('view', 'search' );
        }
        parent::display();
    }
	
	public function modSearch()
	{
		// slashes cause errors, <> get stripped anyway later on. # causes problems.
		$badchars = array('#', '>', '<', '\\');
		$searchword = trim(str_replace($badchars, '', $this->input->getString('searchword', null, 'post')));
		
		// if searchword enclosed in double quotes, strip quotes and do exact match
		if (substr($searchword, 0, 1) == '"' && substr($searchword, -1) == '"')
		{
			$searchword = substr($searchword, 1, -1);
		}
		
		// Sanitize searchword
		$searchword = MinitekWallHelperUtilities::sanityCheck($searchword);

		unset($post['task']);
		unset($post['submit']);

		$uri = JUri::getInstance();
		$uri->setQuery($post);
		$uri->setVar('option', 'com_minitekwall');
		$uri->setVar('view', 'results');
		$uri->setVar('word', $searchword);
		$uri->setVar('Itemid', $this->input->getInt('Itemid'));

		$this->setRedirect(JRoute::_('index.php'.$uri->toString(array('query', 'fragment')), false));
	}	

}