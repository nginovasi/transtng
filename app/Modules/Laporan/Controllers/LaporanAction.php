<?php

namespace App\Modules\Laporan\Controllers;

use App\Core\BaseController;
use App\Modules\Laporan\Models\LaporanModel;

class LaporanAction extends BaseController
{
    private $laporanModel;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->laporanModel = new LaporanModel();
        date_default_timezone_set('Asia/Jakarta');
    }

    public function index()
    {
        return redirect()->to(base_url());
    }

    public function laporan_load()
    {
        parent::_authLoad(function () {
        });
    }

    public function lapspda_save()
    {
        $data = $this->request->getPost();
        // $data != null
        // print_r('<pre>');
        // print_r($data);
        // print_r('</pre>');
        // die();
        if ($data['opsi'] != null) {
            if ($data['opsi'] == 1) {
                $query = "SELECT DISTINCT b.kategori_angkutan_name, d.armada_plat_number, d.armada_name, d.armada_kapasitas, c.route_name, a.tgl_spda, count(a.kd_bus_spda) AS jml_bus, a.ritase_spda, a.ttl_penumpang_spda,
                CONCAT(CEIL((a.ttl_penumpang_spda / d.armada_kapasitas) * 100), ' %') AS load_factor
                FROM t_form_spda a
                LEFT JOIN m_kategori_angkutan b ON b.id = a.kategori_angkutan_id
                LEFT JOIN m_route c ON c.id = a.trayek_id
                LEFT JOIN m_armada d ON d.id = a.kd_bus_spda
                WHERE a.tgl_spda = '" . $data['spda_date'] . "' AND a.kategori_angkutan_id = '" . $data['kategori_angkutan_id'] . "' AND a.trayek_id = '" . $data['trayek_id'] . "'
                GROUP BY b.kategori_angkutan_name, d.armada_plat_number, d.armada_name, d.armada_kapasitas, c.route_name, a.tgl_spda, a.ritase_spda, a.ttl_penumpang_spda, 'load factor'
                ORDER BY a.tgl_spda";
            } else {
                $query = "SELECT DISTINCT b.kategori_angkutan_name, '' as armada_plat_number, d.armada_name, d.armada_kapasitas, c.route_name, a.tgl_spda, count(a.kd_bus_spda) AS jml_bus, a.ritase_spda, a.ttl_penumpang_spda,
                CONCAT(CEIL((a.ttl_penumpang_spda / d.armada_kapasitas) * 100), ' %') AS load_factor
                FROM t_form_spda a
                LEFT JOIN m_kategori_angkutan b ON b.id = a.kategori_angkutan_id
                LEFT JOIN m_route c ON c.id = a.trayek_id
                LEFT JOIN m_armada d ON d.id = a.kd_bus_spda
                WHERE extract(YEAR_MONTH FROM a.tgl_spda) = '" . $data['spda_year'] . $data['spda_month'] . "' AND a.kategori_angkutan_id = '" . $data['kategori_angkutan_id'] . "' AND a.trayek_id = '" . $data['trayek_id'] . "'
                GROUP BY b.kategori_angkutan_name, d.armada_name, d.armada_kapasitas, c.route_name, a.tgl_spda, a.ritase_spda, a.ttl_penumpang_spda, 'load factor'
                ORDER BY a.tgl_spda";
            }
            $result = $this->db->query($query)->getResult();

            if ($result != null) {
                return json_encode(array('success' => true, 'data' => $result));
            } else {
                return json_encode(array('success' => false, 'message' => 'Data tidak ditemukan'));
            }
        } else {
            return json_encode(array('success' => false, 'message' => 'Data tidak ditemukan'));
        }
    }

    public function laporan_edit()
    {
        parent::_authEdit(function () {
        });
    }

    public function laporan_delete()
    {
        parent::_authDelete(function () {
        });
    }

    public function pdf()
    {
        $url = uri_segment("3");
        $data = $this->request->getPost();

        $ipaddress = $this->request->getIPAddress();
        $user = $this->session->get('name');

        $url_export = $url . '_export';
        $filter = $this->request->getPost();
        $data['data_url'] = uri_segment("2");
        $data['data_excel'] = $this->laporanModel->export_view($url_export, $filter);
        $html = view('App\Modules\Laporan\Views\export\\' . $url_export, $data);

        $mpdf = new \Mpdf\Mpdf(['setAutoTopMargin' => 'stretch', 'setAutoBottomMargin' => 'stretch']);
        $mpdf->SetHTMLHeader('
        <div style="text-align: center;"><img src="' . base_url() . '/assets/img/hubdat.png" style="display: block; padding-bottom: 10px; width: 20%;"></div>
        <div style="text-align: center;"><img src="' . base_url() . '/assets/img/logodamri.png" style="display: block; padding-bottom: 10px; width: 30%;"></div>
        <div style="text-align: center; font-size: 18px; font-weight: bold; letter-spacing: 3px;">SURAT PERINTAH DINAS ANGKUTAN (Laporan) AP/1</div>
        <hr style="height:2px;border-width:0;color:gray;background-color:gray">
        ');
        $mpdf->SetHTMLFooter('
          <div style="text-align: center;"><img src="' . base_url() . '/assets/img/logo.png" style="display: block; width: 20%;"></div>
          <div style="text-align: left; font-size: 8px; font-style: italic: color:gray;">Printed on ' . date('d/m/Y H:i:s') . ' from IP ' . $ipaddress . ' by ' . $user . ' </div>');
        $mpdf->SetWatermarkImage(base_url() . '/assets/img/logodamri.png');
        $mpdf->watermarkImageAlpha = 0.1;
        $mpdf->showWatermarkImage = true;
        $mpdf->WriteHTML($html);
        $this->response->setHeader('Content-Type', 'application/pdf');
        $mpdf->Output($url . '-' . date('d-m-Y H:i:s') . '.pdf', 'I');

        exit;
    }

    public function laprampcheck_load()
    {
        parent::_authLoad(function () {
            $query = "SELECT DISTINCT MONTH(a.rampcheck_date) AS rampcheck_month, YEAR(a.rampcheck_date) AS rampcheck_year, count(a.rampcheck_no) AS ttl_rampcheck
            FROM t_rampcheck a where a.is_deleted = '0'
            GROUP BY MONTH(a.rampcheck_date), YEAR(a.rampcheck_date)";
            $where = [];

            parent::_loadDatatable($query, $where, $this->request->getPost());
        });
    }

    function laprampcheck_download()
    {
        $url = uri_segment("3");
        $data = $this->request->getPost();
        // get param rampcheckMonth and rampcheckYear from url_segment
        $bulan = '';
        if (uri_segment("3") == '1') {
            $bulan = 'Januari';
        } else if (uri_segment("3") == '2') {
            $bulan = 'Februari';
        } else if (uri_segment("3") == '3') {
            $bulan = 'Maret';
        } else if (uri_segment("3") == '4') {
            $bulan = 'April';
        } else if (uri_segment("3") == '5') {
            $bulan = 'Mei';
        } else if (uri_segment("3") == '6') {
            $bulan = 'Juni';
        } else if (uri_segment("3") == '7') {
            $bulan = 'Juli';
        } else if (uri_segment("3") == '8') {
            $bulan = 'Agustus';
        } else if (uri_segment("3") == '9') {
            $bulan = 'September';
        } else if (uri_segment("3") == '10') {
            $bulan = 'Oktober';
        } else if (uri_segment("3") == '11') {
            $bulan = 'November';
        } else if (uri_segment("3") == '12') {
            $bulan = 'Desember';
        }

        $filter['rampcheckYear'] = uri_segment("4");

        $ipaddress = $this->request->getIPAddress();
        $user = $this->session->get('name');

        $url_export = $url . '_export';
        $filter = $this->request->getPost();
        $data['data_url'] = uri_segment("2");
        $data['data_rampcheck'] = $this->laporanModel->laprampcheck_export($filter);

        $html = view('App\Modules\Laporan\Views\export\laprampcheck_export', $data);

        $mpdf = new \Mpdf\Mpdf(['setAutoTopMargin' => 'stretch', 'setAutoBottomMargin' => 'stretch']);

        $mpdf->SetHTMLHeader('
        <div style="text-align: center;"><img src="' . base_url() . '/assets/img/hubdat.png" style="display: block; padding-bottom: 10px; width: 20%;"></div>
        <div style="text-align: center; font-size: 18px; font-weight: bold; letter-spacing: 3px;">LAPORAN MONITORING RAMPCHECK</div>
        <div style="text-align: center; font-size: 14px; font-weight: bold; letter-spacing: 3px;">BULAN ' . strtoupper($bulan) . ' TAHUN ' . uri_segment("4") . '</div>
        <hr style="height:2px;border-width:0;color:gray;background-color:gray">
        ');
        $mpdf->SetHTMLFooter('
          <div style="text-align: center;"><img src="' . base_url() . '/assets/img/logo.png" style="display: block; width: 20%;"></div>
          <div style="text-align: left; font-size: 8px; font-style: italic: color:gray;">Printed on ' . date('d/m/Y H:i:s') . ' from IP ' . $ipaddress . ' by ' . $user . ' </div>');
        $mpdf->SetWatermarkImage(base_url() . '/assets/img/dishubdat.png');
        $mpdf->watermarkImageAlpha = 0.09;
        $mpdf->showWatermarkImage = true;
        $mpdf->WriteHTML($html);
        $this->response->setHeader('Content-Type', 'application/pdf');
        $mpdf->Output($url . '-' . date('d-m-Y H:i:s') . '.pdf', 'I');
        // $mpdf->Output($url . '-' . date('d-m-Y H:i:s') . '.pdf', 'D');
        exit;
    }

    public function cekdatapnp_load()
    {
        parent::_authLoad(function () {

            $query = "SELECT a.id, b.armada_name, b.armada_code,
                            CONCAT(
                                DATE_FORMAT(a.jadwal_date_depart, '%d-%m-%Y'),
                                ' ',
                                a.jadwal_time_depart
                            ) AS datetime_depart,
                            CONCAT(
                                DATE_FORMAT(a.jadwal_date_arrived, '%d-%m-%Y'),
                                ' ',
                                a.jadwal_time_arrived
                            ) AS datetime_arrived,
                            a.jadwal_type
                        FROM t_jadwal_mudik a
                        JOIN m_armada_mudik b ON a.jadwal_armada_id = b.id
                        WHERE a.is_deleted = '0' AND a.open = '1'";

            $where = ["a.id", "b.armada_name", "b.armada_code", "a.jadwal_type"];
            parent::_loadDatatable($query, $where, $this->request->getPost());
        });
    }

    public function pdfcekdatapnp()
    {
        $url = uri_segment("3");

        $ipaddress = $this->request->getIPAddress();
        $user = $this->session->get('name');

        $url_export = $url . '_export';
        $filter = $_GET['search'];
        $data['data_url'] = uri_segment("2");
        $data['data_excel'] = $this->laporanModel->export_view($url_export, $filter);

        $html = view('App\Modules\Laporan\Views\export\\' . $url_export, $data);

        $mpdf = new \Mpdf\Mpdf(['setAutoTopMargin' => 'stretch', 'setAutoBottomMargin' => 'stretch']);
        $mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8', 'format' => 'A4-L']);
        $mpdf->AddPage(
            'L',
            '',
            '',
            '',
            '',
            10, // margin_left
            10, // margin right
            5, // margin top
            5, // margin bottom
            0, // margin header
            10
        ); // margin footer

        ini_set('pcre.backtrack_limit', 500000000);
        $mpdf->WriteHTML($html);
        $this->response->setHeader('Content-Type', 'application/pdf');
        $mpdf->Output(strtoupper($url) . '-' . date('d-m-Y H:i:s') . '.pdf', 'I');
    }

    public function excel()
    {
        $url = uri_segment("3");

        header("Content-Type:   application/vnd.ms-excel; charset=utf-8");
        header("Content-Disposition: attachment; filename=" . strtoupper($url) . "-" . date('d-m-Y H:i:s') . ".xls");
        header("Expires: 0");
        header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
        header("Cache-Control: private", false);

        $url_export = $url . '_xls';

        if (isset($_GET['jadwal_type'])) {
            $filter = [
                'jadwal_type' => $_GET['jadwal_type']
            ];
        } else {
            $filter = [
                'jadwal_mudik_id' => $_GET['jadwal_mudik_id'],
                'jadwal' => $_GET['jadwal']
            ];
        }

        $data['data_url'] = uri_segment("2");
        $data['data_excel'] = $this->laporanModel->export_view($url_export, $filter);

        echo view('App\Modules\Laporan\Views\export\\' . $url . '_xls', $data);
    }

    public function cekdatamotis_load()
    {
        parent::_authLoad(function () {

            $query = "SELECT b.*, JSON_ARRAYAGG(JSON_OBJECT ('id', a.id, 'armada_name', a.armada_name)) AS 'armada'
                        FROM m_armada_motis_mudik a
                        JOIN (
                            SELECT
                                    a.id,
                                    d.route_name,
                                    CONCAT(DATE_FORMAT(a.jadwal_date_depart, '%d-%m-%Y'),' ',a.jadwal_time_depart) AS jadwal_datetime_depart,
                                    CONCAT(DATE_FORMAT(a.jadwal_date_arrived, '%d-%m-%Y'),' ',a.jadwal_time_arrived) AS jadwal_datetime_arrived,
                                    a.jadwal_type,
                                    a.quota_public,
                                    a.quota_paguyuban,
                                    a.quota_max,
                                    FLOOR(count(b.motis_jadwal_id) / a.quota_max * 100) as percentage_fully
                                FROM t_jadwal_motis_mudik a
                                LEFT JOIN t_billing_motis_mudik b ON a.id = b.motis_jadwal_id
                                LEFT JOIN t_motis_manifest_mudik c ON b.id = c.motis_billing_id
                                JOIN m_route d ON a.jadwal_route_id = d.id
                                WHERE a.is_deleted = 0 AND NOT b.motis_status_verif = 2 AND NOT b.motis_cancel = 1
                                GROUP BY a.id
                        ) b ON b.id = a.jadwal_motis_mudik_id
                        WHERE a.is_deleted = 0
                        GROUP BY b.id";

            $where = ["b.route_name"];
            parent::_loadDatatable($query, $where, $this->request->getPost());
        });
    }

    public function pdfcekdatamotis()
    {
        $url = uri_segment("3");

        $ipaddress = $this->request->getIPAddress();
        $user = $this->session->get('name');

        $url_export = $url . '_export';
        $filter = $_GET['search'];
        $data['data_url'] = uri_segment("2");
        $data['data_excel'] = $this->laporanModel->export_view($url_export, $filter);

        $html = view('App\Modules\Laporan\Views\export\\' . $url_export, $data);

        $mpdf = new \Mpdf\Mpdf(['setAutoTopMargin' => 'stretch', 'setAutoBottomMargin' => 'stretch']);
        $mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8', 'format' => 'A4-L']);
        $mpdf->AddPage(
            'L',
            '',
            '',
            '',
            '',
            10, // margin_left
            10, // margin right
            5, // margin top
            5, // margin bottom
            0, // margin header
            10
        ); // margin footer

        ini_set('pcre.backtrack_limit', 500000000);
        $mpdf->WriteHTML($html);
        $this->response->setHeader('Content-Type', 'application/pdf');
        $mpdf->Output(strtoupper($url) . '-' . date('d-m-Y H:i:s') . '.pdf', 'I');
    }

    public function cekdatamotis_excel()
    {
        $url = uri_segment("3");

        header("Content-Type: application/vnd.ms-excel; charset=utf-8");
        header("Content-Disposition: attachment; filename=" . strtoupper($url) . "-" . date('d-m-Y H:i:s') . ".xls");
        header("Expires: 0");
        header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
        header("Cache-Control: private", false);

        $url_export = $url . '_xls';

        if ($_GET != null) {
            if(isset($_GET['jadwal_mudik_id'], $_GET['jadwal'])){
                $filter = [
                    'jadwal_mudik_id' => $_GET['jadwal_mudik_id'],
                    'jadwal' => $_GET['jadwal']
                ];
            } else if(isset($_GET['jadwal'])){
                $filter = [
                    'jadwal' => $_GET['jadwal']
                ];
            } else {
                $filter = [
                    'jadwal_mudik_id' => $_GET['jadwal_mudik_id']
                ];
            }
        } else {
            $filter = [];
        }

        $data['data_url'] = uri_segment("2");
        $data['data_excel'] = $this->laporanModel->export_view($url_export, $filter);

        echo view('App\Modules\Laporan\Views\export\\' . $url . '_xls', $data);
    }
}
