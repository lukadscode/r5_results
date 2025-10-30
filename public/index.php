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
    ->match('/signup', 'auth/sign_up', 'signup_auth')
    ->match('/forget', 'auth/forgetpassword', 'forgetpass_auth')
    ->match('/reset', 'auth/resetpassword', 'resetpass_auth')
    ->match('/confirm/[*:token]', 'auth/confirm', 'confirm')

    //
    ->match('/', 'home/index', 'home')
    ->match('/classe/[*:token]', 'classes/index', 'classe')
    ->post('/addClasse', 'classes/storeClasse', 'addClasse')
    ->post('/updateClasse', 'classes/updateClasse', 'updateClasse')
    ->match('/delete/classe/[*:classe_id]', 'classes/deleteClasse', 'deleteClasse')

    ->post('/storeEleve', 'eleves/storeEleve', 'storeEleve')
    ->post('/deleteEleve', 'eleves/deleteEleve', 'deleteEleve')
    ->post('/importExcel', 'eleves/importExcel', 'importExcel')

    //Paddlet
    ->match('/padlet', 'padlet/index', 'padlet')
    ->match('/padlet/categorie', 'padlet/create_categorie', 'padlet_categorie')
    ->match('/padlet/articles', 'padlet/articles', 'padlet_articles')

    ->match('/diplome', 'pdf/diplome', 'diplome')



    ->run();
