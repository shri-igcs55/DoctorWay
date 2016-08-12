<?php if(! defined('BASEPATH')) exit('No direct script access allowed');

	/**
	*  signup model
	*/
	class about_doc_model extends CI_model
	{
		
	   public function about_doc() 
		{
			$this->db->select(['status','description']);
			$this->db->from('about');
			$this->db->where('status','Approved');
			$query = $this->db->get();
			//echo $this->db->last_query($query);exit();
			return $query->result();
        }

		


	}
	


?>