<?php if(! defined('BASEPATH')) exit('No direct script access allowed');
date_default_timezone_set('Asia/Kolkata');

class Review_model extends CI_model
{
function review($input, $serviceName){

$ipJson = json_encode($input);
//echo $ipJson;exit();
$review_data = array(
 'user_id'    =>$input['user_id'],
 'hos_id'     => $input['hos_id'],
 'feedback'   => $input['feedback'],
 'rating'     => $input['rating'],
 'created_on' => Date('Y-m-d h:i:s'),
 );



 
 
 $query = $this->db->insert('hospital_feedback', $review_data);



if ($query == 1) {
					
					$last_id = $this->db->insert_id();
					$this->db->select('user_id,hos_id,feedback,rating,created_on');
				    $this->db->from('hospital_feedback');
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
function check_user($user_id,$hos_id) 
		{

			//echo $email;die();
			$this->db->select('*');
			$this->db->from('hospital_feedback');
			$this->db->where('user_id', $user_id);
			$this->db->where('hos_id',$hos_id);
			$query = $this->db->get();
			$details = $query->result();		
			$result = $query->num_rows();
			if ($result > 0 ){
				//print_r($details); die();
				return $details;
			}
			return false;
		}


}