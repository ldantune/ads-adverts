<?php

use CodeIgniter\Router\RouteCollection;

$routes->setAutoRoute(false);

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index', ['as' => 'home']);


//Rotas para o manager
if(file_exists($manager = ROOTPATH . 'routes/manager.php')){
    require $manager;
}

//Rotas para a API REST
if(file_exists($manager = ROOTPATH . 'routes/api.php')){
    require $manager;
}