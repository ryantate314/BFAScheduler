<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

require_once INCLUDE_PATH . "class.Session.php";

$pageTitle = isset($pageTitle) ? $pageTitle : APPLICATION_NAME;
$session = Session::getInstance();
?>
<!DOCTYPE html>
<html>
	<head>
		<title><?php echo $pageTitle; ?></title>
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
		<?php
			if (isset($extraStyles)) {
				foreach ($extraStyles as $style) {
					echo "<link rel='stylesheet' href='$style' />\r\n";
				}
			}
		?>
		<link rel="stylesheet" href="css/main.css" />
	</head>
	<body>
		<nav class="navbar navbar-default">
			<div class="container-fluid">
				<div class="navbar-header">
					<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse" aria-expanded="false">
						<span class="sr-only">Toggle navigation</span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
					<a class="navbar-brand" href="index.php"><?php echo APPLICATION_NAME; ?></a>
				</div><!--navbar-header-->
				<div class="collapse navbar-collapse" id="navbar-collapse">
					<ul class="nav navbar-nav">
						<li><a href="createEvent.php">Create Event</a></li>
						<li><a href="workers.php">Workers</a></li>
					</ul>
					<ul class="nav navbar-nav navbar-right">
						<?php if ($session->loggedin()): ?>
						<li><a href="logout.php">Logout</a></li>
						<?php else: ?>
						<li><a href="login.php">Log In</a></li>
						<?php endif; ?>
					</ul>
				</div>
			</div>
		</nav>
		<div class="container">
<?php
if (isset($successMessages) && $successMessages) {
	foreach ($successMessages as $message) {
		echo "<p class='alert alert-success'>$message</p>";
	}
}
if (isset($errors) && $errors) {
	foreach ($errors as $error) {
		echo "<p class='alert alert-danger'>$error</p>";
	}
}
?>