<?php

require_once "Setup.php";
require_once INCLUDE_PATH . "class.Session.php";

$session = Session::getInstance();
$session->logOut();
header("Location: index.php");
exit;