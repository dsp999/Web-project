<?php
/**
 * @package   T3 Framework
 * @copyright Copyright (C) 2005 - 2012 Open Source Matters, Inc. All rights reserved.
 * @license   GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;
?>
<?php if ($this->countModules('mn-parallax2')) : ?>
<section class="mn-section">
	<jdoc:include type="modules" name="<?php $this->_p('mn-parallax2') ?>" style="raw" />
</section>
<?php endif ?>
