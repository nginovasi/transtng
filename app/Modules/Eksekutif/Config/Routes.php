<?php

if (!isset($routes)) {
    $routes = \Config\Services::routes(true);
}

$routes->group('eksekutif', ['namespace' => 'App\Modules\Eksekutif\Controllers', 'filter' => 'web-auth'], function ($subroutes) {
    $subroutes->add('action/(:any)', 'EksekutifAction::$1');
    $subroutes->add('ajax/(:any)', 'EksekutifAjax::$1');
    $subroutes->add('pdf/(:any)', 'EksekutifPdf::$1');
    $subroutes->add('', 'Eksekutif::index');
    $subroutes->add('(:any)', 'Eksekutif::$1');
});
