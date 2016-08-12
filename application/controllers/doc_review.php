<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	
	require('application/libraries/REST_Controller.php');  
	//error_reporting(0);
	class Doc_review extends REST_Controller
	{
	public function Doc_review(){
	parent::__construct();
	$this->load->model('doc_review_model');
	
	}
	public function doc_review_post(){
		$serviceName = 'review';
	
	        $input['user_id']       = trim($this->input->post('user_id'));
			$input['doc_id']        = trim($this->input->post('doc_id'));
			$input['feedback']      = trim($this->input->post('feedback'));
			$input['rating']        = trim($this->input->post('rating'));
			
			
			
			$ipJson = json_encode($input);
			
			$validation_array = 1;
			$ip_array[] = array("feedback", $input['feedback'], "not_null", "feedback", "Feedback is empty.");

					$ip_array[] = array("rating", $input['rating'], "not_null", "rating", "Rating is empty.");
					
					 if ($validation_array !=1) {
						$data['message'] = $validation_array;
						 $retVals1 = $this->seekahoo_lib->return_status('error', $serviceName, $data, $ipJson);

					}else if($this->doc_review_model->check_user($input['user_id'],$input['doc_id'])){
                     $data['message'] = 'User alerady given feedback.';
					 $retVals1 = $this->seekahoo_lib->return_status('error', $serviceName, $data, $ipJson);

					} else {
						$retVals1 = $this->doc_review_model->doc_review($input,$serviceName);
					//$data['details'] = $input;
					//	$data['message'] = 'Success';
					//	$retVals1 = $this->seekahoo_lib->return_status('success', $serviceName, $data, $ipJson);
					
					}
					header("content-type: application/json");
			          echo $retVals1;
			          exit;
	}

	
	}