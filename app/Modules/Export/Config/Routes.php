<?php

if(!isset($routes))
{ 
    $routes = \Config\Services::routes(true);
}

$routes->group('export', ['namespace' => 'App\Modules\Export\Controllers'], function($subroutes){
    $subroutes->add('pdf/(:any)','PdfAction::$1');
    $subroutes->add('action/(:any)','ExportAction::$1');
    $subroutes->add('ajax/(:any)','ExportAjax::$1');
    $subroutes->add('', 'Export::index');
	$subroutes->add('(:any)', 'Export::$1');

});
