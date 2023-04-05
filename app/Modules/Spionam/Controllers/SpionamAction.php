<?php namespace App\Modules\Spionam\Controllers;

use App\Modules\Spionam\Models\SpionamModel;
use App\Core\BaseController;
use App\Core\BaseModel;

class SpionamAction extends BaseController
{
    private $spionamModel;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->spionamModel = new SpionamModel();
    }

    public function index()
    {
        return redirect()->to(base_url()); 
    }

    function spionam_load()
    {
        parent::_authLoad(function(){
            $tgl_exp_start = $_POST["filter"][0] ? $_POST["filter"][0] : null;
            $tgl_exp_end = $_POST["filter"][1] ? $_POST["filter"][1] : null;

            if($tgl_exp_start != null && $tgl_exp_end != null) {
                $query = "select a.* 
                            from m_spionam a 
                            where a.is_deleted = 0 
                            and a.tgl_exp_kps BETWEEN " . "'" . $tgl_exp_start . "'" . " and " . "'" . $tgl_exp_end . "'" . "
                            ";                 
            } else {
                $query = "select a.* 
                            from m_spionam a 
                            where a.is_deleted = 0";
            }

            $where = ["a.jenis_pelayanan", "a.noken"];
        
            parent::_loadDatatable($query, $where, $this->request->getPost());

            // get api spionam list
            // $this->APISpionamlist_load();
        });
    }

     // access api hubdat blue load
    private function APISpionamlist_load() {
        $dataToken = parent::_initTokenHubdat();
        $bearerToken = 'Bearer ' . $dataToken["access_token"];

        $start = $_POST["start"];
        $length = $_POST["length"];
        $masa_berlaku_start = $_POST["filter"][0] ? "&tgl_exp_start=" . $_POST["filter"][0] . "T00:00:00" : null;
        $masa_berlaku_end = $_POST["filter"][1] ? "&tgl_exp_end=" . $_POST["filter"][1] . "T00:00:00" : null;

        $response =  $this->APIListSpionam('spionam', $bearerToken, $start, $length, [$masa_berlaku_start, $masa_berlaku_end]);

        $data = json_decode($response, true);

        $baseModel = new BaseModel();

        // log
        $log_param = json_encode((object)array(
            'skip' => $start,
            'limit' => $length,
            'sort' => 'ASC',
            'masa_berlaku_start' => $masa_berlaku_start,
            'masa_berlaku_end' => $masa_berlaku_end
        ));

        $this->APISpionamLog($baseModel, $bearerToken, $log_param, $response);

        // blue dummy
        // $this->db->truncate('m_bluerfid');
        // $this->APISpionamListDummy($baseModel, $bearerToken, 'spionam', 'm_spionam');

        echo json_encode(array("data" => $data["data"], "recordsTotal" => $data["total"], "recordsFiltered" => $data["limit"]));
    }

    function spionam_spionamLast()
    {
        parent::_authDetail(function(){
            // fetch data spionam last
            $res_data = ['jenis_pelayanan', 'noken', 'no_uji', 'tgl_exp_uji(date)', 'no_kps', 'tgl_exp_kps(date)', 'no_rangka', 'no_mesin', 'merek', 'tahun', 'seat'];

            parent::_editModal('m_spionam', $this->request->getPost(), $res_data, 'noken');

            //  fetch api spionam last
            // $this->APISpionam_spionamLast();
        });
    }

     // access api hubdat blue load
    private function APISpionam_spionamLast() {
        $dataToken = parent::_initTokenHubdat();
        $bearerToken = 'Bearer ' . $dataToken["access_token"];

        $id = $_POST["id"];

        $response =  $this->APIDetailSpionam('spionam/last', $bearerToken, $id);

        $detail = json_decode($response, true);

        $data = "<table class='table table-striped table-hover'>
                <tbody>
                    " . $this->APIDetailBlueTRTAG('Jenis Pelayanan', $detail["jenis_pelayanan"]) . "
                    " . $this->APIDetailBlueTRTAG('Noken', $detail["noken"]) . "
                    " . $this->APIDetailBlueTRTAG('No Uji', $detail["no_uji"]) . "
                    " . $this->APIDetailBlueTRTAG('Tgl Exp Uji', date("Y-m-d", strtotime($detail["tgl_exp_uji"]))) . "
                    " . $this->APIDetailBlueTRTAG('No Kps', $detail["no_kps"]) . "
                    " . $this->APIDetailBlueTRTAG('Tgl Exp Kps', date("Y-m-d", strtotime($detail["tgl_exp_kps"]))) . "
                    " . $this->APIDetailBlueTRTAG('No Rangka', $detail["no_rangka"]) . "
                    " . $this->APIDetailBlueTRTAG('No Mesin', $detail["no_mesin"]) . "
                    " . $this->APIDetailBlueTRTAG('Merk', $detail["merek"]) . "
                    " . $this->APIDetailBlueTRTAG('Tahun', $detail["tahun"]) . "
                    " . $this->APIDetailBlueTRTAG('Seat', $detail["seat"]) . "
                </tbody>
            </table>";

        $baseModel = new BaseModel();

        // log
        $log_param = json_encode((object)array(
            'no_registrasi_kendaraan' => $id
        ));

        $this->APISpionamLog($baseModel, $bearerToken, $log_param, $response);

        echo json_encode(array("success" => true, "data" => $data, "atr" => ["modal" => "modal_blue", "modal_body" => "modal_body_blue"]));
    }

    // access api hubdat blue load
    function APIListSpionam($service, $bearerToken, $start, $length, $filter = [], $search = "") {
        $url = "";
        if(!$filter) {
            $url = getenv('service.hubdat') . '/ehubdat/v1/' . $service . '?skip=' . $start . '&limit=' . $length . '&sort=ASC' . $search;
        } else {
            $url = getenv('service.hubdat') . '/ehubdat/v1/' . $service . '?skip=' . $start . '&limit=' . $length . '&sort=ASC' . $filter[0] . '' . $filter[1];
        }

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
              'Authorization: ' . $bearerToken
            ),
          ));

          $response = curl_exec($curl);
          
          curl_close($curl);

          return $response;
    }

    // access api hubdat blue load
    function APIDetailSpionam($service, $bearerToken, $id) {
        $curl = curl_init();

            curl_setopt_array($curl, array(
                CURLOPT_URL => getenv('service.hubdat') . '/ehubdat/v1/' . $service . '?noken=' . $id,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'GET',
                CURLOPT_HTTPHEADER => array(
                    'Authorization: ' . $bearerToken
                ),
            ));

            $response = curl_exec($curl);

            curl_close($curl);

            return $response;
    }

    // spionam log
    function APISpionamLog($baseModel, $bearerToken, $log_param, $response) {
        $log_api = [
            "log_method" => 'get',
            "log_url" => get_current_request_url(),
            "log_token" => $bearerToken,
            "log_header" => json_encode((object)array(
                'Authorization' => $bearerToken,
            )),
            "log_param" => $log_param,
            "log_result" => $response,
            "log_ip" => get_client_ip(),
            "log_user_agent" => get_client_user_agent()
        ];

        $baseModel->log_api($log_api, $response);
    }

    // spionam dummuy run
    function APISpionamListDummy($baseModel, $bearerToken, $service, $db) {
        // insert data api to database #100 data
        for($i = 0; $i <= 4; $i++) {
            $response =  $this->APIListSpionam($service, $bearerToken, $i * 20, 20, []);

            $data = json_decode($response, true);

            foreach($data["data"] as $value) {
                $value["created_by"] = $this->session->id;
                $baseModel->base_insert($value, $db);
            }
        }
    }

    function APIDetailBlueTRTAG($label, $value) {
        return "<tr>
            <td>" . $label . "</td>
            <td> : </td>
            <td>" . $value . "</td>
        </tr>";
    }

}
