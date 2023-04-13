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

    public function importsettlement_load()
    {
        parent::_authLoad(function () {
            $query = "SELECT a.* FROM ref_narasi_tiket a";
            $where = ["a.header", "a.footer"];

            parent::_loadDatatable($query, $where, $this->request->getPost());
        });
    }

    public function importsettlement_save()
    {
        parent::_authInsert(function () {
            // parent::_insert('ref_narasi_tiket', $this->request->getPost());
        });
    }

    public function importsettlement_edit()
    {
        parent::_authEdit(function () {
            // parent::_edit('ref_narasi_tiket', $this->request->getPost());
        });
    }

    public function importsettlement_delete()
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