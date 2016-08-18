<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	
	require('application/libraries/REST_Controller.php');  
	//error_reporting(0);

	/**
	* Sign up form controller
	*/
	class Change_pass extends REST_Controller
	{
		public function chng_pass() {
			parent::__construct();

			$this->load->model('change_pass_model');
			//$this->load->library('seekahoo_lib');
    }
		
		public function chng_pass_post()
		{
			$serviceName = 'update';
			//getting posted values
			$ip['old_pass']    = trim($this->input->post('old_pass'));
			$ip['new_pass']    = trim($this->input->post('new_pass'));
		    $ip['c_pass']      = trim($this->input->post('cn_pass'));
		    $ip['mobile']      = trim($this->input->post('mobile'));
		    $ip['patient_id']  = trim($this->input->post('patient_id'));
		    $ip['user_name']  = trim($this->input->post('user_name'));

			//var_dump($_FILES['user_pic']);exit();
           // print_r($ip); exit();
			if (!null==($ipJson = json_encode($ip)))
                {
               	/*=================GENRAING OTP=====================*/
	            $user="developer2@indglobal-consulting.com:indglobal123";

			    $sender ="TEST SMS";
			    $number = $ip['mobile'];
			    $name   = $ip['user_name'];
			    $message="Hi:".$name." Your Password is Changed Successfully You can Login in Few minutes - DOCTORWAY"; 
			    $ipJson = json_encode($ip);
                $this->load->model('change_pass_model');
			    $chk_pass=$this->change_pass_model->c_pass($ip);
                /*=================ENDING OF GENRAING OTP=====================*/
				}
			
			//validation
			$validation_array = 1;
									
					$ip_array[] = array("old_pass", $ip['old_pass'], "not_null", "old_pass", "Old password is empty.");

					$ip_array[] = array("new_pass", $ip['new_pass'], "not_null", "new_pass", "New password is Empty.");
					
					$ip_array[] = array("c_pass", $ip['c_pass'], "not_null", "c_pass", "Conifirm password is empty.");

					$ip_array[] = array("mobile", $ip['mobile'], "not_null", "mobile", "Mobile number is empty.");

					$ip_array[] = array("patient_id", $ip['patient_id'], "not_null", "patient_id", "Patient id is empty.");

					$validation_array = $this->validator->validate($ip_array);
					
					/*if ($this->update_model->c_pass($ip)) 
					{
					 $data['message'] = 'Mobile number alerady registered.';
					 $retVals1 = $this->seekahoo_lib->return_status('error', $serviceName, $data, $ipJson);
					} 

					else if ($this->update_model->c_pass($ip)) 
					{
					 $data['message'] = 'Email address alerady registered.';
					 $retVals1 = $this->seekahoo_lib->return_status('error', $serviceName, $data, $ipJson);
					}

					else*/ 
                    if($ip['new_pass'] != $ip['c_pass'])
					 {
				     $data['message'] = "Password missmatch.";
				     $retVals1 = $this->seekahoo_lib->return_status('error', $serviceName, $data, $ipJson);
                     }

					else if ($validation_array !=1) 
					{
					 $data['message'] = $validation_array;
					 $retVals1 = $this->seekahoo_lib->return_status('error', $serviceName, $data, $ipJson);
					} 

					else if ($chk_pass=="True") 
					{
					 //$done_simple=$this->update_model->updt_status_simple($ip);
					 $data['message'] = "Paasword matched";
					 $retVals1 = $this->seekahoo_lib->return_status('success', $serviceName, $data, $ipJson);

					 /*===============Sending Otp==================*/
                         $ch = curl_init();
			               curl_setopt($ch,CURLOPT_URL,  "http://api.mVaayoo.com/mvaayooapi/MessageCompose");
			               curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			               curl_setopt($ch, CURLOPT_POST, 1);
			               curl_setopt($ch, CURLOPT_POSTFIELDS, "user=".$user."&senderID=".$sender."&receipientno=".$number."&msgtxt=".$message."");
			               $buffer = curl_exec($ch);
			   
			               curl_close($ch);
					  /*===============Sending Otp===================*/
					} 
					else  
					{
					  //$done_otp=$this->update_model->updt_status_with($ip);
					  $data['message'] = "Paasword not matched from database";
					  $retVals1 = $this->seekahoo_lib->return_status('success', $serviceName, $data, $ipJson);
					  
					}

     		          //echo $retVals1 = $this->signup_model->signup($ip, $serviceName);
			          header("content-type: application/json");
			          echo $retVals1;
			          exit;
	     	}

	}
?>