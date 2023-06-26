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

    function exportTrxPerJenisHarian(){
        $data = $this->request->getGet();

        $explodeDate = explode("-", $data['date']);
        
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
                    "title" => "REKAP LAPORAN TRANSAKSI PER JENIS PERIODE " . $explodeDate[2] . ' ' . $this->getMonth($explodeDate[1]) . ' ' . $explodeDate[0],
                    "date" => $data['date'],
                    "jenis" => $listTarif,
                    "total_per_date" => $totalPerDate,
                    "result" => $result,
                    "ttl_trx" => $ttlTrx,
                    "jml_trx" => $jmlTrx
                ];

        $this->export('Laporan transaksi per jenis tanggal ' . $data['date'], $data['date'], $result, '\exportTrxPerJenisHarian_pdf');
	}

    function exportTrxPerJenisBulanan(){
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
            $totalPerDate[intval($val->tanggal)] += $val->ttl_trx;

            $ttlTrx += $val->ttl_trx;
            $jmlTrx += $val->jml_trx;
        }

        $result = [
                    "title" => "REKAP LAPORAN TRANSAKSI PER JENIS PERIODE " . $this->getMonth($monthOnly) . ' ' . $yearOnly,
                    "date" => $data['date'],
                    "jenis" => $listTarif,
                    "total_per_date" => $totalPerDate,
                    "result" => $result,
                    "ttl_trx" => $ttlTrx,
                    "jml_trx" => $jmlTrx
                ];

        $this->export('Laporan transaksi per jenis bulan ' . $data['date'], $data['date'], $result, '\exportTrxPerJenisBulanan_pdf');
	}

    function exportTrxPerJenisTahunan(){
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
                    "title" => "REKAP LAPORAN TRANSAKSI PER JENIS PERIODE " . $data['date'],
                    "date" => $data['date'],
                    "jenis" => $listTarif,
                    "total_per_date" => $totalPerDate,
                    "result" => $result,
                    "ttl_trx" => $ttlTrx,
                    "jml_trx" => $jmlTrx
                ];

        $this->export('Laporan transaksi per jenis tahun ' . $data['date'], $data['date'], $result, '\exportTrxPerJenisTahunan_pdf');
	}

    function exportTrxPerJalurDateRangeJalurHalteBis(){
        $data = $this->request->getGet();

        $ttlTrx = 0;
        $jmlTrx = 0;

        $query = "SELECT a.jenis, 
                        CASE WHEN ttl_trx THEN ttl_trx ELSE 0 END AS ttl_trx,
                        CASE WHEN jml_trx THEN jml_trx ELSE 0 END AS jml_trx
                    FROM ref_tarif a
                    LEFT JOIN (
                        SELECT a.jenis,
                            count(a.id) as ttl_trx, 
                            SUM(a.kredit) AS jml_trx 
                            FROM transaksi_bis a
                            LEFT JOIN ref_haltebis b
	                            ON a.kode_bis = b.kode_haltebis
                            WHERE a.is_dev = 0 ";

        $title = "REKAP LAPORAN TRANSAKSI PER JENIS ";

        if($data['date']) {
            $dateStart = explode(" - ", $data['date'])[0];
            $dateEnd = explode(" - ", $data['date'])[1];

            $dateStartExplode = explode("-", $dateStart);
            $dateEndExplode = explode("-", $dateEnd);

            $title .= "PERIODE " . $dateStartExplode[2] . " " .  $this->getMonth($dateStartExplode[1]) . " " . $dateStartExplode[0] . " - " . $dateEndExplode[2] . " " .  $this->getMonth($dateEndExplode[1]) . " " . $dateEndExplode[0] . " ";

            $query .= "AND tanggal BETWEEN " . "'" . $dateStart . "'" . " AND " . "'" . $dateEnd . "'" . " ";
        }

        if($data['jalur_id']) {
            $title .= $data['jalur_text'];

            $query .= "AND jalur = " . $data['jalur_id'] . " ";
        }

        if($data['jenpos_id'] != "") {
            $query .= "AND jen_pos= " . $data['jenpos_id'] . " ";
        }

        $query .= "GROUP BY jenis
            ) b
            ON a.jenis = b.jenis
            WHERE is_deleted = 0";

        $result = $this->db->query($query)->getResult();

        foreach($result as $key => $val) {
            $ttlTrx += $val->ttl_trx;
            $jmlTrx += $val->jml_trx;
        }

        $result = [
                    "title" => $title,
                    "date" => $data['date'],
                    "result" => $result,
                    "ttl_trx" => $ttlTrx,
                    "jml_trx" => $jmlTrx
                ];

        $this->export('Laporan transaksi per jalur ' . $data['date'], $data['date'], $result, '\exportTrxPerJalurDateRangeJalurHalteBis_pdf');
	}

    function exportTrxPerHalteBisHarian(){
        $data = $this->request->getGet();

        $explodeDate = explode("-", $data['date']);

        $ttlTunai = 0;
        $ttlIsCashless = 0;
        $ttl = 0;

        $result = $this->db->query("SELECT a.id, 
                                        CONCAT(b.name, ' - ', b.kode_haltebis) as haltebis, 
                                        a.shift, 
                                        a.device_id,
                                        d.jalur,
                                        SUM(CASE WHEN c.is_cashless = 0 THEN a.kredit ELSE 0 END) AS is_cashless,
                                        SUM(CASE WHEN c.is_cashless = 1 THEN a.kredit ELSE 0 END) AS cash,
                                        SUM(CASE WHEN c.is_cashless = 0 THEN a.kredit ELSE 0 END) + SUM(CASE WHEN c.is_cashless = 1 THEN a.kredit ELSE 0 END) as ttl
                                    FROM transaksi_bis a  
                                    LEFT JOIN ref_haltebis b
                                        ON a.kode_bis = b.kode_haltebis
                                    LEFT JOIN ref_tarif c
                                        ON a.jenis = c.jenis
                                    LEFT JOIN ref_jalur d
                                        ON a.jalur = d.id
                                    WHERE a.is_dev = 0
                                    AND tanggal = " . "'" . $data['date'] . "'" . "
                                    GROUP BY CONCAT(b.kode_haltebis, ' - ', b.name), a.shift, a.jenis, a.jalur
                                    ")->getResult();

        foreach($result as $key => $val) {
            $ttlTunai += $val->cash;
            $ttlIsCashless += $val->is_cashless;
            $ttl += $val->ttl;
        }

        $result = [
                    "title" => "REKAP LAPORAN TRANSAKSI PER HALTE / BIS PERIODE " . $explodeDate[2] . ' ' . $this->getMonth($explodeDate[1]) . ' ' . $explodeDate[0],
                    "date" => $data['date'],
                    "result" => $result,
                    "ttl_tunai" => $ttlTunai,
                    "ttl_is_cashless" => $ttlIsCashless,
                    "ttl" => $ttl
                ];

        $this->export('Laporan transaksi per halte/bis ' . $data['date'], $data['date'], $result, '\exportTrxPerHalteBisHarian_pdf');
	}

    function exportTrxPenumpangPerJamJalur(){
        $data = $this->request->getGet();

        $dateStart = explode(" - ", $data['date'])[0];
        $dateEnd = explode(" - ", $data['date'])[1];

        $ttlTrx = 0;
        $jmlTrx = 0;

        $query = "SELECT tanggal, 
                    HOUR(jam) AS jam, 
                    COUNT(id) AS ttl_trx, 
                    SUM(kredit) AS jml_trx
                FROM transaksi_bis a
                WHERE is_dev = 0 ";

        if($data['date']) {
            $query .= "AND tanggal BETWEEN " . "'" . $dateStart . "'" . " AND " . "'" . $dateEnd . "'" . " ";
        }

        if($data['jalur_id']) {
            $query .= "AND jalur = " . $data['jalur_id'] . " ";
        }

        $query .= "GROUP BY tanggal, HOUR(jam)
                    ORDER BY tanggal, HOUR(jam)";

        $result = $this->db->query($query)->getResult();

        foreach($result as $key => $val) {
            $ttlTrx += $val->ttl_trx;
            $jmlTrx += $val->jml_trx;
        }

        $result = [
                    "date" => $data['date'],
                    "result" => $result,
                    "ttl_trx" => $ttlTrx,
                    "jml_trx" => $jmlTrx
                ];

        $this->export('Laporan transaksi per jam & jalur ' . $data['date'], $data['date'], $result, '\exportTrxPenumpangPerJamJalur_pdf');
	}

    function exportTrxPerPos(){
        $data = $this->request->getGet();

        $dateStart = explode(" - ", $data['date'])[0];
        $dateEnd = explode(" - ", $data['date'])[1];

        $ttlTrxCashShiftPagi = 0;
        $ttlTrxCashlessShiftPagi = 0;
        $ttlTrxJmlShiftPagi = 0;
        $ttlTrxCashShiftMalam = 0;
        $ttlTrxCashlessShiftMalam = 0;
        $ttlTrxJmlShiftMalam = 0;
        $ttlTrxJml = 0;

        $query = "SELECT a.id, 
                    a.name, 
                    IFNULL(b.cashless_shift_pagi, 0) as cashless_shift_pagi, 
                    IFNULL(b.cash_shift_pagi, 0) as cash_shift_pagi,
                    IFNULL(b.jml_shift_pagi, 0) as jml_shift_pagi,
                    IFNULL(b.cashless_shift_malam, 0) as cashless_shift_malam,
                    IFNULL(b.cash_shift_malam, 0) as cash_shift_malam,
                    IFNULL(b.jml_shift_malam, 0) as jml_shift_malam,
                    IFNULL(b.jml, 0) as jml
                FROM ref_pool a
                LEFT JOIN (
                    SELECT b.pool_id as id,
                        SUM(CASE WHEN c.is_cashless = 0 && a.shift = 1 THEN kredit ELSE 0 END) AS cashless_shift_pagi,
                        SUM(CASE WHEN c.is_cashless = 1 && a.shift = 1 THEN kredit ELSE 0 END) AS cash_shift_pagi,
                        SUM(CASE WHEN c.is_cashless = 0 && a.shift = 1 THEN kredit ELSE 0 END) + SUM(CASE WHEN c.is_cashless = 1 && a.shift = 1 THEN kredit ELSE 0 END) AS jml_shift_pagi,
                        SUM(CASE WHEN c.is_cashless = 0 && a.shift = 2 THEN kredit ELSE 0 END) AS cashless_shift_malam,
                        SUM(CASE WHEN c.is_cashless = 1 && a.shift = 2 THEN kredit ELSE 0 END) AS cash_shift_malam,
                        SUM(CASE WHEN c.is_cashless = 0 && a.shift = 2 THEN kredit ELSE 0 END) + SUM(CASE WHEN c.is_cashless = 1 && a.shift = 2 THEN kredit ELSE 0 END) AS jml_shift_malam,
                        SUM(CASE WHEN c.is_cashless = 0 && a.shift = 1 THEN kredit ELSE 0 END) + SUM(CASE WHEN c.is_cashless = 1 && a.shift = 1 THEN kredit ELSE 0 END) + SUM(CASE WHEN c.is_cashless = 0 && a.shift = 2 THEN kredit ELSE 0 END) + SUM(CASE WHEN c.is_cashless = 1 && a.shift = 2 THEN kredit ELSE 0 END) AS jml
                    FROM transaksi_bis a
                    LEFT JOIN ref_haltebis b
                        ON a.kode_bis = b.kode_haltebis
                    LEFT JOIN ref_tarif c
                        ON a.jenis = c.jenis
                    WHERE a.is_dev = 0 ";

            if($data['date']) {
            $query .= "AND a.tanggal BETWEEN " . "'" . $dateStart . "'" . " AND " . "'" . $dateEnd . "'" . " ";
            }

            $query .= "GROUP by b.pool_id
                    ) b
                    ON a.id = b.id
                    WHERE is_deleted = 0
                    AND is_dev = 0";

            $result = $this->db->query($query)->getResult();

        foreach($result as $key => $val) {
            $ttlTrxCashShiftPagi += $val->cashless_shift_pagi;
            $ttlTrxCashlessShiftPagi += $val->cash_shift_pagi;
            $ttlTrxJmlShiftPagi += $val->jml_shift_pagi;
            $ttlTrxCashShiftMalam += $val->cashless_shift_malam;
            $ttlTrxCashlessShiftMalam += $val->cash_shift_malam;
            $ttlTrxJmlShiftMalam += $val->jml_shift_malam;
            $ttlTrxJml += $val->jml;
        }

        $result = [
                    "date" => $data['date'],
                    "result" => $result,
                    "ttl_trx_cash_shift_pagi" => $ttlTrxCashShiftPagi,
                    "jml_trx_cashless_shift_pagi" => $ttlTrxCashlessShiftPagi,
                    "jml_trx_jml_shift_pagi" => $ttlTrxJmlShiftPagi,
                    "ttl_trx_cash_shift_malam" => $ttlTrxCashShiftMalam,
                    "jml_trx_cashless_shift_malam" => $ttlTrxCashlessShiftMalam,
                    "jml_trx_jml_shift_malam" => $ttlTrxJmlShiftMalam,
                    "jml_trx_jml" => $ttlTrxJml
                ];

        $this->export('Laporan transaksi per pos periode ' . $data['date'], $data['date'], $result, '\exportTrxPerPos_pdf');
	}

    function getMonth($month) {
        $monthAlias = "";
        switch($month) {
            case "01":
                $monthAlias = "JANUARI";
                break;
            case "02":
                $monthAlias = "FEBRUARI";
                break;
            case "03":
                $monthAlias = "MARET";
                break;
            case "04":
                $monthAlias = "APRIL";
                break;
            case "05":
                $monthAlias = "MEI";
                break;
            case "06":
                $monthAlias = "JUNI";
                break;
            case "07":
                $monthAlias = "JULI";
                break;
            case "08":
                $monthAlias = "AGUSTUS";
                break;
            case "09":
                $monthAlias = "SEPTEMBER";
                break;
            case "10":
                $monthAlias = "OKTOBER";
                break;
            case "11":
                $monthAlias = "NOVEMBER";
                break;
            default:
                $monthAlias = "DESEMBER";
        }

        return $monthAlias;
    }

}