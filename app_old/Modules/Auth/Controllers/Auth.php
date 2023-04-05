<?php namespace App\Modules\Auth\Controllers;

use App\Modules\Auth\Models\AuthModel;
use App\Core\BaseController;

class Auth extends BaseController
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

        if(!$session->get('logged_in')){
            return view('App\Modules\Auth\Views\login');
        }else{
            return redirect()->to(base_url());
        }
    }

    public function test()
    {
        return view('App\Modules\Auth\Views\test'); 
    }

}
