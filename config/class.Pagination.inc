<?php
	class Pagination {
		public $current_page;
		public $per_page;
		public $total_count;

		public function __construct($page=1, $per_page = 10, $total_count = 0) {
			$this->current_page = (int)$page;
			$this->per_page = (int)$per_page;
			$this->total_count = (int)$total_count;
		}

		public function offset() {
			return ($this->current_page - 1) * $this->per_page;
		}

		public function total_pages() {
			return ceil($this->total_count/$this->per_page);
		}

		public function previous_page() {
			return $this->current_page - 1;
		}

		public function next_page() {
			return $this->current_page + 1;
		}

		public function has_previous_page() {
			return $this->previous_page() >= 1 ? true : false;
		}

		public function has_next_page() {
			return $this->next_page() <= $this->total_pages() ? true : false;
		}

		public function __toString() {
			$output = "";
			if($this->total_pages() > 1) { 
				$output .= "<nav aria-label=\"page-navigation\">";
					$output .= "<ul class=\"pagination pagination-sm\">";
						if($this->has_previous_page()) {
					    	$output .= "<li class=\"page-item\">";
					    		$output .= "<a id=\"pagination-link\" class=\"page-link\" href=\"".htmlentities($_SERVER['PHP_SELF'])."?page=".$this->previous_page()."\" aria-label=\"Previous\">";
					    			$output .= "<span aria-hidden=\"true\">&laquo;</span>";
									$output .= "<span class=\"sr-only\">Previous</span>";
					    		$output .= "</a>";
					    	$output .= "</li>";
					    }

					    for($i=1; $i <= $this->total_pages(); $i++) {
					    	if($i == $this->current_page) {
					    		$output .= "<li class=\"page-item active\"><a id=\"pagination-link\" class=\"page-link \" href=\"".htmlentities($_SERVER['PHP_SELF'])."?page={$i}\">{$i}</a></li>";
					    	}
					    	else {
					    		$output .= "<li class=\"page-item\"><a id=\"pagination-link\" class=\"page-link\" href=\"".htmlentities($_SERVER['PHP_SELF'])."?page={$i}\">{$i}</a></li>";
					    	}
					    }

					    if($this->has_next_page()) {
					    	$output .= "<li class=\"page-item\">";
					    		$output .= "<a  id=\"pagination-link\" class=\"page-link\" href=\"".htmlentities($_SERVER['PHP_SELF'])."?page=".$this->next_page()."\" aria-label=\"Next\">";
					    			$output .= "<span aria-hidden=\"true\">&raquo;</span>";
									$output .= "<span class=\"sr-only\">Next</span>";
					    		$output .= "</a>";
					    	$output .= "</li>";
					    }
				  	$output .= "</ul>";
				$output .= "</nav>";
				$output .= '<script type="text/javascript">';
				$nav_link = '';
				if(file_exists('assets'.DS.'js'.DS.'pagination.js')) {
					$nav_link = 'assets'.DS.'js'.DS.'pagination.js';
				}
				else if(file_exists('..'.DS.'assets'.DS.'js'.DS.'pagination.js')) {
					$nav_link = '..'.DS.'assets'.DS.'js'.DS.'pagination.js';
				}
				$output .= file_get_contents($nav_link);
				$output .= '</script>';
			}
			return $output;
		}
	}
?>