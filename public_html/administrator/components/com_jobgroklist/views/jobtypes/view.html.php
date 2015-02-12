<?php
/**
 *
 *
 * This is the view.html.php file for jobgroklist
 *
 * Created: June 13, 2014, 1:18 am
 *
 * Subversion Details
 * $Date: 2013-01-30 21:50:35 -0600 (Wed, 30 Jan 2013) $
 * $Revision: 4673 $
 * $Author: bobsteen $
 *
 * @author TK Tek, LLC. info@jobgrok.com
 * @version 3.1-1.2.57
 * @package com_jobgroklist
 *
 */

defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.view');

/**
 *
 * Job Type View
 *
 */
class JobgroklistViewJobtypes extends JViewLegacy

{
/**
 *
 * Renders the View
 *
 */
    function display($tpl = null)
    {

        global $option;
		$mainframe = JFactory::getApplication();

        JToolBarHelper :: title(JTEXT::_('COM_JOBGROKLIST_VIEWS_JOBTYPES_VIEW_HTML_JOB_TYPES'),'jobtype');
        JToolBarHelper :: addNew();
        JToolBarHelper :: editList();
        JToolBarHelper :: custom('copy','copy.png','copy_f2.png',JTEXT::_('COM_JOBGROKLIST_VIEWS_JOBTYPES_VIEW_HTML_COPY'));
        JToolBarHelper :: deleteList();
        JToolBarHelper :: cancel();

        $items = $this->get('Data');
        $this->assignRef('items', $items);

        $pagination = $this->get('Pagination');
        $this->assignRef('pagination', $pagination);


        parent :: display($tpl);
    }
}
?>
