<?php

namespace App\Exception;

class InvalidStateExceptionHandler {
	public static function handle($e)
	{
		//waited too long to come back from oAuth
		header('location: /error.php');
	}
}