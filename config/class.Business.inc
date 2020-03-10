<?php

	class Business {
		public $id;
		public $name;
		public $address;
		public $user_id;
		public $has_permit;

		public function __construct($data = array()) {
			if($data == null) {
				return null;
			}
			foreach($data as $property => $value) {
				if(property_exists($this, $property)) {
					$this->$property = $value;
				}
			}
			$this->has_permit = (bool)$this->has_permit;
			return $this;
		}

		public function save() {
			return !$this->id ? $this->create() : $this->update();
		}

		public function create() {
			global $db;
			$params = array(
				'name' => $this->name,
				'address' => $this->address,
				'user_id' => $this->user_id
			);
			return $db->insert('businesses', $params);
		}

		public function update() {
			global $db;
			$params = array(
				'name' => $this->name,
				'address' => $this->address,
				'user_id' => $this->user_id
			);
			$ids = array(
				'id' => $this->id
			);
			return $db->insert('businesses', $params, $ids);
		}

		public static function cleanFindByID($id) {
			global $db;
			$params = array(
				'id' => $id
			);
			return new self($db->search('businesses', $params, 'fetch')[0]);
		}

		public static function findByID($id) {
			global $db;
			$params = array(
				'id' => $id,
				'user_id' => $_SESSION['user_id']
			);
			return new self($db->search('businesses', $params, 'fetch')[0]);
		}

		public static function findAll($pagination) {
			global $db;
			$sql = 'SELECT * FROM businesses '
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

		public static function getTotalCount() {
			global $db;
			return $db->search('businesses', array(), 'count');
		}
	}