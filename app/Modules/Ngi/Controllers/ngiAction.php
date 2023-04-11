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

    public function test()
    {
        $data['load_view'] = "App\Modules\Administrator\Views\\test";
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