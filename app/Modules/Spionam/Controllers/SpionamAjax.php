<?php namespace App\Modules\Spionam\Controllers;

use App\Modules\Spionam\Models\SpionamModel;
use App\Core\BaseController;

class SpionamAjax extends BaseController
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
}
