<?php

namespace App\Lib;

use App\Exception\ExceptionHandler;
use App\Exception\Exceptions\InvalidArgumentException;
use App\Exception\Exceptions\InvalidStateException;
use App\Exception\InvalidArgumentExceptionHandler;
use App\Exception\InvalidStateExceptionHandler;
use App\Exception\ParseExceptionHandler;
use Parse\ParseException;

class RunWithParse {
	/**
	 * Run parse functions within trap
	 *
	 * @param $closure
	 * @param $params
	 *
	 * @return mixed
	 */
	public static function run($closure, $params = []) {
		try {
			return call_user_func($closure, $params);
		}
		catch (ParseException $e) {
			ParseExceptionHandler::handleParseError($e);
		}
		catch (InvalidStateException $e) {
			InvalidStateExceptionHandler::handle($e);
		}
		catch (InvalidArgumentException $e) {
			InvalidArgumentExceptionHandler::handle($e);
		}
		catch(\Exception $e) {
			ExceptionHandler::handle($e);
			exit;
		}
		return null;
	}
}