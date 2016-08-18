<?php if(! defined('BASEPATH')) exit('No direct script access allowed');
	/**
	*  Verify_otp model
	*/
	class verify_model extends CI_model
	{
		
		function check_otp($input) 
		{
			$ipJson = json_encode($input);
			
			$this->db->select('*');
			$this->db->from('user_reg');
			$this->db->where('phone_number',$input['mobile_num'] );
			$this->db->where('otp', $input['v_code']);
			$query = $this->db->get();
			$details = $query->result();
	        //echo $this->db->last_query();
			$result = $query->num_rows();
			if ($result > 0 ){
				//print_r($details); die();
				return true;

			}
			return false;	
		}

		function update_status($up_status,$code)
		{
 		    $this->db->where('otp', $code);
	        $ins=$this->db->update('user_reg', $up_status);
        	return $ins;
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
	}
	


?>