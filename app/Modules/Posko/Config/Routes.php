<?php

if(!isset($routes))
{ 
    $routes = \Config\Services::routes(true);
}

$routes->group('posko', ['namespace' => 'App\Modules\Posko\Controllers', 'filter' => 'web-auth'], function($subroutes){
    $subroutes->add('action/(:any)','PoskoAction::$1');
    $subroutes->add('ajax/(:any)','PoskoAjax::$1');
    $subroutes->add('', 'Posko::index');
	$subroutes->add('(:any)', 'Posko::$1');

});