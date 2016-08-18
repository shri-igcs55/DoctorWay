<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
	
	require('application/libraries/REST_Controller.php');  
	//error_reporting(0);

	/**
	* Sign up form controller
	*/
	class Doc_reviewlist extends REST_Controller
	{
		public function Doc_reviewlist() {
			parent::__construct();

			$this->load->model('doc_reviewlist_model');
			//$this->load->library('seekahoo_lib');
}
		
		public function doc_reviewlist_post()
		{
			$serviceName = 'doc_reviewlist';
			//getting posted values
			$ip['doc_id'] = trim($this->input->post('doc_id'));
			

			    
			$ipJson = json_encode($ip);
			//print_r($ipJson);
			//exit();
			//validation
			$validation_array = 1;
									
					$ip_array[] = array("doc_id", $ip['doc_id'], "not_null", "doc_id", "Field is empty.");
				
					$validation_array = $this->validator->validate($ip_array);
					
					
            if ($validation_array !=1) 
					{
					 $data['message'] = $validation_array;
					 $retVals1 = $this->seekahoo_lib->return_status('error', $serviceName, $data, $ipJson);
					} 
					else {
						$retVals = $this->doc_reviewlist_model->doc_reviewlist($ip, $serviceName);
						$data['message'] = $retVals;
					 $retVals1 = $this->seekahoo_lib->return_status('success', $serviceName, $data, $ipJson);

					}



			          header("content-type: application/json");
			          echo $retVals1;
			          exit;
	     	}

	}
?>