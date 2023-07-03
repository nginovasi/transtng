<?php

namespace App\Modules\Qr\Controllers;

use App\Modules\Qr\Models\QrModel;
use App\Core\BaseController;

// test push mamen
class Qr extends BaseController
{
    private $qrModel;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->qrModel = new QrModel();
    }

    public function index()
    {
        return redirect()->to(base_url());
    }

    public function test()
    {
        $data['load_view'] = "App\Modules\Qr\Views\\test";
        return view('App\Modules\Main\Views\layout', $data);
    }

    public function qrlogin()
    {
        $data['user'] = $this->qrModel->getUserDetail();

        return parent::_authView($data);
    }

    public function qrlogout()
    {
        $data['user'] = $this->qrModel->getUserDetail();

        return parent::_authView($data);
    }

}
