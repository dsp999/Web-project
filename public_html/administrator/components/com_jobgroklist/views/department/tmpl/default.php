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
            <legend><?php echo JTEXT::_('COM_JOBGROKLIST_VIEWS_DEPARTMENT_TMPL_DEFAULT_DETAILS'); ?></legend>
            <table class="admintable">
                <tr>
                    <td width="100" align="right" class="key">
                        <label for="department">
                            <?php echo JTEXT::_('COM_JOBGROKLIST_VIEWS_DEPARTMENT_TMPL_DEFAULT_DEPARTMENT'); ?>:
                        </label>
                    </td>
                    <td>
                        <input class="text_area" type="text" name="department" id="department" size="32" maxlength="250" value="<?php if (isset($this->department->department)) echo $this->department->department;?>" />
                    </td>
                </tr>
                <tr>
                    <td width="100" align="right" class="key">
                        <label for="company">
                            <?php echo JTEXT::_('COM_JOBGROKLIST_VIEWS_DEPARTMENT_TMPL_DEFAULT_COMPANY'); ?>:
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
    <input type="hidden" name="id" value="<?php if (isset($this->department->id)) echo $this->department->id; ?>" />
    <input type="hidden" name="task" value="<?php echo (isset($this->lists['submit'])?'save':''); ?>" />
    <input type="hidden" name="controller" value="department" />
    <?php echo JHTML::_( 'form.token'); ?>
</form>
<?php echo "<table width='100%'><tbody><tr><td style='padding-top: 11px; text-align: right; vertical-align: middle;'><a href='http://www.tk-tek.com'><img style='vertical-align: middle;' src='components/com_jobgroklist/assets/images/tk_logo_bar_h16.png' alt='TK Tek, LLC'></a>&nbsp;<img style='vertical-align: middle;' src='components/com_jobgroklist/assets/images/jg_listing_h16.png'>&nbsp;<span style='font-size: 10px;'>JobGrok Listing Version 3.1-1.2.57 | Copyright 2008 - 2014 by <a href='http://www.tk-tek.com'>TK Tek, LLC</a> | License: <a href='http://www.gnu.org/copyleft/gpl.html'>GNU General Public License</a></td></tr></tbody></table>"; ?>
<?php
if (isset($this->lists['css']))
    echo "</body></html>";
?>
