<?php
/** 
 *------------------------------------------------------------------------------
 * @package       Gravity - Joomla Template by Minitek
 *------------------------------------------------------------------------------
 * @copyright     Copyright (C) 2011-2013 Minitek.gr. All Rights Reserved.
 * @license       GNU General Public License version 2 or later; see LICENSE.txt
 * @authors       Minitek (the template is based on the T3_blank template by Joomlart.com)
 * @Framework:    http://t3-framework.org 
 *------------------------------------------------------------------------------
 */
defined( '_JEXEC' ) or die( 'Restricted access' );

if (!isset($this->error)) {
	$this->debug = false;
}
$app = JFactory::getApplication();
//get language and direction
$doc = JFactory::getDocument();
$this->language = $doc->language;
$this->direction = $doc->direction;
?>
			
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo $this->language; ?>" lang="<?php echo $this->language; ?>" dir="<?php echo $this->direction; ?>">

<head>
<title><?php echo $this->error->getCode(); ?>-<?php echo $this->title; ?></title>
<link href='http://fonts.googleapis.com/css?family=Roboto:400,300,700italic' rel='stylesheet' type='text/css'>
<link rel="stylesheet" href="<?php echo $this->baseurl ?>/templates/<?php echo $this->template ?>/css/error.css" type="text/css" />
</head>

<body>

    <div class="error-pg">
        
        <div class="error-cont-top" align="center">
            <div class="logo-cont">
                <div class="logo" align="left">
                    <a href="<?php echo $this->baseurl; ?>/index.php"> 
                        <?php echo htmlspecialchars($app->getCfg('sitename')); ?>
                    </a> 
                </div>
            </div>
            
            <div class="error-box-code"><?php echo $this->error->getCode(); ?></div>
        </div>
        
      	<div class="error-cont-bottom" align="center">
        	<div class="error-cont-inner">
          		<div class="error-box" align="center">
            		<div class="error-box-msg"><?php echo $this->error->getMessage(); ?></div>
            		<div class="error-msg-back"><?php echo JText::_('MN_404_ERROR'); ?></div>
                    <div class="error-box-msg"><?php echo JText::_('MN_404_ERROR_LINK_HEADER'); ?></div>
          			<div class="error-msg-back">
                    	<ul>
                        	<li>
                            	<a href="<?php echo $this->baseurl; ?>/index.php" ><?php echo JText::_('MN_404_ERROR_GO_HOME'); ?></a>
                            	<p><?php echo JText::_('MN_404_ERROR_GO_HOME_MSG'); ?></p>
                            </li>
                        </ul>
                    </div>
                </div>
        	</div>
      	</div>
        
	</div>
    
</body>

</html>
