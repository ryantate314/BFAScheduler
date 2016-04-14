<?php

require_once "Setup.php";

require_once INCLUDE_PATH . "class.Database.php";

$database = Database::getInstance();
$workers = $database->getWorkers();

require INCLUDE_PATH . "inc.header.php";
?>
<h1>BFA Stage Crew and Recording Workers</h1>
<?php if ($workers): ?>
<?php foreach ($workers as $worker): ?>
<div class="row">
	<div class="col-md-1">
		<p><?php echo $worker["workerNumber"]; ?></p>
	</div>
	<div class="col-md-2">
		<p><?php echo $worker["name"]; ?></p>
	</div>
	<div class="col-md-3">
		<p><?php echo $worker["email_address"]; ?></p>
	</div>
	<div class="col-md-1">
		<p><?php echo $worker["phone_number"]; ?></p>
	</div>
	<div class="col-md-1">
		<a href="deleteWorker.php?id=<?php echo $worker["id"]; ?>">Delete</a>
	</div>
</div>
<?php endforeach; ?>
<?php else: ?>
<h2>No workers found.</h2>
<?php endif; ?>
<a href="addWorker.php">Add Worker</a>
<?php
require INCLUDE_PATH . "inc.footer.php";