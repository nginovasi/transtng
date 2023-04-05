<?php namespace App\Modules\Blue\Controllers;

use App\Modules\Blue\Models\BlueModel;
use App\Core\BaseController;

class BlueAjax extends BaseController
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
}
