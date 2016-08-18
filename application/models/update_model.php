<?php if(! defined('BASEPATH')) exit('No direct script access allowed');
	/**
	*  Verify_otp model
	*/
	class update_model extends CI_model
	{	

		function check_update($input,$uploadPhoto)
		{
            $ipJson = json_encode($input);
			

            $this->db->select('*');
			$this->db->from('user_reg');
			$this->db->where('patient_id', $input['patient_id']);
	        $ins=$this->db->where('phone_number', $input['mobile']);
			$query = $this->db->get();
			$details = $query->result();		
        	$result =  $query->num_rows();
           
              
            if ($result > 0 )
        	{
        		$ipJson = json_encode($input);
            
            $up_status = array(
            	        'user_pic' => $input['user_pic'],
					    'username' => $input['username'],
						'email' => $input['email'],
                        'blood_group'=>$input['blood_group'],
                        'gender'=>$input['gender'],
                        'dob'=>$input['dob'],
                        'city'=>$input['city'],
                        'created_on' => Date('Y-m-d h:i:s'),
                        'updated_on' => Date('Y-m-d h:i:s')
                              );

	  		$this->db->where('patient_id',$input['patient_id']);
			$ins=$this->db->update('user_reg', $up_status);
        	     return True;
			}
			else
			{  
				$ipJson = json_encode($input);

            $up_status = array(
            	        'user_pic' => $input['user_pic'],
					    'username' => $input['username'],
						'email' => $input['email'],
						'status'=>'pending',
                        'phone_number' => $input['mobile'],
						'blood_group'=>$input['blood_group'],
                        'gender'=>$input['gender'],
                        'dob'=>$input['dob'],
                        'city'=>$input['city'],
                        'otp'=>$input['otp'],
                        'created_on' => Date('Y-m-d h:i:s'),
                        'updated_on' => Date('Y-m-d h:i:s')
                              );

	  		$this->db->where('patient_id',$input['patient_id']);
			$ins=$this->db->update('user_reg', $up_status);
			     return False;
			}
			

		}

		/*function updt_status_simple ($input,$uploadPhoto)
	    {
            
			//echo $this->db->last_query($ins);
	    }

	    function updt_status_with ($input,$uploadPhoto)
	    {
            
			//echo $this->db->last_query($ins);
	    }*/


		function check_mob($input) 
		{
			//echo $email;die();
			$ipJson = json_encode($input);
			//var_dump($input);
			$this->db->select('*');
			$this->db->from('user_reg');
			$this->db->where('phone_number', $input['mobile']);
			$query = $this->db->get();
			$details = $query->result();

			//var_dump($details);  exit();
			$result = $query->num_rows();
			if ($result > 1 )
			{
				//print_r($details); die();
				return $details;
			}
			return false;
		}


		function check_email($input) 
		{
			//echo $email;die();
			$ipJson = json_encode($input);
			$this->db->select('*');
			$this->db->from('user_reg');
			$this->db->where('email', $input['email']);
			$query = $this->db->get();
			$details = $query->result();
            
			//var_dump($details);  exit();
			$result = $query->num_rows();
			if ($result > 1 )
			{
				//print_r($details); die();
				return $details;
			}
			return false;
	    }


        

        function add_photo($uploadPhoto, $ip) {
            $serviceName = 'add_media';

            $ipJson = json_encode($ip);
            //echo $ipJson;exit();
            if ($ip['flag'] == 'post') {
                $photoArray = array(
                    'media_type' => $uploadPhoto[0]['type'],
                    'media_thumb_url' => $uploadPhoto[0]['thumbnail_url'],
                    'media_org_url' => $uploadPhoto[0]['photo_url'],
                    'media_created_date' => date('Y-m-d H:i:s'),
                    'media_modified_date' => date('Y-m-d H:i:s')
                );
                $photoIns = $this->db->insert('media', $photoArray);
            } else { 
                //print_r($uploadPhoto[0]['thumbnail_url']);
                $photoArray = array(
                    'profile_thumb_url' => $uploadPhoto[0]['thumbnail_url'],
                    'profile_org_url'   => $uploadPhoto[0]['photo_url'],
                    'reg_date_time'     => date('Y-m-d H:i:s')
                );
                $this->db->where('id', $ip['user_id']);
                $photoIns = $this->db->update('signup', $photoArray);
            }
            if ($photoIns) {
                $mediaId = $this->db->insert_id();
                $uploadPhoto[0]['photo_id'] = $mediaId;
            } else {
                return false;
            }
            return $uploadPhoto;
        }









 



}
	


?>