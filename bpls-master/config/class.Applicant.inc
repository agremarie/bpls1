<?php
	class Applicant extends User {
		public $detail_id;
		public $first_name;
		public $last_name;
		public $contact_number;
		public $address;
		public $email = null;

		const LEVEL = 1;

		public function __construct($data = array()) {
			foreach($data as $property => $value) {
				if(property_exists($this, $property)) {
					$this->$property = $value;
				}
			}
			return $this;
		}

		public function save() {
			if(!$this->id) {
				parent::create();
			}
			else {
				parent::update();
			}
			return !$this->detail_id ? $this->create() : $this->update();
		}

		public function create() {
			global $db;
			$params = array(
				'user_id' => $this->id,
				'first_name' => $this->first_name,
				'last_name' => $this->last_name,
				'contact_number' => $this->contact_number,
				'address' => $this->address,
				'email' => $this->email
			);
			return $db->insert('user_details', $params);
		}

		public function update() {

		}

		public static function getDetail() {
			global $db;
			$sql = 'SELECT * FROM user_details '
				. 'WHERE user_id = '.$_SESSION['user_id'];
			return $db->query($sql)->fetch(PDO::FETCH_OBJ);
		}

		public static function findAllBusinesses() {
			global $db;

			$sql = 'SELECT * FROM businesses WHERE user_id = '.$_SESSION['user_id'];
			$result = $db->query($sql);
			if($result->rowCount() > 0) {
				$object_array = array();
				while($row = $result->fetch(PDO::FETCH_ASSOC)) {
					$object_array[] = new Business($row);
				}
				return $object_array;
			}
			else {
				return null;
			}
		}

		public static function findByID($id) {
			global $db;
			$clean = array();
			$user = $db->search('users', array('id' => $id, 'access_level' => self::LEVEL), 'fetch')[0];
			$detail = $db->search('user_details', array('user_id' => $user['id']), 'fetch')[0];
			foreach($user as $key => $value) {
				$clean[$key] = $value;
			}
			foreach($detail as $key => $value) {
				if($key == 'id') {
					$key = 'detail_id';
				}
				$clean[$key] = $value;
			}
			return new self($clean);
		}

		public static function totalCount() {
			global $db;
			return $db->search('users', array('access_level' => 1), 'count');
		}

		public function getFullName() {
			return htmlentities($this->last_name.', '.$this->first_name);
		}
	}