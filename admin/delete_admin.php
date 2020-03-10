<?php
	require '../config/initialize.inc';

	$session->checkAdmin();
	ajaxOnly();

	$id = isset($_GET['id']) ? (int)$_GET['id'] : null;

	if(!$id) {
		exit;
	}

	$params = array(
		'id' => $id,
		'access_level' => Admin::LEVEL
	);

	if($db->delete('users', $params)) {
		echo json_encode(array(
			'status' => true,
			'message' => 'Admin deleted successfully.'
		));
		exit;
	}
?>