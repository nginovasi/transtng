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

            // get URL Photo Profile if $nip is not null
            $curl = curl_init();

            curl_setopt_array($curl, array(
                CURLOPT_URL => 'https://api.hubdat.dephub.go.id/ehubdat/v1/sik-pegawai?nip=' . $nip,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'GET',
                CURLOPT_HTTPHEADER => array(
                    'Authorization: Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpZCI6MTAsInVzZXJfbmFtZSI6ImRpdGplbmxhdXQiLCJleHAiOjE2ODc4NzgzOTh9.j1-4obhSgpcbUI9BsD9_5OR13K-jLTMM5Mn43I9tHWw',
                ),
            ));

            $response = curl_exec($curl);

            curl_close($curl);
            $userPhoto = json_decode($response);
            $userPhotoUrl = null;
            
            if(count($userPhoto->data) > 0){
                if ($userPhoto->data[0]->foto != null || $userPhoto->data[0]->foto != '') {
                    $userPhotoUrl = $userPhoto->data[0]->foto;
                } else {
                    $userPhotoUrl = '-';
                }
            } else {
                $userPhotoUrl = '-';
            }

            if ($data['id'] != '') {
                $user = $this->db->query('select * from m_user_web where id = ' . $this->session->get('id'))->getRow();

                if (!$this->administratorModel->checkExistingPass($data['id'], $data['user_web_password'])) {
                    $data["user_web_password"] = md5($data["user_web_password"]);
                }

                if ($user->instansi_detail_id != null) {
                    $cekRoleInstansi = $this->db->query('select * from m_instansi_detail where id = ' . $data['instansi_detail_id_not_role'])->getRow();

                    $data["instansi_detail_id"] = $data['instansi_detail_id_not_role'];
                    $data["user_web_role_id"] = $cekRoleInstansi->user_web_role_id;

                    unset($data['instansi_detail_id_not_role']);
                }
                $data["user_web_photo"] = $userPhotoUrl;

                parent::_insert('m_user_web', $data);
            } else {
                if ($this->administratorModel->checkUsername($data['user_web_username'])) {
                    if ($this->administratorModel->checkEmailuser($data['user_web_email'])) {
                        $user = $this->db->query('select * from m_user_web where id = ' . $this->session->get('id'))->getRow();
                        
                        $data["user_web_password"] = md5($data["user_web_password"]);

                        if ($user->instansi_detail_id != null) {
                            $cekRoleInstansi = $this->db->query('select * from m_instansi_detail where id = ' . $data['instansi_detail_id_not_role'])->getRow();

                            $data["instansi_detail_id"] = $data['instansi_detail_id_not_role'];
                            $data["user_web_role_id"] = $cekRoleInstansi->user_web_role_id;

                            unset($data['instansi_detail_id_not_role']);
                        }
                        $data["user_web_photo"] = $userPhotoUrl;

                        parent::_insert('m_user_web', $data);

                        $getUserMobile = $this->db->query('select * from m_user_mobile where user_mobile_email = ' . '"' . $data['user_web_email'] . '"')->getRow();

                        $dataUserMobile = [
                            "user_mobile_email" => $data['user_web_email'],
                            "user_mobile_type" => "Android",
                            "user_mobile_role" => 2,
                        ];

                        if ($getUserMobile) {
                            $builder = $this->db->table('m_user_mobile');
                            $builder->where(array('id' => $getUserMobile->id));
                            $builder->update($dataUserMobile);

                            // after update by diyar 31 Mar
                            $update = $this->db->query('UPDATE m_user_web 
                                                        SET user_mobile_id = ' . $getUserMobile->id . ' 
                                                        WHERE user_web_email = "' . $data['user_web_email'] . '"');
                        } else {
                            $builder = $this->db->table('m_user_mobile');
                            $builder->insert($dataUserMobile);
                            $userMobileId = $this->db->insertID();

                            $dataUserWeb = [
                                "user_mobile_id" => $userMobileId,
                            ];

                            // before
                            // $updateUserWeb = $this->db->table('m_user_web');
                            // $updateUserWeb->where(array('user_web_email' => $data['user_web_email']));
                            // $updateUserWeb->update($dataUserWeb);

                            // after update by diyar 31 Mar
                            $update = $this->db->query('UPDATE m_user_web 
                                                        SET user_mobile_id = '.$userMobileId.' 
                                                        WHERE user_web_email = "' . $data['user_web_email'] . '"');
                        }
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
            $query = "SELECT a.*,b.id as instansi_detail_id_not_role, b.instansi_detail_name as instansi_detail_nama_not_role from m_user_web a left join m_instansi_detail b on a.instansi_detail_id=b.id and b.is_deleted='0' where a.is_deleted = 0 and a.id = '" . $this->request->getPost('id') . "' ";

            parent::_edit('m_user_web', $data, null, $query);
            // parent::_edit('m_user_web', $this->request->getPost());

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
            $query = "SELECT a.* FROM ref_narasi_tiket a";
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
        var_dump($input);
        if (!$input) {
            $msg = array("status" => 0, "msg" => "Pilih File.", "error" => $this->validator->getErrors());
            // echo json_encode(array("status" => 0, "msg" => "Pilih File.", "error" => $this->validator->getErrors()));
        } else {
            // var_dump($input);
            $x_file = $this->request->getFile('file');
            
            $nama_file = $x_file->getRandomName();
            $image = \Config\Services::image()
                        ->withFile($x_file)
                        // ->resize(720, 360, true, 'width')
                        ->save(FCPATH . 'public/uploads/foto_pegawai/' . $nama_file);
            // $x_file->move(FCPATH . 'public/uploads/foto_pegawai');

            if ($image) {
                $msg = array("status" => 1, "msg" => "File Has Been Uploaded", "path" => 'public/uploads/banner/' . $nama_file);
                // echo json_encode(array("status" => 1, "msg" => "File Has Been Uploaded", "path" => 'public/uploads/foto_pegawai/' . $nama_file));
            } else {
                $msg = array("status" => 0, "msg" => $this->upload->display_errors());
                // echo json_encode(array("status" => 0, "msg" => $this->upload->display_errors()));
            }
        }
        echo json_encode($msg);
    }

    public function manpegawai_save()
    {
        parent::_authInsert(function () {
            parent::_insert('ref_narasi_tiket', $this->request->getPost());
        });
    }

    public function manpegawai_edit()
    {
        parent::_authEdit(function () {
            parent::_edit('ref_narasi_tiket', $this->request->getPost());
        });
    }

    public function manpegawai_delete()
    {
        parent::_authDelete(function () {
            parent::_delete('ref_narasi_tiket', $this->request->getPost());
        });
    }
}