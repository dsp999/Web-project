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

$db = JFactory::getDBO();
$editor = JFactory::getEditor();
$document = JFactory::getDocument();

JHTML::_('behavior.calendar');
JHTML::_('behavior.framework');

$js = "window.addEvent('domready', function() {
        isUpdatingR1 = false;
        isUpdatingR2 = false;
        isUpdatingR3 = false;
        isUpdatingR4 = false;
        
        $('company_id').addEvent('change',function(e) {
            e.stop();
            
            oFormObject = document.forms['company_form'];
            oFormObject.elements['filter_value'].value = $('company_id').value;

            if (!isUpdatingR1 && !isUpdatingR2 && !isUpdatingR3 && !isUpdatingR4) {

                r1 = null;
                isUpdatingR1 = true;
                oFormObject.elements['filter_for'].value = 'category';
                var r1 = new Request.HTML({
                  url: 'index.php',
                  onComplete: function(responseTree, responseElements, responseHTML) {
                        $('category_update').set('html',responseHTML); 
                        isUpdatingR1 = false; 
                        
                        r2 = null;
                        isUpdatingR2 = true;
                        oFormObject.elements['filter_for'].value = 'department';
                        var r2 = new Request.HTML({
                          url: 'index.php',
                          onComplete: function(responseTree, responseElements, responseHTML) { 
                                $('department_update').set('html',responseHTML); 
                                isUpdatingR2 = false; 
                                  
                                r3 = null;
                                isUpdatingR3 = true;
                                oFormObject.elements['filter_for'].value = 'shift';
                                var r3 = new Request.HTML({
                                  url: 'index.php',
                                  onComplete: function(responseTree, responseElements, responseHTML) { 
                                        $('shift_update').set('html',responseHTML); 
                                        isUpdatingR3 = false; 
                                        
                                        r4 = null;
                                        isUpdatingR4 = true;
                                        oFormObject.elements['filter_for'].value = 'jobtype';
                                        var r4 = new Request.HTML({
                                        url: 'index.php',
                                        onComplete: function(responseTree, responseElements, responseHTML) { 
                                              $('jobtype_update').set('html',responseHTML); 
                                              isUpdatingR4 = false; 
                                          }
                                        }).post($('company_form'));
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

if (isset($this->lists['link']))
    echo "<html><head></head>".$this->lists['link']."<body>";

if (isset($this->lists['css']))
    echo "<style>".$this->lists['css']."</style>";
?>

<form action="index.php" method="post" name="adminForm" id="adminForm" >
    <div class="col100">
        <fieldset class="adminform">
            <legend><?php echo JTEXT::_('COM_JOBGROKLIST_VIEWS_JOB_TMPL_DEFAULT_DETAILS'); ?></legend>
            <table class="admintable">
                <tr>
                    <td valign="top" width="100" align="right" class="key">
                        <label for="job_code">
                            <?php echo JTEXT::_('COM_JOBGROKLIST_VIEWS_JOB_TMPL_DEFAULT_JOB_CODE'); ?>:
                        </label>
                    </td>
                    <td >
                        <?php if (isset($this->job->job_code)) : ?>
                        <input class="text_area" type="text" name="job_code" id="job_code" size="32" maxlength="250" <?php if ($this->autoJobCode) echo "disabled='disabled'" ?> value="<?php if (isset($this->job->job_code)) echo $this->job->job_code; ?>" />
                        <?php else : ?>
                        <input class="text_area" type="text" name="job_code" id="job_code" size="32" maxlength="250" <?php if ($this->autoJobCode) echo "disabled='disabled'" ?> value="" />
                        <?php endif; ?>
                        <?php if ($this->autoJobCode) : ?>
                        <br/><br/><span style="color: silver"><?php echo JTEXT::_('COM_JOBGROKLIST_VIEWS_JOB_TMPL_DEFAULT_AUTO_GENERATED'); ?></span>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php if ($this->autoJobCode && !isset($this->job->create_date)) : ?>
                <tr>
                    <td width="100" align="right" class="key">
                        <label for="create_date">
                            <?php echo JTEXT::_('COM_JOBGROKLIST_VIEWS_JOB_TMPL_DEFAULT_CREATE_DATE'); ?>:
                        </label>
                    </td>
                    <td>
                        <?php
                        if (isset($this->job->create_date) && $this->job->create_date != "0000-00-00 00:00:00")
                            echo JHTML::calendar($this->job->create_date,'create_date','create_date');
                        else
                            echo JHTML::calendar('','create_date','create_date');
                        ?>
                        <br/><br/><span style="color: silver"><?php echo JTEXT::_('COM_JOBGROKLIST_VIEWS_JOB_TMPL_DEFAULT_AUTO_GENERATED_REQUIRES_CREATE_DATE'); ?></span>
                    </td>
                </tr>
                <?php endif; ?>
                <tr>
                    <td width="100" align="right" class="key">
                        <label for="jobtitle">
                            <?php echo JTEXT::_('COM_JOBGROKLIST_VIEWS_JOB_TMPL_DEFAULT_TITLE'); ?>:
                        </label>
                    </td>
                    <td>
                        <input class="text_area" type="text" name="title" id="title" size="32" maxlength="250" value="<?php if (isset($this->job->title)) echo $this->job->title;?>" />
                    </td>
                </tr>
                <tr>
                    <td width="100" align="right" class="key">
                        <label for="alias">
                            <?php echo JTEXT::_('COM_JOBGROKLIST_VIEWS_JOB_TMPL_DEFAULT_ALIAS'); ?>:
                        </label>
                    </td>
                    <td>
                        <input class="text_area" type="text" name="alias" id="alias" size="32" maxlength="250" value="<?php if (isset($this->job->alias)) echo $this->job->alias;?>" />
                    </td>
                </tr>                
                <tr>
                    <td width="100" align="right" class="key">
                        <label for="company_id">
                            <?php echo JTEXT::_('COM_JOBGROKLIST_VIEWS_JOB_TMPL_DEFAULT_COMPANY'); ?>:
                        </label>
                    </td>
                    <td>
                        <?php echo $this->lists['company']; ?>
                    </td>
                </tr>
                <tr>
                    <td width="100" align="right" class="key">
                        <label for="category_id">
                            <?php echo JTEXT::_('COM_JOBGROKLIST_VIEWS_JOB_TMPL_DEFAULT_CATEGORY'); ?>:
                        </label>
                    </td>
                    <td>
                        <span id="category_update"><?php echo $this->lists['category']; ?></span>
                    </td>
                </tr>
                <tr>
                    <td width="100" align="right" class="key">
                        <label for="department_id">
                            <?php echo JTEXT::_('COM_JOBGROKLIST_VIEWS_JOB_TMPL_DEFAULT_DEPARTMENT'); ?>:
                        </label>
                    </td>
                    <td>
                        <span id="department_update"><?php echo $this->lists['department']; ?></span>
                    </td>
                </tr>
                <tr>
                    <td width="100" align="right" class="key">
                        <label for="shift_id">
                            <?php echo JTEXT::_('COM_JOBGROKLIST_VIEWS_JOB_TMPL_DEFAULT_SHIFT'); ?>:
                        </label>
                    </td>
                    <td>
                        <span id="shift_update"><?php echo $this->lists['shift']; ?></span>
                    </td>
                </tr>
                <tr>
                    <td width="100" align="right" class="key">
                        <label for="jobtype_id">
                            <?php echo JTEXT::_('COM_JOBGROKLIST_VIEWS_JOB_TMPL_DEFAULT_JOB_TYPE'); ?>:
                        </label>
                    </td>
                    <td>
                        <span id="jobtype_update"><?php echo $this->lists['jobtype']; ?></span>
                    </td>
                </tr>
                <tr>
                    <td width="100" align="right" class="key">
                        <label for="education_id">
                            <?php echo JTEXT::_('COM_JOBGROKLIST_VIEWS_JOB_TMPL_DEFAULT_EDUCATION'); ?>:
                        </label>
                    </td>
                    <td>
                        <?php echo $this->lists['education']; ?>
                    </td>
                </tr>
                <tr>
                    <td width="100" align="right" class="key">
                        <label for="pay_rate">
                            <?php echo JTEXT::_('COM_JOBGROKLIST_VIEWS_JOB_TMPL_DEFAULT_PAY_RATE'); ?>:
                        </label>
                    </td>
                    <td>
                        <input class="text_area" type="text" name="pay_rate" id="pay_rate" size="32" maxlength="250" value="<?php if (isset($this->job->pay_rate)) echo $this->job->pay_rate;?>" />
                    </td>
                </tr>
                <tr>
                    <td width="100" align="right" class="key">
                        <label for="hide_payrate">
                            <?php echo JTEXT::_('COM_JOBGROKLIST_VIEWS_JOB_TMPL_DEFAULT_HIDE_PAY_RATE'); ?>:
                        </label>
                    </td>
                    <td width="100" align="left" class="key">
                        <fieldset style="display: inline;" class="radio" />
                        <?php
                        if (isset($this->job->hide_payrate))
                            echo JHTML::_('select.booleanlist', 'hide_payrate', 'class="inputbox"', $this->job->hide_payrate);
                        else
                            echo JHTML::_('select.booleanlist', 'hide_payrate', 'class="inputbox"', '');
                        ?>
                        </fieldset>
                    </td>
                </tr>
                <tr>
                    <td width="100" align="right" class="key">
                        <label for="payrange_id">
                            <?php echo JTEXT::_('COM_JOBGROKLIST_VIEWS_JOB_TMPL_DEFAULT_PAYRANGE'); ?>:
                        </label>
                    </td>
                    <td>
                        <?php echo $this->lists['payrange']; ?>
                    </td>
                </tr>
                <tr>
                    <td width="100" align="right" class="key">
                        <label for="duration">
                            <?php echo JTEXT::_('COM_JOBGROKLIST_VIEWS_JOB_TMPL_DEFAULT_DURATION'); ?>:
                        </label>
                    </td>
                    <td>
                        <input class="text_area" type="text" name="duration" id="duration" size="32" maxlength="250" value="<?php if (isset($this->job->duration)) echo $this->job->duration;?>" />
                    </td>
                </tr>
                <tr>
                    <td width="100" align="right" class="key">
                        <label for="travel">
                            <?php echo JTEXT::_('COM_JOBGROKLIST_VIEWS_JOB_TMPL_DEFAULT_TRAVEL'); ?>:
                        </label>
                    </td>
                    <td>
                        <input class="text_area" type="text" name="travel" id="travel" size="32" maxlength="250" value="<?php if (isset($this->job->travel)) echo $this->job->travel;?>" />
                    </td>
                </tr>
                <tr>
                    <td width="100" align="right" valign="top" class="key">
                        <label for="job_description">
                            <?php echo JTEXT::_('COM_JOBGROKLIST_VIEWS_JOB_TMPL_DEFAULT_JOB_DESCRIPTION'); ?>:
                        </label>
                    </td>
                    <td>
                        <?php
                        if (isset($this->job->job_description))
                            echo $editor->display('job_description', $this->job->job_description, '100%', '250', '40', '10');
                        else
                            echo $editor->display('job_description', '', '100%', '250', '40', '10');
                        ?>
                    </td>
                </tr>
                <tr>
                    <td width="100" align="right" valign="top" class="key">
                        <label for="preferred_skills">
                            <?php echo JTEXT::_('COM_JOBGROKLIST_VIEWS_JOB_TMPL_DEFAULT_PREFERRED_SKILLS'); ?>:
                        </label>
                    </td>
                    <td>
                        <?php
                        if (isset($this->job->preferred_skills))
                            echo $editor->display('preferred_skills', $this->job->preferred_skills, '100%', '250', '40', '10');
                        else
                            echo $editor->display('preferred_skills', '', '100%', '250', '40', '10');
                        ?>
                    </td>
                </tr>
            </table>
        </fieldset>
    </div>

    <div class="clr"></div>

    <input type="hidden" name="option" value="com_jobgroklist" />
    <input type="hidden" name="id" value="<?php if (isset($this->job->id)) echo $this->job->id; ?>" />
    <input type="hidden" name="task" value="" />
    <input type="hidden" name="controller" value="job" />
    <?php echo JHTML::_( 'form.token'); ?>
</form>
<form id="company_form" name="company_form" method="post" action="<?php
      echo JRoute::_('index.php'); ?>">
    <input name="option" type="hidden" value="com_jobgroklist" />
    <input name="controller" type="hidden" value="job" />
    <input name="format" type="hidden" value="raw" />
    <input name="view" type="hidden" value="job" />
    <input id="filter_for" name="filter_for" type="hidden" value="" />
    <input id="filter_value" name="filter_value" type="hidden" value="" />
    <input id="filter_on" name="filter_on" type="hidden" value="company" />
    <input id="filter_select" name="filter_select" type="hidden" value="" />
    <?php echo JHTML::_( 'form.token'); ?>
</form> 
<?php echo "<table width='100%'><tbody><tr><td style='padding-top: 11px; text-align: right; vertical-align: middle;'><a href='http://www.tk-tek.com'><img style='vertical-align: middle;' src='components/com_jobgroklist/assets/images/tk_logo_bar_h16.png' alt='TK Tek, LLC'></a>&nbsp;<img style='vertical-align: middle;' src='components/com_jobgroklist/assets/images/jg_listing_h16.png'>&nbsp;<span style='font-size: 10px;'>JobGrok Listing Version 3.1-1.2.57 | Copyright 2008 - 2014 by <a href='http://www.tk-tek.com'>TK Tek, LLC</a> | License: <a href='http://www.gnu.org/copyleft/gpl.html'>GNU General Public License</a></td></tr></tbody></table>"; ?>
<?php
if (isset($this->lists['css']))
    echo "</body></html>";
?> 