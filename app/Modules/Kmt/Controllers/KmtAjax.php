<?php

namespace App\Modules\Kmt\Controllers;

use App\Modules\Kmt\Models\KmtModel;
use App\Core\BaseController;

class KmtAjax extends BaseController {
    private $kmtModel;

    public function __construct() {
        $this->kmtModel = new KmtModel();
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


}