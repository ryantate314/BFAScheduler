<?php

require_once "Setup.php";

header("Location: login.php");
exit;

$errors = [];

if ($_POST) {
	require_once INCLUDE_PATH . "class.Database.php";
	require_once INCLUDE_PATH . "class.Crypto.php";
	require_once INCLUDE_PATH . "class.InputValidator.php";
	
	if (!InputValidator::validateEmail($_POST["email_address"])) {
		$errors[] = "Invalid email address.";
	}
	if (!InputValidator::validatePassword($_POST["password"])) {
		$errors[] = "Password does not meet requirements.";
	}
	
	if (!$errors) {
		$hashedPassword = Crypto::hash($_POST["password"]);
		$_POST["password"] = $hashedPassword;
		
		$database = Database::getInstance();
		
		if ($database->getUser($_POST["email_address"])) {
			$errors[] = "A user already exists with username '$_POST[email_address]'.";
		}
		else {
			try {
				$user = $database->createUser($_POST);
				header("Location: login.php");
				exit;
			} catch (Exception $ex) {
				$errors[] = $ex->getMessage();
			}
		}
	}//End if no validation errors
}//End if POST

$pageTitle = APPLICATION_NAME . " - Add User";
require INCLUDE_PATH . "inc.header.php";
?>
<h1>Create New User</h1>
<form method="post" autocomplete="off">
	<div class="form-group">
		<label for="email_address">Email Address:</label>
		<input type="email" class="form-control" id="email_address" name="email_address" required <?php if ($_POST) echo "value='{$_POST["email_address"]}'";?> />
	</div>
	<div class="form-group">
		<label for="password">Password:</label>
		<input type="password" class="form-control" id="password" name="password" required />
	</div>
	<input type="Submit" class="btn btn-default" value="Create" />
</form>
<?php
require INCLUDE_PATH . "inc.footer.php";