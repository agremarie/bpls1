<?php
	function redirect($location) {
		header('Location: '.$location);
		exit;
	}

	function __autoload($class_name) {
		require_once 'class.'.$class_name.'.inc';
	}

	function ajax() {
		return isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest';
	}

	function protocol() {
		$protocol='http';
		if (isset($_SERVER['HTTPS']) && strtoupper($_SERVER['HTTPS']) == 'ON') {
	  		$protocol='https';
		}
		return $protocol;
	}

	function ajaxOnly() {
		if(!ajax()) {
			redirect(SITE_ROOT.DS.'index.php');
		}
	}

	function checkPermitExpiry() {
		global $db;
		$permits = $db->search('permit_requests', array('approved' => 1), 'fetch');
		if($permits) {
			foreach($permits as $permit) {
				$expiry = $db->search('expiry', array('permit_id' => $permit['id']), 'fetch')[0];
				$start = strtotime('now');
				$end = strtotime($expiry['end_date']);
				if($start > $end) {
					$db->update('permit_requests', array('approved' => Permit::EXPIRED), array('id' => $permit['id']));
					$db->update('businesses', array('has_permit' => 0), array('id' => $permit['business_id']));
					$db->delete('expiry', array('permit_id' => $expiry['permit_id']));
				}
			}
		}
	}
?>