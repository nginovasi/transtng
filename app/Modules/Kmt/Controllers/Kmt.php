<?php

namespace App\Modules\Kmt\Controllers;

use App\Modules\Kmt\Models\KmtModel;
use App\Core\BaseController;

class Kmt extends BaseController {
    private $kmtModel;

    public function __construct() {
        $this->kmtModel = new KmtModel();
    }

    public function index() {
        return redirect()->to(base_url());
    }

    public function lapkmt() {
        return parent::_authView();
    }

}