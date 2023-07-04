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
                            WHEN jenis LIKE '%Tapcash%' THEN SUBSTRING(jenis, 1, 8)
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
            $data = ['success' => FALSE, 'message' => 'Data tidak ditemukan', 'data' => [0 => ['jenis_transaksi' => '', 'total_penumpang' => 0, 'penumpang_kemarin' => 0, 'selisih_penumpang' => 0]] ];
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
            $data = ['success' => FALSE, 'message' => 'Data tidak ditemukan', 'data' => ['total_penumpang' => 0, 'total_kredit' => 0] ];
        }
        echo json_encode($data);
    }

    public function getAllTransaksiJalur() {
        $query = "SELECT a.id, a.jalur, a.rute, a.color, IFNULL(SUM(b.kredit), 0) AS ttl_pendapatan_jalur, IFNULL(count(b.no_trx), 0) AS ttl_penumpang_jalur
                    FROM ref_jalur a
                    LEFT JOIN transaksi_bis b ON a.id = b.jalur AND DATE(b.tanggal) = CURDATE()
                    WHERE a.is_deleted = 0
                    GROUP BY a.id;";
        $rs = $this->db->query($query)->getResult();
        if($rs) {
            $data = ['success' => TRUE, 'message' => 'Data berhasil ditemukan', 'data' => $rs ];
        } else {
            $data = ['success' => FALSE, 'message' => 'Data tidak ditemukan', 'data' => ['id' => '', 'jalur' => '', 'rute' => '', 'color' => '', 'ttl_pendapatan_jalur' => 0, 'ttl_penumpang_jalur' => 0] ];
        }
        echo json_encode($data);
    }

    public function getAllDevice() {
        $query = "SELECT COUNT(*) AS ttl_tob, SUM(CASE WHEN is_power = 'on' THEN 1 ELSE 0 END) AS ttl_tob_online
                    FROM ref_haltebis
                    WHERE is_deleted = 0";
        $rs = $this->db->query($query)->getRow();
        if($rs) {
            $data = ['success' => TRUE, 'message' => 'Data berhasil ditemukan', 'data' => $rs ];
        } else {
            $data = ['success' => FALSE, 'message' => 'Data tidak ditemukan', 'data' => ['ttl_tob' => 0, 'ttl_tob_online' => 0] ];
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
            $data = ['success' => FALSE, 'message' => 'Data tidak ditemukan', 'data' => ['ttl_jalur' => 0] ];
        }
        echo json_encode($data);
    }

    public function sumTransaksi30() {
        $query = "SELECT DATE(tanggal) AS tgl_transaksi, SUM(kredit) AS sum_value, COUNT(no_trx) AS sum_penumpang
                    FROM transaksi_bis
                    WHERE tanggal >= CURDATE() - INTERVAL 30 DAY
                    GROUP BY DATE(tanggal)";
        $rs = $this->db->query($query)->getResultArray();
        if($rs) {
            $data = ['success' => TRUE, 'message' => 'Data berhasil ditemukan', 'data' => $rs ];
        } else {
            $data = ['success' => FALSE, 'message' => 'Data tidak ditemukan', 'data' => ['tgl_transaksi' => '', 'sum_value' => 0, 'sum_penumpang' => 0] ];
        }
        echo json_encode($data);
    }

    public function getPerJenisTransaksi() {
        $query = "SELECT 
                        CASE
                            WHEN jenis LIKE '%BRIZZI%' THEN SUBSTRING(jenis, 1, 7)
                            WHEN jenis LIKE '%E-Money%' THEN SUBSTRING(jenis, 1, 7)
                            WHEN jenis LIKE '%FLAZZ%' THEN SUBSTRING(jenis, 1, 6)
                            WHEN jenis LIKE '%TapCash%' THEN SUBSTRING(jenis, 1, 8)
                            ELSE jenis
                        END AS jenis_transaksi,
                        SUM(CASE WHEN tanggal = CURDATE() - INTERVAL 1 DAY THEN a.kredit ELSE 0 END) AS ttl_pendapatan_kemarin,
                        SUM(CASE WHEN tanggal = CURDATE() THEN a.kredit ELSE 0 END) AS ttl_pendapatan_sekarang,
                        SUM(CASE WHEN tanggal = CURDATE() THEN a.kredit ELSE 0 END) - SUM(CASE WHEN tanggal = CURDATE() - INTERVAL 1 DAY THEN a.kredit ELSE 0 END) AS selisih_pendapatan
                    FROM transaksi_bis a
                    WHERE a.is_dev = 0
                    GROUP BY a.jenis;";
        $rs = $this->db->query($query)->getResult();
        if($rs) {
            $data = ['success' => TRUE, 'message' => 'Data berhasil ditemukan', 'data' => $rs ];
        } else {
            $data = ['success' => FALSE, 'message' => 'Data tidak ditemukan', 'data' => [0 => ['jenis_transaksi' => '', 'ttl_pendapatan_kemarin' => 0, 'ttl_pendapatan_sekarang' => 0, 'selisih_pendapatan' => 0]] ];
        }
        echo json_encode($data);
    }

    public function getMonitPTA() {
        // $query = "SELECT a.id, a.user_web_name, a.last_login_at, a.last_login_tob_at, a.last_logout_tob_at, b.tanggal, c.name
        // FROM m_user_web a
        // LEFT JOIN transaksi_bis b ON b.petugas_id = a.id AND DATE(b.tanggal) = CURDATE() -- PRODUCTION
        // -- LEFT JOIN transaksi_bis b ON b.petugas_id = a.id AND DATE(b.tanggal) = '2023-06-23' -- TESTING
        // LEFT JOIN ref_haltebis c ON c.kode_haltebis = b.kode_bis
        // WHERE a.is_deleted = 0 AND a.user_web_role_id = 2 
        // GROUP BY a.id";
        $query = "SELECT a.id, a.user_web_name,
                    CASE WHEN c.name IS NULL THEN '-' ELSE c.name END AS halte_name, a.last_login_tob_at, a.last_logout_tob_at,
                    CASE WHEN DATE(a.last_login_tob_at) < CURDATE() || a.last_login_tob_at IS NULL THEN '-' ELSE a.last_login_tob_at END AS last_login_tob_at_status,
                    CASE WHEN DATE(a.last_logout_tob_at) < CURDATE() || a.last_login_tob_at IS NULL THEN '-' ELSE a.last_logout_tob_at END AS last_logout_tob_at_status
                    FROM m_user_web a
                    LEFT JOIN transaksi_bis b ON b.petugas_id = a.id AND DATE(b.tanggal) = CURDATE()
                    LEFT JOIN ref_haltebis c ON c.kode_haltebis = b.kode_bis
                    WHERE a.is_deleted = 0 AND a.user_web_role_id = 2 
                    GROUP BY a.id";
        $rs = $this->db->query($query)->getResult();
        if($rs) {
            $data = ['success' => TRUE, 'message' => 'Data berhasil ditemukan', 'data' => $rs ];
        } else {
            $data = ['success' => FALSE, 'message' => 'Data tidak ditemukan', 'data' => [0 => ['id' => '', 'user_web_name' => '', 'last_login_at' => '', 'last_login_tob_at' => '', 'last_logout_tob_at' => '', 'tanggal' => '', 'name' => '']] ];
        }
        echo json_encode($data);
    }

    public function getDetailPTA() {
        $data = $this->request->getPost();
        $query = "SELECT a.id, a.user_web_name, b.no_trx, b.kredit, b.jenis, c.kode_haltebis, b.shift
                    FROM m_user_web a
                    LEFT JOIN transaksi_bis b ON b.petugas_id = a.id AND DATE(b.tanggal) = CURDATE() -- PRODUCTION
                    -- LEFT JOIN transaksi_bis b ON b.petugas_id = a.id AND DATE(b.tanggal) = '2023-06-23' -- TESTING
                    LEFT JOIN ref_haltebis c ON c.kode_haltebis = b.kode_bis
                    WHERE a.is_deleted = 0 AND a.user_web_role_id = 2 AND a.id = '".$data['id']."'";
        $rs = $this->db->query($query)->getResult();
        if($rs[0]->no_trx != NULL) {
            $data = ['success' => TRUE, 'message' => 'Data berhasil ditemukan', 'data' => $rs ];
        } else {
            $data = ['success' => FALSE, 'message' => 'Data tidak ditemukan', 'data' => [0 => ['user_web_name' => '', 'no_trx' => '', 'kredit' => '', 'jenis' => '', 'kode_bis' => '', 'shift' => '', 'jalur' => '']] ];
        }
        echo json_encode($data);
    }
}
