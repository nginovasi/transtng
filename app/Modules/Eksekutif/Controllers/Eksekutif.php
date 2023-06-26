<?php

namespace App\Modules\Eksekutif\Controllers;

use App\Modules\Eksekutif\Models\EksekutifModel;
use App\Core\BaseController;

class Eksekutif extends BaseController {
    private $eksekutifModel;

    public function __construct() {
        $this->eksekutifModel = new EksekutifModel();
    }

    public function index() {
        return redirect()->to(base_url());
    }

    public function trx30haritransaksi() {
        return parent::_authView();
    }

    public function trxperiodikperjenis() {
        return parent::_authView();
    }

    public function cekpta() {
        return parent::_authView();
    }

    public function lapkoridor() {
        return parent::_authView();
    }

    public function lappenumpangjamkor() {
        return parent::_authView();
    }

    public function rekapposharian() {
        return parent::_authView();
    }

    public function logalataktif() {
        return parent::_authView();
    }

    public function grafiktransaksimesinkartu() {
        return parent::_authView();
    }

    public function grafikkoridor() {
        return parent::_authView();
    }

}