<?php
	require '../config/initialize.inc';

	$business_id = isset($_GET['business_id']) ? (int)$_GET['business_id'] : null;

	$session->checkApplicant();

	if(isset($_POST) && !empty($_POST)) {
		if(isset($_GET['permit_id'])) {
			$_POST['id'] = (int)$_GET['permit_id'];
		}
		$data = $_POST;
		$data['user_id'] = $_SESSION['user_id'];
		$data['business_id'] = $business_id;
		$permit = new Permit($data);
		if($permit->save()) {
			$session->message('Permit request sent successfully.<br />Your business will show \'Has Permit? Yes\' if it is approved.');
			redirect('index.php');
		}
	}

	ajaxOnly();

	if(!$business_id) {
		exit;
	}
	$business = Business::findByID($business_id);
	$permit = Permit::findByBusinessID($business_id);
	$type = '';
	$get = '';
	$types = array('New', 'Renewal');
	if($permit && $permit->approved == Permit::EXPIRED) {
		$type = 'Renewal';
		$get = '&permit_id='.$permit->id;
	}
	else {
		$type = 'New';
	}

	if(!$business) {
		exit;
	}

	$self_detail = Applicant::getDetail();
?>
<div class="container-fluid">
	<br />
	<h2>Request Permit</h2>
	<form class="row" action="request_permit.php?business_id=<?=$business_id.$get?>" method="post">
		<div class="col-md-12">
			<div class="input-group">
				<div class="input-group-prepend">
					<span class="input-group-text">Permit Type:</span>
				</div>
				<select class="form-control" name="type" readonly="readonly">
					<?php foreach($types as $t) { ?>
						<option value="<?=$t?>" <?=$t == $type ? 'selected' : null;?>>
							<?=$t?>
						</option>
					<?php } ?>
				</select>
			</div>
		</div>
		<div class="col-md-4">
			<div class="input-group">
				<div class="input-group-prepend">
					<span class="input-group-text">Date of Application:</span>
				</div>
				<input type="text" name="date" class="form-control" readonly="readonly" value="<?=date('Y/m/d')?>">
			</div>
		</div>
		<div class="col-md-8">
			<div class="input-group">
				<div class="input-group-prepend">
					<span class="input-group-text">Business Account No.:</span>
				</div>
				<input type="text" name="business_account_number" class="form-control" value="" required="">
			</div>
		</div>
		<br />
		<hr />
		<br />
		<?php // End ?>

		<div class="col-md-6">
			<div class="input-group">
				<div class="input-group-prepend">
					<span class="input-group-text">Name of Taxpayers:</span>
				</div>
				<input type="text" name="name_of_taxpayers" class="form-control" value="" required="">
			</div>
		</div>
		<div class="col-md-3">
			<div class="input-group">
				<div class="input-group-prepend">
					<span class="input-group-text">Telephone No.:</span>
				</div>
				<input type="text" name="telephone_no" class="form-control" value="" required="">
			</div>
		</div>
		<div class="col-md-3">
			<div class="input-group">
				<div class="input-group-prepend">
					<span class="input-group-text">Capital:</span>
				</div>
				<input type="text" name="capital" class="form-control" value="" required="">
			</div>
		</div>
		<br />
		<hr />
		<br />
		<?php // End ?>

		<div class="col-md-9">
			<div class="input-group">
				<div class="input-group-prepend">
					<span class="input-group-text">Address:</span>
				</div>
				<input type="text" name="address" class="form-control" value="" required="">
			</div>
		</div>
		<div class="col-md-3">
			<div class="input-group">
				<div class="input-group-prepend">
					<span class="input-group-text">Barangay No.:</span>
				</div>
				<input type="text" name="barangay_no" class="form-control" value="" required="">
			</div>
		</div>
		<br />
		<hr />
		<br />
		<?php // End ?>

		<div class="col-md-6">
			<div class="input-group">
				<div class="input-group-prepend">
					<span class="input-group-text">Business Trade Name:</span>
				</div>
				<input type="text" name="business_trade_name" class="form-control" value="" required="">
			</div>
		</div>
		<div class="col-md-3">
			<div class="input-group">
				<div class="input-group-prepend">
					<span class="input-group-text">Telephone No.:</span>
				</div>
				<input type="text" name="business_telephone_no" class="form-control" value="" required="">
			</div>
		</div>
		<div class="col-md-3">
			<div class="input-group">
				<div class="input-group-prepend">
					<span class="input-group-text">Fax No.:</span>
				</div>
				<input type="text" name="fax_no" class="form-control" value="">
			</div>
		</div>
		<br />
		<hr />
		<br />
		<?php // End ?>

		<div class="col-md-6">
			<div class="input-group">
				<div class="input-group-prepend">
					<span class="input-group-text">Commercial Address:</span>
				</div>
				<input type="text" name="commercial_address" class="form-control" value="" required="">
			</div>
		</div>
		<div class="col-md-3">
			<div class="input-group">
				<div class="input-group-prepend">
					<span class="input-group-text">Street:</span>
				</div>
				<input type="text" name="Street" class="form-control" value="">
			</div>
		</div>
		<div class="col-md-3">
			<div class="input-group">
				<div class="input-group-prepend">
					<span class="input-group-text">Barangay:</span>
				</div>
				<input type="text" name="barangay" class="form-control" value="" required="">
			</div>
		</div>
		<br />
		<hr />
		<br />
		<?php // End ?>

		<div class="col-md-6">
			<div class="input-group">
				<div class="input-group-prepend">
					<span class="input-group-text">Main Line of Business:</span>
				</div>
				<input type="text" name="main_line_of_business" class="form-control" value="">
			</div>
		</div>
		<div class="col-md-6">
			<div class="input-group">
				<div class="input-group-prepend">
					<span class="input-group-text">Main Products/Services:</span>
				</div>
				<input type="text" name="main_products_and_services" class="form-control" value="" required="">
			</div>
		</div>
		<br />
		<hr />
		<br />
		<?php // End ?>

		<div class="col-md-2">
			<div class="custom-control custom-checkbox">
				<input type="hidden" name="barangay_clearance" id="brgy-clearance-val" value="0">
				<input id="brgy-clearance" type="checkbox" class="custom-control-input">
				<script type="text/javascript">
					$(document).ready(() => {
						$(document).on('click', '#brgy-clearance', e => {
							const bcv = $('#brgy-clearance-val');
							bcv.attr('value', 1 - bcv.val());
						});
					});
				</script>
				<label class="custom-control-label" for="brgy-clearance">
					Barangay Clearance
				</label>
			</div>
		</div>
		<div class="col-md-4">
			<div class="input-group">
				<div class="input-group-prepend">
					<span class="input-group-text">No. of Employees:</span>
				</div>
				<input type="number" name="no_of_employees" class="form-control" value="" required="">
			</div>
		</div>
		<div class="col-md-6">
			<div class="row">
				<div class="col-md-12">
					<div class="custom-control custom-checkbox">
						<input type="hidden" name="public_liability_insurance" id="public-liability-insurance-val" value="0">
						<input id="public-liability-insurance" type="checkbox" class="custom-control-input">
						<script type="text/javascript">
							$(document).ready(() => {
								$(document).on('click', '#public-liability-insurance', e => {
									const pliv = $('#public-liability-insurance-val');
									pliv.attr('value', 1 - pliv.val());
								});
							});
						</script>
						<label class="custom-control-label" for="public-liability-insurance">
							Public Liability Insurance
						</label>
					</div>
				</div>
				<div class="col-md-6">
					<div class="input-group">
						<div class="input-group-prepend">
							<span class="input-group-text">Issuing Company:</span>
						</div>
						<input type="text" name="issuing_company" class="form-control" value="" required="">
					</div>
				</div>
				<div class="col-md-6">
					<div class="input-group">
						<div class="input-group-prepend">
							<span class="input-group-text">Date:</span>
						</div>
						<input type="date" name="issuing_company_date" class="form-control" value="" required="">
					</div>
				</div>
			</div>
		</div>
		<br />
		<hr />
		<br />
		<?php // End ?>

		<div class="col-md-3">
			<div class="input-group">
				<div class="input-group-prepend">
					<span class="input-group-text">DTI Reg No.:</span>
				</div>
				<input type="text" name="dti_reg_no" class="form-control" value="">
			</div>
		</div>
		<div class="col-md-3">
			<div class="input-group">
				<div class="input-group-prepend">
					<span class="input-group-text">SEC Reg No.:</span>
				</div>
				<input type="text" name="sec_reg_no" class="form-control" value="">
			</div>
		</div>
		<div class="col-md-6 row">
			<div class="col-md-12">
				<div class="input-group">
					<div class="input-group-prepend">
						<span class="input-group-text">Proof of Ownership:</span>
					</div>
					<input type="text" name="proof_of_ownership" class="form-control" value="">
				</div>
			</div>
			<div class="col-md-6">
				<div class="custom-control custom-checkbox">
					<input type="hidden" name="owned" id="owned-val" value="0">
					<input id="owned" type="checkbox" class="custom-control-input">
					<script type="text/javascript">
						$(document).ready(() => {
							$(document).on('click', '#owned', e => {
								const ov = $('#owned-val');
								ov.val(1 - ov.val());
							});
						});
					</script>
					<label class="custom-control-label" for="owned">
						Owned
					</label>
				</div>
			</div>
			<div class="col-md-6">
				<div class="custom-control custom-checkbox">
					<input type="hidden" name="leased" id="leased-val" value="0">
					<input id="leased" type="checkbox" class="custom-control-input">
					<script type="text/javascript">
						$(document).ready(() => {
							$(document).on('click', '#leased', e => {
								const lv = $('#leased-val');
								lv.val(1 - lv.val());
							});
						});
					</script>
					<label class="custom-control-label" for="leased">
						Leased
					</label>
				</div>
			</div>
		</div>
		<?php // End ?>

		<div class="col-md-6">
			<h6>Ownership Type:</h6>
			<div class="custom-control custom-radio">
				<input type="radio" name="ownership_type" class="custom-control-input" value="Sole Propietorship" id="sp-cb">
				<label class="custom-control-label" for="sp-cb">
					Sole Propietorship
				</label>
			</div>
			<div class="custom-control custom-radio">
				<input type="radio" name="ownership_type" class="custom-control-input" value="Partnership" id="p-cb">
				<label class="custom-control-label" for="p-cb">
					Partnership
				</label>
			</div>
			<div class="custom-control custom-radio">
				<input type="radio" name="ownership_type" class="custom-control-input" value="Corporation" id="c-cb">
				<label class="custom-control-label" for="c-cb">
					Corporation
				</label>
			</div>
		</div>
		<div class="col-md-6">
			<div class="row">
				<div class="col-md-6">
					<div class="input-group">
						<div class="input-group-prepend">
							<span class="input-group-text">
								Registered Name:
							</span>
						</div>
						<input type="text" name="registered_name" class="form-control" value="" required="">
					</div>
				</div>
				<div class="col-md-6">
					<div class="input-group">
						<div class="input-group-prepend">
							<span class="input-group-text">
								Lessor's Name:
							</span>
						</div>
						<input type="text" name="lessors_name" class="form-control" value="" required="">
					</div>
				</div>
				<div class="col-md-6">
					<div class="input-group">
						<div class="input-group-prepend">
							<span class="input-group-text">
								Real Property Tax Receipt No.:
							</span>
						</div>
						<input type="text" name="real_property_tax_receipt_no" class="form-control" value="" required="">
					</div>
				</div>
				<div class="col-md-6">
					<div class="input-group">
						<div class="input-group-prepend">
							<span class="input-group-text">
								Rent per Month:
							</span>
						</div>
						<input type="text" name="rent_per_month" class="form-control" value="" required="">
					</div>
				</div>
				<div class="col-md-6">
					<div class="input-group">
						<div class="input-group-prepend">
							<span class="input-group-text">
								Period Date:
							</span>
						</div>
						<input type="date" name="period_date" class="form-control" value="" required="">
					</div>
				</div>
				<div class="col-md-6">
					<div class="input-group">
						<div class="input-group-prepend">
							<span class="input-group-text">
								Area in SQ. Meter:
							</span>
						</div>
						<input type="text" name="area_in_sq_meter" class="form-control" value="" required="">
					</div>
				</div>
			</div>
		</div>
		<?php // End ?>

		<div class="col-md-12">
			<div class="input-group">
				<div class="input-group-prepend">
					<span class="input-group-text">
						Name of Applicant:
					</span>
					<input type="text" name="name_of_applicant" class="form-control" value="<?=htmlentities($self_detail->first_name.' '.$self_detail->last_name)?>" required="">
				</div>
			</div>
			<br /><br />
			<input type="submit" name="submit" class="btn btn-success" value="Send">
			<br /><br />
		</div>
	</form>
</div>