<?php namespace App\Modules\Spda\Controllers;

use App\Modules\Spda\Models\SpdaModel;
use App\Core\BaseController;

class SpdaAction extends BaseController
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

    public function spda_load()
    {
        parent::_authLoad(function () {
            $query = "SELECT a.id, a.trayek_id, a.no_spda, a.tgl_spda, b.nama_pengemudi, c.armada_code, a.ritase_spda, a.jrk_tempuh_spda, a.wkt_tempuh_spda, a.bbm_spda, a.kapsts_bus_spda, a.ttl_penumpang_spda, a.ttl_pdptan_spda,
            d.kategori_angkutan_name, e.route_name
            FROM t_form_spda a
            LEFT JOIN m_driver b on b.id = a.driver_spda
            LEFT JOIN m_armada c on c.id = a.kd_bus_spda
            LEFT JOIN m_kategori_angkutan d on d.id = a.kategori_angkutan_id
            LEFT JOIN m_route e on e.id = a.trayek_id
            WHERE a.is_deleted = '0'";
            $where = ["id, no_spda, kd_bus_spda, tgl_spda, driver_spda, d.kategori_angkutan_name, e.route_name"];
            parent::_loadDatatable($query, $where, $this->request->getPost());
        });
    }

    public function spda_save()
    {
        $data = $this->request->getPost();
        $t_form_spda = $this->db->table('t_form_spda');

        define('UPLOAD_DIR', 'assets/img/signatures/');
        $ttd_pengemudi = $this->request->getPost('form_spda_ttd_pengemudi');
        $img_pengemudi = str_replace('data:image/png;base64,', '', $ttd_pengemudi);
        $img_pengemudi = str_replace(' ', '+', $img_pengemudi);
        $data_pengemudi = base64_decode($img_pengemudi);
        $file_pengemudi = UPLOAD_DIR . md5('SPDA-Pengemudi'.date('YmdHis')) . '.png';
        $filename_pengemudi = site_url('/assets/img/signatures/'.md5('SPDA-Pengemudi'.date('YmdHis')) . '.png');
        $success_pengemudi = file_put_contents($file_pengemudi, $data_pengemudi);

        $ttd_manager = $this->request->getPost('form_spda_ttd_manager');
        $img_manager = str_replace('data:image/png;base64,', '', $ttd_manager);
        $img_manager = str_replace(' ', '+', $img_manager);
        $data_manager = base64_decode($img_manager);
        $file_manager = UPLOAD_DIR . md5('SPDA-Manager'.date('YmdHis')) . '.png';
        $filename_manager = site_url('/assets/img/signatures/'.md5('SPDA-Manager'.date('YmdHis')) . '.png');
        $success_manager = file_put_contents($file_manager, $data_manager);
        
        $data_spda = [
            'kategori_angkutan_id' => $data['kategori_angkutan_id'],
            'trayek_id' => $data['trayek_id'],
            'tgl_spda' => $data['tgl_spda'],
            'driver_spda' => $data['driver_spda'],
            'kd_bus_spda' => $data['kd_bus_spda'],
            'bbm_spda' => $data['bbm_spda'],
            'ritase_spda' => $data['ritase_spda'],
            'wkt_tempuh_spda' => $data['wkt_tempuh_spda'],
            'jrk_tempuh_spda' => $data['jrk_tempuh_spda'],
            'kapsts_bus_spda' => $data['kapsts_bus_spda'],
            'ttl_penumpang_spda' => $data['ttl_penumpang_spda'],
            'ttl_pdptan_spda' => $data['ttl_pdptan_spda'],
            'form_spda_ttd_pengemudi' => $filename_pengemudi,
            'form_spda_ttd_manager' => $filename_manager,
            'form_spda_nama_manager' => $data['form_spda_nama_manager'],
        ];
        $t_form_spda->insert($data_spda);

        if($this->db->transStatus() === FALSE){
            $this->db->transRollback();
            $this->db->transComplete();
            echo json_encode(['success' => FALSE, 'message' => $this->spdaModel->errors()]);
        }else{
            $this->db->transCommit();
            $this->db->transComplete();
            echo json_encode(['success' => TRUE, 'message' => 'Data berhasil disimpan']);
        }
    }

    public function spda_edit()
    {
        parent::_authEdit(function () {
            $data = $this->request->getPost();
            $query = "SELECT * FROM t_form_spda WHERE is_deleted = 0 and id = '" . $this->request->getPost('id') . "' ";
            parent::_edit('t_form_spda', $data, null, $query);
        });
    }

    public function spda_delete()
    {
        parent::_authDelete(function () {
            parent::_delete('t_form_spda', $this->request->getPost());
        });
    }

    function pdf()
    {   
        $url = uri_segment("3");

        $ipaddress = $this->request->getIPAddress();
        $user = $this->session->get('name');
        
        $url_export = $url.'_export';
        $filter = $_GET['search'];
        $data['data_url'] = uri_segment("2");
        $data['data_excel'] = $this->spdaModel->export_view($url_export, $filter);

        $html = view('App\Modules\Spda\Views\export\\'.$url.'_export', $data);

        $mpdf = new \Mpdf\Mpdf(['setAutoTopMargin' => 'stretch', 'setAutoBottomMargin' => 'stretch']);

        $mpdf->SetHTMLHeader('
        <div style="text-align: center;"><img src="' . base_url() . '/assets/img/hubdat.png" style="display: block; padding-bottom: 10px; width: 20%;"></div>
        <div style="text-align: center;"><img src="' . base_url() . '/assets/img/logodamri.png" style="display: block; padding-bottom: 10px; width: 30%;"></div>
        <div style="text-align: center; font-size: 18px; font-weight: bold; letter-spacing: 3px;">SURAT PERINTAH DINAS ANGKUTAN (Spda) AP/1</div>
        <hr style="height:2px;border-width:0;color:gray;background-color:gray">
        ');
        $mpdf->SetHTMLFooter('
          <div style="text-align: center;"><img src="' . base_url() . '/assets/img/logo.png" style="display: block; width: 20%;"></div>
          <div style="text-align: left; font-size: 8px; font-style: italic: color:gray;">Printed on '. date('d/m/Y H:i:s').' from IP '. $ipaddress .' by '. $user .' </div>');
        $mpdf->SetWatermarkImage(base_url().'/assets/img/logodamri.png');
        $mpdf->watermarkImageAlpha = 0.1;
        $mpdf->showWatermarkImage = true;
        $mpdf->WriteHTML($html);
        $this->response->setHeader('Content-Type', 'application/pdf');
        $mpdf->Output($url.'-'.date('d-m-Y H:i:s').'.pdf','I');
    }
}
