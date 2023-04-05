<?php
namespace App\Modules\Auth\Models;

use App\Core\BaseModel;

class AuthModel extends BaseModel
{
    function __construct()
    {
        parent::__construct();
    }

    public function getUser($username, $password)
    {
        #return $this->db->query('select * from m_user_web where user_web_username = ? and user_web_password = md5(?)', array($username, $password))->getRow();
        return $this->db->query('select c.id as bptd_id,c.instansi_detail_name,b.user_web_role_name,a.* from m_user_web a 
inner join s_user_web_role b on a.user_web_role_id = b.id
left join m_instansi_detail c on a.instansi_detail_id=c.id
where a.user_web_username = ? and a.user_web_password=md5(?)', array($username, $password))->getRow();
    }
    public function getUserByEmail($email)
    {
        #return $this->db->query('select * from m_user_web where user_web_email = ? ', array($email))->getRow();
        return $this->db->query('select c.id as bptd_id,c.instansi_detail_name,b.user_web_role_name,a.* from m_user_web a 
inner join s_user_web_role b on a.user_web_role_id = b.id
left join m_instansi_detail c on a.instansi_detail_id=c.id
where a.user_web_email = ?', array($email))->getRow();
    }

    public function getMenu($userRoleId)
    {
        return $this->db->query('SELECT a.*, b.menu_url, b.menu_name, c.module_url, c.module_name, d.menu_name AS menu_parent, CASE WHEN DATE(b.created_at) >= DATE(NOW() - INTERVAL 7 DAY) THEN "new"
        ELSE NULL
        END AS menu_status 
        FROM s_user_web_privilege a
                                      INNER JOIN s_menu b ON a.menu_id = b.id AND b.is_deleted = 0
                                      INNER JOIN s_module c ON b.module_id = c.id AND c.is_deleted = 0
                                      LEFT JOIN s_menu d ON b.menu_id = d.id AND d.is_deleted = 0
                                      WHERE a.user_web_role_id = ? AND a.v = 1 AND a.is_deleted = 0', array($userRoleId))->getResult();
    }

    public function changePassword($newPassword, $id)
    {
        return $this->db->query('update m_user_web set user_web_password = md5(?) where id = ?', array($newPassword, $id));
    }
}