<?php

namespace App\Modules\Settlement\Controllers;

use App\Modules\Settlement\Models\SettlementModel;
use App\Core\BaseController;

class SettlementPdf extends BaseController {

    private $eksekutifModel;

    public function __construct() {
        $this->eksekutifModel = new SettlementModel();
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

		$html = view('App\Modules\Settlement\Views\pdf' . $file , $data);

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

    function exportLapRekonBCA(){
        $data = $this->request->getGet();

        $tenant = $this->getTenant($data["bank"]);

        $dateExplode = explode("-", $data['date']);

        $monthAlias = $this->getMonth($dateExplode[1]);
        
        $query = $this->db->query("SELECT a.tanggal AS date_trx, 
                                        c.date_paid AS date_paid, 
                                        c.ttl_trx,
                                        SUM(b.kredit) AS jml_trx,
                                        c.jml_trx_paid,
                                        c.jml_trx_paid - SUM(b.kredit) AS difference_trx
                                FROM (
                                    SELECT STR_TO_DATE(CONCAT(DATE_FORMAT('" . $data['date'] . "','%Y-%m'),'-',n),'%Y-%m-%e') AS tanggal 
                                    FROM (
                                        SELECT (((b4.0 << 1 | b3.0) << 1 | b2.0) << 1 | b1.0) << 1 | b0.0 AS n
                                        FROM (SELECT 0 UNION ALL SELECT 1) AS b0,
                                                (SELECT 0 UNION ALL SELECT 1) AS b1,
                                                (SELECT 0 UNION ALL SELECT 1) AS b2,
                                                (SELECT 0 UNION ALL SELECT 1) AS b3,
                                                (SELECT 0 UNION ALL SELECT 1) AS b4 
                                            ) t
                                        WHERE n > 0 
                                        AND n <= day(last_day('" . $data['date'] . "'))
                                    ) a
                                LEFT JOIN transaksi_bis b
                                ON a.tanggal = b.tanggal
                                LEFT JOIN (
                                    SELECT tanggal AS date_trx,
                                            date_paid,
                                            count(b.id) AS ttl_trx,
                                            sum(b.kredit) AS jml_trx_paid
                                    FROM (
                                        SELECT STR_TO_DATE(CONCAT(DATE_FORMAT('" . $data['date'] . "','%Y-%m'),'-',n),'%Y-%m-%e') AS tanggal 
                                        FROM (
                                            SELECT (((b4.0 << 1 | b3.0) << 1 | b2.0) << 1 | b1.0) << 1 | b0.0 AS n
                                            FROM (SELECT 0 UNION ALL SELECT 1) AS b0,
                                            (SELECT 0 UNION ALL SELECT 1) AS b1,
                                            (SELECT 0 UNION ALL SELECT 1) AS b2,
                                            (SELECT 0 UNION ALL SELECT 1) AS b3,
                                            (SELECT 0 UNION ALL SELECT 1) AS b4 
                                        ) t
                                    WHERE n > 0 
                                    AND n <= day(last_day('" . $data['date'] . "'))
                                    ) a
                                    LEFT JOIN sttl_bca_paid b
                                    ON a.tanggal = b.date_trx
                                    GROUP BY a.tanggal
                                ) c
                                ON b.tanggal = c.date_trx
                                WHERE b.is_dev = 0
                                AND jenis LIKE 'Flazz%'
                                GROUP BY b.tanggal")->getResult();

        $ttlTrx = 0;
        $jmlTrx = 0;
        $jmlTrxPaid = 0;
        $differenceTrx = 0;
        foreach($query as $key => $val) {
            $ttlTrx += $val->ttl_trx;
            $jmlTrx += $val->jml_trx;
            $jmlTrxPaid += $val->jml_trx_paid;
            $differenceTrx += $val->difference_trx;
        }

        $result = [
            "title" => "REKAP LAPORAN TRANSAKSI " . $tenant . " PERIODE " . $monthAlias . " " . $dateExplode[0],
            "date" => $data['date'],
            "result" => $query,
            "ttl_trx" => $ttlTrx,
            "jml_trx" => $jmlTrx,
            "jml_trx_paid" => $jmlTrxPaid,
            "difference_trx" => $differenceTrx
        ];

        $this->export('Laporan transaksi per jenis tanggal ' . $data['date'], $data['date'], $result, '\exportTrxLapRekon_pdf');
	}

    function exportLapRekonBRI(){
        $data = $this->request->getGet();

        $tenant = $this->getTenant($data["bank"]);

        $dateExplode = explode("-", $data['date']);

        $monthAlias = $this->getMonth($dateExplode[1]);

        $query = $this->db->query("SELECT a.tanggal AS date_trx, 
                                            c.date_paid AS date_paid, 
                                            c.ttl_trx,
                                            SUM(b.kredit) AS jml_trx,
                                            c.jml_trx_paid,
                                            c.jml_trx_paid - SUM(b.kredit) AS difference_trx
                                    FROM (
                                        SELECT STR_TO_DATE(CONCAT(DATE_FORMAT('" . $data['date'] . "','%Y-%m'),'-',n),'%Y-%m-%e') AS tanggal 
                                        FROM (
                                            SELECT (((b4.0 << 1 | b3.0) << 1 | b2.0) << 1 | b1.0) << 1 | b0.0 AS n
                                            FROM (SELECT 0 UNION ALL SELECT 1) AS b0,
                                                    (SELECT 0 UNION ALL SELECT 1) AS b1,
                                                    (SELECT 0 UNION ALL SELECT 1) AS b2,
                                                    (SELECT 0 UNION ALL SELECT 1) AS b3,
                                                    (SELECT 0 UNION ALL SELECT 1) AS b4 
                                        ) t
                                        WHERE n > 0 
                                        AND n <= day(last_day('" . $data['date'] . "'))
                                    ) a
                                    LEFT JOIN transaksi_bis b
                                        ON a.tanggal = b.tanggal
                                    LEFT JOIN (
                                        SELECT tanggal AS date_trx,
                                                date_paid,
                                                COUNT(b.id) AS ttl_trx,
                                                SUM(b.kredit) AS jml_trx_paid
                                        FROM (
                                            SELECT STR_TO_DATE(CONCAT(DATE_FORMAT('" . $data['date'] . "','%Y-%m'),'-',n),'%Y-%m-%e') AS tanggal 
                                            FROM (
                                                SELECT (((b4.0 << 1 | b3.0) << 1 | b2.0) << 1 | b1.0) << 1 | b0.0 AS n
                                                FROM (SELECT 0 UNION ALL SELECT 1) AS b0,
                                                (SELECT 0 UNION ALL SELECT 1) AS b1,
                                                (SELECT 0 UNION ALL SELECT 1) AS b2,
                                                (SELECT 0 UNION ALL SELECT 1) AS b3,
                                                (SELECT 0 UNION ALL SELECT 1) AS b4 
                                            ) t
                                        WHERE n > 0 
                                        AND n <= day(last_day('" . $data['date'] . "'))
                                        ) a
                                        LEFT JOIN sttl_bri_paid b
                                        ON a.tanggal = b.date_trx
                                        GROUP BY a.tanggal
                                    ) c
                                    ON b.tanggal = c.date_trx
                                    WHERE b.is_dev = 0
                                    AND jenis like 'BRIZZI%'
                                    GROUP BY b.tanggal")->getResult();

        $ttlTrx = 0;
        $jmlTrx = 0;
        $jmlTrxPaid = 0;
        $differenceTrx = 0;
        foreach($query as $key => $val) {
            $ttlTrx += $val->ttl_trx;
            $jmlTrx += $val->jml_trx;
            $jmlTrxPaid += $val->jml_trx_paid;
            $differenceTrx += $val->difference_trx;
        }

        $result = [
            "title" => "REKAP LAPORAN TRANSAKSI " . $tenant . " PERIODE " . $monthAlias . " " . $dateExplode[0],
            "date" => $data['date'],
            "result" => $query,
            "ttl_trx" => $ttlTrx,
            "jml_trx" => $jmlTrx,
            "jml_trx_paid" => $jmlTrxPaid,
            "difference_trx" => $differenceTrx
        ];

        $this->export('Laporan transaksi per jenis tanggal ' . $data['date'], $data['date'], $result, '\exportTrxLapRekon_pdf');
	}

    function exportLapRekonBNI(){
        $data = $this->request->getGet();

        $tenant = $this->getTenant($data["bank"]);

        $dateExplode = explode("-", $data['date']);

        $monthAlias = $this->getMonth($dateExplode[1]);
        
        $query = $this->db->query("SELECT a.tanggal AS date_trx, 
                                            c.date_paid AS date_paid, 
                                            c.ttl_trx,
                                            SUM(b.kredit) AS jml_trx,
                                            c.jml_trx_paid,
                                            c.jml_trx_paid - SUM(b.kredit) AS difference_trx
                                    FROM (
                                        SELECT STR_TO_DATE(CONCAT(DATE_FORMAT('" . $data['date'] . "','%Y-%m'),'-',n),'%Y-%m-%e') AS tanggal 
                                        FROM (
                                            SELECT (((b4.0 << 1 | b3.0) << 1 | b2.0) << 1 | b1.0) << 1 | b0.0 AS n
                                            FROM (SELECT 0 UNION ALL SELECT 1) AS b0,
                                                    (SELECT 0 UNION ALL SELECT 1) AS b1,
                                                    (SELECT 0 UNION ALL SELECT 1) AS b2,
                                                    (SELECT 0 UNION ALL SELECT 1) AS b3,
                                                    (SELECT 0 UNION ALL SELECT 1) AS b4 
                                        ) t
                                        WHERE n > 0 
                                        AND n <= day(last_day('" . $data['date'] . "'))
                                    ) a
                                    LEFT JOIN transaksi_bis b
                                        ON a.tanggal = b.tanggal
                                    LEFT JOIN (
                                        SELECT tanggal AS date_trx,
                                                date_paid,
                                                COUNT(b.id) AS ttl_trx,
                                                SUM(b.kredit) AS jml_trx_paid
                                        FROM (
                                            SELECT STR_TO_DATE(CONCAT(DATE_FORMAT('" . $data['date'] . "','%Y-%m'),'-',n),'%Y-%m-%e') AS tanggal 
                                            FROM (
                                                SELECT (((b4.0 << 1 | b3.0) << 1 | b2.0) << 1 | b1.0) << 1 | b0.0 AS n
                                                FROM (SELECT 0 UNION ALL SELECT 1) AS b0,
                                                (SELECT 0 UNION ALL SELECT 1) AS b1,
                                                (SELECT 0 UNION ALL SELECT 1) AS b2,
                                                (SELECT 0 UNION ALL SELECT 1) AS b3,
                                                (SELECT 0 UNION ALL SELECT 1) AS b4 
                                            ) t
                                        WHERE n > 0 
                                        AND n <= day(last_day('" . $data['date'] . "'))
                                        ) a
                                        LEFT JOIN sttl_bni_paid b
                                        ON a.tanggal = b.date_trx
                                        GROUP BY a.tanggal
                                    ) c
                                    ON b.tanggal = c.date_trx
                                    WHERE b.is_dev = 0
                                    AND jenis like 'Tapcash%'
                                    GROUP BY b.tanggal")->getResult();

        $ttlTrx = 0;
        $jmlTrx = 0;
        $jmlTrxPaid = 0;
        $differenceTrx = 0;
        foreach($query as $key => $val) {
            $ttlTrx += $val->ttl_trx;
            $jmlTrx += $val->jml_trx;
            $jmlTrxPaid += $val->jml_trx_paid;
            $differenceTrx += $val->difference_trx;
        }

        $result = [
            "title" => "REKAP LAPORAN TRANSAKSI " . $tenant . " PERIODE " . $monthAlias . " " . $dateExplode[0],
            "date" => $data['date'],
            "result" => $query,
            "ttl_trx" => $ttlTrx,
            "jml_trx" => $jmlTrx,
            "jml_trx_paid" => $jmlTrxPaid,
            "difference_trx" => $differenceTrx
        ];

        $this->export('Laporan transaksi per jenis tanggal ' . $data['date'], $data['date'], $result, '\exportTrxLapRekon_pdf');
	}

    function exportLapRekonMandiri(){
        $data = $this->request->getGet();

        $tenant = $this->getTenant($data["bank"]);

        $dateExplode = explode("-", $data['date']);

        $monthAlias = $this->getMonth($dateExplode[1]);

        $query = $this->db->query("SELECT a.tanggal AS date_trx, 
                                            c.date_paid AS date_paid, 
                                            c.ttl_trx,
                                            SUM(b.kredit) AS jml_trx,
                                            c.jml_trx_paid,
                                            c.jml_trx_paid - SUM(b.kredit) AS difference_trx
                                    FROM (
                                        SELECT STR_TO_DATE(CONCAT(DATE_FORMAT('" . $data['date'] . "','%Y-%m'),'-',n),'%Y-%m-%e') AS tanggal 
                                        FROM (
                                            SELECT (((b4.0 << 1 | b3.0) << 1 | b2.0) << 1 | b1.0) << 1 | b0.0 AS n
                                            FROM (SELECT 0 UNION ALL SELECT 1) AS b0,
                                                    (SELECT 0 UNION ALL SELECT 1) AS b1,
                                                    (SELECT 0 UNION ALL SELECT 1) AS b2,
                                                    (SELECT 0 UNION ALL SELECT 1) AS b3,
                                                    (SELECT 0 UNION ALL SELECT 1) AS b4 
                                        ) t
                                        WHERE n > 0 
                                        AND n <= day(lASt_day('" . $data['date'] . "'))
                                    ) a
                                    LEFT JOIN transaksi_bis b
                                        ON a.tanggal = b.tanggal
                                    LEFT JOIN (
                                        SELECT tanggal AS date_trx,
                                                date_paid,
                                                count(b.id) AS ttl_trx,
                                                sum(b.kredit) AS jml_trx_paid
                                        FROM (
                                            SELECT STR_TO_DATE(CONCAT(DATE_FORMAT('" . $data['date'] . "','%Y-%m'),'-',n),'%Y-%m-%e') AS tanggal 
                                            FROM (
                                                SELECT (((b4.0 << 1 | b3.0) << 1 | b2.0) << 1 | b1.0) << 1 | b0.0 AS n
                                                FROM (SELECT 0 UNION ALL SELECT 1) AS b0,
                                                (SELECT 0 UNION ALL SELECT 1) AS b1,
                                                (SELECT 0 UNION ALL SELECT 1) AS b2,
                                                (SELECT 0 UNION ALL SELECT 1) AS b3,
                                                (SELECT 0 UNION ALL SELECT 1) AS b4 
                                            ) t
                                        WHERE n > 0 
                                        AND n <= day(last_day('" . $data['date'] . "'))
                                        ) a
                                        LEFT JOIN sttl_mandiri_paid b
                                        ON a.tanggal = b.date_trx
                                        GROUP BY a.tanggal
                                    ) c
                                    ON b.tanggal = c.date_trx
                                    WHERE b.is_dev = 0
                                    AND jenis LIKE 'E-Money%'
                                    GROUP BY b.tanggal")->getResult();

        $ttlTrx = 0;
        $jmlTrx = 0;
        $jmlTrxPaid = 0;
        $differenceTrx = 0;
        foreach($query as $key => $val) {
            $ttlTrx += $val->ttl_trx;
            $jmlTrx += $val->jml_trx;
            $jmlTrxPaid += $val->jml_trx_paid;
            $differenceTrx += $val->difference_trx;
        }

        $result = [
            "title" => "REKAP LAPORAN TRANSAKSI " . $tenant . " PERIODE " . $monthAlias . " " . $dateExplode[0],
            "date" => $data['date'],
            "result" => $query,
            "ttl_trx" => $ttlTrx,
            "jml_trx" => $jmlTrx,
            "jml_trx_paid" => $jmlTrxPaid,
            "difference_trx" => $differenceTrx
        ];

        $this->export('Laporan transaksi per jenis tanggal ' . $data['date'], $data['date'], $result, '\exportTrxLapRekon_pdf');
	}

    function getTenant($bank) {
        $bankAlias = "";
        switch($bank) {
            case "BCA":
                $bankAlias = "FLAZZ";
                break;
            case "BNI":
                $bankAlias = "TAPCASH";
                break;
            case "BRI":
                $bankAlias = "BRIZZI";
                break;
            case "Mandiri":
                $bankAlias = "E-MONEY";
                break;
            default:
                $bankAlias = "SERVER ERROR";
        }

        return $bankAlias;
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