<?php

namespace App\Modules\Laporan\Controllers;

use App\Modules\Laporan\Models\LaporanModel;
use App\Core\BaseController;
use App\Libraries\DataTables;
use LengthException;

class LaporanAjax extends BaseController
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

    public function kategori_angkutan_id_select_get()
    {
        $data = $this->request->getGet();
        $query = "SELECT a.id , a.kategori_angkutan_name as 'text' FROM m_kategori_angkutan a where a.is_deleted='0'";
        $where = ["a.kategori_angkutan_name"];

        parent::_loadSelect2($data, $query, $where);
    }

    public function trayek_id_select_get()
    {
        $data = $this->request->getGet();
        $query = "SELECT a.id , a.route_name as 'text' FROM m_route a where a.is_deleted='0' and a.kategori_angkutan_id = '$data[kategori_angkutan_id]'";
        $where = ["a.route_name"];

        parent::_loadSelect2($data, $query, $where);
    }

    public function route_distance_select_get()
    {
        $data = $this->request->getGet();
        $id = $data['id'];
        $query = "SELECT a.id , a.route_distance, a.route_time FROM m_route a where a.is_deleted='0' and a.id = '$id'";

        return json_encode($this->db->query($query)->getResult());
    }

    // get jadwal mudik by eo
    // where :
    // open = 0
    // is_deleted = 0
    public function idjadwalmudikrute_select_get()
    {
        $data = $this->request->getGet();

        $query = "SELECT a.id, CONCAT(b.armada_name,' (',b.armada_code,')',' - (', DATE_FORMAT(a.jadwal_date_depart, '%d-%m-%Y'),' ', a.jadwal_time_depart, ' s/d ', DATE_FORMAT(a.jadwal_date_arrived, '%d-%m-%Y'),' ', a.jadwal_time_arrived,') ', IF(a.jadwal_type = '1', 'Arus Mudik', 'Arus Balik')) AS text
                    FROM t_jadwal_mudik a
                    JOIN m_armada_mudik b ON a.jadwal_armada_id = b.id
                    JOIN m_route c ON a.jadwal_route_id = c.id
                    WHERE a.is_deleted = '0' AND c.kategori_angkutan_id = '5' AND a.open = '1'
                ";

        $where = ["b.armada_name", "b.armada_code", "a.jadwal_date_depart", "a.jadwal_time_depart", "a.jadwal_date_arrived", "a.jadwal_time_arrived", "a.jadwal_type"];

        parent::_loadSelect2($data, $query, $where);
    }

    // get jadwal mudik seats by id
    public function bus_seats_get()
    {
        $id = base64_decode($this->request->getPost('id'));
        $jadwal_type = base64_decode($this->request->getPost('jadwal_type'));
        if ($id != null && $jadwal_type != null) {
            $busSeats = $this->db->query("SELECT b.*, c.transaction_booking_name, CONCAT(SUBSTRING(c.transaction_nik,1,13),'XXX') AS nik, d.billing_status_verif, c.verified_at, e.user_web_name,
                                            CASE
                                                WHEN d.billing_status_verif = 0 THEN IF(NOW() > d.billing_verif_expired_date , '0', '1')
                                                WHEN d.billing_status_verif = 1 THEN IF(NOW() > d.billing_verif_expired_date , '1', '0')
                                            END AS 'status_expired'
                                            FROM t_jadwal_mudik a
                                            JOIN t_jadwal_seat_mudik b ON a.id = b.jadwal_id
                                            LEFT JOIN t_transaction_mudik c ON b.transaction_id = c.id
                                            LEFT JOIN t_billing_mudik d ON c.billing_id = d.id
                                            LEFT JOIN m_user_web e ON e.id = c.verified_by 
                                            WHERE a.is_deleted = 0 AND a.open = 1 AND a.id = ? AND a.jadwal_type = ?", [$id, $jadwal_type])->getResult();

            if ($busSeats) {
                echo json_encode(array('success' => true, 'message' => 'Data ditemukan', 'data' => $busSeats));
            } else {
                echo json_encode(array('success' => false, 'message' => 'Data tidak ditemukan', 'data' => $this->db->error()));
            }
        } else {
            echo json_encode(array('success' => false, 'message' => 'Jadwal tidak valid'));
        }
    }

    public function get_armada_modal() {
        $id = base64_decode($this->request->getPost('id'));
        $jadwal_type = base64_decode($this->request->getPost('jadwal_type'));
        if ($id != null && $jadwal_type != null) {
            $armada = $this->db->query("SELECT a.id, a.armada_name, b.jadwal_type
                                            FROM m_armada_motis_mudik a
                                            JOIN t_jadwal_motis_mudik b ON b.id = a.jadwal_motis_mudik_id
                                            WHERE a.is_deleted = 0 AND a.jadwal_motis_mudik_id = ? AND b.jadwal_type = ?", [$id, $jadwal_type])->getResult();
            if ($armada) {
                echo json_encode(array('success' => true, 'message' => 'Data ditemukan', 'data' => $armada));
            } else {
                echo json_encode(array('success' => false, 'message' => 'Data tidak ditemukan', 'data' => $this->db->error()));
            }
        } else {
            echo json_encode(array('success' => false, 'message' => 'Jadwal armada tidak valid'));
        }
    }

    // get jadwal mudik motis seats by id
    public function get_each_armada_detail()
    {
        $id = $this->request->getPost('id');
        if ($id != null) {
            $armadaDetail = $this->db->query("SELECT c.user_mobile_name, d.jadwal_type,
                                                CONCAT(DATE_FORMAT(d.jadwal_date_depart, '%d-%m-%Y'),' ',d.jadwal_time_depart) AS jadwal_datetime_depart,
                                                CONCAT(DATE_FORMAT(d.jadwal_date_arrived, '%d-%m-%Y'),' ',d.jadwal_time_arrived) AS jadwal_datetime_arrived,
                                                e.route_name
                                                FROM m_armada_motis_mudik a
                                                JOIN t_billing_motis_mudik b ON b.motis_armada_id = a.id
                                                JOIN m_user_mobile c ON c.id = b.motis_user_id
                                                JOIN t_jadwal_motis_mudik d ON d.id = b.motis_jadwal_id
                                                JOIN m_route e ON e.id = d.jadwal_route_id
                                                WHERE a.is_deleted = 0 AND b.motis_cancel = 0 AND a.id = ?", [$id])->getResult();

            $length = count($armadaDetail);
            if ($length > 0) {
                echo json_encode(array('success' => true, 'message' => 'Data ditemukan', 'data' => $armadaDetail));
            } else {
                echo json_encode(array('success' => false, 'message' => 'Data tidak ditemukan', 'data' => $this->db->error()));
            }
        } else {
            echo json_encode(array('success' => false, 'message' => 'Jadwal armada tidak valid'));
        }
    }

    public function getBptd()
    {
        $session = \Config\Services::session();
        $instansiId = $this->session->get('instansi_detail_id');

        if ($instansiId != null && $instansiId != '') {
            $paramInstansi = "AND id = '$instansiId'";
        } else {
            $paramInstansi = "";
        }

        if ($this->request->getVar('q')) {
            $param = $this->request->getVar('q');
        } else {
            $param = '';
        }

        $response = $this->db->query("SELECT id, instansi_detail_name as text FROM m_instansi_detail WHERE is_deleted = '0' AND instansi_detail_id = 334 " . $paramInstansi . " AND instansi_detail_name LIKE '%$param%'")->getResult();
        echo json_encode($response);
    }

    public function ajaxLoadDataRekapRampcheck()
    {
        $params['draw'] = $_REQUEST['draw'];
        $start = $_REQUEST['start'];
        $length = $_REQUEST['length'];
        $search_value = $_REQUEST['search']['value'];

        $session = \Config\Services::session();
        $iduser = $this->session->get('id');
        $role_id = $this->session->get('role');
        $instansiId = $this->session->get('instansi_detail_id');

        $bptd = $this->request->getVar('bptd');

        $startDate = $this->request->getVar('startDate');
        $endDate = $this->request->getVar('endDate');

        if ($bptd != null || $bptd != '') {
            $instansiId = $bptd;
        } else {
            $instansiId = $this->session->get('instansi_detail_id');
        }

        if ($instansiId == null || $instansiId == '' || $role_id == 13) {
            $paramInstansi = '';
        } else {
            $paramInstansi = "AND (a.created_by = '" . $iduser . "' OR IF(POSITION(? IN g.kode)>0, g.kode like CONCAT_WS('',LEFT(g.kode,POSITION(? IN g.kode)+LENGTH(?)-1 ),'%') ,g.kode like '000%') )";
        }

        if ($startDate != null || $startDate != '') {
            $paramStartDate = "AND a.rampcheck_date >= '$startDate'";
        } else {
            $paramStartDate = '';
        }

        if ($endDate != null || $endDate != '') {
            $paramEndDate = "AND a.rampcheck_date <= '$endDate'";
        } else {
            $paramEndDate = '';
        }

        if ($search_value != '') {
            $total_count = $this->db->query("SELECT a.id, a.rampcheck_no, DATE_FORMAT(a.rampcheck_date, '%d %M %Y') AS rampcheck_date, c.jenis_lokasi_name, coalesce(d.terminal_name, a.rampcheck_nama_lokasi) AS terminal_name , a.rampcheck_po_name,
            a.rampcheck_noken, a.rampcheck_stuk, e.jenis_angkutan_name AS jenis_angkutan_name , a.rampcheck_trayek AS trayek_name, b.rampcheck_kesimpulan_status, g.instansi_detail_name AS rampcheck_bptd
            FROM t_rampcheck a
            LEFT JOIN t_rampcheck_kesimpulan b ON b.rampcheck_id = a.id
            LEFT JOIN m_jenis_lokasi c ON c.id = a.rampcheck_jenis_lokasi_id
            LEFT JOIN m_terminal d ON d.id = a.rampcheck_nama_lokasi
            LEFT JOIN m_jenis_angkutan e ON e.id = a.rampcheck_jenis_angkutan_id
            LEFT JOIN m_user_web f ON f.id = a.created_by
            JOIN m_instansi_detail g ON g.id = f.instansi_detail_id
            WHERE (a.is_deleted = '0' " . $paramInstansi . $paramStartDate . $paramEndDate . ") AND (a.rampcheck_no like '%" . $search_value . "%' OR c.jenis_lokasi_name like '%" . $search_value . "%' OR d.terminal_name like '%" . $search_value . "%' OR a.rampcheck_trayek like '%" . $search_value . "%' OR a.rampcheck_noken like '%" . $search_value . "%') ORDER BY a.created_at DESC", array($instansiId, $instansiId, $instansiId))->getNumRows();

            $rs = $this->db->query("SELECT a.id, a.rampcheck_no, DATE_FORMAT(a.rampcheck_date, '%d %M %Y') AS rampcheck_date, c.jenis_lokasi_name, coalesce(d.terminal_name, a.rampcheck_nama_lokasi) AS terminal_name , a.rampcheck_po_name,
            a.rampcheck_noken, a.rampcheck_stuk, e.jenis_angkutan_name AS jenis_angkutan_name , a.rampcheck_trayek AS trayek_name, b.rampcheck_kesimpulan_status, g.instansi_detail_name AS rampcheck_bptd
            FROM t_rampcheck a
            LEFT JOIN t_rampcheck_kesimpulan b ON b.rampcheck_id = a.id
            LEFT JOIN m_jenis_lokasi c ON c.id = a.rampcheck_jenis_lokasi_id
            LEFT JOIN m_terminal d ON d.id = a.rampcheck_nama_lokasi
            LEFT JOIN m_jenis_angkutan e ON e.id = a.rampcheck_jenis_angkutan_id
            LEFT JOIN m_user_web f ON f.id = a.created_by
            JOIN m_instansi_detail g ON g.id = f.instansi_detail_id
            WHERE (a.is_deleted = '0' " . $paramInstansi . $paramStartDate . $paramEndDate . ") AND (a.rampcheck_no like '%" . $search_value . "%' OR c.jenis_lokasi_name like '%" . $search_value . "%' OR d.terminal_name like '%" . $search_value . "%' OR a.rampcheck_trayek like '%" . $search_value . "%' OR a.rampcheck_noken like '%" . $search_value . "%') ORDER BY a.created_at DESC
                                        limit $start, $length", array($instansiId, $instansiId, $instansiId));
            $data = $rs->getResult();
        } else {
            #$total_count = $this->db->query("SELECT * FROM t_rampcheck WHERE is_deleted = '0' ". $paramInstansiCount)->getResult();
            $total_count = $this->db->query("SELECT a.id, a.rampcheck_no, DATE_FORMAT(a.rampcheck_date, '%d %M %Y') AS rampcheck_date, c.jenis_lokasi_name, coalesce(d.terminal_name, a.rampcheck_nama_lokasi) AS terminal_name , a.rampcheck_po_name,
            a.rampcheck_noken, a.rampcheck_stuk, e.jenis_angkutan_name AS jenis_angkutan_name , a.rampcheck_trayek AS trayek_name, b.rampcheck_kesimpulan_status, g.instansi_detail_name AS rampcheck_bptd
            FROM t_rampcheck a
            LEFT JOIN t_rampcheck_kesimpulan b ON b.rampcheck_id = a.id
            LEFT JOIN m_jenis_lokasi c ON c.id = a.rampcheck_jenis_lokasi_id
            LEFT JOIN m_terminal d ON d.id = a.rampcheck_nama_lokasi
            LEFT JOIN m_jenis_angkutan e ON e.id = a.rampcheck_jenis_angkutan_id
            LEFT JOIN m_user_web f ON f.id = a.created_by
            JOIN m_instansi_detail g ON g.id = f.instansi_detail_id
            WHERE (a.is_deleted = '0' " . $paramInstansi . $paramStartDate . $paramEndDate . ") ORDER BY a.created_at DESC", array($instansiId, $instansiId, $instansiId))->getNumRows();

            $rs = $this->db->query("SELECT a.id, a.rampcheck_no, DATE_FORMAT(a.rampcheck_date, '%d %M %Y') AS rampcheck_date, c.jenis_lokasi_name, coalesce(d.terminal_name, a.rampcheck_nama_lokasi) AS terminal_name , a.rampcheck_po_name,
            a.rampcheck_noken, a.rampcheck_stuk, e.jenis_angkutan_name AS jenis_angkutan_name , a.rampcheck_trayek AS trayek_name, b.rampcheck_kesimpulan_status, g.instansi_detail_name AS rampcheck_bptd
            FROM t_rampcheck a
            LEFT JOIN t_rampcheck_kesimpulan b ON b.rampcheck_id = a.id
            LEFT JOIN m_jenis_lokasi c ON c.id = a.rampcheck_jenis_lokasi_id
            LEFT JOIN m_terminal d ON d.id = a.rampcheck_nama_lokasi
            LEFT JOIN m_jenis_angkutan e ON e.id = a.rampcheck_jenis_angkutan_id
            LEFT JOIN m_user_web f ON f.id = a.created_by
            JOIN m_instansi_detail g ON g.id = f.instansi_detail_id
            WHERE (a.is_deleted = '0' " . $paramInstansi . $paramStartDate . $paramEndDate . ") ORDER BY a.created_at DESC limit $start, $length", array($instansiId, $instansiId, $instansiId));
            $data = $rs->getResult();
        }
        $json_data = array(
            "draw" => intval($params['draw']),
            "recordsTotal" => $total_count,
            "recordsFiltered" => $total_count,
            "data" => $data, // total data array

        );
        echo json_encode($json_data);
    }

    public function downloadRekapRampcheckPerArmada()
    {
        $session = \Config\Services::session();
        $iduser = $this->session->get('id');
        $role_id = $this->session->get('role');
        $instansiId = $this->session->get('instansi_detail_id');

        $bptd = $this->request->getVar('bptd');

        $startDate = $this->request->getVar('startDate');
        $endDate = $this->request->getVar('endDate');

        if ($bptd != null || $bptd != '') {
            $instansiId = $bptd;
        } else {
            $instansiId = $this->session->get('instansi_detail_id');
        }

        if ($instansiId == null || $instansiId == '' || $role_id == 13) {
            $paramInstansi = '';
        } else {
            $paramInstansi = "AND (a.created_by = '" . $iduser . "' OR IF(POSITION(? IN g.kode)>0, g.kode like CONCAT_WS('',LEFT(g.kode,POSITION(? IN g.kode)+LENGTH(?)-1 ),'%') ,g.kode like '000%') )";
        }

        if ($startDate != null || $startDate != '') {
            $paramStartDate = "AND a.rampcheck_date >= '$startDate'";
        } else {
            $paramStartDate = '';
        }

        if ($endDate != null || $endDate != '') {
            $paramEndDate = "AND a.rampcheck_date <= '$endDate'";
        } else {
            $paramEndDate = '';
        }

        $rs = $this->db->query("SELECT a.id, a.rampcheck_no, DATE_FORMAT(a.rampcheck_date, '%d %M %Y') AS rampcheck_date, c.jenis_lokasi_name, coalesce(d.terminal_name, a.rampcheck_nama_lokasi) AS terminal_name , a.rampcheck_po_name,
            a.rampcheck_noken, a.rampcheck_stuk, e.jenis_angkutan_name AS jenis_angkutan_name , a.rampcheck_trayek AS trayek_name, g.instansi_detail_name AS rampcheck_bptd,
            CASE WHEN b.rampcheck_kesimpulan_status = 0 THEN 'Diijinkan Operasional'
            WHEN b.rampcheck_kesimpulan_status = 1 THEN 'Peringatan/Perbaiki'
            WHEN b.rampcheck_kesimpulan_status = 2 THEN 'Tilang dan Dilarang Operasional'
            ELSE 'Dilarang Operasional' END AS rampcheck_kesimpulan_status
            FROM t_rampcheck a
            LEFT JOIN t_rampcheck_kesimpulan b ON b.rampcheck_id = a.id
            LEFT JOIN m_jenis_lokasi c ON c.id = a.rampcheck_jenis_lokasi_id
            LEFT JOIN m_terminal d ON d.id = a.rampcheck_nama_lokasi
            LEFT JOIN m_jenis_angkutan e ON e.id = a.rampcheck_jenis_angkutan_id
            LEFT JOIN m_user_web f ON f.id = a.created_by
            LEFT JOIN m_instansi_detail g ON g.id = f.instansi_detail_id
            WHERE a.is_deleted = '0' " . $paramStartDate . $paramEndDate . $paramInstansi . " ORDER BY a.created_at DESC", array($instansiId, $instansiId, $instansiId));
        $data = $rs->getResult();

        header("Content-Type: application/vnd.ms-excel");

        if ($startDate != null || $startDate != '' && $endDate != null || $endDate != '' && $bptd != null || $bptd != '') {
            header("Content-Disposition: attachment; filename=Rekap Rampcheck Per Armada $startDate - $endDate - $bptd.xls");
        } else if ($startDate != null || $startDate != '' && $endDate != null || $endDate != '') {
            header("Content-Disposition: attachment; filename=Rekap Rampcheck Per Armada $startDate - $endDate.xls");
        } else if ($bptd != null || $bptd != '') {
            header("Content-Disposition: attachment; filename=Rekap Rampcheck Per Armada $bptd.xls");
        } else {
            header("Content-Disposition: attachment; filename=Rekap Rampcheck Per Armada.xls");
        }

        header("Pragma: no-cache");

        header("Expires: 0");
        header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
        header("Cache-Control: private", false);

        $html = '<table border="1">
        <tr>
            <th>No</th>
            <th>No Rampcheck</th>
            <th>Tanggal Rampcheck</th>
            <th>Jenis Lokasi</th>
            <th>Nama Lokasi</th>
            <th>PO</th>
            <th>No Kendaraan</th>
            <th>No STUK</th>
            <th>Jenis Angkutan</th>
            <th>Trayek</th>
            <th>Status</th>
            <th>BPTD</th>
        </tr>';

        $no = 1;
        foreach ($data as $row) {
            $html .= '<tr>
                <td>' . $no . '</td>
                <td>' . $row->rampcheck_no . '</td>
                <td>' . $row->rampcheck_date . '</td>
                <td>' . $row->jenis_lokasi_name . '</td>
                <td>' . $row->terminal_name . '</td>
                <td>' . $row->rampcheck_po_name . '</td>
                <td>' . $row->rampcheck_noken . '</td>
                <td>' . $row->rampcheck_stuk . '</td>
                <td>' . $row->jenis_angkutan_name . '</td>
                <td>' . $row->trayek_name . '</td>
                <td>' . $row->rampcheck_kesimpulan_status . '</td>
                <td>' . $row->rampcheck_bptd . '</td>
            </tr>';
            $no++;
        }

        $html .= '</table>';
        echo $html;

    }

    public function downloadRekapRampcheckDetail()
    {
      $session = \Config\Services::session();
        $iduser = $this->session->get('id');
        $role_id = $this->session->get('role');
        $instansiId = $this->session->get('instansi_detail_id');

        $bptd = $this->request->getVar('bptd');

        $startDate = $this->request->getVar('startDate');
        $endDate = $this->request->getVar('endDate');

        if ($bptd != null || $bptd != '') {
            $instansiId = $bptd;
        } else {
            $instansiId = $this->session->get('instansi_detail_id');
        }

        if ($instansiId == null || $instansiId == '' || $role_id == 13) {
            $paramInstansi = '';
        } else {
            $paramInstansi = "AND (a.created_by = '" . $iduser . "' OR IF(POSITION(? IN g.kode)>0, g.kode like CONCAT_WS('',LEFT(g.kode,POSITION(? IN g.kode)+LENGTH(?)-1 ),'%') ,g.kode like '000%') )";
        }

        if ($startDate != null || $startDate != '') {
            $paramStartDate = "AND a.rampcheck_date >= '$startDate'";
        } else {
            $paramStartDate = '';
        }

        if ($endDate != null || $endDate != '') {
            $paramEndDate = "AND a.rampcheck_date <= '$endDate'";
        } else {
            $paramEndDate = '';
        }

        $rs = $this->db->query("SELECT a.id, a.rampcheck_no, a.rampcheck_no_kp, DATE_FORMAT(a.rampcheck_date, '%d %M %Y') AS rampcheck_date, c.jenis_lokasi_name, a.rampcheck_nama_lokasi, a.rampcheck_po_name,
      a.rampcheck_noken, a.rampcheck_stuk, e.jenis_angkutan_name AS jenis_angkutan_name , a.rampcheck_trayek AS trayek_name, g.instansi_detail_name AS rampcheck_bptd,
      CASE WHEN sum(rampcheck_adm_ku + rampcheck_adm_kpr + rampcheck_adm_kpc) > 0 THEN 'Tidak Lulus Unsur Administrasi'
      ELSE 'Lulus Unsur Administrasi'
      END AS adm_status,
      CASE WHEN sum(rampcheck_utp_sp_dpn + rampcheck_utp_sp_blk + rampcheck_utp_bk_kcd + rampcheck_utp_bk_pu + rampcheck_utp_bk_kru + rampcheck_utp_bk_krp + rampcheck_utp_bk_ldt + rampcheck_utp_ktd_jtd + rampcheck_utp_pk_bc + rampcheck_utp_pk_sp + rampcheck_utp_pk_dkr + rampcheck_utp_pk_pbr + rampcheck_utp_pk_ls + rampcheck_utp_pk_pgr + rampcheck_utp_pk_skp + rampcheck_utp_pk_ptk) > 0 THEN 'Tidak Lulus Unsur Teknis Penunjang'
      ELSE 'Lulus Unsur Teknis Penunjang'
      END AS utp_status,
      CASE WHEN sum(rampcheck_utu_lukd + rampcheck_utu_lukj + rampcheck_utu_lpad + rampcheck_utu_lpaj + rampcheck_utu_lr + rampcheck_utu_lm + rampcheck_utu_kru + rampcheck_utu_krp + rampcheck_utu_kbd + rampcheck_utu_kbb + rampcheck_utu_skp + rampcheck_utu_pk + rampcheck_utu_pkw + rampcheck_utu_pd + rampcheck_utu_jd + rampcheck_utu_apk + rampcheck_utu_apar) > 0 THEN 'Tidak Lulus Unsur Teknis Utama'
      ELSE 'Lulus Unsur Teknis Utama'
      END AS utu_status,
      CASE WHEN b.rampcheck_kesimpulan_status = 0 THEN 'Diijinkan Operasional'
      WHEN b.rampcheck_kesimpulan_status = 1 THEN 'Peringatan/Perbaiki'
      WHEN b.rampcheck_kesimpulan_status = 2 THEN 'Tilang dan Dilarang Operasional'
      ELSE 'Dilarang Operasional' END AS rampcheck_kesimpulan_status, a.rampcheck_pengemudi, b.rampcheck_kesimpulan_nama_penguji, b.rampcheck_kesimpulan_no_penguji
      FROM t_rampcheck a
      LEFT JOIN t_rampcheck_kesimpulan b ON b.rampcheck_id = a.id
      LEFT JOIN m_jenis_lokasi c ON c.id = a.rampcheck_jenis_lokasi_id
      LEFT JOIN m_terminal d ON d.id = a.rampcheck_nama_lokasi
      LEFT JOIN m_jenis_angkutan e ON e.id = a.rampcheck_jenis_angkutan_id
      LEFT JOIN m_user_web f ON f.id = a.created_by
      LEFT JOIN m_instansi_detail g ON g.id = f.instansi_detail_id
      JOIN t_rampcheck_adm adm ON adm.rampcheck_id = a.id
      JOIN t_rampcheck_utp utp ON utp.rampcheck_id = a.id
      JOIN t_rampcheck_utu utu ON utu.rampcheck_id = a.id
      WHERE a.is_deleted = '0' " . $paramStartDate . $paramEndDate . $paramInstansi . " 
      GROUP BY a.id, a.rampcheck_no, a.rampcheck_no_kp, DATE_FORMAT(a.rampcheck_date, '%d %M %Y'), c.jenis_lokasi_name, a.rampcheck_nama_lokasi, a.rampcheck_po_name, a.rampcheck_noken, a.rampcheck_stuk, e.jenis_angkutan_name, a.rampcheck_trayek, g.instansi_detail_name, a.rampcheck_pengemudi, b.rampcheck_kesimpulan_status, b.rampcheck_kesimpulan_nama_penguji, b.rampcheck_kesimpulan_no_penguji
      ORDER BY a.created_at DESC", array($instansiId, $instansiId, $instansiId));

      $data = $rs->getResult();

        header("Content-Type: application/vnd.ms-excel");

        if ($startDate != null || $startDate != '' && $endDate != null || $endDate != '' && $bptd != null || $bptd != '') {
            header("Content-Disposition: attachment; filename=Rekap Rampcheck Detail $startDate - $endDate - $bptd.xls");
        } else if ($startDate != null || $startDate != '' && $endDate != null || $endDate != '') {
            header("Content-Disposition: attachment; filename=Rekap Rampcheck Detail $startDate - $endDate.xls");
        } else if ($bptd != null || $bptd != '') {
            header("Content-Disposition: attachment; filename=Rekap Rampcheck Detail $bptd.xls");
        } else {
            header("Content-Disposition: attachment; filename=Rekap Rampcheck Detail.xls");
        }

        header("Pragma: no-cache");

        header("Expires: 0");
        header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
        header("Cache-Control: private", false);

        $html = '<table border="1">
        <tr>
            <th>No</th>
            <th>No. Rampcheck</th>
            <th>No. Rampcheck KP</th>
            <th>Tanggal Rampcheck</th>
            <th>Jenis Lokasi</th>
            <th>Nama Lokasi</th>
            <th>PO</th>
            <th>No. Kendaraan</th>
            <th>No. STUK</th>
            <th>Jenis Angkutan</th>
            <th>Trayek</th>
            <th>BPTD</th>
            <th>Unsur Administrasi</th>
            <th>Unsur Teknis Utama</th>
            <th>Unsur Teknis Penunjang</th>
            <th>Kesimpulan</th>
            <th>Pengemudi</th>
            <th>Nama Penguji</th>
            <th>No. Penguji</th>
        </tr>';

        $no = 1;
        foreach ($data as $row) {
            $html .= '<tr>
            <td>' . $no++ . '</td>
            <td>' . $row->rampcheck_no . '</td>
            <td>' . $row->rampcheck_no_kp . '</td>
            <td>' . $row->rampcheck_date . '</td>
            <td>' . $row->jenis_lokasi_name . '</td>
            <td>' . $row->rampcheck_nama_lokasi . '</td>
            <td>' . $row->rampcheck_po_name . '</td>
            <td>' . $row->rampcheck_noken . '</td>
            <td>' . $row->rampcheck_stuk . '</td>
            <td>' . $row->jenis_angkutan_name . '</td>
            <td>' . $row->trayek_name . '</td>
            <td>' . $row->rampcheck_bptd . '</td>
            <td>' . $row->adm_status . '</td>
            <td>' . $row->utu_status . '</td>
            <td>' . $row->utp_status . '</td>
            <td>' . $row->rampcheck_kesimpulan_status . '</td>
            <td>' . $row->rampcheck_pengemudi . '</td>
            <td>' . $row->rampcheck_kesimpulan_nama_penguji . '</td>
            <td>' . strval($row->rampcheck_kesimpulan_no_penguji) . '</td>
            </tr>';
        }

        $html .= '</table>';
        echo $html;

    }
}
