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

if( !defined('PhpThumbFactoryLoaded') ) {
  require_once( JPATH_SITE.''.DS.'components'.DS.'com_minitekwall'.DS.'helpers'.DS.'phpthumb/ThumbLib.inc.php' );
	define('PhpThumbFactoryLoaded',1);
}

jimport('joomla.filesystem.folder');

class MinitekWallHelperUtilities
{
	
	public static function getParams($option)
	{
	  
		$application = JFactory::getApplication();
		if ($application->isSite())
		{
		  $params = $application->getParams($option);
		}
		else
		{
		  $params = JComponentHelper::getParams($option);
		}
		
		return $params;

	}
	
	// Get instance
  	public static function getInstance($moduleID) 
	{
		$db = JFactory::getDBO();
		$query = ' SELECT * '
			. ' FROM '. $db->quoteName('#__minitek_wall_instances') . ' AS i '
			. ' LEFT JOIN ' . $db->quoteName('#__minitek_wall_modules') . ' AS m '
			. ' ON i.'.$db->quoteName('id').' = m.'.$db->quoteName('instance_id')
			. ' WHERE m.'.$db->quoteName('id').' = ' . $db->Quote($moduleID)
			. ' AND i.'.$db->quoteName('state').' = '. $db->Quote('1');						
		$db->setQuery($query);
		$result = $db->loadObject();
				
		return $result;
  	}
			
	// Decode instance type
  	public static function getInstanceType($instanceJSON) 
	{
		$this_intance_type = json_decode($instanceJSON, true);
				
		return $this_intance_type;
  	}
	
	// Get module_type
  	public static function getModuleType($moduleID) 
	{
		$db = JFactory::getDBO();
		$query = ' SELECT * '
			. ' FROM '. $db->quoteName('#__minitek_wall_modules')
			. ' WHERE '. $db->quoteName('published').' = '. $db->Quote('1')
			. ' AND '. $db->quoteName('id').' = '. $db->Quote($moduleID);
						
		$db->setQuery($query);
		$result = $db->loadObject();
		$module_type = $result->module_type;
			
		return $module_type;
  	}
	
	// Decode module_type
  	public static function getModuleTypeJSON($moduleType) 
	{
		$this_module_type = json_decode($moduleType, true);
				
		return $this_module_type;
  	}
			
	public static function getFilters($wall, $module_type, $loader)
	{
		$params = self::getParams('com_minitekwall');
		$moduleID = $params->get('module_id');
				
		// Start output
		$output = '';
		
		// Category Filters
		if ($module_type['category_filters'])
		{
			// Create cat filters 
			$cat_array = array();		
			foreach($wall as $key=>$wall_item) 
			{	  
				if (isset($wall_item->itemCategoryName)) 
				{					
					array_push($cat_array, $wall_item->itemCategoryName);	
				}
			}
			$cat_array = array_unique($cat_array);
			asort($cat_array);
			$cat_array = array_values($cat_array);	
			
			if ($module_type['filter_type'] == '1') 
			{
				// Inline filters
				$output .= '<div class="button-group button-group-category mnwall_iso_buttons" data-filter-group="category">';
					$output .= '<div class="mnwall_filters_loader">';
						$output .= '<img alt="" src="'.$loader.'" />';
					$output .= '</div>';
					$output .= '<span>'.JText::_('COM_MINITEKWALL_CATEGORY').'</span>';
					$output .= '<a href="#" data-filter="" class="mnwall-filter mnw_filter_active">'.JText::_('COM_MINITEKWALL_SHOW_ALL').'</a>';
					foreach ($cat_array as $category) 
					{
						$cat_name_fixed = self::cleanName($category);
						$category = htmlspecialchars($category);
						$output .= '<a href="#" data-filter=".cat-'.$cat_name_fixed.'" class="mnwall-filter">'.$category.'</a>';
					}		
				$output .= '</div>';	
			}
			
			if ($module_type['filter_type'] == '2') 
			{
				// Dropdown filters
				$output .= '<div class="mnwall_iso_dropdown">';
					$output .= '<div class="mnwall_filters_loader">';
						$output .= '<img alt="" src="'.$loader.'" />';
					$output .= '</div>';
					$output .= '<div class="dropdown-label cat-label">';
						$output .= '<span data-label="'.JText::_('COM_MINITEKWALL_FILTER_BY_CATEGORY').'">';
						$output .= '<i class="fa fa-angle-down"></i>'.JText::_('COM_MINITEKWALL_FILTER_BY_CATEGORY');
						$output .= '</span>';
					$output .= '</div>';
					$output .= '<ul class="button-group button-group-category" data-filter-group="category">';
						$output .= '<li><a href="#" data-filter="" class="mnwall-filter mnw_filter_active">'.JText::_('COM_MINITEKWALL_SHOW_ALL').'</a></li>';
						foreach ($cat_array as $category) 
						{
							$cat_name_fixed = self::cleanName($category);
							$category = htmlspecialchars($category);
							$output .= '<li><a href="#" data-filter=".cat-'.$cat_name_fixed.'" class="mnwall-filter">'.$category.'</a></li>';
						}	
					$output .= '</ul>';
				$output .= '</div>';
			}
			
		}
		
		// Tag Filters
		if ($module_type['tag_filters'])
		{
			// Create tag filters 
			$tag_array = array();		
			foreach($wall as $key=>$wall_item) 
			{	
				if (isset($wall_item->itemTags)) 
				{		
					foreach($wall_item->itemTags as $key=>$itemTag) 
					{
						if (isset($wall_item->isJoomlaArticle)) 
						{
							array_push($tag_array, $itemTag->title);	
						} else {
							array_push($tag_array, $itemTag->name);	
						}
					}
				}
			}
			$tag_array = array_unique($tag_array);
			asort($tag_array);
			$tag_array = array_values($tag_array);	
			
			if ($module_type['filter_type'] == '1') 
			{
				// Inline filters
				$output .= '<div class="button-group button-group-tag mnwall_iso_buttons" data-filter-group="tag">';
					$output .= '<div class="mnwall_filters_loader">';
						$output .= '<img alt="" src="'.$loader.'" />';
					$output .= '</div>';
				$output .= '<span>'.JText::_('COM_MINITEKWALL_TAG').'</span>';
					$output .= '<a href="#" data-filter="" class="mnwall-filter mnw_filter_active">'.JText::_('COM_MINITEKWALL_SHOW_ALL').'</a>';
					foreach ($tag_array as $tagName) 
					{
						$tag_name_fixed = self::cleanName($tagName);
						$tag = htmlspecialchars($tagName);
						$output .= '<a href="#" data-filter=".tag-'.$tag_name_fixed.'" class="mnwall-filter">'.$tag.'</a>';
					}		
				$output .= '</div>';	
			}
			
			if ($module_type['filter_type'] == '2') 
			{
				// Dropdown filters
				$output .= '<div class="mnwall_iso_dropdown">';
					$output .= '<div class="mnwall_filters_loader">';
						$output .= '<img alt="" src="'.$loader.'" />';
					$output .= '</div>';
					$output .= '<div class="dropdown-label tag-label">';
						$output .= '<span data-label="'.JText::_('COM_MINITEKWALL_FILTER_BY_TAG').'">';
						$output .= '<i class="fa fa-angle-down"></i>'.JText::_('COM_MINITEKWALL_FILTER_BY_TAG'); 
						$output .= '</span>';
					$output .= '</div>';
					$output .= '<ul class="button-group button-group-tag" data-filter-group="tag">';
						$output .= '<li><a href="#" data-filter="" class="mnwall-filter mnw_filter_active">'.JText::_('COM_MINITEKWALL_SHOW_ALL').'</a></li>';
						foreach ($tag_array as $tagName) 
						{
							$tag_name_fixed = self::cleanName($tagName);
							$tag = htmlspecialchars($tagName);
							$output .= '<li><a href="#" data-filter=".tag-'.$tag_name_fixed.'" class="mnwall-filter">'.$tag.'</a></li>';
						}	
					$output .= '</ul>';
				$output .= '</div>';
			}
			
		}
								
		return $output;
                                                   
	}
	
	public static function cleanName($name)
	{
		$name_fixed = preg_replace('/(?=\P{Nd})\P{L}/u', '-', $name);
		$name_fixed = preg_replace('/[\s-]{2,}/u', '-', $name_fixed);
		$name_fixed = htmlspecialchars($name_fixed);
		$name_fixed = trim($name_fixed, "-");
		
		return $name_fixed;
	}
			
	public static function wordLimit($str, $limit = 100, $end_char = '&#8230;')
	{
		if (JString::trim($str) == '')
			return $str;

		// always strip tags for text
		$str = strip_tags($str);

		$find = array("/\r|\n/u", "/\t/u", "/\s\s+/u");
		$replace = array(" ", " ", " ");
		$str = preg_replace($find, $replace, $str);

		preg_match('/\s*(?:\S*\s*){'.(int)$limit.'}/u', $str, $matches);
		if (JString::strlen($matches[0]) == JString::strlen($str))
			$end_char = '';
		return JString::rtrim($matches[0]).$end_char;
	}
	
	public static function makeDir( $path )
	{
		$folders = explode ( '/',  ( $path ) );
		$tmppath =  JPATH_SITE.DS.'images'.DS.'mnwallimages'.DS;
		if( !file_exists($tmppath) ) {
			JFolder::create( $tmppath, 0755 );
		}; 
		for( $i = 0; $i < count ( $folders ) - 1; $i ++) {
			if (! file_exists ( $tmppath . $folders [$i] ) && ! JFolder::create( $tmppath . $folders [$i], 0755) ) {
				return false;
			}	
			$tmppath = $tmppath . $folders [$i] . DS;
		}		
		return true;
	}
	
	public static function renderImages( $path, $width, $height, $title='' ) 
	{
	  $path = str_replace( JURI::base(), '', $path );
		$imgSource = JPATH_SITE.DS. str_replace( '/', DS,  $path );
		if ( file_exists($imgSource)  ) 
		{
		  $path =  $width."x".$height.'/'.$path;
			$thumbPath = JPATH_SITE.DS.'images'.DS.'mnwallimages'.DS. str_replace( '/', DS,  $path );
			if ( !file_exists($thumbPath) ) 
			{
			  $thumb = PhpThumbFactory::create( $imgSource  );  
				if( !self::makeDir( $path ) ) 
				{
					return '';
				}		
				$thumb->adaptiveResize( $width, $height);
				$thumb->save( $thumbPath  ); 
			}
			$path = JURI::base().'images/mnwallimages/'.$path;
		} 
		
		return $path;
	}
	
	public static function sortID($a, $b)
	{
		return strcmp($a->id, $b->id);
	}

	public static function sortTitle($a, $b)
	{
		return strcmp($a->title, $b->title);
	}
	
	public static function sortDate($a, $b)
	{
		return strcmp($a->created_time, $b->created_time);
	}
	
	
}