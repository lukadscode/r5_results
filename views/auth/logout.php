<?php
session_start();
session_destroy();
header('Location: ' . $router->url('login'));
session_start();
$_SESSION['flash']['success'] = 'Déconnecté';
exit();