<?php namespace App\Modules\Auth\Controllers;

use App\Modules\Auth\Models\AuthModel;
use App\Core\BaseController;

class AuthAction extends BaseController
{
    private $authModel;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->authModel = new AuthModel();
    }

    public function index()
    {
        return redirect()->to(base_url()); 
    }

    public function login()
    {
        $session = \Config\Services::session();

        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');

        if($username!='' && $password!=''){
            $user = $this->authModel->getUser($username, $password);
            
            if(!is_null($user)){
                if ($user->is_deleted==0) {

                    $menu = $this->authModel->getMenu($user->user_type_code);

                    $sessionData = array(
                        'logged_in' => true,
                        'id' => $user->id,
                        'username' => $user->user_username,
                        'name' => $user->user_name,
                        'email' => $user->user_email,
                        'menu' => $menu

                    );

                    $session->set($sessionData);

                    $response = [
                        "success" => TRUE, 
                        "title" => "Success", 
                        "text" => "Berhasil" 
                    ];
                }else{
                    $response = [
                        "success" => false, 
                        "title" => "Error", 
                        "text" => "Pengguna Sudah Tidak Aktif" 
                    ];
                }
            }else{
                $response = [
                    "success" => false, 
                    "title" => "Error", 
                    "text" => "Username & Password Salah"
                ];
            }
        }else{
            $response = [
                "success" => false, 
                "title" => "Error", 
                "text" => "Username & Password Salah" 
            ];
        }
        
        echo json_encode($response);
    }

    function logout(){
        $session = \Config\Services::session();

        $session->destroy();

        return redirect()->to(base_url()); 
    }
}
