<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;
use App\Core\BaseModel;

class TokenAuthentication implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {   
        helper('extension');
        date_default_timezone_set('Asia/Jakarta');
        $env = $_SERVER['CI_ENVIRONMENT'];
        $timestamp = $request->getHeader('X-TIMESTAMP');
        $deviceId = $request->getHeader("X-DEVICE-ID");

        $baseModel = new BaseModel();
        $headers = [];

        foreach ($request->getHeaders() as $key => $value) {
            $headers[$key] = $request->getHeader($key)->getValue();
        }

        $data = [
            "log_method" => $request->getMethod(),
            "log_url" => get_current_request_url(),
            "log_header" => json_encode($headers),
            "log_param" => json_encode($request->getVar()),
            "log_result" => "",
            "log_ip" => get_client_ip(),
            "log_user_agent" => get_client_user_agent()
        ];
        
        if(!isset($deviceId)||$deviceId==null||$deviceId->getValue() == ""){
            $data["log_result"] = json_encode(["success" => false, "status" => 407, "message" => "X-DEVICE-ID not set", "data" => null]);
            $baseModel->log_api($data);

            header("HTTP/1.1 401 Unauthorized");
            die($data["log_result"]);
        }

        if(isset($timestamp) && $timestamp->getValue() != ""){
            $iat = strtotime(date($timestamp->getValue())) + (60*60);
            $exp = strtotime(date('Y-m-d H:i:s'));

            if($exp > $iat){
                $data["log_result"] = json_encode(["success" => false, "status" => 408, "message" => "Request Expired", "data" => null]);
                $baseModel->log_api($data);

                header("HTTP/1.1 401 Unauthorized");
                die($data["log_result"]);
            }else{
                
            }
        }else{
            $data["log_result"] = json_encode(["success" => false, "status" => 409, "message" => "X-TIMESTAMP not set", "data" => null]);
            $baseModel->log_api($data);

            header("HTTP/1.1 401 Unauthorized");
            die($data["log_result"]);
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        helper('extension');
        date_default_timezone_set('Asia/Jakarta');

        $baseModel = new BaseModel();

        $headers = [];
        foreach ($request->getHeaders() as $key => $value) {
            $headers[$key] = $request->getHeader($key)->getValue();
        }

        $responses = json_decode($response->getBody());

        $data = [
            "log_method" => $request->getMethod(),
            "log_url" => get_current_request_url(),
            "log_header" => json_encode($headers),
            "log_param" => json_encode($request->getVar()),
            "log_result" => json_encode($responses),
            "log_ip" => get_client_ip(),
            "log_user_agent" => get_client_user_agent()
        ];

        $baseModel->log_api($data);
    }
}