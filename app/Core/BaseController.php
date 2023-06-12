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

    protected function sha512($payload, $secret_key)
    {
        $algo = 'sha512';
        $signed_payload = hash_hmac($algo, $payload, $secret_key, true);
        return $signed_payload;
    }

    protected function _authView($data = array())
    {
        $url = uri_segment(1);
        $menu = $this->session->get('menu');

        $authentication = array_filter($menu, function ($arr) use ($url) {
            return strtolower($arr->menu_url) == strtolower($url);
        });

        if (count($authentication) == 1) {
            if (array_values($authentication)[0]->v != "1") {
                // $this->baseModel->log_action("view", "Akses Ditolak");

                $data['load_view'] = 'App\Modules\Main\Views\error';
                return view('App\Modules\Main\Views\layout', $data);
            } else {
                // $this->baseModel->log_action("view", "Akses Diberikan");

                $data['page_title'] = array_values($authentication)[0]->menu_name;
                $data['load_view'] = 'App\Modules\\' . ucfirst(array_values($authentication)[0]->module_url) . '\Views\\' . array_values($authentication)[0]->menu_url;
                $data['rules'] = array_values($authentication)[0];
                return view('App\Modules\Main\Views\layout', $data);
            }
        } else {
            // $this->baseModel->log_action("view", "Akses Ditolak");

            $data['load_view'] = 'App\Modules\Main\Views\error';
            return view('App\Modules\Main\Views\layout', $data);
        }
    }

    protected function _auth($action, $var_action, callable $authenticated)
    {
        $referers = explode("/", $_SERVER['HTTP_REFERER']);
        $referer = end($referers);
        $menu = $this->session->get('menu');

        $authentication = array_filter($menu, function ($arr) use ($referer) {
            return strtolower($arr->menu_url) == strtolower($referer);
        });

        if (count($authentication) == 1 && $referer != "" && array_values($authentication)[0]->$var_action == "1") {
            $this->baseModel->log_action($action, "Akses Diberikan");

            if ($action == "detail") {
                return $authenticated();
            } else {
                $authenticated();
            }
        } else {
            $this->baseModel->log_action($action, "Akses Ditolak");

            if ($action == "load") {
                die(json_encode(array("data" => [], "recordsTotal" => 0, "recordsFiltered" => 0)));
            } else if ($action == "detail") {
                die(view('App\Modules\Main\Views\error'));
            } else {
                die(json_encode(array('success' => false, 'message' => 'Anda tidak mempunyai hak akses untuk ini', 'debug' => array_values($authentication)[0])));
            }
        }
    }

    protected function _authInsert(callable $authenticated)
    {
        $this->_auth("insert", "i", $authenticated);
    }

    protected function _authEdit(callable $authenticated)
    {
        $this->_auth("edit", "e", $authenticated);
    }

    protected function _authDelete(callable $authenticated)
    {
        $this->_auth("delete", "d", $authenticated);
    }

    protected function _authVerif(callable $authenticated)
    {
        $this->_auth("verif", "o", $authenticated);
    }

    protected function _authLoad(callable $authenticated)
    {
        $this->_auth("load", "v", $authenticated);
    }

    protected function _authUpload(callable $authenticated)
    {
        $this->_auth("upload", "i", $authenticated);
    }

    protected function _authDownload(callable $authenticated)
    {
        $this->_auth("download", "v", $authenticated);
    }

    protected function _authDetail(callable $authenticated)
    {
        return $this->_auth("detail", "v", $authenticated);
    }

    protected function _loadDatatable($query, $where, $data, $groupby = NULL)
    {
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

    protected function _insert($tableName, $data, callable $callback = NULL)
    {
        if ($data['id'] == "") {
            $data['created_by'] = $this->session->get('id');

            if ($this->baseModel->base_insert($data, $tableName)) {
                if ($callback != NULL) {
                    $callback();
                }

                echo json_encode(array('success' => true, 'message' => $data));
            } else {
                echo json_encode(array('success' => false, 'message' => $this->baseModel->db->error()));
            }
        } else {
            $id = $data['id'];
            $data['last_edited_at'] = date('Y-m-d H:i:s');
            $data['last_edited_by'] = $this->session->get('id');
            unset($data['id']);

            if ($this->baseModel->base_update($data, $tableName, array('id' => $id))) {
                if ($callback != NULL) {
                    $callback();
                }

                echo json_encode(array('success' => true, 'message' => $data));
            } else {
                echo json_encode(array('success' => false, 'message' => $this->baseModel->db->error()));
            }
        }
    }

    protected function _insertv2($tableName, $data, callable $callback = NULL)
    {
        if ($data['id'] == "") {
            $data['created_by'] = $this->session->get('id');

            if ($this->baseModel->base_insert($data, $tableName)) {
                if ($callback != NULL) {
                    $callback();
                }

                echo json_encode(array('success' => true, 'message' => $data));
            } else {
                echo json_encode(array('success' => false, 'message' => $this->baseModel->db->error()));
            }
        } else {
            $id = $data['id'];
            $data['updated_at'] = date('Y-m-d H:i:s');
            $data['updated_by'] = $this->session->get('id');
            unset($data['id']);

            if ($this->baseModel->base_update($data, $tableName, array('id' => $id))) {
                if ($callback != NULL) {
                    $callback();
                }

                echo json_encode(array('success' => true, 'message' => $data));
            } else {
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

    // fetch detail
    protected function _editModal($tableName, $data, $res_data, $keys = NULL, $query = NULL)
    {
        $key = $keys == NULL ? 'id' : $keys;
        $rs = $query == NULL ? $this->baseModel->base_get($tableName, [$key => $data[$key]])->getRow() : $this->baseModel->db->query($query[0] . " where " . $key . " = " . "'" . $data['id'] . "'" . " " . $query[1])->getRow();

        $dres_data = [];
        foreach ($res_data as $key => $value) {
            switch ($value) {
                case strpos($value, '(date)') !== false:
                    $value = str_replace('(date)', '', $value);
                    $dres_data[str_replace('_', ' ', $value)] = $rs->$value ? date("Y-m-d", strtotime($rs->$value)) : '-';
                    break;
                default:
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

    protected function _delete($tableName, $data)
    {
        if ($this->baseModel->base_delete($tableName, ["id" => $data['id']])) {
            echo json_encode(array('success' => true));
        } else {
            echo json_encode(array('success' => false, 'message' => $this->baseModel->db->error()));
        }
    }

    protected function _deletev2($tableName, $data)
    {
        if ($this->baseModel->base_deletev2($tableName, ["id" => $data['id']])) {
            echo json_encode(array('success' => true));
        } else {
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

    protected function _sendNotification($fcm, $title, $body, $data = null)
    {
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
            'Authorization:key=' . $server_key
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

    protected function _cekEmptyValue($data)
    {
        $result = [];
        foreach($data as $key => $val) {
            if($key != "id") {
                if(!empty($val)) {
                    $result[$key] = $val;
                }
            } else {
                $result[$key] = $val;
            }
        }

        return $result;
    }

}
