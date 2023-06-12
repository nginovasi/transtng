<?php

namespace App\Modules\Administrator\Controllers;

use App\Modules\Administrator\Models\AdministratorModel;
use App\Core\BaseController;

// test push mamen
class Administrator extends BaseController
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

    public function manmodul()
    {
        return parent::_authView();
    }

    public function manmenu()
    {
        $data['modules'] = $this->administratorModel->getModules();

        return parent::_authView($data);
    }

    public function manjenisuser()
    {
        return parent::_authView();
    }

    public function manhakakses()
    {
        $data['jenisusers'] = $this->administratorModel->getUserRoles();

        return parent::_authView($data);
    }

    public function manuser()
    {
        $data['jenisusers'] = $this->administratorModel->getUserRoles();
        $data['user'] = $this->administratorModel->getUserDetail();

        return parent::_authView($data);
    }

    public function mantarif()
    {
        return parent::_authView();
    }

    public function narasitiket()
    {
        return parent::_authView();
    }

    public function manpegawai()
    {
        return parent::_authView();
    }

    public function manpool()
    {
        return parent::_authView();
    }

    public function manjalur()
    {
        return parent::_authView();
    }

    public function manhaltebus()
    {
        return parent::_authView();
    }
}
