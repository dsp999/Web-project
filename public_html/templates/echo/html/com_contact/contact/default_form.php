<?php
/**
 * @package     Joomla.Site
 * @subpackage  com_contact
 *
 * @copyright   Copyright (C) 2005 - 2013 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

JHtml::_('behavior.keepalive');
JHtml::_('behavior.formvalidation');

$regex = '@class="([^"]*)"@';
$lbreg = '@" class="([^"]*)"@';
$label = 'class="$1 col-sm-2 control-label"';
$input = 'class="$1 form-control"';
$input_name = 'class="$1 form-control" placeholder="'.JText::_("COM_CONTACT_CONTACT_EMAIL_NAME_LABEL").'"';
$input_email = 'class="$1 form-control" placeholder="'.JText::_("COM_CONTACT_EMAIL_LABEL").'"';
$input_subject = 'class="$1 form-control" placeholder="'.JText::_("COM_CONTACT_CONTACT_MESSAGE_SUBJECT_LABEL").'"';
$input_message = 'class="$1 form-control" placeholder="'.JText::_("COM_CONTACT_CONTACT_ENTER_MESSAGE_LABEL").'"';

if (isset($this->error)) : ?>
	<div class="contact-error">
		<?php echo $this->error; ?>
	</div>
<?php endif; ?>
<?php 
$version = JVERSION;
$jversion = (int)$version[0];

if ($jversion >= 3)
{ ?>
        <div class="contact-form">
	<form id="contact-form" action="<?php echo JRoute::_('index.php'); ?>" method="post" class="form-validate form-horizontal">
		<fieldset>
			<div class="form-group">
				<div class="mn-form-fix">
					<input type="text" name="jform[contact_name]" id="jform_contact_name" value="" size="30" required="" aria-required="true" placeholder="<?php echo JText::_("COM_CONTACT_CONTACT_EMAIL_NAME_LABEL");?>">
				</div>
			</div>
			<div class="form-group">
				<div class="mn-form-fix">
					<input type="email" name="jform[contact_email]" placeholder="<?php echo JText::_("COM_CONTACT_EMAIL_LABEL");?>" id="jform_contact_email" value="" size="30" required="" aria-required="true">
				</div>
			</div>
			<div class="form-group">
				<div class="">
					<input type="text" name="jform[contact_subject]" id="jform_contact_emailmsg" value="" size="60" required="" aria-required="true"  placeholder="<?php echo JText::_("COM_CONTACT_CONTACT_MESSAGE_SUBJECT_LABEL");?>">
				</div>
			</div>
			<div class="form-group">
				<div class="">
					<textarea name="jform[contact_message]" id="jform_contact_message" cols="50" rows="10" required="" aria-required="true"  placeholder="<?php echo JText::_("COM_CONTACT_CONTACT_ENTER_MESSAGE_LABEL");?>" ></textarea>
				</div>
			</div>
			<div class="form-group">
				<div class="">
					<button class="btn btn-primary validate" type="submit"><?php echo JText::_('COM_CONTACT_CONTACT_SEND'); ?></button>
				</div>
				
				<input type="hidden" name="option" value="com_contact" />
				<input type="hidden" name="task" value="contact.submit" />
				<input type="hidden" name="return" value="<?php echo $this->return_page;?>" />
				<input type="hidden" name="id" value="<?php echo $this->contact->slug; ?>" />
				<?php echo JHtml::_('form.token'); ?>
			</div>
			<?php if ($this->params->get('show_email_copy')) { ?>
				<div class="form-group">
					<div class="col-sm-10">
						<div class="checkbox">
							<?php echo $this->form->getInput('contact_email_copy'); ?>
							<?php echo $this->form->getLabel('contact_email_copy'); ?>
						</div>
					</div>
				</div>
			<?php } ?>
		</fieldset>
	</form>
</div>
<?php 
 }
 else
{
	?>
    <div class="contact-form">
	<form id="contact-form" action="<?php echo JRoute::_('index.php'); ?>" method="post" class="form-validate form-horizontal">
		<fieldset>
			<div class="form-group">
				<div class="col-sm-12 mn-form-fix">
					<?php echo preg_replace($regex, $input_name, $this->form->getInput('contact_name')); ?>
				</div>
			</div>
			<div class="form-group">
				<div class="col-sm-12 mn-form-fix">
					<?php echo preg_replace($regex, $input_email, $this->form->getInput('contact_email')); ?>
				</div>
			</div>
			<div class="form-group">
				<div class="col-sm-12">
					<?php echo preg_replace($regex, $input_subject, $this->form->getInput('contact_subject')); ?>
				</div>
			</div>
			<div class="form-group">
				<div class="col-sm-12">
					<?php echo preg_replace($regex, $input_message, $this->form->getInput('contact_message')); ?>
				</div>
			</div>
			<div class="form-group">
				<div class="col-sm-12">
					<button class="btn btn-primary validate" type="submit"><?php echo JText::_('COM_CONTACT_CONTACT_SEND'); ?></button>
				</div>
				
				<input type="hidden" name="option" value="com_contact" />
				<input type="hidden" name="task" value="contact.submit" />
				<input type="hidden" name="return" value="<?php echo $this->return_page;?>" />
				<input type="hidden" name="id" value="<?php echo $this->contact->slug; ?>" />
				<?php echo JHtml::_('form.token'); ?>
			</div>
			<?php if ($this->params->get('show_email_copy')) { ?>
				<div class="form-group">
					<div class="col-sm-10">
						<div class="checkbox">
							<?php echo $this->form->getInput('contact_email_copy'); ?>
							<?php echo $this->form->getLabel('contact_email_copy'); ?>
						</div>
					</div>
				</div>
			<?php } ?>
		</fieldset>
	</form>
</div>
<?php
}
?>
