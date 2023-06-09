<?php

namespace App\Modules\Eksekutif\Controllers;

use App\Modules\Eksekutif\Models\EksekutifModel;
use App\Core\BaseController;

class EksekutifAjax extends BaseController
{
    private $eksekutifModel;

    public function __construct()
    {
        $this->eksekutifModel = new EksekutifModel();
    }

    public function index()
    {
        return redirect()->to(base_url());
    }

    public function haltebis_id_per_trx30d_select_get()
    {
        $data = $this->request->getGet();

        $query = "SELECT * FROM (
                        SELECT a.kode_haltebis as id, a.kode_haltebis as bis, a.name as text, b.pendapatan
                    FROM ref_haltebis a
                    INNER JOIN (
                        SELECT kode_bis, sum(kredit) as pendapatan 
                        FROM transaksi_bis 
                        WHERE (tanggal BETWEEN date_add(curdate(),INTERVAL -30 DAY) AND curdate()) 
                        GROUP BY kode_bis
                        HAVING pendapatan > 0
                    ) b
                    ON a.kode_haltebis = b.kode_bis
                    WHERE a.is_deleted = 0
                    GROUP BY a.kode_haltebis 
                    ORDER BY b.pendapatan DESC
                    ) a
                WHERE a.bis IS NOT NULL";

        $where = ["a.bis", "a.text", "a.pendapatan"];

        parent::_loadSelect2($data, $query, $where);
    }

    public function chart_trx_30d()
    {
        $data = $this->request->getPost();

        $query = "SELECT DATE_FORMAT(a.tanggal,'%d/%m/%y (%a)') AS tanggal,
                        CONCAT(FLOOR(TIMESTAMPDIFF(minute,MIN(a.jam),MAX(a.jam))/60),' jam ', TIMESTAMPDIFF(minute,MIN(a.jam),MAX(a.jam)) mod 60,' menit') AS 'jam_aktif_transaksi',
                        SUM(a.Kredit) AS pendapatan,
                        SUM(1) AS trx 
                    FROM transaksi_bis a
                    where a.tanggal between date_add(curdate(),interval -30 day) and curdate() ";
                    
        if ($data['haltebis_id'] != "") {
            $query .= "and a.kode_bis = " . "'" . $data["haltebis_id"] . "' ";
        }

        $query .= "group by a.tanggal
                    order by a.tanggal";

        $result = $this->db->query($query)->getResult();

        echo json_encode(array("success" => true, "message" => "get data success", "data" => $result));
    }

    public function getTrxPerJenisHarian()
    {
        $data = $this->request->getPost();

        $result = [];
        $totalPerDate = [];

        $ttlTrx = 0;
        $jmlTrx = 0;

        $nonManual = $this->db->query("SELECT jenis,
                                            tanggal, 
                                            HOUR(jam) AS jam, 
                                            COUNT(id) AS ttl_trx, 
                                            SUM(kredit) AS jml_trx
                                        FROM transaksi_bis a
                                        WHERE is_dev = 0
                                        AND tanggal = " . "'" . $data['date'] . "'" . "
                                        GROUP BY jenis, DATE(tanggal), HOUR(jam)
                                        ORDER BY HOUR(jam), jenis, DATE(tanggal)
                                        ")->getResult();

        $listTarif = $this->db->query("SELECT * 
                                        FROM ref_tarif 
                                        WHERE is_deleted = 0
                                        ")->getResult();

        for ($i = 0; $i < 24; $i++) {
            $totalPerDate[$i] = 0;
        }

        foreach ($nonManual as $key => $val) {
            $result['ttl_trx'][$val->jenis][$val->jam] = $val->ttl_trx;
            $result['jml_trx'][$val->jenis][$val->jam] = $val->jml_trx;
            $totalPerDate[$val->jam] += $val->ttl_trx;

            $ttlTrx += $val->ttl_trx;
            $jmlTrx += $val->jml_trx;
        }

        echo json_encode([
            "success" => true,
            "message" => "get data success",
            "data" => [
                "jenis" => $listTarif,
                "total_per_date" => $totalPerDate,
                "result" => $result,
                "ttl_trx" => $ttlTrx,
                "jml_trx" => $jmlTrx
            ]
        ]);
    }

    public function getTrxPerjenisBulan()
    {
        $data = $this->request->getPost();
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

        for ($i = 01; $i <= $countDate; $i++) {
            $totalPerDate[$i] = 0;
        }

        foreach ($nonManual as $key => $val) {
            $result['ttl_trx'][$val->jenis][$val->tanggal] = $val->ttl_trx;
            $result['jml_trx'][$val->jenis][$val->tanggal] = $val->jml_trx;
            $totalPerDate[intval($val->tanggal)] += $val->ttl_trx;

            $ttlTrx += $val->ttl_trx;
            $jmlTrx += $val->jml_trx;
        }

        echo json_encode([
            "success" => true,
            "message" => "get data success",
            "data" => [
                "jenis" => $listTarif,
                "total_per_date" => $totalPerDate,
                "result" => $result,
                "ttl_trx" => $ttlTrx,
                "jml_trx" => $jmlTrx
            ]
        ]);
    }

    public function getTrxPerjenisTahun()
    {
        $data = $this->request->getPost();
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

        for ($i = 0; $i <= 12; $i++) {
            $totalPerDate[$i] = 0;
        }

        foreach ($nonManual as $key => $val) {
            $result['ttl_trx'][$val->jenis][$val->bulan] = $val->ttl_trx;
            $result['jml_trx'][$val->jenis][$val->bulan] = $val->jml_trx;
            $totalPerDate[$val->bulan] += $val->ttl_trx;

            $ttlTrx += $val->ttl_trx;
            $jmlTrx += $val->jml_trx;
        }

        echo json_encode([
            "success" => true,
            "message" => "get data success",
            "data" => [
                "jenis" => $listTarif,
                "total_per_date" => $totalPerDate,
                "result" => $result,
                "ttl_trx" => $ttlTrx,
                "jml_trx" => $jmlTrx
            ]
        ]);
    }

    public function jalur_id_select_get()
    {
        $data = $this->request->getGet();

        $query = "SELECT id, CONCAT(jalur, ' (', rute, ')') as text
                    FROM ref_jalur 
                    WHERE is_deleted = 0
                    AND is_dev = 0";

        $where = ["jalur", "rute"];

        parent::_loadSelect2($data, $query, $where);
    }

    public function getTrxPerJalurDateRangeJalurHalteBis()
    {
        $data = $this->request->getPost();

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

        if ($data['date']) {
            $dateStart = explode(" - ", $data['date'])[0];
            $dateEnd = explode(" - ", $data['date'])[1];
            
            $query .= "AND a.tanggal BETWEEN " . "'" . $dateStart . "'" . " AND " . "'" . $dateEnd . "'" . " ";
        }

        if ($data['jalur_id']) {
            $query .= "AND a.jalur = " . $data['jalur_id'] . " ";
        }

        if ($data['jenpos_id'] != "") {
            $query .= "AND b.jen_pos= " . $data['jenpos_id'] . " ";
        }

        $query .= "GROUP BY jenis
                    ) b
                    ON a.jenis = b.jenis
                    WHERE is_deleted = 0";

        $result = $this->db->query($query)->getResult();

        echo json_encode([
            "success" => true,
            "message" => "get data success",
            "data" => [
                "result" => $result
            ]
        ]);
    }

    public function getTrxPenumpangPerJamJalur()
    {
        $data = $this->request->getPost();

        $query = "SELECT tanggal, 
                    HOUR(jam) AS jam, 
                    COUNT(id) AS ttl_trx, 
                    SUM(kredit) AS jml_trx
                FROM transaksi_bis a
                WHERE is_dev = 0 ";

        if ($data['date']) {
            $dateStart = explode(" - ", $data['date'])[0];
            $dateEnd = explode(" - ", $data['date'])[1];

            $query .= "AND tanggal BETWEEN " . "'" . $dateStart . "'" . " AND " . "'" . $dateEnd . "'" . " ";
        }

        if ($data['jalur_id']) {
            $query .= "AND jalur = " . $data['jalur_id'] . " ";
        }

        $query .= "GROUP BY tanggal, HOUR(jam)
                    ORDER BY tanggal, HOUR(jam)";

        $result = $this->db->query($query)->getResult();

        echo json_encode([
            "success" => true,
            "message" => "get data success",
            "data" => [
                "result" => $result
            ]
        ]);
    }

    public function getTransaksiPerHalteBisHarian()
    {
        $data = $this->request->getPost();

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

        echo json_encode([
            "success" => true,
            "message" => "get data success",
            "data" => [
                "result" => $result
            ]
        ]);
    }

    public function getTrxPerPetugasHarian()
    {
        $data = $this->request->getPost();

        $result = $this->db->query("SELECT b.user_web_username, 
                                            a.shift, 
                                            a.kode_bis, 
                                            a.device_id, 
                                            concat(c.jalur, ' (', c.rute, ') ' ) AS jalur, 
                                            sum(a.kredit) AS jml_trx
                                        FROM transaksi_bis a
                                        LEFT JOIN m_user_web b
                                            ON a.petugas_id = b.id
                                        LEFT JOIN ref_jalur c
                                            ON a.jalur = c.id
                                        WHERE a.is_dev = 0
                                        AND tanggal = " . "'" . $data['date'] . "'" . "
                                        GROUP BY b.user_web_username, a.shift, a.kode_bis, a.device_id, a.jalur")->getResult();

        echo json_encode([
            "success" => true,
            "message" => "get data success",
            "data" => [
                "result" => $result
            ]
        ]);
    }

    public function getTrxPerPos()
    {
        $data = $this->request->getPost();

        $dateStart = explode(" - ", $data['date'])[0];
        $dateEnd = explode(" - ", $data['date'])[1];

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

        if ($data['date']) {
            $query .= "AND a.tanggal BETWEEN " . "'" . $dateStart . "'" . " AND " . "'" . $dateEnd . "'" . " ";
        }

        $query .= "GROUP by b.pool_id
                    ) b
                    ON a.id = b.id
                    WHERE is_deleted = 0
                    AND is_dev = 0";

        $result = $this->db->query($query)->getResult();

        echo json_encode([
            "success" => true,
            "message" => "get data success",
            "data" => [
                "result" => $result
            ]
        ]);
    }

    public function getTrxGrfkPerjenisHarian()
    {
        $data = $this->request->getPost();

        $result = $this->db->query("SELECT jenis,
                                        tanggal, 
                                        CONCAT(HOUR(created_at), ':00 WIB') AS waktu, 
                                        COUNT(id) AS ttl_trx, 
                                        SUM(kredit) AS jml_trx
                                    FROM transaksi_bis
                                    WHERE is_dev = 0
                                    AND date(tanggal) = " . "'" . $data['date'] . "'" . "
                                    GROUP BY jenis, date(created_at), HOUR(created_at)
                                    ORDER BY HOUR(created_at), jenis, date(created_at)")->getResult();

        echo json_encode([
            "success" => true,
            "message" => "get data success",
            "data" => [
                "result" => $result
            ]
        ]);
    }

    public function getTrxGrfkPerjenisBulanan()
    {
        $data = $this->request->getPost();

        $result = $this->db->query("SELECT jenis, 
                                        DATE_FORMAT(tanggal,'%d') AS waktu, 
                                        COUNT(*) AS ttl_trx, 
                                        SUM(kredit) AS jml_trx
                                    FROM transaksi_bis a 
                                    WHERE is_dev = 0
                                    AND DATE_FORMAT(a.tanggal,'%Y-%m') = " . "'" . $data['date'] . "'" . " AND HOUR(a.Jam) BETWEEN 0 AND 23
                                    GROUP BY jenis, tanggal
                                    ORDER BY tanggal, jenis")->getResult();

        echo json_encode([
            "success" => true,
            "message" => "get data success",
            "data" => [
                "result" => $result
            ]
        ]);
    }

    public function getTrxGrfkPerjenisTahunan()
    {
        $data = $this->request->getPost();

        $result = $this->db->query("SELECT jenis, 
                                        MONTH(tanggal) AS waktu, 
                                        COUNT(id) AS ttl_trx, 
                                        SUM(kredit) AS jml_trx 
                                    FROM transaksi_bis a 
                                    WHERE is_dev = 0
                                    AND YEAR(tanggal) = " . "'" . $data['date'] . "'" . " AND HOUR(jam) BETWEEN 0 AND 23 
                                    GROUP BY jenis, month(tanggal)
                                    ORDER BY month(tanggal), jenis")->getResult();

        echo json_encode([
            "success" => true,
            "message" => "get data success",
            "data" => [
                "result" => $result
            ]
        ]);
    }

    public function getTrxGrfkPerJalurDateRange()
    {
        $data = $this->request->getPost();

        $dateStart = explode(" - ", $data['date'])[0];
        $dateEnd = explode(" - ", $data['date'])[1];

        $result = $this->db->query("SELECT b.rute as jalur, 
                                        a.jenis,
                                        count(a.id) as ttl_trx, 
                                        SUM(a.kredit) AS jml_trx 
                                    FROM transaksi_bis a 
                                    LEFT JOIN ref_jalur b
                                        on a.jalur = b.id
                                    WHERE a.is_dev = 0
                                    AND a.tanggal BETWEEN " . "'" . $dateStart . "'" . " AND " . "'" . $dateEnd . "'" . "
                                    GROUP BY a.jenis, a.jalur ORDER BY a.jalur")->getResult();

        $listJalur = $this->db->query("SELECT * 
                                        FROM ref_jalur
                                        WHERE is_deleted = 0
                                        AND is_dev = 0
                                        ")->getResult();

        echo json_encode([
            "success" => true,
            "message" => "get data success",
            "data" => [
                "result" => $result,
                "list_jalur" => $listJalur
            ]
        ]);
    }

    public function loadalataktif30hari()
    {
        $data = $this->request->getPost();
        $query = "SELECT a.tanggal, count(*) AS alataktif
                    FROM
                        (
                            SELECT tanggal, device_id
                            FROM transaksi_bis a
                            WHERE a.tanggal BETWEEN date_add(curdate(), INTERVAL -30 DAY) AND curdate()
                            GROUP BY a.tanggal, a.device_id
                        ) a
                    GROUP BY a.tanggal
                    ORDER BY a.tanggal desc";

        $result = $this->db->query($query)->getResult();
        echo json_encode([
            "success" => true,
            "message" => "get data success",
            "data" => $result
        ]);
    }
}
