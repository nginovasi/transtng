<?php namespace App\Modules\Spionam\Controllers;

use App\Modules\Spionam\Models\SpionamModel;
use App\Core\BaseController;

class Spionam extends BaseController
{
    private $spionamModel;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->spionamModel = new SpionamModel();
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

    public function spionam()
    {
        return parent::_authView();
    }
}
