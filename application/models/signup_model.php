<?php if(! defined('BASEPATH')) exit('No direct script access allowed');

	/**
	*  signup model
	*/
	class Signup_model extends CI_model
	{
		
		function signup($input, $serviceName) {
			$ipJson = json_encode($input);
			
			 	$signup_data = array(
					    'user_role_id'=>'2',
						'username' => $input['username'],
						'patient_id' => strtotime(Date('Y-m-d H:i:s')),
						'email' => $input['email'],
                        'phone_number' => $input['mobile'],
						'password' =>   base64_encode($input['password']),
                        'status' =>     'Pending',
                        'created_on' => Date('Y-m-d h:i:s'),
                        'updated_on' => Date('Y-m-d h:i:s'),
                        'otp' =>     $input['otp']
					);
				$query = $this->db->insert('user_reg', $signup_data);

				if ($query == 1) {
					
					$last_id = $this->db->insert_id();
					$this->db->select('username,
						patient_id,
						email,
						phone_number');
				    $this->db->from('user_reg');
					$this->db->where('uid', $last_id );

				    $detail_last_user = $this->db->get();
				    $resultq = $detail_last_user->result();
				    
					//$data['detail'] = $resultq;
					$data = $resultq;
					//$data['id'] = $profile_thumb_url;

					$status = $this->seekahoo_lib->return_status('success', $serviceName, $data, $ipJson);

				}
				else {
					$data['message'] = 'Something went wrong while signup. Try Again.';
					$status = $this->seekahoo_lib->return_status('Error', $serviceName, $data, $ipJson);
				}
			return $status;
		}

		function check_email($email) 
		{
			//echo $email;die();
			$this->db->select('*');
			$this->db->from('user_reg');
			$this->db->where('email', $email);
			$query = $this->db->get();
			$details = $query->result();		
			$result = $query->num_rows();
			if ($result > 0 ){
				//print_r($details); die();
				return $details;
			}
			return false;
		}
 
        function check_mob($mobile) 
		{
			//echo $email;die();
			$this->db->select('*');
			$this->db->from('user_reg');
			$this->db->where('phone_number', $mobile);
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
	


?>