<?php
	/* Author:
		chive@github
		Kim Thoenen
		kim@smuzey.ch

		smuzey Web Design & Development
		www.smuzey.ch
	*/
	
	class PDAdapter {
		private $api_key;
		protected $base_url = "https://api.pipelinedeals.com/api/v3/";
		protected $method = "get";
		protected $request_url;
		protected $request_data;


		public function __construct($api_key, $custom_base_url = null) {
			$this->api_key = $api_key;
			if (!empty($custom_base_url)) { $this->base_url = $custom_base_url; }
		}

		public function setMethod($method) {
			$this->method = $method;
		}

		public function doRequest($res, $conditions = null, $page = null, $data = null) {
			$additional_params = null;
			// Adding condition params to URL
			if (!empty($conditions)) {
				foreach ($conditions as $key=>$value) {
					$additional_params .= "&conditions[" . $key . "]=" . $value;
				}
			}

			// Adding page param to URL
			if (!empty($page)) { $additional_params .= "&page=" . $page; }
			if (!empty($data)) { $this->request_data = $data; }

			$this->constructURL($res,$additional_params);

			return $this->decodeJSON($this->performCURL());
				
		}

		private function constructURL($res,$additional = "") {
			$this->request_url = $this->base_url . $res . ".json?api_key=" . $this->api_key . $additional;
		}

		private function performCURL() {
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
			curl_setopt($ch, CURLOPT_COOKIESESSION,0); 
			curl_setopt($ch, CURLOPT_COOKIEFILE, dirname(__FILE__) . "/cookie.txt");
			curl_setopt($ch, CURLOPT_COOKIEJAR, dirname(__FILE__) . "/cookie.txt");
			curl_setopt($ch, CURLOPT_URL, $this->request_url);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
			
			if ($this->method == "post" OR $this->method == "put" OR $this->method == "delete") {
				if ($this->method == "post") { curl_setopt($ch, CURLOPT_POST, 1); }
				else if ($this->method == "put") { curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT"); }
				else if ($this->method == "delete") { curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE"); }

				curl_setopt($ch, CURLOPT_POSTFIELDS, $this->request_data); 
			}

			
			$res = curl_exec($ch);
			curl_close($ch);
			
			return $res;
		}

		private function decodeJSON ($res) {
			return json_decode((string)$res,true);
		}


	}
