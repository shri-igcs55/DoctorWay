<?php if(! defined('BASEPATH')) exit('No direct script access allowed');

	/**
	*  signup model
	*/
	class top_hosp_model extends CI_model
	{
		
	   public function top_hospital() 
		{
			$query = $this->db->select('top_hospital.thid,top_hospital.hospital_id_fk,top_hospital.status,hospitals.hospital_name,hospitals.hospital_img_url,hospital_address.address_line_1,hospital_address.city')
			->from('top_hospital')
			->join('hospitals','hospitals.hospital_id = top_hospital.hospital_id_fk ')
			->join('hospital_address','hospital_address.hospital_id_fk = top_hospital.hospital_id_fk ')
			->where('top_hospital.status','Approved')->get();
			return $query->result();
        }

		


		public function all_hospital($input) 
		{
			$ipJson = json_encode($input);
			$this->db->select(['hospital_id','hos_id_fk','hospital_name','hospital_about','hospital_img_url','insurance','status','created_on','updated_on']);
			$this->db->from('hospitals');
			$query = $this->db->get();
			//echo $this->db->last_query($query);exit();
			$details = $query->result();		
			return $details;
					
		}
		
 
    







	}
	


?>