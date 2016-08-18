<?php if(! defined('BASEPATH')) exit('No direct script access allowed');

	/**
	*  signup model
	*/
	class Cancel_app_model extends CI_model
	{
		
	   function cancel_app($input) 
		{
			$ipJson = json_encode($input);
			//echo $email;die();
 
 $this->db->select('date_time_slot,doc_id_fk');
		
			$this->db->from('appointment');
			$this->db->where('patient_id',$input['patient_id']);
			$query = $this->db->get();
			//echo $this->db->last_query();

			$details = $query->result();
			//print_r($details);
			//exit();		
			return $details;

            
					
		}
		function update_app($input)
		{
			$ipJson = json_encode($input);
			$this->db->set('status','2');
			$this->db->where('patient_id',$input['patient_id']);
			$this->db->update('appointment');
			
			//$query = $this->db->get();

			//$details = $query->result();		
			//return $details;
		}


 
   
	}
	


?>