<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	
	require('application/libraries/REST_Controller.php');  
	//error_reporting(0);
	class Appointment extends REST_Controller
	{
	public function Appointment(){
	parent::__construct();
	$this->load->model('appointment_model');
	
	}
	public function appointment_post(){
		$serviceName = 'appointment';
	
	        $input['patient_name']       = trim($this->input->post('patient_name'));
			$input['doc_id']        = trim($this->input->post('doc_id'));
			$input['email']      = trim($this->input->post('email'));
			$input['phone']        = trim($this->input->post('phone'));
			$input['hos_id']        = trim($this->input->post('hos_id'));
			$input['date_time_slot']        = trim($this->input->post('date_time_slot'));
			$input['status']        = trim($this->input->post('status'));
			$input['asid_fk']        = trim($this->input->post('asid_fk'));
			
			
			
			$ipJson = json_encode($input);
			
			$validation_array = 1;
			$ip_array[] = array("phone", $input['phone'], "not_null", "phone", "Phone is empty.");

					$ip_array[] = array("patient_name", $input['patient_name'], "not_null", "patient_name", "patient_name is empty.");
					$ip_array[] = array("email", $input['email'], "not_null", "email", "email is empty.");
					
					 if ($validation_array !=1) {
						$data['message'] = $validation_array;
						 $retVals1 = $this->seekahoo_lib->return_status('error', $serviceName, $data, $ipJson);

					} else {
						$retVals1 = $this->appointment_model->appointment($input,$serviceName);
					//$data['details'] = $input;
					//	$data['message'] = 'Success';
					//	$retVals1 = $this->seekahoo_lib->return_status('success', $serviceName, $data, $ipJson);
					
					}
					header("content-type: application/json");
			          echo $retVals1;
			          exit;
	}

	
	}