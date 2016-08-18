<?php if(! defined('BASEPATH')) exit('No direct script access allowed');
date_default_timezone_set('Asia/Kolkata');

class Appointment_model extends CI_model
{
function appointment($input, $serviceName){

$ipJson = json_encode($input);
//echo $ipJson;exit();
$data = array(
	'patient_id' => strtotime(Date('Y-m-d H:i:s')),
 'name'    =>$input['patient_name'],
 'doc_id_fk'     => $input['doc_id'],
 'email'   => $input['email'],
 'phone'     => $input['phone'],
 'dr_hospital_id_fk'     => $input['hos_id'],
 'date_time_slot'     => $input['date_time_slot'],
 'status'     => $input['status'],
  'asid_fk'     => $input['asid_fk'],
  //'gender' =>$input['gender']
  //'date_of_birth'=>$input['date_of_birth']

 );



 
 
 $query = $this->db->insert('appointment', $data);



if ($query == 1) {
					
					$last_id = $this->db->insert_id();
					$this->db->select('a.name,a.patient_id,a.doc_id_fk,a.date_time_slot,a.phone,b.doctor_name');
				    $this->db->from('appointment a');
				    $this->db->join('doctor b', 'a.dr_hospital_id_fk=b.dr_hospital_id_fk');
					$this->db->where('id', $last_id );


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