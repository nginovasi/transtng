<?php

use Kint\Zval\Value;

function res_success($status, $message, $data) {
    $response = [
        'status'  => $status,
        'message' => $message,
        'data'    => $data
    ];

    return $response;
}

function res_notfound($status, $message) {
    $response = [
        'status' => $status,
        'message' => $message
    ];

    return $response;
}

function res_success_custom1($status,$message,$param,$value,$param2,$value2,$data){
    $response = [
        'status'  => $status,
        'message' => $message,
        $param    => $value,
        $param2    => $value2,
        'data'    => $data
        
    ];

    return $response;
}

function res_success_custom2($status,$message,$data,$param,$value,$param2,$value2){
    $response = [
        'status'  => $status,
        'message' => $message,
        'data'    => $data,
        $param    => $value,
        $param2   => $value2
    ];

    return $response;
}
function res_success_custom3($status,$message,$data,$param,$value,$param2,$value2,$param3,$value3){
    $response = [
        'status'  => $status,
        'message' => $message,
        'data'    => $data,
        $param    => $value,
        $param2   => $value2,
        $param3   => $value3
    ];

    return $response;
}

function res_where($res_where = [], $root_where = "") {
    $fix_where = $root_where != "" ? $root_where . " " : "";
    if($res_where) {
        foreach ($res_where as $key => $value) {
            if($value == "") {
                break;
            } else {
                return $fix_where . "" . $key . " = "  . "'" . $value ."'";
            }
        }
    }

    return false;
}