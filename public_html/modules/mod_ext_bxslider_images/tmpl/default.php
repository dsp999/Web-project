<?php
/*
# ------------------------------------------------------------------------
# Extensions for Joomla 2.5.x - Joomla 3.x
# ------------------------------------------------------------------------
# Copyright (C) 2011-2014 Ext-Joom.com. All Rights Reserved.
# @license - PHP files are GNU/GPL V2.
# Author: Ext-Joom.com
# Websites:  http://www.ext-joom.com 
# Date modified: 08/04/2014 - 13:00
# ------------------------------------------------------------------------
*/

// no direct access
defined('_JEXEC') or die;

$document->addCustomTag('
<style type="text/css">
.mod_ext_bxslider_images_'.$ext_id.' {
	max-width: '.$ext_width.'px;	
}
</style>');
?>


<script type="text/javascript">
jQuery(document).ready(function(){
	jQuery('#bxslider_<?php echo $ext_id; ?>').bxSlider({
		mode: '<?php echo $ext_mode;?>',
		randomStart: <?php echo $ext_random_start;?>,
		minSlides: <?php echo $ext_min_slides;?>,
		maxSlides: <?php echo $ext_max_slides;?>,
		moveSlides: <?php echo $ext_move_slides;?>,
		slideWidth: <?php echo $ext_slide_width;?>,
		slideMargin: <?php echo $ext_slide_margin;?>,
		adaptiveHeight: <?php echo $ext_adaptive_height;?>,
		adaptiveHeightSpeed: <?php echo $ext_adaptive_height_speed;?>,
		easing:	'<?php echo $ext_easing;?>',		
		speed: <?php echo $ext_speed;?>,
		controls: <?php echo $ext_controls; ?>,
		auto: <?php echo $ext_auto;?>,
		autoControls: <?php echo $ext_auto_controls;?>,
		pause: <?php echo $ext_pause?>,
		autoDelay: <?php echo $ext_auto_delay; ?>,
		autoHover: <?php echo $ext_autohover; ?>,
		pager: <?php echo $ext_pager;?>,
		pagerType: '<?php echo $ext_pager_type;?>',
		pagerShortSeparator: '<?php echo $ext_pager_saparator;?>'
	});
});
</script>

<div class="mod_ext_bxslider_images mod_ext_bxslider_images_<?php echo $ext_id; ?> <?php echo $moduleclass_sfx ?>">	
	<ul id="bxslider_<?php echo $ext_id; ?>">		
		<?php	
		for($n=0;$n < count($img);$n++) {			
			if( $img[$n] != '') {		
				if ($url[$n] != '') {
					echo '<li>';
					echo '<a href="'.$url[$n].'" target="'.$target[$n].'"><img src="'.$img[$n].'" alt="'.$alt[$n].'" /></a>';
					if ($html[$n] != '') {
						echo '<div class="bxlider-custom-html">'.$html[$n].'</div>';
					}
					echo '</li>';
					
				
				} else {
						echo '<li>';
						echo '<img src="'.$img[$n].'" alt="'.$alt[$n].'" />';
						if ($html[$n] != '') {
							echo '<div class="bxlider-custom-html">'.$html[$n].'</div>';
						}
						echo '</li>';
					}

			}
		}	
		?>
	</ul>	
<div style="clear:both;"></div>
</div>

