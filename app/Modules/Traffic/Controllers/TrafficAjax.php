<?php namespace App\Modules\Traffic\Controllers;

use App\Modules\Traffic\Models\TrafficModel;
use App\Core\BaseController;
use App\Libraries\DataTables;

class TrafficAjax extends BaseController
{
    private $rampcheckModel;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->rampcheckModel = new TrafficModel();
        date_default_timezone_set('Asia/Jakarta');
    }

    public function index()
    {
        return redirect()->to(base_url()); 
    }
}