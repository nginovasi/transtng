<?php namespace App\Modules\Etilang\Controllers;

use App\Modules\Etilang\Models\EtilangModel;
use App\Core\BaseController;

class EtilangAction extends BaseController
{
    private $etilangModel;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->etilangModel = new EtilangModel();
    }

    public function index()
    {
        return redirect()->to(base_url()); 
    }

    function etilang_load()
    {
        parent::_authLoad(function(){
            $tgl_penindakan_start = $_POST["filter"][0] ? $_POST["filter"][0] : null;
            $tgl_penindakan_end = $_POST["filter"][1] ? $_POST["filter"][1] : null;

            if($tgl_penindakan_start != null && $tgl_penindakan_end != null) {
                $query = "select a.* 
                            from m_etilang a 
                            where a.is_deleted = 0 
                            and a.tanggal_penindakan BETWEEN " . "'" . $tgl_penindakan_start . "'" . " and " . "'" . $tgl_penindakan_end . "'" . "
                            and a.belangko IS NOT NULL
                            ";                 
            } else {
                $query = "select a.* 
                            from m_etilang a 
                            where a.is_deleted = 0
                            and a.belangko IS NOT NULL
                            ";
            }

            $where = ["a.no_polisi", "a.belangko"];
        
            parent::_loadDatatable($query, $where, $this->request->getPost());

            // get api spionam list
            // $this->APISpionamlist_load();
        });
    }

    function etilang_detail()
    {
        parent::_authDetail(function(){
            // fetch data etilang
            $res_data = ['belangko', 'tanggal_penindakan(date)', 'tanggal_sidang(date)', 'tanggal_bayar(date)', 'nama_ppns', 'satuan_kerja', 'nama_pelanggar', 'tanggal_lahir(date)', 'jenis_kelamin', 'no_polisi', 'kendaraan', 'titipan', 'denda', 'ongkos', 'subsider', 'etl_date', 'pasal', 'denda_maksimum'];

            parent::_editModal('m_etilang', $this->request->getPost(), $res_data);
        });
    }
}
