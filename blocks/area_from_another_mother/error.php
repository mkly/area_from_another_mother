<?php
defined('C5_EXECUTE') or die('Access Denied.');
/**
 * Error View
 *
 * Displays view set by error handler
 * if show errors is enabled
 * Otherwise shows blank
 * @see AreaFromAnotherMotherBlockController::handleError()
 */
?>
<?php if($show_errors): ?>
	<h3>Error</h3>
	<ul class="error">
		<?php foreach($messages as $message): ?>
			<li><?php echo $message ?></li>
		<?php endforeach ?>
	</ul>
<?php endif ?>
