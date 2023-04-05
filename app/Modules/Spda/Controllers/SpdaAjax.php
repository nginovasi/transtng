<?php namespace App\Modules\Spda\Controllers;

use App\Modules\Spda\Models\SpdaModel;
use App\Core\BaseController;
use App\Libraries\DataTables;

class SpdaAjax extends BaseController
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

    public function idarmadamudik_select_get()
    {
        $data = $this->request->getGet();
        $query = "SELECT a.id , a.armada_name as 'text' FROM m_armada_mudik a where a.is_deleted='0'";
        $where = ["a.armada_name"];

        parent::_loadSelect2($data, $query, $where);
    }

    public function idrute_select_get()
    {
        $data = $this->request->getGet();
        $query = "SELECT a.id , a.route_name as 'text' FROM m_route a where a.is_deleted='0'";
        $where = ["a.route_name"];

        parent::_loadSelect2($data, $query, $where);
    }

    public function driver_id_select_get()
    {
        $data = $this->request->getGet();
        $query = "SELECT a.id , a.nama_pengemudi as 'text' FROM m_driver a where a.is_deleted='0'";
        $where = ["a.nama_pengemudi"];

        parent::_loadSelect2($data, $query, $where);
    }

    public function armada_id_select_get()
    {
        $data = $this->request->getGet();
        $query = "SELECT a.id, concat(a.armada_code, ' || ', a.armada_plat_number) as 'text' FROM m_armada a where a.is_deleted = '0'";
        $where = ["a.armada_code"];

        parent::_loadSelect2($data, $query, $where);
    }

    public function armada_kapasitas_select_get()
    {
        $data = $this->request->getGet();
        $query = "SELECT a.id, a.armada_kapasitas as 'text' FROM m_armada a where a.is_deleted = '0'";
        $where = ["a.armada_kapasitas"];

        parent::_loadSelect2($data, $query, $where);
    }

    public function kategori_angkutan_id_select_get()
    {
        $data = $this->request->getGet();
        $query = "SELECT a.id , a.kategori_angkutan_name as 'text' FROM m_kategori_angkutan a where a.is_deleted='0'";
        $where = ["a.kategori_angkutan_name"];

        parent::_loadSelect2($data, $query, $where);
    }

    public function trayek_id_select_get()
    {
        $data = $this->request->getGet();
        $query = "SELECT a.id , a.route_name as 'text' FROM m_route a where a.is_deleted='0' and a.kategori_angkutan_id = '$data[kategori_angkutan_id]'";
        $where = ["a.route_name"];

        parent::_loadSelect2($data, $query, $where);
    }

    public function route_distance_select_get()
    {
        $data = $this->request->getGet();
        $id = $data['id'];
        $query = "SELECT a.id , a.route_distance, a.route_time FROM m_route a where a.is_deleted='0' and a.id = '$id'";
        
        return json_encode($this->db->query($query)->getResult());
    }
    
}