<?php

namespace App\Exception;

class InvalidArgumentExceptionHandler {
	public static function handle($e)
	{
		//somewhere something wrong with method params
		header('location: /error.php');
	}
}