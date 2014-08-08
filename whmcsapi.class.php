<?PHP

class WHMCSAPI {

	const VERSION = '0.01';

	private $curl = false;

	private $url = false;
	private $username = false;
	private $password = false;
	private $timeout = 10;

	private $error = false;

	public function __construct($settings=array()) {
		if(!array_key_exists('url', $settings)) throw new Exception('setting param url missing');
		$this->url = $settings['url'];	
	
		if(!array_key_exists('username', $settings)) throw new Exception('username param is missing');
		$this->username = $settings['username'];

		if(!array_key_exists('password', $settings)) throw new Exception('password param is missing');
		$this->password = $settings['password'];

		if(array_key_exists('timeout', $settings)) $this->timeout = (int) $settings['timeout'];

		$this->curl = curl_init();
		if($this->curl === false) throw new Exception('curl_init failed, ' . curl_error());

		curl_setopt($this->curl, CURLOPT_URL, $this->url);
		curl_setopt($this->curl, CURLOPT_USERAGENT, 'WHMCSAPI-PHP-Class/' . self::VERSION);
		curl_setopt($this->curl, CURLOPT_POST, 1);
		curl_setopt($this->curl, CURLOPT_CONNECTTIMEOUT, $this->timeout);
		curl_setopt($this->curl, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($this->curl, CURLOPT_SSL_VERIFYHOST, 0);
		curl_setopt($this->curl, CURLOPT_SSL_VERIFYPEER, 0);
	}

	public function __destruct() {
		if($this->curl !== false) curl_close($this->curl);
	}

	public function getError() {
		return $this->error;
	}

	public function request($params) {
		if(array_key_exists('username', $params)) throw new Exception('username is a reserved param and cannot be passed to this method');
		if(array_key_exists('password', $params)) throw new Exception('password is a reserved param and cannot be passed to this method');
		if(array_key_exists('responsetype', $params)) throw new Exception('responsetype is a reserved param and cannot be passed to this method');
		
		if(!array_key_exists('action', $params)) throw new Exception('action param is required to use this method');

		$params['username'] = $this->username;
		$params['password'] = $this->password;
		$params['responsetype'] = 'json';

		curl_setopt($this->curl, CURLOPT_POSTFIELDS, $params);
		
		$curl_exec = @curl_exec($this->curl);
		$curl_info = curl_getinfo($this->curl);
		$curl_error = curl_error($this->curl);
		
		if($curl_error != '' || $curl_exec === false) {
			$this->error = $curl_error;
			return false;
		}

		/*
		WHMCS doesnt return the proper content-type for JSON so far now this code is commented out

		if($curl_info['content_type'] != 'application/json') {
			$this->error = 'WHMCS server responded with a content-type of ' . $curl_info['content_type'] . ', expected content-type is application/json';
			return false;
		}
		*/
	
		$response = @json_decode(@utf8_encode($curl_exec), true);
		if(!is_array($response)) {
			$this->error = 'Failed to decode JSON response, ' . json_last_error();
			return false;
		}

		return $response;
	}
}
