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
								$expiry = $db->search('expiry', array('permit_id' => $permit->id), 'fetch');
								if($expiry) {
									$date = new DateTime($expiry[0]['end_date']);
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
										      				<h6>Type: <b><?=htmlentities($permit->type)?></b></h6>
										      			</div>
										      			<div class="col-md-4 border-bottom">
										      				<h6>Business Name: <b><?=htmlentities(Business::cleanFindByID($permit->business_id)->name)?></b></h6>
										      			</div>
										      			<div class="col-md-3 border-bottom">
										      				<h6>Date: 	<b><?php
																		$date = new DateTime($permit->date);
																		echo $date->format('F d, Y');
																	?></b></h6>
										      			</div>
										      			<div class="col-md-3 border-bottom">
										      				<h6>Status:	<b><?php
										      							$statuses = array('Pending', 'Approved', 'Expired');
										      							echo $statuses[$permit->approved];
										      						?></b></h6>
										      			</div>
										      			<div class="col-md-4 border-bottom border-right">
										      				Business Account Number: <b><?=htmlentities($permit->business_account_number)?></b>
										      			</div>
										      			<div class="col-md-4 border-bottom border-right">
										      				Name of Taxpayers: <b><?=htmlentities($permit->name_of_taxpayers)?></b>
										      			</div>
										      			<div class="col-md-4 border-bottom">
										      				Telephone No.: <b><?=htmlentities($permit->telephone_no)?></b>
										      			</div>
										      			<div class="col-md-4 border-bottom border-right">
										      				Capital: <b><?=htmlentities($permit->capital)?></b> PHP
										      			</div>
										      			<div class="col-md-4 border-bottom border-right">
										      				Address: <b><?=htmlentities($permit->address)?></b>
										      			</div>
										      			<div class="col-md-4 border-bottom">
										      				Brgy No.: <b><?=htmlentities($permit->barangay_no)?></b>
										      			</div>
										      			<div class="col-md-4 border-bottom border-right">
										      				Business Trade Name: <b><?=htmlentities($permit->business_trade_name)?></b>
										      			</div>
										      			<div class="col-md-4 border-bottom border-right">
										      				Business Tel No.: <b><?=htmlentities($permit->business_telephone_no)?></b>
										      			</div>
										      			<div class="col-md-4 border-bottom">
										      				Fax No.: <b><?=htmlentities($permit->fax_no)?></b>
										      			</div>
										      			<div class="col-md-4 border-bottom border-right">
										      				Commercial Address: <b><?=htmlentities($permit->commercial_address)?></b>
										      			</div>
										      			<div class="col-md-4 border-bottom border-right">
										      				Street: <b><?=htmlentities($permit->street)?></b>
										      			</div>
										      			<div class="col-md-4 border-bottom">
										      				Barangay: <b><?=htmlentities($permit->barangay)?></b>
										      			</div>
										      			<div class="col-md-4 border-bottom border-right">
										      				Main Line of Business: <b><?=htmlentities($permit->main_line_of_business)?></b>
										      			</div>
										      			<div class="col-md-4 border-bottom border-right">
										      				Main Products and Services: <b><?=htmlentities($permit->main_products_and_services)?></b>
										      			</div>
										      			<div class="col-md-4 border-bottom">
										      				Barangay Clearance: <b><?=$permit->barangay_clearance == 1 ? 'Yes' : 'No'?></b>
										      			</div>
										      			<div class="col-md-4 border-bottom border-right">
										      				No. of Employees: <b><?=htmlentities($permit->no_of_employees)?></b>
										      			</div>
										      			<div class="col-md-4 border-bottom border-right">
										      				Public Liability Insurance: <b><?=$permit->public_liability_insurance == 1 ? 'Yes' : 'No'?></b>
										      			</div>
										      			<div class="col-md-4 border-bottom">
										      				Issuing Company: <b><?=htmlentities($permit->issuing_company)?></b>
										      			</div>
										      			<div class="col-md-4 border-bottom border-right">
										      				Date: <b><?=htmlentities($permit->issuing_company_date)?></b>
										      			</div>
										      			<div class="col-md-4 border-bottom border-right">
										      				DTI Reg No.: <b><?=htmlentities($permit->dti_reg_no)?></b>
										      			</div>
										      			<div class="col-md-4 border-bottom">
										      				SEC Reg No.: <b><?=htmlentities($permit->sec_reg_no)?></b>
										      			</div>
										      			<div class="col-md-4 border-bottom border-right">
										      				Proof of Ownership: <b><?=htmlentities($permit->proof_of_ownership)?></b>
										      			</div>
										      			<div class="col-md-4 border-bottom border-right">
										      				Owned: <b><?=$permit->owned == 1 ? 'Yes' : 'No'?></b>
										      			</div>
										      			<div class="col-md-4 border-bottom">
										      				Leased: <b><?=$permit->leased == 1 ? 'Yes' : 'No'?></b>
										      			</div>
										      			<div class="col-md-4 border-bottom border-right">
										      				Ownership Type: <b><?=htmlentities($permit->ownership_type)?></b>
										      			</div>
										      			<div class="col-md-4 border-bottom border-right">
										      				Registered Name: <b><?=htmlentities($permit->registered_name)?></b>
										      			</div>
										      			<div class="col-md-4 border-bottom">
										      				Lessor's Name: <b><?=htmlentities($permit->lessors_name)?></b>
										      			</div>
										      			<div class="col-md-4 border-bottom border-right">
										      				Real Property Tax Receipt No.: <b><?=htmlentities($permit->real_property_tax_receipt_no)?></b>
										      			</div>
										      			<div class="col-md-4 border-bottom border-right">
										      				Rent per Month: <b><?=htmlentities($permit->rent_per_month)?></b>
										      			</div>
										      			<div class="col-md-4 border-bottom">
										      				Period Date: <b><?php $date = new DateTime($permit->period_date); echo $date->format('F d, Y'); ?></b>
										      			</div>
										      			<div class="col-md-4">
										      				Area in SQ Meter: <b><?=htmlentities($permit->area_in_sq_meter)?></b>
										      			</div>
										      			<div class="col-md-12 border-top">
										      				<h4>
										      					<span>
										      						Name of Applicant: <b><?=htmlentities($permit->name_of_applicant)?></b>
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