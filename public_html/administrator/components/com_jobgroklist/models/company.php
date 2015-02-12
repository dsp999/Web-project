<?php

/**
 *
 *
 * This is the company.php controller for jobgroklist
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
 * Company Model
 *
 */

class JobgroklistModelCompany extends JModelLegacy

{
/**
 * Company Id
 * @access private
 * @var int
 */
    var $_id;

    /**
     * Company Data
     * @access private
     * @var object
     */
    var $_company;

    /**
     * Items total
     * @access private
     * @var integer
     */
    var $_total = null;

    /**
     * Pagination object
     * @access private
     * @var object
     */
    var $_pagination = null;

    /**
     *
     * Set query to pull data
     *
     */

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

    /**
     *
     * Build query for all data
     *
     * @return string
     *
     */
    function _buildQuery()
    {
        $query = 'SELECT * FROM #__tst_jglist_companies c '.
            "";
        return $query;
    }


    /**
     *
     * Retrieves the company data
     *
     * @return array
     *
     */
    function & getData()
    {
        if (empty ($this->_company))
        {
            $query = $this->_buildQuery();
            $limitstart = $this->getState('limitstart');
            $limit = $this->getState('limit');
            $this->_company = $this->_getList($query, $limitstart, $limit);
        }

        return $this->_company;
    }

    /**
     *
     * Method to set the company identifier
     *
     */
    function setId($id)
    {
    // Set id and wipe data
        $this->_id = $id;
        $this->_company = null;
    }

    /**
     *
     * Get count of rows
     *
     */
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
     * @return boolean
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

    /**
     *
     * Store data
     *
     * @return boolean
     *
     */
    function store()
    {
        $row = $this->getTable();

        $data = JRequest :: get('post');

        if (!$row->bind($data))
        {
            $this->setError($this->_db->getErrorMsg());
            return false;
        }

        if (!$row->check())
        {
            $this->setError($this->_db->getErrorMsg());
            return false;
        }

        if (!$row->store())
        {
            $this->setError($this->_db->getErrorMsg());
            return false;
        }

        return true;
    }

    /**
     *
     * Gets Company data
     *
     * @return object
     *
     */
    function & getCompany()
    {
        if (!$this->_company && $this->_id != '')
        {
            $db = $this->getDBO();
            $query = 'SELECT * FROM ' . $db->quoteName('#__tst_jglist_companies') . ' WHERE ' . $db->quoteName('id') . '=' . $this->_id . ';';
            $db->setQuery($query);
            $this->_company = $db->loadObject();
        }
        return $this->_company;
    }

    function copy()
    {

        $cids = JRequest :: getVar('cid', array (0), 'post', 'array');
        $row = $this->getTable();

        foreach ($cids as $cid)
        {
            $this->_company = null;
            $this->_id = $cid;
            $tmp = $this->getCompany();
            if (!$tmp)
            {
                $this->setError($row->getErrorMsg());
                return false;
            }
            $tmp->id = null;
            $tmp->company = "Copy of ".$tmp->company;
            $this->save($tmp);

        }
        return true;

    }

    /**
     *
     * Save a Company
     *
     * @param object
     * @return boolean
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
        $db->setQuery("UPDATE " . $db->quoteName('#__tst_jglist_companies') . " SET " .
            $db->quoteName('hits') . " = " . $db->quoteName('hits') . " + 1 " .
            "WHERE id = " . $this->_id);
        $db->query();
    }
}
?>



