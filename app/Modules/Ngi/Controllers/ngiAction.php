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

    public function dataalat_load()
    {
        parent::_authLoad(function () {
            $query = "SELECT * 
                        FROM ref_midtid 
                        WHERE is_deleted = 0 
                        AND is_dev = 0
                        AND is_active = 0";

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

}