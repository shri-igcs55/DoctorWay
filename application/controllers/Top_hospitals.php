<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
	
	require('application/libraries/REST_Controller.php');  
	//error_reporting(0);

	/**
	* Sign up form controller
	*/
	class Top_hospitals extends REST_Controller
	{
		public function Top_hospitals() {
			parent::__construct();

			 $this->load->model('top_hosp_model');
			//$this->load->library('seekahoo_lib');
		}
		
		public function hospitals_post()
		{
			$serviceName = 'hospitals';
			//getting posted values
			$ip['show_type'] = trim($this->input->post('show_type'));
			$ipJson = json_encode($ip);
			    if (($ip['show_type'])==1)
                {
                	$data['top_hospitals'] =$this->top_hosp_model->top_hospital($ip);
                    $retVals1 = $this->seekahoo_lib->return_status('success', $serviceName, $data, $ipJson);
               	}
				else
				{
                    $data['all_hospitals'] =$this->top_hosp_model->all_hospital($ip);
                    $retVals1 = $this->seekahoo_lib->return_status('success', $serviceName, $data, $ipJson);
				}
				
				//validation
				$validation_array = 1;
									
				$ip_array[] = array("show_type", $ip['show_type'], "not_null", "show_type", "Field is empty.");
			
				$validation_array = $this->validator->validate($ip_array);
				
				
        		if ($validation_array !=1) 
				{
				 $data['message'] = $validation_array;
				 $retVals1 = $this->seekahoo_lib->return_status('error', $serviceName, $data, $ipJson);
				} 



		          header("content-type: application/json");
		          echo $retVals1;
		          exit;
	    }

	}
?>