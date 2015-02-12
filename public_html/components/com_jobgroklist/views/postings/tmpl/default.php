<?php

/**
 *
 *
 * This is the default.php view layout for jobgroklist
 *
 * Created: June 13, 2014, 1:18 am
 *
 * Subversion Details
 * $Date: 2014-05-11 20:21:55 -0500 (Sun, 11 May 2014) $
 * $Revision: 6074 $
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
jimport('joomla.html.html');
jimport('joomla.html.parameter');
$document =JFactory::getDocument();

$display_type = $this->params->get('postings_display','single');
if ($display_type == 'block3') 
    $mod_value = 3;
else
    $mod_value = 2;

if ($this->params->get('use_jobgrok_css','1') == '1') {
    $css = ".jg_el tr, .jg_el td { border: none; }\n"
          ."form div.list-footer ul li { display: inline; list-style-type: none; padding-right: 20px !important;}\n";
    $document->addStyleDeclaration($css);
}

$css_other = $this->params->get('other_css','');
if ($css_other != '') $document->addStyleDeclaration($css_other);
$css_featured = $this->params->get('featured_css','.featured {color: red; font-weight: bold;}');
if ($css_featured != '') $document->addStyleDeclaration($css_featured);

?>

<script language="javascript" type="text/javascript">

    function CheckAll(x) {
        var allInputs = document.getElementsByName(x.name);
        for (var i = 0, max = allInputs.length; i < max; i++) 
        {
            if (allInputs[i].type == 'checkbox') {
                if (x.checked == true)
                    allInputs[i].checked = true;
                else
                    allInputs[i].checked = false;
            }
        }
    }

    function tableOrdering( order, dir, task )
    {
        var form = document.pagination_form;

        form.filter_order<?php echo $this->item_id; ?>.value    = order;
        form.filter_order_Dir<?php echo $this->item_id; ?>.value   = dir;
        form.filter_from_form.value = 1;
        document.pagination_form.submit( task );
    }
</script>
<div class="jg">
<div class="jg_el">
    <h1><?php echo $this->params->get('listing_title'); ?></h1>
<?php
    if ($this->params->get('article_above_postings','0') != '0') {
        $db = JFactory::getDBO();
        $query = "SELECT CONCAT(`introtext`,`fulltext`) as content FROM #__content WHERE id=".$this->params->get('article_above_postings','0');
        $db->setQuery($query);
        $result = $db->loadObject();
        echo JHTML::_('content.prepare',$result->content);
    }
?>
    <form name="pagination_form" method="post" action="">
        <?php
        if (($this->params->get('postings_search_category','0') == '0') ||
            ($this->params->get('postings_search_category_desc','0') == '0') ||
            ($this->params->get('postings_search_category_hybrid','0') == '0') ||
            ($this->params->get('postings_search_department','0') == '0') ||
            ($this->params->get('postings_search_country','0') == '0') ||
            ($this->params->get('postings_search_jobcode','0') == '0') ||
            ($this->params->get('postings_search_payrate','0') == '0') ||
            ($this->params->get('postings_search_jobtype','0') == '0') ||
            ($this->params->get('postings_search_jobtype_desc','0') == '0') ||
            ($this->params->get('postings_search_jobtype_hybrid','0') == '0') ||
            ($this->params->get('postings_search_company','0') == '0') ||
            ($this->params->get('postings_search_location','0') == '0') ||
            ($this->params->get('postings_search_location_desc','0') == '0') ||
            ($this->params->get('postings_search_payrange','0') == '0'))
        {
            echo '<div id="jg_el_criteria" style="background-color:'.$this->params->get('postings_background_color','#f6f6f6').'">';
            if ($this->params->get('filter_by_text_toggle','1') == '1') {
                echo '<div class="mini_header">'.$this->params->get('filter_by_text',JTEXT::_('COM_JOBGROKLIST_VIEWS_POSTINGS_TMPL_DEFAULT_FILTER_BY')).'</div>';
            }
            echo '<div id="jg_el_filters">';
            echo '<div>';
            if ($this->params->get('postings_search_category','0') == '0' &&
                $this->params->get('postings_search_category_type','dropdown') == 'dropdown') { echo $this->lists['category']; }
            if ($this->params->get('postings_search_category_desc','0') == '0') echo "<div style='display: inline;' class='dropdown_filter'>".$this->lists['category_desc']."</div>";
            if ($this->params->get('postings_search_category_hybrid','0') == '0') echo "<div style='display: inline;' class='dropdown_filter'>".$this->lists['category_hybrid']."</div>";
            if ($this->params->get('postings_search_department','0') == '0') echo "<div style='display: inline;' class='dropdown_filter'>".$this->lists['department']."</div>";
            if ($this->params->get('postings_search_country','0') == '0') echo "<div style='display: inline;' class='dropdown_filter'>".$this->lists['country']."</div>";
            if ($this->params->get('postings_search_jobcode','0') == '0' &&
                $this->params->get('postings_search_jobcode_type','dropdown') == 'dropdown') echo "<div style='display: inline;' class='dropdown_filter'>".$this->lists['jobcode']."</div>";
            if ($this->params->get('postings_search_payrate','0') == '0' &&
                $this->params->get('postings_search_payrate_type','dropdown') == 'dropdown') echo "<div style='display: inline;' class='dropdown_filter'>".$this->lists['payrate']."</div>";
            if ($this->params->get('postings_search_jobtype','0') == '0' &&
                $this->params->get('postings_search_jobtype_type','dropdown') == 'dropdown') echo "<div style='display: inline;' class='dropdown_filter'>".$this->lists['jobtype']."</div>";
            if ($this->params->get('postings_search_jobtype_desc','0') == '0' &&
                $this->params->get('postings_search_jobtype_desc_type','dropdown') == 'dropdown') echo "<div style='display: inline;' class='dropdown_filter'>".$this->lists['jobtype_desc']."</div>";
            if ($this->params->get('postings_search_jobtype_hybrid','0') == '0' &&
                $this->params->get('postings_search_jobtype_hybrid_tye','dropdown') == 'dropdown') echo "<div style='display: inline;' class='dropdown_filter'>".$this->lists['jobtype_hybrid']."</div>";
            if ($this->params->get('postings_search_company','0') == '0') echo "<div style='display: inline;' class='dropdown_filter'>".$this->lists['company']."</div>";           
            if ($this->params->get('postings_search_location','0') == '0' &&
                $this->params->get('postings_search_location_type','dropdown') == 'dropdown') { echo $this->lists['location']; }
            if ($this->params->get('postings_search_location_desc','0') == '0' &&
                $this->params->get('postings_search_location_desc_type','dropdown') == 'dropdown') { echo $this->lists['location_desc']; }
            if ($this->params->get('postings_search_payrange','0') == '0' &&
                $this->params->get('postings_search_payrange_type','dropdown') == 'dropdown') { echo $this->lists['payrange']; }
            echo '</div>';
            echo '<div style="clear: both; margin: 0 auto;"> </div>';
            echo '<div>';
            if ($this->params->get('postings_search_category','0') == '0' &&
                $this->params->get('postings_search_category_type','dropdown') == 'checkbox') { echo $this->lists['category']; }
            if ($this->params->get('postings_search_payrate','0') == '0' &&
                $this->params->get('postings_search_payrate_type','dropdown') == 'checkbox') { echo $this->lists['payrate']; }
            if ($this->params->get('postings_search_jobtype','0') == '0' &&
                $this->params->get('postings_search_jobtype_type','dropdown') == 'checkbox') { echo $this->lists['jobtype']; }
            if ($this->params->get('postings_search_jobtype_desc','0') == '0' &&
                $this->params->get('postings_search_jobtype_desc_type','dropdown') == 'checkbox') { echo $this->lists['jobtype_desc']; }
            if ($this->params->get('postings_search_jobtype_hybrid','0') == '0' &&
                $this->params->get('postings_search_jobtype_hybrid_type','dropdown') == 'checkbox') { echo $this->lists['jobtype_hybrid']; }
            if ($this->params->get('postings_search_location','0') == '0' &&
                $this->params->get('postings_search_location_type','dropdown') == 'checkbox') { echo $this->lists['location']; }
            if ($this->params->get('postings_search_location_desc','0') == '0' &&
                $this->params->get('postings_search_location_desc_type','dropdown') == 'checkbox') { echo $this->lists['location_desc']; }
            if ($this->params->get('postings_search_payrange','0') == '0' &&
                $this->params->get('postings_search_payrange_type','dropdown') == 'checkbox') { echo $this->lists['payrange']; }
            echo '</div>';
            echo '<div style="clear: both; margin: 0 auto;"> </div>';
            echo '<div>';
            if ($this->params->get('postings_search_jobcode','0') == '0' &&
                $this->params->get('postings_search_jobcode_type','dropdown') == 'textbox') { echo $this->lists['jobcode']; }            
            echo '</div>';
            echo '<div style="clear: both; margin: 0 auto;"> </div>';
            echo '</div>';           
            echo '</div>';
        }

        if (count($this->items)==0)
        {
            echo '<div id="no_postings">';
            echo $this->params->get('no_postings_found_text',JTEXT::_('COM_JOBGROKLIST_VIEWS_POSTINGS_TMPL_DEFAULT_NO_POSTINGS_FOUND'));
            echo '</div>';
        }

        echo '<div id="jg_el_listing_'.$display_type.'">';
        $k = 0;
        if ( $display_type == 'single' && count($this->items) > 0) echo '<table>';

        if ( $display_type == 'single' && count($this->items) > 0)
        {
            echo '<tr>';
            if ( $this->params->get('postings_job_title','0') == '0') echo '<th id="job_title_heading">'."<div class='sort_order'>".JHTML::_('jobgroklist.sort', JTEXT::_('COM_JOBGROKLIST_VIEWS_POSTINGS_TMPL_DEFAULT_JOB_TITLE'), 'title', $this->lists['order_Dir'], $this->lists['order'])."</div>".'</th>';
            if ( $this->params->get('postings_job_type','1') == '0') echo '<th id="job_type_heading">'."<div class='sort_order'>".JTEXT::_('COM_JOBGROKLIST_VIEWS_POSTINGS_TMPL_DEFAULT_JOB_TYPE')."</div>".'</th>';
            if ( $this->params->get('postings_department','1') == '0') echo '<th id="job_department_heading">'."<div class='sort_order'>".JTEXT::_('COM_JOBGROKLIST_VIEWS_POSTINGS_TMPL_DEFAULT_DEPARTMENT')."</div>".'</th>';
            if ( $this->params->get('postings_company','0') == '0') echo '<th id="company_heading">'."<div class='sort_order'>".JHTML::_('jobgroklist.sort', JTEXT::_('COM_JOBGROKLIST_VIEWS_POSTINGS_TMPL_DEFAULT_COMPANY'), 'company', $this->lists['order_Dir'], $this->lists['order'])."</div>".'</th>';
            if ( $this->params->get('postings_salary','0') == '0') echo '<th id="salary_heading">'."<div class='sort_order'>".JTEXT::_('COM_JOBGROKLIST_VIEWS_POSTINGS_TMPL_DEFAULT_SALARY')."</div>".'</th>'; // JHTML::_('jobgroklist.sort', JTEXT::_('COM_JOBGROKLIST_VIEWS_POSTINGS_TMPL_DEFAULT_SALARY'), 'salary', $this->lists['order_Dir'], $this->lists['order'])."</div>".'</th>';
            if ( $this->params->get('postings_location','0') == '0') echo '<th id="location_heading">'."<div class='sort_order'>".JHTML::_('jobgroklist.sort', JTEXT::_('COM_JOBGROKLIST_VIEWS_POSTINGS_TMPL_DEFAULT_LOCATION'), 'location', $this->lists['order_Dir'], $this->lists['order'])."</div>".'</th>';
            if ( $this->params->get('postings_posting_date','0') == '0' || $this->params->get('display_posted_on','1') == '1') echo '<th id="posting_date_heading">'."<div class='sort_order'>".JHTML::_('jobgroklist.sort', JTEXT::_('COM_JOBGROKLIST_VIEWS_POSTINGS_TMPL_DEFAULT_POSTING_DATE'), 'posting_date', $this->lists['order_Dir'], $this->lists['order'])."</div>".'</th>';
            if ( $this->params->get('postings_closing_date','0') == '0' || $this->params->get('display_closing_on','1') == '1') echo '<th id="closing_date_heading">'."<div class='sort_order'>".JHTML::_('jobgroklist.sort', JTEXT::_('COM_JOBGROKLIST_VIEWS_POSTINGS_TMPL_DEFAULT_CLOSING_DATE'), 'closing_date', $this->lists['order_Dir'], $this->lists['order'])."</div>".'</th>';
            echo '</tr>';
        }

        for ($i=0, $n=count( $this->items ); $i < $n; $i++)
        {
            $row = $this->items[$i];
            $checked = JHTML::_( 'grid.id', $i, $row->id );
            //$link = JRoute::_( 'index.php?option=com_jobgroklist&view=posting&id='. $row->id.'&Itemid='.$this->item_id);
            //$link = JRoute::_( 'index.php?view=posting&id='. $row->slug);
            $title = JHTML::_('jobgroklist.posting',$row->id,true,true);
            //$link = JRoute::_('index.php?option=com_jobgroklist&view=posting&id=' . $row->id . ':' . $title . '&Itemid='.$this->item_id, false);
            $link = JRoute::_('index.php?option=com_jobgroklist&view=posting&returnl='.JRequest::getVar('layout').'&id=' . $row->id . ':' . $title . '&Itemid='.$this->item_id, false);
            
            $my_open_date = new JDate($row->posting_date);
            $my_close_date = new JDate($row->closing_date);
            $my_current_date = new JDate();
            $days_old = round(($my_current_date->format('U') - $my_open_date->format('U')) / (60*60*24));
            $db = JFactory::getDBO();

            $row_stat = $i % $mod_value;
            if ($row_stat == 1) $row_style = $this->params->get('odd_row_css',''); else $row_style = $this->params->get('even_row_css','');
            
            
            echo '<'.($display_type=='single'?'tr':'div').' onclick="window.location=\''.$link.'\'" style="'.$row_style.'" class="'.($row->featured=='1'?'featured':'').' jg_row'.($i%$mod_value).'">';
            if ( $this->params->get('postings_job_title','0') == '0' ||
                $this->params->get('postings_job_type','1') == '0' ||
                $this->params->get('postings_department','1') == '0' ||
                $this->params->get('postings_company','0') == '0' ||
                $this->params->get('postings_salary','0') == '0' ||
                $this->params->get('postings_location','0') == '0' ||
                $this->params->get('postings_posting_date','0') == '0' ||
                $this->params->get('display_posted_on','1') == '1')
            {
                if ($display_type=='block1') echo "<div class='jg_blockheader'>";
                if ( $this->params->get('postings_job_title','0') == '0')
                {
                    $query = 'SELECT title FROM `#__tst_jglist_jobs` WHERE id='.$row->job_id;
                    $db->setQuery($query);
                    echo '<'.($display_type=='single'?'td':'div').' class="jg_jobtitle">';
                    if ($this->params->get('display_new_indicator','0') == '1' &&
                        $days_old <= (int)$this->params->get('display_new_days','3')) {
                        $is_new_style = $this->params->get('display_new_css','color:green; font-weight: bold;');
                        $is_new_text = $this->params->get('display_new_text','New!');
                        $is_new = '&nbsp;<span style="'.$is_new_style.'">'.$is_new_text.'</span>'; 
                    } else {
                        $is_new = "";
                    }
                    if ($row->featured == '1') {
                        $is_featured_text = $this->params->get('display_featured_text','Featured Job!');
                        $is_featured = '&nbsp;<span class="featured_text">'.$is_featured_text.'</span>&nbsp;'; 
                    } else {
                        $is_featured = "";
                    }
                    if ($display_type != 'block1' && $display_type != 'block2' && $display_type != 'block3')
                        echo '<strong>'.$db->loadResult().'</strong>'.$is_featured.$is_new;
                    else
                        echo $db->loadResult().$is_featured.$is_new;
                    echo '</'.($display_type=='single'?'td':'div').'>';
                }
                if ( $this->params->get('postings_job_type','1') == '0')
                {
                    $query = 'select j.id, j.title, sjt.jobtype, jt.jobtype as description, jt.use_description '
                                .'from #__tst_jglist_jobs j '
                                .'join #__tst_jglist_jobtypes jt ON jt.id=j.jobtype_id '
                                .'join #__tst_jglist_static_jobtype sjt on sjt.id=jt.code '
                             .'where '
                                .'j.id='.$row->job_id;
                    $db->setQuery($query);
                    $item = $db->loadObject();
                    echo '<'.($display_type=='single'?'td':'div').' class="jg_jobtitle">';
                    if ($display_type != 'block1' && $display_type != 'block2' && $display_type != 'block3')
                        echo '<strong>'.($item->use_description==0?$item->jobtype:$item->description).'</strong>';
                    else
                        echo ($item->use_description==0?$item->jobtype:$item->description);
                    echo '</'.($display_type=='single'?'td':'div').'>';
                }
                if ( $this->params->get('postings_department','1') == '0') {
                    echo '<'.($display_type=='single'?'td':'div').' class="jg_department">';
                    echo $row->department;
                    echo '</'.($display_type=='single'?'td':'div').'>';
                }
                if ( $this->params->get('postings_company','0') == '0')
                {
                    $query = 'SELECT company FROM `#__tst_jglist_companies` WHERE id IN (SELECT company_id FROM `#__tst_jglist_jobs` WHERE id='.$row->job_id.')';
                    $db->setQuery($query);
                    echo '<'.($display_type=='single'?'td':'div').' class="jg_company">';
                    echo $db->loadResult();
                    echo '</'.($display_type=='single'?'td':'div').'>';
                }
                if ( $this->params->get('postings_salary','0') == '0')
                {
                    $p_paramsdata = $row->params;
                    $p_params = new JRegistry( $p_paramsdata ); // , $p_paramsdefs );

                    $query = 'SELECT pay_rate,hide_payrate FROM `#__tst_jglist_jobs` WHERE id='.$row->job_id;
                    $db->setQuery($query); $payrate_result = $db->loadObject();
                    if (isset($payrate_result->pay_rate)) $payrate = $payrate_result->pay_rate; else $payrate = '';
                    if (isset($payrate_result->hide_payrate)) $hide_payrate = $payrate_result->hide_payrate; else $hide_payrate = '0';
                    echo '<'.($display_type=='single'?'td':'div').' class="jg_salary">';
                    if ($display_type != 'block1' && $display_type != 'block2' && $display_type != 'block3') {
                        if ($this->params->get('display_pay_rate','1')=='0' 
                            || $hide_payrate=='1'
                            || $p_params->get('display_pay_rate','1')=='0'
                            ) echo JTEXT::_('COM_JOBGROKLIST_VIEWS_POSTINGS_TMPL_DEFAULT_NA'); else echo $payrate;
                    } else {
                        echo $payrate; // $db->loadResult();
                    } 
                    echo '</'.($display_type=='single'?'td':'div').'>';
                }
                if ( $this->params->get('postings_location','0') == '0')
                {
                    $query = 'SELECT l.location, sc.country FROM `#__tst_jglist_locations` l JOIN #__tst_jglist_static_country sc ON sc.id=l.country_id  WHERE l.id='.$row->location_id.' GROUP BY location';
                    $db->setQuery($query);
                    $result = $db->loadAssoc();
                    echo '<'.($display_type=='single'?'td':'div').' class="jg_location">';
                    echo $row->location; // $result['location'];
                    if (isset($result['country']) && $result['country'] != '' && $this->params->get('postings_country','0') == '0')
                            echo '&nbsp;<em>'.$result['country'].'</em>';
                    echo '</'.($display_type=='single'?'td':'div').'>';
                }

                if ($display_type=='block1') echo "<div style='clear: both; margin: 0 auto;'> </div></div>";
                if ( ($this->params->get('postings_posting_date','0') == '0' || $this->params->get('display_posted_on','1') == '1')
                        &&
                    $row->posting_date != '0000-00-00 00:00:00')
                {
                    echo '<'.($display_type=='single'?'td':'div').' class="jg_posting_date">';

                    // seems to be some issue with this...
                    echo ($display_type=='single'?'':JTEXT::_('COM_JOBGROKLIST_VIEWS_POSTINGS_TMPL_DEFAULT_POSTING_DATE').':&nbsp;').$my_open_date->format($this->params->get('listing_date_format',JText::_('m-d-Y')));
                    echo '</'.($display_type=='single'?'td':'div').'>';
                }
                if ( $this->params->get('postings_summary','0') == '0' && $display_type != 'single')
                {
                    echo '<'.($display_type=='single'?'td':'div').' class="jg_summary">';
                    if ($this->params->get('allow_plugin_summary','0') == '0') echo $row->summary; else echo JHTML::_('content.prepare',$row->summary);
                    echo '</'.($display_type=='single'?'td':'div').'>';
                }
                if ( $this->params->get('postings_submit_application','0') == '0' ||
                    ($this->params->get('postings_closing_date','0') == '0' || $this->params->get('display_closing_on','1') == '1') )
                {
                    if ($this->params->get('postings_submit_application','0') == '0')
                    {
                        if ( $display_type != 'single')
                        {
                            $query = 'SELECT contact, contact_email FROM `#__tst_jglist_contacts` WHERE id='.$row->contact_id;
                            $db->setQuery($query);
                            $results = $db->loadAssoc();
                            echo '<'.($display_type=='single'?'td':'div').' class="jg_contact">';
                            echo '<span class="jg_apply_link">'.JTEXT::_('COM_JOBGROKLIST_VIEWS_POSTINGS_TMPL_DEFAULT_APPLY_TO').'</span>&nbsp;';
                            if (isset($results)) {
                                echo JHTML::_('email.cloak', $results['contact_email'], true, $results['contact'], false);
                            } else {
                                echo JTEXT::_('COM_JOBGROKLIST_VIEWS_POSTINGS_TMPL_DEFAULT_NA');
                            }
                            echo '</'.($display_type=='single'?'td':'div').'>';
                        }
                    }
                }
                if ( $this->params->get('postings_closing_date','0') == '0' || $this->params->get('display_closing_on','1') == '1')
                {
                    echo '<'.($display_type=='single'?'td':'div').' class="jg_closing_date">';
                    if ($row->closing_date != '0000-00-00 00:00:00')
                        echo ($display_type=='single'?'':JTEXT::_('COM_JOBGROKLIST_VIEWS_POSTINGS_TMPL_DEFAULT_CLOSING_DATE').':&nbsp;').$my_close_date->format($this->params->get('listing_date_format',JText::_('m-d-Y')));
                    else
                        echo $this->params->get('postings_closing_text','Posting always Open');
                    echo '</'.($display_type=='single'?'td':'div').'>';
                }
                if ( $this->params->get('postings_read_more','0') == '0' && $display_type != 'single')
                {
                    echo '<'.($display_type=='single'?'td':'div').' class="jg_readmore">';
                    echo '<strong>'.JTEXT::_('COM_JOBGROKLIST_VIEWS_POSTINGS_TMPL_DEFAULT_READ_MORE').'&raquo;</strong>';
                    echo '</'.($display_type=='single'?'td':'div').'>';
                }
                if ($display_type == 'block1') echo '<div style="clear: both; margin 0 auto"> </div>';
                echo '</'.($display_type=='single'?'tr':'div').'>';
                $k = 1 - $k;
            }
        }

        if ( $display_type == 'single' && count($this->items) > 0)
        {
            echo '<tr class="jg_row2">';
            if ( $this->params->get('postings_job_title','0') == '0') echo '<th>&nbsp;</th>';
            if ( $this->params->get('postings_job_type','1') == '0') echo '<th>&nbsp;</th>';
            if ( $this->params->get('postings_department','1') == '0') echo '<th>&nbsp;</th>';
            if ( $this->params->get('postings_company','0') == '0') echo '<th>&nbsp;</th>';
            if ( $this->params->get('postings_salary','0') == '0') echo '<th>&nbsp;</th>';
            if ( $this->params->get('postings_location','0') == '0') echo '<th>&nbsp;</th>';
            if ( $this->params->get('postings_posting_date','0') == '0' || $this->params->get('display_posted_on','1') == '1') echo '<th>&nbsp;</th>';
            if ( $this->params->get('postings_closing_date','0') == '0' || $this->params->get('display_closing_on','1') == '1') echo '<th>&nbsp;</th>';
            echo '</tr>';
        }

        if ( $display_type == 'single' && count($this->items) > 0) echo '</table>';
        if ( $display_type == 'block1' || $display_type == 'block2' || $display_type == 'block3')
            echo '<div style="clear: both; margin: 0 auto;"> </div>';
        echo '</div>'; ?>

<?php if ($this->params->get('display_rss_feed','1') == '1' || 
          $this->params->get('display_atom_feed','1') == '1') : ?>
<table width="100%"><tr><td style="text-align: right;">
<?php if ($this->params->get('display_rss_feed','1') == '1'): ?>
<?php $rsslink = "index.php?option=com_jobgroklist&amp;view=postings&amp;format=feed&amp;type=rss&amp;Itemid=".JRequest::getVar('Itemid',''); ?>
<span style="padding-left: 10px;">
    <a href="<?php echo $rsslink; ?>"><img src="components/com_jobgroklist/assets/images/rss_feed_h16.png" /></a>
</span>
<?php endif; ?>
<?php if ($this->params->get('display_atom_feed','1') == '1'): ?>
<?php $atomlink = "index.php?option=com_jobgroklist&amp;view=postings&amp;format=feed&amp;type=atom&amp;Itemid=".JRequest::getVar('Itemid',''); ?>
<span style="padding-left: 10px;">
    <a href="<?php echo $atomlink; ?>"><img src="components/com_jobgroklist/assets/images/atom_feed_h16.png" /></a>
</span>
<?php endif; ?>
</td></tr></table>
<?php endif; ?>
        
        <?php echo $this->pagination->getListFooter(); ?>
        <input type="hidden" name="option" value="com_jobgroklist" />
        <input type="hidden" name="view" value="postings" />
        <input type="hidden" name="Itemid" value="<?php echo JRequest::getVar('Itemid',''); ?>" />
        <input type="hidden" name="filter_order<?php echo $this->item_id; ?>" value="<?php echo $this->lists['order']; ?>" />
        <input type="hidden" name="filter_order_Dir<?php echo $this->item_id; ?>" value="" />
        <input type="hidden" name="filter_from_form" value="0" />
    </form>
</div>
</div>
<div id="credits" style="width: 100%"><?php echo JTEXT::_('COM_JOBGROKLIST_VIEWS_POSTINGS_TMPL_DEFAULT_POWERED_BY'); 
?>&nbsp;<a href="http://www.jobgrok.com"><?php echo JTEXT::_('COM_JOBGROKLIST_VIEWS_POSTINGS_TMPL_DEFAULT_JOBGROK'); ?></a></div>

