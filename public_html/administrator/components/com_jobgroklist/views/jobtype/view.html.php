<?php
/**
 *
 *
 * This is the view.html.php file for jobgroklist
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
 */

defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.view');

/**
 *
 * Job Type View
 *
 */
class JobgroklistViewJobtype extends JViewLegacy

{

    function display($tpl = null)
    {
    //get the hello
        $jobtype = $this->get('Jobtype');
        if (!isset($jobtype->id))
            $isNew = true;
        else
            $isNew = false;

        $text = $isNew ? JTEXT::_('COM_JOBGROKLIST_VIEWS_JOBTYPE_VIEW_HTML_ADD') :
            JTEXT::_('COM_JOBGROKLIST_VIEWS_JOBTYPE_VIEW_HTML_EDIT');
        JToolBarHelper :: title(JTEXT::_('COM_JOBGROKLIST_VIEWS_JOBTYPE_VIEW_HTML_JOB_TYPE') . ': <small><small>[ ' . $text . ' ]</small></small>','jobtype');
        JToolBarHelper :: save();
        if ($isNew)
        {
            JToolBarHelper :: cancel();
        }
        else
        {
        // for existing items the button is renamed `close`
            JToolBarHelper :: cancel('cancel', JTEXT::_('COM_JOBGROKLIST_VIEWS_JOBTYPE_VIEW_HTML_CLOSE'));
        }

        $lists['static_jobtype'] = JHTML::_('jobgroklist.static_jobtype',(isset($jobtype->code)?$jobtype->code:''),'','code');
        $lists['company'] = JHTML::_('jobgroklist.company',(isset($jobtype->company_id)?$jobtype->company_id:''),'','company_id','detail');
        $this->assignRef('lists', $lists);

        
        $this->assignRef('jobtype', $jobtype);
        parent :: display($tpl);
    }
}
?>
