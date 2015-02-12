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

defined('JPATH_BASE') or die;

jimport('joomla.form.formfield');
class JFormFieldSeparator extends JFormField {
	protected $type = 'Separator';
	protected function getInput() {
		$text  	= (string) $this->element['text'];
		return '<div id="'.$this->id.'" class="mmSeparator'.(($text != '') ? ' hasText' : '').'" title="'. JText::_($this->element['desc']) .'"><span>' . JText::_($text) . '</span></div>';
	}
}