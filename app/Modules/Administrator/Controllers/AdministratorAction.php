<?php

namespace App\Modules\Administrator\Controllers;

use App\Core\BaseController;
use App\Modules\Administrator\Models\AdministratorModel;

class AdministratorAction extends BaseController
{
    private $administratorModel;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->administratorModel = new AdministratorModel();
    }

    public function index()
    {
        return redirect()->to(base_url());
    }

    public function manmodul_load()
    {
        parent::_authLoad(function () {
            $query = "select a.* from s_module a where a.is_deleted = 0";
            $where = ["a.module_url", "a.module_name"];

            parent::_loadDatatable($query, $where, $this->request->getPost());
        });
    }

    public function manmodul_save()
    {
        parent::_authInsert(function () {
            parent::_insert('s_module', $this->request->getPost());
        });
    }

    public function manmodul_edit()
    {
        parent::_authEdit(function () {
            parent::_edit('s_module', $this->request->getPost());
        });
    }

    public function manmodul_delete()
    {
        parent::_authDelete(function () {
            parent::_delete('s_module', $this->request->getPost());
        });
    }

    public function manmenu_load()
    {
        parent::_authLoad(function () {
            $query = "select a.*, b.module_name, c.menu_name as menu_parent from s_menu a
            left join s_module b on a.module_id = b.id
            left join s_menu c on a.menu_id = c.id
            where a.is_deleted = 0";
            $where = ["a.menu_url", "a.menu_name", "b.module_name", "c.menu_name"];

            parent::_loadDatatable($query, $where, $this->request->getPost());
        });
    }

    public function manmenu_save()
    {
        parent::_authInsert(function () {
            $data = $this->request->getPost();
            $data['menu_id'] = $this->request->getPost('menu_id') == "" ? null : $this->request->getPost('menu_id');
            parent::_insert('s_menu', $data);
        });
    }

    public function manmenu_edit()
    {
        parent::_authEdit(function () {
            parent::_edit('s_menu', $this->request->getPost());
        });
    }

    public function manmenu_delete()
    {
        parent::_authDelete(function () {
            parent::_delete('s_menu', $this->request->getPost());
        });
    }

    public function manjenisuser_load()
    {
        parent::_authLoad(function () {
            $query = "select a.* from s_user_web_role a where a.is_deleted = 0";
            $where = ["a.user_web_role_name"];

            parent::_loadDatatable($query, $where, $this->request->getPost());
        });
    }

    public function manjenisuser_save()
    {
        parent::_authInsert(function () {
            parent::_insert('s_user_web_role', $this->request->getPost());
        });
    }

    public function manjenisuser_edit()
    {
        parent::_authEdit(function () {
            parent::_edit('s_user_web_role', $this->request->getPost());
        });
    }

    public function manjenisuser_delete()
    {
        parent::_authDelete(function () {
            parent::_delete('s_user_web_role', $this->request->getPost());
        });
    }

    public function manuser_load()
    {
        parent::_authLoad(function () {
            $user = $this->db->query('select * from m_user_web where id = ' . $this->session->get('id'))->getRow();

            if ($user->instansi_detail_id != null) {
                $query = "select a.*, b.user_web_role_name, c.instansi_detail_name 
                            from m_user_web a
                            join (
                                select a.id, a.instansi_detail_name 
                                from m_instansi_detail a
                                join (
                                    select b.*
                                    from m_user_web a
                                    join m_instansi_detail b
                                    on a.instansi_detail_id = b.id
                                    where a.id = " . $user->id . "
                                    and b.is_deleted = 0
                                ) b
                                on a.instansi_detail_id = b.id
                                where a.is_deleted = 0
                            ) d
                            on a.instansi_detail_id = d.id
                            left join s_user_web_role b 
                            on a.user_web_role_id = b.id
                            left join m_instansi_detail c 
                            on a.instansi_detail_id = c.id
                            where a.is_deleted = 0";
            } else {
                $query = "SELECT a.*, b.user_web_role_name
                            FROM m_user_web a
                            LEFT JOIN s_user_web_role b ON b.id = a.user_web_role_id
                            WHERE a.is_deleted = 0";
            }

            $where = ["a.user_web_name", "a.user_web_username", "a.user_web_email", "b.user_web_role_name", "c.instansi_detail_name"];

            parent::_loadDatatable($query, $where, $this->request->getPost());
        });
    }

    public function manuser_save()
    {
        parent::_authInsert(function () {
            $data = $this->request->getPost();
            $nip = $this->request->getPost('user_web_nik');

            if ($data['id'] != '') {
                if (!$this->administratorModel->checkExistingPass($data['id'], $data['user_web_password'])) {
                    $encSHA512 = parent::sha512($data['user_web_password'], getenv('app.salt'));
                    $data['user_web_password'] = base64_encode($encSHA512);
                }
                parent::_insert('m_user_web', $data);
            } else {
                if ($this->administratorModel->checkUsername($data['user_web_username'])) {
                    if ($this->administratorModel->checkEmailuser($data['user_web_email'])) {
                        $encSHA512 = parent::sha512($data['user_web_password'], getenv('app.salt'));
                        $data['user_web_password'] = base64_encode($encSHA512);
                        parent::_insert('m_user_web', $data);
                    } else {
                        echo json_encode(array('success' => false, 'message' => "email sudah terpakai, silahkan menginput email lainnya"));
                    }
                } else {
                    echo json_encode(array('success' => false, 'message' => "username sudah terpakai, silahkan menginput username lainnya"));
                }
            }
        });
    }

    public function manuser_edit()
    {
        parent::_authEdit(function () {
            $data = $this->request->getPost();
            $query = "SELECT a.* from m_user_web a where a.is_deleted = 0 and a.id = '" . $this->request->getPost('id') . "' ";
            parent::_edit('m_user_web', $data, null, $query);
        });
    }

    public function manuser_delete()
    {
        parent::_authDelete(function () {
            parent::_delete('m_user_web', $this->request->getPost());
        });
    }

    public function manuser_sync()
    {
        parent::_authEdit(function () {
            if ($this->administratorModel->syncEmailWebMobile($this->request->getPost())) {
                echo json_encode(array('success' => true, 'message' => 'sync email mobile & web success'));
            } else {
                echo json_encode(array('success' => false, 'message' => $this->administratorModel->db->error()));
            }
            // parent::_edit('m_user_web', $this->request->getPost());
        });
    }

    public function manhakakses_save()
    {
        parent::_authInsert(function () {
            $number_menu = count($this->request->getPost('idmenu'));
            $deleted = explode(",", $this->request->getPost('delete'));

            $previlagesData = [];
            for ($i = 0; $i < $number_menu; $i++) {
                $previlagesData[] = [
                    "id" => $this->request->getPost('id')[$i],
                    "menu_id" => $this->request->getPost('idmenu')[$i],
                    "v" => unwrap_null(@$this->request->getPost('v')[$i], "0"),
                    "i" => unwrap_null(@$this->request->getPost('i')[$i], "0"),
                    "d" => unwrap_null(@$this->request->getPost('d')[$i], "0"),
                    "e" => unwrap_null(@$this->request->getPost('e')[$i], "0"),
                    "o" => unwrap_null(@$this->request->getPost('o')[$i], "0"),
                    "user_web_role_id" => $this->request->getPost('iduser'),
                    "created_by" => $this->session->get('id'),
                    "created_at" => date("Y-m-d H:i:s"),
                ];
            }

            if ($this->administratorModel->saveHakAkses($previlagesData, $deleted, $this->request->getPost('iduser'))) {
                echo json_encode(array('success' => true, 'message' => $previlagesData));
            } else {
                echo json_encode(array('success' => false, 'message' => $this->administratorModel->db->error()));
            }
        });
    }

    public function excel()
    {
        $url = uri_segment("3");
        header("Content-Type:   application/vnd.ms-excel; charset=utf-8");
        header("Content-Disposition: attachment; filename=" . $url . "-" . date('d-m-Y H:i:s') . ".xls"); //File name extension was wrong
        header("Expires: 0");
        header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
        header("Cache-Control: private", false);

        $url_export = $url . '_export';
        $filter = $_GET['search'];
        $data['data_url'] = uri_segment("2");
        $data['data_excel'] = $this->administratorModel->export_view($url_export, $filter);

        echo view('App\Modules\Administrator\Views\export\\' . $url . '_export', $data);
    }

    public function pdf()
    {
        $url = uri_segment("3");
        $url_export = $url . '_export';
        $filter = $_GET['search'];
        $data['data_url'] = uri_segment("2");
        $data['data_excel'] = $this->administratorModel->export_view($url_export, $filter);

        $html = view('App\Modules\Administrator\Views\export\\' . $url . '_export', $data);

        $mpdf = new \Mpdf\Mpdf();

        if (isset($_GET['o'])) {
            if ($_GET['o'] == 'l') {
                $mpdf->AddPage('L');
            }
        }

        $mpdf->WriteHTML($html);
        $this->response->setHeader('Content-Type', 'application/pdf');
        $mpdf->Output($url . '-' . date('d-m-Y H:i:s') . '.pdf', 'I');
    }

    function resize_image($image_name, $new_width, $new_height, $uploadDir, $moveToDir)
    {
        $path = $uploadDir . '/' . $image_name;

        $mime = getimagesize($path);

        if ($mime['mime'] == 'image/png') {
            $src_img = imagecreatefrompng($path);
        }
        if ($mime['mime'] == 'image/jpg' || $mime['mime'] == 'image/jpeg' || $mime['mime'] == 'image/pjpeg') {
            $src_img = imagecreatefromjpeg($path);
        }

        $old_x          =   imageSX($src_img);
        $old_y          =   imageSY($src_img);

        if ($old_x > $old_y) {
            $thumb_w    =   $new_width;
            $thumb_h    =   $old_y * ($new_height / $old_x);
        }

        if ($old_x < $old_y) {
            $thumb_w    =   $old_x * ($new_width / $old_y);
            $thumb_h    =   $new_height;
        }

        if ($old_x == $old_y) {
            $thumb_w    =   $new_width;
            $thumb_h    =   $new_height;
        }

        $dst_img        =   ImageCreateTrueColor($thumb_w, $thumb_h);

        imagecopyresampled($dst_img, $src_img, 0, 0, 0, 0, $thumb_w, $thumb_h, $old_x, $old_y);


        // New save location
        $new_thumb_loc = $moveToDir . $image_name;

        if ($mime['mime'] == 'image/png') {
            $result = imagepng($dst_img, $new_thumb_loc, 9);
        }
        if ($mime['mime'] == 'image/jpg' || $mime['mime'] == 'image/jpeg' || $mime['mime'] == 'image/pjpeg') {
            $result = imagejpeg($dst_img, $new_thumb_loc, 80);
        }

        imagedestroy($dst_img);
        imagedestroy($src_img);

        return $result;
    }

    public function mantarif_load()
    {
        parent::_authLoad(function () {
            $query = "SELECT a.*, b.nama AS tenant_name
                        FROM tarif a
                        LEFT JOIN ref_tenant b ON b.id = a.kategori
                        WHERE a.is_aktif = 0";
            $where = ["a.jenis", "a.tarif", "a.tarif_normal", "b.nama"];

            parent::_loadDatatable($query, $where, $this->request->getPost());
        });
    }

    public function mantarif_save()
    {
        parent::_authInsert(function () {
            parent::_insert('tarif', $this->request->getPost());
        });
    }

    public function mantarif_edit()
    {
        parent::_authEdit(function () {
            parent::_edit('tarif', $this->request->getPost());
        });
    }

    public function mantarif_delete()
    {
        parent::_authDelete(function () {
            parent::_delete('tarif', $this->request->getPost());
        });
    }

    public function narasitiket_load()
    {
        parent::_authLoad(function () {
            $query = "SELECT a.* FROM ref_narasi_tiket a";
            $where = ["a.header", "a.footer"];

            parent::_loadDatatable($query, $where, $this->request->getPost());
        });
    }

    public function narasitiket_save()
    {
        parent::_authInsert(function () {
            parent::_insert('ref_narasi_tiket', $this->request->getPost());
        });
    }

    public function narasitiket_edit()
    {
        parent::_authEdit(function () {
            parent::_edit('ref_narasi_tiket', $this->request->getPost());
        });
    }

    public function narasitiket_delete()
    {
        parent::_authDelete(function () {
            parent::_delete('ref_narasi_tiket', $this->request->getPost());
        });
    }

    public function manpegawai_load()
    {
        parent::_authLoad(function () {
            $query = "SELECT a.* FROM pegawai a";
            $where = ["a.header", "a.footer"];

            parent::_loadDatatable($query, $where, $this->request->getPost());
        });
    }

    public function manpegawai_upload()
    {
        $input = $this->validate([
            'file' => [
                'uploaded[file]',
                'mime_in[file,image/jpg,image/jpeg,image/png]',
                'max_size[file,1024]',
            ],
        ]);

        if (!$input) {
            $msg = array("status" => 0, "msg" => $this->validator->getErrors());
        } else {
            $x_file = $this->request->getFile('file');

            $nama_file = $x_file->getRandomName();
            $image = \Config\Services::image()
                ->withFile($x_file)
                ->resize(480, 480, true, 'width')
                ->save(FCPATH . 'public/uploads/foto_pegawai/' . $nama_file);
            if ($image) {
                $msg = array("status" => 1, "msg" => "File Has Been Uploaded", "path" => '/public/uploads/foto_pegawai/' . $nama_file);
            } else {
                $msg = array("status" => 0, "msg" => $this->upload->display_errors());
            }
            echo json_encode($msg);
        }
    }

    public function manpegawai_save()
    {
        $data = $this->request->getPost();
        unset($data['id']);
        if ($data['jabtext'] == 'PRAMUGARA') {
            if ($this->db->table('user_pramugara')->insert($data)) {
                echo json_encode(array("status" => 1, "msg" => "Data Berhasil Disimpan"));
            } else {
                echo json_encode(array("status" => 0, "msg" => "Data Gagal Disimpan"));
            }
        } else if ($data['jabtext'] == 'PRAMUGARI') {
            if ($this->db->table('user_pramugari')->insert($data)) {
                echo json_encode(array("status" => 1, "msg" => "Data Berhasil Disimpan"));
            } else {
                echo json_encode(array("status" => 0, "msg" => "Data Gagal Disimpan"));
            }
        } else {
            if ($this->db->table('user_halte')->insert($data)) {
                echo json_encode(array("status" => 1, "msg" => "Data Berhasil Disimpan"));
            } else {
                echo json_encode(array("status" => 0, "msg" => "Data Gagal Disimpan"));
            }
        }
    }

    public function manpegawai_edit()
    {
        parent::_authEdit(function () {
            parent::_edit('pegawai', $this->request->getPost());
        });
    }

    public function manpegawai_delete()
    {
        parent::_authDelete(function () {
            parent::_delete('pegawai', $this->request->getPost());
        });
    }

    public function manpos_load()
    {
        parent::_authLoad(function () {
            $query = "SELECT a.* FROM ref_narasi_tiket a";
            $where = ["a.header", "a.footer"];

            parent::_loadDatatable($query, $where, $this->request->getPost());
        });
    }

    public function manpos_save()
    {
        parent::_authInsert(function () {
            // parent::_insert('ref_narasi_tiket', $this->request->getPost());
        });
    }

    public function manpos_edit()
    {
        parent::_authEdit(function () {
            // parent::_edit('ref_narasi_tiket', $this->request->getPost());
        });
    }

    public function manpos_delete()
    {
        parent::_authDelete(function () {
            // parent::_delete('ref_narasi_tiket', $this->request->getPost());
        });
    }

    public function manjalur_load()
    {
        parent::_authLoad(function () {
            $query = "SELECT a.* FROM ref_narasi_tiket a";
            $where = ["a.header", "a.footer"];

            parent::_loadDatatable($query, $where, $this->request->getPost());
        });
    }

    public function manjalur_save()
    {
        parent::_authInsert(function () {
            // parent::_insert('ref_narasi_tiket', $this->request->getPost());
        });
    }

    public function manjalur_edit()
    {
        parent::_authEdit(function () {
            // parent::_edit('ref_narasi_tiket', $this->request->getPost());
        });
    }

    public function manjalur_delete()
    {
        parent::_authDelete(function () {
            // parent::_delete('ref_narasi_tiket', $this->request->getPost());
        });
    }

    public function manbus_load()
    {
        parent::_authLoad(function () {
            $query = "SELECT a.* FROM ref_narasi_tiket a";
            $where = ["a.header", "a.footer"];

            parent::_loadDatatable($query, $where, $this->request->getPost());
        });
    }

    public function manbus_save()
    {
        parent::_authInsert(function () {
            // parent::_insert('ref_narasi_tiket', $this->request->getPost());
        });
    }

    public function manbus_edit()
    {
        parent::_authEdit(function () {
            // parent::_edit('ref_narasi_tiket', $this->request->getPost());
        });
    }

    public function manbus_delete()
    {
        parent::_authDelete(function () {
            // parent::_delete('ref_narasi_tiket', $this->request->getPost());
        });
    }
}
