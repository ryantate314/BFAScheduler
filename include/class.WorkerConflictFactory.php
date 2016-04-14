<?php

require_once "class.DayOfWeekConflict.php";

class WorkerConflictFactory {
	public static function buildConflict(string $type, array $fields) {
		if ($type === "DayOfWeek") {
			return self::_buildDayOfWeekConflict($fields);
		}
	}
	
	private static function _buildDayOfWeekConflict($fields) {
		$conflict = new DayOfWeekConflict();
		
		$conflict->dayOfWeek = $fields["dayOfWeek"];
		$conflict->startTime = $fields["startTime"];
		$conflict->endTime = $fields["endTime"];
		return $conflict;
	}
}