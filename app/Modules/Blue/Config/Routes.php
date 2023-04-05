<?php

if(!isset($routes))
{ 
    $routes = \Config\Services::routes(true);
}

$routes->group('blue', ['namespace' => 'App\Modules\Blue\Controllers', 'filter' => 'web-auth'], function($subroutes){
    $subroutes->add('action/(:any)','BlueAction::$1');
    $subroutes->add('ajax/(:any)','BlueAjax::$1');
    $subroutes->add('', 'Blue::index');
	$subroutes->add('(:any)', 'Blue::$1');

});