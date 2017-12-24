<?php

namespace App\Handlers\Auth\SocialAuth\One;

use App\Lib\Request;
use League\OAuth1\Client\Credentials\TokenCredentials;
use App\Handlers\Auth\SocialAuth\Contracts\Provider as ProviderContract;
use League\OAuth1\Client\Server\Server;

abstract class AbstractProvider implements ProviderContract
{
	/**
	 * The HTTP request instance.
	 *
	 * @var Request
	 */
	protected $request;
	/**
	 * The OAuth server implementation.
	 *
	 * @var \League\OAuth1\Client\Server\Server
	 */
	protected $server;
	/**
	 * Create a new provider instance.
	 *
	 * @param  Request  $request
	 * @param  \League\OAuth1\Client\Server\Server  $server
	 * @return void
	 */
	public function __construct(Request $request, Server $server)
	{
		$this->server = $server;
		$this->request = $request;
	}

	/**
	 * Redirect the user to the authentication page for the provider.
	 *
	 */
	public function redirect()
	{
		$this->request->session()->put(
			'oauth.temp', $temp = $this->server->getTemporaryCredentials()
		);
		return header('location: ' . $this->server->getAuthorizationUrl($temp));
	}

	/**
	 * Get the User instance for the authenticated user.
	 *
	 * @return User
	 * @throws \Exception
	 */
	public function user()
	{
		if (! $this->hasNecessaryVerifier()) {
			throw new \Exception('Invalid request. Missing OAuth verifier.');
		}
		$user = $this->server->getUserDetails($token = $this->getToken());
		$instance = (new User)->setRaw($user->extra)
			->setToken($token->getIdentifier(), $token->getSecret());
		return $instance->map([
			'id' => $user->uid, 'nickname' => $user->nickname,
			'name' => $user->name, 'email' => $user->email, 'avatar' => $user->imageUrl,
		]);
	}

	/**
	 * Get a Social User instance from a known access token and secret.
	 *
	 * @param  string $token
	 * @param  string $secret
	 *
	 * @return User
	 */
	public function userFromTokenAndSecret($token, $secret)
	{
		$tokenCredentials = new TokenCredentials();
		$tokenCredentials->setIdentifier($token);
		$tokenCredentials->setSecret($secret);
		$user = $this->server->getUserDetails($tokenCredentials);
		$instance = (new User)->setRaw($user->extra)
			->setToken($tokenCredentials->getIdentifier(), $tokenCredentials->getSecret());
		return $instance->map([
			'id' => $user->uid, 'nickname' => $user->nickname,
			'name' => $user->name, 'email' => $user->email, 'avatar' => $user->imageUrl,
		]);
	}

	/**
	 * Get the token credentials for the request.
	 *
	 * @return \League\OAuth1\Client\Credentials\TokenCredentials
	 */
	protected function getToken()
	{
		$temp = $this->request->session()->get('oauth.temp');
		return $this->server->getTokenCredentials(
			$temp, $this->request->get('oauth_token'), $this->request->get('oauth_verifier')
		);
	}

	/**
	 * Determine if the request has the necessary OAuth verifier.
	 *
	 * @return bool
	 */
	protected function hasNecessaryVerifier()
	{
		return $this->request->has('oauth_token') && $this->request->has('oauth_verifier');
	}

	/**
	 * Set the request instance.
	 *
	 * @param Request $request
	 *
	 * @return $this
	 */
	public function setRequest(Request $request)
	{
		$this->request = $request;
		return $this;
	}
}