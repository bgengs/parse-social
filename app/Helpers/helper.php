<?php

session_start();

date_default_timezone_set("America/New_York");

require_once __DIR__ . '/functions.php';

use App\Helpers\Config;
use App\Lib\Session;

/**
 * load the configuration
 */
(new Config())->load();

/**
 * get config by config path
 *
 * @param $path
 *
 * @return null
 */
function config($path) {
	return Config::get($path);
}

/**
 * generate random string
 *
 * @param int $length
 *
 * @return bool|string
 */
function str_random($length = 16)
{
	$pool = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
	return substr(str_shuffle(str_repeat($pool, 5)), 0, $length);
}

/**
 * get the csrf token
 *
 * @return mixed
 */
function csrf_token() {
	return Session::getCSRFToken();
}

/**
 * Get csrf form field
 */
function csrf_field() {
	print "<input type='hidden' name='csrf_token' value='" . csrf_token() . "'>";
}


//init parse
require_once __DIR__ . '/Init.php';