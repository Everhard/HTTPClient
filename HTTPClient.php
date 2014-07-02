<?php
class HTTPClient {
	/*
		HTTPClient (cURL) Settings:
		*. CURLOPT_URL:              The URL to fetch.
		*. CURLOPT_USERAGENT:        The contents of the "User-Agent" header to be used in a HTTP request.
		*. CURLOPT_HEADER:           TRUE to include the header in the output.
		*. CURLOPT_TIMEOUT:          The maximum number of seconds to allow cURL functions to execute.
		*. CURLOPT_CONNECTTIMEOUT:   The number of seconds to wait while trying to connect.
		*. CURLOPT_POST:             TRUE to do a regular HTTP POST.
		*. CURLOPT_POSTFIELDS:       The full data to post in a HTTP "POST" operation.
		*. CURLOPT_COOKIEFILE:       The name of the file containing the cookie data.
		*. CURLOPT_RETURNTRANSFER:   TRUE to return the transfer as a string instead of outputting it out directly.
		*. CURLOPT_FOLLOWLOCATION:   TRUE to follow any "Location: " header that the server sends as part of the HTTP header.
		
		Docs on PHP.net:
		http://www.php.net/manual/ru/function.curl-setopt.php
	*/

	public function __construct($url = NULL) {

		// Initialization cURL:
		$this->curl = curl_init($url);
		
		// Default cURL settings:
		curl_setopt($this->curl, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($this->curl, CURLOPT_HEADER, TRUE);
		curl_setopt($this->curl, CURLOPT_TIMEOUT, 120);
		curl_setopt($this->curl, CURLOPT_CONNECTTIMEOUT, 120);
		curl_setopt($this->curl, CURLOPT_FOLLOWLOCATION, FALSE);
		curl_setopt($this->curl, CURLOPT_COOKIEFILE, '');
	}

	public function do_request() {
		$result = curl_exec($this->curl);
		if (!$result) {
			$this->curl_errors[] = curl_error($this->curl)." (".curl_errno($this->curl).").";
			return false;
		}
		return $result;
	}

	public function set_url($url) {
		$this->url = $url;
		curl_setopt($this->curl, CURLOPT_URL, $this->url); 
	}
	
	public function set_user_agent($user_agent) {
		$this->user_agent = $user_agent;
		curl_setopt($this->curl, CURLOPT_USERAGENT, $this->user_agent);
	}
	
	public function set_post_method($post_data) {
		curl_setopt($this->curl, CURLOPT_POST, TRUE);
		curl_setopt($this->curl, CURLOPT_POSTFIELDS, $post_data);
	}
	
	public function set_get_method() {
		curl_setopt($this->curl, CURLOPT_HTTPGET, TRUE);
	}
	
	public function close_client() {
		curl_close($this->curl);
	}
	
	private $url;
	private $user_agent;
	private $curl;
	private $curl_errors = array();
}
?>