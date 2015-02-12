<?php

/**
 *
 *
 * This is the job.php table for jobgroklist
 *
 * Created: June 13, 2014, 1:18 am
 *
 * Subversion Details
 * $Date: 2013-07-21 14:29:26 -0500 (Sun, 21 Jul 2013) $
 * $Revision: 5365 $
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

class TableJob extends JTable
{
/** @var int Primary Key */
    var $id = null;
    var $job_code = null;
    /** @var string Location Name */
    var $title = null;
    var $alias = null;
    /** @var category_id */
    var $category_id = null;
    /** @var department id */
    var $department_id = null;
    /** @var shift id */
    var $shift_id = null;
    /** @var location id */
    var $location_id = null;
    /** @var jobtype_id */
    var $jobtype_id = null;
    /** @var company_id */
    var $company_id = null;
    /** @var education_id */
    var $education_id = null;
    /** @var pay_rate */
    var $pay_rate = null;
    /** @var hide_payrate */
    var $hide_payrate = null;
    var $payrange = null;
    /** @var duration */
    var $duration = null;
    /** @var travel */
    var $travel = null;
    /** @var job_description */
    var $job_description = null;
    /** @var preferred_skills */
    var $preferred_skills = null;
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
        parent::__construct('#__tst_jglist_jobs', 'id', $db);
    }

    /**
     * Validation
     *
     * @return boolean True if buffer is valid
     *
     */
    function check()
    {
        jimport( 'joomla.filter.output' );
        //if(empty($this->alias)) {
        //        $this->alias = $this->title;
        //}
        if (!$this->alias) $this->alias = JFilterOutput::stringURLSafe($this->title);
                        
        if (!$this->title)
        {
            $this->setError(JTEXT::_('COM_JOBGROKLIST_TABLES_JOB_JOB_CHECK'));
            return false;
        }
                
        return true;
    }

}

?>
