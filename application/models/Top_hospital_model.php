<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Top_hospital_model extends CI_Model {

	function getAllTopHos(){
		$query = $this->db->select('top_hospital.thid,top_hospital.hospital_id_fk,top_hospital.status,hospitals.hospital_name')
						  ->from('top_hospital')
						  ->join('hospitals','hospitals.hospital_id = top_hospital.hospital_id_fk ')
						  ->get();
		return $query->result();
	}

	function getAllTopHosById($id){
		$query = $this->db->select('top_hospital.thid,top_hospital.hospital_id_fk,top_hospital.status,hospitals.hospital_name')
						  ->from('top_hospital')
						  ->join('hospitals','hospitals.hospital_id = top_hospital.hospital_id_fk ')
						  ->where('thid',$id)
						  ->get();
		return $query->row();
	}

	function getHospitalApproved(){
		$query = $this->db->select('top_hospital.thid,top_hospital.hospital_id_fk,top_hospital.status,hospitals.hospital_name,hospitals.hospital_img_url,hospital_address.address_line_1,hospital_address.city')
							->from('top_hospital')
							->join('hospitals','hospitals.hospital_id = top_hospital.hospital_id_fk ')
							->join('hospital_address','hospital_address.hospital_id_fk = top_hospital.hospital_id_fk ')
							->where('top_hospital.status','Approved')
							->get();
		return $query->result();
	}

	function getAllTopHospital(){
		$query = $this->db->select('top_hospital.thid,top_hospital.hospital_id_fk,top_hospital.status,hospitals.hospital_name,hospitals.hospital_img_url,hospital_address.address_line_1,hospital_address.city')
							->from('top_hospital')
							->join('hospitals','hospitals.hospital_id = top_hospital.hospital_id_fk ')
							->join('hospital_address','hospital_address.hospital_id_fk = top_hospital.hospital_id_fk ')
							->get();
		return $query->result();
	}

	function store_top_hos($hospital_id){
		$data['hospital_id_fk'] = $hospital_id;
		$data['status'] = 'Pending';
		$data['created_on'] = Date('Y-m-d H:i:s');
		$data['updated_on'] = Date('Y-m-d H:i:s');

		$ins = $this->db->insert('top_hospital',$data);
		return $ins;
	}

	function update_top_hos($hospital_id,$id){
		$data['hospital_id_fk'] = $hospital_id;
		$data['status'] = 'Pending';
		$data['updated_on'] = Date('Y-m-d H:i:s');

		$up = $this->db->where('thid',$id)
						->update('top_hospital',$data);
		return $up;
	}

	function approve($id,$data){
		$q = $this->db->set('status',$data)
				 ->where('thid',$id)
				 ->update('top_hospital');
		if($q){
			return true;
		}
		else{
			return false;
		}	
	}

	function check_approve($data){
		$query = $this->db->where('status',$data)
				 ->get('top_hospital');
		if($query->num_rows() >= 4){
			return true;
		} else{
			return false;
		}
	}

	public function deleteTopHosById($hos_id){
		$this->db->where('thid', $hos_id);
		$this->db->delete('top_hospital');
	}
}
?>