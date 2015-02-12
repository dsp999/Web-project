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

class MinitekWallModelInstances extends JModelList
{
	public function __construct($config = array())
	{
		if (empty($config['filter_fields']))
		{
			$config['filter_fields'] = array(
				'id', 'a.id',
				'type_id', 'a.type_id',
				'joomla_type', 'a.joomla_type',
				'k2_type', 'a.k2_type',
				'jomsocial_type', 'a.jomsocial_type',
				'title', 'a.title',
				'alias', 'a.alias',
				'checked_out', 'a.checked_out',
				'checked_out_time', 'a.checked_out_time',
				'state', 'a.state',
				'created', 'a.created',
				'created_by', 'a.created_by',
				'created_by_alias', 'a.created_by_alias',
				'ordering', 'a.ordering',
				'publish_up', 'a.publish_up',
				'publish_down', 'a.publish_down',
				'module_id', 'im.id',
				'module_name', 'im.name'
			);

		}

		parent::__construct($config);
	}

	protected function populateState($ordering = null, $direction = null)
	{
		$app = JFactory::getApplication();

		// Adjust the context to support modal layouts.
		if ($layout = $app->input->get('layout'))
		{
			$this->context .= '.' . $layout;
		}

		$search = $this->getUserStateFromRequest($this->context . '.filter.search', 'filter_search');
		$this->setState('filter.search', $search);
		
		$moduleId = $app->getUserStateFromRequest($this->context . '.filter.module_id', 'filter_module_id');
		$this->setState('filter.module_id', $moduleId);
		
		$typeId = $app->getUserStateFromRequest($this->context . '.filter.type_id', 'filter_type_id');
		$this->setState('filter.type_id', $typeId);
				
		$authorId = $app->getUserStateFromRequest($this->context . '.filter.author_id', 'filter_author_id');
		$this->setState('filter.author_id', $authorId);

		$published = $this->getUserStateFromRequest($this->context . '.filter.published', 'filter_published', '');
		$this->setState('filter.published', $published);

		// List state information.
		parent::populateState('a.title', 'asc');
	}

	protected function getStoreId($id = '')
	{
		// Compile the store id.
		$id .= ':' . $this->getState('filter.search');
		$id .= ':' . $this->getState('filter.module_id');
		$id .= ':' . $this->getState('filter.type_id');
		$id .= ':' . $this->getState('filter.published');
		$id .= ':' . $this->getState('filter.author_id');

		return parent::getStoreId($id);
	}

	protected function getListQuery()
	{
		
		// Create a new query object.
		$db = $this->getDbo();
		$query = $db->getQuery(true);
		$user = JFactory::getUser();
		$app = JFactory::getApplication();

		// Select the required fields from the table.
		$query->select(
			$this->getState(
				'list.select',
				'a.id, a.type_id, a.title, a.alias, a.checked_out, a.checked_out_time' .
					', a.state, a.access, a.created, a.created_by, a.created_by_alias, a.ordering, a.language' .
					', a.publish_up, a.publish_down, im.name as module_name, im.id as module_id'
			)
		);
		$query->from('#__minitek_wall_instances AS a');

		// Join over the language
		$query->select('l.title AS language_title')
			->join('LEFT', $db->quoteName('#__languages') . ' AS l ON l.lang_code = a.language');

		// Join over the users for the checked out user.
		$query->select('uc.name AS editor')
			->join('LEFT', '#__users AS uc ON uc.id=a.checked_out');
			
		// Join over the instances modules
		$query->select('im.name AS module_name')
			->join('LEFT', '#__minitek_wall_modules AS im ON im.instance_id=a.id');
			
		// Join over the instance types
		$query->select('it.value AS type_name')
			->join('LEFT', '#__minitek_wall_types AS it ON it.id=a.type_id');

		// Join over the asset groups.
		$query->select('ag.title AS access_level')
			->join('LEFT', '#__viewlevels AS ag ON ag.id = a.access');

		// Join over the users for the author.
		$query->select('ua.name AS author_name')
			->join('LEFT', '#__users AS ua ON ua.id = a.created_by');
							
		// Filter by access level.
		if ($access = $this->getState('filter.access'))
		{
			$query->where('a.access = ' . (int) $access);
		}

		// Implement View Level Access
		if (!$user->authorise('core.admin'))
		{
			$groups = implode(',', $user->getAuthorisedViewLevels());
			$query->where('a.access IN (' . $groups . ')');
		}

		// Filter by published state
		$published = $this->getState('filter.published');
		if (is_numeric($published))
		{
			$query->where('a.state = ' . (int) $published);
		}
		elseif ($published === '')
		{
			$query->where('(a.state = 0 OR a.state = 1)');
		}
		
		// Filter by author
		$authorId = $this->getState('filter.author_id');
		if (is_numeric($authorId))
		{
			$type = $this->getState('filter.author_id.include', true) ? '= ' : '<>';
			$query->where('a.created_by ' . $type . (int) $authorId);
		}
		
		// Filter by module
		$moduleId = $this->getState('filter.module_id');
		if (is_numeric($moduleId))
		{
			$lstype = $this->getState('filter.module_id.include', true) ? '= ' : '<>';
			$query->where('im.id ' . $lstype . (int) $moduleId);
		}
		
		// Filter by type
		$typeId = $this->getState('filter.type_id');
		if (is_numeric($typeId))
		{
			$lstype = $this->getState('filter.type_id.include', true) ? '= ' : '<>';
			$query->where('a.type_id ' . $lstype . (int) $typeId);
		}

		// Filter by search in title.
		$search = $this->getState('filter.search');
		if (!empty($search))
		{
			if (stripos($search, 'id:') === 0)
			{
				$query->where('a.id = ' . (int) substr($search, 3));
			}
			elseif (stripos($search, 'author:') === 0)
			{
				$search = $db->quote('%' . $db->escape(substr($search, 7), true) . '%');
				$query->where('(ua.name LIKE ' . $search . ' OR ua.username LIKE ' . $search . ')');
			}
			else
			{
				$search = $db->quote('%' . $db->escape($search, true) . '%');
				$query->where('(a.title LIKE ' . $search . ' OR a.alias LIKE ' . $search . ')');
			}
		}

		// Filter on the language.
		if ($language = $this->getState('filter.language'))
		{
			$query->where('a.language = ' . $db->quote($language));
		}

		// Add the list ordering clause.
		$orderCol = $this->state->get('list.ordering', 'a.title');
		$orderDirn = $this->state->get('list.direction', 'asc');
		if ($orderCol == 'a.ordering' || $orderCol == 'category_title')
		{
			$orderCol = 'a.ordering ' . $orderDirn . ', a.ordering';
		}

		$query->order($db->escape($orderCol . ' ' . $orderDirn));
		
		return $query;
	}

	public function getAuthors()
	{
		// Create a new query object.
		$db = $this->getDbo();
		$query = $db->getQuery(true);

		// Construct the query
		$query->select('u.id AS value, u.name AS text')
			->from('#__users AS u')
			->join('INNER', '#__minitek_wall_instances AS c ON c.created_by = u.id')
			->group('u.id, u.name')
			->order('u.name');

		// Setup the query
		$db->setQuery($query);

		// Return the result
		return $db->loadObjectList();
	}
	
	public function getModules()
	{
		// Create a new query object.
		$db = $this->getDbo();
		$query = $db->getQuery(true);

		// Construct the query
		$query->select('m.id AS value, m.name AS text')
			->from('#__minitek_wall_modules as m')
			->join('INNER', '#__minitek_wall_instances AS i ON i.id = m.instance_id')
			->group('m.id, m.name')
			->order('m.name');

		// Setup the query
		$db->setQuery($query);

		// Return the result
		return $db->loadObjectList();
	}
	
	public function getItems()
	{
		$items = parent::getItems();
		$app = JFactory::getApplication();
		if ($app->isSite())
		{
			$user = JFactory::getUser();
			$groups = $user->getAuthorisedViewLevels();

			for ($x = 0, $count = count($items); $x < $count; $x++)
			{
				//Check the access level. Remove articles the user shouldn't see
				if (!in_array($items[$x]->access, $groups))
				{
					unset($items[$x]);
				}
			}
		}
		return $items;
	}
}
