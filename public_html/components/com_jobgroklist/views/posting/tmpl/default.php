<?php

/**
 *
 *
 * This is the default.php view layout for jobgroklist
 *
 * Created: June 13, 2014, 1:18 am
 *
 * Subversion Details
 * $Date: 2014-04-01 22:04:15 -0500 (Tue, 01 Apr 2014) $
 * $Revision: 5887 $
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

jimport('joomla.utilities.date');

$db = JFactory::getDBO();
$editor = JFactory::getEditor();
$mainframe = JFactory::getApplication();
JHTML::_('behavior.calendar');

$document = JFactory::getDocument();
$css_other = $this->params->get('other_css','');
if ($css_other != '') $document->addStyleDeclaration($css_other);

if (isset($this->posting->posting_date) && $this->posting->posting_date != '0000-00-00 00:00:00')    
    $my_open_date = new JDate($this->posting->posting_date);

if (isset($this->posting->closing_date) && $this->posting->closing_date != '0000-00-00 00:00:00')
    $my_close_date = new JDate($this->posting->closing_date);

/*
$timenow = new JDate();

if ($this->posting->published == 0 || 
    (!($this->posting->posting_date == '0000-00-00 00:00:00') && $my_open_date > $timenow) ||
    (!($this->posting->closing_date == '0000-00-00 00:00:00') && $my_close_date < $timenow))
    $mainframe->redirect('index.php',JTEXT::_('COM_JOBGROKLIST_VIEWS_POSTING_TMPL_DEFAULT_POSTING_DOES_NOT_EXIST'),'notice');
*/

if ( isset($this->posting->job_id))
{
    $query = 'SELECT * FROM `#__tst_jglist_jobs` WHERE id='.$this->posting->job_id;
    $db->setQuery($query);
    $results = $db->loadAssoc();
}

if ( isset($this->posting->contact_id))
{
    $query = 'SELECT contact, contact_email FROM `#__tst_jglist_contacts` WHERE id='.$this->posting->contact_id;
    $db->setQuery($query);
    $my_contact = $db->loadAssoc();
}
else
    $my_contact = "";

if ( isset($results['category_id']))
{
    $query = 'SELECT IF(c.use_description,c.description,sc.category) AS category FROM #__tst_jglist_static_category sc '.
        'JOIN #__tst_jglist_categories c ON sc.id=c.code WHERE c.id='.$results['category_id'];
    $db->setQuery($query);
    $my_category = $db->loadResult();
}
else
    $my_category = "";

if ( isset($results['department_id']))
{ 
    $query = 'SELECT department FROM `#__tst_jglist_departments` WHERE id='.$results['department_id'];
    $db->setQuery($query);
    $my_department = $db->loadResult();
}
else
    $my_department = "";

if ( isset($results['shift_id']))
{
    $query = 'SELECT shift FROM `#__tst_jglist_shifts` WHERE id='.$results['shift_id'];
    $db->setQuery($query);
    $my_shift = $db->loadResult();
}
else
    $my_shift = "";

if ( isset($this->posting->location_id))
{
    $query = 'SELECT location, loc_description, loc_address FROM `#__tst_jglist_locations` WHERE id='.$this->posting->location_id;
    $db->setQuery($query);
    $my_location = $db->loadAssoc();
}
else
{
    $my_location['location'] = "";
    $my_location['loc_description'] = "";
    $my_location['loc_address'] = "";
}

if ( isset($results['jobtype_id']))
{
    $query = 'SELECT IF(jt.use_description=1,jt.jobtype,sjt.jobtype) AS jobtype FROM `#__tst_jglist_jobtypes` jt LEFT JOIN `#__tst_jglist_static_jobtype` sjt ON sjt.id=jt.code WHERE jt.id='.$results['jobtype_id'];
    $db->setQuery($query);
    $my_jobtype = $db->loadResult();
}
else
    $my_jobtype = "";

if ( isset($results['education_id']))
{
    $query = 'SELECT education FROM `#__tst_jglist_static_education` WHERE id='.$results['education_id'];
    $db->setQuery($query);
    $my_education = $db->loadResult();
}
else
    $my_education = "";

if ( isset($results['company_id']))
{
    $query = 'SELECT company FROM `#__tst_jglist_companies` WHERE id='.$results['company_id'];
    $db->setQuery($query);
    $my_company = $db->loadResult();
}
else
    $my_company = "";

if ( isset($results['job_code']))
    $my_job_code = $results['job_code'];
else
    $my_job_code = "";

if ($this->params->get('display_jobtitle_in_browserbar','1') == '1') {
    $browserbar = $results['title'];
    $document = JFactory::getDocument();
    $document->setTitle($browserbar);
}
?>

<div class="jg">
<?php
if ($this->params->get('display_company_in_header','1') == '1')	echo "<h1>".$my_company."</h1>";
if ($this->params->get('display_jobtitle_in_header','1') == '1') echo "<h2>".$results['title']."</h2>"; 
?>
<div style="width:100%; border-bottom: 1px solid silver;"></div>
<table width="100%">
    <tr>
        <td style="text-align: left;" colspan="2">
	<?php
		if ($this->params->get('pre_article','0') != '0')
		{
			$db = JFactory::getDBO();
			$query = "SELECT `introtext`, `fulltext` FROM #__content WHERE id=".$this->params->get('pre_article');
			$db->setQuery($query);
			$result = $db->loadAssoc();
                        if ($result['introtext'] != '') echo JHTML::_('content.prepare',$result['introtext']);
                        if ($result['fulltext'] != '') echo JHTML::_('content.prepare',$result['fulltext']);
		}
	?>
        </td>
    </tr>
    <tr>
        <td style="text-align: left;">
            <?php
            if (!isset($this->posting->link)) { $alternate_link = ""; } else { $alternate_link = $this->posting->link; }
            if (!isset($this->posting->link_text)) { $alternate_link_text = ""; } else { $alternate_link_text = $this->posting->link_text; }
            if ($alternate_link == "") {
                $query = 'SELECT contact, contact_email FROM `#__tst_jglist_contacts` WHERE id='.$this->posting->contact_id;
                $db->setQuery($query);
                $results1 = $db->loadAssoc();
                echo '<div>';
                if ($results1['contact_email']!='' && $results1['contact']!='')
                {
                    echo '<span>'.JTEXT::_('COM_JOBGROKLIST_VIEWS_POSTING_TMPL_DEFAULT_APPLY_TO').'</span>';
                    if ($results1['contact_email'] != '' && $results1['contact'] != '')
                        echo JHTML::_('email.cloak', $results1['contact_email'], true, $results1['contact'], false);
                    elseif ($results1['contact'] != '')
                        echo $results1['contact'];
                }
                echo '</div>';
            } else {
                echo '<div>';
                echo '<a id="jg_apply_link" href="'.$this->posting->link.'">'.$this->posting->link_text.'</a>';
                echo '</div>';
            }
            ?>
        </td>
        <td style="text-align: right;"><?php if ($this->params->get('email_to_a_friend','1') == '0') : ?><a class="email_friend" href="index.php?option=com_jobgroklist&controller=application&view=application&Postingid=<?php echo $this->posting->id; ?>&layout=email&<?php if (isset($this->item_id)) echo 'Itemid='.$this->item_id;
        ?>"><?php echo $this->params->get('email_to_a_friend_text',JTEXT::_('COM_JOBGROKLIST_VIEWS_POSTING_TMPL_DEFAULT_EMAIL_TO_A_FRIEND')); ?></a>
            <?php endif; ?>
            <?php if ($this->params->get('display_back_link','1') == '1' && isset($this->item_id)) : ?>
            <a class="back_link" href="index.php?option=com_jobgroklist&view=postings&layout=<?php echo JRequest::getVar('returnl'); ?>&<?php if (isset($this->item_id)) echo 'Itemid='.$this->item_id; 
            ?>"><?php echo $this->params->get('back_link_text',JTEXT::_('COM_JOBGROKLIST_VIEWS_POSTING_TMPL_DEFAULT_RETURN_TO_POSTINGS')); ?></a>
        <?php endif; ?></td>
    </tr>
    <?php if ($this->params->get('display_posting_summary','1') == '1') : ?>
    <tr>
        <td style="font-style: italic;" colspan="2" valign="top">            
            <?php if (isset($this->posting->summary)) echo ($this->params->get('plugin_allow_summary','0')=='0'?$this->posting->summary:JHTML::_('content.prepare',$this->posting->summary)); ?>
        </td>
    </tr>
    <?php endif; ?>
</table>
<div style="width:100%; border-bottom: 1px solid silver;"></div>
<table width="100%">
    <?php if ($my_job_code != "" && $this->params->get('display_job_code','1') == '1') : ?>
    <tr>
        <td <?php if ($this->params->get('posting_field_width','') !== '') echo 'width="'.$this->params->get('posting_field_width').'%"'; ?> style="font-weight: bold;" valign="top"><?php echo JTEXT::_('COM_JOBGROKLIST_VIEWS_POSTING_TMPL_DEFAULT_JOB_CODE'); ?>:</td>
        <td valign="top"><?php echo $my_job_code; ?></td>
    </tr>
    <?php endif; ?>
    <?php if (isset($my_open_date) || isset($my_close_date)) : ?>
    <tr>
        <td <?php if ($this->params->get('posting_field_width','') !== '') echo 'width="'.$this->params->get('posting_field_width').'%"'; ?> style="font-weight: bold;" valign="top">
            <?php if ($this->params->get('display_posted_on','1') == '1' && isset($my_open_date)) echo JTEXT::_('COM_JOBGROKLIST_VIEWS_POSTING_TMPL_DEFAULT_POSTED_ON').":"; ?>
            <?php if (($this->params->get('display_posted_on','1') == '1' && isset($my_open_date)) && ($this->params->get('display_closing_on','1') == '1' && isset($my_close_date))) echo "<br/>"; ?>
            <?php if ($this->params->get('display_closing_on','1') == '1' && isset($my_close_date)) echo JTEXT::_('COM_JOBGROKLIST_VIEWS_POSTING_TMPL_DEFAULT_CLOSING_ON').":"; ?>
        </td>
        <td valign="top">
            <?php if ($this->params->get('display_posted_on','1') == '1' && isset($my_open_date)) echo $my_open_date->format($this->params->get('single_listing_date_format',JTEXT::_('COM_JOBGROKLIST_VIEWS_POSTING_TMPL_DEFAULT_L_JS_F_Y'))); ?>
            <?php if (($this->params->get('display_posted_on','1') == '1' && isset($my_open_date)) && ($this->params->get('display_closing_on','1') == '1' && isset($my_close_date))) echo "<br/>"; ?>
            <?php if ($this->params->get('display_closing_on','1') == '1' && isset($my_close_date)) echo $my_close_date->format($this->params->get('single_listing_date_format',JTEXT::_('COM_JOBGROKLIST_VIEWS_POSTING_TMPL_DEFAULT_L_JS_F_Y'))); ?>
        </td>
    </tr>
    <?php endif; ?>
    <?php if ($my_category != "") : ?>
    <tr>
        <td <?php if ($this->params->get('posting_field_width','') !== '') echo 'width="'.$this->params->get('posting_field_width').'%"'; ?> style="font-weight: bold;" valign="top">
            <?php if ($this->params->get('display_category','1') == '1') echo JTEXT::_('COM_JOBGROKLIST_VIEWS_POSTING_TMPL_DEFAULT_CATEGORY').':'; ?>
        </td>
        <td valign="top">
            <?php if ($this->params->get('display_category','1') == '1') echo $my_category; ?>
        </td>
    </tr>
    <?php endif; ?>
    <?php if ($my_department != "") : ?>
    <tr>
        <td <?php if ($this->params->get('posting_field_width','') !== '') echo 'width="'.$this->params->get('posting_field_width').'%"'; ?> style="font-weight: bold;" valign="top">
            <?php if ($this->params->get('display_department','1') == '1') echo JTEXT::_('COM_JOBGROKLIST_VIEWS_POSTING_TMPL_DEFAULT_DEPARTMENT').':'; ?>
        </td>
        <td valign="top">
            <?php if ($this->params->get('display_department','1') == '1') echo $my_department; ?>
        </td>
    </tr>
    <?php endif; ?>
    <?php if ($my_shift != "") : ?>
    <tr>
        <td <?php if ($this->params->get('posting_field_width','') !== '') echo 'width="'.$this->params->get('posting_field_width').'%"'; ?> style="font-weight: bold;" valign="top">
            <?php if ($this->params->get('display_shift','1') == '1') echo JTEXT::_('COM_JOBGROKLIST_VIEWS_POSTING_TMPL_DEFAULT_SHIFT').':'; ?>
        </td>
        <td valign="top">
            <?php if ($this->params->get('display_shift','1') == '1') echo $my_shift; ?>
        </td>
    </tr>
    <?php endif; ?>
    <?php if ($my_location['location'] != "" ||
                $my_location['loc_description'] != "" ||
                $my_location['loc_address'] != "") : ?>
    <tr>
        <td <?php if ($this->params->get('posting_field_width','') !== '') echo 'width="'.$this->params->get('posting_field_width').'%"'; ?> style="font-weight: bold" valign="top">
            <?php if ($this->params->get('display_location','1') == '1') echo JTEXT::_('COM_JOBGROKLIST_VIEWS_POSTING_TMPL_DEFAULT_LOCATION').':'; ?>
        </td>
        <td valign="top">
            <?php if ($this->params->get('display_location','1') == '1') echo ($my_location['location']==''?'':$my_location['location']."<br />"); ?>
            <?php if ($this->params->get('display_loc_description','1') == '1') echo ($my_location['loc_description']==''?'':$my_location['loc_description']."<br />"); ?>
            <?php if ($this->params->get('display_loc_address','1') == '1') echo ($my_location['loc_address']==''?'':$my_location['loc_address']."<br />"); ?>
        </td>
    </tr>
    <?php endif; ?>
    <?php if ($my_jobtype != "") : ?>
    <tr>
        <td <?php if ($this->params->get('posting_field_width','') !== '') echo 'width="'.$this->params->get('posting_field_width').'%"'; ?> style="font-weight: bold" valign="top">
            <?php if ($this->params->get('display_job_type','1') == '1') echo JTEXT::_('COM_JOBGROKLIST_VIEWS_POSTING_TMPL_DEFAULT_JOB_TYPE').":<br />"; ?>
        </td>
        <td valign="top">
            <?php if ($this->params->get('display_job_type','1') == '1') echo $my_jobtype."<br />"; ?>
        </td>
    </tr>
    <?php endif; ?>
    <?php if ($my_education != "") : ?>
    <tr>
        <td <?php if ($this->params->get('posting_field_width','') !== '') echo 'width="'.$this->params->get('posting_field_width').'%"'; ?> style="font-weight: bold" valign="top">
            <?php if ($this->params->get('display_education','1') == '1') echo JTEXT::_('COM_JOBGROKLIST_VIEWS_POSTING_TMPL_DEFAULT_EDUCATION').":" ?>
        </td>
        <td valign="top">
            <?php if ($this->params->get('display_education','1') == '1') echo $my_education; ?>
        </td>
    </tr>
    <?php endif; ?>
    <?php if ( $this->params->get('display_pay_rate','1') == '1' && $results['pay_rate'] != "") : ?>
    <?php if ( !$results['hide_payrate']) : ?>
    <tr>
        <td <?php if ($this->params->get('posting_field_width','') !== '') echo 'width="'.$this->params->get('posting_field_width').'%"'; ?> style="font-weight: bold;" valign="top">
                    <?php echo JTEXT::_('COM_JOBGROKLIST_VIEWS_POSTING_TMPL_DEFAULT_PAY_RATE'); ?>:
        </td>
        <td valign="top">
                    <?php echo $results['pay_rate']; ?>
        </td>
    </tr>
    <?php endif; ?>
    <?php endif; ?>
    <?php if ( $this->params->get('display_duration','1') == '1') : ?>
    <tr>
        <td <?php if ($this->params->get('posting_field_width','') !== '') echo 'width="'.$this->params->get('posting_field_width').'%"'; ?> style="font-weight: bold;" valign="top">
            <?php echo ($this->params->get('display_duration','1') == '1')?JTEXT::_('COM_JOBGROKLIST_VIEWS_POSTING_TMPL_DEFAULT_DURATION').":":""; ?>
        </td>
        <td valign="top">
            <?php echo ($this->params->get('display_duration','1') == '1')?$results['duration']:""; ?>
        </td>
    </tr> 
    <?php endif; ?>
    <?php if ($this->params->get('display_travel','1') == '1') : ?>
    <tr>
        <td <?php if ($this->params->get('posting_field_width','') !== '') echo 'width="'.$this->params->get('posting_field_width').'%"'; ?> style="font-weight: bold;" valign="top">
            <?php echo ($this->params->get('display_travel','1') == '1')?JTEXT::_('COM_JOBGROKLIST_VIEWS_POSTING_TMPL_DEFAULT_TRAVEL').":":""; ?>
        </td>
        <td valign="top">
            <?php echo ($this->params->get('display_travel','1') == '1')?$results['travel']:""; ?>
        </td>
    </tr>
    <?php endif; ?>
    <?php if ($this->params->get('display_job_description','1') == '1') : ?>
    <tr>
        <td <?php if ($this->params->get('posting_field_width','') !== '') echo 'width="'.$this->params->get('posting_field_width').'%"'; ?> style="font-weight: bold;" valign="top">
            <p><?php echo JTEXT::_('COM_JOBGROKLIST_VIEWS_POSTING_TMPL_DEFAULT_JOB_DESCRIPTION').':'; ?></p>
        </td>
        <td valign="top">
                <?php 
                if ($this->params->get('plugin_allow_jobdescription','0') == '0')
                    echo str_replace('{applynow}',$this->getModel()->getApplyNow(),$results['job_description']); 
                else
                    echo JHTML::_('content.prepare',str_replace('{applynow}',$this->getModel()->getApplyNow(),$results['job_description']))
                ?>
        </td>
    </tr>
    <?php endif; ?>
    <?php if ($this->params->get('display_preferred_skills','1') == '1') : ?>
    <tr>
        <td <?php if ($this->params->get('posting_field_width','') !== '') echo 'width="'.$this->params->get('posting_field_width').'%"'; ?> style="font-weight: bold;" valign="top">
            <p><?php echo JTEXT::_('COM_JOBGROKLIST_VIEWS_POSTING_TMPL_DEFAULT_PREFERRED_SKILLS').':'; ?></p>
        </td>
        <td valign="top">
                <?php 
                if ($this->params->get('plugin_allow_jobdescription','0') == '0')
                    echo str_replace('{applynow}',$this->getModel()->getApplyNow(),$results['preferred_skills']); 
                else
                    echo JHTML::_('content.prepare',str_replace('{applynow}',$this->getModel()->getApplyNow(),$results['preferred_skills']))
                ?>
        </td>
    </tr>
    <?php endif; ?>
    <tr>
        <td style="text-align: left;" colspan="2">
	<?php
		if ($this->params->get('post_article','0') != '0')
		{
			$db = JFactory::getDBO();
			$query = "SELECT `introtext`, `fulltext` FROM #__content WHERE id=".$this->params->get('post_article');
			$db->setQuery($query);
			$result = $db->loadAssoc();
                        if ($result['introtext'] != '') echo JHTML::_('content.prepare',$result['introtext']);
                        if ($result['fulltext'] != '') echo JHTML::_('content.prepare',$result['fulltext']);
		}
	?>
        </td>
    </tr>
</table>
<div style="width:100%; border-bottom: 1px solid silver;"></div>
<div id="credits" style="width: 100%"><?php echo JTEXT::_('COM_JOBGROKLIST_VIEWS_POSTING_TMPL_DEFAULT_POWERED_BY'); 
?>&nbsp;<a href="http://www.jobgrok.com"><?php echo JTEXT::_('COM_JOBGROKLIST_VIEWS_POSTING_TMPL_DEFAULT_JOBGROK'); ?></a></div>
</div>