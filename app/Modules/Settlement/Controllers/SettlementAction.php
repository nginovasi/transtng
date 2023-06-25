<?php

namespace App\Modules\Settlement\Controllers;

use App\Modules\Settlement\Models\SettlementModel;
use App\Core\BaseController;

class SettlementAction extends BaseController {
    private $settlementModel;

    public function __construct() {
        $this->settlementModel = new SettlementModel();
    }

    public function index() {
        return redirect()->to(base_url());
    }

    public function importsettlement_load()
    {
        parent::_authLoad(function () {
            $query = "SELECT a.*, b.user_web_username
                        FROM log_import_sttl a
                        LEFT JOIN m_user_web b
                            ON a.created_by = b.id
                        WHERE filename IS NOT NULL";

            $where = ["a.filename", "a.bank", "b.user_web_username"];

            parent::_loadDatatable($query, $where, $this->request->getPost());
        });
    }

    public function importsettlement_load_BCAPaid() {
        $data = $this->request->getPost();

        $dataDecode = json_decode($data['data']);

        $user_id = $this->session->get('id');

        $this->settlementModel->loadBatchSttlBCA($dataDecode, $user_id);
    }

    public function importsettlement_save_BCAPaid()
    {
        parent::_authInsert(function () {
            $data = $this->request->getPost();

            $dataDecode = json_decode($data['data']);

            $user_id = $this->session->get('id');

            $this->settlementModel->insertLogSttl("BCA", $data['name_file'], $dataDecode, $user_id);

            if($dataDecode) {
                parent::_insertBatchv2('sttl_bca_paid', $dataDecode);
            } else {
                echo json_encode(array("success" => false, "message" => "Data tidak ada", "data" => null));
            }            
        });
    }

    public function importsettlement_load_BNIPaid() {
        $data = $this->request->getPost();

        $dataDecode = json_decode($data['data']);

        $user_id = $this->session->get('id');

        $this->settlementModel->loadBatchSttlBNI($dataDecode, $user_id);
    }

    public function importsettlement_save_BNIPaid()
    {
        parent::_authInsert(function () {
            $data = $this->request->getPost();

            $dataDecode = json_decode($data['data']);

            $user_id = $this->session->get('id');

            $this->settlementModel->insertLogSttl("BNI", $data['name_file'], $dataDecode, $user_id);

            if($dataDecode) {
                parent::_insertBatchv2('sttl_bni_paid', $dataDecode);
            } else {
                echo json_encode(array("success" => false, "message" => "Data tidak ada", "data" => null));
            }            
        });
    }

    public function importsettlement_load_BRIPaid() {
        $data = $this->request->getPost();

        $dataDecode = json_decode($data['data']);

        $user_id = $this->session->get('id');

        $result = $this->settlementModel->loadBatchSttlBRI($dataDecode, $user_id);
    }

    public function importsettlement_save_BRIPaid()
    {
        parent::_authInsert(function () {
            $data = $this->request->getPost();

            $dataDecode = json_decode($data['data']);

            $user_id = $this->session->get('id');

            $this->settlementModel->insertLogSttl("BRI", $data['name_file'], $dataDecode, $user_id);

            if($dataDecode) {
                parent::_insertBatchv2('sttl_bri_paid', $dataDecode);
            } else {
                echo json_encode(array("success" => false, "message" => "Data tidak ada", "data" => null));
            }            
        });
    }

    public function importsettlement_load_MandiriPaid() {
        $data = $this->request->getPost();

        $dataDecode = json_decode($data['data']);

        $user_id = $this->session->get('id');

        $result = $this->settlementModel->loadBatchSttlMandiri($dataDecode, $user_id);

        echo json_encode(array("success" => true, "message" => "Get data success", "data" => $result));
    }

    public function importsettlement_save_MandiriPaid()
    {
        parent::_authInsert(function () {
            $data = $this->request->getPost();

            $dataDecode = json_decode($data['data']);

            $user_id = $this->session->get('id');

            $this->settlementModel->insertLogSttl("Mandiri", $data['name_file'], $dataDecode, $user_id);

            if($dataDecode) {
                parent::_insertBatchv2('sttl_mandiri_paid', $dataDecode);
            } else {
                echo json_encode(array("success" => false, "message" => "Data tidak ada", "data" => null));
            }            
        });
    }

    public function laprekon_load_BCALapRekon() {
        $data = $this->request->getPost();

        $result = $this->settlementModel->loadLapRekonBCA($data['date']);

        echo json_encode(array("success" => true, "message" => "Get data success", "data" => $result));
    }

    public function laprekon_load_BRILapRekon() {
        $data = $this->request->getPost();

        $result = $this->settlementModel->loadLapRekonBRI($data['date']);

        echo json_encode(array("success" => true, "message" => "Get data success", "data" => $result));
    }

    public function laprekon_load_BNILapRekon() {
        $data = $this->request->getPost();

        $result = $this->settlementModel->loadLapRekonBNI($data['date']);

        echo json_encode(array("success" => true, "message" => "Get data success", "data" => $result));
    }

    public function laprekon_load_MandiriLapRekon() {
        $data = $this->request->getPost();

        $result = $this->settlementModel->loadLapRekonMandiri($data['date']);

        echo json_encode(array("success" => true, "message" => "Get data success", "data" => $result));
    }

}