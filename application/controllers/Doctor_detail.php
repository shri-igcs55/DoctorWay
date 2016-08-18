<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	
	require('application/libraries/REST_Controller.php');  
	//error_reporting(0);

	/**
	* Doctor Details controller
	*/
	class Doctor_detail extends REST_Controller
	{
		public function Doctor_detail() {
			parent::__construct();

			$this->load->model('doctor_det_model');
			$this->load->library('seekahoo_lib');
		}
		
		public function doc_details_post()
		{
			$serviceName = 'Doctor_detail';
			//getting posted values
			$ip['doc_id']    = trim($this->input->post('doc_id'));
			$ip['user_id']    = trim($this->input->post('user_id'));
								
			$ipJson = json_encode($ip);
           
			//validation
			$validation_array = 1;
									
					$ip_array[] = array("doc_id", $ip['doc_id'], "not_null", "doc_id", "Can not find Doctor Id.");
					$ip_array[] = array("user_id", $ip['user_id'], "not_null", "user_id", "Can not find User Id.");

					$validation_array = $this->validator->validate($ip_array);
					
					if ($validation_array !=1) 
					{
					 $data['message'] = $validation_array;
					 $retVals1 = $this->seekahoo_lib->return_status('error', $serviceName, $data, $ipJson);
					} 
					else if(!null==$ip['doc_id'])//Adding
					{
						$doc_det =$this->doctor_det_model->doctor_det($ip,$serviceName);
						$qual =$this->doctor_det_model->doctor_det_byid($ip,$serviceName);
						$fav =$this->doctor_det_model->fav_by_id($ip,$serviceName);
						 foreach ($qual as $qualkey => $qualval) 
						 {	 	
						    $quall[]=$qualval['qualification'];
						 }
						 if($fav)
						 $doc_det['0']->favourite=1;
						 else
						 $doc_det['0']->favourite=2;	
						 $imploded_quall=implode(",",$quall);
						 $doc_det['0']->qualification=$imploded_quall;
					     $retVals1 = $this->seekahoo_lib->return_status('success', $serviceName, $doc_det, $ipJson);
					}
			          header("content-type: application/json");
			          echo $retVals1;
			          exit;
	     	}

	}
?>