<?php
/**
 *
 *
 * This is the view.html.php file for jobgroklist
 *
 * Created: June 13, 2014, 1:18 am
 *
 * Subversion Details
 * $Date: 2014-03-30 21:07:23 -0500 (Sun, 30 Mar 2014) $
 * $Revision: 5884 $
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
        $item_id = '';
        if (JRequest::getInt('Itemid',0)!=0) $item_id=JRequest::getInt('Itemid');

        $feed = 'index.php?option=com_jobgroklist&view=postings&format=feed';
        $rss = array(
            'type' => 'application/rss+xml',
            'title' => 'Job Grok RSS Feed'
        );
        $atom = array(
            'type' => 'application/atom+xml',
            'title' => 'Job Grok ATOM Feed'
        );

        $document = JFactory::getDocument();

        $robots = JFactory::getConfig()->get( 'robots' );
        $document->setMetaData( 'robots', $robots );

        global $option;
        $mainframe = JFactory::getApplication();
        $params = $mainframe->getPageParameters();

        if ($params->get('display_rss_feed','1') === '1') $document->addHeadLink(JRoute::_($feed.'&type=rss'), 'alternate', 'rel', $rss);
        if ($params->get('display_atom_feed','1') === '1') $document->addHeadLink(JRoute::_($feed.'&type=atom'), 'alternate', 'rel', $atom);
        
        $lists = array();
        $filter_order = $mainframe->getUserStateFromRequest($option.'filter_order'.$item_id,'filter_order'.$item_id,'postings_job_title');
        $filter_order_Dir = $mainframe->getUserStateFromRequest($option.'filter_order_Dir'.$item_id,'filter_order_Dir'.$item_id,'ASC');
        $filter_category = $mainframe->getUserStateFromRequest($option.'filter_category'.$item_id,'filter_category'.$item_id);
        $filter_category_desc = $mainframe->getUserStateFromRequest($option.'filter_category_desc'.$item_id,'filter_category_desc'.$item_id);
        $filter_category_hybrid  = $mainframe->getUserStateFromRequest($option.'filter_category_hybrid'.$item_id,'filter_category_hybrid'.$item_id);
        $filter_country = $mainframe->getUserStateFromRequest($option.'filter_country'.$item_id,'filter_country'.$item_id);
        $filter_department = $mainframe->getUserStateFromRequest($option.'filter_department'.$item_id,'filter_department'.$item_id);
        $filter_company = $mainframe->getUserStateFromRequest($option.'filter_company'.$item_id,'filter_company'.$item_id);
        $filter_jobcode = $mainframe->getUserStateFromRequest($option.'filter_jobcode'.$item_id,'filter_jobcode'.$item_id);
        $filter_payrate = $mainframe->getUserStateFromRequest($option.'filter_payrate'.$item_id,'filter_payrate'.$item_id);
        $filter_jobtype = $mainframe->getUserStateFromRequest($option.'filter_jobtype'.$item_id,'filter_jobtype'.$item_id);
        $filter_jobtype_desc = $mainframe->getUserStateFromRequest($option.'filter_jobtype_desc'.$item_id,'filter_jobtype_desc'.$item_id);
        $filter_jobtype_hybrid = $mainframe->getUserStateFromRequest($option.'filter_jobtype_hybrid'.$item_id,'filter_jobtype_hybrid'.$item_id);
        $filter_location = $mainframe->getUserStateFromRequest($option.'filter_location'.$item_id,'filter_location'.$item_id);
        $filter_location_desc = $mainframe->getUserStateFromRequest($option.'filter_location_desc'.$item_id,'filter_location_desc'.$item_id);
        $filter_payrange = $mainframe->getUserStateFromRequest($option.'filter_static_payrange'.$item_id,'filter_static_payrange'.$item_id);

        // is this posted from the form filters, or is this from a menu - if it's a menu let's use the default
        if (JRequest::getVar('filter_from_form','0') != '1') {
            $lists['order'] = $params->get('default_sort_field','posting_date');       
            $lists['order_Dir'] = $params->get('default_sort','DESC');
        } else {
            $lists['order'] = $filter_order;        
            $lists['order_Dir'] = $filter_order_Dir;    
        }

        $js = 'onchange="document.pagination_form.submit();"';

        if ($params->get('postings_search_category','0') == '0')
            $lists['category']          = JHTML::_('jobgroklist.static_category',$filter_category,$js,'filter_category'.$item_id,'postings_static_category','*',$params->get('view_category_id',''), false, $params->get('postings_search_category_type','dropdown'));
        if ($params->get('postings_search_category_desc','0') == '0')
            $lists['category_desc']     = JHTML::_('jobgroklist.static_category',$filter_category_desc,$js,'filter_category_desc'.$item_id,'postings_static_category_desc','*',$params->get('view_category_desc_id',''));
        if ($params->get('postings_search_category_hybrid','0') == '0')
            $lists['category_hybrid']   = JHTML::_('jobgroklist.static_category',$filter_category_hybrid,$js,'filter_category_hybrid'.$item_id,'postings_static_category_hybrid','*',$params->get('view_category_desc_id',$params->get('view_category_id','')));
        if ($params->get('postings_search_company','0') == '0')
            $lists['company']           = JHTML::_('jobgroklist.company',$filter_company,$js,'filter_company'.$item_id,'postings_company','*',$params->get('view_company_id',''));
        if ($params->get('postings_search_location','0') == '0')
            $lists['location']          = JHTML::_('jobgroklist.location',$filter_location,$js,'filter_location'.$item_id,'postings_location','0',$params->get('view_location_id',''), false, $params->get('postings_search_location_type','dropdown'));
        if ($params->get('postings_search_location_desc','0') == '0')
            $lists['location_desc']     = JHTML::_('jobgroklist.location',$filter_location_desc,$js,'filter_location_desc'.$item_id,'postings_location_desc','0',$params->get('view_location_desc_id',''), false, $params->get('postings_search_location_desc_type','dropdown'));
        if ($params->get('postings_search_department','0') == '0')
            $lists['department']        = JHTML::_('jobgroklist.department',$filter_department,$js,'filter_department'.$item_id,'postings_department','*',$params->get('view_department_id',''));
        if ($params->get('postings_search_country','0') == '0')
            $lists['country']           = JHTML::_('jobgroklist.static_country',$filter_country,$js,'filter_country'.$item_id,'postings_country','*',$params->get('view_country_id',''));
        if ($params->get('postings_search_jobcode','0') == '0')
            $lists['jobcode']           = JHTML::_('jobgroklist.static_jobcode',$filter_jobcode,$js,'filter_jobcode'.$item_id,'postings_jobcode','*',$params->get('view_jobcode_id',''), false, $params->get('postings_search_jobcode_type','dropdown'));
        if ($params->get('postings_search_payrate','0') == '0')
            $lists['payrate']           = JHTML::_('jobgroklist.static_payrate',$filter_payrate,$js,'filter_payrate'.$item_id,'postings_payrate','*',$params->get('view_payrate_id',''), false, $params->get('postings_search_payrate_type','dropdown'));
        if ($params->get('postings_search_jobtype','0') == '0')
            $lists['jobtype']           = JHTML::_('jobgroklist.static_jobtype',$filter_jobtype,$js,'filter_jobtype'.$item_id,'postings_jobtype','*',$params->get('view_jobtype_id',''), false, $params->get('postings_search_jobtype_type','dropdown'));
        if ($params->get('postings_search_jobtype_desc','0') == '0')
            $lists['jobtype_desc']      = JHTML::_('jobgroklist.static_jobtype',$filter_jobtype_desc,$js,'filter_jobtype_desc'.$item_id,'postings_jobtype_desc','*',$params->get('view_jobtype_desc_id',''), false, $params->get('postings_search_jobtype_desc_type','dropdown'));
        if ($params->get('postings_search_jobtype_hybrid','0') == '0')
            $lists['jobtype_hybrid']    = JHTML::_('jobgroklist.static_jobtype',$filter_jobtype_hybrid,$js,'filter_jobtype_hybrid'.$item_id,'postings_jobtype_hybrid','*',$params->get('view_jobtype_hybrid_id',''), false, $params->get('postings_search_jobtype_hybrid_type','dropdown'));
        if ($params->get('postings_search_payrange','0') == '0')
            $lists['payrange']          = JHTML::_('jobgroklist.static_payrange',$filter_payrange,$js,'filter_static_payrange'.$item_id,'postings_static_payrange','*',$params->get('view_payrange_id',''), false, $params->get('postings_search_payrange_type','dropdown'));
        
        $this->assignRef('lists',$lists);
        $this->assignRef('params', $params);
        $this->assignRef('item_id',$item_id);

        // Get data from the model
        $items = $this->get('Data');
        $pagination = $this->get('Pagination');
        $total = $this->get('Total');
        $limit = $this->get('Limit');
        $limitstart = $this->get('Limitstart');
        $format = 'html';


        // push data into the template
        $this->assignRef('items', $items);
        $this->assignRef('pagination', $pagination);
        $this->assignRef('total', $total);
        $this->assignRef('limit', $limit);
        $this->assignRef('limitstart', $limitstart);
        $this->assignRef('format',$format);

        $document->setMetaData('keywords',$params->get('menu-meta_keywords'));
        $document->setMetaData('description',$params->get('menu-meta_description'));
        
        parent :: display($tpl);
    }
}
?>
