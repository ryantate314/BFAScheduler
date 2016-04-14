<?php

require_once "class.User.php";

class Session {
	
	private static $instance;
	
	private function __construct() {
		session_start();
	}
	
	/**
	 * @return Session
	 */
	public static function getInstance() {
		if (!self::$instance) {
			self::$instance = new Session();
		}
		return self::$instance;
	}
	
	public function loggedIn() {
		return isset($_SESSION["user"]) ? $_SESSION["user"] : false;
	}
	
	public function setCurrentUser(User $user) {
		$_SESSION["user"] = $user;
	}
	
	public function logOut() {
		unset($_SESSION["user"]);
	}
}