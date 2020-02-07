<?php

use Twig\Environment;
use Twig\Loader\FilesystemLoader;

include_once 'router/Request.php';
include_once 'router/Router.php';
include_once 'controller/IndexController.php';
require_once 'vendor/autoload.php';

$loader = new FilesystemLoader('template');
$templater = new Environment($loader,[]);


$indexController = new IndexController($templater);

$router = new Router(new Request);

$router->get('/', function (){
    global $indexController;

    return $indexController->getIndex();

});

$router->get('/index', function (){
    global $indexController;

    return $indexController->getIndex();

});

$router->get('/register',function (){
    global $indexController;

    return $indexController->getRegister();
});

$router->post('/register',function ($request){
    global $indexController;

    return $indexController->postRegister($request->getBody());
});


$router->get('/login',function (){
    global $indexController;

    return $indexController->getLogin();


});

$router->post('/login',function ($request){
    global $indexController;

});

?>