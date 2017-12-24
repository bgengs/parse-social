<?php

namespace App\Lib;

use Parse\ParseUser;

class Session {
	private static $csrf_token;

	/**
	 * @var ParseUser
	 */
	private $user = null;

	/**
	 * Set session value by key
	 *
	 * @param $key
	 * @param $value
	 *
	 * @return mixed
	 */
	public function put($key, $value)
	{
		return $_SESSION[$key] = $value;
	}

	/**
	 * Get session value by key
	 *
	 * @param $key
	 *
	 * @return null
	 */
	public function get($key)
	{
		return isset($_SESSION[$key]) ? $_SESSION[$key] : null;
	}

	/**
	 * Return and remove key
	 *
	 * @param $key
	 *
	 * @return null
	 */
	public function pull($key)
	{
		$val = $this->get($key);
		$this->unset($key);
		return $val;
	}

	/**
	 * Unset a key
	 *
	 * @param $key
	 */
	public function unset($key)
	{
		unset($_SESSION[$key]);
	}

	/**
	 * Get csrf token
	 */
	public function setCSRFToken()
	{
		self::$csrf_token = md5(uniqid(rand(), TRUE));
		$this->put('_csrfToken', self::$csrf_token);
		$this->put('_csrfTokenLife', time()+15*60);
	}

	/**
	 * get the csrf token
	 *
	 * @return mixed
	 */
	public static function getCSRFToken()
	{
		return self::$csrf_token;
	}

	/**
	 * Verify csrf token
	 *
	 * @param $token
	 *
	 * @return bool
	 */
	public function verifyCSRFToken($token)
	{
		return $token === $this->get('_csrfToken') && $this->get('_csrfTokenLife') > time();
	}

	/**
	 * Set and get a flush message
	 *
	 * @param null $message
	 *
	 * @return null
	 */
	public function flush($message = null)
	{
		if($message) {
			return $this->put('flush', $message);
		}
		return $this->pull('flush');
	}

	/**
	 * check if the session has a flush message
	 *
	 * @return bool
	 */
	public function hasMessage()
	{
		return $this->get('flush') !== null;
	}

	/**
	 * set pending authorization status with driver
	 *
	 * @param $driver
	 */
	public function setPendingAuthorizationStatus($driver)
	{
		$this->put('pending_authorization', $driver);
	}

	/**
	 * get pending authorization status
	 *
	 * @return null
	 */
	public function hasPendingAuthorization()
	{
		return $this->get('pending_authorization');
	}

	/**
	 * get and unset pending authorization status
	 * @return null
	 */
	public function unsetPendingAuthorization()
	{
		return $this->pull('pending_authorization');
	}

	/**
	 * checks if the current user logged in
	 *
	 * @return bool
	 */
	public function isUserLoggedIn()
	{
		return $this->user !== null;
	}

	/**
	 * Set the current user
	 */
	public function setUser()
	{
		RunWithParse::run(function () {
			$user = ParseUser::getCurrentUser();
			if($user && $user->get('code') !== 1)
			{
				$this->user = $user;
			}
			else
			{
				ParseUser::logOut();
				$this->user = null;
			}
		});
	}

	/**
	 * Get the user Object
	 *
	 * @return ParseUser|null
	 */
	public function getUser()
	{
		return $this->user ? $this->user : null;
	}
}