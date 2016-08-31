<?php if(! defined('BASEPATH')) exit('No direct script access allowed');

	/**
	*  signup model
	*/
	class Upcoming_app_model extends CI_model
	{
		
	   function upcoming_app($input) 
		{
			$ipJson = json_encode($input);
			//echo $email;die();

			$this->db->select('a.hospital_name,a.hospital_img_url,b.doctor_name,b.doctor_img_url,c.date_time_slot,d.speciality_name');
		
			$this->db->from('hospitals a');
			$this->db->join('doctor b', 'a.hospital_id = b.dr_hospital_id_fk', 'left');
			$this->db->join('appointment c', 'b.doctor_id = c.doc_id_fk', 'left');
			$this->db->join('specialities d', 'b.doctor_speciality = d.speciality_id', 'left');
			$this->db->where('a.hospital_id',$input['hos_id']);
			$this->db->where('c.patient_id',$input['patient_id']);
			//$this->db->where('c.date_time_slot >=',$input['date']);
			$this->db->where('c.date_time_slot >= NOW()',NULL, FALSE);
			$query = $this->db->get();
			//echo $this->db->last_query();

			$details = $query->result();
			//print_r($details);
			//exit();		
			return $details;

            
					
		}


 
  
 function hospital_speciality($input)
  {
  	$ipJson = json_encode($input);
  	$this->db->select('b.speciality_name');
  	$this->db->from('hospital_specialities a');
  	$this->db->join('specialities b', 'a.speciality_id_fk=b.speciality_id');
  	$this->db->where('a.hospital_id_fk',$input['hos_id']);
  	$this->db->where('a.status','current');
  	$query = $this->db->get();
  	$details = $query->result();
  	//$result = $query->num_rows();
  	return $details;
  } 
	}
	


?>