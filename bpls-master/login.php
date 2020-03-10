<?php
	require 'config/initialize.inc';
	ajaxOnly();

	if(isset($_POST) && !empty($_POST)) {
		$user = new User($_POST);
		if($user->authenticate()) {
			$session->message('Logged in successfully.');
			$session->login($user);
			echo json_encode(array(
				'status' => true,
				'data' => $user
			));
			exit;
		}
		else {
			$msg = '';
			foreach($user->messages as $message) {
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
	<h4>Login</h4>
	<p class="lead">
		Please fill the form below.
	</p>
	<hr class="my-2">
	<div id="message-pane"></div>
	<div class="lead">
		<div class="container-fluid">
			<form id="login-form" action="login.php" method="post">
				<span>Username:</span><br />
				<input type="text" name="username" class="form-control-sm" placeholder="Username" required="">
				<br />
				<span>Password:</span><br />
				<input type="password" name="password" class="form-control-sm" placeholder="Password" required="">
				<br />
				<input id="login-btn" type="submit" class="btn btn-success btn-sm" value="Login">
			</form>
			<?php include 'templates/spinner.inc'; ?>
		</div>
		<hr />
		<a id="register-switch-btn" class="text-light" href="register.php">
			Don't have an account yet? Register.
		</a>
	</div>
</div>
<script type="text/javascript">
	$(document).ready(() => {
		$(document).on('click', '#register-switch-btn', function(e) {
			disableLink(e);
			$.get($(this).attr('href'), result => {
				container.loadHTML(result);
			});
		});

		$(document).on('click', '#login-btn', e => {
			disableLink(e);
			toggleSpinner(true);
			const form = $('#login-form');
			const form_data = form.serialize();
			$.post(form.attr('action'), form_data, result => {
				toggleSpinner(false);
				const json = JSON.parse(result);
				if(json.status) {
					switch(json.data.access_level) {
						case 1:
							window.location.href = 'user';
							break;
						case 2:
							window.location.href = 'admin';
							break;
					}
				}
				else {
					message(json.message, 'danger');
				}
			});
		});
	});
</script>