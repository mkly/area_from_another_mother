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
* @category Concrete5Addon
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
 * Area From Another Mother Block Controller
 *
 * Displays Area from another specified page
 * Displays form for user to specify page and area
 *
 * @package AreaFromAnotherMother
 * @category Concrete5Addon
 */
class AreaFromAnotherMotherBlockController extends BlockController {

	/**
	 * @var $btTable string
	 */
	protected $btTable = "btAreaFromAnotherMother";
	/**
	 * @var $btInterfaceWidth string
	 */
	protected $btInterfaceWidth = "400";
	/**
	 * @var $btInterfaceHeight string
	 */
	protected $btInterfaceHeight = "265";
	/**
	 * @var $btCacheBlockRecord bool
	 */
	protected $btCacheBlockRecord = true;
	/**
	 * @var $btCacheBlockOutput bool
	 */
	protected $btCacheBlockOutput = false;

	/**
	 * The area object
	 * @see area()
	 * @var Area
	 */
	protected $area;
	/**
	 * The page object
	 * @see page()
	 * @var Page
	 */
	protected $page;
	/**
	 * Permission to view area
	 * @see can_read()
	 * @var bool
	 */
	protected $can_read;
	/**
	 * Array of area blocks
	 * @see area_blocks()
	 * @var array
	 */
	protected $area_blocks;
	/**
	 * Tells if an error has occured
	 * @staticvar
	 * @var bool
	 */
	protected static $error = false;
	/**
	 * Error messages
	 * @staticvar
	 * @var array
	 */
	protected static $error_messages;
	/**
	 * Log messages
	 * @staticvar
	 * @var array
	 */
	 protected static $log_messages;

	/**
	 * Gets block type name
	 * @return string
	 */
	public function getBlockTypeName() {
		return t('Area From Another Mother');
	}

	/**
	 * Gets block type description
	 * @return string
	 */
	public function getBlockTypeDescription() {
		return t('Display and Area from a different page');
	}
	
	/**
	 * Runs specified area's blocks' on_start()
	 * @return void
	 */
	public function on_start() {
		if($this->area_blocks()) {
			foreach($this->area_blocks() as $block) {
				$block_controller = $block->getController();
				if(method_exists($block_controller, 'on_page_view')) {
					$block_controller->on_start();
				}
			}
		}
	}

	/**
	 * Runs specified area's blocks' on_page_view()
	 * @return void
	 */
	public function on_page_view() {
		$this->addAutoHeaderItems();

		if($this->area_blocks()) {
			foreach($this->area_blocks() as $block) {
				$block_controller = $block->getController();
				if(method_exists($block_controller, 'on_page_view')) {
					$block_controller->on_page_view();
				}
			}
		}
	}

	/**
	 * Prepares the block view
	 * @return void
	 */
	public function view() {
		/**
		 * If there is an error
		 * we want to pass to the
		 * error view
		 */
		if($this->error) {
			/**
			 * Only write to log if
			 * logging errors is enabled
			 */
			if(ENABLE_LOG_ERRORS) {
				$this->writeLog();
			}
			/**
			 * If set to show errors
			 * Unique out the duplicates
			 * and pass to error view
			 */
			if(Config::get('SITE_DEBUG_LEVEL') == DEBUG_DISPLAY_ERRORS) {
				$this->set('messages', array_unique($this->error_messages));
				$this->set('show_errors', true);
			}
			$this->render('error');
		}
		/**
		 * No error so we'll set the values
		 * and render the view
		 */

		/**
		 * Check permissions of the area
		 */
		$this->set('can_read', $this->can_read());

		$this->set('page', $this->page());
		$this->set('area', $this->area());
	}

	/**
	 * Prepare add view
	 *
	 * Simpley calls edit method
	 * @see edit
	 * @return void
	 */
	public function add() {
		$this->edit();
	}

	/**
	 * Prepare edit view
	 *
	 * @return void
	 */
	public function edit() {
		$this->set(
			'page_selector',
			Loader::helper('form/page_selector')
		);
	}

	/**
	 * Get array of area blocks
	 *
	 * @return array area blocks
	 */
	protected function area_blocks() {
		if(!$this->area_blocks) {
			if($this->area()) {
				$this->area_blocks = $this->area()->getAreaBlocksArray($this->page());
			}
		}
		return $this->area_blocks;
	}

	/**
	 * Get the Area object
	 *
	 * If area is not found
	 * call error handler
	 * @see handleError()
	 * @return Area
	 */
	protected function area() {
		if(!$this->area) {
			$this->area = Area::get($this->page(), $this->record->area_name);

			if(!$this->area instanceof Area) {
				$this->handleError(
					t('Area not found. Area Name: ').
					$this->record->area_name
				);
			}
		}
		return $this->area;
	}

	/**
	 * Gets the Page object
	 *
	 * If page is not found call
	 * error handler
	 * @see handleError()
	 * @return Page
	 */
	protected function page() {
		if(!$this->page) {
			$this->page = Page::getByID($this->record->page_id);

			if($this->page->isError()) {
				$this->handleError(
					t('Page not found. Page ID: ').
					$this->record->page_id
				);
			}
		}
		return $this->page;
	}

	/**
	 * Checks permissions of area
	 *
	 * Permissions are base upon the original
	 * page, not the page displayig the area
	 *
	 * @return bool
	 */
	protected function can_read() {
		if(!$this->can_read) {
			if($this->area()) {
				$area_permissions = new Permissions($this->area());
				return $area_permissions->canRead();
			}
		}
	}

	/**
	 * Adds files that are typically auto
	 * included
	 *
	 * Checks if each file exists and then if
	 * so adds it to be linked to in the head
	 * or the document
	 *
	 * view.css
	 * view.js
	 * auto.js
	 *
	 * @return void
	 */
	protected function addAutoHeaderItems() {
		$html = Loader::helper('html');
		
		/**
		 * We need to get the block view
		 * as our only reliable way to grab
		 * the block url
		 */
		foreach($this->area_blocks() as $block) {
			$block_view = new BlockView();
			$block_view->setBlockObject($block);
			$block_url = $block_view->getBlockURL();

			/**
			 * Set up our urls to be included
			 */
			$view_css_url = $block_url.'/view.css';
			$view_js_url = $block_url.'/view.js';

			/**
			 * Get the blocks file path
			 */
			$block_type = $block->getBlockTypeObject();
			$block_type_path = $block_type->getBlockTypePath();

			/**
			 * Set up our files to check
			 */
			$view_css_file = $block_type_path.'/view.css';
			$view_js_file = $block_type_path.'/view.js';

			/**
			 * Check if each file exists and
			 * if so add to the header
			 */
			if(file_exists($view_css_file)) {
				$this->addHeaderItem(
					$html->css($view_css_url)
				);
			}
			if(file_exists($view_js_file)) {
				$this->addHeaderItem(
					$html->javascript($view_js_url)
				);
			}
		}
	}

	/**
	 * Writes errors to log
	 * @return void
	 */
	protected function writeLog() {
		$log = new Log('Area_From_Another_Mother', true);
		$messages = array_unique($this->log_messages);
		foreach($messages as $message) {
			$log->write($message);
		}
		$log->close();
	}

	/**
	 * Handles errors
	 *
	 * Adds to log_messages and error_messages
	 * arrays and sets error to true
	 *
	 * @param string $message The message to display
	 * @return void
	 */
	protected function handleError($message) {
		$this->log_messages[] = $message;
		$this->error_messages[] = $message;
		$this->error = true;
	}
}
