<?php if(! defined('BASEPATH')) exit('No direct script access allowed');

	/**
	*  signup model
	*/
	class list_fav_model extends CI_model
	{
		
	   public function all_hospital($input,$serviceName)
      {
      	$ipJson = json_encode($input);
      	$query = $this->db->select('*')
                          ->from('favorite_tbl')
                          ->join('hospitals','hospitals.hospital_id = favorite_tbl.id')
                          ->join('hospital_address','hospital_address.hospital_id_fk = hospitals.hospital_id ')
                          ->where('favorite_tbl.user_id',$input['user_id'])
                          ->where('favorite_tbl.type',1)
                          ->get();
        return $query->result();
     }

    function all_doctors($input,$serviceName)
    {
        $ipJson = json_encode($input);
        $query = $this->db->select('*')
                          ->from('favorite_tbl')
                          ->join('doctor','doctor.doctor_id = favorite_tbl.id')
                          ->join('specialities','specialities.speciality_id = doctor.doctor_speciality')
                          ->where('favorite_tbl.user_id',$input['user_id'])
                          ->where('favorite_tbl.type',2)
                          ->get();
        return $query->result();
    }    







	}
	


?>