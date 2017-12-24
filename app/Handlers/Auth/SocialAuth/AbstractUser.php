<?php

namespace App\Handlers\Auth\SocialAuth;

use App\Handlers\Auth\SocialAuth\Contracts\User;

abstract class AbstractUser implements User {

	/**
	 * Unique user identifier
	 *
	 * @var
	 */
	private $id;

	/**
	 * get user nickname/username
	 *
	 * @var
	 */
	private $nickname;

	/**
	 * Get user full name
	 *
	 * @var
	 */
	private $name;

	/**
	 * get user email
	 *
	 * @var
	 */
	private $email;

	/**
	 * Get user avatar
	 *
	 * @var
	 */
	private $avatar;

	/**
	 * User raw data
	 *
	 * @var
	 */
	private $user;




	/**
	 * get the user ID
	 *
	 * @return mixed
	 */
	public function getId()
	{
		return $this->id;
	}

	/**
	 * Get user full name
	 *
	 * @return mixed
	 */
	public function getName()
	{
		return $this->name;
	}

	/**
	 * get user nickname
	 *
	 * @return mixed
	 */
	public function getNickname()
	{
		return $this->nickname;
	}

	/**
	 * get user email
	 *
	 * @return mixed
	 */
	public function getEmail()
	{
		return $this->email;
	}

	/**
	 * get user avatar
	 *
	 * @return mixed
	 */
	public function getAvatar()
	{
		return $this->avatar;
	}

	/**
	 * get raw user data
	 *
	 * @return mixed
	 */
	public function getRaw() {
		return $this->user;
	}

	/**
	 * set raw user
	 *
	 * @param $user
	 *
	 * @return $this
	 */
	public function setRaw(array $user) {
		$this->user = $user;
		return $this;
	}

	/**
	 * Map the given array onto the user's properties.
	 *
	 * @param  $attributes
	 * @return $this
	 */
	public function map(array $attributes)
	{
		foreach ($attributes as $key => $value) {
			$this->{$key} = $value;
		}
		return $this;
	}


	/**
	 * Determine if the given raw user attribute exists.
	 *
	 * @param  string  $offset
	 * @return bool
	 */
	public function offsetExists($offset)
	{
		return array_key_exists($offset, $this->user);
	}
	/**
	 * Get the given key from the raw user.
	 *
	 * @param  string  $offset
	 * @return mixed
	 */
	public function offsetGet($offset)
	{
		return $this->user[$offset];
	}
	/**
	 * Set the given attribute on the raw user array.
	 *
	 * @param  string  $offset
	 * @param  mixed  $value
	 * @return void
	 */
	public function offsetSet($offset, $value)
	{
		$this->user[$offset] = $value;
	}
	/**
	 * Unset the given value from the raw user array.
	 *
	 * @param  string  $offset
	 * @return void
	 */
	public function offsetUnset($offset)
	{
		unset($this->user[$offset]);
	}

	abstract public function getToken();

}