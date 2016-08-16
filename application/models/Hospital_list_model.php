<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Hospital_list_model extends CI_Model {

	function searchHosDoc($val,$serviceName){
		$ipJson = json_encode($val);
		$offset = $val['offset'];
		$limit = 7;
		if($offset === 1){
			$limit = 7; // max
			$start = 0; //min
		} else {
			$starting = $offset*7;
			$start = $starting-7;
		}
		if(!empty($val['insur']) && !empty($val['spel']) && $val['insur'] !='none' && $val['spel'] !='none' ){
			$this->load->library('mydb');
			$userid = $val['user_id'];
			$insur = $val['insur'];
			$spel = $val['spel'];
			$query = $this->mydb->GetMultiResults("call SP_GetHospitalListWithInsuranceAndSpeciality('{$userid}','{$insur}','{$spel}','{$start}','{$limit}')");
			//print_r($query[0]);exit();
			foreach ($query[0] as $key => $value) 
			{
				$rating[$value['hospital_id']] = array('avg_rating'=>$value['rating']);
			}
			//print_r($query[2]);exit();
			foreach ($query[2] as $key=> $hospital_result) 
			{
				$query[2][$key]['avg_rating']=0;
			    $query[2][$key]['review_count']=0;

				foreach ($query[0] as  $rating_result) 
				{
					if($hospital_result['hospital_id']==$rating_result['hospital_id'])
					{	
						$query[2][$key]['avg_rating']= $rating_result['rating'];
				    	$query[2][$key]['review_count']= $rating_result['review_count'];
				    }
				} 
			}
			//print_r($query[1]);exit();
			$speciality_name = array_column($query[1], 'hospital_id');
			$hospital_speciality_count = array_count_values($speciality_name);
			//print_r($hospital_speciality_count);exit();
			foreach ($hospital_speciality_count as $hospital_id_key=> $hospital_speciality_result) 
			{
				if($hospital_speciality_result == 1){
					foreach ($query[2] as $key=> $hospital_result) 
					{
						foreach ($query[1] as $speciality_result) 
						{
							if(($hospital_result['hospital_id']==$hospital_id_key) && ($speciality_result['hospital_id']==$hospital_id_key))
							{
								$query[2][$key]['speciality_type']= $speciality_result['speciality_name']; 
							}
						}
					
					}
				}else if($hospital_speciality_result > 1){
					foreach ($query[2] as $key=> $hospital_result)
					{
						foreach ($query[1] as  $speciality_result) 
						{ 
							if(($hospital_result['hospital_id']==$hospital_id_key) && ($speciality_result['hospital_id']==$hospital_id_key))
							{	
								$query[2][$key]['speciality_type']= "Multi_Speciality";
						    }
					    }
					} 
				}/*else{
					foreach ($query[1] as $key=> $hospital_result)
					{
						foreach ($query[2] as  $speciality_result) 
						{ 
							if((array_key_exists($hospital_result['hospital_id'], $hospital_speciality_count)) || ((array_key_exists($speciality_result['hospital_id'], $hospital_speciality_count))))
							{	
								$query[1][$key]['speciality_type']= "";
						    }
					    }
					} 
				}*/
			}	
			$q_result['total_hospital_count'] = count($query[2]);
			$q_result['hospital_list'] = $query[2];

			/*$query = $this->db->select('DISTINCT(hospitals.hospital_id),hospitals.hospital_name,hospitals.hospital_img_url,hospitals.insurance,hospital_address.address_line_1,hospital_address.address_line_2,hospital_address.city,hospital_address.state,hospital_address.country,hospital_specialities.speciality_id_fk')
				 ->from('hospitals')
				 ->join('hospital_specialities','hospital_specialities.hospital_id_fk = hospitals.hospital_id')
				 ->join('hospital_address','hospital_address.hospital_id_fk = hospitals.hospital_id')
				 ->join('specialities','hospital_specialities.speciality_id_fk = specialities.speciality_id')
				 ->where('hospitals.insurance',$val['insur'])
				 ->where('hospital_specialities.speciality_id_fk',$val['spel'])
				 ->limit($limit, $start)
				 ->get();
				echo $inspe = $this->db->last_query($query);exit();*/
		} else if(!empty($val['insur']) && $val['insur'] !='none' ){
			$this->load->library('mydb');
			$userid = $val['user_id'];
			$insur = $val['insur'];
			$query = $this->mydb->GetMultiResults("call SP_GetHospitalListWithInsurance('{$userid}','{$insur}','{$start}','{$limit}')");
			//print_r($query[0]);exit();
			foreach ($query[0] as $key => $value) 
			{
				$rating[$value['hospital_id']] = array('avg_rating'=>$value['rating']);
			}
			//print_r($query[2]);exit();
			foreach ($query[2] as $key=> $hospital_result) 
			{
				$query[2][$key]['avg_rating']=0;
			    $query[2][$key]['review_count']=0;

				foreach ($query[0] as  $rating_result) 
				{
					if($hospital_result['hospital_id']==$rating_result['hospital_id'])
					{	
						$query[2][$key]['avg_rating']= $rating_result['rating'];
				    	$query[2][$key]['review_count']= $rating_result['review_count'];
				    }
				} 
			}
			//print_r($query[1]);exit();
			$speciality_name = array_column($query[1], 'hospital_id');
			$hospital_speciality_count = array_count_values($speciality_name);
			//print_r($hospital_speciality_count);exit();
			foreach ($hospital_speciality_count as $hospital_id_key=> $hospital_speciality_result) 
			{
				if($hospital_speciality_result == 1){
					foreach ($query[2] as $key=> $hospital_result) 
					{
						foreach ($query[1] as $speciality_result) 
						{
							if(($hospital_result['hospital_id']==$hospital_id_key) && ($speciality_result['hospital_id']==$hospital_id_key))
							{
								$query[2][$key]['speciality_type']= $speciality_result['speciality_name']; 
							}
						}
					
					}
				}else if($hospital_speciality_result > 1){
					foreach ($query[2] as $key=> $hospital_result)
					{
						foreach ($query[1] as  $speciality_result) 
						{ 
							if(($hospital_result['hospital_id']==$hospital_id_key) && ($speciality_result['hospital_id']==$hospital_id_key))
							{	
								$query[2][$key]['speciality_type']= "Multi_Speciality";
						    }
					    }
					} 
				}/*else{
					foreach ($query[1] as $key=> $hospital_result)
					{
						foreach ($query[2] as  $speciality_result) 
						{ 
							if((array_key_exists($hospital_result['hospital_id'], $hospital_speciality_count)) || ((array_key_exists($speciality_result['hospital_id'], $hospital_speciality_count))))
							{	
								$query[1][$key]['speciality_type']= "";
						    }
					    }
					} 
				}*/
			}	
			$q_result['total_hospital_count'] = count($query[2]);
			$q_result['hospital_list'] = $query[2];

			/*$query = $this->db->select('DISTINCT(hospitals.hospital_id),hospitals.hospital_name,hospitals.hospital_img_url,hospitals.insurance,hospital_address.address_line_1,hospital_address.address_line_2,hospital_address.city,hospital_address.state,hospital_address.country')
				 ->from('hospitals')
				 ->join('hospital_specialities','hospital_specialities.hospital_id_fk = hospitals.hospital_id')
				 ->join('hospital_address','hospital_address.hospital_id_fk = hospitals.hospital_id')
				 ->where('hospitals.insurance',$val['insur'])
				 ->limit($limit, $start)
				 ->get();*/
		} else if(!empty($val['spel']) && $val['spel'] !='none'){
			$this->load->library('mydb');
			$userid = $val['user_id'];
			$spel = $val['spel'];
			$query = $this->mydb->GetMultiResults("call SP_GetHospitalListWithSpeciality('{$userid}','{$spel}','{$start}','{$limit}')");
			//print_r($query[0]);exit();
			foreach ($query[0] as $key => $value) 
			{
				$rating[$value['hospital_id']] = array('avg_rating'=>$value['rating']);
			}
			//print_r($query[2]);exit();
			foreach ($query[2] as $key=> $hospital_result) 
			{
				$query[2][$key]['avg_rating']=0;
			    $query[2][$key]['review_count']=0;

				foreach ($query[0] as  $rating_result) 
				{
					if($hospital_result['hospital_id']==$rating_result['hospital_id'])
					{	
						
						$query[2][$key]['avg_rating']=	$rating_result['rating'];

				    	$query[2][$key]['review_count']=	$rating_result['review_count'];
				    }
				} 
			}
			//print_r($query[1]);exit();
			$speciality_name = array_column($query[1], 'hospital_id');
			$hospital_speciality_count = array_count_values($speciality_name);
			//print_r($hospital_speciality_count);exit();
			foreach ($hospital_speciality_count as $hospital_id_key=> $hospital_speciality_result) 
			{
				if($hospital_speciality_result == 1){
					foreach ($query[2] as $key=> $hospital_result) 
					{
						foreach ($query[1] as $speciality_result) 
						{
							if(($hospital_result['hospital_id']==$hospital_id_key) && ($speciality_result['hospital_id']==$hospital_id_key))
							{
								$query[2][$key]['speciality_type']= $speciality_result['speciality_name']; 
							}
						}
					
					}
				}else if($hospital_speciality_result > 1){
					foreach ($query[2] as $key=> $hospital_result)
					{
						foreach ($query[1] as  $speciality_result) 
						{ 
							if(($hospital_result['hospital_id']==$hospital_id_key) && ($speciality_result['hospital_id']==$hospital_id_key))
							{	
								$query[2][$key]['speciality_type']= "Multi_Speciality";
						    }
					    }
					} 
				}/*else{
					foreach ($query[1] as $key=> $hospital_result)
					{
						foreach ($query[2] as  $speciality_result) 
						{ 
							if((array_key_exists($hospital_result['hospital_id'], $hospital_speciality_count)) || ((array_key_exists($speciality_result['hospital_id'], $hospital_speciality_count))))
							{	
								$query[1][$key]['speciality_type']= "";
						    }
					    }
					} 
				}*/
			}	
			$q_result['total_hospital_count'] = count($query[2]);
			$q_result['hospital_list'] = $query[2];

			/*$query = $this->db->select('DISTINCT(hospitals.hospital_id),hospitals.hospital_name,hospitals.hospital_img_url,hospitals.insurance,hospital_address.address_line_1,hospital_address.address_line_2,hospital_address.city,hospital_address.state,hospital_address.country,hospital_specialities.speciality_id_fk')
				 ->from('hospitals')
				 ->join('hospital_specialities','hospital_specialities.hospital_id_fk = hospitals.hospital_id')
				 ->join('hospital_address','hospital_address.hospital_id_fk = hospitals.hospital_id')
				 ->join('specialities','hospital_specialities.speciality_id_fk = specialities.speciality_id')
				 ->where('hospital_specialities.speciality_id_fk',$val['spel'])
				 ->limit($limit, $start)
				 ->get();*/
				 
			
		} else if(!empty($val['location'])){
			$this->load->library('mydb');
			$loc = $val['location'];
			$loc = str_replace(' ','+',$loc);
            $dir = file_get_contents('https://maps.googleapis.com/maps/api/geocode/json?address='.$loc.'&key=AIzaSyBqAa1nsNtFCwNnGj8_ux8XOsTFGzypHQs');

			$dat = json_decode($dir);

			$mylat = $dat->results[0]->geometry->location->lat;
			$mylng = $dat->results[0]->geometry->location->lng;

			$userid = $val['user_id'];
			$query = $this->mydb->GetMultiResults("call SP_GetHospitalListWithoutDetails('{$userid}','{$mylng}','{$mylat}','{$start}','{$limit}')");
			//print_r($query[2]);exit();
			foreach ($query[0] as $key => $value) 
			{
				$rating[$value['hospital_id']] = array('avg_rating'=>$value['rating']);
			}
			//print_r($rating);exit();
			foreach ($query[2] as $key=> $hospital_result) 
			{
					$query[2][$key]['avg_rating']=0;

				    $query[2][$key]['review_count']=0;
				
				foreach ($query[0] as  $rating_result) 
				{
					
					if($hospital_result['hospital_id']==$rating_result['hospital_id'])
					{	
						
						$query[2][$key]['avg_rating']=	$rating_result['rating'];

					    $query[2][$key]['review_count']=	$rating_result['review_count'];
				    }
				   
				} 
			}
			
			$speciality_name = array_column($query[1], 'hospital_id');
			$hospital_speciality_count = array_count_values($speciality_name);
			
			foreach ($hospital_speciality_count as $hospital_id_key=> $hospital_speciality_result) 
			{
				if($hospital_speciality_result == 1){
					foreach ($query[2] as $key=> $hospital_result) 
					{
						foreach ($query[1] as $speciality_result) 
						{
							if(($hospital_result['hospital_id']==$hospital_id_key) && ($speciality_result['hospital_id']==$hospital_id_key))
							{
								$query[2][$key]['speciality_type']= $speciality_result['speciality_name']; 
							}
						}
					
					}
				}else if($hospital_speciality_result > 1){
					foreach ($query[2] as $key=> $hospital_result)
					{
						foreach ($query[1] as  $speciality_result) 
						{ 
							if(($hospital_result['hospital_id']==$hospital_id_key) && ($speciality_result['hospital_id']==$hospital_id_key))
							{	
								$query[2][$key]['speciality_type']= "Multi_Speciality";
						    }
					    }
					} 
				}/*else{
					foreach ($query[1] as $key=> $hospital_result)
					{
						foreach ($query[2] as  $speciality_result) 
						{ 
							if((array_key_exists($hospital_result['hospital_id'], $hospital_speciality_count)) || ((array_key_exists($speciality_result['hospital_id'], $hospital_speciality_count))))
							{	
								$query[1][$key]['speciality_type']= "";
						    }
					    }
					} 
				}*/
			}	
			$q_result['total_hospital_count'] = count($query[2]);
			$q_result['hospital_list'] = $query[2];
			/*$query = $this->db->select("DISTINCT(hospitals.hospital_id),hospitals.hospital_name,hospitals.hospital_img_url,hospitals.insurance,hospital_address.address_line_1,hospital_address.address_line_2,hospital_address.city,hospital_address.state,hospital_address.country,( 3959 * acos( cos( radians($mylat) ) * cos( radians( latitude ) ) * cos( radians( longitude ) - radians($mylng) ) + sin( radians($mylat) ) * sin( radians( latitude ) ) ) ) AS distance")
				 ->from('hospitals')
				 ->join('hospital_specialities','hospital_specialities.hospital_id_fk = hospitals.hospital_id')
				 ->join('hospital_address','hospital_address.hospital_id_fk = hospitals.hospital_id')
				 ->having('distance < 100')
				 ->limit($limit, $start)
				 ->get();*/
				
		} else if(empty($val['location'])){
			$this->load->library('mydb');
			$loc = "Bengaluru, Karnataka, India";
			$loc = str_replace(' ','+',$loc);
            $dir = file_get_contents('https://maps.googleapis.com/maps/api/geocode/json?address='.$loc.'&key=AIzaSyBqAa1nsNtFCwNnGj8_ux8XOsTFGzypHQs');
			$dat = json_decode($dir);

			$mylat = $dat->results[0]->geometry->location->lat;
			$mylng = $dat->results[0]->geometry->location->lng;
			
			$userid = $val['user_id'];
			$query = $this->mydb->GetMultiResults("call SP_GetHospitalListWithoutDetails('{$userid}','{$mylng}','{$mylat}','{$start}','{$limit}')");
			//print_r($query[2]);exit();
			foreach ($query[0] as $key => $value) 
			{
				$rating[$value['hospital_id']] = array('avg_rating'=>$value['rating']);
			}
			//print_r($rating);exit();
			foreach ($query[2] as $key=> $hospital_result) 
			{
					$query[2][$key]['avg_rating']=0;

				    $query[2][$key]['review_count']=0;
				
				foreach ($query[0] as  $rating_result) 
				{
					
					if($hospital_result['hospital_id']==$rating_result['hospital_id'])
					{	
						
						$query[2][$key]['avg_rating']=	$rating_result['rating'];

					    $query[2][$key]['review_count']=	$rating_result['review_count'];
				    }
				   
				} 
			}
			
			$speciality_name = array_column($query[1], 'hospital_id');
			$hospital_speciality_count = array_count_values($speciality_name);
			
			foreach ($hospital_speciality_count as $hospital_id_key=> $hospital_speciality_result) 
			{
				if($hospital_speciality_result == 1){
					foreach ($query[2] as $key=> $hospital_result) 
					{
						foreach ($query[1] as $speciality_result) 
						{
							if(($hospital_result['hospital_id']==$hospital_id_key) && ($speciality_result['hospital_id']==$hospital_id_key))
							{
								$query[2][$key]['speciality_type']= $speciality_result['speciality_name']; 
							}
						}
					
					}
				}else if($hospital_speciality_result > 1){
					foreach ($query[2] as $key=> $hospital_result)
					{
						foreach ($query[1] as  $speciality_result) 
						{ 
							if(($hospital_result['hospital_id']==$hospital_id_key) && ($speciality_result['hospital_id']==$hospital_id_key))
							{	
								$query[2][$key]['speciality_type']= "Multi_Speciality";
						    }
					    }
					} 
				}/*else{
					foreach ($query[2] as $key=> $hospital_result)
					{
						foreach ($query[1] as  $speciality_result) 
						{ 
							if(($hospital_result['hospital_id']==$hospital_id_key) && ($speciality_result['hospital_id']==$hospital_id_key))
							{	
								$query[2][$key]['speciality_type']= "Multi_Speciality";
						    }
					    }
					} 
				}*/
			}	
			$q_result['total_hospital_count'] = count($query[2]);
			$q_result['hospital_list'] = $query[2];
		}
			return 	$q_result;
			exit;
		
		if(!empty($val['location'])){
			$spl = explode(",",$val['location']);
			$spl_ex = explode(" ",$spl[0]);
			$search = $spl_ex[0];
			$final = array(); $i=0;
			foreach($arr1 as $a){
				$country = $a->country;
				$state = $a->state;
				$city = $a->city;

				if( (strpos($country, $search) !== false) || (strpos($state, $search) !== false) || (strpos($city, $search) !== false) ) {
					$final[$i] = $a;
				} 
				$i++;
			}
			return $final;
		}
		else {
			return $arr1;
		}
	}






















































/*--------------------------------------------------------------------------*/

	//Start of function to create/add hospital
	public function store_name($name,$about,$target_file,$insurance,$status,$created_on,$updated_on){
		$data['hos_id_fk'] = $_SESSION['hospital_logged_in']['user_id'];
		$data['hospital_name'] = $name;
		$data['hospital_about'] = $about;
		$data['hospital_img_url'] = $target_file;
		$data['insurance'] = $insurance;
		$data['status'] = $status;
		$data['created_on'] = $created_on;
		$data['updated_on'] = $updated_on;
		$this->db->insert('hospitals',$data);
		$query = $this->db->insert_id();
		if($query > 0){
			return $query;
		}
	}

	public function store_email($myemail,$id,$created_on,$updated_on){
		//print_r($myarr); die();
		$data['hos_id_fk'] = $_SESSION['hospital_logged_in']['user_id'];
		$data['email'] = $myemail['email'];
		$data['purpose'] = $myemail['purpose'];
		$data['hospital_id_fk'] = $id;
		$data['status'] = 'Current';
		$data['created_on'] = $created_on;
		$data['updated_on'] = $updated_on;
		$ins = $this->db->insert('hosital_emails',$data);
	}

	public function store_special($spl,$id,$created_on,$updated_on){
		$data['hos_id_fk'] = $_SESSION['hospital_logged_in']['user_id'];
		$data['hospital_id_fk'] = $id;
		$data['status'] = 'Current';
		$data['hs_created_on'] = $created_on;
		$data['hs_updated_on'] = $updated_on;
		$data['speciality_id_fk'] = $spl;
		$ins = $this->db->insert('hospital_specialities',$data);
	}

	public function store_addr($id,$add1,$add2,$city,$state,$country,$lat_lon,$created_on,$updated_on){
		$data['hos_id_fk'] = $_SESSION['hospital_logged_in']['user_id'];
		$data['address_line_1'] = $add1;
		$data['address_line_2'] = $add2;
		$data['hospital_id_fk'] = $id;
		$data['city'] = $city;
		$data['state'] = $state;
		$data['country'] = $country;
		$data['latitude'] = $lat_lon['lat'];
		$data['longitude'] = $lat_lon['lon'];
		$data['status'] = 'Current';
		$data['created_on'] = $created_on;
		$data['updated_on'] = $updated_on;
		//print_r($data); die();
		$ins = $this->db->insert('hospital_address',$data);
	}

	public function store_phone($myph,$id,$created_on,$updated_on){
		//print_r($myarr); die();
		$data['hos_id_fk'] = $_SESSION['hospital_logged_in']['user_id'];
		$data['phone'] = $myph['phone'];
		$data['purpose'] = $myph['purpose'];
		$data['hospital_id_fk'] = $id;
		$data['status'] = 'Current';
		$data['created_on'] = $created_on;
		$data['updated_on'] = $updated_on;
		$ins = $this->db->insert('hospital_phone',$data);
	}

	public function store_images($m,$id,$created_on,$updated_on){
		$data['hos_id_fk'] = $_SESSION['hospital_logged_in']['user_id'];
		$data['hospital_img_path'] = $m;
		$data['hospital_id_fk'] = $id;
		$data['status'] = 'Current';
		$data['created_on'] = $created_on;
		$data['updated_on'] = $updated_on;
		$ins = $this->db->insert('hospital_images',$data);
	}

	public function store_offers($offer,$id,$created_on,$updated_on){
		$data['hos_id_fk'] = $_SESSION['hospital_logged_in']['user_id'];
		$data['offer'] = $offer;
		$data['hospital_id_fk'] = $id;
		$data['created_on'] = $created_on;
		$data['updated_on'] = $updated_on;
		$ins = $this->db->insert('hospital_offers',$data);
	}


	/*public function CreateHospital(){
		$data = array(
				'hospital_name' => $this->input->post('hospital_name'),
				'hospital_email' => $this->input->post('hospital_email'),
				'address_line_1' => $this->input->post('address_line_1'),
				'address_line_2' => $this->input->post('address_line_2'),
				'hospital_country_id' => $this->input->post('country_id'),
				'hospital_state_id' => $this->input->post('state_id'),
				'hospital_city_id' => $this->input->post('city_id'),
			);
		$query = $this->db->insert('hospitals', $data);
		return $query;
	}*/

	//End of function to create/add hospital


	//Start of function to get the list of all hospitals
	public function getAllHospitals(){
		$query = $this->db->get('hospitals');
		return $query->result();
	}

	public function getAllHosByHid($hos_id){
		$query = $this->db->where('hos_id_fk',$hos_id)
							->get('hospitals');
		return $query->result();
	}

	public function getAllHospitalsEmails(){
		$query = $this->db->where('status','Current')
							->get('hosital_emails');
		return $query->result();
	}

	public function getAllHosEmailHid($hos_id){
		$query = $this->db->where('hos_id_fk',$hos_id)
							->where('status','Current')
							->get('hosital_emails');
		return $query->result();
	}

	public function getAllHospitalsSpl(){
		$this->db->select('*');
		$this->db->from('hospital_specialities');
		$this->db->join('specialities' ,'specialities.speciality_id = hospital_specialities.speciality_id_fk', 'left');
		$query = $this->db->where('status','Current')
							->get();
		return $query->result();
	}

	public function getAllHosSplHid($hos_id){
		$this->db->select('*');
		$this->db->from('hospital_specialities');
		$this->db->join('specialities' ,'specialities.speciality_id = hospital_specialities.speciality_id_fk', 'left');
		$query = $this->db->where('hos_id_fk',$hos_id)
							->where('status','Current')
							->get();
		return $query->result();
	}

	public function getAllHospitalsAddress(){
		//$data = $this->db->query('SELECT *, ( 3959 * acos( cos( radians(12.988145) ) * cos( radians( latitude ) ) * cos( radians( longitude ) - radians(77.560033) ) + sin( radians(12.988145) ) * sin( radians( latitude ) ) ) ) AS distance FROM hospital_address HAVING distance < 250 ORDER BY distance');


		//$this->db->select('*');
		//$this->db->from('hospital_address');
		/*$this->db->join('cities' ,'cities.city_id = hospital_address.city_id', 'left');
		$this->db->join('states', 'states.st_id = hospital_address.state_id', 'left');
		$this->db->join('countries', 'countries.id = hospital_address.country_id', 'left');*/
		//$this->db->where(array(
				//'hospital_address.hospital_id_fk' => $hospital_id,
			//	'status'=>'Current'
			//));
		//return $data = $data->result();
		//echo "<pre>";
		//print_r($data);
		//exit;
		$this->db->select('*');
		$this->db->from('hospital_address');
		/*$this->db->join('cities' ,'cities.city_id = hospital_address.city_id', 'left');
		$this->db->join('states', 'states.st_id = hospital_address.state_id', 'left');
		$this->db->join('countries', 'countries.id = hospital_address.country_id', 'left');*/
		$query = $this->db->where('status','Current')
							->get();
		//
		return $query->result();
	}

	public function getAllHosAddHid($hos_id){
		$this->db->select('*');
		$this->db->from('hospital_address');
		$query = $this->db->where('hos_id_fk',$hos_id)
							->where('status','Current')
							->get();
		
		return $query->result();
	}

	public function getAllHospitalsPhone(){
		$query = $this->db->where('status','Current')
							->get('hospital_phone');
		return $query->result();
	}

	public function getAllHosPhHid($hos_id){
		$query = $this->db->where('hos_id_fk',$hos_id)
							->where('status','Current')
							->get('hospital_phone');
		return $query->result();
	}

	public function getAllHospitalsImage(){
		$query = $this->db->where('status','Current')
							->get('hospital_images');
		return $query->result();
	}

	public function getAllHosImgHid($hos_id){
		$query = $this->db->where('hos_id_fk',$hos_id)
							->where('status','Current')
							->get('hospital_images');
		return $query->result();
	}

	//End of function to get the list of all hospitals


	/*//Start of function to get all hospital list with only hospital name and hospital id
	public function getAllHospitalList(){
		$this->db->select('hospital_id, hospital_name');
		$this->db->from('hospitals');
		$query = $this->db->get();
		return $query->result();
	}
	//Start of function to get all hospital list with only hospital name and hospital id*/

	//Start of function to get detail of hospital by ID
	public function getHospitalById($hospital_id){
		$query = $this->db->where('hospital_id',$hospital_id)
				 ->get('hospitals');
		return $query->row();
	}

	public function getHospitalEmailById($hospital_id){
		$query = $this->db->where('hospital_id_fk',$hospital_id)
							->where('status','Current')
				 ->get('hosital_emails');
		return $query->result();
	}

	public function getHospitalAddressById($hospital_id){

		//$data = $this->db->query('SELECT *, ( 3959 * acos( cos( radians(12.988145) ) * cos( radians( latitude ) ) * cos( radians( longitude ) - radians(77.560033) ) + sin( radians(12.988145) ) * sin( radians( latitude ) ) ) ) AS distance FROM hospital_address HAVING distance < 250 ORDER BY distance');


		$this->db->select('*');
		$this->db->from('hospital_address');
		/*$this->db->join('cities' ,'cities.city_id = hospital_address.city_id', 'left');
		$this->db->join('states', 'states.st_id = hospital_address.state_id', 'left');
		$this->db->join('countries', 'countries.id = hospital_address.country_id', 'left');*/
		$this->db->where(array(
				'hospital_address.hospital_id_fk' => $hospital_id,
			'status'=>'Current'
			));
	//	$data = $data->result();
		//print_r($data);
		//exit;
		//return $data = $data->result();

		//$this->db->select('*');
		//$this->db->from('hospital_address');
		/*$this->db->join('cities' ,'cities.city_id = hospital_address.city_id', 'left');
		$this->db->join('states', 'states.st_id = hospital_address.state_id', 'left');
		$this->db->join('countries', 'countries.id = hospital_address.country_id', 'left');*/
		//$this->db->where(array(
				//'hospital_address.hospital_id_fk' => $hospital_id,
			//	'status'=>'Current'
			//));
		$data = $this->db->get();

	//	print_r($data);
		//exit;

		$query = $data->result()[0];
		return $query;
	}

	public function getHospitalPhoneById($hospital_id){
		$query = $this->db->where('hospital_id_fk',$hospital_id)
							->where('status','Current')
				 ->get('hospital_phone');
		return $query->result();
	}

	public function getHospitalSplById($hospital_id){
		$query = $this->db->where('hospital_id_fk',$hospital_id)
					->where('status','Current')
				 ->get('hospital_specialities');
		return $query->result();
	}

	public function getHospitalImageById($hospital_id){
		$query = $this->db->where('hospital_id_fk',$hospital_id)
					->where('status','Current')
				 ->get('hospital_images');
		return $query->result();
	}

	public function getSpecialByHosId($hospital_id){
		$query = $this->db->select('hospital_specialities.speciality_id_fk,specialities.speciality_name')
						  ->from('hospital_specialities')
						  ->join('specialities','specialities.speciality_id = hospital_specialities.speciality_id_fk')
						  ->where('hospital_specialities.status','Current')
						  ->where('hospital_specialities.hospital_id_fk',$hospital_id)
		    			  ->get();
		return $query->result();
	}

	public function getHospitalOfferById($hospital_id){
		$query = $this->db->where('hospital_id_fk',$hospital_id)
				 ->get('hospital_offers');
		return $query->result();
	}

	//End of function to get detail of hospital by ID


	//Start of function to update record of hospital

	/*public function UpdateHospital($hospital_id){
		$data = array(
				'hospital_name' => $this->input->post('hospital_name'),
				'hospital_email' => $this->input->post('hospital_email'),
				'address_line_1' => $this->input->post('address_line_1'),
				'address_line_2' => $this->input->post('address_line_2'),
				'hospital_country_id' => $this->input->post('country_id'),
				'hospital_state_id' => $this->input->post('state_id'),
				'hospital_city_id' => $this->input->post('city_id'),
			);
		$this->db->where('hospital_id', $hospital_id);
		$this->db->update('hospitals', $data);
	}*/

	public function update_name($id,$name,$about,$target_file,$insurance,$updated_on){
		$data['hos_id_fk'] = $_SESSION['hospital_logged_in']['user_id'];
		$data['hospital_name'] = $name;
		$data['hospital_about'] = $about;
		$data['hospital_img_url'] = $target_file;
		$data['insurance'] = $insurance;
		$data['updated_on'] = $updated_on;
		$this->db->where('hospital_id',$id)
				 ->update('hospitals',$data);
	}

	public function update_email($myemail,$id,$created_on,$updated_on){
		$this->db->set('status','Deleted')
				 ->where('hospital_id_fk',$id)
				 ->update('hosital_emails');

		foreach($myemail as $e){ 
		$data['hos_id_fk'] = $_SESSION['hospital_logged_in']['user_id'];
		$data['hospital_id_fk'] = $id;
		$data['status'] = 'Current';
		$data['created_on'] = $created_on;
		$data['updated_on'] = $updated_on;
		$data['email'] = $e['email'];
		$data['purpose'] = $e['purpose'];
		$ins = $this->db->insert('hosital_emails',$data);
		}
	}

	public function update_special($specialities,$id,$created_on,$updated_on){
		$this->db->set('status','Deleted')
				 ->where('hospital_id_fk',$id)
				 ->update('hospital_specialities');

		foreach($specialities as $s){ 
		$data['hos_id_fk'] = $_SESSION['hospital_logged_in']['user_id'];
		$data['hospital_id_fk'] = $id;
		$data['hs_created_on'] = $created_on;
		$data['hs_updated_on'] = $updated_on;
		$data['speciality_id_fk'] = $s;
		$data['status'] = 'Current';
		$ins = $this->db->insert('hospital_specialities',$data);
		}
	}

	public function update_addr($id,$add1,$add2,$city,$state,$country,$lat_lon,$updated_on){
		$data['hos_id_fk'] = $_SESSION['hospital_logged_in']['user_id'];
		$data['address_line_1'] = $add1;
		$data['address_line_2'] = $add2;
		$data['city'] = $city;
		$data['state'] = $state;
		$data['country'] = $country;
		$data['latitude'] = $lat_lon['lat'];
		$data['longitude'] = $lat_lon['lon'];
		$data['updated_on'] = $updated_on;
		$ins = $this->db->where('hospital_id_fk',$id)
						->update('hospital_address',$data);
	}

	public function update_phone($myphone,$id,$created_on,$updated_on){
		$this->db->set('status','Deleted')
				 ->where('hospital_id_fk',$id)
				 ->update('hospital_phone');

		foreach($myphone as $m){
		$data['hos_id_fk'] = $_SESSION['hospital_logged_in']['user_id'];
		$data['hospital_id_fk'] = $id;
		$data['phone'] = $m['phone'];
		$data['purpose'] = $m['purpose'];
		$data['created_on'] = $created_on;
		$data['updated_on'] = $updated_on;
		$data['status'] = 'Current';
		$ins = $this->db->insert('hospital_phone',$data);
		}
	}

	public function update_images($id,$img,$created_on,$updated_on){
			$this->db->set('status','Deleted')
				 ->where('hospital_id_fk',$id)
				 ->update('hospital_images');

			foreach($img as $i){
			$data['hos_id_fk'] = $_SESSION['hospital_logged_in']['user_id'];
			$data['hospital_id_fk'] = $id;
			$data['hospital_img_path'] = $i;
			$data['created_on'] = $created_on;
			$data['updated_on'] = $updated_on;
			$data['status'] = 'Current';
			$ins = $this->db->insert('hospital_images',$data);
			}
	}

	public function update_offers($offer,$id,$created_on,$updated_on)
	{
		$data['hos_id_fk'] = $_SESSION['hospital_logged_in']['user_id'];
		$data['offer'] = $offer;
		$data['created_on'] = $created_on;
		$data['updated_on'] = $updated_on;
		$this->db->where('hospital_id_fk',$id)
				 ->update('hospital_offers',$data);
	}


	//End of function to update record of hospital


	//Start of function to delete hospital
	public function DeleteHospital($hospital_id){
		$this->db->where('hospital_id', $hospital_id);
		$this->db->delete('hospitals');
	}

	public function DeleteHospitalEmail($hospital_id){
		$this->db->where('hospital_id_fk', $hospital_id);
		$this->db->delete('hosital_emails');
	}

	public function DeleteHospitalAddress($hospital_id){
		$this->db->where('hospital_id_fk', $hospital_id);
		$this->db->delete('hospital_address');
	}

	public function DeleteHospitalPhone($hospital_id){
		$this->db->where('hospital_id_fk', $hospital_id);
		$this->db->delete('hospital_phone');
	}

	public function DeleteHospitalSpl($hospital_id){
		$this->db->where('hospital_id_fk', $hospital_id);
		$this->db->delete('hospital_specialities');
	}
	//End of function to delete hospital


	//Start of function to update specialitiy added status
	public function UpdateAfterSpecialityCreate($hospital_id){
		$data = array(
				'speciality_added' => 1
			);
		$this->db->where('hospital_id', $hospital_id);
		$this->db->update('hospitals', $data);
	}
	//End of function to update speciality added status

	//Start of function to get name of Hospital by ID
	public function getHospitalNameByHospitalID($hospital_id){
		$this->db->select('hospital_name');
		$this->db->from('hospitals');
		$this->db->where('hospital_id', $hospital_id);
		$data = $this->db->get();
		$query = $data->result()[0];
		return $query;
	}
	//End of function to get name of Hospital by ID

	//Start of function to update speciality added status after delete
	public function UpdateAfterSpecialtyDeleted($hospital_id){
		$data = array(
				'speciality_added' => 0
			);
		$this->db->where('hospital_id', $hospital_id);
		$this->db->update('hospitals', $data);
	}
	//End of function to update speciality added status after delete

	//Function for Approve and Disapprove
	public function	approve($id,$data){
		$q = $this->db->set('status',$data)
					 ->where('hospital_id',$id)
					 ->update('hospitals');
		if($q){
			return true;
		}
		else{
			return false;
		}
	}
	//End Of Approve and Disapprove

	




	function getHospital(){
		$query = $this->db->select('*')
						->from('hospitals')
						->join('hospital_address','hospital_address.hospital_id_fk = hospitals.hospital_id ')
						
						->get();
		return $query->result();
	}

	public function getHospitalOffers()
	{
			$query = $this->db->get('hospital_offers');
			return $query->result();
	}

	public function getHospitalOffersById($id)
	{
			$query = $this->db->where('hospital_id_fk',$id)
			                  ->get('hospital_offers');
			return $query->result();
	}

}