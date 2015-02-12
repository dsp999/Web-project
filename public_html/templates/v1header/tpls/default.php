<?php

/**
 * @package   T3 Framework
 * @copyright Copyright (C) 2005 - 2012 Open Source Matters, Inc. All rights reserved.
 * @license   GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;
?>

<!DOCTYPE html>
<html lang="<?php echo $this->language; ?>" dir="<?php echo $this->direction; ?>"
	  class='<jdoc:include type="pageclass" />'>
<head>
<jdoc:include type="head" />
<?php $this->loadBlock('head') ?>
</head>

<body>
	<div class="t3-wrapper"> <!-- Need this wrapper for off-canvas menu. Remove if you don't use of-canvas -->
		
		<?php $this->loadBlock('header') ?>
		
		<?php $this->loadBlock('spotlight-1') ?>
		
		<?php $this->loadBlock('mn-parallax1') ?>
		
		<?php $this->loadBlock('spotlight-2') ?>
		
		<?php $this->loadBlock('mn-parallax2') ?>
		
		<?php $this->loadBlock('spotlight-3') ?>
		
		<?php $this->loadBlock('spotlight-4') ?>
		
		<?php $this->loadBlock('spotlight-5') ?>
		
		<?php $this->loadBlock('spotlight-6') ?>
		
		<?php $this->loadBlock('mainbody') ?>
		
		<?php $this->loadBlock('spotlight-7') ?>
		
		<?php $this->loadBlock('navhelper') ?>
		
		<?php $this->loadBlock('footer') ?>
		
		<?php if ($this->countModules('scroll-button')) : ?>
			<!-- Scroll Button -->
			<jdoc:include type="modules" name="<?php $this->_p('scroll-button') ?>" style="raw" />
			<!-- //Scroll Button -->   
		<?php endif ?>
		
	</div>
</body>
</html>