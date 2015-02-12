<?php
/**
* @title			MInitek Wall
* @copyright   		Copyright (C) 2011-2014 Minitek, All rights reserved.
* @license   		GNU General Public License version 3 or later.
* @author url   	http://www.minitek.gr/
* @developers   	Minitek.gr
*/

// no direct access
defined('_JEXEC') or die('Restricted access');

// Include the component HTML helpers.
JHtml::addIncludePath(JPATH_COMPONENT . '/helpers/html');

JHtml::_('behavior.formvalidation');
JHtml::_('behavior.keepalive');
JHtml::_('formbehavior.chosen', 'select');

// Create shortcut to parameters.
$params = $this->state->get('params');
$params = $params->toArray();

// This checks if the config options have ever been saved. If they haven't they will fall back to the original settings.
$editoroptions = isset($params['show_publishing_options']);

$app = JFactory::getApplication();
$input = $app->input;

if (!$editoroptions)
{
	$params['show_publishing_options'] = '1';
}

// Check if the article uses configuration settings besides global. If so, use them.
if (!empty($this->item->attribs['show_publishing_options']))
{
	$params['show_publishing_options'] = $this->item->attribs['show_publishing_options'];
}
?>

<script type="text/javascript">
	Joomla.submitbutton = function(task)
	{
		if (task == 'article.cancel' || document.formvalidator.isValid(document.id('item-form')))
		{
			<?php //echo $this->form->getField('description')->save(); ?>
			Joomla.submitform(task, document.getElementById('item-form'));
		}
	}
</script>

<form action="<?php echo JRoute::_('index.php?option=com_minitekwall&layout=edit&id='.(int) $this->item->id); ?>" method="post" name="adminForm" id="item-form" class="form-validate mw-instance-form">

	<?php echo JLayoutHelper::render('joomla.edit.item_title', $this); ?>

	<div class="row-fluid">
		<!-- Begin Content -->
		<div class="span12 form-horizontal">
        
        	<?php // Select instance type
				if (!JRequest::getVar('type') && !JRequest::getVar('id')) {
					$uri = & JFactory::getURI();
					$new_url = $uri->toString();
					echo '<div class="well mw">';
						echo '<h3>'.JText::_('COM_MINITEKWALL_INSTANCE_SELECT_COMPONENT').'</h3>';
						echo '<div class="thumbnails">
        						<a href="'.$new_url.'&type=joomla" class="thumbnail">
                				<img src="components/com_minitekwall/assets/images/dashboard/icon-48-joomla.png" alt="Joomla">
                				<br>
                				<span>Joomla</span>
            					</a>
        					  </div>';
							  
							echo '<div class="thumbnails">
									<div class="thumbnail thumbnail-div">
										<img class="disabled" src="components/com_minitekwall/assets/images/dashboard/icon-48-k2.png" alt="K2">
										<br>
										<span class="disabled">K2</span>
										<a class="purchase-plugin" href="http://www.minitek.gr/joomla-extensions/joomla/minitek-wall" target="_blank">
											<span class="btn btn-primary">'.JText::_('COM_MINITEKWALL_PURCHASE_PRO').'</span>
										</a>
									</div>
								  </div>';	  
						
							echo '<div class="thumbnails">
									<div class="thumbnail thumbnail-div">
										<img class="disabled" src="components/com_minitekwall/assets/images/dashboard/icon-48-jomsocial.png" alt="Jomsocial">
										<br>
										<span class="disabled">Jomsocial</span>
										<a class="purchase-plugin" href="http://www.minitek.gr/joomla-extensions/joomla/minitek-wall" target="_blank">
											<span class="btn btn-primary">'.JText::_('COM_MINITEKWALL_PURCHASE_PRO').'</span>
										</a>
									</div>
								  </div>';	 
						
					echo '</div>';
				} else { ?>
        
			<?php echo JHtml::_('bootstrap.startTabSet', 'MW', array('active' => 'general')); ?>
                
				<?php
				if (JRequest::getVar('type') || JRequest::getVar('id')) { ?>
				<?php echo JHtml::_('bootstrap.addTab', 'MW', 'general', JText::_('COM_MINITEKWALL_INSTANCE_DETAILS', true)); ?>
					
                    <fieldset class="adminform">                  
                        
						<div class="control-group form-inline">
                            <div class="control-label">
							<?php echo $this->form->getLabel('title'); ?> 
                            </div>
                            <div class="controls">
							<?php echo $this->form->getInput('title'); ?> 
							</div>
                        </div>
                        <div class="control-group form-inline">
                            <div class="control-label">
							<?php echo $this->form->getLabel('state'); ?> 
                            </div>
                            <div class="controls">
							<?php echo $this->form->getInput('state'); ?> 
							</div>
                        </div>
                        <div class="control-group">
                            <div class="control-label">
							<?php echo $this->form->getLabel('description'); ?> 
                            </div>
                            <div class="controls">
							<?php echo $this->form->getInput('description'); ?>
                            </div>
                        </div>
                       
					</fieldset>
                    
				<?php echo JHtml::_('bootstrap.endTab'); ?>
				<?php } ?>
                
                <?php // Joomla Settings
				if (JRequest::getVar('type') == 'joomla' || $this->instance_type == 'joomla') { ?>
                <?php echo JHtml::_('bootstrap.addTab', 'MW', 'joomla', JText::_('COM_MINITEKWALL_FIELDSET_JOOMLA', true)); ?>
                
					<div class="row-fluid">
						<div class="span12">
							<?php echo $this->form->getControlGroup('joomla_type'); ?>
							<?php foreach ($this->form->getGroup('joomla_type') as $field) : ?>
								<?php echo $field->getControlGroup(); ?>
							<?php endforeach; ?>
                        </div>
                    </div>     
                               
                <?php echo JHtml::_('bootstrap.endTab'); ?>
                <?php } ?>
                
                <?php // Publishing Options
				if (JRequest::getVar('type') || JRequest::getVar('id')) { ?>
				<?php // Do not show the publishing options if the edit form is configured not to. ?>
					<?php  if ($params['show_publishing_options'] || ( $params['show_publishing_options'] = '' && !empty($editoroptions)) ) : ?>
						<?php echo JHtml::_('bootstrap.addTab', 'MW', 'publishing', JText::_('COM_MINITEKWALL_FIELDSET_PUBLISHING', true)); ?>
							<div class="row-fluid">
								<div class="span6">
									<div class="control-group">
										<?php echo $this->form->getLabel('alias'); ?>
										<div class="controls">
											<?php echo $this->form->getInput('alias'); ?>
										</div>
									</div>
									<div class="control-group">
										<div class="control-label">
											<?php echo $this->form->getLabel('id'); ?>
										</div>
										<div class="controls">
											<?php echo $this->form->getInput('id'); ?>
										</div>
									</div>
									<div class="control-group">
										<?php echo $this->form->getLabel('created_by'); ?>
										<div class="controls">
											<?php echo $this->form->getInput('created_by'); ?>
										</div>
									</div>
									<div class="control-group">
										<?php echo $this->form->getLabel('created_by_alias'); ?>
										<div class="controls">
											<?php echo $this->form->getInput('created_by_alias'); ?>
										</div>
									</div>
									<div class="control-group">
										<?php echo $this->form->getLabel('created'); ?>
										<div class="controls">
											<?php echo $this->form->getInput('created'); ?>
										</div>
									</div>
								</div>
								<div class="span6">
									<?php if ($this->item->modified_by) : ?>
										<div class="control-group">
											<?php echo $this->form->getLabel('modified_by'); ?>
											<div class="controls">
												<?php echo $this->form->getInput('modified_by'); ?>
											</div>
										</div>
										<div class="control-group">
											<?php echo $this->form->getLabel('modified'); ?>
											<div class="controls">
												<?php echo $this->form->getInput('modified'); ?>
											</div>
										</div>
									<?php endif; ?>
								</div>
							</div>
						<?php echo JHtml::_('bootstrap.endTab'); ?>
					<?php  endif; ?>
					<?php } ?>
                    
					<?php
					if (JRequest::getVar('type') || JRequest::getVar('id')) { ?>
					<?php if ($this->canDo->get('core.admin')) : ?>
						<?php echo JHtml::_('bootstrap.addTab', 'MW', 'permissions', JText::_('COM_MINITEKWALL_FIELDSET_RULES', true)); ?>
							<fieldset>
								<?php echo $this->form->getInput('rules'); ?>
							</fieldset>
						<?php echo JHtml::_('bootstrap.endTab'); ?>
					<?php endif; ?>
                    <?php } ?>

			<?php echo JHtml::_('bootstrap.endTabSet'); ?>
            
            <?php } ?>

			<input type="hidden" name="task" value="" />
			<input type="hidden" name="return" value="<?php echo $input->getCmd('return');?>" />
			<?php echo JHtml::_('form.token'); ?>
		</div>
		<!-- End Content -->
                
	</div>
</form>
