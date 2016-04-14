<?php

class Crypto {

	public static function hash($clearText) {
		return password_hash($clearText, PASSWORD_DEFAULT);
	}
	
	public static function password_verify($password, $hash) {
		return password_verify($password, $hash);
	}
}