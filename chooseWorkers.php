<?php

require_once "Setup.php";
require_once INCLUDE_PATH . "class.URLManager.php";

//Make sure the user is logged in
$session = Session::getInstance();
if (!($user = $session->loggedIn())){
	URLManager::loginRedirect();
}

if (!isset($_REQUEST["id"])) {
	header("Location: index.php");
	exit;
}
$eventId = $_REQUEST["id"];
$database = Database::getInstance();
try {
	$event = $database->getEvent($eventId);
	if (!$event) {
		$pageErrors[] = "Could not find event with id '$eventId'.";
	}
}
catch (InvalidArgumentException $ex) {
	$pageErrors[] = $ex->getMessage();
}

if ($pageErrors) {
	require INCLUDE_PATH . "inc.header.php";
	require INCLUDE_PATH . "inc.error.php";
	require INCLUDE_PATH . "inc.footer.php";
	exit;
}

$positiosn = 


if ($_POST) {
	
}


require INCLUDE_PATH . "inc.header.php";
?>
<h1>Choose Workers</h1>
<h2></h2>
<form method="POST">
	<div class="form-group">
		
	</div>
</form>
<?php
require INCLUDE_PATH . "inc.footer.php";