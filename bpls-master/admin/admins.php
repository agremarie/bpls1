<?php
	require '../config/initialize.inc';
	
	$session->check();
	ajaxOnly();

	$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
	$per_page = 10;
	$total_count = Admin::getTotalCount();
	$pagination = new Pagination($page, $per_page, $total_count);
	$admins = Admin::findAll($pagination);
	include '../templates/admins.inc';
?>