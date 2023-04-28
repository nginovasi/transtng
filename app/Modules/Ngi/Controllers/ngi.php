<?php

namespace App\Modules\Ngi\Controllers;

use App\Modules\Ngi\Models\NgiModel;
use App\Core\BaseController;

class Ngi extends BaseController
{
    private $NgiModel;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->NgiModel = new NgiModel();
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

    public function dataalat()
    {
        return parent::_authView();
    }

    public function koreksitopup()
    {
        return parent::_authView();
    }

    public function resetpasswordpetugas()
    {
        return parent::_authView();
    }

    public function appupdate()
    {
        return parent::_authView();
    }

    public function laporantrouble()
    {
        return parent::_authView();
    }

    public function laprekoninternal()
    {
        return parent::_authView();
    }
}
