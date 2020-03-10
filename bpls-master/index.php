<?php
	require 'config/initialize.inc';

	$header = new Header(array(
		'title' => 'Home',
		'styles' => array(
			'index'
		),
		'scripts' => array(
			'index'
		)
	));
	
	checkPermitExpiry();

	include 'templates/header.inc';
	include 'templates/index.inc';
	include 'templates/footer.inc';
?>