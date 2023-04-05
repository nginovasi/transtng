<?php

namespace App\Modules\Laporan\Controllers;

use App\Modules\Laporan\Models\LaporanModel;
use App\Core\BaseController;

class Laporan extends BaseController
{
    private $laporanModel;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->laporanModel = new LaporanModel();
    }

    public function index()
    {
        return redirect()->to(base_url());
    }

    public function test()
    {
        $data['load_view'] = "App\Modules\Laporan\Views\\test";
        return view('App\Modules\Main\Views\layout', $data);
    }

    public function lapspda()
    {
        return parent::_authView();
    }

    public function laprampcheck()
    {
        return parent::_authView();
    }

    public function grafikrampcheck()
    {
        return parent::_authView();
    }

    public function cekdatapnp()
    {
        return parent::_authView();
    }

    public function cekdatamotis()
    {
        return parent::_authView();
    }

    public function getRampcheckHistory($month = null, $year = null)
    {
      $month = $this->request->getPost('month');
      $year = $this->request->getPost('year');
        $iduser = $this->session->get('id');
        $instansiId = $this->session->get('instansi_detail_id'); 

        $whereClause = '';
          if ($year == '' || $month == '' || $year == null || $month == null || $month == '0') {
              $whereClause = "WHERE a.is_deleted = '0'";
          } elseif ($month != null || $year != null) {
              $whereClause = "WHERE a.is_deleted = '0' AND MONTH(a.rampcheck_date) = '$month' AND YEAR(a.rampcheck_date) = '$year' ";
          } 

      
          $response = $this->db->query("SELECT date_format(a.rampcheck_date, '%d-%m-%Y') AS rampcheck_date, count(a.id) AS ttl_rampcheck, 
          CASE WHEN b.rampcheck_kesimpulan_status = '0' THEN 'Diijinkan Operasional'
          WHEN b.rampcheck_kesimpulan_status = '1' THEN 'Peringatan/Perbaiki'
          WHEN b.rampcheck_kesimpulan_status = '2' THEN 'Tilang dan Dilarang Operasional'
          ELSE 'Dilarang Operasional'
          END AS rampcheck_kesimpulan_status
          , count(b.kesimpulan_id) AS ttl_kesimpulan
                  FROM t_rampcheck a
                  JOIN (
                      SELECT DISTINCT rampcheck_id, rampcheck_kesimpulan_status, id AS kesimpulan_id FROM t_rampcheck_kesimpulan
                  ) b ON b.rampcheck_id = a.id
                          $whereClause
                          GROUP BY a.rampcheck_date,b.rampcheck_kesimpulan_status
                    ORDER BY a.rampcheck_date asc, b.rampcheck_kesimpulan_status ASC")->getResultArray();

echo json_encode($response);
        // return $response;
    }

    public function rekaprampcheckarmada()
    {
        return parent::_authView();
    }
}



