<?php namespace App\Modules\Jto\Controllers;

use App\Modules\Jto\Models\JtoModel;
use App\Core\BaseController;

class Jto extends BaseController
{
    private $jtoModel;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->jtoModel = new JtoModel();
    }

    public function index()
	{
		return redirect()->to(base_url()); 
	}

    public function test()
    {
        $data['load_view'] = "App\Modules\Jto\Views\\test";
        return view('App\Modules\Main\Views\layout', $data); 
    }

    public function jtomaster()
    {
        return parent::_authView();
    }

    public function jtopenindakan()
    {
        return parent::_authView();
    }

}
