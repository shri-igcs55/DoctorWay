<?php if(! defined('BASEPATH')) exit('No direct script access allowed');

	/**
	*  signup model
	*/
	class Doc_list_model extends CI_model
	{
		
	   function about_hospital($input) 
		{
			$ipJson = json_encode($input);
			//echo $email;die();

			$this->db->select('a.hospital_name,a.hospital_img_url,b.address_line_1,b.address_line_2,b.city,b.state,b.country,b.latitude,b.longitude');
			$this->db->select("count(c.feedback) AS reviews", FALSE);
			$this->db->select("avg(c.rating) AS rating", FALSE);
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
		
 
  function doc_list($input)
  {

  	/*SELECT `a`.`doctor_name`, `a`.`experience`, `a`.`doctor_img_url`, `a`.`fee`, `b`.`qualification`,(SELECT count(feedback) AS reviews from doctor_feedback), (SELECT AVG(rating) AS rating from doctor_feedback) FROM (`doctor` a) LEFT JOIN `doctor_qualification` b ON `a`.`doctor_id` = `b`.`doc_id_fk` LEFT JOIN `doctor_feedback` c ON `b`.`doc_id_fk` = `c`.`doc_id` WHERE `a`.`dr_hospital_id_fk` = '8' AND `b`.`status` = 'current'

  	SELECT `a`.`doctor_name`, `a`.`experience`, `a`.`doctor_img_url`, `a`.`fee`, `a`.`doctor_speciality`, `b`.`qualification`, `d`.`speciality_name`, select(count(feedback) AS reviews from `doctor_feedback`), avg(rating) AS rating FROM (`doctor` a, `doctor_feedback`) LEFT JOIN `doctor_qualification` b ON `a`.`doctor_id` = `b`.`doc_id_fk` JOIN `specialities` d ON `a`.`doctor_speciality` = `d`.`speciality_id` WHERE `a`.`dr_hospital_id_fk` = '8' AND `b`.`status` = 'current'*/


  	$ipJson = json_encode($input);
  	$fav = $input['hos_id'];
  	$this->db->select('a.doctor_name,a.experience,a.doctor_img_url,a.fee,b.qualification,d.speciality_name, (select count(feedback) AS reviews from `doctor_feedback`) count_reviews, (select avg(rating) AS rating from `doctor_feedback`) avg_feedback, (select count(*)  from `favorite_tbl`  where `id`='.$input['hos_id'].')  favorite');
    $this->db->from('doctor a');
  	$this->db->join('doctor_qualification b', 'a.doctor_id = b.doc_id_fk', 'left' );
    $this->db->join('specialities d', 'a.doctor_speciality = d.speciality_id');
  	$this->db->where('a.dr_hospital_id_fk',$input['hos_id']);
  	$this->db->where('b.status','current');

  	//$this->db->select("count(feedback) AS reviews", FALSE);
  //	$this->db->select("avg(rating) AS rating", FALSE);
  	//$this->db->from('doctor_feedback');
 	

	//$this->db->select("avg(c.rating) AS rating", FALSE);
  	
  	//$this->db->join('doctor_feedback c', 'b.doc_id_fk = c.doc_id','left');
 
  	$query = $this->db->get();
  	//echo $this->db->last_query();
  	$details = $query->result();
     //print_r($details);
	//exit();	
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






	}
	


?>