<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	
	require('application/libraries/REST_Controller.php');  
	//error_reporting(0);

	/**
	* Sign up form controller
	*/
	class View_detail extends REST_Controller
	{
		public function View_detail() {
			parent::__construct();

			$this->load->model('view_det_model');
			//$this->load->library('seekahoo_lib');
		}
		
		public function viewdet_post()
		{
			$serviceName = 'View detail';
			//getting posted values
			$ip['user_id'] = trim($this->input->post('user_id'));
						
			$ipJson = json_encode($ip);
           
			//validation
			$validation_array = 1;
									
					$ip_array[] = array("user_id", $ip['user_id'], "not_null", "user_id", "Users id is empty.");
					

					$validation_array = $this->validator->validate($ip_array);
			
					if ($validation_array !=1) 
					{
					 $data['message'] = $validation_array;
					 $retVals1 = $this->seekahoo_lib->return_status('error', $serviceName, $data, $ipJson);
					} 
					else if (isset($ip['user_id'])) 
					{      
						 $data['data'] = $this->view_det_model->view_det($ip,$serviceName);
					     $retVals1 = $this->seekahoo_lib->return_status('success', $serviceName, $data, $ipJson);

					     json_decode($retVals1);
					}
					
     		          //echo $retVals1 = $this->signup_model->signup($ip, $serviceName);
			          header("content-type: application/json");
			          echo $retVals1;
			          exit;
	     	}

	}
?>