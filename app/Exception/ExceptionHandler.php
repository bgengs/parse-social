<?php

namespace App\Exception;

class ExceptionHandler {
	public static function handle(\Exception $e)
	{
		//general exceptions handler
		//write down as logs
		error_log("\n\nTime: ".date('H:i:s d-m-Y')."\nFile: {$e->getFile()}\nLine: {$e->getLine()}\nMessage :{$e->getMessage()}");
		print_r("We have an error.");
	}
}