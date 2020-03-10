<?php
	class Session {

		public function __construct() {
			session_start();
		}

		public function message($msg='', $mode='info') {
			if(!empty($msg)) {
				// Set
				$_SESSION['message']  = '<div id="message-pane" class="rounded alert alert-'.$mode.'">';
				$_SESSION['message'] .= $msg;
				$_SESSION['message'] .= '</div>';
				unset($msg);
			}
			else {
				if(isset($_SESSION['message'])) {
					// Get
					$message  = '<div class="toast fade show" role="alert" aria-live="assertive" id="message-toast" aria-atomic="true">';
						$message .= '<div class="toast-header">';
							$message .= '<strong class="mr-auto">Message</strong>';
							$message .= '<small>Just now</small>';
							$message .= '<button class="ml-2 mb-1 close" aria-label="Close" type="button" data-target="#message-toast" data-dismiss="toast">';
								$message .= '<span aria-hidden="true">×</span>';
							$message .= '</button>';
						$message .= '</div>';
						$message .= '<div class="toast-body">';
							$message .= $_SESSION['message'];
						$message .= '</div>';
					$message .= '</div>';
					unset($_SESSION['message']);
					return $message;
				}
				else {
					return '<div id="message-pane"></div>';
				}
			}
		}

		public function login($user) {
			$_SESSION['user_id'] = $user->id;
			$_SESSION['user_username'] = $user->username;
			$_SESSION['user_access_level'] = $user->access_level;
		}

		public function logout($message) {
			$this->check();
			foreach($_SESSION as $key => $value) {
				unset($_SESSION[$key]);
			}
			$this->message($message, 'info');
		}

		public function check() {
			if(!isset($_SESSION['user_id'])) {
				$this->message('Please login first.', 'warning');
				redirect('..'.DS.'index.php');
			}
		}

		public function checkApplicant() {
			if(!isset($_SESSION['user_id'])) {
				$this->message('Please login first.', 'warning');
				redirect('..'.DS.'index.php');
			}
			else if($_SESSION['user_access_level'] != Applicant::LEVEL) {
				$this->logout('Access denied.');
				redirect('..'.DS.'index.php');
			}
		}

		public function checkAdmin() {
			if(!isset($_SESSION['user_id'])) {
				$this->message('Please login first.', 'warning');
				redirect('..'.DS.'index.php');
			}
			else if($_SESSION['user_access_level'] != Admin::LEVEL) {
				$this->logout('Access denied.');
				redirect('..'.DS.'index.php');
			}
		}
	}
?>