<?php

/**
 *
 *
 * This is the category.php table for jobgroklist
 *
 * Created: June 13, 2014, 1:18 am
 *
 * Subversion Details
 * $Date: 2013-07-17 20:28:06 -0500 (Wed, 17 Jul 2013) $
 * $Revision: 5332 $
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

class TableCategory extends JTable
{
/** @var int Primary Key */
    var $id = null;
    /** $var int Category Code */
    var $code = null;
    /** @var string Category Name */
    var $description = null;
    var $use_description = null;
    /** @var int Company Id */
    var $company_id = null;
    var $cat_contact_id = null;
    var $cat_notify_contact = null;
    /** @var int Checked-out Owner */
    var $checked_out = null;
    /** @var string Checked-out Time */
    var $checked_out_time = null;
    /** @var string Parameters */
    var $params = null;
    /** @var ordering Order Position */
    var $ordering = null;
    /** @var int Number of Views */
    var $hits = null;
    /** @var int Published */
    var $published = null;

    /**
     * Constructor
     *
     * @param database Database Object
     *
     */
    function __construct (&$db)
    {
        parent::__construct('#__tst_jglist_categories', 'id', $db);
    }

    /**
     * Validation
     *
     * @return boolean True if buffer is valid
     *
     */
    function check()
    {
        if (!$this->code)
        {
            $this->setError(JTEXT::_('COM_JOBGROKLIST_TABLES_CATEGORY_CATEGORY_CHECK'));
            return false;
        }
        return true;
    }

}

?>
