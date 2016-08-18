<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

/**
* Model for signin
*/
class Signin_model extends CI_model
{
  
  public function check_signin($input, $serviceName) {
    //echo "string";
    $ipJson = json_encode($input);
      
      $this->db->select('uid, username, email, patient_id, phone_number, status');
      $this->db->from('user_reg');
      $this->db->where('email', $input['email']);
      $this->db->where('password', base64_encode($input['password']));
      $query = $this->db->get();
      $resultRows = $query->num_rows();
      //print_r($resultRows);exit();
      $result = $query->result();
      
      if ($resultRows > 0) {
        //print_r($result[0]->pass);exit();
        $data['details'] = $result;
        $data['message'] = 'Login Successfully';
        $status = $this->seekahoo_lib->return_status('success', $serviceName, $data, $ipJson);
      }
      else {
        $data['message'] = 'Email address and Password does not match';
        $status = $this->seekahoo_lib->return_status('error', $serviceName, $data, $ipJson);
      }
    return $status;
  }
}

?>