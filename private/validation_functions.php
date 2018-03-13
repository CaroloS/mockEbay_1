<?php
	
	function is_blank($value) {
		return !isset($value) || trim($value) === '';
	}

  	function is_present($value) {
    	return !is_blank($value);
  	}

	function has_length_greater_than($value, $min) {
    	$length = strlen(trim($value));
   	 	return $length > $min;
  	}

  	function has_length_less_than($value, $max) {
    	$length = strlen(trim($value));
    	return $length < $max;
  	}

  	function has_length($value, $options) {
	    if(isset($options['min']) && !has_length_greater_than($value, $options['min'] - 1)) {
	      return false;
	    } elseif(isset($options['max']) && !has_length_less_than($value, $options['max'] + 1)) {
	      return false;
	    } else {
	      return true;
	    }
  	}

  	function has_valid_email_format($value) {
	    $email_regex = '/\A[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,}\Z/i';
	    return preg_match($email_regex, $value) === 1;
  	}

  	function password_match($password,$password2) {
		if (strcmp($password, $password2) === 0) {
			return true;
		} else {
			return false;
		}
	}


  	function validate_user($user) {
  		
  		$errors = [];

  		//First name length min 1 max 255
  		if (!has_length($user['firstName'], ['min' => 2, 'max' => 255])) {
			$errors[] = "First name must be between 2 and 255 characters.";
		}

  		//Last name length min 1 max 255
  		if (!has_length($user['lastName'], ['min' => 2, 'max' => 255])) {
			$errors[] = "Last name must be between 2 and 255 characters.";
		}

		// Valid email contains @ . [2+ letters]
		if (!has_valid_email_format($user['emailAddress'])) {
			$errors[] = "Invalid e-mail address.";
		}

		//Address1 length min 1 max 255
  		if (!has_length($user['addressLine1'], ['min' => 2, 'max' => 255])) {
			$errors[] = "Address Line 1 must be between 2 and 255 characters.";
		}

		//Address1 length min 1 max 255
  		if (!has_length($user['addressLine2'], ['min' => 2, 'max' => 255])) {
			$errors[] = "Address Line 2 must be between 2 and 255 characters.";
		}

		//Address3 length min 1 max 25
  		if (!has_length($user['addressLine3'], ['min' => 2, 'max' => 25])) {
			$errors[] = "Zip Code must be between 2 and 25 characters.";
		}

		//City length min 1 max 255
  		if (!has_length($user['cityName'], ['min' => 2, 'max' => 255])) {
			$errors[] = "City must be between 2 and 255 characters.";
		}

		//Phone Number length min 1 max 25
  		if (!has_length($user['phoneNumber'], ['min' => 4, 'max' => 25])) {
			$errors[] = "Phone Number must be between 4 and 25 characters.";
		}

		//Username length min 4 max 25
  		if (!has_length($user['username'], ['min' => 4, 'max' => 25])) {
			$errors[] = "Username must be between 4 and 25 characters.";
		}

		//Unique username 
		if (!unique_username($user['username'])) {
			$errors[] = "Username already exist. Choose another one.";
		}

		//Password length min 4 max 12
  		if (!has_length($user['password'], ['min' => 4, 'max' => 12])) {
			$errors[] = "Password must be between 4 and 12 characters.";
		}

		//Password match
		if (!password_match($user['password'], $user['password2'])) {
			$errors[] = "Passwords must match.";
		}

		return $errors;
  	}


  	function validate_edit_user($user) {
  		
  		$errors = [];

  		//First name length min 1 max 255
  		if (!has_length($user['firstName'], ['min' => 2, 'max' => 255])) {
			$errors[] = "First name must be between 2 and 255 characters.";
		}

  		//Last name length min 1 max 255
  		if (!has_length($user['lastName'], ['min' => 2, 'max' => 255])) {
			$errors[] = "Last name must be between 2 and 255 characters.";
		}

		// Valid email contains @ . [2+ letters]
		if (!has_valid_email_format($user['emailAddress'])) {
			$errors[] = "Invalid e-mail address.";
		}

		//Address1 length min 1 max 255
  		if (!has_length($user['addressLine1'], ['min' => 2, 'max' => 255])) {
			$errors[] = "Address Line 1 must be between 2 and 255 characters.";
		}

		//Address1 length min 1 max 255
  		if (!has_length($user['addressLine2'], ['min' => 2, 'max' => 255])) {
			$errors[] = "Address Line 2 must be between 2 and 255 characters.";
		}

		//Address3 length min 1 max 25
  		if (!has_length($user['addressLine3'], ['min' => 2, 'max' => 25])) {
			$errors[] = "Zip Code must be between 2 and 25 characters.";
		}

		//City length min 1 max 255
  		if (!has_length($user['cityName'], ['min' => 2, 'max' => 255])) {
			$errors[] = "City must be between 2 and 255 characters.";
		}

		//Phone Number length min 1 max 25
  		if (!has_length($user['phoneNumber'], ['min' => 4, 'max' => 25])) {
			$errors[] = "Phone Number must be between 4 and 25 characters.";
		}

/*		//Password length min 4 max 12
  		if (!has_length($user['password'], ['min' => 4, 'max' => 12])) {
			$errors[] = "Password must be between 4 and 12 characters.";
		}

		//Password match
		if (!password_match($user['password'], $user['password2'])) {
			$errors[] = "Passwords must match.";
		}*/

		return $errors;
  	}










?>