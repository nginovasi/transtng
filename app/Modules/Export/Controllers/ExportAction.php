<?php namespace App\Modules\Export\Controllers;

use App\Modules\Export\Models\ExportModel;
use App\Core\BaseController;

class ExportAction extends BaseController
{
    private $exportModel;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->exportModel = new ExportModel();
    }

    public function index()
    {
        return redirect()->to(base_url()); 
    }
}
