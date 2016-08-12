<?php if(! defined('BASEPATH')) exit('No direct script access allowed');

	/**
	*  signup model
	*/
	class Hos_reviewlist_model extends CI_model
	{
		
	   function hos_reviewlist($input) 
		{
			$ipJson = json_encode($input);
			//echo $email;die();

			$this->db->select('hospital_feedback.feedback, hospital_feedback.rating,user_reg.username');
			$this->db->select("DATE_FORMAT(hospital_feedback.created_on, '%d %b %Y') AS date ", FALSE);
			$this->db->from('hospital_feedback');
			$this->db->join('user_reg', 'hospital_feedback.user_id = user_reg.uid', 'left');
			$this->db->where('hospital_feedback.hos_id',$input['hos_id']);
			$query = $this->db->get();
			//echo $this->db->last_query();

			$details = $query->result();
			//print_r($details);
			//exit();		
			return $details;

					
		}
		
 
    







	}
	


?>