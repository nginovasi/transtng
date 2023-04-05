<?php namespace App\Modules\Spda\Controllers;

use App\Modules\Spda\Models\SpdaModel;
use App\Core\BaseController;

class Spda extends BaseController
{
    private $spdaModel;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->spdaModel = new SpdaModel();
        date_default_timezone_set('Asia/Jakarta');
    }

    public function index()
	{
		return redirect()->to(base_url()); 
	}

    public function test()
    {
        $data['page_title'] = 'Spda Data';
        $data['load_view'] = "App\Modules\Spda\Views\\spda";
        return view('App\Modules\Main\Views\layout', $data); 
    }

    public function spda()
    {
        return parent::_authView();
    }
}
