<?php
/**
 *
 *
 * This is the view.pdf.php file for jobgroklist
 *
 * Created: June 13, 2014, 1:18 am
 *
 * Subversion Details
 * $Date: 2012-04-14 23:34:52 -0500 (Sat, 14 Apr 2012) $
 * $Revision: 3570 $
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

/**
 *
 * Posting View
 *
 */
class JobgroklistViewPostings extends JViewLegacy

{
/**
 *
 * Renders the View
 *
 */
    function display($tpl = null)
    {

        $document = JFactory::getDocument();
        $document->setName('Name');
        $document->setTitle('Title');
        $document->setDescription('Description');
        $document->setMetaData('keywords','Some Keywords');
        $document->setGenerator('Generator');

        global $option;
		$mainframe = JFactory::getApplication();

        $lists = array();

        $filter_order = $mainframe->getUserStateFromRequest($option.'filter_order','filter_order','postings_job_title');
        $filter_order_Dir = $mainframe->getUserStateFromRequest($option.'filter_order_Dir','filter_order_Dir','ASC');
        $filter_category = $mainframe->getUserStateFromRequest($option.'filter_category','filter_category');
        $filter_location = $mainframe->getUserStateFromRequest($option.'filter_location','filter_location');
        $filter_department = $mainframe->getUserStateFromRequest($option.'filter_department','filter_department');
        $filter_company = $mainframe->getUserStateFromRequest($option.'filter_company','filter_company');
        $filter_jobtype = $mainframe->getUserStateFromRequest($option.'filter_jobtype','filter_jobtype');

        $lists['order_Dir'] = $filter_order_Dir;
        $lists['order'] = $filter_order;

        $js = 'onchange="document.pagination_form.submit();"';

        $db = JFactory::getDBO();

        $query = 'SELECT id, category FROM #__tst_jglist_categories WHERE id <> 0';
        $db->setQuery($query);
        $options = $db->loadAssocList();
        $lists['category'] = JHTML::_('select.genericlist',$options,'filter_category','class="inputbox" size="1" style="font-size: 10px;" '.$js,'id','category',$filter_category);

        $query = 'SELECT id, location FROM #__tst_jglist_locations WHERE id <> 0';
        $db->setQuery($query);
        $options = $db->loadAssocList();
        $lists['location'] = JHTML::_('select.genericlist',$options,'filter_location','class="inputbox" size="1" style="font-size: 10px;" '.$js,'id','location',$filter_location);

        $query = 'SELECT id, department FROM #__tst_jglist_departments WHERE id <> 0';
        $db->setQuery($query);
        $options = $db->loadAssocList();
        $lists['department'] = JHTML::_('select.genericlist',$options,'filter_department','class="inputbox" size="1" style="font-size: 10px;" '.$js,'id','department',$filter_department);

        $query = 'SELECT id, jobtype FROM #__tst_jglist_jobtypes WHERE id <> 0';
        $db->setQuery($query);
        $options = $db->loadAssocList();
        $lists['jobtype'] = JHTML::_('select.genericlist',$options,'filter_jobtype','class="inputbox" size="1" style="font-size: 10px;" '.$js,'id','jobtype',$filter_jobtype);

        $query = 'SELECT id, company FROM #__tst_jglist_companies WHERE id <> 0';
        $db->setQuery($query);
        $options = $db->loadAssocList();
        $lists['company'] = JHTML::_('select.genericlist',$options,'filter_company','class="inputbox" size="1" style="font-size: 10px;" '.$js,'id','company',$filter_company);

        $this->assignRef('lists',$lists);

        //$items = $this->get('Data');
        //$this->assignRef('items', $items);

        //$params = $mainframe->getPageParameters();
        $params = JComponentHelper::getParams();
        $this->assignRef('params', $params);

        // Get data from the model
        $items = $this->get('Data');
        $pagination = $this->get('Pagination');
        $total = $this->get('Total');
        $limit = $this->get('Limit');
        $limitstart = $this->get('Limitstart');
        $format = 'pdf';


        // push data into the template
        $this->assignRef('items', $items);
        $this->assignRef('pagination', $pagination);
        $this->assignRef('total', $total);
        $this->assignRef('limit', $limit);
        $this->assignRef('limitstart', $limitstart);
        $this->assignRef('format',$format);

        parent :: display($tpl);
    }
}
?>
