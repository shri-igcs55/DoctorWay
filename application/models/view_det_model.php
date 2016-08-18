<?php if(! defined('BASEPATH')) exit('No direct script access allowed');

	/**
	*  signup model
	*/
	class view_det_model extends CI_model
	{
		
	   public function view_det($input,$serviceName)
      {
      	$ipJson = json_encode($input);

        $this->db->select(['uid','username','user_pic','patient_id','email','phone_number','status','blood_group','gender','dob','city']);
        $this->db->from('user_reg');
        $this->db->where('uid',$input['user_id']);
        $query = $this->db->get();
        // echo $this->db->last_query();
        return $query->result_array();
      	 
     }



	}
	


?>