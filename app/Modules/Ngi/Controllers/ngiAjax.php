<?php

namespace App\Modules\Ngi\Controllers;

use App\Core\BaseController;
use App\Modules\Ngi\Models\NgiModel;

class NgiAjax extends BaseController
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

}