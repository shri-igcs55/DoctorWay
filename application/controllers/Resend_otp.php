<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	
	require('application/libraries/REST_Controller.php');  
	//error_reporting(0);

	/**
	* Sign up form controller
	*/
	class Resend_otp extends REST_Controller
	{
		public function Resend_otp() {
			parent::__construct();

			$this->load->model('resend_model');
			//$this->load->library('seekahoo_lib');
        }
		
		public function resend_post()
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
			    	 $chkmob=$this->resend_model->check_mob($ip);
                     if($chkmob=="true")
		             {
		             	 $six_digit_random_number = mt_rand(100000, 999999);
				         $ipJson = json_encode($ip);
			             $data['message'] = "Otp send to number";
					     $retVals1 = $this->seekahoo_lib->return_status('success', $serviceName, $data, $ipJson); 
					     /*==================Sending Otp Again=====================*/ 
                           $user="developer2222@indglobal-consulting.com:indglobal123";

					    $sender="TEST SMS";
					    $number = $ip['mobile'];
					    $message="Your One Time Password is :".$six_digit_random_number." For confirm the registration. Please do not share this password with Anyone - Doctorway"; 
					               
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
                					   'otp' => $six_digit_random_number,
                					   );
                        $user = $this->resend_model->updt_otp($ip,$upuser);
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