<?php

namespace App\Modules\Ngi\Controllers;

use App\Modules\Ngi\Models\ngiModel;
use App\Core\BaseController;

class Ngi extends BaseController
{
    private $ngiModel;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->ngiModel = new ngiModel();
    }

    public function index()
    {
        return redirect()->to(base_url());
    }

    public function test()
    {
        $data['load_view'] = "App\Modules\Ngi\Views\\test";
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
