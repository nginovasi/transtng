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

    public function findkartu() {
        $data = $this->request->getGet();
        $query = "SELECT a.id, a.nama as 'text' FROM ref_tenant a WHERE a.nama IS NOT NULL"; //QUERY belum fix
        $where = ["a.nama"];
        parent::_loadSelect2($data, $query, $where);
    }

    public function loadtransaksipta() {
        $tanggal = $this->request->getPost('tanggal');
        $result = $this->db->query("SELECT * FROM ref_narasi_tiket WHERE tanggal = '$tanggal'")->getResultArray();
        $data = [];
        foreach ($result as $key => $value) {
            $data[] = [
                'id' => $value['id'],
                'tanggal' => $value['tanggal'],
                'header' => $value['header'],
                'footer' => $value['footer'],
            ];
        }
        echo json_encode($data);
    }

    public function findpetugas() {
        $data = $this->request->getGet();
        $query = "SELECT a.id, a.nama as 'text' FROM ref_tenant a WHERE a.nama IS NOT NULL"; //QUERY belum fix
        $where = ["a.nama"];
        parent::_loadSelect2($data, $query, $where);
    }

    public function ceksettlement() {
        $data = $this->request->getGet();
        $query = "SELECT a.id, a.nama as 'text' FROM ref_tenant a WHERE a.nama IS NOT NULL"; //QUERY belum fix
        $where = ["a.nama"];
        parent::_loadSelect2($data, $query, $where);
    }

    public function rekapsettlement() {
        $data = $this->request->getGet();
        $query = "SELECT a.id, a.nama as 'text' FROM ref_tenant a WHERE a.nama IS NOT NULL"; //QUERY belum fix
        $where = ["a.nama"];
        parent::_loadSelect2($data, $query, $where);
    }

    public function comparesettlement() {
        $data = $this->request->getGet();
        $query = "SELECT a.id, a.nama as 'text' FROM ref_tenant a WHERE a.nama IS NOT NULL"; //QUERY belum fix
        $where = ["a.nama"];
        parent::_loadSelect2($data, $query, $where);
    }

    public function laprekon() {
        $data = $this->request->getGet();
        $query = "SELECT a.id, a.nama as 'text' FROM ref_tenant a WHERE a.nama IS NOT NULL"; //QUERY belum fix
        $where = ["a.nama"];
        parent::_loadSelect2($data, $query, $where);
    }

    public function rekaprekon() {
        $data = $this->request->getGet();
        $query = "SELECT a.id, a.nama as 'text' FROM ref_tenant a WHERE a.nama IS NOT NULL"; //QUERY belum fix
        $where = ["a.nama"];
        parent::_loadSelect2($data, $query, $where);
    }

    public function importsettlement() {
        $data = $this->request->getGet();
        $query = "SELECT a.id, a.nama as 'text' FROM ref_tenant a WHERE a.nama IS NOT NULL"; //QUERY belum fix
        $where = ["a.nama"];
        parent::_loadSelect2($data, $query, $where);
    }

    public function importrsf() {
        $data = $this->request->getGet();
        $query = "SELECT a.id, a.nama as 'text' FROM ref_tenant a WHERE a.nama IS NOT NULL"; //QUERY belum fix
        $where = ["a.nama"];
        parent::_loadSelect2($data, $query, $where);
    }


}