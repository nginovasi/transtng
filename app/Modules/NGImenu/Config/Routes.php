<?php

if(!isset($routes))
{ 
    $routes = \Config\Services::routes(true);
}

$routes->group('NGImenu', ['namespace' => 'App\Modules\NGImenu\Controllers', 'filter' => 'web-auth'], function($subroutes){
    $subroutes->add('action/(:any)','NGImenuAction::$1');
    $subroutes->add('ajax/(:any)','NGImenuAjax::$1');
    $subroutes->add('', 'NGImenu::index');
	$subroutes->add('(:any)', 'NGImenu::$1');

});