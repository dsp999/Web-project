<?php

/**
 *
 *
 * This is the posting.php model for jobgroklist
 *
 * Created: June 13, 2014, 1:18 am
 *
 * Subversion Details
 * $Date: 2014-05-13 21:20:34 -0500 (Tue, 13 May 2014) $
 * $Revision: 6086 $
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
 jimport('joomla.application.component.model');
 jimport('joomla.application.component.helper');
 jimport('joomla.utilities.date');

 
 /**
 *
 * Posting Model
 *
 */

class JobgroklistModelPosting extends JModelLegacy

{
/**
 *
 * Posting Id
 *
 * @var int
 *
 */
    var $_id;

    /**
     *
     * Posting Data
     *
     * @var object
     *
     */
    var $_posting;
    var $_job;

    /**
     * Items total
     * @var integer
     */
    var $_total = null;

    /**
     * Pagination object
     * @var object
     */
    var $_pagination = null;

    /**
     *
     * Set query to pull data
     *
     */
    function _buildQuery()
    {

        $query = 'SELECT '.
            'p.id, p.viewlevel, p.featured, p.job_id, p.company_id, p.location_id, p.summary, p.posting_date, '.
            'IF(p.closing_days=0, p.closing_date, ADDDATE(p.posting_date, p.closing_days)) as closing_date, p.contact_id, p.notify_contact, '.
            'p.include_detail, p.application_type, p.link, p.link_text, p.tweet, p.checked_out, p.checked_out_time, p.params, p.ordering, p.hits, p.applications, '.
            'p. published, CASE WHEN CHAR_LENGTH(j.alias) THEN CONCAT_WS(":", p.id, j.alias) ELSE p.id END as slug,'.
            'j.pay_rate, j.title, j.job_description, j.category_id, static_cat.category, j.department_id, d.department, l.location, j.jobtype_id, jt.jobtype, j.company_id, cmp.company '.
            'FROM '.
            '#__tst_jglist_postings p ' .
            '	LEFT JOIN #__tst_jglist_jobs j ON p.job_id=j.id' .
            '	LEFT JOIN #__tst_jglist_categories c ON j.category_id=c.id'.
            '   LEFT JOIN #__tst_jglist_departments d ON j.department_id=d.id'.
            '   LEFT JOIN #__tst_jglist_locations l ON p.location_id=l.id'.
            '   LEFT JOIN #__tst_jglist_jobtypes jt ON j.jobtype_id=jt.id'.
            '   LEFT JOIN #__tst_jglist_static_jobtype sjt ON sjt.id=jt.code'.
            '   LEFT JOIN #__tst_jglist_companies cmp ON j.company_id=cmp.id'.
            '	LEFT JOIN #__tst_jglist_static_category static_cat ON static_cat.id=c.code'.
            '	LEFT JOIN #__tst_jglist_static_country static_cntry ON static_cntry.id=l.country_id'.
            $this->_buildQueryWhere().
            $this->_buildQueryOrderBy();

        return $query;

    }


    function _buildQueryWhere()
    {
        global $option;
        $mainframe = JFactory::getApplication();
        $db = $this->getDBO();
        //$params =$mainframe->getPageParameters('com_jobgroklist');
        //$params = JComponentHelper::getParams('com_jobgroklist');
        
        $app = JFactory::getApplication();
        $params = $app->getPageParameters();
        
        $item_id = '';
        if (JRequest::getInt('Itemid',0)!=0) $item_id=JRequest::getInt('Itemid');

        $orderby = "";

        $filter_category = $params->get('view_category_id','');
        $filter_category_desc = $params->get('view_category_desc_id','');
        $filter_category_hybrid = $params->get('view_category_hybrid_id','');
        $filter_country = $params->get('view_country_id','');
        $filter_department = $params->get('view_department_id','');
        $filter_company = $params->get('view_company_id','');
        $filter_payrate = $params->get('view_payrate_id','');
        $filter_jobcode = $params->get('view_jobcode_id','');
        $filter_jobtype = $params->get('view_jobtype_id','');
        $filter_jobtype_desc = $params->get('view_jobtype_desc_id','');
        $filter_jobtype_hybrid = $params->get('view_jobtype_hybrid_id','');
        $filter_location = $params->get('view_location_id','');
        $filter_location_desc = $params->get('view_location_desc_id','');
        $filter_payrange = $params->get('view_payrange','');

        if ($params->get('postings_search_active','0') == '2') {
            $jinput = JFactory::getApplication()->input;
            $searchtext = $jinput->post->get('searchtext', '', 'STRING');
            
        }
        
        // Determine how to filter
        if ( $filter_category == "" ) {
            if ($params->get('postings_search_category','0') == '0') {
                $filter_category = $mainframe->getUserStateFromRequest($option.'filter_category'.$item_id,'filter_category'.$item_id);
                if (is_array($filter_category)) {
                    if (count($filter_category) > 1) {
                        $not = (JRequest::getVar('filter_static_category_not')=='1'?' NOT ':'');
                        $orderby = $orderby." AND c.code $not IN (".$db->escape(implode(",",$filter_category)).")";
                    } else {
                        if ($filter_category != "" && $filter_category != "0") $orderby = $orderby." AND c.code=".$db->quote($db->escape($filter_category), false)." ";
                    }
                } else {
                    if ($filter_category != "" && $filter_category != "0") $orderby = $orderby." AND c.code=".$db->quote($db->escape($filter_category), false)." ";
                }
            }
        } else {
            $orderby = $orderby." AND static_cat.category LIKE ".$db->Quote($db->escape($filter_category))." ";
        }

        if ( $filter_category_desc == "" )
        {
            if ($params->get('postings_search_category_desc','0') == '0') {
                $filter_category_desc = $mainframe->getUserStateFromRequest($option.'filter_category_desc'.$item_id,'filter_category_desc'.$item_id);
                if ( $filter_category_desc != "" && $filter_category_desc != "0") $orderby = $orderby." AND j.category_id=".$db->quote( $db->escape( $filter_category_desc ), false )." ";
            }
        }
        else
        {
            $orderby = $orderby." AND c.description LIKE ".$db->Quote($db->escape($filter_category_desc))." ";
        }

        if ( $filter_category_hybrid == "" )
        {
            if ($params->get('postings_search_category_hybrid','0') == '0') {
                $filter_category_hybrid = $mainframe->getUserStateFromRequest($option.'filter_category_hybrid'.$item_id,'filter_category_hybrid'.$item_id);
                if ( $filter_category_hybrid != "" && $filter_category_hybrid != "0") $orderby = $orderby." AND j.category_id=".$db->quote($db->escape($filter_category_hybrid ), false )." ";
            }
        }
        else
        {
            $orderby = $orderby." AND if(c.use_description,c.description,static_cat.category) LIKE ".$db->Quote($db->escape($filter_category_desc))." ";
        }

        if ( $filter_country == "" )
        {
            if ($params->get('postings_search_country','0') == '0') {
                $filter_country = $mainframe->getUserStateFromRequest($option.'filter_country'.$item_id,'filter_country'.$item_id);
                if ( $filter_country != "" && $filter_country != "0" ) $orderby = $orderby." AND p.location_id IN (SELECT id FROM #__tst_jglist_locations WHERE country_id=".$db->quote( $db->escape( $filter_country ), false ).")";
            }
        }
        else
        {
            $orderby = $orderby." AND static_cntry.country LIKE ".$db->Quote($db->escape($filter_country))." ";
        }

        if ( $filter_department == "" )
        {
            if ($params->get('postings_search_department','0') == '0') {
                $filter_department = $mainframe->getUserStateFromRequest($option.'filter_department'.$item_id,'filter_department'.$item_id);
                if ( $filter_department != "" && $filter_department != "0" ) $orderby = $orderby." AND j.department_id IN (SELECT id FROM #__tst_jglist_departments WHERE department LIKE ".$db->quote( $db->escape( $filter_department ), false ).")";
            }
        }
        else
        {
            $orderby = $orderby." AND d.department LIKE ".$db->Quote($db->escape($filter_department))." ";
        }

        if ( $filter_company == "" )
        {
            if ($params->get('postings_search_company','0') == '0') {
                $filter_company = $mainframe->getUserStateFromRequest($option.'filter_company'.$item_id,'filter_company'.$item_id);
                if ( $filter_company != "0" && $filter_company != "" ) $orderby = $orderby." AND j.company_id IN (SELECT id FROM #__tst_jglist_companies WHERE company LIKE ".$db->quote( $db->escape( $filter_company ), false ).")";
            }
        }
        else
        {
            $orderby = $orderby." AND cmp.company LIKE ".$db->Quote($db->escape($filter_company))." ";
        }

        if ($filter_jobcode == "") {
            if ($params->get('postings_search_jobcode','0') == '0') {
                if ($params->get('postings_search_jobcode_type','dropdown') == 'textbox' &&
                    JRequest::getVar('filter_jobcode_exact') != '1') $wildcard = '%'; else $wildcard = '';
                $filter_jobcode = $mainframe->getUserStateFromRequest($option.'filter_jobcode'.$item_id,'filter_jobcode'.$item_id);
                if ($filter_jobcode != "" && $filter_jobcode != "0") $orderby = $orderby." AND j.job_code LIKE ".$db->quote( $wildcard.$db->escape( $filter_jobcode ).$wildcard, false )."";
            }
        } else {
            $orderby = $orderby." AND j.job_code LIKE ".$db->quote($db->escape($filter_jobcode),false)."";
        }

        if ($filter_payrate == "") {
            if ($params->get('postings_search_payrate','0') == '0') {
                $filter_payrate = $mainframe->getUserStateFromRequest($option.'filter_payrate'.$item_id,'filter_payrate'.$item_id);
                if (is_array($filter_payrate)) {
                    if (count($filter_payrate) > 1) {
                        $not = (JRequest::getVar('filter_payrate_not')=='1'?' NOT ':'');
                        foreach ($filter_payrate as $fp) { $new_filter_payrate[] = $db->Quote($db->escape($fp)); }
                        $orderby = $orderby." AND j.pay_rate $not IN (". implode(",",$new_filter_payrate).")";
                    } else {
                        if ($filter_payrate != "" && $filter_payrate != "0") $orderby = $orderby." AND j.pay_rate LIKE ".$db->quote( $db->escape( $filter_payrate ), false )."";
                    }
                } else {
                    if ($filter_payrate != "" && $filter_payrate != "0") $orderby = $orderby." AND j.pay_rate LIKE ".$db->quote( $db->escape( $filter_payrate ), false )."";
                }
            }
        } else {
            $orderby = $orderby." AND j.pay_rate LIKE ".$db->quote($db->escape($filter_payrate),false)."";
        }
        
        if ( $filter_jobtype == "" )
        {
            if ($params->get('postings_search_jobtype','0') == '0') {
                $filter_jobtype = $mainframe->getUserStateFromRequest($option.'filter_jobtype'.$item_id,'filter_jobtype'.$item_id);
                if (is_array($filter_jobtype)) {
                    if (count($filter_jobtype) > 1) {
                        $not = (JRequest::getVar('filter_static_jobtype_not')=='1'?' NOT ':'');
                        foreach ($filter_jobtype as $fj) { $new_filter_jobtype[] = $db->Quote($db->escape($fj)); }
                        $orderby = $orderby." AND j.jobtype_id IN (SELECT id FROM #__tst_jglist_jobtypes WHERE sjt.jobtype IN (".implode(",",$new_filter_jobtype)."))";
                    } else {
                        if ( $filter_jobtype != "" && $filter_jobtype != "0" ) $orderby = $orderby." AND j.jobtype_id IN (SELECT id FROM #__tst_jglist_jobtypes WHERE sjt.jobtype=".$db->quote( $db->escape( $filter_jobtype ), false ).")";
                    }
                } else {
                    if ( $filter_jobtype != "" && $filter_jobtype != "0" ) $orderby = $orderby." AND j.jobtype_id IN (SELECT id FROM #__tst_jglist_jobtypes WHERE sjt.jobtype=".$db->quote( $db->escape( $filter_jobtype ), false ).")";
                }
            }
        }
        else
        {
            $orderby = $orderby." AND sjt.jobtype LIKE ".$db->Quote($db->escape($filter_jobtype))." ";
        }

        if ( $filter_payrange == "" ) {
            if ($params->get('postings_search_payrange') == '0') {
                $filter_payrange = $mainframe->getUserStateFromRequest($option.'filter_static_payrange'.$item_id,'filter_static_payrange'.$item_id);
                if (is_array($filter_payrange)) {
                    if (count($filter_payrange) > 1) {
                        $not = (JRequest::getVar('filter_static_payrange_not')=='1'?' NOT ':'');
                        foreach ($filter_payrange as $pr) { $new_filter_payrange[] = (int)$pr; }
                        $orderby = $orderby." AND j.payrange $not IN (".implode(",",$new_filter_payrange).")";
                    } else {
                        if ($filter_payrange != "" && $filter_payrange != "0") $orderby = $orderby." AND j.payrange IN (".(int)$filter_payrange.")";
                    }
                } else {
                    if ($filter_payrange != "" && $filter_payrange != "0" ) $orderby = $orderby. " AND j.payrange IN (".(int)$filter_payrange.")";
                }                
            }
        } else {
            $orderby = $orderby." AND j.payrange = ".(int)$filter_payrange;
        }
        
        if ( $filter_jobtype_desc == "" )
        {
            if ($params->get('postings_search_jobtype_desc','0') == '0') {
                $filter_jobtype_desc = $mainframe->getUserStateFromRequest($option.'filter_jobtype_desc'.$item_id,'filter_jobtype_desc'.$item_id);
                if ( $filter_jobtype_desc != "" && $filter_jobtype_desc != "0") $orderby = $orderby." AND j.jobtype_id IN (SELECT id FROM #__tst_jglist_jobtypes WHERE jt.jobtype=".$db->quote( $db->escape( $filter_jobtype_desc ), false ).")";
            }
        }
        else
        {
            $orderby = $orderby." AND jt.jobtype LIKE ".$db->Quote($db->escape($filter_jobtype_desc));
        }

        if ( $filter_jobtype_hybrid == "" )
        {
            if ($params->get('postings_search_jobtype_hybrid','0') == '0') {
                $filter_jobtype_hybrid = $mainframe->getUserStateFromRequest($option.'filter_jobtype_hybrid'.$item_id,'filter_jobtype_hybrid'.$item_id);
                if ( $filter_jobtype_hybrid != "" && $filter_jobtype_hybrid != "0" ) $orderby = $orderby." AND j.jobtype_id IN (SELECT id FROM #__tst_jglist_jobtypes WHERE if(jt.use_description,jt.jobtype,sjt.jobtype)=".$db->quote( $db->escape( $filter_jobtype_hybrid ), false ).")";
            }
        }
        else
        {
            $orderby = $orderby." AND if(jt.use_description,jt.jobtype,sjt.jobtype) LIKE ".$db->quote($db->escape($filter_jobtype_hybrid),false);
        }

        if ( $filter_location == "" )
        {
            if ($params->get('postings_search_location','0') == '0') {
                $filter_location = $mainframe->getUserStateFromRequest($option.'filter_location'.$item_id,'filter_location'.$item_id);
                if (is_array($filter_location)) {
                    if (count($filter_location) > 1) {
                        $not = (JRequest::getVar('filter_location_not')=='1'?' NOT ':'');
                        $orderby = $orderby." AND l.location $not IN (SELECT location FROM #__tst_jglist_locations WHERE id IN (".$db->escape(implode(",",$filter_location))."))";
                    } else {
                        if ($filter_location != "0" && $filter_location != "") $orderby = $orderby." AND l.location IN (SELECT location FROM #__tst_jglist_locations WHERE id=".$db->quote($db->escape($filter_location),false).")";
                    }
                } else {
                    if ($filter_location != "0" && $filter_location != "") $orderby = $orderby." AND l.location IN (SELECT location FROM #__tst_jglist_locations WHERE id=".$db->quote($db->escape($filter_location),false).")";
                }
            }
        }
        else
        {
            $orderby = $orderby." AND l.location LIKE ".$db->Quote($db->escape($filter_location))." ";
        }

        if ( $filter_location_desc == "" )
        {
            if ($params->get('postings_search_location','0') == '0') {
                $filter_location_desc = $mainframe->getUserStateFromRequest($option.'filter_location_desc'.$item_id,'filter_location_desc'.$item_id);
                if (is_array($filter_location_desc)) {
                    if (count($filter_location_desc) > 0) {
                        $not = (JRequest::getVar('filter_location_desc_not')=='1'?' NOT ':'');
                        foreach ($filter_location_desc as $f) {
                            $newFilter[] = $db->Quote($db->Escaped($f));
                        }
                        $orderby = $orderby." AND l.loc_description $not IN (SELECT loc_description FROM #__tst_jglist_locations WHERE id IN (".$db->escape( implode(",",$filter_location_desc))."))";
                    } else {
                        if ( $filter_location_desc != "0" && $filter_location_desc != "" ) $orderby =  $orderby." AND l.loc_description IN (SELECT loc_description FROM #__tst_jglist_locations WHERE id=".$db->quote( $db->escape( $filter_location_desc ), false).")";
                    }
                } else {
                    if ( $filter_location_desc != "0" && $filter_location_desc != "" ) $orderby =  $orderby." AND l.loc_description IN (SELECT loc_description FROM #__tst_jglist_locations WHERE id=".$db->quote( $db->escape( $filter_location_desc ), false).")";
                }
            }
        }
        else
        {
            $orderby = $orderby." AND l.loc_description LIKE ".$db->Quote($db->escape($filter_location_desc))." ";
        }

        $config = JFactory::getConfig();
        $timenow = new JDate();
        $mysqlTime = JHTML::_('date', $timenow,"Y-m-d G:i:s");
        
        
                
        $user = JFactory::getUser();
        $viewlevels = implode(", ",JAccess::getAuthorisedViewLevels($user->id));
        
        $tmp_closing_date = 'p.closing_date';
        $tmp_closing_date = 'IF(p.closing_days=0, p.closing_date, ADDDATE(p.posting_date, p.closing_days))';

        if ($params->get('override_all_closing_dates','0') == '0') {
            $where = ' WHERE p.viewlevel IN ('.$viewlevels.') AND ((\''.$mysqlTime.'\' BETWEEN p.posting_date AND ADDDATE('.$tmp_closing_date.', INTERVAL '.$params->get('use_time_precision','1').' DAY) '.$orderby.') OR '.
                '(\''.$mysqlTime.'\' >= p.posting_date AND ('.$tmp_closing_date.'=\'0000-00-00 00:00:00\' AND p.posting_date <> \'0000-00-00 00:00:00\' '.$orderby.') OR ' .
                '(\''.$mysqlTime.'\' <= ADDDATE('.$tmp_closing_date.', INTERVAL '.$params->get('use_time_precision','1').' DAY) AND p.posting_date=\'0000-00-00 00:00:00\' '.$orderby.'))) AND p.published=1';
        } else {
            $where = ' WHERE p.viewlevel IN ('.$viewlevels.') AND \''.$mysqlTime.'\' >= p.posting_date AND p.published=1';
        }

        return $where.$orderby;
    }



    function _buildQueryOrderBy()
    {
        global $option;
	$app = JFactory::getApplication();
        $params = $app->getPageParameters();

        $item_id = '';
        if (JRequest::getInt('Itemid',0)!=0) $item_id=JRequest::getInt('Itemid');

        $orders = array('posting_date','closing_date','title','company','location');

        $filter_order = $app->getUserStateFromRequest($option.'filter_order'.$item_id,'filter_order'.$item_id,'posting_date');      
        $filter_order_Dir = $app->getUserStateFromRequest($option.'filter_order_Dir'.$item_id,'filter_order_Dir'.$item_id,'DESC');
        
        // is this posted from the form filters, or is this from a menu - if it's a menu let's use the default
        if (JRequest::getVar('filter_from_form','0') != '1') {
            $filter_order = $params->get('default_sort_field','posting_date');       
            $filter_order_Dir = $params->get('default_sort','DESC');
        }

        if (strtoupper($filter_order_Dir) != 'ASC' && strtoupper($filter_order_Dir) !='DESC')
        {
            $filter_order_Dir = $params->get('default_sort','DESC');
        }

        if ( !in_array($filter_order, $orders))
        {
            $filter_order = $params->get('default_sort_field','posting_date');
        }
        if ($filter_order == 'location') $filter_order = 'l.location';
        return ' ORDER BY '.$filter_order.' '.$filter_order_Dir.', featured DESC';
    }

    function getFeedQuery()
    {
        $query = 'SELECT '.
                '   p.id                   AS id, '.
                '   cmp.company            AS company, '.
                '   j.title                AS job_title, '.
                '   l.location             AS location, '.
                '   l.loc_description      AS loc_description, '.
                '   l.loc_address          AS loc_address, '.
                '   p.summary              AS summary, '.
                '   p.posting_date         AS posting_date, '.
                '   p.closing_date         AS closing_date, '.
                '   j.job_code             AS job_code, '.
                '   static_cat.category    AS category, '.
                '   d.department           AS department, '.
                '   s.shift                AS shift, '.
                '   jt.jobtype             AS jobtype, '.
                '   static_edu.education   AS education, '.
                '   j.pay_rate             AS pay_rate, '.
                '   static_pr.range        AS pay_range, '.
                '   j.duration             AS duration, '.
                '   j.travel               AS travel, '.
                '   j.job_description      AS job_description, '.
                '   j.preferred_skills     AS preferred_skills, '.
                '   CASE WHEN CHAR_LENGTH(j.alias) THEN CONCAT_WS(":", p.id, j.alias) ELSE p.id END as slug,'.
                '   j.category_id, j.department_id, d.department, j.jobtype_id, j.company_id '.
                'FROM '.
                '   #__tst_jglist_postings p ' .
                '   LEFT JOIN #__tst_jglist_jobs j ON p.job_id=j.id' .
                '   LEFT JOIN #__tst_jglist_categories c ON j.category_id=c.id'.
                '   LEFT JOIN #__tst_jglist_departments d ON j.department_id=d.id'.
                '   LEFT JOIN #__tst_jglist_shifts s ON j.shift_id=s.id'.
                '   LEFT JOIN #__tst_jglist_locations l ON p.location_id=l.id'.
                '   LEFT JOIN #__tst_jglist_jobtypes jt ON j.jobtype_id=jt.id'.
                '   LEFT JOIN #__tst_jglist_static_jobtype sjt ON sjt.id=jt.code'.
                '   LEFT JOIN #__tst_jglist_companies cmp ON j.company_id=cmp.id'.
                '   LEFT JOIN #__tst_jglist_static_category static_cat ON static_cat.id=c.code'.
                '   LEFT JOIN #__tst_jglist_static_country static_cntry ON static_cntry.id=l.country_id'.
                '   LEFT JOIN #__tst_jglist_static_education static_edu ON static_edu.id=education_id'.
                '   LEFT JOIN #__tst_jglist_static_payrange static_pr ON static_pr.id=payrange'.
                $this->_buildQueryWhere().
                $this->_buildQueryOrderBy();
        return $query;
    }

    /**
     *
     * Retrieves the Posting data
     *
     * @return array Array of objects containing categories data
     *
     */
    function & getData()
    {
    // if data hasn't already been obtained, load it
        if (empty($this->_posting))
        {
            $query = $this->_buildQuery();
            $limitstart = $this->getState('limitstart');
            $limit = $this->getState('limit');

            $this->_posting = $this->_getList($query, $limitstart, $limit);
        }
        return $this->_posting;
 	/*
		if (empty ($this->_posting))
		{
			$query = $this->_buildQuery();
			$this->_posting = $this->_getList($query);
		}

		return $this->_posting;*/
    }

    /**
     * Method to set the posting identifier
     *
     * @access    public
     * @param    int Posting identifier
     * @return    void
     */
    function setId($id)
    {
    // Set id and wipe data
        $this->_id = $id;
        $this->_posting = null;
    }
    /**
     *
     * Constructor
     *
     */
    function __construct()
    {
        parent :: __construct();

        // get the cid array from the default request hash
            $id = JRequest :: getInt('id', 0);
        $this->setId($id);

        $option = JRequest::getVar('option');
		$mainframe = JFactory::getApplication();

        // Get pagination request variables
        $limit = $mainframe->getUserStateFromRequest('global.list.limit', 'limit', $mainframe->getCfg('list_limit'));
        $limitstart = $mainframe->getUserStateFromRequest($option.'.limitstart', 'limitstart', 0);

        //$limitstart = mosGetParam($_REQUEST, 'limitstart', 0);
        // Am I missing something, is this a hack, or an OK solution?
        $limitstart = JRequest::getVar('limitstart',0);

        // In case limit has been changed, adjust it
        $limitstart = ($limit != 0 ? (floor($limitstart / $limit) * $limit) : 0);

        $this->setState('limit', $limit);
        $this->setState('limitstart', $limitstart);
    }

    /**
     *
     * Gets Job data
     *
     * @return object
     *
     */
    function & getPosting()
    {
        $config = JFactory::getConfig();
        $timenow = new JDate();
        $mysqlTime = JHTML::_('date', $timenow,"Y-m-d G:i:s");
        $params = JComponentHelper::getParams('com_jobgroklist');
        
        if (!$this->_posting)
        {
            $id = JRequest::getInt('id',$params->get('id',0));
            $this->setId($id);
            $db = $this->getDBO();
            
            $user = JFactory::getUser();
            $viewlevels = implode(", ",JAccess::getAuthorisedViewLevels($user->id));
            
            $tmp_closing_date = 'p.closing_date';
            $tmp_closing_date = 'IF(p.closing_days=0, p.closing_date, ADDDATE(p.posting_date, p.closing_days))';
            
            $query = "SELECT ".
                    " p.id, p.viewlevel, p.featured, p.job_id, p.company_id, p.location_id, p.summary, p.posting_date, ".
                    "IF(p.closing_days=0, p.closing_date, ADDDATE(p.posting_date, p.closing_days)) as closing_date, p.contact_id, p.notify_contact, ".
                    "p.include_detail, p.application_type, p.link, p.link_text, p.tweet, p.checked_out, p.checked_out_time, p.params, p.ordering, p.hits, p.applications, ".
                    "p. published".
                    " FROM " . $db->quoteName('#__tst_jglist_postings') . " p WHERE " .
                $db->quoteName('viewlevel').' IN ('.$viewlevels.') AND '.
                $db->quoteName('id') . ' = ' . $this->_id.' AND '.
                '(\''.$mysqlTime.'\' BETWEEN posting_date AND ADDDATE('.$tmp_closing_date.', INTERVAL '.$params->get('use_time_precision','1').' DAY)) OR '.
                '('.$db->quoteName('id').'='.$this->_id.' AND \''.$mysqlTime.'\' >= posting_date AND ('.$tmp_closing_date.'=\'0000-00-00 00:00:00\' AND posting_date <> \'0000-00-00 00:00:00\') OR ' .
                '('.$db->quoteName('id').'='.$this->_id.' AND \''.$mysqlTime.'\' <= ADDDATE('.$tmp_closing_date.', INTERVAL '.$params->get('use_time_precision','1').' DAY) AND posting_date=\'0000-00-00 00:00:00\')) ';
            $db->setQuery($query);
            $this->_posting = $db->loadObject();
            
            $this->_job = null;
            if (isset($this->_posting->job_id)) {
                $query = "SELECT * FROM " .$db->quoteName('#__tst_jglist_jobs')." WHERE ".$db->quoteName('id').'='.$this->_posting->job_id;
                $db->setQuery($query);
                $this->_job = $db->loadObject();
            }

        }
        $this->hit();

        // $this->_setApplyNow($this->_posting);
        return $this->_posting;
    }

    function getPostingJob() {
        return $this->_job;
    }
    
    function getApplyNow($text="Apply Now",$attr="")
    {
        if ( $this->_posting->application_type > 0)
        {
            $db = JFactory::getDBO();
            $query = 'SELECT link FROM #__menu WHERE id='.$this->_posting->application_type;
            $db->setQuery($query);
            $results1 = $db->loadAssoc();
            $link = JRoute::_($results1['link'].'&Itemid='.$this->_posting->application_type.'&Postingid='.$this->_posting->id);
        }
        else
        {
            $link = "";
        }

        if ($link !== "") $link = "<a $attr href='$link'>$text</a>";

        return $link;
    }


    /**
     *
     * Increments the hit counter
     *
     */
    function hit()
    {
        $db = JFactory :: getDBO();
        $db->setQuery("UPDATE " . $db->quoteName('#__tst_jglist_postings') . " SET " .
            $db->quoteName('hits') . " = " . $db->quoteName('hits') . " + 1 " .
            "WHERE id = " . $this->_id);
        $db->query();
    }

    function getTotal()
    {
    // Load the content if it doesn't already exist
        if (empty($this->_total))
        {
            $query = $this->_buildQuery();
            $this->_total = $this->_getListCount($query);
        }
        return $this->_total;
    }

    function getPagination()
    {
    // Load the content if it doesn't already exist
        if (empty($this->_pagination))
        {
            jimport('joomla.html.pagination');

            $total = $this->getTotal();
            $limitstart = $this->getState('limitstart');
            $limit = $this->getState('limit');

            $this->_pagination = new JPagination($total, $limitstart, $limit);
        }
        return $this->_pagination;
    }

    function getLimit()
    {
        return $this->getState('limit');
    }
    function getLimitstart()
    {
        return $this->getState('limitstart');
    }
}
?>
