<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
	
	require('application/libraries/REST_Controller.php');  
	//error_reporting(0);

	/**
	* Sign up form controller
	*/
	class Self_book extends REST_Controller
	{
		public function Self_book() {
			parent::__construct();

			$this->load->model('self_book_model');
			//$this->load->library('seekahoo_lib');
}
		
		public function self_book_post()
		{
			$serviceName = 'self_book';
			//getting posted values
			$ip['hos_id'] = trim($this->input->post('hos_id'));
			$ip['doc_id'] = trim($this->input->post('doc_id'));			

			    
			$ipJson = json_encode($ip);
			//print_r($ipJson);
			//exit();
			//validation
			$validation_array = 1;
									
					$ip_array[] = array("hos_id", $ip['hos_id'], "not_null", "hos_id", "Field is empty.");
				
					$validation_array = $this->validator->validate($ip_array);
					
					
            if ($validation_array !=1) 
					{
					 $data['message'] = $validation_array;
					 $retVals1 = $this->seekahoo_lib->return_status('error', $serviceName, $data, $ipJson);
					} 
					else {
						$retVals = $this->self_book_model->self_book($ip, $serviceName);
						$data['confirm booking details'] = $retVals;
					
						
					 $retVals1 = $this->seekahoo_lib->return_status('success', $serviceName, $data, $ipJson);

					}



			          header("content-type: application/json");
			          echo $retVals1;
			          exit;
	     	}

	}
?>