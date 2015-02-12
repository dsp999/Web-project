<?php
/**
 *
 * This is the installer file for the extension [com_jobgroklist]
 *
 * Created: Fri Mar 25 6:46:59 CDT 2011
 * Last Updated: June 13, 2014, 1:18 am
 *
 * @author TK Tek, LLC. - info@tk-tek.com
 * @version 3.1-1.2.57
 * @package jobgroklist
 *
 * @copyright Copyright {c} 2008-2014
 * @license GNU Public License Version 2
 *
 * "JobGrok Listing" is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 2 of the License, or
 * (at your option) any later version.
 *
 * "JobGrok Listing" is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with "JobGrok Listing".  If not, see <http://www.gnu.org/licenses/>.
 *
 */
defined('_JEXEC') or die('Restricted access');

jimport('joomla.filesystem.file');

/**
 *
 * Class:        com_jobgroklistInstallerScript
 * Last Modifed: June 13, 2014, 1:18 am
 *
 * Description:  This is the installer class for the extension [com_jobgroklist]
 *
 * Package:      Job Grok Application
 */
class com_jobgroklistInstallerScript {

    private $db = null;
    private $app = null;
    private $sql = array();
    private $debug = false;

    function __construct() {
        $this->db = JFactory::getDbo();
        $this->app = JFactory::getApplication();
    }
    
    /**
     *
     * Function:     install
     *
     * Description:  Method to install the extension [com_jobgroklist]
     *
     * @param:       $parent
     * @return:      void
     *
     */
    public function install($parent) {
        if ($this->debug) echo '<p>Executing installation script.</p>'; 
        // echo '<p>'.JTEXT::_('COM_JOBGROKLIST_SCRIPT_COM_JOBGROKAPPLICATION_INSTALLER_INSTALL_TEXT').'</p>';
        $this->com_install();
        $this->updateDatabaseOnInstall();
    }

    /**
     *
     * Function:     uninstall
     *
     * Description:  Method to uninstall the extension [com_jobgroklist]
     *
     * @param:       $parent
     * @return:      void
     *
     */
    public function uninstall($parent) {
        if ($this->debug) echo '<p>Executing uninstall script.</p>'; 
        // echo '<p>' . JTEXT::_('COM_JOBGROKLIST_SCRIPT_COM_JOBGROKAPPLICATION_INSTALLER_UNINSTALL_TEXT') . '</p>';
    }

    /**
     *
     * Function:     update
     *
     * Description:  Method to uninstall the extension [com_jobgroklist]
     *
     * @param:       $parent
     * @return:      void
     *
     */
    public function update($parent) {
        if ($this->debug) echo '<p>Executing update script.</p>'; 
        $this->com_install();
        $this->updateDatabaseOnUpdate();
    }

    /**
     *
     * Function:     preflight
     *
     * Description:  Method to run before install/uninstall/update of the extension [com_jobgroklist]
     *
     * @param:       $type
     * @param:       $parent
     * @return:      void
     *
     */
    public function preflight($type, $parent) {
        if ($this->debug) echo '<p>Executing pre-flight script.</p>'; 
        // echo 'Executing Pre Flight actions!';
    }

    /**
     *
     * Function:     postflight
     *
     * Description:  Method to run after install/uninstall/update of the extension [com_jobgroklist]
     *
     * @param:       $type
     * @param:       $parent
     * @return:      void
     *
     */
    public function postflight($type, $parent) {
        if ($this->debug) echo '<p>Executing post-flight script.</p>'; 
        // echo 'Executing Post Flight actions!';
    }
        
    /**
     *
     * Function:     getSQLHTML
     *
     * Description:  Returns SQL executed during install script execution
     *
     * @return:      string (HTML code of SQL)
     *
     */
    private function getSQLHTML() {
        $output = "";
        foreach ($this->sql as $sql) {
            $output .= "<p>SQL:<code>".$sql."</code></p>\n";
        }
        return $output;
    }
    
    /**
     *
     * Function:     showDebug
     *
     * Description:  Displays message if debug is on
     *
     * @return:      null
     *
     */
    private function showDebug($message) {
        if ($this->debug) { $this->app->enqueueMessage($message); }
    }
    
    /**
     *
     * Function:     columnExists
     *
     * Description:  Check for column in table.
     *
     * @param:       $table    - table to check (do not include joomla/extension/company prefix
     * @param:       $column   - column to check for
     * @return:      boolean
     *
     */
    private function columnExists($table, $column) {
        $this->showDebug("function columnExists($table, $column)");
        $columns = $this->db->getTableColumns($table);
        $result = false;

        if (isset($columns[$column])) $result = true;
        
        $this->showDebug("return ".($result?'true':'false'));
        return $result;
    }

    /**
     *
     * Function:     tableExists
     *
     * Description:  Check for table in database.
     *
     * @param:       $table    - table to check (do not include joomla/extension/company prefix
     * @return:      boolean
     *
     */
    private function tableExists($table) {
        $this->showDebug("function tableExists($table)");
        $query = "show tables like '".$table."'";
        
        $this->showDebug('$query = '.$query);
        $this->db->setQuery($query); $this->db->Query();
        $exists = $this->db->loadObjectList();
        $result = false;
        
        if (count($exists) > 0) $result =  true;
        
        $this->showDebug("return ".($result?'true':'false'));
        return $result;
    }
    
    /**
     *
     * Function:     addTable
     *
     * Description:  Check for table in database.
     *
     * @param:       $table    - table to add (do not include prefix)
     * @param:       $columns  - columns in array()
     * @param:       $key      - key 
     * @param:       $engine   - engine - default is InnoDB
     * @return:      boolean
     *
     */
    private function addTable($table, $columns, $key, $uniques = '', $engine = 'InnoDB') {
        $tmp_columns = implode(", ", $columns);
        
        $this->showDebug("function addTable($table, $tmp_columns, $key, $uniques, $engine)");
        $prefix = $this->db->getPrefix();
        if ($this->tableExists($prefix."tst_jglist_".$table)) return false;
        if (!is_array($columns)) return false;
        foreach ($columns as $field => $definition) { $c[] = $this->db->quoteName($field) . " " . $definition; }

        if (is_array($uniques)) { 
            foreach ($uniques as $f) { 
                $u[] = "UNIQUE (".$this->db->quoteName($f).")"; 
            }
            $unique = ", ".implode(', ', $u);
        } else {
            $unique = '';
        }
        
        $column_string = implode(', ',$c);
        switch ($this->db->name) {
            case 'mysqli':
            case 'mysql':
                $query = 'CREATE TABLE IF NOT EXISTS `#__tst_jglist_'.$table.'` ('.$column_string.', PRIMARY KEY ('.$this->db->quoteName($key).') '.$unique.' ) ENGINE='.$engine.';';
                break;
            case 'sqlsrv':
            case 'sqlazure':
            case 'sqlite':
            case 'postgresql':
            case 'oracle':
            default: 
                $query = 'CREATE TABLE IF NOT EXISTS `#__tst_jglist_'.$table.'` ('.$column_string.', PRIMARY KEY('.$this->db->quoteName($key).') '.$unique.' );';
        }
        $this->db->setQuery($query);
        if ($this->db->Query()) {
            if ($this->debug) $this->app->enqueueMessage('['.$this->db->name.'] Database changes were successful on upgrade/install<br/><em>'.$query.'</em>','message');
            $this->sql[] = $query;
        } else {
            $this->app->enqueueMessage('['.$this->db->name.'] Database changes were NOT successful on upgrade/install<br/><em>'.$query.'</em>');
        }
        
        return true;
    }
    
    /**
     *
     * Function:     addColumn
     *
     * Description:  Add column to table.
     *
     * @param:       $table       - table to add column to
     * @param:       $column      - column to add
     * @param:       $definition  - column definition (i.e. INT, INT DEFAULT 0, etc)
     * @return:      boolean
     *
     */
    private function addColumn($table, $column, $definition) {
        $this->showDebug("function addColumn($table, $column, $definition)");
        $prefix = $this->db->getPrefix();
        if ($this->columnExists($prefix."tst_jglist_".$table, $column)) return false;
        switch ($this->db->name) {
            case 'mysqli':
            case 'mysql':
            case 'sqlsrv':
            case 'sqlazure':
            case 'sqlite':
            case 'postgresql':
            case 'oracle':
            default: 
                $query = 'ALTER TABLE #__tst_jglist_'.$table.' ADD COLUMN '.$column.' '.strtoupper($definition);
        }
        $this->db->setQuery($query);
        if ($this->db->Query()) {
            if ($this->debug) $this->app->enqueueMessage('['.$this->db->name.'] Database changes were successful on upgrade/install <br/><em>'.$query.'</em>');
            $this->sql[] = $query;
        } else {
            $this->app->enqueueMessage('['.$this->db->name.'] Database changes were NOT successful on upgrade/install <br/><em>'.$query.'</em>');
        }
        
        return true;
    }
       
    /**
     *
     * Function:     executeSQLScript
     *
     * Description:  Execute SQL script found in folder /sql
     *
     * @param:       $script      - script to execute (exists in /sql)
     * @param:       $folder      - defaults to misc folder in /sql
     * @param:       $suffix      - defaults to .mysql.utf.sql
     * @return:      boolean
     *
     */
    private function executeSQLScript($script, $folder = 'misc', $suffix = '.mysql.utf.sql') {
        $this->showDebug("function executeSQLScript($script, $folder, $suffix)");
        $file_path = JPATH_ADMINISTRATOR . DIRECTORY_SEPARATOR . 
                        'components' . DIRECTORY_SEPARATOR . 
                        'com_jobgroklist' . DIRECTORY_SEPARATOR . 
                        'sql' . DIRECTORY_SEPARATOR .
                        $folder . DIRECTORY_SEPARATOR . 
                        $script . $suffix;
        $file = JFile::read($file_path);
        if (!$file) {
            $this->app->enqueueMessage('[sql/'.$folder.'/'.$script.$suffix.'] Could not read SQL file or file does not exist.');
            return false;
        }
        // $db = JFactory::getDbo();
        $lines = explode(";", $file); array_pop($lines);
        foreach ($lines as $query) {
            $this->db->setQuery($query); 
            if ($this->db->Query()) { $this->sql[] = $query; } 
            if ($this->debug) $this->app->enqueueMessage('Executing: '.$query); 
        }
        if ($this->debug) $this->app->enqueueMessage('[sql/'.$folder.'/'.$script.'] SQL script executed successfully.','message');
    }
    
    /**
     *
     * Function:     getRowCount
     *
     * Description:  Get row count
     *
     * @param:       $table    - table to get rows from
     * @param:       $where    - where statement if needed
     * @return:      boolean
     *
     */
    private function getRowCount($table, $where = '') {
        $this->showDebug("function getRowCount($table, $where)");
        $prefix = $this->db->getPrefix();
        if (!$this->tableExists($prefix."tst_jglist_".$table)) { 
            if ($this->debug) $this->app->enqueueMessage('['.$table.'] Not found. Row count aborted.');
            return 0;
        }
        switch ($this->db->name) {
            case 'mysqli':
            case 'mysql':
            case 'sqlsrv':
            case 'sqlazure':
            case 'sqlite':
            case 'postgresql':
            case 'oracle':
            default: 
                $query = 'SELECT COUNT(*) FROM `'.$prefix.'tst_jglist_'.$table."`".($where == ''?'':' WHERE '.$where);
        }
        $this->db->setQuery($query);
        
        if ($this->db->Query()) {
            if ($this->debug) $this->app->enqueueMessage('['.$this->db->name.'] Row count completed successfully <br/><em>'.$query.'</em>');
            $this->sql[] = $query;
        } else {
            $this->app->enqueueMessage('['.$this->db->name.'] Row count could not successfully complete <br/><em>'.$query.'</em>');
        }
        
        $result = $this->db->loadResult();
        $this->showDebug("Row Count: ".$result);
        return $result;
    }

    /**
     *
     * Function:     getValue
     *
     * Description:  Get value from table
     *
     * @param:       $table    - table to get value from
     * @param:       $field    - field to get value from
     * @param:       $where    - where statement if needed
     * @return:      boolean
     *
     */
    private function get($table, $field, $where = '') {
        $this->showDebug("function get($table, $field, $where)");
        $prefix = $this->db->getPrefix();
        if (!$this->tableExists($prefix."tst_jglist_".$table)) return -1;
        switch ($this->db->name) {
            case 'mysqli':
            case 'mysql':
            case 'sqlsrv':
            case 'sqlazure':
            case 'sqlite':
            case 'postgresql':
            case 'oracle':
            default: 
                $query = "SELECT ".$this->db->quoteName($field)." FROM ".$this->db->quoteName('#__tst_jglist_'.$table).($where == ''?'':' WHERE '.$where);
        }
        $this->db->setQuery($query);
        
        if ($this->db->Query()) {
            if ($this->debug) $this->app->enqueueMessage('['.$this->db->name.'] Value retrieval completed successfully<br/><em>'.$query.'</em>');
            $this->sql[] = $query;
        } else {
            $this->app->enqueueMessage('['.$this->db->name.'] Value retrieval could not successfully complete<br/><em>'.$query.'</em>');
        }

        $result = $this->db->loadResult();
        return $result;
    }
    
    /**
     *
     * Function:     updateValue
     *
     * Description:  Update value in table
     *
     * @param:       $table
     * @param:       $field
     * @param:       $value
     * @param:       $numeric (if value to update is numeric set to true)
     * @param:       $where
     * 
     * @return:      boolean
     *
     */
    private function updateValue($table, $field, $value, $numeric = false, $where = '') {
        $this->showDebug("function updateValue($table, $field, $value, $numeric, $where)");
        $prefix = $this->db->getPrefix();
        if (!$this->tableExists($prefix."tst_jglist_".$table)) return -1;
        switch ($this->db->name) {
            case 'mysqli':
            case 'mysql':
            case 'sqlsrv':
            case 'sqlazure':
            case 'sqlite':
            case 'postgresql':
            case 'oracle':
            default: 
                $query = "UPDATE ".$this->db->quoteName('#__tst_jglist_'.$table)." SET ".$this->db->quoteName($field)."=".($numeric?$value:$this->db->quote($value)).($where == ''?'':' WHERE '.$where);
        }
        $this->db->setQuery($query);
        if ($this->db->Query()) {
            if ($this->debug) $this->app->enqueueMessage('['.$this->db->name.'] Database changes were successful on upgrade/install <br/><em>'.$query.'</em>');
        } else {
            $this->app->enqueueMessage('['.$this->db->name.'] Database changes were NOT successful on upgrade/install <br/><em>'.$query.'</em>');
        }
        
        return true;
    }

    /**
     *
     * Function:     insertRow
     *
     * Description:  Insert row into table
     *
     * @param:       $table
     * @param:       $fields
     * @param:       $values
     * @return:      boolean
     *
     */
    private function insertRow($table, $fields, $values) {
        $tmp_fields = implode(", ", $fields);
        $tmp_values = implode(", ", $values);
        $this->showDebug("function insertRow($table, $tmp_fields, $tmp_values)");
        // $db = JFactory::getDbo();
        $prefix = $this->db->getPrefix();
        if (!$this->tableExists($prefix."tst_jglist_".$table)) return -1;
        foreach ($fields as $f) {
            $fields_prep[] = $this->db->quoteName($f);
        }
        $field_string = implode(", ",$fields_prep);
        $value_string = implode(", ",$values);
        switch ($this->db->name) {
            case 'mysqli':
            case 'mysql':
            case 'sqlsrv':
            case 'sqlazure':
            case 'sqlite':
            case 'postgresql':
            case 'oracle':
            default: 
                $query = "INSERT INTO ".$this->db->quoteName('#__tst_jglist_'.$table)." (".$field_string.") VALUES (".$value_string.")";
        }
        $this->db->setQuery($query);
        if ($this->db->Query()) {
            if ($this->debug) $this->app->enqueueMessage('['.$this->db->name.'] Database changes were successful on upgrade/install <br/><em>'.$query.'</em>');
            $this->sql[] = $query;
        } else {
            $this->app->enqueueMessage('['.$this->db->name.'] Database changes were NOT successful on upgrade/install <br/><em>'.$query.'</em>');
        }
        
        return true;
    }
    
    /**
     *
     * Function:     getRows
     *
     * Description:  Get rows from table
     *
     * @param:       $table
     * @param:       $where
     * @return:      boolean
     *
     */
    private function getRows($table, $where) {
        $this->showDebug("function getRows($table, $where)");
        $prefix = $this->db->getPrefix();
        if (!$this->tableExists($prefix."tst_jglist_".$table)) return false;
        switch ($this->db->name) {
            case 'mysqli':
            case 'mysql':
            case 'sqlsrv':
            case 'sqlazure':
            case 'sqlite':
            case 'postgresql':
            case 'oracle':
            default: 
                $query = "SELECT * FROM ".$this->db->quoteName('#__tst_jglist_'.$table).($where == ''?'':' WHERE '.$where);
        }
        $this->db->setQuery($query);
        if ($this->db->Query()) {
            if ($this->debug) $this->app->enqueueMessage('['.$this->db->name.'] Table rows successfully extracted <br/><em>'.$query.'</em>');
            $this->sql[] = $query;
        } else {
            $this->app->enqueueMessage('['.$this->db->name.'] Table rows could not be extracted. <br><em>'.$query.'</em>');
        }
        $results = $this->db->loadObjectList();
        return $results;
    }
    
    /**
     *
     * Function:     upgradeLocationIdToPostings
     *
     * Description:  In earlier versions location was linked to the jobs table,
     *               this completes the data conversion by pulling location id
     *               into the postings table.
     *
     * @param:       $table    - table to check (do not include joomla/extension/company prefix
     * @return:      boolean
     *
     */
    private function upgradeLocationIdToPostings() {
        $this->showDebug("function upgradeLocationIdToPostings()");
        $postings = $this->getRows('postings','location_id=0 OR location_id IS NULL');
        if (!is_array($postings)) return;
        foreach ($postings as $posting) {
            $location_id = $this->get("jobs","location_id",$this->db->quoteName('id').'='.$posting->job_id);
            if ($location_id > 0 && ($posting->location_id == 0)) {
                $this->updateValue("postings", "location_id", (int)$location_id, true, $this->db->quoteName('id').'='.$posting->id);
            }
        }
    }
    
    /**
     *
     * Function:     upgradeAliasToJobs
     *
     * Description:  In earlier versions alias may not have existed or was blank
     *
     * @param:       $table    - table to check (do not include joomla/extension/company prefix
     * @return:      boolean
     *
     */
    private function upgradeAliasToJobs() {
        $this->showDebug("function upgradeAliasToJobs()");
        $jobs = $this->getRows('jobs','alias=\'\' OR alias IS NULL');
        if (!is_array($jobs)) return;
        foreach ($jobs as $job) {
            $alias = JFilterOutput::stringURLSafe($job->title);
            $this->updateValue("jobs", "alias", $alias, false, $this->db->quoteName('id').'='.$job->id);
        }
    }

    /**
     * 
     * Function:    updateDatabaseOnInstall
     * 
     * Description: Executes all the database updates required for an update
     * 
     * @return:     null
     */
    private function updateDatabaseOnInstall() {
        $this->showDebug("function updateDatabaseOnInstall()");
        // Execute any SQL scripts 
        if ($this->getRowCount('static_category') == 0) $this->executeSQLScript('category');
        if ($this->getRowCount('static_companyrevenue') == 0) $this->executeSQLScript('companyrevenue');
        if ($this->getRowCount('static_companysize') == 0) $this->executeSQLScript('companysize');
        if ($this->getRowCount('static_country') == 0) $this->executeSQLScript('country');
        if ($this->getRowCount('static_education') == 0) $this->executeSQLScript('education');
        if ($this->getRowCount('static_jobtype') == 0) $this->executeSQLScript('jobtype');
        if ($this->getRowCount('static_payrange') == 0) $this->executeSQLScript ('payrange');
    }
    
    /**
     *
     * Function:     updateDatabaseOnUpdate
     *
     * Description:  Executes all the database updates required for current version
     *
     * @return:      null
     *
     */
    private function updateDatabaseOnUpdate() {
        $this->showDebug("function updateDatabaseOnUpdate()");
        // Add missing tables (if needed)
        $this->addTable('static_payrange', array( 'id' => 'INT NOT NULL', 'range' => 'TEXT NOT NULL'), 'id');

        // Add missing data from script (if needed)
        if ($this->getRowCount('static_payrange') == 0) $this->executeSQLScript ('payrange');
        
        // Update [postings] table (if needed)
        $this->addColumn('postings', 'link', 'TEXT');
        $this->addColumn('postings', 'link_text', 'TEXT');
        $this->addColumn('postings', 'location_id', 'INT NOT NULL');
        $this->addColumn('postings', 'featured', 'TINYINT NOT NULL DEFAULT 0');
        $this->addColumn('postings', 'viewlevel', 'INT NOT NULL DEFAULT 1');
        $this->addcolumn('postings', 'closing_days', 'INT NOT NULL DEFAULT 0');
        $this->addColumn('postings', 'tweet', 'TINYINT NOT NULL DEFAULT 0');

        // Update [jobs] table (if needed)
        $this->addColumn('jobs', 'job_code', 'TEXT NOT NULL');
        $this->addColumn('jobs', 'create_date', 'DATETIME NOT NULL DEFAULT \'0000-00-00 00:00:00\'');
        $this->addColumn('jobs', 'alias', 'TEXT NOT NULL');
        $this->addColumn('jobs', 'payrange','INT(11) NOT NULL DEFAULT \'0\'');
        
        // Update [categories] table (if needed)
        $this->addColumn('categories', 'cat_contact_id', 'INT NOT NULL');
        $this->addColumn('categories', 'cat_notify_contact', 'TINYINT NOT NULL DEFAULT 0');
        $this->addColumn('categories', 'code', 'INT NOT NULL DEFAULT 0');
       
        // Update [location id] for older version upgrade]]]
        $this->upgradeLocationIdToPostings();
        $this->upgradeAliasToJobs();
    }

    /*
     *
     * Function:     com_install
     *
     * Description:  Original function for installation
     *
     * @return:      boolean
     *
     */
    function com_install() {
        $this->showDebug("function com_install()");
        $result = $this->getRowCount('values','variable=\'version\'');
        
        if ($result == 0) $prior_version = 'none';
            else $prior_version = $this->get('values','value',$this->db->quoteName('variable')."='version'");

        if ($result == 0) {
            $this->insertRow("values", array ('variable','value'), array("'version'","'3.1-1.2.57'"));
        } else {
            $this->updateValue("values","value","3.1-1.2.57", false, $this->db->quoteName('variable')."='version'");
        }
        
        $news = $this->getRowCount('values','variable=\'news\'');
        if ($news == 0) {
            $this->insertRow("values", array('variable','value'), array("'news'",0));
        }

    }

}
?>
