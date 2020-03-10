<?php
	require '../config/initialize.inc';

	$session->checkAdmin();

	$header = new Header(array(
		'title' => 'Dashboard',
		'styles' => array(
			'admin.index'
		)
	));
	checkPermitExpiry();
?>
<?php if(!ajax()) { ?>
	<!DOCTYPE html>
	<html>
		<?=$header->setHead()?>
		<body>
			<?php include '../templates/navbar.inc'; ?>
			<div id="container">
				<div class="container">
					<?=$session->message()?>
				</div>
			</div>
		</body>
		<?=$header->loadScripts()?>
	</html>
<?php } else {

} ?>