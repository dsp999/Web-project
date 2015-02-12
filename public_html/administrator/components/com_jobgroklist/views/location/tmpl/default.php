<?php
/**
 *
 *
 * This is the default.php view layout for jobgroklist
 *
 * Created: June 13, 2014, 1:18 am
 *
 * Subversion Details
 * $Date: 2012-08-14 20:50:52 -0500 (Tue, 14 Aug 2012) $
 * $Revision: 4276 $
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

defined('_JEXEC') or die('Restricted access'); ?>

<?php
if (isset($this->lists['link']))
    echo "<html><head></head>".$this->lists['link']."<body>";

if (isset($this->lists['css']))
    echo "<style>".$this->lists['css']."</style>";
?>

<form action="index.php" method="post" name="adminForm" id="adminForm" >
    <div class="col100">
        <fieldset class="adminform">
            <legend><?php echo JTEXT::_('COM_JOBGROKLIST_VIEWS_LOCATION_TMPL_DEFAULT_DETAILS'); ?></legend>
            <table class="admintable">
                <tr>
                    <td width="100" align="right" class="key">
                        <label for="code">
                            <?php echo JTEXT::_('COM_JOBGROKLIST_VIEWS_LOCATION_TMPL_DEFAULT_COUNTRY'); ?>:
                        </label>
                    </td>
                    <td>
                        <?php echo $this->lists['country_static']; ?>
                    </td>
                </tr>
                <tr>
                    <td width="100" align="right" class="key">
                        <label for="location">
                            <?php echo JTEXT::_('COM_JOBGROKLIST_VIEWS_LOCATION_TMPL_DEFAULT_LOCATION'); ?>:
                        </label>
                    </td>
                    <td>
                        <input class="text_area" type="text" name="location" id="location" size="32" maxlength="250" value="<?php if (isset($this->location->location)) echo $this->location->location;?>" />
                    </td>
                </tr>
                <!--
         <tr>
             <td width="100" align="right" class="key">
                 <label for="use_location">
                <?php echo JTEXT::_('COM_JOBGROKLIST_VIEWS_LOCATION_TMPL_DEFAULT_USE_LOCATION'); ?>:
                 </label>
             </td>
             <td>
                <?php
                if (isset($this->location->use_location))
                    echo JHTML::_('select.booleanlist', 'use_location', 'class="inputbox"', $this->location->use_location);
                else
                    echo JHTML::_('select.booleanlist', 'use_location', 'class="inputbox"', '');
                ?>
             </td>
         </tr>
		 -->
                <tr>
                    <td width="100" align="right" class="key">
                        <label for="loc_description">
                            <?php echo JTEXT::_('COM_JOBGROKLIST_VIEWS_LOCATION_TMPL_DEFAULT_LOC_DESCRIPTION'); ?>:
                        </label>
                    </td>
                    <td>
                        <input class="text_area" type="text" name="loc_description" id="loc_description" size="32" maxlength="250" value="<?php if (isset($this->location->loc_description)) echo $this->location->loc_description;?>" />
                    </td>
                </tr>
                <tr>
                    <td width="100" align="right" class="key">
                        <label for="loc_address">
                            <?php echo JTEXT::_('COM_JOBGROKLIST_VIEWS_LOCATION_TMPL_DEFAULT_LOC_ADDRESS'); ?>:
                        </label>
                    </td>
                    <td>
                        <input class="text_area" type="text" name="loc_address" id="loc_address" size="32" maxlength="250" value="<?php if (isset($this->location->loc_address)) echo $this->location->loc_address;?>" />
                    </td>
                </tr>
                <tr>
                    <td width="100" align="right" class="key">
                        <label for="company">
                            <?php echo JTEXT::_('COM_JOBGROKLIST_VIEWS_LOCATION_TMPL_DEFAULT_COMPANY'); ?>:
                        </label>
                    </td>
                    <td>
                        <?php echo $this->lists['company']; ?>
                    </td>
                </tr>
            </table>
        </fieldset>
    </div>

    <div class="clr"></div>

    <?php
    echo (isset($this->lists['submit'])?$this->lists['submit']:'');
    echo (isset($this->lists['format'])?$this->lists['format']:'');
    echo (isset($this->lists['view'])?$this->lists['view']:'');
    ?>

    <input type="hidden" name="option" value="com_jobgroklist" />
    <input type="hidden" name="id" value="<?php if (isset($this->location->id)) echo $this->location->id; ?>" />
    <input type="hidden" name="task" value="<?php echo (isset($this->lists['submit'])?'save':''); ?>" />
    <input type="hidden" name="controller" value="location" />
    <?php echo JHTML::_( 'form.token'); ?>
</form>
<?php echo "<table width='100%'><tbody><tr><td style='padding-top: 11px; text-align: right; vertical-align: middle;'><a href='http://www.tk-tek.com'><img style='vertical-align: middle;' src='components/com_jobgroklist/assets/images/tk_logo_bar_h16.png' alt='TK Tek, LLC'></a>&nbsp;<img style='vertical-align: middle;' src='components/com_jobgroklist/assets/images/jg_listing_h16.png'>&nbsp;<span style='font-size: 10px;'>JobGrok Listing Version 3.1-1.2.57 | Copyright 2008 - 2014 by <a href='http://www.tk-tek.com'>TK Tek, LLC</a> | License: <a href='http://www.gnu.org/copyleft/gpl.html'>GNU General Public License</a></td></tr></tbody></table>"; ?>
<?php
if (isset($this->lists['css']))
    echo "</body></html>";
?> 