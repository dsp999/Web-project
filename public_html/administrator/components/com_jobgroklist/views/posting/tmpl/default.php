<?php
/**
 *
 *
 * This is the default.php view layout for jobgroklist
 *
 * Created: June 13, 2014, 1:18 am
 *
 * Subversion Details
 * $Date: 2014-05-07 20:15:44 -0500 (Wed, 07 May 2014) $
 * $Revision: 6063 $
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
jimport('joomla.html.pane');

$db = JFactory::getDBO();
$editor = JFactory::getEditor();
$document = JFactory::getDocument();

JHTML::_('behavior.calendar');
JHTML::_('behavior.framework');

$js = "window.addEvent('domready', function() {			
        isUpdatingR1 = false;
        isUpdatingR2 = false;
        isUpdatingR3 = false;


        $('company_id').addEvent('change',function(e) {
            e.stop();

            oFormObject = document.forms['company_form'];
            oFormObject.elements['filter_value'].value = $('company_id').value;

            if (!isUpdatingR1 && !isUpdatingR2 && !isUpdatingR3) {
            
                r1 = null;
                isUpdatingR1 = true;
                oFormObject.elements['filter_for'].value = 'job';
                var r1 = new Request.HTML({
                  url: 'index.php',
                  onComplete: function(responseTree, responseElements, responseHTML) {
                        $('job_update').set('html',responseHTML); 
                        isUpdatingR1 = false; 
                        
                        r2 = null;
                        isUpdatingR2 = true;
                        oFormObject.elements['filter_for'].value = 'contact';
                        var r2 = new Request.HTML({
                          url: 'index.php',
                          onComplete: function(responseTree, responseElements, responseHTML) { 
                                $('contact_update').set('html',responseHTML); 
                                isUpdatingR2 = false; 
                                  
                                r3 = null;
                                isUpdatingR3 = true;
                                oFormObject.elements['filter_for'].value = 'location';
                                var r3 = new Request.HTML({
                                  url: 'index.php',
                                  onComplete: function(responseTree, responseElements, responseHTML) { 
                                        $('location_update').set('html',responseHTML); 
                                        isUpdatingR3 = false; 
                                  }
                                }).post($('company_form'));
                          }
                        }).post($('company_form'));
                  }
                }).post($('company_form'));
            }
         })       
    });";

$document->addScriptDeclaration($js);

$css = "
fieldset.adminform .jg_bool label, fieldset.adminform .jg_bool input { float:none; display: inline; }
.pane-slider label.hasTip { width: 50%; display: inline-block; padding-left: 4px; padding-top: 2px; padding-bottom: 2px; }
.pane-slider label#paramspre_article-lbl, .pane-slider label#paramspost_article-lbl { float: left; }
";

$document->addStyleDeclaration($css);

?>
<form action="index.php" method="post" name="adminForm" id="adminForm" >
    <table border="0" width="100%">
        <tr>
            <td valign="top">

                <div class="col100">
                    <fieldset class="adminform">
                        <legend><?php echo JTEXT::_('COM_JOBGROKLIST_VIEWS_POSTING_TMPL_DEFAULT_DETAILS'); ?></legend>
                        <table class="admintable">
                            <tr>
                                <td width="100" align="right" class="key">
                                    <label for="published">
                                        <?php echo JTEXT::_('COM_JOBGROKLIST_VIEWS_POSTING_TMPL_DEFAULT_PUBLISHED'); ?>
                                    </label>
                                </td>
                                <td class="jg_bool">
                                    <?php echo $this->options['published']; ?>
                                </td>
                            </tr>
                            <tr>
                                <td width="100" align="right" class="key">
                                    <label for="viewlevel">
                                        <?php echo JTEXT::_('COM_JOBGROKLIST_VIEWS_POSTING_TMPL_DEFAULT_VIEWLEVEL'); ?>
                                    </label>
                                </td>
                                <td class="jg_bool">
                                    <?php echo $this->options['viewlevel']; ?>
                                </td>
                            </tr>
                            <tr>
                                <td width="100" align="right" class="key">
                                    <label for="company_id">
                                        <?php echo JTEXT::_('COM_JOBGROKLIST_VIEWS_POSTING_TMPL_DEFAULT_COMPANY'); ?>
                                    </label>
                                </td>
                                <td>
                                    <?php echo $this->lists['company']; ?>
                                </td>
                            </tr>
                            <tr>
                                <td width="100" align="right" class="key">
                                    <label for="job_id">
                                        <?php echo JTEXT::_('COM_JOBGROKLIST_VIEWS_POSTING_TMPL_DEFAULT_JOB_TITLE'); ?>:
                                    </label>
                                </td>
                                <td>
                                    <span id="job_update"><?php echo $this->lists['job']; ?></span>
                                </td>
                            </tr>
                            <tr>
                                <td width="100" align="right" class="key">
                                    <label for="location_id">
                                        <?php echo JTEXT::_('COM_JOBGROKLIST_VIEWS_POSTING_TMPL_DEFAULT_LOCATION'); ?>
                                    </label>
                                </td>
                                <td>
                                    <span id="location_update"><?php echo $this->lists['location']; ?></span>
                                </td>
                            </tr>
                            <tr>
                                <td width="100" align="right" valign="top" class="key">
                                    <label for="summary">
                                        <?php echo JTEXT::_('COM_JOBGROKLIST_VIEWS_POSTING_TMPL_DEFAULT_SUMMARY'); ?>:
                                    </label>
                                </td>
                                <td>
                                    <input class="text_area" type="text" name="summary" id="summary" size="32" maxlength="250" value="<?php if (isset($this->posting->summary)) echo $this->posting->summary;?>" />
                                </td>
                            </tr>
                            <tr>
                                <td width="100" align="right" class="key">
                                    <label for="posting_date">
                                        <?php echo JTEXT::_('COM_JOBGROKLIST_VIEWS_POSTING_TMPL_DEFAULT_POSTING_DATE'); ?>:
                                    </label>
                                </td>
                                <td>
                                    <?php
                                    if (isset($this->posting->posting_date) && $this->posting->posting_date != "0000-00-00 00:00:00")
                                        echo JHTML::calendar($this->posting->posting_date,'posting_date','posting_date');
                                    else
                                        echo JHTML::calendar('','posting_date','posting_date');
                                    ?>
                                </td>
                            </tr>
                            <tr>
                                <td width="100" align="right" class="key">
                                    <label for="closing_date">
                                        <?php echo JTEXT::_('COM_JOBGROKLIST_VIEWS_POSTING_TMPL_DEFAULT_CLOSING_DATE'); ?>:
                                    </label>
                                </td>
                                <td>
                                    <?php
                                    if ( isset($this->posting->closing_date) && $this->posting->closing_date != "0000-00-00 00:00:00")
                                        echo JHTML::calendar($this->posting->closing_date,'closing_date','closing_date');
                                    else
                                        echo JHTML::calendar('','closing_date','closing_date');
                                    ?>
                                </td>
                            </tr>
                            <tr>
                                <td width="100" align="right" class="key">
                                    <label for="closing_days">
                                        <?php echo JTEXT::_('COM_JOBGROKLIST_VIEWS_POSTING_TMPL_DEFAULT_CLOSING_DAYS'); ?>:
                                    </label>
                                </td>
                                <td>
                                    <input class="text_area" type="text" name="closing_days" id="closing_days" size="32" value="<?php if (isset($this->posting->closing_days)) echo $this->posting->closing_days; else echo $this->cparams->get('default_days_to_close','0'); ?>" />
                                </td>
                            </tr>
                            <tr>
                                <td width="100" align="right" class="key">
                                    <label for="job_id">
                                        <?php echo JTEXT::_('COM_JOBGROKLIST_VIEWS_POSTING_TMPL_DEFAULT_CONTACT'); ?>:
                                    </label>
                                </td>
                                <td>
                                    <span id="contact_update"><?php echo $this->lists['contact']; ?></span>
                                </td>
                            </tr>

                            <tr>
                                <td width="100" align="right" class="key">
                                    <label for="link_text">
                                        <?php echo JTEXT::_('COM_JOBGROKLIST_VIEWS_POSTING_TMPL_DEFAULT_APPLICATION_ALT_LINK_TEXT'); ?>:
                                    </label>
                                </td>
                                <td>
                                    <input class="text_area" type="text" name="link_text" id="link_text" size="32" maxlength="250" value="<?php if (isset($this->posting->link_text)) echo $this->posting->link_text;?>" />
                                </td>
                            </tr>
                            <tr>
                                <td width="100" align="right" class="key">
                                    <label for="link">
                                        <?php echo JTEXT::_('COM_JOBGROKLIST_VIEWS_POSTING_TMPL_DEFAULT_APPLICATION_ALT_LINK'); ?>:
                                    </label>
                                </td>
                                <td>
                                    <input class="text_area" type="text" name="link" id="link" size="32" maxlength="250" value="<?php if (isset($this->posting->link)) echo $this->posting->link;?>" />
                                    <br /><br/><span style="font-size:9px; color:silver;"><?php echo JTEXT::_('COM_JOBGROKLIST_VIEWS_POSTING_TMPL_DEFAULT_ALTERNATE_ALT_LINK_TEXT_INSTRUCTION'); ?></span>
                                </td>
                            </tr>
                        </table>
                    </fieldset>
                </div>

                <div class="clr"></div>

                <input type="hidden" name="option" value="com_jobgroklist" />
                <input type="hidden" name="id" value="<?php if (isset($this->posting->id)) echo $this->posting->id; ?>" />
                <input type="hidden" name="task" value="" />
                <input type="hidden" name="controller" value="posting" />
                <?php echo JHTML::_( 'form.token'); ?>

            </td>
            <td valign="top" style="width: 25%; min-width: 175px;">

<!-- normal fieldsets -->
<div class="width-300 fltlft">
    <?php
echo JHtml::_('sliders.start', 'tab_group_id');    // Iterate through the normal form fieldsets and display each one.
    foreach ($this->params->getFieldsets('params') as $fieldsets => $fieldset): ?>
<?php $jtext = JTEXT::_('COM_JOBGROKLIST_MODELS_POSTING_XML_'.strtoupper($fieldset->name)); ?>
    <?php echo JHtml::_('sliders.panel',  $jtext, $jtext ); ?>
        <table width="300px">
        <?php
        // Iterate through the fields and display them.
        foreach($this->params->getFieldset($fieldset->name) as $field):
            // If the field is hidden, only use the input.
            if ($field->hidden):
                echo $field->input;
            else:
            ?>
            <tr>
            <td width="150px">
                <?php echo $field->label; ?>
            </td>
            <td<?php echo ($field->type == 'Editor' || $field->type == 'Textarea') ? ' style="clear: both; margin: 0;"' : ''?>>
                <?php echo $field->input; ?>
            </td>
            </tr>
            <?php
            endif;
        endforeach;
        ?>
        </tr></table>
        
    <?php
    
    endforeach;
    
    echo JHtml::_('sliders.end');
    ?>
</div>
            
            </td>
            
        </tr>
    </table>
</form>
<form id="company_form" name="company_form" method="post" action="<?php
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