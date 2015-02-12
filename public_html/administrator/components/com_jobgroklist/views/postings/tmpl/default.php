<?php
/**
 *
 *
 * This is the default.php view layout for jobgroklist
 *
 * Created: June 13, 2014, 1:18 am
 *
 * Subversion Details
 * $Date: 2014-05-07 20:05:45 -0500 (Wed, 07 May 2014) $
 * $Revision: 6062 $
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

?>
<script language="javascript" type="text/javascript">

    function tableOrdering( order, dir, task )
    {
        var form = document.adminForm;

        form.filter_postings_order.value    = order;
        form.filter_postings_order_Dir.value   = dir;
        document.adminForm.submit( task );
    }
</script>

<form action="index.php" method="post" name="adminForm" id="adminForm" >
    <div id="editcell">
        <table class='table'>
            <thead>
                <tr>
                    <th width="5"><?php echo JTEXT::_('COM_JOBGROKLIST_VIEWS_POSTINGS_TMPL_DEFAULT_ID'); ?></th>
                    <th width="20"><input type="checkbox" name="checkall-toggle" value title="Check All" onclick="Joomla.checkAll(this)" /></th>
                    <th style="text-align: left;"><?php echo JTEXT::_('COM_JOBGROKLIST_VIEWS_POSTINGS_TMPL_DEFAULT_JOB_TITLE'); ?></th>
                    <th style="text-align: left;"><?php echo JTEXT::_('COM_JOBGROKLIST_VIEWS_POSTINGS_TMPL_DEFAULT_COMPANY'); ?></th>
                    <th style="text-align: left;"><?php echo JTEXT::_('COM_JOBGROKLIST_VIEWS_POSTINGS_TMPL_DEFAULT_LOCATION'); ?></th>
                    <th style="text-align: left;"><?php echo JTEXT::_('COM_JOBGROKLIST_VIEWS_POSTINGS_TMPL_DEFAULT_DEPARTMENT'); ?></th>
                    <th style="text-align: left;"><?php echo JTEXT::_('COM_JOBGROKLIST_VIEWS_POSTINGS_TMPL_DEFAULT_POSTING_DATE'); ?></th>
                    <th style="text-align: left;"><?php echo JTEXT::_('COM_JOBGROKLIST_VIEWS_POSTINGS_TMPL_DEFAULT_CLOSING_DATE'); ?></th>
                    <th style="text-align: center;"><?php echo JTEXT::_('COM_JOBGROKLIST_VIEWS_POSTINGS_TMPL_DEFAULT_PUBLISHED'); ?></th>
                    <th style="text-align: center;"><?php echo JTEXT::_('COM_JOBGROKLIST_VIEWS_POSTINGS_TMPL_DEFAULT_FEATURED'); ?></th>
                    <th style="text-align: center;"><?php echo JTEXT::_('COM_JOBGROKLIST_VIEWS_POSTINGS_TMPL_DEFAULT_VIEWLEVEL'); ?></th>
                    <th style="text-align: center;"><?php echo JTEXT::_('COM_JOBGROKLIST_VIEWS_POSTINGS_TMPL_DEFAULT_HITS'); ?></th>
                </tr>
            </thead>
            <?php
            $k = 0;
            for ($i=0, $n=count( $this->items ); $i < $n; $i++)
            {
                $row = $this->items[$i];
                $checked = JHTML::_( 'grid.id', $i, $row->id );
                $link = JRoute::_( 'index.php?option=com_jobgroklist&controller=posting&task=edit&cid[]='. $row->id );
                $link_reset = JRoute::_('index.php?option=com_jobgroklist&controller=posting&task=reset&cid[]='.$row->id );
                $link_publish = JRoute::_('index.php?option=com_jobgroklist&controller=posting&task=publish&cid[]='. $row->id);
                $link_unpublish = JRoute::_('index.php?option=com_jobgroklist&controller=posting&task=unpublish&cid[]='. $row->id);
                $link_featured = JRoute::_('index.php?option=com_jobgroklist&controller=posting&task=featured&id='.$row->id);
                $link_unfeatured = JRoute::_('index.php?option=com_jobgroklist&controller=posting&task=unfeatured&id='.$row->id);
                if ($row->featured == '1') {
                    $featured_link = "<a href='".$link_unfeatured."'><img alt='featured' src='".JURI::base(true)."/components/com_jobgroklist/assets/images/featured.png'></a>";
                } else {
                    $featured_link = "<a href='".$link_featured."'><img alt='unfeatured' src='".JURI::base(true)."/components/com_jobgroklist/assets/images/disabled.png'></a>";
                }
                ?>
            <tr class="<?php echo "row$k"; ?>">
                <td>
                        <?php echo $row->id; ?>
                </td>
                <td>
                        <?php echo $checked; ?>
                </td>
                <td>
                    <a href="<?php echo $link; ?>">
                            <?php
                            $db = JFactory::getDBO();
                            $query = 'SELECT title, job_code FROM `#__tst_jglist_jobs` WHERE id='.$row->job_id;
                            $db->setQuery($query);
                            $jt = $db->loadObject();
                            echo (isset($jt->title)?$jt->title:''); ?></a>
                            <?php
                            if (isset($jt->job_code) && $jt->job_code != '') echo "<br/><span style='color: silver;'>".JTEXT::_('COM_JOBGROKLIST_VIEWS_POSTINGS_TMPL_DEFAULT_JOB_CODE').": ".$jt->job_code."</span>"; ?>
                </td>
                <td>
                        <?php
                        $query = 'SELECT company FROM `#__tst_jglist_companies` WHERE id IN (SELECT company_id FROM `#__tst_jglist_jobs` WHERE id='.$row->job_id.')';
                        $db->setQuery($query);
                        echo $db->loadResult();
                        ?>
                </td>
                <td>
                        <?php
                        $query = 'SELECT location FROM `#__tst_jglist_locations` WHERE id='.$row->location_id;
                        $db->setQuery($query);
                        echo $db->loadResult();
                        ?>
                </td>
                <td>
                        <?php
                        $query = 'SELECT department FROM `#__tst_jglist_departments` WHERE id IN (SELECT department_id FROM `#__tst_jglist_jobs` WHERE id='.$row->job_id.')';
                        $db->setQuery($query);
                        echo $db->loadResult();
                        ?>
                </td>
                <td>
                        <?php if ($row->posting_date != "0000-00-00 00:00:00") echo $row->posting_date; ?>
                </td>
                <td>
                        <?php 
                            if (!$row->closing_date || $row->closing_days > 0) {
                                $ndate = new JDate($row->posting_date);
                                echo $ndate->add(new DateInterval('P'.$row->closing_days.'D')).'<br />';
                                if ($row->closing_days > 1) {
                                    echo '<span style="color: silver">'.JTEXT::_('COM_JOBGROKLIST_VIEWS_POSTINGS_TMPL_DEFAULT_CLOSING_AFTER')." "
                                            .$row->closing_days." ".JTEXT::_('COM_JOBGROKLIST_VIEWS_POSTINGS_TMPL_DEFAULT_CLOSING_AFTER_DAYS').'</span>';
                                } else {
                                    echo '<span style="color: silver">'.JTEXT::_('COM_JOBGROKLIST_VIEWS_POSTINGS_TMPL_DEFAULT_CLOSING_AFTER')." "
                                            .$row->closing_days." ".JTEXT::_('COM_JOBGROKLIST_VIEWS_POSTINGS_TMPL_DEFAULT_CLOSING_AFTER_DAY').'</span>';
                                }
                            } else {
                                if ($row->closing_date != "0000-00-00 00:00:00") echo $row->closing_date; 
                            }
                        ?>
                </td>
                <td style="text-align: center;">
                        <?php echo JHTML::_('grid.published', $row, $i ); ?>
                </td>
                <td style="text-align: center;">
                    <?php echo $featured_link; ?>
                </td>
                <td style="text-align: center;">
                    <?php echo JHtml::_('jobgroklist.viewlevel_description',$row->viewlevel); ?>
                </td>
                <td style="text-align: center;">
                    <?php echo $row->hits; ?>
                    <em><a href="<?php echo $link_reset; ?>" title="Reset Hits to Zero" />Reset</a></em>
                </td>
            </tr>
                <?php
                $k = 1 - $k;
            }
            ?>
            <tr>
                <td colspan="13" style="text-align: center;">
                    <?php echo $this->pagination->getListFooter(); ?>
                </td>
            </tr>
        </table>
    </div>
    <input type="hidden" name="option" value="com_jobgroklist" />
    <input type="hidden" name="task" value="" />
    <input type="hidden" name="boxchecked" value="0" />
    <input type="hidden" name="controller" value="posting" />
    <?php echo JHTML::_( 'form.token'); ?>
</form>
<?php echo "<table width='100%'><tbody><tr><td style='padding-top: 11px; text-align: right; vertical-align: middle;'><a href='http://www.tk-tek.com'><img style='vertical-align: middle;' src='components/com_jobgroklist/assets/images/tk_logo_bar_h16.png' alt='TK Tek, LLC'></a>&nbsp;<img style='vertical-align: middle;' src='components/com_jobgroklist/assets/images/jg_listing_h16.png'>&nbsp;<span style='font-size: 10px;'>JobGrok Listing Version 3.1-1.2.57 | Copyright 2008 - 2014 by <a href='http://www.tk-tek.com'>TK Tek, LLC</a> | License: <a href='http://www.gnu.org/copyleft/gpl.html'>GNU General Public License</a></td></tr></tbody></table>"; ?>