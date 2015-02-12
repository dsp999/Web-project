<?php
/**
 *
 *
 * This is the default.php view layout for jobgroklist
 *
 * Created: June 13, 2014, 1:18 am
 *
 * Subversion Details
 * $Date: 2013-07-15 21:31:13 -0500 (Mon, 15 Jul 2013) $
 * $Revision: 5325 $
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

?>
<script language="javascript" type="text/javascript">

    function tableOrdering( order, dir, task )
    {
        var form = document.adminForm;

        form.filter_jobs_order.value    = order;
        form.filter_jobs_order_Dir.value   = dir;
        document.adminForm.submit( task );
    }
</script>
<form action="index.php" method="post" name="adminForm" id="adminForm" >
    <div id="editcell">
        <table class='table'>
            <thead>
                <tr>
                    <th width="5"><?php echo JTEXT::_('COM_JOBGROKLIST_VIEWS_JOBS_TMPL_DEFAULT_ID'); ?></th>
                    <th width="20"><input type="checkbox" name="checkall-toggle" value title="Check All" onclick="Joomla.checkAll(this)" /></th>
                    <th style="text-align: left;"><?php echo JTEXT::_('COM_JOBGROKLIST_VIEWS_JOBS_TMPL_DEFAULT_JOB_TITLE'); ?></th>
                    <th style="text-align: left;"><?php echo JTEXT::_('COM_JOBGROKLIST_VIEWS_JOBS_TMPL_DEFAULT_CATEGORY'); ?></th>
                    <th style="text-align: left;"><?php echo JTEXT::_('COM_JOBGROKLIST_VIEWS_JOBS_TMPL_DEFAULT_DEPARTMENT'); ?></th>
                    <th style="text-align: left;"><?php echo JTEXT::_('COM_JOBGROKLIST_VIEWS_JOBS_TMPL_DEFAULT_SHIFT'); ?></th>
                    <th style="text-align: left;"><?php echo JTEXT::_('COM_JOBGROKLIST_VIEWS_JOBS_TMPL_DEFAULT_JOB_TYPE'); ?></th>
                    <th style="text-align: left;"><?php echo JTEXT::_('COM_JOBGROKLIST_VIEWS_JOBS_TMPL_DEFAULT_COMPANY'); ?></th>
                </tr>
            </thead>
            <?php
            $k = 0;
            for ($i=0, $n=count( $this->items ); $i < $n; $i++)
            {
                $row = $this->items[$i];
                $checked = JHTML::_( 'grid.id', $i, $row->id );
                $link = JRoute::_( 'index.php?option=com_jobgroklist&controller=job&task=edit&cid[]='. $row->id );
                ?>
            <tr class="<?php echo "row$k"; ?>">
                <td valign="top">
                        <?php echo $row->id; ?>
                </td>
                <td valign="top">
                        <?php echo $checked; ?>
                </td>
                <td valign="top">
                    <a href="<?php echo $link; ?>"><?php echo $row->title; ?></a>
                    <?php if (isset($row->job_code)) echo "<br/><span style='color: silver;'>".JTEXT::_('COM_JOBGROKLIST_VIEWS_JOBS_TMPL_DEFAULT_JOB_CODE').": ".$row->job_code."</span>"; ?>
                </td>
                <td valign="top">
                        <?php
                        $db = JFactory::getDBO();
                        $query = 'SELECT sc.category As category, c.description As description FROM `#__tst_jglist_static_category` sc '.
                            ' LEFT JOIN `#__tst_jglist_categories` c ON sc.id=c.code '.
                            ' WHERE c.id='.$row->category_id;
                        $db->setQuery($query);
                        $result = $db->loadAssoc();
                        echo $result['category'].($result['description']!=''?"<br/><em style='color:silver;'>".$result['description']."</em>":"");
                        //echo $db->loadResult();
                        ?>
                </td>
                <td valign="top">
                        <?php
                        $db = JFactory::getDBO();
                        $query = 'SELECT department FROM `#__tst_jglist_departments` WHERE id='.$row->department_id;
                        $db->setQuery($query);
                        echo $db->loadResult();
                        ?>
                </td>
                <td valign="top">
                        <?php
                        $db = JFactory::getDBO();
                        $query = 'SELECT shift FROM `#__tst_jglist_shifts` WHERE id='.$row->shift_id;
                        $db->setQuery($query);
                        echo $db->loadResult();
                        ?>
                </td>
                <td valign="top">
                        <?php

                        $query = 'SELECT code, jobtype FROM `#__tst_jglist_jobtypes` WHERE id='.$row->jobtype_id;
                        $db->setQuery($query);
                        $result = $db->loadAssoc();
                        echo JHTML::_('jobgroklist.static_jobtype_description',$result['code']);
                        echo ($result['jobtype']!=''?"<br /><em style='color:silver;'>".$result['jobtype']."</em>":"");
                        ?>
                </td>
                <td valign="top">
                        <?php
                        $query = 'SELECT company FROM `#__tst_jglist_companies` WHERE id='.$row->company_id;
                        $db->setQuery($query);
                        echo $db->loadResult();
                        ?>
                </td>
            </tr>
                <?php
                $k = 1 - $k;
            }
            ?>
            <tr>
                <td colspan="8" style="text-align: center;">
                    <?php echo $this->pagination->getListFooter(); ?>
                </td>
            </tr>
        </table>
    </div>
    <input type="hidden" name="option" value="com_jobgroklist" />
    <input type="hidden" name="task" value="" />
    <input type="hidden" name="boxchecked" value="0" />
    <input type="hidden" name="controller" value="job" />
    <?php echo JHTML::_( 'form.token'); ?>
</form>
<?php echo "<table width='100%'><tbody><tr><td style='padding-top: 11px; text-align: right; vertical-align: middle;'><a href='http://www.tk-tek.com'><img style='vertical-align: middle;' src='components/com_jobgroklist/assets/images/tk_logo_bar_h16.png' alt='TK Tek, LLC'></a>&nbsp;<img style='vertical-align: middle;' src='components/com_jobgroklist/assets/images/jg_listing_h16.png'>&nbsp;<span style='font-size: 10px;'>JobGrok Listing Version 3.1-1.2.57 | Copyright 2008 - 2014 by <a href='http://www.tk-tek.com'>TK Tek, LLC</a> | License: <a href='http://www.gnu.org/copyleft/gpl.html'>GNU General Public License</a></td></tr></tbody></table>"; ?>