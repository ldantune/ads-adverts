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

//Rotas para a dashboard
if(file_exists($dashboard = ROOTPATH . 'routes/dashboard.php')){
    require $dashboard;
}

//Rotas para a API REST
if(file_exists($api = ROOTPATH . 'routes/api.php')){
    require $api;
}

\Fluent\Auth\Facades\Auth::routes();


