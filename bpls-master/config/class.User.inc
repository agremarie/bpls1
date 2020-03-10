<?php
	class User {
		public $id;
		public $username;
		public $password;
		public $access_level;
		public $messages = array();

		public function __construct($data = array()) {
			foreach($data as $property => $value) {
				if(property_exists($this, $property)) {
					$this->$property = $value;
				}
			}
			return $this;
		}

		public function save() {
			return !$this->id ? $this->create() : $this->update();
		}

		public function create() {
			global $db;
			$sql = 'SELECT * FROM users WHERE username = '.$db->quote($this->username);
			if($db->query($sql)->rowCount() == 0) {
				$params = array(
					'username' => $this->username,
					'password' => password_hash($this->password, PASSWORD_DEFAULT),
					'access_level' => static::LEVEL
				);
				if($db->insert('users', $params)) {
					$user = $db->search('users', $params, 'fetch');
					$this->id = $user[0]['id'];
					return true;
				}
			}
			else {
				return false;
			}
		}

		public function update() {

		}

		public function authenticate() {
			global $db;

			$sql = 'SELECT * FROM users '
				. 'WHERE username = '.$db->quote($this->username);
			$result = $db->query($sql);
			if($result->rowCount() > 0 ) {
				$user = $result->fetch(PDO::FETCH_ASSOC);
				if(password_verify($this->password, $user['password'])) {
					$this->messages[] = 'User logged in successfully.';
					$this->id = $user['id'];
					$this->password = $user['password'];
					$this->access_level = $user['access_level'];
					return true;
				}
				else {
					$this->messages[] = 'Wrong password.';
					return false;
				}
			}
			else {
				$this->messages[] = 'Username not found.';
				return false;
			}
		}
	}