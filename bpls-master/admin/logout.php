<?php
	require '../config/initialize.inc';

	$session->checkAdmin();
	$session->logout('You have logged out.');
	redirect('../index.php');
?>