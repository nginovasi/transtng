<?php

namespace App\Modules\Settlement\Controllers;

use App\Modules\Settlement\Models\SettlementModel;
use App\Core\BaseController;

class Settlement extends BaseController {
    private $settlementModel;

    public function __construct() {
        $this->settlementModel = new SettlementModel();
    }

    public function importsettlement() {
        return parent::_authView();
    }

    public function index() {
        return redirect()->to(base_url());
    }

    public function ceksettlement() {
        return parent::_authView();
    }

    public function comparesettlement() {
        return parent::_authView();
    }

    public function laprekon() {
        return parent::_authView();
    }

    public function laporanpendapatan() {
        return parent::_authView();
    }

    public function laprimportsettlement() {
        return parent::_authView();
    }

    public function importrsf() {
        return parent::_authView();
    }

}