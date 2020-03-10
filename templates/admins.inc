<div class="container">
	<h3>Admins</h3>
	<p>
		<a id="add-admin-btn" class="btn btn-info btn-sm" href="add_admin.php">
			Add
		</a>
	</p>
	<div class="col-md-4">
		<div id="message-pane"></div>
	</div>
	<?php if($admins) { ?>
		<table class="table">
			<thead>
				<tr>
					<th>ID</th>
					<th>Username</th>
					<th>Actions</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach($admins as $admin) { ?>
					<tr>
						<td><?=$admin->id?></td>
						<td><?=htmlentities($admin->username)?></td>
						<td>
							<a id="delete-admin-btn" class="btn btn-danger btn-sm" href="delete_admin.php?id=<?=$admin->id?>">
								Delete
							</a>
						</td>
					</tr>
				<?php } ?>
			</tbody>
		</table>
	<?php } else {
		echo 'There are no admins aside from you.';
	} ?>
	<?php include '../templates/spinner.inc'; ?>
</div>
<script type="text/javascript">
	doc.ready(() => {
		doc.on('click', '#add-admin-btn', function(e) {
			disableLink(e);
			toggleSpinner(true);
			$.get($(this).attr('href'), result => {
				container.loadHTML(result);
			});
		});
		doc.on('click', '#delete-admin-btn', function(e) {
			disableLink(e);
			if(confirm('Are you sure?')) {
				toggleSpinner(true);
				$.get($(this).attr('href'), result => {
					const json = JSON.parse(result);
					if(json.status) {
						$.get('admins.php', result => {
							container.loadHTML(result);
							setTimeout(function() {
								message(json.message, 'success');
							},400);
						});
					}
				});
			}
		});
	});
</script>