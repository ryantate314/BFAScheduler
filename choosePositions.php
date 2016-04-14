<?php

require_once "Setup.php";
require_once INCLUDE_PATH . "class.URLManager.php";

//Make sure the user is logged in
$session = Session::getInstance();
if (!($user = $session->loggedIn())){
	URLManager::loginRedirect();
}

require_once INCLUDE_PATH . "class.Database.php";

if (!isset($_REQUEST["id"])) {
	header("Location: index.php");
	exit;
}

$pageErrors = [];

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

$allPositions = $database->getPositions();
$eventPositions = $database->getPositions($eventId);
$workers = $database->getWorkers();


if ($_POST) {
	
}

function createSelect($name, $options, $displayField, $valueField, $classes=[]) {
	$output = "<select name='$name' class='";
	$output .= implode(" ", $classes);
	$output .= "'>";
	foreach ($options as $option) {
		$output .= "<option value='" . $option[$valueField] . "'>" . $option[$displayField] . "</option>\r\n";
	}
	$output .= "</select>";
	return $output;
}


require INCLUDE_PATH . "inc.header.php";
?>
<h1>Choose Workers for <?php echo $event["title"]; ?></h1>
<form method="POST">
	<h2>Worker Positions</h2>
	<?php foreach ($eventPositions as $position) : ?>
		<div class="form-group">
			<label for="<?php echo $position->name; ?>_position">Position Type:</label>
			<input type="text" id="<?php echo $position->name; ?>_position" class="form-control" name="position[]" value="<?php $position->name; ?>" />
		</div>
		<div class="form-group">
			<label for="<?php echo $position->name; ?>_estimatedHours">Estimated Hours:</label>
			<input type="number" id="<?php echo $position->name; ?>_estimatedHours" name="estimatedHours[]" value="<?php $position->estimatedHours; ?>" />
		</div>
	<div class="row">
		<div class="col-sm-offset-1">
			<h3>Workers</h3>
			<?php foreach ($position["workers"] as $worker) : ?>
				<div class="form-group">
					<label for="<?php echo "$position[name]_$worker[id]_worker"; ?>">Worker:</label>
					<?php echo createSelect("$position[name]_$worker[id]_worker", $workers, "name", "id", ["form-control"]); ?>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
	<?php endforeach; ?>
</form>
<?php
require INCLUDE_PATH . "inc.footer.php";