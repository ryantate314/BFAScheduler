<div class="error-box">
<h1><?php echo APPLICATION_NAME; ?> encountered an error.</h1>
<?php
if (isset($pageErrors) && $pageErrors) {
	foreach ($pageErrors as $error) {
		echo "<p class='alert alert-danger'>$error</p>";
	}
}
else {
	echo "<p>The application encountered an unknown error.</p>";
}
?>
<button type="button" class="btn btn-link" onclick="window.history.back();">Back</button>
</div>