<?php
	defined('DS') ? null : define('DS', DIRECTORY_SEPARATOR);

	$config = array(
		'db' => array(
			'dsn' => 'mysql:host=localhost;dbname=bpls',
			'host' => '',
			'username' => 'root',
			'password' => '',
			'dbname' => '',
			'driver' => ''
		),
		'title' => array(
			'abbv' => 'BPLS',
			'full' => 'Business Permit and Licensing System'
		),
		'authors' => array(
			'John Michael Manlupig'
		),
		'environment' => 'Development'
	);

	$config['environment'] = $config['environment'] == 'Development' ? DS.strtolower($config['title']['abbv']) : null;

	date_default_timezone_set('Asia/Manila');

	$site_root = protocol().':'.DS.DS.$_SERVER['HTTP_HOST'];
	defined('SITE_ROOT') ? null : define('SITE_ROOT', $site_root.$config['environment']);
?>