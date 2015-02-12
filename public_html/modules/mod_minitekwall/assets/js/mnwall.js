jQuery.noConflict();																	

jQuery(document).ready(function(){
	
	// Hex to RGB
	function hexToRgb(hex) {
		var shorthandRegex = /^#?([a-f\d])([a-f\d])([a-f\d])$/i;
		hex = hex.replace(shorthandRegex, function(m, r, g, b) {
			return r + r + g + g + b + b;
		});
	
		var result = /^#?([a-f\d]{2})([a-f\d]{2})([a-f\d]{2})$/i.exec(hex);
		return result ? {
			r: parseInt(result[1], 16),
			g: parseInt(result[2], 16),
			b: parseInt(result[3], 16)
		} : null;
	}
	
	// RGB Color
	var ColorR = function ColorR(color) {
		var color_r = hexToRgb(color).r;
		return color_r;
	}
	window.ColorR = ColorR;
	
	var ColorG = function ColorG(color) {
		var color_g = hexToRgb(color).g;
		return color_g;
	}
	window.ColorG = ColorG;
	
	var ColorB = function ColorB(color) {
		var color_b = hexToRgb(color).b;
		return color_b;
	}
	window.ColorB = ColorB;
	
	// Recursive function for masonry items classes
	var recurseMasItemIndex = function recurseMasItemIndex(mnw_mas_index, gridType) 
	{
		mnw_mas_index = mnw_mas_index - gridType;
		if (mnw_mas_index > gridType) {
			mnw_mas_index = recurseMasItemIndex(mnw_mas_index, gridType);
		}
		
		return mnw_mas_index;
	}
	window.recurseMasItemIndex = recurseMasItemIndex;
	
	// Center Hover content
	var centerHoverContent = function centerHoverContent($container, gridType) {
		jQuery(window).load(function(){
			$container.find(".mnwall-hover-box-content").each(function(index){
				if (gridType == 99 || gridType == 98) {
					jQuery(this).css( "top", ((jQuery(this).parents(".mnwall-img-div").height() - jQuery(this).outerHeight() ) / 2) + "px" );
				}
				if (gridType != 99 && gridType != 98) {
					jQuery(this).css( "top", ((jQuery(this).parents(".mnwall-item").height() - jQuery(this).outerHeight() ) / 2) + "px" );
				}
			});
		});
	}
	window.centerHoverContent = centerHoverContent;
	
	// Center Hover content Dynamic
	var centerHoverContentDynamic = function centerHoverContentDynamic($container, gridType) {
		$container.find(".mnwall-hover-box-content").each(function(index){
			if (gridType == 99 || gridType == 98) {
				jQuery(this).css( "top", ((jQuery(this).parents(".mnwall-img-div").height() - jQuery(this).outerHeight() ) / 2) + "px" );
			}
			if (gridType != 99 && gridType != 98) {
				jQuery(this).css( "top", ((jQuery(this).parents(".mnwall-item").height() - jQuery(this).outerHeight() ) / 2) + "px" );
			}
		});
	}
	window.centerHoverContentDynamic = centerHoverContentDynamic;
	
	// Trigger Hover-box
	var triggerHoverBox = function triggerHoverBox(gridType, mwmod, hoverBoxEffect, hoverContentEffectClass) {
					
		if (gridType == 99 || gridType == 98) {
			// Hover effects
			jQuery("#mnwall_container_"+mwmod+" .mnwall-item").find(".mnwall-item-inner-cont")
			.mouseenter(function(e) {        
				
				if (hoverBoxEffect == "no") {
					jQuery(this).find(".mnwall-hover-box").stop().addClass("hoverShow");
					jQuery(this).find(".mnwall-hover-box-content").addClass(hoverContentEffectClass);
				}
				if (hoverBoxEffect == "1") {
					jQuery(this).find(".mnwall-hover-box").stop().addClass("hoverFadeIn")
					.bind("transitionend webkitTransitionEnd oTransitionEnd MSTransitionEnd", function(){  
						jQuery(this).find(".mnwall-hover-box-content").addClass(hoverContentEffectClass);
					});
				}
								
			}).mouseleave(function (e) {   
				
				if (hoverBoxEffect == "no") {
					jQuery(this).find(".mnwall-hover-box").stop().removeClass("hoverShow");
					jQuery(this).find(".mnwall-hover-box-content").removeClass(hoverContentEffectClass);
				}
				if (hoverBoxEffect == "1") {
					jQuery(this).find(".mnwall-hover-box").stop().removeClass("hoverFadeIn")
					.bind("transitionend webkitTransitionEnd oTransitionEnd MSTransitionEnd", function(){  
						jQuery(this).find(".mnwall-hover-box-content").removeClass(hoverContentEffectClass);
					});
				}
				
			});
		}
		
		if (gridType != 98 && gridType != 99) {
			// Hover effects
			jQuery("#mnwall_container_"+mwmod+" .mnwall-item")
			.mouseenter(function(e) {        
				
				if (hoverBoxEffect == "no") {
					jQuery(this).find(".mnwall-hover-box").stop().addClass("hoverShow");
					jQuery(this).find(".mnwall-hover-box-content").addClass(hoverContentEffectClass);
				}
				if (hoverBoxEffect == "1") {
					jQuery(this).find(".mnwall-hover-box").stop().addClass("hoverFadeIn")
					.bind("transitionend webkitTransitionEnd oTransitionEnd MSTransitionEnd", function(){  
						jQuery(this).find(".mnwall-hover-box-content").addClass(hoverContentEffectClass);
					});
				}
								
			}).mouseleave(function (e) {   
				
				if (hoverBoxEffect == "no") {
					jQuery(this).find(".mnwall-hover-box").stop().removeClass("hoverShow");
					jQuery(this).find(".mnwall-hover-box-content").removeClass(hoverContentEffectClass);
				}
				if (hoverBoxEffect == "1") {
					jQuery(this).find(".mnwall-hover-box").stop().removeClass("hoverFadeIn")
					.bind("transitionend webkitTransitionEnd oTransitionEnd MSTransitionEnd", function(){  
						jQuery(this).find(".mnwall-hover-box-content").removeClass(hoverContentEffectClass);
					});
				}
				
			});
		}
	}
	window.triggerHoverBox = triggerHoverBox;
		
	// Add detail-box background-color
	var backgroundColor = function backgroundColor($container, gridType, themeType, detailBoxBackground, detailBoxBackgroundOpacity) {
		$container.find(".mnwall-item").each(function(index){
			if (gridType != 99) {
				if (themeType == 1) {
					if (gridType == 98) {
						jQuery(this).find(".mnwall-item-inner-cont").css({"background":"rgba("+ColorR(detailBoxBackground)+", "+ColorG(detailBoxBackground)+", "+ColorB(detailBoxBackground)+", "+detailBoxBackgroundOpacity+")"});
					} else {
						jQuery(this).find(".mnwall-item-inner").css({"background":"rgba("+ColorR(detailBoxBackground)+", "+ColorG(detailBoxBackground)+", "+ColorB(detailBoxBackground)+", "+detailBoxBackgroundOpacity+")"});
					}
				}
				if (themeType == 2) {
					jQuery(this).find(".mnwall-detail-box-inner").css({"background":"rgba("+ColorR(detailBoxBackground)+", "+ColorG(detailBoxBackground)+", "+ColorB(detailBoxBackground)+", "+detailBoxBackgroundOpacity+")"});
				}
			}
			if (gridType == 99) {
				jQuery(this).find(".mnwall-item-inner-cont").css({"background":"rgba("+ColorR(detailBoxBackground)+", "+ColorG(detailBoxBackground)+", "+ColorB(detailBoxBackground)+", "+detailBoxBackgroundOpacity+")"});
			}
		});
	};
	window.backgroundColor = backgroundColor;
	
	// Change active class on filter buttons
	var active_Filters = function active_Filters(mwmod) {
		var $activeFilters = jQuery("#mnwall_container_"+mwmod+" .button-group").each( function( i, buttonGroup ) {
			var $buttonGroup = jQuery( buttonGroup );
			$buttonGroup.on( "click", "a", function(event) {
				event.preventDefault();
				$buttonGroup.find(".mnw_filter_active").removeClass("mnw_filter_active");
				jQuery( this ).addClass("mnw_filter_active");
			});
		});
	};
	window.active_Filters = active_Filters;
	
	// Dropdown filter list
	var dropdown_Filters = function dropdown_Filters(mwmod) {
		var $dropdownFilters = jQuery("#mnwall_iso_filters_"+mwmod+" .mnwall_iso_dropdown").each( function( i, dropdownGroup ) {
			var $dropdownGroup = jQuery( dropdownGroup );
			$dropdownGroup.on( "click", ".dropdown-label", function(event) {
				event.preventDefault();
				$dropdownGroup.toggleClass("expanded");
			});
		});
		jQuery(document).mouseup(function (e)
		{
			var $dropdowncontainer = jQuery("#mnwall_container_"+mwmod+" .mnwall_iso_dropdown");
		
			if (!$dropdowncontainer.is(e.target)
				&& $dropdowncontainer.has(e.target).length === 0
				) 
			{
				$dropdowncontainer.removeClass("expanded");
			}
		});
	};
	window.dropdown_Filters = dropdown_Filters;
	
	// Dropdown sorting list
	var dropdown_Sortings = function dropdown_Sortings(mwmod) {
		var $dropdownSortings = jQuery("#mnwall_iso_sortings_"+mwmod+" .mnwall_iso_dropdown").each( function( i, dropdownSorting ) {
			var $dropdownSorting = jQuery( dropdownSorting );
			$dropdownSorting.on( "click", ".dropdown-label", function(event) {
				event.preventDefault();
				$dropdownSorting.toggleClass("expanded");
			});
		});
	};
	window.dropdown_Sortings = dropdown_Sortings;
	
	// Fix background image size
	var backgroundSize = function backgroundSize($container) {
		$container.find(".mnwall-item").each(function(){
			var $lp = jQuery(this).attr("data-lp");
			var $child_cont = jQuery(this).find(".mnwall-item-inner-cont");
			var $child_cont_width = $child_cont.width();
			var $child_cont_height = $child_cont.height();
			var $lk_raw = $child_cont_width / $child_cont_height;
			var $lk = $lk_raw.toFixed(2);
			// 1.
			if ($lk <= 1 && $lp >= 1) {
				jQuery(this).find(".mnwall-item-inner-cont").css({"background-size":"auto 100%"});
			}
			// 2.
			if ($lk < 1 && $lp < 1) {
				// 2a.
				if ($lp > $lk) {
					jQuery(this).find(".mnwall-item-inner-cont").css({"background-size":"auto 100%"});
				}
				// 2b.
				if ($lp < $lk) {
					jQuery(this).find(".mnwall-item-inner-cont").css({"background-size":"100% auto"});
				}
			}
			// 3.
			if ($lk >= 1 && $lp <= 1) {
				jQuery(this).find(".mnwall-item-inner-cont").css({"background-size":"100% auto"});
			}
			// 4.
			if ($lk > 1 && $lp > 1) {
				// 4a.
				if ($lp > $lk) {
					jQuery(this).find(".mnwall-item-inner-cont").css({"background-size":"auto 100%"});
				}
				// 4b.
				if ($lp < $lk) {
					jQuery(this).find(".mnwall-item-inner-cont").css({"background-size":"100% auto"});
				}
			}
			
		});
	};
	window.backgroundSize = backgroundSize;
	
});	