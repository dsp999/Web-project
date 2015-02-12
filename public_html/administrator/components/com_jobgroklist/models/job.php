<?php

/**
 *
 *
 * This is the job.php controller for jobgroklist
 *
 * Created: June 13, 2014, 1:18 am
 *
 * Subversion Details
 * $Date: 2013-07-15 20:50:45 -0500 (Mon, 15 Jul 2013) $
 * $Revision: 5323 $
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
jimport('joomla.application.component.model');

/**
 *
 * Job Model
 *
 */

class JobgroklistModelJob extends JModelLegacy

{
/**
 *
 * Job Id
 *
 * @var int
 *
 */
    var $_id;

    /**
     *
     * Job Data
     *
     * @var object
     *
     */
    var $_job;

    /**
     * Items total
     * @var integer
     */
    var $_total = null;

    /**
     * Pagination object
     * @var object
     */
    var $_pagination = null;
    var $_last_id = null;
    var $_last_company_id = null;
    /**
     *
     * Set query to pull data
     *
     */
    function _buildQuery()
    {
        $query = 'SELECT j.* FROM #__tst_jglist_jobs j '.
            'LEFT JOIN #__tst_jglist_departments d ON j.department_id=d.id '.
            'LEFT JOIN #__tst_jglist_shifts s ON j.shift_id=s.id '.
            'LEFT JOIN #__tst_jglist_jobtypes jt ON j.jobtype_id=jt.id '.
            'LEFT JOIN #__tst_jglist_companies c ON j.company_id=c.id '.
            'LEFT JOIN #__tst_jglist_categories cat ON j.category_id=cat.id '.
            'LEFT JOIN #__tst_jglist_static_category sc ON cat.code=sc.id ' .
            "";
        return $query;
    }

    /**
     *
     * Retrieves the Jobs data
     *
     * @return array Array of objects containing categories data
     *
     */
    function & getData()
    {
        if (empty ($this->_job))
        {
            $query = $this->_buildQuery();
            $limitstart = $this->getState('limitstart');
            $limit = $this->getState('limit');
            $this->_job = $this->_getList($query, $limitstart, $limit);

        }

        return $this->_job;
    }


    /**
     * Method to set the job identifier
     *
     * @access    public
     * @param    int Job identifier
     * @return    void
     */
    function setId($id)
    {
    // Set id and wipe data
        $this->_id = $id;
        $this->_job = null;
    }
    /**
     *
     * Constructor
     *
     */
    function __construct()
    {
        parent :: __construct();

        // get the cid array from the default request hash
        $cid = JRequest :: getVar('cid', false, 'DEFAULT', 'array');
        if ($cid)
        {
            $id = $cid[0];
        }
        else
        {
            $id = JRequest :: getInt('id', 0);
        }
        $this->setId($id);

        global $option;
        $mainframe = JFactory::getApplication();

        // Get pagination request variables
        $limit = $mainframe->getUserStateFromRequest('global.list.limit', 'limit', $mainframe->getCfg('list_limit'));
        //$limitstart = $mainframe->getUserStateFromRequest($option . '.limitstart', 'limitstart', 0);

        //$limitstart = mosGetParam($_REQUEST, 'limitstart', 0);
        // Am I missing something, is this a hack, or an OK solution?
        $limitstart = JRequest :: getVar('limitstart', 0);

        // In case limit has been changed, adjust it
        $limitstart = ($limit != 0 ? (floor($limitstart / $limit) * $limit) : 0);

        $this->setState('limit', $limit);
        $this->setState('limitstart', $limitstart);
    }

    function getTotal()
    {
    // Load the content if it doesn't already exist
        if (empty ($this->_total))
        {
            $query = $this->_buildQuery();
            $this->_total = $this->_getListCount($query);
        }
        return $this->_total;
    }

    function getPagination()
    {
    // Load the content if it doesn't already exist
        if (empty ($this->_pagination))
        {
            jimport('joomla.html.pagination');

            $total = $this->getTotal();
            $limitstart = $this->getState('limitstart');
            $limit = $this->getState('limit');

            $this->_pagination = new JPagination($total, $limitstart, $limit);
        }
        return $this->_pagination;
    }

    /**
     * Method to delete record(s)
     *
     * @access    public
     * @return    boolean    True on success
     */
    function delete()
    {
        $cids = JRequest :: getVar('cid', array (
            0
            ), 'post', 'array');
        $row = $this->getTable();

        foreach ($cids as $cid)
        {
            if (!$row->delete($cid))
            {
                $this->setError($row->getErrorMsg());
                return false;
            }
        }

        return true;
    }
    function store()
    {

        $row = $this->getTable();

        if (!$row->bind(JRequest :: get('post')))
        {
            $this->setError($this->_db->getErrorMsg());
            return false;
        }

        $row->job_description = JRequest :: getVar('job_description', '', 'POST', 'string', JREQUEST_ALLOWRAW);
        $row->preferred_skills = JRequest :: getVar('preferred_skills', '', 'POST', 'string', JREQUEST_ALLOWRAW);

        if (!$row->check()) { return false; }
        
        if (!$row->store())
        {
            $this->setError($this->_db->getErrorMsg());
            return false;
        }
        
        if(empty($row->create_date)) {
            $timenow = new JDate();
            $mysqlTime = JHTML::_('date', $timenow,"Y-m-d G:i:s");
            $row->create_date = $mysqlTime;
        }
        
        if(empty($row->job_code)) {
            $params = JComponentHelper::getParams('com_jobgroklist');
            if ($params->get('auto_generate_job_codes','0') == '1') {
                $row->job_code = JHTML::_('jobgroklist.auto_generate_jobcode',$row,$params);
                $row->store();
            }
        }
        
        $this->_last_id = $row->id;
        $this->_last_company_id = $row->company_id;
        
        return true;

    }
    
    function getLastCompanyId() {
        return $this->_last_company_id;
    }
    
    function getLastId() {
        return $this->_last_id;
    }

    /**
     *
     * Gets Job data
     *
     * @return object
     *
     */
    function & getJob()
    {
        if (!$this->_job && $this->_id != '')
        {
            $db = $this->getDBO();
            $query = "SELECT * FROM " . $db->quoteName('#__tst_jglist_jobs') . " WHERE " .
                $db->quoteName('id') . " = " . $this->_id;
            ;
            $db->setQuery($query);
            $this->_job = $db->loadObject();
        }
        return $this->_job;
    }

    function copy()
    {

        $cids = JRequest :: getVar('cid', array (0), 'post', 'array');
        $row = $this->getTable();

        foreach ($cids as $cid)
        {
            $this->_job = null;
            $this->_id = $cid;
            $tmp = $this->getJob();
            if (!$tmp)
            {
                $this->setError($row->getErrorMsg());
                return false;
            }
            $tmp->id = null;
            $tmp->title = "Copy of ".$tmp->title;
            $this->save($tmp);

        }
        return true;

    }

    /**
     *
     * Save a Job
     *
     */
    function save($data)
    {
        $table = $this->getTable();
        if (!$table->save($data))
        {
            $this->setError($table->getError());
            return false;
        }
        return true;
    }

    /**
     *
     * Increments the hit counter
     *
     */
    function hit()
    {
        $db = JFactory :: getDBO();
        $db->setQuery("UPDATE " . $db->quoteName('#__tst_jglist_jobs') . " SET " .
            $db->quoteName('hits') . " = " . $db->quoteName('hits') . " + 1 " .
            "WHERE id = " . $this->_id);
        $db->query();
    }
}
?>
