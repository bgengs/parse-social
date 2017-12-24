<?php


require_once 'vendor/autoload.php';
$app = new \App\Lib\App();

/**
 * check if the user is logged in
 */
if ($app->isLoggedIn())
{
	//user is logged in
	header('location: dashboard.php');
}
else
{
		//show the login form
		include 'pages/login.php';
}