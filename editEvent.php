<?php

require_once "Setup.php";
require_once INCLUDE_PATH . "class.Session.php";
require_once INCLUDE_PATH . "class.URLManager.php";
require_once INCLUDE_PATH . "class.Database.php";

//Make sure the user is logged in
$session = Session::getInstance();
if (!($user = $session->loggedIn())){
	URLManager::loginRedirect();
}

if (!isset($_REQUEST["id"]) || !($eventId = $_REQUEST["id"])) {
	header("Location: index.php");
	exit;
}

$pageErrors = array();

if (is_numeric($eventId)) {
	$database = Database::getInstance();
	if (!($event = $database->getEvent($eventId))) {
		$pageErrors[] = "Could not find event with id '$eventId'.";
	}
}
else {
	$pageErrors[] = "Invalid event id '$eventId'.";
}

if ($pageErrors) {
	require INCLUDE_PATH . "inc.header.php";
	require INCLUDE_PATH . "inc.error.php";
	require INCLUDE_PATH . "inc.footer.php";
	exit;
}

if ($_POST) {
	$event["title"] = $_POST["title"];
	$event["start_date"] = new DateTime($_POST["start_date"]);
	if (!$event["start_date"]) {
		$errors[] = "Invalid Date Time format.";
	}
	$event["description"] = $_POST["description"];
	
	if (!$errors) {
		try {
			$database->updateEvent($event);
			header("Location: index.php");
			exit;
		}
		catch (Exception $ex) {
			$errors[] = $ex->getMessage();
			print_r($ex);
		}
	}
}//End if POST

//Add extra styles for date time picker.
$extraScripts[] = "https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js";
$extraScripts[] = "js/jquery-ui-timepicker-addon.js";
$extraScripts[] = "js/main.js";
$extraStyles[]  = "https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/themes/smoothness/jquery-ui.css";
$extraStyles[]  = "css/jquery-ui-timepicker-addon.css";

$pageTitle = "Edit Event - " . $event["title"];

require INCLUDE_PATH . "inc.header.php";
?>
<h1>Edit Event</h1>
<hr />
<form method="POST">
	<input type="hidden" name="id" value="<?php echo $event["id"]; ?>" />
	<div class="form-group">
		<label for="title">Event Title:</label>
		<input type="text" class="form-control" id="title" name="title" required value="<?php echo $event["title"]; ?>" />
	</div>
	<div class="form-group">
		<label for="start_date">Start Date</label>
		<input type="text" class="form-control datetimepicker" id="start_date" name="start_date" required readonly value="<?php echo $event["start_date"]->format("m/d/Y h:i a"); ?>" />
	</div>
	<div class="form-group">
		<label for="description">Comment:</label>
		<textarea class="form-control" rows="5" id="description" name="description" style="resize: vertical;"><?php echo $event["description"]; ?></textarea>
	</div>
	<input type="submit" class="btn btn-default" value="Update" />
</form>
<?php
require INCLUDE_PATH . "inc.footer.php";