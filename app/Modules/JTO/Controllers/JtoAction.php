<?php namespace App\Modules\Jto\Controllers;

use App\Modules\Jto\Models\JtoModel;
use App\Core\BaseController;

class JtoAction extends BaseController
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

    function jtomaster_load()
    {
        parent::_authLoad(function(){
            $etl_date_start = $_POST["filter"][0] ? $_POST["filter"][0] : null;
            $etl_date_end = $_POST["filter"][1] ? $_POST["filter"][1] : null;

            if($etl_date_start != null && $etl_date_end != null) {
                $query = "select a.* 
                            from m_jto a 
                            where a.is_deleted = 0 
                            and a.etl_date BETWEEN " . "'" . $etl_date_start . "'" . " and " . "'" . $etl_date_end . "'" . "
                            ";                 
            } else {
                $query = "select a.* 
                            from m_jto a 
                            where a.is_deleted = 0
                            ";
            }

            $where = ["a.nama_provinsi", "a.nama_kota", "nama_jembatan", "alamat"];
        
            parent::_loadDatatable($query, $where, $this->request->getPost());
        });
    }

    function jtomaster_detail()
    {
        parent::_authDetail(function(){
            // fetch data etilang
            $res_data = ['nama_provinsi', 'nama_kota', 'nama_jembatan', 'alamat', 'toleransi', 'batas', 'ramcek', 'kode_jt', 'etl_date'];

            parent::_editModal('m_jto', $this->request->getPost(), $res_data);
        });
    }

    function jtopenindakan_load()
    {
        parent::_authLoad(function(){
            $etl_date_start = $_POST["filter"][0] ? $_POST["filter"][0] : null;
            $etl_date_end = $_POST["filter"][1] ? $_POST["filter"][1] : null;

            if($etl_date_start != null && $etl_date_end != null) {
                $query = "select a.id, a.nama_jembatan, max(b.tanggal) as tanggal, a.toleransi, b.no_kend, b.pelanggaran
                            from m_jto a
                            left join s_jto_penindakan b
                            on a.id = b.idjt
                            where tanggal BETWEEN " . "'" . $etl_date_start . "'" . " and " . "'" . $etl_date_end . "'" . "
                            group by a.id";
            } else {
                $query = "select a.id, a.nama_jembatan, max(b.tanggal) as tanggal, a.toleransi, b.no_kend, b.pelanggaran
                            from m_jto a
                            left join s_jto_penindakan b
                            on a.id = b.idjt
                            group by a.id";
            }

            $where = ["a.nama_jembatan"];
        
            parent::_loadDatatable($query, $where, $this->request->getPost());
        });
    }

    function jtopenindakan_detail()
    {
        parent::_authDetail(function(){
            // fetch data etilang
            $res_data = ['id', 'nama_jembatan', 'tanggal', 'toleransi', 'no_kend', 'pelanggaran'];

            parent::_editModal('m_jto', $this->request->getPost(), $res_data, 'a.id', 
            ['select a.id, a.nama_jembatan, max(b.tanggal) as tanggal, a.toleransi, b.no_kend, b.pelanggaran
                from m_jto a
                left join s_jto_penindakan b
                on a.id = b.idjt',
            'group by a.id']);
        });
    }
}
