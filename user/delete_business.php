<?php
	require '../config/initialize.inc';

	$session->checkApplicant();

	$id = isset($_GET['id']) ? (int)$_GET['id'] : null;

	if(!$id) {
		redirect('index.php');
	}

	if($db->delete('businesses', array('id' => $id))) {
		$session->message('Business deleted successfully.');
		redirect('index.php');
	}
?>