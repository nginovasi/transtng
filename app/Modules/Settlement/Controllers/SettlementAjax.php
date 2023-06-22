<?php

namespace App\Modules\Settlement\Controllers;

use App\Modules\Settlement\Models\SettlementModel;
use App\Core\BaseController;

class SettlementAjax extends BaseController {
    private $settlementModel;

    public function __construct() {
        $this->settlementModel = new SettlementModel();
    }

    public function index() {
        return redirect()->to(base_url());
    }

    public function bank_id_select_get()
    {
        $data = $this->request->getGet();
        
        $query = "SELECT id, name as text
                    FROM ref_bank
                    WHERE is_deleted = 0
                    AND is_active = 0
                    AND is_dev = 0";
        
        $where = ["name"];

        parent::_loadSelect2($data, $query, $where);
    }

}