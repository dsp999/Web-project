<?php
/**
 *
 *
 * This is the default.php view layout for jobgroklist
 *
 * Created: June 13, 2014, 1:18 am
 *
 * Subversion Details
 * $Date: 2013-11-17 13:48:40 -0600 (Sun, 17 Nov 2013) $
 * $Revision: 5598 $
 * $Author: jobgrok $
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

$document =JFactory::getDocument();

$js = "window.addEvent('domready', function() {			
        isUpdatingR1 = false;

        $('company_id').addEvent('change',function(e) {
            e.stop();

            oFormObject = document.forms['company_form'];
            oFormObject.elements['filter_value'].value = $('company_id').value;

            if (!isUpdatingR1) {
            
                r1 = null;
                isUpdatingR1 = true;
                oFormObject.elements['filter_for'].value = 'contact';
                var r1 = new Request.HTML({
                  url: 'index.php',
                  onComplete: function(responseTree, responseElements, responseHTML) {
                        $('contact_update').set('html',responseHTML); 
                        isUpdatingR1 = false;                         
                  }
                }).post($('company_form'));
            }
         })       
    });";

$document->addScriptDeclaration($js);

if (isset($this->lists['link']))
    echo  '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">'.
        '<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en-gb" lang="en-gb" dir="ltr">'.
        $this->lists['link'].
        '</head>'.
        '<body>'.
        '<style>'.
        $this->lists['css'].
        '</style>';
?>
<form action="index.php" method="post" name="adminForm" id="adminForm" >
    <div class="col100">
        <fieldset class="adminform">
            <legend><?php echo JTEXT::_('COM_JOBGROKLIST_VIEWS_CATEGORY_TMPL_DEFAULT_DETAILS'); ?></legend>
            <table class="admintable">
                <tr>
                    <td width="100" align="right" class="key">
                        <label for="code">
                            <?php echo JTEXT::_('COM_JOBGROKLIST_VIEWS_CATEGORY_TMPL_DEFAULT_CATEGORY'); ?>:
                        </label>
                    </td>
                    <td>
                        <?php echo $this->lists['category_static']; ?>
                    </td>
                </tr>
                <tr>
                    <td width="100" align="right" class="key">
                        <label for="description">
                            <?php echo JTEXT::_('COM_JOBGROKLIST_VIEWS_CATEGORY_TMPL_DEFAULT_DESCRIPTION'); ?>:
                        </label>
                    </td>
                    <td>
                        <input class="text_area" type="text" name="description" id="description" size="32" maxlength="250" value="<?php if (isset($this->category->description)) echo $this->category->description;?>" />
                    </td>
                </tr>
                <tr>
                    <td width="100" align="right" class="key">
                        <label for="use_description">
                            <?php echo JTEXT::_('COM_JOBGROKLIST_VIEWS_CATEGORY_TMPL_DEFAULT_USE_DESCRIPTION'); ?>:
                        </label>
                    </td>
                    <td width="100" align="left" class="key">
                        <fieldset style="display: inline;" class="radio">
                        <?php
                        if (isset($this->category->use_description))
                            echo JHTML::_('select.booleanlist', 'use_description', '', $this->category->use_description);
                        else
                            echo JHTML::_('select.booleanlist', 'use_description', '', '');
                        ?>
                        </fieldset>
                    </td>
                </tr>
                <tr>
                    <td width="100" align="right" class="key">
                        <label for="company">
                            <?php echo JTEXT::_('COM_JOBGROKLIST_VIEWS_CATEGORY_TMPL_DEFAULT_COMPANY'); ?>:
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
    <input type="hidden" name="id" value="<?php if ( isset($this->category->id)) echo $this->category->id; ?>" />
    <input type="hidden" name="task" value="<?php echo (isset($this->lists['submit'])?'save':''); ?>" />
    <input type="hidden" name="controller" value="category" />
    <?php echo JHTML::_( 'form.token'); ?>
</form>
<form id="company_form" method="post" action="<?php
      echo JRoute::_('index.php'); ?>">
    <input name="option" type="hidden" value="com_jobgroklist" />
    <input name="controller" type="hidden" value="posting" />
    <input name="format" type="hidden" value="raw" />
    <input name="view" type="hidden" value="posting" />
    <input name="filter_for" type="hidden" value="" />
    <input name="filter_value" type="hidden" value="" />
    <input name="filter_on" type="hidden" value="" />
    <?php echo JHTML::_( 'form.token'); ?>
</form>
<?php echo "<table width='100%'><tbody><tr><td style='padding-top: 11px; text-align: right; vertical-align: middle;'><a href='http://www.tk-tek.com'><img style='vertical-align: middle;' src='components/com_jobgroklist/assets/images/tk_logo_bar_h16.png' alt='TK Tek, LLC'></a>&nbsp;<img style='vertical-align: middle;' src='components/com_jobgroklist/assets/images/jg_listing_h16.png'>&nbsp;<span style='font-size: 10px;'>JobGrok Listing Version 3.1-1.2.57 | Copyright 2008 - 2014 by <a href='http://www.tk-tek.com'>TK Tek, LLC</a> | License: <a href='http://www.gnu.org/copyleft/gpl.html'>GNU General Public License</a></td></tr></tbody></table>"; ?>
<?php
if (isset($this->lists['css']))
    echo "</body></html>";
?>
