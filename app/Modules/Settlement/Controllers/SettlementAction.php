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

    public function pdf() {
        $url = uri_segment("3");
        $url_export = $url . "_export";
        $filter = $_GET['search'];
        $data['data_url'] = uri_segment("2");
        $data['data_excel'] = $this->settlementModel->export_view($url_export, $filter);

        $html = view("Settlement/Views/$url", $data);
        $mpdf = new \Mpdf\Mpdf();
        if (isset($_GET['o'])) {
            if ($_GET['o'] == 'l') {
                $mpdf->AddPage('L');
            }
        }

        $mpdf->WriteHTML($html);
        $this->response->setHeader('Content-Type', 'application/pdf');
        $mpdf->Output($url.'_'.date('YmdHis').'.pdf', 'I');
    }

    public function excel() {
        $url = uri_segment("3");
        header("Content-type: application/vnd-ms-excel; charset=utf-8;");
        header("Content-Disposition: attachment; filename=".$url."_".date('YmdHis').".xls");
        header("Pragma: no-cache; Expires: 0");
        header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
        header("Cache-Control: private", false);

        $url_export = $url . "_export";
        $filter = $_GET['search'];
        $data['data_url'] = uri_segment("2");
        $data['data_excel'] = $this->settlementModel->export_view($url_export, $filter);

        echo view("Settlement/Views/$url", $data);
    }

    public function importsettlement_load__BCAPaid() {

    }

    public function importsettlement_save_BCAPaid()
    {
        parent::_authInsert(function () {
            // $number_menu = count($this->request->getPost('idmenu'));
            // $deleted = explode(",", $this->request->getPost('delete'));

            // $previlagesData = [];
            // for ($i = 0; $i < $number_menu; $i++) {
            //     $previlagesData[] = [
            //         "id" => $this->request->getPost('id')[$i],
            //         "menu_id" => $this->request->getPost('idmenu')[$i],
            //         "v" => unwrap_null(@$this->request->getPost('v')[$i], "0"),
            //         "i" => unwrap_null(@$this->request->getPost('i')[$i], "0"),
            //         "d" => unwrap_null(@$this->request->getPost('d')[$i], "0"),
            //         "e" => unwrap_null(@$this->request->getPost('e')[$i], "0"),
            //         "o" => unwrap_null(@$this->request->getPost('o')[$i], "0"),
            //         "user_web_role_id" => $this->request->getPost('iduser'),
            //         "created_by" => $this->session->get('id'),
            //         "created_at" => date("Y-m-d H:i:s"),
            //     ];
            // }

            $data = $this->request->getPost();

            $dataDecode = json_decode($data['data']);

            if ($this->settlementModel->insertBatchSttlBCA('sttl_bca_paid', $dataDecode)) {
                echo json_encode(array('success' => true, 'message' => 'Berhasil simpan rekening koran'));
            } else {
                echo json_encode(array('success' => false, 'message' => $this->settlementModel->db->error()));
            }
        });
    }

    public function importsettlement_save_BNIPaid()
    {
        parent::_authInsert(function () {
            // parent::_insert('ref_narasi_tiket', $this->request->getPost());
        });
    }

    public function importsettlement_save_BRIPaid()
    {
        parent::_authInsert(function () {
            // parent::_insert('ref_narasi_tiket', $this->request->getPost());
        });
    }

    public function importsettlement_save_MandiriPaid()
    {
        parent::_authInsert(function () {
            // parent::_insert('ref_narasi_tiket', $this->request->getPost());
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