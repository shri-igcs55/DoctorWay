<?php

/*

	0	-	field name

	1	-	field value

	2	-	validation type

	3	-	field description

	4	-	error description

	5	-	+/- if numeric validation,
			minimum limit for name validation

	6	-	maximum limit for name validation

Validation Type

	not_null
	email
	url
	username
	password
	name
	name_space
	price
	numeric
	alphanumeric
	phone,fax
	zip
	date
	datetimecheck

*/


class Validator{

	var $errorMesg;
	var $errorDesc;
	var $errorArray;
	var $result;

	function validate($ipArray){
		$this->errorMesg = "Error: Invalid input";
		$this->errorDesc = "";
		$this->errorArray = array();
		$this->result = "";

		if( !empty($ipArray) && is_array($ipArray) ){

			foreach($ipArray as $inputs){

				$this->errorDesc = "";

				if( !empty($inputs[0]) && !empty($inputs[2]) ){

					if(!$this->isNotNull($inputs[1])){
						$error = "1";
					}
					else{

						$error = "";
						switch($inputs[2]){

							case "not_null":

								if(!$this->isNotNull($inputs[1])){
									$error = "1";
								}

								break;

							case "email":

								if(!$this->isValidEmail($inputs[1])){
									$error = "1";
								}

								break;

							case "url":

								if(!$this->isValidUrl($inputs[1])){
									$error = "1";
								}

								break;

							case "username":

								$limitArray = array();

								if(!empty($inputs[5])){
									$limitArray[] = $inputs[5];
								}

								if(!empty($inputs[6])){
									$limitArray[] = $inputs[6];
								}

								if(! $this->isValidName($inputs[1], "username", $limitArray)){
									$error = "1";
								}

								break;

							case "name":

								$limitArray = array();

								if(!empty($inputs[5])){
									$limitArray[] = $inputs[5];
								}

								if(!empty($inputs[6])){
									$limitArray[] = $inputs[6];
								}

								if(! $this->isValidName($inputs[1],"", $limitArray)){
									$error = "1";
								}

								break;

							case "name_space":

								$limitArray = array();

								if(!empty($inputs[5])){
									$limitArray[] = $inputs[5];
								}

								if(!empty($inputs[6])){
									$limitArray[] = $inputs[6];
								}

								if(! $this->isValidNameSpace($inputs[1],"", $limitArray)){
									$error = "1";
								}

								break;

							case "price":

								if(!empty($inputs[5])){
									if(! $this->isDecimalPositive($inputs[1], $inputs[5])){
										$error = "1";
									}
								}
								else{
									if(! $this->isDecimalPositive($inputs[1])){
										$error = "1";
									}
								}

								break;

							case "numeric":
								if(!empty($inputs[5])){
									$sign = $inputs[5];
								}else{
									$sign = "";
								}

								if(!$this->isNumeric($inputs[1], $sign)){
									$error = "1";
								}

								break;

							case "alphanumeric":

								$limitArray = array();

								if(!empty($inputs[5])){
									$limitArray[] = $inputs[5];
								}

								if(!empty($inputs[6])){
									$limitArray[] = $inputs[6];
								}

								if(!$this->isAlphaNumeric($inputs[1], $limitArray)){
									$error = "1";
								}

								break;

							case "password":

								$limitArray = array();

								if(!empty($inputs[5])){
									$limitArray[] = $inputs[5];
								}

								if(!empty($inputs[6])){
									$limitArray[] = $inputs[6];
								}

								if(!$this->isPassword($inputs[1], $limitArray)){
									$error = "1";
								}

								break;

							case "alphanumericwithspace":

								$limitArray = array();

								if(!empty($inputs[5])){
									$limitArray[] = $inputs[5];
								}

								if(!empty($inputs[6])){
									$limitArray[] = $inputs[6];
								}

								if(!$this->isAlphaNumericWithSpace($inputs[1], $limitArray)){
									$error = "1";
								}

								break;

							case "phone":
								if(! $this->isValidPhone($inputs[1])){
									$error = "1";
								}

								break;
							case "fax":

								if(! $this->isValidPhone($inputs[1])){
									$error = "1";
								}

								break;

							case "zip":

								if(! $this->isValidPostalCode($inputs[1])){
									$error = "1";
								}

								break;

							case "date":

								if(! $this->isValidDateFormat($inputs[1])){
									$error = "1";
								}

								break;

							case "datetimecheck":

								if(! $this->isValidDateTimeFormat($inputs[1])){
									$error = "1";
								}

								break;

							default:

								$this->errorArray['error'][] = "Error: Invalid validation type ".$inputs[2];

								break;

						}

					}

					if(!empty($this->errorDesc)){
						$this->errorArray[$inputs[0]] = "Error: ".$inputs[3]." ".$this->errorDesc;
					}
					else{

						if(!empty($error)){

							if(!empty($inputs[4])){
								$this->errorArray[$inputs[0]] = $inputs[4];
							}elseif(!empty($inputs[3])){
								$this->errorArray[$inputs[0]] = $this->errorMesg." for ".$inputs[3];
							}else{
								$this->errorArray[$inputs[0]] = $this->errorMesg;
							}
						}

					}

				}
				else{
					$this->errorArray['error'][] = "Error: Invalid Inputs for validation.";
				}

			}

		}

		if(!empty($this->errorArray)){
			return $this->errorArray;
		}
		else{
			$this->result = "1";
			return true;
		}

	}


	function isNotNull($data){

		if(!empty($data)){
			return true;
		}else{
			return false;
		}

	}

	function isValidName($name, $uName="", $limit){

			if(trim($name)==""){
				return false;
			}

			if(!empty($limit[0])){
				if(!$this->isValidCharacterMinLength($name, $limit[0])){
					$this->errorDesc = " should contain atleast ".$limit[0]." characters.";
					return false;
				}
			}

			if(!empty($limit[1])){
				if(!$this->isValidCharacterMaxLength($name, $limit[1])){
					$this->errorDesc = " should contain maximum of ".$limit[1]." characters.";
					return false;
				}
			}

			if(!empty($uName)){
				if(!$this->isAlphaNumeric($name)){
					return false;
				}
			}else{
				if(!$this->isValidChars($name)){
					return false;
				}
			}

			return true;
	}


	function isValidNameSpace($name, $uName="", $limit){

			if(trim($name)==""){
				return false;
			}

			if(!empty($limit[0])){
				if(!$this->isValidCharacterMinLength($name, $limit[0])){
					return false;
				}
			}

			if(!empty($limit[1])){
				if(!$this->isValidCharacterMaxLength($name, $limit[1])){
					return false;
				}
			}

			if(! $this->isAlphabet($name)){
				return false;
			}

			return true;
	}


	function isValidEmail($email){

		if(!preg_match("/^[a-zA-Z0-9\._\-]+@([a-zA-Z0-9\._\-]+\.)+[a-zA-Z0-9]{2,4}$/",$email)){
			return false;
		}else{
			return true ;
		}

	}

	function isValidUrl($url){

		if(!ereg("^http://[a-zA-Z0-9\.\-]+([a-zA-Z0-9\._\-]+\.)+[a-zA-Z0-9]{2,4}$",$url)){
			return false;
		}else{
			return true ;
		}

	}

	function isValidPostalCode($postal){

		if(!empty($postal)){
			if(!ereg("^([0-9]{5}|[0-9]{5}-[0-9]{4})$",$postal)){// the no of digits of the postal code shoul be 5
			//if(!ereg("^[a-z,A-Z]{1,2}[0-9]{1,2} ?[0-9][a-z,A-Z]{2}$",$postal)){	//UK postal code validation
				return false;
			}else{
				return true;
			}
		}else{
			return false;
		}

	}


	function isValidCharacterMaxLength($data, $lengthlimit=50){

		if($data == ""){
			return false; // return false error object if implemented as service
		}else{

			if( (strlen($data) <= $lengthlimit) ){
				return true;
			}
			else{
				return false;
			}

		}
	}

	function isValidCharacterMinLength($data, $lengthlimit=5){

		if($data == ""){
			return false; // return a false object for this;
		}else{

			if( $lengthlimit <= strlen($data) ){
				return true;
			}
			else{
				return false;
			}
		}

	}

	function isAlphabet($data){
		//alphabets with space allowed
		if(!ereg("^([a-zA-Z]+(\ [a-zA-Z]+)*)$|(\=\'\+\&)",$data))
		{
			//$this->setError("Error : Invalid Alphabetical entry.");
			return false; // return a false object for this;
		}
		else
		{
			return true;
		}
	}

	function isValidPhone($data){
		if(!empty($data)){
			//if(!ereg("(^[0-9]{10}|[0-9]{3}-[0-9]{3}-[0-9]{4}|\([0-9]{3}\)[0-9]{7}|[0-9]{3}\.[0-9]{3}\.[0-9]{4}|[0-9]{3}\ [0-9]{3}\ [0-9]{4}))*$",$data)){    // the no of digits of the phone should be 10
			//if(!ereg("^([0-9]{5}(()|-|\ )|\([0-9]{5}\)-)[0-9]{6}$",$data)){	//UK Phone validation
			if(!ereg("(^[0-9]{3}-[0-9]{3}-[0-9]{4})$",$data)) {
				return false; // return a false object for this;
			}
			else if(!$this->isValidCharacterMaxLength($data, "10")){
				//$this->errorDesc = "should contain maximum of 10 digits.";
				return false;
			} else {
				return true;
			}
		}
		else{
			return false;
		}

	}
/*
	function isValidPhone($data){

		if(!$this->isValidCharacterMinLength($data, "6")){
			$this->errorDesc = "should contain atleast 6 digits.";
			return false;
		}

		if(!$this->isValidCharacterMaxLength($data, "11")){
			$this->errorDesc = " should contain maximum of 11 digits.";
			return false;
		}

		if(!ereg("(^[0-9]*)$",$data)){
			return false; // return a false object for this;
		}
		else{
			return true;
		}

	}
*/	
	function isNumeric($data, $sign){
		if(!empty($sign)){
			if($sign == "+"){
				if(!$this->isNumericPositiveWithoutSpace($data)){
					$this->errorDesc = " should be positive integer.";
					return false;
				}
			}else{
				if(!$this->isNumericNegative($data)){
					$this->errorDesc = " should be negative integer.";
					return false;
				}
			}
		}
		else{

			if(!preg_match("/^(-?[0-9]*)$/",$data)){//interger with optional -ve
				return false; // return a false object for this;
			}else{
				return true;
			}
		}
		return true;
	}


	function isNumericPositiveWithoutSpace($data){
	 		//Numerals with Only +ve allowed
			if(!ereg("^([0-9]*)$",$data)){ 
				return false; // return a false object for this;
			}else{ 
				return true;
			}
	}

	function isNumericNegative($data){

	 		//Numerals with Only -ve allowed
			if(!ereg("^-([0-9]*)$",$data)){
				return false; // return a false object for this;
			}
			else{
				return true;
			}

	}

    	function isAlphaNumeric($data,$limit=array()){

		if(!empty($limit[0])){
			if(!$this->isValidCharacterMinLength($data, $limit[0])){
				$this->errorDesc = " should contain atleast ".$limit[0]." characters.";
				return false;
			}
		}

		if(!empty($limit[1])){
			if(!$this->isValidCharacterMaxLength($data, $limit[1])){
				$this->errorDesc = " should contain maximum of ".$limit[0]." characters.";
				return false;
			}
		}

		//if(!ereg("^(([a-zA-Z]+[0-9]*)*)$|^(([a-zA-Z]+[0-9]*[a-zA-Z]+)*)$|(\=\'\+\&)",$data))
		if(!ereg("^[a-zA-Z]([a-zA-Z0-9]*)$",$data)){
			return false; // return a false object for this;
		}else{
			return true;
		}

	}

	function isPassword($data,$limit=array()){

		if(!preg_match("^([a-zA-Z0-9`~!@#$%\^&*()-_=+\|{}?><.,\/]*)$^",$data)){
			return false; // return a false object for this;
		}else{
			return true;
		}
	}


    	function isAlphaNumericWithSpace($data,$limit=array()){

		if(!empty($limit[0])){
			if(!$this->isValidCharacterMinLength($data, $limit[0])){
				$this->errorDesc = " should contain atleast ".$limit[0]." characters.";
				return false;
			}
		}

		if(!empty($limit[1])){
			if(!$this->isValidCharacterMaxLength($data, $limit[1])){
				$this->errorDesc = " should contain maximum of ".$limit[0]." characters.";
				return false;
			}
		}

		//if(!ereg("^(([a-zA-Z]+[0-9]*)*)$|^(([a-zA-Z]+[0-9]*[a-zA-Z]+)*)$|(\=\'\+\&)",$data))
		if(!ereg("^[a-zA-Z\ ]([a-zA-Z0-9\ ]*)$",$data)){
			return false; // return a false object for this;
		}else{
			return true;
		}

	}

    	function isValidChars($data){

		//if(!ereg("^(([a-zA-Z]+[0-9]*)*)$|^(([a-zA-Z]+[0-9]*[a-zA-Z]+)*)$|(\=\'\+\&)",$data))
		//if(!ereg("^([a-zA-Z\ ]+[0-9]*)*$",$data)){
		if(!ereg("^[a-zA-Z\ ]*$",$data)){
			return false; // return a false object for this;
		}else{
			return true;
		}

	}

	function isValidDateFormat($data){

		if (!ereg ("^([0-9]{1,2})/([0-9]{1,2})/([0-9]{4})$", $data )) {
		//if (!ereg ("^([0-9]{1,2})/([0-9]{1,2})/([0-9]{4}) [0-9]{2}:[0-9]{2}:[0-9]{2} [A-Z]{2}$", $data )) {
		//if (!ereg ("^([0-9]{4})-([0-9]{1,2})-([0-9]{1,2})$", $data )) {
			return false;
		}
		else{
			return true;
		}

	}

	function isValidDateTimeFormat($data){

		if (!ereg ("^([0-9]{1,2})/([0-9]{1,2})/([0-9]{4}) [0-9]{2}:[0-9]{2}:[0-9]{2} [A-Z]{2}$", $data )) {
			return false;
		}
		else{
			return true;
		}

	}


	function isDecimalPositive($data, $limit=""){

		if(!empty($limit)){

			if(strlen($data) >= $limit){
				$str_pos = strpos($data, ".");
				if(empty($str_pos) || ($str_pos > $limit - 1)){
					return false;
				}
			}

		}

		//allow numeric as well as decimal number
		if (!ereg ("^(([0-9]+\.[0-9]{1,2})|([0-9]{1,10}))$",$data)){
			return false; // return a false object for this;
		} else {
			return true;
		}

	}
}
?>
