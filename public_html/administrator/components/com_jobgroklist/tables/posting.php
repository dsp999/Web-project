<?php

/**
 *
 *
 * This is the posting.php table for jobgroklist
 *
 * Created: June 13, 2014, 1:18 am
 *
 * Subversion Details
 * $Date: 2014-05-06 21:06:48 -0500 (Tue, 06 May 2014) $
 * $Revision: 6057 $
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

class TablePosting extends JTable
{
/** @var int Primary Key */
    var $id = null;
    /** @var int Job Id*/
    var $job_id = null;
    /** @var int Company Id*/
    var $company_id = null;
    /** @var int Location Id*/
    var $location_id = null;
    /** @var string summary */
    var $summary = null;
    /** @var string posting_date */
    var $posting_date = null;
    /** @var string closing_date */
    var $closing_date = null;
    var $closing_days = null;
    /** @var int contact_id */
    var $contact_id = null;
    var $notify_contact = null;
    var $include_detail = null;
    /** @var text application_type */
    var $application_type = null;
    /** @var int Checked-out Owner */
    var $link = null;
    var $link_text = null;
    var $checked_out = null;
    /** @var string Checked-out Time */
    var $checked_out_time = null;
    /** @var string Parameters */
    var $params = null;
    /** @var ordering Order Position */
    var $ordering = null;
    /** @var int Number of Views */
    var $hits = null;
    /** @var int Number of Applications */
    var $applications = null;
    /** @var int Published */
    var $published = null;
    var $viewlevel = null;

    /**
     * Constructor
     *
     * @param database Database Object
     *
     */
    function __construct (&$db)
    {
        parent::__construct('#__tst_jglist_postings', 'id', $db);
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

    /**
     * Validation
     *
     * @return boolean True if buffer is valid
     *
     */
    function check()
    {
        $params = JComponentHelper::getParams('com_jobgroklist');        
        if (!$this->job_id)
        {
            $this->setError(JTEXT::_('COM_JOBGROKLIST_TABLES_POSTING_POSTING_CHECK'));
            return false;
        }
        return true;
    }

}

?>
