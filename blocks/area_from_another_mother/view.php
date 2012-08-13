<?php
defined('C5_EXECUTE') or die('Access Denied.');
/**
 * Displays Area Specified
 * if permissions allow
 *
 * @see AreaFromAnotherMother::view()
 * @package AreaFromAnotherMother
 * @category Concrete5Addon
 */

if($can_read) {
	$area = new Area($area_name);
	$area->display($page);
}
