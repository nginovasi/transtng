<?php

if(!isset($routes))
{ 
    $routes = \Config\Services::routes(true);
}

$routes->group('api', ['namespace' => 'App\Modules\Api\Controllers'], function($subroutes){
    $subroutes->add('token/(:any)','Token::$1', ["filter" => "token-auth"]);
    $subroutes->add('v1/(:any)','MobileV1::$1', ["filter" => "api-auth"]);
    $subroutes->add('dev/(:any)','TicketingDev::$1', ["filter" => "api-auth"]);
    $subroutes->add('public/(:any)','ApiPublic::$1');
});