<?php

if(!isset($routes))
{ 
    $routes = \Config\Services::routes(true);
}

$routes->group('api', ['namespace' => 'App\Modules\Api\Controllers'], function($subroutes){
    $subroutes->add('token/(:any)','Token::$1', ["filter" => "token-auth"]);
    $subroutes->add('v1/(:any)','MobileV1::$1', ["filter" => "api-auth"]);
    $subroutes->add('dev/(:any)','MobileDev::$1', ["filter" => "api-auth"]);
    $subroutes->add('tes/(:any)','Tes::$1');
    $subroutes->add('public/(:any)','ApiPublic::$1');
    $subroutes->add('call/(:any)','Call::$1');
});