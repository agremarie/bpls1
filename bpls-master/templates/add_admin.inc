<div class="container">
	<h3>Add Admin</h3>
	<div class="col-md-4">
		<div id="message-pane"></div>
	</div>
	<form id="add-admin-form" action="add_admin.php" method="post">
		<span>Username:</span><br />
		<input type="text" name="username" class="form-control-sm" placeholder="Username" required="">
		<br />
		<span>Password:</span><br />
		<input type="password" name="password" class="form-control-sm" placeholder="Password" required="">
		<br />
		<input id="add-admin-submit" type="submit" class="btn btn-success btn-sm" value="Add">
	</form>
	<?php include '../templates/spinner.inc'; ?>
</div>
<script type="text/javascript">
	doc.ready(() => {
		doc.on('click', '#add-admin-submit', e => {
			disableLink(e);
			toggleSpinner(true);
			const form = $('#add-admin-form');
			const form_data = form.serialize();
			$.post(form.attr('action'), form_data, result => {
				toggleSpinner(false);
				const json = JSON.parse(result);
				if(json.status) {
					$.get('admins.php', result => {
						container.loadHTML(result);
						setTimeout(() => {
							message(json.message, 'success');
						}, 400);
					});
				}
				else {
					message(json.message, 'danger');
				}
			});
		});
	});
</script>