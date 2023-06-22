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

        $result = $this->settlementModel->loadBatchSttlBCA($dataDecode, $user_id);

        echo json_encode(array("success" => true, "message" => "Get data success", "data" => $result));
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

        $result = $this->settlementModel->loadBatchSttlBNI($dataDecode, $user_id);

        echo json_encode(array("success" => true, "message" => "Get data success", "data" => $result));
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

        echo json_encode(array("success" => true, "message" => "Get data success", "data" => $result));
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

    // not use

    public function ceksettlement_load()
    {
        parent::_authLoad(function () {
            $query = "SELECT a.* FROM ref_narasi_tiket a";
            $where = ["a.header", "a.footer"];

            parent::_loadDatatable($query, $where, $this->request->getPost());
        });
    }

    public function ceksettlement_save()
    {
        parent::_authInsert(function () {
            // parent::_insert('ref_narasi_tiket', $this->request->getPost());
        });
    }

    public function ceksettlement_edit()
    {
        parent::_authEdit(function () {
            // parent::_edit('ref_narasi_tiket', $this->request->getPost());
        });
    }

    public function ceksettlement_delete()
    {
        parent::_authDelete(function () {
            // parent::_delete('ref_narasi_tiket', $this->request->getPost());
        });
    }

    public function comparesettlement_load()
    {
        parent::_authLoad(function () {
            $query = "SELECT a.* FROM ref_narasi_tiket a";
            $where = ["a.header", "a.footer"];

            parent::_loadDatatable($query, $where, $this->request->getPost());
        });
    }

    public function comparesettlement_save()
    {
        parent::_authInsert(function () {
            // parent::_insert('ref_narasi_tiket', $this->request->getPost());
        });
    }

    public function comparesettlement_edit()
    {
        parent::_authEdit(function () {
            // parent::_edit('ref_narasi_tiket', $this->request->getPost());
        });
    }

    public function comparesettlement_delete()
    {
        parent::_authDelete(function () {
            // parent::_delete('ref_narasi_tiket', $this->request->getPost());
        });
    }

    public function laprekon_load()
    {
        parent::_authLoad(function () {
            $query = "SELECT a.* FROM ref_narasi_tiket a";
            $where = ["a.header", "a.footer"];

            parent::_loadDatatable($query, $where, $this->request->getPost());
        });
    }

    public function laprekon_save()
    {
        parent::_authInsert(function () {
            // parent::_insert('ref_narasi_tiket', $this->request->getPost());
        });
    }

    public function laprekon_edit()
    {
        parent::_authEdit(function () {
            // parent::_edit('ref_narasi_tiket', $this->request->getPost());
        });
    }

    public function laprekon_delete()
    {
        parent::_authDelete(function () {
            // parent::_delete('ref_narasi_tiket', $this->request->getPost());
        });
    }

    public function laporanpendapatan_load()
    {
        parent::_authLoad(function () {
            $query = "SELECT a.* FROM ref_narasi_tiket a";
            $where = ["a.header", "a.footer"];

            parent::_loadDatatable($query, $where, $this->request->getPost());
        });
    }

    public function laporanpendapatan_save()
    {
        parent::_authInsert(function () {
            // parent::_insert('ref_narasi_tiket', $this->request->getPost());
        });
    }

    public function laporanpendapatan_edit()
    {
        parent::_authEdit(function () {
            // parent::_edit('ref_narasi_tiket', $this->request->getPost());
        });
    }

    public function laporanpendapatan_delete()
    {
        parent::_authDelete(function () {
            // parent::_delete('ref_narasi_tiket', $this->request->getPost());
        });
    }

    public function importrsf_load()
    {
        parent::_authLoad(function () {
            $query = "SELECT a.* FROM ref_narasi_tiket a";
            $where = ["a.header", "a.footer"];

            parent::_loadDatatable($query, $where, $this->request->getPost());
        });
    }

    public function importrsf_save()
    {
        parent::_authInsert(function () {
            // parent::_insert('ref_narasi_tiket', $this->request->getPost());
        });
    }

    public function importrsf_edit()
    {
        parent::_authEdit(function () {
            // parent::_edit('ref_narasi_tiket', $this->request->getPost());
        });
    }

    public function importrsf_delete()
    {
        parent::_authDelete(function () {
            // parent::_delete('ref_narasi_tiket', $this->request->getPost());
        });
    }

}