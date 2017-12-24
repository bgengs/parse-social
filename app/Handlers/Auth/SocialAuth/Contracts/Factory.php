<?php

namespace App\Handlers\Auth\SocialAuth\Contracts;

interface Factory {
	/**
	 * Set the driver
	 *
	 * @param $driver
	 *
	 * @return mixed
	 */
	public function driver($driver);
}