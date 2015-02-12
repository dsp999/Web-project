<?php
/**
 *
 *
 * This is the view.html.php file for jobgroklist
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

jimport('joomla.application.component.view');

/**
 *
 * Job Type View
 *
 */
class JobgroklistViewPosting extends JViewLegacy

{

    function display($tpl = null)
    {
    //get the hello
        $job = $this->get('Posting');
        if (!isset($job->id))
            $isNew = true;
        else
            $isNew = false;

        
        $text = $isNew ? JTEXT::_('COM_JOBGROKLIST_VIEWS_POSTING_VIEW_HTML_ADD') :
            JTEXT::_('COM_JOBGROKLIST_VIEWS_POSTING_VIEW_HTML_EDIT');
        JToolBarHelper :: title(JTEXT::_('COM_JOBGROKLIST_VIEWS_POSTING_VIEW_HTML_POSTING') . ': <small><small>[ ' . $text . ' ]</small></small>','posting');
        JToolBarHelper :: save();
        if ($isNew)
        {
            JToolBarHelper :: cancel();
        }
        else
        {
        // for existing items the button is renamed `close`
            JToolBarHelper :: cancel('cancel', JTEXT::_('COM_JOBGROKLIST_VIEWS_POSTING_VIEW_HTML_CLOSE'));
        }

        $lists = array();
        // $lists['company'] = JHTML::_('jobgroklist.company',isset($job->company_id)?$job->company_id:'*','','company_id','detail');
        // $lists['location'] = JHTML::_('jobgroklist.location',isset($job->location_id)?$job->location_id:'*','','location_id','companies',isset($job->company_id)?$job->company_id:'*');
        // $lists['job'] = JHTML::_('jobgroklist.jobtitle',isset($job->job_id)?$job->job_id:'*','','job_id','companies',isset($job->company_id)?$job->company_id:'*');
        // $lists['contact'] = JHTML::_('jobgroklist.contact',isset($job->contact_id)?$job->contact_id:'*','','contact_id','companies',isset($job->company_id)?$job->company_id:'*');

        // all this garbage should move to the model (see options)
        $lists['company'] = JHTML::_('jobgroklist.company',isset($job->company_id)?$job->company_id:'*','','company_id','detail');
        $lists['location'] = JHTML::_('jobgroklist.location',isset($job->location_id)?$job->location_id:'*','','location_id',isset($job->company_id)?'companies':'location',isset($job->company_id)?$job->company_id:'*');
        $lists['job'] = JHTML::_('jobgroklist.jobtitle',isset($job->job_id)?$job->job_id:'*','','job_id',isset($job->company_id)?'companies':'jobtitle',isset($job->company_id)?$job->company_id:'*');
        $lists['contact'] = JHTML::_('jobgroklist.contact',isset($job->contact_id)?$job->contact_id:'*','','contact_id',isset($job->company_id)?'companies':'contact',isset($job->company_id)?$job->company_id:'*');

        $options = $this->get('Options');
        $this->assignRef('options',$options);

        $this->assignRef('lists', $lists);
        $this->assignRef('posting', $job);

        
        $paramsdata = isset($job->params)?$job->params:null;
        $paramsdefs = JPATH_COMPONENT.DIRECTORY_SEPARATOR.'models'.DIRECTORY_SEPARATOR.'posting.xml';
        //$params = new JParameter( $paramsdata, $paramsdefs );
        
        $params = JForm::getInstance('params',$paramsdefs);
        $test['params'] = json_decode($paramsdata,true);
        $params->bind($test);
        $this->assignRef('params', $params);
 
        $cparams = JComponentHelper::getParams('com_jobgroklist');
        $this->assignRef('cparams', $cparams);
        
        parent :: display($tpl);
    }
}
?>
