<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	
	require('application/libraries/REST_Controller.php');  
	//error_reporting(0);

	/**
	* Sign up form controller
	*/
	class User extends REST_Controller
	{
		public function User() {
			parent::__construct();

			$this->load->model('user_model');
			$this->load->library('email');
			$this->load->library('upload');
			//$this->load->library('seekahoo_lib');
    	}
		
		public function user_signup_post()
		{
			$six_digit_random_number = mt_rand(100000, 999999);
			$serviceName = 'user_signup';
			//getting posted values
			$ip['username'] = trim($this->input->post('username'));
			$ip['email']    = trim($this->input->post('email'));
			$ip['mobile']   = trim($this->input->post('mobile'));
			$ip['password'] = trim($this->input->post('password'));
			$ip['c_pass']   = trim($this->input->post('c_pass'));
            $ip['otp']      = $six_digit_random_number;
			//var_dump($_FILES['user_pic']);exit();
           // print_r($ip); exit();
			if (!null==($ipJson = json_encode($ip)))
                {
               	/*=================GENRAING OTP=====================*/
	            $user="developer2dasdadd@indglobal-consulting.com:indglobal123";

			    $sender="TEST SMS";
			    $number = $ip['mobile'];
			    $message="Your One Time Password is :".$six_digit_random_number." For confirm the registration. Please do not share this password with Anyone - DOCTORWAY"; 
			               
			    
			    $ipJson = json_encode($ip);
                /*=================ENDING OF GENRAING OTP=====================*/
				}
			
			//validation
			$validation_array = 1;
									
					$ip_array[] = array("name", $ip['username'], "not_null", "name", "Name is empty.");

					$ip_array[] = array("email", $ip['email'], "email", "email_id", "Wrong or Invalid Email address.");
					
					$ip_array[] = array("mobile", $ip['mobile'], "not_null", "mobile", "Mobile Number is empty.");
					$validation_array = $this->validator->validate($ip_array);
					
					if($ip['password'] != $ip['c_pass'])
					 {
				     $data['message'] = "Password missmatch.";
				     $retVals1 = $this->seekahoo_lib->return_status('error', $serviceName, $data, $ipJson);
                     } 
					else if(empty($_POST['password']))
					 {
					  $data['message'] = "Password field empty.";
				      $retVals1 = $this->seekahoo_lib->return_status('error', $serviceName, $data, $ipJson);
					 }


					else if ($this->user_model->check_mob($ip)) 
					{
					 $data['message'] = 'Mobile number alerady registered.';
					 $retVals1 = $this->seekahoo_lib->return_status('error', $serviceName, $data, $ipJson);
					} 

					else if ($this->user_model->check_email($ip)) 
					{
					 $data['message'] = 'Email address alerady registered.';
					 $retVals1 = $this->seekahoo_lib->return_status('error', $serviceName, $data, $ipJson);
					}

					else if ($validation_array !=1) 
					{
					 $data['message'] = $validation_array;
					 $retVals1 = $this->seekahoo_lib->return_status('error', $serviceName, $data, $ipJson);
					} 
					else  {
                           $retVals1 = $this->user_model->signup($ip, $serviceName);
						   $ch = curl_init();
			               curl_setopt($ch,CURLOPT_URL,  "http://api.mVaayoo.com/mvaayooapi/MessageCompose");
			               curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			               curl_setopt($ch, CURLOPT_POST, 1);
			               curl_setopt($ch, CURLOPT_POSTFIELDS, "user=".$user."&senderID=".$sender."&receipientno=".$number."&msgtxt=".$message."");
			               $buffer = curl_exec($ch);
			   
			               curl_close($ch);
			               json_decode($retVals1);	
			               
					      }

     		          //echo $retVals1 = $this->user_model->signup($ip, $serviceName);
			          header("content-type: application/json");
			          echo $retVals1;
			          exit;
	     	}

/*Sign in Section*/

             public function user_signin_post(){
		$serviceName = 'user_signin';
		//getting posted values
		$ip['email'] = trim($this->input->post('email'));
		$ip['password'] = trim($this->input->post('password'));
		$ipJson = json_encode($ip);
		//validation
		$validation_array = 1;
			$ip_array[] = array("email", $ip['email'], "email", "email_id", "Wrong or Invalid Email address.");
			$ip_array[] = array("password", $ip['password'], "not_null", "password", "Password is empty.");
			$validation_array = $this->validator->validate($ip_array);
			if ($validation_array !=1) {
				$data['message'] = $validation_array;
				$retVals = $this->seekahoo_lib->return_status('error', $serviceName, $data, $ipJson);
				json_decode($retVals1);
			} 
			else {
				$retVals = $this->user_model->check_signin($ip, $serviceName);
			}
		
		header("content-type: application/json");
		echo $retVals;
		exit;
	}
/*End of Sign in Section*/
/*Verification Section*/

public function verify_post()
		{
			$serviceName = 'verify';
			$ip['v_code']     = trim($this->input->post('v_code'));
            $ip['mobile_num'] = trim($this->input->post('mobile_num'));
            $ip['email']      = trim($this->input->post('email'));
            $ipJson = json_encode($ip);
            if(empty($ip['v_code']) && empty($ip['mobile_num']))
            {
               $data['message'] = "Feilds are Required";
			   $retVals1 = $this->seekahoo_lib->return_status('error', $serviceName, $data, $ipJson);
            } 
            else
            {
                $chkotp=$this->user_model->check_otp($ip);
               
                 if($chkotp=="true")
                 {
                 	$code =$ip['v_code'];
                 	$data['message'] = "OTP Matched";
                 	$retVals1 = $this->seekahoo_lib->return_status('success', $serviceName, $data, $ipJson);
                 	$up_status = array(
								       'status' => 'Verify'
					                  );
                 	$chkotp=$this->user_model->update_status($up_status,$code);
                        
                    /*======================Mailing Part======================*/
			        $from_email = "Anuragdubey@gmail.com"; 
			        $to_email = $this->input->post('email'); 
			   
			        $this->email->from($from_email, 'Doctor Way'); 
			        $this->email->to($to_email);
			        $this->email->subject('Email Test'); 
			        $this->email->message('Testing the email class.');
                    /*=====================Ending Mailing Part====================*/   

                 }
            	else 
	            {
    	        	$data['message'] = "OTP Not Matching";
			    	$retVals1 = $this->seekahoo_lib->return_status('error', $serviceName, $data, $ipJson);
			    	json_decode($retVals1);
           	    }
        }
	        //echo $retVals1 = $this->signup_model->signup($ip, $serviceName);
            header("content-type: application/json");
            echo $retVals1;
            exit;
	     	}

/*End of Verification in Section*/
/*Resend Otp Section*/


 public function resend_post()
		{
			$six_digit_random_number = mt_rand(100000, 999999);
			$serviceName = 'user_signup';
			
			$ip['mobile']   = trim($this->input->post('mobile'));
			$ipJson = json_encode($ip);
			if (empty($ip['mobile']))
            {    
            	
                $data['message'] = "Mobile number is null....";
				$retVals1 = $this->seekahoo_lib->return_status('error', $serviceName, $data, $ipJson);
		         //json_decode($retVals1);	
				}
			    else 
			    {   
			    	 $chkmob=$this->resend_model->check_mob($ip);
                     if($chkmob=="true")
		             {
		             	 $six_digit_random_number = mt_rand(100000, 999999);
				         $ipJson = json_encode($ip);
			             $data['message'] = "Otp send to number";
					     $retVals1 = $this->seekahoo_lib->return_status('success', $serviceName, $data, $ipJson); 
					     /*==================Sending Otp Again=====================*/ 
                           $user="developer2222@indglobal-consulting.com:indglobal123";

					    $sender="TEST SMS";
					    $number = $ip['mobile'];
					    $message="Your One Time Password is :".$six_digit_random_number." For confirm the registration. Please do not share this password with Anyone - Doctorway"; 
					               
					    $ch = curl_init();
					    curl_setopt($ch,CURLOPT_URL, "http://api.mVaayoo.com/mvaayooapi/MessageCompose");
					    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
					    curl_setopt($ch, CURLOPT_POST, 1);
					    curl_setopt($ch, CURLOPT_POSTFIELDS, "user=".$user."&senderID=".$sender."&receipientno=".$number."&msgtxt=".$message."");
					    $buffer = curl_exec($ch);
					   
					    curl_close($ch);
					    /*==================Sending Otp Again=====================*/
					    /*==================Updating Otp Again=====================*/
                        $upuser = array( 
                					   'otp' => $six_digit_random_number,
                					   );
                        $user = $this->user_model->updt_otp($ip,$upuser);
					    /*==================Updating Otp Again=====================*/
				     
		             }
		             else
		             {
		             	$data['message'] = "Please Sign up first";
					    $retVals1 = $this->seekahoo_lib->return_status('error', $serviceName, $data, $ipJson);	
					    json_decode($retVals1);
		             }

				        
		        }
			        header("content-type: application/json");
			        echo $retVals1;
			        exit;
	     	}


/*End of Resend Otp Section*/
/* chng_pass Section*/
 public function chng_pass_post()
		{
			$serviceName = 'update';
			//getting posted values
			$ip['old_pass']    = trim($this->input->post('old_pass'));
			$ip['new_pass']    = trim($this->input->post('new_pass'));
		    $ip['c_pass']      = trim($this->input->post('cn_pass'));
		    $ip['mobile']      = trim($this->input->post('mobile'));
		    $ip['patient_id']  = trim($this->input->post('patient_id'));
		    $ip['user_name']  = trim($this->input->post('user_name'));

			//var_dump($_FILES['user_pic']);exit();
           // print_r($ip); exit();
			if (!null==($ipJson = json_encode($ip)))
                {
               	/*=================GENRAING OTP=====================*/
	            $user="developer2@indglobal-consulting.com:indglobal123";

			    $sender ="TEST SMS";
			    $number = $ip['mobile'];
			    $name   = $ip['user_name'];
			    $message="Hi:".$name." Your Password is Changed Successfully You can Login in Few minutes - DOCTORWAY"; 
			    $ipJson = json_encode($ip);
                $this->load->model('change_pass_model');
			    $chk_pass=$this->user_model->c_pass($ip);
                /*=================ENDING OF GENRAING OTP=====================*/
				}
			
			//validation
			$validation_array = 1;
									
					$ip_array[] = array("old_pass", $ip['old_pass'], "not_null", "old_pass", "Old password is empty.");

					$ip_array[] = array("new_pass", $ip['new_pass'], "not_null", "new_pass", "New password is Empty.");
					
					$ip_array[] = array("c_pass", $ip['c_pass'], "not_null", "c_pass", "Conifirm password is empty.");

					$ip_array[] = array("mobile", $ip['mobile'], "not_null", "mobile", "Mobile number is empty.");

					$ip_array[] = array("patient_id", $ip['patient_id'], "not_null", "patient_id", "Patient id is empty.");

					$validation_array = $this->validator->validate($ip_array);
					
					/*if ($this->update_model->c_pass($ip)) 
					{
					 $data['message'] = 'Mobile number alerady registered.';
					 $retVals1 = $this->seekahoo_lib->return_status('error', $serviceName, $data, $ipJson);
					} 

					else if ($this->update_model->c_pass($ip)) 
					{
					 $data['message'] = 'Email address alerady registered.';
					 $retVals1 = $this->seekahoo_lib->return_status('error', $serviceName, $data, $ipJson);
					}

					else*/ 
                    if($ip['new_pass'] != $ip['c_pass'])
					 {
				     	$data['message'] = "Password missmatch.";
				     	$retVals1 = $this->seekahoo_lib->return_status('error', $serviceName, $data, $ipJson);
                     }

					else if ($validation_array !=1) 
					{
					 	$data['message'] = $validation_array;
					 	$retVals1 = $this->seekahoo_lib->return_status('error', $serviceName, $data, $ipJson);
					} 

					else if ($chk_pass=="True") 
					{
					 //$done_simple=$this->update_model->updt_status_simple($ip);
						 $data['message'] = "Paasword matched";
					 	 $retVals1 = $this->seekahoo_lib->return_status('success', $serviceName, $data, $ipJson);

					 /*===============Sending Otp==================*/
                         $ch = curl_init();
			               curl_setopt($ch,CURLOPT_URL,  "http://api.mVaayoo.com/mvaayooapi/MessageCompose");
			               curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			               curl_setopt($ch, CURLOPT_POST, 1);
			               curl_setopt($ch, CURLOPT_POSTFIELDS, "user=".$user."&senderID=".$sender."&receipientno=".$number."&msgtxt=".$message."");
			               $buffer = curl_exec($ch);
			   
			               curl_close($ch);
						  /*===============Sending Otp===================*/
					} 
					else  
					{
					  	//$done_otp=$this->update_model->updt_status_with($ip);
					  	$data['message'] = "Paasword not matched from database";
					  	$retVals1 = $this->seekahoo_lib->return_status('success', $serviceName, $data, $ipJson);
					  	json_decode($retVals1);
					  
					}

     		         	//echo $retVals1 = $this->signup_model->signup($ip, $serviceName);
			          	header("content-type: application/json");
			            echo $retVals1;
			            exit;
	     	}     



 /*End of chng_pass Section*/
/* Update Section*/

public function update_post()
		{
			$six_digit_random_number = mt_rand(100000, 999999);
			$serviceName = 'update';
			//getting posted values
			$ip['user_pic']    = trim($this->input->post('user_pic'));
			$ip['blood_group'] = trim($this->input->post('blood_group'));
		    $ip['gender']      = trim($this->input->post('gender'));
			$ip['dob']         = trim($this->input->post('dob'));
		    $ip['city']        = trim($this->input->post('city'));
			$ip['user_id']     = trim($this->input->post('user_id'));
			$ip['username']    = trim($this->input->post('username'));
			$ip['email']       = trim($this->input->post('email'));
			$ip['mobile']      = trim($this->input->post('mobile'));
			$ip['patient_id']  = trim($this->input->post('patient_id'));
			$ip['otp']         = $six_digit_random_number;
			//var_dump($_FILES['user_pic']);exit();
           // print_r($ip); exit();
			if (!null==($ipJson = json_encode($ip)))
                {
	               	/*=================GENRAING OTP=====================*/
		            $user="developer27788@indglobal-consulting.com:indglobal123";

				    $sender="TEST SMS";
				    $number = $ip['mobile'];
				    $message="Your One Time Password is :".$six_digit_random_number." For confirm the registration. Please do not share this password with Anyone - DOCTORWAY"; 
				    $ipJson = json_encode($ip);


	                //$uploadPhoto[] = array('profile_org_url'=>'', 'type'=>'image', 'profile_thumb_url'=>'', 'photo_id'=>'');

				    $chkmob=$this->user_model->check_update($ip);
	                /*=================ENDING OF GENRAING OTP=====================*/
				}
			
			//validation
			$validation_array = 1;
									
					$ip_array[] = array("name", $ip['username'], "not_null", "name", "Name is empty.");

					$ip_array[] = array("email", $ip['email'], "email", "email_id", "Email is Empty.");
					
					$ip_array[] = array("mobile", $ip['mobile'], "not_null", "mobile", "Mobile Number is empty.");
					$validation_array = $this->validator->validate($ip_array);
					
					if ($this->user_model->check_mob_u($ip)) 
					{
						 $data['message'] = 'Mobile number alerady registered.';
						 $retVals1 = $this->seekahoo_lib->return_status('error', $serviceName, $data, $ipJson);
					} 

					else if ($this->user_model->check_email_u($ip)) 
					{
						 $data['message'] = 'Email address alerady registered.';
						 $retVals1 = $this->seekahoo_lib->return_status('error', $serviceName, $data, $ipJson);
					}

					else if ($validation_array !=1) 
					{
						 $data['message'] = $validation_array;
						 $retVals1 = $this->seekahoo_lib->return_status('error', $serviceName, $data, $ipJson);
					} 

					else if ($chkmob=="True") 
					{
					     //$done_simple=$this->update_model->updt_status_simple($ip,$uploadPhotos);
						 $data['message'] = "Profile updated succesfully";
						 $retVals1 = $this->seekahoo_lib->return_status('success', $serviceName, $data, $ipJson);
					} 
					else  
					{
						//$done_otp=$this->update_model->	updt_status_with($ip,$uploadPhotos);
					  	$data['message'] = "Profile updated status pending";
					  	$retVals1 = $this->seekahoo_lib->return_status('success', $serviceName, $data, $ipJson);
					  /*===============Sending Otp==================*/
                         $ch = curl_init();
			               curl_setopt($ch,CURLOPT_URL,  "http://api.mVaayoo.com/mvaayooapi/MessageCompose");
			               curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			               curl_setopt($ch, CURLOPT_POST, 1);
			               curl_setopt($ch, CURLOPT_POSTFIELDS, "user=".$user."&senderID=".$sender."&receipientno=".$number."&msgtxt=".$message."");
			               $buffer = curl_exec($ch);
			   
			               curl_close($ch);
			               json_decode($retVals1);
					  /*===============Sending Otp===================*/

                    	  // $patient_id = $ip['patient_id'];
					 	  //$upic = $_FILES['user_pic'];
					      //echo $retvals = $this->add_media_post($ip,$patient_id,$upic,'profile');



					} 
        
                         //echo $retVals1 = $this->signup_model->signup($ip,  $serviceName);
			             header("content-type: application/json");
			             echo $retVals1;
			             exit;
	     	}
 

            /*function add_media_post($ip,$patient_id,$upic, $flags) {
                //echo $user_id = $ip['user_id'];
                //print_r($upic);exit;
                ini_set('max_execution_time', 1000);
                $serviceName = 'add_media';
                $flag = $flags;
                $ip['patient_id'] = $patient_id;
                $ip['flag'] = $flag;
                $ipJson = json_encode($ip);
                $validation_array = 1;



                $ip_array[] = array("patient_id", $ip['patient_id'], "not_null", "patient_id", "Wrong or Invalid Patient id.");
                $ip_array[] = array("flag", $ip['flag'], "not_null", "flag", "flag is empty.");
                //$ip_array[] = array("flag", $ip['flag']);
                $ipJson = json_encode($ip);
                $validation_array = $this->validator->validate($ip_array);
                if ($validation_array !=1) {
                $data['message'] = $validation_array;
                $retVals = $this->seekahoo_lib->return_status('error', $serviceName, $data, $ipJson);
                } 
                else {
                $this->load->library('uploader');

                $uploadPhoto[] = $this->uploader->upload_image($upic, $flag,$ip);

                if ($uploadPhoto[0] == 'failed') {

                //$uploadPhoto = array();
                $uploadPhotos[] = array('profile_org_url'=>'', 'type'=>'image', 'profile_thumb_url'=>'', 'photo_id'=>'');
                //print_r($uploadPhoto);exit();
                //    $uploadDb = $this->signup_model->add_photo($uploadPhoto, $ip);
                $data['uploaded_data'] = $uploadPhotos;
                $data['details'] = $ip;
                $data['message'] = 'Successfully Uploaded';
                $retVals = $this->seekahoo_lib->return_status('success', $serviceName, $data, $ipJson);

                } else {


                $uploadDb = $this->user_model->check_update($ip,$uploadPhoto );
                
                if (!$uploadDb) {
                $data['message'] = 'Failed to add media to database';
                $retVals = $this->seekahoo_lib->return_status('error', $serviceName, $data, $ipJson);
                } else {
                $data['uploaded_data'] = $uploadDb;
                $data['details'] = $ip;
                $data['message'] = 'Successfully Uploaded';
                $retVals = $this->seekahoo_lib->return_status('success', $serviceName, $data, $ipJson);
                }

                }
               }
              echo $retVals;
				//exit;
				return;
				}*/

/*End of Update Section*/
/* Forget password(Recover) Section*/

     public function recover_post()
		{
			$six_digit_random_number = mt_rand(100000, 999999);
			$serviceName = 'user_signup';
			
			$ip['mobile']   = trim($this->input->post('mobile'));
			$ipJson = json_encode($ip);
			if (empty($ip['mobile']))
            {    
            	
                $data['message'] = "Mobile number is null....";
				$retVals1 = $this->seekahoo_lib->return_status('error', $serviceName, $data, $ipJson);
		         //json_decode($retVals1);	
			}
			    else 
			    {    
			    	 $chkmob=$this->user_model->recover($ip);
                     if($chkmob=="true")
		             {
		             	 $six_digit_random_number = mt_rand(10000000, 99999999);
		             	 //echo $six_digit_random_number;exit()
				         $ipJson = json_encode($ip);
			             $data['message'] = "Password sent to number";
					     $retVals1 = $this->seekahoo_lib->return_status('success', $serviceName, $data, $ipJson); 
					     /*==================Sending Otp Again=====================*/ 
                           $user="developer321322@indglobal-consulting.com:indglobal123";

					    $sender="TEST SMS";
					    $number = $ip['mobile'];
					    $message="Your Temporary Password is :".$six_digit_random_number." To change Your Paasword Login with this Please do not share this password with Anyone - Doctorway"; 
					               
					    $ch = curl_init();
					    curl_setopt($ch,CURLOPT_URL, "http://api.mVaayoo.com/mvaayooapi/MessageCompose");
					    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
					    curl_setopt($ch, CURLOPT_POST, 1);
					    curl_setopt($ch, CURLOPT_POSTFIELDS, "user=".$user."&senderID=".$sender."&receipientno=".$number."&msgtxt=".$message."");
					    $buffer = curl_exec($ch);
					   
					    curl_close($ch);
					    /*==================Sending Otp Again=====================*/
					    /*==================Updating Otp Again=====================*/
                        $upuser = array( 
                					   'password' => base64_encode($six_digit_random_number),
                					   );
                        $user = $this->user_model->updt_pass($ip,$upuser);
					    /*==================Updating Otp Again=====================*/
				     
		             }
		             else
		             {
		             	$data['message'] = "Please Sign up first";
					    $retVals1 = $this->seekahoo_lib->return_status('error', $serviceName, $data, $ipJson);	
					    json_decode($retVals1);
		             }

				        
		        }
			        header("content-type: application/json");
			        echo $retVals1;
			        exit;
	     	}  


/*End of Forget (Recover) Section*/
/*View details Section Starts*/
public function viewdet_post()
		{
			$serviceName = 'View detail';
			//getting posted values
			$ip['user_id'] = trim($this->input->post('user_id'));
						
			$ipJson = json_encode($ip);
           
			//validation
			$validation_array = 1;
									
					$ip_array[] = array("user_id", $ip['user_id'], "not_null", "user_id", "Users id is empty.");
					

					$validation_array = $this->validator->validate($ip_array);
			
					if ($validation_array !=1) 
					{
					 $data['message'] = $validation_array;
					 $retVals1 = $this->seekahoo_lib->return_status('error', $serviceName, $data, $ipJson);
					} 
					else if (isset($ip['user_id'])) 
					{      
						 $data['data'] = $this->user_model->view_det($ip,$serviceName);
					     $retVals1 = $this->seekahoo_lib->return_status('success', $serviceName, $data, $ipJson);

					     json_decode($retVals1);
					}
					
     		          //echo $retVals1 = $this->signup_model->signup($ip, $serviceName);
			          header("content-type: application/json");
			          echo $retVals1;
			          exit;
	     	}

/*End of View details Section*/
/*Favrourite Submission Section Starts*/

	}
?>