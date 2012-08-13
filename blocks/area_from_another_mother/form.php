<?php
/**
 * Displays block edit form
 *
 * @see AreaFromAnotherMother::edit()
 * @see AreaFromAnotherMother::add()
 * @package AreaFromAnotherMother
 * @category Concrete5Addon
 */


/**
 * Displays form for block editing
 */
defined('C5_EXECUTE') or die('Access Denied.');
?>
<div class="ccm-ui">
	<div class="alert-message block-message warning">
		<?php echo t('This block displays an area from another page. If you need to edit the content of the area you see here, you can do so at the original page.') ?>
	</div>
	<?php echo $page_selector->selectPage('page_id', $page_id) ?>
	<?php echo $form->label('area_name', t('Area Name'), array('style' => 'display:block; margin-bottom: 5px; font-weight: bold; float: none; text-align: left; width: auto;')) ?>
	<div class="ccm-ui">
		<?php echo $form->text('area_name', $area_name) ?>
	</div>
</div>
