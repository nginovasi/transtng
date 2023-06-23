<?php namespace App\Modules\Main\Controllers;

use App\Modules\Main\Models\MainModel;
use CodeIgniter\Controller;
use App\Core\BaseController;

class MainAjax extends BaseController
{
    private $mainModel;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->mainModel = new MainModel();
    }

    public function index()
    {
        return redirect()->to(base_url()); 
    }

    public function findByKoridor()
    {
        $data = $this->request->getGet();
        $query = "SELECT a.id, a.jalur AS 'text' FROM ref_jalur a WHERE a.is_deleted = 0"; //QUERY belum fix
        $where = ["a.jalur"];
        parent::_loadSelect2($data, $query, $where);
    }

    public function getJenisTransaksi() {
        $query = "SELECT
                        CASE
                            WHEN jenis LIKE '%BRIZZI%' THEN SUBSTRING(jenis, 1, 7)
                            WHEN jenis LIKE '%E-Money%' THEN SUBSTRING(jenis, 1, 7)
                            WHEN jenis LIKE '%FLAZZ%' THEN SUBSTRING(jenis, 1, 6)
                            ELSE jenis
                        END AS jenis_transaksi,
                        SUM(CASE WHEN tanggal = CURDATE() THEN 1 ELSE 0 END) AS total_penumpang,
                        SUM(CASE WHEN tanggal = CURDATE() - INTERVAL 1 DAY THEN 1 ELSE 0 END) AS penumpang_kemarin,
                        SUM(CASE WHEN tanggal = CURDATE() THEN 1 ELSE 0 END) - SUM(CASE WHEN tanggal = CURDATE() - INTERVAL 1 DAY THEN 1 ELSE 0 END) AS selisih_penumpang
                    FROM transaksi_bis
                    WHERE tanggal >= CURDATE() - INTERVAL 1 DAY
                    GROUP BY jenis;";
        $rs = $this->db->query($query)->getResult();
        if($rs) {
            $data = ['success' => TRUE, 'message' => 'Data berhasil ditemukan', 'data' => $rs ];
        } else {
            $data = ['success' => FALSE, 'message' => 'Data tidak ditemukan', 'data' => [] ];
        }
        echo json_encode($data);
    }

    public function getAllTransaksi() {
        $query = "SELECT COUNT(a.no_trx) AS total_penumpang, SUM(a.kredit) AS total_kredit
                    FROM transaksi_bis a
                    LEFT JOIN ref_jalur b ON b.id = a.jalur
                    WHERE DATE(a.tanggal) = CURDATE()
                    GROUP BY DATE(a.tanggal)";
        $rs = $this->db->query($query)->getRow();
        if($rs) {
            $data = ['success' => TRUE, 'message' => 'Data berhasil ditemukan', 'data' => $rs ];
        } else {
            $data = ['success' => FALSE, 'message' => 'Data tidak ditemukan', 'data' => [] ];
        }
        echo json_encode($data);
    }

    public function getAllDevice() {
        $query = "SELECT COUNT(*) AS ttl_tob, SUM(CASE WHEN is_power = 'off' THEN 1 ELSE 0 END) AS ttl_tob_offline
                    FROM ref_haltebis
                    WHERE is_deleted = 0";
        $rs = $this->db->query($query)->getRow();
        if($rs) {
            $data = ['success' => TRUE, 'message' => 'Data berhasil ditemukan', 'data' => $rs ];
        } else {
            $data = ['success' => FALSE, 'message' => 'Data tidak ditemukan', 'data' => [] ];
        }
        echo json_encode($data);
    }

    public function getAllJalur() {
        $query = "SELECT count(*) as ttl_jalur
                    FROM ref_jalur a
                    WHERE a.is_deleted = 0";
        $rs = $this->db->query($query)->getRow();
        if($rs) {
            $data = ['success' => TRUE, 'message' => 'Data berhasil ditemukan', 'data' => $rs ];
        } else {
            $data = ['success' => FALSE, 'message' => 'Data tidak ditemukan', 'data' => [] ];
        }
        echo json_encode($data);
    }
}
