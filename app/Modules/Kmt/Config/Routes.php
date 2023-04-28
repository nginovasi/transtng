<?php

if (!isset($routes)) {
    $routes = \Config\Services::routes(true);
}

$routes->group('kmt', ['namespace' => 'App\Modules\Kmt\Controllers', 'filter' => 'web-auth'], function ($subroutes) {
    $subroutes->add('action/(:any)', 'KmtAction::$1');
    $subroutes->add('ajax/(:any)', 'KmtAjax::$1');
    $subroutes->add('', 'Kmt::index');
    $subroutes->add('(:any)', 'Kmt::$1');
});
