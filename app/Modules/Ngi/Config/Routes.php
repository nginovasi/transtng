<?php

if(!isset($routes))
{ 
    $routes = \Config\Services::routes(true);
}

$routes->group('ngi', ['namespace' => 'App\Modules\Ngi\Controllers', 'filter' => 'web-auth'], function($subroutes){
    $subroutes->add('action/(:any)','NgiAction::$1');
    $subroutes->add('ajax/(:any)','NgiAjax::$1');
    $subroutes->add('', 'Ngi::index');
	$subroutes->add('(:any)', 'Ngi::$1');

});