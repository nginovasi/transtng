<?php namespace App\Modules\Auth\Models;

use App\Core\BaseModel;

class AuthModel extends BaseModel
{
	function __construct() {
		parent::__construct();
	}

    public function getUser($username, $password)
    {
        return $this->db->query('select * from master_user where user_username = "'.$username.'" and user_password = md5("'.$password.'")')->getRow();
    }

    public function getMenu($userType)
    {
    	return $this->db->query('select a.*, b.menu_url, b.menu_name, c.module_url, c.module_name, d.menu_name as menu_parent from master_user_privileges a
                              inner join master_menu b on a.menu_id = b.id and b.is_deleted = 0
                              inner join master_module c on b.module_id = c.id and c.is_deleted = 0
                              left join master_menu d on b.menu_id = d.id and d.is_deleted = 0
                              where a.user_type_code = "'.$userType.'" and a.v = 1')->getResult();
    }
}