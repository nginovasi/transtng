<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;
use App\Core\BaseModel;

class TokenAuthenticationEncryption implements FilterInterface
{
   

    private function encrypted($data){
        $secretKey  = '2W87k4rL6nYopDgXb3F95uJvEc1HdRwZ';
        $v = $data;
		if(strlen($secretKey) != 32){
			echo json_encode("SecretKey length is not 32 chars");
		}else{
			$iv = substr($secretKey, 0, 16);
			$key = [$secretKey, $iv];
			$encrypted = openssl_encrypt($v, 'aes-256-cbc', $key[0], 0, $key[1]);
			
            return $encrypted;
			
		}
    }

    public function before(RequestInterface $request, $arguments = null)
    {   
     
        helper('extension');
        date_default_timezone_set('Asia/Jakarta');
        $env = $_SERVER['CI_ENVIRONMENT'];
        $timestamp = $request->getHeader('X-TIMESTAMP');
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
        
        if(isset($timestamp) && $timestamp->getValue() != ""){
            $iat = strtotime(date($timestamp->getValue())) + 120;
            $exp = strtotime(date('Y-m-d H:i:s'));

            if($exp > $iat){
                $data["log_result"] = json_encode(["success" => false, "error_code" => "408", "message" => "Request Expired"]);
                $baseModel->log_api($data);
                $res = $this->encrypted(json_encode(["success" => false, "error_code" => "408", "message" => "Request Expired"]));

                header("HTTP/1.1 401 Unauthorized");
                die($res);
            }else{
                // $data["log_result"] = json_encode(["success" => true]);
                // $baseModel->log_api($data);
            }
        }else{
            $data["log_result"] = json_encode(["success" => false, "error_code" => "409", "message" => "Invalid Request"]);
            $baseModel->log_api($data);
            $res = $this->encrypted(json_encode(["success" => false, "error_code" => "409", "message" => "Invalid Request"]));
            header("HTTP/1.1 401 Unauthorized");
            die($res);
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