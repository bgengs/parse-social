<?php

namespace App\Handlers\Auth\SocialAuth\Two;


interface ProviderInterface
{
	/**
	 * Redirect the user to the authentication page for the provider.
	 */
	public function redirect();
	/**
	 * Get the User instance for the authenticated user.
	 *
	 * @return User
	 */
	public function user();
}