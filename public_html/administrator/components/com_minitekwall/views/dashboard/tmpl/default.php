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

$user  = JFactory::getUser();
$token = JSession::getFormToken();
?>

<div id="j-sidebar-container" class="span2">
	<?php echo $this->sidebar; ?>
</div>
<div id="j-main-container" class="span6">
	<div class="well mw">
        <!--<div class="module-title nav-header"><?php //echo JText::_('COM_MINITEKWALL_QUICK_ICONS_ADMIN'); ?></div>-->
        <div class="thumbnails">
        	<a class="thumbnail" href="index.php?option=com_minitekwall&view=instances">
                <img alt="<?php echo JText::_('COM_MINITEKWALL_SUBMENU_MODULE_INSTANCES'); ?>" src="components/com_minitekwall/assets/images/dashboard/icon-48-instance.png">
                <br>
                <span><?php echo JText::_('COM_MINITEKWALL_SUBMENU_MODULE_INSTANCES'); ?></span>
            </a>
        </div>
        <div class="thumbnails">
        	<a class="thumbnail" href="index.php?option=com_minitekwall&view=modules">
                <img alt="<?php echo JText::_('COM_MINITEKWALL_SUBMENU_MODULES'); ?>" src="components/com_minitekwall/assets/images/dashboard/icon-48-module.png">
                <br>
                <span><?php echo JText::_('COM_MINITEKWALL_SUBMENU_MODULES'); ?></span>
            </a>
        </div>
        <div class="thumbnails">
        	<a class="thumbnail" href="index.php?option=com_minitekwall&view=about">
                <img alt="<?php echo JText::_('COM_MINITEKWALL_SUBMENU_ABOUT'); ?>" src="components/com_minitekwall/assets/images/dashboard/icon-48-about.png">
                <br>
                <span><?php echo JText::_('COM_MINITEKWALL_SUBMENU_ABOUT'); ?></span>
            </a>
        </div>
        <div class="thumbnails">
        	<a class="thumbnail" href="http://www.minitek.gr/joomla-extensions/joomla/minitek-wall" target="_blank">
                <img alt="<?php echo JText::_('COM_MINITEKWALL_SUBMENU_HELP'); ?>" src="components/com_minitekwall/assets/images/dashboard/icon-48-help.png">
                <br>
                <span><?php echo JText::_('COM_MINITEKWALL_SUBMENU_HELP'); ?></span>
            </a>
        </div>
    </div>
    
    <div class="well" style="text-align: center; position: relative;">
    	<a data-dismiss="alert" class="close" style="position: absolute; top: 28px; right: 28px; z-index: 99;">×</a>
        <iframe width="710" scrolling="no" height="183" frameborder="0" marginheight="0" marginwidth="0" cellspacing="0" border="0" noresize="noresize" src="http://www.minitek.gr/ads/ad.php" style="padding:0;margin:0;border:0">
		</iframe>
        <a href="http://www.minitek.gr/" class="btn btn-primary" style="margin-top: 15px;" target="_blank">Learn more</a>
    </div>
 
</div>
<div class="span4">
    
	<div class="well well-small">
    	<div class="module-title nav-header"><?php echo JText::_('COM_MINITEKWALL_QUICK_ICONS'); ?></div>
        <div class="row-striped">
        
            <?php if ($user->authorise('core.create', 'com_minitekwall')) { ?>
            <div class="row-fluid">
                <div class="span12">
                    <a href="<?php echo JRoute::_('index.php?option=com_minitekwall&task=instance.add'); ?>">
                    <i class="icon-file-add"></i>
                    <span><?php echo JText::_('COM_MINITEKWALL_QUICKICONS_ADD_NEW_MODULE_INSTANCE'); ?></span>
                    </a>
                </div>
            </div>
            <?php } ?>
            <div class="row-fluid">
                <div class="span12">
                    <a href="<?php echo JRoute::_('index.php?option=com_minitekwall&view=instances'); ?>">
                    <i class="icon-pencil-2"></i>
                    <span><?php echo JText::_('COM_MINITEKWALL_QUICKICONS_MODULE_INSTANCE_MANAGER'); ?></span>
                    </a>
                </div>
            </div>  
            <div class="row-fluid">
                <div class="span12">
                    <a href="<?php echo JRoute::_('index.php?option=com_minitekwall&view=about'); ?>">
                    <i class="icon-help"></i>
                    <span><?php echo JText::_('COM_MINITEKWALL_QUICKICONS_ABOUT'); ?></span>
                    </a>
                </div>
            </div>
            <div class="row-fluid">
                <div class="span12">
                    <a href="http://www.minitek.gr/support/documentation/joomla-extensions/minitek-wall" target="_blank">
                    <i class="icon-support"></i>
                    <span><?php echo JText::_('COM_MINITEKWALL_QUICKICONS_HELP'); ?></span>
                    </a>
                </div>
            </div>
            <?php if ($user->authorise('core.admin', 'com_minitekwall')) { ?> 
            <div class="row-fluid">
                <div class="span12">
                    <a href="<?php echo JRoute::_('index.php?option=com_config&view=component&component=com_minitekwall'); ?>">
                    <i class="icon-cog"></i>
                    <span><?php echo JText::_('COM_MINITEKWALL_QUICKICONS_CONFIGURATION'); ?></span>
                    </a>
                </div>
            </div>
            <?php } ?>
            <?php if ($user->authorise('core.manage', 'com_minitekwall')) { ?> 
            <div class="row-fluid">
                <div class="span12">
                    <a href="<?php echo JRoute::_('index.php?option=com_minitekwall&task=purgeImages&'.$token.'=1'); ?>">
                    <i class="icon-remove"></i>
                    <span><?php echo JText::_('COM_MINITEKWALL_QUICKICONS_PURGE_IMAGE_CACHE'); ?></span>
                    </a>
                </div>
            </div>
            <?php } ?>
            
        </div>
    </div>
    
    <div class="alert alert-info well">
    	<div class="row-fluid">
         	<div class="span12" style="padding: 12px 10px; font-size: 14px;">
              	<a href="http://extensions.joomla.org/extensions/search-a-indexing/site-search/27246" target="_blank" target="_blank">
                  	<i class="icon-star"></i>
                    <span><?php echo JText::_('COM_MINITEKWALL_QUICKICONS_REVIEW'); ?></span>
                </a>
            </div>
        </div>
    </div>
    
    <div class="alert alert-success well">
        <a data-dismiss="alert" class="close">×</a>
        <br />
        <?php 
		$xml = JFactory::getXML(JPATH_ADMINISTRATOR .'/components/com_minitekwall/minitekwall.xml');
		$version = (string)$xml->version;
		?>

		<h4 class="alert-heading"><?php echo JText::_('COM_MINITEKWALL_VERSION_MSG').': '.$version; ?></h4>
        <br />
        <a class="btn" title="Check for new version" href="http://www.minitek.gr/joomla-extensions/joomla/minitek-wall" target="_blank">Check for new version</a>
        <br /><br />
    </div>
    
</div>
