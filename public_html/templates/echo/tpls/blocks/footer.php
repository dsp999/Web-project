<?php
/**
 * @package   T3 Framework
 * @copyright Copyright (C) 2005 - 2012 Open Source Matters, Inc. All rights reserved.
 * @license   GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;
?>
<!-- FOOTER -->

<footer id="t3-footer" class="t3-footer">
	<div class="mn-footer-in">
		<div class="container">
		
			<?php if ($this->checkSpotlight('footnav', 'footer-1, footer-2, footer-3, footer-4, footer-5, footer-6')) : ?>
			<!-- FOOT NAVIGATION -->
			<?php $this->spotlight('footnav', 'footer-1, footer-2, footer-3, footer-4, footer-5, footer-6') ?>
			<!-- //FOOT NAVIGATION -->
			<?php endif ?>
		</div>
	</div>
	<?php if ($this->countModules('copyright')) : ?>
	<section class="t3-copyright">
		<div class="container">
			<div class="copyright row">
				<jdoc:include type="modules" name="<?php $this->_p('copyright') ?>" style="raw" />
			</div>
		</div>
	</section>
	<?php endif ?>
</footer>
<!-- //FOOTER -->