<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	
	require('application/libraries/REST_Controller.php');  
	//error_reporting(0);

	/**
	* Sign up form controller
	*/
	class Ab_doctorway extends REST_Controller
	{
		public function Ab_doctorway() {
			parent::__construct();

			$this->load->model('about_doc_model');
			$this->load->library('seekahoo_lib');
		}
		
		public function about_post()
		{
			$serviceName = 'Ab_doctorway';
			//getting posted values
			$ip['value']    = trim($this->input->post('value'));
								
			$ipJson = json_encode($ip);
           
			//validation
			$validation_array = 1;
									
					$ip_array[] = array("value", $ip['value'], "not_null", "value", "Value field is empty.");

					$validation_array = $this->validator->validate($ip_array);
					
					if ($validation_array !=1) 
					{
					 $data['message'] = $validation_array;
					 $retVals1 = $this->seekahoo_lib->return_status('error', $serviceName, $data, $ipJson);
					} 
					else if($ip['value']=='1')//Adding
					{
						 $data['data'] =$this->about_doc_model->about_doc($ip,$serviceName);
					    $retVals1 = $this->seekahoo_lib->return_status('success', $serviceName, $data, $ipJson);
					}

				    else if($ip['value']=='2')//Removing
					{						 
						$data['data'] =$this->about_doc_model->about_doc($ip,$serviceName);
					    $retVals1 = $this->seekahoo_lib->return_status('success', $serviceName, $data, $ipJson);
					}


     		          //echo $retVals1 = $this->signup_model->signup($ip, $serviceName);
			          header("content-type: application/json");
			          echo $retVals1;
			          exit;
	     	}

	}
?>