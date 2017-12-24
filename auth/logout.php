<?php

use App\Handlers\Auth\Logout;
use App\Lib\App;

require_once '../vendor/autoload.php';

if (!empty($_POST) && isset($_POST['action']) && $_POST['action'] === 'logout')
{
	//instantiate the app
	$app = new App();

	//log the user out
	if(!$app->run(new Logout())->getResult()) {
		header('location: /error.php');
	}
}
//any action sends the user to the index
//if not logout request, if not logged in, if logged in
header('location: /index.php');