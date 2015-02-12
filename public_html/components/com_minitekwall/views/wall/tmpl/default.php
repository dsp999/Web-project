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
if ($this->gridType == '99v') {
	$mnwall_class = 'mnwall-list';
	$mnwall_grid = '';
} else if ($this->gridType == '98o') {
	$mnwall_class = 'mnwall-grid';	
	$mnwall_grid = '';
} else {
	$mnwall_class = 'mnwall-masonry';	
	$mnwall_grid = 'mnwall-grid'.$this->gridType;
}

// Theme class
if ($this->themeType == '1') {
	$themeType = 'light-theme';
} if ($this->themeType == '2') {
	$themeType = 'modern-theme';
} if ($this->themeType == '3') {
	$themeType = 'elegant-theme';
}

// Detail box text color
if ($this->detailBoxTextColor == '1') {
	$detailBoxTextColor = 'dark-text';
} else {
	$detailBoxTextColor = 'light-text';
}

?>

<div id="mnwall_container" class="mnwall_container <?php echo $mnwall_class; ?> <?php echo $mnwall_grid; ?> <?php echo $themeType; ?> <?php echo $detailBoxTextColor; ?>">

	<?php if (isset($this->filters)) { ?>
	<div id="mnwall_iso_filters_cont" class="mnwall_iso_filters_cont">
    	<div id="mnwall_iso_filters" class="mnwall_iso_filters">
			<?php echo $this->filters; ?>
		</div>
	</div>
	<?php } ?>		        	
	    	    
    <div id="mnwall_iso_container" class="mnwall_iso_container" style="margin: -<?php echo (int)$this->gutter; ?>px;">
    	
		<?php if ($this->gridType != '99v') { ?>
			<div 
				class="masonry-width"
				<?php if (isset($cols)) { ?>
					style=" <?php echo $cols; ?>"
				<?php } ?>
			></div>
		<?php } ?>
		
		<?php // Themes
		if (isset($this->themeType) && $this->themeType == 2)
		{
			include JPATH_SITE.'/components/com_minitekwall/views/wall/tmpl/modern.php'; 
		} ?>
        
    </div>
    
</div>