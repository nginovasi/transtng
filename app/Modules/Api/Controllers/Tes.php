<?php namespace App\Modules\Api\Controllers;

use App\Modules\Api\Models\ApiModel;
use App\Core\BaseController;

class Tes extends BaseController
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

    public function login()
    {
        date_default_timezone_set('Asia/Jakarta');
        $username = $this->request->getPost("username");
        $password = $this->request->getPost("password");

        $sign = json_decode($this->_siganture());
        $jwt = json_decode($this->_token($sign->signature));
        $login = $this->_login($jwt->token);

        return $login;
    }

    protected function _siganture(){
        $url = '".base_url()."api/token/signature';

        $headers = array(
            'Content-Type:application/json',
            'X-TIMESTAMP:' . date('Y-m-d H:i:s')
        );

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, false);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $result = curl_exec($ch);

        if ($result === FALSE) {
            die('Oops! FCM Send Error: ' . curl_error($ch));
        }

        curl_close($ch);

        return $result;
    }

    protected function _token($signature){
        $url = '".base_url()."api/token/jwt';

        $data = array(
            "signature" => $signature
        );

        $headers = array(
            'X-TIMESTAMP:' . date('Y-m-d H:i:s')
        );

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        $result = curl_exec($ch);

        if ($result === FALSE) {
            die('Oops! FCM Send Error: ' . curl_error($ch));
        }

        curl_close($ch);

        return $result;
    }

    protected function _login($token){
        $url = '".base_url()."api/v1/bannerMobile';
        
        $headers = array(
            'X-NGI-TOKEN:'.$token
        );

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, false);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $result = curl_exec($ch);

        if ($result === FALSE) {
            die('Oops! FCM Send Error: ' . curl_error($ch));
        }

        curl_close($ch);

        return $result;
    }
}
