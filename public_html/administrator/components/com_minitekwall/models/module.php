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

class MinitekWallModelModule extends JModelAdmin
{
	protected $text_prefix = 'COM_MINITEKWALL';

	protected function canDelete($record)
	{
		if (!empty($record->id))
		{

			$user = JFactory::getUser();

			return $user->authorise('core.delete', 'com_minitekwall');
		}
	}

	protected function canEditState($record)
	{
		$user = JFactory::getUser();

		return $user->authorise('core.edit.state', 'com_minitekwall');
	}

	public function getTable($type = 'Module', $prefix = 'MinitekWallTable', $config = array())
	{
		return JTable::getInstance($type, $prefix, $config);
	}
	
	public function getItem($pk = null)
	{
		if ($item = parent::getItem($pk))
		{
			// Convert the module fields to an array.
			$registry = new JRegistry;
			$registry->loadString($item->module_type);
			$item->module_type = $registry->toArray();
						
		}

		return $item;
	}

	public function getForm($data = array(), $loadData = true)
	{
		// Get the form.
		$form = $this->loadForm('com_minitekwall.module', 'module', array('control' => 'jform', 'load_data' => $loadData));

		if (empty($form))
		{
			return false;
		}

		return $form;
	}

	protected function loadFormData()
	{
		// Check the session for previously entered form data.
		$data = JFactory::getApplication()->getUserState('com_minitekwall.edit.module.data', array());

		if (empty($data))
		{
			$data = $this->getItem();
		}

		$this->preprocessData('com_minitekwall.module', $data);

		return $data;
	}
	
	public function save($data)
	{
		$app = JFactory::getApplication();
		
		// Joomla	
		if (isset($data['module_type']) && is_array($data['module_type']))
		{
			$registry = new JRegistry;
			$registry->loadArray($data['module_type']);
			$data['module_type'] = (string) $registry;
		}
		
		if (parent::save($data))
		{
			return true;
		}

		return false;
	}

	protected function prepareTable($table)
	{
		$table->name = htmlspecialchars_decode($table->name, ENT_QUOTES);
	}
}
