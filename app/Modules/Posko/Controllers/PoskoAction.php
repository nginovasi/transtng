<?php

namespace App\Modules\Posko\Controllers;

use App\Modules\Posko\Models\PoskoModel;
use App\Core\BaseController;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Reader\Xls;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;
use PhpOffice\PhpSpreadsheet\Writer\Xls as WriterXls;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx as WriterXlsx;


class PoskoAction extends BaseController
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

    // manajamenen armada mudik
    // load
    public function lokasiposko_load()
    {
        parent::_authLoad(function () {
            $iduser = $this->session->get('id');

            $query = "SELECT a.*,b.klas_posko,c.kabkota,d.prov
                      FROM m_posko_mudik a
                      INNER JOIN m_klas_posko b ON a.klas_posko_id = b.id 
                      INNER JOIN m_lokabkota c on a.idkabkota=c.id
                      INNER JOIN m_lokprov d on a.lokprov_id=d.id
                      WHERE a.is_deleted = 0";

            $where = ["b.klas_posko", "a.posko_mudik_name"];

            parent::_loadDatatable($query, $where, $this->request->getPost());
        });
    }

    // save
    public function lokasiposko_save()
    {
        parent::_authInsert(function () {
            $data = $this->request->getPost();
            unset($data['posko_mudik_latlong_nominatim']);
            $data['id'] = $this->request->getPost('id') == "" ? null : $this->request->getPost('id');
            parent::_insert('m_posko_mudik', $data);
        });
    }

    // edit
    public function lokasiposko_edit()
    {
        parent::_authEdit(function () {
            $data = $this->request->getPost();

            $query = "SELECT a.*,b.klas_posko,c.kabkota,d.prov
                      FROM m_posko_mudik a
                      INNER JOIN m_klas_posko b ON a.klas_posko_id = b.id 
                      INNER JOIN m_lokabkota c on a.idkabkota=c.id
                      INNER JOIN m_lokprov d on a.lokprov_id=d.id
                      WHERE a.is_deleted = 0 and a.id = " . $this->request->getPost('id') . "
                        ";

            parent::_edit('m_posko_mudik', $data, null, $query);
        });
    }

    // delete
    public function lokasiposko_delete()
    {
        parent::_authDelete(function () {
            parent::_delete('m_posko_mudik', $this->request->getPost());
        });
    }

    

    public function excellokasiposko()
    {
        $url = uri_segment("3");
        
        $lokasiposkodata = $this->db->query("SELECT a.*,b.klas_posko,c.kabkota,d.prov
                      FROM m_posko_mudik a
                      INNER JOIN m_klas_posko b ON a.klas_posko_id = b.id 
                      INNER JOIN m_lokabkota c on a.idkabkota=c.id
                      INNER JOIN m_lokprov d on a.lokprov_id=d.id
                      WHERE a.is_deleted")->getResult();

        $spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('A1', 'Lokasi Posko')
            ->setCellValue('A2', 'Area Posko  ')
            ->setCellValue('A3', 'Provinsi ')
            ->setCellValue('A4', 'Kota/Kabupaten ')
            ->setCellValue('A5', 'Latitude Longitude');

        $column = 5;

        foreach ($lokasiposkodata as $q) {
            $spreadsheet->setActiveSheetIndex(0)
                ->setCellValue('A' . $column, $q->posko_mudik_name);

            $column++;
        }

        $writer = new WriterXlsx($spreadsheet);
        $filename = date('Y-m-d-His'). '-Data-Lokasiposko';

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename=' . $filename . '.xlsx');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');

    }

    // manajamenen jadwal posko
    // load
    public function jadwalposko_load()
    {
        parent::_authLoad(function () {
            $iduser = $this->session->get('id');

            $query = "SELECT a.*,b.posko_mudik_name,c.id as user_id, concat_ws('',c.user_web_username,' (',c.user_web_name,')') as petugasposko
                      FROM m_jadwal_posko a
                      INNER JOIN m_posko_mudik b ON a.posko_id = b.id 
                      INNER JOIN m_user_web c on a.user_id=c.id
                      WHERE a.is_deleted = 0";

            $where = ["b.posko_mudik_name", "c.user_web_username","c.user_web_name","a.tgl_tugas"];

            parent::_loadDatatable($query, $where, $this->request->getPost());
        });
    }

    // save
    public function jadwalposko_save()
    {
        parent::_authInsert(function () {
            $data = $this->request->getPost();
            $data['id'] = $this->request->getPost('id') == "" ? null : $this->request->getPost('id');
            parent::_insert('m_jadwal_posko', $data);
        });
    }

    // edit
    public function jadwalposko_edit()
    {
        parent::_authEdit(function () {
            $data = $this->request->getPost();

            $query = "SELECT a.*,b.posko_mudik_name,c.id as user_id, concat_ws('',c.user_web_username,' (',c.user_web_name,')') as username
                      FROM m_jadwal_posko a
                      INNER JOIN m_posko_mudik b ON a.posko_id = b.id 
                      INNER JOIN m_user_web c on a.user_id=c.id
                      WHERE a.is_deleted = 0 and a.id = " . $this->request->getPost('id') . "
                        ";

            parent::_edit('m_jadwal_posko', $data, null, $query);
        });
    }

    // delete
    public function jadwalposko_delete()
    {
        parent::_authDelete(function () {
            parent::_delete('m_jadwal_posko', $this->request->getPost());
        });
    }
}
