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
	protected $helpers = ['extension'];

	protected $session;

	private $baseModel;


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
		$this->baseModel = new BaseModel();
		$this->session = \Config\Services::session();
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

			$authenticated();
		}else{
			$this->baseModel->log_action($action, "Akses Ditolak");

			if($action == "load"){
				die(json_encode(array("data" => [], "recordsTotal" => 0, "recordsFiltered" => 0)));
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

	protected function _authLoad(callable $authenticated){
		$this->_auth("load", "v", $authenticated);	
	}

	protected function _authUpload(callable $authenticated){
		$this->_auth("upload", "i", $authenticated);	
	}

	protected function _authDownload(callable $authenticated){
		$this->_auth("download", "v", $authenticated);	
	}

	protected function _loadDatatable($query, $where, $data, callable $callback = NULL){
		$start = $_POST["start"];
        $length = $_POST["length"];
        $search = $_POST["search"];
        $order = $_POST["order"][0];
        $columns = $_POST["columns"];
        $key = $search["value"];
        $orderColumn = $columns[$order["column"]]["data"];
        $orderDirection = $order["dir"];

        $result = $this->baseModel->base_load_datatable($query, $where, $key, $start, $length, $orderColumn, $orderDirection);

		echo json_encode(array("data" => $result["data"], "recordsTotal" => $result["allData"], "recordsFiltered" => $result["filteredData"]));
	}

	protected function _insert($tableName, $data, callable $callback = NULL){
		if($data['id'] == ""){
			$data['created_by'] = $this->session->get('id');

			if($this->baseModel->base_insert($data, $tableName)){
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
				echo json_encode(array('success' => true, 'message' => $data));
			}else{
				echo json_encode(array('success' => false, 'message' => $this->baseModel->db->error()));
			}
		}
	}

	protected function _edit($tableName, $data, $query = NULL){
		$rs = $query == NULL ? $this->baseModel->base_get($tableName, ["id" => $data['id']])->getRow() : $this->baseModel->db->query($query)->getRow();

		if(!is_null($rs)){
			echo json_encode(array('success' => true, 'data' => $rs));
		}else{
			echo json_encode(array('success' => false, 'message' => $this->baseModel->db->error()));
		}
	}

	protected function _delete($tableName, $data){
		if($this->baseModel->base_delete($tableName, ["id" => $data['id']])){
			echo json_encode(array('success' => true));
		}else{
			echo json_encode(array('success' => false, 'message' => $this->baseModel->db->error()));
		}
	}
}
