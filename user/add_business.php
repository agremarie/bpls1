<?php
	require '../config/initialize.inc';

	$session->checkApplicant();

	if(isset($_POST) && !empty($_POST)) {
		$_POST['user_id'] = $_SESSION['user_id'];
		$business = new Business($_POST);
		if($business->save()) {
			$session->message('Business added successfully.');
			redirect('index.php');
		}
	}

	ajaxOnly();


?>
<div class="container">
	<br />
	<h2>Add Business</h2>
	<form action="add_business.php" method="post">
		<span>Name:</span><br />
		<input type="text" name="name" placeholder="Name" class="form-control-sm" required=""><br />
		<span>Address:</span><br />
		<input type="text" name="address" placeholder="Address" class="form-control-sm" required=""><br />
		<br />
		<input type="submit" class="btn btn-success btn-sm" value="Add">
	</form>
</div>