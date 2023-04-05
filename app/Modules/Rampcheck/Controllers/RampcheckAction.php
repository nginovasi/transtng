<?php namespace App\Modules\Rampcheck\Controllers;

use App\Core\BaseController;
use App\Modules\Rampcheck\Models\RampcheckModel;
use CodeIgniter\Files\File;

class RampcheckAction extends BaseController
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

    // public function rampcheck_upload()
    // {
    //     parent::_authInsert(function () {
    //         $imagefile = $this->request->getFiles();

    //         if ($imagefile) {
    //             $img = $imagefile['filename'];
    //             if ($img->isValid() && !$img->hasMoved()) {
    //                 $newName = $img->getRandomName();
    //                 $img->move(FCPATH . '/upliddir/rampcheck/', $newName);

    //                 $savedFileName = strval(base_url() . '/upliddir/rampcheck/' . $newName);

    //                 $dataInsert = [
    //                     "document_name" => $newName,
    //                     "document_filename" => $savedFileName,
    //                     "created_by" => $this->session->get('id'),
    //                     "created_at" => date("Y-m-d H:i:s"),
    //                 ];

    //                 $db = \Config\Database::connect();
    //                 $insertDocument = $db->table('m_document_rampcheck');

    //                 if ($insertDocument->insert($dataInsert)) {
    //                     $docID = $db->insertID();
    //                     var_dump($docID);
    //                 } else {
    //                     $docID = null;
    //                 }

    //                 $data = [
    //                     "status" => 1, "msg" => "Berhasil Upload", "filename" => $newName, "docid" => $docID,
    //                 ];
    //             } else {

    //                 $data = [
    //                     "status" => 0, "msg" => "Gagal Upload", "filename" => $newName, "docid" => $docID,
    //                 ];
    //             }
    //         } else {
    //             $data = [
    //                 "status" => 0, "msg" => "Gagal Upload", "filename" => $newName, "docid" => $docID,
    //             ];
    //         }

    //         echo json_encode($data);
    //     });

    // }

    function resize_image($image_name,$new_width,$new_height,$uploadDir,$moveToDir)
    {
        $path = $uploadDir . '/' . $image_name;

        $mime = getimagesize($path);

        if($mime['mime']=='image/png') { 
            $src_img = imagecreatefrompng($path);
        }
        if($mime['mime']=='image/jpg' || $mime['mime']=='image/jpeg' || $mime['mime']=='image/pjpeg') {
            $src_img = imagecreatefromjpeg($path);
        }   

        $old_x          =   imageSX($src_img);
        $old_y          =   imageSY($src_img);

        if($old_x > $old_y) 
        {
            $thumb_w    =   $new_width;
            $thumb_h    =   $old_y*($new_height/$old_x);
        }

        if($old_x < $old_y) 
        {
            $thumb_w    =   $old_x*($new_width/$old_y);
            $thumb_h    =   $new_height;
        }

        if($old_x == $old_y) 
        {
            $thumb_w    =   $new_width;
            $thumb_h    =   $new_height;
        }

        $dst_img        =   ImageCreateTrueColor($thumb_w,$thumb_h);

        imagecopyresampled($dst_img,$src_img,0,0,0,0,$thumb_w,$thumb_h,$old_x,$old_y); 


        // New save location
        $new_thumb_loc = $moveToDir . $image_name;

        if($mime['mime']=='image/png') {
            $result = imagepng($dst_img,$new_thumb_loc,9);
        }
        if($mime['mime']=='image/jpg' || $mime['mime']=='image/jpeg' || $mime['mime']=='image/pjpeg') {
            $result = imagejpeg($dst_img,$new_thumb_loc,80);
        }

        imagedestroy($dst_img); 
        imagedestroy($src_img);

        return $result;
    }

    public function rampcheck_upload()
    {
        parent::_authInsert(function () {
          
           $data = $this->request->getPost();
           $path = FCPATH . 'public/uploads/ttd/';
           $imageExtention = pathinfo($_FILES["filename"]["name"], PATHINFO_EXTENSION);
           $now = \DateTime::createFromFormat('U.u', microtime(true));
           $imageName = md5($now->format("m-d-Y H:i:s.u")).'.'.$imageExtention;
           $target_file = $path.$imageName;

           if (move_uploaded_file($_FILES["filename"]["tmp_name"], $target_file)) {
                // insert to database
                
                $this->resize_image($imageName,1200,1200,$path,$path);

                $dataInsert = [
                "document_name" => $imageName,
                "document_filename" => '/public/uploads/ttd/' . $imageName,
                "created_by" => $this->session->get('id'),
                "created_at" => date("Y-m-d H:i:s"),
                ];

                $db = \Config\Database::connect();
                $insertDocument = $db->table('m_document_rampcheck');

                if ($insertDocument->insert($dataInsert)) {
                $docID = $db->insertID();
                } else {
                $docID = null;
                }

                $data = [
                "status" => 1, "msg" => "Berhasil Upload", "filename" => $imageName, "docid" => $docID,
                "path_filename" => base_url().'/public/uploads/ttd/'.$imageName
                ];

                echo json_encode($data);
          }else{
                $data = [
                "status" => 0, "msg" => "Failed to upload", "error" =>  $_FILES["filename"]["error"],
                ];

                echo json_encode($data);
          }

        });
    }

    public function rampcheck_deleteUpload()
    {
        $data = $this->request->getPost();

        $docRampcheck = [
            "is_deleted" => 1,
            "updated_at" => date("Y-m-d H:i:s"),
            "updated_by" => $this->session->get('id'),
        ];

        $tRampcheck = $this->db->table('m_document_rampcheck');
        if ($tRampcheck->update($docRampcheck, ['document_name' => $data['filename']])) {
            $response = [
                "status" => 1, "msg" => "Berhasil Dihapus",
            ];
        } else {
            $response = [
                "status" => 2, "msg" => "Error",
            ];
        }
        echo json_encode($response);
    }

    public function rampcheck_save()
    {
        $rampcheck = $this->db->table('t_rampcheck');
        $rampcheckAdministrasi = $this->db->table('t_rampcheck_adm');
        $rampcheckTeknisPenunjang = $this->db->table('t_rampcheck_utp');
        $rampcheckTeknisUtama = $this->db->table('t_rampcheck_utu');
        $rampcheckKesimpulan = $this->db->table('t_rampcheck_kesimpulan');

        $data = $this->request->getPost();

        $rampcheck_no_kp = $data["rampcheck_no_kp"] ?? null;
        $rampcheck_expired_kp_date = $data["rampcheck_expired_kp_date"] ?? null;
        $rampcheck_expired_blue_date = $data["rampcheck_expired_blue_date"] ?? null;

        $rampcheck_adm_no_kpc = $data["rampcheck_adm_no_kpc"] ?? null;
        $rampcheck_adm_exp_date_kpc = $data["rampcheck_adm_exp_date_kpc"] ?? null;

        $namaLokasi = $data["rampcheck_nama_lokasi_sel"] ?? $data["rampcheck_nama_lokasi_text"];

        // Nomor rump check formatnya : "RC" + kode bptd (2 digit 1-26) + Kode terminal (3 digit) + timestamp + no urut (4 digit)

        ########################################
        ## Insert Rampcheck
        ########################################
        $dataRampcheck = [
            "rampcheck_date" => $data["rampcheck_date"],
            "rampcheck_jenis_lokasi_id" => $data["rampcheck_jenis_lokasi_id"],
            "rampcheck_nama_lokasi" => $namaLokasi,
            "rampcheck_pengemudi" => strtoupper($data["rampcheck_pengemudi"]),
            "rampcheck_umur_pengemudi" => $data["rampcheck_umur_pengemudi"],
            "rampcheck_po_name" => strtoupper($data["rampcheck_po_name"]),
            "rampcheck_noken" => strtoupper($data["rampcheck_noken"]),
            "rampcheck_stuk" => strtoupper($data["rampcheck_stuk"]),
            "rampcheck_jenis_angkutan_id" => $data["rampcheck_jenis_angkutan_id"],
            "rampcheck_trayek" => $data["rampcheck_trayek"],
            "rampcheck_sticker_no" => $data["rampcheck_sticker_no"],
            "rampcheck_no_kp" => $rampcheck_no_kp,
            "rampcheck_expired_kp_date" => $rampcheck_expired_kp_date,
            "rampcheck_expired_blue_date" => $rampcheck_expired_blue_date,
            "created_by" => $this->session->get('id'),
            "created_at" => date("Y-m-d H:i:s"),
        ];

        $rampcheckID = $this->rampcheckModel->saveRampcheck($dataRampcheck);

        ########################################
        ## Insert Rampcheck - Unsur Administrasi
        ########################################
        if($data["rampcheck_adm_kpr"] == 2) {
            $rampcheck_adm_kpc = isset($data["rampcheck_adm_kpc"])?$data["rampcheck_adm_kpc"]:null;
        } else {
            $rampcheck_adm_kpc = 2;
        }

        $dataRampcheckAdministrasi = [
            "rampcheck_id" => $rampcheckID,
            "rampcheck_adm_ku" => $data["rampcheck_adm_ku"],
            "rampcheck_adm_kpr" => $data["rampcheck_adm_kpr"],
            "rampcheck_adm_kpc" => $rampcheck_adm_kpc,
            "rampcheck_adm_sim" => $data["rampcheck_adm_sim"],
            "rampcheck_adm_no_kpc" => $rampcheck_adm_no_kpc,
            "rampcheck_adm_exp_date_kpc" => $rampcheck_adm_exp_date_kpc,
            "created_by" => $this->session->get('id'),
            "created_at" => date("Y-m-d H:i:s"),
        ];

        $rampcheckAdministrasi->insert($dataRampcheckAdministrasi);

        ########################################
        ## Insert Rampcheck - Unsur Teknis Utama
        ########################################
        $dataRampcheckTeknisUtama = [
            "rampcheck_id" => $rampcheckID,
            "rampcheck_utu_lukd" => $data["rampcheck_utu_lukd"],
            "rampcheck_utu_lukj" => $data["rampcheck_utu_lukj"],
            "rampcheck_utu_lpad" => $data["rampcheck_utu_lpad"],
            "rampcheck_utu_lpaj" => $data["rampcheck_utu_lpaj"],
            "rampcheck_utu_lr" => $data["rampcheck_utu_lr"],
            "rampcheck_utu_lm" => $data["rampcheck_utu_lm"],
            "rampcheck_utu_kru" => $data["rampcheck_utu_kru"],
            "rampcheck_utu_krp" => $data["rampcheck_utu_krp"],
            "rampcheck_utu_kbd" => $data["rampcheck_utu_kbd"],
            "rampcheck_utu_kbb" => $data["rampcheck_utu_kbb"],
            "rampcheck_utu_skp" => $data["rampcheck_utu_skp"],
            "rampcheck_utu_pk" => $data["rampcheck_utu_pk"],
            "rampcheck_utu_pkw" => $data["rampcheck_utu_pkw"],
            "rampcheck_utu_pd" => $data["rampcheck_utu_pd"],
            "rampcheck_utu_jd" => $data["rampcheck_utu_jd"],
            "rampcheck_utu_apk" => $data["rampcheck_utu_apk"],
            "rampcheck_utu_apar" => $data["rampcheck_utu_apar"],
            "created_by" => $this->session->get('id'),
            "created_at" => date("Y-m-d H:i:s"),
        ];

        $rampcheckTeknisUtama->insert($dataRampcheckTeknisUtama);

        ############################################
        ## Insert Rampcheck - Unsur Teknis Penunjang
        ############################################
        $dataRampcheckTeknisPenunjang = [
            "rampcheck_id" => $rampcheckID,
            "rampcheck_utp_sp_dpn" => $data["rampcheck_utp_sp_dpn"],
            "rampcheck_utp_sp_blk" => $data["rampcheck_utp_sp_blk"],
            "rampcheck_utp_bk_kcd" => $data["rampcheck_utp_bk_kcd"],
            "rampcheck_utp_bk_pu" => $data["rampcheck_utp_bk_pu"],
            "rampcheck_utp_bk_kru" => $data["rampcheck_utp_bk_kru"],
            "rampcheck_utp_bk_krp" => $data["rampcheck_utp_bk_krp"],
            "rampcheck_utp_bk_ldt" => $data["rampcheck_utp_bk_ldt"],
            "rampcheck_utp_ktd_jtd" => $data["rampcheck_utp_ktd_jtd"],
            "rampcheck_utp_pk_bc" => $data["rampcheck_utp_pk_bc"],
            "rampcheck_utp_pk_sp" => $data["rampcheck_utp_pk_sp"],
            "rampcheck_utp_pk_dkr" => $data["rampcheck_utp_pk_dkr"],
            "rampcheck_utp_pk_pbr" => $data["rampcheck_utp_pk_pbr"],
            "rampcheck_utp_pk_ls" => $data["rampcheck_utp_pk_ls"],
            "rampcheck_utp_pk_pgr" => $data["rampcheck_utp_pk_pgr"],
            "rampcheck_utp_pk_skp" => $data["rampcheck_utp_pk_skp"],
            "rampcheck_utp_pk_ptk" => $data["rampcheck_utp_pk_ptk"],
            "created_by" => $this->session->get('id'),
            "created_at" => date("Y-m-d H:i:s"),
        ];

        $rampcheckTeknisPenunjang->insert($dataRampcheckTeknisPenunjang);

        ##################################
        ## Insert Rampcheck Kesimpulan
        ##################################
        //  Decode base64 tanda tangan to .png then upload
        define('UPLOAD_DIR', 'public/uploads/ttd/');

        $img = $this->request->getPost("sigText");
        $img = str_replace('data:image/png;base64,', '', $img);
        $img = str_replace(' ', '+', $img);
        $dataImg = base64_decode($img);
        $file = UPLOAD_DIR . md5('RC-Pengemudi' . date('ymdhis')) . '.png';
        $filename = 'public/uploads/ttd/' . md5('RC-Pengemudi' . date('ymdhis')) . '.png';
        $success = file_put_contents($file, $dataImg);

        $imgPenguji = $this->request->getPost("sigTextPenguji");
        $imgPenguji = str_replace('data:image/png;base64,', '', $imgPenguji);
        $imgPenguji = str_replace(' ', '+', $imgPenguji);
        $dataImgPenguji = base64_decode($imgPenguji);
        $filePenguji = UPLOAD_DIR . md5('RC-Penguji' . date('ymdhis')) . '.png';
        $filenamePenguji = 'public/uploads/ttd/' . md5('RC-Penguji' . date('ymdhis')) . '.png';
        $successPenguji = file_put_contents($filePenguji, $dataImgPenguji);

        $imgPenyidik = $this->request->getPost("sigTextPenyidik");
        $imgPenyidik = str_replace('data:image/png;base64,', '', $imgPenyidik);
        $imgPenyidik = str_replace(' ', '+', $imgPenyidik);
        $dataImgPenyidik = base64_decode($imgPenyidik);
        $filePenyidik = UPLOAD_DIR . md5('RC-Penyidik' . date('ymdhis')) . '.png';
        $filenamePenyidik = 'public/uploads/ttd/' . md5('RC-Penyidik' . date('ymdhis')) . '.png';
        $successPenyidik = file_put_contents($filePenyidik, $dataImgPenyidik);
        //Decode base64 tanda tangan to .png then upload

        $dataRampcheckKesimpulan = [
            "rampcheck_id" => $rampcheckID,
            "rampcheck_kesimpulan_status" => $data["rampcheck_kesimpulan_status"],
            "rampcheck_kesimpulan_catatan" => strtoupper($data["rampcheck_kesimpulan_catatan"]),
            "rampcheck_kesimpulan_ttd_pengemudi" => $filename,
            "rampcheck_kesimpulan_ttd_penguji" => $filenamePenguji,
            "rampcheck_kesimpulan_nama_penguji" => strtoupper($data["rampcheck_kesimpulan_nama_penguji"]),
            "rampcheck_kesimpulan_no_penguji" => strtoupper($data["rampcheck_kesimpulan_no_penguji"]),
            "rampcheck_kesimpulan_ttd_penyidik" => $filenamePenyidik,
            "rampcheck_kesimpulan_nama_penyidik" => strtoupper($data["rampcheck_kesimpulan_nama_penyidik"]),
            "rampcheck_kesimpulan_no_penyidik" => strtoupper($data["rampcheck_kesimpulan_no_penyidik"]),
            "created_by" => $this->session->get('id'),
            "created_at" => date("Y-m-d H:i:s"),
            "document_rampcheck_id" => $data["filename"],
        ];

        $rampcheckKesimpulan->insert($dataRampcheckKesimpulan);

        //  echo 'Last Insert ID is: '. $rampcheckID;

        if ($this->db->transStatus() === false) {
            $this->db->transRollback();
            $this->db->transComplete();
            echo json_encode(array('success' => false, 'message' => $this->rampcheckModel->db->error()));
            // return false;
        } else {

            $this->db->transCommit();
            $this->db->transComplete();
            echo json_encode(array('success' => true, 'message' => "Data Rampcheck Berhasil disimpan"));
            // return true;
        }

    }

    public function rampcheck_edit()
    {
        parent::_authEdit(function () {
            $data = $this->request->getPost();
            $id = $this->request->getPost('id');
            $query = "SELECT a.id, a.rampcheck_no, a.rampcheck_date, f.jenis_lokasi_name, h.terminal_name, a.rampcheck_pengemudi, a.rampcheck_umur_pengemudi, a.rampcheck_po_name, a.rampcheck_noken, a.rampcheck_stuk, g.kategori_angkutan_name AS jenis_angkutan_name, a.rampcheck_trayek AS trayek_name,
          b.rampcheck_adm_ku, b.rampcheck_adm_kpr, b.rampcheck_adm_kpc, b.rampcheck_adm_sim,
          d.rampcheck_utu_lukd, d.rampcheck_utu_lukj, d.rampcheck_utu_lpad,  d.rampcheck_utu_lpaj, d.rampcheck_utu_lm, d.rampcheck_utu_lr, d.rampcheck_utu_kru, d.rampcheck_utu_krp, d.rampcheck_utu_kbd, d.rampcheck_utu_kbb, d.rampcheck_utu_skp, d.rampcheck_utu_pk, d.rampcheck_utu_pkw, d.rampcheck_utu_pd, d.rampcheck_utu_jd, d.rampcheck_utu_apk, d.rampcheck_utu_apar,
          c.rampcheck_utp_sp_dpn, c.rampcheck_utp_sp_blk, c.rampcheck_utp_bk_kcd, c.rampcheck_utp_bk_pu, c.rampcheck_utp_bk_kru, c.rampcheck_utp_bk_krp, c.rampcheck_utp_bk_ldt, c.rampcheck_utp_ktd_jtd, c.rampcheck_utp_pk_bc, c.rampcheck_utp_pk_sp, c.rampcheck_utp_pk_dkr, c.rampcheck_utp_pk_pbr, c.rampcheck_utp_pk_ls, c.rampcheck_utp_pk_pgr, c.rampcheck_utp_pk_skp, c.rampcheck_utp_pk_ptk,
          e.rampcheck_kesimpulan_status, e.rampcheck_kesimpulan_catatan, e.rampcheck_kesimpulan_ttd_pengemudi, e.rampcheck_kesimpulan_nama_penguji, e.rampcheck_kesimpulan_no_penguji, e.rampcheck_kesimpulan_ttd_penguji, e.rampcheck_kesimpulan_nama_penyidik, e.rampcheck_kesimpulan_no_penyidik, e.rampcheck_kesimpulan_ttd_penyidik, a.rampcheck_pengemudi, a.rampcheck_jenis_angkutan_id, a.rampcheck_jenis_lokasi_id, a.rampcheck_nama_lokasi, a.rampcheck_trayek, a.rampcheck_sticker_no
          FROM t_rampcheck a
          JOIN t_rampcheck_adm b ON b.rampcheck_id = a.id
          JOIN t_rampcheck_utp c ON c.rampcheck_id = a.id
          JOIN t_rampcheck_utu d ON d.rampcheck_id = a.id
          JOIN t_rampcheck_kesimpulan e ON e.rampcheck_id = a.id
          JOIN m_jenis_lokasi f ON f.id = a.rampcheck_jenis_lokasi_id
          JOIN m_kategori_angkutan g ON g.id = a.rampcheck_jenis_angkutan_id
          JOIN m_terminal h ON h.id = a.rampcheck_nama_lokasi
          WHERE a.is_deleted = 0 and a.id = '" . $id . "' ";

            parent::_edit('t_rampcheck', $data, null, $query);
        });
    }

    public function rampcheck_delete()
    {

        $id = $this->request->getPost('id');

        $this->rampcheckModel->deleteRampcheck($id);

        if ($this->rampcheckModel->deleteRampcheck($id)) {
            echo json_encode(array('success' => true, 'message' => "Data berhasil dihapus"));
        } else {
            echo json_encode(array('success' => false, 'message' => $this->rampcheckModel->db->error()));
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
        $data['data_excel'] = $this->rampcheckModel->export_view($url_export, $filter);

        $html = view('App\Modules\Rampcheck\Views\export\\' . $url . '_export', $data);

        $mpdf = new \Mpdf\Mpdf(['setAutoTopMargin' => 'stretch', 'setAutoBottomMargin' => 'stretch']);

        // if (isset($_GET['o'])) {
        //     if ($_GET['o']=='l') {
        //         $mpdf->AddPage('L');
        //     }
        // }
        $mpdf->SetHTMLHeader('
        <div style="text-align: center;"><img src="' . base_url() . '/assets/img/hubdat.png" style="display: block; padding-bottom: 10px; width: 30%;"></div>
        <div style="text-align: center; font-size: 18px; font-weight: bold; letter-spacing: 3px;">FORMULIR INSPEKSI KESELAMATAN <br> PEMERIKSAAN KENDARAAN UMUM</div>
        <hr style="height:2px;border-width:0;color:gray;background-color:gray">
        ');
        $mpdf->SetHTMLFooter('
          <div style="text-align: center;"><img src="' . base_url() . '/assets/img/logo.png" style="display: block; width: 20%;"></div>
          <div style="text-align: left; font-size: 8px; font-style: italic: color:gray;">Printed on ' . date('d/m/Y H:i:s') . ' from IP ' . $ipaddress . ' by ' . $user . ' </div>');
        $mpdf->SetWatermarkImage(base_url() . '/assets/img/dishubdat.png');
        $mpdf->watermarkImageAlpha = 0.05;
        $mpdf->showWatermarkImage = true;
        $mpdf->WriteHTML($html);
        $this->response->setHeader('Content-Type', 'application/pdf');
        $mpdf->Output($url . '-' . date('d-m-Y H:i:s') . '.pdf', 'I');
    }

}
