<?php

require_once 'vendor/autoload.php';

$app = new \App\Lib\App();

if(!$app->isLoggedIn()) {
	header('location: /index.php');
	exit;
}

include 'pages/dashboard.php';