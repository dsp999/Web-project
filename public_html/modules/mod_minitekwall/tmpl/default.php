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

$document = JFactory::getDocument();

// Layout class
if ($gridType == '99v') {
	$mnwall_class = 'mnwall-list';
	$mnwall_grid = '';
} else if ($gridType == '98o') {
	$mnwall_class = 'mnwall-grid';	
	$mnwall_grid = '';
} else {
	$mnwall_class = 'mnwall-masonry';	
	$mnwall_grid = 'mnwall-grid'.$gridType;
}

// Theme class
if ($themeType == '2') {
	$themeTypeClass = 'modern-theme';
}
// Detail box text color
if ($detailBoxTextColor == '1') {
	$detailBoxTextColor = 'dark-text';
} else {
	$detailBoxTextColor = 'light-text';
}

?>

<div id="mnwall_container_<?php echo $mwmod; ?>" class="mnwall_container <?php echo $mnwall_class; ?> <?php echo $mnwall_grid; ?> <?php echo $themeTypeClass; ?> <?php echo $detailBoxTextColor; ?>">

	<?php if (isset($filters)) { ?>
	<div id="mnwall_iso_filters_cont_<?php echo $mwmod; ?>" class="mnwall_iso_filters_cont">
    	<div id="mnwall_iso_filters_<?php echo $mwmod; ?>" class="mnwall_iso_filters">
			<?php echo $filters; ?>
		</div>
	</div>
	<?php } ?>		        
   
	<?php if (isset($sortings)) { ?>
	<div id="mnwall_iso_sortings_cont_<?php echo $mwmod; ?>" class="mnwall_iso_sortings_cont">
		<div id="mnwall_iso_sortings_<?php echo $mwmod; ?>" class="mnwall_iso_sortings">
		
			<?php if (isset($inline_sorting)) { 
				
				// Inline sortings ?>
				<div class="sorting-group sorting-group-filters mnwall_iso_buttons">
					<span><?php echo JText::_('MOD_MINITEKWALL_SORT_BY'); ?></span>
					<a href="#" data-sort-value="original-order" class="mnwall-filter mnw_filter_active"><?php echo JText::_('MOD_MINITEKWALL_DEFAULT_ORDER'); ?></a>
					<?php if (isset($title_sorting)) { ?>
						<a href="#" data-sort-value="title" class="mnwall-filter"><?php echo JText::_('MOD_MINITEKWALL_TITLE'); ?></a>
					<?php } ?>
					<?php if (isset($author_sorting)) { ?>
						<a href="#" data-sort-value="author" class="mnwall-filter"><?php echo JText::_('MOD_MINITEKWALL_AUTHOR'); ?></a>
					<?php } ?>
					<?php if (isset($date_sorting)) { ?>
						<a href="#" data-sort-value="date" class="mnwall-filter"><?php echo JText::_('MOD_MINITEKWALL_DATE'); ?></a>
					<?php } ?>
				</div>
			
				<?php if (isset($sorting_direction)) {
				// Inline Direction ?>
				<div class="sorting-group sorting-group-direction mnwall_iso_buttons">
					<span><?php echo JText::_('MOD_MINITEKWALL_SORT_DIRECTION'); ?></span>
					<a href="#" data-sort-value="asc" class="mnwall-filter mnw_filter_active"><?php echo JText::_('MOD_MINITEKWALL_ASC'); ?></a>
					<a href="#" data-sort-value="desc" class="mnwall-filter"><?php echo JText::_('MOD_MINITEKWALL_DESC'); ?></a>
				</div>
				<?php } ?>
				
			<?php } ?>
			
			<?php if (isset($dropdown_sorting)) { 
			
				// Dropdown sortings ?>
				<div class="mnwall_iso_dropdown">
					<div class="dropdown-label sorting-label">
						<span data-label="<?php echo JText::_('MOD_MINITEKWALL_SORT_BY'); ?>">
							<i class="fa fa-angle-down"></i><?php echo JText::_('MOD_MINITEKWALL_SORT_BY'); ?>
						</span>
					</div>
					<ul class="sorting-group sorting-group-filters">
						<li><a href="#" data-sort-value="original-order" class="mnwall-filter mnw_filter_active"><?php echo JText::_('MOD_MINITEKWALL_DEFAULT_ORDER'); ?></a></li>
						<?php if (isset($title_sorting)) { ?>
							<li><a href="#" data-sort-value="title" class="mnwall-filter"><?php echo JText::_('MOD_MINITEKWALL_TITLE'); ?></a></li>
						<?php } ?>
						<?php if (isset($author_sorting)) { ?>
							<li><a href="#" data-sort-value="author" class="mnwall-filter"><?php echo JText::_('MOD_MINITEKWALL_AUTHOR'); ?></a></li>
						<?php } ?>
						<?php if (isset($date_sorting)) { ?>
							<li><a href="#" data-sort-value="date" class="mnwall-filter"><?php echo JText::_('MOD_MINITEKWALL_DATE'); ?></a></li>
						<?php } ?>
					</ul>
				</div>
			
				<?php if (isset($sorting_direction)) {
				// Dropdown direction ?>
				<div class="mnwall_iso_dropdown">
					<div class="dropdown-label sorting-label">
						<span data-label="<?php echo JText::_('MOD_MINITEKWALL_SORT_DIRECTION'); ?>">
							<i class="fa fa-angle-down"></i><?php echo JText::_('MOD_MINITEKWALL_SORT_DIRECTION'); ?>
						</span>
					</div>
					<ul class="sorting-group sorting-group-direction">
						<li><a href="#" data-sort-value="asc" class="mnwall-filter mnw_filter_active"><?php echo JText::_('MOD_MINITEKWALL_ASC'); ?></a></li>
						<li><a href="#" data-sort-value="desc" class="mnwall-filter"><?php echo JText::_('MOD_MINITEKWALL_DESC'); ?></a></li>
					</ul>
				</div>
				<?php } ?>
				
			<?php } ?>
			
    	</div>
	</div>
    <?php } ?>		
	    	    
    <div id="mnwall_iso_container_<?php echo $mwmod; ?>" class="mnwall_iso_container" style="margin: -<?php echo (int)$gutter; ?>px;">
    	
		<?php if ($gridType != '99v') { ?>
			<div 
				class="masonry-width"
				<?php if (isset($cols)) { ?>
					style=" <?php echo $cols; ?>"
				<?php } ?>
			></div>
		<?php } ?>
		
		<?php // Themes
		if (isset($themeType) && $themeType == 2)
		{
			include JPATH_SITE.'/modules/mod_minitekwall/tmpl/modern.php'; 
		} ?>
        
    </div>
    
</div>