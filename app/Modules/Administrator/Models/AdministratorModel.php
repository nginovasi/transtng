<?php

namespace App\Modules\Administrator\Models;

use App\Core\BaseModel;

class AdministratorModel extends BaseModel
{
	public function getModules()
	{
		return $this->db->query('select a.* from s_module a where a.is_deleted = 0')->getResult();
	}

	public function getUserRoles()
	{
		return $this->db->query('select a.* from s_user_web_role a where a.is_deleted = 0')->getResult();
	}

	public function getUserDetail()
	{
		return $this->db->query('select a.* from m_user_web a where a.id = ' . $this->session->get('id') . ' and a.is_deleted = 0')->getRow();
	}

	public function getModuleUser($role_id)
	{
		return $this->db->query('select a.*, b.menu_name, b.menu_url, c.id as module_id, c.module_name, c.module_name 
    		from s_user_web_privilege a 
    		inner join s_menu b on a.menu_id = b.id and b.is_deleted = 0
    		inner join s_module c on b.module_id = c.id and c.is_deleted = 0
    		where a.user_web_role_id = ? and a.is_deleted = 0
    		', array($role_id))->getResult();
	}

	public function getParentMenu($module_id)
	{
		return $this->db->query('select * from s_menu where module_id = ? and menu_id is null and is_deleted = 0', array($module_id))->getResult();
	}

	public function getSubMenu($menu_id)
	{
		return $this->db->query('select * from s_menu where menu_id = ? and is_deleted = 0', $menu_id)->getResult();
	}

	public function deleteByModuleAndUserType($role_id, $id)
	{
		return $this->db->query('delete a.* from s_user_web_privilege a 
    		inner join s_menu b on a.menu_id = b.id
    		inner join s_module c on b.module_id = c.id
    		where a.user_web_role_id = ? and c.id = ? and a.is_deleted = 1', array($role_id, $id));
	}

	public function deleteMenuByModuleAndUserType($role_id, $id)
	{
		return $this->db->query('update s_user_web_privilege a 
    		inner join s_menu b on a.menu_id = b.id
    		inner join s_module c on b.module_id = c.id
    		set a.is_deleted = 1, a.last_edited_at = ?, a.last_edited_by = ?
    		where a.user_web_role_id = ? and c.id = ?', array(date("Y-m-d H:i:s"), $this->session->get('id'), $role_id, $id));
	}

	public function saveHakAkses($previleges, $deleted, $role_id)
	{
		$this->db->transBegin();

		foreach ($deleted as $deleted_id) {
			$this->deleteByModuleAndUserType($role_id, $deleted_id);
			$this->deleteMenuByModuleAndUserType($role_id, $deleted_id);
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

			$query = $this->string_insert($previlege, 's_user_web_privilege') . ' ON DUPLICATE KEY UPDATE ' . implode(", ", $previlagesUpdate);
			$this->db->query($query);
		}

		if ($this->db->transStatus() === FALSE) {
			$this->db->transRollback();
			$this->db->transComplete();
			return false;
		} else {
			$this->db->transCommit();
			$this->db->transComplete();
			return true;
		}
	}

	public function checkUsername($user_web_username)
	{
		$rs = $this->db->query("select user_web_username from m_user_web where (user_web_username=? and is_deleted='0')", array($user_web_username));
		if ($rs->getNumRows() > 0) {
			return false;
		} else {
			return true;
		}
	}

	public function checkEmailuser($user_web_email)
	{
		$rs = $this->db->query("select user_web_email from m_user_web where (user_web_email=? and is_deleted='0')", array($user_web_email));
		if ($rs->getNumRows() > 0) {
			return false;
		} else {
			return true;
		}
	}

	public function checkExistingPass($id, $user_web_password)
	{
		$rs = $this->db->query("select user_web_password from m_user_web where (user_web_password=? and is_deleted='0' and id=?)", array($user_web_password, $id));
		if ($rs->getNumRows() > 0) {
			return true;
		} else {
			return false;
		}
	}
}
