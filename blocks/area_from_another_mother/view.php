<?php
defined('C5_EXECUTE') or die('Access Denied.');
/**
 * Displays Area Specified
 *
 * @see AreaFromAnotherMother::view()
 * @package AreaFromAnotherMother
 * @category Concrete5Addon
 */

$area = new Area($area_name);
$area->display($page);
