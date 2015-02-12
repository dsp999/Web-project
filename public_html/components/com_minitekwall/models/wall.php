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

jimport('joomla.application.component.modelitem');

// Add helpers
JLoader::register('MinitekWallHelperUtilities', JPATH_BASE.DS.'components'.DS.'com_minitekwall'.DS.'helpers'.DS.'utilities.php');
JLoader::register('MinitekWallHelperContentUtilities', JPATH_BASE.DS.'components'.DS.'com_minitekwall'.DS.'helpers'.DS.'contentutilities.php');

class MinitekWallModelWall extends JModelItem
{
		
	public static function getAllResults($moduleID)
	{
		// Get instance
		$instance = MinitekWallHelperUtilities::getInstance($moduleID); 
		$instance_id = $instance->id;
		
		// Limits
		$moduleType = MinitekWallHelperUtilities::getModuleType($moduleID);
		$moduleTypeJSON = MinitekWallHelperUtilities::getModuleTypeJSON($moduleType);	
		$startLimit = (int)$moduleTypeJSON['starting_limit'];
	
		// Joomla
		if ($instance->type_id == '1') 
		{
			$this_instance_type = MinitekWallHelperUtilities::getInstanceType($instance->joomla_type);
			$joomla_output = self::getJoomlaResults($this_instance_type, $instance_id, $startLimit, $pageLimit = 0, $globalLimit = 0);
			$output = $joomla_output;	
		} 			
			
		return $output;
	}
		
	// Get Joomla results
	public static function getJoomlaResults($joomla_type, $instance_id, $startLimit, $pageLimit, $globalLimit)
	{		
		$joomla_mode = $joomla_type['joomla_mode'];
		
		$output = array();
		
		// Joomla Articles
		if ($joomla_mode == 'ja') {
			$joomla_articles = MinitekWallHelperContentUtilities::getJoomlaArticles($joomla_type, $startLimit, $pageLimit, $globalLimit);
			
			if ($joomla_articles) {
				$output = array_merge($output, $joomla_articles);
			}
			
		} 
		
		// Joomla Categories
		if ($joomla_mode == 'jc') {
			$joomla_categories = MinitekWallHelperContentUtilities::getJoomlaCategories($joomla_type, $startLimit, $pageLimit, $globalLimit);

			if ($joomla_categories) {
				$output = array_merge($output, $joomla_categories);
			}
						
		}
		
		return $output;
	}
		
}