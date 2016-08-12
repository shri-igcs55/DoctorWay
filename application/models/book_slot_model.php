<?php if(! defined('BASEPATH')) exit('No direct script access allowed');

	
	class Book_slot_model extends CI_model
	{
		function book_slot($input)
		{
			
          $ipJson = json_encode($input);
          //$start = $input['start_date'];
          //$end = $input['end_date'];
			$this->db->select('date_time_slot');
			$this->db->from('appointment');
			$this->db->where('date_time_slot >=', $input['start_date']);
			$this->db->where('date_time_slot <=', $input['end_date']);
			$this->db->where('doc_id_fk',$input['doc_id']);
			$this->db->or_where('status !=','2');
			
			$query = $this->db->get();
			echo $this->db->last_query();
//echo $test= $this->db->last_query($query);exit();
			$details = $query->result();
			print_r($details);
			exit();		
			return $details;
		}

		

	}
	?>