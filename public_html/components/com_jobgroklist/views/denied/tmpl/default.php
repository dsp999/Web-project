<?php

/**
 *
 *
 * This is the default.php view layout for jobgroklist
 *
 * Created: June 13, 2014, 1:18 am
 *
 * Subversion Details
 * $Date: 2014-04-20 21:33:51 -0500 (Sun, 20 Apr 2014) $
 * $Revision: 5975 $
 * $Author: bobsteen $
 *
 * @author TK Tek, LLC. info@jobgrok.com
 * @version 3.1-1.2.57
 * @package com_jobgroklist
 *
 * @copyright Copyright {c} 2008-2014
 * @license GNU Public License Version 2
 *
 * This file is part of JobGrok.
 *
 * JobGrok is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 2 of the License, or
 * (at your option) any later version.
 *
 * JobGrok is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with JobGrok.  If not, see <http://www.gnu.org/licenses/>.
 *
 */

defined('_JEXEC') or die('Restricted access'); 

?>

<h3><?php echo JTEXT::_('COM_JOBGROKLIST_VIEWS_DENIED_TMPL_DEFAULT_USER_DENIED_HEADER'); ?></h3>
<p><?php echo JTEXT::_('COM_JOBGROKLIST_VIEWS_DENIED_TMPL_DEFAULT_USER_DENIED'); ?></p>
<?php
    echo '<div>';
    $use_link =$this->params->get('registration_link','0');
    $menu_item = $this->params->get('registration_menu','');
    $link_text = $this->params->get('registration_text',JTEXT::_('COM_JOBGROKLIST_VIEWS_DENIED_TMPL_DEFAULT_TO_REGISTRATION_FORM'));
    
    if ($menu_item != '' && $use_link != '0') {
        $link = JRoute::_('index.php?Itemid='.$menu_item);
        $registration_notice = "<a href='".$link."'>".$link_text."</a>";
        echo "<p>".$registration_notice."</p>";
    }
    echo '</div>';
?>