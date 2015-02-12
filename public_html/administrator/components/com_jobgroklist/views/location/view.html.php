<?php
/**
 *
 *
 * This is the view.html.php file for jobgroklist
 *
 * Created: June 13, 2014, 1:18 am
 *
 * Subversion Details
 * $Date: 2014-02-16 21:39:18 -0600 (Sun, 16 Feb 2014) $
 * $Revision: 5782 $
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
 * Category View
 *
 */
class JobgroklistViewLocation extends JViewLegacy

{

    function display($tpl = null)
    {
    //get the hello
        $location = $this->get('Location');
        if (!isset($location->id))
            $isNew = true;
        else
            $isNew = false;

        $text = $isNew ? JTEXT::_('COM_JOBGROKLIST_VIEWS_LOCATION_VIEW_HTML_ADD') :
            JTEXT::_('COM_JOBGROKLIST_VIEWS_LOCATION_VIEW_HTML_EDIT');
        JToolBarHelper :: title(JTEXT::_('COM_JOBGROKLIST_VIEWS_LOCATION_VIEW_HTML_LOCATION') . ': <small><small>[ ' . $text . ' ]</small></small>','location');
        JToolBarHelper :: save();
        if ($isNew)
        {
            JToolBarHelper :: cancel();
        }
        else
        {
        // for existing items the button is renamed `close`
            JToolBarHelper :: cancel('cancel', JTEXT::_('COM_JOBGROKLIST_VIEWS_LOCATION_VIEW_HTML_CLOSE'));
        }

        $cparams = JComponentHelper::getParams('com_jobgroklist');
        $this->assignRef('cparams', $cparams);
        
        $lists['country_static'] = JHTML::_('jobgroklist.static_country',(isset($location->country_id)?$location->country_id:$cparams->get('default_country_code','')),'','country_id');
        $lists['company'] = JHTML::_('jobgroklist.company',(isset($location->company_id)?$location->company_id:''),'','company_id','detail');
        $this->assignRef('lists', $lists);
        
        $this->assignRef('location', $location);
        parent :: display($tpl);
    }
}
?>
