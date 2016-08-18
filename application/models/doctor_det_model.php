<?php if(! defined('BASEPATH')) exit('No direct script access allowed');

	/**
	*  signup model
	*/
	class doctor_det_model extends CI_model
	{
		
	   
 public function doctor_det($input,$serviceName)
    {
 	    $ipJson = json_encode($input);
        $this->db->select('doctor.doctor_id,doctor.dr_hospital_id_fk,doctor.doctor_name,doctor.doctor_img_url, doctor.doctor_about, doctor.experience,doctor.qualification_description,doctor.experience_description,doctor.fee,doctor.status,specialities.speciality_id ,specialities.speciality_name,hospitals.hospital_name,doctor.city,doctor.state,doctor.country,doctor.doctor_speciality');
        $this->db->from('doctor');
        $this->db->join('specialities' ,'specialities.speciality_id = doctor.doctor_speciality', 'left');
        $this->db->join('hospitals' ,'hospitals.hospital_id = doctor.dr_hospital_id_fk', 'left');
        
        $this->db->where('doctor.doctor_id',$input['doc_id']);
        $query = $this->db->get();
        //echo '<pre>'; print_r($query->result());exit();
        return $query->result();
    }



    public function doctor_det_byid($input,$serviceName)
    {
        $this->db->select('qualification');
        $this->db->where('doc_id_fk',$input['doc_id']);
        $this->db->where('status','Current');
        $query = $this->db->get('doctor_qualification');
        return $query->result_array();
    }

   public function fav_by_id($input,$serviceName)
    {
    	
        $this->db->select('*');
        $this->db->where('id',$input['doc_id']);
        $this->db->where('user_id',$input['user_id']);
        $this->db->where('type','2');
        $query = $this->db->get('favorite_tbl');
        //var_dump($query->row());exit();
        return $query->result_array();
    }














		


	}
	


?>