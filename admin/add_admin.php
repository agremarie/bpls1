<?php
	require '../config/initialize.inc';
	ajaxOnly();
	$session->check();

	if(isset($_POST) && !empty($_POST)) {
		$admin = new Admin($_POST);
		if($admin->save()) {
			echo json_encode(array(
				'status' => true,
				'message' => 'Admin added successfully.'
			));
			exit;
		}
		else {
			echo json_encode(array(
				'status' => false,
				'message' => 'Username already taken.'
			));
			exit;
		}
	}

	include '../templates/add_admin.inc';
?>