<?php
/**
 *
 *
 * This is the default.php view layout for jobgroklist
 *
 * Created: June 13, 2014, 1:18 am
 *
 * Subversion Details
 * $Date: 2013-11-17 13:48:40 -0600 (Sun, 17 Nov 2013) $
 * $Revision: 5598 $
 * $Author: jobgrok $
 *
 * @author TK Tek, LLC. info@jobgrok.com
 * @version 3.1-1.2.57
 * @package com_jobgroklist
 *
 */

defined('_JEXEC') or die('Restricted access');

$document =JFactory::getDocument();

if (isset($this->lists['link']))
    echo "<html><head></head>".$this->lists['link']."<body>";

if (isset($this->lists['css']))
    echo "<style>".$this->lists['css']."</style>";
?>

<form action="index.php" method="post" name="adminForm" id="adminForm" >
    <div class="col100">
        <fieldset class="adminform">
            <legend><?php echo JTEXT::_('COM_JOBGROKLIST_VIEWS_JOBTYPE_TMPL_DEFAULT_DETAILS'); ?></legend>
            <table class="admintable">
                <tr>
                    <td width="100" align="right" class="key">
                        <label for="jobtype">
                            <?php echo JTEXT::_('COM_JOBGROKLIST_VIEWS_JOBTYPE_TMPL_DEFAULT_JOB_TYPE'); ?>:
                        </label>
                    </td>
                    <td>
                        <?php echo $this->lists['static_jobtype']; ?>
                    </td>
                </tr>
                <tr>
                    <td width="100" align="right" class="key">
                        <label for="jobtype">
                            <?php echo JTEXT::_('COM_JOBGROKLIST_VIEWS_JOBTYPE_TMPL_DEFAULT_JOB_TYPE_DESCRIPTION'); ?>:
                        </label>
                    </td>
                    <td>
                        <input class="text_area" type="text" name="jobtype" id="jobtype" size="32" maxlength="250" value="<?php if (isset($this->jobtype->jobtype)) echo $this->jobtype->jobtype;?>" />
                    </td>
                </tr>
                <tr>
                    <td width="100" align="right" class="key">
                        <label for="use_description">
                            <?php echo JTEXT::_('COM_JOBGROKLIST_VIEWS_JOBTYPE_TMPL_DEFAULT_USE_DESCRIPTION'); ?>:
                        </label>
                    </td>
                    <td width="100" class="key">
                        <fieldset style="display: inline;" class="radio">
                        <?php
                        if (isset($this->jobtype->use_description))
                            echo JHTML::_('select.booleanlist', 'use_description', 'class="inputbox"', $this->jobtype->use_description);
                        else
                            echo JHTML::_('select.booleanlist', 'use_description', 'class="inputbox"', '');
                        ?>
                        </fieldset>
                    </td>
                </tr>
                <tr>
                    <td width="100" align="right" class="key">
                        <label for="company">
                            <?php echo JTEXT::_('COM_JOBGROKLIST_VIEWS_JOBTYPE_TMPL_DEFAULT_COMPANY'); ?>:
                        </label>
                    </td>
                    <td>
                        <?php echo $this->lists['company']; ?>
                    </td>
                </tr>
            </table>
        </fieldset>
    </div>

    <div class="clr"></div>

    <?php
    echo (isset($this->lists['submit'])?$this->lists['submit']:'');
    echo (isset($this->lists['format'])?$this->lists['format']:'');
    echo (isset($this->lists['view'])?$this->lists['view']:'');
    ?>

    <input type="hidden" name="option" value="com_jobgroklist" />
    <input type="hidden" name="id" value="<?php if (isset($this->jobtype->id)) echo $this->jobtype->id; ?>" />
    <input type="hidden" name="task" value="<?php echo (isset($this->lists['submit'])?'save':''); ?>" />
    <input type="hidden" name="controller" value="jobtype" />
    <?php echo JHTML::_( 'form.token'); ?>
</form>
<?php echo "<table width='100%'><tbody><tr><td style='padding-top: 11px; text-align: right; vertical-align: middle;'><a href='http://www.tk-tek.com'><img style='vertical-align: middle;' src='components/com_jobgroklist/assets/images/tk_logo_bar_h16.png' alt='TK Tek, LLC'></a>&nbsp;<img style='vertical-align: middle;' src='components/com_jobgroklist/assets/images/jg_listing_h16.png'>&nbsp;<span style='font-size: 10px;'>JobGrok Listing Version 3.1-1.2.57 | Copyright 2008 - 2014 by <a href='http://www.tk-tek.com'>TK Tek, LLC</a> | License: <a href='http://www.gnu.org/copyleft/gpl.html'>GNU General Public License</a></td></tr></tbody></table>"; ?>
<?php
if (isset($this->lists['css']))
    echo "</body></html>";
?>
