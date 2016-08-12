<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
	
	require('application/libraries/REST_Controller.php');  
	//error_reporting(0);

	/**
	* Sign up form controller
	*/
	class Cancel_app extends REST_Controller
	{
		public function Cancel_app() {
			parent::__construct();

			$this->load->model('cancel_app_model');
			//$this->load->library('seekahoo_lib');
}
		
		public function cancel_app_post()
		{
			$serviceName = 'cancel_app';
			//getting posted values
			
			$ip['patient_id'] = trim($this->input->post('patient_id'));			

			    
			$ipJson = json_encode($ip);
			//print_r($ipJson);
			//exit();
			//validation
			$validation_array = 1;
									
					$ip_array[] = array("patient_id", $ip['patient_id'], "not_null", "patient_id", "Field is empty.");
				
					$validation_array = $this->validator->validate($ip_array);
					
					
            if ($validation_array !=1) 
					{
					 $data['message'] = $validation_array;
					 $retVals1 = $this->seekahoo_lib->return_status('error', $serviceName, $data, $ipJson);
					} 
					else {
						$retVals = $this->cancel_app_model->update_app($ip, $serviceName);
						$data['cancel'] = $retVals;
						
						//$retVals3 = $this->past_app_model->hospital_speciality($ip, $serviceName);
						//$data['speciality'] = $retVals3;
						
						//$retVals3 = $this->hospital_model->doc_reviewlist($ip, $serviceName);
						//$data['doctor_review_list'] = $retVals3;
					 $retVals1 = $this->seekahoo_lib->return_status('success', $serviceName, $data, $ipJson);

					}



			          header("content-type: application/json");
			          echo $retVals1;
			          exit;
	     	}

	}
?>