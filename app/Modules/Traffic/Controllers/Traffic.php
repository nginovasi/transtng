<?php namespace App\Modules\Traffic\Controllers;

use App\Modules\Traffic\Models\TrafficModel;
use App\Core\BaseController;

class Traffic extends BaseController
{
    private $trafficModel;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->trafficModel = new TrafficModel();
        date_default_timezone_set('Asia/Jakarta');
    }

    public function index()
	{
		return redirect()->to(base_url()); 
	}


    public function trafficcount()
    {
        return parent::_authView();
    }

    public function livetrack()
    {
        return parent::_authView();
    }

    public function testing()
    {
        return parent::_authView();
    }
}
