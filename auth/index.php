<?php

require_once __DIR__ . '/../vendor/autoload.php';

use App\Handlers\Auth\Auth;
use App\Lib\App;

$app = new App();

if($app->isLoggedIn()) {
	header('location: /dashboard.php');
	exit;
}

if($app->session()->hasPendingAuthorization()) {
	//returned user from oAuth
	$result = $app->run(new Auth())->getResult();
	//unset pending authorization
	$app->session()->unsetPendingAuthorization();
	if($result) {
		//user signed up and logged in
		header('location: /welcome.php');
	}
	else {
		//could not log in
		header('location: /error.php');
	}
}
else {
	//user does not have a pending authorization
	header('location: /index.php');
}