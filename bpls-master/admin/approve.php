<?php
	require '../config/initialize.inc';

	$session->checkAdmin();

	$id = isset($_GET['id']) ? (int)$_GET['id'] : redirect('index.php');
	$params = array(
		'approved' => 1
	);

	$ids = array('id' => $id);

	if($db->update('permit_requests', $params, $ids)) {
		$params = array(
			'has_permit' => 1
		);
		$permit = $db->search('permit_requests', $ids, 'fetch')[0];
		$business = $db->search('businesses', array('id' => $permit['business_id']), 'fetch')[0];
		if($db->update('businesses', $params, array('id' => $business['id']))) {
			$params = array(
				'permit_id' => $permit['id'],
				'start_date' => date('Y/m/d'),
				'end_date' => date('Y/m/d', strtotime('+1 year'))
			);
			$db->insert('expiry', $params);
			$session->message('Permit request approved successfully.', 'success');
			redirect('index.php');
		}
	}
?>