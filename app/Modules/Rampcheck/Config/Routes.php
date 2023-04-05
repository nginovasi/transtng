<?php

if(!isset($routes))
{ 
    $routes = \Config\Services::routes(true);
}

$routes->group('rampcheck', ['namespace' => 'App\Modules\Rampcheck\Controllers', 'filter' => 'web-auth'], function($subroutes){
    $subroutes->add('action/(:any)','RampcheckAction::$1');
    $subroutes->add('ajax/(:any)','RampcheckAjax::$1');
    $subroutes->add('', 'Rampcheck::index');
	$subroutes->add('(:any)', 'Rampcheck::$1');

});

