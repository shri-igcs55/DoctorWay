<?php if(! defined('BASEPATH')) exit('No direct script access allowed');

	/**
	*  signup model
	*/
	class Top_hosp_model extends CI_model
	{
		
	   function top_hospital($input) 
		{
			$ipJson = json_encode($input);
			//echo $email;die();
			$this->db->select('*');
			$this->db->from('top_hospital');
			$this->db->where('status',$input['show_type']);
			$query = $this->db->get();
			$details = $query->result();		
			return $details;
					
		}
		
 
    







	}
	


?>