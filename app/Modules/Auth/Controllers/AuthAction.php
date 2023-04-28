<?php

namespace App\Modules\Auth\Controllers;

use App\Modules\Auth\Models\AuthModel;
use App\Core\BaseController;
use Google_Client;
use Google_Service_Oauth2;

class AuthAction extends BaseController
{
    private $client;
    private $authModel;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->authModel = new AuthModel();
        $this->client = new Google_Client();
        $this->client->setClientId('952480244845-on52q6pv8f20mnlat55ip23uddpjldsg.apps.googleusercontent.com');
        $this->client->setClientSecret('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');
        $this->client->setRedirectUri(base_url('Auth/callback'));
        $this->client->addScope('email');
        $this->client->addScope('profile');
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

        if ($username != '' && $password != '') {
            $user = $this->authModel->getUser($username, $password);
            if (!is_null($user)) {
                if ($user->is_deleted == 0) {
                    $menu = $this->authModel->getMenu($user->user_web_role_id);
                    $sessionData = array(
                        'logged_in_transhubdat' => true,
                        'id'                    => $user->id,
                        'role'                  => $user->user_web_role_id,
                        'role_name'             => $user->user_web_role_name,
                        'username'              => $user->user_web_username,
                        'name'                  => $user->user_web_name,
                        'email'                 => $user->user_web_email,
                        'instansi_detail_id'    => $user->bptd_id,
                        'instansi_detail_name'  => $user->instansi_detail_name,
                        'menu'                  => $menu
                    );
                    $session->set($sessionData);
                    $this->baseModel->log_action("login", "Akses Diberikan");
                    $response = ["success" => TRUE, "title"   => "Success", "text"    => "Berhasil"];
                } else {
                    $this->baseModel->log_action("login", "Akses Ditolak");
                    $response = ["success" => false, "title"   => "Error", "text"    => "Pengguna Sudah Tidak Aktif"];
                }
            } else {
                $this->baseModel->log_action("login", "Akses Ditolak");
                $response = ["success" => false, "title"   => "Error", "text"    => "Username & Password Salah"];
            }
        } else {
            $this->baseModel->log_action("login", "Akses Ditolak");
            $response = ["success" => false, "title" => "Error", "text" => "Username & Password Salah"];
        }
        echo json_encode($response);
    }

    function logout()
    {
        $session = \Config\Services::session();
        $session->destroy();
        return redirect()->to(base_url());
    }

    public function loginGoogle()
    {
        $session = \Config\Services::session();
        $email = $this->request->getPost('email');
        $user = $this->authModel->getUserByEmail($email);
        if (!is_null($user)) {
            if ($user->is_deleted == 0) {
                $menu = $this->authModel->getMenu($user->user_web_role_id);
                $sessionData = array(
                    'logged_in_transhubdat' => true,
                    'id' => $user->id,
                    'role' => $user->user_web_role_id,
                    'role_name' => $user->user_web_role_name,
                    'username' => $user->user_web_username,
                    'name' => $user->user_web_name,
                    'email' => $user->user_web_email,
                    'instansi_detail_id' => $user->bptd_id,
                    'instansi_detail_name' => $user->instansi_detail_name,
                    'menu' => $menu
                );
                $session->set($sessionData);
                $this->baseModel->log_action("login", "Akses Diberikan");
                $response = ["success" => TRUE, "title" => "Success", "text" => "Berhasil"];
            } else {
                $this->baseModel->log_action("login", "Akses Ditolak");
                $response = ["success" => false, "title" => "Error", "text" => "Pengguna Sudah Tidak Aktif"];
            }
        } else {
            $this->baseModel->log_action("login", "Akses Ditolak");
            $response = ["success" => false, "title" => "Error", "text" => "User tidak terdaftar"];
        }
        echo json_encode($response);
    }

    // public function callback()
    // {
    //     $client = new Client();

    //     $client->fetchAccessTokenWithAuthCode($this->request->getGet('code'));

    //     $oauth2 = new \Google_Service_Oauth2($client);
    //     $userInfo = $oauth2->userinfo->get();
    // }

    // public function process()
    // {
    //     $response = ['success' => true,'message' => 'Password changed successfully.'];
    //     return $this->response->setJSON($response);
    // }

    function checkpassword()
    {
        $userData = $_SESSION;
        $q = $this->db->query('select id from m_user_web where id = "' . $userData['id'] . '" and user_web_password = md5("' . $_POST['pass'] . '") ');
        if ($q->getNumRows() == 0) {
            echo json_encode(array('available' => false));
        } else {
            echo json_encode(array('available' => true));
        }
    }

    public function changePassword()
    {
        $session = \Config\Services::session();
        $userData = $_SESSION;
        $currentPassword = $this->request->getPost('current-password');
        $newPassword = $this->request->getPost('new-password');
        $confirmPassword = $this->request->getPost('confirm-password');
        $user = $this->authModel->getUser($userData['username'], $currentPassword);
        if (!is_null($user)) {
            if ($newPassword == $confirmPassword) {
                $result = $this->authModel->changePassword($newPassword, $userData['id']);
                if ($result) {
                    $response = ["success" => true,"title" => "Success","text" => "Password Berhasil Diubah"];
                    $session->destroy();
                } else {
                    $response = ["success" => false,"title" => "Error","text" => "Password Gagal Diubah"];
                }
            } else {
                $response = ["success" => false,"title" => "Peringatan","text" => "Konfirmasi Password Tidak Sama"];
            }
        } else {
            $response = ["success" => false,"title" => "Peringatan","text" => "Password Saat Ini Salah"];
        }
        echo json_encode($response);
    }
}
