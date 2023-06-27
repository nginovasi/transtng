<?php

namespace App\Modules\Ngi\Controllers;

use App\Modules\Ngi\Models\NgiModel;
use App\Core\BaseController;

class Ngi extends BaseController
{
    private $NgiModel;

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

    public function dataalat()
    {
        return parent::_authView();
    }
    
    public function appupdate()
    {
        $latestVersion = $this->db->query("SELECT MAX(app_version) as app_version 
                                            FROM ref_haltebis 
                                            WHERE is_deleted = 0
                                            AND is_dev = 0
                                            AND is_active = 0")->getRow();

        $data['latest_version'] = $latestVersion->app_version;
        
        return parent::_authView($data);
    }

}
