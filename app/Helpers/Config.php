<?php

namespace App\Helpers;

class Config {
	private static $config = [];

	public function load() {
		$files = glob(__DIR__.'/../../config/*.php');
		foreach ($files as $config_file) {
			$config = include $config_file;
			self::$config[pathinfo($config_file)['filename']] = $config;
		}
	}

	public static function get($path)
	{
		return get(self::$config, $path);
	}
}
