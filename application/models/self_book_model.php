<?php if(! defined('BASEPATH')) exit('No direct script access allowed');

	
	class Self_book_model extends CI_model
	{
		function self_book($input)
		{
			
          $ipJson = json_encode($input);
          //$start = $input['start_date'];
          //$end = $input['end_date'];
			$this->db->select('a.hospital_name,b.doctor_name');
			$this->db->from('hospitals a');
			$this->db->join('doctor b', 'a.hospital_id=b.dr_hospital_id_fk', 'left');
			$this->db->where('a.hospital_id',$input['hos_id']);
			$this->db->where('b.doctor_id',$input['doc_id']);
				
			$query = $this->db->get();
			//echo $this->db->last_query();
//echo $test= $this->db->last_query($query);exit();
			$details = $query->result();
			//print_r($details);
			//exit();		
			return $details;
		}

		

	}
	?>