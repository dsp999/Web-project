<?php
/**
 *
 *
 * This is the view.raw.php file for jobgroklist
 *
 * Created: June 13, 2014, 1:18 am
 *
 * Subversion Details
 * $Date: 2012-05-17 21:22:36 -0500 (Thu, 17 May 2012) $
 * $Revision: 3941 $
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
 * Job Type View
 * 
 */
class JobgroklistViewPosting extends JViewLegacy
{

	function display($tpl = 'dropdown')
	{
		$filter_on = JRequest::getVar('filter_on'); // field to filter on
		$filter_value = JRequest::getInt('filter_value'); // value in field to filter on
		$filter_for = JRequest::getVar('filter_for'); // object to filter for
                $filter_select = JRequest::getVar('filter_select','*'); // selected value
		
		$allowed_filter_on = array('companies');
		$allowed_filter_for = array('job','contact','location');
		
		if (!in_array($filter_on, $allowed_filter_on))
		{
			$filter_on = 'companies';
		}
		
		if (!in_array($filter_for, $allowed_filter_for))
		{
			$filter_for = 'job';
		}
		
		switch ($filter_for)
		{
			case 'job':
				$lists['dropdown'] = JHTML::_('jobgroklist.jobtitle','','',$filter_for.'_id',$filter_on,$filter_value);
				break;
			case 'contact':
				$lists['dropdown'] = JHTML::_('jobgroklist.contact',$filter_select,'',$filter_for.'_id',$filter_on,$filter_value);
				break;
                        case 'location':
                                $lists['dropdown'] = JHTML::_('jobgroklist.location',$filter_select,'',$filter_for.'_id',$filter_on,$filter_value);
                                break;
		}
		$this->assignRef('lists',$lists);
		
		parent :: display($tpl);
	}
}
?>
