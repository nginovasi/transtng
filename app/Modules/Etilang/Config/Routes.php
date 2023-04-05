<?php

if(!isset($routes))
{ 
    $routes = \Config\Services::routes(true);
}

$routes->group('etilang', ['namespace' => 'App\Modules\Etilang\Controllers', 'filter' => 'web-auth'], function($subroutes){
    $subroutes->add('action/(:any)','EtilangAction::$1');
    $subroutes->add('ajax/(:any)','EtilangAjax::$1');
    $subroutes->add('', 'Etilang::index');
	$subroutes->add('(:any)', 'Etilang::$1');

});