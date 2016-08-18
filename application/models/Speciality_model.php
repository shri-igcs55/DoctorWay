<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Speciality_model extends CI_Model {
    //Start of function to create speciality
    public function speciality_create(){
        $data = array(
                'speciality_name' => $this->input->post('speciality_name'),
                'speciality_created_on' => date('Y-m-d H:i:s')
            );
       $query =  $this->db->insert('specialities', $data);
       return $query;
    }
    //End of function to create functionality

    //Start of function to get the list of specialities
    public function getAllSpecialities(){
        $query = $this->db->get_where('specialities', array(
            'speciality_is_active' => 1,
            ));
       // var_dump($query->result());
        //exit;
        return $query->result();
    }
    //End of function to get the list of specialities

    //Start of function to get detail of speciality by id
    public function getSpecialityById($speciality_id){
        $data = $this->db->get_where('specialities',array(
                'speciality_id' => $speciality_id,
            ));
        $query = $data->result()[0];
        return $query;
    }
    //End of function to get detail of speciality by id

    //Start of function to update speciality
    public function update_speciality($speciality_id){
        $data = array(
                'speciality_name' => $this->input->post('speciality_name'),
                'speciality_updated_on' => date('Y-m-d H:i:s')
            );

        $this->db->where('speciality_id', $speciality_id);
        $this->db->update('specialities', $data);
    }
    //End of function to update speciality

    //Start of function to delete specialtity
    public function delete_speciality($speciality_id){
        $this->db->where('speciality_id', $speciality_id);
        $this->db->delete('specialities');
    }
    //End of function to delete speciality
	
	public function get_speciality($input,$serviceName)
	{
		$ipJson = json_encode($input);
		$this->db->select(['speciality_id','speciality_name','speciality_is_active']);
		$this->db->from('specialities');
		$this->db->where('speciality_is_active',1);
		$query = $this->db->get();
		return $query->result();
	}
}