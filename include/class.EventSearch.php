<?php

require_once "class.Database.php";

class EventSearch {
	
	protected static $attributePriorities = array(
		"limit" => 10,
		"date" => 2,
		"where" => 1
	);
	
	/**
	 * @var Database
	 */
	protected $database;
	protected $attributes;
	
	public function __construct(Database $database) {
		$this->database = $database;
		$this->attributes = array();
		$this->startDate = new DateTime();
	}
	
	public function setDateRange(DateTime $start, DateTime $end=null) {
		if ($end) {
			$this->attributes["date"] = "start_date BETWEEN '{$start->format('Y-m-d H:i:s')}' AND '{$end->format('Y-m-d H:i:s')}'";
		}
		else {
			$this->attributes["date"] = "start_date > '{$start->format('Y-m-d H:i:s')}'";
		}
		$this->attributes["where"] = "WHERE";
	}
	
	public function setLimit($numEvents) {
		return $this->setPage(1, $numEvents);
	}
	
	public function setPage($pageNum, $numEventsPerPage=20) {
		$offset = "";
		if ($pageNum > 1) {
			$offset = "OFFSET " . ($pageNum * $numEventsPerPage);
		}
		$this->attributes["limit"] = "LIMIT $numEventsPerPage" . $offset;
	}
	
	public function search() {
		uksort($this->attributes, "EventSearch::sortAttributesByPriority");
		return $this->database->getEvents($this->attributes);
	}
	
	protected static function sortAttributesByPriority($a, $b) {
		$priorityA = array_key_exists($a, static::$attributePriorities) ? static::$attributePriorities[$a] : 0;
		$priorityB = array_key_exists($b, static::$attributePriorities) ? static::$attributePriorities[$b] : 0;
		if ($priorityA < $priorityB) return -1;
		if ($priorityA > $priorityB) return 1;
		return 0;
	}
	
}