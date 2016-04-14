<?php

require_once 'Setup.php';
include_once INCLUDE_PATH . "class.Session.php";

//Make sure the user is logged in
$session = Session::getInstance();
if (!($user = $session->loggedIn())){
	URLManager::loginRedirect();
}

$errors = array();

if ($_POST) {
	require_once INCLUDE_PATH . "class.InputValidator.php";
	
	if (!InputValidator::validateName($_POST["name"])) {
		$errors[] = "Invalid name: '{$_POST["name"]}'.";
	}
	if (!InputValidator::validatePhoneNumber($_POST["phone_number"])) {
		$errors[] = "Invalid phone number: '{$_POST["phone_number"]}'.";
	}
	if (!InputValidator::validateEmail($_POST["email_address"])) {
		$errors[] = "Invalid email address: '{$_POST["email_address"]}'.";
	}
	
	if (!$errors) {
		require_once INCLUDE_PATH . "class.Database.php";
		
		$database = Database::getInstance();
		try {
			$worker = $database->createWorker($_POST);
			header("Location: workers.php");
			exit;
			
		} catch (Exception $ex) {
			$errors[] = $ex->getMessage();
		}
	}
}

require INCLUDE_PATH . "inc.header.php";
?>
<form id="addWorkerForm" method="POST" autocomplete="off">
	<div class="form-group">
		<label for="workerNumber">workerNumber:</label>
		<input id="workerNumber" class="form-control" type="number" name="workerNumber" required <?php if ($_POST) echo "value='{$_POST["workerNumber"]}'";?> />
	</div>
	<div class="form-group">
		<label for="name">Name:</label>
		<input id="name" class="form-control" type="text" name="name" required <?php if ($_POST) echo "value='{$_POST["name"]}'";?> />
	</div>
	<div class="form-group">
		<label for="phone_number">Phone Number:</label>
		<input id="last_name" class="form-control" type="text" name="phone_number" maxlength="10" required <?php if ($_POST) echo "value='{$_POST["phone_number"]}'";?> />
	</div>
	<div class="form-group">
		<label for="email_address">Email Address:</label>
		<input id="email_address" class="form-control" type="email" name="email_address" required <?php if ($_POST) echo "value='{$_POST["email_address"]}'";?> />
	</div>
	<div class="form-group">
		<label for="password">Password:</label>
		<input type="password" id="password" class="form-control" name="password" required />
	</div>
	<input type="submit" value="Create" />
</form>
<?php
require INCLUDE_PATH . "inc.footer.php";