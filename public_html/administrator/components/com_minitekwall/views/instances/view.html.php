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

class MinitekWallViewInstances extends JViewLegacy
{
	protected $items;

	protected $pagination;

	protected $state;

	public function display($tpl = null)
	{
		if ($this->getLayout() !== 'modal')
		{
			MinitekWallHelper::addSubmenu('instances');
		}

		$this->items		= $this->get('Items');
		$this->pagination	= $this->get('Pagination');
		$this->state		= $this->get('State');
		$this->modules		= $this->get('Modules');
		$this->authors		= $this->get('Authors');
		
		// Check for errors.
		if (count($errors = $this->get('Errors')))
		{
			JError::raiseError(500, implode("\n", $errors));
			return false;
		}

		// We don't need toolbar in the modal window.
		if ($this->getLayout() !== 'modal')
		{
			$this->addToolbar();
			$this->sidebar = JHtmlSidebar::render();
		}
		
		parent::display($tpl);
	}

	protected function addToolbar()
	{
		//$canDo = MinitekLSHelper::getActions($this->state->get('filter.category_id'));
		$canDo = MinitekWallHelper::getActions();
		$user  = JFactory::getUser();

		// Get the toolbar object instance
		$bar = JToolBar::getInstance('toolbar');

		JToolbarHelper::title(JText::_('COM_MINITEKWALL_INSTANCES_TITLE'), 'instance.png');

		if ($canDo->get('core.create'))
		{
			JToolbarHelper::addNew('instance.add');
		}

		if (($canDo->get('core.edit')) || ($canDo->get('core.edit.own')))
		{
			JToolbarHelper::editList('instance.edit');
		}

		if ($canDo->get('core.edit.state'))
		{
			JToolbarHelper::publish('instances.publish', 'JTOOLBAR_PUBLISH', true);
			JToolbarHelper::unpublish('instances.unpublish', 'JTOOLBAR_UNPUBLISH', true);
			JToolbarHelper::archiveList('instances.archive');
			JToolbarHelper::checkin('instances.checkin');
		}

		if ($this->state->get('filter.published') == -2 && $canDo->get('core.delete'))
		{
			JToolbarHelper::deleteList('', 'instances.delete', 'JTOOLBAR_EMPTY_TRASH');
		}
		elseif ($canDo->get('core.edit.state'))
		{
			JToolbarHelper::trash('instances.trash');
		}

		if ($canDo->get('core.admin'))
		{
			JToolbarHelper::preferences('com_minitekwall');
		}

		JHtmlSidebar::setAction('index.php?option=com_minitekwall&view=instances');
		
		JHtmlSidebar::addFilter(
			JText::_('COM_MINITEKWALL_SELECT_MODULE'),
			'filter_module_id',
			JHtml::_('select.options', $this->modules, 'value', 'text', $this->state->get('filter.module_id'))
		);
				
		JHtmlSidebar::addFilter(
			JText::_('JOPTION_SELECT_PUBLISHED'),
			'filter_published',
			JHtml::_('select.options', JHtml::_('jgrid.publishedOptions'), 'value', 'text', $this->state->get('filter.published'), true)
		);
				
		JHtmlSidebar::addFilter(
			JText::_('JOPTION_SELECT_AUTHOR'),
			'filter_author_id',
			JHtml::_('select.options', $this->authors, 'value', 'text', $this->state->get('filter.author_id'))
		);

	}

	protected function getSortFields()
	{
		return array(
			'im.id' => JText::_('COM_MINITEKWALL_SORT_MODULE'),
			'a.type_id' => JText::_('COM_MINITEKWALL_SORT_TYPE'),
			'a.state' => JText::_('JSTATUS'),
			'a.title' => JText::_('JGLOBAL_TITLE'),
			'a.created_by' => JText::_('JAUTHOR'),
			'a.created' => JText::_('JDATE'),
			'a.id' => JText::_('JGRID_HEADING_ID')		
		);
	}
}
