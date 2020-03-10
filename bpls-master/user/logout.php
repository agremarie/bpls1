<?php
	require '../config/initialize.inc';

	$session->checkApplicant();
	$session->logout('You have logged out.');
	redirect('../index.php');
?>