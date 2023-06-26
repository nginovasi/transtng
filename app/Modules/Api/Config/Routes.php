<?php

if(!isset($routes))
{ 
    $routes = \Config\Services::routes(true);
}

$routes->group('api', ['namespace' => 'App\Modules\Api\Controllers'], function($subroutes){
    $subroutes->add('token/(:any)','Token::$1', ["filter" => "token-auth"]);
    $subroutes->add('tokenencryption/(:any)','TokenEncryption::$1', ["filter" => "token-auth-encryption"]);
    $subroutes->add('pisv1/(:any)','MobileV1::$1', ["filter" => "api-auth-encryption"]);
    $subroutes->add('dev/(:any)','TicketingDev::$1', ["filter" => "api-auth"]);
    $subroutes->add('public/(:any)','ApiPublic::$1');
});