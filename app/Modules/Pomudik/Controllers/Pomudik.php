<?php

namespace App\Modules\Pomudik\Controllers;

use App\Modules\Pomudik\Models\PomudikModel;
use App\Core\BaseController;

class Pomudik extends BaseController
{
    private $pomudikModel;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->pomudikModel = new PomudikModel();
    }

    public function index()
    {
        return redirect()->to(base_url());
    }

    public function test()
    {
        return view('App\Modules\Pomudik\Views\test');
    }

    // feature manajemen armada mudik
    public function manarmadamudik()
    {
        $data['facilities'] = $this->pomudikModel->getFacilities();

        return parent::_authView($data);
    }

    // feature manajemen jadwal mudik
    public function manjadwalmudik()
    {
        return parent::_authView();
    }

    // feature manajemen paguyuban
    public function manpaguyuban()
    {
        return parent::_authView();
    }

    public function manpindahbus()
    {
        return parent::_authView();
    }

    public function manpaguyubanmudik()
    {
        return parent::_authView();
    }

    public function verifikasimudik()
    {
        return parent::_authView();
    }

    public function manarmadamotis()
    {
        return parent::_authView();
    }

    public function manjadwalmotis()
    {
        return parent::_authView();
    }

    public function verifikasipesertamudik()
    {
        return parent::_authView();
    }

    public function verifikasikendaraanmudik()
    {
        return parent::_authView();
    }
    public function verifikasikedatangankendaraanmudik()
    {
        return parent::_authView();
    }
    public function verifikasipengambilankendaraanmudik()
    {
        return parent::_authView();
    }

    // feature manajemen paguyuban motis
    public function manpaguyubanmotis()
    {
        return parent::_authView();
    }

    // feature list data pemudik after verif(not fix)
    public function listdataarmadabis()
    {
        return parent::_authView();
    }

    // lap manivest penumpang
    public function lapmanivestpenumpang()
    {
        return parent::_authView();
    }

    public function layananaduan()
    {
        return parent::_authView();
    }
}
