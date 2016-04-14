<?php

class InputValidator {
	public static function validateFirstName($firstName) {
		return preg_match("/^[A-Za-z]{1,32}$/", $firstName);
	}
	public static function validateLastName($lastName) {
		return self::validateFirstName($lastName);
	}
	public static function validateName($name) {
		return preg_match("/^[A-Za-z]{1,32}\s[A-Za-z]{1,32}$/", $name);
	}
	public static function validateEmail($emailAddress) {
		$valid = filter_var($emailAddress, FILTER_VALIDATE_EMAIL) !== false;
		$valid = $valid && strlen($valid) < 128;
		return $valid;
	}
	public static function validatePhoneNumber($phoneNumber) {
		$phoneNumber = preg_replace('/[^0-9]+/i', '_', $phoneNumber); 
		return preg_match("/^[0-9]{10}$/", $phoneNumber);
	}
	public static function validatePassword($password) {
		return preg_match("/^.{8,64}$/", $password);
	}
	public static function validateEventTitle($title) {
		return preg_match("/^.{8,128}$/", $title);
	}
}
