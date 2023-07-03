<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;
use App\Core\BaseModel;

class ApiAuthentication implements FilterInterface
{

    public function before(RequestInterface $request, $arguments = null)
    {
        helper('extension');
        date_default_timezone_set('Asia/Jakarta');
        $baseModel = new BaseModel();

        $token = $request->getHeader('X-NGI-TOKEN');
        $deviceId = $request->getHeader("X-DEVICE-ID");
        $timestamp = $request->getHeader('X-TIMESTAMP');

        $env = $_SERVER['CI_ENVIRONMENT'];
        $headers = [];
        $keyToken =  $token->getValue();

        if($keyToken != 'dev'){

            if(!isset($deviceId)||$deviceId==null||$deviceId->getValue() == ""){
                $data["log_result"] = json_encode(["success" => false, "status" => 407, "message" => "X-DEVICE-ID not set", "data" => null]);
                $baseModel->log_api($data);
    
                header("HTTP/1.1 401 Unauthorized");
                die($data["log_result"]);
            }

            if(!isset($timestamp)||$timestamp==null||$timestamp->getValue() == ""){
                $data["log_result"] = json_encode(["success" => false, "status" => 407, "message" => "X-TIMESTAMP not set", "data" => null]);
                $baseModel->log_api($data);
    
                header("HTTP/1.1 401 Unauthorized");
                die($data["log_result"]);
            }

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

            if(isset($token) && $token->getValue() != "" && count(explode(".", $token->getValue())) == 3){
                $arrToken = explode(".", $token->getValue());
                $header = $arrToken[0];
                $payload = $arrToken[1];
                $signature = $arrToken[2];

                $verify = verify_data($header . "." . $payload, $signature);

                if($verify){
                    $payload = json_decode(decrypt_data($payload));

                    if($payload->exp > time()){

                    }else{
                        $data["log_result"] = json_encode(["success" => false, "status" => 509, "message" => "Token Expired", "data" => null]);
                        $baseModel->log_api($data);

                        header("HTTP/1.1 401 Unauthorized");
                        die($data["log_result"]);
                    }
                }else{
                    $data["log_result"] = json_encode(["success" => false, "status" => 505, "message" => "Invalid Token", "data" => null]);
                    $baseModel->log_api($data);

                    header("HTTP/1.1 401 Unauthorized");
                    die($data["log_result"]);
                }
            }else{
                $data["log_result"] = json_encode(["success" => false, "status" => 506, "message" => "Invalid Token", "data" => null]);
                $baseModel->log_api($data);

                header("HTTP/1.1 401 Unauthorized");
                die($data["log_result"]);
            }
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