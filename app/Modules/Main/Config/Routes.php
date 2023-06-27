<?php

if (!isset($routes)) {
    $routes = \Config\Services::routes(true);
}

$routes->group('main', ['namespace' => 'App\Modules\Main\Controllers', 'filter' => 'web-auth'], function ($subroutes) {
    $subroutes->add('action/(:any)', 'Action::$1');
    $subroutes->add('ajax/(:any)', 'MainAjax::$1');
    $subroutes->add('', 'Main::index');
    $subroutes->add('(:any)', 'Main::$1');
});
