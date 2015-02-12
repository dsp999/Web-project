<?php

/**
 *
 *
 * This is the responsive.php view layout for jobgroklist
 *
 * Created: June 13, 2014, 1:18 am
 *
 * Subversion Details
 * $Date: 2013-10-07 20:19:00 -0500 (Mon, 07 Oct 2013) $
 * $Revision: 5517 $
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

jimport('bootstrap.framework');

$db             = JFactory::getDbo();
$document       = JFactory::getDocument();

$column_count   = 0;
$less_column    = 0;

$css            = ".table-hover tbody tr:hover > td { cursor: pointer }";
$css_other      = $this->params->get('other_css','');

$document->addStyleSheet($this->baseurl . '/media/jui/css/bootstrap.css');
$document->addStyleDeclaration($css);
$document->addStyleDeclaration($css_other);

?>
<script>
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

    <?php
        // is plugin installed (this uses Joomla!'s native search) 
        $db = JFactory::getDBO();
        $query = "SELECT COUNT(*) FROM #__extensions WHERE element='jgsearchlist' AND type='plugin' AND enabled=1";
        $db->setQuery($query);
        $result = $db->loadResult();
    ?>
    <?php if ($result != '0' && $this->params->get('postings_search_active','0') == '1') : ?>
        <form class="well form-search form-horizontal" id="searchForm" name="searchForm" method="post" action="index.php?com_option=search&view=search">
            <?php echo $this->params->get('postings_search_text','')==''?'':'<label>'.$this->params->get('postings_search_text').'</label>'; ?>
            <input type="text" class="input-medium search-query" placeholder="<?php echo $this->params->get('postings_search_placeholder'); ?>" name="searchword" alt="Search" />
            <button type="submit" class="btn">Search</button>
            <input type="hidden" name="task" value="search" />
            <input type="hidden" name="option" value="com_search" />
            <input type="hidden" name="areas[]" value="jgsearchlist" />
            <input type="hidden" name="Itemid" value="<?php echo JRequest::getVar('Itemid',''); ?>" />
        </form>
        <form name="pagination_form" method="post" action="">
    <?php elseif ($this->params->get('postings_search_active','0') == '2') : ?>
        <form name="pagination_form" method="post" action="">
            <div>
                <label><?php echo $this->params->get('postings_search_text',JTEXT::_('COM_JOBGROKLIST_VIEWS_POSTINGS_TMPL_RESPONSIVE_SEARCH_FOR')); ?></label>
                <input type="text" class="input-medium search-query" placeholder="<?php echo $this->params->get('postings_search_placeholder'); ?>" name="searchword" alt="Search" />
                <button type="submit" class="btn">Search</button>
            </div>
    <?php endif; ?>

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
            echo '<div>';
            if ($this->params->get('filter_by_text_toggle','1') == '1') {
                echo '<div class="mini_header">'.$this->params->get('filter_by_text',JTEXT::_('COM_JOBGROKLIST_VIEWS_POSTINGS_TMPL_RESPONSIVE_FILTER_BY')).'</div>';
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
?>

<table width="100%">
    <tr>
        <td style="text-align: left;">
            <strong><?php echo $this->params->get('listing_title'); ?></strong>            
        </td>
        <?php if ($this->params->get('display_rss_feed','1') == '1' || $this->params->get('display_atom_feed','1') == '1') : ?>
        <td style="text-align: right;">
        <?php if ($this->params->get('display_rss_feed','1') == '1'): ?>
            <?php $rsslink = "index.php?option=com_jobgroklist&amp;view=postings&amp;format=feed&amp;type=rss&amp;Itemid=".JRequest::getVar('Itemid',''); ?>
            <span style="padding-left: 10px;">
            <a href="<?php echo $rsslink; ?>"><img src="components/com_jobgroklist/assets/images/rss_feed_h16.png" /></a>
            </span>
        <?php endif; ?>
        <?php if ($this->params->get('display_atom_feed','1') == '1') : ?>
            <?php $atomlink = "index.php?option=com_jobgroklist&amp;view=postings&amp;format=feed&amp;type=atom&amp;Itemid=".JRequest::getVar('Itemid',''); ?>
            <span style="padding-left: 10px;">
            <a href="<?php echo $atomlink; ?>"><img src="components/com_jobgroklist/assets/images/atom_feed_h16.png" /></a>
            </span>
        <?php endif; ?>
        </td>
        <?php endif; ?>
    </tr>
</table>

    <?php if (count($this->items)==0) : ?>
    <p class="text-center text-info"><?php echo $this->params->get('no_postings_found_text', JTEXT::_('COM_JOBGROKLIST_VIEWS_POSTINGS_TMPL_RESPONSIVE_NO_POSTINGS_FOUND')); ?></p>
    <?php else : ?>
    
    <form name="pagination_form" method="post" action="">
        <table class="table table-condensed table-hover">
            <thead>
                <tr>
                    <?php if ($this->params->get('postings_job_title','0') == '0') : ?>
                    <th><?php echo JHTML::_('jobgroklist.sort', JTEXT::_('COM_JOBGROKLIST_VIEWS_POSTINGS_TMPL_RESPONSIVE_JOB_TITLE'), 'title', $this->lists['order_Dir'], $this->lists['order']); ?></th>
                    <?php $column_count++; endif; ?>
                    <?php if ($this->params->get('postings_job_type','1') == '0') : ?>
                    <th class="hidden-phone"><?php echo JTEXT::_('COM_JOBGROKLIST_VIEWS_POSTINGS_TMPL_RESPONSIVE_JOB_TYPE'); ?></th>
                    <?php $column_count++; endif; ?>
                    <?php if ($this->params->get('postings_category','1') == '0') : ?>
                    <th class="hidden-phone"><?php echo JTEXT::_('COM_JOBGROKLIST_VIEWS_POSTINGS_TMPL_RESPONSIVE_CATEGORY'); ?></th>
                    <?php $column_count++; endif; ?>
                    <?php if ($this->params->get('postings_department','1') == '0') : ?>
                    <th class="hidden-phone"><?php echo JTEXT::_('COM_JOBGROKLIST_VIEWS_POSTINGS_TMPL_RESPONSIVE_DEPARTMENT'); ?></th>
                    <?php $column_count++; endif; ?>
                    <?php if ($this->params->get('postings_company','0') == '0') : ?>
                    <th class="hidden-phone"><?php echo JHTML::_('jobgroklist.sort', JTEXT::_('COM_JOBGROKLIST_VIEWS_POSTINGS_TMPL_RESPONSIVE_COMPANY'), 'company', $this->lists['order_Dir'], $this->lists['order']); ?></th>
                    <?php $column_count++; endif; ?>
                    <?php if ($this->params->get('postings_salary','0') == '0') : ?>
                    <th class="hidden-phone"><?php echo JTEXT::_('COM_JOBGROKLIST_VIEWS_POSTINGS_TMPL_RESPONSIVE_SALARY'); ?></th>
                    <?php $column_count++; endif; ?>
                    <?php if ( $this->params->get('postings_location','0') == '0') : ?>
                    <th class="hidden-phone"><?php echo JHTML::_('jobgroklist.sort', JTEXT::_('COM_JOBGROKLIST_VIEWS_POSTINGS_TMPL_RESPONSIVE_LOCATION'), 'location', $this->lists['order_Dir'], $this->lists['order']); ?></th>
                    <?php $column_count++; endif; ?>
                    <?php if ($this->params->get('postings_posting_date','0') == '0') : ?>
                    <th nowrap="nowrap" class="hidden-phone"><?php echo JHTML::_('jobgroklist.sort', JTEXT::_('COM_JOBGROKLIST_VIEWS_POSTINGS_TMPL_RESPONSIVE_POSTING_DATE'), 'posting_date', $this->lists['order_Dir'], $this->lists['order']); ?></th>
                    <?php $column_count++; endif; ?>
                    <?php if ( $this->params->get('postings_closing_date','0') == '0') : ?>
                    <th nowrap="nowrap" class="hidden-phone"><?php echo JHTML::_('jobgroklist.sort', JTEXT::_('COM_JOBGROKLIST_VIEWS_POSTINGS_TMPL_RESPONSIVE_CLOSING_DATE'), 'closing_date', $this->lists['order_Dir'], $this->lists['order']); ?></th>
                    <?php $column_count++; endif; ?>
                </tr>
            </thead>
    <?php for ($i=0, $n=count( $this->items ); $i < $n; $i++) : ?>
    <?php 
        // some prep for each entry
        $row = $this->items[$i]; 
        $title = JHTML::_('jobgroklist.posting',$row->id,true,true);
        $link = JRoute::_('index.php?option=com_jobgroklist&view=posting&returnl='.JRequest::getVar('layout').'&id=' . $row->id . ':' . $title . '&Itemid='.$this->item_id, false);
        $less_column = 0;
        $my_open_date = new JDate($row->posting_date);
        $my_close_date = new JDate($row->closing_date);
        $my_current_date = new JDate();
        $days_old = round(($my_current_date->format('U') - $my_open_date->format('U')) / (60*60*24));

    ?>
    <tr onclick="window.location='<?php echo $link; ?>'">
        <div class="panel panel-default">
    <?php if ($this->params->get('postings_job_title','0') == '0') : ?>
        
        <?php
        // JOB TITLE
        $query = "SELECT title FROM `#__tst_jglist_jobs` WHERE id=".$row->job_id;
        $db->setQuery($query);
        
        if ($this->params->get('display_new_indicator','0') == '1' &&
            $days_old <= (int)$this->params->get('display_new_days','3')) {
            $is_new_text = $this->params->get('display_new_text','New!');
            $is_new = '<span class="label label-success">'.$is_new_text.'</span>&nbsp;'; 
        } else {
            $is_new = "";
        }
        
        if ($row->featured == '1') {
            $is_featured_text = $this->params->get('display_featured_text','Featured Job!');
            $is_featured = '&nbsp;<span class="badge badge-info">'.$is_featured_text.'</span>'; 
        } else {
            $is_featured = "";
        }
        
        echo '<td>';
        echo $is_new.'<strong><a href="'.$link.'">'.$db->loadResult().'</a></strong>'.$is_featured;
        
        // display posting date on phone if active
        $show_date_table = '';
        if (($this->params->get('postings_posting_date','0') == '0') && $row->posting_date != '0000-00-00 00:00:00') {
            $show_date_table = '<table class="visible-phone">';
            echo $show_date_table.'<tr><td><em>'.JTEXT::_('COM_JOBGROKLIST_VIEWS_POSTINGS_TMPL_RESPONSIVE_POSTING_DATE').':</em></td><td><em>'.$my_open_date->format($this->params->get('listing_date_format',JText::_('m-d-Y'))).'</em></td></tr>';
        }
        // display closing date on phone if active
        if ( $this->params->get('postings_closing_date','0') == '0' || $this->params->get('display_closing_on','1') == '1') {
            if ($show_date_table == '') { $show_date_table = '<table class="visible-phone">'; echo $show_date_table; }
            if ($row->closing_date != '0000-00-00 00:00:00') {
                echo '<tr><td><em>'.JTEXT::_('COM_JOBGROKLIST_VIEWS_POSTINGS_TMPL_RESPONSIVE_CLOSING_DATE').':</em></td><td><em>'.$my_close_date->format($this->params->get('listing_date_format',JText::_('m-d-Y'))).'</em></td></tr>';
            } else {
                echo '<tr><td colspan="2"><em>'.$this->params->get('postings_closing_text','Posting always Open').'</em></td></tr>';
            }
        }
        if ( $show_date_table != '') echo '</table>';
        
        echo '</td>';
        ?>
        
    <?php endif; ?> 
        <div class="panel-body">
    <?php if ($this->params->get('postings_job_type','1') == '0') : ?>

        <?php
        // JOBTYPE
        $query = 'select j.id, j.title, sjt.jobtype, jt.jobtype as description, jt.use_description '
                .'from #__tst_jglist_jobs j '
                .'join #__tst_jglist_jobtypes jt ON jt.id=j.jobtype_id '
                .'join #__tst_jglist_static_jobtype sjt on sjt.id=jt.code '
                .'where '
                .'j.id='.$row->job_id;
        $db->setQuery($query);
        $item = $db->loadObject();
        echo '<td class="hidden-phone">';
        if ($item) echo ($item->use_description==0?$item->jobtype:$item->description);
        echo '</td>';
        ?>
        
    <?php endif; ?>
            
    <?php if ($this->params->get('postings_category','1') == '0') : ?>
    <?php
        echo '<td class="hidden-phone">'.$row->category.'</td>';
    ?>
    <?php endif ?>
            
    <?php if ($this->params->get('postings_department','1') == '0') : ?>
    <?php
        echo '<td class="hidden-phone">'.$row->department.'</td>';
    ?>
    <?php endif; ?>
    <?php if ($this->params->get('postings_company','0') == '0') : ?>
    <?php
         $query = 'SELECT company FROM `#__tst_jglist_companies` WHERE id IN (SELECT company_id FROM `#__tst_jglist_jobs` WHERE id='.$row->job_id.')';
         $db->setQuery($query);
         echo '<td class="hidden-phone">'.$db->loadResult().'</td>';
    ?>
    <?php endif; ?>
    <?php if ($this->params->get('postings_salary','0') == '0') : ?>
    <?php
        $p_paramsdata = $row->params;
        $p_params = new JRegistry( $p_paramsdata ); // , $p_paramsdefs );

        $query = 'SELECT pay_rate,hide_payrate FROM `#__tst_jglist_jobs` WHERE id='.$row->job_id;
        $db->setQuery($query); $payrate_result = $db->loadObject();
        if (isset($payrate_result->pay_rate)) $payrate = $payrate_result->pay_rate; else $payrate = '';
        if (isset($payrate_result->hide_payrate)) $hide_payrate = $payrate_result->hide_payrate; else $hide_payrate = '0';
        if ($this->params->get('display_pay_rate','1')=='0' || $hide_payrate=='1'
            || $p_params->get('display_pay_rate','1')=='0'
        ) echo '<td class="hidden-phone">'.JTEXT::_('COM_JOBGROKLIST_VIEWS_POSTINGS_TMPL_RESPONSIVE_NA').'</td>'; else echo '<td>'.$payrate.'</td>';
    ?>
    <?php endif; ?>    
    <?php if ( $this->params->get('postings_location','0') == '0') : ?>
    <?php
        $query = 'SELECT l.location, sc.country FROM `#__tst_jglist_locations` l JOIN #__tst_jglist_static_country sc ON sc.id=l.country_id  WHERE l.id='.$row->location_id.' GROUP BY location';
        $db->setQuery($query);
        $result = $db->loadAssoc();
        echo '<td class="hidden-phone">';
        echo $row->location;
        if (isset($result['country']) && $result['country'] != '' && $this->params->get('postings_country','0') == '0')
        echo '&nbsp;<em>'.$result['country'].'</em>';
        echo '</td>';
    ?>
    <?php endif; ?>
    <?php if (($this->params->get('postings_posting_date','0') == '0') && $row->posting_date != '0000-00-00 00:00:00') : ?>
    <?php
        echo '<td class="hidden-phone">'.$my_open_date->format($this->params->get('listing_date_format',JTEXT::_('COM_JOBGROKLIST_VIEWS_POSTINGS_TMPL_RESPONSIVE_MDY'))).'</td>';
    ?>
    <?php endif; ?>
    <?php if ( $this->params->get('postings_closing_date','0') == '0' || $this->params->get('display_closing_on','1') == '1') : ?>
    <?php
        if ($row->closing_date != '0000-00-00 00:00:00') {
            echo '<td class="hidden-phone">'.$my_close_date->format($this->params->get('listing_date_format',JTEXT::_('COM_JOBGROKLIST_VIEWS_POSTINGS_TMPL_RESPONSIVE_MDY'))).'</td>';
        } else {
            echo '<td class="hidden-phone">'.$this->params->get('postings_closing_text','Posting always Open').'</td>';
        }
    ?>
    <?php endif; ?>
            
    <?php if ($this->params->get('postings_summary','0') == '0' ||
              $this->params->get('postings_read_more','0') == '0' ||
              $this->params->get('postings_submit_application','0') == '0') : ?>
    <?php 
        if ($this->params->get('postings_read_more','0') == '0') { $less_column++; $less_column++; }
        if ($this->params->get('postings_submit_application','0') == '0') $less_column++;
        $row_output = '</tr><tr class="hidden-phone">'.'<td colspan="'.($column_count - $less_column).'">'; 
    ?>
    <?php if ($this->params->get('postings_summary','0') == '0') : ?>
    <?php $row_output = $row_output.($this->params->get('plugin_allow_summary','0')=='0'?$row->summary:JHTML::_('content.prepare',$row->summary)); ?>
    <?php endif; ?>
    <?php echo $row_output.'</td>'; ?>
            
    <?php if ( $this->params->get('postings_read_more','0') == '0') : ?>
    <?php
         echo '<td colspan="2" style="text-align: right; vertical-align: bottom;" class="hidden-phone"><strong><a href="'.$link.'">'.JTEXT::_('COM_JOBGROKLIST_VIEWS_POSTINGS_TMPL_RESPONSIVE_READ_MORE').'</a>&raquo;</strong></td>';
    ?>
    <?php endif; ?>
            
    <?php if ($this->params->get('postings_submit_application','0') == '0' ||
                   ($this->params->get('postings_closing_date','0') == '0') ) : ?>
    <?php
        if ($this->params->get('postings_submit_application','0') == '0')
        {
            $query = 'SELECT contact, contact_email FROM `#__tst_jglist_contacts` WHERE id='.$row->contact_id;
            $db->setQuery($query);
            $results = $db->loadAssoc();
            echo '<td class="hidden-phone">';
            echo '<span class="jg_apply_link">'.JTEXT::_('COM_JOBGROKLIST_VIEWS_POSTINGS_TMPL_RESPONSIVE_APPLY_TO').'</span>&nbsp;';
            if (isset($results)) {
                echo JHTML::_('email.cloak', $results['contact_email'], true, $results['contact'], false);
            } else {
                echo JTEXT::_('COM_JOBGROKLIST_VIEWS_POSTINGS_TMPL_RESPONSIVE_NA');
            }
            echo '</td>';
        }
    ?>
    <?php endif; ?>
    <?php endif; ?>
        </div>
        </div>
        </tr>
    <?php endfor; ?>
    </table>        
<?php echo $this->pagination->getListFooter(); ?>
<input type="hidden" name="option" value="com_jobgroklist" />
<input type="hidden" name="view" value="postings" />
<input type="hidden" name="Itemid" value="<?php echo JRequest::getVar('Itemid',''); ?>" />
<input type="hidden" name="filter_order<?php echo $this->item_id; ?>" value="<?php echo $this->lists['order']; ?>" />
<input type="hidden" name="filter_order_Dir<?php echo $this->item_id; ?>" value="" />
<input type="hidden" name="filter_from_form" value="0" />
</form>
<?php endif; ?>
</div>
<div id="credits" style="width: 100%"><?php echo JTEXT::_('COM_JOBGROKLIST_VIEWS_POSTINGS_TMPL_RESPONSIVE_POWERED_BY'); 
?>&nbsp;<a href="http://www.jobgrok.com"><?php echo JTEXT::_('COM_JOBGROKLIST_VIEWS_POSTINGS_TMPL_RESPONSIVE_JOBGROK'); ?></a></div>

