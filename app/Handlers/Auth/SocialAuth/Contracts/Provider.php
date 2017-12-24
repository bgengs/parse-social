<?php

namespace App\Handlers\Auth\SocialAuth\Contracts;

interface Provider {
	/**
	 * Redirect for authentication
	 *
	 * @return mixed
	 */
	public function redirect();

	/**
	 * Get the user information
	 *
	 * @return mixed
	 */
	public function user();
}