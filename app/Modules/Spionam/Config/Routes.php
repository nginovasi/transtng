<?php

if(!isset($routes))
{ 
    $routes = \Config\Services::routes(true);
}

$routes->group('spionam', ['namespace' => 'App\Modules\Spionam\Controllers', 'filter' => 'web-auth'], function($subroutes){
    $subroutes->add('action/(:any)','SpionamAction::$1');
    $subroutes->add('ajax/(:any)','SpionamAjax::$1');
    $subroutes->add('', 'Spionam::index');
	$subroutes->add('(:any)', 'Spionam::$1');

});