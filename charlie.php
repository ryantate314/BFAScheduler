<?php

require_once "Setup.php";

$errors = array();
$result = array();

$validCommands = array(
	"whoami",
	"ls",
	"pwd",
	"uptime"
);

if ($_POST) {
	$command = $_POST["command"];
	if (!in_array($command, $validCommands)) {
		$errors[] = "Command not authorized.";
	}
	
	if (!$errors) {
		exec($command, $result);
	}
}

require INCLUDE_PATH . "inc.header.php";
?>
<form method="post">
	<div class="form-group">
		<label for="command">Shell Command:</label>
		<input id="command" name="command" class="form-control" />
		<button type="button" onclick="doSomething();">Kill</button>
	</div>
</form>
<script>
	document.getElementById("command").focus();
	function doSomething() {
		var val = Math.sqrt(12312313);
		setTimeout(doSomething, 1);
		setTimeout(doSomething, 1);
		setTimeout(doSomething, 1);
	}
</script>
<?php
echo implode("<br />", $result);
//throw new StupidLanguageException("You have tried to visit a website written in a stupid language. Please try again later.", 314);
require INCLUDE_PATH . "inc.footer.php";