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
        $ipAddress = "0.0.0.0";
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
        $expTime = $issuedAt + (1 * 60 * 60);

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

    // public function getToken()
    // {
    //     $path = FCPATH . "cert/kunci_rahasia.pem";
    //     $path2 = FCPATH . "cert/kunci_publik.pem";

    //     $header = json_encode([
    //         'typ' => 'JWT', 
    //         'alg' => 'ES256',
    //     ]);

    //     $payload = json_encode([
    //        'iat'   => '123',
    //        'sub'   => '123',
    //        'aud'   => 'com.ngi.trans',
    //        'iat'   => 1663792210,
    //        'exp'   => 1979411410,
    //     ]);

    //     $base64UrlHeader = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($header));
    //     $base64UrlPayload = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($payload));

    //     $data = $base64UrlHeader . "." . $base64UrlPayload;

    //     if(file_exists($path)) {
    //         $privateKey = file_get_contents($path);
    //         $privateKey = openssl_get_privatekey($privateKey, "Nusantara88");
    //         $publicKey = file_get_contents($path2);
    //         $publicKey = openssl_get_publickey($publicKey);

    //         if($privateKey){
    //             // openssl_public_encrypt($data, $encData, $publicKey);
    //             openssl_sign($data, $signature, $privateKey, OPENSSL_ALGO_SHA256);

    //             $base64UrlSignature = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($signature));
    //             // $base64UrlSignature = base64_encode($signature);

    //             $jwt = $data . "." . $base64UrlSignature;

    //             return $jwt;
    //             // openssl_public_encrypt($encData, $data, $publicKey);

    //             // echo $data;

    //             // echo base64_decode($data);
    //             // echo $data."\r\n\r\n\r\n\r\n";

    //             // $publicKey = file_get_contents($path2);
    //             // $publicKey = openssl_get_publickey($publicKey);
    //             // $signature = base64_decode(str_replace(['-', '_'], ['+', '/'], $base64UrlSignature));

    //             // $verify = openssl_verify($data, $signature, $publicKey, "sha256WithRSAEncryption");

    //             // return json_encode($verify);
    //         }else{
    //             return "Cant open private key";
    //         }
    //     }

    //     return "not exist";
    // }

    // public function tes($token){
    //     $arrToken = explode(".", $token);
    //     $signature = array_pop($arrToken);
    //     $data = implode(".", $arrToken);
        
    //     echo $data;
    //     echo " ||| " . $signature;

    //     $path = FCPATH . "cert/kunci_publik.pem";

    //     if(file_exists($path)) {
    //         $publicKey = file_get_contents($path);
    //         $publicKey = openssl_get_publickey($publicKey);

    //         if($publicKey){
    //             $signature = base64_decode(str_replace(['-', '_'], ['+', '/'], $signature));
    //             $verify = openssl_verify($data, $signature, $publicKey, "sha256WithRSAEncryption");

    //             return " ||| " . json_encode($verify);
    //         }else{
    //             return "cant open public key";
    //         }
    //     }

    //     return "not exist";
    // }

    // tuwo
    // public function signature(){
    //     echo "signature";
    // }

    // function signatureGenerator($data, $privateKey) {
    //     $signature = '';
    //     openssl_sign($data, $signature, $privateKey, OPENSSL_ALGO_SHA256);

    //     return base64_encode($signature);
    // }
}
