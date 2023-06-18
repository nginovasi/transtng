<?php

namespace App\Modules\Eksekutif\Controllers;

use App\Modules\Eksekutif\Models\EksekutifModel;
use App\Core\BaseController;

class EksekutifAjax extends BaseController {
    private $eksekutifModel;

    public function __construct() {
        $this->eksekutifModel = new EksekutifModel();
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

    public function haltebis_id_per_pendapatan30d_select_get() {
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

    public function chartinfo30hari() 
    {
        $data = $this->request->getPost();

        $query = "SELECT DATE_FORMAT(a.tanggal,'%d/%m/%y (%a)') AS tanggal,
                        CONCAT(FLOOR(TIMESTAMPDIFF(minute,MIN(a.jam),MAX(a.jam))/60),' jam ', TIMESTAMPDIFF(minute,MIN(a.jam),MAX(a.jam)) mod 60,' menit') AS 'jam_aktif_transaksi',
                        SUM(a.Kredit) AS pendapatan,
                        SUM(1) AS trx 
                    FROM transaksi_bis a
                    where a.tanggal between date_add(curdate(),interval -30 day) and curdate() ";
        if($data['haltebis_id'] != "") {
            $query .= "and a.kode_bis = " . "'" . $data["haltebis_id"] . "' ";
        }

        $query .= "group by a.tanggal
                    order by a.tanggal";

        $result = $this->db->query($query)->getResult();
        
        echo json_encode([
            "success" => true, 
            "message" => "get data success", 
            "data" => $result
        ]);
    }

    public function getTransaksiPerjenisHarian() 
    {
        $data = $this->request->getPost();

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
                                        ORDER BY HOUR(created_at), jenis, DATE(created_at)
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

    public function getTransaksiPerjenisBulan() 
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

    public function getTransaksiPerjenisTahun() 
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

    public function getTransaksiPerHalteBisHarian() 
    {
        $data = $this->request->getPost();

        $result = $this->db->query("SELECT a.id, 
                                        CONCAT(b.name, ' - ', b.kode_haltebis) as haltebis, 
                                        a.shift, 
                                        a.imei,
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

    public function getTransaksiPerJalurDateRangeJalurHalteBis() 
    {
        $data = $this->request->getPost();

        $dateStart = explode(" - ", $data['date'])[0];
        $dateEnd = explode(" - ", $data['date'])[1];

        $query = "SELECT a.jenis, 
                        CASE WHEN ttl_trx THEN ttl_trx ELSE 0 END AS ttl_trx,
                        CASE WHEN jml_trx THEN jml_trx ELSE 0 END AS jml_trx
                    FROM ref_tarif a
                    LEFT JOIN (
                        SELECT jenis,
                            count(id) as ttl_trx, 
                            SUM(kredit) AS jml_trx 
                            FROM transaksi_bis a
                            WHERE is_dev = 0 ";

        if($data['date']) {
            $query .= "AND tanggal BETWEEN " . "'" . $dateStart . "'" . " AND " . "'" . $dateEnd . "'" . " ";
        }

        if($data['jalur_id']) {
            $query .= "AND jalur = " . $data['jalur_id'] . " ";
        }

        if($data['jenpos_id']) {
            $query .= "AND jenpos= " . $data['jenpos_id'] . " ";
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

}