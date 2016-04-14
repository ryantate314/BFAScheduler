<?php

require_once "class.Worker.php";
require_once "class.WorkerConflictFactory.php";
require_once "class.User.php";
require_once "class.Event.php";
require_once "Exceptions.php";

class Database {
	private static $instance;
	
	protected $connection;
	
	private function __construct() {
		$user = "bfa_schedule";
		$pass = "CultureClub314";
		$host = "localhost";
		$db   = "bfa_schedule";
		$this->connection = new mysqli($host, $user, $pass, $db);
		if (!$this->connection) {
			throw new Exception("Could not connect to database.");
		}
	}
	
	/**
	 * @return Database
	 */
	public static function getInstance() {
		if (!self::$instance) {
			self::$instance = new Database();
		}
		return self::$instance;
	}
	
	protected function query($query) {
		$result = $this->connection->query($query);
		if ($result === false) {
			throw new MysqlException("Error executing sql query.", "Query: $query\r\n" . $this->connection->error);
		}
		return $result;
	}
	
	protected function getInsertID() {
		return $this->connection->insert_id;
	}
	
	public function getUser($email_address) {
		$saniEmail = $this->sani($email_address);
		$query = "SELECT * FROM user WHERE email_address = '$saniEmail';";
		
		$result = $this->query($query);
		$data = $result->fetch_assoc();
		if (!$data) return null;
		$user = new User();
		$user->email_address = $data["email_address"];
		$user->password = $data["password"];
		
		return $user;		
	}
	
	public function createUser($data) {
		$saniData = array();
		foreach ($data as $key => $value) {
			$saniData[$key] = $this->sani($value);
		}
		
		$query = 
"INSERT INTO user (email_address, password)
VALUES ('$saniData[email_address]', '$saniData[password]');";
		$this->query($query);
		
		return $this->getUser($data["email_address"]);
	}
	
	public function getWorkers() {
		$query = 
"SELECT * FROM worker
ORDER BY workerNumber;";
		$result = $this->query($query);
		return $this->mysqlResultToArray($result);
	}
	
	public function getWorker($id) {
		$query = "SELECT * FROM worker WHERE id = $id;";
		$result = $this->query($query);
		$fields = $result->fetch_assoc();
		if (!$fields) throw new WorkerNotFoundException($id);
		
		return $fields;
	}
	
	public function createWorker($data) {
		$saniData = array();
		foreach ($data as $key => $value) {
			$saniData[$key] = $this->sani($value);
		}
		
		$query = 
"INSERT INTO worker (workerNumber, name, email_address, phone_number)
VALUES  ('$saniData[workerNumber]', '$saniData[name]', '$saniData[email_address]', '$saniData[phone_number]');";
		$this->query($query);
		
		$id = $this->getInsertID();
		return $this->getWorker($id);
	}
	
	public function updateWorker($data) {
		$saniName = $this->sani($data["name"]);
		$saniEmail    = $this->sani($data["email_address"]);
		$saniPhone    = $this->sani($data["phone_number"]);
		
		$query = 
"UPDATE worker SET first_name = '$saniName',
				   email_address = '$saniEmail',
				   phone_number  = '$saniPhone';";
		$this->query($query);
	}
	
	public function getEvent($id) {
		if (!is_numeric($id)) throw new InvalidArgumentException("Invalid event id '$id'.");
		
		$query = "SELECT * FROM event WHERE id = $id;";
		$result = $this->query($query);
		if (!$result) {
			return null;
		}
		
		$row = $result->fetch_assoc();
		if (!$row) return null;
		$row["start_date"] = new DateTime($row["start_date"]);
		
		/*$event = new Event();
		$event->id = $row["id"];
		$event->title = $row["title"];
		$event->start_date = new DateTime($row["start_date"]);
		$event->end_date = new DateTime($row["end_date"]);
		$event->worker_hours = $row["worker_hours"];
		$event->description = $row["description"];*/
		return $row;
	}
	
	public function getEvents($conditions=[]) {
		$query = 
"SELECT * FROM event
";
		foreach ($conditions as $condition) {
			if (stristr($condition, ';')) {
				throw new Exception("SQL Injection attempt. This action will be reported.");
			}
			$query .= $condition . "\r\n";
		}
		$query .= ";";
		
//		echo $query;
//		echo "<br />";
		
		//Cast the mysqlresult to an array
		$result = $this->query($query);
		$output = array();
		foreach ($result as $row) {
			$row["start_date"] = new DateTime($row["start_date"]);
			$row["workerPositions"] = $this->getPositions($row["id"]);
			$output[] = $row;
		}
		
		return $output;
		//return $this->mysqlResultToArray($result);
	}
	
	public function createEvent($data) {
		$title = $this->sani($data["title"]);
		$start_date = $data["start_date"]->format('Y-m-d G:i:s');
		$description = $this->sani($data["description"]);
		
		$query =
"INSERT INTO event (title, start_date, description)
VALUES ('$title', '$start_date', '$description');";
		
		$this->query($query);
		return $this->getEvent($this->getInsertID());
	}
	
	public function updateEvent($data) {
		$query = "UPDATE event SET ";
		foreach ($data as $key => $value) {
			$query .= "$key='" . $this->sani($value) . "', ";
		}
		$query = substr($query, 0, strlen($query) - 2);
		$query .= "WHERE id=$data[id];";
		$this->query($query);
	}
	
	public function getPositions($eventId = null) {
		if ($eventId) {
			return $this->_getPositionsForEvent($eventId);
		}
		$query = "SELECT * FROM workerPosition;";
		$result = $this->query($query);
		return $this->mysqlResultToArray($result);
	}
	
	protected function _getPositionsForEvent($eventId) {
		if (!is_numeric($eventId)) {
			throw new InvalidArgumentException("Invalid value for eventId");
		}
		$query = 
"SELECT * FROM eventWorkerPosition
JOIN event ON event.id = event_id
WHERE event_id = $eventId;";
		$result = $this->query($query);
		
		$output = array();
		foreach ($result as $row) {
			$position = $row;
			$position["workers"] = $this->_getWorkersForPosition($eventId, $position["name"]);
			$output[] = $position;
		}
		return $output;
	}
	
	protected function _getWorkersForPosition($eventId, $positionName) {
		$saniPositionName = $this->sani($positionName);
		
		if (!is_numeric($eventId)) {
			throw new InvalidArgumentException();
		}
		
		$query = 
"SELECT * FROM eventWorkerPosition AS ewp
JOIN worker ON worker.id = ewp.worker_id
WHERE eventId = $eventId
AND   name = '$saniPositionName';";
		
		$workerResult = $this->query($query);
		return $this->mysqlResultToArray($workerResult);
	}
	
	protected function mysqlResultToArray($mysqli_result) {
		$output = array();
		foreach ($mysqli_result as $row) {
			$output[] = $row;
		}
		return $output;
	}
	
	protected function sani($string) {
		if (is_numeric($string)) return $string;
		return $this->connection->real_escape_string($string);
	}
}