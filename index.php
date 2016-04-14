<?php

require_once "Setup.php";
require_once INCLUDE_PATH . "class.Database.php";
require_once INCLUDE_PATH . "class.EventSearch.php";

//See if the user is logged in
$loggedIn = false;
$session = Session::getInstance();
if ($user = $session->loggedIn()){
	$loggedIn = true;
}

$database = Database::getInstance();
$search = new EventSearch($database);
$search->setLimit(20);
$startDate = new DateTime();
$startDate->setTimestamp(strtotime('today midnight'));
$search->setDateRange($startDate);

try {
$events = $search->search();
}
catch (Exception $ex) {
	print_r($ex);
}

$pageTitle = APPLICATION_NAME . " - Home";

require INCLUDE_PATH . "inc.header.php";
?>
<?php if ($events): ?>
<h1>Upcoming Events</h1>
<table class="table table-striped table-bordered">
	<?php foreach($events as $event): ?>
	<tr>
		<td><?php echo $event["start_date"]->format("D"); ?></td>
		<td><?php echo $event["start_date"]->format("M j"); ?></td>
		<td><?php echo $event["start_date"]->format("ga"); ?></td>
		<td><?php echo $event["title"]; ?></td>
		<?php
			if ($event["workerPositions"]) {
				foreach ($event["workerPositions"] as $position) {
					echo "<td>";
					foreach ($position["workers"] as $worker) {
						echo $worker["workerNumber"];
					}
					echo "</td>";
				}
			}
			else {
				echo "<td>TBA</td>";
			}
		?>
		<?php if ($loggedIn): ?>
		<td class="col-sm-1">
			<a href="editEvent.php?id=<?php echo $event["id"]; ?>">Edit</a>
		</td>
		<?php endif; ?>
	</tr>
	<?php endforeach; ?>
</table>
<?php else: ?>
<h2>No upcoming events</h2>
<?php endif; ?>
<a href="events.php">All events</a>
<?php
require INCLUDE_PATH . "inc.footer.php";