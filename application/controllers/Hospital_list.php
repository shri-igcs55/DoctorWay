<?php defined('BASEPATH') OR exit('No direct script access allowed');
	require('application/libraries/REST_Controller.php');

class Hospital_list extends REST_Controller {

	public function __construct(){
		parent::__construct();
		//exit;
  			$this->load->model('Hospital_list_model');
  			$this->load->model('Speciality_model');
			$this->load->model('Favorite_model');
			$this->load->model('Top_hospital_model');
	}

	public function list_hospital_post(){

		$serviceName = "hospital_list";

		$ip['location'] = trim($this->input->post('location'));
		$ip['spel'] = trim($this->input->post('speciality'));
		$ip['s_date'] = trim($this->input->post('date'));
		$ip['insur'] = trim($this->input->post('insurance'));
		$ip['offset'] = trim($this->input->post('offset'));
		$ip['user_id'] = trim($this->input->post('user_id'));

		$ipJson = json_encode($ip);

		$ip_array[] = array('offset', $ip['offset'], 'not_null', 'Page Number required.');
		$ip_array[] = array('user_id', $ip['user_id'], 'not_null', 'User id required.');

		$validation_array = 1;

		$validation_array = $this->validator->validate($ip_array);
		if ($validation_array != 1) {
			$data['message'] = $validation_array;
			$retVals = $this->seekahoo_lib->return_status('error', $serviceName, $data, $ipJson);
		} else {
			$retVals = $this->Hospital_list_model->searchHosDoc($ip,$serviceName);	
			//$retVals['hospital_addr'] = $this->Hospital_model->getAllHospitalsAddress();
			//$retVals['hospital_image'] = $this->Hospital_model->getAllHospitalsImage();
			//$retVals['special'] = $this->Hospital_model->getAllHospitalsSpl();
			//$retVals['specialities'] = $this->Speciality_model->getAllSpecialities();
			//$retVals['hos_all'] = $this->Top_hospital_model->getAllTopHospital();
			//$retVals['fav'] = $this->Favorite_model->getAllFav();

			//print_r($retVals);exit();
			//$detail_hospital_list = json_decode($retVals);
			$status = $this->seekahoo_lib->return_status('success', $serviceName, $retVals, $ipJson);
		}
		header("content-type: application/json");
		echo $status;
		exit;

	}
	
}
>>>>>>> 98fdd13b8f1052f4c0723dc6f72fdd9679037fe4
