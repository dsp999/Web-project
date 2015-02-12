<?php

/**
 *
 *
 * This is the company.php table for jobgroklist
 *
 * Created: June 13, 2014, 1:18 am
 *
 * Subversion Details
 * $Date: 2012-05-05 20:49:02 -0500 (Sat, 05 May 2012) $
 * $Revision: 3833 $
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

class TableCompany extends JTable
{
/** 
 * Primary Key
 * @access public
 * @var int
 */
    var $id = null;
    /**
     * Company Name
     * @access public
     * @var string
     */
    var $company = null;
    /**
     * Checked-out Owner
     * @access public
     * @var int
     */
    var $company_revenue = null;
    var $company_size = null;
    var $checked_out = null;
    /**
     * Checked-out Time
     * @access public
     * @var string
     */
    var $checked_out_time = null;
    /**
     * Parameters
     * @access public
     * @var string
     */
    var $params = null;
    /**
     * Order Position
     * @access public
     * @var ordering
     */
    var $ordering = null;
    /**
     * Number of Views
     * @access public
     * @var int
     */
    var $hits = null;
    /**
     * Published
     * @access public
     * @var int
     */
    var $published = null;

    /**
     * Constructor
     *
     * @param database
     *
     */
    function __construct(& $db)
    {
        parent :: __construct('#__tst_jglist_companies', 'id', $db);
    }

    /**
     * Validation
     *
     * @return boolean
     *
     */
    function check()
    {
        if (!$this->company)
        {
            $this->setError(JTEXT::_('COM_JOBGROKLIST_TABLES_COMPANY_COMPANY_CHECK'));
            return false;
        }
        return true;
    }

    function bind($array, $ignore = '')
    {
            if (key_exists( 'params', $array ) && is_array( $array ))
            {
                    $registry = new JRegistry();
                    $registry->loadArray($array['params']);
                    $array['params'] = $registry->toString();
            }
            return parent::bind($array, $ignore);
    }

}
?>
