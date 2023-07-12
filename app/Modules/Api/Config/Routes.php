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
    $subroutes->add('qris_bjb_dev/(:any)','BJBQrisDev::$1', ["filter" => "api-auth"]);
    $subroutes->add('settlement/(:any)','SettlementFlazz::$1');
    $subroutes->add('public/(:any)','ApiPublic::$1');

    // settlement
    $subroutes->add('emoney/(:any)','Settlement\\Emoney::$1');
    $subroutes->add('brizzi/(:any)','Settlement\\Brizzi::$1');
    $subroutes->add('flazz/(:any)','Settlement\\Flazz::$1');
});