<?php

namespace App\Modules\Posko\Controllers;

use App\Modules\Posko\Models\PoskoModel;
use App\Core\BaseController;

class Posko extends BaseController
{
    private $poskoModel;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->poskoModel = new PoskoModel();
    }

    public function index()
    {
        return redirect()->to(base_url());
    }

    // manajemen lokasi posko
    public function lokasiposko()
    {
        return parent::_authView();
    }

    // manajemen jadwal posko
    public function jadwalposko()
    {
        return parent::_authView();
    }
}
