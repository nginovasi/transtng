<?php

namespace App\Modules\Administrator\Controllers;

use App\Core\BaseController;
use App\Modules\Administrator\Models\AdministratorModel;

class AdministratorAjax extends BaseController
{
    private $administratorModel;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->administratorModel = new AdministratorModel();
    }

    public function index()
    {
        return redirect()->to(base_url());
    }

    public function menu_select_get($module_id)
    {
        $menu = $this->administratorModel->base_get('s_menu', ['module_id' => $module_id, 'menu_id' => null])->getResult();

        $option = array_map(function ($data) {
            return "<option value='" . $data->id . "'>" . $data->menu_name . "</option>";
        }, $menu);

        echo "<option value=''>Jadikan Menu Utama</option>" . implode("", $option);
    }

    public function moduleuser_get()
    {
        $module_user = groupby($this->administratorModel->getModuleUser($_POST['id']), 'module_id');

        echo json_encode($module_user);
    }

    public function menu_get($module_id)
    {
        $menus = $this->administratorModel->getParentMenu($module_id);
        $array = array_map(function ($menu) {
            $x = json_decode(json_encode($menu), true);
            $x['submenu'] = $this->administratorModel->getSubMenu($x['id']);

            return $x;
        }, $menus);

        echo json_encode($array);
    }

    public function module_select_get()
    {
        $module = $this->administratorModel->getModules();

        $option = array_map(function ($data) {
            return "<option value='" . $data->id . "'>" . $data->module_name . "</option>";
        }, $module);

        return "<select class='idmodule' name='idmodule[]' required>
                <option value=''>Pilih Modul</option>" .
            implode("", $option) . "<select>";
    }

    public function getTenant() {
        $data = $this->request->getGet();
        $query = "SELECT a.id, a.nama as 'text' FROM ref_tenant a WHERE a.nama IS NOT NULL";
        $where = ["a.nama"];

        parent::_loadSelect2($data, $query, $where);
    }

    // public function idprov_select_get()
    // {
    //     $data = $this->request->getGet();
    //     $query = "SELECT a.id , a.prov as 'text' FROM m_lokprov a where a.is_deleted='0'";
    //     $where = ["a.prov"];

    //     parent::_loadSelect2($data, $query, $where);
    // }

    // public function idkabkota_select_get()
    // {
    //     $data = $this->request->getGet();
    //     $query = "SELECT a.id , a.kabkota as 'text' from m_lokabkota a where a.is_deleted='0' and  a.idprov='" . $data['idprov'] . "'";
    //     $where = ["a.kabkota"];

    //     parent::_loadSelect2($data, $query, $where);
    // }

    // public function id_kec_select_get()
    // {
    //     $data = $this->request->getGet();
    //     $query = "SELECT a.id , a.kec as 'text' from m_lokec a where a.is_deleted='0' and  a.idkabkota='" . $data['idkabkota'] . "' ";
    //     $where = ["a.kec"];

    //     parent::_loadSelect2($data, $query, $where);
    // }

    // public function kspn_id_select_get()
    // {
    //     $data = $this->request->getGet();
    //     $query = "SELECT a.id , a.kspn_name as 'text' FROM m_kspn a where a.is_deleted='0'";
    //     $where = ["a.kspn_name"];

    //     parent::_loadSelect2($data, $query, $where);
    // }

    // public function kategori_angkutan_id_select_get()
    // {
    //     $data = $this->request->getGet();
    //     $query = "SELECT a.id , a.kategori_angkutan_name as 'text' FROM m_kategori_angkutan a where a.is_deleted='0'";
    //     $where = ["a.kategori_angkutan_name"];

    //     parent::_loadSelect2($data, $query, $where);
    // }

    // public function trayek_id_select_get()
    // {
    //     $data = $this->request->getGet();
    //     $query = "SELECT a.id , concat(COALESCE(concat(d.prov, ' || '), '') ,COALESCE(c.kspn_name, b.kategori_angkutan_name), ' || ', a.trayek_name) as 'text'
    //               FROM m_trayek a
    //               LEFT JOIN m_kategori_angkutan b on b.id = a.kategori_angkutan_id
    //               LEFT JOIN m_kspn c on c.id = a.kspn_id
    //               LEFT JOIN m_lokprov d on d.id = a.lokprov_id
    //               WHERE a.is_deleted='0'";
    //     $where = ["a.trayek_name", "b.kategori_angkutan_name"];

    //     parent::_loadSelect2($data, $query, $where);
    // }

    // public function lokprov_id_select_get()
    // {
    //     $data = $this->request->getGet();
    //     $query = "SELECT a.id , a.prov as 'text' FROM m_lokprov a where a.is_deleted='0'";
    //     $where = ["a.prov"];

    //     parent::_loadSelect2($data, $query, $where);
    // }

    // public function getSeatMap()
    // {

    //     $params['draw'] = $_REQUEST['draw'];
    //     $start = $_REQUEST['start'];
    //     $length = $_REQUEST['length'];
    //     $search_value = $_REQUEST['search']['value'];

    //     if (!empty($search_value)) {
    //         $total_count = $this->db->query("SELECT a.id, a.seat_map_name, a.id, a.seat_map_name, a.seat_map_capacity, a.seat_map_left, a.seat_map_right, a.seat_map_row, a.seat_map_last FROM m_seat_map a
    //           WHERE a.is_deleted = 0 AND a.seat_map_name like '%" . $search_value . "%' ")->getResult();

    //         $data = $this->db->query("SELECT a.id, a.seat_map_name, a.id, a.seat_map_name, a.seat_map_capacity, a.seat_map_left, a.seat_map_right, a.seat_map_row, a.seat_map_last FROM m_seat_map a
    //           WHERE a.is_deleted = 0 AND a.seat_map_name like '%" . $search_value . "%' limit $start, $length")->getResult();
    //     } else {
    //         $total_count = $this->db->query("SELECT * FROM m_seat_map WHERE is_deleted = '0'")->getResult();
    //         $data = $this->db->query("SELECT a.id, a.seat_map_name, a.id, a.seat_map_name, a.seat_map_capacity, a.seat_map_left, a.seat_map_right, a.seat_map_row, a.seat_map_last FROM m_seat_map a
    //           WHERE a.is_deleted = 0 ORDER BY a.created_at DESC limit $start, $length")->getResult();
    //     }
    //     $json_data = array(
    //         "draw" => intval($params['draw']),
    //         "recordsTotal" => count($total_count),
    //         "recordsFiltered" => count($total_count),
    //         "data" => $data, // total data array
    //     );
    //     echo json_encode($json_data);
    // }

    // public function terminal_select_get()
    // {
    //     $data = $this->request->getGet();
    //     $query = "SELECT a.id , a.terminal_name as 'text', terminal_lat as lat, terminal_lng AS lng  FROM m_terminal a where a.is_deleted='0'";
    //     $where = ["a.terminal_name"];

    //     parent::_loadSelect2($data, $query, $where);
    // }

    // public function route_select_get()
    // {
    //     $data = $this->request->getGet();
    //     $query = "SELECT a.id , a.route_name AS 'text', a.route_polyline FROM m_route a 
    //     JOIN m_kategori_angkutan b ON b.id = a.kategori_angkutan_id
    //     WHERE a.is_deleted='0' AND b.id IN (11, 12) and b.kategori_angkutan_name like '%mudik%'";
    //     $where = ["a.route_name"];

    //     parent::_loadSelect2($data, $query, $where);
    // }

    // public function getRouteAPI()
    // {
    //     $from = $this->request->getPost('from');
    //     $to = $this->request->getPost('to');
    //     $curl = curl_init();

    //     curl_setopt_array($curl, array(
    //         CURLOPT_URL => 'https://gps.brtnusantara.com/dev/api/route?points=' . $from . '|' . $to,
    //         CURLOPT_RETURNTRANSFER => true,
    //         CURLOPT_ENCODING => '',
    //         CURLOPT_MAXREDIRS => 10,
    //         CURLOPT_TIMEOUT => 0,
    //         CURLOPT_FOLLOWLOCATION => true,
    //         CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    //         CURLOPT_CUSTOMREQUEST => 'GET',
    //         CURLOPT_HTTPHEADER => array(
    //             'Authorization: Basic bmdpOm5naXJheWE=',
    //             'Cookie: ci_session=a%3A5%3A%7Bs%3A10%3A%22session_id%22%3Bs%3A32%3A%223d932811093efdacf20aabf71a4802e7%22%3Bs%3A10%3A%22ip_address%22%3Bs%3A12%3A%2245.126.187.5%22%3Bs%3A10%3A%22user_agent%22%3Bs%3A21%3A%22PostmanRuntime%2F7.30.0%22%3Bs%3A13%3A%22last_activity%22%3Bi%3A1674794284%3Bs%3A9%3A%22user_data%22%3Bs%3A0%3A%22%22%3B%7D8e61d249a0e05a2ff4f083d8424cacc9; csrf_cookie_name=fe850f94504f926d0105116c76eebb8d; ci_session=a%3A5%3A%7Bs%3A10%3A%22session_id%22%3Bs%3A32%3A%223fbd99d136f25a1cf7393a232ee4ab31%22%3Bs%3A10%3A%22ip_address%22%3Bs%3A12%3A%2245.126.187.5%22%3Bs%3A10%3A%22user_agent%22%3Bs%3A21%3A%22PostmanRuntime%2F7.29.2%22%3Bs%3A13%3A%22last_activity%22%3Bi%3A1674798644%3Bs%3A9%3A%22user_data%22%3Bs%3A0%3A%22%22%3B%7D2403868db653d753f9e6135a7cd6c1d4; csrf_cookie_name=fe850f94504f926d0105116c76eebb8d',
    //         ),
    //     )
    //     );

    //     $response = curl_exec($curl);

    //     curl_close($curl);
    //     echo $response;
    // }

    // public function kategori_angkutan_select_get()
    // {
    //     $data = $this->request->getGet();
    //     $query = "SELECT a.id , a.kategori_angkutan_name as 'text'  FROM m_kategori_angkutan a where a.is_deleted='0'";
    //     $where = ["a.kategori_angkutan_name"];

    //     parent::_loadSelect2($data, $query, $where);
    // }

    // public function driver_id_select_get()
    // {
    //     $data = $this->request->getGet();
    //     $query = "SELECT a.id , a.nama_pengemudi as 'text' FROM m_driver a where a.is_deleted='0'";
    //     $where = ["a.nama_pengemudi"];

    //     parent::_loadSelect2($data, $query, $where);
    // }

    // public function armada_id_select_get()
    // {
    //     $data = $this->request->getGet();
    //     $query = "SELECT a.id, concat(a.armada_code, ' || ', a.armada_plat_number) as 'text' FROM m_armada a where a.is_deleted = '0'";
    //     $where = ["a.armada_code"];

    //     parent::_loadSelect2($data, $query, $where);
    // }

    // public function armada_kapasitas_select_get()
    // {
    //     $data = $this->request->getGet();
    //     $query = "SELECT a.id, a.armada_kapasitas as 'text' FROM m_armada a where a.is_deleted = '0'";
    //     $where = ["a.armada_kapasitas"];

    //     parent::_loadSelect2($data, $query, $where);
    // }

    // public function subkategori_angkutan_select_get()
    // {
    //     $data = $this->request->getGet();
    //     if ($data['kategori_angkutan'] == 'KSPN') {
    //         $query = "SELECT a.id , a.kspn_name as 'text'  FROM m_kspn a where a.is_deleted='0'";
    //         $where = ["a.kspn_name"];

    //         // nanti diubah ketika ada pengkategorian selain kspn seperti perintis, dll
    //         parent::_loadSelect2($data, $query, $where);
    //     } else {
    //         $query = "SELECT a.id, a.lokprov_id, b.prov, concat(b.prov, ' - ', a.kspn_name) AS 'text' FROM m_kspn a
    //         LEFT JOIN m_lokprov b ON b.id = a.lokprov_id
    //         WHERE a.is_deleted = '0'";
    //         $where = ["a.kspn_name", "b.prov"];

    //         parent::_loadSelect2($data, $query, $where);
    //     }
    // }

    // public function petugas_id_select_get()
    // {
    //     $db = \Config\Database::connect();
    //     $builder = $db->table('m_user_mobile');
    //     $builder->select('id, user_mobile_name as text');
    //     $builder->where('is_deleted', '0');
    //     $builder->where('user_mobile_role', '2');
    //     $query = $builder->get();

    //     $results = [];
    //     foreach ($query->getResult() as $row) {
    //         $results[] = ['id' => $row->id, 'text' => $row->text];
    //     }

    //     return $this->response->setJSON($results);
    // }

    // public function get_petugas_name() {
    //     $data = $this->request->getGet();
    //     $query = "SELECT a.id, a.user_mobile_name as 'text' FROM m_user_mobile a where a.id = '". $this->request->getPost('petugas_id')."' ORDER BY a.id, a.user_mobile_name";
    //     $result = $this->db->query($query)->getResult();
    //     return json_encode($result);
    // }

    // public function parent_1_id_select_get()
    // {
    //     $data = $this->request->getGet();
    //     $query = "select id, instansi_detail_name as 'text' from m_instansi_detail where kode NOT LIKE '%.%' and is_deleted = 0";
    //     $where = ["instansi_detail_name"];

    //     parent::_loadSelect2($data, $query, $where);
    // }

    // public function parent_est_id_select_get()
    // {
    //     $data = $this->request->getGet();
    //     $query = "select id, instansi_detail_name as 'text' from m_instansi_detail where kode LIKE '".$data['id_parent'].".%' and is_deleted = 0";
    //     $where = ["instansi_detail_name"];

    //     parent::_loadSelect2($data, $query, $where);
    // }

    // public function user_web_role_id_select_get()
    // {
    //     $data = $this->request->getGet();
    //     $query = "select a.id, a.user_web_role_name as 'text' from s_user_web_role a where a.is_deleted = 0";
    //     $where = ["user_web_role_name"];

    //     parent::_loadSelect2($data, $query, $where);
    // }

    // public function instansi_detail_id_select_by_role_get()
    // {
    //     $data = $this->request->getGet();
    //     $query = "select a.id, a.instansi_detail_name as 'text' from m_instansi_detail a where a.user_web_role_id = ".$data['user_web_role_id'];
    //     $where = ["instansi_detail_name"];

    //     parent::_loadSelect2($data, $query, $where);
    // }

    // public function instansi_detail_id_select_get()
    // {
    //     $data = $this->request->getGet();

    //     $query = "select a.id, a.instansi_detail_name  as 'text'
    //                 from m_instansi_detail a
    //                 join (
    //                     select b.*
    //                     from m_user_web a
    //                     join m_instansi_detail b
    //                     on a.instansi_detail_id = b.id
    //                     where a.id = " . $this->session->get('id') . "
    //                     and b.is_deleted = 0
    //                 ) b
    //                 on a.instansi_detail_id = b.id
    //                 where a.is_deleted = 0";

    //     $where = ["a.instansi_detail_name"];

    //     parent::_loadSelect2($data, $query, $where);
    // }

    // public function selected_append_instansi_detail()
    // {
    //     $id = $this->request->getPost('id');

    //     $result = $this->db->query("select * from m_instansi_detail where id = " . $id)->getRow();

    //     echo json_encode($result);
    // }

    // public function klas_posko_id_select_get()
    // {
    //     $data = $this->request->getGet();
    //     $query = "SELECT a.id , a.klas_posko as 'text'  FROM m_klas_posko a where a.is_deleted='0'";
    //     $where = ["a.klas_posko"];

    //     parent::_loadSelect2($data, $query, $where);
    // }
}