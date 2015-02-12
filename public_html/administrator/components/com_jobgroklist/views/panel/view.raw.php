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
class JobgroklistViewPanel extends JViewLegacy
{

	function display($tpl = 'panelnews')
	{
                $panelnews = 'none';
                $extension = JRequest::getVar('e','0');
		$allowed = array('1','2','3','4');
                	
		if (!in_array($extension, $allowed)) {
			$extension = '0';
		} 
                
		switch ($extension) {
			case '1':
                            $panelnews = 'board';
                            break;
			case '2':
                            $panelnews = 'premium';
                            break;
                        case '3':
                            $panelnews = 'listing';
                            break;
                        case '4':
                            $panelnews = 'application';
                            break;
                        default:
                            $panelnews = 'none';
		}
		$this->assignRef('panelnews',$panelnews);
		
		parent :: display($tpl);
	}
}
?>
