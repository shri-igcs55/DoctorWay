<?php if(! defined('BASEPATH')) exit('No direct script access allowed');

	/**
	*  signup model
	*/
	class speciality_model extends CI_model
	{
		
	   public function get_speciality($input,$serviceName)
      {
      	$ipJson = json_encode($input);
        $this->db->select(['speciality_id','speciality_name','speciality_is_active']);
        $this->db->from('specialities');
        $this->db->where('speciality_is_active',1);
        $query = $this->db->get();
        return $query->result();
      }



	}
	
?>