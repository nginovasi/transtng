<?php

if(!isset($routes))
{ 
    $routes = \Config\Services::routes(true);
}

$routes->group('administrator', ['namespace' => 'App\Modules\Administrator\Controllers', 'filter' => 'web-auth'], function($subroutes){
    $subroutes->add('action/(:any)','AdministratorAction::$1');
    $subroutes->add('ajax/(:any)','AdministratorAjax::$1');
    $subroutes->add('', 'Administrator::index');
	$subroutes->add('(:any)', 'Administrator::$1');

});