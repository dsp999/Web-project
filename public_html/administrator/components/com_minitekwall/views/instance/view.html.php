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

class MinitekWallViewInstance extends JViewLegacy
{
	protected $form;

	protected $item;

	protected $state;

	public function display($tpl = null)
	{
		if ($this->getLayout() == 'pagebreak')
		{
			// TODO: This is really dogy - should change this one day.
			$eName    = JRequest::getVar('e_name');
			$eName    = preg_replace('#[^A-Z0-9\-\_\[\]]#i', '', $eName);
			$document = JFactory::getDocument();
			$document->setTitle(JText::_('COM_MINITEKWALL_PAGEBREAK_DOC_TITLE'));
			$this->eName = &$eName;
			parent::display($tpl);
			return;
		}

		$this->form		= $this->get('Form');
		$this->item		= $this->get('Item');
		$this->state	= $this->get('State');
		$this->canDo	= MinitekWallHelper::getActions($this->state->get('filter.category_id'));

		// Check for errors.
		if (count($errors = $this->get('Errors')))
		{
			JError::raiseError(500, implode("\n", $errors));
			return false;
		}

		if ($this->getLayout() == 'modal')
		{
			$this->form->setFieldAttribute('language', 'readonly', 'true');
			//$this->form->setFieldAttribute('catid', 'readonly', 'true');
		}
		
		// Get instance type/id from model
		if (JRequest::getVar('id')) {
			$model = $this->getModel('Instance');
			$this->instance_type = $model->getType(JRequest::getVar('id'));
			if ($this->instance_type == 'joomla') {
			 	$this->instance_id = '1';
			} else if ($this->instance_type == 'k2') {
			 	$this->instance_id = '2';
			} else if ($this->instance_type == 'jomsocial') {
			 	$this->instance_id = '3';
			} else {
				$this->instance_id = '0';
			}
		} else {
			if (JRequest::getVar('type') == 'joomla') {
				$this->instance_type = 'joomla';
				$this->instance_id = '1';
			} else if (JRequest::getVar('type') == 'k2') {
				$this->instance_type = 'k2';
				$this->instance_id = '2';
			} else if (JRequest::getVar('type') == 'jomsocial') {
				$this->instance_type = 'jomsocial';
				$this->instance_id = '3';
			} else {
				$this->instance_type = '';
				$this->instance_id = '0';
			}
		}
	
		$this->addToolbar();
		parent::display($tpl);
	}

	protected function addToolbar()
	{
		JFactory::getApplication()->input->set('hidemainmenu', true);
		$user		= JFactory::getUser();
		$userId		= $user->get('id');
		$isNew		= ($this->item->id == 0);
		$checkedOut	= !($this->item->checked_out == 0 || $this->item->checked_out == $userId);
		$canDo		= MinitekWallHelper::getActions($this->state->get('filter.category_id'), $this->item->id);
		JToolbarHelper::title(JText::_('COM_MINITEKWALL_PAGE_'.($checkedOut ? 'VIEW_INSTANCE' : ($isNew ? 'ADD_INSTANCE' : 'EDIT_INSTANCE'))), 'instance-add.png');

		// Built the actions for new and existing records.

		// For new records, check the create permission.
		if ($isNew && (count($user->getAuthorisedCategories('com_minitekwall', 'core.create')) > 0))
		{
			if (JRequest::getVar('type') || JRequest::getVar('id')) {
				JToolbarHelper::apply('instance.apply');
				JToolbarHelper::save('instance.save');
				JToolbarHelper::save2new('instance.save2new');
			}
			JToolbarHelper::cancel('instance.cancel');
		}
		else
		{
			// Can't save the record if it's checked out.
			if (!$checkedOut)
			{
				// Since it's an existing record, check the edit permission, or fall back to edit own if the owner.
				if ($canDo->get('core.edit') || ($canDo->get('core.edit.own') && $this->item->created_by == $userId))
				{
					if (JRequest::getVar('type') || JRequest::getVar('id')) {
						JToolbarHelper::apply('instance.apply');
						JToolbarHelper::save('instance.save');
					}

					// We can save this record, but check the create permission to see if we can return to make a new one.
					if ($canDo->get('core.create'))
					{
						if (JRequest::getVar('type') || JRequest::getVar('id')) {
							JToolbarHelper::save2new('instance.save2new');
						}
					}
				}
			}

			JToolbarHelper::cancel('instance.cancel', 'JTOOLBAR_CLOSE');
		}

	}
}
