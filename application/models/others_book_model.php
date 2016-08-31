<?php if(! defined('BASEPATH')) exit('No direct script access allowed');
date_default_timezone_set('Asia/Kolkata');

class Others_book_model extends CI_model
{
function others_book($input, $serviceName){

$ipJson = json_encode($input);
//echo $ipJson;exit();
$data = array(
 'patient_id'       => strtotime(Date('Y-m-d H:i:s')),
 'name'             => $input['name'],
 'doc_id_fk'        => $input['doctor_id'],
 'email'            => $input['email'],
 'phone'            => $input['phone'],
 'dr_hospital_id_fk'=> $input['hos_id'],
 'date_time_slot'   => $input['date_time_slot'],
 'status'           => $input['status'],
 'asid_fk'          => $input['asid_fk'],
  //'gender' =>$input['gender']
  //'date_of_birth'=>$input['date_of_birth']

 );



 
 
 $query = $this->db->insert('appointment', $data);



if ($query == 1) {
					
					$last_id = $this->db->insert_id();

$data = array(
	'ap_id_fk' => $last_id,
    'pat_id'   => strtotime(Date('Y-m-d H:i:s')),
    'oname' => $input['name'],
    'ophone' => $input['phone'],
    'oemail' => $input['email'],
    'ogender' => $input['gender'],
    'odob' => $input['dob']
    );
$query = $this->db->insert('appointment_other', $data);
}
if ($query == 1) {
					
					$last_id = $this->db->insert_id();

					//$this->db->select('a.name,a.patient_id,a.doc_id_fk,a.date_time_slot,a.phone,b.doctor_name');
				    //$this->db->from('appointment a');
				    //$this->db->join('doctor b', 'a.dr_hospital_id_fk=b.dr_hospital_id_fk');
				    $this->db->select('a.oname,a.pat_id,a.ophone,a.odob,a.ogender,b.date_time_slot,c.doctor_name');
				    $this->db->from('appointment_other a');
				    $this->db->join('appointment b', 'a.ap_id_fk = b.id', 'left');
				    $this->db->join('doctor c', 'b.dr_hospital_id_fk = c.dr_hospital_id_fk', 'left');
					$this->db->where('oid', $last_id );


				    $detail_last_user = $this->db->get();
				    $resultq = $detail_last_user->result();
				    
					
					$data = $resultq;
					

					$status = $this->seekahoo_lib->return_status('success', $serviceName, $data, $ipJson);

				}
				else {
					$data['message'] = ' Try Again.';
					$status = $this->seekahoo_lib->return_status('Error', $serviceName, $data, $ipJson);
				}
				return $status;


			
		}


}