<?php
/**
 *
 *
 * This is the default.php view layout for jobgroklist
 *
 * Created: June 13, 2014, 1:18 am
 *
 * Subversion Details
 * $Date: 2014-04-26 15:47:41 -0500 (Sat, 26 Apr 2014) $
 * $Revision: 6007 $
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
jimport('joomla.html.pane');
$db = JFactory::getDBO();
$document = JFactory::getDocument();

JHTML::_('behavior.framework');

if ($this->getnews) {
    $js = "window.addEvent('domready', function() {	
        var r1 = new Request.HTML({
            url: 'index.php',
            onComplete: function (responseTree, responseElements, responseHTML) {
                $('news_id').set('html',responseHTML);
                $('wait').set('html','');
            } }).post($('panelnews'));})";

    $document->addScriptDeclaration($js);
}
$css2 = ".jg_ea2 .pane-sliders .panel { border: 1px solid #cccccc; margin-bottom: 3px; padding-bottom: 0px; }\n" .
        ".jg_ea2 .pane-sliders .panel h3 { margin: 0px; background: #f6f6f6 repeat scroll 0px 0px; color: #666666; font-size: 13px; }\n" .
        ".jg_ea2 .pane-sliders .panel h3 a { text-decoration: none; }\n" .
        ".jg_ea2 .pane-sliders .panel span { padding-left: 20px; }\n" .
        ".jg_ea2 .pane-sliders .title { cursor: pointer; margin: 0px; padding: 2px; color: #666666; }\n" .
        ".jg_ea2 .pane-sliders .panel h3.pane-toggler span { background: url(" . JURI::base() . "components/com_jobgrokboard/assets/images/arrow_right.gif) no-repeat 5px 5px; }\n" .
        ".jg_ea2 .pane-sliders .panel h3.pane-toggler-down span { background: url(" . JURI::base() . "components/com_jobgrokboard/assets/images/arrow_down.gif) no-repeat 5px 5px; }\n" .
        ".jg_ea2 .pane-toggler-down { border-bottom: 1px solid #cccccc; }\n" .
        ".jg_ea2 .pane-toggler-down span { padding-left: 20px; }\n" .
        ".jg_ea2 .pane-slider fieldset { border: 0px none; }\n" .
        ".jg_ea2 .pane-slider input { margin: 1px; }\n" .
        ".jg_ea2 dl.tabs { clear: both; float: left; margin: 50px 0 0; z-index: 50; }\n" .
        ".jg_ea2 dl.tabs dt.open { background: none repeat scroll 0 0 #f9f9f9; border-bottom: 1px solid #f9f9f9; color: #000000; z-index: 100; }\n" .
        ".jg_ea2 dl.tabs dt { margin-bottom: 3px; height: 18px; background: none repeat scroll 0 0 #f0f0f0; border-left: 1px solid #ccc; border-right: 1px solid #ccc; border-top: 1px solid #ccc; color: #666; float: left; margin-right: 3px; padding: 4px 10px; }\n" .
        ".jg_ea2 div.current { border: 1px solid #ccc; clear: both; padding: 10px; }\n" .
        ".jg_ea2 .tabs fieldset { border: 0px none; }\n" .
        ".jg_ea2 .tabs input { margin: 1px; }\n" .
        "a.btn { width: 100px; border: 0; background: transparent; padding-top: 20px; padding-bottom: 20px; }\n" .
        "hr.hr-condensed { margin: 0px 0; }\n" .
        "table.adminlist { background-color: white; }\n";


$document->addStyleDeclaration($css2);

?>
                <div class="span6">
                    <div class="well well-small">
                        <div id="cpanel">
                            <div class="module-title nav-header"><a href="index.php?option=com_jobgroklist&controller=panel"><span><?php echo JTEXT::_('COM_JOBGROKLIST_VIEWS_PANEL_TMPL_DEFAULT_CONTROL_PANEL'); ?></span></a></div>
                            <hr class="hr-condensed">
                            <a class="btn" href="index.php?option=com_jobgroklist&controller=posting">
                                <img alt="Postings" src="components/com_jobgroklist/assets/images/posting48x48.png" /><br/>
                                <span><?php echo JTEXT::_('COM_JOBGROKLIST_VIEWS_PANEL_TMPL_DEFAULT_POSTINGS'); ?></span>
                            </a>
                            <a class="btn" href="index.php?option=com_jobgroklist&controller=job">
                                <img alt="Jobs" src="components/com_jobgroklist/assets/images/job48x48.png" /><br/>
                                <span><?php echo JTEXT::_('COM_JOBGROKLIST_VIEWS_PANEL_TMPL_DEFAULT_JOBS'); ?></span>
                            </a>
                            <a class="btn" href="index.php?option=com_jobgroklist&controller=company">
                                <img alt="Companies" src="components/com_jobgroklist/assets/images/company48x48.png" /><br/>
                                <span><?php echo JTEXT::_('COM_JOBGROKLIST_VIEWS_PANEL_TMPL_DEFAULT_COMPANIES'); ?></span>
                            </a>
                            <a class="btn" href="index.php?option=com_jobgroklist&controller=location">
                                <img alt="Locations" src="components/com_jobgroklist/assets/images/location48x48.png" /><br/>
                                <span><?php echo JTEXT::_('COM_JOBGROKLIST_VIEWS_PANEL_TMPL_DEFAULT_LOCATIONS'); ?></span>
                            </a>
                            <a class="btn" href="index.php?option=com_jobgroklist&controller=department">
                                <img alt="Departments" src="components/com_jobgroklist/assets/images/department48x48.png" /><br/>
                                <span><?php echo JTEXT::_('COM_JOBGROKLIST_VIEWS_PANEL_TMPL_DEFAULT_DEPARTMENTS'); ?></span>
                            </a>
                            <a class="btn" href="index.php?option=com_jobgroklist&controller=category">
                                <img alt="Categories" src="components/com_jobgroklist/assets/images/category48x48.png" /><br/>
                                <span><?php echo JTEXT::_('COM_JOBGROKLIST_VIEWS_PANEL_TMPL_DEFAULT_CATEGORIES'); ?></span>
                            </a>
                            <a class="btn" href="index.php?option=com_jobgroklist&controller=jobtype">
                                <img alt="Job Types" src="components/com_jobgroklist/assets/images/jobtype48x48.png" /><br/>
                                <span><?php echo JTEXT::_('COM_JOBGROKLIST_VIEWS_PANEL_TMPL_DEFAULT_JOB_TYPES'); ?></span>
                            </a>
                            <a class="btn" href="index.php?option=com_jobgroklist&controller=shift">
                                <img alt="Shifts" src="components/com_jobgroklist/assets/images/shift48x48.png" /><br/>
                                <span><?php echo JTEXT::_('COM_JOBGROKLIST_VIEWS_PANEL_TMPL_DEFAULT_SHIFTS'); ?></span>
                            </a>
                            <a class="btn" href="index.php?option=com_jobgroklist&controller=contact">
                                <img alt="Contacts" src="components/com_jobgroklist/assets/images/contact48x48.png" /><br/>
                                <span><?php echo JTEXT::_('COM_JOBGROKLIST_VIEWS_PANEL_TMPL_DEFAULT_CONTACTS'); ?></span>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="span6">
                    <div class="well well-small">
                        <div class="jg_ea2">
                            <table width='100%' class='adminlist' style="margin-bottom: 10px; border: 1px silver solid;">
                                <thead>
                                    <tr>
                                        <td>
                                            <table width='100%' class='adminlist'>
                                                <thead>
                                                    <tr>
                                                        <td colspan="3" style="text-align: center;" align="center"><img style='vertical-align: middle;' src='components/com_jobgroklist/assets/images/jg_listing_h220.png'></td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="1" align="right" width="33%" style="font-weight: bold; padding-right: 15px; text-align: right;">Version:</td>
                                                        <td colspan="2" align="left">3.1-1.2.57</td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="1" align="right" style="font-weight: bold; padding-right: 15px; text-align: right;">Date:</td>
                                                        <td colspan="2" align="left">2014-06-13</td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="1" align="right" style="font-weight: bold; padding-right: 15px; text-align: right;">Author:</td>
                                                        <td colspan="2" align="left">TK Tek, LLC</td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="1" align="right" style="font-weight: bold; padding-right: 15px; text-align: right;">Copyright:</td>
                                                        <td colspan="2" align="left">&copy;&nbsp;2008 - 2014 TK Tek, LLC, All rights reserved.</td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="1" align="right" style="font-weight: bold; padding-right: 15px; text-align: right;">License:</td>
                                                        <td colspan="2" align="left">GNU General Public License</td>
                                                    </tr>
                                                    <tr><td colspan="3" style="padding-bottom: 15px;">&nbsp;</td></tr>
                                                </thead>
                                            </table>
                                            <div id="news_id"></div>
                                            <div style="margin-left: 10px; font-size: 10px;"><a href="index.php?option=com_jobgroklist&news=1"><?php
                                            if ($this->getnews) echo "Hide News Feed"; else echo "Display News Feed"; ?></a>.<span id="wait"><?php
                                            if ($this->getnews) echo '&nbsp;<img src="components/com_jobgroklist/assets/images/dots16.gif">'; ?></span>&nbsp;Troubles? <a target='_blank' href='http://www.tk-tek.com/forum'>Post to the Forums</a>.&nbsp;Happy? <a target='_blank' href='http://extensions.joomla.org/extensions/ads-a-affiliates/jobs-a-recruitment/4109/review'>Review Us</a>.&nbsp;Upgrade: <a target='_blank' href='http://www.tk-tek.com/products/jobgrok-extensions/jobgrok-premium'>Buy Premium</a>&nbsp;<img src='components/com_jobgroklist/assets/images/jg_premium_h16.png' /></div>
                                        </td>
                                    </tr>
                                </thead>
                            </table>
                            <?php
echo JHtml::_('sliders.start', 'tab_group_id');                            echo JHtml::_('sliders.panel', JTEXT::_('COM_JOBGROKLIST_VIEWS_PANEL_TMPL_DEFAULT_TOP_VIEWED_JOBS'), 'TOPJOBS_VIEWED');
                            echo "<table width='100%' class='adminlist'>";
                            echo "<thead>";
                            echo "<tr>";
                            echo "<td class='title'>";
                            echo "<strong>" . JTEXT::_('COM_JOBGROKLIST_VIEWS_PANEL_TMPL_DEFAULT_ID') . "</strong>";
                            echo "</td>";
                            echo "<td class='title'>";
                            echo "<strong>" . JTEXT::_('COM_JOBGROKLIST_VIEWS_PANEL_TMPL_DEFAULT_TITLE') . "</strong>";
                            echo "</td>";
                            echo "<td class='title'>";
                            echo "<strong>" . JTEXT::_('COM_JOBGROKLIST_VIEWS_PANEL_TMPL_DEFAULT_HITS') . "</strong>" . '&nbsp;<em><a href="index.php?option=com_jobgroklist&controller=panel&task=resetAllHits">';
                            echo JTEXT::_('COM_JOBGROKLIST_VIEWS_PANEL_TMPL_DEFAULT_RESET') . '</a></em>';
                            echo "</td>";
                            echo "</tr>";
                            echo "</thead>";
                            echo "<tbody>";
                            
                            $query = "SELECT p.id, j.title, p.hits FROM #__tst_jglist_postings p JOIN " .
                                    "#__tst_jglist_jobs j ON p.job_id=j.id ORDER BY p.hits DESC, p.id ASC LIMIT 0,9";
                            $query = 
                            $db->setQuery($query);
                            $result = $db->loadAssocList();

                            foreach ($result as $row) {
                                echo "<tr>";
                                echo "<td>";
                                echo $row['id'];
                                echo "</td>";
                                echo "<td>";
                                echo $row['title'];
                                echo "</td>";
                                echo "<td>";
                                echo $row['hits'];
                                echo "</td>";
                                echo "</tr>";
                            }

                            echo "</tbody>";
                            echo "</table>";
                            
                            echo JHtml::_('sliders.panel', JTEXT::_('COM_JOBGROKLIST_VIEWS_PANEL_TMPL_DEFAULT_MOST_RECENT_POSTINGS'), 'RECENTPOSTINGS');
                            echo "<table width='100%' class='adminlist'>";
                            echo "<thead>";
                            echo "<tr>";
                            echo "<td class='title'>";
                            echo "<strong>" . JTEXT::_('COM_JOBGROKLIST_VIEWS_PANEL_TMPL_DEFAULT_ID') . "</strong>";
                            echo "</td>";
                            echo "<td class='title'>";
                            echo "<strong>" . JTEXT::_('COM_JOBGROKLIST_VIEWS_PANEL_TMPL_DEFAULT_TITLE') . "</strong>";
                            echo "</td>";
                            echo "<td class='title'>";
                            echo "<strong>" . JTEXT::_('COM_JOBGROKLIST_VIEWS_PANEL_TMPL_DEFAULT_POSTED_ON') . "</strong>";
                            echo "</td>";
                            echo "<td class='title'>";
                            echo "<strong>" . JTEXT::_('COM_JOBGROKLIST_VIEWS_PANEL_TMPL_DEFAULT_CLOSES_ON') . "</strong>";
                            echo "</td>";
                            echo "</tr>";
                            echo "</thead>";
                            echo "<tbody>";

                            $query = "SELECT p.id, j.title, LEFT(p.posting_date,10) As posted_on, " .
                                    "LEFT(p.closing_date,10) AS closes_on FROM  #__tst_jglist_postings p " .
                                    "JOIN #__tst_jglist_jobs j ON p.job_id=j.id " .
                                    "WHERE p.published=1 ORDER BY posted_on DESC, id ASC LIMIT 0,9";
                            $db->setQuery($query);
                            $result = $db->loadAssocList();

                            foreach ($result as $row) {
                                echo "<tr>";
                                echo "<td>";
                                echo $row['id'];
                                echo "</td>";
                                echo "<td>";
                                echo $row['title'];
                                echo "</td>";
                                echo "<td>";
                                echo $row['posted_on'];
                                echo "</td>";
                                echo "<td>";
                                echo $row['closes_on'];
                                echo "</td>";
                                echo "</tr>";
                            }
                            echo "</tbody>";
                            echo "</table>";
                            echo JHtml::_('sliders.end');
                            ?>
                        </div>
                    </div>
                </div>
<form action="index.php" method="post" name="adminForm" id="adminForm" >
    <input type="hidden" name="option" value="com_jobgroklist" />
    <input type="hidden" name="task" value="" />
    <input type="hidden" name="controller" value="panel" />
</form>
<form id="panelnews" name="panelnews" method="post" action="index.php">
    <input name="option" type="hidden" value="com_jobgroklist" />
    <input name="controller" type="hidden" value="panel" />
    <input name="format" type="hidden" value="raw" />
    <input name="view" type="hidden" value="panel" />
    <?php echo JHTML::_( 'form.token'); ?>
</form>
<?php echo "<table width='100%'><tbody><tr><td style='padding-top: 11px; text-align: right; vertical-align: middle;'><a href='http://www.tk-tek.com'><img style='vertical-align: middle;' src='components/com_jobgroklist/assets/images/tk_logo_bar_h16.png' alt='TK Tek, LLC'></a>&nbsp;<img style='vertical-align: middle;' src='components/com_jobgroklist/assets/images/jg_listing_h16.png'>&nbsp;<span style='font-size: 10px;'>JobGrok Listing Version 3.1-1.2.57 | Copyright 2008 - 2014 by <a href='http://www.tk-tek.com'>TK Tek, LLC</a> | License: <a href='http://www.gnu.org/copyleft/gpl.html'>GNU General Public License</a></td></tr></tbody></table>"; ?>
