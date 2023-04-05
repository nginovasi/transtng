<?php namespace App\Modules\Administrator\Controllers;

use App\Modules\Administrator\Models\AdministratorModel;
use App\Core\BaseController;

class AdministratorAction extends BaseController
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

    function manmodul_load()
    {
        parent::_authLoad(function(){
            $query = "select a.* from master_module a where a.is_deleted = 0";
            $where = ["a.module_url", "a.module_name"];
        
            parent::_loadDatatable($query, $where, $this->request->getPost());
        });
    }

    function manmodul_save()
    {
        parent::_authInsert(function(){
            parent::_insert('master_module', $this->request->getPost());
        });
    }

    function manmodul_edit()
    {
        parent::_authEdit(function(){
            parent::_edit('master_module', $this->request->getPost());
        });
    }

    function manmodul_delete()
    {   
        parent::_authDelete(function(){
            parent::_delete('master_module', $this->request->getPost());
        });
    }

    function manmenu_load()
    {
        parent::_authLoad(function(){
            $query = "select a.*, b.module_name, c.menu_name as menu_parent from master_menu a 
            left join master_module b on a.module_id = b.id
            left join master_menu c on a.menu_id = c.id
            where a.is_deleted = 0";
            $where = ["a.menu_url", "a.menu_name", "b.module_name", "c.menu_name"];
            
            parent::_loadDatatable($query, $where, $this->request->getPost());
        });
    }

    function manmenu_save()
    {
        parent::_authInsert(function(){
            $data = $this->request->getPost();
            $data['menu_id'] = $this->request->getPost('menu_id') == "" ? null : $this->request->getPost('menu_id');
            parent::_insert('master_menu', $data);
        });
    }

    function manmenu_edit()
    {
        parent::_authEdit(function(){
            parent::_edit('master_menu', $this->request->getPost());
        });
    }

    function manmenu_delete()
    {
        parent::_authDelete(function(){
            parent::_delete('master_menu', $this->request->getPost());
        });
    }

    function manjenisuser_load()
    {
        parent::_authLoad(function(){
            $query = "select a.* from master_user_type a where a.is_deleted = 0";
            $where = ["a.user_type_code", "a.user_type_name"];
            
            parent::_loadDatatable($query, $where, $this->request->getPost());
        });
    }

    function manjenisuser_save()
    {   
        parent::_authInsert(function(){
            parent::_insert('master_user_type', $this->request->getPost());
        });
    }

    function manjenisuser_edit()
    {   
        parent::_authEdit(function(){
            parent::_edit('master_user_type', $this->request->getPost());
        });
    }

    function manjenisuser_delete()
    {   
        parent::_authDelete(function(){
            parent::_delete('master_user_type', $this->request->getPost());
        });
    }

    function manuser_load()
    {
        parent::_authLoad(function(){
            $query = "select a.*, b.user_type_name from master_user a 
            left join master_user_type b on a.user_type_code = b.user_type_code
            where a.is_deleted = 0";
            $where = ["a.user_name", "a.user_username", "a.user_email", "b.user_type_name"];
            
            parent::_loadDatatable($query, $where, $this->request->getPost());
        });
    }

    function manuser_save()
    {   
        parent::_authInsert(function(){
            $data = $this->request->getPost();
            $data["user_password"] = md5($data["user_password"]);
            
            parent::_insert('master_user', $data);
        });
    }

    function manuser_edit()
    {   
        parent::_authEdit(function(){
            parent::_edit('master_user', $this->request->getPost());
        });
    }

    function manuser_delete()
    {   
        parent::_authDelete(function(){
            parent::_delete('master_user', $this->request->getPost());
        });
    }


    function manhakakses_save()
    {
        parent::_authInsert(function(){
            $number_menu = count($this->request->getPost('idmenu'));
            $deleted = explode(",", $this->request->getPost('delete'));

            $previlagesData = [];
            for ($i=0; $i < $number_menu; $i++) {
                $previlagesData[] = [
                    "id" => $this->request->getPost('id')[$i],
                    "menu_id" => $this->request->getPost('idmenu')[$i],
                    "v" => unwrap_null(@$this->request->getPost('v')[$i], "0"),
                    "i" => unwrap_null(@$this->request->getPost('i')[$i], "0"),
                    "d" => unwrap_null(@$this->request->getPost('d')[$i], "0"),
                    "e" => unwrap_null(@$this->request->getPost('e')[$i], "0"),
                    "o" => unwrap_null(@$this->request->getPost('o')[$i], "0"),
                    "user_type_code" => $this->request->getPost('iduser'),
                    "created_by" => $this->session->get('id'),
                    "created_at" => date("Y-m-d H:i:s")
                ];
            }

            if($this->administratorModel->saveHakAkses($previlagesData, $deleted, $this->request->getPost('iduser'))){
                echo json_encode(array('success' => true, 'message' => $previlagesData));
            }else{
                echo json_encode(array('success' => false, 'message' => $this->administratorModel->db->error()));
            }
        });
    }
}
