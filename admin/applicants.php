<?php
	require '../config/initialize.inc';

	$session->checkAdmin();
	ajaxOnly();

	$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
	$per_page = 10;
	$total_count = Applicant::totalCount();

	$pagination = new Pagination($page, $per_page, $total_count);

	$applicants = Admin::findAllApplicants($pagination);
?>
<div class="container">
	<h2>Applicants</h2>
	<?php if($applicants) { ?>
		<table class="table table-sm table-hover">
			<thead>
				<tr>
					<th>Name</th>
					<th>Contact No.</th>
					<th>Email</th>
					<th>Username</th>
					<th>Businesses</th>
					<th>Permits</th>
					<th>Permit Requests</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach($applicants as $applicant) { ?>
					<tr>
						<td>
							<?=htmlentities($applicant->last_name.', '.$applicant->first_name)?>
						</td>
						<td>
							<?=htmlentities($applicant->contact_number)?>
						</td>
						<td>
							<?=htmlentities($applicant->email)?>
						</td>
						<td>
							<?=htmlentities($applicant->username)?>
						</td>
						<td>
							<?=$applicant->business_count?>
						</td>
						<td>
							<?=$applicant->permit_count?>
						</td>
						<td>
							<?=$applicant->permit_request_count?>
						</td>
					</tr>
				<?php } ?>
			</tbody>
		</table>
		<?=$pagination?>
	<?php } else {
		echo 'There are no applicants.';
	} ?>
</div>