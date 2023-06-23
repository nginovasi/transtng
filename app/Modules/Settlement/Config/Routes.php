<?php

if (!isset($routes)) {
    $routes = \Config\Services::routes(true);
}

$routes->group('settlement', ['namespace' => 'App\Modules\Settlement\Controllers', 'filter' => 'web-auth'], function ($subroutes) {
    $subroutes->add('action/(:any)', 'SettlementAction::$1');
    $subroutes->add('ajax/(:any)', 'SettlementAjax::$1');
    $subroutes->add('pdf/(:any)', 'SettlementPdf::$1');
    $subroutes->add('', 'Settlement::index');
    $subroutes->add('(:any)', 'Settlement::$1');
});
