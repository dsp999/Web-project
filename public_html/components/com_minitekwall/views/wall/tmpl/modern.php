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

if (!empty($this->wall) ||  $this->wall!== 0) { 

	// Hover effects
	$hoverEffectClass = '';
	
	// Transition styles
	$animated = '';
	if ($this->hoverBoxEffect != 'no' && $this->hoverBoxEffect != '2' && $this->hoverBoxEffect != '3') {
		$animated = 'transition: all '.$this->hoverBoxEffectSpeed.'s ease 0s';
	}
	$animated_content = '';
	if ($this->hoverBoxContentEffect != 'no-effect') {
		$animated_content = 'transition: all '.$this->hoverBoxContentEffectSpeed.'s ease 0s';
	}
		
	// Hover content effects
	$hoverContentEffectClass = '';
	// Fade
	if ($this->hoverBoxContentEffect == '1') {
		$hoverContentEffectClass = 'hoverFadeInPre';
	}
	
	// Columns width
	if ($this->gridType == '98o') {
		$this->masColsper = number_format((float)$this->masColsper, 2, '.', '');
		$cols = 'width: '.$this->masColsper.'%;';
	}
	
	// Hover box theme
	if ($this->hoverBoxTheme == 'black') {
		$hoverTheme = 'black-hover';
	} if ($this->hoverBoxTheme == 'white') {
		$hoverTheme = 'white-hover';
	}
	
	// Hover box text color
	if ($this->hoverBoxTextColor == '1') {
		$hoverTextColor = 'dark-text';
	} else {
		$hoverTextColor = 'light-text';
	}
	?>
	
	<?php foreach ($this->wall as $key=>$wall_item) {	
		$index = $key + 1;
		$class = 'mnwitem'.$index;
		$cols = '';
		if ($this->gridType == '98o') {
			$this->masColsper = number_format((float)$this->masColsper, 2, '.', '');
			$cols = 'width: '.$this->masColsper.'%;';
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
			style=" <?php echo $cols; ?> padding:<?php echo (int)$this->gutter; ?>px;"
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
			>
			<div 
				class="mnwall-item-inner-cont" 
				<?php if ($this->gridType != '99v' && $this->gridType != '98o') { ?>
					style="background: url('<?php echo $wall_item->itemImage; ?>') no-repeat scroll center center;"
				<?php } ?>
			>
			
				<?php if ($this->gridType != '99v' && $this->gridType != '98o') { ?>
					
					<a href="<?php echo $wall_item->itemLink; ?>" class="mnwall-photo-link"></a>
					
					<?php if ($wall_item->itemImage) { ?>
						<?php if ((isset($wall_item->itemCategory) && $wall_item->itemCategory && $this->detailBoxCategory) || (isset($wall_item->itemType) && $this->detailBoxType)) { ?>
							<div class="mnwall-item-category-type">
							<?php if (isset($wall_item->itemCategory) && $wall_item->itemCategory && $this->detailBoxCategory) { ?>
								<span class="mnwall-item-category">
									<?php echo $wall_item->itemCategory; ?>
								</span>
							<?php } ?>
							
							<?php if (isset($wall_item->itemType) && $this->detailBoxType) { ?>
								<span class="mnwall-item-type">
									<?php if (isset($wall_item->itemCategory) && $wall_item->itemCategory && $this->detailBoxCategory) { ?>
										&#47;&nbsp;
									<?php } ?>
									<?php echo $wall_item->itemType; ?>&nbsp;
								</span>
							<?php } ?>
							</div>
						<?php } ?>
					<?php } ?>
					
				<?php } ?>
				
				<?php if ($this->detailBox || $this->gridType == '99v' || $this->gridType == '98o') { ?>
					
					<div 
						class="mnwall-item-inner mnwall-detail-box"
						<?php if (!($wall_item->itemImage)) { ?>
							style="height: 100%;"
						<?php } ?>
					>
						
						<?php if ($this->gridType == '98o' || $this->gridType == '99v') { ?>
							<?php if (isset($wall_item->itemImage)) { ?>
							<div class="mnwall-cover <?php echo $hoverEffectClass; ?>">
							
								<div class="mnwall-img-div">
								
									<?php if ($wall_item->itemImage) { ?>
										<?php if ((isset($wall_item->itemCategory) && $wall_item->itemCategory && $this->detailBoxCategory) || (isset($wall_item->itemType) && $this->detailBoxType)) { ?>
											<div class="mnwall-item-category-type">
											<?php if (isset($wall_item->itemCategory) && $wall_item->itemCategory && $this->detailBoxCategory) { ?>
												<span class="mnwall-item-category">
													<?php echo $wall_item->itemCategory; ?>
												</span>
											<?php } ?>
											
											<?php if (isset($wall_item->itemType) && $this->detailBoxType) { ?>
												<span class="mnwall-item-type">
													<?php if (isset($wall_item->itemCategory) && $wall_item->itemCategory && $this->detailBoxCategory) { ?>
														&#47;&nbsp;
													<?php } ?>
													<?php echo $wall_item->itemType; ?>&nbsp;
												</span>
											<?php } ?>
											</div>
										<?php } ?>
									<?php } ?>
									
									<div class="mnwall-item-img">
										<a href="<?php echo $wall_item->itemLink; ?>" class="">
											<img src="<?php echo $wall_item->itemImage; ?>" alt="">
										</a>
									</div>
									
									<?php if ($this->gridType == '98o') { ?>
										<?php if ($this->detailBox) { ?>
											
											<div 
												class="mnwall-detail-box-inner"
												<?php if (!($wall_item->itemImage)) { ?>
													style="position: static;"
												<?php } ?>
											>
										
												<header>
												
													<?php if ($this->detailBoxTitle) { ?>
														<h3 class="mnwall-item-title">
															<a href="<?php echo $wall_item->itemLink; ?>">
																<?php echo $wall_item->itemTitle; ?>
															</a>	
														</h3>
													<?php } ?>
													
													<?php if ((isset($wall_item->itemCategory) && $this->detailBoxCategory) || 
																(isset($wall_item->itemType) && $this->detailBoxType) || 
																(isset($wall_item->itemAuthor) && $this->detailBoxAuthor) || 
																(isset($wall_item->itemDate) && $this->detailBoxDate)) { 
													?>
													<div class="mnwall-item-subheader">
													
														<?php if (!$wall_item->itemImage) { ?>
															<?php if (isset($wall_item->itemCategory) && $wall_item->itemCategory && $this->detailBoxCategory) { ?>
																<span class="mnwall-item-category">
																	<?php echo $wall_item->itemCategory; ?>
																</span>
															<?php } ?>
															
															<?php if (isset($wall_item->itemType) && $this->detailBoxType) { ?>
																<span class="mnwall-item-type">
																	<?php if (isset($wall_item->itemCategory) && $wall_item->itemCategory && $this->detailBoxCategory) { ?>
																		&#47;&nbsp;
																	<?php } ?>
																	<?php echo $wall_item->itemType; ?>&nbsp;
																</span>
															<?php } ?>
															<div class="mnwall-item-clear"></div>
														<?php } ?>
																							
														<?php if (isset($wall_item->itemAuthor) && $this->detailBoxAuthor) { ?>
															<span class="mnwall-item-author">
																<?php echo JText::_('COM_MINITEKWALL_BY'); ?>&nbsp;<?php echo $wall_item->itemAuthor; ?>
															</span>
														<?php } ?>
														
														<?php if (isset($wall_item->itemDate) && $this->detailBoxDate) { ?>
															<span class="mnwall-item-date">
																<?php echo JText::_('COM_MINITEKWALL_ON'); ?>&nbsp;<?php echo $wall_item->itemDate; ?>
															</span>
														<?php } ?>
													
													</div>
													<?php } ?>
												
													<?php if ((
													(isset($wall_item->itemIntrotext) && $wall_item->itemIntrotext && $this->detailBoxIntrotext) 
													|| (isset($wall_item->itemCount) && $this->detailBoxCount))
													&& ($this->detailBoxTitle
													|| (isset($wall_item->itemAuthor) && $wall_item->itemAuthor && $this->detailBoxAuthor)
													|| (isset($wall_item->itemDate) && $wall_item->itemDate && $this->detailBoxDate)
													)
													) { ?>
														<div class="mnwall-item-clear"></div>
													<?php } ?>
												
												</header>
											
												<?php if ($this->detailBoxIntrotext || $this->detailBoxCount) { ?>
													<section>
													
														<?php if (isset($wall_item->itemIntrotext) && $wall_item->itemIntrotext && $this->detailBoxIntrotext) { ?>
															<div class="mnwall-item-introtext">
																<?php echo $wall_item->itemIntrotext; ?>
															</div>
														<?php } ?>
														
														<?php if (isset($wall_item->itemCount) && $this->detailBoxCount) { ?>
															<div class="mnwall-item-count">
																<?php echo $wall_item->itemCount; ?>
															</div>
														<?php } ?>
														
													</section>
												<?php } ?>
											
											</div>
										<?php } ?>
									<?php } ?>
									
									<?php if ($this->hoverBox) { ?>
										
										<div class="mnwall-hover-box <?php echo $hoverTheme; ?>" style=" <?php echo $animated; ?>">
											
											<div class="mnwall-hover-box-bg"></div>
											
											<div class="mnwall-hover-box-content <?php echo $hoverTextColor; ?> <?php echo $hoverContentEffectClass; ?>">
											
												<?php if ($this->hoverBoxTitle) { ?>
													<h3 class="mnwall-item-title" style=" <?php echo $animated_content; ?>">
														<a href="<?php echo $wall_item->itemLink; ?>">
															<?php echo $wall_item->itemTitle; ?>
														</a>	
													</h3>
												<?php } ?>
												
												<div class="mnwall-item-info" style=" <?php echo $animated_content; ?>">
												
													<?php if (isset($wall_item->itemCategory) && $wall_item->itemCategory && $this->hoverBoxCategory) { ?>
														<span class="mnwall-item-category">
															<?php echo JText::_('COM_MINITEKWALL_IN'); ?>&nbsp;<?php echo $wall_item->itemCategory; ?>
														</span>
													<?php } ?>
													
													<?php if (isset($wall_item->itemType) && $this->hoverBoxType) { ?>
														<span class="mnwall-item-type">
															<?php if (isset($wall_item->itemCategory) && $wall_item->itemCategory && $this->hoverBoxCategory) { ?>
																&#47;
															<?php } ?>
															<?php echo $wall_item->itemType; ?>
														</span>
													<?php } ?>
													
													<div class="mnwall-item-clear"></div>
													
													<?php if (isset($wall_item->itemAuthor) && $this->hoverBoxAuthor) { ?>
														<span class="mnwall-item-author">
															<?php echo JText::_('COM_MINITEKWALL_BY'); ?>&nbsp;<?php echo $wall_item->itemAuthor; ?>
														</span>
													<?php } ?>
													
													<?php if (isset($wall_item->itemDate) && $this->hoverBoxDate) { ?>
														<span class="mnwall-item-date">
															<?php echo JText::_('COM_MINITEKWALL_ON'); ?>&nbsp;<?php echo $wall_item->itemDate; ?>
														</span>
													<?php } ?>
													
												</div>
																								
												<?php if (isset($wall_item->itemIntrotext) && $wall_item->itemIntrotext && $this->hoverBoxIntrotext) { ?>
													<div class="mnwall-item-introtext" style=" <?php echo $animated_content; ?>">
														<?php echo $wall_item->itemIntrotext; ?>
													</div>
												<?php } ?>
												
												<?php if ($this->hoverBoxLinkButton || $this->hoverBoxFancyButton) { ?>
													<div class="mnwall-item-icons" style=" <?php echo $animated_content; ?>">
														<?php if ($this->hoverBoxLinkButton) { ?>
															<a href="<?php echo $wall_item->itemLink; ?>" class="mnwall-item-link-icon" style=" <?php echo $animated_content; ?>">
																<i class="fa fa-link"></i>
															</a>
														<?php } ?>
														
														<?php if ($this->hoverBoxFancyButton) { ?>
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
						
						<?php if ($this->gridType != '98o') { ?>
							<?php if ($this->detailBox) { ?>
								<div 
									class="mnwall-detail-box-inner"
									<?php if (!($wall_item->itemImage)) { ?>
										style="height: 100%;"
									<?php } ?>
								>
							
									<header>
									
										<?php if ($this->detailBoxTitle) { ?>
											<h3 class="mnwall-item-title">
												<a href="<?php echo $wall_item->itemLink; ?>">
													<?php echo $wall_item->itemTitle; ?>
												</a>	
											</h3>
										<?php } ?>
										
										<?php if ((isset($wall_item->itemCategory) && $this->detailBoxCategory) || 
													(isset($wall_item->itemType) && $this->detailBoxType) || 
													(isset($wall_item->itemAuthor) && $this->detailBoxAuthor) || 
													(isset($wall_item->itemDate) && $this->detailBoxDate)) { 
										?>
										<div class="mnwall-item-subheader">
											
											<?php if (!$wall_item->itemImage) { ?>
												<?php if (isset($wall_item->itemCategory) && $wall_item->itemCategory && $this->detailBoxCategory) { ?>
													<span class="mnwall-item-category">
														<?php echo $wall_item->itemCategory; ?>
													</span>
												<?php } ?>
												
												<?php if (isset($wall_item->itemType) && $this->detailBoxType) { ?>
													<span class="mnwall-item-type">
														<?php if (isset($wall_item->itemCategory) && $wall_item->itemCategory && $this->detailBoxCategory) { ?>
															&#47;&nbsp;
														<?php } ?>
														<?php echo $wall_item->itemType; ?>&nbsp;
													</span>
												<?php } ?>
												<div class="mnwall-item-clear"></div>
											<?php } ?>
																						
											<?php if (isset($wall_item->itemAuthor) && $this->detailBoxAuthor) { ?>
												<span class="mnwall-item-author">
													<?php echo JText::_('COM_MINITEKWALL_BY'); ?>&nbsp;<?php echo $wall_item->itemAuthor; ?>
												</span>
											<?php } ?>
											
											<?php if (isset($wall_item->itemDate) && $this->detailBoxDate) { ?>
												<span class="mnwall-item-date">
													<?php echo JText::_('COM_MINITEKWALL_ON'); ?>&nbsp;<?php echo $wall_item->itemDate; ?>
												</span>
											<?php } ?>
										
										</div>
										<?php } ?>
									
										<?php if ((
										(isset($wall_item->itemIntrotext) && $wall_item->itemIntrotext && $this->detailBoxIntrotext) 
										|| (isset($wall_item->itemCount) && $this->detailBoxCount))
										&& ($this->detailBoxTitle
										|| (isset($wall_item->itemAuthor) && $wall_item->itemAuthor && $this->detailBoxAuthor)
										|| (isset($wall_item->itemDate) && $wall_item->itemDate && $this->detailBoxDate)
										)
										) { ?>
											<div class="mnwall-item-clear"></div>
										<?php } ?>
									
									</header>
								
									<?php if ($this->detailBoxIntrotext || $this->detailBoxCount) { ?>
										<section>
										
											<?php if (isset($wall_item->itemIntrotext) && $wall_item->itemIntrotext && $this->detailBoxIntrotext) { ?>
												<div class="mnwall-item-introtext">
													<?php echo $wall_item->itemIntrotext; ?>
												</div>
											<?php } ?>
											
											<?php if (isset($wall_item->itemCount) && $this->detailBoxCount) { ?>
												<div class="mnwall-item-count">
													<?php echo $wall_item->itemCount; ?>
												</div>
											<?php } ?>
											
										</section>
									<?php } ?>
								
								</div>
							<?php } ?>
						<?php } ?>
											
					</div>
				<?php } ?>
				
			</div>
			
			<?php if ($this->gridType != '99v' && $this->gridType != '98o') { ?>
			
				<?php if ($this->hoverBox) { ?>
												
					<div class="mnwall-hover-box <?php echo $hoverTheme; ?>" style=" <?php echo $animated; ?>">
						
						<div class="mnwall-hover-box-bg"></div>
						
						<div class="mnwall-hover-box-content <?php echo $hoverTextColor; ?> <?php echo $hoverContentEffectClass; ?>">
						
							<?php if ($this->hoverBoxTitle) { ?>
								<h3 class="mnwall-item-title" style=" <?php echo $animated_content; ?>">
									<a href="<?php echo $wall_item->itemLink; ?>">
										<?php echo $wall_item->itemTitle; ?>
									</a>	
								</h3>
							<?php } ?>
							
							<div class="mnwall-item-info" style=" <?php echo $animated_content; ?>">
							
								<?php if (isset($wall_item->itemCategory) && $wall_item->itemCategory && $this->hoverBoxCategory) { ?>
									<span class="mnwall-item-category">
										<?php echo JText::_('COM_MINITEKWALL_IN'); ?>&nbsp;<?php echo $wall_item->itemCategory; ?>
									</span>
								<?php } ?>
								
								<?php if (isset($wall_item->itemType) && $this->hoverBoxType) { ?>
									<span class="mnwall-item-type">
										<?php if (isset($wall_item->itemCategory) && $wall_item->itemCategory && $this->hoverBoxCategory) { ?>
											&#47;
										<?php } ?>
										<?php echo $wall_item->itemType; ?>
									</span>
								<?php } ?>
								
								<div class="mnwall-item-clear"></div>
								
								<?php if (isset($wall_item->itemAuthor) && $this->hoverBoxAuthor) { ?>
									<span class="mnwall-item-author">
										<?php echo JText::_('COM_MINITEKWALL_BY'); ?>&nbsp;<?php echo $wall_item->itemAuthor; ?>
									</span>
								<?php } ?>
								
								<?php if (isset($wall_item->itemDate) && $this->hoverBoxDate) { ?>
									<span class="mnwall-item-date">
										<?php echo JText::_('COM_MINITEKWALL_ON'); ?>&nbsp;<?php echo $wall_item->itemDate; ?>
									</span>
								<?php } ?>
								
							</div>
																			
							<?php if (isset($wall_item->itemIntrotext) && $wall_item->itemIntrotext && $this->hoverBoxIntrotext) { ?>
								<div class="mnwall-item-introtext" style=" <?php echo $animated_content; ?>">
									<?php echo $wall_item->itemIntrotext; ?>
								</div>
							<?php } ?>
							
							<?php if ($this->hoverBoxLinkButton || $this->hoverBoxFancyButton) { ?>
								<div class="mnwall-item-icons" style=" <?php echo $animated_content; ?>">
									<?php if ($this->hoverBoxLinkButton) { ?>
										<a href="<?php echo $wall_item->itemLink; ?>" class="mnwall-item-link-icon" style=" <?php echo $animated_content; ?>">
											<i class="fa fa-link"></i>
										</a>
									<?php } ?>
									
									<?php if ($this->hoverBoxFancyButton) { ?>
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