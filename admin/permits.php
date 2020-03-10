<?php
	require '../config/initialize.inc';

	$session->checkAdmin();
	ajaxOnly();

	$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
	$per_page = 10;
	$total_count = Permit::totalCount();

	$pagination = new Pagination($page, $per_page, $total_count);

	$permits = Permit::findAll($pagination);
?>
<div class="container">
	<h2>Permits</h2>
	<?php if($permits) { ?>
		<table class="table table-sm table-hover">
			<thead>
				<tr>
					<th>Owner</th>
					<th>Business Name</th>
					<th>Type</th>
					<th>Date</th>
					<th>Expiry</th>
					<th>Actions</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach($permits as $permit) { ?>
					<tr>
						<td>
							<?php $owner = Applicant::findByID($permit->user_id); ?>
							<?=$owner->getFullName()?>
						</td>
						<td>
							<?=htmlentities(Business::cleanFindByID($permit->business_id)->name)?>
						</td>
						<td>
							<?=$permit->type?>
						</td>
						<td>
							<?php
								$date = new DateTime($permit->date);
								echo $date->format('F d, Y');
							?>
						</td>
						<td>
							<?php
								$expiry = $db->search('expiry', array('permit_id' => $permit->id), 'fetch')[0];
								if($expiry) {
									$date = new DateTime($expiry['end_date']);
									echo $date->format('F d, Y');
								}
								else {
									echo 'N/A';
								}
							?>
						</td>
						<td>
							<?php if($permit->approved) { ?>
								<a class="btn btn-danger btn-sm disabled" href="approve.php?id=<?=urlencode($permit->id)?>">
									Approved
								</a>
							<?php } else { ?>
									<button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#view-permit<?=htmlentities($permit->id)?>">
										View
									</button>
									<div class="modal fade" id="view-permit<?=htmlentities($permit->id)?>" tabindex="-1" role="dialog" aria-labelledby="view-permit-title<?=htmlentities($permit->id)?>" aria-hidden="true">
									  	<div class="modal-dialog modal-xl" role="document">
									    	<div class="modal-content">
									      		<div class="modal-header">
									        		<h5 class="modal-title" id="view-permit-title<?=htmlentities($permit->id)?>">View Permit</h5>
									        		<button type="button" class="close" data-dismiss="modal" aria-label="Close">
									          			<span aria-hidden="true">&times;</span>
									        		</button>
									      		</div>
									      		<div class="modal-body">
										      		<div class="row">
										      			<div class="col-md-2 border-bottom">
										      				<h6>Type: <?=htmlentities($permit->type)?></h6>
										      			</div>
										      			<div class="col-md-4 border-bottom">
										      				<h6>Business Name: <?=htmlentities(Business::cleanFindByID($permit->business_id)->name)?></h6>
										      			</div>
										      			<div class="col-md-3 border-bottom">
										      				<h6>Date: 	<?php
																		$date = new DateTime($permit->date);
																		echo $date->format('F d, Y');
																	?></h6>
										      			</div>
										      			<div class="col-md-3 border-bottom">
										      				<h6>Status:	<?php
										      							$statuses = array('Pending', 'Approved', 'Expired');
										      							echo $statuses[$permit->approved];
										      						?></h6>
										      			</div>
										      			<div class="col-md-4 border-bottom border-right">
										      				Business Account Number: <?=htmlentities($permit->business_account_number)?>
										      			</div>
										      			<div class="col-md-4 border-bottom border-right">
										      				Name of Taxpayers: <?=htmlentities($permit->name_of_taxpayers)?>
										      			</div>
										      			<div class="col-md-4 border-bottom">
										      				Telephone No.: <?=htmlentities($permit->telephone_no)?>
										      			</div>
										      			<div class="col-md-4 border-bottom border-right">
										      				Capital: <?=htmlentities($permit->capital)?> PHP
										      			</div>
										      			<div class="col-md-4 border-bottom border-right">
										      				Address: <?=htmlentities($permit->address)?>
										      			</div>
										      			<div class="col-md-4 border-bottom">
										      				Brgy No.: <?=htmlentities($permit->barangay_no)?>
										      			</div>
										      			<div class="col-md-4 border-bottom border-right">
										      				Business Trade Name: <?=htmlentities($permit->business_trade_name)?>
										      			</div>
										      			<div class="col-md-4 border-bottom border-right">
										      				Business Tel No.: <?=htmlentities($permit->business_telephone_no)?>
										      			</div>
										      			<div class="col-md-4 border-bottom">
										      				Fax No.: <?=htmlentities($permit->fax_no)?>
										      			</div>
										      			<div class="col-md-4 border-bottom border-right">
										      				Commercial Address: <?=htmlentities($permit->commercial_address)?>
										      			</div>
										      			<div class="col-md-4 border-bottom border-right">
										      				Street: <?=htmlentities($permit->street)?>
										      			</div>
										      			<div class="col-md-4 border-bottom">
										      				Barangay: <?=htmlentities($permit->barangay)?>
										      			</div>
										      			<div class="col-md-4 border-bottom border-right">
										      				Main Line of Business: <?=htmlentities($permit->main_line_of_business)?>
										      			</div>
										      			<div class="col-md-4 border-bottom border-right">
										      				Main Products and Services: <?=htmlentities($permit->main_products_and_services)?>
										      			</div>
										      			<div class="col-md-4 border-bottom">
										      				Barangay Clearance: <?=$permit->barangay_clearance == 1 ? 'Yes' : 'No'?>
										      			</div>
										      			<div class="col-md-4 border-bottom border-right">
										      				No. of Employees: <?=htmlentities($permit->no_of_employees)?>
										      			</div>
										      			<div class="col-md-4 border-bottom border-right">
										      				Public Liability Insurance: <?=$permit->public_liability_insurance == 1 ? 'Yes' : 'No'?>
										      			</div>
										      			<div class="col-md-4 border-bottom">
										      				Issuing Company: <?=htmlentities($permit->issuing_company)?>
										      			</div>
										      			<div class="col-md-4 border-bottom border-right">
										      				Date: <?=htmlentities($permit->issuing_company_date)?>
										      			</div>
										      			<div class="col-md-4 border-bottom border-right">
										      				DTI Reg No.: <?=htmlentities($permit->dti_reg_no)?>
										      			</div>
										      			<div class="col-md-4 border-bottom">
										      				SEC Reg No.: <?=htmlentities($permit->sec_reg_no)?>
										      			</div>
										      			<div class="col-md-4 border-bottom border-right">
										      				Proof of Ownership: <?=htmlentities($permit->proof_of_ownership)?>
										      			</div>
										      			<div class="col-md-4 border-bottom border-right">
										      				Owned: <?=$permit->owned == 1 ? 'Yes' : 'No'?>
										      			</div>
										      			<div class="col-md-4 border-bottom">
										      				Leased: <?=$permit->leased == 1 ? 'Yes' : 'No'?>
										      			</div>
										      			<div class="col-md-4 border-bottom border-right">
										      				Ownership Type: <?=htmlentities($permit->ownership_type)?>
										      			</div>
										      			<div class="col-md-4 border-bottom border-right">
										      				Registered Name: <?=htmlentities($permit->registered_name)?>
										      			</div>
										      			<div class="col-md-4 border-bottom">
										      				Lessor's Name: <?=htmlentities($permit->lessors_name)?>
										      			</div>
										      			<div class="col-md-4 border-bottom border-right">
										      				Real Property Tax Receipt No.: <?=htmlentities($permit->real_property_tax_receipt_no)?>
										      			</div>
										      			<div class="col-md-4 border-bottom border-right">
										      				Rent per Month: <?=htmlentities($permit->rent_per_month)?>
										      			</div>
										      			<div class="col-md-4 border-bottom">
										      				Period Date: <?php $date = new DateTime($permit->period_date); echo $date->format('F d, Y'); ?>
										      			</div>
										      			<div class="col-md-4">
										      				Area in SQ Meter: <?=htmlentities($permit->area_in_sq_meter)?>
										      			</div>
										      			<div class="col-md-12 border-top">
										      				<h4>
										      					<span>
										      						Name of Applicant: <?=htmlentities($permit->name_of_applicant)?>
										      					</span>
										      				</h4>
										      			</div>
										      		</div>
									      		</div>
									      		<div class="modal-footer">
										        	<?php if($permit->approved == Permit::PENDING) { ?>
										        		<a class="btn btn-warning text-light btn-sm" href="approve.php?id=<?=urlencode($permit->id)?>">
										        			Approve
										        		</a>
										        	<?php } ?>
									        		<button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
									      		</div>
									    	</div>
										</div>
									</div>
							<?php } ?>
						</td>
					</tr>
				<?php } ?>
			</tbody>
		</table>
		<?=$pagination?>
	<?php } else {
		echo 'There are no permits.';
	} ?>
</div>