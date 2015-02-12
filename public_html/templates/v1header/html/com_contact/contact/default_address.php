<?php
/**
 * @package     Joomla.Site
 * @subpackage  com_contact
 *
 * @copyright   Copyright (C) 2005 - 2013 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

/**
 * marker_class: Class based on the selection of text, none, or icons
 */
?>
<div class="contact-address" itemprop="address" itemscope itemtype="http://schema.org/PostalAddress">
<div class="col-md-6">
	<?php if (($this->params->get('address_check') > 0) &&
		($this->contact->address || $this->contact->suburb  || $this->contact->state || $this->contact->country || $this->contact->postcode)) : ?>

		<?php if ($this->contact->address && $this->params->get('show_street_address')) : ?>
        <div class="mn-contact-address-list">
            <span class="mn-contact-ico">
                <i class="fa fa-map-marker"></i>
            </span>    
            <span class="contact-street" itemprop="streetAddress">
                <?php echo $this->contact->address .'<br/>'; ?>
            </span>
        </div>    
		<?php endif; ?>

		<?php if ($this->contact->suburb && $this->params->get('show_suburb')) : ?>
         <div class="mn-contact-address-list">

                <span class="mn-contact-ico">
                    <i class="fa fa-map-marker"></i>
                </span>    
				<span class="contact-suburb" itemprop="addressLocality">
					<?php echo $this->contact->suburb .'<br/>'; ?>
				</span>
         </div>
        
		<?php endif; ?>
        
		<?php if ($this->contact->state && $this->params->get('show_state')) : ?>
         <div class="mn-contact-address-list">
                <span class="mn-contact-ico">
                    <i class="fa fa-map-marker"></i>
                </span>    
				<span class="contact-state" itemprop="addressRegion">
					<?php echo $this->contact->state . '<br/>'; ?>
				</span>
        </div>        
		<?php endif; ?>
		<?php if ($this->contact->postcode && $this->params->get('show_postcode')) : ?>
        	<div class="mn-contact-address-list">
                <span class="mn-contact-ico">
                    <i class="fa fa-map-marker"></i>
                </span>    
				<span class="contact-postcode" itemprop="postalCode">
					<?php echo $this->contact->postcode .'<br/>'; ?>
				</span>
            </div>    
		<?php endif; ?>
        
		<?php if ($this->contact->country && $this->params->get('show_country')) : ?>
        	<div class="mn-contact-address-list">
                <span class="mn-contact-ico">
                    <i class="fa fa-map-marker"></i>
                </span>    
                <span class="contact-country" itemprop="addressCountry">
                    <?php echo $this->contact->country .'<br/>'; ?>
                </span>
        	</div>
		<?php endif; ?>
        
	<?php endif; ?>
</div>  

  
<div class="col-md-6">
	<?php if ($this->contact->email_to && $this->params->get('show_email')) : ?>
        <div class="mn-contact-address-list">
            <span class="mn-contact-ico">
            	<i class="fa fa-envelope"></i>
            </span>    
            
            <span class="contact-emailto">
				<?php echo $this->contact->email_to; ?>
            </span>
        </div>
    <?php endif; ?>
    
    <?php if ($this->contact->telephone && $this->params->get('show_telephone')) : ?>
        <div class="mn-contact-address-list">
            <span class="mn-contact-ico">
            	<i class="fa fa-phone"></i>
            </span> 
               
            <span class="contact-telephone" itemprop="telephone">
                <?php echo nl2br($this->contact->telephone); ?>
            </span>
            
        </div>
    <?php endif; ?>
    
    <?php if ($this->contact->fax && $this->params->get('show_fax')) : ?>
        <div class="mn-contact-address-list">
            <span class="mn-contact-ico">
            	<i class="fa fa-phone"></i>
            </span>
                
            <span class="contact-fax" itemprop="faxNumber">
            <?php echo nl2br($this->contact->fax); ?>
            </span>
            
        </div>
    <?php endif; ?>
    
    <?php if ($this->contact->mobile && $this->params->get('show_mobile')) :?>
        <div class="mn-contact-address-list">
            <span class="mn-contact-ico">
            	<i class="fa fa-mobile-phone"></i>
            </span>
                
            <span class="contact-mobile" itemprop="telephone">
                <?php echo nl2br($this->contact->mobile); ?>
            </span>
            
        </div>
    <?php endif; ?>
    
    <?php if ($this->contact->webpage && $this->params->get('show_webpage')) : ?>
        <div class="mn-contact-address-list">
            <span class="mn-contact-ico">
            	<i class="fa fa-link"></i>
            </span>  
              
            <span class="contact-webpage">
                <a href="<?php echo $this->contact->webpage; ?>" target="_blank" itemprop="url">
                <?php echo $this->contact->webpage; ?></a>
            </span>
            
        </div>
        
    <?php endif; ?>
    </div>
</div>
