<?php if(! defined('BASEPATH')) exit('No direct script access allowed');

	/**
	*  signup model
	*/
	class Doc_reviewlist_model extends CI_model
	{
		
	   function doc_reviewlist($input) 
		{
			$ipJson = json_encode($input);
			//echo $email;die();

			$this->db->select('doctor_feedback.feedback, doctor_feedback.rating,user_reg.username');
			$this->db->select("DATE_FORMAT(doctor_feedback.created_on, '%d %b %Y') AS date ", FALSE);
			$this->db->from('doctor_feedback');
			$this->db->join('user_reg', 'doctor_feedback.user_id = user_reg.uid', 'left');
			$this->db->where('doctor_feedback.doc_id',$input['doc_id']);
			$query = $this->db->get();
			//echo $this->db->last_query();

			$details = $query->result();
			//print_r($details);
			//exit();		
			return $details;

					
		}
		
 
    







	}
	


?>