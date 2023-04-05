<?php
namespace App\Core;

/**
 * Class BaseController
 *
 * BaseController provides a convenient place for loading components
 * and performing functions that are needed by all your controllers.
 * Extend this class in any new controllers:
 *     class Home extends BaseController
 *
 * For security be sure to declare any new methods as protected or private.
 *
 * @package CodeIgniter
 */

use CodeIgniter\Controller;
use App\Core\BaseModel;

class BaseController extends Controller
{

	/**
	 * An array of helpers to be loaded automatically upon
	 * class instantiation. These helpers will be available
	 * to all other controllers that extend BaseController.
	 *
	 * @var array
	 */
	protected $helpers = ['extension', 'apires'];

	protected $session;

	protected $baseModel;

	protected $db;


	/**
	 * Constructor.
	 */
	public function initController(\CodeIgniter\HTTP\RequestInterface $request, \CodeIgniter\HTTP\ResponseInterface $response, \Psr\Log\LoggerInterface $logger)
	{
		// Do Not Edit This Line
		parent::initController($request, $response, $logger);

		//--------------------------------------------------------------------
		// Preload any models, libraries, etc, here.
		//--------------------------------------------------------------------
		// E.g.:
		// $this->session = \Config\Services::session();
		$this->baseModel = new BaseModel(\Config\Services::request());
		$this->session = \Config\Services::session();
		$this->db = \Config\Database::connect();
	}

	protected function _authView($data = array()){
		$url = uri_segment(1);
		$menu = $this->session->get('menu');

		$authentication = array_filter($menu, function($arr) use ($url){
			return strtolower($arr->menu_url) == strtolower($url);
		});

		if(count($authentication) == 1){
			if(array_values($authentication)[0]->v != "1"){
				// $this->baseModel->log_action("view", "Akses Ditolak");

				$data['load_view'] = 'App\Modules\Main\Views\error';
				return view('App\Modules\Main\Views\layout', $data);
			}else{
				// $this->baseModel->log_action("view", "Akses Diberikan");

				$data['page_title'] = array_values($authentication)[0]->menu_name;
				$data['load_view'] = 'App\Modules\\'.ucfirst(array_values($authentication)[0]->module_url).'\Views\\'.array_values($authentication)[0]->menu_url;
				$data['rules'] = array_values($authentication)[0];
				return view('App\Modules\Main\Views\layout', $data);
			}
		}else{
			// $this->baseModel->log_action("view", "Akses Ditolak");

			$data['load_view'] = 'App\Modules\Main\Views\error';
			return view('App\Modules\Main\Views\layout', $data);
		}
	}

	protected function _auth($action, $var_action, callable $authenticated){
		$referers = explode("/", $_SERVER['HTTP_REFERER']);
		$referer = end($referers);
		$menu = $this->session->get('menu');

		$authentication = array_filter($menu, function($arr) use ($referer) {
			return strtolower($arr->menu_url) == strtolower($referer);
		});

		if(count($authentication) == 1 && $referer != "" && array_values($authentication)[0]->$var_action == "1"){
			$this->baseModel->log_action($action, "Akses Diberikan");

            if($action=="detail") {
                return $authenticated();
            }else{
                $authenticated();
            }
		}else{
			$this->baseModel->log_action($action, "Akses Ditolak");

			if($action == "load"){
				die(json_encode(array("data" => [], "recordsTotal" => 0, "recordsFiltered" => 0)));
			}else if($action == "detail"){
                die(view('App\Modules\Main\Views\error'));
            }else{
				die(json_encode(array('success' => false, 'message' => 'Anda tidak mempunyai hak akses untuk ini', 'debug' => array_values($authentication)[0])));
			}
		}
	}

	protected function _authInsert(callable $authenticated){
		$this->_auth("insert", "i", $authenticated);
	}

	protected function _authEdit(callable $authenticated){
		$this->_auth("edit", "e", $authenticated);
	}

	protected function _authDelete(callable $authenticated){
		$this->_auth("delete", "d", $authenticated);
	}

    protected function _authVerif(callable $authenticated){
        $this->_auth("verif", "o", $authenticated);
    }

	protected function _authLoad(callable $authenticated){
		$this->_auth("load", "v", $authenticated);	
	}

	protected function _authUpload(callable $authenticated){
		$this->_auth("upload", "i", $authenticated);	
	}

	protected function _authDownload(callable $authenticated){
		$this->_auth("download", "v", $authenticated);	
	}

    protected function _authDetail(callable $authenticated){
        return $this->_auth("detail", "v", $authenticated);  
    }

	protected function _loadDatatable($query, $where, $data, $groupby = NULL){
		$start = $_POST["start"];
        $length = $_POST["length"];
        $search = $_POST["search"];
        $order = $_POST["order"][0];
        $columns = $_POST["columns"];
        $key = $search["value"];
        $orderColumn = $columns[$order["column"]]["data"];
        $orderDirection = $order["dir"];

        $result = $this->baseModel->base_load_datatable($query, $where, $key, $start, $length, $orderColumn, $orderDirection, $groupby);

		echo json_encode(array("data" => $result["data"], "recordsTotal" => $result["allData"], "recordsFiltered" => $result["filteredData"]));
	}

    protected function _loadDatatableBlue($query, $where, $data, $groupby = NULL){
		$start = $_POST["start"];
        $length = $_POST["length"];
        $search = $_POST["search"];
        $order = $_POST["order"][0];
        $columns = $_POST["columns"];
        $key = $search["value"];
        $orderColumn = $columns[$order["column"]]["data"];
        $orderDirection = $order["dir"];

        $result = $this->baseModel->base_load_datatable_blue($query, $where, $key, $start, $length, $orderColumn, $orderDirection, $groupby);

		echo json_encode(array("data" => $result["data"], "recordsTotal" => $result["allData"], "recordsFiltered" => $result["filteredData"]));
	}

	protected function _insert($tableName, $data, callable $callback = NULL){
		if($data['id'] == ""){
			$data['created_by'] = $this->session->get('id');

			if($this->baseModel->base_insert($data, $tableName)){
                if($callback!=NULL) { $callback(); }

				echo json_encode(array('success' => true, 'message' => $data));
			}else{
				echo json_encode(array('success' => false, 'message' => $this->baseModel->db->error()));
			}
		}else{
			$id = $data['id'];
			$data['last_edited_at'] = date('Y-m-d H:i:s');
			$data['last_edited_by'] = $this->session->get('id');
			unset($data['id']);

			if($this->baseModel->base_update($data, $tableName, array('id' => $id))){
                if($callback!=NULL) { $callback(); }

				echo json_encode(array('success' => true, 'message' => $data));
			}else{
				echo json_encode(array('success' => false, 'message' => $this->baseModel->db->error()));
			}
		}
	}

	protected function _edit($tableName, $data, $keys = NULL, $query = NULL)
    {
        $key = $keys == NULL ? 'id' : $keys;
        $rs = $query == NULL ? $this->baseModel->base_get($tableName, [$key => $data[$key]])->getRow() : $this->baseModel->db->query($query)->getRow();

        if (!is_null($rs)) {
            echo json_encode(array('success' => true, 'data' => $rs));
        } else {
            echo json_encode(array('success' => false, 'message' => $this->baseModel->db->error()['message']));
        }
    }

	// fetch api blue lite no union
	// protected function _editOnlyBlueLite($tableName, $data, $keys = NULL, $query = NULL)
    // {
    //     $key = $keys == NULL ? 'id' : $keys;
    //     $rs = $query == NULL ? $this->baseModel->base_get($tableName, ['no_registrasi_kendaraan' => $data[$key]])->getRow() : $this->baseModel->db->query($query)->getRow();

	// 	$data = "<table class='table table-striped table-hover'>
    //                 <tbody>
    //                     " . $this->_APIDetailBlueTRTAG('Nama Pemilik', $rs->nama_pemilik) . "
    //                     " . $this->_APIDetailBlueTRTAG('Alamat Pemilik', $rs->alamat_pemilik) . "
    //                     " . $this->_APIDetailBlueTRTAG('No Registrasi Kendaraan', $rs->no_registrasi_kendaraan) . "
    //                     " . $this->_APIDetailBlueTRTAG('No Rangka', $rs->no_rangka) . "
    //                     " . $this->_APIDetailBlueTRTAG('No Mesin', $rs->no_mesin) . "
    //                     " . $this->_APIDetailBlueTRTAG('Jenis Kendaraan', $rs->jenis_kendaraan) . "
    //                     " . $this->_APIDetailBlueTRTAG('Merk', $rs->merk) . "
    //                     " . $this->_APIDetailBlueTRTAG('Tipe', $rs->tipe) . "
    //                     " . $this->_APIDetailBlueTRTAG('Tahun Rakit', $rs->tahun_rakit) . "
    //                     " . $this->_APIDetailBlueTRTAG('Bahan Bakar', $rs->bahan_bakar) . "
    //                     " . $this->_APIDetailBlueTRTAG('Isi Silinder', $rs->isi_silinder) . "
    //                     " . $this->_APIDetailBlueTRTAG('Daya Motor', $rs->daya_motor) . "
    //                     " . $this->_APIDetailBlueTRTAG('Ukuran Ban', $rs->ukuran_ban) . "
    //                     " . $this->_APIDetailBlueTRTAG('Sumbu', $rs->sumbu) . "
    //                     " . $this->_APIDetailBlueTRTAG('Berat Kosong', $rs->berat_kosong) . "
    //                     " . $this->_APIDetailBlueTRTAG('Panjang Kendaraan', $rs->panjang_kendaraan) . "
    //                     " . $this->_APIDetailBlueTRTAG('Lebar Kendaraan', $rs->lebar_kendaraan) . "
    //                     " . $this->_APIDetailBlueTRTAG('Tinggi Kendaraan', $rs->tinggi_kendaraan) . "
    //                     " . $this->_APIDetailBlueTRTAG('Julur Depan', $rs->julur_depan) . "
    //                     " . $this->_APIDetailBlueTRTAG('Julur Belakang', $rs->julur_belakang) . "
    //                     " . $this->_APIDetailBlueTRTAG('Jarak Sumbu 1 2', $rs->jarak_sumbu_1_2) . "
    //                     " . $this->_APIDetailBlueTRTAG('Jarak Sumbu 2 3', $rs->jarak_sumbu_2_3) . "
    //                     " . $this->_APIDetailBlueTRTAG('Jarak Sumbu 3 4', $rs->jarak_sumbu_3_4) . "
    //                     " . $this->_APIDetailBlueTRTAG('Dimensi Bak Tangki', $rs->dimensi_bak_tangki) . "
    //                     " . $this->_APIDetailBlueTRTAG('JBB', $rs->jbb) . "
    //                     " . $this->_APIDetailBlueTRTAG('JBKB', $rs->jbkb) . "
    //                     " . $this->_APIDetailBlueTRTAG('JBI', $rs->jbi) . "
    //                     " . $this->_APIDetailBlueTRTAG('JBKI', $rs->jbki) . "
    //                     " . $this->_APIDetailBlueTRTAG('Daya Angkut Orang', $rs->daya_angkut_orang) . "
    //                     " . $this->_APIDetailBlueTRTAG('Daya Angkut KG', $rs->daya_angkut_kg) . "
    //                     " . $this->_APIDetailBlueTRTAG('Kelas Jalan', $rs->kelas_jalan) . "
    //                     " . $this->_APIDetailBlueTRTAG('Keterangan hasil Uji Coba', $rs->keterangan_hasil_uji) . "
    //                     " . $this->_APIDetailBlueTRTAG('Petugas Penguji', $rs->petugas_penguji) . "
    //                     " . $this->_APIDetailBlueTRTAG('NRP Petugas Penguji', $rs->nrp_petugas_penguji) . "
    //                     " . $this->_APIDetailBlueTRTAG('Kepala Dinas', $rs->kepala_dinas) . "
    //                     " . $this->_APIDetailBlueTRTAG('Pangkat Kepala Dinas', $rs->pangkat_kepala_dinas) . "
    //                     " . $this->_APIDetailBlueTRTAG('NIP Kepala Dinas', $rs->nip_kepala_dinas) . "
    //                     " . $this->_APIDetailBlueTRTAG('Unit Pelaksana Teknis', $rs->unit_pelaksana_teknis) . "
    //                     " . $this->_APIDetailBlueTRTAG('Direktur', $rs->direktur) . "
    //                     " . $this->_APIDetailBlueTRTAG('Perangkat Direktur', $rs->pangkat_direktur) . "
    //                     " . $this->_APIDetailBlueTRTAG('NIP Direktur', $rs->nip_direktur) . "
    //                     " . $this->_APIDetailBlueTRTAG('No Uji Kendaraan', $rs->no_uji_kendaraan) . "
    //                 </tbody>
    //             </table>";

    //     if (!is_null($rs)) {
    //         echo json_encode(array('success' => true, 'data' => $data, "atr" => ["modal" => "modal_blue", "modal_body" => "modal_body_blue"]));
    //     } else {
    //         echo json_encode(array('success' => false, 'message' => $this->baseModel->db->error()['message']));
    //     }
    // }

	// fetch api blue test period no union
	// protected function _editOnlyBlueTestPeriod($tableName, $data, $keys = NULL, $query = NULL)
    // {
    //     $key = $keys == NULL ? 'id' : $keys;
    //     $rs = $query == NULL ? $this->baseModel->base_get($tableName, ['no_registrasi_kendaraan' => $data[$key]])->getRow() : $this->baseModel->db->query($query)->getRow();

	// 	// comment because response not same list blue
	// 	// $statusUjiBerkala = $rs->status_uji_berkala ? "true" : "false";
	// 	// " . $this->_APIDetailBlueTRTAG('No Registrasi Kendaraan', $statusUjiBerkala) . "
	// 	// " . $this->_APIDetailBlueTRTAG('Tempat Uji Terakhir', $rs->tempat_uji_terakhir) . "
	// 	// " . $this->_APIDetailBlueTRTAG('Hasil Uji Terakhir', $rs->hasil_uji_terakhir) . "

	// 	$data = "<table class='table table-striped table-hover'>
    //                 <tbody>
    //                     " . $this->_APIDetailBlueTRTAG('Status Uji Berkala', $rs->no_registrasi_kendaraan) . "
    //                     " . $this->_APIDetailBlueTRTAG('Date', date("Y-m-d", strtotime($rs->date ))) . "
    //                 </tbody>
    //             </table>";

    //     if (!is_null($rs)) {
    //         echo json_encode(array('success' => true, 'data' => $data, "atr" => ["modal" => "modal_blue", "modal_body" => "modal_body_blue"]));
    //     } else {
    //         echo json_encode(array('success' => false, 'message' => $this->baseModel->db->error()['message']));
    //     }
    // }

    // fetch detail
	protected function _editModal($tableName, $data, $res_data, $keys = NULL, $query = NULL)
    {
        $key = $keys == NULL ? 'id' : $keys;
        $rs = $query == NULL ? $this->baseModel->base_get($tableName, [$key => $data[$key]])->getRow() : $this->baseModel->db->query($query[0] . " where " . $key . " = " . "'" . $data['id'] . "'" . " " . $query[1])->getRow();

        $dres_data = [];
        foreach($res_data as $key => $value) {
            switch($value) {
                case strpos($value, '(date)') !== false :
                    $value = str_replace('(date)', '', $value);
                    $dres_data[str_replace('_', ' ', $value)] = $rs->$value ? date("Y-m-d", strtotime($rs->$value)) : '-';
                break;
                default :
                    $dres_data[str_replace('_', ' ', $value)] = $rs->$value ? $rs->$value : '-';
            }
        }

        $data = $this->tableDumb($dres_data);        

        if (!is_null($rs)) {
            echo json_encode(array('success' => true, 'data' => $data, "atr" => ["modal" => "modal_blue", "modal_body" => "modal_body_blue"]));
        } else {
            echo json_encode(array('success' => false, 'message' => $this->baseModel->db->error()['message']));
        }
    }

	// fetch detail only blue
	protected function _editModalCustomBlue($tableName, $data, $res_data, $keys = NULL, $query = NULL, $svc = "last")
    {
        $key = $keys == NULL ? 'id' : $keys;
        $rs = $query == NULL ? $this->baseModel->base_get($tableName, ['no_registrasi_kendaraan' => $data[$key]])->getRow() : $this->baseModel->db->query($query[0] . " and a.no_registrasi_kendaraan = " . "'" . $data[$key] . "'" . " UNION " . $query[1] . " and b.no_registrasi_kendaraan = " . "'" . $data[$key] . "'")->getRow();

		$data = "";
        $dres_data = [];
        foreach($res_data as $key => $value) {
            switch($value) {
                case strpos($value, '(date)') !== false :
                    $value = str_replace('(date)', '', $value);
                    $dres_data[str_replace('_', ' ', $value)] = $rs->$value ? date("Y-m-d", strtotime($rs->$value)) : '-';
                break;
                default :
                    $dres_data[str_replace('_', ' ', $value)] = $rs->$value ? $rs->$value : '-';
            }
        }
		switch ($svc) {
			case 'lite' :
                $data = $this->tableDumb($dres_data);
			break;
			case 'test-period' :
                // comment because response not same list blue last
                // status_uji_berkala, tempat_uji_terakhir, hasil_uji_terakhir
                $data = $this->tableDumb($dres_data);
			break;
			case 'last' :
				// comment because response not same list blue last
                // uji, uji['item_uji'], uji['ambang_batas'], uji['hasiluji]
                $data = $this->tableDumb($dres_data);
			break;
		}
		

        if (!is_null($rs)) {
            echo json_encode(array('success' => true, 'data' => $data, "atr" => ["modal" => "modal_blue", "modal_body" => "modal_body_blue"]));
        } else {
            echo json_encode(array('success' => false, 'message' => $this->baseModel->db->error()['message']));
        }
    }

    protected function tableDumb($fields) {
        $data = "<table class='table table-striped table-hover'>
                    <tbody>";

        foreach($fields as $key => $value) {
            $data .= $this->_APIDetailBlueTRTAG($key, $value);
        }

        $data .= "</tbody>
                </table>";

        return $data;
    }

	protected function _APIDetailBlueTRTAG($label, $value) {
        return "<tr>
            <td>" . $label . "</td>
            <td> : </td>
            <td>" . $value . "</td>
        </tr>";
    }

	protected function _delete($tableName, $data){
		if($this->baseModel->base_delete($tableName, ["id" => $data['id']])){
			echo json_encode(array('success' => true));
		}else{
			echo json_encode(array('success' => false, 'message' => $this->baseModel->db->error()));
		}
	}

	protected function _loadSelect2($data, $query, $where)
    {
        $keyword = $data['keyword'] ?? "";
        $page = $data['page'];
        $perpage = $data['perpage'];

        $result = $this->baseModel->base_load_select2($query, $where, $keyword, $page, $perpage);

        echo json_encode(array("page" => $page, "perpage" => $perpage, "total" => count($result), "rows" => $result));
    }

    protected function _sendNotification($fcm, $title, $body, $data = null){
        $json_data = [
                        "to" => $fcm,
                        "notification" => [
                            "title" => $title,
                            "body" => $body,
                            "icon" => "ic_launcher"
                        ],
                        "data" => $data
                    ];

        $data = json_encode($json_data);
        //FCM API end-point
        $url = 'https://fcm.googleapis.com/fcm/send';
        //api_key in Firebase Console -> Project Settings -> CLOUD MESSAGING -> Server key
        $server_key = '';
        //header with content_type api key
        $headers = array(
            'Content-Type:application/json',
            'Authorization:key='.$server_key
        );

        //CURL request to route notification to FCM connection server (provided by Google)
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        $result = curl_exec($ch);

        if ($result === FALSE) {
            die('Oops! FCM Send Error: ' . curl_error($ch));
        }

        curl_close($ch);

        return $result;
    }

	protected function _initTokenHubdat(){
        $curl = curl_init();

		curl_setopt_array($curl, array(
		CURLOPT_URL => getenv('service.hubdat') . '/token',
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_ENCODING => '',
		CURLOPT_MAXREDIRS => 10,
		CURLOPT_TIMEOUT => 0,
		CURLOPT_FOLLOWLOCATION => true,
		CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		CURLOPT_CUSTOMREQUEST => 'POST',
		CURLOPT_POSTFIELDS => 'grant_type=client_credentials',
		CURLOPT_HTTPHEADER => array(
			'Authorization: Basic ' . getenv('service.hubdat.basic'),
			'Content-Type: application/x-www-form-urlencoded'
		),
		));

		$response = curl_exec($curl);

		curl_close($curl);

		return json_decode($response, true);
    }

    protected function _curlGETKemenhub($urlTail) {
        $curl = curl_init();
        
        curl_setopt_array($curl, array(
          CURLOPT_URL => getenv('service.kemenhub') . $urlTail,
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => '',
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => 'GET',
          CURLOPT_HTTPHEADER => array(
            'Authorization: Basic ' . getenv('service.kemenhub.basic')
          ),
        ));
        
        $response = curl_exec($curl);

        curl_close($curl);
        
        return json_decode($response, true);
    }
}
