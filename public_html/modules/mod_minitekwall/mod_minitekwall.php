<?php
/**
* @title			Minitek Wall
* @copyright   		Copyright (C) 2011-2014 Minitek, All rights reserved.
* @license   		GNU General Public License version 3 or later.
* @author url   	http://www.minitek.gr/
* @developers   	Minitek.gr
*/

// No direct access
defined('_JEXEC') or die('Restricted access');

if(!defined('DS')){
	define('DS',DIRECTORY_SEPARATOR);
}

// Get global variables
$document = JFactory::getDocument();

// Define module id & sfx
$module_id = $module->id;
if ($params->get('auto_module_id')) {
  $mwmod = 'mwm'.$module_id;
} else {
  $mwmod = ''.$params->get('custom_module_id'); 
}
$moduleclass_sfx = $params->get('moduleclass_sfx'); 

// Add css
$document->addStyleSheet(JURI::base().'components/com_minitekwall/assets/css/style.css');

// Font Awesome
if ($params->get('load_fontawesome')) {
	$document->addStyleSheet('http://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css');
}

// Load jQuery
if ($params->get('load_jquery')) {
	JHtml::_('jquery.framework');
}

// Load Fancybox
if ($params->get('load_fancybox')) {
	$document->addStyleSheet(JURI::base().'components/com_minitekwall/assets/fancybox/jquery.fancybox-1.3.4.css');
	$document->addScript(JURI::base().'components/com_minitekwall/assets/fancybox/jquery.fancybox-1.3.4.pack.js');
}
$fancybox = $params->get('load_fancybox'); 

// Add js
$document->addScript(JURI::base().'components/com_minitekwall/assets/js/mnwall-isotope.js');
$document->addScript(JURI::base().'components/com_minitekwall/assets/js/mnwall-isotope-packery.js');
$document->addScript(JURI::base().'components/com_minitekwall/assets/js/imagesloaded.pkgd.min.js');
$document->addScript(JURI::base().'modules/mod_minitekwall/assets/js/mnwall.js');

// Get wall model
jimport('joomla.application.component.model');
JModelLegacy::addIncludePath(JPATH_SITE.'/components/com_minitekwall/models');
$wallModel = JModelLegacy::getInstance( 'Wall', 'MinitekWallModel' );

// Import wall helpers
JLoader::register('MinitekWallHelperUtilities', JPATH_SITE.''.DS.'components'.DS.'com_minitekwall'.DS.'helpers'.DS.'utilities.php');
JLoader::register('MinitekWallHelperContentUtilities', JPATH_SITE.''.DS.'components'.DS.'com_minitekwall'.DS.'helpers'.DS.'contentutilities.php');

// Get wall module_id
$moduleID = $params->get('module_id'); 

// Get module_type parameters
$module_type_raw = MinitekWallHelperUtilities::getModuleType($moduleID);
$module_type = MinitekWallHelperUtilities::getModuleTypeJSON($module_type_raw);
			
// Get module_type
$loader = $module_type['loader'];

// Get Total count - Arrows pagination
$startLimit = $module_type['starting_limit'];

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
$token = JSession::getFormToken();
$site_path = JURI::root();
$itemid = JRequest::getVar('Itemid');

// Add Script
$document->addScriptDeclaration(
'
jQuery.noConflict();																	

jQuery(document).ready(function(){
	
	// Global variables
	var token = "'.$token.'";
	var site_path = "'.$site_path.'";
	var moduleID = "'.$moduleID.'";
	var mwmod = "'.$mwmod.'";
	var itemid = "'.$itemid.'";
	var $container = jQuery("#mnwall_container_"+mwmod);
	var gridType = "'.$gridType.'";
	gridType = parseInt(gridType);
	if (gridType == 99) {
		gridLayout = "vertical";
	} else {
		gridLayout = "packery";
	}                                
	var themeType = "'.$themeType.'";
	var hoverBox = "'.$hoverBox.'";
	var loader = "'.$loader.'";
	var fancybox = "'.$fancybox.'";
	// Fancybox
	if (fancybox == 1) {
		$container.find(".mnwall-item-fancy-icon").fancybox();
	}
		
	// Colors
	var detailBoxBackground = "'.$detailBoxBackground.'";
	var detailBoxBackgroundOpacity = "'.$detailBoxBackgroundOpacity.'";
	
	// Hover effects
	var hoverBoxEffect = "'.$hoverBoxEffect.'";
	var hoverBoxContentEffect = "'.$hoverBoxContentEffect.'";
	if (hoverBoxContentEffect == 1) {
		var hoverContentEffectClass = \'hoverFadeIn\';
	} else {
		var hoverContentEffectClass = \'no-effect\';
	}
					
	// Initialize isotope	
	var $wall = jQuery("#mnwall_iso_container_"+mwmod).imagesLoaded( function() 
	{
		// Isotope
		$wall.isotope({
			// General
			itemSelector: ".mnwall-item",
			layoutMode: gridLayout,
			// Vertical list
			vertical: {
				horizontalAlignment: 0
			},
			getSortData: {
			  	title: "[data-title]",
				category: "[data-category]",
				author: "[data-author]",
				date: "[data-date]"
			},
			sortBy: "original-order"
		});
	});
	
	// Fix classes
	if (gridType != 99 && gridType != 98) 
	{
		// Add classes to items
		$container.find(".mnwall-item").each(function(index){
			mnw_mas_index = index + 1;
			if (mnw_mas_index > gridType) {
				mnw_mas_index = recurseMasItemIndex(mnw_mas_index, gridType);
			}
			jQuery(this).removeClass (function (class_index, css) {
				return (css.match (/(^|\s)mnwitem\S+/g) || []).join(" ");
			}).addClass("mnwitem"+mnw_mas_index);
		});
		// Re-initialize isotope layout
		//$wall.isotope();
	}
	
	// Hover box trigger
	if (hoverBox == "1") {
		triggerHoverBox(gridType, mwmod, hoverBoxEffect, hoverContentEffectClass);
		centerHoverContent($container, gridType);
	}
		
	// Add detail-box background-color
	backgroundColor($container, gridType, themeType, detailBoxBackground, detailBoxBackgroundOpacity);
					
	// Filters
	var filters = {};
	jQuery("#mnwall_iso_filters_"+mwmod).on( "click", ".mnwall-filter", function(event) 
	{
		event.preventDefault();
		var $this = jQuery(this);
		// get group key
		var $buttonGroup = $this.parents(".button-group");
		var filterGroup = $buttonGroup.attr("data-filter-group");
		// set filter for group
		filters[ filterGroup ] = $this.attr("data-filter");
		// combine filters
		var filterValue = "";
		for ( var prop in filters ) {
			filterValue += filters[ prop ];
		}
		// set filter for Isotope
		$wall.isotope({ filter: filterValue });
		// Fix background image size
		if (gridType != 99 && gridType != 98) 
		{
			backgroundSize($container);
		}
		// Center hover content
		if (hoverBox == "1") {
			centerHoverContentDynamic($container, gridType);
		}
	});
	
	// Change active class on filter buttons
	active_Filters(mwmod);
	
	// Dropdown filter list
	dropdown_Filters(mwmod);
		
	// Bind sort button click
  	jQuery("#mnwall_container_"+mwmod+" .sorting-group-filters").on( "click", ".mnwall-filter", function(event) {
		event.preventDefault();
    	var sortValue = jQuery(this).attr("data-sort-value");
    	// set filter for Isotope
		$wall.isotope({ 
			sortBy: sortValue
		});
  	});
	
	// Change active class on sorting filters
	jQuery("#mnwall_container_"+mwmod+" .sorting-group-filters").each( function( i, sortingGroup ) {
		var $sortingGroup = jQuery( sortingGroup );
		$sortingGroup.on( "click", ".mnwall-filter", function() {
	  		$sortingGroup.find(".mnw_filter_active").removeClass("mnw_filter_active");
	  		jQuery( this ).addClass("mnw_filter_active");
		});
	});
	
	// Bind sorting direction button click
  	jQuery("#mnwall_container_"+mwmod+" .sorting-group-direction").on( "click", ".mnwall-filter", function(event) {
		event.preventDefault();
    	var sortDirection = jQuery(this).attr("data-sort-value");
		if (sortDirection == "asc") {
			sort_Direction = true;
		} else {
			sort_Direction = false;
		}
    	// set direction
		$wall.isotope({ 
			sortAscending: sort_Direction
		});
  	});
	
	// Change active class on sorting direction
	jQuery("#mnwall_container_"+mwmod+" .sorting-group-direction").each( function( i, sortingDirection ) {
		var $sortingDirection = jQuery( sortingDirection );
		$sortingDirection.on( "click", ".mnwall-filter", function() {
	  		$sortingDirection.find(".mnw_filter_active").removeClass("mnw_filter_active");
	  		jQuery( this ).addClass("mnw_filter_active");
		});
	});
	
	// Dropdown sorting list
	dropdown_Sortings(mwmod);
	
	// Fix background image size
	if (gridType != 99 && gridType != 98) 
	{
		backgroundSize($container);
	}
					  
	jQuery(window).resize(function() {
		
		// Center hover content
		if (hoverBox == "1") {
			centerHoverContentDynamic($container, gridType);
		}
				
		// Fix background image size
		if (gridType != 99 && gridType != 98) 
		{
			backgroundSize($container);
		}
		
	});
			
});		
'
);
		
// Get wall
$wall = $wallModel->getAllResults($moduleID);

if (!$wall || $wall == '' || $wall == 0)
{
	$output = '<div class="mnw-results-empty-results">';
	$output .= '<span><i class="fa fa-times-circle"></i>'.JText::_("COM_MINITEKWALL_NO_ITEMS").'</span>';
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
	}
	// Get Sortings
	if ($module_type['title_sorting'] || 
		$module_type['author_sorting'] ||
		$module_type['date_sorting'])
	{
		$sortings = true;
		if ($module_type['title_sorting']) {
			$title_sorting = true;
		}
		if ($module_type['author_sorting']) {
			$author_sorting = true;
		}
		if ($module_type['date_sorting']) {
			$date_sorting = true;
		}
		
		if ($module_type['sorting_type'] == 1) {
			$inline_sorting = true;
		} else if ($module_type['sorting_type'] == 2) {
			$dropdown_sorting = true;
		}
		
		if ($module_type['sorting_direction'] == 1) {
			$sorting_direction = 1;
		}
		
	}
	
}

// Display the view
require(JModuleHelper::getLayoutPath("mod_minitekwall"));