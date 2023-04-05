<?php

if(!isset($routes))
{ 
    $routes = \Config\Services::routes(true);
}

$routes->group('Spda', ['namespace' => 'App\Modules\Spda\Controllers', 'filter' => 'web-auth'], function($subroutes){
    $subroutes->add('action/(:any)','SpdaAction::$1');
    $subroutes->add('ajax/(:any)','SpdaAjax::$1');
    $subroutes->add('', 'Spda::index');
	$subroutes->add('(:any)', 'Spda::$1');

});

