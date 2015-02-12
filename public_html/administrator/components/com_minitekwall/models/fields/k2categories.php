<?php
/**
* @title			Minitek Wall
* @copyright   		Copyright (C) 2011-2014 Minitek, All rights reserved.
* @license   		GNU General Public License version 3 or later.
* @author url   	http://www.minitek.gr/
* @developers   	Minitek.gr
*/

// no direct access
defined('_JEXEC') or die('Restricted access');

require_once (JPATH_ADMINISTRATOR.'/components/com_k2/elements/base.php');

class JFormFieldK2Categories extends JFormField
{

    function getInput()
    {
        $params = JComponentHelper::getParams('com_k2');
        $document = JFactory::getDocument();
        JHtml::_('behavior.framework');
		
        $db = JFactory::getDBO();
        $query = 'SELECT m.* FROM #__k2_categories m WHERE trash = 0 ORDER BY parent, ordering';
        $db->setQuery($query);
        $mitems = $db->loadObjectList();
        $children = array();
        if ($mitems)
        {
            foreach ($mitems as $v)
            {
                $v->title = $v->name;
                $v->parent_id = $v->parent;
				
                $pt = $v->parent;
                $list = @$children[$pt] ? $children[$pt] : array();
                array_push($list, $v);
                $children[$pt] = $list;
            }
        }
        $list = JHTML::_('menu.treerecurse', 0, '', array(), $children, 9999, 0, 0);
        $mitems = array();
		$mitems[] = JHTML::_('select.option', '0', JText::_('JALL'));
		
        foreach ($list as $item)
        {
            $item->treename = JString::str_ireplace('&#160;', '- ', $item->treename);
            $mitems[] = JHTML::_('select.option', $item->id, $item->treename);
        }

        $doc = JFactory::getDocument();
        
        $output = JHTML::_('select.genericlist', $mitems, $this->name, 'class="inputbox" multiple="multiple" size="10"', 'value', 'text', $this->value, $this->id);
		
		return $output;
    }

}
