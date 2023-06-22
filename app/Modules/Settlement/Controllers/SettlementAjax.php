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

    function uploadCSVBCAPaid()
    {
        $data = $this->request->getPost();

        // $data1 = $this->request->getGet();

        // var_dump("done");
        // var_dump(base64_decode($data['excelfile']));
        // die;

        // var_dump("done1");
        // var_dump($data1);
        // die;

        $input = file_get_contents(base64_decode($data['excelfile']));
        var_dump($input);
        die;


    }

    // public function findkartu() {
    //     $data = $this->request->getGet();
    //     $query = "SELECT a.id, a.nama as 'text' FROM ref_tenant a WHERE a.nama IS NOT NULL"; //QUERY belum fix
    //     $where = ["a.nama"];
    //     parent::_loadSelect2($data, $query, $where);
    // }

    // public function loadtransaksipta() {
    //     $tanggal = $this->request->getPost('tanggal');
    //     $result = $this->db->query("SELECT * FROM ref_narasi_tiket WHERE tanggal = '$tanggal'")->getResultArray();
    //     $data = [];
    //     foreach ($result as $key => $value) {
    //         $data[] = [
    //             'id' => $value['id'],
    //             'tanggal' => $value['tanggal'],
    //             'header' => $value['header'],
    //             'footer' => $value['footer'],
    //         ];
    //     }
    //     echo json_encode($data);
    // }

    // public function findpetugas() {
    //     $data = $this->request->getGet();
    //     $query = "SELECT a.id, a.nama as 'text' FROM ref_tenant a WHERE a.nama IS NOT NULL"; //QUERY belum fix
    //     $where = ["a.nama"];
    //     parent::_loadSelect2($data, $query, $where);
    // }

    // public function ceksettlement() {
    //     $data = $this->request->getGet();
    //     $query = "SELECT a.id, a.nama as 'text' FROM ref_tenant a WHERE a.nama IS NOT NULL"; //QUERY belum fix
    //     $where = ["a.nama"];
    //     parent::_loadSelect2($data, $query, $where);
    // }

    // public function rekapsettlement() {
    //     $data = $this->request->getGet();
    //     $query = "SELECT a.id, a.nama as 'text' FROM ref_tenant a WHERE a.nama IS NOT NULL"; //QUERY belum fix
    //     $where = ["a.nama"];
    //     parent::_loadSelect2($data, $query, $where);
    // }

    // public function comparesettlement() {
    //     $data = $this->request->getGet();
    //     $query = "SELECT a.id, a.nama as 'text' FROM ref_tenant a WHERE a.nama IS NOT NULL"; //QUERY belum fix
    //     $where = ["a.nama"];
    //     parent::_loadSelect2($data, $query, $where);
    // }

    // public function laprekon() {
    //     $data = $this->request->getGet();
    //     $query = "SELECT a.id, a.nama as 'text' FROM ref_tenant a WHERE a.nama IS NOT NULL"; //QUERY belum fix
    //     $where = ["a.nama"];
    //     parent::_loadSelect2($data, $query, $where);
    // }

    // public function rekaprekon() {
    //     $data = $this->request->getGet();
    //     $query = "SELECT a.id, a.nama as 'text' FROM ref_tenant a WHERE a.nama IS NOT NULL"; //QUERY belum fix
    //     $where = ["a.nama"];
    //     parent::_loadSelect2($data, $query, $where);
    // }

    // public function importsettlement() {
    //     $data = $this->request->getGet();
    //     $query = "SELECT a.id, a.nama as 'text' FROM ref_tenant a WHERE a.nama IS NOT NULL"; //QUERY belum fix
    //     $where = ["a.nama"];
    //     parent::_loadSelect2($data, $query, $where);
    // }

    // public function importrsf() {
    //     $data = $this->request->getGet();
    //     $query = "SELECT a.id, a.nama as 'text' FROM ref_tenant a WHERE a.nama IS NOT NULL"; //QUERY belum fix
    //     $where = ["a.nama"];
    //     parent::_loadSelect2($data, $query, $where);
    // }

}