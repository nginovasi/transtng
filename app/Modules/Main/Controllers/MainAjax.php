<?php namespace App\Modules\Main\Controllers;

use App\Modules\Main\Models\MainModel;
use CodeIgniter\Controller;
use App\Core\BaseController;

class MainAjax extends BaseController
{
    private $mainModel;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->mainModel = new MainModel();
    }

    public function index()
    {
        return redirect()->to(base_url()); 
    }

    public function findByKoridor()
    {
        $data = $this->request->getGet();
        $query = "SELECT a.id, a.jalur AS 'text' FROM ref_jalur a WHERE a.is_deleted = 0"; //QUERY belum fix
        $where = ["a.jalur"];
        parent::_loadSelect2($data, $query, $where);
    }
}
