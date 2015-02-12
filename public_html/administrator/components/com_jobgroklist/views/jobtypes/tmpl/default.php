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
 */

defined('_JEXEC') or die('Restricted access');
?>
<script language="javascript" type="text/javascript">

    function tableOrdering( order, dir, task )
    {
        var form = document.adminForm;

        form.filter_jobtypes_order.value    = order;
        form.filter_jobtypes_order_Dir.value   = dir;
        document.adminForm.submit( task );
    }
</script>
<form action="index.php" method="post" name="adminForm" id="adminForm" >
    <div id="editcell">
        <table class='table'>
            <thead>
                <tr>
                    <th width="5"><?php echo JTEXT::_('COM_JOBGROKLIST_VIEWS_JOBTYPES_TMPL_DEFAULT_ID'); ?></th>
                    <th width="20"><input type="checkbox" name="checkall-toggle" value title="Check All" onclick="Joomla.checkAll(this)" /></th>
                    <th style="text-align: left;"><?php echo JTEXT::_('COM_JOBGROKLIST_VIEWS_JOBTYPES_TMPL_DEFAULT_JOB_TYPE'); ?></th>
                    <th style="text-align: left;"><?php echo JTEXT::_('COM_JOBGROKLIST_VIEWS_JOBTYPES_TMPL_DEFAULT_DESCRIPTION'); ?></th>
                    <th style="text-align: left;"><?php echo JTEXT::_('COM_JOBGROKLIST_VIEWS_JOBTYPES_TMPL_DEFAULT_COMPANY'); ?></th>
                </tr>
            </thead>
            <?php
            $k = 0;
            for ($i=0, $n=count( $this->items ); $i < $n; $i++)
            {
                $row = $this->items[$i];
                $checked = JHTML::_( 'grid.id', $i, $row->id );
                $link = JRoute::_( 'index.php?option=com_jobgroklist&controller=jobtype&task=edit&cid[]='. $row->id );
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
                        <?php echo JHTML::_('jobgroklist.static_jobtype_description',$row->code); ?>
                    </a>
                </td>
                <td>
                        <?php echo $row->jobtype; ?>
                </td>
                <td>
                        <?php
                        $db = JFactory::getDBO();
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
                <td colspan="5" style="text-align: center;">
                    <?php echo $this->pagination->getListFooter(); ?>
                </td>
            </tr>
        </table>
    </div>
    <input type="hidden" name="option" value="com_jobgroklist" />
    <input type="hidden" name="task" value="" />
    <input type="hidden" name="boxchecked" value="0" />
    <input type="hidden" name="controller" value="jobtype" />
    <?php echo JHTML::_( 'form.token'); ?>
</form>
<?php echo "<table width='100%'><tbody><tr><td style='padding-top: 11px; text-align: right; vertical-align: middle;'><a href='http://www.tk-tek.com'><img style='vertical-align: middle;' src='components/com_jobgroklist/assets/images/tk_logo_bar_h16.png' alt='TK Tek, LLC'></a>&nbsp;<img style='vertical-align: middle;' src='components/com_jobgroklist/assets/images/jg_listing_h16.png'>&nbsp;<span style='font-size: 10px;'>JobGrok Listing Version 3.1-1.2.57 | Copyright 2008 - 2014 by <a href='http://www.tk-tek.com'>TK Tek, LLC</a> | License: <a href='http://www.gnu.org/copyleft/gpl.html'>GNU General Public License</a></td></tr></tbody></table>"; ?>