<?php namespace App\Modules\Jto\Controllers;

use App\Modules\Jto\Models\JtoModel;
use App\Core\BaseController;

class JtoAjax extends BaseController
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
}
