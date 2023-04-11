<?php

namespace App\Modules\NGImenu\Controllers;

use App\Modules\NGImenu\Models\NGImenuModel;
use App\Core\BaseController;

class NGImenu extends BaseController
{
    private $NGImenuModel;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->NGImenuModel = new NGImenuModel();
    }

    public function index()
    {
        return redirect()->to(base_url());
    }

    public function test()
    {
        $data['load_view'] = "App\Modules\NGImenu\Views\\test";
        return view('App\Modules\Main\Views\layout', $data);
    }

    public function softwarelicense()
    {
        return parent::_authView();
    }

    public function manalat()
    {
        return parent::_authView();
    }

    public function koreksi_topup()
    {
        return parent::_authView();
    }

    public function reset_pass_petugas()
    {
        return parent::_authView();
    }

    public function app_update()
    {
        return parent::_authView();
    }

    public function laporantrouble()
    {
        return parent::_authView();
    }
}
