<?php if(! defined('BASEPATH')) exit('No direct script access allowed');

	/**
	*  signup model
	*/
	class Hospital_model extends CI_model
	{
		
	   function about_hospital($input) 
		{
			$ipJson = json_encode($input);
			//echo $email;die();

			$this->db->select('a.hospital_name,a.hospital_img_url,b.address_line_1,b.address_line_2,b.city,b.state,b.country,b.latitude,b.longitude');
			$this->db->select("count(c.feedback) AS count_reviews", FALSE);
			$this->db->select("avg(c.rating) AS avg_rating", FALSE);
			//$this->db->select("count(d.speciality_id_fk) AS speciality", FALSE);
		
			$this->db->from('hospitals a');
			$this->db->join('hospital_address b', 'a.hospital_id = b.hospital_id_fk', 'left');
			$this->db->join('hospital_feedback c', 'b.hospital_id_fk = c.hos_id', 'left');
			//$this->db->join('hospital_specialities d', 'b.hospital_id_fk = d.hospital_id_fk', 'left');
			//$this->db->join('hospital_specialities d', 'c.hos_id = d.hospital_id_fk', 'left');
			$this->db->where('a.hospital_id',$input['hos_id']);
			$query = $this->db->get();
			//echo $this->db->last_query();

			$details = $query->result();
			//print_r($details);
			//exit();		
			return $details;

            
					
		}

	function hospital_about($input)
		{
			$ipJson = json_encode($input);
			$this->db->select('hospital_about');
			$this->db->from('hospitals');
			$this->db->where('hospital_id',$input['hos_id']);
  	$query = $this->db->get();
  	$details = $query->result();
  	return $details;
		}
 
  function hospital_image($input)
  {
  	$ipJson = json_encode($input);
  	$this->db->select('hospital_img_path');
  	$this->db->from('hospital_images');
  	$this->db->where('hospital_id_fk',$input['hos_id']);
  	$query = $this->db->get();
  	$details = $query->result();
  	return $details;
  }  
 function hospital_speciality($input)
  {
  	$ipJson = json_encode($input);
  	$this->db->select('b.speciality_name');
  	$this->db->from('hospital_specialities a');
  	$this->db->join('specialities b', 'a.speciality_id_fk=b.speciality_id');
  	$this->db->where('a.hospital_id_fk',$input['hos_id']);
  	$this->db->where('a.status','current');
  	$query = $this->db->get();
  	$details = $query->result();
  	//$result = $query->num_rows();
  	return $details;
  } 

  function hospital_favourite($input)
  {
  	$ipJson = json_encode($input);
  	$this->db->select('*');
  	$this->db->from('favorite_tbl');
  	$this->db->where('id',$input['hos_id']);
  	$this->db->where('user_id',$input['user_id']);
  	$query = $this->db->get();
  	$details = $query->result();
  	$result = $query->num_rows();
  	return $result;
  	
  }

  function doc_list($input)
  {
  	$ipJson = json_encode($input);
  	$fav = $input['hos_id'];
  	$this->db->select('a.doctor_name,a.experience,a.doctor_img_url,a.fee,b.qualification,d.speciality_name, (select count(feedback) AS reviews from `doctor_feedback`) count_reviews, (select avg(rating) AS rating from `doctor_feedback`) avg_feedback, (select count(*)  from `favorite_tbl`  where `id`='.$input['hos_id'].')  favorite');
    $this->db->from('doctor a');
  	$this->db->join('doctor_qualification b', 'a.doctor_id = b.doc_id_fk', 'left' );
    $this->db->join('specialities d', 'a.doctor_speciality = d.speciality_id');
  	$this->db->where('a.dr_hospital_id_fk',$input['hos_id']);
  	$this->db->where('b.status','current');
  		$query = $this->db->get();
  	//echo $this->db->last_query();
  	$details = $query->result();
     //print_r($details);
	//exit();	
  	return $details;
  }
   function hos_reviewlist($input) 
		{
			$ipJson = json_encode($input);
			//echo $email;die();

			$this->db->select('hospital_feedback.feedback, hospital_feedback.rating,user_reg.username');
			$this->db->select("DATE_FORMAT(hospital_feedback.created_on, '%d %b %Y') AS date ", FALSE);
			$this->db->from('hospital_feedback');
			$this->db->join('user_reg', 'hospital_feedback.user_id = user_reg.uid', 'left');
			$this->db->where('hospital_feedback.hos_id',$input['hos_id']);
			$query = $this->db->get();
			//echo $this->db->last_query();

			$details = $query->result();
			//print_r($details);
			//exit();		
			return $details;

					
		}







	}
	


?>