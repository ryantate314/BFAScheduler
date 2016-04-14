<?php

require_once "Setup.php";
require_once INCLUDE_PATH . "class.Database.php";
require_once INCLUDE_PATH . "class.EventSearch.php";

/* PHP DateInterval constructor string */
$DEFAULT_DISPLAY_INTERVAL = "P1M";

$database = Database::getInstance();

$errors = array();

$start_date = new DateTime();
if (isset($_REQUEST["start_date"]) && $_REQUEST["start_date"]) {
	try {
		$start_date = new DateTime($_REQUEST["start_date"]);
	} catch (Exception $ex) {
		$errors[] = "Invalid start date: '$_REQUEST[start_date]'.";
	}
}
$end_date = new DateTime();
if (isset($_REQUEST["end_date"]) && $_REQUEST["end_date"]) {
	try {
		$end_date = new DateTime($_REQUEST["end_date"]);
	} catch (Exception $ex) {
		$errors[] = "Invalid end date: '$_REQUEST[end_date]'.";
	}
}
else {
	$end_date = clone $start_date;
	$end_date->add(new DateInterval($DEFAULT_DISPLAY_INTERVAL));
}

if (!$errors) {
	try {
		$search = new EventSearch($database);
		$search->setDateRange($start_date, $end_date);
		$events = $search->search();
		echo json_encode($events);
		exit;
	}
	catch (MysqlException $ex) {
		$errors[] = $ex->getMessage();
	}
}

echo json_encode(array("errors" => $errors));
