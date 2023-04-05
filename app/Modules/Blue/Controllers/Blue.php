<?php namespace App\Modules\Blue\Controllers;

use App\Modules\Blue\Models\BlueModel;
use App\Core\BaseController;

class Blue extends BaseController
{
    private $blueModel;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->blueModel = new BlueModel();
    }

    public function index()
	{
		return redirect()->to(base_url()); 
	}

    public function test()
    {
        $data['load_view'] = "App\Modules\Blue\Views\\test";
        return view('App\Modules\Main\Views\layout', $data); 
    }

    public function blue()
    {
        return parent::_authView();
    }

    // ignore blue rfid, blue >< blue rfid
    public function bluerfidlist()
    {
        return parent::_authView();
    }

}
