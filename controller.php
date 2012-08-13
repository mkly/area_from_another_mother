<?php
defined('C5_EXECUTE') or die('Access Denied.');
/**
* Area From Another Mother
*
* @author Mike Lay
* @copyright 2012 Mike Lay
* @license MIT
* @version 0.1
* @package AreaFromAnotherMother
*
* MIT LICENSE
*
* Permission is hereby granted, free of charge, to any person obtaining
* a copy of this software and associated documentation files (the
* "Software"), to deal in the Software without restriction, including
* without limitation the rights to use, copy, modify, merge, publish,
* distribute, sublicense, and/or sell copies of the Software, and to
* permit persons to whom the Software is furnished to do so, subject to
* the following conditions:
*
* The above copyright notice and this permission notice shall be
* included in all copies or substantial portions of the Software.
*
* THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND,
* EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF
* MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND
* NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE
* LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION
* OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION
* WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
*/


/**
 * Area From Another Mother Package
 *
 * @package Area From Another Mother
 * @uathor Mike Lay
 */
class AreaFromAnotherMotherPackage extends Package {

	/**
	 * @var string
	 */
	protected $pkgHandle = "area_from_another_mother";
	/**
	 * @var string
	 */
	protected $appVersionRequired = "5.0";
	/**
	 * @var string
	 */
	protected $pkgVersion = "0.1";

	/**
	 * Gets package name
	 * @return string
	 */
	public function getPackageName() {
		return t('Area From Another Mother');
	}

	/**
	 * Gets package description
	 * @return string
	 */
	public function getPackageDescription() {
		return t('Package Description');
	}

	/**
	 * Installs Area From Another Mother Package
	 * @return void
	 */
	public function install() {
		$pkg = parent::install();

		/**
		 * Install Block Types
		 */
		$block_type = BlockType::getByHandle('area_from_another_mother');
		if(!is_object($block_type)) {
			BlockType::installBlockTypeFromPackage(
				'area_from_another_mother',
				$pkg
			);
		}
	}
}
