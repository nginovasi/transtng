<?php namespace App\Modules\Po\Controllers;

use App\Modules\Po\Models\PoModel;
use App\Core\BaseController;

class PoAjax extends BaseController
{
    private $poModel;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->poModel = new PoModel();
    }

    public function index()
    {
        return redirect()->to(base_url()); 
    }

    function po_id_select_get()
    {
        $data = $this->request->getGet();
        $query = "SELECT a.id , a.po_name as 'text' FROM m_po a where a.is_deleted='0'";
        $where = ["a.po_name"];

        parent::_loadSelect2($data, $query, $where);
    }

    function po_agent_id_select_get()
    {
        $data = $this->request->getGet();
        $query = "SELECT a.id , a.po_agent_name as 'text' FROM m_po_agent a where a.is_deleted='0' and a.po_id='".$data['po_id']."'";
        $where = ["a.po_agent_name"];

        parent::_loadSelect2($data, $query, $where);
    }

    function lokprov_id_select_get()
    {
        $data = $this->request->getGet();
        $query = "SELECT a.id , a.prov as 'text' FROM m_lokprov a where a.is_deleted='0'";
        $where = ["a.prov"];

        parent::_loadSelect2($data, $query, $where);
    }

    function idkabkota_select_get()
    {
        $data = $this->request->getGet();
        $query = "SELECT a.id , a.kabkota as 'text' from m_lokabkota a where a.is_deleted='0' and  a.idprov='".$data['idprov']."'";
        $where = ["a.kabkota"];

        parent::_loadSelect2($data, $query, $where);
    }

    function trayek_id_select_get()
    {
      $data = $this->request->getGet();
      $query = "SELECT a.id , a.route_name as 'text' FROM m_route a where a.is_deleted='0' and a.kategori_angkutan_id ='".$data['kategori_angkutan_id']."'";
      $where = ["a.route_name"];

      parent::_loadSelect2($data, $query, $where);
    }

    function class_id_select_get()
    {
        $data = $this->request->getGet();
        $query = "SELECT a.id , a.class_name as 'text' FROM m_class a where a.is_deleted='0'";
        $where = ["a.class_name"];

        parent::_loadSelect2($data, $query, $where);
    }

    function kategori_angkutan_id_select_get()
    {
        $data = $this->request->getGet();
        $query = "SELECT a.id , a.kategori_angkutan_name as 'text' FROM m_kategori_angkutan a where a.is_deleted='0'";
        $where = ["a.kategori_angkutan_name"];

        parent::_loadSelect2($data, $query, $where);
    }
}
