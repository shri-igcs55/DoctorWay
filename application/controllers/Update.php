<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	
	require('application/libraries/REST_Controller.php');  
	//error_reporting(0);

	/**
	* Sign up form controller
	*/
	class Update extends REST_Controller
	{
		public function update() {
			parent::__construct();

			$this->load->model('update_model');
			$this->load->library('upload');
			//$this->load->library('seekahoo_lib');
    }
		
		public function update_post()
		{
			$six_digit_random_number = mt_rand(100000, 999999);
			$serviceName = 'update';
			//getting posted values
			$ip['user_pic']    = trim($this->input->post('user_pic'));
			$ip['blood_group'] = trim($this->input->post('blood_group'));
		    $ip['gender']      = trim($this->input->post('gender'));
			$ip['dob']         = trim($this->input->post('dob'));
		    $ip['city']        = trim($this->input->post('city'));
			$ip['user_id']     = trim($this->input->post('user_id'));
			$ip['username']    = trim($this->input->post('username'));
			$ip['email']       = trim($this->input->post('email'));
			$ip['mobile']      = trim($this->input->post('mobile'));
			$ip['patient_id']  = trim($this->input->post('patient_id'));
			$ip['otp']         = $six_digit_random_number;
			//var_dump($_FILES['user_pic']);exit();
           // print_r($ip); exit();
			if (!null==($ipJson = json_encode($ip)))
                {
               	/*=================GENRAING OTP=====================*/
	            $user="developer27788@indglobal-consulting.com:indglobal123";

			    $sender="TEST SMS";
			    $number = $ip['mobile'];
			    $message="Your One Time Password is :".$six_digit_random_number." For confirm the registration. Please do not share this password with Anyone - DOCTORWAY"; 
			    $ipJson = json_encode($ip);


                $uploadPhoto[] = array('profile_org_url'=>'', 'type'=>'image', 'profile_thumb_url'=>'', 'photo_id'=>'');

			    $chkmob=$this->update_model->check_update($ip,$uploadPhoto);
                /*=================ENDING OF GENRAING OTP=====================*/
				}
			
			//validation
			$validation_array = 1;
									
					$ip_array[] = array("name", $ip['username'], "not_null", "name", "Name is empty.");

					$ip_array[] = array("email", $ip['email'], "email", "email_id", "Email is Empty.");
					
					$ip_array[] = array("mobile", $ip['mobile'], "not_null", "mobile", "Mobile Number is empty.");
					$validation_array = $this->validator->validate($ip_array);
					
					if ($this->update_model->check_mob($ip)) 
					{
					 $data['message'] = 'Mobile number alerady registered.';
					 $retVals1 = $this->seekahoo_lib->return_status('error', $serviceName, $data, $ipJson);
					} 

					else if ($this->update_model->check_email($ip)) 
					{
					 $data['message'] = 'Email address alerady registered.';
					 $retVals1 = $this->seekahoo_lib->return_status('error', $serviceName, $data, $ipJson);
					}

					else if ($validation_array !=1) 
					{
					 $data['message'] = $validation_array;
					 $retVals1 = $this->seekahoo_lib->return_status('error', $serviceName, $data, $ipJson);
					} 

					else if ($chkmob=="True") 
					{
				//$done_simple=$this->update_model->updt_status_simple($ip,$uploadPhotos);
					 $data['message'] = "Profile updated succesfully";
					 $retVals1 = $this->seekahoo_lib->return_status('success', $serviceName, $data, $ipJson);
					} 
					else  
					{
					//$done_otp=$this->update_model->updt_status_with($ip,$uploadPhotos);
					  $data['message'] = "Profile updated status pending";
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

                      $patient_id = $ip['patient_id'];
					  $upic = $_FILES['user_pic'];
					  



					} 
        
                      //echo $retVals1 = $this->signup_model->signup($ip, $serviceName);
			          header("content-type: application/json");
			          echo $retVals1;
			          exit;
	     	}
 

            







       

	}
?>