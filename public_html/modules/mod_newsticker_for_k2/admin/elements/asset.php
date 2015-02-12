<?php
/**
* @title			Newsticker for K2
* @version   		3.x
* @copyright   		Copyright (C) 2011-2014 Minitek, All rights reserved.
* @license   		GNU General Public License version 3 or later.
* @author url   	http://www.minitek.gr/
* @author email   	info@minitek.gr
* @developers   	Minitek.gr
*/

// no direct access
defined('_JEXEC') or die('Restricted access');

jimport('joomla.form.formfield');
class JFormFieldAsset extends JFormField {
    protected $type = 'Asset';
    protected function getInput() {
		// JS
        $doc = JFactory::getDocument();
        //$doc->addScript(JURI::root().$this->element['path'].'script.js');
		// CSS
        $doc->addStyleSheet(JURI::root().$this->element['path'].'style.css'); 
        return null;
    }
}