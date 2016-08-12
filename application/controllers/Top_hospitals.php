<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
	
	require('application/libraries/REST_Controller.php');  
	//error_reporting(0);

	/**
	* Sign up form controller
	*/
	class Top_hospitals extends REST_Controller
	{
		public function hospitals() {
			parent::__construct();

			$this->load->model('Top_hosp_model');
			//$this->load->library('seekahoo_lib');
}
		
		public function hospitals_post()
		{
			$serviceName = 'hospitals';
			//getting posted values
			$ip['show_type'] = trim($this->input->post('show_type'));
			

			    if (($ip['show_type'])==1)
                {
               	  $hi =$this->Top_hosp_model->top_hospital($ip['show_type']);
               		var_dump($hi);exit();
				}
				else
				{
                  $all_hospitals=$this->Top_hosp_model->top_hospital($ip['top_hospital']);
				}
			$ipJson = json_encode($ip);
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