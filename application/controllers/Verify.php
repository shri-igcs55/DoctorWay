<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	
	require('application/libraries/REST_Controller.php');  
	//error_reporting(0);

	/**
	* Verify otp form controller
	*/
	class Verify extends REST_Controller
	{
		public function Verify()
		 {
		  parent::__construct();
		  $this->load->model('verify_model');
		  $this->load->library('email');
		 }
		
		public function verify_post()
		{
			$serviceName = 'verify';
			$ip['v_code']     = trim($this->input->post('v_code'));
            $ip['mobile_num'] = trim($this->input->post('mobile_num'));
            $ip['email']      = trim($this->input->post('email'));
            $ipJson = json_encode($ip);
            if(empty($ip['v_code']) && empty($ip['mobile_num']))
            {
               $data['message'] = "Feilds are Required";
			   $retVals1 = $this->seekahoo_lib->return_status('error', $serviceName, $data, $ipJson);
            } 
            else
            {
                $chkotp=$this->verify_model->check_otp($ip);
               
                 if($chkotp=="true")
                 {
                 	$code =$ip['v_code'];
                 	$data['message'] = "OTP Matched";
                 	$retVals1 = $this->seekahoo_lib->return_status('success', $serviceName, $data, $ipJson);
                 	$up_status = array(
								       'status' => 'Verify'
					                  );
                 	$chkotp=$this->verify_model->update_status($up_status,$code);
                        
                    /*======================Mailing Part======================*/
			        $from_email = "Anuragdubey@gmail.com"; 
			        $to_email = $this->input->post('email'); 
			   
			        $this->email->from($from_email, 'Doctor Way'); 
			        $this->email->to($to_email);
			        $this->email->subject('Email Test'); 
			        $this->email->message('Testing the email class.');
                    /*=====================Ending Mailing Part====================*/   

                 }
            	else 
	            {
    	        	$data['message'] = "OTP Not Matching";
			    	$retVals1 = $this->seekahoo_lib->return_status('error', $serviceName, $data, $ipJson);
           	    }
        }



			
										

	        //echo $retVals1 = $this->signup_model->signup($ip, $serviceName);
            header("content-type: application/json");
            echo $retVals1;
            exit;
	     	}

	}
?>