<?php

use App\Handlers\Auth\Auth;
use App\Lib\App;

require_once '../vendor/autoload.php';

if(!empty($_POST) && isset($_POST['action']))
{
	//instantiate the app
	$app = new App();

	//check if already logged in
	if($app->isLoggedIn()) {
		header('location: /dashboard.php');
		exit;
	}

	//handle request
	if ($_POST['action'] === 'login')
	{

		//user wants to log in
		$result = $app->run(new Auth())->getResult();
		if ($result)
		{
			//user successfully logged in
			header('location: /welcome.php');
		}
		else
		{
			//login failed
			header('location: /error.php');
		}
	}
	else {
		header('location: /index.php');
	}
}
else {
	header('location: /index.php');
}