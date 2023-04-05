<?php

if(!isset($routes))
{ 
    $routes = \Config\Services::routes(true);
}

$routes->group('po', ['namespace' => 'App\Modules\Po\Controllers', 'filter' => 'web-auth'], function($subroutes){
    $subroutes->add('action/(:any)','PoAction::$1');
    $subroutes->add('ajax/(:any)','PoAjax::$1');
    $subroutes->add('', 'Po::index');
	$subroutes->add('(:any)', 'Po::$1');

});
