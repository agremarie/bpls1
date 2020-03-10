<?php
	require 'config/initialize.inc';
	ajaxOnly();

	if(isset($_POST) && !empty($_POST)) {
		$user = array(
			'first_name' => $_POST['first_name'],
			'last_name' => $_POST['last_name'],
			'address' => $_POST['address'],
			'contact_number' => $_POST['contact_number'],
			'username' => $_POST['username'],
			'password' => $_POST['password'],
			'email' => $_POST['email'],
			'access_level' => Applicant::LEVEL
		);
		$applicant = new Applicant($user);
		if($applicant->save()) {
			$business = array(
				'name' => $_POST['business_name'],
				'address' => $_POST['business_address'],
				'user_id' => $applicant->id
			);
			$business = new Business($business);
			if($business->save()) {
				$session->login($applicant);
				$session->message('Logged in successfully.', 'success');
				echo json_encode(array(
					'status' => true
				));
				exit;
			}
		}
		else {
			$msg = '';
			foreach($applicant->messages as $message) {
				$msg .= $message.'<br />';
			}
			echo json_encode(array(
				'status' => false,
				'message' => $msg
			));
			exit;
		}
	}
?>
<div class="jumbotron bg-primary">
	<h1 class="display-3"><?=$config['title']['full']?></h1>
	<h4>Register</h4>
	<p class="lead">
		Please fill the form below.
	</p>
	<hr class="my-2">
	<div id="message-pane"></div>
	<div class="lead">
		<div class="container-fluid">
			<form id="register-form" class="row" action="register.php" method="post">
				<div class="col-md-4 border-right">
					<span>First Name:</span><br />
					<input type="text" name="first_name" placeholder="First Name" class="form-control-sm" required="">
					<br />
					<span>Last Name:</span><br />
					<input type="text" name="last_name" placeholder="Last Name" class="form-control-sm" required="">
					<br />
					<span>Address:</span><br />
					<input type="text" name="address" placeholder="Address" class="form-control-sm" required="">
					<br />
					<span>Contact Number:</span><br />
					<input type="text" name="contact_number" placeholder="Contact Number" class="form-control-sm" required="">
					<br />
					<input id="register-btn" type="submit" class="btn btn-warning text-light btn-sm" value="Register">
				</div>
				<div class="col-md-4 border-right">
					<span>Username:</span><br />
					<input type="text" name="username" placeholder="Username" class="form-control-sm" required="">
					<br />
					<span>Password:</span><br />
					<input type="password" name="password" placeholder="Password" class="form-control-sm" required="">
					<br />
					<span>Email (optional):</span><br />
					<input type="email" name="email" placeholder="Email" class="form-control-sm">
					
				</div>
				<div class="col-md-4">
					<span>Business Name:</span><br />
					<input type="text" name="business_name" placeholder="Business Name" class="form-control-sm" required="">
					<br />
					<span>Business Address:</span><br />
					<input type="text" name="business_address" placeholder="Business Address" class="form-control-sm" required="">
					<br />
				</div>
			</form>
			<?php include 'templates/spinner.inc'; ?>
			<hr />
		</div>
		<a id="login-switch-btn" class="text-light" href="login.php">
			Already have an account? Login.
		</a>
	</div>
</div>
<script type="text/javascript">
	$(document).ready(() => {
		$(document).on('click', '#register-btn', e => {
			disableLink(e);
			toggleSpinner(true);
			const form = $('#register-form');
			const form_data = form.serialize();
			$.post(form.attr('action'), form_data, result => {
				toggleSpinner(false);
				console.log(result);
				const json = JSON.parse(result);
				if(json.status) {
					window.location.href = 'user'
				}
				else {
					message(json.message);
				}
			});
		});

		$(document).on('click', '#login-switch-btn', function(e) {
			disableLink(e);
			$.get($(this).attr('href'), result => {
				container.loadHTML(result);
			});
		});
	});
</script>