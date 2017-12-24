<?php

namespace App\Handlers\Auth;

use App\handlers\Handler;
use Parse\ParseUser;

class Logout extends Handler {

	/**
	 * Execute the jobs
	 *
	 * @return mixed
	 */
	public function run()
	{
		if($this->session->isUserLoggedIn())
		{
			ParseUser::logOut();
			return true;
		}
		$this->session->flush('You\'re not logged in.');
		return false;
	}
}