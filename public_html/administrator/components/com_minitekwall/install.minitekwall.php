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
 
class com_minitekwallInstallerScript
{
        function install($parent) 
        {
                // $parent is the class calling this method
                //$parent->getParent()->setRedirectURL('index.php?option=com_minitekwall');
        }
 
        function uninstall($parent) 
        {
                // $parent is the class calling this method
                //echo '<p>' . JText::_('COM_MINITEKWALL_UNINSTALL_TEXT') . '</p>';
        }
 
        function update($parent) 
        {
                // $parent is the class calling this method
                //echo '<p>' . JText::sprintf('COM_MINITEKWALL_UPDATE_TEXT', $parent->get('manifest')->version) . '</p>';
        }
 
        function preflight($type, $parent) 
        {
                // $parent is the class calling this method
                // $type is the type of change (install, update or discover_install)
                //echo '<p>' . JText::_('COM_MINITEKWALL_PREFLIGHT_' . $type . '_TEXT') . '</p>';
        }
 
        function postflight($type, $parent) 
        {
        	// Copy images to Joomla images/stories/mlsloaders folder
			$src_dir = JPATH_SITE.DIRECTORY_SEPARATOR.'components'.DIRECTORY_SEPARATOR.'com_minitekwall'.DIRECTORY_SEPARATOR.'assets'.DIRECTORY_SEPARATOR.'images'.DIRECTORY_SEPARATOR.'mwloaders';
			$dest_dir = JPATH_SITE.DIRECTORY_SEPARATOR.'images'.DIRECTORY_SEPARATOR.'mwloaders';
			$this->recurse_copy($src_dir, $dest_dir);
        }
				
		private function recurse_copy($src, $dest ) 
		{ 
			jimport('joomla.filesystem.folder');
			$dir = opendir($src); 
			@mkdir($dest); 
			while(false !== ( $file = readdir($dir)) ) { 
				if (( $file != '.' ) && ( $file != '..' )) { 
					if ( is_dir($src . '/' . $file) ) { 
						recurse_copy($src . '/' . $file,$dest . '/' . $file); 
					} 
					else { 
						copy($src . '/' . $file,$dest . '/' . $file); 
					} 
				} 
			} 
			closedir($dir); 
			if (is_dir($src)) 
			{
				JFolder::delete($src);
			}
		} 
}