<?php

require_once "Setup.php";
require_once INCLUDE_PATH . "class.Database.php";

$errors = array();
$pageErrors = array();

if (!isset($_REQUEST["id"]) && !$_REQUEST["id"]) {
	header("Location: index.php");
	exit;
}
$eventId = $_REQUEST["id"];

$database = Database::getInstance();
try {
	$event = $database->getEvent($eventId);
	if (!$event) {
		$pageErrors[] = "Could not find event with id $eventId.";
	}
} catch (Exception $ex) {
	$pageErrors[] = $ex->getMessage();
}
if ($pageErrors) {
	require INCLUDE_PATH . "inc.header.php";
	require INCLUDE_PATH . "inc.error.php";
	require INCLUDE_PATH . "inc.footer.php";
	exit;
}

$pageTitle = "{$event->title} - " . APPLICATION_NAME;

//Add extra styles for date time picker.
$extraScripts[] = "https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js";
$extraScripts[] = "js/jquery-ui-timepicker-addon.js";
$extraScripts[] = "js/main.js";
$extraStyles[]  = "https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/themes/smoothness/jquery-ui.css";
$extraStyles[]  = "css/jquery-ui-timepicker-addon.css";

require INCLUDE_PATH . "inc.header.php";
?>
<h1><?php echo "value='{$event->title}'";?></h1>
<p><?php echo "value='{$event->description}'";?></p>
		<label for="end_date">End Date</label>
		<input type="text" class="form-control datetimepicker" id="end_date" name="end_date" required readonly <?php echo "value='{$_POST["end_date"]}'";?> />
	</div>
	<div class="form-group">
		<label for="description">Comment:</label>
		<textarea class="form-control" rows="5" id="description" name="description" style="resize: vertical;"></textarea>
	</div>
	<input type="submit" class="btn btn-default" value="Create" />
</form>
<?php
require INCLUDE_PATH . "inc.footer.php";