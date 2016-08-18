<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	
	require('application/libraries/REST_Controller.php');  
	//error_reporting(0);

	/**
	* Sign up form controller
	*/
	class Recover_pass extends REST_Controller
	{
		public function Recover_pass() {
			parent::__construct();

			$this->load->model('recover_model');
			//$this->load->library('seekahoo_lib');
        }
		
		public function recover_post()
		{
			$six_digit_random_number = mt_rand(100000, 999999);
			$serviceName = 'user_signup';
			
			$ip['mobile']   = trim($this->input->post('mobile'));
			$ipJson = json_encode($ip);
		
			if (empty($ip['mobile']))
            {    
            	
                $data['message'] = "Mobile number is null....";
				$retVals1 = $this->seekahoo_lib->return_status('error', $serviceName, $data, $ipJson);
		         //json_decode($retVals1);	
				}
			    else 
			    {    
			    	 $chkmob=$this->recover_model->recover($ip);
			  
                     if($chkmob=="true")
		             {
		             	 $six_digit_random_number = mt_rand(10000000, 99999999);
		             	 //echo $six_digit_random_number;exit()
				         $ipJson = json_encode($ip);
			             $data['message'] = "Password sent to number";
					     $retVals1 = $this->seekahoo_lib->return_status('success', $serviceName, $data, $ipJson); 
					     /*==================Sending Otp Again=====================*/ 
                           $user="developer321322@indglobal-consulting.com:indglobal123";

					    $sender="TEST SMS";
					    $number = $ip['mobile'];
					    $message="Your Temporary Password is :".$six_digit_random_number." To change Your Paasword Login with this Please do not share this password with Anyone - Doctorway"; 
					               
					    $ch = curl_init();
					    curl_setopt($ch,CURLOPT_URL, "http://api.mVaayoo.com/mvaayooapi/MessageCompose");
					    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
					    curl_setopt($ch, CURLOPT_POST, 1);
					    curl_setopt($ch, CURLOPT_POSTFIELDS, "user=".$user."&senderID=".$sender."&receipientno=".$number."&msgtxt=".$message."");
					    $buffer = curl_exec($ch);
					   
					    curl_close($ch);
					    /*==================Sending Otp Again=====================*/
					    /*==================Updating Otp Again=====================*/
                        $upuser = array( 
                					   'password' => base64_encode($six_digit_random_number),
                					   );
                        $user = $this->recover_model->updt_pass($ip,$upuser);
					    /*==================Updating Otp Again=====================*/
				     
		             }
		             else
		             {
		             	$data['message'] = "Please Sign up first";
					    $retVals1 = $this->seekahoo_lib->return_status('error', $serviceName, $data, $ipJson);	
		             }

				        
		        }
			        header("content-type: application/json");
			        echo $retVals1;
			        exit;
	     	}

	}
?>