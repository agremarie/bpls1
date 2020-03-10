<?php
	
	class Permit {
		public $id;
		public $user_id;
		public $business_id;
		public $type;
		public $date;
		public $approved;
		public $business_account_number;
		public $name_of_taxpayers;
		public $telephone_no;
		public $capital;
		public $address;
		public $barangay_no;
		public $business_trade_name;
		public $business_telephone_no;
		public $fax_no;
		public $commercial_address;
		public $street;
		public $barangay;
		public $main_line_of_business;
		public $main_products_and_services;
		public $barangay_clearance;
		public $no_of_employees;
		public $public_liability_insurance;
		public $issuing_company;
		public $issuing_company_date;
		public $dti_reg_no;
		public $sec_reg_no;
		public $proof_of_ownership;
		public $owned;
		public $leased;
		public $ownership_type;
		public $registered_name;
		public $lessors_name;
		public $real_property_tax_receipt_no;
		public $rent_per_month;
		public $period_date;
		public $area_in_sq_meter;
		public $name_of_applicant;

		private $columns = array();

		const PENDING  = 0;
		const APPROVED = 1;
		const EXPIRED  = 2;

		public function __construct($data = array()) {
			foreach($data as $property => $value) {
				if(property_exists($this, $property)) {
					$this->columns[] = $property;
					$this->$property = $value;
				}
			}
			return $this;
		}

		private function attributes() {
			$data = array();
			foreach($this->columns as $property) {
				if(property_exists($this, $property)) {
					$data[$property] = $this->$property;
				}
			}
			return $data;
		}

		public function save() {
			return !$this->id ? $this->create() : $this->update();
		}

		private function create() {
			global $db;
			return $db->insert('permit_requests', $this->attributes());
		}

		private function update() {
			global $db;
			$data = $this->attributes();
			if($data['type'] == 'Renewal') {
				$data['approved'] = 0;
			}
			$ids = array(
				'id' => $data['id']
			);
			unset($data['id']);
			return $db->update('permit_requests', $data, $ids);
		}

		public static function findByBusinessID($id) {
			global $db;
			$params = array(
				'user_id' => $_SESSION['user_id'],
				'business_id' => $id
			);
			$result = $db->search('permit_requests', $params, 'fetch');
			if($result) {
				return new self($result[0]);
			}
			else {
				return null;
			}
		}

		public static function findAll($pagination) {
			global $db;
			$sql = 'SELECT * FROM permit_requests '
				. 'ORDER BY approved ASC '
				. 'LIMIT '.$pagination->per_page.' '
				. 'OFFSET '.$pagination->offset();
			$result = $db->query($sql);
			if($result->rowCount() > 0) {
				$object_array = array();
				while($row = $result->fetch(PDO::FETCH_ASSOC)) {
					$object_array[] = new self($row);
				}
				return $object_array;
			}
			else {
				return null;
			}
		}

		public static function totalCount() {
			global $db;
			return $db->search('permit_requests', array(), 'count');
		}
	}