<?php namespace App\Modules\Administrator\Models;

use App\Core\BaseModel;
class AdministratorModel extends BaseModel
{
    public function getModules()
    {
        return $this->db->query('select a.* from master_module a where a.is_deleted = 0')->getResult();
    }

    public function getUserTypes()
    {
    	return $this->db->query('select a.* from master_user_type a where a.is_deleted = 0')->getResult();	
    }

    public function getModuleUser($user_code)
    {
    	return $this->db->query('select a.*, b.menu_name, b.menu_url, c.id as module_id, c.module_name, c.module_name 
    		from master_user_privileges a 
    		inner join master_menu b on a.menu_id = b.id and b.is_deleted = 0
    		inner join master_module c on b.module_id = c.id and c.is_deleted = 0
    		where a.user_type_code = "'.$user_code.'" and a.is_deleted = 0
    		')->getResult();
    }

	public function getParentMenu($module_id)
	{
	 	return $this->db->query('select * from master_menu where module_id = "'.$module_id.'" and menu_id is null and is_deleted = 0')->getResult();
	}

	public function getSubMenu($menu_id)
	{
     	return $this->db->query('select * from master_menu where menu_id = "'.$menu_id.'" and is_deleted = 0')->getResult();
    }

	public function deleteByModuleAndUserType($id, $user_type)
    {
    	return $this->db->query('delete a.* from master_user_privileges a 
    		inner join master_menu b on a.menu_id = b.id
    		inner join master_module c on b.module_id = c.id
    		where a.user_type_code = "'.$user_type.'" and c.id = "'.$id.'" and a.is_deleted = 1');	
    }

    public function deleteMenuByModuleAndUserType($id, $user_type)
    {
    	return $this->db->query('update master_user_privileges a 
    		inner join master_menu b on a.menu_id = b.id
    		inner join master_module c on b.module_id = c.id
    		set a.is_deleted = 1, a.last_edited_at = "'.date("Y-m-d H:i:s").'", a.last_edited_by = "'.$this->session->get('id').'"
    		where a.user_type_code = "'.$user_type.'" and c.id = "'.$id.'"');	
    }

	public function saveHakAkses($previleges, $deleted, $user_type)
	{
		$this->db->transBegin();

		foreach ($deleted as $deleted_id) {
			$this->deleteByModuleAndUserType($deleted_id, $user_type);
			$this->deleteMenuByModuleAndUserType($deleted_id, $user_type);
		}

		foreach ($previleges as $previlege) {

			$previlagesUpdate = [
                "v = '" . $previlege["v"] . "'",
                "i = '" . $previlege["i"] . "'",
                "d = '" . $previlege["d"] . "'",
                "e = '" . $previlege["e"] . "'",
                "o = '" . $previlege["o"] . "'",
                "last_edited_by = '" . $this->session->get('id') . "'",
                "last_edited_at = '" . date("Y-m-d H:i:s") . "'"
            ];

            $query = $this->string_insert($previlege, 'master_user_privileges') . ' ON DUPLICATE KEY UPDATE '. implode(", ", $previlagesUpdate);
            $this->db->query($query);
		}

		if ($this->db->transStatus() === FALSE)
		{
		    $this->db->transRollback();
		    $this->db->transComplete();
		    return false;
		}
		else
		{
		    $this->db->transCommit();
		    $this->db->transComplete();
		    return true;
		}
	}
}