<?php
/**
 *
 *
 * This is the view.html.php file for jobgroklist
 *
 * Created: June 13, 2014, 1:18 am
 *
 * Subversion Details
 * $Date: 2012-08-14 20:50:52 -0500 (Tue, 14 Aug 2012) $
 * $Revision: 4276 $
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

jimport('joomla.application.component.view');

/**
 *
 * Company View
 *
 */
class JobgroklistViewCompany extends JViewLegacy

{

    function display($tpl = null)
    {
    //get the hello
        $company = $this->get('Company');
        if (!isset($company->id))
            $isNew = true;
        else
            $isNew = false;

        $text = $isNew ? JTEXT::_('COM_JOBGROKLIST_VIEWS_COMPANY_VIEW_HTML_ADD') :
            JTEXT::_('COM_JOBGROKLIST_VIEWS_COMPANY_VIEW_HTML_EDIT');
        JToolBarHelper :: title(JTEXT::_('COM_JOBGROKLIST_VIEWS_COMPANY_VIEW_HTML_COMPANY') . ': <small><small>[ ' . $text . ' ]</small></small>','company');
        JToolBarHelper :: save();
        if ($isNew)
        {
            JToolBarHelper :: cancel();
        }
        else
        {
        // for existing items the button is renamed `close`
            JToolBarHelper :: cancel('cancel', JTEXT::_('COM_JOBGROKLIST_VIEWS_COMPANY_VIEW_HTML_CLOSE'));
        }

        $lists['company_size'] = JHTML::_('jobgroklist.static_company_size',(isset($company->company_size)?$company->company_size:''),'','company_size');
        $lists['company_revenue'] = JHTML::_('jobgroklist.static_company_revenue',(isset($company->company_revenue)?$company->company_revenue:''),'','company_revenue');

        $this->assignRef('lists', $lists);
        $this->assignRef('company', $company);
        parent :: display($tpl);
    }
}
?>
