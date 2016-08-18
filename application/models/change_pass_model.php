<?php if(! defined('BASEPATH')) exit('No direct script access allowed');
	/**
	*  Verify_otp model
	*/
	class change_pass_model extends CI_model
	{	

		function c_pass($input)
		{
            $ipJson = json_encode($input);
			
            $this->db->select('*');
			$this->db->from('user_reg');
			$this->db->where('patient_id', $input['patient_id']);
	        $ins=$this->db->where('password', base64_encode($input['old_pass']));
			$query = $this->db->get();
		    $this->db->last_query($query);
			$details = $query->result();		
        	$result =  $query->num_rows();
           
              
            if ($result > 0 )
        	{
        	  $ipJson = json_encode($input);

            $up_status = array(
            	        'password' => base64_encode($input['new_pass']) 
					          );

	  		$this->db->where('patient_id',$input['patient_id']);
			$ins=$this->db->update('user_reg', $up_status);
        	     return True;
			}
			else
			{  
			     return False;
			}
			

		}

		function updt_status_simple ($input)
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
			//echo $this->db->last_query($ins);
	    }

	    function updt_status_with ($input)
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
			//echo $this->db->last_query($ins);
	    }


		function check_mob_cp($input) 
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
}
	


?>