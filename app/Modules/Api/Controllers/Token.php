<?php namespace App\Modules\Api\Controllers;

use App\Modules\Api\Models\ApiModel;
use App\Core\BaseController;

class Token extends BaseController
{
    private $apiModel;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->apiModel = new ApiModel();
    }

    public function index()
	{
		return redirect()->to(base_url()); 
	}

    public function test()
    {
        return view('App\Modules\Api\Views\test'); 
    }

    public function signature(){
        $timestamp = $this->request->getHeader("X-TIMESTAMP");
        // $ipAddress = get_client_ip(); //filter ip
        $ipAddress = "0.0.0.0";
        $data = json_encode([
            "timestamp" => $timestamp,
            "ip_address" => $ipAddress 
        ]);

        $signature = sign_data($data);

        if($signature != ""){
            $response = ["success" => true, "message" => "Success", "signature" => $signature];
        }else{
            $response = ["success" => true, "message" => "Invalid Request", "signature" => null, "error_code" => "500"];
        }

        return $this->response->setJson($response);
    }

    public function jwt(){
        $signature = $this->request->getPost("signature");
        $timestamp = $this->request->getHeader("X-TIMESTAMP");
        // $ipAddress = get_client_ip(); //filter ip
        // $ipAddress = "0.0.0.0";
        $data = json_encode([
            "timestamp" => $timestamp,
            "ip_address" => $ipAddress 
        ]);

        $verify = verify_data($data, $signature);

        if($verify){
            $token = $this->_generateJwtToken($ipAddress);
            $response = ["success" => true, "message" => "Success", "token" => $token];
        }else{
            $response = ["success" => false, "message" => "Invalid Signature", "token" => null, "error_code" => "500"];
        }

        return $this->response->setJson($response);
    }

    private function _generateJwtToken($ipAddress){
        $issuedAt = time();
        $expTime = $issuedAt + (1 * 15 * 60);

        $header = json_encode([
            'typ' => 'JWT', 
            'alg' => 'ES256',
        ]);

        $payload = json_encode([
           'aud'   => $ipAddress,
           'iat'   => $issuedAt,
           'exp'   => $expTime,
        ]);

        $encodedHeader = encrypt_data($header);
        $encodedPayload = encrypt_data($payload);

        $jwt = $encodedHeader . "." . $encodedPayload;
        $signature = sign_data($jwt);

        return $jwt . "." . $signature;
    }

    public function auth(){
        header('Content-Type: application/json');
        $payload = file_get_contents('php://input');

        $timestamp = $this->request->getHeader("X-TIMESTAMP");
        $deviceId = $this->request->getHeader("X-DEVICE-ID");

        if(!isset($payload)||$payload==null){
            $response = ["success" => false, "status" => 406, "message" => "Request body not set", "data" => null];
            return $this->response->setJson($response);
        }

        $token = $this->_generateJwtToken($deviceId->getValue());
        $signature = $this->signatureService($payload,$deviceId->getValue(),$timestamp->getValue(),$token);


        $data['token'] = $token;
        $data['expired'] = 60*15;
        $data['signature'] = $signature;

        $response = ["success" => true, "status" => 100, "message" => "Success", "data" => $data];
        
        return $this->response->setJson($response);
    }

    public function signatureService($payload,$client_secret,$timestamp,$token){
        $minify = json_encode(json_decode($payload));
        $sha256 = hash('sha256', $minify);
        $lowercase = strtolower($sha256);
        $encriptsi = $lowercase;
        $data = $encriptsi.':'.$timestamp.':'.$token;
        $encSHA512 = $this->sha512($data,$client_secret);

        $encBase64 = base64_encode($encSHA512);

        return $encBase64;
    }

    function sha512($payload,$secret_key){
        $algo = 'sha512';
        $signed_payload = hash_hmac(
             $algo,
             $payload,
             $secret_key,
             true,
        );
        return $signed_payload;
    }
}
