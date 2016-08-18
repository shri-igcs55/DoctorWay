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
			$input['doc_name']        = trim($this->input->post('doc_name'));
			$input['email']      = trim($this->input->post('email'));
			$input['phone']        = trim($this->input->post('phone'));
			$input['hos_id']        = trim($this->input->post('hos_id'));
			$input['hos_name']        = trim($this->input->post('hos_name'));
			$input['date_time_slot']        = trim($this->input->post('date_time_slot'));
			$input['status']        = trim($this->input->post('status'));
			$input['asid_fk']        = trim($this->input->post('asid_fk'));
				if (!null==($ipJson = json_encode($input)))
                {
               	/*=================GENRAING OTP=====================*/

	            $user="developer2@indglobal-consulting.com:indglobal123";

			    $sender="TEST SMS";
			    $number = $input['phone'];
			    $doctor = $input['doc_name'];
			    $hospital = $input['hos_name'];
			    //print_r($hospital);
			    //exit();
			    $message="Your appointment is booked with Dr.".$doctor." in ".$hospital.""; 
			    //$message="Your appointment is booked ";
			               
			    
			    $ipJson = json_encode($input);
			    //var_dump($ipJson);
			    //exit();
                /*=================ENDING OF GENRAING OTP=====================*/
				}
			
			
			
			//$ipJson = json_encode($input);
			
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
						$retVals1 = $this->appointment_model->appointment($input, $serviceName);
						   $ch = curl_init();
			               curl_setopt($ch,CURLOPT_URL,  "http://api.mVaayoo.com/mvaayooapi/MessageCompose");
			               curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			               curl_setopt($ch, CURLOPT_POST, 1);
			               curl_setopt($ch, CURLOPT_POSTFIELDS, "user=".$user."&senderID=".$sender."&receipientno=".$number."&msgtxt=".$message."");
			               $buffer = curl_exec($ch);
			   
			               curl_close($ch);
			               json_decode($retVals1);
					
					}
					header("content-type: application/json");
			          echo $retVals1;
			          exit;
	}

	
	}