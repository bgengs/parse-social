<?php

namespace App\Handlers\Auth\SocialAuth\One;

use App\Handlers\Auth\SocialAuth\AbstractUser;

class User extends AbstractUser {

	/**
	 * Users access token
	 *
	 * @var
	 */
	private $token;

	/**
	 * Users access token secret
	 * @var
	 */
	private $tokenSecret;

	/**
	 * Set the token on the user
	 *
	 * @param $token
	 * @param $tokenSecret
	 *
	 * @return $this
	 */
	public function setToken($token, $tokenSecret)
	{
		$this->token = $token;
		$this->tokenSecret = $tokenSecret;
		return $this;
	}

	/**
	 * get user token
	 *
	 * @return mixed
	 */
	public function getToken()
	{
		return $this->token;
	}

	/**
	 * Get the token secret
	 *
	 * @return mixed
	 */
	public function getTokenSecret()
	{
		return $this->tokenSecret;
	}
}