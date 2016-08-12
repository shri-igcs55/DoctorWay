<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class seekahoo_lib 
{
	var $CI;
	function seekahoo_lib() {
		$this->CI =& get_instance();
	}
  
	function return_status($msg, $serviceName, $data, $ipJson) 
	{
		$status['status_code'] = '200';
		if ($msg != 'success') 
		{
			$status['status_code'] = '100';
		}
		$status['status'] = $msg;
		$status['service_name'] = $serviceName;
		$status['data'] = $data;
		$this->logs($status, $ipJson);
		return $this->format_json($status);
	}

	function logs($status, $ipJson) 
	{
		$opJson = json_encode($status['data']);
		$data = array(
			'service_name' => $status['service_name'],
			'status' => $status['status'],
			'request' => $ipJson,
			'response' => $opJson,
			'log_created_date' => date('Y-m-d H:i:s')
		);
		$this->CI->db->insert('web_service_logs', $data);
	}
	
	function format_json($data = array())
	{
		return json_encode($data);
	}
	
	function make_bitly_url_post($post_id)
{	
	$url = "http://50.62.164.79/seekahoo_v3/before_layout.php?post_id=".$post_id;
	
	$login = 'o_3mpt05ddoa';
	$appkey = 'R_6b5126719f134c0a84101132fa7bbed0';
	$version = '2.0.1';
	$format = 'json';
	//create the URL
	 $bitly = 'http://api.bit.ly/shorten?version='.$version.'&longUrl='.urlencode($url).'&login='.$login.'&apiKey='.$appkey.'&format='.$format;
	
	//get the url
	//could also use cURL here
	$response = file_get_contents($bitly);
	
	//parse depending on desired format
	if(strtolower($format) == 'json')
	{    
		$json = @json_decode($response,true);
		//header("content-type: application/json");
		echo $this->format_json($json['results'][$url]['shortUrl']);
		// $json['results'][$url]['shortUrl'];
		exit;
	}
	else //xml
	{
		$xml = simplexml_load_string($response);
		echo  'http://bit.ly/'.$xml->results->nodeKeyVal->hash;
	}
}

}

/* End of file privue_lib.php */
/* Location: ./application/libraries/privue_lib.php */
