<?php

require_once "Setup.php";
require_once INCLUDE_PATH . "class.URLManager.php";

//Make sure the user is logged in
$session = Session::getInstance();
if (!($user = $session->loggedIn())){
	URLManager::loginRedirect();
}

$errors = array();

if ($_POST) {
	require_once INCLUDE_PATH . "class.InputValidator.php";
	require_once INCLUDE_PATH . "class.Database.php";
	
	if (!InputValidator::validateEventTitle($_POST["title"])) {
		$errors[] = "Title must be between 8 and 128 characters, " . strlen($_POST["title"]) . " characters given.";
	}
	
	$start_date = date_create($_POST["start_date"]);
	if (!$start_date) {
		$errors[] = "Invalid Date Time format.";
		
	}
	
	if (!$errors) {
		try {
			$database = Database::getInstance();
			$data = array("title" => $_POST["title"], "start_date" => $start_date, "description" => $_POST["description"]);
			$event = $database->createEvent($data);
			header("Location: choosePositions.php?id=$event[id]");
			exit;
		} catch (Exception $ex) {
			$errors[] = $ex->getMessage();
			print_r($ex);
		}
	}
	
}//End if POST

$pageTitle = "Create Event - " . APPLICATION_NAME;

//Add extra styles for date time picker.
$extraScripts[] = "https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js";
$extraScripts[] = "js/jquery-ui-timepicker-addon.js";
$extraScripts[] = "js/main.js";
$extraStyles[]  = "https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/themes/smoothness/jquery-ui.css";
$extraStyles[]  = "css/jquery-ui-timepicker-addon.css";

require INCLUDE_PATH . "inc.header.php";
?>
<h1>Create a New Event</h1>
<hr />
<form method="POST">
	<div class="form-group">
		<label for="title">Event Title:</label>
		<input type="text" class="form-control" id="title" name="title" required <?php if ($_POST) echo "value='{$_POST["title"]}'";?> />
	</div>
	<div class="form-group">
		<label for="start_time">Start Date</label>
		<input type="text" class="form-control datetimepicker" id="start_time" name="start_date" required <?php if ($_POST) echo "value='{$_POST["start_date"]}'";?> />
	</div>
	<div class="form-group">
		<label for="description">Comment:</label>
		<textarea class="form-control" rows="5" id="description" name="description" style="resize: vertical;"><?php if ($_POST) echo $_POST["description"]; ?></textarea>
	</div>
	<input type="submit" class="btn btn-default" value="Create" />
</form>
<?php
require INCLUDE_PATH . "inc.footer.php";