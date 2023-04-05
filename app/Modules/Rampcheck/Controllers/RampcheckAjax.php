<?php namespace App\Modules\Rampcheck\Controllers;

use App\Core\BaseController;
use App\Modules\Rampcheck\Models\RampcheckModel;

class RampcheckAjax extends BaseController
{
    private $rampcheckModel;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->rampcheckModel = new RampcheckModel();
        date_default_timezone_set('Asia/Jakarta');
    }

    public function index()
    {
        return redirect()->to(base_url());
    }

    public function getJenisLokasi()
    {
        if ($this->request->getVar('q')) {
            $param = $this->request->getVar('q');
        } else {
            $param = '';
        }
        $builder = $this->db->table('m_jenis_lokasi');
        $query = $builder->like('jenis_lokasi_name', $param)
            ->select('id, jenis_lokasi_name as text')
            ->get();
        $jenisLokasi = $query->getResult();

        return json_encode($jenisLokasi);
    }

    public function getNamaLokasi()
    {
        $iduser = $this->session->get('id');
        $instansiId = $this->session->get('instansi_detail_id');

        if ($instansiId == null || $instansiId == '') {
            if ($this->request->getVar('q')) {
                $param = $this->request->getVar('q');
            } else {
                $param = '';
            }

            $namaLokasi = $this->db->query("SELECT terminal_name AS id, terminal_name AS text FROM m_terminal
                                            WHERE is_deleted = '0' AND terminal_name LIKE '%" . $param . "%'")->getResult();
        } else {
            $provUser = $this->db->query("SELECT distinct coalesce(b.multiple_lokprov_id, b.lokprov_id) AS id_prov
                                        FROM m_user_web a
                                        LEFT JOIN m_instansi_detail b ON b.id = a.instansi_detail_id
                                        WHERE a.is_deleted = '0' AND b.is_deleted = '0'
                                        AND ( IF( POSITION(? IN b.kode)>0
                                                                        , b.kode LIKE CONCAT_WS(
                                                                            '',
                                                                            LEFT(b.kode,POSITION(? IN b.kode)+LENGTH(?)-1)
                                                                            ,'%'
                                                                            )
                                                                        ,b.kode LIKE '000%'
                                                                    )
                                                            )", array($instansiId, $instansiId, $instansiId))->getRowArray();

            if ($provUser['id_prov'] == null) {
                $paramProv = "";
            } else {
                $provUser['id_prov'] = $provUser['id_prov'];
                $paramProv = " AND api_kode_prov_dagri IN (" . $provUser['id_prov'] . ")";
            }

            if ($this->request->getVar('q')) {
                $param = $this->request->getVar('q');
            } else {
                $param = '';
            }

            $namaLokasi = $this->db->query("SELECT terminal_name AS id, terminal_name AS text FROM m_terminal
                                            WHERE is_deleted = '0' " . $paramProv . " AND terminal_name LIKE '%" . $param . "%'")->getResult();
        }

        return json_encode($namaLokasi);
    }

    public function getJenisAngkutan()
    {
        if ($this->request->getVar('q')) {
            $param = $this->request->getVar('q');
        } else {
            $param = '';
        }
        $builder = $this->db->table('m_jenis_angkutan');
        $query = $builder->like('jenis_angkutan_name', $param)
            ->select('id, jenis_angkutan_name as text')
            ->get();
        $jenisAngkutan = $query->getResult();

        return json_encode($jenisAngkutan);
    }

    public function getTrayek()
    {
        if ($this->request->getVar('q')) {
            $param = $this->request->getVar('q');
        } else {
            $param = '';
        }
        $builder = $this->db->table('m_trayek');
        $query = $builder->like('trayek_name', $param)
            ->select('id, trayek_name as text')
            ->get();
        $trayek = $query->getResult();

        return json_encode($trayek);
    }

    public function ajaxDataTables()
    {
        // $db = db_connect();
        // $builder = $db->table("t_rampcheck")
        //               ->select("t_rampcheck.rampcheck_no", "t_rampcheck.rampcheck_date", "m_jenis_lokasi.jenis_lokasi_name",
        //                        "m_terminal.terminal_name", "t_rampcheck.rampcheck_po_name", "t_rampcheck.rampcheck_noken",
        //                        "t_rampcheck.rampcheck_stuk", "m_jenis_angkutan.jenis_angkutan_name", "m_trayek.trayek_name",
        //                        "t_rampcheck_kesimpulan.rampcheck_kesimpulan_status")
        //               ->join("t_rampcheck_kesimpulan", "t_rampcheck_kesimpulan.rampcheck_id = t.rampcheck.id")
        //               ->join("m_jenis_lokasi","m_jenis_lokasi.id = t_rampcheck.rampcheck_jenis_lokasi_id")
        //               ->join("m_terminal", "m_terminal.id = t_rampcheck.rampcheck_jenis_angkutan_id")
        //               ->join("m_jenis_angkutan", "m_jenis_angkutan.id = t_rampcheck.rampcheck_jenis_angkutan_id")
        //               ->join("m_trayek", "m_trayek.id = t_rampcheck.rampcheck_trayek")
        //               ->where("t_rampcheck.is_deleted","0");

        // return json_encode($builder);
    }

    public function ajaxLoadData()
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
        $terminal = $this->request->getVar('terminal');
        $status = $this->request->getVar('status');

        if ($bptd != null || $bptd != '') {
            $instansiId = $bptd;
        } else {
            $instansiId = $this->session->get('instansi_detail_id');
        }

        if ($terminal != null || $terminal != '') {
            $paramTerminal = "AND a.rampcheck_nama_lokasi = '" . $terminal . "'";
        } else {
            $paramTerminal = '';
        }

        if ($status != null || $status != '') {
            $paramStatus = "AND b.rampcheck_kesimpulan_status = '" . $status . "'";
        } else {
            $paramStatus = '';
        }

        if ($instansiId == null || $instansiId == '' || $role_id == 13) {
            $paramInstansi = '';
        } else {
            $paramInstansi = "AND (a.created_by = '" . $iduser . "' OR IF(POSITION(? IN g.kode)>0, g.kode like CONCAT_WS('',LEFT(g.kode,POSITION(? IN g.kode)+LENGTH(?)-1 ),'%') ,g.kode like '000%') )";
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
            WHERE (a.is_deleted = '0' " . $paramStatus . $paramTerminal . $paramInstansi . ") AND (a.rampcheck_no like '%" . $search_value . "%' OR c.jenis_lokasi_name like '%" . $search_value . "%' OR d.terminal_name like '%" . $search_value . "%' OR a.rampcheck_trayek like '%" . $search_value . "%' OR a.rampcheck_noken like '%" . $search_value . "%') ORDER BY a.created_at DESC", array($instansiId, $instansiId, $instansiId))->getNumRows();

            $rs = $this->db->query("SELECT a.id, a.rampcheck_no, DATE_FORMAT(a.rampcheck_date, '%d %M %Y') AS rampcheck_date, c.jenis_lokasi_name, coalesce(d.terminal_name, a.rampcheck_nama_lokasi) AS terminal_name , a.rampcheck_po_name,
            a.rampcheck_noken, a.rampcheck_stuk, e.jenis_angkutan_name AS jenis_angkutan_name , a.rampcheck_trayek AS trayek_name, b.rampcheck_kesimpulan_status, g.instansi_detail_name AS rampcheck_bptd
            FROM t_rampcheck a
            LEFT JOIN t_rampcheck_kesimpulan b ON b.rampcheck_id = a.id
            LEFT JOIN m_jenis_lokasi c ON c.id = a.rampcheck_jenis_lokasi_id
            LEFT JOIN m_terminal d ON d.id = a.rampcheck_nama_lokasi
            LEFT JOIN m_jenis_angkutan e ON e.id = a.rampcheck_jenis_angkutan_id
            LEFT JOIN m_user_web f ON f.id = a.created_by
            JOIN m_instansi_detail g ON g.id = f.instansi_detail_id
            WHERE (a.is_deleted = '0' " . $paramStatus . $paramTerminal . $paramInstansi . ") AND (a.rampcheck_no like '%" . $search_value . "%' OR c.jenis_lokasi_name like '%" . $search_value . "%' OR d.terminal_name like '%" . $search_value . "%' OR a.rampcheck_trayek like '%" . $search_value . "%' OR a.rampcheck_noken like '%" . $search_value . "%') ORDER BY a.created_at DESC
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
            WHERE (a.is_deleted = '0' " . $paramStatus . $paramTerminal . $paramInstansi . ") ORDER BY a.created_at DESC", array($instansiId, $instansiId, $instansiId))->getNumRows();

            $rs = $this->db->query("SELECT a.id, a.rampcheck_no, DATE_FORMAT(a.rampcheck_date, '%d %M %Y') AS rampcheck_date, c.jenis_lokasi_name, coalesce(d.terminal_name, a.rampcheck_nama_lokasi) AS terminal_name , a.rampcheck_po_name,
            a.rampcheck_noken, a.rampcheck_stuk, e.jenis_angkutan_name AS jenis_angkutan_name , a.rampcheck_trayek AS trayek_name, b.rampcheck_kesimpulan_status, g.instansi_detail_name AS rampcheck_bptd
            FROM t_rampcheck a
            LEFT JOIN t_rampcheck_kesimpulan b ON b.rampcheck_id = a.id
            LEFT JOIN m_jenis_lokasi c ON c.id = a.rampcheck_jenis_lokasi_id
            LEFT JOIN m_terminal d ON d.id = a.rampcheck_nama_lokasi
            LEFT JOIN m_jenis_angkutan e ON e.id = a.rampcheck_jenis_angkutan_id
            LEFT JOIN m_user_web f ON f.id = a.created_by
            JOIN m_instansi_detail g ON g.id = f.instansi_detail_id
            WHERE (a.is_deleted = '0' " . $paramStatus . $paramTerminal . $paramInstansi . ") ORDER BY a.created_at DESC limit $start, $length", array($instansiId, $instansiId, $instansiId));
            $data = $rs->getResult();
        }
        $json_data = array(
            "draw" => intval($params['draw']),
            "recordsTotal" => $total_count,
            "recordsFiltered" => $total_count,
            "lq" => $this->db->getLastQuery(),
            "data" => $data, // total data array

        );
        echo json_encode($json_data);
    }

    public function getSpionamAPI()
    {
        $noken = $this->request->getPost('noken');

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://mitradarat.dephub.go.id/api/v1/spionam',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => array('noken' => $noken),
            CURLOPT_HTTPHEADER => array(
                'X-NGI-TOKEN: dev',
                'Cookie: ci_session=qiik850j86gjmchpgc43ptlaokk1icer',
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        echo $response;
    }

    public function getBlueAPI()
    {
        $noken = $this->request->getPost('noken');

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://mitradarat.dephub.go.id/api/v1/blue',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => array('no_registrasi_kendaraan' => $noken),
            CURLOPT_HTTPHEADER => array(
                'X-NGI-TOKEN: dev',
                'Cookie: ci_session=qiik850j86gjmchpgc43ptlaokk1icer',
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        echo $response;
    }

    public function getPerusahaanSpionam()
    {
        $data = $this->request->getVar();
        $perusahaan_id = $data['perusahaan_id'];

        $query = $this->db->query("SELECT * FROM m_perusahaan_spionam WHERE perusahaan_id = '$perusahaan_id'")->getResult();

        echo json_encode($query);
    }

    public function getJenisAngkutanByName()
    {
        $data = $this->request->getVar();
        $jenis_angkutan = strtolower($data['jenis_angkutan']);

        $query = $this->db->query("SELECT * FROM m_jenis_angkutan WHERE lower(jenis_angkutan_name) = '$jenis_angkutan'")->getResult();

        echo json_encode($query);
    }

    public function ajaxLoadDataById()
    {
        $data = $this->request->getVar();
        $id = $data['id'];
        $query = $this->db->query("SELECT a.id, a.rampcheck_no, a.rampcheck_date, f.jenis_lokasi_name, coalesce(h.terminal_name, a.rampcheck_nama_lokasi) AS terminal_name, a.rampcheck_pengemudi, a.rampcheck_umur_pengemudi, a.rampcheck_po_name, a.rampcheck_noken, a.rampcheck_stuk, g.jenis_angkutan_name AS jenis_angkutan_name, a.rampcheck_trayek AS trayek_name,
        CAST(CONCAT('[', IF(b.rampcheck_id IS NULL, '', GROUP_CONCAT(DISTINCT JSON_OBJECT('rampcheck_adm_ku', b.rampcheck_adm_ku, 'rampcheck_adm_kpr', b.rampcheck_adm_kpr, 'rampcheck_adm_kpc', b.rampcheck_adm_kpc, 'rampcheck_adm_sim', b.rampcheck_adm_sim))),']')AS json) AS administrasi,
        CAST(CONCAT('[', IF(b.rampcheck_id IS NULL, '', GROUP_CONCAT(DISTINCT JSON_OBJECT('rampcheck_utu_lukd', d.rampcheck_utu_lukd, 'rampcheck_utu_lukj', d.rampcheck_utu_lukj, 'rampcheck_utu_lpad', d.rampcheck_utu_lpad, 'rampcheck_utu_lpaj', d.rampcheck_utu_lpaj, 'rampcheck_utu_lm', d.rampcheck_utu_lm, 'rampcheck_utu_lr', d.rampcheck_utu_lr, 'rampcheck_utu_kru', d.rampcheck_utu_kru, 'rampcheck_utu_krp', d.rampcheck_utu_krp, 'rampcheck_utu_kbd', d.rampcheck_utu_kbd, 'rampcheck_utu_kbb', d.rampcheck_utu_kbb, 'rampcheck_utu_skp', d.rampcheck_utu_skp, 'rampcheck_utu_pk', d.rampcheck_utu_pk, 'rampcheck_utu_pkw', d.rampcheck_utu_pkw, 'rampcheck_utu_pd', d.rampcheck_utu_pd, 'rampcheck_utu_jd', d.rampcheck_utu_jd, 'rampcheck_utu_apk', d.rampcheck_utu_apk, 'rampcheck_utu_apar', d.rampcheck_utu_apar))),']')AS json) AS unsur_utama,
        CAST(CONCAT('[', IF(b.rampcheck_id IS NULL, '', GROUP_CONCAT(DISTINCT JSON_OBJECT('rampcheck_utp_sp_dpn', c.rampcheck_utp_sp_dpn, 'rampcheck_utp_sp_blk', c.rampcheck_utp_sp_blk, 'rampcheck_utp_bk_kcd', c.rampcheck_utp_bk_kcd, 'rampcheck_utp_bk_pu', c.rampcheck_utp_bk_pu, 'rampcheck_utp_bk_kru', c.rampcheck_utp_bk_kru, 'rampcheck_utp_bk_krp', c.rampcheck_utp_bk_krp, 'rampcheck_utp_bk_ldt', c.rampcheck_utp_bk_ldt, 'rampcheck_utp_ktd_jtd', c.rampcheck_utp_ktd_jtd, 'rampcheck_utp_pk_bc', c.rampcheck_utp_pk_bc, 'rampcheck_utp_pk_sp', c.rampcheck_utp_pk_sp, 'rampcheck_utp_pk_dkr', c.rampcheck_utp_pk_dkr, 'rampcheck_utp_pk_pbr', c.rampcheck_utp_pk_pbr, 'rampcheck_utp_pk_ls', c.rampcheck_utp_pk_ls, 'rampcheck_utp_pk_pgr', c.rampcheck_utp_pk_pgr, 'rampcheck_utp_pk_skp', c.rampcheck_utp_pk_skp, 'rampcheck_utp_pk_ptk', c.rampcheck_utp_pk_ptk))),']')AS json) AS unsur_penunjang,
        CAST(CONCAT('[', IF(b.rampcheck_id IS NULL, '', GROUP_CONCAT(DISTINCT JSON_OBJECT('rampcheck_kesimpulan_status', e.rampcheck_kesimpulan_status, 'rampcheck_kesimpulan_catatan', e.rampcheck_kesimpulan_catatan, 'rampcheck_kesimpulan_ttd_pengemudi', e.rampcheck_kesimpulan_ttd_pengemudi, 'rampcheck_kesimpulan_nama_penguji', e.rampcheck_kesimpulan_nama_penguji, 'rampcheck_kesimpulan_no_penguji', e.rampcheck_kesimpulan_no_penguji, 'rampcheck_kesimpulan_ttd_penguji', e.rampcheck_kesimpulan_ttd_penguji, 'rampcheck_kesimpulan_nama_penyidik', e.rampcheck_kesimpulan_nama_penyidik, 'rampcheck_kesimpulan_no_penyidik', e.rampcheck_kesimpulan_no_penyidik, 'rampcheck_kesimpulan_ttd_penyidik', e.rampcheck_kesimpulan_ttd_penyidik, 'nama_pengemudi', a.rampcheck_pengemudi))),']')AS json) AS unsur_kesimpulan
        FROM t_rampcheck a
        JOIN t_rampcheck_adm b ON b.rampcheck_id = a.id
        JOIN t_rampcheck_utp c ON c.rampcheck_id = a.id
        JOIN t_rampcheck_utu d ON d.rampcheck_id = a.id
        JOIN t_rampcheck_kesimpulan e ON e.rampcheck_id = a.id
        JOIN m_jenis_lokasi f ON f.id = a.rampcheck_jenis_lokasi_id
        JOIN m_jenis_angkutan g ON g.id = a.rampcheck_jenis_angkutan_id
        LEFT JOIN m_terminal h ON h.id = a.rampcheck_nama_lokasi
        WHERE a.is_deleted = 0 AND a.id= '$id'")->getResult();
        echo json_encode($query);
    }

    public function getBptd()
    {
        $session = \Config\Services::session();
        $instansiId = $this->session->get('instansi_detail_id');

        if ($instansiId != null && $instansiId != '') {
            $paramInstansi = "AND (id = '$instansiId' or id=(select a.instansi_detail_id from m_instansi_detail a where a.id='$instansiId'))";
        } else {
            $paramInstansi = "";
        }

        if ($this->request->getVar('q')) {
            $param = $this->request->getVar('q');
        } else {
            $param = '';
        }

        $response = $this->db->query("SELECT id, instansi_detail_name as text FROM m_instansi_detail WHERE is_deleted = '0' AND instansi_detail_id = 334
         " . $paramInstansi . " AND instansi_detail_name LIKE '%$param%'")->getResult();
        echo json_encode($response);
    }

    public function getTerminal()
    {
        $iduser = $this->session->get('id');
        $instansiId = $this->session->get('instansi_detail_id');

        if ($instansiId == null || $instansiId == '') {
            if ($this->request->getVar('q')) {
                $param = $this->request->getVar('q');
            } else {
                $param = '';
            }

            $namaLokasi = $this->db->query("SELECT terminal_name AS id, terminal_name AS text FROM m_terminal
                                            WHERE is_deleted = '0' AND terminal_name LIKE '%" . $param . "%'")->getResult();
        } else {
            $provUser = $this->db->query("SELECT distinct coalesce(b.multiple_lokprov_id, b.lokprov_id) AS id_prov
                                        FROM m_user_web a
                                        LEFT JOIN m_instansi_detail b ON b.id = a.instansi_detail_id
                                        WHERE a.is_deleted = '0' AND b.is_deleted = '0'
                                        AND ( IF( POSITION(? IN b.kode)>0
                                                                        , b.kode LIKE CONCAT_WS(
                                                                            '',
                                                                            LEFT(b.kode,POSITION(? IN b.kode)+LENGTH(?)-1)
                                                                            ,'%'
                                                                            )
                                                                        ,b.kode LIKE '000%'
                                                                    )
                                                            )", array($instansiId, $instansiId, $instansiId))->getRowArray();

            if ($provUser['id_prov'] == null) {
                $paramProv = "";
            } else {
                $provUser['id_prov'] = $provUser['id_prov'];
                $paramProv = " AND api_kode_prov_dagri IN (" . $provUser['id_prov'] . ")";
            }

            if ($this->request->getVar('q')) {
                $param = $this->request->getVar('q');
            } else {
                $param = '';
            }

            $namaLokasi = $this->db->query("SELECT terminal_name AS id, terminal_name AS text FROM m_terminal
                                            WHERE is_deleted = '0' " . $paramProv . " AND terminal_name LIKE '%" . $param . "%'")->getResult();
        }

        return json_encode($namaLokasi);
    }

    public function getStatus()
    {
        $response = $this->db->query("SELECT DISTINCT rampcheck_kesimpulan_status AS id,
      CASE WHEN rampcheck_kesimpulan_status = 0 THEN 'Diijinkan Operasional'
      WHEN rampcheck_kesimpulan_status = 1 THEN 'Peringatan/Perbaiki'
      WHEN rampcheck_kesimpulan_status = 2 THEN 'Tilang dan Dilarang Operasional'
      ELSE 'Dilarang Operasional' END AS 'text'
      FROM t_rampcheck_kesimpulan WHERE is_deleted = '0'
      ORDER BY rampcheck_kesimpulan_status asc")->getResult();
        echo json_encode($response);
    }

}
