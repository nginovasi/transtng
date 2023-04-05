<?php

function uri_segment($index){
   $uri = explode("/", uri_string(true));

   return count($uri) > $index ? $uri[$index] : '';
}

function groupby($datas, $by){
	$array = [];

	foreach ($datas as $data) {
		$array[$data->$by][] = $data;
	}

	return $array;
}

function unwrap_null($var, $default){
	return isset($var) === TRUE ? $var : $default;
}

function get_current_request_url(){
    return $_SERVER['REQUEST_URI'];
}

function get_client_ip() {
    $ipaddress = '';

    if (getenv('HTTP_CLIENT_IP'))
        $ipaddress = getenv('HTTP_CLIENT_IP');
    else if(getenv('HTTP_X_FORWARDED_FOR'))
        $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
    else if(getenv('HTTP_X_FORWARDED'))
        $ipaddress = getenv('HTTP_X_FORWARDED');
    else if(getenv('HTTP_FORWARDED_FOR'))
        $ipaddress = getenv('HTTP_FORWARDED_FOR');
    else if(getenv('HTTP_FORWARDED'))
       $ipaddress = getenv('HTTP_FORWARDED');
    else if(getenv('REMOTE_ADDR'))
        $ipaddress = getenv('REMOTE_ADDR');
    else
        $ipaddress = 'UNKNOWN';

    $arr = explode(", ", $ipaddress);
    $new_ipaddress = $arr > 0 ? $arr[0] : $ipaddress;


    return $new_ipaddress;
}

function get_client_user_agent(){
    return isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : NULL; 
}

function is_mobile(){
	$iPod    = stripos($_SERVER['HTTP_USER_AGENT'],"iPod");
	$iPhone  = stripos($_SERVER['HTTP_USER_AGENT'],"iPhone");
	$iPad    = stripos($_SERVER['HTTP_USER_AGENT'],"iPad");
	$Android = stripos($_SERVER['HTTP_USER_AGENT'],"Android");
	$webOS   = stripos($_SERVER['HTTP_USER_AGENT'],"webOS");

	return ($iPod || $iPhone || $iPad || $Android) ? true : false;
}

function encrypt_data($data){
    $path = FCPATH . "cert/kunci_publik.pem";

    if(file_exists($path)) {
        $publicKey = file_get_contents($path);
        $publicKey = openssl_get_publickey($publicKey);

        openssl_public_encrypt($data, $encData, $publicKey);

        return str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($encData));
    }

    return "";
}

function decrypt_data($encData){
    $path = FCPATH . "cert/kunci_rahasia.pem";
    $encData = base64_decode(str_replace(['-', '_'], ['+', '/'], $encData));

    if(file_exists($path)) {
        $privateKey = file_get_contents($path);
        $privateKey = openssl_get_privatekey($privateKey, "Nusantara88");

        openssl_private_decrypt($encData, $decData, $privateKey);

        return $decData;
    }

    return "";
}

function sign_data($data){
    $path = FCPATH . "cert/kunci_rahasia.pem";

    if(file_exists($path)) {
        $privateKey = file_get_contents($path);
        $privateKey = openssl_get_privatekey($privateKey, "Nusantara88");

        openssl_sign($data, $signature, $privateKey, OPENSSL_ALGO_SHA256);

        $base64UrlSignature = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($signature));

        return $base64UrlSignature;
    }

    return "";
}

function verify_data($data, $signature){
    $path = FCPATH . "cert/kunci_publik.pem";

    if(file_exists($path)) {
        $publicKey = file_get_contents($path);
        $publicKey = openssl_get_publickey($publicKey);

        $signature = base64_decode(str_replace(['-', '_'], ['+', '/'], $signature));
        $verify = openssl_verify($data, $signature, $publicKey, "sha256WithRSAEncryption");

        return $verify;
    }

    return false;
}