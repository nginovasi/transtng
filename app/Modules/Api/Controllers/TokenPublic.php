<?php namespace App\Modules\Api\Controllers;

use App\Modules\Api\Models\ApiModel;
use App\Core\BaseController;

class TokenPublic extends BaseController
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

    public function generateToken(){
        $data = $this->request->getPost();
        $grant_type =  $data['grant_type'];
        $key = 'client_credentials';
       
        
        if($grant_type == $key){
            $date = $this->db->query("SELECT NOW() as date_now")->getRow();
        
            $encode = base64_encode(base64_encode("hubd4tenjiay-".$date->date_now));
            $resultToken = 'Bearer '.$encode;
            $expired = time() + 300;
    
            $response = [
                "success" => true,
                "access_token" => $encode,
                "scope" => "default",
                "token_type" => "Bearer",
                "expires_in" => $expired
            ];
            return $this->response->setJSON($response);
        }else{
            // $this->response->setStatusCode(404, 'Nope. Not here.');
            $response = [
                "success" => false,
                "error_description" => 'Unsupported grant_type value',
                "error" => "invalid_request",
               
            ];
            
            $this->response->setStatusCode(400, 'Bad Request');
            return $this->response->setJSON($response);

        }
       
       
    }

   

  
}
