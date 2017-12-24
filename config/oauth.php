<?php

return [
	'redirect_url' => 'http://' .$_SERVER['HTTP_HOST'] . '/auth/',
	'providers' => [
		'twitter' => [
			'provider' => \App\Handlers\Auth\SocialAuth\One\Providers\TwitterProvider::class,
			'client_id' => '',
			'client_secret' => ''
		],
		'facebook' => [
			'provider' => \App\Handlers\Auth\SocialAuth\Two\Providers\FacebookProvider::class,
			'client_id' => '',
			'client_secret' => ''
		],
		'linkedIn' => [
			'provider' => \App\Handlers\Auth\SocialAuth\Two\Providers\LinkedInProvider::class,
			'client_id' => '',
			'client_secret' => ''
		],
		'instagram' => [
			'provider' => \App\Handlers\Auth\SocialAuth\Two\Providers\InstagramProvider::class,
			'client_id' => '',
			'client_secret' => ''
		],
		'github' => [
			'provider' => \App\Handlers\Auth\SocialAuth\Two\Providers\GithubProvider::class,
			'client_id' => '',
			'client_secret' => ''
		],
		'bitbucket' => [
			'provider' => \App\Handlers\Auth\SocialAuth\Two\Providers\BitbucketProvider::class,
			'client_id' => '',
			'client_secret' => ''
		],
		'google' => [
			'provider' => \App\Handlers\Auth\SocialAuth\Two\Providers\GoogleProvider::class,
			'client_id' => '',
			'client_secret' => ''
		]
	]
];
