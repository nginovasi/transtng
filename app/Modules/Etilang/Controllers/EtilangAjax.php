<?php namespace App\Modules\Etilang\Controllers;

use App\Modules\Etilang\Models\EtilangModel;
use App\Core\BaseController;

class EtilangAjax extends BaseController
{
    private $etilangModel;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->etilangModel = new EtilangModel();
    }

    public function index()
    {
        return redirect()->to(base_url()); 
    }
}
