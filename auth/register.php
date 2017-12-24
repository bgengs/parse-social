<?php

use App\Handlers\Auth\Auth;
use App\Lib\App;

require_once '../vendor/autoload.php';

if (!empty($_POST) && isset($_POST['action']))
{

	//instantiate the app
	$app = new App();

	//check if the user already logged in
	if($app->isLoggedIn()) {
		header('location: /dashboard.php');
		exit;
	}

	if($_POST['action'] === 'registration') {

		//user wants to register through social login
		$service = $_POST['driver'];
		//check if the user requested for a valid oAuth service
		if (Auth::isValidOAuthService($service))
		{
			$app->run(new Auth());
		}
		else
		{
			//we do not support that driver
			print 'Invalid service';
		}
	}
	elseif($_POST['action'] === 'register') {
		//user wants to register with password
		$result = $app->run(new Auth())->getResult();
		if($result) {
			header('location: /welcome.php');
		}
		else {
			header('location: /register.php');
		}
	}
}
else
{
	header('location: /index.php');
}