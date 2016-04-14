<?php

class URLManager {
	public static function currentUrl() {
		return "$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
	}
	public static function loginRedirect() {
		$currentPage = self::currentUrl();
		$location = "login.php?redirect=" . urlencode("http://" . $currentPage);
		header("Location: $location");
		exit;
	}
}