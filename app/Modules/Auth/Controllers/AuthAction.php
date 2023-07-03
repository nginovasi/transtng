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
            $encSHA512 = parent::sha512($password, getenv('app.salt'));
            $password = base64_encode($encSHA512);
            $user = $this->authModel->getUser($username, $password);
            if (!is_null($user)) {
                if ($user->is_deleted == 0) {
                    $menu = $this->authModel->getMenu($user->user_web_role_id);
                    $sessionData = array(
                        'logged_in_transtng'    => true,
                        'id'                    => $user->id,
                        'role'                  => $user->user_web_role_id,
                        'role_name'             => $user->user_web_role_name,
                        'username'              => $user->user_web_username,
                        'name'                  => $user->user_web_name,
                        'email'                 => $user->user_web_email,
                        'menu'                  => $menu
                    );
                    // var_dump($sessionData);
                    $session->set($sessionData);
                    $this->baseModel->log_action("login", "Akses Diberikan");

                    $loginAt = date("Y-m-d H:i:s");

                    $this->authModel->setlastLoginAt($loginAt, $user->id);

                    $encrypter = $this->baseModel->initEncrypter();

                    $qrLoginData = [
                        "status"   => "login",
                        "id"       => $user->id,
                        "username" => $user->user_web_username,
                        "email"    => $user->user_web_email,
                        "login_at" => $loginAt
                    ];
                    $qrLogin = bin2hex($encrypter->encrypt(json_encode($qrLoginData)));

                    $qrLogoutData = [
                        "status"   => "logout",
                        "id"       => $user->id,
                        "username" => $user->user_web_username,
                        "email"    => $user->user_web_email,
                        "login_at" => $loginAt
                    ];
                    $qrLogout = bin2hex($encrypter->encrypt(json_encode($qrLogoutData)));

                    // sample decrypt
                    // $encrypter->decrypt(hex2bin(bin2hex($encrypter->encrypt(json_encode($qrLoginData)))));
                    // $encrypter->decrypt(hex2bin(bin2hex($encrypter->encrypt(json_encode($qrLogoutData)))));
                    
                    $this->authModel->setQrLoginLogout($qrLogin, $qrLogout, $user->id);

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
                    'logged_in_transtng'    => true,
                    'id'                    => $user->id,
                    'role'                  => $user->user_web_role_id,
                    'role_name'             => $user->user_web_role_name,
                    'username'              => $user->user_web_username,
                    'name'                  => $user->user_web_name,
                    'email'                 => $user->user_web_email,
                    'menu'                  => $menu
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

    function checkpassword()
    {
        $userData = $_SESSION;
        $encSHA512 = parent::sha512($this->request->getPost('password'), getenv('app.salt'));
        $password = base64_encode($encSHA512);
        $q = $this->db->query("SELECT * FROM m_user_web WHERE id = ? AND user_web_password = ?", array($userData['id'], $password));
        if ($q->getNumRows() == 0) {
            echo json_encode(array('success' => FALSE));
        } else {
            echo json_encode(array('success' => TRUE));
        }
    }

    public function changePassword()
    {
        $session = \Config\Services::session();
        $userData = $_SESSION;

        $currentPassword = $this->request->getPost('current-password');
        $newPassword = $this->request->getPost('new-password');
        $confirmPassword = $this->request->getPost('confirm-password');

        $encSHA512 = parent::sha512($newPassword, getenv('app.salt'));
        $password = base64_encode($encSHA512);

        $user = $this->authModel->getUser($userData['username'], $currentPassword);
        if (!is_null($user)) {
            if ($newPassword == $confirmPassword) {
                $result = $this->authModel->changePassword($password, $userData['id']);
                if ($result) {
                    $response = ["success" => true, "title" => "Success", "text" => "Password Berhasil Diubah"];
                    $session->destroy();
                } else {
                    $response = ["success" => false, "title" => "Error", "text" => "Password Gagal Diubah"];
                }
            } else {
                $response = ["success" => false, "title" => "Peringatan", "text" => "Konfirmasi Password Tidak Sama"];
            }
        } else {
            $response = ["success" => false, "title" => "Peringatan", "text" => "Password Saat Ini Salah"];
        }
        echo json_encode($response);
    }
}
