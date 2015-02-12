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

JHtml::addIncludePath(JPATH_COMPONENT . '/helpers/html');

JHtml::_('behavior.formvalidation');
JHtml::_('formbehavior.chosen', 'select');
?>
<script type="text/javascript">
	Joomla.submitbutton = function(task)
	{
		if (task == 'client.cancel' || document.formvalidator.isValid(document.id('client-form')))
		{
			Joomla.submitform(task, document.getElementById('client-form'));
		}
	}
</script>

<form action="<?php echo JRoute::_('index.php?option=com_minitekwall&layout=edit&id=' . (int) $this->item->id); ?>" method="post" name="adminForm" id="client-form" class="form-validate">

	<div class="form-horizontal">
		
		<div class="control-group ">
			<div class="control-label">
				<span class="spacer">
					<span class="before"></span>
					<span>
						<label>
							<h3><?php echo JText::_('COM_MINITEKWALL_FIELD_MODULE_BASIC_PARAMS'); ?></h3>
						</label>
					</span>
				</span>
			</div>
		</div>
		
		<div class="row-fluid">
			<div class="span12">
				<?php
				echo $this->form->getControlGroup('name');
				echo $this->form->getControlGroup('instance_id');
				echo $this->form->getControlGroup('published');
				echo $this->form->getControlGroup('description');
				?>
			</div>
		</div>
		<div class="row-fluid">
			<div class="span12">
				<?php echo $this->form->getControlGroup('module_type'); ?>
				<?php foreach ($this->form->getGroup('module_type') as $field) : ?>
					<?php echo $field->getControlGroup(); ?>
				<?php endforeach; ?>
			</div>
		</div>     
		<div class="row-fluid">
			<div class="span12">
				<?php echo $this->form->getControlGroup('pagination'); ?>
				<?php foreach ($this->form->getGroup('pagination') as $field) : ?>
					<?php echo $field->getControlGroup(); ?>
				<?php endforeach; ?>
			</div>
		</div>     
	</div>

	<input type="hidden" name="task" value="" />
	<?php echo JHtml::_('form.token'); ?>
</form>
