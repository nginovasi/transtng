<?php namespace App\Modules\Administrator\Controllers;

use App\Modules\Administrator\Models\AdministratorModel;
use App\Core\BaseController;

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
        $menu = $this->administratorModel->base_get('master_menu', ['module_id' => $module_id, 'menu_id' => NULL])->getResult();

        $option = array_map(function($data){
            return "<option value='".$data->id."'>".$data->menu_name."</option>";
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
        $array = array_map(function($menu){
            $x = json_decode(json_encode($menu), true);
            $x['submenu'] = $this->administratorModel->getSubMenu($x['id']);

            return $x;
        }, $menus);

        echo json_encode($array);
    }

    public function module_select_get(){
        $module = $this->administratorModel->getModules();

        $option = array_map(function($data){
            return "<option value='".$data->id."'>".$data->module_name."</option>";
        }, $module);

        return "<select class='idmodule' name='idmodule[]' required>
                <option value=''>Pilih Modul</option>" .
                implode("", $option) . "<select>";
    }
}
