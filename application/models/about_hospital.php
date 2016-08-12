<?php if(! defined('BASEPATH')) exit('No direct script access allowed');

	/**
	*  signup model
	*/
	class About_hospital_model extends CI_model
	{
		
	   function about_hospital($input) 
		{
			$ipJson = json_encode($input);
			//echo $email;die();

			$this->db->select('a.hospital_name,a.hospital_about,a.hospital_img_url,b.address_line_1,b.address_line_2,b.city,b.state,b.country,b.latitude,b.longitude,(count(c.feedback))');
		
			$this->db->from('hospitals a');
			$this->db->join('hospital_address b', 'a.hospital_id = b.hospital_id_fk', 'left');
			$this->db->join('hospital_feedback c', 'b.hospital_id_fk = c.hos_id', 'left');
			$this->db->where('a.hospital_id',$input['hos_id']);
			$query = $this->db->get();
			//echo $this->db->last_query();

			$details = $query->result();
			//print_r($details);
			//exit();		
			return $details;

					
		}
		
 
    







	}
	


?>