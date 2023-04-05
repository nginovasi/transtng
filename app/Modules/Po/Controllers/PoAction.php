<?php namespace App\Modules\Po\Controllers;

use App\Modules\Po\Models\PoModel;
use App\Core\BaseController;

class PoAction extends BaseController
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

    function poagent_load()
    {
        parent::_authLoad(function(){
            $query = "SELECT a.id, d.po_name, a.po_agent_name, a.po_agent_phone, b.prov as provinsi, c.kabkota , a.po_agent_address, a.po_agent_email, a.po_agent_open, a.po_agent_close, a.po_agent_lat, a.po_agent_long FROM m_po_agent a
            LEFT JOIN m_lokprov b ON b.id = a.lokprov_id
            LEFT JOIN m_lokabkota c ON c.id = a.idkabkota
            LEFT JOIN m_po d ON d.id = a.po_id WHERE a.is_deleted = 0";
            $where = ["a.po_agent_name", "d.po_name", "b.prov", "c.kabkota"];
        
            parent::_loadDatatable($query, $where, $this->request->getPost());
        });
    }

    function poagent_save()
    {
        parent::_authInsert(function(){
            parent::_insert('m_po_agent', $this->request->getPost());
        });
    }

    function poagent_edit()
    {
        parent::_authEdit(function(){
            $data = $this->request->getPost();
            $query = "SELECT a.id, d.po_name, a.po_agent_name, a.po_agent_phone, a.lokprov_id, b.prov as provinsi, c.kabkota, a.idkabkota, a.po_agent_address, a.po_agent_email, a.po_agent_open, a.po_agent_close, a.po_agent_lat, a.po_agent_long FROM m_po_agent a
            LEFT JOIN m_lokprov b ON b.id = a.lokprov_id
            LEFT JOIN m_lokabkota c ON c.id = a.idkabkota
            LEFT JOIN m_po d ON d.id = a.po_id WHERE a.is_deleted = 0 and a.id = '" . $this->request->getPost('id') . "' ";

            parent::_edit('m_po_agent', $data, null, $query);
        });
    }

    function poagent_delete()
    {   
        parent::_authDelete(function(){
            parent::_delete('m_po_agent', $this->request->getPost());
        });
    }

    function manarmada_load()
    {
        parent::_authLoad(function(){
            $query = "SELECT a.id, a.armada_name, a.armada_plat_number, b.trayek_name as trayek, b.trayek_code, f.class_name, 
                      f.id as class_id, e.prov as provinsi, b.jarak, c.kspn_name as kspn, d.kategori_angkutan_name, a.armada_color, 
                      a.armada_merk, a.armada_gps_id, g.id as po_id, g.po_name, h.id as po_agent_id, h.po_agent_name, a.armada_code, a.armada_stnk_number, a.armada_stnk_active_date, a.armada_year, a.armada_kir_number, a.armada_kir_active_date FROM m_armada a 
                      LEFT JOIN m_trayek b ON b.id = a.trayek_id 
                      LEFT JOIN m_kspn c ON c.id = b.kspn_id 
                      LEFT JOIN m_kategori_angkutan d ON d.id = b.kategori_angkutan_id 
                      LEFT JOIN m_lokprov e ON e.id = b.lokprov_id 
                      LEFT JOIN m_class f ON f.id = a.class_id
                      LEFT JOIN m_po g ON g.id = a.po_id
                      LEFT JOIN m_po_agent h ON h.id = a.po_agent_id
                      WHERE a.is_deleted = 0";
            $where = ["a.id", "a.armada_name"];
        
            parent::_loadDatatable($query, $where, $this->request->getPost());
        });
    }

    function manarmada_save()
    {
        parent::_authInsert(function(){
            parent::_insert('m_armada', $this->request->getPost());
        });
    }

    function manarmada_edit()
    {
        parent::_authEdit(function(){
            $data = $this->request->getPost();
            $query = "SELECT a.id, a.armada_name, a.armada_plat_number, b.trayek_name as trayek, b.trayek_code, f.class_name, 
                      f.id as class_id, e.prov as provinsi, b.jarak, c.kspn_name as kspn, d.kategori_angkutan_name, a.armada_color, 
                      a.armada_merk, a.armada_gps_id, g.id as po_id, g.po_name, h.id as po_agent_id, h.po_agent_name, a.armada_code, a.armada_stnk_number, a.armada_stnk_active_date, a.armada_year, a.armada_kir_number, a.armada_kir_active_date FROM m_armada a 
            LEFT JOIN m_trayek b ON b.id = a.trayek_id 
            LEFT JOIN m_kspn c ON c.id = b.kspn_id 
            LEFT JOIN m_kategori_angkutan d ON d.id = b.kategori_angkutan_id 
            LEFT JOIN m_lokprov e ON e.id = b.lokprov_id 
            LEFT JOIN m_class f ON f.id = a.class_id
            LEFT JOIN m_po g ON g.id = a.po_id
            LEFT JOIN m_po_agent h ON h.id = a.po_agent_id
            WHERE a.is_deleted = 0 AND a.id = '" . $this->request->getPost('id') . "' ";

            parent::_edit('m_armada', $data, null, $query);
        });
    }

    function manarmada_delete()
    {   
        parent::_authDelete(function(){
            parent::_delete('m_armada', $this->request->getPost());
        });
    }

    
}
