<?php
/**
 *
 *
 * This is the view.html.php file for jobgroklist
 *
 * Created: June 13, 2014, 1:18 am
 *
 * Subversion Details
 * $Date: 2014-04-21 20:47:28 -0500 (Mon, 21 Apr 2014) $
 * $Revision: 5985 $
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
 * Posting View
 *
 */
class JobgroklistViewPanel extends JViewLegacy
{
    /**
     *
     * Renders the View
     *
     */
    function display($tpl = null) {
        $getnews = $this->get('News');
        $this->assignRef('getnews', $getnews);
        
        

        JToolBarHelper::title(JTEXT::_('COM_JOBGROKLIST_VIEWS_PANEL_VIEW_HTML_JOBGROKLIST'),'postings');

        JToolBarHelper :: preferences("com_jobgroklist",'400');

        parent :: display($tpl);
    }
}
?>
