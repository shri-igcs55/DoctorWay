<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	
	require('application/libraries/REST_Controller.php');  
	//error_reporting(0);

	/**
	* Sign up form controller
	*/
	class Favourite extends REST_Controller
	{
		public function Favourite() {
			parent::__construct();

			$this->load->model('favourite_model');
			//$this->load->library('seekahoo_lib');
		}
		
		public function favrourite_post()
		{
			$serviceName = 'Favourite';
			//getting posted values
			$ip['h_id'] = trim($this->input->post('h_id'));
			$ip['type']    = trim($this->input->post('type'));
			$ip['user_id']   = trim($this->input->post('user_id'));
			$ip['remove']   = trim($this->input->post('remove'));
					
			$ipJson = json_encode($ip);
           
			//validation
			$validation_array = 1;
									
					$ip_array[] = array("h_id", $ip['h_id'], "not_null", "h_id", "Hospital id is empty.");

					$ip_array[] = array("type", $ip['type'], "not_null", "type", "Selection type is empty.");
					
					$ip_array[] = array("user_id", $ip['user_id'], "not_null", "user_id", "Users id is empty.");
					
					$validation_array = $this->validator->validate($ip_array);
					
					


					if ($validation_array !=1) 
					{
					 $data['message'] = $validation_array;
					 $retVals1 = $this->seekahoo_lib->return_status('error', $serviceName, $data, $ipJson);
					} 
					else if($ip['remove']=='1')//Adding
					{
						 $retVals1=$this->favourite_model->favourite_submit($ip,$serviceName);
					}

				    else if($ip['remove']=='2')//Removing
					{
						 $this->favourite_model->remove_favourite($ip,$serviceName);
						 $data['message'] ="Favourite Removed";
					     $retVals1 = $this->seekahoo_lib->return_status('success', $serviceName, $data, $ipJson);
					}


     		          //echo $retVals1 = $this->signup_model->signup($ip, $serviceName);
			          header("content-type: application/json");
			          echo $retVals1;
			          exit;
	     	}

	}
?>