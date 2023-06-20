<?php

namespace App\Modules\Eksekutif\Controllers;

use App\Modules\Eksekutif\Models\EksekutifModel;
use App\Core\BaseController;

class EksekutifAction extends BaseController {
    private $eksekutifModel;

    public function __construct() {
        $this->eksekutifModel = new EksekutifModel();
    }

    public function index() {
        return redirect()->to(base_url());
    }

    public function pdf() {
        $url = uri_segment("3");
        $url_export = $url . "_export";
        $filter = $_GET['search'];
        $data['data_url'] = uri_segment("2");
        $data['data_excel'] = $this->eksekutifModel->export_view($url_export, $filter);

        $html = view("Eksekutif/Views/$url", $data);
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
        $data['data_excel'] = $this->eksekutifModel->export_view($url_export, $filter);

        echo view("Eksekutif/Views/$url", $data);
    }

    public function cekmutasikartu_load()
    {
        parent::_authLoad(function () {
            $query = "SELECT a.* FROM ref_narasi_tiket a";
            $where = ["a.header", "a.footer"];

            parent::_loadDatatable($query, $where, $this->request->getPost());
        });
    }

    public function cekmutasikartu_save()
    {
        parent::_authInsert(function () {
            // parent::_insert('ref_narasi_tiket', $this->request->getPost());
        });
    }

    public function cekmutasikartu_edit()
    {
        parent::_authEdit(function () {
            // parent::_edit('ref_narasi_tiket', $this->request->getPost());
        });
    }

    public function cekmutasikartu_delete()
    {
        parent::_authDelete(function () {
            // parent::_delete('ref_narasi_tiket', $this->request->getPost());
        });
    }

    public function grafikbulanan_load()
    {
        parent::_authLoad(function () {
            $query = "SELECT a.* FROM ref_narasi_tiket a";
            $where = ["a.header", "a.footer"];

            parent::_loadDatatable($query, $where, $this->request->getPost());
        });
    }

    public function grafikbulanan_save()
    {
        parent::_authInsert(function () {
            // parent::_insert('ref_narasi_tiket', $this->request->getPost());
        });
    }

    public function grafikbulanan_edit()
    {
        parent::_authEdit(function () {
            // parent::_edit('ref_narasi_tiket', $this->request->getPost());
        });
    }

    public function grafikbulanan_delete()
    {
        parent::_authDelete(function () {
            // parent::_delete('ref_narasi_tiket', $this->request->getPost());
        });
    }

    public function lapdatakartubaru_load()
    {
        parent::_authLoad(function () {
            $query = "SELECT a.* FROM ref_narasi_tiket a";
            $where = ["a.header", "a.footer"];

            parent::_loadDatatable($query, $where, $this->request->getPost());
        });
    }

    public function lapdatakartubaru_save()
    {
        parent::_authInsert(function () {
            // parent::_insert('ref_narasi_tiket', $this->request->getPost());
        });
    }

    public function lapdatakartubaru_edit()
    {
        parent::_authEdit(function () {
            // parent::_edit('ref_narasi_tiket', $this->request->getPost());
        });
    }

    public function lapdatakartubaru_delete()
    {
        parent::_authDelete(function () {
            // parent::_delete('ref_narasi_tiket', $this->request->getPost());
        });
    }

    public function lappesantiket_load()
    {
        parent::_authLoad(function () {
            $query = "SELECT a.* FROM ref_narasi_tiket a";
            $where = ["a.header", "a.footer"];

            parent::_loadDatatable($query, $where, $this->request->getPost());
        });
    }

    public function lappesantiket_save()
    {
        parent::_authInsert(function () {
            // parent::_insert('ref_narasi_tiket', $this->request->getPost());
        });
    }

    public function lappesantiket_edit()
    {
        parent::_authEdit(function () {
            // parent::_edit('ref_narasi_tiket', $this->request->getPost());
        });
    }

    public function lappesantiket_delete()
    {
        parent::_authDelete(function () {
            // parent::_delete('ref_narasi_tiket', $this->request->getPost());
        });
    }

    public function laptopup_load()
    {
        parent::_authLoad(function () {
            $query = "SELECT a.* FROM ref_narasi_tiket a";
            $where = ["a.header", "a.footer"];

            parent::_loadDatatable($query, $where, $this->request->getPost());
        });
    }

    public function laptopup_save()
    {
        parent::_authInsert(function () {
            // parent::_insert('ref_narasi_tiket', $this->request->getPost());
        });
    }

    public function laptopup_edit()
    {
        parent::_authEdit(function () {
            // parent::_edit('ref_narasi_tiket', $this->request->getPost());
        });
    }

    public function laptopup_delete()
    {
        parent::_authDelete(function () {
            // parent::_delete('ref_narasi_tiket', $this->request->getPost());
        });
    }

    public function logalataktif_load()
    {
        parent::_authLoad(function () {
            $query = "SELECT a.* FROM ref_narasi_tiket a";
            $where = ["a.header", "a.footer"];

            parent::_loadDatatable($query, $where, $this->request->getPost());
        });
    }

    public function logalataktif_save()
    {
        parent::_authInsert(function () {
            // parent::_insert('ref_narasi_tiket', $this->request->getPost());
        });
    }

    public function logalataktif_edit()
    {
        parent::_authEdit(function () {
            // parent::_edit('ref_narasi_tiket', $this->request->getPost());
        });
    }

    public function logalataktif_delete()
    {
        parent::_authDelete(function () {
            // parent::_delete('ref_narasi_tiket', $this->request->getPost());
        });
    }

    public function pembaruankartu_load()
    {
        parent::_authLoad(function () {
            $query = "SELECT a.* FROM ref_narasi_tiket a";
            $where = ["a.header", "a.footer"];

            parent::_loadDatatable($query, $where, $this->request->getPost());
        });
    }

    public function pembaruankartu_save()
    {
        parent::_authInsert(function () {
            // parent::_insert('ref_narasi_tiket', $this->request->getPost());
        });
    }

    public function pembaruankartu_edit()
    {
        parent::_authEdit(function () {
            // parent::_edit('ref_narasi_tiket', $this->request->getPost());
        });
    }

    public function pembaruankartu_delete()
    {
        parent::_authDelete(function () {
            // parent::_delete('ref_narasi_tiket', $this->request->getPost());
        });
    }

    public function sirkulasipenumpang_load()
    {
        parent::_authLoad(function () {
            $query = "SELECT a.* FROM ref_narasi_tiket a";
            $where = ["a.header", "a.footer"];

            parent::_loadDatatable($query, $where, $this->request->getPost());
        });
    }

    public function sirkulasipenumpang_save()
    {
        parent::_authInsert(function () {
            // parent::_insert('ref_narasi_tiket', $this->request->getPost());
        });
    }

    public function sirkulasipenumpang_edit()
    {
        parent::_authEdit(function () {
            // parent::_edit('ref_narasi_tiket', $this->request->getPost());
        });
    }

    public function sirkulasipenumpang_delete()
    {
        parent::_authDelete(function () {
            // parent::_delete('ref_narasi_tiket', $this->request->getPost());
        });
    }

    public function sirkulasipenumpangportabel_load()
    {
        parent::_authLoad(function () {
            $query = "SELECT a.* FROM ref_narasi_tiket a";
            $where = ["a.header", "a.footer"];

            parent::_loadDatatable($query, $where, $this->request->getPost());
        });
    }

    public function sirkulasipenumpangportabel_save()
    {
        parent::_authInsert(function () {
            // parent::_insert('ref_narasi_tiket', $this->request->getPost());
        });
    }

    public function sirkulasipenumpangportabel_edit()
    {
        parent::_authEdit(function () {
            // parent::_edit('ref_narasi_tiket', $this->request->getPost());
        });
    }

    public function sirkulasipenumpangportabel_delete()
    {
        parent::_authDelete(function () {
            // parent::_delete('ref_narasi_tiket', $this->request->getPost());
        });
    }

}