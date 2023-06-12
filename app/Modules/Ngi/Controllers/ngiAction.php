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

    // software licence not use
    // public function softwarelicense_load()
    // {
    //     parent::_authLoad(function () {
    //         $query = "select * from ngi_license where is_deleted = 0";

    //         $where = ["imei", "enkripsi"];

    //         parent::_loadDatatable($query, $where, $this->request->getPost());
    //     });
    // }

    // public function softwarelicense_save()
    // {
    //     parent::_authInsert(function () {
    //         $data = $this->request->getPost();

    //         parent::_insertv2('ngi_license', $data);
    //     });
    // }

    // public function softwarelicense_edit()
    // {
    //     parent::_authEdit(function () {
    //         parent::_edit('ngi_license', $this->request->getPost());
    //     });
    // }

    // public function softwarelicense_delete()
    // {
    //     parent::_authDelete(function () {
    //         parent::_deletev2('ngi_license', $this->request->getPost());
    //     });
    // }

    public function dataalat_load()
    {
        parent::_authLoad(function () {
            $query = "select * from ref_midtid where is_deleted = 0";

            $where = ["device_id", "no_telp"];

            parent::_loadDatatable($query, $where, $this->request->getPost());
        });
    }

    public function dataalat_save()
    {
        parent::_authInsert(function () {
            $data = $this->request->getPost();

            $cekEmpty = parent::_cekEmptyValue($data);

            parent::_insertv2('ref_midtid', $cekEmpty);
        });
    }

    public function dataalat_edit()
    {
        parent::_authEdit(function () {
            parent::_edit('ref_midtid', $this->request->getPost());
        });
    }

    public function dataalat_delete()
    {
        parent::_authDelete(function () {
            parent::_deletev2('ref_midtid', $this->request->getPost());
        });
    }

    public function appupdate_load()
    {
        parent::_authLoad(function () {
            $query = "SELECT *
                        FROM ref_haltebis
                        WHERE is_deleted = 0";

            $where = ["name", "device_id", "app_version"];

            parent::_loadDatatable($query, $where, $this->request->getPost());
        });
    }
    
    // public function laporantrouble_upload()
    // {
    //     $input = $this->validate([
    //         'file' => [
    //             'uploaded[file]',
    //             'mime_in[file,image/jpg,image/jpeg,image/png]',
    //             'max_size[file,1024]',
    //         ],
    //     ]);

    //     if (!$input) {
    //         $msg = array("status" => 0, "msg" => $this->validator->getErrors());
    //     } else {
    //         $x_file = $this->request->getFile('file');
            
    //         $nama_file = $x_file->getRandomName();
    //         $image = \Config\Services::image()
    //                     ->withFile($x_file)
    //                     ->resize(480, 480, true, 'width')
    //                     ->save(FCPATH . 'public/uploads/foto_laporan/' . $nama_file);
    //         if ($image) {
    //             $msg = array("status" => 1, "msg" => "File Has Been Uploaded", "path" => '/public/uploads/foto_laporan/' . $nama_file);
    //         } else {
    //             $msg = array("status" => 0, "msg" => $this->upload->display_errors());
    //         }
    //         echo json_encode($msg);
    //     }
    // }

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