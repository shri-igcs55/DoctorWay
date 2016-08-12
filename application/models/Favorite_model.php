<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Favorite_model extends CI_Model {

	function favorite_add($val){
		$data['id'] = $val['id'];
		$data['type'] = $val['type'];
		$data['user_id'] = $val['uid'];
		$data['created_on'] = Date('Y-m-d H:i:s');
		$data['updated_on'] = Date('Y-m-d H:i:s');

		$ins = $this->db->insert('favorite_tbl',$data);
		return $ins;
	}

	function getAllFav(){
		$query = $this->db->get('favorite_tbl');
		return $query->result();
	}


	function getFavHosById(){

		$query = $this->db->select('*')
						  ->from('favorite_tbl')
						  ->join('hospitals','hospitals.hospital_id = favorite_tbl.id')
						  ->join('hospital_address','hospital_address.hospital_id_fk = hospitals.hospital_id ')
						  ->where('favorite_tbl.user_id',$this->session->userdata['user_logged_in']['user_id'])
						  ->where('favorite_tbl.type',1)
						  ->get();
		return $query->result();
	}

	function getFavDocById(){

		$query = $this->db->select('*')
						  ->from('favorite_tbl')
						  ->join('doctor','doctor.doctor_id = favorite_tbl.id')
						  ->join('specialities','specialities.speciality_id = doctor.doctor_speciality')
						  ->where('favorite_tbl.user_id',$this->session->userdata['user_logged_in']['user_id'])
						  ->where('favorite_tbl.type',2)
						  ->get();
		return $query->result();
	}



	function remove_fav($id){
		$query = $this->db->where('fid',$id)
						  ->delete('favorite_tbl');
		if($query){
			return true;
		} 
	}

	function favorite_del($id,$type){
		$query = $this->db->where('id',$id)
						  ->where('type',$type)
						  ->delete('favorite_tbl');
		if($query){
			return 'true';
		} else{
			return 'false';
		}
	}
	
}
?>