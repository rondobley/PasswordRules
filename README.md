### PasswordRules

This is a class that is used to determine if a password meets a set of
configurable rules. The most basic usage:


	$password = 'qwerty1';
	$passwordRules = new PasswordRules($password);
	if($passwordRules->getIsValid()) {
		// password meets the rules
	} else {
		// password does not meet the rules, get errors
		$passwordRules->getErrors();
	}


Configurable options and their defaults are:

	minLength = 8
	maxLength = 255
	requireAlpha = false
	requireLowercase = false
	requireUppercase = false
	requireNumber = false
	requireSpecialChar = false
	requireNumberOrSpecialChar = false

An example with a more strict set of rules:

	$password = 'Qwerty1!';
	$rules = array(
					'requireAlpha' => true,
					'requireLowercase' => true,
					'requireUppercase' => true,
					'requireNumber' => true,
					'requireSpecialChar' => true
					);
	$passwordRules = new PasswordRules($password, $rules);
	if($passwordRules->getIsValid()) {
		// password meets the rules
	} else {
		// password does not meet the rules, get errors
		$passwordRules->getErrors();
	}

Errors are returned as an array of errors. Each error in the array is an array
with a key corresponding to the error code and a message.

Example format of an array retuned by getErrors() with three errors:

	array(3) {
	  [0]=>
	  array(1) {
	    ["minLength"]=>
	    string(43) "Password must be at least 8 characters long"
	  }
	  [1]=>
	  array(1) {
	    ["noUppercase"]=>
	    string(42) "Password does not have an UPPERCASE letter"
	  }
	  [2]=>
	  array(1) {
	    ["noSpecialChar"]=>
	    string(42) "Password does not have a special character"
	  }
	}


### LICENSE

This project is licensed under the terms of the MIT license. See LICENSE.txt