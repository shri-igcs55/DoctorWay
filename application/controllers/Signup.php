<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	
	require('application/libraries/REST_Controller.php');  
	//error_reporting(0);

	/**
	* Sign up form controller
	*/
	class Signup extends REST_Controller
	{
		public function Signup() {
			parent::__construct();

			$this->load->model('signup_model');
			//$this->load->library('seekahoo_lib');
		}
		
		public function user_signup_post()
		{
			$six_digit_random_number = mt_rand(100000, 999999);
			$serviceName = 'user_signup';
			//getting posted values
			$ip['username'] = trim($this->input->post('username'));
			$ip['email']    = trim($this->input->post('email'));
			$ip['mobile']   = trim($this->input->post('mobile'));
			$ip['password'] = trim($this->input->post('password'));
			$ip['c_pass']   = trim($this->input->post('c_pass'));
            $ip['otp']      = $six_digit_random_number;
			//var_dump($_FILES['user_pic']);exit();
           // print_r($ip); exit();
			if (!null==($ipJson = json_encode($ip)))
                {
               	/*=================GENRAING OTP=====================*/
	            $user="developer256789@indglobal-consulting.com:indglobal123";

			    $sender="TEST SMS";
			    $number = $ip['mobile'];
			    $message="Your One Time Password is :".$six_digit_random_number." For confirm the registration. Please do not share this password with Anyone - DOCTORWAY"; 
			               
			    
			    $ipJson = json_encode($ip);
                /*=================ENDING OF GENRAING OTP=====================*/
				}
			
			//validation
			$validation_array = 1;
									
					$ip_array[] = array("name", $ip['username'], "not_null", "name", "Name is empty.");

					$ip_array[] = array("email", $ip['email'], "email", "email_id", "Wrong or Invalid Email address.");
					
					$ip_array[] = array("mobile", $ip['mobile'], "not_null", "mobile", "Mobile Number is empty.");
					$validation_array = $this->validator->validate($ip_array);
					
					if($ip['password'] != $ip['c_pass'])
					 {
				     $data['message'] = "Password missmatch.";
				     $retVals1 = $this->seekahoo_lib->return_status('error', $serviceName, $data, $ipJson);
                     } 
					else if(empty($_POST['password']))
					 {
					  $data['message'] = "Password field empty.";
				      $retVals1 = $this->seekahoo_lib->return_status('error', $serviceName, $data, $ipJson);
					 }


					else if ($this->signup_model->check_mob($ip)) 
					{
					 $data['message'] = 'Mobile number alerady registered.';
					 $retVals1 = $this->seekahoo_lib->return_status('error', $serviceName, $data, $ipJson);
					} 

					else if ($this->signup_model->check_email($ip)) 
					{
					 $data['message'] = 'Email address alerady registered.';
					 $retVals1 = $this->seekahoo_lib->return_status('error', $serviceName, $data, $ipJson);
					}

					else if ($validation_array !=1) 
					{
					 $data['message'] = $validation_array;
					 $retVals1 = $this->seekahoo_lib->return_status('error', $serviceName, $data, $ipJson);
					} 
					else  {
                           $retVals1 = $this->signup_model->signup($ip, $serviceName);
						   $ch = curl_init();
			               curl_setopt($ch,CURLOPT_URL,  "http://api.mVaayoo.com/mvaayooapi/MessageCompose");
			               curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			               curl_setopt($ch, CURLOPT_POST, 1);
			               curl_setopt($ch, CURLOPT_POSTFIELDS, "user=".$user."&senderID=".$sender."&receipientno=".$number."&msgtxt=".$message."");
			               $buffer = curl_exec($ch);
			   
			               curl_close($ch);
			               json_decode($retVals1);	
					      }

     		          //echo $retVals1 = $this->signup_model->signup($ip, $serviceName);
			          header("content-type: application/json");
			          echo $retVals1;
			          exit;
	     	}

	}
?>