<?php

namespace App\Exception;

use Parse\ParseException;
use Parse\ParseUser;

class ParseExceptionHandler
{
	public static function handleParseError(ParseException $e)
	{
		$code = $e->getCode();
		switch ($code)
		{
			case 209: // INVALID_SESSION_TOKEN
				ParseUser::logOut();
				header('location: index.php');
				break;
			default:
				print_r($e);
				exit;
		}
	}
}