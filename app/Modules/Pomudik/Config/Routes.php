<?php

if(!isset($routes))
{ 
    $routes = \Config\Services::routes(true);
}

$routes->group('pomudik', ['namespace' => 'App\Modules\Pomudik\Controllers', 'filter' => 'web-auth'], function($subroutes){
    $subroutes->add('action/(:any)','PomudikAction::$1');
    $subroutes->add('ajax/(:any)','PomudikAjax::$1');
    $subroutes->add('', 'Pomudik::index');
	$subroutes->add('(:any)', 'Pomudik::$1');

});