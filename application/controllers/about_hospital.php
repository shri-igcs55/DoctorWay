<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
	
	require('application/libraries/REST_Controller.php');  
	//error_reporting(0);

	/**
	* Sign up form controller
	*/
	class About_hospital extends REST_Controller
	{
		public function About_hospital() {
			parent::__construct();

			$this->load->model('about_hospital_model');
			//$this->load->library('seekahoo_lib');
}
		
		public function about_hospital_post()
		{
			$serviceName = 'about_hospital';
			//getting posted values
			$ip['hos_id'] = trim($this->input->post('hos_id'));
			$ip['user_id'] = trim($this->input->post('user_id'));			

			    
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
						$retVals = $this->about_hospital_model->hospital_speciality($ip, $serviceName);
						$data['count speciality'] = count($retVals);
						$retVals = $this->about_hospital_model->about_hospital($ip, $serviceName);
						$data['hospital'] = $retVals;
						$retVals = $this->about_hospital_model->hospital_about($ip, $serviceName);
						$data['hospital_about'] = $retVals;
						//$hos = array_merge($data['hospital'],$data['count speciality']);
						//$hos = $data['hospital'] + $data['count speciality'];
						//$data['hospital'] = $hos;
						
						$retVals2 = $this->about_hospital_model->hospital_image($ip, $serviceName);
						$data['image'] = $retVals2;
						$retVals3 = $this->about_hospital_model->hospital_speciality($ip, $serviceName);
						$data['speciality'] = $retVals3;
						$retVals4 = $this->about_hospital_model->hospital_favourite($ip, $serviceName);
						if ($retVals4 == 0)
						{
							$data['favorite'] = '0';//yes
						} else {
							$data['favorite'] = '1';//no
						}

						$data['speciality'] = $retVals3;
					 $retVals1 = $this->seekahoo_lib->return_status('success', $serviceName, $data, $ipJson);

					}



			          header("content-type: application/json");
			          echo $retVals1;
			          exit;
	     	}

	}
?>