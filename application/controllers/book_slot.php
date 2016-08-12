<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
	
	require('application/libraries/REST_Controller.php');  
	//error_reporting(0);

	/**
	* Sign up form controller
	*/
	class Book_slot extends REST_Controller
	{
		public function Book_slot() {
			parent::__construct();

			$this->load->model('book_slot_model');
			//$this->load->library('seekahoo_lib');
}
		
		public function book_slot_post()
		{
			$serviceName = 'book_slot';
			//getting posted values
			$ip['doc_id'] = trim($this->input->post('doc_id'));
			$ip['user_id'] = trim($this->input->post('user_id'));
			$ip['start_date'] = trim($this->input->post('start_date'));
			$ip['end_date'] = trim($this->input->post('end_date'));			

			    
			$ipJson = json_encode($ip);
			//print_r($ipJson);
			//exit();
			//validation
			$validation_array = 1;
									
					$ip_array[] = array("start_date", $ip['start_date'], "not_null", "start_date", "Field is empty.");
				
					$validation_array = $this->validator->validate($ip_array);
					
					
            if ($validation_array !=1) 
					{
					 $data['message'] = $validation_array;
					 $retVals1 = $this->seekahoo_lib->return_status('error', $serviceName, $data, $ipJson);
					} 
					else {
						
						$retVals4 = $this->book_slot_model->book_slot($ip, $serviceName);
						if ($retVals4 == 0)
						{
							$data['slot'] = '1';//booked
						} else {
							$data['slot'] = '2';//Available
						}

						$data['Booking Slots'] = $retVals4;
					 $retVals1 = $this->seekahoo_lib->return_status('success', $serviceName, $data, $ipJson);

					}



			          header("content-type: application/json");
			          echo $retVals1;
			          exit;
	     	}

	}
?>