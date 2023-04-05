<?php

if(!isset($routes))
{ 
    $routes = \Config\Services::routes(true);
}

$routes->group('laporan', ['namespace' => 'App\Modules\Laporan\Controllers', 'filter' => 'web-auth'], function($subroutes){
    $subroutes->add('action/(:any)','LaporanAction::$1');
    $subroutes->add('ajax/(:any)','LaporanAjax::$1');
    $subroutes->add('', 'Laporan::index');
	$subroutes->add('(:any)', 'Laporan::$1');

});

