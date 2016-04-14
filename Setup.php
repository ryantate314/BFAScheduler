<?php

ini_set("display_errors", 1);
error_reporting(E_ALL);


define("APPLICATION_NAME", "BFA Scheduler");

$include = __DIR__ . DIRECTORY_SEPARATOR . "include" . DIRECTORY_SEPARATOR;
define("INCLUDE_PATH", $include);
unset($include);

include_once INCLUDE_PATH . "class.Session.php";