<?php

namespace App\Modules\Pomudik\Controllers;

use App\Modules\Pomudik\Models\PomudikModel;
use App\Core\BaseController;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Reader\Xls;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;
use PhpOffice\PhpSpreadsheet\Writer\Xls as WriterXls;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx as WriterXlsx;


class PomudikAction extends BaseController
{
    private $pomudikModel;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->pomudikModel = new PomudikModel();
    }

    public function index()
    {
        return redirect()->to(base_url());
    }

    // manajamenen armada mudik
    // load
    public function manarmadamudik_load()
    {
        parent::_authLoad(function () {
            $iduser = $this->session->get('id');

            $idArrUser = [$iduser];

            $cekChildUsers = $this->db->query("SELECT d.* 
                                                FROM m_user_web a
                                                JOIN m_instansi_detail b
                                                    ON a.instansi_detail_id = b.id
                                                JOIN m_instansi_detail c
                                                    ON b.id = c.instansi_detail_id
                                                JOIN m_user_web d
                                                    ON c.id = d.instansi_detail_id
                                                WHERE a.id = " . $iduser . "")->getResult();

            foreach ($cekChildUsers as $cekChildUser) {
                array_push($idArrUser, $cekChildUser->id);
            }

            $query = "SELECT a.id, a.armada_name, a.armada_plat_number, a.armada_merk, a.armada_color, b.po_name, c.class_name, d.seat_map_name
                      FROM m_armada_mudik a
                      JOIN m_po b
                        ON a.po_id = b.id 
                      JOIN m_class c
                        ON a.po_class_id = c.id
                      JOIN m_seat_map d
                        ON a.armada_sheet_id = d.id
                      WHERE a.is_deleted = 0
                      AND a.created_by IN (" . implode(',', $idArrUser) . ")
                      ";

            $where = ["a.armada_name", "a.armada_plat_number", "a.armada_merk", "b.po_name", "c.class_name"];

            parent::_loadDatatable($query, $where, $this->request->getPost());
        });
    }

    // save
    public function manarmadamudik_save()
    {
        parent::_authInsert(function () {
            $facilities_id = count($this->request->getPost('facilities_id'));

            $facilitiesData = [];
            $facilitiesDataDel = [];
            for ($i = 0; $i < $facilities_id; $i++) {
                if (unwrap_null(@$this->request->getPost('check')[$i], "0") == 1) {
                    $facilitiesData[] = [
                        "facilities_id" => unwrap_null(@$this->request->getPost('facilities_id')[$i], "0"),
                        "created_by" => $this->session->get('id')
                    ];
                } else {
                    $facilitiesDataDel[] = [
                        "facilities_id" => unwrap_null(@$this->request->getPost('facilities_id')[$i], "0"),
                        "created_by" => $this->session->get('id')
                    ];
                }
            }

            if ($this->pomudikModel->saveFasilitas($facilitiesData, $facilitiesDataDel, $this->session->get('id'), $this->request->getPost())) {
                echo json_encode(array('success' => true, 'message' => "success"));
            } else {
                echo json_encode(array('success' => false, 'message' => $this->pomudikModel->db->error()));
            }
        });
    }

    // edit
    public function manarmadamudik_edit()
    {
        parent::_authEdit(function () {
            $data = $this->request->getPost();

            $query = "select a.*, b.po_name as po_nama, c.class_name as po_class_nama, d.seat_map_name as armada_sheet_nama,
                            JSON_ARRAYAGG(
                                JSON_OBJECT (
                                    'id', e.id,
                                    'nama', e.name,
                                    'icon', e.icon,
                                    'facilities_id', e.cek_exist
                                )
                            ) as facilities,
                        a.open_at
                        from m_armada_mudik a
                        join m_po b
                        on a.po_id = b.id
                        join m_class c
                        on a.po_class_id = c.id
                        join m_seat_map d
                        on a.armada_sheet_id = d.id
                        join (
                            select a.id, a.name, a.icon, b.id as armada_mudik_fasility_id, IFNULL(b.armada_mudik_id, " . $this->request->getPost('id') . ") as armada_mudik_id, b.facilities_id as cek_exist
                                from m_facilities a
                                left join (
                                    select *
                                    from m_armada_mudik_fasilities a
                                    where a.is_deleted = 0
                                    and a.armada_mudik_id = " . $this->request->getPost('id') . "
                                ) as b
                                on a.id = b.facilities_id
                                where a.is_deleted = 0
                                order by a.id asc
                        ) e
                        on a.id = e.armada_mudik_id
                        where a.is_deleted = 0
                        and b.is_deleted = 0
                        and c.is_deleted = 0
                        and a.id = " . $this->request->getPost('id') . "
                        ";

            parent::_edit('m_armada_mudik', $data, null, $query);
        });
    }

    // delete
    public function manarmadamudik_delete()
    {
        parent::_authDelete(function () {
            parent::_delete('m_armada_mudik', $this->request->getPost());
        });
    }

    // upload
    public function manarmadamudik_upload()
    {
        $input = $this->validate([
            'file' => [
                'uploaded[file]',
                'mime_in[file,image/jpg,image/jpeg,image/png]',
                'max_size[file,1024]',
            ],
        ]);

        if (!$input) {
            print_r('Choose a valid file');
        } else {
            $x_file = $this->request->getFile('file');
            $nama_file = $x_file->getRandomName();
            $image = \Config\Services::image()
                ->withFile($x_file)
                ->resize(720, 360, true, 'width')
                ->save('public/uploads/armadamudik/' . $nama_file);

            if ($image) {
                $msg = array("status" => 1, "msg" => "File Has Been Uploaded", "path" => 'public/uploads/armadamudik/' . $nama_file);
            } else {
                $msg = array("status" => 0, "msg" => $this->upload->display_errors());
            }

            echo json_encode($msg);
        }
    }

    // manajemen jadwal
    // load
    public function manjadwalmudik_load()
    {
        parent::_authLoad(function () {
            $iduser = $this->session->get('id');

            $idArrUser = [$iduser];

            $cekChildUsers = $this->db->query("SELECT d.* 
                                                FROM m_user_web a
                                                JOIN m_instansi_detail b
                                                ON a.instansi_detail_id = b.id
                                                JOIN m_instansi_detail c
                                                ON b.id = c.instansi_detail_id
                                                JOIN m_user_web d
                                                ON c.id = d.instansi_detail_id
                                                WHERE a.id = " . $iduser . "")->getResult();

            foreach ($cekChildUsers as $cekChildUser) {
                array_push($idArrUser, $cekChildUser->id);
            }

            $query = "SELECT a.id, b.armada_name, a.jadwal_date_depart, a.jadwal_time_depart, a.jadwal_date_arrived, a.jadwal_time_arrived, c.route_name, a.open, a.jadwal_type,date_format(a.open_at,'%d-%b-%Y %H:%i:%s') as open_at
                        FROM t_jadwal_mudik a
                        LEFT JOIN m_armada_mudik b
                            ON a.jadwal_armada_id = b.id
                        LEFT JOIN m_route c
                            ON a.jadwal_route_id = c.id
                        WHERE a.is_deleted = 0
                        AND c.kategori_angkutan_id = 5
                        AND a.created_by IN (" . implode(',', $idArrUser) . ")
                        ";
            $where = ["b.armada_name", "c.route_name"];

            parent::_loadDatatable($query, $where, $this->request->getPost());
        });
    }

    // save
    public function manjadwalmudik_save()
    {
        parent::_authInsert(function () {
            if ($this->pomudikModel->saveJadwal($this->session->get('id'), $this->request->getPost())) {
                echo json_encode(array('success' => true, 'message' => "success"));
            } else {
                echo json_encode(array('success' => false, 'message' => $this->pomudikModel->db->error()));
            }
        });
    }

    // edit
    public function manjadwalmudik_edit()
    {
        parent::_authEdit(function () {
            $data = $this->request->getPost();

            $query = "SELECT a.id, a.jadwal_armada_id, a.jadwal_route_id, b.armada_name as jadwal_armada_nama, a.jadwal_date_depart, a.jadwal_time_depart, a.jadwal_date_arrived, a.jadwal_time_arrived, c.route_name as jadwal_route_nama, a.open, a.open_at,a.jadwal_type
                        FROM t_jadwal_mudik a
                        LEFT JOIN m_armada_mudik b
                            ON a.jadwal_armada_id = b.id
                        LEFT JOIN m_route c
                            ON a.jadwal_route_id = c.id
                        WHERE a.id = '" . $this->request->getPost('id') . "'
                        ";

            parent::_edit('t_jadwal_mudik', $data, null, $query);
        });
    }

    // delete
    public function manjadwalmudik_delete()
    {
        parent::_authDelete(function () {
            parent::_delete('t_jadwal_mudik', $this->request->getPost());
        });
    }

    // manajemen paguyuban
    // load
    public function manpaguyuban_load()
    {
        parent::_authLoad(function () {
            $query = "SELECT *
                        from t_paguyuban_mudik
                        where is_deleted = 0";
            $where = ["paguyuban_mudik_name"];

            parent::_loadDatatable($query, $where, $this->request->getPost());
        });
    }

    // save
    public function manpaguyuban_save()
    {
        parent::_authInsert(function () {
            parent::_insert('t_paguyuban_mudik', $this->request->getPost());
        });
    }

    // edit
    public function manpaguyuban_edit()
    {
        parent::_authEdit(function () {
            $data = $this->request->getPost();

            $query = "SELECT *
                        FROM t_paguyuban_mudik
                        WHERE id = '" . $this->request->getPost('id') . "'
                        ";

            parent::_edit('t_paguyuban_mudik', $data, null, $query);
        });
    }

    // delete
    public function manpaguyuban_delete()
    {
        parent::_authDelete(function () {
            parent::_delete('t_paguyuban_mudik', $this->request->getPost());
        });
    }

    // manajemen paguyuban mudik
    // save
     public function manpaguyubanmudik_save()
    {
        parent::_authInsert(function () {
            $data = $this->request->getPost();

            $emailBillings = [];
            for ($x = 0; $x < count($this->request->getPost('paguyuban_tempat_duduk')); $x++) {
                if($this->request->getPost('paguyuban_email' . $x) != null) {
                     // check completeness input data
                     if(empty($data['paguyuban_name'][$x]) 
                        || empty($data['paguyuban_no_wa'][$x]) 
                        || empty($data['paguyuban_no_ktp'][$x]) 
                        // || empty($data['paguyuban_no_kk'][$x]) 
                        || strlen($data['paguyuban_no_ktp'][$x]) !== 16
                    ) {
                        echo json_encode(array('success' => false, 'message' => 'Isi data dengan benar'));
                        return;
                    } else if($data['open'] == 0) {
                        // if(empty($data['paguyuban_mudik_ids' . $x])) {
                        //     echo json_encode(array('success' => false, 'message' => 'Isi data dengan benar'));
                        //     return;
                        // }
                    }

                    array_push($emailBillings, $this->request->getPost('paguyuban_email' . $x));

                    $cekPaguyubanMudik = $this->db->query("SELECT *
                                                            FROM t_billing_mudik
                                                            WHERE billing_jadwal_id = " . $data['jadwal_mudik_id'] . "
                                                            AND billing_user_id = " . $this->request->getPost('paguyuban_email' . $x) . "
                                                            AND billing_cancel = 0
                                                            ")->getRow();
                                    
                    if(!$cekPaguyubanMudik) {
                        $cekNikPaguyubanDuplicate = $this->db->query("SELECT a.*
                                                                            FROM t_billing_mudik a
                                                                            JOIN t_transaction_mudik b
                                                                                ON a.id = b.billing_id
                                                                            WHERE b.transaction_nik = " . $data['paguyuban_no_ktp'][$x] . "
                                                                            AND a.billing_cancel = 0
                                                                            ")->getRow();


                        if($cekNikPaguyubanDuplicate) {
                            // echo json_encode(array('success' => false, 'message' => 'NIK Sudah digunakan'));
                            // return;
                        }
                    }
                }
            }

            $countEmailNow = array_count_values($emailBillings);

            $quota = $this->db->query("SELECT *
                                        FROM s_config_quota_mudik
                                        WHERE config_active = 1
                                        ORDER BY id DESC")->getRow();

            $cekJadwalNow = $this->db->query("SELECT *
                                                FROM t_jadwal_mudik
                                                WHERE id = " . $this->request->getPost('jadwal_mudik_id'))->getRow();
 
            foreach($emailBillings as $emailBilling) {
                $cekQuotaBillings = $this->db->query("SELECT sum(billing_qty) as quota_on_user
                                                        FROM t_billing_mudik a
                                                        join t_jadwal_mudik b
                                                            on a.billing_jadwal_id = b.id 
                                                        WHERE a.billing_user_id = " . $emailBilling . "
                                                        AND a.billing_status_payment = 1
                                                        AND a.billing_cancel = 0
                                                        AND a.billing_status_verif = 1
                                                        AND a.billing_is_paguyuban = 1
                                                        AND b.jadwal_type = " . $cekJadwalNow->jadwal_type . "
                                                        GROUP BY billing_user_id")->getRow();

                $cekQuotaUserOnJadwalChoose = $this->db->query("SELECT b.billing_qty
                                                                    FROM t_jadwal_mudik a
                                                                    join t_billing_mudik b
                                                                        on a.id = b.billing_jadwal_id
                                                                    where a.id = " . $this->request->getPost('jadwal_mudik_id') . "
                                                                    and billing_user_id = " . $emailBilling)->getRow();

                if($cekQuotaUserOnJadwalChoose) {
                    $beforeCountEmailNow = $cekQuotaUserOnJadwalChoose->billing_qty;
                } else {
                    $beforeCountEmailNow = 0;
                }

                if($cekQuotaBillings) {
                    $quotaBilling = $cekQuotaBillings->quota_on_user;
                } else {
                    $quotaBilling = 0;
                }

                if($countEmailNow[$emailBilling] - $beforeCountEmailNow + $quotaBilling> $quota->config_quota) {
                    $emailMobile = $this->db->query("SELECT * 
                                                        FROM m_user_mobile
                                                        WHERE id = " . $emailBilling)->getRow();

                    // echo json_encode(array('success' => false, 'message' => 'Email ' . $emailMobile->user_mobile_email . ' sudah melebihi kuota mudik'));
                    // return;  
                }
            }

            if ($this->pomudikModel->savePaguyuban($this->session->get('id'), $this->request->getPost())) {
                echo json_encode(array('success' => true, 'message' => "success"));
            } else {
                echo json_encode(array('success' => false, 'message' => $this->pomudikModel->db->error()));
            }
        });
    }

    // public function verifikasimudik_load()
    // {
    //     parent::_authLoad(function () {

    //         if ($_POST["filter"][0] == '1') {
    //             $query = "SELECT a.id, a.transaction_booking_name, a.transaction_nik, a.transaction_number, a.billing_code, a.transaction_seat_id, a.is_verified,
    //                         CASE WHEN a.is_verified = '1' THEN 'Terverifikasi' END AS is_verified
    //                         FROM t_transaction_mudik a
    //                         WHERE a.is_verified = '1'";
    //         } else if ($_POST["filter"][0] == '2') {
    //             $query = "SELECT a.id, a.transaction_booking_name, a.transaction_nik, a.transaction_number, a.billing_code, a.transaction_seat_id, a.is_verified,
    //                         CASE WHEN a.is_verified = '2' THEN 'Ditolak' END AS is_verified
    //                         FROM t_transaction_mudik a
    //                         WHERE a.is_verified = '2'";
    //         } else {
    //             $query = "SELECT a.id, a.transaction_booking_name, a.transaction_nik, a.transaction_number, a.billing_code, a.transaction_seat_id, a.is_verified,
    //                         CASE WHEN a.is_verified = '0' THEN 'Belum Verifikasi' END AS is_verified
    //                         FROM t_transaction_mudik a
    //                         WHERE a.is_verified = '0'";
    //         }
    //         $where = ["a.id", "a.transaction_booking_name", "a.transaction_nik", "a.transaction_number", "a.billing_code", "a.transaction_seat_id", "a.is_verified"];
    //         parent::_loadDatatable($query, $where, $this->request->getPost());
    //     });
    // }
    public function verifikasimudik_load()
    {
        parent::_authLoad(function () {

            if ($_POST["filter"][0] == '1') {
                $query = "SELECT a.id, a.transaction_booking_name, a.transaction_nik, a.transaction_number, a.billing_code, a.is_verified, c.jadwal_type, b.seat_map_detail_name,
                            CASE WHEN c.jadwal_type = '1' THEN 'Arus Mudik' 
                            WHEN c.jadwal_type = '2' THEN 'Arus Balik' END AS jadwal_type,
                            CASE WHEN a.is_verified = '1' THEN 'Terverifikasi' END AS is_verified
                            FROM t_transaction_mudik a
        	                LEFT JOIN t_jadwal_seat_mudik b ON b.id = a.transaction_seat_id
        	                LEFT JOIN t_jadwal_mudik c ON c.id = b.jadwal_id
                            WHERE a.is_verified = '1'";

            // } else if ($_POST["filter"][0] == '3') {
            //     $query = "SELECT a.id, a.transaction_booking_name, a.transaction_nik, a.transaction_number, a.billing_code, a.is_verified, c.jadwal_type, b.seat_map_detail_name,
            //                 CASE WHEN c.jadwal_type = '1' THEN 'Arus Mudik' 
            //                 WHEN c.jadwal_type = '2' THEN 'Arus Balik' END AS jadwal_type,
            //                 CASE WHEN a.is_verified = '1' THEN 'Terverifikasi' END AS is_verified
            //                 FROM t_transaction_mudik a
        	//                 LEFT JOIN t_jadwal_seat_mudik b ON b.id = a.transaction_seat_id
        	//                 LEFT JOIN t_jadwal_mudik c ON c.id = b.jadwal_id
            //                 WHERE a.is_verified = '1' AND c.jadwal_type = '1'";

            // } else if ($_POST["filter"][0] == '4') {
            //     $query = "SELECT a.id, a.transaction_booking_name, a.transaction_nik, a.transaction_number, a.billing_code, a.is_verified, c.jadwal_type, b.seat_map_detail_name,
            //                 CASE WHEN c.jadwal_type = '1' THEN 'Arus Mudik' 
            //                 WHEN c.jadwal_type = '2' THEN 'Arus Balik' END AS jadwal_type,
            //                 CASE WHEN a.is_verified = '1' THEN 'Terverifikasi' END AS is_verified
            //                 FROM t_transaction_mudik a
        	//                 LEFT JOIN t_jadwal_seat_mudik b ON b.id = a.transaction_seat_id
        	//                 LEFT JOIN t_jadwal_mudik c ON c.id = b.jadwal_id
            //                 WHERE a.is_verified = '1' AND c.jadwal_type = '2'";

            // } else if ($_POST["filter"][0] == '3') {
            //     $query = "SELECT a.id, a.transaction_booking_name, a.transaction_nik, a.transaction_number, a.billing_code, a.is_verified, c.jadwal_type, b.seat_map_detail_name,
            //                 CASE WHEN c.jadwal_type = '1' THEN 'Arus Mudik' 
            //                 WHEN c.jadwal_type = '2' THEN 'Arus Balik' END AS jadwal_type,
            //                 CASE WHEN a.is_verified = '1' THEN 'Terverifikasi' END AS is_verified
            //                 FROM t_transaction_mudik a
        	//                 LEFT JOIN t_jadwal_seat_mudik b ON b.id = a.transaction_seat_id
        	//                 LEFT JOIN t_jadwal_mudik c ON c.id = b.jadwal_id
            //                 WHERE a.is_verified = '0' AND c.jadwal_type = '1'";

            // } else if ($_POST["filter"][0] == '4') {
            //     $query = "SELECT a.id, a.transaction_booking_name, a.transaction_nik, a.transaction_number, a.billing_code, a.is_verified, c.jadwal_type, b.seat_map_detail_name,
            //                 CASE WHEN c.jadwal_type = '1' THEN 'Arus Mudik' 
            //                 WHEN c.jadwal_type = '2' THEN 'Arus Balik' END AS jadwal_type,
            //                 CASE WHEN a.is_verified = '1' THEN 'Terverifikasi' END AS is_verified
            //                 FROM t_transaction_mudik a
        	//                 LEFT JOIN t_jadwal_seat_mudik b ON b.id = a.transaction_seat_id
        	//                 LEFT JOIN t_jadwal_mudik c ON c.id = b.jadwal_id
            //                 WHERE a.is_verified = '0' AND c.jadwal_type = '2'";

            } else if ($_POST["filter"][0] == '2') {
                $query = "SELECT a.id, a.transaction_booking_name, a.transaction_nik, a.transaction_number, a.billing_code, a.is_verified, c.jadwal_type, b.seat_map_detail_name,
                             CASE WHEN c.jadwal_type = '1' THEN 'Arus Mudik' 
                            WHEN c.jadwal_type = '2' THEN 'Arus Balik' END AS jadwal_type,
                            CASE WHEN a.is_verified = '2' THEN 'Ditolak' END AS is_verified
                            FROM t_transaction_mudik a
        	                LEFT JOIN t_jadwal_seat_mudik b ON b.id = a.transaction_seat_id
        	                LEFT JOIN t_jadwal_mudik c ON c.id = b.jadwal_id
                            WHERE a.is_verified = '2' OR c.jadwal_type = '2'";
                            
            } else {
                $query = "SELECT a.id, a.transaction_booking_name, a.transaction_nik, a.transaction_number, a.billing_code,  a.is_verified, c.jadwal_type, b.seat_map_detail_name, 
                             CASE WHEN c.jadwal_type = '1' THEN 'Arus Mudik' 
                                    WHEN c.jadwal_type = '2' THEN 'Arus Balik' END AS jadwal_type,
                            CASE WHEN a.is_verified = '0' THEN 'Belum Verifikasi' END AS is_verified
                            FROM t_transaction_mudik a
        	                LEFT JOIN t_jadwal_seat_mudik b ON b.id = a.transaction_seat_id
        	                LEFT JOIN t_jadwal_mudik c ON c.id = b.jadwal_id
                            LEFT JOIN t_billing_mudik d ON d.id = a.billing_id
                            WHERE a.is_verified = '0' and d.billing_cancel = 0 ";
            }
            $where = ["a.id", "a.transaction_booking_name", "a.transaction_nik", "a.transaction_number", "a.billing_code",  "a.is_verified", "c.jadwal_type"];
            parent::_loadDatatable($query, $where, $this->request->getPost());
        });
    }

    // public function verifikasimudik_save()
    // {
    //     $data = $this->request->getPost();
    //     if ($data['id'] != null) {
    //         $id = $this->request->getPost('id');
    //         $name = $this->request->getPost('transaction_booking_name');
    //         $nik = $this->request->getPost('transaction_nik');
    //         $transaction_number = $this->request->getPost('transaction_number');
    //         $verified_by = $this->session->get('id');
    //         $verified_date = date('Y-m-d H:i:s');
    //         // if id is already verified
    //         $q1 = "SELECT * from t_transaction_mudik where id = '" . $id . "' AND is_verified = '1' AND transaction_number ='" . $transaction_number . "'";
    //         if ($this->db->query($q1)->getResult()) {
    //             echo json_encode(array('success' => 2, 'message' => "Tiket Sudah di Verifikasi"));
    //         } else {
    //             // $q2 = "SELECT * from t_transaction_mudik where transaction_nik = '" . $nik . "' AND is_verified = '1' AND transaction_number ='" . $transaction_number . "'";
    //             $update = $this->db->query('UPDATE t_transaction_mudik SET is_verified = "1", verified_by = "' . $verified_by . '", verified_at = NOW(), transaction_booking_name = "' . $name . '" , transaction_nik = "' . $nik . '" WHERE id = "' . $id . '"');
    //             // $update = $this->db->query('UPDATE t_transaction_mudik SET is_verified = "1", verified_by = "' . $verified_by . '", verified_at = NOW() WHERE id = "' . $id . '"');
    //             if ($update) {
    //                 $where = "SELECT billing_code FROM t_transaction_mudik WHERE sha1(sha1(transaction_number)) = '" . $transaction_number . "'";
    //                 $getdata = $this->db->query("SELECT
    //                                 a.*, g.po_name, f.armada_name, e.route_name, e.route_from, e.route_to, c.seat_map_detail_name, h.user_web_name, DATE_FORMAT(a.verified_at, '%d-%m-%Y') AS verified_at_tanggal
    //                                 FROM t_transaction_mudik a
    //                                 LEFT JOIN t_billing_mudik b ON b.id = a.billing_id
    //                                 LEFT JOIN t_jadwal_seat_mudik c ON c.id = a.transaction_seat_id
    //                                 LEFT JOIN t_jadwal_mudik d ON d.id = c.jadwal_id
    //                                 LEFT JOIN m_route e ON e.id = d.jadwal_route_id
    //                                 LEFT JOIN m_armada_mudik f ON f.id = d.jadwal_armada_id
    //                                 left JOIN m_po g ON g.id = f.po_id
    //                                 JOIN m_user_web h on h.id = a.verified_by
    //                                 WHERE a.billing_code = (" . $where . ") OR a.id = '" . $id . "'");
    //                 echo json_encode(array('success' => 1, 'message' => "Tiket Mudik Berhasil di Verifikasi", 'data' => $getdata->getResult()));
    //             } else {
    //                 echo json_encode(array('success' => 3, 'message' => "Gagal Verifikasi Tiket Mudik"));
    //             }
    //         }
    //     } else {
    //         echo json_encode(array('success' => false, 'message' => "Gagal verifikasi tiket mudik tidak valid"));
    //     }
    // }

    public function verifikasimudik_save()
    {
        $data = $this->request->getPost();
        if ($data['id'] != null) {
            $id = $this->request->getPost('id');
            $name = $this->request->getPost('transaction_booking_name');
            $nik = $this->request->getPost('transaction_nik');
            $transaction_number = $this->request->getPost('transaction_number');
            $verified_by = $this->session->get('id');
            $verified_date = date('Y-m-d H:i:s');
            
            $trx_mudik = $this->db->query("SELECT a.billing_code, a.transaction_number, a.transaction_nik, a.is_verified, c.jadwal_type
                                            FROM t_transaction_mudik a 
                                            LEFT JOIN t_billing_mudik b ON a.billing_code = b.billing_code
                                            LEFT JOIN t_jadwal_mudik c ON b.billing_jadwal_id = c.id
                                            WHERE a.id = '".$id."'")->getRow();

            if ($trx_mudik) {
                $transaction_nik = $trx_mudik->transaction_nik;
                $jadwal_type = $trx_mudik->jadwal_type;
                $is_verified = $trx_mudik->is_verified;

                if ($is_verified == 0) {
                    $check_double_nik_jadwal_type = $this->db->query("SELECT a.billing_code, a.transaction_number, a.transaction_nik, a.is_verified, c.jadwal_type
                                                                    FROM t_transaction_mudik a 
                                                                    LEFT JOIN t_billing_mudik b ON a.billing_code = b.billing_code
                                                                    LEFT JOIN t_jadwal_mudik c ON b.billing_jadwal_id = c.id
                                                                    WHERE a.transaction_nik = '".$transaction_nik."'
                                                                        AND c.jadwal_type = ".$jadwal_type."
                                                                        AND a.is_verified = 1");

                    if ($check_double_nik_jadwal_type->getNumRows() == 0) {
                        $update = $this->db->query('UPDATE t_transaction_mudik SET is_verified = "1", verified_by = "' . $verified_by . '", verified_at = NOW() WHERE id = "' . $id . '"');
                        // print_r($this->db->getLastQuery());

                        if ($update) {
                            $where = "SELECT billing_code FROM t_transaction_mudik WHERE sha1(sha1(transaction_number)) = '" . $transaction_number . "'";
                            $getdata = $this->db->query("SELECT
                                            a.*, g.po_name, f.armada_name, e.route_name, e.route_from, e.route_to, c.seat_map_detail_name, h.user_web_name, DATE_FORMAT(a.verified_at, '%d-%m-%Y') AS verified_at_tanggal
                                            FROM t_transaction_mudik a
                                            LEFT JOIN t_billing_mudik b ON b.id = a.billing_id
                                            LEFT JOIN t_jadwal_seat_mudik c ON c.id = a.transaction_seat_id
                                            LEFT JOIN t_jadwal_mudik d ON d.id = c.jadwal_id
                                            LEFT JOIN m_route e ON e.id = d.jadwal_route_id
                                            LEFT JOIN m_armada_mudik f ON f.id = d.jadwal_armada_id
                                            left JOIN m_po g ON g.id = f.po_id
                                            JOIN m_user_web h on h.id = a.verified_by
                                            WHERE a.billing_code = (" . $where . ") OR a.id = '" . $id . "'");
                            echo json_encode(array('success' => 1, 'message' => "Tiket Mudik Berhasil di Verifikasi", 'data' => $getdata->getResult()));
                        } else {
                            echo json_encode(array('success' => 2, 'message' => "Gagal Verifikasi Tiket Mudik"));
                        }
                    } else {
                        echo json_encode(array('success' => 2, 'message' => "NIK ".$transaction_nik." sudah memiliki tiket yang di verifikasi"));
                    }
                } else if ($is_verified == 1){
                    echo json_encode(array('success' => 2, 'message' => "Tiket Sudah di Verifikasi"));
                } else {
                    echo json_encode(array('success' => 2, 'message' => "Gagal verifikasi tiket mudik, tiket sudah di tolak"));
                }
            } else {
                echo json_encode(array('success' => 2, 'message' => "Gagal verifikasi tiket mudik tidak ditemukan"));
            }
        } else {
            echo json_encode(array('success' => 2, 'message' => "Gagal verifikasi tiket mudik tidak valid"));
        }
    }

    // public function verifikasimudik_unverif()
    // {
    //     $data = $this->request->getPost();
    //     $verified_by = $this->session->get('id');
    //     $verified_date = date('Y-m-d H:i:s');
    //     $update = $this->db->query('UPDATE t_transaction_mudik SET is_verified = "2",transaction_seat_id=NULL, reject_verified_reason = "' . $data['reject_verified_reason'] . '", verified_by = "' . $verified_by . '", verified_at = "' . $verified_date . '" WHERE id = "' . $data['id'] . '"');
    //     if ($update) {
    //         echo json_encode(array('success' => true, 'message' => "komentar  berhasil Verifikasi"));
    //     } else {
    //         echo json_encode(array('success' => false, 'message' => "Gagal Verifikasi Tiket Mudik"));
    //     }
    // }

    public function verifikasimudik_unverif()
    {
        $data = $this->request->getPost();
        $verified_by = $this->session->get('id');
        $verified_date = date('Y-m-d H:i:s');
        $update = $this->db->query('UPDATE t_transaction_mudik SET is_verified = "2",transaction_seat_id=NULL, reject_verified_reason = "' . $data['reject_verified_reason'] . '", verified_by = "' . $verified_by . '", verified_at = NOW() WHERE id = "' . $data['id'] . '"');
        if ($update) {
            $transaction_data = $this->db->query('select id,billing_code,transaction_nik,transaction_number from t_transaction_mudik where id = "' . $data['id'] . '"')->getRow();
            $billing_code = $transaction_data->billing_code;
            $transaction_number = $transaction_data->transaction_number;
            $id = $transaction_data->id;
            $nik = $transaction_data->transaction_nik;

            $result = $this->db->query('SELECT b.jadwal_type FROM t_billing_mudik a
                            INNER JOIN t_jadwal_mudik b
                                ON a.billing_jadwal_id = b.id
                            WHERE a.billing_code = "' . $billing_code . '"')->getRow();

            if ($result) {
                $is_mudik = $result->jadwal_type;
                if ($is_mudik = 1) {
                    $update_balik = $this->db->query('UPDATE t_billing_mudik a
                    INNER JOIN t_jadwal_mudik b
                        ON a.billing_jadwal_id = b.id
                    RIGHT JOIN t_transaction_mudik c
                        ON c.billing_code = a.billing_code
                    SET c.transaction_seat_id = NULL, c.is_verified = 2, c.verified_at = NOW() ,c.reject_verified_reason = "Ditolak oleh sistem", c.verified_by = "' . $verified_by . '"
                    where a.billing_user_id = (select billing_user_id from t_billing_mudik where billing_code = "' . $billing_code . '")
                    and b.jadwal_type = 2 and c.is_verified = 0 and c.transaction_nik = "' . $nik . '"');
                    $where = "SELECT billing_code FROM t_transaction_mudik WHERE sha1(sha1(transaction_number)) = '" . $transaction_number . "'";
                    $getdata = $this->db->query("SELECT
                                    a.*, g.po_name, f.armada_name, e.route_name, e.route_from, e.route_to, c.seat_map_detail_name, h.user_web_name, DATE_FORMAT(a.verified_at, '%d-%m-%Y') AS verified_at_tanggal
                                    FROM t_transaction_mudik a
                                    LEFT JOIN t_billing_mudik b ON b.id = a.billing_id
                                    LEFT JOIN t_jadwal_seat_mudik c ON c.id = a.transaction_seat_id
                                    LEFT JOIN t_jadwal_mudik d ON d.id = c.jadwal_id
                                    LEFT JOIN m_route e ON e.id = d.jadwal_route_id
                                    LEFT JOIN m_armada_mudik f ON f.id = d.jadwal_armada_id
                                    left JOIN m_po g ON g.id = f.po_id
                                    JOIN m_user_web h on h.id = a.verified_by
                                    WHERE a.billing_code = (" . $where . ") OR a.id = '" . $id . "'");
                    if ($update_balik) {
                        echo json_encode(array('success' => true, 'message' => 'NIK : ' . $nik . ', Tiket Mudik dan Balik Berhasil Dibatalkan', 'data' => $getdata->getResult()));
                    } else {
                        echo json_encode(array('success' => true, 'message' => 'NIK : ' . $nik . ', Tiket Mudik Berhasil Dibatalkan'));
                    }
                } else {
                    echo json_encode(array('success' => true, 'message' => 'NIK : ' . $nik . ', Tiket Arus Balik Berhasil Dibatalkan'));
                }
            }
        } else {
            echo json_encode(array('success' => false, 'message' => "Gagal Verifikasi Tiket Mudik"));
        }
    }


    public function verifikasimudik_edit()
    {
        // $data = $this->request->getPost();
        // $query = "SELECT a.*, g.po_name, f.armada_name, e.route_name, e.route_from, e.route_to, c.seat_map_detail_name
        // FROM t_transaction_mudik a
        // JOIN t_billing_mudik b ON b.id = a.billing_id
        // JOIN t_jadwal_seat_mudik c ON c.id = a.transaction_seat_id
        // JOIN t_jadwal_mudik d ON d.id = c.jadwal_id
        // JOIN m_route e ON e.id = d.jadwal_route_id
        // JOIN m_armada_mudik f ON f.id = d.jadwal_armada_id
        // JOIN m_po g ON g.id = f.po_id
        // WHERE b.billing_code = (SELECT billing_code FROM t_billing_mudik WHERE id = (SELECT billing_id FROM t_transaction_mudik WHERE sha1(sha1(transaction_number)) = '" . $data['transaction_number'] . "'))";
        // $result = $this->db->query($query)->getRow();

        $data = $this->request->getPost();
        $query = "SELECT
	    a.*,b.billing_verif_expired_date, g.po_name, f.armada_name, e.route_name, h.user_web_name, DATE_FORMAT(a.verified_at, '%d-%m-%Y') AS verified_at_tanggal,
        CASE WHEN e.route_from IS NULL THEN 'Ditolak' ELSE e.route_from END AS route_from,
	    CASE WHEN e.route_to IS NULL THEN 'Ditolak' ELSE e.route_to END AS route_to,
	    CASE WHEN c.seat_map_detail_name IS NULL THEN 'Ditolak' ELSE c.seat_map_detail_name END AS seat_map_detail_name
        FROM t_transaction_mudik a
	    LEFT JOIN t_billing_mudik b ON b.id = a.billing_id
        LEFT JOIN t_jadwal_seat_mudik c ON c.id = a.transaction_seat_id
        LEFT JOIN t_jadwal_mudik d ON d.id = c.jadwal_id
        LEFT JOIN m_route e ON e.id = d.jadwal_route_id
        LEFT JOIN m_armada_mudik f ON f.id = d.jadwal_armada_id
        LEFT JOIN m_po g ON g.id = f.po_id
        LEFT JOIN m_user_web h on h.id = a.verified_by
        WHERE a.billing_code = (SELECT billing_code FROM t_transaction_mudik WHERE sha1(sha1(transaction_number)) = '" . $data['transaction_number'] . "')";
        // print_r($this->db->getLastQuery());
        // die();
        $result = $this->db->query($query)->getResult();
        if ($result) {
            echo json_encode(array('success' => true, 'data' => $result));
        } else {
            echo json_encode(array('success' => false, 'data' => $this->db->error()));
        }
    }

    public function verifikasipesertamudik_load()
    {
        parent::_authLoad(function () {
            $query = "SELECT a.id, a.transaction_booking_name, a.transaction_nik, a.transaction_number, a.billing_code, a.transaction_seat_id
                    FROM t_transaction_mudik a
                    WHERE a.is_verified = '1' and a.is_boarding = '1'";
            $where = ["a.id", "a.transaction_booking_name", "a.transaction_nik", "a.transaction_number", "a.billing_code", "a.transaction_seat_id"];
            parent::_loadDatatable($query, $where, $this->request->getPost());
        });
    }

    public function verifikasipesertamudik_save()
    {
        $data = $this->request->getPost();
        if ($data['id'] != null) {
            $id = $this->request->getPost('id');
            $verified_by = $this->session->get('id');
            $verified_date = date('Y-m-d H:i:s');
            // if id is already verified

            $q1 = "SELECT * from t_transaction_mudik where id = '" . $id . "' AND is_boarding = '1'";
            if ($this->db->query($q1)->getResult()) {
                echo json_encode(array('success' => 2, 'message' => "Tiket Sudah di Verifikasi"));
            } else {
                $update = $this->db->query('UPDATE t_transaction_mudik SET is_boarding = "1", boarding_by = "' . $verified_by . '", boarding_at = NOW() WHERE id = "' . $id . '"');
                if ($update) {
                    echo json_encode(array('success' => 1, 'message' => "Tiket Mudik Berhasil di Verifikasi"));
                } else {
                    echo json_encode(array('success' => 3, 'message' => "Gagal Verifikasi Tiket Mudik"));
                }
            }
        } else {
            echo json_encode(array('success' => false, 'message' => "Gagal verifikasi tiket mudik tidak valid"));
        }
    }

    public function pdf()
    {
        $url = uri_segment("3");

        $ipaddress = $this->request->getIPAddress();
        $user = $this->session->get('name');

        $url_export = $url . '_export';
        $filter = $_GET['search'];
        $data['data_url'] = uri_segment("2");
        $data['data_excel'] = $this->pomudikModel->export_view($url_export, $filter);
        // print_r($this->db->getLastQuery());


        $html = view('App\Modules\Pomudik\Views\export\\' . $url . '_export', $data);

        $mpdf = new \Mpdf\Mpdf(['setAutoTopMargin' => 'stretch', 'setAutoBottomMargin' => 'stretch', 'format' => [100, 210]]);

        $mpdf->AddPage(
            'L',
            '',
            '',
            '',
            '',
            8, // margin_left
            10, // margin right
            35, // margin top
            5, // margin bottom
            90, // margin header
            10
        ); // margin footer

        // template background pdf
        // $pagecount = $mpdf->SetSourceFile('assets/verifikasi.pdf');
        // $tplIdx = $mpdf->ImportPage($pagecount);

        // $mpdf->useTemplate($tplIdx);
        $mpdf->WriteHTML($html);
        $this->response->setHeader('Content-Type', 'application/pdf');
        $mpdf->Output($url . '-' . date('d-m-Y H:i:s') . '.pdf', 'I');
    }
    public function pdfcetak()
    {
        $url = uri_segment("3"); // verifikasimudikcetak
        // print_r($_GET['search']);
        // die();
        $ipaddress = $this->request->getIPAddress();
        $user = $this->session->get('name');

        $url_export = $url . '_export';
        $filter = $_GET['search'];
        $data['data_url'] = uri_segment("2");
        $data['data_excel'] = $this->pomudikModel->export_view($url_export, $filter);
        // print_r($data['data_excel']);
        // die();

        $html = view('App\Modules\Pomudik\Views\export\\' . $url . '_export', $data);

        $mpdf = new \Mpdf\Mpdf(['setAutoTopMargin' => 'stretch', 'setAutoBottomMargin' => 'stretch', 'format' => [297, 210]]);

        $mpdf->AddPage(
            'L',
            '',
            '',
            '',
            '',
            8, // margin_left
            10, // margin right
            10, // margin top
            5, // margin bottom
            90, // margin header
            10
        ); // margin footer

        $mpdf->WriteHTML($html);
        $this->response->setHeader('Content-Type', 'application/pdf');
        $mpdf->Output($url . '-' . date('d-m-Y H:i:s') . '.pdf', 'I');
    }

    public function verifikasipesertamudik_edit()
    {
        $data = $this->request->getPost();
        $query = "SELECT a.*
        FROM t_transaction_mudik a
        where sha1(sha1(a.transaction_number)) = '" . $data['transaction_number'] . "'";
        $result = $this->db->query($query)->getRow();
        if ($result) {
            echo json_encode(array('success' => true, 'data' => $result));
        } else {
            echo json_encode(array('success' => false, 'data' => $this->db->error()));
        }
    }


    public function verifikasikendaraanmudik_load()
    {
        parent::_authLoad(function () {
            if ($_POST["filter"][0] == '1') {
                $query = "SELECT a.id, a.motis_user_id, a.motis_armada_id, a.motis_code, b.no_kendaraan, b.jenis_kendaraan, b.no_stnk_kendaraan, a.motis_status_boarding, b.nik_pendaftar_kendaraan, a.motis_status_verif, c.id as armada_id,c.armada_name,c.armada_code,
                            CASE WHEN a.motis_status_verif = '1' THEN 'Terverifikasi' END AS motis_status_verif
                           FROM t_billing_motis_mudik a
                           LEFT JOIN t_motis_manifest_mudik b ON b.motis_billing_code = a.motis_code 
                           LEFT JOIN m_armada_motis_mudik c ON c.id = a.motis_armada_id
                            WHERE a.motis_status_verif = '1'";
            } else if ($_POST["filter"][0] == '2') {
                $query = "SELECT a.id, a.motis_user_id, a.motis_armada_id, a.motis_code, b.no_kendaraan, b.jenis_kendaraan, b.no_stnk_kendaraan, a.motis_status_boarding, b.nik_pendaftar_kendaraan, a.motis_status_verif, c.id as armada_id,c.armada_name,c.armada_code,
                           CASE WHEN a.motis_status_verif = '2' THEN 'Ditolak' END AS motis_status_verif
                           FROM t_billing_motis_mudik a
                           LEFT JOIN t_motis_manifest_mudik b ON b.motis_billing_code = a.motis_code 
                           LEFT JOIN m_armada_motis_mudik c ON c.id = a.motis_armada_id
                           WHERE a.motis_status_verif = '2'";
            } else {
                $query = "SELECT a.id, a.motis_user_id, a.motis_armada_id, a.motis_code, b.no_kendaraan, b.jenis_kendaraan, b.no_stnk_kendaraan, a.motis_status_boarding, b.nik_pendaftar_kendaraan, a.motis_status_verif, c.id as armada_id,c.armada_name,c.armada_code,
                            CASE WHEN a.motis_status_verif = '0' THEN 'Belum Verifikasi' END AS motis_status_verif
                            FROM t_billing_motis_mudik a
                            LEFT JOIN t_motis_manifest_mudik b ON b.motis_billing_code = a.motis_code 
                            LEFT JOIN m_armada_motis_mudik c ON c.id = a.motis_armada_id
                            WHERE a.motis_status_verif = '0'";
            }

            $where = ["a.id", "a.motis_code", "a.motis_status_verif", "b.nik_pendaftar_kendaraan", "b.no_kendaraan", "b.jenis_kendaraan", "b.no_stnk_kendaraan", "c.armada_id", "c.armada_name", "c.armada_code"];
            parent::_loadDatatable($query, $where, $this->request->getPost());
        });
    }


    // public function verifikasikendaraanmudik_edit()
    // {
    //     $data = $this->request->getPost();
    //     $query =
    //     " SELECT a.id, a.motis_user_id, a.motis_code, b.no_kendaraan, b.jenis_kendaraan, b.no_stnk_kendaraan, a.motis_status_boarding, b.nik_pendaftar_kendaraan, a.motis_status_verif
    //     FROM t_billing_motis_mudik a
    //     JOIN t_motis_manifest_mudik b ON b.motis_billing_code = a.motis_code 
    //     WHERE sha1(sha1(a.motis_code)) = '" . $data['motis_code'] . "'";

    //     $result = $this->db->query($query)->getRow();
    //     if ($result) {
    //         echo json_encode(array('success' => true, 'data' => $result));
    //     } else {
    //         echo json_encode(array('success' => false, 'data' => $this->db->error()));
    //     }
    // }

   

    public function verifikasikendaraanmudik_edit()
    {
        $data = $this->request->getPost();
        $check = " SELECT a.motis_status_verif
        FROM t_billing_motis_mudik a
        WHERE sha1(sha1(a.motis_code)) = '" . $data['motis_code'] . "'";
        if ($this->db->query($check)->getRow()->motis_status_verif == 1) {
            // $query = "SELECT a.id, a.motis_user_id, a.motis_code, b.no_kendaraan, b.jenis_kendaraan, b.no_stnk_kendaraan, a.motis_status_boarding, b.nik_pendaftar_kendaraan, a.motis_status_verif,c.id as armada_id,c.armada_name,c.armada_code
            //             FROM t_billing_motis_mudik a
            //             LEFT JOIN t_motis_manifest_mudik b ON b.motis_billing_code = a.motis_code 
            //             LEFT JOIN m_armada_motis_mudik c ON c.id = a.motis_armada_id
            //             WHERE sha1(sha1(a.motis_code)) = '" . $data['motis_code'] . "'";
            $query = "SELECT a.id, a.motis_user_id, a.motis_code, b.no_kendaraan, b.jenis_kendaraan, b.no_stnk_kendaraan, b.nama_pemilik_kendaraan, b.foto_kendaraan, b.foto_stnk, b.foto_ktp, a.motis_status_boarding, b.nik_pendaftar_kendaraan, a.motis_status_verif, c.id AS armada_id,c.armada_name,c.armada_code, e.route_from, e.route_to, a.motis_verif_expired_date, d.id AS id_jadwal
                        FROM t_billing_motis_mudik a
                        JOIN t_motis_manifest_mudik b ON b.motis_billing_code = a.motis_code 
                        JOIN m_armada_motis_mudik c ON c.id = a.motis_armada_id
                        LEFT JOIN t_jadwal_motis_mudik d ON d.id = a.motis_jadwal_id
                        LEFT JOIN m_route e ON e.id = d.jadwal_route_id
                        WHERE sha1(sha1(a.motis_code)) = '" . $data['motis_code'] . "'";
        } else {
            // $query = " SELECT a.id, a.motis_user_id, a.motis_code, b.no_kendaraan, b.jenis_kendaraan, b.no_stnk_kendaraan, a.motis_status_boarding, b.nik_pendaftar_kendaraan, a.motis_status_verif
            //             FROM t_billing_motis_mudik a
            //             LEFT JOIN t_motis_manifest_mudik b ON b.motis_billing_code = a.motis_code 
            //             WHERE sha1(sha1(a.motis_code)) = '" . $data['motis_code'] . "'";
            $query = " SELECT a.id, a.motis_verif_expired_date, a.motis_user_id, a.motis_code, b.no_kendaraan, b.jenis_kendaraan, b.no_stnk_kendaraan, b.nama_pemilik_kendaraan, a.motis_status_boarding, b.nik_pendaftar_kendaraan, a.motis_status_verif, b.foto_kendaraan, b.foto_stnk, b.foto_ktp, d.route_from, d.route_to, a.motis_verif_expired_date, c.id AS id_jadwal
                        FROM t_billing_motis_mudik a
                        JOIN t_motis_manifest_mudik b ON b.motis_billing_code = a.motis_code 
                        LEFT JOIN t_jadwal_motis_mudik c ON c.id = a.motis_jadwal_id
                        LEFT JOIN m_route d ON d.id = c.jadwal_route_id
                        WHERE sha1(sha1(a.motis_code)) = '" . $data['motis_code'] . "'";
        }

        $result = $this->db->query($query)->getRow();
        if ($result) {
            echo json_encode(array('success' => true, 'data' => $result));
        } else {
            echo json_encode(array('success' => false, 'data' => $this->db->error()));
        }
    }

    public function verifikasikendaraanmudik_unverif()
    {
        $data = $this->request->getPost();
        $verified_date = date('Y-m-d H:i:s');
        $update = $this->db->query('UPDATE t_billing_motis_mudik SET motis_status_verif = "2", reject_verified_reason = "' . $data['reject_verified_reason'] . '", motis_date_verif = NOW() WHERE id = "' . $data['id'] . '"');
        if ($update) {
            $transaction_data = $this->db->query('SELECT motis_code, motis_user_id, jadwal_type 
                                        FROM t_billing_motis_mudik a
                                        LEFT JOIN t_jadwal_motis_mudik b
                                            ON a.motis_jadwal_id = b.id
                                        WHERE a.id = "' . $data['id'] . '"')->getRow();

            if ($transaction_data) {
                $billing_code = $transaction_data->motis_code;
                $is_mudik = $transaction_data->jadwal_type;
                $motis_user_id = $transaction_data->motis_user_id;

                if ($is_mudik = 1) {
                    $update_balik = $this->db->query('
                        UPDATE t_billing_motis_mudik a
                        LEFT JOIN t_jadwal_motis_mudik b
                        ON a.motis_jadwal_id = b.id
                        SET a.motis_status_verif = 2, a.reject_verified_reason = "Ditolak oleh system", a.motis_date_verif = NOW()
                        WHERE a.motis_user_id = ' . $motis_user_id . ' and b.jadwal_type = 2 and a.motis_status_verif = 0');
                    if ($update_balik) {
                        echo json_encode(array('success' => true, 'message' => 'Tiket Motis Mudik dan Balik Berhasil Dibatalkan'));
                    } else {
                        echo json_encode(array('success' => true, 'message' => 'Tiket Motis Mudik Berhasil Dibatalkan'));
                    }
                } else {
                    echo json_encode(array('success' => true, 'message' => 'Tiket Arus Balik Berhasil Dibatalkan'));
                }
            }
        } else {
            echo json_encode(array('success' => false, 'message' => "Gagal Verifikasi Tiket Mudik"));
        }
    }


    // public function verifikasikendaraanmudik_save()
    // {
    //     $data = $this->request->getPost();
    //     if ($data['id'] != null) {
    //         $id = $this->request->getPost('id');
    //         $verified_date = date('Y-m-d H:i:s');
    //         // if id is already verified
    //         $q1 = "SELECT * from t_billing_motis_mudik where id = '" . $id . "' AND motis_status_verif = '1'";
    //         if ($this->db->query($q1)->getRow()) {

    //             echo json_encode(array('success' => 2, 'message' => "Tiket Sudah di Verifikasi"));
    //         } else {

    //             $update = $this->db->query('UPDATE t_billing_motis_mudik SET motis_status_verif = "1", motis_date_verif = "' . $verified_date . '" WHERE id = "' . $id . '"');
    //             if ($update) {
    //                 echo json_encode(array('success' => 1, 'message' => "Tiket Mudik Berhasil di Verifikasi"));
    //             } else {
    //                 echo json_encode(array('success' => 3, 'message' => "Gagal Verifikasi Tiket Mudik"));
    //             }
    //         }
    //     } else {
    //         echo json_encode(array('success' => false, 'message' => "Gagal verifikasi tiket Kendaraan mudik tidak valid"));
    //     }
    // }

    public function verifikasikendaraanmudik_save()
    {
        $data = $this->request->getPost();
        if ($data['id'] != null) {
            if ($data['motis_armada_id'] != null) {
                $id = $this->request->getPost('id');
                $motis_code = $this->request->getPost('motis_code');
                $nama_pemilik_kendaraan = $this->request->getPost('nama_pemilik_kendaraan');
                $motis_armada_id = $this->request->getPost('motis_armada_id');
                $verified_date = date('Y-m-d H:i:s');
                $q1 = "SELECT * from t_billing_motis_mudik where id = '" . $id . "' AND motis_status_verif = '1'";
                if ($this->db->query($q1)->getResult()) {
                    echo json_encode(array('success' => 2, 'message' => "Tiket Sudah di Verifikasi"));
                } else {
                    $update = $this->db->query('UPDATE t_billing_motis_mudik SET motis_status_verif = "1", motis_armada_id ="' . $motis_armada_id . '", motis_date_verif = NOW() WHERE id = "' . $id . '"');
                    $update = $this->db->query('UPDATE t_motis_manifest_mudik SET nama_pemilik_kendaraan = "' . $nama_pemilik_kendaraan . '" WHERE motis_billing_code = "' . $motis_code . '"');
                    if ($update) {
                        $getdata = $this->db->query("SELECT a.id, a.motis_user_id, a.motis_code, DATE_FORMAT (a.motis_date_verif, '%d-%m-%Y') AS motis_date_verif , b.no_kendaraan, b.jenis_kendaraan, b.no_stnk_kendaraan, b.nama_pemilik_kendaraan , a.motis_status_boarding, b.nik_pendaftar_kendaraan, a.motis_status_verif,c.id as armada_id,c.armada_name,c.armada_code
                        FROM t_billing_motis_mudik a
                        JOIN t_motis_manifest_mudik b ON b.motis_billing_code = a.motis_code 
                        JOIN m_armada_motis_mudik c ON c.id = a.motis_armada_id
                        WHERE a.motis_code = '" . $motis_code . "'");
                        echo json_encode(array('success' => 1, 'message' => "Tiket Mudik Berhasil di Verifikasi", 'data' => $getdata->getResult()));
                    } else {
                        echo json_encode(array('success' => 3, 'message' => "Gagal Verifikasi Tiket Mudik"));
                    }
                }
            } else {
                echo json_encode(array('success' => false, 'message' => "Belum memilih armada", 'status' => "warning"));
            }
        } else {
            echo json_encode(array('success' => false, 'message' => "Gagal verifikasi tiket Kendaraan mudik tidak valid"));
        }
    }


    public function verifikasikedatangankendaraanmudik_load()
    {
        parent::_authLoad(function () {
            $query = " SELECT a.id, a.motis_user_id, a.motis_code, b.no_kendaraan, b.jenis_kendaraan, b.no_stnk_kendaraan, a.motis_status_boarding, b.nik_pendaftar_kendaraan, a.motis_status_verif, a.motis_status_boarding,
                        CASE 
                        WHEN a.motis_status_boarding = '1' THEN 'Check-In' 
                        ELSE 'Ditolak'
                        END AS motis_status_boarding
                        FROM t_billing_motis_mudik a
                        JOIN t_motis_manifest_mudik b ON b.motis_billing_code = a.motis_code 
                    WHERE a.motis_status_verif = '1' AND a.motis_status_boarding = '1' ";

            $where = ["a.id", "a.motis_code", "a.motis_status_verif", "a.motis_status_boarding", "b.nik_pendaftar_kendaraan", "b.no_kendaraan", "b.jenis_kendaraan", "b.no_stnk_kendaraan"];
            parent::_loadDatatable($query, $where, $this->request->getPost());
        });
    }

    public function verifikasikedatangankendaraanmudik_save()
    {
        $data = $this->request->getPost();
        if ($data['id'] != null) {
            $id = $this->request->getPost('id');
            $verified_date = date('Y-m-d H:i:s');
            // if id is already verified
            $q1 = "SELECT * from t_billing_motis_mudik where id = '" . $id . "' AND motis_status_boarding = '1'";
            if ($this->db->query($q1)->getRow()) {
                echo json_encode(array('success' => 2, 'message' => "Tiket Sudah di verifikasi"));
            } else {

                $update = $this->db->query('UPDATE t_billing_motis_mudik SET motis_status_boarding = "1", motis_date_boarding = NOW() WHERE id = "' . $id . '"');
                if ($update) {
                    echo json_encode(array('success' => 1, 'message' => "Tiket Mudik Berhasil di Verifikasi"));
                } else {
                    echo json_encode(array('success' => 3, 'message' => "Gagal Verifikasi Tiket Mudik"));
                }
            }
        } else {
            echo json_encode(array('success' => false, 'message' => "Gagal verifikasi tiket Kendaraan mudik tidak valid"));
        }
    }

    public function verifikasikedatangankendaraanmudik_edit()
    {
        $data = $this->request->getPost();
        $query =
            " SELECT a.id, a.motis_user_id, a.motis_code, b.no_kendaraan, b.jenis_kendaraan, b.no_stnk_kendaraan, a.motis_status_boarding, b.nik_pendaftar_kendaraan, a.motis_status_verif
        FROM t_billing_motis_mudik a
        JOIN t_motis_manifest_mudik b ON b.motis_billing_code = a.motis_code 
        WHERE sha1(sha1(a.motis_code)) = '" . $data['motis_code'] . "'";

        $result = $this->db->query($query)->getRow();
        if ($result) {
            echo json_encode(array('success' => true, 'data' => $result));
        } else {
            echo json_encode(array('success' => false, 'data' => $this->db->error()));
        }
    }

    public function verifikasipengambilankendaraanmudik_load()
    {
        parent::_authLoad(function () {
            $query = " SELECT a.id, a.motis_user_id, a.motis_code, b.no_kendaraan, b.jenis_kendaraan, b.no_stnk_kendaraan, a.motis_status_boarding, b.nik_pendaftar_kendaraan, a.motis_status_verif, a.motis_status_take,
                        CASE 
                        WHEN a.motis_status_take = '1' THEN 'Diambil' 
                        ELSE 'Ditolak'
                        END AS motis_status_take
                        FROM t_billing_motis_mudik a
                        JOIN t_motis_manifest_mudik b ON b.motis_billing_code = a.motis_code 
                    WHERE a.motis_status_boarding = '1' AND a.motis_status_take = '1' AND a.motis_status_verif ='1'";

            $where = ["a.id", "a.motis_code", "a.motis_status_take", "a.motis_status_verif", "a.motis_status_boarding", "b.nik_pendaftar_kendaraan", "b.no_kendaraan", "b.jenis_kendaraan", "b.no_stnk_kendaraan"];
            parent::_loadDatatable($query, $where, $this->request->getPost());
        });
    }

    public function verifikasipengambilankendaraanmudik_save()
    {
        $data = $this->request->getPost();
        if ($data['id'] != null) {
            $id = $this->request->getPost('id');
            $verified_date = date('Y-m-d H:i:s');
            // if id is already verified
            $q1 = "SELECT * from t_billing_motis_mudik where id = '" . $id . "' AND motis_status_take = '1'";
            if ($this->db->query($q1)->getRow()) {
                echo json_encode(array('success' => 2, 'message' => "Kendaraan Sudah di Ambil"));
            } else {

                $update = $this->db->query('UPDATE t_billing_motis_mudik SET motis_status_take = "1", motis_date_take = NOW() WHERE id = "' . $id . '"');
                if ($update) {
                    echo json_encode(array('success' => 1, 'message' => "Kendaraan Berhasil di Ambil"));
                } else {
                    echo json_encode(array('success' => 3, 'message' => "Gagal Mengambil Kendaraan "));
                }
            }
        } else {
            echo json_encode(array('success' => false, 'message' => "Gagal Mengambil Kendaraan Mudik Tidak Valid"));
        }
    }

    public function verifikasipengambilankendaraanmudik_edit()
    {
        $data = $this->request->getPost();
        $query =
            " SELECT a.id, a.motis_user_id, a.motis_code, b.no_kendaraan, b.jenis_kendaraan, b.no_stnk_kendaraan, a.motis_status_boarding, b.nik_pendaftar_kendaraan, a.motis_status_verif
        FROM t_billing_motis_mudik a
        JOIN t_motis_manifest_mudik b ON b.motis_billing_code = a.motis_code 
        WHERE sha1(sha1(a.motis_code)) = '" . $data['motis_code'] . "'";

        $result = $this->db->query($query)->getRow();
        if ($result) {
            echo json_encode(array('success' => true, 'data' => $result));
        } else {
            echo json_encode(array('success' => false, 'data' => $this->db->error()));
        }
    }

    // manajemen pindah bus
    // load
    public function manpindahbus_load()
    {
        parent::_authLoad(function () {
            $query = "SELECT a.id, b.armada_name, a.jadwal_date_depart, a.jadwal_time_depart, a.jadwal_date_arrived, a.jadwal_time_arrived, c.route_name 
                        from t_jadwal_mudik a
                        left join m_armada_mudik b
                            on a.jadwal_armada_id = b.id
                        left join m_route c
                            on a.jadwal_route_id = c.id
                        where a.is_deleted = 0";
            $where = ["b.armada_name", "c.route_name"];

            parent::_loadDatatable($query, $where, $this->request->getPost());
        });
    }

    // change
    public function manpindahbus_changeseat()
    {
        parent::_authEdit(function () {
            $id = $this->request->getPost("id");
            $seat = $this->request->getPost("seat");
            $use = $this->request->getPost("use");

            // get data seat original
            $getDataFrom = $this->db->query("SELECT b.* 
                                                FROM t_jadwal_seat_mudik a
                                                JOIN t_jadwal_mudik b
                                                ON a.jadwal_id = b.id
                                                WHERE a.id = " . $id[0])->getRow();

            // get data seat destination
            $getDataTo = $this->db->query("SELECT b.* 
                                                FROM t_jadwal_seat_mudik a
                                                JOIN t_jadwal_mudik b
                                                ON a.jadwal_id = b.id
                                                WHERE a.id = " . $id[1])->getRow();


            if ($getDataFrom->jadwal_type != $getDataTo->jadwal_type) {
                echo json_encode(array('success' => false, 'message' => 'Jadwal mudik dan balik tidak bisa ganti kursi'));
                return;
            }

            if ($this->pomudikModel->changeSeat($this->session->get('id'), $id, $seat, $use)) {
                echo json_encode(array('success' => true, 'message' => "success"));
            } else {
                echo json_encode(array('success' => false, 'message' => $this->pomudikModel->db->error()));
            }
        });
    }

    public function manarmadamotis_load()
    {
        parent::_authLoad(function () {
            $query = "SELECT a.id, a.armada_name, b.po_name, a.armada_merk, a.armada_code, a.armada_plat_number, a.armada_capacity, a.armada_color
                            FROM m_armada_motis_mudik a
                            JOIN m_po b
                                ON a.po_id = b.id
                            WHERE a.is_deleted = 0";

            $where = ["a.armada_name", "b.po_name", "a.armada_merk", "a.armada_code", "a.armada_plat_number", "a.armada_capacity"];

            parent::_loadDatatable($query, $where, $this->request->getPost());
        });
    }

    public function manarmadamotis_save()
    {
        parent::_authInsert(function () {
            parent::_insert('m_armada_motis_mudik', $this->request->getPost());
        });
    }

    public function manarmadamotis_edit()
    {
        parent::_authEdit(function () {
            $data = $this->request->getPost();

            $query = "SELECT a.*, b.po_name as po_nama, CONCAT(d.route_name, ' - ( ', c.jadwal_date_depart, ' ' , c.jadwal_time_depart, ' s/d ', c.jadwal_date_arrived, ' ', c.jadwal_time_arrived, ' )') as jadwal_motis_mudik_nama
                        FROM m_armada_motis_mudik a
                        JOIN m_po b
                            ON a.po_id = b.id
                        LEFT JOIN t_jadwal_motis_mudik c
                        ON a.jadwal_motis_mudik_id = c.id
                        LEFT JOIN m_route d
                        ON c.jadwal_route_id = d.id
                        WHERE a.id = " . $this->request->getPost('id');

            parent::_edit('m_armada_motis_mudik', $data, null, $query);
        });
    }

    public function manarmadamotis_delete()
    {
        parent::_authDelete(function () {
            parent::_delete('m_armada_motis_mudik', $this->request->getPost());
        });
    }

    public function manarmadamotis_upload()
    {

        $input = $this->validate([
            'file' => [
                'uploaded[file]',
                'mime_in[file,image/jpg,image/jpeg,image/png]',
                'max_size[file,1024]',
            ],
        ]);

        if (!$input) {
            print_r('Choose a valid file');
        } else {

            $x_file = $this->request->getFile('file');
            $nama_file = $x_file->getRandomName();
            $image = \Config\Services::image()
                ->withFile($x_file)
                ->resize(720, 360, true, 'width')
                ->save('public/uploads/motis/' . $nama_file);

            if ($image) {

                $msg = array("status" => 1, "msg" => "File Has Been Uploaded", "path" => 'public/uploads/motis/' . $nama_file);
            } else {
                $msg = array("status" => 0, "msg" => $this->upload->display_errors());
            }

            echo json_encode($msg);
        }
    }

    public function manjadwalmotis_load()
    {
        parent::_authLoad(function () {
            $query = "SELECT a.*, b.route_name
                        FROM t_jadwal_motis_mudik a
                        JOIN m_route b
                            ON a.jadwal_route_id = b.id
                        WHERE a.is_deleted = 0";

            $where = ["b.route_name"];

            parent::_loadDatatable($query, $where, $this->request->getPost());
        });
    }

    public function manjadwalmotis_save()
    {
        parent::_authInsert(function () {
            if ($this->request->getPost("id") == "") {
                $query = $this->db->query('SELECT *
                FROM t_jadwal_motis_mudik
                where jadwal_route_id = ' . $this->request->getPost('jadwal_route_id') . '
                and is_deleted = 0')->getRow();

                if ($query) {
                    echo json_encode(array('success' => false, 'message' => 'Rute sudah pernah dipilih, silahkan pilih rute lain'));
                    return;
                }
            }

            parent::_insert('t_jadwal_motis_mudik', $this->request->getPost());
        });
    }

    public function manjadwalmotis_edit()
    {
        parent::_authEdit(function () {
            $data = $this->request->getPost();

            $query = "SELECT a.*, b.route_name as jadwal_route_nama
                        FROM t_jadwal_motis_mudik a
                        JOIN m_route b
                            ON a.jadwal_route_id = b.id
                        WHERE a.is_deleted = 0
                        AND a.id = '" . $this->request->getPost('id') . "'
                        ";

            parent::_edit('t_jadwal_motis_mudik', $data, null, $query);
        });
    }

    public function manjadwalmotis_delete()
    {
        parent::_authDelete(function () {
            parent::_delete('t_jadwal_motis_mudik', $this->request->getPost());
        });
    }

    // manajamenen paguyuban motis
    // insert
    public function manpaguyubanmotis_save()
    {
        parent::_authInsert(function () {
            $data = $this->request->getPost();
            
            $countNo = count($data['no']);
            $isPaguyubanCountNow = 0; 
            $resultKuotaAvail = [];
            $resultKuotaAvailBalik = [];
            for($i = 0; $i < $countNo; $i++) {
                if(@$data['email'][$i]) {
                    $cekPaguyubanMotis = $this->db->query("SELECT *
                                                            FROM t_billing_motis_mudik
                                                            WHERE motis_jadwal_id = " . $data['jadwal_mudik_id'] . "
                                                            AND motis_user_id = " . $data['email'][$i] . "
                                                            AND motis_cancel = 0
                                                            ")->getRow();
                                    
                    if($cekPaguyubanMotis) {
                       if($cekPaguyubanMotis->motis_is_paguyuban == 1) {
                            $isPaguyubanCountNow++;
                       }
                    } else {
                        $cekEmailPaguyubanMotisDuplicate = $this->db->query("SELECT *
                                                                            FROM t_billing_motis_mudik
                                                                            WHERE motis_user_id = " . $data['email'][$i] . "
                                                                            AND motis_cancel = 0
                                                                            ")->getRow();

                        $cekNikPaguyubanMotisDuplicate = $this->db->query("SELECT a.*
                                                                            FROM t_billing_motis_mudik a
                                                                            JOIN t_motis_manifest_mudik b
                                                                                ON a.id = b.motis_billing_id
                                                                            WHERE b.nik_pendaftar_kendaraan = " . $data['nik_pendaftar_kendaraan'][$i] . "
                                                                            AND a.motis_cancel = 0
                                                                            ")->getRow();

                        if($cekEmailPaguyubanMotisDuplicate) {
                            echo json_encode(array('success' => false, 'message' => 'Email Sudah digunakan'));
                            return;
                        }

                        if($cekNikPaguyubanMotisDuplicate) {
                            echo json_encode(array('success' => false, 'message' => 'NIK Sudah digunakan'));
                            return;
                        }
                    }

                    // check email new not registered motis
                    if($data['billing_id'][$i] == "") {
                        $cekBillingMudikType = $this->db->query("SELECT b.jadwal_type
                                                                    FROM t_billing_motis_mudik a
                                                                    JOIN t_jadwal_motis_mudik b
                                                                        ON a.motis_jadwal_id = b.id
                                                                    WHERE a.motis_user_id = " . $data['email'][$i] . "
                                                                    AND a.motis_jadwal_id = " . $data['jadwal_mudik_id'])->getRow();

                        $cekJadwalMudikType = $this->db->query("SELECT jadwal_type, quota_paguyuban, quota_public
                                                                    FROM t_jadwal_motis_mudik
                                                                    WHERE id = " . $data['jadwal_mudik_id'])->getRow();

                        if($cekBillingMudikType) {
                            if($cekBillingMudikType->jadwal_type == $cekJadwalMudikType->jadwal_type) {
                                $emailMobile = $this->db->query("SELECT * 
                                                                    FROM m_user_mobile
                                                                    WHERE id = " . $data['email'][$i])->getRow();

                                echo json_encode(array('success' => false, 'message' => 'Email ' . $emailMobile->user_mobile_email . ' sudah melebihi kuota motis'));
                                return;  
                            }
                        }

                        if($isPaguyubanCountNow > $cekJadwalMudikType->quota_paguyuban) {
                            echo json_encode(array('success' => false, 'message' => 'Paguyuban telah memenuhi kuota'));
                            return;  
                        } else {
                            $isPaguyubanCountNow++;
                        }
                    }

                    // check completeness input data
                    if(empty($data['no_kendaraan'][$i]) 
                        || empty($data['jenis_kendaraan'][$i]) 
                        || empty($data['no_stnk_kendaraan'][$i]) 
                        || empty($data['nik_pendaftar_kendaraan'][$i]) 
                        || strlen($data['nik_pendaftar_kendaraan'][$i]) !== 16
                        || empty($data['foto_kendaraan'][$i]) 
                        || empty($data['foto_stnk'][$i]) 
                        || empty($data['foto_ktp'][$i])
                    ) {
                        echo json_encode(array('success' => false, 'message' => 'Isi data dengan benar'));
                        return;
                    }

                     // cek kuota truck motis
                    if(empty($resultKuotaAvail)) {
                        $cekKuotaTruckAvail = $this->db->query("SELECT b.id, 
                                                            b.armada_name, count(c.id) as ttl_motis, 
                                                            sum(case when c.motis_is_paguyuban = '0' then 1 else 0 end) as ttl_motis_umum,
                                                            sum(case when c.motis_is_paguyuban = '1' then 1 else 0 end) as ttl_motis_paguyuban
                                                    from t_jadwal_motis_mudik a
                                                    join m_armada_motis_mudik b
                                                        on a.id = b.jadwal_motis_mudik_id
                                                    left join t_billing_motis_mudik c
                                                        on b.id = c.motis_armada_id
                                                    where a.id = " . $data['jadwal_mudik_id'] . "
                                                    group by b.id, c.motis_is_paguyuban")->getResult();

                        if($cekKuotaTruckAvail) {
                            for($y = 0; $y < count($cekKuotaTruckAvail); $y++) {
                                if($cekKuotaTruckAvail[$y]->ttl_motis_umum > $cekJadwalMudikType->quota_public) {
                                    echo json_encode(array('success' => false, 'message' => 'Kuota public err'));
                                    return;
                                }
                            }

                            for($xx = 0; $xx < count($cekKuotaTruckAvail); $xx++) {
                                if($cekKuotaTruckAvail[$xx]->id == @$data['armada_mudik'][$i]) {
                                    $cekKuotaTruckAvail[$xx]->ttl_motis_paguyuban += 1;
                                }

                                if($cekKuotaTruckAvail[$xx]->ttl_motis_paguyuban > $cekJadwalMudikType->quota_paguyuban) {
                                    echo json_encode(array('success' => false, 'message' => 'Kuota Armada ' . $cekKuotaTruckAvail[$xx]->armada_name . ' Paguyuban Mudik Melebihi Batas 30 Motor'));
                                    return;
                                }

                                array_push($resultKuotaAvail, $cekKuotaTruckAvail[$xx]);
                            }
                        }
                    } else {
                        for($xxy = 0; $xxy < count($resultKuotaAvail); $xxy++) {
                            if($resultKuotaAvail[$xxy]->id == @$data['armada_mudik'][$i]) {
                                $resultKuotaAvail[$xxy]->ttl_motis_paguyuban += 1;
                            }
                        }
                    }

                    // cek kuota truck motis balik
                    if(empty($resultKuotaAvailBalik)) {
                        $cekKuotaTruckAvailJadwalBalik = $this->db->query("SELECT b.*
                                                                        FROM t_jadwal_motis_mudik a
                                                                        JOIN m_route b
                                                                        ON a.jadwal_route_id = b.id
                                                                        WHERE a.id = " . $data['jadwal_mudik_id'] . "
                                                                        AND b.is_deleted = 0;
                                                                        ")->getRow();

                        $cekKuotaTruckAvailRouteBalik = $this->db->query("SELECT b.* 
                                                                FROM m_route a
                                                                JOIN t_jadwal_motis_mudik b
                                                                    ON a.id = b.jadwal_route_id
                                                                WHERE a.terminal_from_id = " . $cekKuotaTruckAvailJadwalBalik->terminal_to_id . "
                                                                AND a.terminal_to_id = " . $cekKuotaTruckAvailJadwalBalik->terminal_from_id . "
                                                                AND a.is_deleted = 0")->getRow();

                        $cekKuotaTruckAvailBalik = $this->db->query("SELECT b.id, 
                                                            b.armada_name, count(c.id) as ttl_motis, 
                                                            sum(case when c.motis_is_paguyuban = '0' then 1 else 0 end) as ttl_motis_umum,
                                                            sum(case when c.motis_is_paguyuban = '1' then 1 else 0 end) as ttl_motis_paguyuban
                                                    from t_jadwal_motis_mudik a
                                                    join m_armada_motis_mudik b
                                                        on a.id = b.jadwal_motis_mudik_id
                                                    left join t_billing_motis_mudik c
                                                        on b.id = c.motis_armada_id
                                                    where a.id = " . $cekKuotaTruckAvailRouteBalik->id . "
                                                    group by b.id, c.motis_is_paguyuban")->getResult();

                        if($cekKuotaTruckAvailBalik) {
                            for($y = 0; $y < count($cekKuotaTruckAvailBalik); $y++) {
                                if($cekKuotaTruckAvailBalik[$y]->ttl_motis_umum > $cekJadwalMudikType->quota_public) {
                                    echo json_encode(array('success' => false, 'message' => 'Kuota public err'));
                                    return;
                                }
                            }

                            for($xx = 0; $xx < count($cekKuotaTruckAvailBalik); $xx++) {
                                if($cekKuotaTruckAvailBalik[$xx]->id == @$data['armada_balik'][$i]) {
                                    $cekKuotaTruckAvailBalik[$xx]->ttl_motis_paguyuban += 1;
                                }

                                if($cekKuotaTruckAvailBalik[$xx]->ttl_motis_paguyuban > $cekJadwalMudikType->quota_paguyuban) {
                                    echo json_encode(array('success' => false, 'message' => 'Kuota Armada ' . $cekKuotaTruckAvailBalik[$xx]->armada_name . ' Paguyuban Balik Melebihi Batas 30 Motor'));
                                    return;
                                }

                                array_push($resultKuotaAvailBalik, $cekKuotaTruckAvailBalik[$xx]);
                            }
                        }
                    } else {
                        for($xxy = 0; $xxy < count($resultKuotaAvailBalik); $xxy++) {
                            if($resultKuotaAvailBalik[$xxy]->id == @$data['armada_balik'][$i]) {
                                $resultKuotaAvailBalik[$xxy]->ttl_motis_paguyuban += 1;
                            }
                        }
                    }
                }
            }
            
            if ($this->pomudikModel->savePaguyubanMotis($this->session->get('id'), $data)) {
                echo json_encode(array('success' => true, 'message' => "success"));
            } else {
                echo json_encode(array('success' => false, 'message' => $this->pomudikModel->db->error()));
            }
        });
    }

    // upload kendaran, just in case name file kendaraan
    public function manpaguyubanmotis_uploadkendaraan()
    {

        $input = $this->validate([
            'file' => [
                'uploaded[file]',
                'mime_in[file,image/jpg,image/jpeg,image/png]',
                'max_size[file,1024]',
            ],
        ]);

        if (!$input) {
            print_r('Choose a valid file');
        } else {

            $x_file = $this->request->getFile('file');
            $nama_file = $x_file->getRandomName();
            $image = \Config\Services::image()
                ->withFile($x_file)
                ->resize(720, 360, true, 'width')
                ->save('public/uploads/motis/' . $nama_file);

            if ($image) {
                $msg = array("status" => 1, "msg" => "File Has Been Uploaded", "path" => 'public/uploads/motis/' . $nama_file);
            } else {
                $msg = array("status" => 0, "msg" => $this->upload->display_errors());
            }

            echo json_encode($msg);
        }
    }

    // upload stnk, just in case name file stnk
    public function manpaguyubanmotis_uploadstnk()
    {

        $input = $this->validate([
            'file' => [
                'uploaded[file]',
                'mime_in[file,image/jpg,image/jpeg,image/png]',
                'max_size[file,1024]',
            ],
        ]);

        if (!$input) {
            print_r('Choose a valid file');
        } else {

            $x_file = $this->request->getFile('file');
            $nama_file = $x_file->getRandomName();
            $image = \Config\Services::image()
                ->withFile($x_file)
                ->resize(720, 360, true, 'width')
                ->save('public/uploads/motis/' . $nama_file);

            if ($image) {
                $msg = array("status" => 1, "msg" => "File Has Been Uploaded", "path" => 'public/uploads/motis/' . $nama_file);
            } else {
                $msg = array("status" => 0, "msg" => $this->upload->display_errors());
            }

            echo json_encode($msg);
        }
    }

    // upload ktp, just in case name file ktp
    public function manpaguyubanmotis_uploadktp()
    {

        $input = $this->validate([
            'file' => [
                'uploaded[file]',
                'mime_in[file,image/jpg,image/jpeg,image/png]',
                'max_size[file,1024]',
            ],
        ]);

        if (!$input) {
            print_r('Choose a valid file');
        } else {

            $x_file = $this->request->getFile('file');
            $nama_file = $x_file->getRandomName();
            $image = \Config\Services::image()
                ->withFile($x_file)
                ->resize(720, 360, true, 'width')
                ->save('public/uploads/motis/' . $nama_file);

            if ($image) {
                $msg = array("status" => 1, "msg" => "File Has Been Uploaded", "path" => 'public/uploads/motis/' . $nama_file);
            } else {
                $msg = array("status" => 0, "msg" => $this->upload->display_errors());
            }

            echo json_encode($msg);
        }
    }

    // feature not fix
    public function listdataarmadabis_load()
    {
        parent::_authLoad(function () {
            $iduser = $this->session->get('id');

            $idArrUser = [$iduser];

            $cekChildUsers = $this->db->query("SELECT d.* 
                                                FROM m_user_web a
                                                JOIN m_instansi_detail b
                                                ON a.instansi_detail_id = b.id
                                                JOIN m_instansi_detail c
                                                ON b.id = c.instansi_detail_id
                                                JOIN m_user_web d
                                                ON c.id = d.instansi_detail_id
                                                WHERE a.id = " . $iduser . "")->getResult();

            foreach ($cekChildUsers as $cekChildUser) {
                array_push($idArrUser, $cekChildUser->id);
            }

            $query = "SELECT a.id, b.armada_name, a.jadwal_date_depart, a.jadwal_time_depart, a.jadwal_date_arrived, a.jadwal_time_arrived, c.route_name, a.open, a.jadwal_type
                        , e.jumlah_full, e.jumlah_complete
                        FROM t_jadwal_mudik a
                        LEFT JOIN m_armada_mudik b
                            ON a.jadwal_armada_id = b.id
                        LEFT JOIN m_route c
                            ON a.jadwal_route_id = c.id
                        LEFT JOIN m_seat_map d
                            ON b.armada_sheet_id = d.id
                        JOIN (
                            select jadwal_id, seat_map_id, count(jadwal_id) as jumlah_full, count(transaction_id) as jumlah_complete 
                            from t_jadwal_seat_mudik
                            group by jadwal_id, seat_map_id
                        ) e
                        on a.id = e.jadwal_id
                        WHERE a.is_deleted = 0
                        AND c.kategori_angkutan_id = 5
                        AND a.created_by IN (" . implode(',', $idArrUser) . ")
                        GROUP BY a.id
                        ";

            $where = ["b.armada_name", "c.route_name"];

            parent::_loadDatatable($query, $where, $this->request->getPost());
        });
    }

    // public function listdataarmadabis_save()
    // {
    //     parent::_authInsert(function () {
    //         if ($this->pomudikModel->saveJadwal($this->session->get('id'), $this->request->getPost())) {
    //             echo json_encode(array('success' => true, 'message' => "success"));
    //         } else {
    //             echo json_encode(array('success' => false, 'message' => $this->pomudikModel->db->error()));
    //         }
    //     });
    // }

    public function listdataarmadabis_edit()
    {
        parent::_authEdit(function () {
            $data = $this->request->getPost();

            $idJadwal = $this->request->getPost('id');

            $query = "SELECT c.seat_map_name, c.seat_map_left, c.seat_map_right, c.seat_map_row, c.seat_map_last, c.seat_map_capacity,
                        JSON_ARRAYAGG(
                            JSON_OBJECT(
                                'id', d.id,
                                'jadwal_id', d.jadwal_id,
                                'seat_map_id', d.seat_map_id,
                                'seat_map_detail_name', d.seat_map_detail_name,
                                'seat_map_use', d.seat_map_use,
                                'seat_group_baris', d.seat_group_baris, 
                                'transaction_id', d.transaction_id,
                                'transaction_name', e.transaction_booking_name,
                                'transaction_nik', e.transaction_nik
                            )
                        ) as seat
                        FROM t_jadwal_mudik a
                        LEFT JOIN m_armada_mudik b
                            ON a.jadwal_armada_id = b.id
                        LEFT JOIN m_seat_map c
                            ON b.armada_sheet_id = c.id
                        JOIN t_jadwal_seat_mudik d
                            ON c.id = d.seat_map_id
                        LEFT JOIN t_transaction_mudik e
                            ON d.transaction_id = e.id
                        WHERE a.id = " . $idJadwal . "
                        AND a.is_deleted = 0
                        AND d.jadwal_id = " . $idJadwal . "
                        group by d.jadwal_id
                        ";

            parent::_edit('t_jadwal_mudik', $data, null, $query);
        });
    }

    // public function listdataarmadabis_delete()
    // {
    //     parent::_authDelete(function () {
    //         parent::_delete('t_jadwal_mudik', $this->request->getPost());
    //     });
    // }

    // manajemen manivest mudik
    // load
    public function lapmanivestpenumpang_load()
    {
        parent::_authLoad(function () {
            $query = "SELECT b.id, b.user_mobile_name, b.user_mobile_email, b.user_mobile_phone
                        FROM t_billing_mudik a
                        JOIN m_user_mobile b
                            ON a.billing_user_id = b.id
                        GROUP BY billing_user_id";

            $where = ["b.user_mobile_name", "b.user_mobile_email", "b.user_mobile_phone"];

            parent::_loadDatatable($query, $where, $this->request->getPost());
        });
    }

    // show
    public function lapmanivestpenumpang_show()
    {
        parent::_authEdit(function () {
            $query = $this->db->query("select d.user_mobile_email,
                                                e.armada_name,
                                                e.armada_code,
                                                e.armada_plat_number,
                                                e.armada_merk,
                                                f.po_name,
                                                g.class_name,
                                                h.route_name,
                                                b.jadwal_type,
                                                b.jadwal_date_depart,
                                                b.jadwal_time_depart,
                                                b.jadwal_date_arrived,
                                                b.jadwal_time_arrived,
                                                a.billing_code as 'billing_code',
                                                a.billing_qty,
                                                a.billing_expired_date,
                                                a.billing_payment_date,
                                                CASE WHEN a.billing_status_payment = '0' THEN 'Pending' ELSE 'Paid' END as status_payment,
                                                CASE WHEN a.billing_cancel = '1' THEN '( billing cancel )' ELSE '' END as billing_cancel,
                                                CASE WHEN a.billing_is_paguyuban = '1' THEN '( Paguyuban )' ELSE '' END as billing_is_paguyuban,
                                                a.billing_verif_expired_date,
                                                CASE WHEN a.billing_status_verif = '1' THEN '( Verified )' ELSE '' END as billing_status_verif,
                                                a.billing_date_verif,
                                                CASE WHEN a.billing_status_boarding = '1' THEN '( Boarding )' ELSE '' END as billing_status_boarding,
                                                a.billing_date_boarding
                                        , JSON_ARRAYAGG(
                                            JSON_OBJECT (
                                                'transaction_id', c.id,
                                                'billing_code', c.billing_code,
                                                'transaction_number', c.transaction_number,
                                                'transaction_seat_id', c.transaction_seat_id,
                                                'transaction_nik', c.transaction_nik,
                                                'transaction_booking_name', c.transaction_booking_name,
                                                'is_verified', CASE WHEN c.is_verified = '0' THEN 'Belum' ELSE 'Sudah' END,
                                                'is_boarding', CASE WHEN c.is_boarding = '0' THEN 'Belum' ELSE 'Sudah' END,
                                                'reject_verified_reason', c.reject_verified_reason,
                                                'seat_map_detail', CASE WHEN i.seat_map_detail_name IS NULL THEN '-' ELSE i.seat_map_detail_name END,
                                                'jadwal_type', CASE WHEN b.jadwal_type = '1' THEN 'Mudik' ELSE 'Balik' END
                                                )
                                            ) as 'transaction_mudik'
                                        from t_billing_mudik a
                                        join t_jadwal_mudik b
                                            on a.billing_jadwal_id = b.id
                                        left join t_transaction_mudik c
                                            on 	a.id = c.billing_id	
                                        join m_user_mobile d
                                            on a.billing_user_id = d.id 
                                        join m_armada_mudik e
                                            on b.jadwal_armada_id = e.id
                                        join m_po f
                                            on e.po_id = f.id
                                        join m_class g
                                            on e.po_class_id = g.id	
                                        join m_route h
                                            on b.jadwal_route_id = h.id
                                        left join t_jadwal_seat_mudik i
                                            on c.transaction_seat_id = i.id 
                                        where a.billing_user_id = " . $this->request->getPost('id') . "
                                        group by b.jadwal_type, a.billing_code")->getResult();

            $data = '<div class="row">';

            foreach ($query as $q) {
                $transactions = json_decode($q->transaction_mudik);
                foreach ($transactions as $transaction) {
                    $data .= '<div class="col-lg-6 shadow-md p-3 bg-white rounded">
                                <div class="card p-4">
                                    <div class="card-header font-weight-bold gd-info">
                                        No Transaksi : ' . $transaction->transaction_number . '
                                    </div>
                                    <div class="card-body">
                                        <h5 class="card-title">' . $transaction->transaction_booking_name . ' 
                                            <small class="text-danger">' . $q->billing_cancel . '</small> 
                                            <small class="text-success"> ' . $q->billing_is_paguyuban . ' </small>
                                            <small class="text-success"> ' . $q->billing_status_verif . ' </small>
                                            <small class="text-success"> ' . $q->billing_status_boarding . ' </small>
                                        </h5>
                                        <p class="card-text"></p>
                                        <table class="table">
                                            <tbody>
                                                <tr>
                                                    <th scope="col">NIK</th>
                                                    <th scope="col"> : </th>
                                                    <th scope="col"> ' . $transaction->transaction_nik . ' </th>
                                                </tr>
                                                <tr>
                                                    <th scope="col">Status Payment</th>
                                                    <th scope="col"> : </th>
                                                    <th scope="col"> ' . $q->status_payment . ' </th>
                                                </tr>
                                                <tr>
                                                    <th scope="col">Boarding</th>
                                                    <th scope="col"> : </th>
                                                    <th scope="col"> ' . $transaction->is_boarding . ' </th>
                                                </tr>
                                                <tr>
                                                    <th scope="col">PO</th>
                                                    <th scope="col"> : </th>
                                                    <th scope="col"> ' . $q->po_name . ' </th>
                                                </tr>
                                                <tr>
                                                    <th scope="col">Class</th>
                                                    <th scope="col"> : </th>
                                                    <th scope="col"> ' . $q->class_name . ' </th>
                                                </tr>
                                                <tr>
                                                    <th scope="col">Route</th>
                                                    <th scope="col"> : </th>
                                                    <th scope="col"> ' . $q->route_name . ' </th>
                                                </tr>
                                                <tr>
                                                    <th scope="col">Armada</th>
                                                    <th scope="col"> : </th>
                                                    <th scope="col"> ' . $q->armada_name . ' </th>
                                                </tr>
                                                <tr>
                                                    <th scope="col">Plate Number</th>
                                                    <th scope="col"> : </th>
                                                    <th scope="col"> ' . $q->armada_plat_number . ' </th>
                                                </tr>
                                                <tr>
                                                    <th scope="col">Tipe Tiket</th>
                                                    <th scope="col"> : </th>
                                                    <th scope="col"> Arus ' . $transaction->jadwal_type . ' </th>
                                                </tr>
                                                <tr>
                                                    <th scope="col">Seat</th>
                                                    <th scope="col"> : </th>
                                                    <th scope="col"> ' . $transaction->seat_map_detail . ' </th>
                                                </tr>
                                                
                                            </tbody>
                                         </table>
                                    </div>
                                </div>
                            </div>';
                }
            }

            $data .= '</div>';

            echo json_encode(array("success" => true, "data" => $data, "atr" => ["modal" => "modal_blue", "modal_body" => "modal_body_blue"]));
        });
    }

    public function layananaduan_load()
    {
        $filter = $this->request->getGet('filter');
        if ($filter == '1') {
            $query = "select * from t_aduan where aduan_reply is null and date(created_at) >= '2023-03-10' order by created_at desc, aduan_reply asc";
        } else if ($filter == '2') {
            $query = "select * from t_aduan where aduan_reply is not null and date(created_at) >= '2023-03-10' order by created_at desc, aduan_reply asc";
        } else {
            $query = "select * from t_aduan where date(created_at) >= '2023-03-10'  order by created_at desc, aduan_reply asc";
        }
        $response = $this->db->query($query)->getResultArray();
        echo json_encode($response);
    }

    public function layananaduan_edit()
    {
        parent::_authEdit(function () {
            $data = $this->request->getPost();
            $updated_by = $this->session->get('id');
            $datereply = date('Y-m-d');
            $lastEdited = date('Y-m-d H:i:s');
            $update = $this->db->query("update t_aduan set aduan_reply = '" . $data['reply'] . "', aduan_date_reply = '" . $datereply . "', last_edited_by = '" . $updated_by . "', last_edited_at = '" . $lastEdited . "' where id = '" . $data['id'] . "' ");
            if ($update) {
                echo json_encode(array('success' => true, 'message' => "success"));
            } else {
                echo json_encode(array('success' => false, 'message' => "failed"));
            }
        });
    }

    public function layananaduan_delete()
    {
        parent::_authDelete(function () {
            parent::_delete('t_aduan', $this->request->getPost());
        });
    }

    // public function excel()
    // {
    //     $url = uri_segment("3");
    //     header("Content-Type:   application/vnd.ms-excel; charset=utf-8");
    //     header("Content-Disposition: attachment; filename=" . $url . "-" . date('d-m-Y H:i:s') . ".xls"); //File name extension was wrong
    //     header("Expires: 0");
    //     header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
    //     header("Cache-Control: private", false);

    //     $url_export = $url . '_export';
    //     $filter = [
    //         'jadwal_mudik_id' => $_GET['jadwal_mudik_id'],
    //         'paguyuban_mudik_id' => $_GET['paguyuban_mudik_id']
    //     ];
    //     $data['data_url'] = uri_segment("2");
    //     $data['data_excel'] = $this->pomudikModel->export_view($url_export, $filter);

    //     echo view('App\Modules\Pomudik\Views\export\\' . $url . '_export', $data);
    // }

    public function excelpaguyubanxlsx()
    {
        $url = uri_segment("3");
        $jadwal_mudik_id = $_GET['jadwal_mudik_id'];
        $paguyuban_mudik_id = $_GET['paguyuban_mudik_id'];

        $query = $this->db->query("SELECT b.*, c.transaction_booking_name, d.billing_is_paguyuban, e.paguyuban_mudik_id, f.paguyuban_mudik_name, e.paguyuban_name, e.paguyuban_email, e.paguyuban_no_wa, e.paguyuban_no_ktp, e.paguyuban_no_kk, d.billing_user_id, g.user_mobile_email as 'billing_user_nama'
                                    FROM t_jadwal_mudik a
                                    JOIN t_jadwal_seat_mudik b
                                        ON a.id = b.jadwal_id
                                    LEFT JOIN t_transaction_mudik c
                                        ON b.transaction_id = c.id
                                    LEFT JOIN t_billing_mudik d
                                        ON c.billing_id = d.id
                                    LEFT JOIN t_paguyuban_mudik_detail e
                                        ON b.id = e.jadwal_seat_mudik_id
                                    LEFT JOIN t_paguyuban_mudik f
                                        ON e.paguyuban_mudik_id = f.id
                                    LEFT JOIN m_user_mobile g
                                        ON d.billing_user_id = g.id
                                    WHERE a.is_deleted = 0
                                    AND a.id = " . $jadwal_mudik_id . "")->getResult();

        $paguyuban = $this->db->query("SELECT * 
                                    FROM t_paguyuban_mudik
                                    WHERE id = " . $paguyuban_mudik_id)->getRow();

        $jadwal = $this->db->query("SELECT a.id, CONCAT(b.armada_name, ' - ', c.route_name, ' - ( ', a.jadwal_date_depart, ' ' , a.jadwal_time_depart, ' s/d ', a.jadwal_date_arrived, ' ', a.jadwal_time_arrived, ' )') as 'text'
                                        from t_jadwal_mudik a
                                        join m_armada_mudik b
                                        on a.jadwal_armada_id = b.id
                                        JOIN m_route c
                                        ON a.jadwal_route_id = c.id
                                        where c.kategori_angkutan_id = 5
                                        and a.open = 0
                                        and a.is_deleted = 0
                                        and a.id = " . $jadwal_mudik_id)->getRow();
        
        $spreadsheet = new Spreadsheet();

        $spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('A1', 'Data Paguyuban')
            ->setCellValue('A3', 'Paguyuban : ' . $paguyuban->paguyuban_mudik_name)
            ->setCellValue('A5', 'Jadwal : ' . $jadwal->text)
            ->setCellValue('A7', 'Download date : '. date("d M Y H:i:s"))
            ->setCellValue('A8', 'Kursi')
            ->setCellValue('B8', 'Nama')
            ->setCellValue('C8', 'Email (Sudah pernah login apk mitra darat & belum daftar mudik sebelumnya)')
            ->setCellValue('D8', 'WA')
            ->setCellValue('E8', 'NIK')
            ->setCellValue('F8', 'No KK');

        $column = 9;

        foreach ($query as $q) {
            $spreadsheet->setActiveSheetIndex(0)
                ->setCellValue('A' . $column, $q->seat_map_detail_name);

            $column++;
        }

        $writer = new WriterXlsx($spreadsheet);
        $filename = date('Y-m-d-His'). '-Data-paguyuban';

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename=' . $filename . '.xlsx');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');

    }
}
