<?php

require_once "Setup.php";
require_once INCLUDE_PATH . "class.Session.php";

//Redirect the user away if they are already logged in.
$session = Session::getInstance();
if ($user = $session->loggedIn()) {
	if ($_GET["redirect"]) {
		header("Location: {$_GET["redirect"]}");
	}
	else {
		header("Location: index.php");
	}
	exit;
}

//Process POST request
if ($_POST) {
	require_once INCLUDE_PATH . "class.UserValidation.php";
	require_once INCLUDE_PATH . "class.Database.php";
	
	$database = Database::getInstance();
	$username = $_POST["username"];
	if (($user = $database->getUser($username)) &&
		(UserValidation::validateUser($user, $_POST["password"]))) {
		
		$session->setCurrentUser($user);
		
		if ($_GET["redirect"]) {
			header("Location: {$_GET["redirect"]}");
		}
		else {
			header("Location: index.php");
		}
		exit;
	}
	else {
		$errors[] = "Invalid username or password.";
	}
}//End if POST

$pageTitle = "Login - " . APPLICATION_NAME;

require INCLUDE_PATH . "inc.header.php";
?>
<h1>Login</h1>
<hr />
<form method="POST">
	<div class="form-group">
		<label for="username">Email:</label>
		<input type="email" id="username" name="username" class="form-control" required <?php if ($_POST) echo "value='{$_POST["username"]}'";?> />
	</div>
	<div class="form-group">
		<label for="password">Password:</label>
		<input type="password" id="password" name="password" class="form-control" />
	</div>
	<input type="submit" class="btn btn-default" value="Login" />
</form>