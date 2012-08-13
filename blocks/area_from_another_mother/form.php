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

/**
 * Display Page Selector
 */
echo $page_selector->selectPage('page_id', $page_id);

/**
 * Display Area Specifier
 */
echo $form->label('area_name', t('Area Name'));
echo $form->text('area_name', $area_name);
