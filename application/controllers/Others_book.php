<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
	
	require('application/libraries/REST_Controller.php');  
	//error_reporting(0);

	/**
	* Sign up form controller
	*/
	class Others_book extends REST_Controller
	{
		public function Others_book() {
			parent::__construct();

			$this->load->model('others_book_model');
			$this->load->library('seekahoo_lib');
			$this->load->library('Validator.php');
}
		
		public function others_book_post()
		{
			$serviceName = 'others_book';
			//getting posted values
			$ip['name']             = trim($this->input->post('name'));
			$ip['phone']            = trim($this->input->post('phone'));	
			$ip['email']            = trim($this->input->post('email'));
			$ip['gender']           = trim($this->input->post('gender'));
			$ip['dob']              = trim($this->input->post('dob'));
			$ip['doctor_id']     = trim($this->input->post('doctor_id'));
			//$input['doc_name']       = trim($this->input->post('doc_name'));
			$ip['hos_id']         = trim($this->input->post('hos_id'));
			//$input['hos_name']       = trim($this->input->post('hos_name'));
			$ip['date_time_slot'] = trim($this->input->post('date_time_slot'));
			$ip['status']         = trim($this->input->post('status'));
			$ip['asid_fk']        = trim($this->input->post('asid_fk'));
			//$ip['pat_id'] = trim($this->input->post('pat_id'));		

			    
			$ipJson = json_encode($ip);
			//print_r($ipJson);
			//exit();
			//validation
			$validation_array = 1;
									
			$ip_array[] = array("name", $ip['name'], "not_null", "name", "Field is empty.");
			$ip_array[] = array("email", $ip['email'], "not_null", "email", "Field is empty.");
			$ip_array[] = array("gender", $ip['gender'], "not_null", "gender", "Field is empty.");
				
					$validation_array = $this->validator->validate($ip_array);
					
					
            if ($validation_array !=1) 
					{
					 $data['message'] = $validation_array;
					 $retVals1 = $this->seekahoo_lib->return_status('error', $serviceName, $data, $ipJson);
					} 
					else {
						$retVals1 = $this->others_book_model->others_book($ip, $serviceName);
						$data['confirm booking details'] = $retVals1;
					
						
					 //$retVals1 = $this->seekahoo_lib->return_status('success', $serviceName, $data, $ipJson);

					}



			          header("content-type: application/json");
			          echo $retVals1;
			          exit;
	     	}

	}
?>