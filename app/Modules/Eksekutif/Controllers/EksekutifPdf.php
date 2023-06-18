<?php

namespace App\Modules\Eksekutif\Controllers;

use App\Modules\Eksekutif\Models\EksekutifModel;
use App\Core\BaseController;

class EksekutifPdf extends BaseController {

    private $eksekutifModel;

    public function __construct() {
        $this->eksekutifModel = new EksekutifModel();
    }

    public function index() {
        return redirect()->to(base_url());
    }

    private function export($title, $id, $result, $file){
        // mpf
		$mpdf = new \Mpdf\Mpdf(['format' => 'A5']);
		$mpdf->curlAllowUnsafeSslRequests = true;

        // layout html view
        $data = [];
        foreach($result as $key => $val) {
            $data[$key] = $val;
        }

		$html = view('App\Modules\Eksekutif\Views\pdf' . $file , $data);

        // margin left, right, top, bottom, header, footer
		$mpdf->AddPage('L','', '', '', '', 20, 20, 5, 10, 90, 10);

        // template background pdf
        // $pagecount = $mpdf->SetSourceFile('assets/template.pdf');
        // $tplIdx = $mpdf->ImportPage($pagecount);

        // $mpdf->useTemplate($tplIdx);

		$mpdf->WriteHTML($html);

        // set header, so that the data return pdf, no binary text
        $this->response->setHeader("Content-Type", "application/pdf");

        // output name pdf
        $name = "";
		// $mpdf->Output('SKD - '.$id.' - '. $name .'.pdf','I');

        $mpdf->Output($title . '.pdf','I');
	}

    function exportTransaksiPerJenisHarian(){
        $data = $this->request->getGet();

        $result = [];
        $totalPerDate = [];

        $ttlTrx = 0;
        $jmlTrx = 0;

        $nonManual = $this->db->query("SELECT jenis,
                                            tanggal, 
                                            HOUR(created_at) AS jam, 
                                            COUNT(id) AS ttl_trx, 
                                            SUM(kredit) AS jml_trx
                                        FROM transaksi_bis a
                                        WHERE is_dev = 0
                                        AND date(tanggal) = " . "'" . $data['date'] . "'" . "
                                        GROUP BY jenis, DATE(created_at), HOUR(created_at)
                                        ORDER BY HOUR(created_at), jenis, DATE(created_at);
                                        ")->getResult();

        $listTarif = $this->db->query("SELECT * 
                                        FROM ref_tarif 
                                        WHERE is_deleted = 0
                                        ")->getResult();

        for($i = 0; $i < 24; $i++) {
            $totalPerDate[$i] = 0;
        }

        foreach($nonManual as $key => $val) {
            $result['ttl_trx'][$val->jenis][$val->jam] = $val->ttl_trx;
            $result['jml_trx'][$val->jenis][$val->jam] = $val->jml_trx;
            $totalPerDate[$val->jam] += $val->ttl_trx;

            $ttlTrx += $val->ttl_trx;
            $jmlTrx += $val->jml_trx;
        }

        $result = [
                    "date" => $data['date'],
                    "jenis" => $listTarif,
                    "total_per_date" => $totalPerDate,
                    "result" => $result,
                    "ttl_trx" => $ttlTrx,
                    "jml_trx" => $jmlTrx
                ];

        $this->export('Laporan transaksi per jenis tanggal ' . $data['date'], $data['date'], $result, '\exportTransaksiPerJenisHarian_pdf');
	}

    function exportTransaksiPerJenisBulanan(){
        $data = $this->request->getGet();
        $date = $data['date'];
        $monthOnly = explode("-", $date)[1];
        $yearOnly = explode("-", $date)[0];

        $result = [];
        $totalPerDate = [];

        $ttlTrx = 0;
        $jmlTrx = 0;

        $nonManual = $this->db->query("SELECT jenis, 
                                            DATE_FORMAT(tanggal,'%d') AS tanggal, 
                                            COUNT(id) AS ttl_trx, 
                                            SUM(kredit) AS jml_trx
                                        FROM transaksi_bis 
                                        WHERE is_dev = 0
                                        AND DATE_FORMAT(tanggal,'%Y-%m') = " . "'" . $date . "'" . " AND HOUR(jam) BETWEEN 0 AND 23
                                        GROUP BY jenis, tanggal
                                        ORDER BY tanggal, jenis
                                        ")->getResult();

        $listTarif = $this->db->query("SELECT * 
                                        FROM ref_tarif 
                                        WHERE is_deleted = 0
                                        ")->getResult();

        $countDate = cal_days_in_month(CAL_GREGORIAN, $monthOnly, $yearOnly);

        for($i = 0; $i <= $countDate; $i++) {
            $totalPerDate[$i] = 0;
        }

        foreach($nonManual as $key => $val) {
            $result['ttl_trx'][$val->jenis][$val->tanggal] = $val->ttl_trx;
            $result['jml_trx'][$val->jenis][$val->tanggal] = $val->jml_trx;
            $totalPerDate[$val->tanggal] += $val->ttl_trx;

            $ttlTrx += $val->ttl_trx;
            $jmlTrx += $val->jml_trx;
        }

        $result = [
                    "date" => $data['date'],
                    "jenis" => $listTarif,
                    "total_per_date" => $totalPerDate,
                    "result" => $result,
                    "ttl_trx" => $ttlTrx,
                    "jml_trx" => $jmlTrx
                ];

        $this->export('Laporan transaksi per jenis bulan ' . $data['date'], $data['date'], $result, '\exportTransaksiPerJenisBulanan_pdf');
	}

    function exportTransaksiPerJenisTahunan(){
        $data = $this->request->getGet();
        $date = $data['date'];

        $result = [];
        $totalPerDate = [];

        $ttlTrx = 0;
        $jmlTrx = 0;

        $nonManual = $this->db->query("SELECT jenis, 
                                            MONTH(tanggal) AS bulan, 
                                            COUNT(id) AS ttl_trx, 
                                            SUM(kredit) AS jml_trx 
                                        FROM transaksi_bis a 
                                        WHERE is_dev = 0
                                        AND YEAR(tanggal) = " . "'" . $date . "'" . " AND HOUR(jam) BETWEEN 0 AND 23 
                                        GROUP BY jenis, month(tanggal)
                                        ORDER BY month(tanggal), jenis
                                        ")->getResult();

        $listTarif = $this->db->query("SELECT * 
                                        FROM ref_tarif 
                                        WHERE is_deleted = 0
                                        ")->getResult();

        for($i = 0; $i <= 12; $i++) {
            $totalPerDate[$i] = 0;
        }

        foreach($nonManual as $key => $val) {
            $result['ttl_trx'][$val->jenis][$val->bulan] = $val->ttl_trx;
            $result['jml_trx'][$val->jenis][$val->bulan] = $val->jml_trx;
            $totalPerDate[$val->bulan] += $val->ttl_trx;

            $ttlTrx += $val->ttl_trx;
            $jmlTrx += $val->jml_trx;
        }

        $result = [
                    "date" => $data['date'],
                    "jenis" => $listTarif,
                    "total_per_date" => $totalPerDate,
                    "result" => $result,
                    "ttl_trx" => $ttlTrx,
                    "jml_trx" => $jmlTrx
                ];

        $this->export('Laporan transaksi per jenis tahun ' . $data['date'], $data['date'], $result, '\exportTransaksiPerJenisTahunan_pdf');
	}

}