<?php

/**
 * Set the server URL and the mount path
 */

use Parse\ParseClient;
use Parse\ParseSessionStorage;

\App\Lib\RunWithParse::run(function () {
	ParseClient::setServerURL(config('parse.server_url'), config('parse.mount_path'));

	/**
	 * Set the credentials
	 */
	ParseClient::initialize(config('parse.app_id'), null, config('parse.master_key'));

	/**
	 *Check server health
	 */
	$server_health = ParseClient::getServerHealth();

	if ($server_health['status'] !== 200)
	{
		//we have an error somewhere in the server
		print_r("Something went wrong");
		print_r($server_health);
		exit;
	}

//everything looks fine
	ParseClient::setStorage(new ParseSessionStorage());
});