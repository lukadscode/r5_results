<?php
require '../vendor/autoload.php';

//define('DEBUG_TIME', microtime(true));

/*$whoops = new \Whoops\Run;
$whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler);
$whoops->register();*/

$router = new App\Router(dirname(__DIR__) . '/views');
$router
    //connexion
    ->get('/logout', 'auth/logout', 'logout')
    ->get('/404', 'auth/404', '404')
    ->match('/login', 'auth/login', 'login_auth')
    ->match('/forget', 'auth/forgetpassword', 'forgetpass_auth')
    ->match('/reset', 'auth/resetpassword', 'resetpass_auth')

    //
    ->match('/', 'home/index', 'home')
    ->match('/classe', 'home/classe', 'classe')

    ->run();
