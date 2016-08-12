<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	
	require('application/libraries/REST_Controller.php');  
	//error_reporting(0);

	/**
	* Sign up form controller
	*/
	class List_fav extends REST_Controller
	{
		public function List_fav() {
			parent::__construct();

			$this->load->model('list_fav_model');
			//$this->load->library('seekahoo_lib');
		}
		
		public function favrourite_post()
		{
			$serviceName = 'Favourite';
			//getting posted values
			$ip['user_id'] = trim($this->input->post('user_id'));
			$ip['type'] = trim($this->input->post('type'));
			
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
					else if ($ip['type']=='1') 
					{      
						 $data['message'] = $this->list_fav_model->all_hospital($ip,$serviceName);
					     $retVals1 = $this->seekahoo_lib->return_status('success', $serviceName, $data, $ipJson);
					}
					else if ($ip['type']=='2') 
					{
						 $data['message'] = $this->list_fav_model->all_doctors($ip,$serviceName);
					     $retVals1 = $this->seekahoo_lib->return_status('success', $serviceName, $data, $ipJson);	
					}

				   


     		          //echo $retVals1 = $this->signup_model->signup($ip, $serviceName);
			          header("content-type: application/json");
			          echo $retVals1;
			          exit;
	     	}

	}
?>