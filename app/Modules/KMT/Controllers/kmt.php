<?php

namespace App\Modules\kmt\Controllers;

use App\Modules\kmt\Models\kmtModel;
use App\Core\BaseController;

class kmt extends BaseController {
    private $kmtModel;

    public function __construct() {
        $this->kmtModel = new kmtModel();
    }

    public function index() {
        return redirect()->to(base_url());
    }

    public function lapkmt() {
        return parent::_authView();
    }

}