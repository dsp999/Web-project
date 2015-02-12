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

require_once JPATH_COMPONENT_ADMINISTRATOR . '/helpers/minitekwall.php';

class MinitekWallModelInstance extends JModelAdmin
{
	protected $text_prefix = 'COM_MINITEKWALL';

	protected function canDelete($record)
	{
		if (!empty($record->id))
		{
			if ($record->state != -2)
			{
				return;
			}
			$user = JFactory::getUser();
			return $user->authorise('core.delete', 'com_minitekwall.instance.' . (int) $record->id);
		}
	}

	protected function canEditState($record)
	{
		$user = JFactory::getUser();

		// Check for existing instance.
		if (!empty($record->id))
		{
			return $user->authorise('core.edit.state', 'com_minitekwall.instance.' . (int) $record->id);
		}
		else
		{
			return parent::canEditState('com_minitekwall');
		}
	}

	protected function prepareTable($table)
	{
		// Set the publish date to now
		$db = $this->getDbo();
		if ($table->state == 1 && (int) $table->publish_up == 0)
		{
			$table->publish_up = JFactory::getDate()->toSql();
		}

		if ($table->state == 1 && intval($table->publish_down) == 0)
		{
			$table->publish_down = $db->getNullDate();
		}

		// Reorder the instances within the module so the new instance is first
		/*if (empty($table->id))
		{
			$table->reorder('module_id = ' . (int) $table->module_id . ' AND state >= 0');
		}*/
	}

	public function getTable($type = 'Instance', $prefix = 'MinitekWallTable', $config = array())
	{
		return JTable::getInstance($type, $prefix, $config);
	}

	public function getItem($pk = null)
	{
		if ($item = parent::getItem($pk))
		{
						
			// Convert the params field to an array.
			$registry = new JRegistry;
			$registry->loadString($item->attribs);
			$item->attribs = $registry->toArray();
			
			// Convert the joomla fields to an array.
			$registry = new JRegistry;
			$registry->loadString($item->joomla_type);
			$item->joomla_type = $registry->toArray();
			
			// Convert the k2 fields to an array.
			$registry = new JRegistry;
			$registry->loadString($item->k2_type);
			$item->k2_type = $registry->toArray();
			
			// Convert the jomsocial fields to an array.
			$registry = new JRegistry;
			$registry->loadString($item->jomsocial_type);
			$item->jomsocial_type = $registry->toArray();
			
		}

		return $item;
	}

	public function getForm($data = array(), $loadData = true)
	{
		// Get the form.
		$form = $this->loadForm('com_minitekwall.instance', 'instance', array('control' => 'jform', 'load_data' => $loadData));
		
		if (empty($form))
		{
			return false;
		}
		$jinput = JFactory::getApplication()->input;

		// The front end calls this model and uses a_id to avoid id clashes so we need to check for that first.
		if ($jinput->get('a_id'))
		{
			$id = $jinput->get('a_id', 0);
		}
		// The back end uses id so we use that the rest of the time and set it to 0 by default.
		else
		{
			$id = $jinput->get('id', 0);
		}
		// Determine correct permissions to check.
		if ($this->getState('instance.id'))
		{
			$id = $this->getState('instance.id');
			// Existing record. Can only edit in selected modules.
			//$form->setFieldAttribute('module_id', 'action', 'core.edit');
			// Existing record. Can only edit own instances in selected modules.
			//$form->setFieldAttribute('module_id', 'action', 'core.edit.own');
		}
		/*else
		{
			// New record. Can only create in selected modules.
			$form->setFieldAttribute('module_id', 'action', 'core.create');
		}*/

		$user = JFactory::getUser();

		// Check for existing instance.
		// Modify the form based on Edit State access controls.
		if ($id != 0 && (!$user->authorise('core.edit.state', 'com_minitekwall.instance.' . (int) $id))
			|| ($id == 0 && !$user->authorise('core.edit.state', 'com_minitekwall'))
		)
		{
			// Disable fields for display.
			$form->setFieldAttribute('ordering', 'disabled', 'true');
			$form->setFieldAttribute('publish_up', 'disabled', 'true');
			$form->setFieldAttribute('publish_down', 'disabled', 'true');
			$form->setFieldAttribute('state', 'disabled', 'true');

			// Disable fields while saving.
			// The controller has already verified this is an instance you can edit.
			$form->setFieldAttribute('ordering', 'filter', 'unset');
			$form->setFieldAttribute('publish_up', 'filter', 'unset');
			$form->setFieldAttribute('publish_down', 'filter', 'unset');
			$form->setFieldAttribute('state', 'filter', 'unset');
		}

		return $form;
	}

	protected function loadFormData()
	{
		// Check the session for previously entered form data.
		$app = JFactory::getApplication();
		$data = $app->getUserState('com_minitekwall.edit.instance.data', array());

		if (empty($data))
		{
			$data = $this->getItem();

			// Prime some default values.
			//if ($this->getState('instance.id') == 0)
			//{
				//$data->set('catid', $app->input->getInt('catid', $app->getUserState('com_minitekwall.instances.filter.category_id')));
			//}
		}

		$this->preprocessData('com_minitekwall.instance', $data);

		return $data;
	}

	public function save($data)
	{
		$app = JFactory::getApplication();
		
		// Joomla	
		if (isset($data['joomla_type']) && is_array($data['joomla_type']))
		{
			$registry = new JRegistry;
			$registry->loadArray($data['joomla_type']);
			$data['joomla_type'] = (string) $registry;
			$data['type_id'] = '1';
		}
		
		// K2	
		if (isset($data['k2_type']) && is_array($data['k2_type']))
		{
			$registry = new JRegistry;
			$registry->loadArray($data['k2_type']);
			$data['k2_type'] = (string) $registry;
			$data['type_id'] = '2';
		}
		
		// Jomsocial
		if (isset($data['jomsocial_type']) && is_array($data['jomsocial_type']))
		{
			$registry = new JRegistry;
			$registry->loadArray($data['jomsocial_type']);
			$data['jomsocial_type'] = (string) $registry;
			$data['type_id'] = '3';
		}

		// Alter the title for save as copy
		if ($app->input->get('task') == 'save2copy')
		{
			//list($title, $alias) = $this->generateNewTitle($data['catid'], $data['alias'], $data['title']);
			$data['title'] = $title;
			$data['alias'] = $alias;
			$data['state'] = 0;
		}

		if (parent::save($data))
		{
			return true;
		}

		return false;
	}

	protected function getReorderConditions($table)
	{
		$condition = array();
		$condition[] = 'module_id = ' . (int) $table->module_id;
		return $condition;
	}

	protected function preprocessForm(JForm $form, $data, $group = 'minitekwall')
	{
		
		parent::preprocessForm($form, $data, $group);
	}

	protected function cleanCache($group = null, $client_id = 0)
	{
		parent::cleanCache('minitekwall');
	}
	
	public function getType($id)
	{
		$db		= JFactory::getDBO();
		$query	= 'SELECT '.$db->quoteName( 'id' ).',
		'.$db->quoteName( 'joomla_type' ).',
		'.$db->quoteName( 'k2_type' ).',
		'.$db->quoteName( 'jomsocial_type' ).'
		FROM ' . $db->quoteName( '#__minitek_wall_instances' ) . ' '
		. 'WHERE ' . $db->quoteName( 'id' ) . '=' . $db->Quote($id);

		$db->setQuery( $query );

		$row = $db->loadObject();
		if ($row->joomla_type) {
			$instance_type = 'joomla';
		} else if ($row->k2_type) {
			$instance_type = 'k2';
		} else if ($row->jomsocial_type) {
			$instance_type = 'jomsocial';
		} else {
			$instance_type = '';
		}
		
		return $instance_type;
		
	}
}
