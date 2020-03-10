<?php
	
	class Admin extends User {

		const LEVEL = 2;

		public static function findAll($pagination) {
			global $db;
			$sql = 'SELECT * FROM users '
				. 'WHERE access_level = '.self::LEVEL.' '
				. 'AND id NOT IN ('.$_SESSION['user_id'].') '
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
			return $db->query('SELECT * FROM users WHERE access_level = 2 AND id NOT IN ('.$_SESSION['user_id'].')')->rowCount();
		}

		public static function findAllApplicants($pagination) {
			global $db;
			$sql = 'SELECT * FROM users '
				. 'WHERE access_level = 1 '
				. 'LIMIT '.$pagination->per_page.' '
				. 'OFFSET '.$pagination->offset();
			$result = $db->query($sql);
			$raw_applicants;
			if($result->rowCount() > 0) {
				$raw_applicants = array();
				while($row = $result->fetch(PDO::FETCH_ASSOC)) {
					$raw_applicants[] = $row;
				}
			}
			else {
				$raw_applicants = null;
			}
			if($raw_applicants) {
				$object_array = array();
				foreach($raw_applicants as $applicant) {
					$detail = $db->search('user_details', array('user_id' => $applicant['id']), 'fetch');
					if($detail) {
						$clean_applicant = array();
						foreach($detail[0] as $key => $value) {
							if($key == 'id') {
								$key = 'detail_id';
							}
							$clean_applicant[$key] = $value;
						}
						foreach($applicant as $key => $value) {
							$clean_applicant[$key] = $value;
						}
						$p = new Applicant($clean_applicant);
						$sql = 'SELECT * FROM businesses WHERE user_id = '.$p->id;
						$p->business_count = $db->query($sql)->rowCount();
						$sql = 'SELECT * FROM permit_requests WHERE user_id = '.$p->id.' '
							. 'AND approved = 1';
						$p->permit_count = $db->query($sql)->rowCount();
						$sql = 'SELECT * FROM permit_requests WHERE user_id = '.$p->id.' '
							. 'AND approved = 0';
						$p->permit_request_count = $db->query($sql)->rowCount();
						$object_array[] = $p;
					}
				}
				return $object_array;
			}
			else {
				return null;
			}
		}
	}