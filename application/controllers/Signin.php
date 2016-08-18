<?php if(!defined('BASEPATH')) exit('No direct script access allowed');
	require('application/libraries/REST_Controller.php');
/**
* controller for signin
*/
class Signin extends REST_Controller{
	
	public function Signin() {
		parent::__construct();

		$this->load->model('signin_model');
		//$this->load->library('seekahoo_lib');
	}

	public function user_signin_post(){
		$serviceName = 'user_signin';
		//getting posted values
		$ip['email'] = trim($this->input->post('email'));
		$ip['password'] = trim($this->input->post('password'));
		$ipJson = json_encode($ip);
		//validation
		$validation_array = 1;
			$ip_array[] = array("email", $ip['email'], "email", "email_id", "Wrong or Invalid Email address.");
			$ip_array[] = array("password", $ip['password'], "not_null", "password", "Password is empty.");
			$validation_array = $this->validator->validate($ip_array);
			if ($validation_array !=1) {
				$data['message'] = $validation_array;
				$retVals = $this->seekahoo_lib->return_status('error', $serviceName, $data, $ipJson);
			} 
			else {
				$retVals = $this->signin_model->check_signin($ip, $serviceName);
			}
		
		header("content-type: application/json");
		echo $retVals;
		exit;
	}
}
?>