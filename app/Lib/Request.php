<?php

namespace App\Lib;

class Request {
	private $data = [
		'requests' => [],
		'method' => '',
		'referer' => '',
		'url' => '',
		'query' => '',
		'files' => [],
		'user' => null,
		'session' => null
	];

	public function __construct(Session $session)
	{
		$this->data['requests'] = array_merge($_GET, $_POST);
		$this->data['files'] = $_FILES;
		$this->data['method'] = $_SERVER['REQUEST_METHOD'];
		$this->data['referer'] = @$_SERVER['HTTP_REFERER'];
		$this->data['url'] = $_SERVER['REQUEST_URI'];
		$this->data['query'] = @$_SERVER['QUERY_STRING'];
		if($this->data['method'] === 'POST' && !$session->verifyCSRFToken($this->get('csrf_token'))) {
			$session->flush('Invalid CSRF Token');
			header('location: ' . $this->data['referer']);
			exit;
		}
		$this->data['user'] = $session->getUser();
		$this->data['session'] = $session;
	}

	/**
	 * Get current session
	 *
	 * @return mixed
	 */
	public function session()
	{
		return $this->data['session'];
	}

	/**
	 * get current user
	 *
	 * @return mixed
	 */
	public function user()
	{
		return $this->data['user'];
	}

	/**
	 * check if a key exists
	 *
	 * @param $key
	 *
	 * @return bool
	 */
	public function has($key)
	{
		return isset($this->data['requests'][$key]);
	}

	/**
	 * Get value by key from request
	 *
	 * @param $key
	 *
	 * @return null
	 */
	public function get($key)
	{
		return $this->has($key) ? $this->data['requests'][$key] : null;
	}

	/**
	 * Merge data with requests
	 *
	 * @param $array
	 */
	public function merge($array)
	{
		$this->data['requests'] = array_merge($this->data['requests'], $array);
	}

	/**
	 * Get the requested method
	 *
	 * @return mixed
	 */
	public function method() {
		return $this->data['method'];
	}

	/**
	 * Get the referer
	 *
	 * @return mixed
	 */
	public function referer()
	{
		return $this->data['referer'];
	}

	/**
	 * Get the request url
	 *
	 * @return mixed
	 */
	public function url()
	{
		return $this->data['url'];
	}

	/**
	 * get the query string
	 *
	 * @return mixed
	 */
	public function query()
	{
		return $this->data['query'];
	}
}