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
?>

<div id="j-sidebar-container" class="span2">
	<?php echo $this->sidebar; ?>
</div>
<div id="j-main-container" class="span10">
	<div class="mw-info">

<table cellpadding="4" cellspacing="0" border="0" width="100%">
	
	<tr>
		<td>	
			<h3 style="font-size:16px;"><?php echo JText::_('COM_MINITEKWALL_ABOUT_TITLE'); ?></h3>
			<p style="font-size:14px;">
				<?php echo JText::_('COM_MINITEKWALL_ABOUT_DESC'); ?><br />
			</p>
			<p style="font-size:14px;"><a href="http://www.minitek.gr/">www.minitek.gr </a></p>
		</td>
	</tr>
	<tr>
		<td>		
			<h3 style="font-size:16px;"><?php echo JText::_('COM_MINITEKWALL_VERSION'); ?></h3>
            <?php 
			$xml = JFactory::getXML(JPATH_ADMINISTRATOR .'/components/com_minitekwall/minitekwall.xml');
			$version = (string)$xml->version;
			?>

			<p style="font-size:14px;"><?php echo JText::_('COM_MINITEKWALL_VERSION_MSG').': '.$version; ?></p>
		</td>
	</tr>
	<tr>
		<td>		
			<h3 style="font-size:16px;">Copyright</h3>
			<p style="font-size:14px;">
			© 2011 - 2014 Minitek
			</p>
		</td>
	</tr>
	<tr>
		<td>		
			<h3 style="font-size:16px;">Licence</h3>
			<p style="font-size:14px;">
			<a href="http://www.gnu.org/licenses/gpl-2.0.html" target="_blank">GPLv2</a>
			</p>
		</td>
	</tr>
	
</table>

</div>
</div>
