<?php
	/* Author:	chive@github
			Kim Thoenen
			kim@smuzey.ch
				
			smuzey Web Design & Development
			www.smuzey.ch
				
	 Last Change: 	07. January 13	*/
	
	// Please enter your API Key here
	// You can get it from here: https://www.pipelinedeals.com/admin/api (API_KEY)
	$api_key = '';
	
	
	/* API Adapter Function / Shorthand version
	     Arguments
		   $res		The wanted resource name, e.g.: "deals" or "admin/lead_statuses"
		   $conditions	Conditions in key=>value array, e.g.: "array('[deal_created][from_date]'=>'2011-01-01','[deal_created][to_date]' => '2012-01-01')"
		   $page	The wanted page as integer, e.g.: "2"
		   $postdata	For POST requests, e.g.: "deal[name]=Kinda a big deal"
		 Return value
		   array	JSON decoded PHP array, ready to use in your application
	*/
		
	function getData ($res, $conditions = null, $page = null, $postdata = false) {
		global $api_key;
		
		// Base URL
		$url = "https://api.pipelinedeals.com/api/v3/" . $res . ".json?api_key=" . $api_key;
		
		// Adding conditions
		if (!empty($conditions)) {
			foreach ($conditions as $key=>$value) {
				$url .= "&conditions" . $key . "=" . $value;
			}
		}
		
		// Adding page
		if (!empty($page)) { $url .= "&page=" . $page; }
		
		return getJSON(curl($url,$postdata));
	}
	
	/* API Adapter Function / URL version
	     Arguments
		   $url		Whole URL except the API_KEY part, e.g.: "https://api.pipelinedeals.com/api/v3/deals.json"
		   $postdata	For POST requests, e.g.: "deal[name]=Kinda a big deal"
		 Return value
		   array	JSON decoded PHP array, ready to use in your application
	*/
	
	function getDataURL ($url,$postdata = false) {
		global $api_key;
		
		// Do we already have arguments in the URL query string
		if (strstr($url, '?')) { $sign = '&'; }
		else { $sign = '?';	}
		
		// Construct string
		$url .= $sign . "api_key=" . $api_key;
		
		return getJSON(curl($url,$postdata));
	}
	
	
	// ***************************** //
	// Do not modify anything below! //
	// ***************************** //
		
	// Basic cURL function	
	function curl($url,$postdata = false) {
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
		curl_setopt($ch, CURLOPT_COOKIESESSION,0); 
		curl_setopt($ch, CURLOPT_COOKIEFILE, dirname(__FILE__) . "/cookie.txt");
		curl_setopt($ch, CURLOPT_COOKIEJAR, dirname(__FILE__) . "/cookie.txt");
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		
		if ($postdata != false) {
			curl_setopt($ch, CURLOPT_POST, 1); 
			curl_setopt($ch, CURLOPT_POSTFIELDS, $postdata); 
		}
		
		$res = curl_exec($ch);
		curl_close($ch);
		
		return $res;
	}
	
	// Basic json_decode function
	function getJSON ($res) {
		return json_decode((string)$res,true);
	}
