<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
	
	require('application/libraries/REST_Controller.php');  
	//error_reporting(0);

	/**
	* Sign up form controller
	*/
	class Hos_reviewlist extends REST_Controller
	{
		public function Hos_reviewlist() {
			parent::__construct();

			$this->load->model('hos_reviewlist_model');
			//$this->load->library('seekahoo_lib');
}
		
		public function hos_reviewlist_post()
		{
			$serviceName = 'hos_reviewlist';
			//getting posted values
			$ip['hos_id'] = trim($this->input->post('hos_id'));
			

			    
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
						$retVals = $this->hos_reviewlist_model->hos_reviewlist($ip, $serviceName);
						$data['message'] = $retVals;
					 $retVals1 = $this->seekahoo_lib->return_status('success', $serviceName, $data, $ipJson);

					}



			          header("content-type: application/json");
			          echo $retVals1;
			          exit;
	     	}

	}
?>