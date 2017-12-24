<?php

namespace App\Models;

use App\Handlers\Auth\SocialAuth\AbstractUser;
use App\Lib\RunWithParse;
use Parse\ParseQuery;
use Parse\ParseUser;

class User
{
	private $id;
	private $nickname;
	private $name;
	private $email;
	private $profilePicture;
	private $token;
	private $signedUpWith;

	/**
	 * @var ParseUser
	 */
	private $parseUser;

	/**
	 * @param $userId
	 *
	 * @return User|null
	 */
	public static function find($userId)
	{
		$query = new ParseQuery('_User');
		$query->equalTo('username', (string)$userId);
		$user = $query->first(true);
		if (empty($user))
		{
			return null;
		}

		return new User($user);
	}

	/**
	 * @param $email
	 *
	 * @return User
	 */
	public static function findByEmail($email)
	{
		$query = new ParseQuery('_User');
		$query->equalTo('email', $email);
		$user = $query->first(true);
		if (empty($user))
		{
			return null;
		}

		return new self($user);
	}

	/**
	 * @param $data
	 *
	 * @return mixed
	 */
	public static function signUp($data)
	{
		return RunWithParse::run(function () use ($data) {
			$parseUser = new ParseUser();
			foreach ($data as $k => $v)
			{
				$parseUser->set($k, $v);
			}
			$parseUser->signUp();

			return new self($parseUser);
		});
	}

	/**
	 * User constructor.
	 *
	 * @param ParseUser|null $user
	 *
	 * @throws \Exception
	 */
	public function __construct(ParseUser $user)
	{
		if ($user !== null)
		{
			RunWithParse::run(function () use ($user) {
				$this->id             = $user->get('username');
				$this->nickname       = $user->get('nickname');
				$this->name           = $user->get('name');
				$this->email          = $user->get('email');
				$this->profilePicture = $user->get('profilePicture');
				$this->token          = $user->get('token');
				$this->signedUpWith   = $user->get('signedUpWith');
			});
			$this->parseUser = $user;
		}
	}

	/**
	 * @param AbstractUser $user
	 * @param              $driver
	 * @param              $passwd
	 *
	 * @return mixed
	 */
	public static function signUpSocialUser(AbstractUser $user, $driver, $passwd)
	{
		return RunWithParse::run(function () use ($user, $driver, $passwd) {
			$parseUser = new ParseUser();
			$parseUser->set('token', $user->getToken());
			$parseUser->set('username', (string)$user->getId());
			$parseUser->set('nickname', $user->getNickname());
			$parseUser->set('password', $passwd);
			$parseUser->set('name', $user->getName());
			$parseUser->set('email', $user->getEmail());
			$parseUser->set('profilePicture', $user->getAvatar());
			$parseUser->set('signedUpWith', $driver);
			$parseUser->signUp();

			return new self($parseUser);
		});
	}

	/**
	 * @param AbstractUser $user
	 *
	 * @return mixed
	 */
	public function updateFromSocialUser(AbstractUser $user)
	{
		return RunWithParse::run(function () use ($user) {
			$this->token = $user->getToken();
			$this->parseUser->set('token', $user->getToken());
			//just in case of updates
			$this->name = $user->getName();
			$this->parseUser->set('name', $user->getName());

			$this->profilePicture = $user->getAvatar();
			$this->parseUser->set('profilePicture', $user->getAvatar());

			return $this->parseUser->save(true);
		});
	}

	/**
	 * @param $data
	 *
	 * @return mixed
	 */
	public function update($data)
	{
		return RunWithParse::run(function () use ($data) {
			if (isset($data['name']))
			{
				$this->name = $data['name'];
				$this->parseUser->set('name', $data['name']);
			}
			if (isset($data['email']))
			{
				$this->email = $data['email'];
				$this->parseUser->set('email', $data['email']);
			}
			if (isset($data['profilePicture']))
			{
				$this->profilePicture = $data['profilePicture'];
				$this->parseUser->set('profilePicture', $data['profilePicture']);
			}
			if (isset($data['token']))
			{
				$this->token = $data['token'];
				$this->parseUser->set('token', $data['token']);
			}
			if (isset($data['signedUpWith']))
			{
				$this->signedUpWith = $data['signedUpWith'];
				$this->parseUser->set('signedUpWith', $data['signedUpWith']);
			}
			if (!empty($data))
			{
				return $this->parseUser->save(true);
			}

			return true;
		});
	}

	/**
	 * @param $password
	 *
	 * @return mixed
	 */
	public function changePasswd($password)
	{
		return RunWithParse::run(function () use ($password) {
			$this->parseUser->set('password', $password);

			return $this->parseUser->save(true);
		});
	}

	/**
	 * @param $uid
	 * @param $password
	 */
	public static function logIn($uid, $password)
	{
		RunWithParse::run(function () use ($uid, $password) {
			ParseUser::logIn((string)$uid, $password);
		});
	}

	/**
	 * @return null|ParseUser
	 */
	public static function getCurrentUser()
	{
		return ParseUser::getCurrentUser();
	}
}