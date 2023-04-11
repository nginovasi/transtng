<?php

if(!isset($routes))
{ 
    $routes = \Config\Services::routes(true);
}

$routes->group('ngi', ['namespace' => 'App\Modules\Ngi\Controllers', 'filter' => 'web-auth'], function($subroutes){
    $subroutes->add('action/(:any)','ngiAction::$1');
    $subroutes->add('ajax/(:any)','ngiAjax::$1');
    $subroutes->add('', 'ngi::index');
	$subroutes->add('(:any)', 'ngi::$1');

});