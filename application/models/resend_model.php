<?php if(! defined('BASEPATH')) exit('No direct script access allowed');
	/**
	*  Verify_otp model
	*/
	class resend_model extends CI_model
	{
		
		function check_mob($input) 
		{
			$ipJson = json_encode($input);
		    //var_dump($ipJson);exit();
			$this->db->select('*');
			$this->db->from('user_reg');
			$this->db->where('phone_number',$input['mobile'] );
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



		function updt_otp ($input,$upuser)
	    {
	  		$this->db->where('phone_number',$input['mobile']);
			$ins=$this->db->update('user_reg', $upuser);
			//echo $this->db->last_query($ins);
	    }

		
	}
	
	


?>