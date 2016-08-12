<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	
class uploader
{
	var $CI;
	function uploader(){
		$this->CI =& get_instance();
	}
	
	function upload_image($value, $flag,$ip) {
		//print_r($value);exit();
		$allowedExts = array("jpg", "jpeg", "png", "gif", "mov","MOV", "mp4", "m4v", "JPG", "JPEG");
		if ($value['type'] == "application/octet-stream"){
			$imageMime = getimagesize($value['tmp_name']); // get temporary file REAL info
			if (empty($imageMime['mime'])) {
				$imageMime['mime'] = mime_content_type($value['tmp_name']); // get temporary file REAL info
			}
			$value['type'] = $imageMime['mime'];
		}
		$extension = end(explode(".", $value["name"]));
		if ((($value["type"] == "image/jpeg") || ($value["type"] == "video/mp4")  || ($value["type"] == "video/quicktime") || ($value["type"] == "video/x-m4v") || ($value["type"] == "image/jpg") || ($value["type"] == "image/png") || ($value["type"] == "image/gif"))  && in_array($extension, $allowedExts)) {
			if ($value["error"] > 0) {
				return false;
			}
			$container = 'uploads/'.$ip['user_id'];
			$profilePic = 'uploads/'.$ip['user_id'].'/profile/photos';
			$profileThumb = 'uploads/'.$ip['user_id'].'/profile/thumbs';
			$postUploadOrg = 'uploads/'.$ip['user_id'].'/post/photos';
			$postUploadThumb = 'uploads/'.$ip['user_id'].'/post/thumbs';
			$chatPic = 'uploads/'.$ip['user_id'].'/chat/photos';
			$chatThumb = 'uploads/'.$ip['user_id'].'/chat/thumbs';
			if (!file_exists($container)) {
				mkdir($container, 0755, true);
			}
			if (!file_exists($profilePic)) {
				mkdir($profilePic, 0755, true);
				mkdir($profileThumb, 0755, true);	
			}
			if (!file_exists($postUploadOrg)) {
				mkdir($postUploadOrg, 0755, true);
				mkdir($postUploadThumb, 0755, true);	
			}
			if (!file_exists($chatPic))
			{
				mkdir($chatPic, 0755, true);
				mkdir($chatThumb, 0755, true);
			}
			$name = rand().strtotime(date('Y-m-d H:i:s')).'.'.$extension;
			if ($flag == 'profile') {
				$pathName = $profilePic."/". $name;
				$thumnail_path = $profileThumb."/". $name;
			}
			if ($flag == 'post') {
				$pathName = $postUploadOrg."/". $name;
				$thumnail_path = $postUploadThumb."/". $name;
			}
			if ($flag == 'chat_media') {
				$pathName = $chatPic."/". $name;
				$thumnail_path = $chatThumb."/". $name;
			}
			if (move_uploaded_file($value["tmp_name"], $pathName)) {
				//$out['photo_url'] =  $pathName;
				$out['profile_org_url'] =  $pathName;
				 $img = array("jpg","JPG", "jpeg", "JPEG",  "png",  "PNG", "gif");
				 $video = array("mp4", "mov", "m4v","MOV");
				 if (in_array($extension, $img)) {
				 	 $out['type'] = 'image';
				 } if (in_array($extension, $video)) {
				 	 $out['type'] = 'video';
				 }
				if (($value["type"] == "video/mp4")  || ($value["type"] == "video/quicktime")  || ($value["type"] == "video/x-m4v")) {
					$nameVideo = rand().strtotime(date('Y-M-D H:I:S')).'.'.'jpeg';
					$thumbpathVideo = $postUploadThumb;
					$out['profile_thumb_url'] = $this->makeVideoThumbnails($out['profile_org_url'], $nameVideo,$thumbpathVideo);;
				} else {
					$out['profile_thumb_url'] = $this->make_thumb($out['profile_org_url'],$thumnail_path);
				}
				return $out;
			} else {
				return 'failed';
			}
		} else {
			return 'failed';
		}
	}
	
	function upload_image_android($value, $flag,$ip) {
		$allowedExts = array("jpg", "jpeg", "png", "gif", "mov","MOV", "mp4", "m4v", "JPG", "JPEG");
		if ($value['type'] == "application/octet-stream"){
			$imageMime = getimagesize($value['tmp_name']); // get temporary file REAL info
			if (empty($imageMime['mime'])) {
				$imageMime['mime'] = mime_content_type($value['tmp_name']); // get temporary file REAL info
			}
			$value['type'] = $imageMime['mime'];
		}
		$extension = end(explode(".", $value["name"]));
		if ((($value["type"] == "image/jpeg") || ($value["type"] == "video/mp4")  || ($value["type"] == "video/quicktime") || ($value["type"] == "video/x-m4v") || ($value["type"] == "image/jpg") || ($value["type"] == "image/png") || ($value["type"] == "image/gif"))  && in_array($extension, $allowedExts)) {
			if ($value["error"] > 0) {
				return false;
			}
			$container = 'uploads/'.$ip['user_id'];
			$profilePic = 'uploads/'.$ip['user_id'].'/profile/photos';
			$profileThumb = 'uploads/'.$ip['user_id'].'/profile/thumbs';
			$postUploadOrg = 'uploads/'.$ip['user_id'].'/post/photos';
			$postUploadThumb = 'uploads/'.$ip['user_id'].'/post/thumbs';
			$chatPic = 'uploads/'.$ip['user_id'].'/chat/photos';
			$chatThumb = 'uploads/'.$ip['user_id'].'/chat/thumbs';
			if (!file_exists($container)) {
				mkdir($container, 0755, true);
			}
			if (!file_exists($profilePic)) {
				mkdir($profilePic, 0755, true);
				mkdir($profileThumb, 0755, true);	
			}
			if (!file_exists($postUploadOrg)) {
				mkdir($postUploadOrg, 0755, true);
				mkdir($postUploadThumb, 0755, true);	
			}
			if (!file_exists($chatPic))
			{
				mkdir($chatPic, 0755, true);
				mkdir($chatThumb, 0755, true);
			}
			
			$name = rand().strtotime(date('Y-m-d H:i:s')).'.'.$extension;
			if ($flag == 'profile') {
				$pathName = $profilePic."/". $name;
				$thumnail_path = $profileThumb."/". $name;
			}
			if ($flag == 'post') {
				$pathName = $postUploadOrg."/". $name;
				$thumnail_path = $postUploadThumb."/". $name;
			}
			if ($flag == 'chat_media') {
				$pathName = $chatPic."/". $name;
				$thumnail_path = $chatThumb."/". $name;
			}
			if (move_uploaded_file($value["tmp_name"], $pathName)) {
				$out['photo_url'] =  $pathName;
				 $img = array("jpg","JPG", "jpeg", "JPEG",  "png",  "PNG", "gif");
				 $video = array("mp4", "mov", "m4v","MOV");
				 if (in_array($extension, $img)) {
				 	 $out['type'] = 'image';
				 } if (in_array($extension, $video)) {
				 	 $out['type'] = 'video';
				 }
				if (($value["type"] == "video/mp4")  || ($value["type"] == "video/quicktime")  || ($value["type"] == "video/x-m4v")) {
					$nameVideo = rand().strtotime(date('Y-M-D H:I:S')).'.'.'jpeg';
					$thumbpathVideo = $postUploadThumb;
					$out['thumbnail_url'] = $this->makeVideoThumbnails_android($out['photo_url'], $nameVideo,$thumbpathVideo);;
				} else {
					$out['thumbnail_url'] = $this->make_thumb($out['photo_url'],$thumnail_path);
				}
				return $out;
			} else {
				return 'failed';
			}
		} else {
			return 'failed';
		}
	}
	
	function makeVideoThumbnails($photoUrl ,$name,$thumbpath) {
		$video = escapeshellcmd($photoUrl);
		$cmd = "ffmpeg -i $video 2>&1";
		$second = 1;
		if (preg_match('/Duration: ((\d+):(\d+):(\d+))/s', `$cmd`, $time)) {
			$total = ($time[2] * 3600) + ($time[3] * 60) + $time[4];
			$second = rand(1, ($total - 1));
		}
		
		$image  = $thumbpath.'/'.$name;
		$cmd = "ffmpeg -i $video -deinterlace -an -ss $second -t 00:00:01 -r 1 -y -vcodec mjpeg -f mjpeg $image 2>&1";
		$do = `$cmd`;
		$videoThumb = $this->video_thumb($image, $name, $image);
		return $videoThumb;
	}
	
	function makeVideoThumbnails_android($photoUrl ,$name,$thumbpath) {
		$video = escapeshellcmd($photoUrl);
		$cmd = "ffmpeg -i $video 2>&1";
		$second = 1;
		if (preg_match('/Duration: ((\d+):(\d+):(\d+))/s', `$cmd`, $time)) {
			$total = ($time[2] * 3600) + ($time[3] * 60) + $time[4];
			$second = rand(1, ($total - 1));
		}
		
		$image  = $thumbpath.'/'.$name;
		$cmd = "ffmpeg -i $video -deinterlace -an -ss $second -t 00:00:01 -r 1 -y -vcodec mjpeg -f mjpeg $image 2>&1";
		$do = `$cmd`;
		$videoThumb = $this->video_thumb_android($image, $name, $image);
		return $videoThumb;
	}
	
	function video_thumb($updir ,$name,$thumbpath)
	{
	  // Get the CodeIgniter super object
    	$CI =& get_instance();
	  // Path to image thumbnail
		  if(  file_exists($thumbpath))
		{
			// LOAD LIBRARY
			$CI->load->library('image_lib');
			  // CONFIGURE IMAGE LIBRARY
			$config['image_library']    = 'gd2';
			$config['source_image']     = $updir;
			$config['new_image']        = $thumbpath;
			$config['maintain_ratio']   = FALSE;
			$config['height']           = 320;
			$config['width']            = 320;
			$CI->image_lib->initialize($config);
			$CI->image_lib->resize();
			$CI->image_lib->clear();
			//echo $CI->image_lib->display_errors();
		}

    return $thumbpath;
	}
	
	function video_thumb_android($updir ,$name,$thumbpath)
	{
	  // Get the CodeIgniter super object
    	$CI =& get_instance();
	  // Path to image thumbnail
		  if(  file_exists($thumbpath))
		{
			// LOAD LIBRARY
			$CI->load->library('image_lib');
			  // CONFIGURE IMAGE LIBRARY
			$config['image_library']    = 'gd2';
			$config['source_image']     = $updir;
			$config['new_image']        = $thumbpath;
			$config['maintain_ratio']   = FALSE;
			$config['height']           = 320;
			$config['width']            = 320;
			$config['rotation_angle'] = 270;
			$CI->image_lib->initialize($config); 
			$CI->image_lib->resize();
			$CI->image_lib->rotate();
			$CI->image_lib->clear();
			//echo $CI->image_lib->display_errors();
		}

    return $thumbpath;
	}
	
	
	function image_thumb($updir ,$name,$thumbpath,$flag)
	{
	  // Get the CodeIgniter super object
    	$CI =& get_instance();
	  // Path to image thumbnail
		  $height = 190;
		  $width  = 190;
		  if ($flag == 'post') {
			  $height = 320;
			  $width  = 320;
			  $config['rotation_angle'] = 270;
		  }
		  if( ! file_exists($thumbpath))
		{
			// LOAD LIBRARY
			$CI->load->library('image_lib');
			  // CONFIGURE IMAGE LIBRARY
			$config['image_library']    = 'gd2';
			$config['source_image']     = $updir;
			$config['new_image']        = $thumbpath;
			$config['maintain_ratio']   = FALSE;
			$config['height']           = $height;
			$config['width']            = $width;
			//$config['rotation_angle'] = '90';
			$CI->image_lib->initialize($config);
			$CI->image_lib->resize();
			$CI->image_lib->rotate(); 
			$CI->image_lib->clear();
			//echo $CI->image_lib->display_errors();
		}

    return $thumbpath;
	}


	function make_thumb($src, $dest) {
		$desired_width = 190;
		/* read the source image */
		
		$ext = pathinfo($src, PATHINFO_EXTENSION);
		if($ext == 'png')
		{
		$source_image = imagecreatefrompng($src);
		$width = imagesx($source_image);
		$height = imagesy($source_image);
		}
		else
		{
		  $source_image = imagecreatefromjpeg($src);
		  $width = imagesx($source_image);
		  $height = imagesy($source_image);
		} 
		/* find the "desired height" of this thumbnail, relative to the desired width  */
		$desired_height = floor($height * ($desired_width / $width));
		
		/* create a new, "virtual" image */
		$virtual_image = imagecreatetruecolor($desired_width, $desired_height);
		
		/* copy source image at a resized size */
		imagecopyresampled($virtual_image, $source_image, 0, 0, 0, 0, $desired_width, $desired_height, $width, $height);
		// Fix Orientation
		$exif = exif_read_data($src);
		//echo "<pre>";
		//print_r($exif);exit;
             $orientation = @$exif['Orientation'];
    switch($orientation) {
        case 3:
            $virtual_image = imagerotate($virtual_image, 180, 0);
            break;
        case 6:
            $virtual_image = imagerotate($virtual_image, -90, 0);
            break;
        case 8:
            $virtual_image = imagerotate($virtual_image, 90, 0);
            break;
    }
		/* create the physical thumbnail image to its destination */
		imagejpeg($virtual_image, $dest, 90);
		
		return $dest;
	}
	function make_bitly_url($url,$login,$appkey,$format = 'xml',$version = '2.0.1')
{
	//create the URL
	$bitly = 'http://api.bit.ly/shorten?version='.$version.'&longUrl='.urlencode($url).'&login='.$login.'&apiKey='.$appkey.'&format='.$format;
	
	//get the url
	//could also use cURL here
	$response = file_get_contents($bitly);
	
	//parse depending on desired format
	if(strtolower($format) == 'json')
	{
		$json = @json_decode($response,true);
		return $json['results'][$url]['shortUrl'];
	}
	else //xml
	{
		$xml = simplexml_load_string($response);
		return 'http://bit.ly/'.$xml->results->nodeKeyVal->hash;
	}
}

function upload_image_bitly($value, $flag,$ip) {
		$flag = "post";
		//echo $value['type'];
		$allowedExts = array("jpg", "jpeg", "png", "gif", "mov","MOV", "mp4", "m4v","x-png");
		if ($value['type'] == "application/octet-stream"){
			$imageMime = getimagesize($value['tmp_name']); // get temporary file REAL info
			if (empty($imageMime['mime'])) {
				$imageMime['mime'] = mime_content_type($value['tmp_name']); // get temporary file REAL info
			}
			$value['type'] = $imageMime['mime'];
		}
		$extension = end(explode(".", $value["name"]));
		if ((($value["type"] == "image/jpeg") || ($value["type"] == "video/mp4")  || ($value["type"] == "video/quicktime") || ($value["type"] == "video/x-m4v") || ($value["type"] == "image/jpg") || ($value["type"] == "image/png") || ($value["type"] == "image/gif"))  && in_array($extension, $allowedExts)) {
			if ($value["error"] > 0) {
				return false;
			}
			$container = 'datas';
			$profilePic = 'datas/'.$ip['post_id'].'/profile/photos';
			$profileThumb = 'datas/'.$ip['post_id'].'/profile/thumbs';
			$postUploadOrg = 'datas/';
			$postUploadThumb = 'datas/';
			if (!file_exists($container)) {
				mkdir($container, 0755, true);
				mkdir($profilePic, 0755, true);
				mkdir($profileThumb, 0755, true);
				mkdir($postUploadOrg, 0755, true);
				mkdir($postUploadThumb, 0755, true);
			}
			$name = rand().strtotime(date('Y-m-d H:i:s')).'.'.$extension;
			if ($flag == 'profile') {
				$pathName = $profilePic."/". $name;
				$thumnail_path = $profileThumb."/". $name;
			}
			if ($flag == 'post') {
				$pathName = $postUploadOrg."/". $name;
				$thumnail_path = $postUploadThumb."/". $name;
			}
			if (move_uploaded_file($value["tmp_name"], $pathName)) {
				$out['photo_url'] =  $pathName;
				 $img = array("jpg","JPG", "jpeg", "JPEG",  "png",  "PNG", "gif");
				 $video = array("mp4", "mov", "m4v","MOV");
				 if (in_array($extension, $img)) {
				 	 $out['type'] = 'image';
				 } if (in_array($extension, $video)) {
				 	 $out['type'] = 'video';
				 }
				if (($value["type"] == "video/mp4")  || ($value["type"] == "video/quicktime")  || ($value["type"] == "video/x-m4v")) {
					$nameVideo = rand().strtotime(date('Y-M-D H:I:S')).'.'.'jpeg';
					$thumbpathVideo = $postUploadThumb;
					//$out['thumbnail_url'] = $this->makeVideoThumbnails($out['photo_url'], $nameVideo,$thumbpathVideo);;
				} else {
					//$out['thumbnail_url'] = $this->make_thumb($out['photo_url'],$thumnail_path);
				}
				return $out;
			} else {
				return 'failed';
			}
		} else {
			return 'failed';
		}
	}
}

