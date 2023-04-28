<?php

namespace App\Modules\Ngi\Controllers;

use App\Core\BaseController;
use App\Modules\Ngi\Models\NgiModel;


class NgiAction extends BaseController
{
    private $NgiModel;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->NgiModel = new NgiModel();
    }

    public function index()
    {
        return redirect()->to(base_url());
    }

    public function test()
    {
        $data['load_view'] = "App\Modules\Ngi\Views\\test";
        return view('App\Modules\Main\Views\layout', $data);
    }

    public function softwarelicense_load()
    {
        parent::_authLoad(function () {
            $query = "select a.* from s_user_web_role a where a.is_deleted = 0";
            $where = ["a.user_web_role_name"];

            parent::_loadDatatable($query, $where, $this->request->getPost());
        });
    }

    public function softwarelicense_save()
    {
        parent::_authInsert(function () {
            parent::_insert('s_user_web_role', $this->request->getPost());
        });
    }

    public function softwarelicense_edit()
    {
        parent::_authEdit(function () {
            parent::_edit('s_user_web_role', $this->request->getPost());
        });
    }

    public function softwarelicense_delete()
    {
        parent::_authDelete(function () {
            parent::_delete('s_user_web_role', $this->request->getPost());
        });
    }
    
    public function laporantrouble_upload()
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
                        ->save(FCPATH . 'public/uploads/foto_laporan/' . $nama_file);
            if ($image) {
                $msg = array("status" => 1, "msg" => "File Has Been Uploaded", "path" => '/public/uploads/foto_laporan/' . $nama_file);
            } else {
                $msg = array("status" => 0, "msg" => $this->upload->display_errors());
            }
            echo json_encode($msg);
        }
    }

    // public function mantarif_load()
    // {
    //     parent::_authLoad(function () {
    //         $query = "SELECT a.* FROM tarif a WHERE a.is_aktif = 0";
    //         $where = ["a.jenis", "a.tarif", "a.tarif_normal"];

    //         parent::_loadDatatable($query, $where, $this->request->getPost());
    //     });
    // }

    // public function mantarif_save()
    // {
    //     parent::_authInsert(function () {
    //         parent::_insert('tarif', $this->request->getPost());
    //     });
    // }

    // public function mantarif_edit()
    // {
    //     parent::_authEdit(function () {
    //         parent::_edit('tarif', $this->request->getPost());
    //     });
    // }

    // public function mantarif_delete()
    // {
    //     parent::_authDelete(function () {
    //         parent::_delete('tarif', $this->request->getPost());
    //     });
    // }

}