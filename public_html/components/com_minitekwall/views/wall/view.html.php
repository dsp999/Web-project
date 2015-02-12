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

// import Joomla view library
jimport('joomla.application.component.view');

// Add utilities helper
JLoader::register('MinitekWallHelperUtilities', JPATH_COMPONENT.DS.'helpers'.DS.'utilities.php');

class MinitekWallViewWall extends JViewLegacy
{

	// Overwriting JView display method
	function display($tpl = null) 
	{		
 		$document = JFactory::getDocument();
		$model = $this->getModel('Wall');
		$params = MinitekWallHelperUtilities::getParams('com_minitekwall');
		$moduleID = $params->get('module_id');
		
		// Fancybox
		$fancybox = $params->get('load_fancybox', '1');
		
		// Get module_type parameters
		$module_type_raw = MinitekWallHelperUtilities::getModuleType($params->get('module_id'));
		$module_type = MinitekWallHelperUtilities::getModuleTypeJSON($module_type_raw);
			
		// Get loader
		$loader = $module_type['loader'];
										
		// Get Grid
		$gridType = $module_type['grid'];
		$masCols = $module_type['mas_cols'];
		$masColsper = 100 / $masCols;
		
		// Get Theme
		$themeType = $module_type['themeType'];
				
		// Detail box
		$detailBox = $module_type['detailBox'];
		$detailBoxBackground = $module_type['detailBoxBackground'];
		$detailBoxBackgroundOpacity = $module_type['detailBoxBackgroundOpacity'];
		$detailBoxTextColor = $module_type['detailBoxTextColor'];
		$detailBoxTitle = $module_type['detailBoxTitle'];
		$detailBoxCategory = $module_type['detailBoxCategory'];
		$detailBoxType = $module_type['detailBoxType'];
		$detailBoxAuthor = $module_type['detailBoxAuthor'];
		$detailBoxDate = $module_type['detailBoxDate'];
		$detailBoxIntrotext = $module_type['detailBoxIntrotext'];
		$detailBoxCount = $module_type['detailBoxCount'];
		
		// Hover box
		$hoverBox = $module_type['hoverBox'];
		$hoverBoxTitle = $module_type['hoverBoxTitle'];
		$hoverBoxCategory = $module_type['hoverBoxCategory'];
		$hoverBoxType = $module_type['hoverBoxType'];
		$hoverBoxAuthor = $module_type['hoverBoxAuthor'];
		$hoverBoxDate = $module_type['hoverBoxDate'];
		$hoverBoxIntrotext = $module_type['hoverBoxIntrotext'];
		$hoverBoxLinkButton = $module_type['hoverBoxLinkButton'];
		$hoverBoxFancyButton = $module_type['hoverBoxFancyButton'];
		$hoverBoxEffect = $module_type['hoverBoxEffect'];
		$hoverBoxEffectSpeed = $module_type['hoverBoxEffectSpeed'];
		$hoverBoxContentEffect = $module_type['hoverBoxContentEffect'];
		$hoverBoxContentEffectSpeed = $module_type['hoverBoxContentEffectSpeed'];
		$hoverBoxTheme = $module_type['hoverBoxTheme'];
		$hoverBoxTextColor = $module_type['hoverBoxTextColor'];
		
		// Get Gutter
		$gutter = $module_type['gutter'];
		
		// Get javascript variables
		$document->addScriptDeclaration('window.mnwvars2 = {
			gridType: "'.$gridType.'",
			themeType: "'.$themeType.'",
			detailBoxBackground: "'.$detailBoxBackground.'",
			detailBoxBackgroundOpacity: "'.$detailBoxBackgroundOpacity.'",
			hoverBox: "'.$hoverBox.'",
			hoverBoxEffect: "'.$hoverBoxEffect.'",
			hoverBoxContentEffect: "'.$hoverBoxContentEffect.'",
			loader: "'.$loader.'",
			fancybox: "'.$fancybox.'"
    	};');
				
		// Get wall
		$wall = $model->getAllResults($moduleID);
		
		if (!$wall || $wall == '' || $wall == 0)
		{
			$output = '<div class="mnw-results-empty-results">';
			$output .= '<span><i class="fa fa-times-circle"></i>'.JText::_('COM_MINITEKWALL_NO_ITEMS').'</span>';
			$output .= '</div>';
			echo $output;
		} 
		else 
		{
			// Get Filters
			if ($module_type['category_filters'] || 
				$module_type['tag_filters'])
			{
				$filters = MinitekWallHelperUtilities::getFilters($wall, $module_type, $loader);
				$this->assignRef('filters', $filters);
			}
			
			$this->assignRef('wall', $wall);
			$this->assignRef('loader', $loader);
			$this->assignRef('gutter', $gutter);
			$this->assignRef('gridType', $gridType);
			$this->assignRef('themeType', $themeType);
			$this->assignRef('masColsper', $masColsper);
			$this->assignRef('detailBox', $detailBox);
			$this->assignRef('detailBoxTextColor', $detailBoxTextColor);
			$this->assignRef('detailBoxTitle', $detailBoxTitle);
			$this->assignRef('detailBoxCategory', $detailBoxCategory);
			$this->assignRef('detailBoxType', $detailBoxType);
			$this->assignRef('detailBoxAuthor', $detailBoxAuthor);
			$this->assignRef('detailBoxDate', $detailBoxDate);
			$this->assignRef('detailBoxIntrotext', $detailBoxIntrotext);
			$this->assignRef('detailBoxCount', $detailBoxCount);
			$this->assignRef('hoverBox', $hoverBox);
			$this->assignRef('hoverBoxTitle', $hoverBoxTitle);
			$this->assignRef('hoverBoxCategory', $hoverBoxCategory);
			$this->assignRef('hoverBoxType', $hoverBoxType);
			$this->assignRef('hoverBoxAuthor', $hoverBoxAuthor);
			$this->assignRef('hoverBoxDate', $hoverBoxDate);
			$this->assignRef('hoverBoxIntrotext', $hoverBoxIntrotext);
			$this->assignRef('hoverBoxLinkButton', $hoverBoxLinkButton);
			$this->assignRef('hoverBoxFancyButton', $hoverBoxFancyButton);
			$this->assignRef('hoverBoxEffect', $hoverBoxEffect);
			$this->assignRef('hoverBoxEffectSpeed', $hoverBoxEffectSpeed);
			$this->assignRef('hoverBoxContentEffect', $hoverBoxContentEffect);
			$this->assignRef('hoverBoxContentEffectSpeed', $hoverBoxContentEffectSpeed);
			$this->assignRef('hoverBoxTheme', $hoverBoxTheme);
			$this->assignRef('hoverBoxTextColor', $hoverBoxTextColor);
			
			// Check for errors.
			if (count($errors = $this->get('Errors'))) {
				JError::raiseError(500, implode('<br />', $errors));
				return false;
			}
	
			// Display the view
			parent::display($tpl);
			
		}
		
	}
	
}