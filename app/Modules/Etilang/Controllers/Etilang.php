<?php namespace App\Modules\Etilang\Controllers;

use App\Modules\Etilang\Models\EtilangModel;
use App\Core\BaseController;

class Etilang extends BaseController
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

    public function test()
    {
        $data['load_view'] = "App\Modules\Etilang\Views\\test";
        return view('App\Modules\Main\Views\layout', $data); 
    }

    public function etilang()
    {
        return parent::_authView();
    }

}
