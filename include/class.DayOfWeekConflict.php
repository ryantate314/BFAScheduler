<?php

require_once "class.WorkerConflict.php";

class DayOfWeekConflict extends WorkerConflict {
	
	//Three Letter Abreviation
	public $dayOfWeek;
	
	public $startTime;
	public $endTime;
}