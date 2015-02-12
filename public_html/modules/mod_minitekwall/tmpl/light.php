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

if (!empty($wall) ||  $wall!== 0) { 

	// Hover effects
	$hoverEffectClass = '';
	if ($hoverBoxEffect == '4') {
		$hoverEffectClass = 'slideInRight';
	}
	if ($hoverBoxEffect == '5') {
		$hoverEffectClass = 'slideInLeft';
	}
	if ($hoverBoxEffect == '6') {
		$hoverEffectClass = 'slideInTop';
	}
	if ($hoverBoxEffect == '7') {
		$hoverEffectClass = 'slideInBottom';
	}
	if ($hoverBoxEffect == '8') {
		$hoverEffectClass = 'mnwzoomIn';
	}
	
	// Transition styles
	$animated = '';
	if ($hoverBoxEffect != 'no' && $hoverBoxEffect != '2' && $hoverBoxEffect != '3') {
		$animated = 'transition: all '.$hoverBoxEffectSpeed.'s ease 0s';
	}
	$animated_content = '';
	if ($hoverBoxContentEffect != 'no-effect') {
		$animated_content = 'transition: all '.$hoverBoxContentEffectSpeed.'s ease 0s';
	}
	
	$animated_flip = '';
	if ($hoverBoxEffect == '2' || $hoverBoxEffect == '3') {
		$animated_flip = 'transition: all '.$hoverBoxEffectSpeed.'s ease 0s';
	}
	
	// Hover content effects
	$hoverContentEffectClass = '';
	// Fade
	if ($hoverBoxContentEffect == '1') {
		$hoverContentEffectClass = 'hoverFadeInPre';
	}
	// Slide in left
	if ($hoverBoxContentEffect == '2') {
		$hoverContentEffectClass = 'slideInLeftPre';
	}
	// Slide in right
	if ($hoverBoxContentEffect == '3') {
		$hoverContentEffectClass = 'slideInRightPre';
	}
	// Slide in top
	if ($hoverBoxContentEffect == '4') {
		$hoverContentEffectClass = 'slideInTopPre';
	}
	// Slide in bottom
	if ($hoverBoxContentEffect == '5') {
		$hoverContentEffectClass = 'slideInBottomPre';
	}
	// Slide mix 1
	if ($hoverBoxContentEffect == '6') {
		$hoverContentEffectClass = 'slideInMix1Pre';
	}
	// Slide mix 2
	if ($hoverBoxContentEffect == '7') {
		$hoverContentEffectClass = 'slideInMix2Pre';
	}
	// Slide mix 3
	if ($hoverBoxContentEffect == '8') {
		$hoverContentEffectClass = 'slideInMix3Pre';
	}
	
	// Columns width
	if ($gridType == '98o') {
		$masColsper = number_format((float)$masColsper, 2, '.', '');
		$cols = 'width: '.$masColsper.'%;';
	}
	
	// Hover box theme
	if ($hoverBoxTheme == 'black') {
		$hoverTheme = 'black-hover';
	} if ($hoverBoxTheme == 'white') {
		$hoverTheme = 'white-hover';
	} if ($hoverBoxTheme == 'red') {
		$hoverTheme = 'red-hover';
	} if ($hoverBoxTheme == 'green') {
		$hoverTheme = 'green-hover';
	} if ($hoverBoxTheme == 'blue') {
		$hoverTheme = 'blue-hover';
	} if ($hoverBoxTheme == 'grey') {
		$hoverTheme = 'grey-hover';
	} if ($hoverBoxTheme == 'orange') {
		$hoverTheme = 'orange-hover';
	} if ($hoverBoxTheme == 'purple') {
		$hoverTheme = 'purple-hover';
	}
	
	// Hover box text color
	if ($hoverBoxTextColor == '1') {
		$hoverTextColor = 'dark-text';
	} else {
		$hoverTextColor = 'light-text';
	}
	?>
	
	<?php foreach ($wall as $key=>$wall_item) {	
		$index = $key + 1;
		$class = 'mnwitem'.$index;
		$cols = '';
		if ($gridType == '98o') {
			$masColsper = number_format((float)$masColsper, 2, '.', '');
			$cols = 'width: '.$masColsper.'%;';
		}
		// Filters
		$catfilter = '';
		if (isset($wall_item->itemCategory) && !isset($wall_item->itemCategoryOff)) {
			$catfilter .= 'cat-'.MinitekWallHelperUtilities::cleanName($wall_item->itemCategoryName);
		}	
		$datefilter = '';
		if (isset($wall_item->itemDateFilter)) {
			$datefilter .= 'date-'.MinitekWallHelperUtilities::cleanName($wall_item->itemDateFilter);
		}
		$locationfilter = '';
		if (isset($wall_item->itemLocation)) {
			$locationfilter .= 'location-'.MinitekWallHelperUtilities::cleanName($wall_item->itemLocation);
		}
		// Background image size
		if (isset($wall_item->itemImage) && $wall_item->itemImage) {
			list($lp_width, $lp_height) = getimagesize($wall_item->itemImage);
			$lp = $lp_width / $lp_height;
			$lp = number_format((float)$lp, 2, '.', '');
		}
	?>
	
		<div 
			class="mnwall-item 
			<?php echo $catfilter; ?>
			<?php if (isset($wall_item->isJoomlaArticle)) { ?>
				<?php if (isset($wall_item->itemTags)) { foreach($wall_item->itemTags as $key=>$itemTag) { echo 'tag-'.MinitekWallHelperUtilities::cleanName($itemTag->title).' '; } } ?> 
			<?php } else { ?>
				<?php if (isset($wall_item->itemTags)) { foreach($wall_item->itemTags as $key=>$itemTag) { echo 'tag-'.MinitekWallHelperUtilities::cleanName($itemTag->name).' '; } } ?>
			<?php } ?>
			<?php echo $datefilter; ?>
			<?php echo $locationfilter; ?>
			<?php echo $class; ?> 
			<?php echo $hoverEffectClass; ?>" 
			style=" <?php echo $cols; ?> padding:<?php echo (int)$gutter; ?>px;"
			data-title="<?php echo strtolower($wall_item->itemTitle); ?>"
			<?php if (isset($wall_item->itemCategory) && !isset($wall_item->itemCategoryOff)) { ?>
				data-category="<?php echo strtolower($wall_item->itemCategoryName); ?>"
			<?php } ?>
			<?php if (isset($wall_item->itemAuthorName)) { ?>
				data-author="<?php echo strtolower($wall_item->itemAuthorName); ?>"
			<?php } ?>
			<?php if (isset($wall_item->itemDateRaw)) { ?>
				data-date="<?php echo $wall_item->itemDateRaw; ?>"
			<?php } ?>
			<?php if (isset($wall_item->itemImage) && $wall_item->itemImage) { ?>
				data-lp="<?php echo $lp; ?>"
			<?php } ?>
		>
			<div 
				class="mnwall-item-outer-cont"
				<?php if ($gridType != '99v' && $gridType != '98o') { ?>
					style=" <?php echo $animated_flip; ?>"
				<?php } ?>
			>
			<div 
				class="mnwall-item-inner-cont" 
				<?php if ($gridType != '99v' && $gridType != '98o') { ?>
					style="background: url('<?php echo $wall_item->itemImage; ?>') no-repeat scroll center center;"
				<?php } ?>
			>
			
				<?php if ($gridType != '99v' && $gridType != '98o') { ?>
					<a href="<?php echo $wall_item->itemLink; ?>" class="mnwall-photo-link"></a>
				<?php } ?>
				
				<?php if ($detailBox || $gridType == '99v' || $gridType == '98o') { ?>
					<div class="mnwall-item-inner mnwall-detail-box">
					
						<header>
						
							<?php if ($gridType == '98o' || $gridType == '99v') { ?>
								<?php if (isset($wall_item->itemImage)) { ?>
								<div class="mnwall-cover <?php echo $hoverEffectClass; ?>">
									<div class="mnwall-img-div" style=" <?php echo $animated_flip; ?>">
									
										<div class="mnwall-item-img">
											<a href="<?php echo $wall_item->itemLink; ?>" class="">
												<img src="<?php echo $wall_item->itemImage; ?>" alt="">
											</a>
										</div>
										
										<?php if ($hoverBox) { ?>
											
											<div class="mnwall-hover-box <?php echo $hoverTheme; ?>" style=" <?php echo $animated; ?>">
												
												<div class="mnwall-hover-box-bg"></div>
												
												<div class="mnwall-hover-box-content <?php echo $hoverTextColor; ?> <?php echo $hoverContentEffectClass; ?>">
												
													<?php if ($hoverBoxTitle) { ?>
														<h3 class="mnwall-item-title" style=" <?php echo $animated_content; ?>">
															<a href="<?php echo $wall_item->itemLink; ?>">
																<?php echo $wall_item->itemTitle; ?>
															</a>	
														</h3>
													<?php } ?>
													
													<div class="mnwall-item-info" style=" <?php echo $animated_content; ?>">
													
														<?php if (isset($wall_item->itemCategory) && $wall_item->itemCategory && $hoverBoxCategory) { ?>
															<span class="mnwall-item-category">
																<?php echo JText::_('COM_MINITEKWALL_IN'); ?>&nbsp;<?php echo $wall_item->itemCategory; ?>
															</span>
														<?php } ?>
														
														<?php if (isset($wall_item->itemType) && $hoverBoxType) { ?>
															<span class="mnwall-item-type">
																<?php if (isset($wall_item->itemCategory) && $wall_item->itemCategory && $hoverBoxCategory) { ?>
																	&#47;
																<?php } ?>
																<?php echo $wall_item->itemType; ?>
															</span>
														<?php } ?>
														
														<div class="mnwall-item-clear"></div>
														
														<?php if (isset($wall_item->itemAuthor) && $hoverBoxAuthor) { ?>
															<span class="mnwall-item-author">
																<?php echo JText::_('COM_MINITEKWALL_BY'); ?>&nbsp;<?php echo $wall_item->itemAuthor; ?>
															</span>
														<?php } ?>
														
														<?php if (isset($wall_item->itemDate) && $hoverBoxDate) { ?>
															<span class="mnwall-item-date">
																<?php echo JText::_('COM_MINITEKWALL_ON'); ?>&nbsp;<?php echo $wall_item->itemDate; ?>
															</span>
														<?php } ?>
														
													</div>
																									
													<?php if (isset($wall_item->itemIntrotext) && $wall_item->itemIntrotext && $hoverBoxIntrotext) { ?>
														<div class="mnwall-item-introtext" style=" <?php echo $animated_content; ?>">
															<?php echo $wall_item->itemIntrotext; ?>
														</div>
													<?php } ?>
													
													<?php if ($hoverBoxLinkButton || $hoverBoxFancyButton) { ?>
														<div class="mnwall-item-icons" style=" <?php echo $animated_content; ?>">
															<?php if ($hoverBoxLinkButton) { ?>
																<a href="<?php echo $wall_item->itemLink; ?>" class="mnwall-item-link-icon" style=" <?php echo $animated_content; ?>">
																	<i class="fa fa-link"></i>
																</a>
															<?php } ?>
															
															<?php if ($hoverBoxFancyButton) { ?>
																<a href="<?php echo $wall_item->itemImage; ?>" class="mnwall-item-fancy-icon" style=" <?php echo $animated_content; ?>">
																	<i class="fa fa-search"></i>
																</a>
															<?php } ?>
														</div>
													<?php } ?>
													
												</div>
												
											</div>
											
										<?php } ?>
										
									</div>
								</div>
								<?php } ?>
							<?php } ?>
							
							<?php if ($detailBox) { ?>
							
								<?php if ($detailBoxTitle) { ?>
									<h3 class="mnwall-item-title">
										<a href="<?php echo $wall_item->itemLink; ?>">
											<?php echo $wall_item->itemTitle; ?>
										</a>	
									</h3>
								<?php } ?>
								
								<?php if ((isset($wall_item->itemCategory) && $detailBoxCategory) || 
											(isset($wall_item->itemType) && $detailBoxType) || 
											(isset($wall_item->itemAuthor) && $detailBoxAuthor) || 
											(isset($wall_item->itemDate) && $detailBoxDate)) { 
								?>
								<div class="mnwall-item-subheader">
								
									<?php if (isset($wall_item->itemCategory) && $wall_item->itemCategory && $detailBoxCategory) { ?>
										<span class="mnwall-item-category">
											<?php echo JText::_('COM_MINITEKWALL_IN'); ?>&nbsp;<?php echo $wall_item->itemCategory; ?>
										</span>
									<?php } ?>
									
									<?php if (isset($wall_item->itemType) && $detailBoxType) { ?>
										<span class="mnwall-item-type">
											<?php if (isset($wall_item->itemCategory) && $wall_item->itemCategory && $detailBoxCategory) { ?>
												&#47;
											<?php } ?>
											<?php echo $wall_item->itemType; ?>
										</span>
									<?php } ?>
									
									<div class="mnwall-item-clear"></div>
									
									<?php if (isset($wall_item->itemAuthor) && $detailBoxAuthor) { ?>
										<span class="mnwall-item-author">
											<?php echo JText::_('COM_MINITEKWALL_BY'); ?>&nbsp;<?php echo $wall_item->itemAuthor; ?>
										</span>
									<?php } ?>
									
									<?php if (isset($wall_item->itemDate) && $detailBoxDate) { ?>
										<span class="mnwall-item-date">
											<?php echo JText::_('COM_MINITEKWALL_ON'); ?>&nbsp;<?php echo $wall_item->itemDate; ?>
										</span>
									<?php } ?>
								
								</div>
								<?php } ?>
							
								<?php if ((
								(isset($wall_item->itemIntrotext) && $wall_item->itemIntrotext && $detailBoxIntrotext) 
								|| (isset($wall_item->itemCount) && $detailBoxCount))
								&& ($detailBoxTitle
								|| (isset($wall_item->itemCategory) && $wall_item->itemCategory && $detailBoxCategory)
								|| (isset($wall_item->itemType) && $wall_item->itemType && $detailBoxType)
								|| (isset($wall_item->itemAuthor) && $wall_item->itemAuthor && $detailBoxAuthor)
								|| (isset($wall_item->itemDate) && $wall_item->itemDate && $detailBoxDate)
								)
								) { ?>
									<div class="mnwall-item-clear"></div>
									<div class="mnwall-item-separator">mnwall-separator</div>
								<?php } ?>
								
							<?php } ?>
							
						</header>
						
						<?php if ($detailBox) { ?>
						
							<?php if ($detailBoxIntrotext || $detailBoxCount) { ?>
								<section>
								
									<?php if (isset($wall_item->itemIntrotext) && $wall_item->itemIntrotext && $detailBoxIntrotext) { ?>
										<div class="mnwall-item-introtext">
											<?php echo $wall_item->itemIntrotext; ?>
										</div>
									<?php } ?>
									
									<?php if (isset($wall_item->itemCount) && $detailBoxCount) { ?>
										<div class="mnwall-item-count">
											<?php echo $wall_item->itemCount; ?>
										</div>
									<?php } ?>
									
								</section>
							<?php } ?>
						
						<?php } ?>
											
					</div>
				<?php } ?>
				
			</div>
			
			<?php if ($gridType != '99v' && $gridType != '98o') { ?>
			
				<?php if ($hoverBox) { ?>
												
					<div class="mnwall-hover-box <?php echo $hoverTheme; ?>" style=" <?php echo $animated; ?>">
						
						<div class="mnwall-hover-box-bg"></div>
						
						<div class="mnwall-hover-box-content <?php echo $hoverTextColor; ?> <?php echo $hoverContentEffectClass; ?>">
						
							<?php if ($hoverBoxTitle) { ?>
								<h3 class="mnwall-item-title" style=" <?php echo $animated_content; ?>">
									<a href="<?php echo $wall_item->itemLink; ?>">
										<?php echo $wall_item->itemTitle; ?>
									</a>	
								</h3>
							<?php } ?>
							
							<div class="mnwall-item-info" style=" <?php echo $animated_content; ?>">
							
								<?php if (isset($wall_item->itemCategory) && $wall_item->itemCategory && $hoverBoxCategory) { ?>
									<span class="mnwall-item-category">
										<?php echo JText::_('COM_MINITEKWALL_IN'); ?>&nbsp;<?php echo $wall_item->itemCategory; ?>
									</span>
								<?php } ?>
								
								<?php if (isset($wall_item->itemType) && $hoverBoxType) { ?>
									<span class="mnwall-item-type">
										<?php if (isset($wall_item->itemCategory) && $wall_item->itemCategory && $hoverBoxCategory) { ?>
											&#47;
										<?php } ?>
										<?php echo $wall_item->itemType; ?>
									</span>
								<?php } ?>
								
								<div class="mnwall-item-clear"></div>
								
								<?php if (isset($wall_item->itemAuthor) && $hoverBoxAuthor) { ?>
									<span class="mnwall-item-author">
										<?php echo JText::_('COM_MINITEKWALL_BY'); ?>&nbsp;<?php echo $wall_item->itemAuthor; ?>
									</span>
								<?php } ?>
								
								<?php if (isset($wall_item->itemDate) && $hoverBoxDate) { ?>
									<span class="mnwall-item-date">
										<?php echo JText::_('COM_MINITEKWALL_ON'); ?>&nbsp;<?php echo $wall_item->itemDate; ?>
									</span>
								<?php } ?>
								
							</div>
																			
							<?php if (isset($wall_item->itemIntrotext) && $wall_item->itemIntrotext && $hoverBoxIntrotext) { ?>
								<div class="mnwall-item-introtext" style=" <?php echo $animated_content; ?>">
									<?php echo $wall_item->itemIntrotext; ?>
								</div>
							<?php } ?>
							
							<?php if ($hoverBoxLinkButton || $hoverBoxFancyButton) { ?>
								<div class="mnwall-item-icons" style=" <?php echo $animated_content; ?>">
									<?php if ($hoverBoxLinkButton) { ?>
										<a href="<?php echo $wall_item->itemLink; ?>" class="mnwall-item-link-icon" style=" <?php echo $animated_content; ?>">
											<i class="fa fa-link"></i>
										</a>
									<?php } ?>
									
									<?php if ($hoverBoxFancyButton) { ?>
										<a href="<?php echo $wall_item->itemImage; ?>" class="mnwall-item-fancy-icon" style=" <?php echo $animated_content; ?>">
											<i class="fa fa-search"></i>
										</a>
									<?php } ?>
								</div>
							<?php } ?>
							
						</div>
						
					</div>
					
				<?php } ?>
				
			<?php } ?>
			
			</div>
			
		</div>
	
	<?php }
	
} else {
	echo '-'; // =0 // for ajax purposes
}