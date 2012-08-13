<?php
defined('C5_EXECUTE') or die('Access Denied.');
/**
 * Error View
 *
 * Displays view set by error handler
 * @see AreaFromAnotherMotherBlockController::handleError()
 */
?>
<h3>Error</h3>
<ul class="error">
	<?php foreach($messages as $message): ?>
		<li><?php echo $message ?></li>
	<?php endforeach ?>
</ul>
