<?php
/**
 *
 *
 * This is the view.html.php file for jobgroklist
 *
 * Created: June 13, 2014, 1:18 am
 *
 * Subversion Details
 * $Date: 2013-07-21 14:29:26 -0500 (Sun, 21 Jul 2013) $
 * $Revision: 5365 $
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

jimport('joomla.application.component.view');

/**
 *
 * Job Type View
 *
 */
class JobgroklistViewJob extends JViewLegacy

{

    function display($tpl = null)
    {
    //get the hello
        $job = $this->get('Job');
        if (!isset($job->id))
            $isNew = true;
        else
            $isNew = false;

        $text = $isNew ? JTEXT::_('COM_JOBGROKLIST_VIEWS_JOB_VIEW_HTML_ADD') :
            JTEXT::_('COM_JOBGROKLIST_VIEWS_JOB_VIEW_HTML_EDIT');
        JToolBarHelper :: title(JTEXT::_('COM_JOBGROKLIST_VIEWS_JOB_VIEW_HTML_JOB') . ': <small><small>[ ' . $text . ' ]</small></small>','job');
        JToolBarHelper :: save();
        if ($isNew)
        {
            JToolBarHelper :: cancel();
        }
        else
        {
        // for existing items the button is renamed `close`
            JToolBarHelper :: cancel('cancel', JTEXT::_('COM_JOBGROKLIST_VIEWS_JOB_VIEW_HTML_CLOSE'));
        }

        // old method required a company to be set...
        // $lists['company'] = JHTML::_('jobgroklist.company',(isset($job->company_id)?$job->company_id:'*'),'','company_id','detail');
        // $lists['category'] = JHTML::_('jobgroklist.static_category',(isset($job->category_id)?$job->category_id:'*'),'','category_id','companies',(isset($job->company_id)?$job->company_id:'*'));
        // $lists['department'] = JHTML::_('jobgroklist.department',(isset($job->department_id)?$job->department_id:'*'),'','department_id','companies',(isset($job->company_id)?$job->company_id:'*'));
        // $lists['shift'] = JHTML::_('jobgroklist.shift',(isset($job->shift_id)?$job->shift_id:'*'),'','shift_id','companies',(isset($job->company_id)?$job->company_id:'*'));
        // $lists['location'] = JHTML::_('jobgroklist.location',(isset($job->location_id)?$job->location_id:'*'),'','location_id','companies',(isset($job->company_id)?$job->company_id:'*'));
        // $lists['jobtype'] = JHTML::_('jobgroklist.jobtype',(isset($job->jobtype_id)?$job->jobtype_id:'*'),'','jobtype_id','companies',(isset($job->company_id)?$job->company_id:'*'));
        $lists['company'] = JHTML::_('jobgroklist.company',(isset($job->company_id)&&$job->company_id!='0'?$job->company_id:'*'),'','company_id','detail');
        $lists['category'] = JHTML::_('jobgroklist.category',(isset($job->category_id)?$job->category_id:'*'),'','category_id',isset($job->company_id)&&$job->company_id!='0'?'companies':'category',(isset($job->company_id)&&$job->company_id!='0'?$job->company_id:'*'));
        $lists['department'] = JHTML::_('jobgroklist.department',(isset($job->department_id)?$job->department_id:'*'),'','department_id',isset($job->company_id)&&$job->company_id!='0'?'companies':'department',(isset($job->company_id)&&$job->company_id!='0'?$job->company_id:'*'));
        $lists['shift'] = JHTML::_('jobgroklist.shift',(isset($job->shift_id)?$job->shift_id:'*'),'','shift_id',isset($job->company_id)&&$job->company_id!='0'?'companies':'shift',(isset($job->company_id)&&$job->company_id!='0'?$job->company_id:'*'));
        $lists['location'] = JHTML::_('jobgroklist.location',(isset($job->location_id)?$job->location_id:'*'),'','location_id',isset($job->company_id)&&$job->company_id!='0'?'companies':'location',(isset($job->company_id)&&$job->company_id!='0'?$job->company_id:'*'));
        $lists['jobtype'] = JHTML::_('jobgroklist.jobtype',(isset($job->jobtype_id)?$job->jobtype_id:'*'),'','jobtype_id',isset($job->company_id)&&$job->company_id!='0'?'companies':'jobtype',(isset($job->company_id)&&$job->company_id!='0'?$job->company_id:'*'));
        $lists['education'] = JHTML::_('jobgroklist.static_education',(isset($job->education_id)?$job->education_id:'*'),'','education_id','detail');
        $lists['payrange'] = JHTML::_('jobgroklist.static_payrange',(isset($job->payrange)?$job->payrange:'*'),'','payrange_id','detail');
        $this->assignRef('lists',$lists);
        
        
        $params = JComponentHelper::getParams('com_jobgroklist');
        $this->assignRef('params',$params);
        
        if ($params->get('auto_generate_job_codes','0') == '1') $autoJobCode = true; else $autoJobCode = false;
        $this->assignRef('autoJobCode',$autoJobCode);

        $this->assignRef('job', $job);
        parent :: display($tpl);
    }
}
?>
