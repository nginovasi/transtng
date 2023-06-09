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

    public function web_role_get()
    {
        $data = $this->request->getGet();
        $query = "SELECT a.id, a.user_web_role_name AS 'text' FROM s_user_web_role a WHERE a.is_deleted != '1' ";
        $where = ["a.user_web_role_name"];

        parent::_loadSelect2($data, $query, $where);
    }

    public function getTenant()
    {
        $data = $this->request->getGet();
        $query = "SELECT a.id, a.nama as 'text' FROM ref_tenant a WHERE a.nama IS NOT NULL";
        $where = ["a.nama"];

        parent::_loadSelect2($data, $query, $where);
    }

    public function type_bis_id_select_get()
    {
        $data = $this->request->getGet();

        // $query = "SELECT a.id, a.nama as 'text' FROM ref_tenant a WHERE a.nama IS NOT NULL";

        $query = "SELECT id, name as 'text' from m_type_bis where is_deleted = 0";
        
        $where = ["name"];

        parent::_loadSelect2($data, $query, $where);
    }
}
