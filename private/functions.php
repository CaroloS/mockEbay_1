<?php

	include_once('../private/initialise.php');

	function redirect_to($location) {
 		header("Location: " . $location);
  		exit();
	}

	function is_post_request() {
  		return $_SERVER['REQUEST_METHOD'] == 'POST';
	}

	function h($string="") {
  	return htmlspecialchars($string);
	}
	
	function display_errors($errors=array()) {
		 $output = '';
		 if(!empty($errors)) {
		 	$output .= "<div class=\"container clearfix\">";
			$output .= "<div class=\"alert alert-danger alert-dismissible float-left\" role=\"alert\">";
			$output .= "<a class=\"close\" data-dismiss=\"alert\" aria-label=\"close\">";
			$output .= "<span aria-hidden=\"true\">&times;";
			$output .= "</span>";
			$output .= "</a>";
			$output .= "<strong>Please rectify the following issues: </strong>";
			$output .= "<ul>";
			foreach($errors as $error) {
				$output .= "<li>" . h($error) . "</li>";
			}
			$output .= "</ul>";
			$output .= "</div>";
			$output .= "</div>";
		  }
		 return $output;
	}

?>