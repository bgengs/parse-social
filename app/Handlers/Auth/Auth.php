<?php

namespace App\Handlers\Auth;

use App\Handlers\Auth\SocialAuth\SocialAuthManager;
use App\handlers\Handler;
use App\Lib\RunWithParse;
use App\Models\User;

class Auth extends Handler
{
	//execute the jobs
	public function run()
	{
		if ($this->request->has('driver') || $this->session->hasPendingAuthorization())
		{
			return RunWithParse::run(function () {
				return $this->socialAuth();
			});
		}
		elseif ($this->request->has('register'))
		{
			return RunWithParse::run(function () {
				return $this->register();
			});
		}
		elseif ($this->request->has('login'))
		{
			//normal email password login
			return RunWithParse::run(function () {
				return $this->login();
			});
		}

		return false;
	}

	/**
	 * Register a new user
	 *
	 * @return bool
	 */
	public function register()
	{
		$user = User::findByEmail($this->request->get('email'));
		if ($user)
		{
			$this->session->flush('Email already used');

			return false;
		}

		User::signUp([
			'username'     => $this->request->get('email'),
			'name'         => $this->request->get('name'),
			'email'        => $this->request->get('email'),
			'password'     => $this->request->get('password'),
			'signedUpWith' => 'password'
		]);

		User::logIn($this->request->get('email'), $this->request->get('password'));

		return User::getCurrentUser() !== null;
	}

	/**
	 * Log the user in
	 *
	 * @return bool
	 */
	public function login()
	{
		if ($this->session->isUserLoggedIn())
		{
			return true;
		}

		User::logIn($this->request->get('email'), $this->request->get('password'));

		return User::getCurrentUser() !== null;
	}

	/**
	 * Register if new user
	 * Login if existing
	 *
	 * @return bool
	 * @throws \Exception
	 */
	public function socialAuth()
	{
		//check if the user already logged in
		if ($this->session->isUserLoggedIn())
		{
			return true;
		}

		//instantiate the social auth manager
		$provider = new SocialAuthManager($this->request);

		// http://url.com/?driver=facebook
		if ($this->request->has('driver'))
		{
			//we have driver set, so, let's redirect
			return $this->redirect($provider);
		}
		else
		{
			//user returned from redirect
			return $this->registerOrLogin($provider);
		}
	}

	/**
	 * Redirect to auth service provider
	 *
	 * @param SocialAuthManager $provider
	 */
	private function redirect(SocialAuthManager $provider)
	{
		$driver = $this->request->get('driver');
		//set the authorization status to the currently used driver
		$this->session->setPendingAuthorizationStatus($driver);
		$provider->driver($driver)->redirect();
	}

	/**
	 * Create a new user
	 *
	 * @param SocialAuthManager $provider
	 *
	 * @return bool
	 * @throws \Exception
	 */
	private function registerOrLogin(SocialAuthManager $provider)
	{
		$driver      = $this->session->hasPendingAuthorization();
		$social_user = $provider->driver($driver)->user();

		//find the user in database
		$user = User::find($social_user->getId());

		$passwd = str_random(8);

		if (!$user)
		{
			//not found in database, store
			User::signUpSocialUser($social_user, $driver, $passwd);
		}
		else
		{
			//update relevant fields
			$user->updateFromSocialUser($social_user);
			$user->changePasswd($passwd); //to let us log in with the user
		}

		User::logIn($social_user->getId(), $passwd);

		return User::getCurrentUser() !== null;
	}

	/**
	 * check if the requested service is allowed by our app
	 *
	 * @param $service
	 *
	 * @return bool
	 */
	public static function isValidOAuthService($service)
	{
		return in_array($service, array_keys(config('oauth.providers')));
	}

}