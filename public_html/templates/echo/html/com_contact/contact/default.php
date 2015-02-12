<?php
/**
 * @package     Joomla.Site
 * @subpackage  com_contact
 *
 * @copyright   Copyright (C) 2005 - 2013 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

$cparams = JComponentHelper::getParams('com_media');

jimport('joomla.html.html.bootstrap');
?>

<div class="contact<?php echo $this->pageclass_sfx?>" itemscope itemtype="http://schema.org/Person">

    <div class="mn-mod-header">
        <?php if ($this->params->get('show_page_heading')) : ?>
            <h2>
                <?php echo $this->escape($this->params->get('page_heading')); ?>
            </h2>
        <?php endif; ?>
        
        <?php if ($this->contact->name && $this->params->get('show_name')) : ?>
                <h4>
                    <?php if ($this->item->published == 0) : ?>
                        <span class="label label-warning"><?php echo JText::_('JUNPUBLISHED'); ?></span>
                    <?php endif; ?>
                    <span class="contact-name" itemprop="name"><?php echo $this->contact->name; ?></span>
                </h4>
        <?php endif;  ?>
        <?php if ($this->contact->misc && $this->params->get('show_misc')) : ?>
                <h4>
                    <?php echo $this->contact->misc; ?>
                </h4>
        <?php endif; ?>
    </div>  
     
    
    <div class="col-md-12 mn-contact-address">
        <?php echo $this->loadTemplate('address'); ?>
	</div>
    

	<?php if ($this->params->get('show_email_form') && ($this->contact->email_to || $this->contact->user_id)) : ?>
        <div class="col-md-6 mn-contact-form">
            <?php  echo $this->loadTemplate('form');  ?>
        </div> 
	<?php endif; ?>


	<?php if ($this->contact->image && $this->params->get('show_image')) : ?>
		<div class="col-md-6 mn-contact-img">
			<?php echo JHtml::_('image', $this->contact->image, JText::_('COM_CONTACT_IMAGE_DETAILS'), array('align' => 'middle', 'itemprop' => 'image')); ?>
		</div>
	<?php endif; ?>
    
</div>
