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

class MinitekWallViewModules extends JViewLegacy
{
	protected $items;

	protected $pagination;

	protected $state;

	public function display($tpl = null)
	{
		if ($this->getLayout() !== 'modal')
		{
			MinitekWallHelper::addSubmenu('modules');
		}

		$this->items		= $this->get('Items');
		$this->pagination	= $this->get('Pagination');
		$this->state		= $this->get('State');
		
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
		//$canDo = MinitekWallHelper::getActions($this->state->get('filter.category_id'));
		$canDo = MinitekWallHelper::getActions();
		$user  = JFactory::getUser();

		// Get the toolbar object instance
		$bar = JToolBar::getInstance('toolbar');

		JToolbarHelper::title(JText::_('COM_MINITEKWALL_MODULES_TITLE'), 'module.png');

		if ($canDo->get('core.create'))
		{
			JToolbarHelper::addNew('module.add');
		}

		if (($canDo->get('core.edit')) || ($canDo->get('core.edit.own')))
		{
			JToolbarHelper::editList('module.edit');
		}

		if ($canDo->get('core.edit.state'))
		{
			JToolbarHelper::publish('modules.publish', 'JTOOLBAR_PUBLISH', true);
			JToolbarHelper::unpublish('modules.unpublish', 'JTOOLBAR_UNPUBLISH', true);
			JToolbarHelper::archiveList('modules.archive');
			JToolbarHelper::checkin('modules.checkin');
		}

		if ($this->state->get('filter.published') == -2 && $canDo->get('core.delete'))
		{
			JToolbarHelper::deleteList('', 'modules.delete', 'JTOOLBAR_EMPTY_TRASH');
		}
		elseif ($canDo->get('core.edit.state'))
		{
			JToolbarHelper::trash('modules.trash');
		}

		if ($canDo->get('core.admin'))
		{
			JToolbarHelper::preferences('com_minitekwall');
		}

		JHtmlSidebar::setAction('index.php?option=com_minitekwall&view=modules');
				
		JHtmlSidebar::addFilter(
			JText::_('JOPTION_SELECT_PUBLISHED'),
			'filter_published',
			JHtml::_('select.options', JHtml::_('jgrid.publishedOptions'), 'value', 'text', $this->state->get('filter.published'), true)
		);
				
	}

	protected function getSortFields()
	{
		return array(
			'a.published' => JText::_('JSTATUS'),
			'a.name' => JText::_('JGLOBAL_TITLE'),
			'a.id' => JText::_('JGRID_HEADING_ID')		
		);
	}
}
