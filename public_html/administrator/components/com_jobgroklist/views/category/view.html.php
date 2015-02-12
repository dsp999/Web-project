<?php
/**
 *
 *
 * This is the view.html.php file for jobgroklist
 *
 * Created: June 13, 2014, 1:18 am
 *
 * Subversion Details
 * $Date: 2013-07-16 10:00:40 -0500 (Tue, 16 Jul 2013) $
 * $Revision: 5328 $
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

jimport('joomla.application.component.view');

/**
 *
 * Category View
 *
 */
class JobgroklistViewCategory extends JViewLegacy

{

    function display($tpl = null)
    {
    //get the hello
        $category = $this->get('Category');
        if (!isset($category->id))
            $isNew = true;
        else
            $isNew = false;

        $text = $isNew ? JTEXT::_('COM_JOBGROKLIST_VIEWS_CATEGORY_VIEW_HTML_ADD') :
            JTEXT::_('COM_JOBGROKLIST_VIEWS_CATEGORY_VIEW_HTML_EDIT');
        JToolBarHelper :: title(JTEXT::_('COM_JOBGROKLIST_VIEWS_CATEGORY_VIEW_HTML_CATEGORY') . ': <small><small>[ ' . $text . ' ]</small></small>','category');
        JToolBarHelper :: save();
        if ($isNew)
        {
            JToolBarHelper :: cancel();
        }
        else
        {
        // for existing items the button is renamed `close`
            JToolBarHelper :: cancel('cancel', JTEXT::_('COM_JOBGROKLIST_VIEWS_CATEGORY_VIEW_HTML_CLOSE'));
        }

        $lists['company'] = JHTML::_('jobgroklist.company',(isset($category->company_id)?$category->company_id:''),'','company_id','detail');
        $lists['category_static'] = JHTML::_('jobgroklist.static_category',(isset($category->code)?$category->code:''));
        $lists['contact'] = JHTML::_('jobgroklist.contact',isset($category->cat_contact_id)?$category->cat_contact_id:'*','','cat_contact_id',isset($category->company_id)?'companies':'contact',isset($category->company_id)?$category->company_id:'*');
        $this->assignRef('lists', $lists);

        
        $this->assignRef('category', $category);
        parent :: display($tpl);
    }
}
?>