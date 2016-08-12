<?php if(! defined('BASEPATH')) exit('No direct script access allowed');

	/**
	*  signup model
	*/
	class favourite_model extends CI_model
	{
		
		function favourite_submit($input, $serviceName) {
			$ipJson = json_encode($input);
			
			 	$fav_data = array(
					    'id'=>$input['h_id'],
						'type' => $input['type'],
						'user_id' => $input['user_id'],
						'created_on' => Date('Y-m-d h:i:s'),
                        'updated_on' => Date('Y-m-d h:i:s'),
					);
				$query = $this->db->insert('favorite_tbl', $fav_data);

				if ($query == 1) {
					
					$last_id = $this->db->insert_id();
					$this->db->select('fid,
										id,
										type,
										user_id
										');
				    $this->db->from('favorite_tbl');
					$this->db->where('fid', $last_id );

				    $detail_last_user = $this->db->get();
				    $resultq = $detail_last_user->result();
				    
					//$data['detail'] = $resultq;
					$data = $resultq;
					//$data['id'] = $profile_thumb_url;

					$status = $this->seekahoo_lib->return_status('success', $serviceName, $data, $ipJson);

				}
				else {
					$data['message'] = 'Something went wrong while Submitting Favourites. Try Again.';
					$status = $this->seekahoo_lib->return_status('Error', $serviceName, $data, $ipJson);
				}
			return $status;
		}

		

         public function remove_favourite($input, $serviceName)
		   {   
		  $this->db->where('id',$input['h_id']);
		  $this->db->where('type',$input['type']);
		  $this->db->where('user_id',$input['user_id']);
		  $query=$this->db->delete('favorite_tbl');
		  return $query;
		   }





	}
	


?>