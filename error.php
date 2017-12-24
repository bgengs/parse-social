<?php

use App\Lib\App;

require_once 'vendor/autoload.php';

$app = new App();

if($app->session()->hasMessage()) {
    print_r($app->session()->flush());
}
else {
    print_r("We have an error");
}