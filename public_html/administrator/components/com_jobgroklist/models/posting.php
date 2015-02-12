<?php

/**
 *
 *
 * This is the posting.php controller for jobgroklist
 *
 * Created: June 13, 2014, 1:18 am
 *
 * Subversion Details
 * $Date: 2014-05-04 16:22:58 -0500 (Sun, 04 May 2014) $
 * $Revision: 6035 $
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
jimport('joomla.application.component.model');

jimport('joomla.filesystem.file');


/**
 *
 * Posting Model
 *
 */

class JobgroklistModelPosting extends JModelLegacy

{
/**
 *
 * Posting Id
 *
 * @var int
 *
 */
    var $_id;
    var $_options;
    /**
     *
     * Posting Data
     *
     * @var object
     *
     */
    var $_posting;

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

    /**
     *
     * Set query to pull data
     *
     */
    function _buildQuery()
    {
        $query = 'SELECT p.* FROM #__tst_jglist_postings p LEFT JOIN #__tst_jglist_jobs j ON p.job_id=j.id '.
            'LEFT JOIN #__tst_jglist_companies c ON j.company_id = c.id '.
            'LEFT JOIN #__tst_jglist_departments d ON j.department_id = d.id '.
            'LEFT JOIN #__tst_jglist_locations l ON p.location_id = l.id '.
            "";
        return $query;

    }

    /**
     *
     * Retrieves the Posting data
     *
     * @return array Array of objects containing categories data
     *
     */
    function & getData()
    {
    // if data hasn't already been obtained, load it
        if (empty($this->_posting))
        {
            $query = $this->_buildQuery();
            $limitstart = $this->getState('limitstart');
            $limit = $this->getState('limit');

            $this->_posting = $this->_getList($query, $limitstart, $limit);
        }
        return $this->_posting;
    }


    /**
     * Method to set the posting identifier
     *
     * @access    public
     * @param    int Posting identifier
     * @return    void
     */
    function setId($id)
    {
    // Set id and wipe data
        $this->_id = $id;
        $this->_posting = null;
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
        //$limitstart = $mainframe->getUserStateFromRequest($option.'.limitstart', 'limitstart', 0);

        //$limitstart = mosGetParam($_REQUEST, 'limitstart', 0);
        // Am I missing something, is this a hack, or an OK solution?
        $limitstart = JRequest::getVar('limitstart',0);

        // In case limit has been changed, adjust it
        $limitstart = ($limit != 0 ? (floor($limitstart / $limit) * $limit) : 0);

        $this->setState('limit', $limit);
        $this->setState('limitstart', $limitstart);
    }

    function getTotal()
    {
    // Load the content if it doesn't already exist
        if (empty($this->_total))
        {
            $query = $this->_buildQuery();
            $this->_total = $this->_getListCount($query);
        }
        return $this->_total;
    }

    function getPagination()
    {
    // Load the content if it doesn't already exist
        if (empty($this->_pagination))
        {
            jimport('joomla.html.pagination');

            $total = $this->getTotal();
            $limitstart = $this->getState('limitstart');
            $limit = $this->getState('limit');

            $this->_pagination = new JPagination($total, $limitstart, $limit);
        }
        return $this->_pagination;
    }

    function publish()
    {
        $cids = JRequest :: getVar('cid', array (0), 'post', 'array');
        $row = $this->getTable();

        if ( !$row->publish($cids,1))
        {
            $this->setError('Could not publish record(s)!');
            return false;
        }
        return true;
    }

    function unpublish()
    {
        $cids = JRequest :: getVar('cid', array (0), 'post', 'array');
        $row = $this->getTable();

        if ( !$row->publish($cids,0))
        {
            $this->setError('Could not unpublish record(s)!');
            return false;
        }
        return true;
    }

    function featured() {
        $id = JRequest::getVar('id');
        if (isset($id)) {
            if (!$this->setFeatured($id, 1)) {
                $this->setError('Could not set record(s) as featured item!');
                return false;
            }
            return true;
        }
        return false;
    }
    
    function unfeatured() {
        $id = JRequest::getVar('id');
        if (isset($id)) {
            if (!$this->setFeatured($id, 0)) {
                $this->setError('Could not set record(s) as unfeatured item!');
                return false;
            }
            return true;
        }
        return false;
    }
    
    function setFeatured($id, $value) {
        $db = JFactory::getDBO();
        $query = "UPDATE #__tst_jglist_postings SET ".$db->quoteName('featured')."=".$value." WHERE ".$db->quoteName('id')."=".$id;
        $db->setQuery($query); 
        if (!$db->Query()) return false;
        return true;
    }
    
    function reset()
    {
        $db = JFactory::getDBO();
        $cids = JRequest::getVar('cid',array(0)); //,'post','array');
        
        foreach ($cids as $cid)
        {
            $query = "UPDATE #__tst_jglist_postings SET ".
                        $db->quoteName('hits')."=0 WHERE ".$db->quoteName('id')."=".$cid;
            $db->setQuery($query);$db->Query();;
        }
        return true;
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

        if (!$row->bind(JRequest::get('post')))
        {
            $this->setError($this->_db->getErrorMsg());
            return false;
        }

        $row->summary = JRequest::getVar('summary','','POST','string',JREQUEST_ALLOWRAW);

        $db = JFactory::getDBO();
        $params = JComponentHelper::getParams('com_jobgroklist');
        // get company params if company exists
        if (isset($row->company_id) && $row->company_id > 0)
        {
            $query = "SELECT params FROM #__tst_jglist_companies WHERE id=".$row->company_id;
            $db->setQuery($query);
            $paramsdata = $db->loadResult();
            // merge params
            if ($paramsdata) $params->merge(new JRegistry($paramsdata));
        }

        if (!isset($row->viewlevel) or (int)$row->viewlevel == 0) $row->viewlevel = $params->get('default_viewlevel','1');
        
        if (!$row->store())
        {
            $this->setError($this->_db->getErrorMsg());
            return false;
        }

        return true;

    }

    /**
     *
     * Gets Job data
     *
     * @return object
     *
     */
    function & getPosting()
    {
        if (!$this->_posting && $this->_id != '')
        {
            $db = $this->getDBO();
            $query = "SELECT * FROM " . $db->quoteName('#__tst_jglist_postings') . " WHERE " .
                $db->quoteName('id') . " = " . $this->_id;
            ;
            $db->setQuery($query);
            $this->_posting = $db->loadObject();
        }
        return $this->_posting;
    }

    function copy()
    {

        $cids = JRequest :: getVar('cid', array (0), 'post', 'array');
        $row = $this->getTable();

        foreach ($cids as $cid)
        {
            $this->_posting = null;
            $this->_id = $cid;
            $tmp = $this->getPosting();
            if (!$tmp)
            {
                $this->setError($row->getErrorMsg());
                return false;
            }
            $tmp->id = null;
            //$tmp->posting = "Copy of ".$tmp->posting;
            $tmp->hits = 0;
            $tmp->applications = 0;
            $this->save($tmp);

        }
        return true;

    }

    /**
     *
     * Save a Posting
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
        $db->setQuery("UPDATE " . $db->quoteName('#__tst_jglist_postings') . " SET " .
            $db->quoteName('hits') . " = " . $db->quoteName('hits') . " + 1 " .
            "WHERE id = " . $this->_id);
        $db->query();
    }

    function columnExists($table, $column)
    {
        $db = JFactory::getDBO();
        $prefix = $db->getPrefix();
        $table = $prefix.'tst_jglist_'.$table;
        $result = $db->getTableColumns($table);
        if (isset($table[$column]))
            return true;
        else
            return false;
    }

    function getLocationFix()
    {
        if ($this->columnExists('postings', 'location_id'))
            return false;
        else
            return true;
    }

    function bugFixI()
    {
        try
        {
            $db = $this->_db;
            $query = "ALTER TABLE #__tst_jglist_postings ADD `location_id` INT NOT NULL;";
            $db->setQuery($query);$db->Query();;

            $query = "UPDATE #__tst_jglist_postings p JOIN #__tst_jglist_jobs j ON p.job_id=j.id SET p.location_id=j.location_id WHERE p.location_id=0 OR p.location_id IS NULL;";
            $db->setQuery($query);$db->Query();;
        }
        catch (Exception $e)
        {
            return false;
        }
        return true;
    }

    function getComCount()
    {

        $db = JFactory::getDBO();
        $query = "SELECT COUNT(name) FROM #__extensions WHERE name='com_employmentlisting'";
        $db->setQuery($query);
        return $db->loadResult();
    }

    function getRecordCount()
    {
        $db = JFactory::getDBO();
        $query = "SELECT SUM(a.ID) As 'RowCount' FROM ( ".
            "SELECT COUNT(id) As 'ID' FROM #__tst_jglist_categories UNION ALL ".
            "SELECT COUNT(id) As 'ID' FROM #__tst_jglist_companies UNION ALL ".
            "SELECT COUNT(id) As 'ID' FROM #__tst_jglist_departments UNION ALL ".
            "SELECT COUNT(id) As 'ID' FROM #__tst_jglist_locations UNION ALL ".
            "SELECT COUNT(id) As 'ID' FROM #__tst_jglist_jobtypes UNION ALL ".
            "SELECT COUNT(id) As 'ID' FROM #__tst_jglist_contacts UNION ALL ".
            "SELECT COUNT(id) As 'ID' FROM #__tst_jglist_shifts UNION ALL ".
            "SELECT COUNT(id) As 'ID' FROM #__tst_jglist_jobs UNION ALL ".
            "SELECT COUNT(id) As 'ID' FROM #__tst_jglist_postings) a";
        $db->setQuery($query);
        return $db->loadResult();
    }

    function import()
    {
        try
        {
            $db = $this->_db;

            $query = "INSERT INTO #__tst_jglist_categories (`id`, `description`, `use_description`, `company_id`, ".
                "`checked_out`, `checked_out_time`, `params`, `ordering`, `hits`, `published`) SELECT ".
                "`id`, `category`, 1, `company_id`, `checked_out`, `checked_out_time`, `params`, `ordering`, ".
                "`hits`, `published` FROM `#__tst_el_categories` WHERE `id`>1;";
            $db->setQuery($query);$db->Query();;

            $query = "INSERT INTO #__tst_jglist_companies (`id`, `company`, `checked_out`, `checked_out_time`, `params`,".
                "`ordering`, `hits`, `published`) SELECT `id`, `company`, `checked_out`, `checked_out_time`, `params`,".
                "`ordering`, `hits`, `published` FROM `#__tst_el_companies` WHERE `id`>1;";
            $db->setQuery($query);$db->Query();;

            $query = "INSERT INTO #__tst_jglist_departments (`id`, `department`, `company_id`, `checked_out`, `checked_out_time`,".
                "`params`, `ordering`, `hits`, `published`) SELECT `id`, `department`, `company_id`, `checked_out`, ".
                "`checked_out_time`, `params`, `ordering`, `hits`, `published` FROM `#__tst_el_departments` WHERE `id`>1;";
            $db->setQuery($query);$db->Query();;

            $query = "INSERT INTO #__tst_jglist_locations (`id`, `location`, `use_location`, `loc_description`, `loc_address`,".
                "`company_id`, `checked_out`, `checked_out_time`, `params`, `ordering`, `hits`, `published`) SELECT `id`,".
                "`location`, 1, `loc_description`, `loc_address`, `company_id`, `checked_out`, `checked_out_time`,".
                "`params`, `ordering`, `hits`, `published` FROM `#__tst_el_locations` WHERE `id`>1;";
            $db->setQuery($query);$db->Query();;

            $query = "INSERT INTO #__tst_jglist_jobtypes (`id`, `jobtype`, `use_description`, `company_id`, `checked_out`,".
                "`checked_out_time`, `params`, `ordering`, `hits`, `published`) SELECT `id`, `jobtype`, 1, `company_id`,".
                "`checked_out`, `checked_out_time`, `params`, `ordering`, `hits`, `published` FROM `#__tst_el_jobtypes` WHERE `id`>1;";
            $db->setQuery($query);$db->Query();;

            $query = "INSERT INTO #__tst_jglist_contacts (`id`, `contact`, `contact_email`, `company_id`, `checked_out`, `checked_out_time`,".
                "`params`, `ordering`, `hits`, `published`) SELECT `id`, `contact`, `contact_email`, `company_id`, `checked_out`,".
                "`checked_out_time`, `params`, `ordering`, `hits`, `published` FROM #__tst_el_contacts WHERE `id`>1;";
            $db->setQuery($query);$db->Query();;

            $query = "INSERT INTO #__tst_jglist_shifts (`id`, `shift`, `company_id`, `checked_out`, `checked_out_time`, `params`,".
                "`ordering`, `hits`, `published`) SELECT `id`, `shift`, `company_id`, `checked_out`, `checked_out_time`, `params`,".
                "`ordering`, `hits`, `published` FROM #__tst_el_shifts WHERE `id`>1;";
            $db->setQuery($query);$db->Query();;

            $query = "INSERT INTO #__tst_jglist_jobs (`id`, `title`, `category_id`, `department_id`, `shift_id`, `location_id`, `jobtype_id`,".
                "`company_id`, `pay_rate`, `hide_payrate`, `duration`, `travel`, `job_description`, `preferred_skills`, `checked_out`, ".
                "`checked_out_time`, `params`, `ordering`, `hits`, `published`) SELECT `id`, `title`, `category_id`, `department_id`, ".
                "`shift_id`, `location_id`, `jobtype_id`, `company_id`, `pay_rate`, `hide_payrate`, `duration`, `travel`, ".
                "`job_description`, `preferred_skills`, `checked_out`, `checked_out_time`, `params`, `ordering`, `hits`, `published` ".
                "FROM #__tst_el_jobs  WHERE `id`>0;";
            $db->setQuery($query);$db->Query();;

            $query = "INSERT INTO #__tst_jglist_postings (`id`, `job_id`, `summary`, `posting_date`, `closing_date`, `contact_id`, `checked_out`, ".
                "`checked_out_time`, `params`, `ordering`, `hits`, `published`, `notify_contact` ) SELECT `id`, `job_id`, `summary`, `posting_date`, ".
                "`closing_date`, `contact_id`, `checked_out`, `checked_out_time`, `params`, `ordering`, `hits`, `published`, 0 ".
                "FROM #__tst_el_postings WHERE `id`>0;";
            $db->setQuery($query);$db->Query();;
            $query = "UPDATE #__tst_jglist_postings jgp, #__tst_el_jobs elj SET jgp.company_id=elj.company_id WHERE jgp.job_id=elj.id;";
            $db->setQuery($query);$db->Query();;

            $this->upgrade_import_location_id_to_postings();

        }
        catch (Exception $e)
        {
            return false;
        }
        return true;
    }

    function upgrade_import_location_id_to_postings()
    {
        $db = JFactory::getDBO();
        $query = 'SELECT * FROM #__tst_jglist_postings WHERE location_id=0 OR location_id IS NULL';
        $db->setQuery($query);
        $postings = $db->loadObjectList();

        foreach ($postings as $posting)
        {
            $query = 'SELECT location_id FROM #__tst_jglist_jobs WHERE id='.$posting->job_id;
            $db->setQuery($query);
            $result = $db->loadResult();

            if ($result > 0 && ($posting->location_id == 0))
            {
                $query = 'UPDATE #__tst_jglist_postings SET location_id='.$result.' WHERE id='.$posting->id;
                $db->setQuery($query);$db->Query();;
            }
        }
    }

    function &getOptions()
    {
        $params =JComponentHelper::getParams('com_jobgroklist');
        
        if ( !$this->_options )
        {
            $this->_options = array();

            $this->_options['viewlevel'] = JHtml::_('jobgroklist.viewlevels',isset($this->_posting->viewlevel)?$this->_posting->viewlevel:$params->get('default_viewlevel','1'));
            
            if (isset($this->_posting->published))
                $this->_options['published'] = JHTML::_('select.booleanlist', 'published', 'class="inputbox"', $this->_posting->published);
            else
                $this->_options['published'] = JHTML::_('select.booleanlist', 'published', 'class="inputbox"', '');

            
        }
        return $this->_options;
    }

}
?>
