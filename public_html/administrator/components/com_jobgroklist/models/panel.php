<?php
/**
 *
 *
 * This is the panel.php controller for jobgroklist
 *
 * Created: June 13, 2014, 1:18 am
 *
 * Subversion Details
 * $Date: 2014-04-21 21:56:52 -0500 (Mon, 21 Apr 2014) $
 * $Revision: 6000 $
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
jimport('joomla.database.database.mysqlexporter');

// model class for application on admin site
class JobgroklistModelPanel extends JModelLegacy {

    function getNews() {
        $news = (int)JRequest::getVar('news','0');
        
        $db = JFactory::getDBO();
        $query = "SELECT `value` FROM #__tst_jglist_values WHERE `variable`='news';";
        $db->setQuery($query);     
        $result = $db->loadResult();
        
        if ($news === 1) {
            $result = ($result=='0'?'1':'0');
            $this->setNews($result);
        }
        
        return ($result=='1'?true:false);
    }
    
    function setNews($value) {
        $db = JFactory::getDBO();
        $query = "UPDATE `#__tst_jglist_values` SET `value`= '".$value."' WHERE `variable`='news';";
        $db->setQuery($query);
        $db->Query();      
    }
    
    function resetAllHits() {
        $db = JFactory::getDBO();
        $query = "UPDATE #__tst_jglist_postings SET " .
                $db->quoteName('hits') . "=0";
        $db->setQuery($query);
        $db->Query();

        return true;
    }

    function bugFixI() {
        try {
            $db = $this->_db;
            $query = "ALTER TABLE #__tst_jglist_postings ADD `location_id` INT NOT NULL;";
            $db->setQuery($query);
            $db->Query();
            ;

            $query = "UPDATE #__tst_jglist_postings p JOIN #__tst_jglist_jobs j ON p.job_id=j.id SET p.location_id=j.location_id WHERE p.location_id=0 OR p.location_id IS NULL;";
            $db->setQuery($query);
            $db->Query();
            ;
        } catch (Exception $e) {
            return false;
        }
        return true;
    }

    function upgrade_import_location_id_to_postings() {
        $db = JFactory::getDBO();
        $query = 'SELECT * FROM #__tst_jglist_postings WHERE location_id=0 OR location_id IS NULL';
        $db->setQuery($query);
        $postings = $db->loadObjectList();

        foreach ($postings as $posting) {
            $query = 'SELECT location_id FROM #__tst_jglist_jobs WHERE id=' . $posting->job_id;
            $db->setQuery($query);
            $result = $db->loadResult();

            if ($result > 0 && ($posting->location_id == 0)) {
                $query = 'UPDATE #__tst_jglist_postings SET location_id=' . $result . ' WHERE id=' . $posting->id;
                $db->setQuery($query);
                $db->Query();
                ;
            }
        }
    }

}
