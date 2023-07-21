<?php

namespace Hdelima\RDStation;

class RDStation {
	
	private $publicToken;
	private $privateToken;
	private $endpoint = "https://api.rd.services/platform";
	const TIMEOUT = 10;

	public function __construct($publicToken, $endpoint = null) 
	{
		if (!function_exists('curl_init') || !function_exists('curl_setopt')) {
			throw new \Exception("cURL support is required, but can't be found.");
		}

		$this->publicToken = $publicToken;

		if (!empty($endpoint)) {
			$this->endpoint = $endpoint;
		}
	}

	public function getApiEndpoint()
	{
		return $this->endpoint;
	}

	public function post($url, $args = array(), $timeout = self::TIMEOUT)
	{
		return $this->makeRequest('post', $url, $args, $timeout);
	}

	public function get($url, $args = array(), $timeout = self::TIMEOUT)
	{
		return $this->makeRequest('get', $url, $args, $timeout);
	}

	public function patch($url, $args = array(), $timeout = self::TIMEOUT)
	{
		return $this->makeRequest('patch', $url, $args, $timeout);
	}

	public function put($url, $args = array(), $timeout = self::TIMEOUT)
	{
		return $this->makeRequest('put', $url, $args, $timeout);
	}

	public function delete($url, $args = array(), $timeout = self::TIMEOUT)
	{
		return $this->makeRequest('delete', $url, $args, $timeout);
	}

	public function callEvent( string $email, $args = array(), string $eventName = "CONVERSION", $timeout = self::TIMEOUT)
	{
		$args['payload']['email'] => $email;
		return $this->makeRequest('post', "events?event_type=$eventName", $args, $timeout);
	}

	private function makeRequest($method, $url, $args = [], $timeout = self::TIMEOUT)
	{
		$url = $this->endpoint . '/' . $url;
		$headers = [
			'Accept: application/json',
			'Content-Type: application/json',
		];

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_VERBOSE, true);
		curl_setopt($ch, CURLOPT_HEADER, true);
		curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_ENCODING, '');
		curl_setopt($ch, CURLINFO_HEADER_OUT, true);

		switch (strtolower($method)) {
			case 'post':
				curl_setopt($ch, CURLOPT_POST, true);
				$url .= '?' . http_build_query(['api_key' => $this->publicToken]);
				curl_setopt($ch, CURLOPT_URL, $url);
				curl_setopt($ch, CURLOPT_POSTFIELDS, $this->prepareData($args));
				break;
			
			case 'get':
				$query = http_build_query($args, '', '&');
				$url .= '?' . $query;
				curl_setopt($ch, CURLOPT_URL, $url);
				break;

			case 'delete':
				curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE');
				break;

			case 'patch':
				curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PATCH');
				curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($args));
				break;

			case 'put':
				curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
				curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($args));
				break;
		}

		$response = curl_exec($ch);

		if (curl_errno($ch)) {
			throw new \Exception(curl_error($ch));
		}

		curl_close($ch);

		return json_decode($response, true);
	}

	private function prepareData($args)
	{
		$default = [
			'event_type' => 'CONVERSION',
			'event_family' => 'CDP',
			'payload' => [
				'conversion_identifier' => 'CONVERSION',
			]
		];
		return json_encode(array_replace_recursive($default, $args));
	}
}