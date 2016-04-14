<?php

class SafeException extends Exception {
	public $description;
	
	public function __construct($message, $description, $code=0, $previous=null) {
		$this->description = $description;
		parent::__construct($message, $code, $previous);
	}
}

class WorkerNotFoundException extends SafeException {
	public $worker;
	
	public function __construct($worker, $description="") {
		$this->worker = $worker;
		$message = "Could not find worker '$worker'.";
		parent::__construct($message, $description);
	}
}

class InvalidInputException extends SafeException {
	public function __construct($message, $description, $code = 0, $previous = null) {
		parent::__construct($message, $description, $code, $previous);
	}
}

class MysqlException extends SafeException {
	public function __construct($message, $description, $code = 0, $previous = null) {
		parent::__construct($message, $description, $code, $previous);
	}
}