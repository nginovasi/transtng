<?php

if (!isset($routes)) {
    $routes = \Config\Services::routes(true);
}

$routes->group('kmt', ['namespace' => 'App\Modules\kmt\Controllers', 'filter' => 'web-auth'], function ($subroutes) {
    $subroutes->add('action/(:any)', 'kmtAction::$1');
    $subroutes->add('ajax/(:any)', 'kmtAjax::$1');
    $subroutes->add('', 'kmt::index');
    $subroutes->add('(:any)', 'kmt::$1');
});
