<?php

require_once INCLUDE_PATH . "class.Crypto.php";

class UserValidation {
	public static function validateUser(User $user, $password) {
		return Crypto::password_verify($password, $user->password);
	}
}