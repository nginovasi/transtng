<?php

if(!isset($routes))
{ 
    $routes = \Config\Services::routes(true);
}

$routes->group('qr', ['namespace' => 'App\Modules\Qr\Controllers', 'filter' => 'web-auth'], function($subroutes){
    $subroutes->add('action/(:any)','QrAction::$1');
    $subroutes->add('ajax/(:any)','QrAjax::$1');
    $subroutes->add('', 'Qr::index');
	$subroutes->add('(:any)', 'Qr::$1');

});