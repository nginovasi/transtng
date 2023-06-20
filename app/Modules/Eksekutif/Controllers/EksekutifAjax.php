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

    public function loadalataktif30hari() {
        $data = $this->request->getPost();
        $query = "SELECT a.tanggal, count(*) AS alataktif
                    FROM
                        (
                            SELECT tanggal, imei
                            FROM transaksi_bis a
                            WHERE a.tanggal BETWEEN date_add(curdate(), INTERVAL -30 DAY) AND curdate()
                            GROUP BY a.tanggal, a.imei
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