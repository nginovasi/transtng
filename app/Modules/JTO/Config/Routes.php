<?php

if(!isset($routes))
{ 
    $routes = \Config\Services::routes(true);
}

$routes->group('jto', ['namespace' => 'App\Modules\Jto\Controllers', 'filter' => 'web-auth'], function($subroutes){
    $subroutes->add('action/(:any)','JtoAction::$1');
    $subroutes->add('ajax/(:any)','JtoAjax::$1');
    $subroutes->add('', 'Jto::index');
	$subroutes->add('(:any)', 'Jto::$1');

});