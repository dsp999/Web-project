<?php

/**
 *
 *
 * This is the jobgrok.php helper for jobgroklist
 *
 * Created: June 13, 2014, 1:18 am
 *
 * Subversion Details
 * $Date: 2014-05-04 20:43:05 -0500 (Sun, 04 May 2014) $
 * $Revision: 6053 $
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

jimport('joomla.html.html');
jimport('joomla.utilities.date');

class JHTMLJobgroklist extends JHTML

{
    public static function getRSSLayout($row, $format) {
            $app    = JFactory::getApplication();
            $params = $app->getPageParameters();
        
            $td_start = "<tr><td nowrap='nowrap' valign='top'>";
            $td_end   = "</td></tr>\n";
            
            $company = "$td_start".JTEXT::_('COM_JOBGROKLIST_HELPERS_JOBGROK_COMPANY')."</td><td>".$row->company.$td_end;
            $job_title = $td_start.JTEXT::_('COM_JOBGROKLIST_HELPERS_JOBGROK_JOB_TITLE')."</td><td>".$row->company.$td_end;
            $location = $td_start.JTEXT::_('COM_JOBGROKLIST_HELPERS_JOBGROK_LOCATION')."</td><td>".$row->location.$td_end;
            $loc_description = $td_start."</td><td>".$row->loc_description.$td_end;
            $loc_address = $td_start."</td><td>".$row->loc_address.$td_end;        
            
            $posting_date = $td_start.JTEXT::_('COM_JOBGROKLIST_HELPERS_JOBGROK_POSTING_DATE')."</td><td>".$row->posting_date.$td_end;
            $closing_date = $td_start.JTEXT::_('COM_JOBGROKLIST_HELPERS_JOBGROK_CLOSING_DATE')."</td><td>".$row->closing_date.$td_end;
            
            $job_code = $td_start.JTEXT::_('COM_JOBGROKLIST_HELPERS_JOBGROK_JOB_CODE')."</td><td>".$row->job_code.$td_end;
            $category = $td_start.JTEXT::_('COM_JOBGROKLIST_HELPERS_JOBGROK_CATEGORY')."</td><td>".$row->category.$td_end;
            $department = $td_start.JTEXT::_('COM_JOBGROKLIST_HELPERS_JOBGROK_DEPARTMENT')."</td><td>".$row->department.$td_end;
            $shift = $td_start.JTEXT::_('COM_JOBGROKLIST_HELPERS_JOBGROK_SHIFT')."</td><td>".$row->shift.$td_end;
            $job_type = $td_start.JTEXT::_('COM_JOBGROKLIST_HELPERS_JOBGROK_JOB_TYPE')."</td><td>".$row->job_type.$td_end;
            $education = $td_start.JTEXT::_('COM_JOBGROKLIST_HELPERS_JOBGROK_EDUCATION')."</td><td>".$row->education.$td_end;
            $pay_rate = $td_start.JTEXT::_('COM_JOBGROKLIST_HELPERS_JOBGROK_PAY_RATE')."</td><td>".$row->pay_rate.$td_end;
            $pay_range = $td_start.JTEXT::_('COM_JOBGROKLIST_HELPERS_JOBGROK_PAY_RANGE')."</td><td>".$row->pay_range.$td_end;
            $duration = $td_start.JTEXT::_('COM_JOBGROKLIST_HELPERS_JOBGROK_DURATION')."</td><td>".$row->duration.$td_end;
            $travel = $td_start.JTEXT::_('COM_JOBGROKLIST_HELPERS_JOBGROK_TRAVEL')."</td><td>".$row->travel.$td_end;
            $job_description = $td_start.JTEXT::_('COM_JOBGROKLIST_HELPERS_JOBGROK_JOB_DESCRIPTION')."</td><td valign='top'>".preg_replace("/\{[^}]+\}/","",$row->job_description).$td_end;
            $preferred_skills = $td_start.JTEXT::_('COM_JOBGROKLIST_HELPERS_JOBGROK_PREFERRED_SKILLS')."</td><td valign='top'>".preg_replace("/\{[^}]+\}/","",$row->preferred_skills).$td_end;

            $rss_layout = ''; 
            if ($format == 'feed') {
                $display = array ('1', '3');
            } elseif ($format == 'app') {
                $display = array ('2', '3');
            }
            if (in_array($params->get('rss_company','1'),$display)) { $rss_layout .= $company; }
            if (in_array($params->get('rss_job_title','1'),$display)) { $rss_layout .= $job_title; }
            if (in_array($params->get('rss_location','1'),$display)) { $rss_layout .= $location; }
            if (in_array($params->get('rss_loc_description','1'),$display)) { $rss_layout .= $loc_description; }
            if (in_array($params->get('rss_loc_address','1'),$display)) { $rss_layout .= $loc_address; }
            // if (in_array($params->get('rss_summary','1'),$display)) { $rss_layout .= $summary; }
            if (in_array($params->get('rss_posting_date','1'),$display)) { $rss_layout .= $posting_date; }
            if (in_array($params->get('rss_closing_date','1'),$display)) { $rss_layout .= $closing_date; }

            if (in_array($params->get('rss_job_code','1'),$display)) { $rss_layout .= $job_code; }
            if (in_array($params->get('rss_category','1'),$display)) { $rss_layout .= $category; }
            if (in_array($params->get('rss_department','1'),$display)) { $rss_layout .= $department; }
            if (in_array($params->get('rss_shift','1'),$display)) { $rss_layout .= $shift; }
            if (in_array($params->get('rss_job_type','1'),$display)) { $rss_layout .= $job_type; }
            if (in_array($params->get('rss_education','1'),$display)) { $rss_layout .= $education; }
            if (in_array($params->get('rss_pay_rate','1'),$display)) { $rss_layout .= $pay_rate; }
            if (in_array($params->get('rss_pay_range','1'),$display)) { $rss_layout .= $pay_range; }
            if (in_array($params->get('rss_duration','1'),$display)) { $rss_layout .= $duration; }
            if (in_array($params->get('rss_travel','1'),$display)) { $rss_layout .= $travel; }
            if (in_array($params->get('rss_job_description','1'),$display)) { $rss_layout .= $job_description; }
            if (in_array($params->get('rss_preferred_skills','1'),$display)) { $rss_layout .= $preferred_skills; }
            
            return $rss_layout;
    }
    public static function posting($posting_id,$textonly=false,$alias=false)
    {
        $db = JFactory::getDBO();
        $config = JFactory::getConfig();
        $timenow = new JDate();
        $mysqlTime = JHTML::_('date', $timenow,"Y-m-d G:i:s");
        $cparams = JComponentHelper::getParams('com_jobgroklist');
        $where = ' WHERE ((\''.$mysqlTime.'\' BETWEEN p.posting_date AND ADDDATE(p.closing_date, INTERVAL '.$cparams->get('use_time_precision','1').' DAY) ) OR '.
            '(\''.$mysqlTime.'\' >= p.posting_date AND (p.closing_date=\'0000-00-00 00:00:00\' AND p.posting_date <> \'0000-00-00 00:00:00\') OR ' .
            '(\''.$mysqlTime.'\' <= ADDDATE(p.closing_date, INTERVAL '.$cparams->get('use_time_precision','1').' DAY) AND p.posting_date=\'0000-00-00 00:00:00\'))) AND p.published=1';

        if (isset($posting_id) && $posting_id >0 && $posting_id != '')
        {
            $query = "SELECT p.id as value, j.title as text, j.alias as alias FROM #__tst_jglist_postings p JOIN #__tst_jglist_jobs j ON p.job_id = j.id ".$where.' AND p.id='.$posting_id;
            $db->setQuery($query);
            $result = $db->loadAssoc();
            if ($result)
            {
                if ($textonly)
                    if ($alias) $postings = $result['alias']; else $postings = $result['text'];
                else
                    $postings = '<div id="selected_job_header">'.$result['text'].'<input type="hidden" value="'.$result['value'].'" name="posting_id" id="posting_id" /></div>';
                return $postings;
            }
            else
            {
                $postings = "no-title";
                return $postings;
            }
        }
        else
        {
            if ($textonly)
            {
                $postings = "no-title"; return $postings;
            }
        }

        $postings[] = JHTML::_('select.option','','- '.JTEXT::_('COM_JOBGROKLIST_HELPERS_JOBGROK_SELECT_POSTING').' -');
        $postings[] = JHTML::_('select.option','0',JTEXT::_('COM_JOBGROKLIST_HELPERS_JOBGROK_SUBMIT_APPLICATION_NO_JOB'));

        $query = "SELECT p.id AS value, CONCAT(p.id,' - ',j.title,IF(p.closing_date='0000-00-00 00:00:00','',CONCAT(' - Closing ',LEFT(p.closing_date,10)))) AS text FROM #__tst_jglist_postings p JOIN #__tst_jglist_jobs j ON p.job_id = j.id ".$where;
        $db->setQuery($query);
        $postings = array_merge($postings, $db->loadObjectList());
        $postings = JHTML::_('select.genericlist',$postings,'posting_id','class="inputbox" size="1"','value','text',$posting_id);

        return $postings;
    }
    public static function static_yesno($static_yesno=null,$js='',$name='id',$limit='no',$filter_value='*')
    {
        $entry1 = new stdClass();
        $entry1->value = 0;
        $entry1->text = JTEXT::_('COM_JOBGROKLIST_HELPERS_JOBGROK_NO');
        $entry2 = new stdClass();
        $entry2->value = 1;
        $entry2->text = JTEXT::_('COM_JOBGROKLIST_HELPERS_JOBGROK_YES');
        $weblinks = array( $entry1, $entry2 );
        return JHTML::_('select.radiolist', $weblinks, $name, null, 'value', 'text', $static_yesno);
    }

    public static function sort( $title, $order, $direction = 'asc', $selected = 0, $task=NULL )
    {
        $direction    = strtolower( $direction );
        $images        = array( 'arrow_up.gif','arrow_down.gif');
        $index        = intval( $direction == 'desc');
        $direction    = ($direction == 'desc') ? 'asc' : 'desc';

        $html = '<a href="javascript:tableOrdering(\''.$order.'\',\''.$direction.'\',\''.$task.'\');" title="'.JTEXT::_('COM_JOBGROKLIST_HELPERS_JOBGROK_CLICK_TO_SORT_THIS_COLUMN').'">';
        $html .= JText::_($title );
        if ($order == $selected )
        {
            $html .= JHTML::_('image', 'components'.DIRECTORY_SEPARATOR.'com_jobgroklist'.DIRECTORY_SEPARATOR.'assets'.DIRECTORY_SEPARATOR.'images'.DIRECTORY_SEPARATOR.$images[$index], NULL, NULL);
        }
        $html .= '</a>';
        return $html;
    }


    public static function static_category($static_category='*',$js='',$name='code',$limit='no',$filter_value='*',$menu_filter='',$restrict=false, $type='dropdown')
    {
        $db = JFactory::getDBO();
        $app = JFactory::getApplication();
        $params = $app->getPageParameters();
        
        $config = JFactory::getConfig();
        $timenow = new JDate();
        $mysqlTime = JHTML::_('date', $timenow,"Y-m-d G:i:s");
        
        switch ($limit)
        {
            case 'postings_static_category':
                $not_name = "filter_static_category";
                $show_all = $params->get('postings_search_category_show_all','0');
                if ($menu_filter != '') $menu_filter = "sc.category LIKE ".$db->Quote($db->escape($menu_filter))." AND ";
                if ($show_all == '1') {
                    $query = 'SELECT sc.id as value, sc.category as text FROM #__tst_jglist_static_category sc '.
                                ' JOIN #__tst_jglist_categories c ON sc.id=c.code '.
                                ' ORDER BY category';
                } else {
                    $query = 'SELECT sc.id as value, sc.category as text FROM #__tst_jglist_static_category sc '.
                                'JOIN #__tst_jglist_categories c ON sc.id=c.code '.
                                'JOIN #__tst_jglist_jobs j ON j.category_id=c.id '.
                                'JOIN #__tst_jglist_postings p ON p.job_id=j.id '.
                                ' WHERE '.$menu_filter.
                                '((\''.$mysqlTime.'\' BETWEEN p.posting_date AND ADDDATE(p.closing_date, INTERVAL '.$params->get('use_time_precision','1').' DAY) '.''.') OR '.
                                '(\''.$mysqlTime.'\' >= p.posting_date AND (p.closing_date=\'0000-00-00 00:00:00\' AND p.posting_date <> \'0000-00-00 00:00:00\' '.''.') OR ' .
                                '(\''.$mysqlTime.'\' <= ADDDATE(p.closing_date, INTERVAL '.$params->get('use_time_precision','1').' DAY) AND p.posting_date=\'0000-00-00 00:00:00\' '.''.'))) AND p.published=1 '.
                                'GROUP BY category ORDER BY category';
                }
                break;
            case 'postings_static_category_desc':
                $not_name = "filter_static_category_desc";
                $show_all = $params->get('postings_search_category_desc_show_all','0');
                if ($menu_filter != '') $menu_filter = 'c.description LIKE '.$db->Quote($db->escape($menu_filter)).' AND ';
                if ($show_all == '1') {
                    $query = 'SELECT c.id as value, c.description as text FROM #__tst_jglist_categories c '.
                        'JOIN #__tst_jglist_jobs j ON j.category_id=c.id '.
                        'JOIN #__tst_jglist_postings p ON p.job_id=j.id '.
                        'WHERE c.description <> "" GROUP BY c.description ORDER BY c.description';   
                } else {
                    $query = 'SELECT c.id as value, c.description as text FROM #__tst_jglist_categories c '.
                        'JOIN #__tst_jglist_jobs j ON j.category_id=c.id '.
                        'JOIN #__tst_jglist_postings p ON p.job_id=j.id '.
                        ' WHERE '.$menu_filter.
                        '((\''.$mysqlTime.'\' BETWEEN p.posting_date AND ADDDATE(p.closing_date, INTERVAL '.$params->get('use_time_precision','1').' DAY) '.''.') OR '.
                        '(\''.$mysqlTime.'\' >= p.posting_date AND (p.closing_date=\'0000-00-00 00:00:00\' AND p.posting_date <> \'0000-00-00 00:00:00\' '.''.') OR ' .
                        '(\''.$mysqlTime.'\' <= ADDDATE(p.closing_date, INTERVAL '.$params->get('use_time_precision','1').' DAY) AND p.posting_date=\'0000-00-00 00:00:00\' '.''.'))) AND p.published=1 '.
                        'AND c.description <> "" GROUP BY c.description ORDER BY c.description';
                }
                break;
            case 'postings_static_category_hybrid':
                $not_name = "filter_static_category_hybrid";
                $show_all = $params->get('postings_search_category_hybrid_show_all','0');
                if ($menu_filter != '') $menu_filter = 'if(c.use_description,c.description,sc.category) LIKE '.$db->Quote($db->escape($menu_filter)).' AND ';
                if ($show_all == '1') {
                    $query = 'SELECT c.id as value, IF(c.use_description,c.description,sc.category) as text FROM #__tst_jglist_static_category sc ' .
                            'JOIN #__tst_jglist_categories c ON sc.id=c.code ' .
                            'JOIN #__tst_jglist_jobs j ON j.category_id=c.id ' .
                            'JOIN #__tst_jglist_postings p ON p.job_id=j.id ' .
                            'WHERE IF(c.use_description,c.description,sc.category) <> "" ' . 
                            'GROUP BY IF(c.use_description,c.description,sc.category) ORDER BY IF(c.use_description,c.description,sc.category)';
                } else {
                    $query = 'SELECT c.id as value, IF(c.use_description,c.description,sc.category) as text FROM #__tst_jglist_static_category sc '.
                        'JOIN #__tst_jglist_categories c ON sc.id=c.code '.
                        'JOIN #__tst_jglist_jobs j ON j.category_id=c.id '.
                        'JOIN #__tst_jglist_postings p ON p.job_id=j.id '.
                        ' WHERE '.$menu_filter.
                        '((\''.$mysqlTime.'\' BETWEEN p.posting_date AND ADDDATE(p.closing_date, INTERVAL '.$params->get('use_time_precision','1').' DAY) '.''.') OR '.
                        '(\''.$mysqlTime.'\' >= p.posting_date AND (p.closing_date=\'0000-00-00 00:00:00\' AND p.posting_date <> \'0000-00-00 00:00:00\' '.''.') OR ' .
                        '(\''.$mysqlTime.'\' <= ADDDATE(p.closing_date, INTERVAL '.$params->get('use_time_precision','1').' DAY) AND p.posting_date=\'0000-00-00 00:00:00\' '.''.'))) AND p.published=1 '.
                        'AND IF(c.use_description,c.description,sc.category) <> "" GROUP BY IF(c.use_description,c.description,sc.category) ORDER BY IF(c.use_description,c.description,sc.category)';
                }
                break;
            case 'no':
            default:
                $query = 'SELECT id AS value, category AS text FROM #__tst_jglist_static_category';
        }

        //$db->setQuery($query);
        //$categorys = array_merge($categorys, $db->loadObjectList());
        //$categorys = JHTML::_('select.genericlist',$categorys,$name,'class="inputbox" size="1" '.$js, 'value', 'text', $static_category);
        //return $categorys;
        
        // START
        $db->setQuery($query);
        $results = $db->loadObjectList();
        
        switch ($type) {
            case 'checkbox':   
                $incBreak = $params->get('checkbox_layout','0')=='0'?'<br/>':'';
                $categorys = '<span>'.JTEXT::_('COM_JOBGROKLIST_HELPERS_JOBGROK_SELECT_CATEGORY').'</span><br/>'; 
                $categorys = '<input type="checkbox" name="'.$name.'[]" onchange="CheckAll(this); document.pagination_form.submit();" value="0" id="'.$name.'_0" />&nbsp;'.JTEXT::_('COM_JOBGROKLIST_HELPERS_JOBGROK_ALL_CATEGORIES').'<br/>';
                $count = 0; $total = count($results); 
                foreach ($results as $r) {
                    $count++;
                    if (is_array($static_category)) {
                        if (in_array($r->value, $static_category)) $checked = 'checked="checked"'; else $checked = '';
                    } elseif ($static_category == $r->value) {
                        $checked = 'checked="checked"';
                    } else {
                        $checked = '';
                    }    
                    $categorys .= '<input type="checkbox" '.$checked.' name="'.$name.'[]" onchange="document.pagination_form.submit();" value="'.$r->value.'" id="'.$name.'_'.$r->value.'" /><span style="padding-right: 8px; padding-left: 4px;">'.$r->text.'</span>'.$incBreak;
                }
                break;
            case 'dropdown':
                $categorys[] = JHTML::_('select.option','0','- '.JTEXT::_('COM_JOBGROKLIST_HELPERS_JOBGROK_SELECT_CATEGORY').' -');
                $categorys = array_merge($categorys, $results);
                $categorys = JHTML::_('select.genericlist',$categorys,$name,'class="inputbox" style="'.$params->get('postings_search_category_css').'" size="1" '.$js, 'value', 'text', $static_category);
                break;
        }

        // START: setting the divs
        $pre = ""; $post = "";
        if ($type == 'checkbox') {
             $pre = "<div class='checkbox_filter_background' style='float: left;'>";
             if ($limit == "postings_static_category") $pre = $pre."<div style='".$params->get('postings_search_category_header_css')."' class='checkbox_filter_header'>".JTEXT::_('COM_JOBGROKLIST_HELPERS_JOBGROK_CATEGORIES')."&nbsp;";
             //if ($limit == "postings_location_desc") $pre = $pre."<div style='".$params->get('postings_search_location_desc_header_css')."' class='checkbox_filter_header'>".JTEXT::_('COM_JOBGROKLIST_HELPERS_JOBGROK_LOCATIONS')."&nbsp;";
             $not = (JRequest::getVar($not_name.'_not')=='1'?'checked="checked"':'');
             $pre = $pre."<input type='checkbox' $not name='".$not_name."_not' id='".$not_name."_not' value='1' onchange='document.pagination_form.submit();' />&nbsp;";
             $pre = $pre."<span style='font-size: 8px; color: silver'>".JTEXT::_('COM_JOBGROKLIST_HELPERS_JOBGROK_NOT')."</span>";
             $pre = $pre."</div>";
             $post = "</div>";
        }
        switch ($limit) {
            case "postings_static_category":
                $pre = $pre."<div style='".$params->get('postings_search_category_css','display: inline;')."' class='".$params->get('postings_search_category_type','dropdown')."_filter'>";       
                $post = $post."</div>";   
                break;
        }
        // END: setting the divs
       
        return $pre.$categorys.$post;

        
    }

// JHTML::_('jobgroklist.location',
//              $filter_location,
//              $js,
//              'filter_location'.$item_id,
//              'postings_location',
//              '0',
//              $params->get('view_location_id',''), 
//              false, 
//              $params->get('postings_search_location_type','dropdown'));
// JHTML::_('jobgroklist.location',
//              $filter_location_desc,
//              $js,
//              'filter_location_desc'.$item_id,
//              'postings_location_desc',
//              '0',
//              $params->get('view_location_desc_id',''),
//              false,
//              $params->get('postings_search_location_desc_type','dropdown'));
    
    public static function location($location='*',$js='',$name='code',$limit='no',$filter_value='0',$menu_filter='',$restrict=false, $type='dropdown')
    {
        $db = JFactory::getDBO();
        $app = JFactory::getApplication();
        $params = $app->getPageParameters();
        
        $config = JFactory::getConfig();
        $timenow = new JDate();
        $mysqlTime = JHTML::_('date', $timenow,"Y-m-d G:i:s");
               
        switch ($limit)
        {
            case 'user':
                $query = ' SELECT l.id as value, CONCAT("(",IFNULL(co.company,"Global"),") ",l.location, " - ", IFNULL(l.loc_description,"'.JTEXT::_('COM_JOBGROKLIST_HELPERS_JOBGROK_NO_DESCRIPTION').'"), " - ", IFNULL(l.loc_address,"'.JTEXT::_('NO_ADDRESS').'")) as text '.
                            ' FROM #__tst_jglist_locations l '.
                            ' LEFT JOIN #__tst_jglist_companies co '.
                            '   ON co.id=l.company_id AND '.
                            '      co.user_id=l.user_id '.
' WHERE l.user_id='.JobgroklistACL::getCurrentUserId().' '.
                            ' ORDER BY CONCAT("(",IFNULL(co.company,"Global"),") ",l.location)';
                break;
            case 'postings_location':
                $not_name = "filter_location";
                $show_all = $params->get('postings_search_location_show_all','0');
                if ($menu_filter != '') $menu_filter = 'l.location LIKE '.$db->Quote($db->escape($menu_filter)).' AND ';
                if ($show_all == '1') {
                    $query = 'SELECT DISTINCT l.id as value, location as text '.
                                ' FROM #__tst_jglist_locations l LEFT OUTER JOIN #__tst_jglist_postings p '.
                                ' ON p.location_id=l.id ORDER BY l.location;';
                } else {
                    $query = 'SELECT l.id as value, location as text FROM #__tst_jglist_locations l '.
                        'JOIN #__tst_jglist_postings p ON p.location_id=l.id '.
                        ' WHERE '.$menu_filter.
                        '((\''.$mysqlTime.'\' BETWEEN p.posting_date AND ADDDATE(p.closing_date, INTERVAL '.$params->get('use_time_precision','1').' DAY) '.''.') OR '.
                        '(\''.$mysqlTime.'\' >= p.posting_date AND (p.closing_date=\'0000-00-00 00:00:00\' AND p.posting_date <> \'0000-00-00 00:00:00\' '.''.') OR ' .
                        '(\''.$mysqlTime.'\' <= ADDDATE(p.closing_date, INTERVAL '.$params->get('use_time_precision','1').' DAY) AND p.posting_date=\'0000-00-00 00:00:00\' '.''.'))) AND p.published=1 '.
                        'GROUP BY location ORDER BY location';
                }
                break;
            case 'postings_location_desc':
                $show_all = $params->get('postings_desc_search_location_show_all','0');
                $not_name = "filter_location_desc";
                if ($menu_filter != '') $menu_filter = 'l.loc_description LIKE '.$db->Quote($db->escape($menu_filter)).' AND ';
                if ($show_all == '1') {
                    $query = 'SELECT DISTINCT l.id as value, loc_description as text '.
                                ' FROM #__tst_jglist_locations l LEFT OUTER JOIN #__tst_jglist_postings p '.
                                ' ON p.location_id=l.id ORDER BY l.location;';
                } else {
                    $query = 'SELECT l.id as value, loc_description as text FROM #__tst_jglist_locations l '.
                        'JOIN #__tst_jglist_postings p ON p.location_id=l.id '.
                        ' WHERE '.$menu_filter.
                        '((\''.$mysqlTime.'\' BETWEEN p.posting_date AND ADDDATE(p.closing_date, INTERVAL '.$params->get('use_time_precision','1').' DAY) '.''.') OR '.
                        '(\''.$mysqlTime.'\' >= p.posting_date AND (p.closing_date=\'0000-00-00 00:00:00\' AND p.posting_date <> \'0000-00-00 00:00:00\' '.''.') OR ' .
                        '(\''.$mysqlTime.'\' <= ADDDATE(p.closing_date, INTERVAL '.$params->get('use_time_precision','1').' DAY) AND p.posting_date=\'0000-00-00 00:00:00\' '.''.'))) AND p.published=1 '.
                        'GROUP BY loc_description ORDER BY loc_description';
                }
                break;
            case 'no':
            default:
                $query = 'SELECT id AS value, location AS text FROM #__tst_jglist_locations';
        }

        $db->setQuery($query);
        $results = $db->loadObjectList();
        
        switch ($type) {
            case 'checkbox':   
                $incBreak = $params->get('checkbox_layout','0')=='0'?'<br/>':'';
                $locations = '<span>'.JTEXT::_('COM_JOBGROKLIST_HELPERS_JOBGROK_SELECT_LOCATION').'</span><br/>'; 
                $locations = '<input type="checkbox" name="'.$name.'[]" onchange="CheckAll(this); document.pagination_form.submit();" value="0" id="'.$name.'_0" />&nbsp;'.JTEXT::_('COM_JOBGROKLIST_HELPERS_JOBGROK_ALL_LOCATIONS').'<br/>';
                $count = 0; $total = count($results); 
                foreach ($results as $r) {
                    $count++;
                    if (is_array($location)) {
                        if (in_array($r->value, $location)) $checked = 'checked="checked"'; else $checked = '';
                    } elseif ($location == $r->value) {
                        $checked = 'checked="checked"';
                    } else {
                        $checked = '';
                    }    
                    $locations .= '<input type="checkbox" '.$checked.' name="'.$name.'[]" onchange="document.pagination_form.submit();" value="'.$r->value.'" id="'.$name.'_'.$r->value.'" /><span style="padding-right: 8px; padding-left: 4px;">'.$r->text.'</span>'.$incBreak;
                }
                break;
            case 'dropdown':
                $locations[] = JHTML::_('select.option','0','- '.JTEXT::_('COM_JOBGROKLIST_HELPERS_JOBGROK_SELECT_LOCATION').' -');
                $locations = array_merge($locations, $results);
                $locations = JHTML::_('select.genericlist',$locations,$name,'class="inputbox" style="'.$params->get('postings_search_location_css').'" size="1" '.$js, 'value', 'text', $location);
                break;
        }

        // START: setting the divs
        $pre = ""; $post = "";
        if ($type == 'checkbox') {
             $pre = "<div class='checkbox_filter_background' style='float: left;'>";
             if ($limit == "postings_location") $pre = $pre."<div style='".$params->get('postings_search_location_header_css')."' class='checkbox_filter_header'>".JTEXT::_('COM_JOBGROKLIST_HELPERS_JOBGROK_LOCATIONS')."&nbsp;";
             if ($limit == "postings_location_desc") $pre = $pre."<div style='".$params->get('postings_search_location_desc_header_css')."' class='checkbox_filter_header'>".JTEXT::_('COM_JOBGROKLIST_HELPERS_JOBGROK_LOCATIONS')."&nbsp;";
             $not = (JRequest::getVar($not_name.'_not')=='1'?'checked="checked"':'');
             $pre = $pre."<input type='checkbox' $not name='".$not_name."_not' id='".$not_name."_not' value='1' onchange='document.pagination_form.submit();' />&nbsp;";
             $pre = $pre."<span style='font-size: 8px; color: silver'>".JTEXT::_('COM_JOBGROKLIST_HELPERS_JOBGROK_NOT')."</span>";
             $pre = $pre."</div>";
             $post = "</div>";
        }
        switch ($limit) {
            case "postings_location":
                $pre = $pre."<div style='".$params->get('postings_search_location_css','display: inline;')."' class='".$params->get('postings_search_location_type','dropdown')."_filter'>";       
                $post = $post."</div>";   
                break;
            case "postings_location_desc":
                $pre = $pre."<div style='".$params->get('postings_search_location_desc_css','display: inline;')."' class='".$params->get('postings_search_location_desc_type','dropdown')."_filter'>";       
                $post = $post."</div>";
                break;
        }
        // END: setting the divs
       
        return $pre.$locations.$post;
    }

    public static function static_country($filter_location = '*',$js='',$name='filter_location',$limit='no',$filter_value='*',$menu_filter='')
    {
        $db = JFactory :: getDBO();
        $app = JFactory::getApplication();
        $params = $app->getPageParameters();
        
        $config = JFactory::getConfig();
        $timenow = new JDate();
        $mysqlTime = JHTML::_('date', $timenow,"Y-m-d G:i:s");

        $locations[] = JHTML :: _('select.option', '', '- ' . JTEXT::_('COM_JOBGROKLIST_HELPERS_JOBGROK_SELECT_COUNTRY') . ' -');

        switch ($limit)
        {
            case 'postings_country':
                $show_all = $params->get('postings_search_country_show_all','0');
                if ($menu_filter != '') $menu_filter = 'sc.country LIKE '.$db->Quote($db->escape($menu_filter)).' AND ';
                if ($show_all == '1') {
                    $query = 'SELECT sc.id as value, country as text FROM #__tst_jglist_static_country sc '.
                        'GROUP BY country ORDER BY country';                    
                } else {
                    $query = 'SELECT sc.id as value, country as text FROM #__tst_jglist_static_country sc '.
                        'JOIN #__tst_jglist_locations l ON sc.id=l.country_id '.
                        'JOIN #__tst_jglist_postings p ON p.location_id=l.id '.
                        ' WHERE '.$menu_filter.
                        '((\''.$mysqlTime.'\' BETWEEN p.posting_date AND ADDDATE(p.closing_date, INTERVAL '.$params->get('use_time_precision','1').' DAY) '.''.') OR '.
                        '(\''.$mysqlTime.'\' >= p.posting_date AND (p.closing_date=\'0000-00-00 00:00:00\' AND p.posting_date <> \'0000-00-00 00:00:00\' '.''.') OR ' .
                        '(\''.$mysqlTime.'\' <= ADDDATE(p.closing_date, INTERVAL '.$params->get('use_time_precision','1').' DAY) AND p.posting_date=\'0000-00-00 00:00:00\' '.''.'))) AND p.published=1 '.
                        'GROUP BY country ORDER BY country';
                }
                break;

            case 'no':
            default:
                if ($filter_location=='' || $filter_location=='*' || (int)$filter_location==0)
                {
                    $params = JComponentHelper::getParams('com_jobgroklist');
                    $default_code = $params->get('default_country_code');
                    $query = 'SELECT id FROM #__tst_jglist_static_country WHERE `code`="'.$default_code.'"';
                    $db->setQuery($query);
                    $tmp = $db->loadAssoc();
                    $filter_location = $tmp['id'];
                }
                $query = 'SELECT id AS value, concat("(",code,") ",country) AS text'.
                    ' FROM #__tst_jglist_static_country ORDER BY country';
                break;
        }
        $db->setQuery($query);
        $sections = array_merge($locations, $db->loadObjectList());

        $locations = JHTML :: _('select.genericlist', $sections, $name, 'class="inputbox" size="1" '.$js, 'value', 'text', $filter_location);

        return $locations;
    }

    public static function country_desc($id) {
        $db = JFactory::getDbo();
        $query = "SELECT country FROM #__tst_jglist_static_country WHERE id=".(int)$id;
        $db->setQuery($query);
        $result = $db->loadResult();
        return $result;
    }
    
    public static function department($filter_department = '*',$js='',$name='filter_department',$limit='no',$filter_value='*',$menu_filter='',$restrict=false)
    {
        $db = JFactory :: getDBO();
        $app = JFactory::getApplication();
        $params = $app->getPageParameters();
        
        $config = JFactory::getConfig();
        $timenow = new JDate();
        $mysqlTime = JHTML::_('date', $timenow,"Y-m-d G:i:s");

        $departments[] = JHTML :: _('select.option', '', '- ' . JTEXT::_('COM_JOBGROKLIST_HELPERS_JOBGROK_SELECT_DEPARTMENT') . ' -');

        switch ($limit)
        {
            case 'user':
                $query = 'SELECT d.id as value, CONCAT("(",IFNULL(co.company,"Global"),") ",d.department) as text '.
                    ' FROM #__tst_jglist_departments d '.
                    ' LEFT JOIN #__tst_jglist_companies co '.
                    '   ON co.id=d.company_id AND '.
                    '      co.user_id=d.user_id '.
' WHERE d.user_id='.JobgroklistACL::getCurrentUserId().' '.
                    ' ORDER BY CONCAT("(",IFNULL(co.company,"Global"),") ",d.department)';
                break;
            case 'postings_department':
                $show_all = $params->get('postings_search_department_show_all','0');
                if ($menu_filter != '') $menu_filter = 'd.department LIKE '.$db->Quote($db->escape($menu_filter)).' AND ';
                if ($show_all == '1') {
                    $query = 'SELECT department as value, department as text FROM #__tst_jglist_departments d '.
                        'JOIN #__tst_jglist_jobs j ON j.department_id=d.id '.
                        'GROUP BY department ORDER BY department';                    
                } else {
                    $query = 'SELECT department as value, department as text FROM #__tst_jglist_departments d '.
                        'JOIN #__tst_jglist_jobs j ON j.department_id=d.id '.
                        'JOIN #__tst_jglist_postings p ON p.job_id=j.id '.
                        ' WHERE '.$menu_filter.
                        '((\''.$mysqlTime.'\' BETWEEN p.posting_date AND ADDDATE(p.closing_date, INTERVAL '.$params->get('use_time_precision','1').' DAY) '.''.') OR '.
                        '(\''.$mysqlTime.'\' >= p.posting_date AND (p.closing_date=\'0000-00-00 00:00:00\' AND p.posting_date <> \'0000-00-00 00:00:00\' '.''.') OR ' .
                        '(\''.$mysqlTime.'\' <= ADDDATE(p.closing_date, INTERVAL '.$params->get('use_time_precision','1').' DAY) AND p.posting_date=\'0000-00-00 00:00:00\' '.''.'))) AND p.published=1 '.
                        'GROUP BY department ORDER BY department';
                }
                break;
            case 'no':
            default:
                $query = 'SELECT department AS value, department AS text '.
                    'FROM #__tst_jglist_departments GROUP BY department ORDER BY department';
                break;
        }

        $db->setQuery($query);
        $sections = array_merge($departments, $db->loadObjectList());

        $departments = JHTML :: _('select.genericlist', $sections, $name, 'class="inputbox" size="1" '.$js, 'value', 'text', $filter_department);

        return $departments;
    }

    public static function static_jobcode($filter_jobcode = '*', $js='', $name='code',$limit='no',$filter_value='*',$menu_filter='',$restrict = false, $type='dropdown') 
    {
        switch ($type) {
            case "dropdown":
                $db = JFactory::getDbo();
                $query = "SELECT DISTINCT `job_code` as value, `job_code` as text FROM `#__tst_jglist_jobs` WHERE `job_code` IS NOT NULL;";
                $db->setQuery($query);

                $jobcodes[] = JHTML::_('select.option','','- '.JTEXT::_('COM_JOBGROKLIST_HELPERS_JOBGROK_SELECT_JOBCODE').' -');
                $result = $db->loadObjectList();

                if (count($result) > 0) $sections = array_merge($jobcodes, $result); else $sections = array_merge ($jobcodes);
                $jobcodes = JHTML :: _('select.genericlist', $sections, $name, 'class="inputbox" size="1" '.$js, 'value', 'text', $filter_jobcode);
                break;
            case "textbox":
                if (JRequest::getVar('filter_jobcode_exact') == '1') $exact = 'checked="checked"'; else $exact = '';
                $jobcodes = '<div class="input_textbox"><strong>'.JTEXT::_('COM_JOBGROKLIST_HELPERS_JOBGROK_SEARCH_BY_JOBCODE').'<strong>&nbsp;<input name="'.$name.'" type="textbox" class="inputbox" size="1" '.$js.' />&nbsp;<em>['.($filter_jobcode==''?'All':$filter_jobcode).']</em>&nbsp;';
                $jobcodes = $jobcodes."<input type='checkbox' $exact name='filter_jobcode_exact' id='filter_jobcode_exact' value='1' />&nbsp;";
                $jobcodes = $jobcodes."<span style='font-size: 8px; color: silver'>".JTEXT::_('COM_JOBGROKLIST_HELPERS_JOBGROK_EXACT_MATCH')."</span></div>";
                
                break;
        }
        return $jobcodes;        
    }
    
    public static function static_payrate($filter_payrates = '*', $js='', $name='code',$limit='no',$filter_value='*',$menu_filter='',$restrict = false, $type='dropdown') 
    {
        $db = JFactory::getDbo();
        $query = "SELECT DISTINCT `pay_rate` as value, `pay_rate` as text FROM `#__tst_jglist_jobs` WHERE `pay_rate` IS NOT NULL;";
        $db->setQuery($query);
        
        $app = JFactory::getApplication();
        $params = $app->getPageParameters();
        
        switch($type) {
            case "dropdown":
                $payrates[] = JHTML::_('select.option','','- '.JTEXT::_('COM_JOBGROKLIST_HELPERS_JOBGROK_SELECT_PAYRATE').' -');
                $results = $db->loadObjectList();

                if (count($results) > 0) $sections = array_merge($payrates, $results); else $sections = array_merge ($payrates);
                $payrates = JHTML :: _('select.genericlist', $sections, $name, 'class="inputbox" size="1" '.$js, 'value', 'text', $filter_payrates);
                break;
            case "checkbox":
                $not_name = "filter_static_payrate";
                $incBreak = $params->get('checkbox_layout','0')=='0'?'<br/>':'';
                $payrates = '<span>'.JTEXT::_('COM_JOBGROKLIST_HELPERS_JOBGROK_SELECT_PAYRATE').'</span><br/>'; 
                $payrates = '<input type="checkbox" name="'.$name.'[]" onchange="CheckAll(this); document.pagination_form.submit();" value="0" id="'.$name.'_0" />&nbsp;'.JTEXT::_('COM_JOBGROKLIST_HELPERS_JOBGROK_ALL_PAYRATES').'<br/>';
                $results = $db->loadObjectList();
                $count = 0; $total = count($results); 
                foreach ($results as $r) {
                    $count++;
                    if (is_array($filter_payrates)) {
                        if (in_array($r->value, $filter_payrates)) $checked = 'checked="checked"'; else $checked = '';
                    } elseif ($filter_payrates == $r->value) {
                        $checked = 'checked="checked"';
                    } else {
                        $checked = '';
                    }    
                    $payrates .= '<input type="checkbox" '.$checked.' name="'.$name.'[]" onchange="document.pagination_form.submit();" value="'.$r->value.'" id="'.$name.'_'.$r->value.'" /><span style="padding-right: 8px; padding-left: 4px;">'.$r->text.'</span>'.$incBreak;
                }
                break;
        }

        // START: setting the divs
        $pre = ""; $post = "";
        if ($type == 'checkbox') {
             $pre = "<div class='checkbox_filter_background' style='float: left;'>";
             if ($limit == "postings_payrate") $pre = $pre."<div style='".$params->get('postings_search_payrate_header_css')."' class='checkbox_filter_header'>".JTEXT::_('COM_JOBGROKLIST_HELPERS_JOBGROK_PAYRATES')."&nbsp;";
             $not = (JRequest::getVar($not_name.'_not')=='1'?'checked="checked"':'');
             $pre = $pre."<input type='checkbox' $not name='".$not_name."_not' id='".$not_name."_not' value='1' onchange='document.pagination_form.submit();' />&nbsp;";
             $pre = $pre."<span style='font-size: 8px; color: silver'>".JTEXT::_('COM_JOBGROKLIST_HELPERS_JOBGROK_NOT')."</span>";
             $pre = $pre."</div>";
             $post = "</div>";
        }
        switch ($limit) {
            case "postings_payrate":
                $pre = $pre."<div style='".$params->get('postings_search_payrate_css','display: inline;')."' class='".$type."_filter'>";       
                $post = $post."</div>";   
                break;
        }
        // END: setting the divs
        
        return $pre.$payrates.$post;
        
    }
    
    public static function static_jobtype($filter_jobtype = '*', $js='', $name='code',$limit='no',$filter_value='*',$menu_filter='',$restrict = false, $type="dropdown")
    {
        $db = JFactory::getDBO();
        $app = JFactory::getApplication();
        $params = $app->getPageParameters();
        
        $config = JFactory::getConfig();
        $timenow = new JDate();
        $mysqlTime = JHTML::_('date', $timenow,"Y-m-d G:i:s");
        
        
        $menu_filter = '';
if ($restrict) $menu_filter = ' user_id='.JobgroklistACL::getCurrentUserId().' ';
        switch ($limit)
        {
            case 'postings_jobtype':
                $not_name = "filter_static_jobtype";
                $show_all = $params->get('postings_search_jobtype_show_all','0');
                if ($show_all == '1') {
                    $query = 'SELECT sjt.jobtype AS value, sjt.jobtype AS text'.
                            ' FROM #__tst_jglist_jobtypes jt'.
                            ' JOIN #__tst_jglist_static_jobtype sjt ON sjt.id=jt.code'.
                            ' ORDER BY sjt.jobtype';                    
                } else {
                    $query = 'SELECT sjt.jobtype AS value, sjt.jobtype AS text'.
                            ' FROM #__tst_jglist_jobtypes jt'.
                            ' JOIN #__tst_jglist_jobs j ON j.jobtype_id=jt.id'.
                            ' JOIN #__tst_jglist_postings p ON p.job_id=j.id'.
                            ' JOIN #__tst_jglist_static_jobtype sjt ON sjt.id=jt.code'.
                            ' WHERE '.$menu_filter.
                            ' ((\''.$mysqlTime.'\' BETWEEN p.posting_date AND ADDDATE(p.closing_date, INTERVAL '.$params->get('use_time_precision','1').' DAY) '.''.') OR '.
                            ' (\''.$mysqlTime.'\' >= p.posting_date AND (p.closing_date=\'0000-00-00 00:00:00\' AND p.posting_date <> \'0000-00-00 00:00:00\' '.''.') OR ' .
                            ' (\''.$mysqlTime.'\' <= ADDDATE(p.closing_date, INTERVAL '.$params->get('use_time_precision','1').' DAY) AND p.posting_date=\'0000-00-00 00:00:00\' '.''.'))) AND p.published=1 '.
                            ' GROUP BY sjt.jobtype ORDER BY sjt.jobtype';
                }
                break; 
            case 'postings_jobtype_desc':
                $not_name = "filter_static_jobtype_desc";
                $show_all = $params->get('postings_search_jobtype_desc_show_all','0');
                if ($show_all == '1') {
                    $query = 'SELECT jt.jobtype as value, jt.jobtype as text'.
                            ' FROM #__tst_jglist_jobtypes jt '.
                            ' WHERE jt.jobtype <> "" ORDER BY jt.jobtype';                    
                } else {
                    $query = 'SELECT jt.jobtype as value, jt.jobtype as text FROM #__tst_jglist_jobtypes jt '.
                            'JOIN #__tst_jglist_jobs j ON j.jobtype_id=jt.id '.
                            'JOIN #__tst_jglist_postings p on p.job_id=j.id '.
                            ' WHERE '.$menu_filter.
                            '((\''.$mysqlTime.'\' BETWEEN p.posting_date AND ADDDATE(p.closing_date, INTERVAL '.$params->get('use_time_precision','1').' DAY) '.''.') OR '.
                            '(\''.$mysqlTime.'\' >= p.posting_date AND (p.closing_date=\'0000-00-00 00:00:00\' AND p.posting_date <> \'0000-00-00 00:00:00\' '.''.') OR ' .
                            '(\''.$mysqlTime.'\' <= ADDDATE(p.closing_date, INTERVAL '.$params->get('use_time_precision','1').' DAY) AND p.posting_date=\'0000-00-00 00:00:00\' '.''.'))) AND p.published=1 '.
                            'AND jt.jobtype <> "" GROUP BY jt.jobtype ORDER BY jt.jobtype';
                }
                break;
            case 'postings_jobtype_hybrid':
                $not_name = "filter_static_jobtype_hybrid";
                $show_all = $params->get('postings_search_jobtype_desc_show_all','0');
                if ($show_all == '1') {
                    $query = 'SELECT if(jt.use_description,jt.jobtype,sjt.jobtype) as value, if(jt.use_description,jt.jobtype,sjt.jobtype) as text '.
                            ' FROM #__tst_jglist_jobtypes jt '.
                            ' JOIN #__tst_jglist_static_jobtype sjt ON sjt.id=jt.code '.
                            ' WHERE if(jt.use_description,jt.jobtype,sjt.jobtype) <> "" ORDER BY if(use_description,jobtype,sjt.jobtype)';                    
                } else {
                    $query = 'SELECT if(jt.use_description,jt.jobtype,sjt.jobtype) as value, if(jt.use_description,jt.jobtype,sjt.jobtype) as text FROM #__tst_jglist_jobtypes jt '.
                            'JOIN #__tst_jglist_jobs j ON j.jobtype_id=jt.id '.
                            'JOIN #__tst_jglist_postings p on p.job_id=j.id '.
                            'JOIN #__tst_jglist_static_jobtype sjt ON sjt.id=jt.code '.
                            ' WHERE '.$menu_filter.
                            '((\''.$mysqlTime.'\' BETWEEN p.posting_date AND ADDDATE(p.closing_date, INTERVAL '.$params->get('use_time_precision','1').' DAY) '.''.') OR '.
                            '(\''.$mysqlTime.'\' >= p.posting_date AND (p.closing_date=\'0000-00-00 00:00:00\' AND p.posting_date <> \'0000-00-00 00:00:00\' '.''.') OR ' .
                            '(\''.$mysqlTime.'\' <= ADDDATE(p.closing_date, INTERVAL '.$params->get('use_time_precision','1').' DAY) AND p.posting_date=\'0000-00-00 00:00:00\' '.''.'))) AND p.published=1 '.
                            'AND if(jt.use_description,jt.jobtype,sjt.jobtype) <> "" GROUP BY if(use_description,jobtype,sjt.jobtype) ORDER BY if(use_description,jobtype,sjt.jobtype)';
                }
                break; 
            case 'code':
                $query = 'SELECT id as value, jobtype as text FROM #__tst_jglist_static_jobtype'; 
                break;
             
        }

        // START
        $db->setQuery($query);
        $results = $db->loadObjectList();
        
        switch ($type) {
            case 'checkbox':   
                $incBreak = $params->get('checkbox_layout','0')=='0'?'<br/>':'';
                $jobtypes = '<span>'.JTEXT::_('COM_JOBGROKLIST_HELPERS_JOBGROK_SELECT_JOBTYPE').'</span><br/>'; 
                $jobtypes = '<input type="checkbox" name="'.$name.'[]" onchange="CheckAll(this); document.pagination_form.submit();" value="0" id="'.$name.'_0" />&nbsp;'.JTEXT::_('COM_JOBGROKLIST_HELPERS_JOBGROK_ALL_JOBTYPES').'<br/>';
                $count = 0; $total = count($results); 
                foreach ($results as $r) {
                    $count++;
                    if (is_array($filter_jobtype)) {
                        if (in_array($r->value, $filter_jobtype)) $checked = 'checked="checked"'; else $checked = '';
                    } elseif ($filter_jobtype == $r->value) {
                        $checked = 'checked="checked"';
                    } else {
                        $checked = '';
                    }    
                    $jobtypes .= '<input type="checkbox" '.$checked.' name="'.$name.'[]" onchange="document.pagination_form.submit();" value="'.$r->value.'" id="'.$name.'_'.$r->value.'" /><span style="padding-right: 8px; padding-left: 4px;">'.$r->text.'</span>'.$incBreak;
                }
                break;
            case 'dropdown':
                $jobtypes[] = JHTML::_('select.option','0','- '.JTEXT::_('COM_JOBGROKLIST_HELPERS_JOBGROK_SELECT_JOB_TYPE').' -');
                $jobtypes = array_merge($jobtypes, $results);
                $jobtypes = JHTML::_('select.genericlist',$jobtypes,$name,'class="inputbox" style="'.$params->get('postings_search_jobtype_css').'" size="1" '.$js, 'value', 'text', $filter_jobtype);
                break;
        }

        // START: setting the divs
        $pre = ""; $post = "";
        if ($type == 'checkbox') {
             $pre = "<div class='checkbox_filter_background' style='float: left;'>";
             if ($limit == "postings_jobtype") $pre = $pre."<div style='".$params->get('postings_search_jobtype_header_css')."' class='checkbox_filter_header'>".JTEXT::_('COM_JOBGROKLIST_HELPERS_JOBGROK_JOB_TYPES')."&nbsp;";
             if ($limit == "postings_jobtype_desc") $pre = $pre."<div style='".$params->get('postings_search_jobtype_desc_header_css')."' class='checkbox_filter_header'>".JTEXT::_('COM_JOBGROKLIST_HELPERS_JOBGROK_JOB_TYPES')."&nbsp;";
             if ($limit == "postings_jobtype_hybrid") $pre = $pre."<div style='".$params->get('postings_search_jobtype_hybrid_header_css')."' class='checkbox_filter_header'>".JTEXT::_('COM_JOBGROKLIST_HELPERS_JOBGROK_JOB_TYPES')."&nbsp;";
             $not = (JRequest::getVar($not_name.'_not')=='1'?'checked="checked"':'');
             $pre = $pre."<input type='checkbox' $not name='".$not_name."_not' id='".$not_name."_not' value='1' onchange='document.pagination_form.submit();' />&nbsp;";
             $pre = $pre."<span style='font-size: 8px; color: silver'>".JTEXT::_('COM_JOBGROKLIST_HELPERS_JOBGROK_NOT')."</span>";
             $pre = $pre."</div>";
             $post = "</div>";
        }
        switch ($limit) {
            case "postings_jobtype":
                $pre = $pre."<div style='".$params->get('postings_search_jobtype_css','display: inline;')."' class='".$type."_filter'>";       
                $post = $post."</div>";   
                break;
            case "postings_jobtype_desc":
                $pre = $pre."<div style='".$params->get('postings_search_jobtype_desc_css','display: inline;')."' class='".$type."_filter'>";       
                $post = $post."</div>";   
                break;
            case "postings_jobtype_hybrid":
                $pre = $pre."<div style='".$params->get('postings_search_jobtype_hybrid_css','display: inline;')."' class='".$type."_filter'>";       
                $post = $post."</div>";   
                break;
        }
        // END: setting the divs
       
        return $pre.$jobtypes.$post;

        
        //$db->setQuery($query);
        //$sections = array_merge($jobtypes, $db->loadObjectList());

        //$jobtypes = JHTML :: _('select.genericlist', $sections, $name, 'class="inputbox" size="1" '.$js, 'value', 'text', $filter_jobtype);

        //return $jobtypes;
        /* old method
        $jobtypes[] = JHTML :: _('select.option', '', '- ' . JTEXT::_('COM_JOBGROKLIST_HELPERS_JOBGROK_SELECT_JOB_TYPE') . ' -');
        $jobtypes[] = JHTML :: _('select.option', '1', JTEXT::_('COM_JOBGROKLIST_HELPERS_JOBGROK_FULL_TIME'));
        $jobtypes[] = JHTML :: _('select.option', '2', JTEXT::_('COM_JOBGROKLIST_HELPERS_JOBGROK_PART_TIME'));
        $jobtypes[] = JHTML :: _('select.option', '3', JTEXT::_('COM_JOBGROKLIST_HELPERS_JOBGROK_CONTRACT'));
        $jobtypes[] = JHTML :: _('select.option', '4', JTEXT::_('COM_JOBGROKLIST_HELPERS_JOBGROK_INTERNSHIP'));

        $jobtypes = JHTML :: _('select.genericlist', $jobtypes, $name, 'class="inputbox" size="1" '.$js, 'value', 'text', $filter_jobtype);

        return $jobtypes;*/
    }
    public static function company($filter_company = '*',$js='',$name='filter_company',$limit='no',$filter_value='*',$menu_filter='',$restrict = false)
    {
        $db = JFactory :: getDBO();
        $app = JFactory::getApplication();
        $params = $app->getPageParameters();

        $config = JFactory::getConfig();
        $timenow = new JDate();
        $mysqlTime = JHTML::_('date', $timenow,"Y-m-d G:i:s");

        $companies[] = JHTML :: _('select.option', '0', '- ' . JTEXT::_('COM_JOBGROKLIST_HELPERS_JOBGROK_SELECT_COMPANY') . ' -');

        switch ($limit)
        {
            case 'user':
                $query = 'SELECT id AS value, company AS text '.
                    ' FROM #__tst_jglist_companies co '.
' WHERE co.user_id='.JobgroklistACL::getCurrentUserId().' '.
                    ' ORDER BY company';
                break;
            case 'postings_company':
                if ($menu_filter != '') $menu_filter = 'c.company LIKE '.$db->Quote($db->escape($menu_filter)).' ';
                $show_all = $params->get('postings_search_category_show_all','0');
                if ($show_all == '1') {
                    $query = 'SELECT company as value, company as text FROM #__tst_jglist_companies c ORDER BY company';                    
                } else {
                    $query = 'SELECT company as value, company as text FROM #__tst_jglist_companies c '.
                        'JOIN #__tst_jglist_jobs j ON j.company_id=c.id '.
                        'JOIN #__tst_jglist_postings p ON p.job_id=j.id '.
                        ' WHERE '.(($menu_filter=='')?'':$menu_filter.' AND ').
                        '((\''.$mysqlTime.'\' BETWEEN p.posting_date AND ADDDATE(p.closing_date, INTERVAL '.$params->get('use_time_precision','1').' DAY) '.''.') OR '.
                        '(\''.$mysqlTime.'\' >= p.posting_date AND (p.closing_date=\'0000-00-00 00:00:00\' AND p.posting_date <> \'0000-00-00 00:00:00\' '.''.') OR ' .
                        '(\''.$mysqlTime.'\' <= ADDDATE(p.closing_date, INTERVAL '.$params->get('use_time_precision','1').' DAY) AND p.posting_date=\'0000-00-00 00:00:00\' '.''.'))) AND p.published=1 '.
                        'GROUP BY company ORDER BY company';
                }
                break;
            case 'id':
                $query = 'SELECT id AS value, company AS text '.
                    ' FROM #__tst_jglist_companies '.
                    ($menu_filter!=''?' WHERE '.$menu_filter:'').
                    ' ORDER BY company';
                break;
            case 'no':
            default:
                $query = 'SELECT company AS value, company AS text '.
                    ' FROM #__tst_jglist_companies '.
                    ' GROUP BY company ORDER BY company';
                break;
        }
        $db->setQuery($query);
        $sections = array_merge($companies, $db->loadObjectList());

        $companies = JHTML :: _('select.genericlist', $sections, $name, 'class="inputbox" size="1" '.$js, 'value', 'text', $filter_company);

        return $companies;
    }

    public static function location_desc($id = '') {
        if ($id == '') return "";
        $db = JFactory::getDBO();
        $query = "SELECT location"
                    ." FROM #__tst_jglist_locations"
                    ." WHERE id=".$id;
        $db->setQuery($query); $db->Query();
        if ($row = $db->loadObject()) {
            $result = $row->location;
        } else {
            $result = "";
        }
        return $result;
    }
        
    public static function company_desc($id = '') {
        if ($id == '') return "";
        $db = JFactory::getDBO();
        $query = "SELECT company"
                ." FROM #__tst_jglist_companies"
                ." WHERE id=".$id;
        $db->setQuery($query); $db->Query();
        if ($row = $db->loadObject()) {
            $result = $row->company;
        } else {
            $result = "";
        }
        return $result;
    }
    public static function static_payrange($static_payrange = '*',$js='',$name='id',$limit='no', $filter_value='*',$menu_filter='',$restrict=false, $type='dropdown') {
        $db = JFactory::getDBO();
        $app = JFactory::getApplication();
        $params = $app->getPageParameters();

        $query = "SELECT `id` AS value, `range` AS text FROM #__tst_jglist_static_payrange";
// replace([field_name],'[string_to_find]','[string_to_replace]')
        $db->setQuery($query);
        $results = $db->loadObjectList();
        
        switch ($type) {
            case 'checkbox':   
                $not_name = "filter_static_payrange";
                $incBreak = $params->get('checkbox_layout','0')=='0'?'<br/>':'';
                $payranges = '<span>'.JTEXT::_('COM_JOBGROKLIST_HELPERS_JOBGROK_SELECT_PAYRANGE').'</span><br/>'; 
                $payranges = '<input type="checkbox" name="'.$name.'[]" onchange="CheckAll(this); document.pagination_form.submit();" value="0" id="'.$name.'_0" />&nbsp;'.JTEXT::_('COM_JOBGROKLIST_HELPERS_JOBGROK_ALL_PAYRANGES').'<br/>';
                $count = 0; $total = count($results); 
                foreach ($results as $r) {
                    $count++;
                    if (is_array($static_payrange)) {
                        if (in_array($r->value, $static_payrange)) $checked = 'checked="checked"'; else $checked = '';
                    } elseif ($static_payrange == $r->value) {
                        $checked = 'checked="checked"';
                    } else {
                        $checked = '';
                    }    
                    $payranges .= '<input type="checkbox" '.$checked.' name="'.$name.'[]" onchange="document.pagination_form.submit();" value="'.$r->value.'" id="'.$name.'_'.$r->value.'" /><span style="padding-right: 8px; padding-left: 4px;">'.$r->text.'</span>'.$incBreak;
                }
                break;
            case 'dropdown':
                $payranges[] = JHTML::_('select.option','0','- '.JTEXT::_('COM_JOBGROKLIST_HELPERS_JOBGROK_SELECT_PAYRANGE').' -');
                $payranges = array_merge($payranges, $results);
                $payranges = JHTML::_('select.genericlist',$payranges,$name,'class="inputbox" style="'.$params->get('postings_search_payrange_css').'" size="1" '.$js, 'value', 'text', $static_payrange);
                break;
        }

        // START: setting the divs
        $pre = ""; $post = "";
        if ($type == 'checkbox') {
             $pre = "<div class='checkbox_filter_background' style='float: left;'>";
             if ($limit == "postings_static_payrange") $pre = $pre."<div style='".$params->get('postings_search_payrange_header_css')."' class='checkbox_filter_header'>".JTEXT::_('COM_JOBGROKLIST_HELPERS_JOBGROK_PAYRANGES')."&nbsp;";
             //if ($limit == "postings_location_desc") $pre = $pre."<div style='".$params->get('postings_search_location_desc_header_css')."' class='checkbox_filter_header'>".JTEXT::_('COM_JOBGROKLIST_HELPERS_JOBGROK_LOCATIONS')."&nbsp;";
             $not = (JRequest::getVar($not_name.'_not')=='1'?'checked="checked"':'');
             $pre = $pre."<input type='checkbox' $not name='".$not_name."_not' id='".$not_name."_not' value='1' onchange='document.pagination_form.submit();' />&nbsp;";
             $pre = $pre."<span style='font-size: 8px; color: silver'>".JTEXT::_('COM_JOBGROKLIST_HELPERS_JOBGROK_NOT')."</span>";
             $pre = $pre."</div>";
             $post = "</div>";
        }
        switch ($limit) {
            case "postings_static_payrange":
                $pre = $pre."<div style='".$params->get('postings_search_payrange_css','display: inline;')."' class='".$params->get('postings_search_payrange_type','dropdown')."_filter'>";       
                $post = $post."</div>";   
                break;
        }
        // END: setting the divs
       
        return $pre.$payranges.$post;
        
        //return $payranges;
    }
    
    public static function static_payrange_desc() {
        if (!isset($id) or $id=='') return "";
        $db = JFactory::getDbo();
        $query = "SELECT `range` FROM #__tst_jglist_static_payrange WHERE id=".(int)$id;
        $db->setQuery($query);
        $result = $db->loadResult();
        return $result;
    }
}
?>
