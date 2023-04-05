<?php namespace App\Modules\Administrator\Models;

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

            $query = $this->string_insert($previlege, 's_user_web_privilege') . ' ON DUPLICATE KEY UPDATE '. implode(", ", $previlagesUpdate);
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

	public function saveFasilitas($facilitiesDatas, $deleted, $role_id)
	{
		$this->db->transBegin();

		foreach ($deleted as $deleted_id) {
			$this->db->query("delete from m_armada_mudik_fasilities where armada_mudik_id = ".$deleted_id['armada_mudik_id']." and facilities_id = " . $deleted_id['facilities_id']);
		}

		foreach ($facilitiesDatas as $facilitiesData) {
			$this->db->query("insert into m_armada_mudik_fasilities 
								(armada_mudik_id, facilities_id) 
								VALUES (".$facilitiesData['armada_mudik_id'].",".$facilitiesData['facilities_id'].")
								ON DUPLICATE KEY UPDATE armada_mudik_id = values(armada_mudik_id), facilities_id = values(facilities_id)
								");
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

	function banner_export($filter){
        $query = "SELECT a.banner_name, ifnull(a.banner_link, 'https://devel74.nginovasi.id/guloasem/assets/img/notavailable.jpeg') as banner_link, a.banner_order from m_banner a  where a.is_deleted = 0 and ( a.banner_name like '%$filter%' or a.banner_link like '%$filter%')";
        return $this->db->query($query)->getResult();
    }

	function news_export($filter){
        $query = "SELECT a.id, a.`news_title`, a.`news_description`, ifnull(a.`news_banner`, 'https://devel74.nginovasi.id/guloasem/assets/img/notavailable.jpeg') as news_banner  FROM t_news a where a.is_deleted='0' and ( a.news_title like '%$filter%' or a.news_description  like '%$filter%' )";

        // return $query;
        return $this->db->query($query)->getResult();
    }

    public function saveSeatMap($role_id, $data, callable $callback = NULL)
    {
        $this->db->transBegin();

		if($data['id'] == ""){
			$dataSeatMap = [
				"seat_map_name" => strtoupper($data["seat_map_name"]),
				"seat_map_left" => $data["seat_map_left"],
				"seat_map_right" => $data["seat_map_right"],
				"seat_map_row" => $data["seat_map_row"],
				"seat_map_last" => $data["seat_map_last"],
				"seat_map_capacity" => $data["seat_map_capacity"],
				"created_by" => $this->session->get('id'),
				"created_at" => date("Y-m-d H:i:s"),
			];
	
			$result = parent::base_insertRID($dataSeatMap, 'm_seat_map');
	
			$dataSeatMapDetail = [];
	
			foreach($data['seat_map_detail_name'] as $key => $value) {
				$dataSeatMapDetail[] = [
					"seat_map_id" => $result,
					"seat_map_detail_name" => $value,
					"created_by" => $this->session->get('id'),
					"created_at" => date("Y-m-d H:i:s"),
				];	
			}	
	
			$result = parent::base_insertBatch($dataSeatMapDetail, 'm_seat_map_detail');
		}else{
			$id = $data['id'];
			$data['last_edited_at'] = date('Y-m-d H:i:s');
			$data['last_edited_by'] = $this->session->get('id');
			unset($data['id']);

			$cekdataSeatMap = $this->db->query("select * from m_seat_map
								where id = " . $id)->getRow();
			
			$dataSeatMap = [
				"seat_map_name" => strtoupper($data["seat_map_name"]),
				"seat_map_left" => $data["seat_map_left"],
				"seat_map_right" => $data["seat_map_right"],
				"seat_map_row" => $data["seat_map_row"],
				"seat_map_last" => $data["seat_map_last"],
				"seat_map_capacity" => $data["seat_map_capacity"],
				"last_edited_at" => date('Y-m-d H:i:s'),
				"last_edited_by" => $this->session->get('id')
			];

			parent::base_update($dataSeatMap, 'm_seat_map', array('id' => $id));

			if($cekdataSeatMap->seat_map_left != $data["seat_map_left"] || $cekdataSeatMap->seat_map_right != $data["seat_map_right"] || $cekdataSeatMap->seat_map_row != $data["seat_map_row"] || $cekdataSeatMap->seat_map_last != $data["seat_map_last"] || $cekdataSeatMap->seat_map_capacity != $data["seat_map_capacity"]) {
				$this->db->query("update m_seat_map_detail 
													set is_deleted = 1, last_edited_at = NOW(), last_edited_by = " . $role_id . "
													where is_deleted = 0
													and seat_map_id = " . $id);

				$dataSeatMapDetail = [];

				foreach($data['seat_map_detail_name'] as $key => $value) {
					$dataSeatMapDetail[] = [
						"seat_map_id" => $id,
						"seat_map_detail_name" => $value,
						"created_by" => $this->session->get('id'),
						"created_at" => date("Y-m-d H:i:s"),
					];	
				}	
		
				$result = parent::base_insertBatch($dataSeatMapDetail, 'm_seat_map_detail');
			}
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

	public function spda_export($filter)
	{
		$data_explode = explode(".", $filter);
		$no_spda = $data_explode[0];
		$id_spda = $data_explode[1];
		
		$query = "SELECT a.id, a.trayek_id, a.no_spda, a.tgl_spda, b.nama_pengemudi, c.armada_code, a.ritase_spda, a.jrk_tempuh_spda, a.wkt_tempuh_spda, a.bbm_spda, a.kapsts_bus_spda, a.ttl_penumpang_spda, a.ttl_pdptan_spda
		FROM t_form_spda a
		LEFT JOIN m_driver b on b.id = a.driver_spda
		LEFT JOIN m_armada c on c.id = a.kd_bus_spda 
		WHERE a.is_deleted = '0' AND a.id = ? AND a.no_spda = ?";
		
		return $this->db->query($query, array(base64_decode($id_spda), base64_decode($no_spda)))->getResult();
	}

	public function getArmadaMudik()
    {
    	return $this->db->query('select a.* from m_armada_mudik a where a.is_deleted = 0')->getResult();	
    }

	public function saveProfileInstansi($role_id, $data, callable $callback = NULL) {
		$this->db->transBegin();

		if(empty($data['code'])) {
			$data['code'][] = 'one code';
		}

		$kode = "";
		for($i = 0; $i < count($data['code']); $i++) {
			if($kode == "") {
				$kode .= $data['code'][$i];
			} else {
				$kode .= "." . $data['code'][$i];
			}
		}

		$dataResp = [
			"instansi_detail_name" => $data["instansi_detail_name"],
			"instansi_detail_id" => $kode == 'one code' ? null : end($data['code']),
			"kode" => $kode,
			"user_web_role_id" => $data["user_web_role"]
		];	

		if($data['id'] == ""){ 
			$result = parent::base_insertRID($dataResp, 'm_instansi_detail');

			$getInstansiDetail = $this->db->query('select * from m_instansi_detail where id = ' . $result)->getRow();

			if($getInstansiDetail->instansi_detail_id != null) {
				$dataUpdate = [
					"kode" => $getInstansiDetail->kode . "." . $getInstansiDetail->id
				];
			} else {
				$dataUpdate = [
					"kode" => $getInstansiDetail->id
				];
			}

			parent::base_update($dataUpdate, 'm_instansi_detail', array('id' => $getInstansiDetail->id));
		} else {
			$id = $data['id'];

			$getInstansiDetail = $this->db->query("select * from m_instansi_detail where id = " . $id)->getRow();

			if($getInstansiDetail->kode == $dataResp['kode']) {
				$dataResp['kode'] = $dataResp['kode'];
				$dataResp['instansi_detail_id'] = $getInstansiDetail->instansi_detail_id;
			} else {
				$dataResp['kode'] = $dataResp['kode'] . "." . $id;
			}

			parent::base_update($dataResp, 'm_instansi_detail', array('id' => $id));
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

	public function checkUsername($user_web_username){
		$rs = $this->db->query("select user_web_username from m_user_web where (user_web_username=? and is_deleted='0')",array($user_web_username));
		if($rs->getNumRows()>0){
			return false;
		}else{
			return true;
		}
	}

	public function checkEmailuser($user_web_email){
		$rs = $this->db->query("select user_web_email from m_user_web where (user_web_email=? and is_deleted='0')",array($user_web_email));
		if($rs->getNumRows()>0){
			return false;
		}else{
			return true;
		}
	}

	public function checkExistingPass($id, $user_web_password){
		$rs = $this->db->query("select user_web_password from m_user_web where (user_web_password=? and is_deleted='0' and id=?)",array($user_web_password,$id));
		if($rs->getNumRows()>0){
			return true;
		}else{
			return false;
		}
	}

	

	public function syncEmailWebMobile($data) {
		$this->db->transBegin();

		$id = $data['id'];

		$getUserWeb = $this->db->query('select * from m_user_web where id = ' . $id)->getRow();

		if($getUserWeb) {
			$getUserMobile = $this->db->query('select * from m_user_mobile where user_mobile_email = ' . '"' . $getUserWeb->user_web_email . '"')->getRow();

			$data = [
				"user_mobile_email" => $getUserWeb->user_web_email,
				"user_mobile_type" => "Android",
				"user_mobile_role" => 2
			];

			if($getUserMobile) {
				parent::base_update($data, 'm_user_mobile', array('id' => $getUserMobile->id));
			} else {
				$result = parent::base_insertRID($data, 'm_user_mobile');

				$dataUserWeb = [
					"user_mobile_id" => $result
				];

				parent::base_update($dataUserWeb, 'm_user_web', array('id' => $id));
			}
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

}
