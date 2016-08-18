<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	
	require('application/libraries/REST_Controller.php');  
	//error_reporting(0);

	/**
	* Sign up form controller
	*/
	class Speciality extends REST_Controller
	{
		public function Speciality() {
			parent::__construct();

			$this->load->model('speciality_model');
			//$this->load->library('seekahoo_lib');
		}
		
		public function special_post()
		{
			$serviceName = 'specility';
			//getting posted values
			$ip['specility'] = trim($this->input->post('specility'));
			
			$ipJson = json_encode($ip);
           
			//validation
			$validation_array = 1;
									
					$ip_array[] = array("specility", $ip['specility'], "not_null", "specility", "specility Field is empty.");
					
					$validation_array = $this->validator->validate($ip_array);
			
					if ($validation_array !=1) 
					{
					 $data['message'] = $validation_array;
					 $retVals1 = $this->seekahoo_lib->return_status('error', $serviceName, $data, $ipJson);
					} 
					else if ($ip['specility']=='1') 
					{      
						 $data['data'] = $this->speciality_model->get_speciality($ip,$serviceName);
					     $retVals1 = $this->seekahoo_lib->return_status('success', $serviceName, $data, $ipJson);
					}
				   


     		          //echo $retVals1 = $this->signup_model->signup($ip, $serviceName);
			          header("content-type: application/json");
			          echo $retVals1;
			          exit;
	     	}

	}
?>