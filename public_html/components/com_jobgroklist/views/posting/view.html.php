<?php
/**
 *
 *
 * This is the view.html.php file for jobgroklist
 *
 * Created: June 13, 2014, 1:18 am
 *
 * Subversion Details
 * $Date: 2014-05-04 20:12:43 -0500 (Sun, 04 May 2014) $
 * $Revision: 6050 $
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
jimport('joomla.application.component.helper');
jimport('joomla.html.parameter');
/**
 *
 * Job Type View
 *
 */
class JobgroklistViewPosting extends JViewLegacy
{

    function display($tpl = null)
    {
        global $mainframe;

        $params = JComponentHelper::getParams('com_jobgroklist');
        if (JRequest::getInt('Itemid','0') != '0')
        {
            $db = JFactory::getDBO();
            $query = "SELECT params FROM #__menu WHERE id=".JRequest::getInt('Itemid');
            $db->setQuery($query);
            $paramsdata = $db->loadResult();
            $params->merge(new JRegistry($paramsdata));
            $item_id = JRequest::getInt('Itemid');
            $this->assignRef('item_id',$item_id);
        }
        $quicklink = $params->get('employer_quicklink','');
        $this->assignRef('quicklink',$quicklink);
        

        // allow for global override - kind of a hack, but hey! it works.       
        JRequest::setVar('id',$params->get('id',JRequest::getVar('id')));
        $job = $this->get('Posting');
        $this->assignRef('posting', $job);
        if (!$job) { parent::display("none"); return; }
        
        $posting_params = new JRegistry($job->params);
        $posting_params_array = $posting_params->toArray();
        $new_params = new JRegistry();

        foreach ($posting_params_array as $key=>$value) {
                if ($value != "99") { $new_params->set($key, $value); }
        }
        $params->merge($new_params);
        

        $pjob = $this->get('PostingJob');
        $this->assignRef('pjob',$pjob);
        
        $this->assignRef('test',$paramsdata);
        $this->assignRef('params', $params);
        // JHTML::_('jobgroklist.static_referral_description',$row->referral_id)
        $document = JFactory::getDocument();
        if (isset($pjob)) if ($params->get('meta_title','1')) $meta_description[] = $pjob->title;
        if (isset($job)) if ($params->get('meta_location','1')) $meta_description[] = JHTML::_('jobgroklist.location_desc',$job->location_id);
        if (isset($pjob)) if ($params->get('meta_company','1')) $meta_description[] = JHTML::_('jobgroklist.company_desc',$pjob->company_id);
        if (isset($pjob)) if ($params->get('meta_job_code','1')) $meta_description[] = $pjob->job_code;
        if (isset($meta_description)) {
            $document->setMetaData('description',implode(" - ",$meta_description));
            $document->title = implode(" - ", $meta_description);
        } else {
            $document->setMetaData('description',$params->get('menu-meta_description'));
        }
        $robots = JFactory::getConfig()->get( 'robots' );
        $document->setMetaData( 'robots', $robots );
        // $document->setMetaData('keywords',$params->get('menu-meta_keywords'));
        
        
        parent :: display($tpl);
    }
}
?>
