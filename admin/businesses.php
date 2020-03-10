<?php
	require '../config/initialize.inc';

	$session->checkAdmin();
	ajaxOnly();

	$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
	$per_page = 10;
	$total_count = Business::getTotalCount();
	$pagination = new Pagination($page, $per_page, $total_count);

	$businesses = Business::findAll($pagination);
?>
<div class="container">
	<?php if($businesses) { ?>
		<h2>Businesses</h2>
		<table class="table table-sm table-hover">
			<thead>
				<tr>
					<th>Owner</th>
					<th>Name</th>
					<th>Address</th>
					<th>Has Permit</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach($businesses as $business) { ?>
					<tr>
						<td>
							<?php $owner = Applicant::findByID($business->user_id); ?>
							<?=htmlentities($owner->last_name.', '.$owner->first_name)?>
						</td>
						<td>
							<?=htmlentities($business->name)?>
						</td>
						<td>
							<?=htmlentities($business->address)?>
						</td>
						<td>
							<?php echo $business->has_permit ? 'Yes' : 'No'; ?>
						</td>
					</tr>
				<?php } ?>
			</tbody>
		</table>
		<?=$pagination?>
	<?php } else {
		echo 'There are no businesses.';
	} ?>
</div>