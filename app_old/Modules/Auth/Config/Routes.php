<?php

if(!isset($routes))
{ 
    $routes = \Config\Services::routes(true);
}

$routes->group('auth', ['namespace' => 'App\Modules\Auth\Controllers'], function($subroutes){
	$subroutes->add('action/(:any)','AuthAction::$1');
    $subroutes->add('ajax/(:any)','AuthAjax::$1');
    $subroutes->add('', 'Auth::login', ['as' => 'login']);
	$subroutes->add('(:any)', 'Auth::$1');
});