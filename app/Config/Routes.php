<?php

use CodeIgniter\Router\RouteCollection;

$routes->setAutoRoute(false);

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'HomeController::index', ['as' => 'web.home']);


//Rotas para o manager
if(file_exists($manager = ROOTPATH . 'routes/manager.php')){
    require $manager;
}

//Rotas para a API REST
if(file_exists($manager = ROOTPATH . 'routes/api.php')){
    require $manager;
}

\Fluent\Auth\Facades\Auth::routes();


$routes->group('dashboard', ['filter' => 'auth:web'], function ($routes) {
    $routes->get('/', 'HomeController::dashboard', ['filter' => 'verified']);
    $routes->get('confirm', 'HomeController::confirm', ['filter' => 'confirm']);
});