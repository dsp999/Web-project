<?php
/**
 * @package   T3 Framework
 * @copyright Copyright (C) 2005 - 2012 Open Source Matters, Inc. All rights reserved.
 * @license   GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

// get params
$sitename  = $this->params->get('sitename');
$slogan    = $this->params->get('slogan', '');
$logotype  = $this->params->get('logotype', 'text');
$logoimage = $logotype == 'image' ? $this->params->get('logoimage', T3Path::getUrl('images/logo.png', '', true)) : '';
$logoimgsm = ($logotype == 'image' && $this->params->get('enable_logoimage_sm', 0)) ? $this->params->get('logoimage_sm', T3Path::getUrl('images/logo-sm.png', '', true)) : false;
if (!$sitename) {
	$sitename = JFactory::getConfig()->get('sitename');
}
$t3action = JRequest::getVar('t3action');
if ($t3action != 'layout') 
{
	if ($this->countModules('search-popup') && $this->countModules('login-popup'))  
	{
	$mainnav_class = 'col-md-7 col-lg-7';
	$logosize = ' col-xs-12 col-sm-3';
	}
	
	elseif ($this->countModules('search-popup') && !$this->countModules('login-popup'))
	{
	$mainnav_class = 'col-md-7 col-lg-7';
	$logosize = ' col-xs-12 col-sm-3';
	}
	
	elseif (!$this->countModules('search-popup') && $this->countModules('login-popup')) 
	{
	$mainnav_class = 'col-md-7 col-lg-7';
	$logosize = ' col-xs-12 col-sm-3';
	}
	
	else{
	$mainnav_class = 'col-md-8 col-lg-8';
	$logosize = ' col-xs-12 col-sm-3';
	}
}
$sliderCaption = $this->params->get('slider-caption');
if ($sliderCaption ){
	$sliderclass = 'mn-slider-caption';
}
else{
	$sliderclass ='';
}

if ($sliderCaption ){
$slider_image = $this->params->get('slider_image');
}
else{
	$slider_image='';
}
$sliderImage = 'style="background-image:url('.$slider_image.')"';
$sliderIco = $this->params->get('slider-caption-ico');
$sliderTitle = $this->params->get('slider-caption-tilte');
$sliderBtnText = $this->params->get('slider-caption-btn-text');
$sliderBtnLink = $this->params->get('slider-caption-btn-link');

?>

<!-- HEADER -->

<header id="t3-header" class="t3-header <?php echo $sliderclass ?>" <?php echo $sliderImage ?>>
	<div class="container">
		<div class="row mn-header"> 
			
			<!-- LOGO -->
			<div class="<?php echo $logosize ?> logo">
				<div class="logo-<?php echo $logotype, ($logoimgsm ? ' logo-control' : '') ?>"> <a href="<?php echo JURI::base(true) ?>" title="<?php echo strip_tags($sitename) ?>">
					<?php if($logotype == 'image'): ?>
					<img class="logo-img" src="<?php echo JURI::base(true) . '/' . $logoimage ?>" alt="<?php echo strip_tags($sitename) ?>" />
					<?php endif ?>
					<?php if($logoimgsm) : ?>
					<img class="logo-img-sm" src="<?php echo JURI::base(true) . '/' . $logoimgsm ?>" alt="<?php echo strip_tags($sitename) ?>" />
					<?php endif ?>
					<span><?php echo $sitename ?></span> </a> <small class="site-slogan"><?php echo $slogan ?></small> </div>
			</div>
			<!-- //LOGO --> 
			
			<!-- Main Nav -->
			<nav id="t3-mainnav" class="navbar navbar-default t3-mainnav col-xs-12 <?php echo $mainnav_class; ?>">
				<div class="row"> 
					<!-- Brand and toggle get grouped for better mobile display -->
					<div class="navbar-header">
						<?php if ($this->getParam('navigation_collapse_enable', 1) && $this->getParam('responsive', 1)) : ?>
						<?php $this->addScript(T3_URL.'/js/nav-collapse.js'); ?>
						<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".t3-navbar-collapse"> <i class="fa fa-bars"></i> </button>
						<?php endif ?>
						<?php if ($this->getParam('addon_offcanvas_enable')) : ?>
						<?php $this->loadBlock ('off-canvas') ?>
						<?php endif ?>
					</div>
					<?php if ($this->getParam('navigation_collapse_enable')) : ?>
					<div class="t3-navbar-collapse navbar-collapse collapse"></div>
					<?php endif ?>
					<div class="t3-navbar navbar-collapse collapse">
						<jdoc:include type="<?php echo $this->getParam('navigation_type', 'megamenu') ?>" name="<?php echo $this->getParam('mm_type', 'mainmenu') ?>" />
					</div>
				</div>
			</nav>
			<!-- //Main Nav --> 
			
			<!-- Top-Right Login Icon -->
			<?php if ($t3action != 'layout') { ?>
			<?php if ($this->countModules('login-popup')) : ?>
			<div class="col-xs-1 col-mn-login">
				<?php $user =& JFactory::getUser();
                    if ($user->get('guest')) { ?>
				<a data-toggle="modal" href="#mn-login" class="mn-login"><i class="fa fa-lock"></i></a>
				<?php } else { ?>
				<a data-toggle="modal" href="#mn-login" class="mn-login"><i class="fa fa-unlock"></i></a>
				<?php } ?>
			</div>
			<?php endif ?>
			<?php } ?>
			<!-- //Top-Right Login Icon --> 
			
			<!-- Top-Right Search Icon -->
			<?php if ($t3action != 'layout') { ?>
			<?php if ($this->countModules('search-popup')) : ?>
			<!-- Top-Right Login -->
			<div class="col-xs-1 col-mn-search">
				<?php $user =& JFactory::getUser();
                    if ($user->get('guest')) { ?>
				<a data-toggle="modal" href="#mn-search" class="mn-search"><i class="fa fa-search"></i></a>
				<?php } else { ?>
				<a data-toggle="modal" href="#mn-search" class="mn-search"><i class="fa fa-search"></i></a>
				<?php } ?>
			</div>
			<?php endif ?>
			<?php } ?>
			<!-- //Top-Right Search Icon --> 
			
			<!-- LANGUAGE SWITCHER -->
			<?php if ($t3action != 'layout') { ?>
			<?php if ($this->countModules('languageswitcherload')) : ?>
			<div class="col-xs-12 col-sm-1 col-mn-languageswitcher">
				<div class="languageswitcherload">
					<jdoc:include type="modules" name="<?php $this->_p('languageswitcherload') ?>" style="raw" />
				</div>
			</div>
			<?php endif ?>
			<?php } ?>
			<!-- //LANGUAGE SWITCHER -->
			
			<?php if ($t3action != 'layout') { ?>
				<?php if ($sliderCaption) { ?>
				<div class="col-xs-12">
					<div class="mn-mod-header">
						<?php if ($sliderIco){ ?>
						<div class="mn-logo text-center"> <i class="<?php echo $sliderIco?>"></i> </div>
						<?php } ?>
						<?php if ($sliderTitle){ ?>
						<div class="mn-title">
							<h2><?php echo $sliderTitle ?></h2>
						</div>
						<?php } ?>
						<?php if ($sliderBtnText){ ?>
						<div class="mn-mod-btn text-center"> <a class="btn btn-primary" href="<?php echo $sliderBtnLink ?>"> <?php echo $sliderBtnText ?> </a> </div>
						<?php } ?>
					</div>
				</div>
				<?php } ?>
			<?php } ?>
		</div>
	</div>
</header>
<!-- //HEADER -->

<?php if ($t3action != 'layout') { ?>

<!-- Top-Right Search Modal -->
<?php if ($this->countModules('search-popup')) : ?>
<?php if ($t3action != 'layout') { ?>
<div id="mn-search" class="modal fade mn-modal-controls" tabindex="-1" role="dialog" aria-labelledby="MNsearch" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-body">
				<div class="modal-close-btn">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				</div>
				<?php } ?>
				<jdoc:include type="modules" name="<?php $this->_p('search-popup') ?>" style="T3Xhtml" />
				<?php if ($t3action != 'layout') { ?>
			</div>
		</div>
	</div>
</div>
<?php } ?>
<?php endif ?>
<!-- //Top-Right Search Modal --> 

<!-- Top-Right Login Modal -->
<?php if ($this->countModules('login-popup')) : ?>
<?php if ($t3action != 'layout') { ?>
<div id="mn-login" class="modal fade mn-modal-controls" tabindex="-1" role="dialog" aria-labelledby="MNLogin" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-body">
				<div class="modal-close-btn">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				</div>
				<?php } ?>
				<jdoc:include type="modules" name="<?php $this->_p('login-popup') ?>" style="T3Xhtml" />
				<?php if ($t3action != 'layout') { ?>
				<i class="fa fa-lock tip login-ico" title="Password"></i> </div>
		</div>
	</div>
</div>
<?php } ?>
<?php endif ?>
<!-- //Top-Right Login Modal -->

<?php } ?>
