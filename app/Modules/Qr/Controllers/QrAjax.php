<?php

namespace App\Modules\Qr\Controllers;

use App\Core\BaseController;
use App\Modules\Qr\Models\QrModel;

class QrAjax extends BaseController
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

}
