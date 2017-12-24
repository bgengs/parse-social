<?php

namespace App\Handlers\Auth\SocialAuth;

use App\Handlers\Auth\SocialAuth\Contracts\Factory;
use App\Handlers\Auth\SocialAuth\Contracts\Provider;
use App\Handlers\Auth\SocialAuth\One\Providers\TwitterProvider;
use App\Handlers\Auth\SocialAuth\Two\AbstractProvider;
use App\Helpers\Arr;
use App\Lib\Request;
use League\OAuth1\Client\Server\Twitter as TwitterServer;

class SocialAuthManager implements Factory
{
	/**
	 * @var Provider
	 */
	private $driver;
	/**
	 *
	 * @var Request
	 */
	private $request;

	public function __construct(Request $request)
	{
		$this->request = $request;
	}

	/**
	 * Build an OAuth 2 provider instance.
	 *
	 * @param  string $provider
	 * @param  array  $config
	 *
	 * @return AbstractProvider
	 */
	public function buildProvider($provider, $config)
	{
		return new $provider(
			$this->request, $config['client_id'],
			$config['client_secret'], $this->formatRedirectUrl(),
			Arr::get($config, 'guzzle', [])
		);
	}

	/**
	 * Format the server configuration.
	 *
	 * @param  array $config
	 *
	 * @return array
	 */
	public function formatConfig(array $config)
	{
		return array_merge([
			'identifier' => $config['client_id'],
			'secret' => $config['client_secret'],
			'callback_uri' => $this->formatRedirectUrl(),
		], $config);
	}

	/**
	 * Format the callback URL, resolving a relative URI if needed.
	 *
	 * @return string
	 */
	protected function formatRedirectUrl()
	{
		return config('oauth.redirect_url');
	}

	public function driver($driver)
	{
		if($driver==='twitter') {
			$config = config('oauth.providers.twitter');
			return new TwitterProvider(
				$this->request, new TwitterServer($this->formatConfig($config))
			);
		}
		$config = config('oauth.providers.' . $driver);
		return $this->buildProvider($config['provider'], $config);
	}
}