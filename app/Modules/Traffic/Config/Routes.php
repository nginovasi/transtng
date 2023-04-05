<?php

if(!isset($routes))
{ 
    $routes = \Config\Services::routes(true);
}

$routes->group('traffic', ['namespace' => 'App\Modules\Traffic\Controllers', 'filter' => 'web-auth'], function($subroutes){
    $subroutes->add('action/(:any)','TrafficAction::$1');
    $subroutes->add('ajax/(:any)','TrafficAjax::$1');
    $subroutes->add('', 'Traffic::index');
	$subroutes->add('(:any)', 'Traffic::$1');

});

