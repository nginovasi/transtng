<?php namespace App\Modules\Posko\Controllers;

use App\Modules\Posko\Models\PoskoModel;
use App\Core\BaseController;

class PoskoAjax extends BaseController
{
    private $poskoModel;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->poskoModel = new PoskoModel();
    }

    public function index()
    {
        return redirect()->to(base_url()); 
    }

    public function posko_id_select_get()
    {
        $data = $this->request->getGet();
        $query = "SELECT a.id , a.posko_mudik_name as 'text' FROM m_posko_mudik a where a.is_deleted='0'";
        $where = ["a.posko_mudik_name"];

        parent::_loadSelect2($data, $query, $where);
    }

    public function user_id_select_get()
    {
        $data = $this->request->getGet();
        $query = "SELECT a.id , concat_ws('',a.user_web_username,' (',a.user_web_name,')') as 'text' FROM m_user_web a where a.is_deleted='0'";
        $where = ["a.user_web_username","a.user_web_name"];

        parent::_loadSelect2($data, $query, $where);
    }

    public function klas_posko_id_select_get()
    {
        $data = $this->request->getGet();
        $query = "SELECT a.id , a.klas_posko as 'text' FROM m_klas_posko a where a.is_deleted='0'";
        $where = ["a.klas_posko"];

        parent::_loadSelect2($data, $query, $where);
    }

    public function lokprov_id_select_get()
    {
        $data = $this->request->getGet();
        $query = "SELECT a.id , a.prov as 'text' FROM m_lokprov a where a.is_deleted='0'";
        $where = ["a.prov"];

        parent::_loadSelect2($data, $query, $where);
    }

    public function idkabkota_select_get()
    {
        $data = $this->request->getGet();
        $query = "SELECT a.id , a.kabkota as 'text' from m_lokabkota a where a.is_deleted='0' and  a.idprov='" . $data['idprov'] . "'";
        $where = ["a.kabkota"];

        parent::_loadSelect2($data, $query, $where);
    }
}
