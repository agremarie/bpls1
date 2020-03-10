<?php
	require '../config/initialize.inc';
	ajaxOnly();
	$session->checkApplicant();

	$businesses = Applicant::findAllBusinesses();
?>
<div class="container">
	<br />
	<h2>Businesses</h2>
	<p>
		<a id="add-business-btn" class="btn btn-info btn-sm" href="add_business.php">
			Add
		</a>
	</p>
	<?php if($businesses) { ?>
		<table class="table table-hover">
			<thead>
				<tr>
					<th>Name</th>
					<th>Address</th>
					<th>Has Permit?</th>
					<th>Actions</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach($businesses as $business) { ?>
					<tr>
						<td>
							<?=htmlentities($business->name)?>
						</td>
						<td>
							<?=htmlentities($business->address)?>
						</td>
						<td>
							<?=$business->has_permit ? 'Yes' : 'No'?>
						</td>
						<td>
							<?php $permit = Permit::findByBusinessID($business->id); ?>
							<?php if(!$business->has_permit && !$permit) { ?>
								<a id="request-permit-btn" class="btn btn-warning text-light btn-sm" href="request_permit.php?business_id=<?=urlencode($business->id)?>">
									Request Permit
								</a>
							<?php } else { ?>
								<?php if($permit->approved == Permit::PENDING) { ?>
									<a id="request-permit-btn" class="btn btn-warning text-light btn-sm disabled" href="request_permit.php?business_id=<?=urlencode($business->id)?>">
										Permit Requested
									</a>
								<?php } else if($permit->approved == Permit::EXPIRED) { ?>
									<a id="request-permit-btn" class="btn btn-warning text-light btn-sm" href="request_permit.php?business_id=<?=urlencode($business->id)?>">
										Request Renewal
									</a>
								<?php } ?>
							<?php } ?>
							<a class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')" href="delete_business.php?id=<?=$business->id?>">
								Delete
							</a>
						</td>
					</tr>
				<?php } ?>
			</tbody>
		</table>
	<?php } ?>
	<?php include '../templates/spinner.inc'; ?>
</div>
<script type="text/javascript">
	$(document).ready(() => {
		$(document).on('click', '#add-business-btn', function(e) {
			disableLink(e);
			toggleSpinner(true);
			$.get($(this).attr('href'), result => {
				toggleSpinner(false);
				container.loadHTML(result);
			});
		});

		$(document).on('click', '#request-permit-btn', function(e) {
			disableLink(e);
			toggleSpinner(true);
			$.get($(this).attr('href'), result => {
				toggleSpinner(false);
				container.loadHTML(result);
			});
		});
	});
</script>